<?php
Session_Start(); 
if(!$_SESSION["login"]){
header("Location: http://127.0.0.1/error404.html");//
exit();  
}
$con = mysqli_connect("localhost","root","");
  if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }
mysqli_select_db($con,"BugFade");


$ID=$_GET['projectID'];
$s2="select * from $ID"."group";
$result2 = mysqli_query($con,$s2);
//echo $ID;
while($t2=mysqli_fetch_array($result2,MYSQLI_NUM)){
//		echo $t2;
      echo "<option value=\"$t2[1]\">"."$t2[1]"."</option>";
                }

?>