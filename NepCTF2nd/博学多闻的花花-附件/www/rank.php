<?php
include("config.php");


$mysqli = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DATABASE);
mysqli_query($mysqli,"set names utf8");
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
        <h1>排行榜</h1>
        <?php

        if ($mysqli->connect_errno) {
            exit("暂无排行");
        }

        if ($result = $mysqli->query("select * from score order by score desc")) {
            if ($result->num_rows >= 1) {
                $row = $result->fetch_all();
                for ($i=0;$i<count($row);$i++){
                    echo "
                        <div class=\"card\">
                            <div class=\"card-body question-main\" align='center'>
                                <div align='center'>
                                    <h2>姓名：***     得分：".$row[$i]["2"]."分</h2>
                                </div>
                            </div>
                        </div>
                    ";
                }

            } else {
                exit("暂无排行.</br><a href='score.php'>返回查询</a>");
            }
        }
        ?>
    </div>
</body></html>
