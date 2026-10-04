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
	$username = trim($_POST['username']);
	$pword = trim($_POST['pword']);
	
	//email validation.
	if(!isEmailValid($email)) {
		//ERROR: Email Invalid.
		push_error_response("email_error", "101");
	}
	
	if(!isUsernameValid($username)) {
		//ERROR: Username Empty.
		push_error_response("username_empty", "143");
	}
	
	//validating password value
	if(!isPasswordValid($pword)) {
		//ERROR: Password Invalid.
		push_error_response("pword_error", "103");
	}
	
	//if no errors proceeding with activating account.
	if(errorsCount() == 0) {
		if(activateAccount($email, $username, $pword)) {
			set_success_response("true");
		}
		else {
			//ERROR: Account Activation failed.
			push_error_response("account_activate_error", "123");
		}
	}
	
	//closing Database connection.
	closeDb();
	
	print_response();
	
	//localhost/istian/tpo/account_activate.php?sessionid=1234&email=imran@gmail.com&username=imran&pword=123456
?>