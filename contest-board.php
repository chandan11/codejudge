<?php
ob_start();
session_start();
include "conn_db.php";
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
	header("Location:/codejudge/");
	exit();
}
//checking for wrong url id--> contest code
if(isset($_GET['id']))
{
	$contest_code=$_GET['id'];
	$result=mysqli_query($con,"SELECT * FROM judge_contest WHERE contest_code='$contest_code'") or die('mysql_error($con)');
	$count=$result->num_rows;
	if($count!=1)
	{
		header("Location:/codejudge/error.php");
		exit();	
	}
}
else
{
	session_regenerate_id();
  	$error_msg="You entered a wrong url";
	$_SESSION['wrong_url'] = $error_msg;
	session_write_close();
	flush();
	header("Location:/codejudge/error.php");
	exit();	
}
?>

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
.header {
    height:50px;
    background:#3399FF;
    border:1px solid #CCC;
	width:100%;
    margin:0px auto;
	text-align:center;
}
.left-part{
	float:left;
	width:60%;
}
.right-part{
	float:right;
	width:40%;
}
#contest-board
{
font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
width:100%;
border-collapse:collapse;
}
#contest-board td, #contest-board th 
{
font-size:1em;
padding:3px 7px 2px 7px;
}
#contest-board td
{
	height:25px;
}

