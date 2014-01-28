<!DOCTYPE html>
<html>

<head>
<style type="text/css">
*{
	margin:0;
 font-size: 100%;
 font-family: Arial;
}
table{
	font-size:15px;
	table-layout: fixed;
}
a{
	text-decoration: none;
}
html, body {
	height: 100%;
}

.header-cont {
    width:100%;
    position:absolute;
    top:0px;
}
.header-border{
position:absolute;
width:100%;
border:2px solid #6666FF;
top:50px;
}
.header {
    height:50px;
    background:#3399FF;
    border:1px solid #CCC;
	width:100%;
    margin:0px auto;
	text-align:center;
}
.content a:link{
  color:#3399FF;
}
.content a:visited{
  color:#3399FF;
}
.content a:hover{
  color:#3399FF;
}
.content a:focus{
  color:#3399FF;
}
.content a:active{
  color:#3399FF;
}

.content{
	min-height: 100%;
	height: auto !important;
	height: 100%;
	width:1130px;
    background: white;
    border: 1px solid white;
	top:80px;
	margin-right:155px;
	margin-top:100px;
	margin-left:125px;
}
.footer, .push {
height: 37px;
}
.footer, .push {
clear: both;
}
.footer{
	position:relative;
	text-align:center;
	margin-bottom:-20px;
	
	margin-right:0px;
	margin-left:0px;
	width:100%;
	background-color: #3399FF;
}
.footer-data
{	
	padding:7px;
	text-align:center;
	font-size:18px;
}

.code{
	overflow:scroll;
	border-style:solid;
	border-width: 5px;
	background-color:#F4F4F4;
	border-color:#A9A9A9;
	font-size:15px;
	font-family: "HelveticaNeue-Light", "Helvetica Neue Light", "Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif; 
}
.code-content{
	margin-left:2%;
	font-family: "HelveticaNeue-Light", "Helvetica Neue Light", "Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif; 
}
.code-header{
	font-size:20px;
	color:white;
	text-align:center;
	vertical-align: middle;
	line-height: 40px;     
	top-margin:20%;
	height:40px;
	width:100%;
	-webkit-border-radius: 25px;
	-moz-border-radius: 25px;
	border-radius: 25px 25px 0 0;
	background:#3399FF;
}
.code-footer
{
	height:30px;
	width:100%;
	background:#3399FF;	
}
#submission-board
{
font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
width:100%;
border-collapse:collapse;
}
#submission-board td, #submission-board th 
{
font-size:15px;
border:2px solid white;
padding:3px 7px 2px 7px;
}
#submission-board td
{
	height:25px;
}
#submission-board th
{
font-size:15px;
height :40px;
text-align:left;
padding-top:5px;
padding-bottom:4px;
background-color:#E6E6E6;
color:black;
}

.home{
	float:left;
	margin-left:125px;
	font-size: 25px;
	padding-top: 12px;
	color:white;
	padding-bottom: 12px;
}
.account{
	float:right;
	margin-right:20px;
	font-size:18px;
	padding-top:20px;
	padding-bottom: 20px;
	color:white;
}
.logout{
	float:right;
	margin-right:155px;
	font-size:18px;
	padding-top:20px;
	padding-bottom: 20px;
	color:white;
}
h4{
	color:red;
}
</style>

</head>
<body>
	<?php
include "conn_db.php";
ob_start();
session_start();
//$name= $_SESSION['sess_username'];
//echo "yes".$name;
if((!isset($_SESSION['sess_user_id'])) || (trim($_SESSION['sess_user_id']) == '')) //sess_username or sess_userid not set then redirect to login page.
{
	//writing in session for redirecting to the same page after login process.
	session_regenerate_id();
	$redirect_url=$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];
	echo $redirect_url;
	$_SESSION['redirect_url'] = $redirect_url;
	session_write_close();
	header("Location: /codejudge/");
	exit();
}
if(isset($_GET['id']))
{
	//check given username is present in DB or not
	$sub_id=$_GET['id'];
	$result=mysqli_query($con,"SELECT * FROM judge_submission WHERE submission_id='$sub_id'") or die('mysql_error($con)');
    $count=$result->num_rows;
    if($count!=1)
    {
  		session_regenerate_id();
  		$error_msg="You entered a wrong url";
		$_SESSION['wrong_url'] = $error_msg;
		session_write_close();
		header("Location: /codejudge/error.php");
		exit();	
    }
}
else
{
	session_regenerate_id();
  	$error_msg="You entered a wrong url";
	$_SESSION['wrong_url'] = $error_msg;
	session_write_close();
	header("Location: /codejudge/error.php");
	exit();	
}

?>
<div class="header-cont">
	<div class="header">
		<a href="/codejudge/contest.php" class="home">CODE JUDGE</a>
		<a href="/codejudge/logout.php" class="logout">Logout</a>
		<a href="/codejudge/account.php" class="account">Account</a>
	</div>
