<?php
Session_Start(); 
if(!$_SESSION["login"]){
header("Location: http://127.0.0.1/error404.html");//
exit();  
}
$ID=$_GET['ID'];
$position=$_GET['position'];
$description=$_GET['description'];

echo $ID;

$con = mysqli_connect("localhost","root","");
  if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }
mysqli_select_db($con,"BugFade");
$userId=$_SESSION["ID"];
$userName=$_SESSION["usr"];
$time=date("Y-m-d H:i:s");
$s="INSERT INTO "."$ID"."application (aID,position,userName,description,time)
VALUES
('$userId','$position','$userName','$description','$time')";


$result = mysqli_query($con,$s);
  
?>
