
<?php
//管理员进入工程后显示的页面
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

<!-- Latest compiled and minified JavaScript -->



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
<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="index.php" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#" class="current">project</a> </div>
    <h1>项目信息</h1>
<button class="btn btn-large btn-danger" style="position: relative;
  left: 830px;
  top: 10px;"
  onclick="deleteProject()"> 
 删除项目
</button>

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
<?php 
$s="select * from $ID"."application";
$result=mysqli_query($con,$s);

?>
    <div class="row-fluid">
      <div class="span6">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-file"></i> </span>
            <h5>Recent Posts</h5>
          </div>
          <div class="widget-content nopadding">
            <ul class="recent-posts">
            <?php 
            	$p;
				while($t=mysqli_fetch_array($result,MYSQLI_NUM)){
					if($t[1]=="manager"){
						$p=1;
					}
					else if($t[1]=="developer"){
						$p=2;
					}
					else if($t[1]=="tester"){
						$p=3;
					}
				
            ?>
              <li>
                <div class="user-thumb"> <img width="40" height="40" alt="User" src="img/demo/av1.jpg"> </div>
                <div class="article-post">
                  <div class="fr">
                  <?php if($p==3)
                          echo "<a href=\"#\" id=\"$t[0]\" onclick=\"acceptTester(this)\" class=\"btn btn-primary btn-mini\">申请测试人员</a>";
                        else if($p==2)
                          echo "<a href=\"#\" id=\"$t[0]\" onclick=\"acceptDeveloper(this)\" class=\"btn btn-success btn-mini\">申请开发人员</a>";
                        else if($p==1)
                          echo "<a href=\"#\" id=\"$t[0]\" onclick=\"acceptManager(this)\" class=\"btn btn-danger btn-mini\">申请管理人员</a>";
                  ?>

                  </div>

                  <span class="user-info" > By: <?php echo $t[2] ?> / Date: <?php echo $t[4] ?> </span>
                  <p><a href="#"><?php echo $t[3] ?>.</a> </p>
                </div>
              </li>
  <?php } ?>
