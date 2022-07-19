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
        <?php
        if (($_SESSION['username'])=='admin'):{
        ?>
        <h1>请输入学号以查询成绩</h1>
        学号：<input type="text" value="" id="studentid" name="studentid"><br>
        <br>
        <input type="submit" class="btn btn-lg btn-primary" value="提交" name="submit">
        <?php
        function getAns($ans, $type){
            if ($type=='1') {
                switch ($ans) {
                    case "1": return "A";
                    case "2": return "B";
                    case "3": return "C";
                    case "4": return "D";
                }
            }elseif ($type=='2'){
                switch ($ans) {
                    case "1": return "√";
                    case "2": return "X";
                }
            }
        }

            if (isset($_POST['studentid'])){
                $studentid = addslashes_deep($_POST['studentid']);

    //            var_dump($studentid);
                if ($mysqli->connect_errno) {
                    exit("something err0r！");
                }
                if ($result = $mysqli->query("select * from users where studentid='$studentid';")) {
                    $row = $result->fetch_array();
                    if ($row){
                        $username = $row['username'];
                        $sql = "select * from score where username='$username';";
                        if ($result2 = $mysqli->multi_query($sql)){
                            $row2 = $mysqli->store_result()->fetch_array();
                            echo "
                                <div class=\"card\">
                                    <div class=\"card-body question-main\" align='cent'>
                                        <div align='center'>
                                            <h1>姓名：".$row2["username"]."</h1>
                                        </div>
                                        <div align='center'>
                                            恭喜你获得了：<h2>".$row2["score"]."分</h2>
                                        </div>
                                    </div>
                                </div><br>
                                ";
                            if ($result = $mysqli->query("SELECT
                    type,Title,TitleImg,OptionA,OptionB,OptionC,OptionD,Answer
                FROM
                    challengesAll,randChallenges 
                WHERE
                    randChallenges.username = '".addslashes_deep($_SESSION['username'])."'
                    AND (challengesAll.id = randChallenges.challengeId1 
                    OR challengesAll.id = randChallenges.challengeId2 
                    OR challengesAll.id = randChallenges.challengeId3 
                    OR challengesAll.id = randChallenges.challengeId4 
                    OR challengesAll.id = randChallenges.challengeId5) 
                ")) {
                                if ($result->num_rows == 5) {
                                    $row = $result->fetch_all();

                                    $result2 = $mysqli->query("select ans1,ans2,ans3,ans4,ans5 from userAnswer where studentid='".$_SESSION['studentid']."'");
                                    $row2 = $result2->fetch_all();

                                    for ($i=0;$i<count($row);$i++){
//                        var_dump($row[$i]);

                                        if ($row[$i][0]=='1') {
                                            echo '<div class="card">
            <div class="card-body question-main">
                <div class="question-q">
                    '.($i+1).'.'.$row[$i][1].'<br>
                    <img src="'.$row[$i][2].'" width="500px">
                </div>
                <div class="input-group input-group-sm mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="q'.($i+1).'">答案</span>
                        <tr>
                            A、'.$row[$i][3].'<br>
                        </tr>
                        <tr>
                            B、'.$row[$i][4].'<br>
                        </tr>
                        <tr>
                            C、'.$row[$i][5].'<br>
                        </tr>
                        <tr>
                            D、'.$row[$i][6].'<br>
                        </tr>
                    </div>
                </div>
                <br>
                <h3 align="centre">正确答案：'.getAns($row[$i][7], '1').'   您的答案：'.getAns($row2[0][$i], '1').'</h3>
            </div>
        </div>
        <br>';
                                        }elseif ($row[$i][0]=='2'){
                                            echo '<div class="card">
            <div class="card-body question-main">
                <div class="question-q">
                    '.($i+1).'.'.$row[$i][1].'<br>
                    <img src="'.$row[$i][2].'" width="500px">
                </div>

                <div class="input-group input-group-sm mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="q'.($i+1).'">答案</span>
                        <tr>
                            A、'.$row[$i][3].'<br>
                        </tr>
                        <tr>
                            B、'.$row[$i][4].'<br>
                        </tr>
                    </div>
                </div>
                <br>
                <h3 align="centre">正确答案：'.getAns($row[$i][7], '2').'   您的答案：'.getAns($row2[0][$i], '2').'</h3>
            </div>
        </div>
        <br>';
                                        }
                                    }

                                }
                            }
                        }else{
                            exit("<br>未查询到成绩.</br>学号或姓名可能有误");
                        }
                    } else {
                        exit("<br>未查询到成绩.</br>学号或姓名可能有误");
                    }
                }
            }
        }else:?>
        <h1>只有admin可以查询特定学号的成绩</h1><br>
        <a href='index.php'>返回主页</a>
        <?php  endif; ?>
    </div>
</body></html>
