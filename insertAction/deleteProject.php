<?php
session_start();
if(!$_SESSION["login"]){
	header("Location: http://127.0.0.1/error404.php");//
	exit(); 
}

$projectID=$_GET['projectID'];
//$groupName=$_GET['groupName'];



$con = mysqli_connect("localhost","root","");
  if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }
// header("Location: http://127.0.0.1/error404.html");
mysqli_select_db($con,"bugfade");
// header("Location: http://127.0.0.1/error404.html");
mysqli_query($con,"DROP TABLE "."$projectID"."application");
// header("Location: http://127.0.0.1/error404.html");
mysqli_query($con,"DROP TABLE "."$projectID"."bugcheck");
mysqli_query($con,"DROP TABLE "."$projectID"."buggroup");
mysqli_query($con,"DROP TABLE "."$projectID"."buginfo");
mysqli_query($con,"DROP TABLE "."$projectID"."bugresponsibility");
mysqli_query($con,"DROP TABLE "."$projectID"."group");
mysqli_query($con,"DROP TABLE "."$projectID"."membermanage");
mysqli_query($con,"DROP TABLE "."$projectID"."membergroup");
mysqli_query($con,"DROP TABLE "."$projectID"."solutions");
mysqli_query($con,"DELETE FROM projects where ID='$projectID'");
$result=mysqli_query($con,"select ID from users");
while($t2=mysqli_fetch_array($result,MYSQLI_NUM)){
	mysqli_query($con,"DELETE from $t2[0]"."project where projectID='$projectID'");
}
 //print("delete success");
//header("Location: http://127.0.0.1/error404.php");
//echo "~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~";
header("Location: http://127.0.0.1/projectManage.php");
exit();
?>