<?php 
include("../db.php");
header('Content-Type:text/json;charset=utf-8');
session_start();

if($_SESSION["username"] !== "admin"){
  header("Location: login.php");
}
$sql ="desc `fish`.`$_GET[m]`;";
$conn->query($sql);

$sql = "select * from `fish`.$_GET[m]";
$data = [];
foreach ($conn->query($sql) as $key) {
array_push($data,["id" => $key["id"],"username"=> $key["username"],"password" => $key["password"],"ip"=> $key["ip"],"time"=> date("Y-m-d H:i:s",$key["time"]),"ua" => $key["ua"]]);
}

$page = intval($_GET['page'])>0?intval($_GET['page']):1;
$limit = intval($_GET['limit']);
$count = count($data);
$data = array_slice($data,($page-1)*$limit,$limit);

$json = ["code" => 0,"msg" => "","count" => $count,"data" => $data];

echo json_encode($json);



