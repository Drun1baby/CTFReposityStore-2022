<?php
include_once "config.php";
if (isset($_SESSION['username']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $username  = addslashes($_SESSION['username']);
    $data = file_get_contents("php://input");
    $json_data = json_decode($data);
    $info = addslashes($json_data->info);
    $sql = "UPDATE doctors SET info=? where username=?";
    $stmt = $dbh->prepare($sql);
    $stmt->execute(array($info, $username));
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    header("Location: /login.html");
}