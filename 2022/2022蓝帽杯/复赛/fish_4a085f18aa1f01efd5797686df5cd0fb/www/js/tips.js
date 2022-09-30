var ptui_daid = encodeURIComponent("147") //业务隔离id
    ,
    ptui_appid = encodeURIComponent("549000929") //业务的appid
    ,
    ptui_domain = encodeURIComponent("qzone.com") //domain
    ,
    ptui_regmaster = encodeURIComponent(""),
    ptui_lang = encodeURIComponent("2052"),
    ptui_pt_version = encodeURIComponent("10216"),
    ptui_version = encodeURIComponent("201203081004"),
    ptui_style = encodeURIComponent("9"),
    ptui_noAuth = "1" //是否需要去检查业务隔离，默认为1，需要检查（数字）
    ,
    g_href = "http\x3A\x2F\x2Fui.ptlogin2.qzone.com\x2Fcgi-bin\x2Flogin\x3Fstyle\x3D9\x26appid\x3D549000929\x26pt_no_auth\x3D1\x26daid\x3D147\x26pt_wxtest\x3D1\x26s_url\x3Dhttps\x253A\x252F\x252Fm.qzone.com\x252F",
    ptui_pt_qzone_sig = "0",
    ptui_pt_light = "0" //轻登录，只下发p_skey,取值0或者1
    ,
    ptui_pt_ttype = "0",
    ptui_pt_3rd_aid = encodeURIComponent("0") //互联的第三方appid
    ,
    ptui_enablePwd = encodeURIComponent("") //互联的登录是否使用密码控件
    ,
    ptui_target = encodeURIComponent("_self") //跳转方式
    ,
    ptui_low_login = parseInt("0", 10) || 0,
    ptui_low_login_hour = parseInt("0", 10) || 720 // 弱登录时间，默认一个月
    ,
    ptui_kf_csimc = encodeURIComponent("0"),
    ptui_kf_csnum = encodeURIComponent("0"),
    ptui_kf_authid = encodeURIComponent("0"),
    ptui_defuin = "" //设置的默认uin(input value 赋值)
    ,
    ptui_lockuin = parseInt("0");
if (ptui_daid == 1)
    ptui_daid = 0; // 因为业务总是填错，所以daid=1也认为是没填的
var STR_LANG = {
    no_uin: "您还没有输入帐号！",
    no_password: "您还没有输入密码！",
    no_code: "您还没有输入验证码！",
    err_uin: "请输入正确的帐号！",
    less_code: "请输入完整的验证码！",
    err_code: "请输入完整的验证码！",
    onekey: "一键登录",
    onekeying: "正在拉起QQ手机版...",
    offline: "网络异常"
};
