<?php
Session_Start(); 
if(!$_SESSION["login"]){
header("Location: http://127.0.0.1/error404.html");//
exit();  
}
$bugID=$_GET['bugID'];
$projectID=$_GET['projectID'];
$group=$_GET['group'];
$priority=$_GET['priority'];

$con = mysqli_connect("localhost","root","");
  if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }
mysqli_select_db($con,"BugFade");
$userId=$_SESSION["ID"];
$userName=$_SESSION["usr"];
$time=date("Y-m-d H:i:s");
$s="UPDATE $projectID"."buginfo SET state = 'newAdd',priority=$priority
WHERE ID = '$bugID'";
$result = mysqli_query($con,$s);

echo $s;  

$s="INSERT INTO "."$projectID"."buggroup (bugID,groupID)
VALUES
('$bugID','$group')";
$result = mysqli_query($con,$s);

$s="SELECT * from "."$projectID"."buginfo where ID='$bugID'";
$result = mysqli_query($con,$s);
$row=mysqli_fetch_array($result,MYSQLI_NUM);


$s="INSERT INTO "."$projectID"."bugcheck (ID,checkerID,creatorID)
VALUES
('$bugID','$userId','$row[4]')";
$result = mysqli_query($con,$s);


?>
