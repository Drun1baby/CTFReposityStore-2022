<?php

class Ez
{
    function __construct()
    {

    }
    function __destruct()
    {
        $this->run();
    }
    function run()
    {
        echo "exit";
    }
}

class Junit
{
    private $judge;
    function __construct()
    {
        $this->judge = False;
    }

    function e($arguments)
    {
        if($this->judge)
        {
            eval(implode(", ", $arguments));
        }
    }
}

class Ez1
{
    function __construct()
    {

    }
    function __destruct()
    {
        $this->get();
    }
    function get()
    {
        echo "get";
    }
}

class Space
{
    protected $name;
    function __construct($name)
    {
        $this->name = $name;
    }
    function __wakeup()
    {
        echo "My name is " . $this->name;
    }
}

class CallFunction
{
    private $num;
    public $func;
    function __construct()
    {
        $this->num = 5;
    }

    function __call($function, $arguments)
    {
        if($this->num > 10)
        {
            call_user_func($this->func, $arguments);
        }
    }
}

class chain
{
    private $name;
    function __construct($name)
    {
        $this->name = $name;
    }
    function __set($func, $name)
    {
        echo $func;
    }
}

class Proc01
{
    public $param;
    function __construct()
    {
        $this->param = "whoami";
    }
    function __toString()
    {
        echo "toString 被调用";
        if(isset($this->param))
        {
            system("whoami");
        }
        return $this->param;
    }
}

class SetName
{
    private $app;
    protected $args;
    function __construct()
    {

    }
    function __isset($name)
    {
        $this->app->list($this->args);
    }
}

class GetName
{
    private $app;
    protected $args;
    function __construct()
    {

    }
    function __get($name)
    {
        $this->app->list($this->args);
    }
}


if(isset($_GET['b']))
{
    unserialize(base64_decode($_GET['b']));
}
else
{
    highlight_file(__FILE__);
}
