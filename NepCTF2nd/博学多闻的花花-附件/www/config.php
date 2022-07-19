<?php
define('MYSQL_HOST', '');
define('MYSQL_USER', '');
define('MYSQL_PASSWORD', '');
define('MYSQL_DATABASE', '');

error_reporting(0);
ini_set('display_errors', 'Off');
ini_set('allow_url_fopen', 'Off');
ini_set('session.cookie_httponly', 1);
session_start();

function addslashes_deep($value){
    if (empty($value)){
        return $value;
    }else {
        return is_array($value) ? array_map('addslashes_deep', $value): addslashes($value);
    }
}