<!--
              <li>
                <div class="user-thumb"> <img width="40" height="40" alt="User" src="img/demo/av2.jpg"> </div>
                <div class="article-post">
                  <div class="fr"><a href="#" class="btn btn-primary btn-mini">Edit</a> <a href="#" class="btn btn-success btn-mini">Publish</a> <a href="#" class="btn btn-danger btn-mini">Delete</a></div>
                  <span class="user-info"> By: john Deo / Date: 2 Aug 2012 / Time:09:27 AM </span>
                  <p><a href="#">This is a much longer one that will go on for a few lines.It has multiple paragraphs and is full of waffle to pad out the comment.</a> </p>
                </div>
              </li>
              <li>
                <div class="user-thumb"> <img width="40" height="40" alt="User" src="img/demo/av3.jpg"> </div>
                <div class="article-post">
                  <div class="fr"><a href="#" class="btn btn-primary btn-mini">Edit</a> <a href="#" class="btn btn-success btn-mini">Publish</a> <a href="#" class="btn btn-danger btn-mini">Delete</a></div>
                  <span class="user-info"> By: john Deo / Date: 2 Aug 2012 / Time:09:27 AM </span>
                  <p><a href="#">This is a much longer one that will go on for a few lines.Itaffle to pad out the comment.</a> </p>
                </div>
              <li>
                <button class="btn btn-warning btn-mini">View All</button>
              </li>
  -->


            </ul>
          </div>
        </div>
       
      
      </div>
      <div class="span6">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-time"></i></span>
            <h5>分组列表</h5>
            <button class="btn btn-small btn-danger" style="position: relative;
  left: 240px;
  top: 5px;"
  onclick="popGroupForm()"
   >新添分组</button>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th>组别</th>
                  <th>操作</th>
                </tr>
              </thead>
              <tbody>
              <?php 
                $s2="select * from $ID"."group";
                $result2 = mysqli_query($con,$s2);

                while($t2=mysqli_fetch_array($result2,MYSQLI_NUM)){
                    
                    echo "<tr>
                  <td class=\"taskDesc\"> $t2[1]</td>
                  <td class=\"taskStatus\">
                  <span class=\"in-progress\">
                  <button id=\"$t2[0]\" onclick=\"deleteGroup(this)\" class=\"icon-remove\"></button>
                  </span>
                  </td>
                </tr>";
                }
              ?>
              </tbody>
            </table>
          </div>
        </div>
       



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
                  <th>操作</th>
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
                    $Reputation=$t3[4];

                    $s4="select * from $ID"."MemberGroup"." where name='$t2[0]'";
                    $result4 = mysqli_query($con,$s4);
                    $t4=mysqli_fetch_array($result4,MYSQLI_NUM);
                    $Position=$t4[0];
        /*            while($t4=mysqli_fetch_array($result4,MYSQLI_NUM)){
                      $s5="select * from $ID"."group"." where groupID='$t4[0]'";
                      $result5 = mysqli_query($con,$s5);
                      $t5=mysqli_fetch_array($result5,MYSQLI_NUM);
                      $Position=$Position.",".$t5[1];
                    }
          */
                    echo "<tr>
                  <td class=\"taskDesc\"> "."$Name"."</td>
                  <td class=\"taskStatus\"><span class=\"in-progress\">"."$Email"."</span></td>
                  <td class=\"taskStatus\"><span class=\"in-progress\">"."$Position"."</span></td>
                  <td class=\"taskStatus\"><span class=\"in-progress\">"."$Reputation"."</span></td>
                  <td class=\"taskStatus\"><span class=\"in-progress\">
                  <button  id=\"$t2[0]\" onclick=\"modifyGroup(this)\" class=\"icon-pencil\"></button>
                  <button mark=\"0\" id=\"$t2[0]\" onclick=\"deleteMember(this)\" class=\"icon-remove\"></button>
                                    </span></td>
                </tr>";
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
                 <th>操作</th>
                
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
                    $Reputation=$t3[4];

                    $s4="select * from $ID"."MemberGroup"." where name='$t2[0]'";
                    $result4 = mysqli_query($con,$s4);
                    $t4=mysqli_fetch_array($result4,MYSQLI_NUM);
                    $Position=$t4[0];
                    /*
                    while($t4=mysqli_fetch_array($result4,MYSQLI_NUM)){
                      $s5="select * from $ID"."group"." where groupID='$t4[0]'";
                      $result5 = mysqli_query($con,$s5);
                      $t5=mysqli_fetch_array($result5,MYSQLI_NUM);
                      $Position=$Position.",".$t5[1];
                    }
                    */
                    echo "<tr>
                  <td class=\"taskDesc\"> "."$Name"."</td>
                  <td class=\"taskStatus\"><span class=\"in-progress\">"."$Email"."</span></td>
                  <td class=\"taskStatus\"><span class=\"in-progress\">"."$Position"."</span></td>
                  <td class=\"taskStatus\"><span class=\"in-progress\">"."$Reputation"."</span></td>
                  <td class=\"taskStatus\"><span class=\"in-progress\">
                  <button id=\"$t2[0]\" onclick=\"modifyGroup(this)\" class=\"icon-pencil\"></button>
                  <button mark=\"1\" id=\"$t2[0]\" onclick=\"deleteMember(this)\" class=\"icon-remove\"></button>
                  </span></td>
                </tr>";
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

<!--end-Footer-part--> 
<div  class="widget-box" id="applyForm" style="display:none ;position:absolute; top:100px; right:400px;width:600px; height:160px; " >
        <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
          <h5>选择分组</h5>
        </div>
        <div class="widget-content nopadding">
          
       <center>
          
   <div class="input-group input-group-lg" >
                      <div class="input-group-btn input-group-lg">
      <select id="idsel" class="form-control" style="
          width:100px;
          appearance:none;
          -moz-appearance:none;
-webkit-appearance:none;
background:url(img/arrow.jpg) no-repeat right center;
background-color: #eee;
background-size:20%;
">
<?php 
$s2="select * from $ID"."group";
$result2 = mysqli_query($con,$s2);
while($t2=mysqli_fetch_array($result2,MYSQLI_NUM)){
      echo "<option value=\"$t2[1]\">"."$t2[1]"."</option>";
                }  
?>
</select>
</div>
</div>
 </center>
           
              <button onclick="submit()" class="btn btn-success" >创建</button>
            
        </div>
      </div>



<div  class="widget-box" id="modifyForm" style="display:none ;position:absolute; top:500px; right:400px;width:600px; height:105px; " >
        <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
          <h5>修改分组</h5>
        </div>
        <div class="widget-content nopadding">
       <center>
   <div class="input-group input-group-lg" >
                     
      <select id="idsel_" class="form-control" style="
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
</div>
 </center>
           
              <button onclick="modify()" class="btn btn-success" >修改</button>
            
        </div>
      </div>


      <div  class="widget-box" id="groupForm" style="display:none ;position:absolute; top:100px; right:400px;width:600px; height:160px;background-color:#FFFFFF " >
