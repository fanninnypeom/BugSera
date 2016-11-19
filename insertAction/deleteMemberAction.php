<?php
Session_Start(); 
if(!$_SESSION["login"]){
header("Location: http://127.0.0.1/error404.html");//
exit();  
}
$position=$_GET['position'];
$userID=$_GET['userID'];
$projectID=$_GET['projectID'];

$con = mysqli_connect("localhost","root","");
  if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }
mysqli_select_db($con,"BugFade");

$s2="DELETE FROM "."$projectID"."membermanage WHERE memberID='$userID'";// and position='$position' 不支持一个人多个职位，所以将这个人的信息全部删除
mysqli_query($con,$s2);

$s2="DELETE FROM "."$projectID"."membergroup WHERE name='$userID'";//不支持一个人多个分组，所以将这个人的信息全部删除
mysqli_query($con,$s2);


mysql_close($con);

?>
