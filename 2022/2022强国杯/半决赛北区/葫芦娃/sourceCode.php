if(empty($_POST['Huluxiaojinggang']) || empty($_POST['Shejing'])){
    die('¿´ÎÒËÄÍÞÅç»ð£¡¿´ÎÒÎåÍÞÅçË£¡');
}

$secret = getenv("secret");

if(isset($_POST['yeye']))
    $secret = hash_hmac('sha256', $_POST['yeye'], $secret);


$qwer = hash_hmac('sha256', $_POST['Shejing'], $secret);

if($qwer !== $_POST['Huluxiaojinggang']){
    die('¿´ÎÒ´óÍÞ ÕýµÅ£¬±ÞÍÈ£¬´ÌÈ­£¬ÑµÁ·ÓÐËØ¡£');
}

echo exec("nc".$_POST['Shejing']);