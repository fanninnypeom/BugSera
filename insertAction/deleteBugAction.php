<?php
Session_Start(); 


$con = mysql_connect("localhost","root","");
  if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }
mysql_select_db("BugFade", $con);

$projectID=$_GET['projectID'];
$bugID=$_GET['bugID'];


$sql="select * from ".$projectID."buginfo";

$result = mysql_query($sql) or die(mysql_error());//得到已有用户的数量
$count=0;

	while($row = mysql_fetch_array($result)){
		$count=$count+1;
}
$time=date("Y-m-d H:i:s");
$creatorID=$_SESSION["ID"];



$sql="DELETE FROM "."$projectID"."buginfo WHERE ID='$bugID'";

if (!mysql_query($sql))
  {
  die('Error: ' . mysql_error());
  }
header("Location: http://127.0.0.1/bugCheck.php");//
exit();  


?>