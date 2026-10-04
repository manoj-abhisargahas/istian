<?php
	include("session.php");
	include("operations.php");
	include("info.php");
	include("db_server.php");
	
	set_session(get_session_cookie());
	is_old_session();
	set_session_cookie();
	set_empty_response();
	//establishing Database connection
	//if not established redirecting to same page.
	if(!connectDb()) {
		push_error_response_id("100");
	}
	
	$success_url = "../";
	$failure_url = "../login.php";
	$params = [];
	$GLOBALS["notice_by"] = "";
	
	//getting login credentials
	$email = trim($_POST['login-email']);
	$pword = trim($_POST['login-pword']);
	
	//validating login credentials
	if(!isEmailValid($email)) {
		push_param("lgemailerr","114");
		push_error_response_id("114");
	}
	if($pword==null || $pword=="") {
		push_param("lgpworderr","115");
		push_error_response_id("115");
	}
	
	//if no errors proceeding with login
	if(errors_count() == 0) {
		$user_details = userDetails($email);
		if(is_array($user_details)) {
			if($pword==$user_details['notice_by_pword']) {
				set_success_response(true);
				
				if(session_status()===PHP_SESSION_ACTIVE)
					session_destroy();
				create_session_id("dntc");
				$_SESSION["login_time"] = $_SESSION["recreated_time"];
				$_SESSION['email'] = $email;
				$_SESSION['pword'] = $pword;
				$_SESSION['notice_by'] = $user_details["notice_by_name"];
				set_session_cookie();
			}
			else {
				//ERROR: Login Invalid.
				push_param("lgerr","109");
			}
		}
		else {
			//ERROR: No account with this email.
			push_param("lgerr","122");
		}
	}
	//closing Database connection.
	closeDb();
	
	//if login:
	//success, redirecting to digitalnotice home page.
	//failure, redirecting to login page with errors.
	if($response["success_msg"]) {
		header("location:".$success_url);
	}
	else {
		push_param("lgemail", $email);
		$_SESSION = array_merge($_SESSION, $params);
		header("location:".$failure_url);
	}
?>