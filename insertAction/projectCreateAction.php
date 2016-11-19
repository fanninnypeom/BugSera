	<?php
Session_Start(); 

if(!$_SESSION["login"]){
header("Location: http://127.0.0.1/error404.html");//
exit();  
}

//用于注册用户的信息插入
$con = mysql_connect("localhost","root","");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }


mysql_select_db("BugFade", $con);

$result = mysql_query("select * from total where name='projects'") or die(mysql_error());//得到已有项目的数量
	$row = mysql_fetch_array($result);//这个函数第一次被调用可以得到数据，再调用就没数据了，注意一下
$rowCount=$row['length'];
$rowCount=$rowCount+1;
//echo $rowCount;
//$sql;
if($rowCount==1	){
	$sql="INSERT INTO total (name, length)
VALUES
('projects',$rowCount)";	
}
else{
	$sql="UPDATE total  SET length='$rowCount'
	WHERE name='projects'";	
}
mysql_query($sql,$con);
$creator=$_SESSION["ID"];
date_default_timezone_set('Etc/GMT-8'); 
$time=date("Y-m-d H:i:s");

$sql="INSERT INTO projects (ID, createrID, CreatedTime,dueTime,description,name)
VALUES
('project$rowCount','$creator','$time','$_POST[dueTime]','$_POST[description]','$_POST[projectName]')";

//reputation为声望(积分),初始值为0
//echo $sql;


if (!mysql_query($sql,$con))
  {
  die('Error: ' . mysql_error());
  }
//echo "1 record added";

$sql = "CREATE TABLE project"."$rowCount"."BugInfo 
(
ID varchar(20),
description varchar(15),
state varchar(15),
createdTime date,
creatorID varchar(20),
priority int,
name varchar(20),
solverID varchar(20)
)";
mysql_query($sql,$con);


$sql = "CREATE TABLE project"."$rowCount"."BugCheck 
(
ID varchar(20),
checkerID varchar(20),
creatorID varchar(20)
)";
mysql_query($sql,$con);


$sql = "CREATE TABLE project"."$rowCount"."Solutions 
(
ID varchar(20),
content varchar(1000),
bugID varchar(20),
solverID varchar(20)
)";
mysql_query($sql,$con);

$sql = "CREATE TABLE project"."$rowCount"."Group 
(
groupID varchar(20),
name varchar(20)
)";
mysql_query($sql,$con);//项目分组表


$sql = "CREATE TABLE project"."$rowCount"."MemberGroup 
(
groupID varchar(20),
name varchar(20)
)";
mysql_query($sql,$con);//项目人员分组表

$sql = "CREATE TABLE project"."$rowCount"."BugGroup 
(
bugID varchar(20),
groupID varchar(20)
)";
mysql_query($sql,$con);//项目Bug分组表


$sql = "CREATE TABLE project"."$rowCount"."MemberManage 
(
memberID varchar(20),
position varchar(20),
projectReputation int
)";
mysql_query($sql,$con);//项目人员管理表

$sql = "CREATE TABLE project"."$rowCount"."MemberManage 
(
memberID varchar(20),
position varchar(20),
projectReputation int
)";
mysql_query($sql,$con);//项目人员管理表
echo $_SESSION["ID"]; 
$id=$_SESSION["ID"];
$sql="INSERT INTO project"."$rowCount"."MemberManage(memberID,position, projectReputation)
VALUES('$id','manager',0)";

mysql_query($sql,$con);//将创建者作为管理人员加入到人员列表中



$sql = "CREATE TABLE project"."$rowCount"."BugResponsibility 
(
bugID varchar(20),
resID varchar(20),
getTime int
)";
mysql_query($sql,$con);//项目Bug负责表

$sql = "CREATE TABLE project"."$rowCount"."Application 
(
aID varchar(20),
position varchar(20),
userName varchar(20),
description varchar(1000),
time date
)";
mysql_query($sql,$con);//项目申请表...保存游客对某一项目的申请



$sql="INSERT INTO "."$id"."project (ID, projectID,projectName)
VALUES
('$id','project$rowCount','$_POST[projectName]')";
//插入一项到userXXproject中，表明用户和该project有关联
if (!mysql_query($sql,$con))
  {
  die('Error: ' . mysql_error());
  }



mysql_close($con);

header("Location: http://127.0.0.1/projectManage.php");//跳转回项目管理界面
//确保重定向后，后续代码不会被执行
exit;
?>


