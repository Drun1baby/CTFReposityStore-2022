<?php
include_once "config.php";
if ($_SESSION['username']) {
    $sql = "SELECT * FROM users WHERE username=? LIMIT 1";
    $stmt = $dbh->prepare($sql);
    $stmt->execute(array($_SESSION['username']));
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $role = $data[0]['role'];
    if ($role === '0') {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($_POST['submit1']) {
                $filename = $_FILES['file']['name'];
                $filename = str_replace("..","",$filename);
                $filename = str_replace("ht","no",$filename);
                $ext = pathinfo($filename, PATHINFO_EXTENSION);
                if (in_array($ext,['php','php3','php4','php5','php6','php7','php8','phtml','htaccess'])){
                    exit('hacker out!');
                }
                $url = "img/".$filename;
                if (analyse($filename, file_get_contents($_FILES['file']['tmp_name'])) && $_POST['username'] && $_POST['info'] && $_POST['name'] && $_POST['worktime'] && $_POST['special'] && $_POST['position'] && $_POST['password'] && $_POST['idcard'] && $_POST['phone']) {
		    move_uploaded_file($_FILES['file']['tmp_name'], $url);
		    $stmt->execute(array($_POST['username']));
		    if (!empty($stmt->fetchAll(PDO::FETCH_ASSOC))) die("repeat user!");
                    $sql = "INSERT INTO doctors (`username`,`info`,`worktime`,`url`,`special`,`position`,`name`) VALUES (?, ?, ?, ?, ?, ?, ?)";
                    $stmt = $dbh->prepare($sql);
                    $stmt->execute(array($_POST['username'], $_POST['info'], $_POST['worktime'], $url, $_POST['special'], $_POST['position'], $_POST['name']));
                    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $sql = "INSERT INTO users (`username`,`password`,`role`,`phone`,`idcard`,`name`) values(?, ?, '1', ?, ?, ?)";
                    $stmt = $dbh->prepare($sql);
                    $stmt->execute(array($_POST['username'], $_POST['password'], $_POST['phone'], $_POST['idcard'], $_POST['name']));
                    echo "医生信息插入成功！";
                } else {
                    die("信息不全或检测到webshell");
                }
            } else if ($_POST['submit2']) {
                $username = $_POST['username'];
                $newtime = $_POST['newtime'];
                if ($username && $newtime) {
                    $sql = "UPDATE doctors SET worktime=? WHERE username=?";
                    $stmt = $dbh->prepare($sql);
                    $stmt->execute(array($newtime, $username));
                    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    echo "工作时间更改成功";
                } else {
                    die("信息不全");
                }
            } else {
                die("???");
            }


        } else {
            echo file_get_contents("manage.html");
        }
    } else {
        header("Location: /login.html");
    }
}
