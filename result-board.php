<!DOCTYPE html>
<html>
<head>
<style type="text/css">

	*{
	margin:0;
 font-size: 100%;
 font-family: Arial;
}
p{
	font-size: 18px;
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

button ,select{
   width:80px;
   height:30px;
   color: white;
   font-weight: bold;
   -moz-border-radius: 4px;
   -webkit-border-radius: 4px;
    border-radius: 4px;
	background:#3399FF;
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
.show-result{
	min-height:40%;
	width:50%;
	float:center;
    background: white;
	margin-right:auto;
	margin-top:10%;
	margin-left:auto;
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
.submit_link{
	position:absolute;
	left:30%;
	right:30%;
}
.box-model{

	display: block;
    position:absolute;
    height:auto;
    bottom:50%;
    top:25%;
    left:30%;
    right:30%;
    background-color: #F2F2FC;
    border:2px solid  #A1A1AF;
}
img {
    display: block;
    margin-left: auto;
    margin-right: auto;
}
</style>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	
		var problem_code = $("#problem_code").val();
		var code = $("#code").val();
		var lang = $("#lang").val();
		$.ajax({
			type: "POST",
			url: "ajax.php",
			cache:false,
			data : {problem_code:problem_code,code:code,lang:lang},
			success: function(html)
			{
				//alert("ajax response returned.. ");
				//console.log(html);
				$(".result-board").empty();
				$(".result-board").append('<br>' + html);
			}
		})

});
</script>
<title>Result-board</title>
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
	//echo $_POST['id'];
	if(isset($_GET['id'])){
	$problem_code=$_GET['id'];
	$result=mysqli_query($con,"SELECT * FROM judge_problem WHERE problem_code='$problem_code'") or die('mysql_error($con)');
	$count=$result->num_rows;
	if($count!=1)
	{
		header("Location: /codejudge/error.php");
		exit();	
	}
	echo'<div class="submission">';
	echo '<a href="/codejudge/submission-board.php?pid='.$problem_code.'&uid='.$user_name.'">My Submission</a>';		
	//echo '<a href="/codejudge/submission-board.php?cid-'.$contest_code.'" class="submission">My Submissions</a>';
	echo "</div>";
	}
	else
	{
			header("Location: /codejudge/error.php");
			exit();
		//echo "error in result-board.php file ,problem id not configure ";
	}
	$problem_code=$_GET['id'];
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
	

	//testing same as submit.php , future ,present of past events
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
	?>
	</div>
</div>
<div class="header-border">
</div>
<?php
//$code="may be code is empty";
//$lang=11;
//rest code of submission and get result
//if(isset($_POST['code']))
$code=stripcslashes($_POST['code']);
//echo "<br>";
//if(isset($_POST['lang']))
$lang=stripcslashes($_POST['lang']);

//$codecopy=str_replace('<',"&gt;",$codecopy);
//$codecopy=str_replace('>',"&lt;",$codecopy);

//echo "<br><br><br><br><br><br>";
$pattern = array('/</','/>/','/\n/');
$replace = array('&lt;','&gt;','<br>');
$code = preg_replace($pattern,$replace,$code);
/*$len= strlen($codecopy);
$code="";
for($i=0;$i<$len;$i++)
{
	if($codecopy[$i]=='<')
		$code.="&gt;";
	else if($codecopy[$i]=='>')
		$code.="&lt;";
	else
		$code.=$codecopy[$i];
}*/
//echo $len;
//$result=mysqli_query($con,"INSERT INTO judge_users (user_name, password,email_id) VALUES ('$code', '$codecopy','abc@gmai.com')") or die('mysql_error($con)');
//$row=mysqli_fetch_array($result);		
?>
<div class="content">
<?php
	$problem_code=$_GET['id'];
	$result=mysqli_query($con,"SELECT * FROM judge_problem WHERE problem_code='$problem_code'") or die('mysql_error($con)');
	$row=mysqli_fetch_array($result);
	$contest_code=$row['contest_code'];
	$problem_name=$row['problem_name'];
	$result=mysqli_query($con,"SELECT * FROM judge_contest WHERE contest_code='$contest_code'") or die('mysql_error($con)');
	$row=mysqli_fetch_array($result);
	$contest_name=$row['contest_name'];
	echo '<div class="submit_link">';
	echo '<b><a href="/codejudge/contest-board.php?id='.$contest_code.'">'.$contest_name.'</a></b>';
	echo " : ";	
	echo '<b><a href="/codejudge/problem-board.php?id='.$problem_code.'">'.$problem_name.'</a></b>';
	echo " : ";
	echo " <b>Solution Submitted</b>";
	echo "</div>";
?>
<div class="result-board">
<div class="box-model">
<br><b><p align="center">Submission Running</p></b><br>
<img src="/codejudge/gif-load.gif">
</div>
</div>
</div>
<textarea id="problem_code" style="display:none;"> <?php echo $problem_code;?> </textarea>
<textarea id="code" style="display:none;"> <?php echo $code;?> </textarea>
<textarea id="lang" style="display:none;"><?php echo $lang;?></textarea>

<div class="footer">
<div class="footer-data">
		Developed by <span style="color:white;">Chandan Singh </span> 
	</div>
</div>

</body>
</html>
