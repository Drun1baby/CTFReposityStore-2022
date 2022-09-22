<?php

error_reporting(0);
$action=$_GET['action'];

switch ($action) {
    case "upload":
        doUpload();
        break;
    case "include":
        doInclude();
    default:
        "nothing here";

}


function doInclude(){
    $file=$_POST['filename'];
    if(preg_match("/log|php|tmp/i",$file)){
        die("error filenname");
    }
    if(file_exists($file)){
        include "file://".$file;
    }
}

function doUpload(){
    if($_FILES["file"]["error"]>0){
        $ret = ["code"=>1,"msg"=>"文件上传失败"];
        die(json_encode($ret));
    }


    $file = $_FILES['file']['name'];
    $tmp_name=$_FILES['file']['tmp_name'];
    $content=file_get_contents($tmp_name);

    if(filter_filename($file)){
        $ret = ["code"=>2,"msg"=>"文件上传失败"];
        die(json_encode($ret));
    }

    if(filter_content($content)){
        $ret = ["code"=>3,"msg"=>"文件上传失败"];
        die(json_encode($ret));
    }

    move_uploaded_file($tmp_name,"./upload/".$file);
    $ret = ["code"=>0,"msg"=>"文件上传成功,文件路径为  /var/www/html/upload/".$file];
    die(json_encode($ret));
    
}

function filter_filename($file){
    $ban_ext=array("jpeg","png");
    $file_ext = end(explode(".",$file));
    return !in_array($file_ext,$ban_ext);
}

function filter_content($content){
    return preg_match("/php|include|require|get|post|request/i",$content);
}