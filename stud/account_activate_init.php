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
	
	$email = trim($_POST['email']);
	
	//email validation.
	if(!isEmailValid($email)) {
		//ERROR: Email invalid.
		push_error_response("email_error", "101");
	}
	
	if(errorsCount() == 0) {
		$user_details = userDetails("email", "s", $email, "name");
		if(is_array($user_details)) {
			$user_details_logged = userDetailsLogged("email", "s", $email, "username");
			if(!is_array($user_details_logged)) {
				push_info_response("stud_name", $user_details["name"]);
				set_success_response("true");
			}
			else {
				//ERROR: Account activation already done with this email.
				push_error_response("email_error", "105");
			}
		}
		else {
			//ERROR: your email is not associated with the college.
			push_error_response("email_error", "104");
		}
	}
	
	//closing Database connection.
	closeDb();
	
	print_response();
	
	// http://localhost/istian/stud/account_activate_init.php?sesssiod=&email=anirudhbala007@gmail.com
	// http://localhost/istian/stud/account_activate_init.php?sesssiod=1234&email=anirudhbala007@gmail.com
?>