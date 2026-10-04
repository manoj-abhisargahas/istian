<?php
	include("session.php");
	include("operations.php");
	
	set_session($_POST['sessionid']);
	logout();
	set_empty_response();
	set_sessionid_response();
	set_success_response("true");
	
	print_response();
	
	// localhost/istian/tpo/logout.php?sessionid=tpolggd-12345678
?>