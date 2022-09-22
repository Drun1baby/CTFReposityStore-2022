<?php
include_once "config.php";
if (isset($_SESSION['username'])) {
    $sql = "SELECT * FROM doctors WHERE username=:name";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':name', $_SESSION['username']);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $img = $data[0]['url'];
    $des = $data[0]['info'];
    $name = $data[0]['name'];
    $sql = "SELECT * FROM orders WHERE doctorusername=:uname";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':uname', $_SESSION['username']);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (empty($data)) {
        die('{"img":"'.$img.'","des":"'.$des.'","order":[]}');
    }
    $res = '{"img":"'.$img.'","des":"'.$des.'","order":[';
    foreach ($data as $key=>$value) {
        $tmp='{"name":"'.$value["diagnosename"].'","phone":'.$value["diagnosephone"].',"reserve_time":"'.$value["appointmenttime"].'"}';
        $res = $res.$tmp;
        if ($value !== end($data)) {
            $res = $res.",";
        } else {
            $res = $res."]";
        }
    }
    echo $res."}";

} else {
    header("Location: /login.php");
}