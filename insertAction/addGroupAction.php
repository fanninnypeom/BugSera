<?php
Session_Start(); 
if(!$_SESSION["login"]){
header("Location: http://127.0.0.1/error404.html");//
exit();  
}
$projectID=$_GET['projectID'];
$groupName=$_GET['groupName'];

$con = mysqli_connect("localhost","root","");
  if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }
mysqli_select_db($con,"BugFade");


$s2="select * from $projectID"."group";
$result2 = mysqli_query($con,$s2);
$count=0;
while($t2=mysqli_fetch_array($result2,MYSQLI_NUM))
      $count++;
            

$count++;
$s="INSERT INTO "."$projectID"."group (groupID,name)
VALUES
('$count','$groupName')";
$result = mysqli_query($con,$s);
  

?>
