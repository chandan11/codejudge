<!DOCTYPE html>
<html>
<head>
	<style type="text/css">
	* {
 font-size: 100%;
 font-family: Arial;
}
p{
	color:red;
}
div.vr{
	width:1px;
	float:center;    
    background-color:#000;
    position:absolute;
    top:142px;
    bottom:0;
    height:60%;
    left:47%;
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


	.form-login-control,.register-control {
border: 1px solid #b7bbbd;
-webkit-border-radius: 5px;
-moz-border-radius: 5px;
border-radius: 5px;
padding: 4px;
width: 200px;
}
div.forms-left{
float:left;
margin-left:50px;
width:40%;
height:100%;
}
div.forms-right{
float:right;
width:40%;
height:100%;
}
div.home-form
{
margin-top:100px;
margin-right:170px;
margin-left:170px;
}
h3
{
	height:20px;
	width:200px;
	background:#F0F0F0;
	text-align:center;
	padding:12px;
}
div.error{
	color:red;
	font-size:12px;
}
.content{
	font-size:15px;
}
</style>

</head>
<body>
<?php
include "header.php";
ob_start();
session_start();
?>
<div class="content">
		<div class="forms">
		<div class="forms-left" id="forms-left">
		<h3>Already A Member?</h3>
		<form name="form-login" id="form-login" class="form-login" action="/codejudge/check_login.php"  method="post">
		<label for ="Username">Username</label><br>
		<input type="text" class="form-login-control" id="Username" name="Username" placeholder="Enter Username" ><br><br>
		<label for ="Password">Password</label><br>
		<input type="password" class="form-login-control" id="password" name="password" placeholder="Enter Password" ><br><br>
		<button type="submit" class="btn">Submit</button>
		</form>
		</form>
		<?php
		//echo $_SESSION['error_msg'];
		$error="wrong username and password combination";
		if(isset($_SESSION['error_msg'])  && $_SESSION['error_msg']==$error)
		{
			unset($_SESSION['error_msg']);
			echo "<p>**Wrong Username and Password combination**</p>";
		}
?>

	</div>
	<div class="vr">&nbsp;</div>
<div class="forms-right" id="forms-right">
<h3>New User? Register Here!</h3>
<form id="register" name="register" action="/codejudge/register.php" method="post" >
<label for ="Username"> Username </label><br>
<input type="text" class="register-control" id="Username" name="Username" placeholder="Enter Username"> <br><br>
<label for ="Name"> Full Name  </label><br>
<input type="text" class="register-control" id="Name" name="Name" placeholder="Enter Name" ><br><br>
<label for ="Password"> Password </label><br>
<input type="password" class="register-control" id="password" name="password" placeholder="Enter Password" ><br><br>
<label for="email" > Email </label><br>
<input type ="email" class="register-control" id="email" name="email" placeholder="Enter Valid Email"><br><br>
<button type="submit" class="btn">Submit</button>

</form>
<?php
$error="username already exist choose another one";
if(isset($_SESSION['error_msg'])  && $_SESSION['error_msg']==$error)
{
	unset($_SESSION['error_msg']);
	echo "<p>**Username already exist,choose another one.**</p>";
}
$error="email already in use choose another one";
if(isset($_SESSION['error_msg'])  && $_SESSION['error_msg']==$error)
{
	unset($_SESSION['error_msg']);
	echo "<p>**Email already in use choose another one.**</p>";
}
?>
</div>
</div>
</div>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
		<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.8/jquery.validate.min.js"></script>
		<script type="text/javascript">
		$(document).ready(function(){
		$("#form-login").validate({
		errorElement: 'div',
		rules:{
			"Username":{
				required: true,		
			},
			"password":{
				required:true,
			}
			},
			messages: {
         Username: {
                    required: "Please provide a username",
                    },
         password: {
                    required: "Please provide a password",
                   }
        }
			
		});  
		});
</script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.8/jquery.validate.min.js"></script>
<script type="text/javascript">

 jQuery.validator.addMethod("word_check", function(value, element) {
  return this.optional(element) || /^[a-zA-Z0-9-_]+$/i.test(value);
}, "special characters/spaces not allowed");
$(document).ready(function(){
  $("#register").validate({
  	errorElement: 'div',
	rules:{
		"Username":{
		required: true,		
		minlength:5,
		word_check : true
		},
	"password":{
	required:true,
	minlength:5
	},
	"Name":{
	required:true,
	},
	"email":{
	required:true,	
	email:true
	}
	},
	messages: {
		Username:{
			         required: "Please provide a username",
                    minlength: "Your Username must be at least 5 characters long"
		},
         password: {
                    required: "Please provide a password",
                    minlength: "Your password must be at least 5 characters long"
                    },
         ConfirmPassword: {
                    required: "Please provide a confirm password",
                    minlength: "Your password must be at least 5 characters long",
            		equalTo:"Password not match"
                    },
         email:{
			        required: "Please provide a valid email"
		}
        },
        submitHandler: function (form) {
            form.submit();
        }
        
  });  
});
</script>
		
</body>
</html>
