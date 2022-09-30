/*
    core.other.js
    v1.0
    create bridge for qq browser
    client environment besides iOS and Android 
    date:2014-08-13
*/

; !function (window, ns, bridge) {

    "use strict";

    var exports = window[ns] = window[ns] || {};

    // 此方法用于创建 qb_channel
    !function () {
        var QbChannel = function (type) {
            this.type = type;
            this.handlers = {};
            this.numHandlers = 0;
            this.onHasSubscribersChange = null;
        };

        QbChannel.prototype.subscribe = function (f) {
            var func = f,
                guid = f.observer_guid;

            if (!guid) {
                // first time any channel has seen this subscriber
                guid = '' + window.qb_channel.nextGuid++;
            }
            func.observer_guid = guid;
            f.observer_guid = guid;

            // Don't add the same handler more than once.
            if (!this.handlers[guid]) {
                this.handlers[guid] = func;
                this.numHandlers++;
                if (this.numHandlers == 1) {
                    this.onHasSubscribersChange && this.onHasSubscribersChange();
                }
            }
        };

        /**
         * Unsubscribes the function with the given guid from the channel.
         */
        QbChannel.prototype.unsubscribe = function (f) {
            var guid = f.observer_guid,
                handler = this.handlers[guid];
            if (handler) {
                delete this.handlers[guid];
                this.numHandlers--;
                if (this.numHandlers === 0) {
                    this.onHasSubscribersChange && this.onHasSubscribersChange();
                }
            }
        };

        /**
         * Calls all functions subscribed to this channel.
         */
        QbChannel.prototype.fire = function (e) {
            if (this.numHandlers) {
                // Copy the values first so that it is safe to modify it from within
                // callbacks.
                var toCall = [];
                for (var item in this.handlers) {
                    toCall.push(this.handlers[item]);
                }
                for (var i = 0; i < toCall.length; ++i) {
                    toCall[i](e);
                }
            }
        };

        window.qb_channel = {
            create: function (type) {
                return window.qb_channel[type] = new QbChannel(type);
            },
            nextGuid: 0
        };
    }();

    // 调用bridge
    if (typeof bridge === 'function') {
        bridge();
    }

    // 创建命名空间
    var createNamespace = function (name) {
        var arr = name.split('.'),
            space = window;
        arr.forEach(function (a) {
            !space[a] && (space[a] = {});
            space = space[a];
        });
        return space;
    };

    //用来对API进行定义
    exports.define = function (name, fn) {
        var index = name.lastIndexOf('.'),
            ns = createNamespace(name.substring(0, index));
        ns[name.substring(index + 1)] = fn;
    };

}(window, 'browser');browser.define("browser.app.openImageReaderWithDelete", function(urls, index, httpRefer, succFun){
	/*请在这里输入API的实现代码*/
  x5mtt.openImageReaderWithDelete(urls, index, httpRefer, succFun);
});