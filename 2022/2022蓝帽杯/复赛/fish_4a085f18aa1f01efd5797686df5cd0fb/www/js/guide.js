(function() {
    var $ = function(id) {
        return document.getElementById(id)
    };
    var on = function(el, event, callback) {
        el.addEventListener(event, callback, false)
    };
    var getCookie = function(name) {
        var r = new RegExp("(?:^|;+|\\s+)\s*" + name + "=([^;]*)"),
            m = document.cookie.match(r);
        return !m ? "" : decodeURIComponent(m[1]);
    }
    var setCookie = function(name, value, domain, path, hour) {
        if (hour) {
            var expire = new Date;
            expire.setTime(expire.getTime() + 36E5 * hour)
        }
        document.cookie = name + "=" + value + "; " + (hour ? "expires=" + expire.toGMTString() + "; " : "") + (path ? "path=" + path + "; " : "path=/; ") + (domain ? "domain=" + domain + ";" : "domain=" + domainPrefix + ";");
        return true
    }
    var pv = function(domain, path) {
        var refer = document.referrer.match(/http:\/\/([^/]+)\/([^\?#]+)/);
        var param = [
            'dm+=' + escape(domain),
            'url+=' + escape(path),
            'rdm+=' + escape(refer ? refer[1] : ''),
            'rurl+=' + escape(refer ? refer[2] : ''),
            'pgv_pvid+=' + getId(),
            'sds+=' + Math.random()
        ];
        img = new Image();
    }
    var getId = function() {
            var t, d, h, f;
            t = document.cookie.match(/(?:^|;+|\s+)pgv_pvid=([^;]*)/i);
            if (t && t.length && t.length > 1) {
                d = t[1];
            } else {
                d = (Math.round(Math.random() * 2147483647) * (new Date().getUTCMilliseconds())) % 10000000000;
                document.cookie = "pgv_pvid=" + d + "; path=/; domain=qq.com; expires=Sun, 18 Jan 2038 00:00:00 GMT;";
            }
            h = document.cookie.match(/(?:^|;+|\s+)pgv_info=([^;]*)/i);
            if (!h) {
                f = (Math.round(Math.random() * 2147483647) * (new Date().getUTCMilliseconds())) % 10000000000;
                document.cookie = "pgv_info=ssid=s" + f + "; path=/; domain=qq.com;";
            }
            return d;
        }
        /*layer switch*/
    var hasShown = getCookie('guide2');
    var refer = document.referrer || '';
    var url = location.href;
    /*弹出逻辑：手动输入网址：refer空或等于http://m.qzone.com*/
    //  if(refer && refer != 'http://m.qzone.com/' && refer != 'http://m.qzone.com'){
    //      hasShown = true;
    //  }
    //活动页干掉
    if (refer && refer.indexOf('qzs.qq.com') > 0) {
        hasShown = true;
    }
    //微信,qq干掉
    if (url.indexOf('5758') > 0 || url.indexOf('5757') > 0) {
        hasShown = true;
    } else if (url.indexOf('6456') > 0 || url.indexOf('17636') > 0 || url.indexOf('17615') > 0 || url.indexOf('22578') > 0 || url.indexOf('22174') > 0) {
        hasShown = true;
    }

    //MSIE也不展示
    var ua = navigator.userAgent;
    if (ua.match(/MSIE/)) {
        hasShown = true;
    }
    if (ua.indexOf('MicroMessenger') > 0) {
        hasShown = true;
    }

    if (!hasShown) {
        $('guide').style.display = '';
        if (navigator.connection && navigator.connection.type == '2') {
            $('guideBG').setAttribute('class', 'wifi');
        }
        var close = function() {
            setCookie('guide2', '1', ".ui.ptlogin2.qq.com", "/", 7 * 24);
            $('guide').style.display = 'none';
        }
        on($('guideSkip'), 'click', function() {
            close();
            pv('m.qzone.com', '/guide_toWeb');
        });
        on($('guideJump'), 'click', function() {
            setCookie('guide2', '1', ".ui.ptlogin2.qq.com", "/", 3 * 24);
            var g_sSchema = "mqzonev2:\/\/arouse\/activefeed?source=webview&version=1";
            var g_sQzoneDownloadPage = "http://m.qzone.com/activity/client_update.html";
            var g_sDownload = 'http://m.qzone.com/l?g=151&g_f=2000000141';
            var g_sUA = navigator.userAgent.toLowerCase();
            var android = g_sUA.match(/(android)\s+([\d.]+)/);
            var ios = g_sUA.match(/(ipad|iphone|ipod).*os\s([\d_]+)/);
            var isAndroid = !!android;
            var isIos = !!ios;

            if (isAndroid || isIos) {
                var div = document.createElement('div');
                div.style.visibility = 'hidden';
                div.innerHTML = "<iframe id=\"schema\" src=\"" + g_sSchema + "\" scrolling=\"no\" width=\"1\" height=\"1\"></iframe>";
                document.body.appendChild(div);
                var start = Date.now();
                setTimeout(function() {
                    var time = Date.now() - start;
                    if (time < 1000) {
                        location = g_sDownload;
                    }
                }, 800);
            } else {
                location = g_sQzoneDownloadPage; //走不到这个分支
            }
        });
        pv('m.qzone.com', '/guide_show');
    }
})();
