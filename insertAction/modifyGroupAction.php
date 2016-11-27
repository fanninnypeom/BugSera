<?php
Session_Start(); 
if(!$_SESSION["login"]){
header("Location: http://127.0.0.1/error404.html");//
exit();  
}
$group=$_GET['group'];
$userID=$_GET['userID'];
$projectID=$_GET['projectID'];

$con = mysqli_connect("localhost","root","");
  if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }
mysqli_select_db($con,"BugFade");

$sql="
delimiter $$
drop procedure if exists updateGroup$$
create procedure updateGroup
(
projectID varchar(25),
group_ varchar(25),
userID varchar(25)
)
begin
  set @temp_table_query=concat('update ',projectID,' SET groupID=\'',group_,'\' WHERE name =\'',userID,'\'');
  prepare pst from @temp_table_query;
  execute pst;
  drop prepare pst;
end;
$$

delimiter ;
";

$result=mysqli_query($con,$sql);


//$s2="UPDATE "."$projectID"."membergroup SET groupID = '$group'
//WHERE name ='$userID'";
//mysqli_query($con,$s2);
$projectID=$projectID."membergroup";
$result=$con->query("call updateGroup('$projectID','$group','$userID')");

mysql_close($con);

?>
