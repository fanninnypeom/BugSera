
<?php

//测试人员进入工程后显示的页面
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
  <h1><a href="dashboard.php">Matrix Admin</a></h1>
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

    <li class="content" style="display: none;"> <span>Monthly Bandwidth Transfer</span>
      <div class="progress progress-mini progress-danger active progress-striped">
        <div style="width: 77%;" class="bar"></div>
      </div>
      <span class="percent">77%</span>
      <div class="stat">21419.94 / 14000 MB</div>
    </li>
    <li class="content" style="display: none;"> <span>Disk Space Usage</span>
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
    <div id="breadcrumb"> <a href="index.php" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#" class="current">project</a> </div>
    <h1>项目信息</h1>
    <button class="btn btn-large btn-success" style="position: relative;
  left: 730px;
  top: 0px;"
  onclick="popBug()"
   >提交Bug</button>
  </div>
  <div class="container-fluid"><hr>
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-briefcase"></i> </span>
            <h5 id="projectID" value="<?php 
            echo $ID;
            ?>"  ><?php 
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
                      <td class="width70"><strong>
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
    <div class="row-fluid">
      <div class="span6">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-file"></i> </span>
            <h5>Bug Lists</h5>
          </div>
          <div class="widget-content nopadding">
            <ul class="recent-posts">
              
              <?php 
              $sql="select * from ".$ID."buginfo";
    $result = mysqli_query($con,$sql);//得到已有用户的数量
  while($row = mysqli_fetch_array($result,MYSQLI_NUM)){
              $r = mysqli_query($con,"select * from users where ID='$row[4]'");
              $rr=mysqli_fetch_array($r,MYSQLI_NUM);
              $pri="";
              if($row[5]==1){
                $pri="一般";
              }
              else if($row[5]==2){
                $pri="重要";
              }
              else if($row[5]==3){
                $pri="紧急";
              }
              else{
                $pri="非常紧急";
              }
              $r1 = mysqli_query($con,"select * from ".$ID."buggroup where bugID='$row[0]'");
              $rr1=mysqli_fetch_array($r1,MYSQLI_NUM);

              echo "<li>
                <div class=\"user-thumb\"> <img width=\"40\" height=\"40\" alt=\"User\" src=\"img/demo/av1.jpg\"> </div>
                <div class=\"article-post\">
                  <div class=\"fr\">
<a href=\"#\" class=\"btn btn-primary btn-mini\">".$rr1[1]."</a>                  
<a href=\"#\" class=\"btn btn-danger btn-mini\">".$pri."</a>
<a href=\"#\" class=\"btn btn-success btn-mini\">".$row[2]."</a></div>
                  <span class=\"user-info\"> ".$row[6]."  By: ".$rr[1]." / Date: ".$row[3]."  </span>
                  <p><a href=\"bug.php?bugID=".$row[0]."&projectID=".$ID."\">".$row[1]."</a> </p>
                </div>
              </li>";
            }
              ?>
            </ul>
          </div>
        </div>
       
      
      </div>
      <div class="span6">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-time"></i></span>
            <h5>管理员列表</h5>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th>姓名</th>
                  <th>邮箱</th>
                </tr>
              </thead>
              <tbody>
              <?php 
                $s2="select * from $ID"."membermanage"." where position='manager'";
                $result2 = mysqli_query($con,$s2);

                while($t2=mysqli_fetch_array($result2,MYSQLI_NUM)){
                    $s3="select * from users where ID='$t2[0]'";
                    $result3 = mysqli_query($con,$s3);
                    $t3=mysqli_fetch_array($result3,MYSQLI_NUM);
                    $Name=$t3[1];
                    $Email=$t3[3];
                    echo '<tr>
                  <td class="taskDesc"> '."$Name".'</td>
                  <td class="taskStatus"><span class="in-progress">'."$Email".'</span></td>
                </tr>';
                }
              ?>
              </tbody>
            </table>
          </div>
        </div>
       
       <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-time"></i></span>
            <h5>开发人员列表</h5>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th>姓名</th>
                  <th>邮箱</th>
                  <th>组别</th>
                  <th>声望</th>
                </tr>
              </thead>
              <tbody>
              <?php 
                
                $s2="select * from $ID"."membermanage"." where position='developer'";
                $result2 = mysqli_query($con,$s2);

                while($t2=mysqli_fetch_array($result2,MYSQLI_NUM)){
                    $s3="select * from users where ID='$t2[0]'";
                    $result3 = mysqli_query($con,$s3);
                    $t3=mysqli_fetch_array($result3,MYSQLI_NUM);
                    $Name=$t3[1];
                    $Email=$t3[3];
                    $Reputation=$t2[2];
                    $s4="select * from $ID"."MemberGroup"." where name='$t2[0]'";
                    $Position;
                    $result4 = mysqli_query($con,$s4);
                    $t4=mysqli_fetch_array($result4,MYSQLI_NUM);
                    /*
                    while($t4=mysqli_fetch_array($result4,MYSQLI_NUM)){
                      $s5="select * from $ID"."group"." where groupID='$t4[0]'";
                      $result5 = mysqli_query($con,$s5);
                      $t5=mysqli_fetch_array($result5,MYSQLI_NUM);
                      $Position=$Position.",".$t5[1];
                    }
                    */
                    $Position=$t4[0];
                    echo '<tr>
                  <td class="taskDesc"> '."$Name".'</td>
                  <td class="taskStatus"><span class="in-progress">'."$Email".'</span></td>
                  <td class="taskStatus"><span class="in-progress">'."$Position".'</span></td>
                  <td class="taskStatus"><span class="in-progress">'."$Reputation".'</span></td>
                </tr>';
                
                }
              ?>
               
              </tbody>
            </table>
          </div>
        </div>
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-time"></i></span>
            <h5>测试人员列表</h5>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th>姓名</th>
                  <th>邮箱</th>
                  <th>组别</th>
                  <th>声望</th>
                
                </tr>
              </thead>
              <tbody>
              <?php 
                $s2="select * from $ID"."membermanage"." where position='tester'";
                $result2 = mysqli_query($con,$s2);

                while($t2=mysqli_fetch_array($result2,MYSQLI_NUM)){
                    $s3="select * from users where ID='$t2[0]'";
                    $result3 = mysqli_query($con,$s3);
                    $t3=mysqli_fetch_array($result3,MYSQLI_NUM);
                    $Name=$t3[1];
                    $Email=$t3[3];
                    $Reputation=$t2[2];
                    $s4="select * from $ID"."MemberGroup"." where name='$t2[0]'";
                    $Position;
                    $result4 = mysqli_query($con,$s4);
                    $t4=mysqli_fetch_array($result4,MYSQLI_NUM);
                    /*
                    while($t4=mysqli_fetch_array($result4,MYSQLI_NUM)){
                      $s5="select * from $ID"."group"." where groupID='$t4[0]'";
                      $result5 = mysqli_query($con,$s5);
                      $t5=mysqli_fetch_array($result5,MYSQLI_NUM);
                      $Position=$Position.",".$t5[1];
                    }
                    */
                    $Position=$t4[0];
                    echo '<tr>
                  <td class="taskDesc"> '."$Name".'</td>
                  <td class="taskStatus"><span class="in-progress">'."$Email".'</span></td>
                  <td class="taskStatus"><span class="in-progress">'."$Position".'</span></td>
                  <td class="taskStatus"><span class="in-progress">'."$Reputation".'</span></td>
                </tr>';
                
                }
              ?>
                
              </tbody>
            </table>
          </div>
        </div>

  </div>
