<?php
	include("session.php");
	include("operations.php");
	include("db_server.php");
	
	set_session(get_session_id());
	is_old_session();
	set_empty_response();
	set_sessionid_response();
	// include("db_conn.php");
	// select_database(getenv('DB_NAME_ISTIAN_DB'));
	include("login_validate.php");
	
	$email = trim($_POST['email']);
	
	//email validation.
	if(!isEmailValid($email)) {
		//ERROR: Email invalid.
		push_error_response("email_error", "101");
	}
	
	if(errorsCount() == 0) {
		$otp = generateOTP();
		//pending: send OTP Email
		create_session_id("otp");
		$_SESSION["otp"] = $otp;
		// echo $_SESSION["otp"];
		push_info_response("otp_sessionid", session_id());
		push_info_response("otp", $_SESSION["otp"]);
		push_info_response("email", $email);
		set_success_response("true");
	}
	//closing Database connection.
	// closeDb();
	
	print_response();
	
	//localhost/istian/tpo/otp_send.php?sessionid=tpolggd-1234&email=vishnulokesh520@gmail.com
	//localhost/istian/tpo/otp_send.php?sessionid=1234&email=vishnulokesh520@gmail.com
?>