<?php
show_source(__FILE__);

###very___so___easy!!!!
class test{
    public $a;
    public $b;
    public $c;
    public function __construct(){
        $this->a=1;
        $this->b=2;
        $this->c=3;
    }
    public function __wakeup(){
        $this->a='';
    }
    public function __destruct(){
        $this->b=$this->c;
        eval($this->a);
    }
}


$temp = new test;
$temp->a = 'phpinfo();';
$temp->b = '4';
$temp->c = '4';
$payload = serialize($temp);
echo($payload);

$a='123';
if(!preg_match('/test":3/i',$a)){
    die("你输入的不正确！！！搞什么！！");
}
$bbb=unserialize($_GET['a']);

?>