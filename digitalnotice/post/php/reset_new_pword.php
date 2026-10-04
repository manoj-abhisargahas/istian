<?php
	include("session.php");
	include("operations.php");
	include("db_server.php");
	
	//getting rnpid and setting as sessionid.
	$rnpid = $_POST['rnpid'];
	set_session($rnpid);
	is_link_session_expired($GLOBALS["reset_new_pword_link_life_time"], 1);
	set_empty_response();
	//establishing Database connection
	//if not established redirecting to same page.
	if(!connectDb()) {
		push_error_response_id("100");
	}
	
	$success_url = "../login.php";
	$failure_url = "reset_new_pword_link.php";
	$params = [];
	push_param("rnpid", $rnpid);
	
	//getting password value
	$pword = trim($_POST['reset_new_pword-pword']);
	
	//validating password value
	if(!isPasswordValid($pword)) {
		//ERROR: password invalid.
		push_param("rnppworderr", "115");
		push_error_response_id("115");
	}
	
	//if no errors proceeding with updating password.
	if(errors_count() == 0) {
		$email = trim($_SESSION['assoc_email']);
		
		if(updatePassword($email, $pword)["updated"]) {
			set_success_response(true);
			logout();
		}
		else {
			//ERROR: Password update failed.
			push_param("rnperr", "113");
			push_error_response_id("113");
		}
	}
	
	//closing Database connection.
	closeDb();
	
	//if sending link:
	//success, redirecting to login page.
	//failure, redirecting to same page with errors.
	if($response["success_msg"]) {
		header("location:".$success_url);
	}
	else {
		header("location:".$failure_url."?".implode("&", $params));
	}
?>