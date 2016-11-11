
<?php
//游客进入工程后显示的页面

?>


<?php
Session_Start(); 
$ID=$_GET['ID'];



$con = mysqli_connect("localhost","root","");
  if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }
  mysqli_select_db($con,"BugFade");

$s="select * from projects where ID='$ID'";
$result = mysqli_query($con,$s);
$t=mysqli_fetch_array($result,MYSQLI_NUM);
$name=$t[5];
$description=$t[4];
$dueTime=$t[3];
$createdTime=$t[2];
$createrID=$t[1];

$s1="select * from users where ID='$createrID'";
$result1 = mysqli_query($con,$s1);
$t1=mysqli_fetch_array($result1,MYSQLI_NUM);
$createrName=$t1[1];


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

<!--sidebar-menu-->
<div id="sidebar"><a href="#" class="visible-phone"><i class="icon icon-home"></i> Dashboard</a>
  <ul>
    <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>项目</span> <span class="label label-important">3</span></a>
      <ul>
        <li><a href="projectManage.html">管理的项目</a></li>
        <li><a href="projectTest.html">测试的项目</a></li>
        <li><a href="projectMaintain.html">维护的项目</a></li>
      </ul>
    </li>
    <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Bug</span> <span class="label label-important">3</span></a>
      <ul>
        <li><a href="bugSubmit.html">Bug &amp; 提交</a></li>
        <li><a href="bugCheck.html">Bug &amp; 审核</a></li>
        <li><a href="bugSolve.html">Bug &amp; 解决</a></li>
        <li><a href="bugClaim.html">Bug &amp; 领取</a></li>
      </ul>
    </li>
    <li><a href="solutions.html"><i class="icon icon-tint"></i> <span>解决方案</span></a></li>

    <li class="content"> <span>Monthly Bandwidth Transfer</span>
      <div class="progress progress-mini progress-danger active progress-striped">
        <div style="width: 77%;" class="bar"></div>
      </div>
      <span class="percent">77%</span>
      <div class="stat">21419.94 / 14000 MB</div>
    </li>
    <li class="content"> <span>Disk Space Usage</span>
      <div class="progress progress-mini active progress-striped">
        <div style="width: 87%;" class="bar"></div>
      </div>
      <span class="percent">87%</span>
      <div class="stat">604.44 / 4000 MB</div>
    </li>
  </ul>
</div>
<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#" class="current">project</a> </div>
    <h1>项目信息</h1>
    <button class="btn btn-large btn-danger" style="position: relative;left: 430px;top: 0px;" onclick="popManager()"
   >申请成为管理人员</button>
    <button class="btn btn-large btn-success" style="position: relative;
  left: 530px;
  top: 0px;"
  onclick="popDeveloper()"
   >申请成为开发人员</button>
    <button class="btn btn-large btn-primary" style="position: relative;
  left: 630px;
  top: 0px;"
  onclick="popTester()"
   >申请成为测试人员</button>
  </div>
  <div class="container-fluid"><hr>
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-briefcase"></i> </span>
            <h5 ><?php 
            echo $name;
            ?></h5>
          </div>
          <div class="widget-content">
            <div class="row-fluid">
              <div class="span6">
                <table class="">
                  <tbody>
                    <tr>
          <?php echo $description; ?>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="span6">
                <table class="table table-bordered table-invoice">
                  <tbody>
                    <tr>
                    <tr>
                      <td class="width30">项目 ID:</td>
                      <td class="width70" id="projectID" value="<?php 
                        echo $ID;
                        ?>">
                        <strong>
                        <?php 
                        echo $ID;
                        ?>
                      </strong></td>
                    </tr>
                    <tr>
                      <td>创建日期:</td>
                      <td><strong>
                        <?php 
                        echo $createdTime;
                        ?>
                      </strong></td>
                    </tr>
                    <tr>
                      <td>创建人:</td>
                      <td><strong>
                        <?php 
                        echo $createrName;
                        ?>
                      </strong></td>
                    </tr>
                  </tr>
                    </tbody>
                  
                </table>
              </div>
            </div>
        
          </div>
        </div>
      </div>
    </div>


    <hr>
    
<!--Footer-part-->
<div class="row-fluid">
  <div id="footer" class="span12"> 2016 &copy; WuNing &amp;LiuYing. Power by <a href="http://themedesigner.in">Themedesigner.in</a> </div>
</div>

<div  class="widget-box" id="tip1" style="display:none ;position:absolute; top:100px; right:600px;width:600px; height:160px; " >
<center>
          <h3>备注信息</h3>
          <textarea style="width:350px;" class="span11" name="description" id="description1"></textarea>

		<button class="btn btn-large btn-danger" onclick="askManager()">申请</button>
</center>

      </div>

<div  class="widget-box" id="tip2" style="display:none ;position:absolute; top:100px; right:600px;width:600px; height:160px; " >
<center>
          <h3>备注信息</h3>

          <textarea style="width:350px;" class="span11" name="description" id="description2"></textarea>

			<button class="btn btn-large btn-danger" onclick="askDeveloper()">申请</button>
</center>

      </div>

      <div  class="widget-box" id="tip3" style="display:none ;position:absolute; top:100px; right:600px;width:600px; height:160px; " >
<center>
          <h3>备注信息</h3>

          <textarea style="width:350px;" class="span11" name="description" id="description3"></textarea>

			<button class="btn btn-large btn-danger" onclick="askTester()">申请</button>
</center>

      </div>

<!--end-Footer-part--> 
<script src="js/jquery.min.js"></script> 
<script src="js/jquery.ui.custom.js"></script> 
<script src="js/bootstrap.min.js"></script> 
<script src="js/matrix.js"></script>
<script type="text/javascript">

//以下三个函数通过ajax调用addApplicationAction.php来将请求添加到数据库中
function popManager(){
  $("#tip1").css("display","");	
}


function popDeveloper(){
  $("#tip2").css("display","");	
}

function popTester(){
  $("#tip3").css("display","");	
}
function askManager(){
  var position = "manager";
  var ID=$("#projectID").attr("value");
  var description=$("#description1").val();
	$.ajax({
		url: 'insertAction/addApplicationAction.php',
		method:'post',
		data: {
		position: position,
		ID: ID,
		description: description
	}
})
	 $("#tip1").css("display","none");	
}                

function askDeveloper(){
  $("#tip2").css("display","");
  var position = "developer";
  var ID=$("#projectID").attr("value");
  var description=$("#description2").val();
 	$.ajax({
		url: 'insertAction/addApplicationAction.php',
		method:'post',
		data: {
		position: position,
		ID: ID,
		description: description
	}
})
	 $("#tip2").css("display","none");	

}

function askTester(){
  $("#tip3").css("display","");
  var position = "tester";
  var ID=$("#projectID").attr("value");
  var description=$("#description3").val();
	$.ajax({
		url: 'insertAction/addApplicationAction.php',
		method:'post',
		data: {
		position: position,
		ID: ID,
		description: description
	}
})
	 $("#tip3").css("display","none");	

}




</script>


</body>
</html>