<center>
          <h3>新增分组名字</h3>

          <textarea class="span6" name="description" id="groupName"></textarea>

      <button class="btn btn-large btn-danger" onclick="addGroup()">添加</button>
</center>

      </div>     

<script src="js/jquery.min.js"></script> 
<script src="js/jquery.ui.custom.js"></script> 
<script src="js/bootstrap.min.js"></script> 
<script src="js/matrix.js"></script>
<script src="js/bootstrap-select.min.js"></script>

<!-- (Optional) Latest compiled and minified JavaScript translation files -->

<script type="text/javascript">
function acceptTester(t){
  console.log(t.id);
  $("#applyForm").css("display","");
  $("#applyForm").attr("userID",t.id);
  $("#applyForm").attr("type",1);
}
function acceptDeveloper(t){
  console.log(t.id);
  $("#applyForm").css("display","");
  $("#applyForm").attr("userID",t.id);
  $("#applyForm").attr("type",2);
}
function acceptManager(t){
  console.log(t.id);
  $("#applyForm").css("display","");
  $("#applyForm").attr("userID",t.id);
  $("#applyForm").attr("type",3);
}

function popGroupForm(){
  $("#groupForm").css("display","");
}

function addGroup(){
  $("#groupForm").css("display","none");
  var projectID=$("#projectID").attr("value");
  var groupName=$("#groupName").val();
  console.log(projectID);
  $.ajax({
    url: 'insertAction/addGroupAction.php',
    method:'post',
    data: {
    projectID: projectID,
    groupName: groupName
  }
})
  location.reload(true); 

}
function deleteProject()
{
  var projectID=$("#projectID").attr("value");
  var groupName=$("#groupName").val();
  console.log(projectID);
  console.log(groupName);
  var ifdelete=confirm("确定要删除该项目吗");
//   console.log(ifdelete);
  if(ifdelete)
  {
//    console.log(ifdelete);
/*    $.ajax({
      url: 'insertAction/deleteProject.php',
      method:'post',
        data: {
        projectID: projectID
      }
    })
  */
     window.location.href="insertAction/deleteProject.php?projectID="+projectID;
    console.log("delete success");
  }
}
function submit(){
  $("#applyForm").css("display","none");
  var userID=$("#applyForm").attr("userID");
  var projectID=$("#projectID").attr("value");
  var group=document.getElementById("idsel").value;
  console.log(document.getElementById("idsel").value)
  var position;
  if($("#applyForm").attr("type")==1)
    position="tester";
  else if($("#applyForm").attr("type")==2)
    position="developer";
  else 
    position="manager";

  $.ajax({
    url: 'insertAction/addMemberAction.php',
    method:'post',
    data: {
    position: position,
    userID: userID,
    projectID: projectID,
    group: group
  }
})

$.ajax({
    url: 'insertAction/deleteApplyAction.php',
    method:'post',
    data: {
    position: position,
    userID: userID,
    projectID: projectID
  }
})

location.reload(true);   
}
function modifyGroup(t){
  $("#modifyForm").css("display","");
  $("#modifyForm").attr("userID",t.id);
}
function modify(){
 $("#modifyForm").css("display","none");

  var userID=$("#modifyForm").attr("userID");

  var projectID=$("#projectID").attr("value");
  var group=document.getElementById("idsel_").value;
  console.log(userID);
  console.log(projectID);
  console.log(group);
  
  $.ajax({
    url: 'insertAction/modifyGroupAction.php',
    method:'post',
    data: {
    userID: userID,
    projectID: projectID,
    group: group
  }
})
location.reload(true); 
}
function deleteMember(t){
  var projectID=$("#projectID").attr("value");
  var userID=t.id;
  var type=t.getAttribute("mark");
  var position;
//  console.log(t);
  if(type==0)
      position="developer";
  else 
        position="tester";
  console.log(position);
  $.ajax({
    url: 'insertAction/deleteMemberAction.php',
    method:'post',
    data: {
    userID: userID,
    projectID: projectID,
    position: position
  }
})
location.reload(true); 
}

function deleteGroup(t){
  var projectID=$("#projectID").attr("value");
  console.log(projectID);
  var groupID=t.id;
  $.ajax({
    url: 'insertAction/deleteGroupAction.php',
    method:'post',
    data: {
    groupID: groupID,
    projectID: projectID
      }
})
location.reload(true); 
}


</script>
</body>
</html>
