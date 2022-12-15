<?php
//flag in flag.php
error_reporting(0);
class UUCTF{
    public $name,$key,$basedata,$ob;
    function __construct($str){
        $this->name=$str;
    }
    function __wakeup(){
    if($this->key==="UUCTF"){
            $this->ob=unserialize(base64_decode($this->basedata));
        }
        else{
            die("oh!you should learn PHP unserialize String escape!");
        }
    }
}
class output{
    public $a;
    function __toString(){
        $this->a->rce();
    }
}
class nothing{
    public $a;
    public $b;
    public $t;
    function __wakeup(){
        $this->a="";
    }
    function __destruct(){
        $this->b=$this->t;
        die($this->a);
    }
}
class youwant{
    public $cmd;
    function rce(){
        eval($this->cmd);
    }
}
$pdata=$_POST["data"];
if(isset($pdata))
{
    $data=serialize(new UUCTF($pdata));
    $data_replace=str_replace("hacker","loveuu!",$data);
    unserialize($data_replace);
}else{
    highlight_file(__FILE__);
}

$uu = new UUCTF('Drunkbaby');
$uu->key = "UUCTF";

$b = new youwant();
$b->cmd = 'flag.php';

$c = new output();
$c->$a = $b;
?>