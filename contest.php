<?php
ob_start();
session_start();
include "conn_db.php";
if((!isset($_SESSION['sess_user_id'])) || (trim($_SESSION['sess_user_id']) == '')) //sess_username or sess_userid not set then redirect to login page.
{
	session_regenerate_id();
	$redirect_url=$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];
	$_SESSION['redirect_url'] = $redirect_url;
	session_write_close();
	header("Location:/codejudge/");
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
	color:white;
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
.left-part{
	float:left;
	width:60%;
}
.right-part{
	float:right;
	width:40%;
}
#contest-table
{
font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
width:100%;
border-collapse:collapse;
}
#contest-table td, #contest-table th 
{
font-size:1em;
padding:3px 7px 2px 7px;
}
#contest-table td
{
	height:25px;
}
#contest-table th
{
font-size:1.1em;
height :40px;
text-align:left;
padding-top:5px;
padding-bottom:4px;
background-color:#E6E6E6;
color:black;
}
h3{
	color:#9A9A9A;
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

.contest-header{
	min-height: 5%;
}

</style>
</head>
<title>Contest</title>
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


<div class="contest-header">
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
</div>
<div class="content">
	<div class="left-part">
	<!-- table for contests-->
	<h3>Future Contest</h3>
	<br>
	<table class="contest-table" id="contest-table" rules="rows" border=1 frame=hsides rules=rows style="border-color:#F4F4F4;">
	<col style ="width:20%;">
  	<col style ="width:50%;">
	<col style ="width:15%;">
  	<col style ="width:15%;">
	
	<tr>
		<th ><a href="/codejudge/contest.php">CODE</a></th>
		<th ><a href="/codejudge/contest.php">NAME</a></th>
		<th ><a href="/codejudge/contest.php">START</a></th>
		<th ><a href="/codejudge/contest.php">END</a></th>
	</tr>
	<?php
		$status=2;
		$result=mysqli_query($con,"SELECT * FROM judge_contest WHERE status='$status'");
		while($row = mysqli_fetch_array($result))
		{
			echo "<tr>";
			$contest_code=$row['contest_code'];
			$contest_name=$row['contest_name'];
			$start_date=$row['start_time'];
  			$end_date=$row['end_time'];
  			echo "<td >$contest_code</td>";
  			echo "<td >";
  			echo '<a href="/codejudge/contest-board.php?id='.$contest_code.'">'.$contest_name.'</a>';
  			echo "</td>";
  			
  			echo "<td>$start_date</td>";
  			echo "<td>$end_date</td>";
  			echo "</tr>";
  		}
	?>
	</table>
	<br><br>
	<h3>Present Contest</h3>
	<br>
	<table class="contest-table" id="contest-table" border=1 frame=hsides rules=rows style="border-color:#F4F4F4;">
	<col style ="width:20%;">
  	<col style ="width:50%;">
	<col style ="width:15%;">
  	<col style ="width:15%;">
	
	<tr>
		<th ><a href="/codejudge/contest.php">CODE</a></th>
		<th ><a href="/codejudge/contest.php">NAME</a></th>
		<th ><a href="/codejudge/contest.php">START</a></th>
		<th ><a href="/codejudge/contest.php">END</a></th>
	
	</tr>
	<?php
		$status=1;
		$result=mysqli_query($con,"SELECT * FROM judge_contest WHERE status='$status'");
		while($row = mysqli_fetch_array($result))
		{
			echo "<tr>";
			$contest_code=$row['contest_code'];
			$contest_name=$row['contest_name'];
			$start_date=$row['start_time'];
  			$end_date=$row['end_time'];
  			echo "<td >$contest_code</td>";
  			echo "<td >";
  			echo '<a href="/codejudge/contest-board.php?id='.$contest_code.'">'.$contest_name.'</a>';
  			echo "</td>";
  			
  			echo "<td >$start_date</td>";
  			echo "<td >$end_date</td>";
  			echo "</tr>";
  		}
	?>
	</table>
	<br><br>
	<h3>Past Contest</h3>
	<br>
	<table class="contest-table" id="contest-table" border=1 frame=hsides rules=rows style="border-color:#F4F4F4;">
	<col style ="width:20%; ">
  	<col style ="width:50%; ">
	<col style ="width:15%; ">
  	<col style ="width:15%; ">
	<tr>
		<th><a href="/codejudge/contest.php">CODE</a></th>
		<th ><a href="/codejudge/contest.php">NAME</a></th>
		<th ><a href="/codejudge/contest.php">START</a></th>
		<th ><a href="/codejudge/contest.php">END</a></th>
	</tr>
	<?php
		$status=0;
		$result=mysqli_query($con,"SELECT * FROM judge_contest WHERE status='$status'");
		while($row = mysqli_fetch_array($result))
		{
			echo "<tr>";
			$contest_code=$row['contest_code'];
			$contest_name=$row['contest_name'];
			$start_date=$row['start_time'];
  			$end_date=$row['end_time'];
  			echo '<td style="overflow:hidden;">'.$contest_code.'</td>';
  			echo '<td style="text-overflow:ellipsis;">';
  			echo '<a href="/codejudge/contest-board.php?id='.$contest_code.'">'.$contest_name.'</a>';
  			echo "</td>";
  			
  			echo '<td style="text-overflow:ellipsis;">'.$start_date.'</td>';
  			echo '<td style="text-overflow:ellipsis;">'.$end_date.'</td>';
  			echo "</tr>";
  		}
	?>
	</table>
	<br><br><br>
	</div>
</div>
<div class="footer">
<div class="footer-data">
		Developed by <span style="color:white;">Chandan Singh</span> 
	</div>
</div>
</body>
</html>
