<?php
	include("session.php");
	include("operations.php");
	include("db_server.php");
	
	set_session(get_session_id());
	is_old_session();
	set_empty_response();
	set_sessionid_response();
	include("db_conn.php");
	select_database(getenv('DB_NAME_DIGITAL_DB'));
	include("login_validate.php");
	
	$email = $_SESSION['email'];
	$new_pword = trim($_POST['new_pword']);
	
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
			push_error_response("pword_update_error", "110");
		}
	}
	
	//closing Database connection.
	closeDb();
	
	print_response();
	
	// http://localhost/istian/stud/pword_change.php?sessionid=studlggd-1234&new_pword=123456
?>