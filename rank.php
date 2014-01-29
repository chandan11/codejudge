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
	font-size:12px;
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
#rank-board
{
font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
width:100%;
border-collapse:collapse;
}
#rank-board td, #rank-board th 
{
font-size:15px;
padding:3px 7px 2px 7px;
}
#rank-board td
{
	height:25px;
}
#rank-board th
{
font-size:15px;
height :50px;
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
.green{
	background-color: 	#19FF19;
}
.red{
	background-color: #FF3333;
}
</style>
<title>Rank</title>
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
	//account link
	$user_name=$_SESSION['sess_username'];
	echo '<div class="account">';
	echo '<a href="/codejudge/account.php?id='.$user_name.'">Account</a>';
	echo "</div>";
	?>
	<!--- <a href="/codejudge/rank.php" class="rank">Ranking</a> contest name-->
	<?php
	if(isset($_GET['id']))
	{
		$contest_code=$_GET['id'];
		$result=mysqli_query($con,"SELECT * FROM judge_contest WHERE contest_code='$contest_code'") or die('mysql_error($con)');
		$row=mysqli_fetch_array($result);
		$contest_name=$row['contest_name'];
		echo '<div class="contest-name">';
		echo '<a href="/codejudge/contest-board.php?id='.$contest_code.'">'.$contest_name.'</a>';		
		echo "</div>";
	}
	else
	{
		header("Location: /codejudge/error.php");
		exit();
	}
	?>
	</div>
</div>
<div class="header-border"></div>
<div class="content">
	<table class="rank-board" id="rank-board" border=1 frame=hsides rules=rows style="border-color:#F4F4F4;">
		<col style ="width:20px;">
  		<col style ="width:100px;">
		<?php
  			//get number of problems in contest
  			if(isset($_GET['id']))
  			{
  				$contest_code=$_GET['id'];
  				$result=mysqli_query($con,"SELECT * FROM judge_problem WHERE contest_code='$contest_code'") or die('mysql_error($con)');
				$problems=array();
				while($row=mysqli_fetch_array($result))
				{
					$problem_id=$row['problem_id'];
					array_push($problems,$problem_id);
				}
				sort($problems);
				foreach ( $problems as $problem_id )
				{
					echo '<col style="width:30px">';
				}
				echo '<col style ="width:30px;">';
  				echo '<col style ="width:30px;">';
  				echo '<col style ="width:20px;">';
  		
				echo "<tr>";
				echo "<th>Rank</th>";
				echo "<th >User</th>";
				foreach ($problems as $problem_id )
				{
					$result=mysqli_query($con,"SELECT * FROM judge_problem WHERE problem_id='$problem_id'") or die('mysql_error($con)');
					$row=mysqli_fetch_array($result);
					$problem_code=$row['problem_code'];
					echo "<th>";
					echo '<a href="/codejudge/problem-board.php?id='.$problem_code.'">'.$problem_code.'</a>';
					echo "</th>";
				}
				echo "<th >Problem Solved</th>";
				echo "<th >Time</th>";
				echo "<th >Penalty</th>";
				echo "</tr>";
  				
				// code for calculating rank 

				//getting all distintc user id from submission for contest_id 
				//get contest_id from contest_code
				$result=mysqli_query($con,"SELECT * FROM judge_contest WHERE contest_code='$contest_code'") or die('mysql_error($con)');
				$row=mysqli_fetch_array($result);
				$contest_id=$row['contest_id'];
				$end_time=$row['end_time'];
				$start_time=$row['start_time'];
				//get all user_ids from submission 
				$result=mysqli_query($con,"SELECT DISTINCT user_id FROM judge_submission WHERE contest_id='$contest_id'") or die('mysql_error($con)');
				$users=array();
				while($row=mysqli_fetch_array($result))
				{
					$user_id=$row['user_id'];
					array_push($users,$user_id);
				}
				//table break
				$score=array();
				foreach ($users as $user_id)
				{
					//echo $user_id;
					$penalty=0;
					$total_time=0;
					foreach($problems as $problem_id)
					{
					$result=mysqli_query($con,"SELECT * FROM judge_submission WHERE user_id='$user_id' AND problem_id='$problem_id' ORDER BY time_of_submission ASC") or die('mysql_error($con)');
					//$sumission=array();
					while($row=mysqli_fetch_array($result))
						{
							//echo $row['time_of_submission'];
							//echo "<br>";
						$AC="AC";
						if($row['result']!=$AC)
						{
							$penalty+=1;
						}
						if($row['result']==$AC)
						{
							$time_of_submission=$row['time_of_submission'];
							//echo $time_of_submission;
							//echo $start_time;
							$timeDiff=strtotime($end_time)-strtotime($time_of_submission);
							//echo $timeDiff."  ";
							$total_time=$total_time+($timeDiff);
							break;
						}
						}
					}
					//echo "<br>";
					//adding plenalty of 10 minutes in case of WA,TLE,RTE
					$total_time=$total_time-(600*$penalty);
					//get user_name from user_id
					$result=mysqli_query($con,"SELECT * FROM judge_users WHERE user_id='$user_id'") or die('mysql_error($con)');
					$row=mysqli_fetch_array($result);
					$user_name=$row['user_name'];
					$score[$user_name]=$total_time;
					//echo $score[$user_name];  
					//echo $user_name;
					//echo "  ".$total_time."  ";
					//echo "<br>";
					
				}
				// sort array in reverse order
				arsort($score);
				$rank=1;
				foreach($score as $x=>$x_value)
    			{
    				echo "<tr>";
    				//echo "Name=" . $x . ", Time=" . $x_value;// $x=>username and $x_value=>time
    				echo "<td>".$rank."</td>";
    				echo "<td>";
    				echo '<a href="/codejudge/account.php?id='.$x.'">'.$x.'</a>';
    				echo "</td>";
    				$user_name=$x;
    				$result=mysqli_query($con,"SELECT * FROM judge_users WHERE user_name='$user_name'") or die('mysql_error($con)');
    				$row=mysqli_fetch_array($result);
					$user_id=$row['user_id'];
					$total_penalty=0;
					$total_time=0;
					$problem_solved=0;
					foreach ($problems as $problem_id)
					{
						$time_problem=0;
						$penalty_problem=0;
						$flag=0;
						$result=mysqli_query($con,"SELECT * FROM judge_submission WHERE user_id='$user_id' AND problem_id='$problem_id' ORDER BY time_of_submission ASC") or die('mysql_error($con)');
						while($row=mysqli_fetch_array($result))
						{
							//echo $row['time_of_submission'];
							//echo "<br>";
						$AC="AC";
						if($row['result']!=$AC)
						{
							$penalty_problem=$penalty_problem+1;
						}
						if($row['result']==$AC)
						{
							$flag=1;
							$problem_solved=$problem_solved+1;
							$time_of_submission=$row['time_of_submission'];
							//echo $time_of_submission;
							//echo $start_time;
							$timeDiff=strtotime($time_of_submission)-strtotime($start_time);
							//echo $timeDiff."  ";
							$time_problem=($timeDiff);
							break;
						}
						}
						$time_problem=$time_problem+(600*$penalty_problem);
						$total_penalty=$total_penalty+$penalty_problem;
						$total_time=$total_time+$time_problem;
						if($time_problem!=0)
						{
						if($flag==1){
						echo '<td class="green">';
						echo "$time_problem($penalty_problem)";
						echo "</td>";
						}
						else
						{
							echo '<td class="red">';
							echo "-$time_problem($penalty_problem)";
							echo "</td>";
						}
						}
						else
						{
							echo "<td>";
							echo "N/A";
							echo "</td>";
						}
					}
					echo "<td>$problem_solved</td>";
					echo "<td>$total_time</td>";
					echo "<td>$total_penalty</td>";
    				echo "</tr>";
    				$rank=$rank+1;
    			}
				echo "</table>";
  			}
  			else{
  				header("Location: /codejudge/error.php");
				exit();
  			}
  		?>
		
	
</div>
<div class="footer">
<div class="footer-data">
		Developed by <span style="color:white;">Chandan Singh </span> 
	</div>
</div>

</body>

</html>
