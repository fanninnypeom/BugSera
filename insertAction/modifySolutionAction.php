<?php
Session_Start(); 
if(!$_SESSION["login"]){
header("Location: http://127.0.0.1/error404.html");//
exit();  
}
$state=$_GET['state'];
$bugID=$_GET['bugID'];
$projectID=$_GET['projectID'];
$solutionID=$_GET['solutionID'];


$con = mysqli_connect("localhost","root","");
  if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }
mysqli_select_db($con,"BugFade");


$s2="UPDATE "."$projectID"."solutions SET accept = '$state'
WHERE ID ='$solutionID'";
mysqli_query($con,$s2);

if($state==1){
$s2="SELECT * FROM "."$projectID"."solutions
WHERE ID ='$solutionID'";
$result=mysqli_query($con,$s2);
$row=mysqli_fetch_array($result,MYSQLI_NUM);

$s2="UPDATE "."$projectID"."buginfo SET solverID = '$row[3]'
WHERE ID ='$bugID'";
mysqli_query($con,$s2);

}

mysql_close($con);

?>
