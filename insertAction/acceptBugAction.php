<?php
Session_Start(); 

$bugID=$_GET['bugID'];
$projectID=$_GET['projectID'];
$usrID=$_SESSION['ID'];
 

$con = mysqli_connect("localhost","root","");
  if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }
  mysqli_select_db($con,"BugFade");
 $sql="UPDATE "."$projectID"."buginfo SET state='doing' WHERE ID='$bugID'";
 $result = mysqli_query($con,$sql);

echo $sql;

$time=date("Y-m-d H:i:s");
 $sql="INSERT INTO "."$projectID"."bugresponsibility (bugID, resID, getTime)
VALUES
('$bugID','$usrID','$time')";
echo $sql;

 $result = mysqli_query($con,$sql);

header("Location: http://127.0.0.1/bugClaim.php");


?>