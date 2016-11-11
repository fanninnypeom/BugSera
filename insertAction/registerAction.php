	<?php
Session_Start(); 

//用于注册用户的信息插入
$con = mysql_connect("localhost","root","");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }


mysql_select_db("BugFade", $con);

$result = mysql_query("select * from total where name='users'") or die(mysql_error());//得到已有用户的数量
	$row = mysql_fetch_array($result);//这个函数第一次被调用可以得到数据，再调用就没数据了，注意一下
$rowCount=$row['length'];
$rowCount=$rowCount+1;
//echo $rowCount;
//$sql;
if($rowCount==1	){
	$sql="INSERT INTO total (name, length)
VALUES
('users',$rowCount)";	
}
else{
	$sql="UPDATE total  SET length='$rowCount'
	WHERE name='users'";	
}
mysql_query($sql,$con);

$sql="INSERT INTO users (ID, Name, Password,Email,Reputation)
VALUES
('user$rowCount','$_POST[Username]','$_POST[Password]','$_POST[Email]',0)";
//reputation为声望(积分),初始值为0
//echo $sql;

if (!mysql_query($sql,$con))
  {
  die('Error: ' . mysql_error());
  }
//echo "1 record added";
$sql = "CREATE TABLE user"."$rowCount"."project 
(
ID varchar(20),
projectID varchar(20),
projectName varchar(20)
)";//这个表用来记录每个用户和哪些项目有关联，在查找的时候就只需要到相应项目的表中去查询了

if (!mysql_query($sql,$con))
  {
  die('Error: ' . mysql_error());
  }


mysql_close($con);

header("Location: http://127.0.0.1");//跳转回首页
//确保重定向后，后续代码不会被执行
exit;
?>


