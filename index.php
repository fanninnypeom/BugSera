<?php
Session_Start(); 

if(!$_SESSION["login"]){
header("Location: http://127.0.0.1/error404.php");//
exit();  
}


$ID=$_SESSION["ID"];
//$con = new mysqli('localhost', 'test', '', 'test');
$con = mysqli_connect("localhost","root","");
  if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }
$z=mysqli_select_db($con,"bugfade");
if(!$z){
  mysqli_query($con,"CREATE DATABASE bugfade");
  mysqli_select_db($con,"bugfade");
}

if(mysqli_num_rows(mysqli_query($con,"SHOW TABLES LIKE '%users%'"))==1) {
} else {
   $sql = "CREATE TABLE users 
(
ID varchar(20),
Name varchar(20),
Password varchar(20),
Email varchar(20),
Reputation int(10)
)";
mysqli_query($con,$sql);
}
if(mysqli_num_rows(mysqli_query($con,"SHOW TABLES LIKE '%total%'"))==1) {
} else {
   $sql = "CREATE TABLE total 
(
name varchar(20),
length int(10)
)";
mysqli_query($con,$sql);
}
if(mysqli_num_rows(mysqli_query($con,"SHOW TABLES LIKE '%projects%'"))==1) {
} else {
   $sql = "CREATE TABLE projects 
(
ID varchar(20),
createrID varchar(20),
createdTime date,
dueTime date,
description varchar(1024),
name varchar(20)
)";
mysqli_query($con,$sql);
}

///////////////以下为删除项目的触发器
$sql="DROP TRIGGER IF EXISTS deleteProjectTrigger;";
$con->query($sql);
$sql="CREATE TRIGGER deleteProjectTrigger 
AFTER DELETE ON projects
FOR EACH ROW
BEGIN 
";
$result=mysqli_query($con,"select ID from users");
while($t2=mysqli_fetch_array($result,MYSQLI_NUM)){
  $sql=$sql."DELETE from $t2[0]"."project where projectID=old.ID;";
}
$sql=$sql." END;";
$con->query($sql);
///////////////////定义存储过程
//call projectNum('user17project')
$sql="
delimiter $$
drop procedure if exists projectNum$$
create procedure projectNum( table_id varchar(25) )
begin
  set @temp_query = 'drop temporary table if exists temp_cursor_table';
  prepare pst from @temp_query;
  execute pst;
  drop prepare pst; -- or
  -- deallocate prepare pst;

  set @temp_table_query='create temporary table temp_cursor_table ';
  set @temp_table_query=concat( @temp_table_query, ' select ID from ' );
  set @temp_table_query=concat( @temp_table_query, table_id );

  prepare pst from @temp_table_query;
  execute pst;
  drop prepare pst;

  -- now write your actual cursor and update statements
  -- in a separate block
  begin
    declare done int default false;
    declare stmt1 varchar(1024);
    declare stmt2 varchar(1024);
    declare count int;
    declare id varchar(20);    
    declare getid cursor for  
              select ID from temp_cursor_table;
    declare continue handler for not found set done = 1;

    set count=0;
    open getid;
    fetch getid into id;
    repeat
      set count=count+1;
      fetch getid into id;
    until done end repeat;
    close getid;
    select count;
  end;
end;
$$

delimiter ;
";

$result=mysqli_query($con,$sql);

$sql="
DROP VIEW IF EXISTS pprojects;";

$result=mysqli_query($con,$sql);

$sql="create view pprojects(id,content,name) as select projects.ID,projects.description,projects.name from projects with local check option;
";
$result=mysqli_query($con,$sql);


?>
<!DOCTYPE html>
<html lang="en">
<head>
<title id="zz" userID="<?php echo $ID; ?>">Bug Fade</title>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="stylesheet" href="css/bootstrap.min.css" />
<link rel="stylesheet" href="css/bootstrap-responsive.min.css" />
<link rel="stylesheet" href="css/fullcalendar.css" />
<link rel="stylesheet" href="css/matrix-style.css" />
<link rel="stylesheet" href="css/matrix-media.css" />
<link href="font-awesome/css/font-awesome.css" rel="stylesheet" />
<link rel="stylesheet" href="css/jquery.gritter.css" />
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>
</head>
<body>

<!--Header-part-->
<div id="header">
  
  <h1><a href="dashboard.html">Bug Fade</a></h1>
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

