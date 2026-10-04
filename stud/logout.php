<?php
	include("session.php");
	include("operations.php");
	
	set_session($_POST['sessionid']);
	logout();
	set_empty_response();
	set_sessionid_response();
	set_success_response("true");
	
	print_response();
	
	// http://localhost/istian/stud/logout.php?sessionid=studlggd-12345678
?>