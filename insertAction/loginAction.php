<?php
Session_Start(); 
$con = mysql_connect("localhost","root","");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }


mysql_select_db("BugFade", $con);

$sql="select * from users where Name='$_POST[userID]' and password='$_POST[password]'";

$result = mysql_query($sql) or die(mysql_error());//得到已有用户的数量
$row = mysql_fetch_array($result);
print_r($row);

$_SESSION["usr"]=$row['Name'];
if(count($row['Name'])!=0)
$_SESSION["login"]=1;
else
$_SESSION["login"]=0;

$_SESSION["ID"]=$row['ID'];

mysql_close($con);

header("Location: http://127.0.0.1");//跳转回首页
//确保重定向后，后续代码不会被执行
exit;

?>
