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
	
	$email = $_SESSION['email'];
	$pword = trim($_POST['pword']);
	
	//validating password value
	if(!isPasswordValid($pword)) {
		//ERROR: password invalid.
		push_error_response("pword_error", "103");
	}
	
	//if no errors proceeding with verifying password.
	if(errorsCount() == 0) {
		if(verifyPassword($email, $pword)) {
			set_success_response("true");
		}
	}
	
	//closing Database connection.
	closeDb();
	
	print_response();
	
	//localhost/istian/tpo/pword_verify.php?sessionid=tpolggd-1234&pword=123456
?>