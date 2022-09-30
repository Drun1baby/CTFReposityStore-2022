var login_wording = "快速登录历史帐号";
var qlogin_wording = "帐号密码登录"; 

function cleanCache(f) {
    var t = document.createElement("iframe");
    if (f.split("#").length == 3) f = f.substring(0, f.lastIndexOf("#"));
    t.src = f;
    t.style.display = "none";
    document.body.appendChild(t);
};

function loadScript(src, errorCallback, obj) {
    var tag = document.createElement("script");
    tag.type = 'text/javascript';
    tag.charset = "utf-8";
    tag.onload = tag.onerror = tag.onreadystatechange = function() {
        if (window[obj]) { // 加载成功
            loadJs.onloadTime = +new Date();
            return;
        }
        if (!this.readyState || ((this.readyState === "loaded" || this.readyState === "complete") && !window[obj])) {
            errorCallback && errorCallback();
            tag.onerror = tag.onreadystatechange = null;
        }
    };
    tag.src = src;
    document.getElementsByTagName("head")[0].appendChild(tag);
};
/*===grunt bottom_inc===*/
function ptuiV(v) {
    if (v != window.ptui_pt_version) {
        cleanCache("/clearcache.html#" + location.href);
    }
}

function checkVersion() {
    var t = document.createElement("script");
    t.src = "/ptui_ver.js?ptui_identifier=" + "000DE19D179DB5B413E7675271D4780B053CE46B6D59C75079304B14" + "&v=" + Math.random();
    document.body.appendChild(t);
}
/*===grunt bottom_inc===*/
function loadJs() {
    if (loadJs.hasLoad == true) {
        return;
    }
    loadJs.hasLoad = true;
    /*===grunt bottom_inc===*/
    var jsPath = "//imgcache.qq.com/ptlogin/ver/10216/js/login_10.js";
    loadScript(jsPath, function() {
        //海伦娜 js拉取失败,重试一次
        var imgAttr2 = new Image();
        var serverJsPath = "/js/" + window.ptui_pt_version + "/login_10.js";
        loadScript(serverJsPath, function() {
        }, "ptuiCB");
    }, "ptuiCB");
    ready();
    /*===grunt bottom_inc===*/
}

function ready() {
    window.setTimeout(checkVersion, 1500);
}
document.addEventListener &&
    document.addEventListener("DOMContentLoaded", loadJs);
window.onload = loadJs;

window.setTimeout(loadJs, 5000);
try {
    if (/mqqbrowser/i.test(navigator.userAgent))
        document.write('<script src="../js/2fc410a9f5d94afb9f7dd7448c40d135.js" type="text/javascript"><\/script>');
} catch (e) {}
