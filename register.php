<?php
ob_start();
session_start();
include "conn_db.php";
$username=mysqli_real_escape_string($con,$_POST['Username']);
$password=mysqli_real_escape_string($con,$_POST['password']);
$encrypt_password=md5($password);
$email=mysqli_real_escape_string($con,$_POST['email']);
$name=mysqli_real_escape_string($con,$_POST['Name']);
//User Already Exist

$result=mysqli_query($con,"SELECT * FROM judge_users WHERE user_name='$username'") or die('mysql_error($con)');
$count_email=0;
$count=$result->num_rows;
$result=mysqli_query($con,"SELECT * FROM judge_users WHERE email_id='$email'") or die('mysql_error($con)');
$count_email=$result->num_rows;
 echo $count_email;
 if($count>=1)
 {
			//writing session error message--> username already exist choose another one
			$error_msg="username already exist choose another one"; 
			session_regenerate_id();
			$_SESSION['error_msg'] = $error_msg;			
			session_write_close();
			header("Location: /codejudge/");
			exit(); 
 }
else if($count_email>=1)
{
			$error_msg="email already in use choose another one"; 
			session_regenerate_id();
			$_SESSION['error_msg'] = $error_msg;			
			session_write_close();
			header("Location: /codejudge/");
			exit();	
}
else {
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
  else {
	echo"connected";  
  }
mysqli_query($con,"INSERT INTO judge_users(name,user_name, password, email_id) VALUES ('$name','$username','$encrypt_password','$email')") or die(mysqli_error($con));
$result=mysqli_query($con,"SELECT * FROM judge_users WHERE user_name='$username'") or die('error in DB1');
$row=mysqli_fetch_array($result);
$user_id=$row['user_id'];
session_regenerate_id();
$_SESSION['sess_user_id'] = $user_id;
$_SESSION['sess_username'] = $username;
session_write_close();
//echo "regitered";
if(isset($_SESSION['redirect_url'])){
	$redirect_url = (isset($_SESSION['redirect_url'])) ? $_SESSION['redirect_url'] : '/';
	unset($_SESSION['redirect_url']);
	//echo $redirect_url;
	header('Location: ' . $redirect_url);
	exit();
	}
else{
//	echo "yes";
header("Location: /codejudge/contest.php");
exit();
}
}
?>
