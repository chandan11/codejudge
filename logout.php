<?php
ob_start();
session_start();

unset($_SESSION['sess_user_id']);
unset($_SESSION['sess_username']);
if(isset($_SESSION['admin_status']))
	unset($_SESSION['admin_status']);
header("Location: /codejudge/");
exit();

?>