<div id="all">
</div>
<!--close-top-Header-menu-->
<!--start-top-serch-->
<div id="search">

  <button type="submit" class="tip-bottom" title="Show">浏览所有项目<i class="icon-search icon-white" onclick="showAllProject()"></i></button>
  <input type="text" id="searchProject" placeholder="Search project..."/>
  <button type="submit" class="tip-bottom" title="Search"><i class="icon-search icon-white" onclick="search()"></i></button>
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
    <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Bug</span> <span class="label label-important">4</span></a>
      <ul>
        <li><a href="bugSubmit.php">Bug &amp; 提交</a></li>
        <li><a href="bugCheck.php">Bug &amp; 审核</a></li>
        <li><a href="bugSolve.php">Bug &amp; 解决</a></li>
        <li><a href="bugClaim.php">Bug &amp; 领取</a></li>
      </ul>
    </li>
    <li><a href="solutions.html"><i class="icon icon-tint"></i> <span>解决方案</span></a></li>

    <li class="content" style="display:none;"> <span>Monthly Bandwidth Transfer</span>
      <div class="progress progress-mini progress-danger active progress-striped">
        <div style="width: 77%;" class="bar"></div>
      </div>
      <span class="percent">77%</span>
      <div class="stat">21419.94 / 14000 MB</div>
    </li>
    <li class="content" style="display:none;"> <span>Disk Space Usage</span>
      <div class="progress progress-mini active progress-striped">
        <div style="width: 87%;" class="bar"></div>
      </div>
      <span class="percent">87%</span>
      <div class="stat">604.44 / 4000 MB</div>
    </li>
  </ul>
</div>
<!--sidebar-menu-->

<!--main-container-part-->
<div id="content">
<!--breadcrumbs-->
  <div id="content-header">
    <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a></div>
  </div>
<!--End-breadcrumbs-->

<!--Action boxes-->
  <div class="container-fluid">
    <div class="quick-actions_homepage">
      <ul class="quick-actions">
        <li class="bg_lb"> <a href="projectManage.php"> <i class="icon-dashboard"></i> <span class="label label-important"></span> 管理的项目 </a> </li>
        <li class="bg_lg span3"> <a href="projectTest.php"> <i class="icon-signal"></i> 测试的项目</a> </li>
        <li class="bg_ly"> <a href="projectMaintain.php"> <i class="icon-inbox"></i><span class="label label-success"></span> 负责维护的项目 </a> </li>
        <li class="bg_lo"> <a href="bugSubmit.php"> <i class="icon-th"></i> 已提交的Bug</a> </li>
        <li class="bg_ls"> <a href="bugCheck.php"> <i class="icon-fullscreen"></i> Bug &amp; 审核</a> </li>
        <li class="bg_lo span3"> <a href="bugSolve.php"> <i class="icon-th-list"></i> Bug &amp; 解决</a> </li>
        <li class="bg_lb"> <a href="bugClaim.php"> <i class="icon-pencil"></i>Bug认领区</a> </li>
        <li class="bg_ls"> <a href="solutions.php"> <i class="icon-tint"></i> 我的解决方案</a> </li>

<!--
        <li class="bg_lg"> <a href="calendar.html"> <i class="icon-calendar"></i> Calendar</a> </li>
        <li class="bg_lr"> <a href="error404.html"> <i class="icon-info-sign"></i> Error</a> </li>
-->
      </ul>
    </div>
<!--End-Action boxes-->    

<!--Chart-box-->    
    <div class="row-fluid">
      <div class="widget-box">
        <div class="widget-title bg_lg"><span class="icon"><i class="icon-signal"></i></span>
          <h5>Recent Analytics</h5>
        </div>
        <div class="widget-content" >
          <div class="row-fluid">
            <div class="span9">
              <div id="placeholder" class="chart"></div>
            </div>
            <div class="span3">
              <ul class="site-stats">
<?php 
$myProjectNum=0;
$table=$ID."project";
$result=$con->query("call projectNum('$table')");
$row=$result->fetch_array(MYSQLI_ASSOC);
$myProjectNum=$myProjectNum+$row['count'];


$con = mysqli_connect("localhost","root","");
  if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }
$z=mysqli_select_db($con,"bugfade");
//$row = $result->fetch_array(MYSQLI_ASSOC);
//$row=$result->fetch_array(MYSQLI_ASSOC);
//$myProjectNum=$row["count"];
//$myProjectNum=mysqli_fetch_array($result,MYSQLI_NUM)[0];
/*
$result=mysqli_query($con,"select * from ".$ID."project");
while($t2=mysqli_fetch_array($result,MYSQLI_NUM)){
  $myProjectNum=$myProjectNum+1;
}
*/
$result=mysqli_query($con,"select * from users where ID='$ID'");
$t2=mysqli_fetch_array($result,MYSQLI_NUM);
$reputation=$t2[4];

