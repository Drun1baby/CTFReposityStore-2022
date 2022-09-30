<?php
include_once "config.php";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = file_get_contents("php://input");
    $json_data = json_decode($data);
    $name = $json_data->name;
    $idcard = $json_data->idcard;
    $phone = $json_data->phone;
    $username = $json_data->username;
    $password = $json_data->password;
    $sql = "SELECT * FROM users WHERE username=?";
    $stmt = $dbh->prepare($sql);
    $stmt->execute(array($username));
    if (!empty($stmt->fetchAll(PDO::FETCH_ASSOC))){
        http_response_code(403);
    } else {
        $sql = "SELECT count(*) FROM users";
        $result = $dbh->query($sql);
        $data = $result->fetchAll(PDO::FETCH_ASSOC);
        $count = $data[0]["count(*)"];

        if ($count > 15) {//test only 15 users
            http_response_code(403);
        }

	$sql = "INSERT INTO users (`role`, `username`, `password`, `phone`, `idcard`, `name`) VALUES
                ('2','".addslashes($username)."', '".addslashes($password)."', '".$phone."', '".addslashes($idcard)."', '".addslashes($name)."')";
        $sql = str_replace(";","",$sql);
        $stmt = $dbh->prepare($sql);
	$stmt->execute();

    }
} else {
    header("Location: /login.php");
}
