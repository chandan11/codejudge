<!DOCTYPE html>
<html>
<head>
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
width:90px;
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
table {
	font-size:15px;
	table-layout: fixed;
}
td {
  overflow: hidden;
  text-overflow: ellipsis;  
}
th {
  overflow: hidden;
  text-overflow: ellipsis;  
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

.problem-details{
	float:left;
	width:60%;
	font-size:15px;
}
.submission-details{
	float:right;
	margin-right:40px;
	width:30%;
}
.sub-prob{
	width:100%;
}

#problem-submission
{
font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
width:100%;
border-collapse:collapse;
}
#problem-submission td, #problem-submission th 
{
font-size:1em;
padding:3px 7px 2px 7px;
}
#problem-submission td
{
	height:25px;
}
#problem-submission th
{
font-size:15px;
font-family:helvetica;
height :30px;
text-align:left;
padding-top:5px;
padding-bottom:4px;
background-color:#E6E6E6;
color:black;
}
p{
	color:red;
}
.prob-code{
	font-size: 12px;
}
.view-all-submission
{
	float:right;
	margin-right:185px;
}
</style>
<title>Problem-board</title>
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
	//echo $redirect_url;
	$_SESSION['redirect_url'] = $redirect_url;
	session_write_close();
	header("Location: /codejudge/");
	exit();
}
if(isset($_GET['id']))
{
	$problem_code=$_GET['id'];
	$result=mysqli_query($con,"SELECT * FROM judge_problem WHERE problem_code='$problem_code'") or die('mysql_error($con)');
	$count=$result->num_rows;
	//echo $count;
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
	<?php
//	session_start();
	$user_name=$_SESSION['sess_username'];
	echo '<div class="account">';
	echo '<a href="/codejudge/account.php?id='.$user_name.'">Account</a>';		
	echo "</div>";
	if(isset($_GET['id'])){
	$problem_code=$_GET['id'];
	echo'<div class="submission">';
	echo '<a href="/codejudge/submission-board.php?pid='.$problem_code.'&uid='.$user_name.'">My Submission</a>';		
	//echo '<a href="/codejudge/submission-board.php?cid-'.$contest_code.'" class="submission">My Submissions</a>';
	echo "</div>";
	}
	else
	{
		header("Location: /codejudge/error.php");
			exit();
	
		//echo "error in problem-board.php file ,problem id not configure ";
	}
	$result=mysqli_query($con,"SELECT * FROM judge_problem WHERE problem_code='$problem_code'") or die('mysql_error($con)');
	$row=mysqli_fetch_array($result);
	$contest_code=$row['contest_code'];
	echo '<div class="rank">';
	echo '<a href="/codejudge/rank.php?id='.$contest_code.'">Ranking</a>';		
	echo "</div>";
	$result=mysqli_query($con,"SELECT * FROM judge_contest WHERE contest_code='$contest_code'") or die('mysql_error($con)');
	$row=mysqli_fetch_array($result);
	$contest_name=$row['contest_name'];
	echo '<div class="contest-name">';
	echo '<a href="/codejudge/contest-board.php?id='.$contest_code.'">'.$contest_name.'</a>';		
	echo "</div>";
	?>
	</div>
</div>
<div class="header-border"></div>
<div class="content">
	<div class="problem-name">
		<?php
		if(isset($_GET['id']))
		{
		$problem_code=$_GET['id'];
		$result=mysqli_query($con,"SELECT * FROM judge_problem WHERE problem_code='$problem_code'") or die('mysql_error($con)');
		$row=mysqli_fetch_array($result);
		$problem_name=$row['problem_name']; //getting contest name
		echo '<div class="problem-name">';
		echo '<h3><a href="/codejudge/problem-board.php?id='.$problem_code.'">'.$problem_name.'</a></h3>';
		echo "</div>";
		}
		else{
			header("Location: /codejudge/error.php");	
				exit();
		}
		echo '<p><b class="prob-code">Problem Code:'.$problem_code.'</b></p><br>';
		?>
		</div>
	<div class="problem-details">
	<!-- problem details-->
	<?php
		include "conn_db.php";
		//showing problem details
		if(isset($_GET['id'])){
			
			$problem_code=$_GET['id'];
			$result=mysqli_query($con,"SELECT * FROM judge_problem WHERE problem_code='$problem_code'") or die('mysql_error($con)');

			$row=mysqli_fetch_array($result);
			$statement=$row['statement'];
			$sample_input=$row['sample_input'];
			$sample_output=$row['sample_output'];
			$time_limit=$row['time_limit'];
			$memory_limit=$row['memory_limit'];
			$contest_code=$row['contest_code'];
			$explaination=$row['explaination'];

			//problem belongs to future contest
			$curr_time=date("Y-m-d H:i:s");
			$result=mysqli_query($con,"SELECT * FROM judge_contest WHERE contest_code='$contest_code'") or die('mysql_error($con)');
			$row=mysqli_fetch_array($result);
			$end_time=$row['end_time'];
			$start_time=$row['start_time'];
			$diff=strtotime($start_time)-strtotime($curr_time);
			if($diff<=0)
			{

			//check before printing the data
			echo nl2br($statement);
			echo "<br><br><b>Sample Input:</b><br>";
			echo nl2br($sample_input);
			echo "<br><br><b>Sample Output:</b><br>";
			echo nl2br($sample_output);
			echo "<br><br><b>Time Limit:</b>";
			
			echo ($time_limit);
			echo "<br><br><b>Memory Limit:</b>";
			echo ($memory_limit);		
			
			if($explaination!="")
				echo "<br><br><b>Memory Limit:</b><br>".$explaination;
		    /////////////////////////////////////
			//passing problem id to submit.php
			//$url="/codejudge/submit.php?id=".$problem_code;

			//after testing
			$curr_time=date("Y-m-d H:i:s");
			$result=mysqli_query($con,"SELECT * FROM judge_contest WHERE contest_code='$contest_code'") or die('mysql_error($con)');
			$row=mysqli_fetch_array($result);
			//end-time of contest
			$end_time=$row['end_time'];
			$start_time=$row['start_time'];
			$diff=strtotime($end_time)-strtotime($curr_time);
			if($diff>0){
			echo "<br><br>";
			echo '<form name="submit-button" action="/codejudge/submit.php?id='.$problem_code.'" method="post">';
			echo '<button type="submit" class="btn">Submit</button>';
			echo "</form>";
			echo "<br><br>";
			}
			else
			{
				echo "<br><br>";
				echo "<p>Contest ended ,now you can't submit solution<br><br><br></p>";
				// make all solution public and change contest status to past
				mysqli_query($con,"UPDATE judge_contest SET status=0 WHERE contest_code='$contest_code'") or die('mysql_error($con)');
				//making all solution public
				$result=mysqli_query($con,"SELECT * FROM judge_contest WHERE contest_code='$contest_code'") or die('mysql_error($con)');
				$row=mysqli_fetch_array($result);
				$contest_id=$row['contest_id'];
				mysqli_query($con,"UPDATE judge_submission SET status=1 WHERE contest_id='$contest_id'") or die('mysql_error($con)');
			}
			/////////////////////////////////////////////////////////////
			}
			else
			{
				//trying to access future contest problem.
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
	</div>
	<div class="submission-details">
		<h6>Recent Submisions</h6>
	<p></p>
	<table class="problem-submission" id="problem-submission" border=1 frame=hsides rules=rows style="border-color:#F4F4F4;">
		<col style ="width:40%;">
  		<col style ="width:20%;">
		<col style ="width:20%;">
  		<col style ="width:20%;">
		
		<tr>

		<th >User</th>
		<th >Result</th>
		<th >Time</th>
		<th >Lang</th>
		</tr>
		<?php
		$status=1;
		if(isset($_GET['id']))
		{
			$problem_code=$_GET['id'];
			$result=mysqli_query($con,"SELECT * FROM judge_problem WHERE problem_code='$problem_code'") or die('mysql_error($con)');
			$ro=mysqli_fetch_array($result);
			$problem_id=$ro['problem_id'];
			$result=mysqli_query($con,"SELECT * FROM judge_submission WHERE problem_id='$problem_id' ORDER BY time_of_submission DESC ") or die('mysql_error($con)');
				//echo $result->num_rows;
				$count=0;
				while($row = mysqli_fetch_array($result) and $count<15)
				{
						echo "<tr>";
						// name , problem name,result, lang
						// table contain user_id,problem_id,result,lang
						$user_id=$row['user_id'];
						$result1=$row['result'];
						$lang=$row['language'];
						$getuser=mysqli_query($con,"SELECT * FROM judge_users WHERE user_id='$user_id'") or die('mysql_error($con)');
						$getuserfetch=mysqli_fetch_array($getuser);
						$user_name=$getuserfetch['user_name'];		
						$time=$row['time_taken'];
						$AC="AC";
						$CE="CE";
						$RTE="RTE";
						$WA="WA";
						$TLE="TLE";
						echo "<td >";
  						echo '<a href="/codejudge/account.php?id='.$user_name.'">'.$user_name.'</a>';
  						echo "</td>";
  						echo "<td  >";
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
  						echo "</td >";
  						
  						echo "<td>";
  						echo $time;
  						echo "</td>";
  						echo "<td  >";
  						echo $lang;
  						echo "</td>";
  						echo "</tr>";
  						$count+=1;
				}
			echo "</table>";
		}
		else{
				header("Location: /codejudge/error.php");	
					exit();
	
		}
		?>
	
	<?php
		echo "<br>";
		echo "<hr>";
		echo "<br>";
		echo '<div class="view-all-submission">';
		//view all submissions
		if(isset($_GET['id']))
		{
			$problem_code=$_GET['id'];
			echo '<a href="/codejudge/submission-board.php?pid='.$problem_code.'">view-all-submissions</a>';			
		}
		else
		{
				header("Location: /codejudge/error.php");
					exit();
	
		}
		echo "</div>";
	?>
		
	</div>

</div>
<div class="footer">
<div class="footer-data">
		Developed by <span style="color:white;">Chandan Singh </span> 
	</div>
</div>
</body>
</html>
