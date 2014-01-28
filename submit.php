<!DOCTYPE html>
<html>

<head>
<script type="text/javascript">
	function call_ajax()
	{
		
	}
</script>
<style type="text/css">

	*{
	margin:0;
 font-size: 100%;
 font-family: Arial;
}

.btn{
display:inline-block;
padding:6px 12px;
margin-bottom:0;
font-size:14px;
font-weight:normal;
line-height:1.42;
text-align:center;
white-space:nowrap;
vertical-align:middle;
cursor:pointer;
background-image:none;
border:1px solid transparent;
border-radius:4px;
user-select:none;
width:90px;
color:#fff;
background-color:#428bca;
border-color:#357ebd
}
.lang{
display:inline-block;
padding:6px 12px;
margin-bottom:0;
font-size:14px;
font-weight:normal;
line-height:1.42;
text-align:center;
white-space:nowrap;
vertical-align:middle;
cursor:pointer;
background-image:none;
border:1px solid transparent;
border-radius:4px;
user-select:none;
color:#fff;
background-color:#428bca;
border-color:#357ebd

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
.submission
{
	float:right;
	margin-right:20px;
	font-size:18px;
	padding-top:20px;
	padding-bottom:20px;
	color:white;
}
.submission a{
	color:white;
}
.rank
{
	float:right;
	margin-right:20px;
	font-size:18px;
	padding-top:20px;
	padding-bottom:20px;
	color:white;	
}
.rank a{
	color:white;
}
.account a{
	color:white;
}
.contest-name a{
	color:white;
}
.contest-name{
	float:right;
	margin-right:20px;
	font-size:18px;
	padding-top:20px;
	padding-bottom:20px;
	color:white;
}
.submit_link a:link{
  color:#191919;
}
.submit_link a:visited{
  color:#191919;
}
.submit_link a:hover{
  color:#191919;
  	text-decoration: underline;;
}
.submit_link a:focus{
  color:#191919;
}
.submit_link a:active{
  color:#191919;
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
?>

<div class="header-cont">
	<div class="header">
	<a href="/codejudge/contest.php" class="home">CODE JUDGE</a>
	<a href="/codejudge/logout.php" class="logout">Logout</a>
	<?php
//	session_start();
	$user_name=$_SESSION['sess_username'];
	echo '<div class="account">';
	echo '<a href="/codejudge/account.php?id='.$user_name.'">Account</a>';		
	echo "</div>";
	if(isset($_GET['id'])){
	$problem_code=$_GET['id'];
	//check problem code is exist in database or not
	$result=mysqli_query($con,"SELECT * FROM judge_problem WHERE problem_code='$problem_code'") or die('mysql_error($con)');
	$count=$result->num_rows;
	if($count!=1)
	{
		header("Location: /codejudge/error.php");
		exit();	
	}	
	echo'<div class="submission">';
	//echo "<br><br><br><br><br><br><br><br><br><br>".$problem_code.$user_name;
	echo '<a href="/codejudge/submission-board.php?pid='.$problem_code.'&uid='.$user_name.'">My Submission</a>';		
	//echo '<a href="/codejudge/submission-board.php?cid-'.$contest_code.'" class="submission">My Submissions</a>';
	echo "</div>";
	}
	else
	{
		header("Location: /codejudge/error.php");
		exit();	
	}

	$result=mysqli_query($con,"SELECT * FROM judge_problem WHERE problem_code='$problem_code'") or die('mysql_error($con)');
	$row=mysqli_fetch_array($result);
	$contest_code=$row['contest_code'];
	$result=mysqli_query($con,"SELECT * FROM judge_contest WHERE contest_code='$contest_code'") or die('mysql_error($con)');
	$row=mysqli_fetch_array($result);
	$contest_name=$row['contest_name'];
	echo '<div class="rank">';
	echo '<a href="/codejudge/rank.php?id='.$contest_code.'">Ranking</a>';		
	echo "</div>";
	
	echo '<div class="contest-name">';
	echo '<a href="/codejudge/contest-board.php?id='.$contest_code.'">'.$contest_name.'</a>';	
	echo "</div>";

	?>
	</div>
</div>
<div class="header-border">
</div>
<div class="content">
<?php
if(isset($_GET['id']))
{
	$problem_code=$_GET['id'];
	// print problem name /contest name submit solution
	$result=mysqli_query($con,"SELECT * FROM judge_problem WHERE problem_code='$problem_code'") or die('mysql_error($con)');
	$row=mysqli_fetch_array($result);
	$problem_name=$row['problem_name'];
	$contest_code=$row['contest_code'];
	//get contest name
	$result=mysqli_query($con,"SELECT * FROM judge_contest WHERE contest_code='$contest_code'") or die('mysql_error($con)');
	$row=mysqli_fetch_array($result);
	$contest_name=$row['contest_name'];
	echo '<div class="submit_link">';
	echo '<b><a href="/codejudge/contest-board.php?id='.$contest_code.'">'.$contest_name.'</a></b>';
	echo " : ";
	echo '<b><a href="/codejudge/problem-board.php?id='.$problem_code.'">'.$problem_name.'</a></b>';
	echo " : ";
	echo "<b>Submit Solution</b>";
	echo "</div>";
	echo "<br>";
	echo '<form name="submit-button" action="/codejudge/result-board.php?id='.$problem_code.'" method="post">';
$testing=1;
$result=mysqli_query($con,"SELECT * FROM judge_problem WHERE problem_code='$problem_code'") or die('mysql_error($con)');

$row=mysqli_fetch_array($result);
$contest_code=$row['contest_code'];
			

//problem belongs to future contest
$curr_time=date("Y-m-d H:i:s");
$result=mysqli_query($con,"SELECT * FROM judge_contest WHERE contest_code='$contest_code'") or die('mysql_error($con)');
$row=mysqli_fetch_array($result);
$end_time=$row['end_time'];
$start_time=$row['start_time'];
$diff=strtotime($start_time)-strtotime($curr_time);

	if($diff<=0)
	{
		//present or past problem  but only present problem sub will be allowed
		$curr_time=date("Y-m-d H:i:s");
		$result=mysqli_query($con,"SELECT * FROM judge_contest WHERE contest_code='$contest_code'") or die('mysql_error($con)');
		$row=mysqli_fetch_array($result);
			//end-time of contest
		$end_time=$row['end_time'];
		$start_time=$row['start_time'];
		$diff=strtotime($end_time)-strtotime($curr_time);
		if($diff<0){
			//problem belongs to past contest show error page
			header("Location: /codejudge/error.php");
			exit();
		}
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
<textarea id="editor" class="editor" rows="20" cols="100" name="code">
</textarea>
<br>
<select id="lang" name="lang" class="lang">
	<option value="11" selected>C</option>
	<option value="41">C++</option>
	<option value="4">Python 2</option>
	<option value="116">Python 3</option>
	<option value="55">Java</option>
	<option value="17">Ruby</option>
</select>
<button type="submit" class="btn" onclick="call_ajax">Submit</button>
</form>
<br><br><br>
</div>
<script src="/codejudge/edit_area/edit_area_full.js"></script>
<script language="Javascript" type="text/javascript">
editAreaLoader.init({
	id:"editor",
	start_highlight:true,
	allow_resize:"both",
	allow_toggle: true,
	language:"en",
	syntax:"cpp",
	font_size:"8"
});
$("#lang").bind('change', function(){
		var lang_id = $("#lang").val();
		if (typeof lang_map[lang_id] != "undefined") {
			window.frames['frame_file'].document.getElementById('syntax_selection').value = lang_map[lang_id];
			window.frames['frame_file'].editArea.execCommand('change_syntax', lang_map[lang_id]);
		} else {
			window.frames['frame_file'].document.getElementById('syntax_selection').value = "basic";
			window.frames['frame_file'].editArea.execCommand('change_syntax', lang_map[lang_id]);
		}
	});
</script>
<div class="footer">
<div class="footer-data">
		Developed by <span style="color:white;">Chandan Singh </span> 
	</div>
</div>
</body>
</html>
