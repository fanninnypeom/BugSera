<?php
Session_Start(); 
$con = mysqli_connect("localhost","root","");
  if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }
  mysqli_select_db($con,"BugFade");

?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Matrix Admin</title>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="stylesheet" href="css/bootstrap.min.css" />
<link rel="stylesheet" href="css/bootstrap-responsive.min.css" />
<link rel="stylesheet" href="css/matrix-style.css" />
<link rel="stylesheet" href="css/matrix-media.css" />
<link href="font-awesome/css/font-awesome.css" rel="stylesheet" />
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>
</head>
<body>

<!--Header-part-->
<div id="header">
  <h1><a href="dashboard.php">Matrix Admin</a></h1>
</div>
<!--close-Header-part--> 

<!--top-Header-menu-->

<div id="user-nav" class="navbar navbar-inverse">
  <ul class="nav">
    <li  class="dropdown" id="profile-messages" ><a title="" href="#" data-toggle="dropdown" data-target="#profile-messages" class="dropdown-toggle"><i class="icon icon-user"></i>  <span class="text">Welcome <?php 
       
    if(count($_SESSION)!=0&&$_SESSION["login"]==1){
    echo $_SESSION["usr"];
    echo $_SESSION["login"];
}
    else
      echo "visitor";
     ?>
</span><b class="caret"></b></a>
      <ul class="dropdown-menu">
        <li><a href="#"><i class="icon-user"></i> My Profile</a></li>
        <li class="divider"></li>
        <li><a href="#"><i class="icon-check"></i> My Tasks</a></li>
      </ul>
    </li>
    <li class=""><a title="" href=
<?php 
    if(count($_SESSION)!=0&&$_SESSION["login"]==1)
    echo "insertAction/logoutAction.php";
    else
      echo "Login.php";
     ?>
    ><i class="icon icon-share-alt"></i> <span class="text">
<?php 
    if(count($_SESSION)!=0&&$_SESSION["login"]==1)
    echo "Logout";
    else
      echo "Login";
     ?>
    </span></a></li>
    <li class=""><a title="" href="register.php"><i class="icon icon-plus"></i> <span class="text">Register</span></a></li>
  </ul>
</div>


<!--start-top-serch-->
<div id="search">
  <input type="text" placeholder="Search here..."/>
  <button type="submit" class="tip-bottom" title="Search"><i class="icon-search icon-white"></i></button>
</div>
<!--close-top-serch--> 
<div id="sidebar"><a href="#" class="visible-phone"><i class="icon icon-home"></i> Dashboard</a>
  <ul>
    <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>项目</span> <span class="label label-important">3</span></a>
      <ul>
        <li><a href="projectManage.php">管理的项目</a></li>
        <li><a href="projectTest.php">测试的项目</a></li>
        <li><a href="projectMaintain.php">维护的项目</a></li>
      </ul>
    </li>
    <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Bug</span> <span class="label label-important">3</span></a>
      <ul>
        <li><a href="bugSubmit.php">Bug &amp; 提交</a></li>
        <li><a href="bugCheck.php">Bug &amp; 审核</a></li>
        <li><a href="bugSolve.php">Bug &amp; 解决</a></li>
        <li><a href="bugClaim.php">Bug &amp; 领取</a></li>
      </ul>
    </li>
    <li><a href="solutions.php"><i class="icon icon-tint"></i> <span>解决方案</span></a></li>

    <li class="content" style="display:none"> <span>Monthly Bandwidth Transfer</span>
      <div class="progress progress-mini progress-danger active progress-striped">
        <div style="width: 77%;" class="bar"></div>
      </div>
      <span class="percent">77%</span>
      <div class="stat">21419.94 / 14000 MB</div>
    </li>
    <li class="content" style="display:none"> <span>Disk Space Usage</span>
      <div class="progress progress-mini active progress-striped">
        <div style="width: 87%;" class="bar"></div>
      </div>
      <span class="percent">87%</span>
      <div class="stat">604.44 / 4000 MB</div>
    </li>
  </ul>
</div>
<!--sidebar-menu-->

<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="index.php" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#" class="current">Bug认领区</a> </div>
    <h1>Bug认领区 </h1>
  </div>
  <div class="container-fluid">
    <hr>
    <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-ok"></i></span>
            <h5>无人问津的Bug</h5>
          </div>
          <div class="widget-content">
            <div class="todo">
              <ul>
                 <?php     
                 $usrID=$_SESSION["ID"];
              $sql="select distinct projectID from ".$usrID."project";
              $result = mysqli_query($con,$sql);
              while($row = mysqli_fetch_array($result,MYSQLI_NUM)){
              $sql1="select * from ".$row[0]."membermanage where memberID='$usrID'";
              $result1 = mysqli_query($con,$sql1);
              $row1 = mysqli_fetch_array($result1,MYSQLI_NUM);
              if($row1[1]=="developer"){
                   $sql2="select * from ".$row[0]."buginfo";
                   $result2 = mysqli_query($con,$sql2);
                   while($row2=mysqli_fetch_array($result2,MYSQLI_NUM)){
                    if($row2[2]=="newAdd"){
                      $sql3="select * from users where ID='$row2[4]'";
                      
                      $result3 = mysqli_query($con,$sql3);
                      $row3=mysqli_fetch_array($result3,MYSQLI_NUM);

                      $sql4="select * from ".$row[0]."buggroup where bugID='$row2[0]'";
                      $result4 = mysqli_query($con,$sql4);
                      $row4=mysqli_fetch_array($result4,MYSQLI_NUM);

                      $sql5="select * from ".$row[0]."membergroup where name='$usrID'";
                      $result5 = mysqli_query($con,$sql5);
                      $row5=mysqli_fetch_array($result5,MYSQLI_NUM);


                      if($row4[1]==$row5[0])

                      echo "<li class=\"clearfix\">
                  <div class=\"txt\"> <a href=\"bug.php\" > 
                  ".$row2[6]."   ".$row2[1]."
                   </a><span class=\"by label\">Creator:".$row3[1]."</span> <span class=\"date badge badge-important\">".$row2[3]."</span> </div>
                  <div class=\"pull-right\"> <a 
                  class=\"tip\" href=\"insertAction/acceptBugAction.php?bugID=$row2[0]&projectID=$row[0]\" onclick=\"acceptBug()\" title=\"Accept\"><i class=\"icon-pencil\"></i></a> </div>
                </li>";
                    }
                   }
              }
              }                         

              ?>
              </ul>
            </div>
          </div>
        </div>

    
  </div>
</div>
<!--Footer-part-->
<div class="row-fluid">
  <div id="footer" class="span12"> 2016 &copy; WuNing &amp;LiuYing. Power by <a href="http://themedesigner.in">Themedesigner.in</a> </div>
</div>

<!--end-Footer-part-->
<script src="js/jquery.min.js"></script> 
<script src="js/jquery.ui.custom.js"></script> 
<script src="js/bootstrap.min.js"></script> 
<script src="js/matrix.js"></script>
<script type="text/javascript">
function acceptBug(){

}
  

</script>

</body>
</html>
