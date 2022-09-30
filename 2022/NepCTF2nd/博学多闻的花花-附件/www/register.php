<?php
include("config.php");

if (isset($_COOKIE['username'])) {
    header("Location: index.php");
    exit();
}

function getRandom($arrend){
    $numbers = range (1,$arrend);
    shuffle ($numbers);
    $num=5;
    $result = array_slice($numbers,0,$num);
    return $result;
}

if (isset($_POST['username']) && isset($_POST['studentid'])) {

    if ($_POST['username']==='admin') {
        exit('你想干啥？');
    }

    if ($_POST['username']==='' || $_POST['studentid']==='' || $_POST['submit']!=='提交')
    {
        exit("搞事搞事搞事.jpg");
    }


    $mysqli = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DATABASE);
    mysqli_query($mysqli,"set names utf8");
    $username = $mysqli->escape_string($_POST['username']);
    $studentid = addslashes_deep($_POST['studentid']);

    if ($mysqli->connect_errno) {
        exit("something err0r!<br>姓名或学号重复");
    }

    if($result = $mysqli->query("select * from users where studentid='$studentid'")) {
        if ($result->num_rows) {
            $result->close();
            echo "<script>alert(\"用户已存在\");</script>";
        } else {
            $arrend = $mysqli->query("select count(*) from challengesAll")->fetch_row()[0];
            $arr = getRandom($arrend);
            $query = "insert into users values (NULL, '$username', '$studentid');";
            $query .= "insert into randChallenges values (NULL, '$username', '$arr[0]', '$arr[1]', '$arr[2]', '$arr[3]', '$arr[4]');";
            if ($mysqli->multi_query($query)===TRUE) {
                $mysqli->close();
                header("Location: login.php");
            } else {
                exit("something error！".$mysqli->error);
            }
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
        <h1>注册</h1>
        姓名：<input type="text" value="" id="username" name="username"><br><br>
        学号：<input type="text" value="" id="studentid" name="studentid"><br>

        <br>
        <input type="submit" class="btn btn-lg btn-primary" value="提交" name="submit">
    </div>
</body></html>
