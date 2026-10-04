<?php
	include("session.php");
	
	set_session(get_session_cookie());
	logout();
	set_session_cookie();
	header("location:../login.php");
?>