#contest-board th
{
font-size:1.1em;
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
.account a{
	color:white;
}
.left-part{
	float:left;
	width:60%;
}
.right-part{
	float:right;
	margin-right:40px;
	width:30%;
}
#contest-submission
{
font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
width:100%;
border-collapse:collapse;
}
#contest-submission td, #contest-submission th 
{
font-size:1em;
padding:3px 7px 2px 7px;
}
#contest-submission td
{
	height:25px;
}
#contest-submission th
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

.view-all-submission
{
	float:right;
	margin-right:185px;
}
</style>
<title>Conetest-board</title>
</head>

<body>

<!-- begin olark code -->
<script data-cfasync="false" type='text/javascript'>/*<![CDATA[*/window.olark||(function(c){var f=window,d=document,l=f.location.protocol=="https:"?"https:":"http:",z=c.name,r="load";var nt=function(){
f[z]=function(){
(a.s=a.s||[]).push(arguments)};var a=f[z]._={
},q=c.methods.length;while(q--){(function(n){f[z][n]=function(){
f[z]("call",n,arguments)}})(c.methods[q])}a.l=c.loader;a.i=nt;a.p={
0:+new Date};a.P=function(u){
a.p[u]=new Date-a.p[0]};function s(){
a.P(r);f[z](r)}f.addEventListener?f.addEventListener(r,s,false):f.attachEvent("on"+r,s);var ld=function(){function p(hd){
hd="head";return["<",hd,"></",hd,"><",i,' onl' + 'oad="var d=',g,";d.getElementsByTagName('head')[0].",j,"(d.",h,"('script')).",k,"='",l,"//",a.l,"'",'"',"></",i,">"].join("")}var i="body",m=d[i];if(!m){
return setTimeout(ld,100)}a.P(1);var j="appendChild",h="createElement",k="src",n=d[h]("div"),v=n[j](d[h](z)),b=d[h]("iframe"),g="document",e="domain",o;n.style.display="none";m.insertBefore(n,m.firstChild).id=z;b.frameBorder="0";b.id=z+"-loader";if(/MSIE[ ]+6/.test(navigator.userAgent)){
b.src="javascript:false"}b.allowTransparency="true";v[j](b);try{
b.contentWindow[g].open()}catch(w){
c[e]=d[e];o="javascript:var d="+g+".open();d.domain='"+d.domain+"';";b[k]=o+"void(0);"}try{
var t=b.contentWindow[g];t.write(p());t.close()}catch(x){
b[k]=o+'d.write("'+p().replace(/"/g,String.fromCharCode(92)+'"')+'");d.close();'}a.P(2)};ld()};nt()})({
loader: "static.olark.com/jsclient/loader0.js",name:"olark",methods:["configure","extend","declare","identify"]});
/* custom configuration goes here (www.olark.com/documentation) */
olark.identify('9700-375-10-2541');/*]]>*/</script><noscript><a href="https://www.olark.com/site/9700-375-10-2541/contact" title="Contact us" target="_blank">Questions? Feedback?</a> powered by <a href="http://www.olark.com?welcome" title="Olark live chat software">Olark live chat software</a></noscript>
<!-- end olark code -->

<div class="header-cont">
	<div class="header">
	<a href="/codejudge/contest.php" class="home">CODE JUDGE</a>
	<a href="/codejudge/logout.php" class="logout">Logout</a>
	<?php

	$user_name=$_SESSION['sess_username'];
	echo '<div class="account">';
	echo '<a href="/codejudge/account.php?id='.$user_name.'">Account</a>';		
	echo "</div>";
	if(isset($_GET['id'])){
	$contest_code=$_GET['id'];
	echo'<div class="submission">';
	echo '<a href="/codejudge/submission-board.php?cid='.$contest_code.'&uid='.$user_name.'">My Submission</a>';		
	//echo '<a href="/codejudge/submission-board.php?cid-'.$contest_code.'" class="submission">My Submissions</a>';
	echo "</div>";
	}
	else
	{
		header("Location: /codejudge/error.php");
		exit();
		//echo "error in contest-board.php file ,cid not configure ";
	}
	echo '<div class="rank">';
	echo '<a href="/codejudge/rank.php?id='.$contest_code.'">Ranking</a>';		
	echo "</div>";
	?>
	</div>
</div>
<div class="header-border"></div>
<div class="content">
		<div class="contest-name">
		<?php
		if(isset($_GET['id']))
		{
		$contest_code=$_GET['id'];
		$result=mysqli_query($con,"SELECT * FROM judge_contest WHERE contest_code='$contest_code'") or die('mysql_error($con)');
		$row=mysqli_fetch_array($result);
		$contest_name=$row['contest_name']; //getting contest name
		echo '<a href="/codejudge/contest-board.php?id='.$contest_code.'">'.$contest_name.'</a>'.'<br>';
		echo '<br>';
		}
		else
		{
			header("Location: /codejudge/error.php");
			exit();
		}
		?>
		</div>
		<div class="left-part">
		<table class="contest-board" id="contest-board" border=1 frame=hsides rules=rows style="border-color:#F4F4F4;">
		<col style ="width:20%;">
  		<col style ="width:50%;">
		<col style ="width:15%;">
  		<col style ="width:15%;">
		<tr>
		<th >CODE</th>
		<th >NAME</th>
		<th >Solved By</th>
		<th >Accuracy</th>
		</tr>
	<?php
		$status=1;
		if(isset($_GET['id'])){
		$contest_code=$_GET['id'];
		$result=mysqli_query($con,"SELECT * FROM judge_contest WHERE contest_code='$contest_code'") or die('mysql_error($con)');
		$row=mysqli_fetch_array($result);
		$status=$row['status']; //checking status of contest
		if($status!=2){
		$result=mysqli_query($con,"SELECT * FROM judge_problem WHERE contest_code='$contest_code'") or die('mysql_error($con)');

		while($row = mysqli_fetch_array($result))
		{
			echo "<tr>";
			$problem_code=$row['problem_code'];
			$problem_name=$row['problem_name'];
			$problem_id=$row['problem_id'];
			$solvedby=0;
			$users=array();
			$AC="AC";
			$totaluserresult=mysqli_query($con,"SELECT * FROM judge_submission WHERE problem_id='$problem_id'") or die('mysql_error($con)');
			$totalusers=$totaluserresult->num_rows;
			$solvedByresult=mysqli_query($con,"SELECT * FROM judge_submission WHERE problem_id='$problem_id' AND result='$AC'") or die('mysql_error($con)');
			//for calculate the unique users who solved problem
			$totalAc=$solvedByresult->num_rows;
			while($r=mysqli_fetch_array($solvedByresult))
			{
				//echo $r['result'];
				$user_id=$r['user_id'];
				if(!array_search($user_id,$users))
				{
					$solvedby+=1;
					array_push($users,$user_id);
				}
			}
			if($totalusers!=0)
			$accuracy=($totalAc/$totalusers)*100;
			else
			$accuracy=0;
			$accuracy=round($accuracy,2);
  			//echo $totalusers." ".$totalAc." ".$accuracy." ";
  			echo "<td >";
  			echo '<a href="/codejudge/problem-board.php?id='.$problem_code.'">'.$problem_code.'</a>';
  			echo "</td>";
  			echo "<td >";
  			echo '<a href="/codejudge/problem-board.php?id='.$problem_code.'">'.$problem_name.'</a>';
  			echo "</td>";
  			$AC="AC";
  			echo '<td>';
  			echo '<a href="/codejudge/submission-board.php?pid='.$problem_code.'&result='.$AC.'">'.$solvedby.'</a>';		
  			echo "</td >";//$solvedby</td>";
  			//echo "<td >$accuracy%</td>";
  			echo '<td>';
  			echo '<a href="/codejudge/submission-board.php?pid='.$problem_code.'">'.$accuracy.'%</a>';	
  			echo "</td >";//$solvedby</td>";
  			echo "</tr>";
  		}
  		}
  	}
  	else
  	{
  			header("Location: /codejudge/error.php");
		exit();
  	}
	?>
	</table>
	</div>
	<div class="right-part">
	<h6>Recent Submissions</h6>
	<p></p>
	<table class="contest-submission" id="contest-submission" border=1 frame=hsides rules=rows style="border-color:#F4F4F4">
		<col style ="width:35%;">
  		<col style ="width:30%;">
		<col style ="width:18%;">
  		<col style ="width:18%;">
		<tr>
		<th >User</th>
		<th >Problem</th>
		<th >Result</th>
		<th >Lang</th>
		</tr>
		<?php
		$status=1;
		if(isset($_GET['id']))
		{
			$contest_code=$_GET['id'];
			$result=mysqli_query($con,"SELECT * FROM judge_contest WHERE contest_code='$contest_code'") or die('mysql_error($con)');
			$ro=mysqli_fetch_array($result);
			$status=$ro['status']; //checking status of contest
			$contest_id=$ro['contest_id'];
			if($status!=2){
				$result=mysqli_query($con,"SELECT * FROM judge_submission WHERE contest_id='$contest_id' ORDER BY time_of_submission DESC") or die('mysql_error($con)');
				//echo $result->num_rows;
				$count=0;
				while($row = mysqli_fetch_array($result) and $count<15)
				{
						// name , problem name,result, lang
						// table contain user_id,problem_id,result,lang
						$user_id=$row['user_id'];
						$result1=$row['result'];
						$lang=$row['language'];
						$getuser=mysqli_query($con,"SELECT * FROM judge_users WHERE user_id='$user_id'") or die('mysql_error($con)');
						$getuserfetch=mysqli_fetch_array($getuser);
						$user_name=$getuserfetch['user_name'];		
						$problem_id=$row['problem_id'];
						$getproblem=mysqli_query($con,"SELECT * FROM judge_problem WHERE problem_id='$problem_id'") or die('mysql_error($con)');
						$getproblemfetch=mysqli_fetch_array($getproblem);
						$problem_name=$getproblemfetch['problem_name'];
						$problem_code=$getproblemfetch['problem_code'];
						$AC="AC";
						$RTE="RTE";
						$WA="WA";
						$TLE="TLE";
						$CE="CE";
						echo "<tr>";

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
  						echo "<td >".$lang."</td>";
  						echo "</tr>";
  						$count+=1;
				}
			}
		}
		else
		{
				header("Location: /codejudge/error.php");
			exit();
	
		}
		?>
	</table>
	<?php
		echo "<br>";
		echo "<hr>";
		echo "<br>";
		echo '<div class="view-all-submission">';
		//view all submissions
		if(isset($_GET['id']))
		{
			$contest_code=$_GET['id'];
			echo '<a href="/codejudge/submission-board.php?cid='.$contest_code.'">view-all-submissions</a>';  			
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
		Developed by <span style="color:white;">Chandan Singh</span> 
	</div>
</div>

</body>
</html>
