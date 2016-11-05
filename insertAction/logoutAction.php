<?php
session_start();//在某一个页面使用session之前一定要先用这个函数，否则对session做出的更改都会被丢掉，浪费我好久时间
$_SESSION["login"]=0;
//echo $_SESSION["login"];
header("Location: http://127.0.0.1");
?>