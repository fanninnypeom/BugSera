<?php
header('content-type:application/json;charset=utf8');
Session_Start(); 
$id=$_GET['userID'];
$con = mysqli_connect("localhost","root","");
  if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }
  mysqli_select_db($con,"BugFade");
    $re = array();
	for($i=0;$i<10;$i++) {
	for($j=0;$j<2;$j++) {
	$re[$i][$j]=$i;
		}
	}
  for($i=0;$i<10;$i++){
      $tem=9-$i;
      $ddd=date("Y-m-d",strtotime("-".$tem." day"));
      $result1=mysqli_query($con,"select * from $id"."project");
      $count=0;
        while($p=mysqli_fetch_array($result1,MYSQLI_NUM)){
          $result2=mysqli_query($con,"select ID from $p[1]"."solutions where time='$ddd' and solverID='$id'");

    //echo "select ID from $p[0]"."buginfo where createdTime='$ddd' and creatorID='$id'";
          
          while($p1=mysqli_fetch_array($result2,MYSQLI_NUM)){
             $count++;
        }
}    
      $re[$i][1]=$count;
   }

	echo json_encode($re);

?>
