<?php
Session_Start(); 
if(!$_SESSION["login"]){
header("Location: http://127.0.0.1/error404.php");//
exit();  
}

$solverID=$_SESSION['ID'];
$bugID=$_GET['bugID'];
$projectID=$_GET['projectID'];
$description=$_GET['description'];

$con = mysqli_connect("localhost","root","");
  if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }
mysqli_select_db($con,"BugFade");

$sql="select * from ".$projectID."solutions";

$result = mysqli_query($con,$sql);
$count=0;

	while($row = mysqli_fetch_array($result,MYSQLI_NUM)){
		$count=$count+1;
}

echo $count;

echo $description;
echo $bugID;
echo $solverID;

echo $projectID;
$ttt=date("Y-m-d H:i:s");

$s="INSERT INTO "."$projectID"."solutions(ID,content,bugID,solverID,accept,time)
VALUES
('solution$count','$description','$bugID','$solverID',0,'$ttt')";
echo $s;
$result = mysqli_query($con,$s);
?>