$totalUsers=0;
$table="users";
$result=$con->query("call projectNum('$table')");
//print_r($result);
$row=$result->fetch_array(MYSQLI_ASSOC);
$totalUsers=$totalUsers+$row['count'];

$con = mysqli_connect("localhost","root","");
  if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }
$z=mysqli_select_db($con,"bugfade");


/*
$result=mysqli_query($con,"select * from users");
while($t2=mysqli_fetch_array($result,MYSQLI_NUM)){
  $totalUsers=$totalUsers+1;
}
*/

$totalProjects=0;
$table="projects";
$result=$con->query("call projectNum('$table')");
//print_r($result);
$row=$result->fetch_array(MYSQLI_ASSOC);
$totalProjects=$totalProjects+$row['count'];

$con = mysqli_connect("localhost","root","");
  if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }
$z=mysqli_select_db($con,"bugfade");

/*
$result=mysqli_query($con,"select * from projects");
while($t2=mysqli_fetch_array($result,MYSQLI_NUM)){
  $totalProjects=$totalProjects+1;
}
*/

$totalBugs=0;
$result=mysqli_query($con,"select projectID from ".$ID."project");
while($t2=mysqli_fetch_array($result,MYSQLI_NUM)){
   $result1=mysqli_query($con,"select ID from $t2[0]"."buginfo");
  while($t3=mysqli_fetch_array($result1,MYSQLI_NUM)){
    $totalBugs=$totalBugs+1;
  }
}


$totalSolutions=0;
$result=mysqli_query($con,"select projectID from ".$ID."project");
while($t2=mysqli_fetch_array($result,MYSQLI_NUM)){
/*
    $table=$t2[0]."solutions";
    $result=$con->query("call projectNum('$table')");
    $row=$result->fetch_array(MYSQLI_ASSOC);
    $totalSolutions=$totalSolutions+$row['count'];
    $con = mysqli_connect("localhost","root","");
    if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }
  $z=mysqli_select_db($con,"bugfade");
  */

  $result1=mysqli_query($con,"select ID from $t2[0]"."solutions");
  while($t3=mysqli_fetch_array($result1,MYSQLI_NUM)){
    $totalSolutions=$totalSolutions+1;
  }
}



?>

                <li class="bg_lh"><i class="icon-shopping-cart"></i> <strong><?php echo $myProjectNum; ?></strong> <small>My Projects</small></li>
                <li class="bg_lh"><i class="icon-user"></i> <strong><?php echo $reputation; ?></strong> <small>My Reputation</small></li>
                <li class="bg_lh"><i class="icon-globe"></i> <strong><?php echo $totalUsers; ?></strong> <small>Total Users</small></li>
                <li class="bg_lh"><i class="icon-plus"></i> <strong><?php echo $totalProjects; ?></strong> <small>Total Projects </small></li>
                <li class="bg_lh"><i class="icon-repeat"></i> <strong><?php echo $totalBugs; ?></strong> <small>Total Bugs</small></li>
                <li class="bg_lh"><i class="icon-globe"></i> <strong><?php echo $totalSolutions; ?></strong> <small>Total Solutions</small></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
<!--End-Chart-box--> 
    <hr/>


<!--end-main-container-part-->

<!--Footer-part-->

<div class="row-fluid">
  <div id="footer" class="span12"> 2016 &copy; WuNing &amp;LiuYing. Power by <a href="http://themedesigner.in">Themedesigner.in</a> </div>
</div>

<!--end-Footer-part-->

<script src="js/excanvas.min.js"></script> 
<script src="js/jquery.min.js"></script> 
<script src="js/jquery.ui.custom.js"></script> 
<script src="js/bootstrap.min.js"></script> 
<script src="js/jquery.flot.min.js"></script> 
<script src="js/jquery.flot.resize.min.js"></script> 
<script src="js/jquery.peity.min.js"></script> 
<script src="js/fullcalendar.min.js"></script> 
<script src="js/matrix.js"></script> 
<script src="js/jquery.gritter.min.js"></script> 
<script src="js/matrix.interface.js"></script> 
<script src="js/matrix.chat.js"></script> 
<script src="js/jquery.validate.js"></script> 
<script src="js/matrix.form_validation.js"></script> 
<script src="js/jquery.wizard.js"></script> 
<script src="js/jquery.uniform.js"></script> 
<script src="js/select2.min.js"></script> 
<script src="js/matrix.popover.js"></script> 
<script src="js/jquery.dataTables.min.js"></script> 
<script src="js/matrix.tables.js"></script> 

