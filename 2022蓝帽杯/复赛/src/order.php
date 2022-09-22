<?php
include "config.php";
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['username'])) {
    $data = file_get_contents("php://input");
    $json_data = json_decode($data);
    $position_time = $json_data->position_time;
    $name = $json_data->name;
    $time = time();
    $sql = "SELECT * FROM doctors WHERE name=?";
    $stmt = $dbh->prepare($sql);
    $stmt->execute(array($name));
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $username = $data[0]['username'];
    $sql = "SELECT * FROM users WHERE username=?";
    $stmt = $dbh->prepare($sql);
    $stmt->execute(array($_SESSION['username']));
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $diagnosename = $data[0]['name'];
    $sql = "INSERT INTO orders(`doctorusername`,`diagnosename`,`diagnosephone`,`ordertime`,`appointmenttime`)values(?, ?, ?, ?, ?)";
    $stmt = $dbh->prepare($sql);
    $stmt->execute(array($username, $diagnosename, $_SESSION['phone'], $time, $position_time));
    $data =$stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    header("Location: /login.php");
}