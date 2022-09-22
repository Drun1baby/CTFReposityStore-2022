<?php
include_once "config.php";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = file_get_contents("php://input");
    $json_data = json_decode($data);
    $username = $json_data->username;
    $passwd = $json_data->passwd;
    $sql = "SELECT * FROM users WHERE username=:name LIMIT 1";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':name', $username);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    header("Content-Type: application/json");
    if (empty($data)) {
        die('{"code":3}');
    }
    $sql_password = $data[0]["password"];
    $phone = $data[0]["phone"];
    if ($sql_password === $passwd) {
        $_SESSION['username'] = $username;
        $_SESSION['phone'] = $phone;
        $role = $data[0]["role"];
        echo '{"code":'.$role.'}';
    } else {
        echo '{"code":3}';
    }

} else {
    header("Location: /login.html");
}

