<?php
ob_start();
session_start();
include "conn_db.php";
//echo $_SESSION['sess_user_id'].$_SESSION['sess_username'];
$username=stripcslashes($_POST['Username']);
$password=stripcslashes($_POST['password']);
$encrypt_password=md5($password);
$result=mysqli_query($con,"SELECT * FROM judge_users WHERE user_name='$username' AND password='$encrypt_password' ");
$user_name="";
$user_id=0;
$count=0;
//echo $password;
while($row = mysqli_fetch_array($result))
  {
	$user_name=$row['user_name'];
	$user_id=$row['user_id'];
	$admin_status=$row['admin'];
  	$count=$count+1;
  	$live=$row['live'];
  	if($live==0)
  	{
  		header("Location: /codejudge/");
		exit();
  	}
  }

//username exist and password match
if($count==1)
{
	//echo "login successfull";
	//echo $user_name;
	//echo $user_id;
	//Creating Session and store user_id and username in it
	session_regenerate_id();
	$_SESSION['sess_user_id'] = $user_id;
	$_SESSION['sess_username'] = $user_name;
	if($admin_status==1)
	$_SESSION['admin_status']=1;
	session_write_close();
	if(isset($_SESSION['redirect_url'])){
	$redirect_url = (isset($_SESSION['redirect_url'])) ? $_SESSION['redirect_url'] : '/';
	unset($_SESSION['redirect_url']);
	//echo $redirect_url;
	header('Location: ' . $redirect_url);
	exit();
	}
	else{
	header("Location: /codejudge/contest.php");	
	exit();
	}
}
//wrong username password combination
else {
	//writing session error message
	$error_msg="wrong username and password combination"; 
	session_regenerate_id();
	$_SESSION['error_msg'] = $error_msg;
	session_write_close();
	//echo "wrong login and password combination";
	header("Location: /codejudge/");
	exit();
}
?>
