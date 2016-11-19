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
$userID=$_SESSION['usr'];

//~~~~~~~~~~~~~~

//根据type的不同跳转到不同的php页面，以实现对不同的角色显示不同的页面
if($type==0){
  $s="select position from $ID"."membermanage where ID="."'$userID'";
  $result = mysqli_query($con,$s);
  $t=mysqli_fetch_array($result,MYSQLI_NUM);
  if(count($t[0])==0){
    $type=4; //在项目人员管理表中找不到这个人，那么这个人就是游客
  }
  else if($t[0]=="manager"){
    $type=1;
  }
  else if($t[0]=="tester"){
    $type=3; 
  }
  else if($t[0]=="developer"){
    $type=2; 
  }
}

if($type==1){
  header("Location: http://127.0.0.1/projectForManager.php"."?ID="."$ID");
  exit();  
}
else if($type==2){
  header("Location: http://127.0.0.1/projectForDeveloper.php"."?ID="."$ID");
  exit();  
}
else if($type==3){
  header("Location: http://127.0.0.1/projectForTester.php"."?ID="."$ID");
  exit();  
}
else if($type==4){
  header("Location: http://127.0.0.1/projectForTourist.php"."?ID="."$ID");
  exit();  
}

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
  <h1><a href="dashboard.html">Matrix Admin</a></h1>
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
    <li class="dropdown" id="menu-messages"><a href="#" data-toggle="dropdown" data-target="#menu-messages" class="dropdown-toggle"><i class="icon icon-envelope"></i> <span class="text">Messages</span> <span class="label label-important">5</span> <b class="caret"></b></a>
      <ul class="dropdown-menu">
        <li><a class="sAdd" title="" href="#"><i class="icon-plus"></i> new message</a></li>
        <li class="divider"></li>
        <li><a class="sInbox" title="" href="#"><i class="icon-envelope"></i> inbox</a></li>
        <li class="divider"></li>
        <li><a class="sOutbox" title="" href="#"><i class="icon-arrow-up"></i> outbox</a></li>
        <li class="divider"></li>
        <li><a class="sTrash" title="" href="#"><i class="icon-trash"></i> trash</a></li>
      </ul>
    </li>
    <li class=""><a title="" href="#"><i class="icon icon-cog"></i> <span class="text">Settings</span></a></li>
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
    <div id="breadcrumb"> <a href="index.php" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#" class="current">Bug</a> </div>
  
    <h1>Bug</h1>
    </div>
     
  <div class="container-fluid">
    <hr>
    <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-time"></i></span>
            <h5>问题TZ_1283</h5>
            <h5><span class="date badge badge-important">已解决</span></h5>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-striped table-bordered">

              <tbody>
                <tr>
                  <td class="taskDesc"><i class="icon-info-sign"></i> 提出者</td>
                  <td class="taskStatus"><span class="in-progress">fanninnypeom</span></td>
                </tr>
                <tr>
                  <td class="taskDesc"><i class="icon-plus-sign"></i> 提出时间</td>
                  <td class="taskStatus"><span class="pending">2016.11.3</span></td>
                </tr>
                <tr>
                  <td class="taskDesc"><i class="icon-ok-sign"></i> 紧急程度</td>
                  <td class="taskStatus"><span class="done">十万火急</span></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      <div class="widget-box">
          <div class="widget-title">
            <ul class="nav nav-tabs">
              <li class="active"><a data-toggle="tab" href="#tab1">Bug详述</a></li>

            </ul>
          </div>
          <div class="widget-content tab-content">
            <div id="tab1" class="tab-pane active">
              <p>And is full of waffle to It has multiple paragraphs and is full of waffle to pad out the comment. Usually, you just wish these sorts of comments would come to an end.multiple paragraphs and is full of waffle to pad out the comment. Usually, you just wish these sorts of comments would come to an end.multiple paragraphs and is full of waffle to pad out the comment. Usually, you just wish these sorts of comments would come to an end. </p>
            </div>

          </div>
        </div>

    <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-list"></i> 解决方案TA_1211</span>
            <h5>解决者:</h5>
            <span class="icon"><a href="">fanninnypeom</a></span>

            <h5><span class="date badge badge-important">通过</span></h5>
          </div> 
          <div class="widget-content"> 
          使用gcc5.0重新编译protobuf即可 </div>
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
