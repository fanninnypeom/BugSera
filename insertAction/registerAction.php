	<?php
//用于注册用户的信息插入
$con = mysql_connect("localhost","root","");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }


mysql_select_db("BugFade", $con);

$result = mysql_query("select * from total where name='users'") or die(mysql_error());//得到已有用户的数量
print_r(mysql_fetch_array($result));
//$r=mysql_fetch_array($result,MYSQL_NUM);
$re=array();
$rowCount=0;
echo "length1";
//while(
	$row = mysql_fetch_array($result,MYSQL_NUM);
//	)
//  {
  	echo "length";
  	echo $row[1];
//  $re[0]=$row;
//  print_r(mysql_fetch_array($row));
//  }
$re[0]=mysql_fetch_assoc($result);
$rowCount=$row['length'];
$rowCount=$rowCount+1;
echo $rowCount;
$sql;
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
//echo 'row';
//echo $rowCount;


//echo $_POST;

//foreach($_POST as $key=>$value)
//echo $key."=>".$value;
// print_r($_POST);


$sql="INSERT INTO users (ID, Name, Password,Email,Reputation)
VALUES
('user$rowCount','$_POST[Username]','$_POST[Password]','$_POST[Email]',0)";
//reputation为声望(积分),初始值为0
echo $sql;

if (!mysql_query($sql,$con))
  {
  die('Error: ' . mysql_error());
  }
echo "1 record added";

mysql_close($con)
?>