</div>
<div class="header-border">
</div>
<div class="content">
<?php
if(isset($_GET['id']))
{
	$sub_id=$_GET['id'];
	$result=mysqli_query($con,"SELECT * FROM judge_submission WHERE submission_id='$sub_id'") or die('mysql_error($con)');
	$row=mysqli_fetch_array($result);
	$contest_id=$row['contest_id'];
	$problem_id=$row['problem_id'];
	$user_id=$row['user_id'];
	$problem_id=$row['problem_id'];

	//problem name and code
	$getproblem=mysqli_query($con,"SELECT * FROM judge_problem WHERE problem_id='$problem_id'") or die('mysql_error($con)');
	$getproblemfetch=mysqli_fetch_array($getproblem);
	$problem_name=$getproblemfetch['problem_name'];
	$problem_code=$getproblemfetch['problem_code'];
			
	$getuser=mysqli_query($con,"SELECT * FROM judge_users WHERE user_id='$user_id'") or die('mysql_error($con)');
	$getuserfetch=mysqli_fetch_array($getuser);
	$user_name=$getuserfetch['user_name'];
			

	$result1=$row['result'];
	$AC="AC";
	$RTE="RTE";
	$WA="WA";
	$TLE="TLE";
	$CE="CE";
	$time=$row['time_taken'];
	$memory=$row['memory_taken'];
	$lang=$row['language'];
	$status=$row['status'];
	$date_time=$row['time_of_submission'];	
	$status=$row['status'];
	$code=$row['source_code'];
	//contest name
	$result=mysqli_query($con,"SELECT * FROM judge_contest WHERE contest_id='$contest_id'") or die('mysql_error($con)');
	$row=mysqli_fetch_array($result);
	$contest_name=$row['contest_name'];	
	$contest_code=$row['contest_code'];
	echo '<a href="/codejudge/contest-board.php?id='.$contest_code.'">'.'Contest:'.$contest_name.'</a>';
	//echo " / ";
	//problem name
	/*$result=mysqli_query($con,"SELECT * FROM judge_problem WHERE problem_id='$problem_id'") or die('mysql_error($con)');
	$row=mysqli_fetch_array($result);
	$problem_name=$row['problem_name'];	
	$problem_code=$row['problem_code'];
	echo '<a href="/codejudge/problem-board.php?id='.$problem_code.'">'.'Probelm:'.$problem_name.'</a>'; 
	echo " / ";
	
	echo '<a href="/codejudge/view-solution.php?id='.$sub_id.'">'.'Submission ID:'.$sub_id.'</a>';
	*/echo "<br><br>";

	echo '<table class="submission-board" id="submission-board">';
	/*echo '<col width="8%">';
  	echo '<col width="20%">';
	echo '<col width="20%">';
  	echo '<col width="8%">';
  	echo '<col width="8%">';
  	echo '<col width="8%">';
  	echo '<col width="8%">';
  	echo '<col width="10%">';
	*/
		echo '<col style ="width:8%;">';
  		echo '<col style ="width:28%;">';
		echo '<col style ="width:28%;">';
  		echo '<col style ="width:10%;">';
		echo '<col style ="width:8%;">';
  		echo '<col style ="width:8%;">';
		echo '<col style ="width:8%;">';
  		echo '<col style ="width:10%;">';
		
		
	echo "<tr>";

	echo "<th >Sub ID</th>";
	echo "<th >User</th>";
	echo "<th >Problem</th>";
	echo "<th >Result</th>";
	echo "<th >Time</th>";
	echo "<th >Lang</th>";
	echo "<th >Memory</th>";
	echo "<th >Date/Time</th>";
	echo "</tr>";
		echo "<td>".$sub_id."</td>";
			echo "<td>";
  			echo '<a href="/codejudge/account.php?id='.$user_name.'">'.$user_name.'</a>';
  			echo "</td>";
  			
  			echo "<td>";
  			echo '<a href="/codejudge/problem-board.php?id='.$problem_code.'">'.$problem_name.'</a>';
  			echo "</td>";
  			
  			echo "<td>";
			if($result1==$AC)
  					echo '<img src="/codejudge/ac-icon.gif">';
  			else if($result1==$WA)
  					echo '<img src="/codejudge/wa-icon.gif">';
  			else if($result1==$RTE)
  					echo '<img src="/codejudge/rte-icon.png">';
  			else if($result1==$TLE)
  					echo '<img src="/codejudge/tle-icon.png">';
  			else if($result1==$CE)
  					echo '<img src="/codejudge/ce-icon.gif">';
  			echo "</td>";
			echo "<td>".$time."</td>";
			
			echo "<td>".$lang."</td>";
			echo "<td>".$memory."</td>";
  			echo "<td>".$date_time."</td>";
			echo "</tr>";	
	echo "</table>";
	echo "<br><br>";
	echo '<div class="code-header">--Code Board--</div>';
	if($status==1)
	{
		echo '<div class="code">';
		echo '<div class="code-content">';
		echo "<pre>";
		echo htmlspecialchars($code);
		echo "</pre>";
		echo "</div>";
		echo "</div>";
		echo '<div class="code-footer"></div>';
	}

	else
	{
		header("Location: /codejudge/error.php");
		exit();
	}
			
}
else
{
	header("Location: /codejudge/error.php");
	exit();
}
?>
<br><br><br>
</div>
<div class="footer">
<div class="footer-data">
		Developed by <span style="color:white;">Chandan Singh </span> 
	</div>
</div>

</body>
</html>
