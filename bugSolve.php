<?php
Session_Start(); 
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
    <div id="breadcrumb"> <a href="index.php" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#" class="current">Bug &amp; 解决</a> </div>
    <h1>Bug &amp; 解决 </h1>
  </div>
  <div class="container-fluid">
    <hr>
    <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-ok"></i></span>
            <h5>unSolved Bug list</h5>
          </div>
          <div class="widget-content">
            <div class="todo">
              <ul>
                <?php
    //  echo "~~~~~~~~~~~~~~~~~~~";
      
                $con = mysqli_connect("localhost","root","");
  if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }
  mysqli_select_db($con,"bugfade");
   $id=$_SESSION["ID"];
   $result1=mysqli_query($con,"select projectID from $id"."project");
   while($p=mysqli_fetch_array($result1,MYSQLI_NUM))
   {
    $test_group=mysqli_query($con,"select memberID from $p[0]"."membermanage where position = 'developer' and memberID='$id' ");
    $flag=false; 
    if(count($test_group)<=0)
      continue; 
    while($t=mysqli_fetch_array($test_group,MYSQLI_NUM))
    {
      if($t[0]==$id)
        $flag=true;
    }
    if($flag==true)
    {
      $b=mysqli_query($con,"select * from $p[0]"."bugresponsibility where resID='$id'");
      while($bl=mysqli_fetch_array($b,MYSQLI_NUM)){
      $bug=mysqli_query($con,"select * from $p[0]"."buginfo where ID='$bl[0]'");

      while($buglist=mysqli_fetch_array($bug,MYSQLI_NUM))
      {
        if($buglist[7]!=$id){
        $z=mysqli_query($con,"select * from users where ID='$buglist[4]'");
        $zz=mysqli_fetch_array($z,MYSQLI_NUM);
      
        if($buglist[2]!="solved")
        echo "<li class=\"clearfix\">
                  <div  href=\"bug.php?bugID=".$buglist[0]."&projectID=".$p[0]."\" class=\"txt\"> "."$buglist[6] "." : "." $buglist[1] "." <span class=\"by label\">"."$zz[1]"." </span> <span class=\"date badge badge-important\">"."$buglist[3]"."</span> 

                  <a class=\"date badge badge-important\" href=\"bug.php?bugID=".$buglist[0]."&projectID=".$p[0]."\"> go</a>
                  </div><div class=\"pull-right\"> 
                  
            
                  </div></li>"; 
                  } 
      } 
}
    }
   }
               ?>
              </ul>
            </div>
          </div>
        </div>

<hr>
    <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-ok"></i></span>
            <h5>solved Bug list</h5>
          </div>
          <div class="widget-content">
            <div class="todo">
              <ul>
                
                <?php
    //  echo "~~~~~~~~~~~~~~~~~~~";
      
                $con = mysqli_connect("localhost","root","");
  if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }
  mysqli_select_db($con,"bugfade");
   $id=$_SESSION["ID"];
   $result1=mysqli_query($con,"select projectID from $id"."project");
   while($p=mysqli_fetch_array($result1,MYSQLI_NUM))
   {
    $test_group=mysqli_query($con,"select memberID from $p[0]"."membermanage where position = 'developer' and memberID='$id' ");
    $flag=false; 
    if(count($test_group)<=0)
      continue; 
    while($t=mysqli_fetch_array($test_group,MYSQLI_NUM))
    {
      if($t[0]==$id)
        $flag=true;
    }
    if($flag==true)
    {
      $bug=mysqli_query($con,"select * from $p[0]"."buginfo where solverID='$id'");

      while($buglist=mysqli_fetch_array($bug,MYSQLI_NUM))
      {

        $z=mysqli_query($con,"select * from users where ID='$buglist[4]'");
        $zz=mysqli_fetch_array($z,MYSQLI_NUM);
        echo "<li class=\"clearfix\">
                  <div  href=\"bug.php?bugID=".$buglist[0]."&projectID=".$p[0]."\" class=\"txt\"> "."$buglist[6] "." : "." $buglist[1] "." <span class=\"by label\">"."$zz[1]"." </span> <span class=\"date badge badge-important\">"."$buglist[3]"."</span> 

                  <a class=\"date badge badge-important\" href=\"bug.php?bugID=".$buglist[0]."&projectID=".$p[0]."\"> go</a>
                  </div><div class=\"pull-right\"> 
                  
                 
                  </div></li>";  
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
</body>
</html>
