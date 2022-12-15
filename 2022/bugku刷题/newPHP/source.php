<?php
// php版本:5.4.44
header("Content-type: text/html; charset=utf-8");
highlight_file(__FILE__);

class evil{
    public $hint;

    public function __construct($hint){
        $this->hint = $hint;
    }

    public function __destruct(){
    if($this->hint==="hint.php")
            @$this->hint = base64_encode(file_get_contents($this->hint)); 
        var_dump($this->hint);
    }

    function __wakeup() { 
        if ($this->hint != "╭(●｀∀´●)╯") { 
            //There's a hint in ./hint.php
            $this->hint = "╰(●’◡’●)╮"; 
        } 
    }
}

class User
{
    public $username;
    public $password;

    public function __construct($username, $password){
        $this->username = $username;
        $this->password = $password;
    }

}

function write($data){
    global $tmp;
    $data = str_replace(chr(0).'*'.chr(0), '\0\0\0', $data);
    $tmp = $data;
}

function read(){
    global $tmp;
    $data = $tmp;
    $r = str_replace('\0\0\0', chr(0).'*'.chr(0), $data);
    return $r;
}

$tmp = "test";
$username = $_POST['username'];
$password = $_POST['password'];

$a = serialize(new User($username, $password));
if(preg_match('/flag/is',$a))
    die("NoNoNo!");

unserialize(read(write($a)));
