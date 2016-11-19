<?php
Session_Start(); 
if(!$_SESSION["login"]){
header("Location: http://127.0.0.1/error404.html");//
exit();  
}
$state=$_GET['state'];
$bugID=$_GET['bugID'];
$projectID=$_GET['projectID'];

$con = mysqli_connect("localhost","root","");
  if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }
mysqli_select_db($con,"BugFade");

$s2="UPDATE "."$projectID"."buginfo SET state = '$state'
WHERE ID ='$bugID'";
echo $s2;
mysqli_query($con,$s2);
//header("Location: http://127.0.0.1/bugForTester.php?projectID=".$projectID."&bugID=".$bugID);


?>
