<?php
session_start();
setcookie("username");
$_SESSION['username'] = '';
$_SESSION['studentid'] = '';
header("Location: index.php");
session_destroy();
exit();