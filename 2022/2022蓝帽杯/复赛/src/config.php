<?php
session_start();
$dbh = new PDO('mysql:host=127.0.0.1;dbname=hospital', 'hospital', '123123');
function analyse($filename, $data) {
    global $dbh;
    $filehash = md5($data);
    $sql = "SELECT * FROM files where hash=:hash";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':hash', $filehash);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (empty($result)) {
        $sql = "INSERT INTO files(`hash`, `shell`) VALUES (?,?)";
        $stmt = $dbh->prepare($sql);
        if (preg_match("/(<\?php\s)|(<\?=)/i", $data)) {
            $stmt->execute(array($filehash, 'yes'));
            return false;
        } else {
            $stmt->execute(array($filehash, 'no'));
            return true;
        }
    } else {
        if ($result[0]['shell'] === 'yes') {
            return false;
        } else {
            return true;
        }
    }
    

}
