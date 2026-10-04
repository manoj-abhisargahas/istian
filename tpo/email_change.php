<?php
	include("session.php");
	include("operations.php");
	include("db_server.php");

	set_session(get_session_id());
	is_old_session();
	set_empty_response();
	set_sessionid_response();
	include("db_conn.php");
	select_database(getenv('DB_NAME_ISTIAN_DB'));
	include("login_validate.php");
	
	$old_email = $_SESSION["email"];
	$new_email = $_POST["new_email"];
	
	//email validation.
	if(!isEmailValid($new_email)) {
		//ERROR: Email invalid.
		push_error_response("email_error", "101");
	}
	
	include("main_code/otp_verify.php");
	
	if(errorsCount()==0) {
		if(updateEmail($old_email, $new_email)) {
			set_success_response("true");
		}
		else {
			//ERROR: Change email failed.
			push_error_response("email_update_error", "141");
		}
	}
	
	//closing Database connection.
	closeDb();
	
	print_response();
	
	//localhost/istian/tpo/email_change.php?sessionid=tpolggd-1234&otp_sessionid=otp-ax&otp=123456
?>