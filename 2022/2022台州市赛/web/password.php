<?php
$passwd = getenv("passwd");
# passwd 的格式为 [a-zA-z0-9]{10}
$hintfile = "/tmp/hint".$passwd;
system("touch $hintfile");

if (isset($_GET['passwd'])){
    foreach ((new DirectoryIterator($_GET['dir'])) as $file){
        echo $file->getSize()."\n<br>";
    }

    if ($_GET["passwd"]===$passwd){
        eval($_GET["cmd"]);
    }
    
}else{
    highlight_file(__FILE__);
}