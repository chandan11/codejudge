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
	font-size:12px;
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


.left-part{
	float:left;
	width:60%;
}
.right-part{
	float:right;
	width:40%;
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
.account a{
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
//wrong url check
$testing=1;
/* cid can be 0 or valid , pid will be valid uid will be valid
possible combination 
cid-> cid, cid+uid, cid[0]+uid
pid--> pid, pid+uid, pid+result="AC" 
*/
//for cid combinations
//echo "<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>ashhsh";
if(isset($_GET['cid']))
{
	$contest_code=$_GET['cid'];
	//echo $contest_code;
	if($contest_code!="0")
	{
		//echo "yes";
		if(isset($_GET['uid']))
		{
			$user_name=$_GET['uid'];
			$result=mysqli_query($con,"SELECT * FROM judge_users WHERE user_name='$user_name'") or die('mysql_error($con)');
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
    		$contest_code=$_GET['cid'];
			$result=mysqli_query($con,"SELECT * FROM judge_contest WHERE contest_code='$contest_code'") or die('mysql_error($con)');
    		$count=$result->num_rows;
    		echo $count;
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
			$contest_code=$_GET['cid'];
			$result=mysqli_query($con,"SELECT * FROM judge_contest WHERE contest_code='$contest_code'") or die('mysql_error($con)');
    		$count=$result->num_rows;
    		echo $count;
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
	}
	//if contest code=0 then only in case of user submission so uid should be set
	else
	{
		if(isset($_GET['uid']))
		{
			//find username in DB
			$user_name=$_GET['uid'];
			$result=mysqli_query($con,"SELECT * FROM judge_users WHERE user_name='$user_name'") or die('mysql_error($con)');
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
			//wrong URl
			session_regenerate_id();
  			$error_msg="You entered a wrong url";
			$_SESSION['wrong_url'] = $error_msg;
			session_write_close();
			header("Location: /codejudge/error.php");
			exit();
		}
	}
}
//when pid is presnet possible case pid,pid+uid,pid+result
else if(isset($_GET['pid']))
{
		$problem_code=$_GET['pid'];
	    $result=mysqli_query($con,"SELECT * FROM judge_problem WHERE problem_code='$problem_code'") or die('mysql_error($con)');
    	$count=$result->num_rows;
    	if($count!=1)
    	{
  			session_regenerate_id();
  			$error_msg="You entered a wrong url";
			$_SESSION['wrong_url'] = $error_msg;
			session_write_close();
			//testing....echo "<br><br><br><br><br><br><br><br>".$_GET['pid'].$_GET['uid'];
			header("Location: /codejudge/error.php");
			exit();	
    	}
	if(isset($_GET['uid']))
	{
			$user_name=$_GET['uid'];
			$result=mysqli_query($con,"SELECT * FROM judge_users WHERE user_name='$user_name'") or die('mysql_error($con)');
    		$count=$result->num_rows;
    		if($count!=1)
    		{
  				session_regenerate_id();
  				$error_msg="You entered a wrong url";
				$_SESSION['wrong_url'] = $error_msg;
				session_write_close();
				//testing ...echo "<br><br><br><br><br><br><br><br>".$_GET['pid'].$_GET['uid'];
		
				header("Location: /codejudge/error.php");
				exit();	
    		}
	}
	else if(isset($_GET['result']))
	{
		$AC="AC";
		if($AC!=$_GET['result'])
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
		$problem_code=$_GET['pid'];
		$result=mysqli_query($con,"SELECT * FROM judge_problem WHERE problem_code='$problem_code'") or die('mysql_error($con)');
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
	//account link
	$user_name=$_SESSION['sess_username'];
	echo '<div class="account">';
	echo '<a href="/codejudge/account.php?id='.$user_name.'">Account</a>';
	echo "</div>";
	?>
	<?php
	//echo $_GET['pid'].$_SESSION['sess_username'];
	$user_name=$_SESSION['sess_username'];
	if(isset($_GET['pid']))
	{
		$problem_code=$_GET['pid'];
		$result=mysqli_query($con,"SELECT * FROM judge_problem WHERE problem_code='$problem_code'") or die('mysql_error($con)');
		$row=mysqli_fetch_array($result);
		$problem_name=$row['problem_name'];	
		$contest_code=$row['contest_code'];
		
		echo '<div class="submission">';
		echo '<a href="/codejudge/rank.php?id='.$contest_code.'">Ranking</a>';
		echo "</div>";
		echo '<div class="submission">';
		echo '<a href="/codejudge/problem-board.php?id='.$problem_code.'">'.$problem_name.'</a>';	
		echo "</div>";
		
	}
	if(isset($_GET['cid']))
	{
		$contest_code=$_GET['cid'];
		if($contest_code!="0"){
		$result=mysqli_query($con,"SELECT * FROM judge_contest WHERE contest_code='$contest_code'") or die('mysql_error($con)');
		$row=mysqli_fetch_array($result);
		$contest_name=$row['contest_name'];	
		echo '<div class=submission>';
		echo '<a href="/codejudge/rank.php?id='.$contest_code.'">Ranking</a>';	
		echo "</div>";
		
		echo '<div class="submission">';
	
		echo '<a href="/codejudge/contest-board.php?id='.$contest_code.'">'.$contest_name.'</a>';
		echo "</div>";
		}
	}
	if((!isset($_GET['cid'])) and (!isset($_GET['pid'])))
	{
		header("Location: /codejudge/error.php");
		exit();
	}
	?>
	</div>
</div>
<div class="header-border"></div>
<div class="content">
	<div class="submission-details">
	<?php
	if(isset($_GET['pid']))
	{
		$problem_code=$_GET['pid'];
		$result=mysqli_query($con,"SELECT * FROM judge_problem WHERE problem_code='$problem_code'") or die('mysql_error($con)');
		$row=mysqli_fetch_array($result);
		$problem_name=$row['problem_name'];	
		echo '<a href="/codejudge/problem-board.php?id='.$problem_code.'">'.$problem_name.'</a>';	
		echo ' Submissions:<br><br>';
	}
	if(isset($_GET['cid']))
	{
		$contest_code=$_GET['cid'];
		if($contest_code!=0){
		$result=mysqli_query($con,"SELECT * FROM judge_contest WHERE contest_code='$contest_code'") or die('mysql_error($con)');
		$row=mysqli_fetch_array($result);
		$contest_name=$row['contest_name'];	
		echo '<a href="/codejudge/contest-board.php?id='.$contest_code.'">'.$contest_name.'</a>';
		echo ' Submissions:<br><br>';
		}		
	}	
	?>
	<p></p>
	<table class="submission-board" id="submission-board">
		<col style ="width:5%;">
  		<col style ="width:20%;">
		<col style ="width:20%;">
  		<col style ="width:5%;">
		<col style ="width:5%;">
  		<col style ="width:5%;">
		<col style ="width:5%;">
  		<col style ="width:10%;">
		<col style ="width:5%;">
		
		<tr>

		<th >Sub ID</th>
		<th >User</th>
		<th >Problem</th>
		<th >Result</th>
		<th >Time</th>
		<th >Lang</th>
		<th >Memory</th>
		<th >Date/Time</th>
		<th >View</th>
		</tr>
	<?php
	// first case when problem id is on
	if(isset($_GET['pid']))
	{
		$problem_code=$_GET['pid'];
		$result1=mysqli_query($con,"SELECT * FROM judge_problem WHERE problem_code='$problem_code'") or die('mysql_error($con)');
		$ro=mysqli_fetch_array($result1);
		$problem_id=$ro['problem_id'];
		$problem_name=$ro['problem_name'];
		if(isset($_GET['uid']))
		{
				$user_name=$_GET['uid'];
				$result2=mysqli_query($con,"SELECT * FROM judge_users WHERE user_name='$user_name'") or die('mysql_error($con)');
				$ro1=mysqli_fetch_array($result2);
				$user_id=$ro1['user_id'];
				$result=mysqli_query($con,"SELECT * FROM judge_submission WHERE problem_id='$problem_id' AND user_id='$user_id' ORDER BY time_of_submission DESC") or die('mysql_error($con)');
		}
		else if(isset($_GET['result']))
		{
				$AC="AC";
				$result=mysqli_query($con,"SELECT * FROM judge_submission WHERE problem_id='$problem_id' AND result='$AC' ORDER BY time_of_submission DESC") or die('mysql_error($con)');	
		}
		else
		{
				$result=mysqli_query($con,"SELECT * FROM judge_submission WHERE problem_id='$problem_id' ORDER BY time_of_submission DESC ") or die('mysql_error($con)');	
		}
		while($row=mysqli_fetch_array($result))
		{
			echo '<tr>';
			$sub_id=$row['submission_id'];
			$user_id=$row['user_id'];
			//problem name already known
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
			
			echo "<td>$sub_id</td>";

			//user name 
			$getuser=mysqli_query($con,"SELECT * FROM judge_users WHERE user_id='$user_id'") or die('mysql_error($con)');
			$getuserfetch=mysqli_fetch_array($getuser);
			$user_name=$getuserfetch['user_name'];
			//
			echo '<td>';
  			echo '<a href="/codejudge/account.php?id='.$user_name.'">'.$user_name.'</a>';
  			echo "</td>";
  			
  			echo '<td>';
  			echo '<a href="/codejudge/problem-board.php?id='.$problem_code.'">'.$problem_name.'</a>';
  			echo '</td>';
  			
  			echo '<td>';
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
  			echo '</td>';
			echo "<td>$time</td>";
			
			echo "<td>$lang</td>";
			echo "<td>$memory</td>";
  			echo "<td>$date_time</td>";
  			echo "<td>";
  			if($status==1)
  			{
  				echo '<a href="/codejudge/view-solution.php?id='.$sub_id.'">View</a>';
  			}
  			else
  			{
  				echo "View";
  			}
  			echo "</td>";
  			//echo "<td>$status</td>";
			echo '</tr>';
		}
	}
	else if(isset($_GET['cid']))
	{
		$contest_code=$_GET['cid'];
		if($contest_code!="0"){
		$result1=mysqli_query($con,"SELECT * FROM judge_contest WHERE contest_code='$contest_code'") or die('mysql_error($con)');
		$ro=mysqli_fetch_array($result1);
		$contest_id=$ro['contest_id'];
		$contest_name=$ro['contest_name'];
		if(isset($_GET['uid']))
		{
				$user_name=$_GET['uid'];
				$result2=mysqli_query($con,"SELECT * FROM judge_users WHERE user_name='$user_name'") or die('mysql_error($con)');
				$ro1=mysqli_fetch_array($result2);
				$user_id=$ro1['user_id'];
				$result=mysqli_query($con,"SELECT * FROM judge_submission WHERE contest_id='$contest_id' AND user_id='$user_id' ORDER BY time_of_submission DESC") or die('mysql_error($con)');
		}
		else
		{
				$result=mysqli_query($con,"SELECT * FROM judge_submission WHERE contest_id='$contest_id' ORDER BY time_of_submission DESC") or die('mysql_error($con)');		
		}
		}
		else if($contest_code==0)
		{
			if(isset($_GET['uid']))
			{
				$user_name=$_GET['uid'];
				$result2=mysqli_query($con,"SELECT * FROM judge_users WHERE user_name='$user_name'") or die('mysql_error($con)');
				$ro1=mysqli_fetch_array($result2);
				$user_id=$ro1['user_id'];
				$result=mysqli_query($con,"SELECT * FROM judge_submission WHERE user_id='$user_id' ORDER BY time_of_submission DESC") or die('mysql_error($con)');
			}
		}
		while($row=mysqli_fetch_array($result))
		{
			echo '<tr>';
			$sub_id=$row['submission_id'];
			$user_id=$row['user_id'];
			$problem_id=$row['problem_id'];

			//problem name and code
			$getproblem=mysqli_query($con,"SELECT * FROM judge_problem WHERE problem_id='$problem_id'") or die('mysql_error($con)');
			$getproblemfetch=mysqli_fetch_array($getproblem);
			$problem_name=$getproblemfetch['problem_name'];
			$problem_code=$getproblemfetch['problem_code'];
			
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
			
			echo "<td>$sub_id</td>";

			//user name 
			$getuser=mysqli_query($con,"SELECT * FROM judge_users WHERE user_id='$user_id'") or die('mysql_error($con)');
			$getuserfetch=mysqli_fetch_array($getuser);
			$user_name=$getuserfetch['user_name'];
			//
			echo '<td>';
  			echo '<a href="/codejudge/account.php?id='.$user_name.'">'.$user_name.'</a>';
  			echo "</td>";
  			
  			echo '<td>';
  			echo '<a href="/codejudge/problem-board.php?id='.$problem_code.'">'.$problem_name.'</a>';
  			echo '</td>';
  			
  			echo '<td>';
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
  			echo '</td>';
			echo "<td>$time</td>";
			
			echo "<td>$lang</td>";
			echo "<td>$memory</td>";
  			echo "<td>$date_time</td>";
  			echo "<td>";
  			if($status==1)
  			{
  				echo '<a href="/codejudge/view-solution.php?id='.$sub_id.'">View</a>';
  			}
  			else
  			{
  				echo "View";
  			}
  			echo "</td>";
  			//echo "<td>$status</td>";
			echo '</tr>';
		}	
	}	
	?>
	</table>
	</div>
</div>
<div class="footer">
<div class="footer-data">
		Developed by <span style="color:white;">Chandan Singh </span> 
	</div>
</div>

</body>

</html>
