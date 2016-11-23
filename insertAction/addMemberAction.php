<?php
Session_Start(); 
if(!$_SESSION["login"]){
header("Location: http://127.0.0.1/error404.php");//
exit();  
}
$userID=$_GET['userID'];
$position=$_GET['position'];
$projectID=$_GET['projectID'];
$group=$_GET['group'];

$con = mysqli_connect("localhost","root","");
  if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }
mysqli_select_db($con,"BugFade");

$s="INSERT INTO "."$projectID"."membermanage (memberID,position,projectReputation)
VALUES
('$userID','$position',0)";
$result = mysqli_query($con,$s);
  
$s="INSERT INTO "."$projectID"."membergroup (groupID,name)
VALUES
('$group','$userID')";   //这里修改一下，groupID里存的是group的名字,name里存的是人的ID。。。这样更合理...(还能少写点代码)
$result = mysqli_query($con,$s);

$s="select * from projects where ID=$projectID";
$result = mysqli_query($con,$s);
$row = mysqli_fetch_array($result,MYSQLI_NUM);
$projectName=$row[5];
 

$s="INSERT INTO "."$userID"."project (ID,projectID,projectName)
VALUES
('$userID','$projectID','$projectName')";
$result = mysqli_query($con,$s);



?>