<script type="text/javascript">
  // This function is called from the pop-up menus to transfer to
  // a different page. Ignore if the value returned is a null string:
//  function goPage (newURL) {

      // if url is empty, skip the menu dividers and reset the menu selection to default
//      if (newURL != "") {
      
          // if url is "-", it is this page -- reset the menu:
//          if (newURL == "-" ) {
//              resetMenu();            
 //         } 
          // else, send page to designated URL            
  //        else {  
  //          document.location.href = newURL;
  //        }
  //    }
 // }

// resets the menu selection upon entry to this page:
//function resetMenu() {
//   document.gomenu.selector.selectedIndex = 2;
//}

<?php
/*
//用于搜索功能的php代码...以工程的名字进行搜索...有点麻烦...
暂不实现...
  $con = mysqli_connect("localhost","root","");
  if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }
  mysqli_select_db($con,"BugFade");
  $id=$_SESSION["ID"];
  $s="select projectID from "."$id"."project where projectName= and ID='$id'";
  $result = mysqli_query($con,$s);
  $row=mysqli_fetch_array($result,MYSQLI_NUM);
  if(count($row)){
    $s1="select position from "."$row[1]"."membermanage where memberID='$id'";
    $result1 = mysqli_query($con,$s1);
    $row1=mysqli_fetch_array($result1,MYSQLI_NUM);
    echo $row1[1]
  }
  */
   ?>
function showAllProject(){
  console.log("~~~~~~~");
  window.location.href = 'http://127.0.0.1/allProject.php';
}
function search(){
  console.log("-------");
  var name=$("#searchProject").attr("value");
  var ID=$("#searchProject").attr("value","<?php
   ?>");
 //   window.location.href = 'http://127.0.0.1/project.php?type=0&name='+name;
}
//////////////////////chart

    var sin = [],
      cos = [];
    var userID=$("#zz").attr("userID");
      $.ajax({
    url: 'getRecentBug.php',
    method:'post',
    data: {
    userID: userID
    },
    success: function(data){
//        console.log(data);
        sin=data;
    }
})
      $.ajax({
    url: 'getRecentSolution.php',
    method:'post',
    data: {
    userID: userID
    },
    success: function(data){
        console.log(data);
        cos=data;
    }
})

setTimeout("loadChart()","500"); //等待ajax加载
function loadChart() {


      /*
    for (var i = 0; i < 10; i += 1) {
      sin.push([i, i]);
      cos.push([i, i+1]);
    }
*/
    var plot = $.plot("#placeholder", [
      { data: sin, label: "提出bug"},
      { data: cos, label: "提出solution"}
    ], {
      series: {
        lines: {
          show: true
        },
        points: {
          show: true
        }
      },
      grid: {
        hoverable: true,
        clickable: true
      },
      yaxis: {
        min: 0,
        max: 16
      }
    });

    $("<div id='tooltip'></div>").css({
      position: "absolute",
      display: "",
      border: "1px solid #fdd",
      padding: "2px",
      "background-color": "#fee",
      opacity: 0.80
    }).appendTo("body");

    $("#placeholder").bind("plothover", function (event, pos, item) {

      if ($("#enablePosition:checked").length > 0) {
        var str = "(" + pos.x.toFixed(2) + ", " + pos.y.toFixed(2) + ")";
        $("#hoverdata").text(str);
      }

      if ($("#enableTooltip:checked").length > 0) {
        if (item) {
          var x = item.datapoint[0].toFixed(2),
            y = item.datapoint[1].toFixed(2);

          $("#tooltip").html(item.series.label + " of " + x + " = " + y)
            .css({top: item.pageY+5, left: item.pageX+5})
            .fadeIn(200);
        } else {
          $("#tooltip").hide();
        }
      }
    });

    $("#placeholder").bind("plotclick", function (event, pos, item) {
      if (item) {
        $("#clickdata").text(" - click point " + item.dataIndex + " in " + item.series.label);
        plot.highlight(item.series, item.datapoint);
      }
    });

    // Add the Flot version string to the footer

    $("#footer").prepend("Flot " + $.plot.version + " &ndash; ");
  };

  </script>

</script>
</body>
</html>
