<?php
Session_Start(); 
if(!$_SESSION["login"]){
header("Location: http://127.0.0.1/error404.php");//
exit();  
}

$con = mysqli_connect("localhost","root","");
  if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }
  mysqli_select_db($con,"BugFade");

$bugID=$_GET['bugID'];
$projectID=$_GET['projectID'];
$userID=$_SESSION['ID'];

//~~~~~~~~~~~~~~

//根据type的不同跳转到不同的php页面，以实现对不同的角色显示不同的页面


  $s="select ID from $projectID"."buginfo where creatorID='$userID'";
  $result = mysqli_query($con,$s);
  $t=mysqli_fetch_array($result,MYSQLI_NUM);
  print_r($t);
  if(count($t[0])!=0){
    header("Location: http://127.0.0.1/bugForTester.php?bugID="."$bugID"."&projectID="."$projectID"); 
    exit();//此人为测试者
  }

  $s="select bugID from $projectID"."bugresponsibility where resID='$userID' and bugID='$bugID'";
  $result = mysqli_query($con,$s);
  $t=mysqli_fetch_array($result,MYSQLI_NUM);
  if(count($t[0])!=0){
    header("Location: http://127.0.0.1/bugForDeveloper.php?bugID="."$bugID"."&projectID="."$projectID"); 
    exit();//此人为领取Bug者
  }  

header("Location: http://127.0.0.1/bugForOther.php?bugID="."$bugID"."&projectID="."$projectID"); 
    exit();

?>