</div>
<!--Footer-part-->
<div class="row-fluid">
  <div id="footer" class="span12"> 2016 &copy; WuNing &amp;LiuYing. Power by <a href="http://themedesigner.in">Themedesigner.in</a> </div>
</div>

<div id="bugForm" class="widget-box" style="position:absolute; top:100px; right:600px;width:600px; height:160px;background:#DDD; display:none">
        <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
          <h5>Bug-info</h5>
        </div>
        <div class="widget-content nopadding" style="background:#DDD">
          <form class="form-horizontal" name=bugF>
            <div class="control-group">
              <label class="control-label" >名称 :</label>
              <div class="controls">
                <input type="text" class="span4" name="bugName" placeholder="First name" />
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" >Description</label>
              <div class="controls">
                <textarea class="span4" name="bugDescription"></textarea>
              </div>
            </div>
            <center>
            <select id="groupSelect" class="form-control" style="
          width:100px;
background-color: #eee;

">
<?php 
$s2="select * from $ID"."group";
$result2 = mysqli_query($con,$s2);
while($t2=mysqli_fetch_array($result2,MYSQLI_NUM)){
      echo "<option value=\"$t2[1]\">"."$t2[1]"."</option>";
                }  
?>
</select>
            <select id="prioritySelect" class="form-control" style="
          width:100px;background-color: #eee;
">
<option value="1">一般</option>
<option value="2">重要</option>
<option value="3">紧急</option>
<option value="4">非常紧急</option>
</select>
</center>
            
          </form>
          <div style="background:#DDD">
              <button onclick="submitBug()" class="btn btn-success">Save</button>
            </div>
        </div>
      </div>
      


<!--end-Footer-part--> 
<script src="js/jquery.min.js"></script> 
<script src="js/jquery.ui.custom.js"></script> 
<script src="js/bootstrap.min.js"></script> 
<script src="js/matrix.js"></script>
<script type="text/javascript">
function popBug(){
    $("#bugForm").css("display","");
}
function submitBug(){
    $("#bugForm").css("display","none");
    var group=document.getElementById("groupSelect").value;
    var priority=document.getElementById("prioritySelect").value;
    var name=bugF.bugName.value;
    var description=bugF.bugDescription.value; 
    var projectID=$("#projectID").attr("value");
    var type=0;
    $.ajax({
    url: 'insertAction/addBugAction.php',
    method:'post',
    data: {
    group: group,
    priority: priority,
    name: name,
    description: description,
    projectID: projectID,
    type:type
  }
})
       
}



</script>
</body>
</html>
