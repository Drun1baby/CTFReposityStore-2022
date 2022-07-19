<?php
include("config.php");

if (isset($_COOKIE['username'])) {
    header("Location: index.php");
    exit();
}

if (isset($_POST['username']) && isset($_POST['studentid'])) {
    if ($_POST['username']==='' || $_POST['studentid']==='' || $_POST['submit']!=='提交')
    {
        exit("搞事搞事搞事.jpg");
    }

    $mysqli = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DATABASE);
    mysqli_query($mysqli,"set names utf8");
    $username = addslashes_deep($_POST['username']);

    $studentid = addslashes_deep($_POST['studentid']);

    if ($mysqli->connect_errno) {
        exit("something err0r");
    }

    if($result = $mysqli->query("select * from users where username='$username' and studentid='$studentid'")) {
        if ($result->num_rows === 1) {
            $row = $result->fetch_array();
            setcookie('username', md5($row['username']));
            $_SESSION['username'] = ($row['username']);
            $_SESSION['studentid'] = ($row['studentid']);

            if ($row['username']=="admin"){
                $random = md5(time());
                $mysqli->query("update users set studentid='$random' where username='admin'");
            }
            header("Location: index.php");
        } else {
            exit("用户名或密码错误 QAQ");
        }
    }
}
?>
<!DOCTYPE html>
<html lang="zh"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <link rel="stylesheet" href="./_files/bootstrap.min.css">
    <link rel="stylesheet" href="./_files/main.css">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=no">
    <title>2022年全国统一CTF高考试卷</title>
</head>
<body class="text-center">
    <form class="form-getflag" method="post">
    <div id="app">
        <h1>登陆</h1>
        姓名：<input type="text" value="" id="username" name="username"><br><br>
        学号：<input type="text" value="" id="studentid" name="studentid"><br>

        <br>
        <input type="submit" class="btn btn-lg btn-primary" value="提交" name="submit">
    </div>
</body></html>
