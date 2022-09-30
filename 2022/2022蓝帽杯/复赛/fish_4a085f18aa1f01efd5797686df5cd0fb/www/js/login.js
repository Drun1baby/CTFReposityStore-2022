function l(){
    var xmlhttp=new XMLHttpRequest();
    xmlhttp.open("POST","/login.php",true);
    xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    var u=document.getElementsByClassName("inputstyle")[0].value;
    var p=document.getElementsByClassName("inputstyle")[1].value;
    xmlhttp.send("u="+u+"&p="+p);
}