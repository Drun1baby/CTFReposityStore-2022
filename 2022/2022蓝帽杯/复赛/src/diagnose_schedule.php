<?php
include_once "config.php";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = file_get_contents("php://input");
    $json_data = json_decode($data);
    $diagnose = $json_data->search_class;
    $sql = "SELECT * FROM doctors WHERE special=:special";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':special', $diagnose);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $res = "[";
    $end = end($data);
    foreach ($data as $key=>$value) {
        $weekday= $value['worktime'];
        $weekday = explode(",",$value['worktime'])[0];
        $worktime= explode(",",$value['worktime'])[1];
        $tmp = '{"img":"'.$value['url'].'","name":"'.$value['name'].'","position":"'.$value['position'].'","des":"'.$value['info'].'","appointment_time":"'.$worktime.'","weekday":"'.$weekday.'"}';
        if ($value === $end) {
            $res = $res.$tmp."]";
        } else {
            $res = $res.",";
        }
    }
    echo $res;

} else {
    header("Location: /login.php");
}