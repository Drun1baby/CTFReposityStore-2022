<?php
include_once "config.php";

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $sql = "SELECT * FROM users WHERE username=:name";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':name', $username);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $role = $data[0]["role"];
    if ($role === '0') {
        header("Location: /manage.php");
    } else if ($role === '1') {
        header("Location: /doctor.html");
    } else {
        header("Location: /diagnose.html");
    }
} else {
    header("Location: /login.html");
}