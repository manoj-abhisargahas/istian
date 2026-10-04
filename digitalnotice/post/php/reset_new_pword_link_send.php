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
	
	$success_url = "../forgot_pword.php";
	$failure_url = $success_url;
	$params = [];
	
	//getting email value
	$email = trim($_GET['forgot_pword-email']);
	
	//validating email value
	if($email==null || $email=="") {
		push_param("fpemailerr", "114");
		push_error_response_id("114");
	}
	
	//if no errors proceeding with sending link
	if(errors_count() == 0) {
		$user_details = userDetails($email);
		if(is_array($user_details)) {
			//mail reset password link to client.
			
			//destroy present session and
			//create a session with prefix:"rnpdntc" to produce "rnpid" for link.
			session_destroy();
			create_session_id("rnpdntc");
			$_SESSION["assoc_email"] = $email;
			$protocol = (isset($_SERVER["HTTPS"])&&($_SERVER["HTTPS"]==="on"))?"https":"http";
			$host = $_SERVER["HTTP_HOST"];
			$path = explode("/", $_SERVER["PHP_SELF"]);
			array_shift($path);
			array_pop($path);
			$path = implode("/", $path);
			$filename = "reset_new_pword_link.php";
			$query = "rnpid=".session_id();
			$link = $protocol."://".$host."/".$path."/".$filename."?".$query;
			
			// $is_mailed = false;
			// $subject = "New Password Create";
			// $message = "Click on below link to reset password: ".$link;
			//if(mail("$email", $subject, $message)) {
				//mail("$email", $subject, $message);
				set_success_response(true);
				push_param("lnksend", $link);
			//}
			//else {
				//ERROR: link send failed.
			//	push_param("lnksenderr","116");
			//	push_error_response_id("116");
			//}
		}
		else {
			//ERROR: No account with this email.
			push_param("lnksenderr","122");
			push_error_response_id("122");
		}
	}
	
	//closing Database connection.
	closeDb();
	// if sending link:
	// success, redirecting to same page with success msg.
	// failure, redirecting to same page with errors.
	push_param("fpemail", $email);
	$_SESSION = array_merge($_SESSION, $params);
	if($response["success_msg"]) {
		header("location:".$success_url);
	}
	else {
		header("location:".$failure_url);
	}
	
	$response = "";
?>