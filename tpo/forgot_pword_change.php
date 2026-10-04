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
	
	$email = trim($_POST['email']);
	$new_pword = trim($_POST['new_pword']);
	
	//email validation.
	if(!isEmailValid($email)) {
		//ERROR: Email invalid.
		push_error_response("email_error", "101");
	}
	
	//validating password value
	if(!isPasswordValid($new_pword)) {
		//ERROR: password invalid.
		push_error_response("pword_error", "103");
	}
	
	//if no errors proceeding with updating password.
	if(errorsCount() == 0) {
		if(updatePassword($email, $new_pword)["updated"]) {
			set_success_response("true");
		}
		else {
			//ERROR: Password update failed.
			push_error_response("pword_update_error", "141");
		}
	}
	
	//closing Database connection.
	closeDb();
	
	print_response();
	
	//localhost/istian/tpo/forgot_pword_change.php?sessionid=1234&email=malapatisivakumarreddy@gmail.com&pword=123456
?>