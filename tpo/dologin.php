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
	
	$email = $_POST['email'];
	$pword = $_POST['pword'];
	
	if(!isEmailValid($email)) {
		//ERROR: email invalid.
		push_error_response("email_error", "101");
	}
	if($pword==null || $pword=="") {
		//ERROR: password invalid.
		push_error_response("pword_error", "103");
	}
	
	//if no errors proceeding with login
	if(errorsCount() == 0) {
		$user_details_logged = userDetailsLogged("email", "s", $email, "pword");
		if(is_array($user_details_logged) && 
		  !($user_details_logged['pword']=="" ||
		  $user_details_logged['pword']==null)) {
			if($pword==$user_details_logged['pword']) {
				set_success_response("true");
				
				if(session_status()===PHP_SESSION_ACTIVE)
					session_destroy();
				create_session_id("tpolggd");
				$_SESSION["login_time"] = $_SESSION["recreated_time"];
				$_SESSION['email'] = $email;
				$_SESSION['pword'] = $pword;
				set_sessionid_response();
			}
			else {
				//ERROR: Email or Password Wrong.
				push_error_response("login_error", "120");
			}
		}
		else {
			//ERROR: No account with this email.
			push_error_response("email_error", "121");
		}
	}
	
	//closing Database connection.
	closeDb();
	
	print_response();
	
	// localhost/istian/tpo/dologin.php?sessionid=1234&email=manojabhisargahas1@gmail.com&pword=1234567890
?>