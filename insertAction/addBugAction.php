<?php
Session_Start(); 


$con = mysql_connect("localhost","root","");
  if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }
mysql_select_db("BugFade", $con);

$group=$_GET['group'];
$priority=$_GET['priority'];
$name=$_GET['name'];
$description=$_GET['description'];
$projectID=$_GET['projectID'];
$type=$_GET['type'];
echo $group;

echo $priority;
echo $name;
echo $description;
echo $projectID;
echo $type;


$sql="select * from ".$projectID."buginfo";

$result = mysql_query($sql) or die(mysql_error());//得到已有用户的数量
$count=0;

	while($row = mysql_fetch_array($result)){
		$count=$count+1;
}
$time=date("Y-m-d H:i:s");
$creatorID=$_SESSION["ID"];

if($type==0){
$sql="INSERT INTO ".$projectID."buginfo (ID, description, state,createdTime,creatorID,priority,name,solverID)
VALUES
('bug$count','$description','newAdd','$time','$creatorID','$priority','$name','null')";
	mysql_query($sql);
}
//bug的状态为 waitingExam newAdd waitingCheck doing reOpen solved waitSolves 
else{
$sql="INSERT INTO ".$projectID."buginfo (ID, description, state,createdTime,creatorID,priority,name,solverID)
VALUES
('bug$count','$description','waitingExam','$time','$creatorID','$priority','$name','null')";
	mysql_query($sql);
  exit();
}


$sql="INSERT INTO ".$projectID."buggroup (bugID, groupID)
VALUES
('bug$count','$group')";

//http://127.0.0.1/insertAction/addBugAction.php?group=sql&priority=1&name=zz&description=adwukh&projectID=project22&type=0
if (!mysql_query($sql))
  {
  die('Error: ' . mysql_error());
  }


?>