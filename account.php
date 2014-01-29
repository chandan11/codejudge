<?php
ob_start();
session_start();
include "conn_db.php";
if((!isset($_SESSION['sess_user_id'])) || (trim($_SESSION['sess_user_id']) == '')) //sess_username or sess_userid not set then redirect to login page.
{
	//writing in session for redirecting to the same page after login process.
	session_regenerate_id();
	$redirect_url=$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];
	$_SESSION['redirect_url'] = $redirect_url;
	session_write_close();
	header("Location:/codejudge/");
	exit();
}
//checking for wrong url id--> contest code
if(isset($_GET['id']))
{
	$user_name=$_GET['id'];
	$result=mysqli_query($con,"SELECT * FROM judge_users WHERE user_name='$user_name'") or die('mysql_error($con)');
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

.left-part{
	float:left;
	width:60%;
}
.right-part{
	float:right;
	width:30%;
}
#user-table
{
font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
width:100%;
border-collapse:collapse;
}
#user-table td, #user-table th 
{
font-size:1em;
padding:3px 7px 2px 7px;
}
#user-table td
{
	height:25px;
}
#user-table th
{
font-size:15px;
font-family:helvetica;
height :40px;
text-align:left;
padding-top:5px;
padding-bottom:4px;
background-color:#E6E6E6;
color:black;
}
#user-sub
{
font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
width:100%;
border-collapse:collapse;
}
#user-sub td, #user-sub th 
{
font-size:1em;
padding:3px 7px 2px 7px;
}
#user-sub td
{
	height:25px;
}
#user-sub th
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

h3{
	color:#9A9A9A;
}
.account a{
	color:white;
}

</style>
<title>Account</title>
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
		//session_start();
		if(isset($_SESSION['sess_username'])){
		$user_name=$_SESSION['sess_username'];
		echo '<div class="account">';
		echo '<a href="/codejudge/account.php?id='.$user_name.'">Account</a>';		
		echo "</div>";
		}
		else
		{
			header("Location: /codejudge/");
		}
		?>
	</div>
</div>
<div class="header-border">
</div>
<div class="content">
<!--- user account-->
<div class="left-part">
<table class="user-table" id="user-table"  border=1 frame=hsides rules=rows style="border-color:#F4F4F4;">
	<col style ="width:16%;">
  	<col style ="width:16%;">
	<col style ="width:16%;">
  	<col style ="width:16%;">
	<col style ="width:16%;">
  	<col style ="width:16%;">
	<tr>
		<th >Problem Solved</th>
		<th >Total Submissions</th>
		<th >Accepted Solution</th>
		<th >Wrong Answer</th>
		<th >Time Limit Exceed</th>
		<th >Run Time Error</th>
	</tr>
<?php
// username info (username,emailID, problem solved,submissions,AC,WA,RTE,TLE) and contest code and problems
if($_GET['id'])
{
	//username in id
	$user_name=$_GET['id'];
	//get userID
	$result=mysqli_query($con,"SELECT * FROM judge_users WHERE user_name='$user_name'") or die('mysql_error($con)');
    $row=mysqli_fetch_array($result);
    $user_id=$row['user_id'];
    $name=$row['name'];
    echo "<b>Name : </b>".$name."<br><br>";
    echo "<b>Username : </b>".$user_name."<br><br><br>";
    //number of problem solved
    //total submissions
    $result=mysqli_query($con,"SELECT * FROM judge_submission WHERE user_id='$user_id'") or die('mysql_error($con)');
    $total_sub=$result->num_rows;
    //total Ac solution
    $AC="AC";
    $result=mysqli_query($con,"SELECT * FROM judge_submission WHERE user_id='$user_id' AND result='$AC'") or die('mysql_error($con)');
   	$total_ac=$result->num_rows;
   	// total wa
   	$WA="WA";
   	$result=mysqli_query($con,"SELECT * FROM judge_submission WHERE user_id='$user_id' AND result='$WA'") or die('mysql_error($con)');
   	$total_wa=$result->num_rows;
   	$TLE="TLE";
   	$result=mysqli_query($con,"SELECT * FROM judge_submission WHERE user_id='$user_id' AND result='$TLE'") or die('mysql_error($con)');
   	$total_tle=$result->num_rows;
   	$RTE="RTE";
   	$result=mysqli_query($con,"SELECT * FROM judge_submission WHERE user_id='$user_id' AND result='$RTE'") or die('mysql_error($con)');
   	$total_rte=$result->num_rows;
   	// number of problem solved
   	$result=mysqli_query($con,"SELECT DISTINCT problem_id FROM judge_submission WHERE user_id='$user_id' AND result='$AC'") or die('mysql_error($con)');
   	$total_prob_solve=$result->num_rows;
   	//echo $total_prob_solve;
   	// make a table;
   	
   	echo "<tr>";
   	echo "<td>$total_sub</td>";
   	echo "<td>$total_prob_solve</td>";
   	echo "<td>$total_ac</td>";
	echo "<td>$total_wa</td>";
	echo "<td>$total_tle</td>";
	echo "<td>$total_rte</td>";
	echo "</tr>";
}
else
{
	header("Location: /codejudge/error.php");
	exit();
}

?> 
</table>
<?php
//contest participation list
if($_GET['id'])
{
	//username in id
	$user_name=$_GET['id'];
	//get userID
	$result=mysqli_query($con,"SELECT * FROM judge_users WHERE user_name='$user_name'") or die('mysql_error($con)');
    $row=mysqli_fetch_array($result);
    $user_id=$row['user_id'];
  	//get all contest in which user particpated
  	$result=mysqli_query($con,"SELECT DISTINCT contest_id FROM judge_submission WHERE user_id='$user_id'") or die('mysql_error($con)');
  	$num_contest=$result->num_rows;
  	//echo $num_contest;
  	$c=1;
  	echo "<br><br><b>History Of Participation :</b><br><br>";
  	while($row=mysqli_fetch_array($result))
  	{
  		$c+=1;
  		//get contest ID
  		$contest_id=$row['contest_id'];
  		//get contest name
  		$result_contest=mysqli_query($con,"SELECT * FROM judge_contest WHERE contest_id='$contest_id'") or die('mysql_error($con)');
  		// get contest name and contest code 
  		$row_contest=mysqli_fetch_array($result_contest);
  		$contest_code=$row_contest['contest_code'];
  		$contest_name=$row_contest['contest_name'];
  		echo '<a href="/codejudge/contest-board.php?id='.$contest_code.'">'.$contest_name.'</a>';
  		echo " : ";
  		$AC="AC";
  		// list of problem solved in contest
  		$result_problem=mysqli_query($con,"SELECT DISTINCT problem_id FROM judge_submission WHERE user_id='$user_id' AND result='$AC' AND contest_id='$contest_id'") or die('mysql_error($con)');
  		$count=1;
  		while($row_problem=mysqli_fetch_array($result_problem))
  		{
  			if($count!=1) echo ", ";
  			$problem_id=$row_problem['problem_id'];
  			// get problem code of the name
  			$result_problem_code=mysqli_query($con,"SELECT * FROM judge_problem WHERE problem_id='$problem_id'") or die('mysql_error($con)');
  			$row_problem_code=mysqli_fetch_array($result_problem_code);
  			$problem_code=$row_problem_code['problem_code'];
  			echo '<a href="/codejudge/problem-board.php?id='.$problem_code.'">'.$problem_code.'</a>';
  			$count=$count+1;
  		}
  		if($count==1)
  		{
  			echo "N/A";
  		}
  		echo "<br>";
  	}
  	if($c==1)
  	{
  		echo "**No any participation yet**<br>";
  	}
}
else
{
	header("Location: /codejudge/error.php");
	exit();
}
?>
</div>
<div class="right-part">
<b>Recent Submissions</b><br>
<table class="user-sub" id="user-sub"  border=1 frame=hsides rules=rows style="border-color:#F4F4F4;">
	<col style ="width:35%;">
  	<col style ="width:30%;">
	<col style ="width:18%;">
  	<col style ="width:18%;">
	<tr>
		<th >Problem Name</th>
		<th >Date/Time</th>
		<th >Result</th>
		<th >Time</th>
	</tr>
<?php
//show submission of user (problem name ,date/time, result,time)

if(isset($_GET['id']))
{
	// get user name and show 15 submissions and view all for submission board
	$user_name=$_GET['id'];
	$result=mysqli_query($con,"SELECT * FROM judge_users WHERE user_name='$user_name'") or die('mysql_error($con)');
    $row=mysqli_fetch_array($result);
    $user_id=$row['user_id'];
	$result=mysqli_query($con,"SELECT * FROM judge_submission WHERE user_id='$user_id' ORDER BY time_of_submission DESC") or die('mysql_error($con)');
	while($row=mysqli_fetch_array($result))
	{
		echo "<tr>";
		$problem_id=$row['problem_id'];
		$date_time=$row['time_of_submission'];
		$result1=$row['result'];
		$time=$row['time_taken'];
		//get problem name and problem code
		$res_problem=mysqli_query($con,"SELECT * FROM judge_problem WHERE problem_id='$problem_id'") or die('mysql_error($con)');
		$row_problem=mysqli_fetch_array($res_problem);
		$problem_name=$row_problem['problem_name'];
		$problem_code=$row_problem['problem_code'];
		echo "<td>";
		echo '<a href="/codejudge/problem-board.php?id='.$problem_code.'">'.$problem_name.'</a>';
		echo "</td>";
		echo "<td>$date_time</td>";
		echo "<td>";
		$AC="AC";
		$WA="WA";
		$TLE="TLE";
		$AC="AC";
		$CE="CE";
		if($result1==$AC)
			echo '<img src="/codejudge/ac-icon.gif">';
  		else if($result1==$WA)
  			echo '<img src="/codejudge/wa-icon.gif">';
  		else if($result1==$TLE)
  			echo '<img src="/codejudge/tle-icon.png">';
  		else if($result1==$RTE)
  			echo '<img src="/codejudge/rte-icon.png">';		
  		else if($result1==$CE)
  					echo '<img src="/codejudge/ce-icon.gif">';
		echo "</td>";
		echo "<td>$time</td>";
		echo "</tr>";
	}
	echo "</table><br>";
	echo "<hr>";
	echo '<a href="/codejudge/submission-board.php?cid=0&uid='.$user_name.'">View-all-submissions</a>';
}
?>
</div>
</div>
<div class="push"></div>
<div class="footer">
<div class="footer-data">
		Developed by <span style="color:white;">Chandan Singh </span> 
	</div>
</div>

</body>
</html>
