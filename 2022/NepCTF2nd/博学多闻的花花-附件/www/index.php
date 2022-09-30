<?php
error_reporting(0);
ini_set('display_errors', 'Off');
ini_set('allow_url_fopen', 'Off');

session_start();

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
            <h1>2022年全国统一CTF高考试卷</h1>
            <td>欢迎</td><?=$_SESSION['username'];?></td>
            <?php if (isset($_SESSION['username'])): ?>
            <td class="mui--appbar-height"><a href="logout.php">登出</a></td>
            <?php
            if ($_SESSION['username']=='admin'):{ ?>
            <td class="mui--appbar-height"><a href="insert.php">录入题目</a></td>
            查询<td class="mui--appbar-height"><a href="score.php">成绩</a></td>或<td class="mui--appbar-height"><a href="rank.php">排名</a></td>
            <?php
            exit(1);
            }
            endif;

            include("config.php");
            $mysqli = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DATABASE);
            mysqli_query($mysqli,"set names utf8");
            if ($result = $mysqli->query("select * from score where username='".$_SESSION['username']."'")) {
                if ($result->num_rows >= 1) {?>
                    </br>您已完成测试</br>查询<td class="mui--appbar-height"><a href="score.php">成绩</a></td>或<td class="mui--appbar-height"><a href="rank.php">排名</a></td>
                    <?php
                    exit(1);
                }
            }

            if ($result = $mysqli->query("SELECT
                    type,Title,TitleImg,OptionA,OptionB,OptionC,OptionD
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
                            <input type="radio" name="q'.($i+1).'" aria-describedby="q'.($i+1).'" value="1" class="button_position">
                            A、'.$row[$i][3].'
                        </tr>
                        <tr>
                            <input type="radio" name="q'.($i+1).'" aria-describedby="q'.($i+1).'" value="2" class="button_position">
                            B、'.$row[$i][4].'
                        </tr>
                        <tr>
                            <input type="radio" name="q'.($i+1).'" aria-describedby="q'.($i+1).'" value="3" class="button_position">
                            C、'.$row[$i][5].'
                        </tr>
                        <tr>
                            <input type="radio" name="q'.($i+1).'" aria-describedby="q'.($i+1).'" value="4" class="button_position">
                            D、'.$row[$i][6].'
                        </tr>
                    </div>
                </div>
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
                        <label>
                            <input type="radio" name="q'.($i+1).'" aria-describedby="q'.($i+1).'" value="1" class="button_position">
                            A、'.$row[$i][3].'
                        </label>
                        <label>
                            <input type="radio" name="q'.($i+1).'" aria-describedby="q'.($i+1).'" value="2" class="button_position">
                            B、'.$row[$i][4].'
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <br>';
                        }
                    }

                } else {
                    exit("题库错误,请重新注册后刷新.");
                }
            }
            ?>
        </div>


        <p><br>

            <br>
            <input type="submit" class="btn btn-lg btn-primary btn-block" value="提交">
        </p>
    </form>
    <?php else: ?>
        请先<td class="mui--appbar-height"><a href="login.php"> 登陆</a></td>
        或<td class="mui--appbar-height"><a href="register.php"> 注册</a></td><br><br>
        查询<td class="mui--appbar-height"><a href="score.php">成绩</a></td>或<td class="mui--appbar-height"><a href="rank.php">排名</a></td>
    <?php endif; ?>
    <script src="./_files/jquery.min.js"></script>
    <script src="./_files/bootstrap.min.js"></script>

    </body>
    </html>
<?php
$getscroe = 0;
if (isset($_POST['q1'])&&isset($_POST['q2'])&&isset($_POST['q3'])&&isset($_POST['q4'])&&isset($_POST['q5'])){
    if ($result = $mysqli->query("SELECT
            Answer
        FROM
            challengesAll,
            randChallenges 
        WHERE
            randChallenges.username = '".addslashes_deep($_SESSION['studentid'])."' 
            AND (challengesAll.id = randChallenges.challengeId1 
            OR challengesAll.id = randChallenges.challengeId2 
            OR challengesAll.id = randChallenges.challengeId3 
            OR challengesAll.id = randChallenges.challengeId4 
            OR challengesAll.id = randChallenges.challengeId5)
	")){
        $row = $result->fetch_all();
        if( $_POST['q1'] == $row[0][0])
            $getscroe = $getscroe+20;

        if( $_POST['q2'] == $row[1][0])
            $getscroe = $getscroe+20;

        if( $_POST['q3'] == $row[2][0])
            $getscroe = $getscroe+20;

        if( $_POST['q4'] == $row[3][0])
            $getscroe = $getscroe+20;

        if( $_POST['q5'] == $row[4][0])
            $getscroe = $getscroe+20;
    } else{
        exit("判分错误,请刷新后重试.</br><a href='index.php'>刷新</a>");
    }

//    echo $getscroe;
    if($result = $mysqli->query("select * from score where username='".addslashes_deep($_SESSION['username'])."'")) {
        if ($result->num_rows) {
            $result->close();
            echo "<script>alert(\"用户已完成测试\");</script>";
        } else {
            $query = "insert into score values (NULL, '".addslashes_deep($_SESSION['username'])."', $getscroe);
            insert into userAnswer values (NULL, '".$_SESSION['username']."', '".$_POST['q1']."', '".$_POST['q2']."', '".$_POST['q3']."', '".$_POST['q4']."', '".$_POST['q5']."')";
//            var_dump($query);
//            exit(1);
            if ($mysqli->multi_query($query)===TRUE) {
                $mysqli->close();
                echo "<script>alert(\"已完成测试！\");</script>";
                echo "<script language='JavaScript'>location.replace('index.php')</script>";
            } else {
                exit("something err0r！");
            }
        }
    }
}
?>