<?php
	include("session.php");
	include("db_server.php");
	
	set_session(get_session_id());
	is_old_session();
	set_empty_response();
	set_sessionid_response();
	include("db_conn.php");
	select_database(getenv('DB_NAME_ISTIAN_DB'));
	include("login_validate.php");
	
	include("main_code/is_username_availabe.php");

	if(errorsCount() == 0) {
		if(updateUsername($email, $username)["updated"]) {
			set_success_response("true");
		}
		else {
			//ERROR: username update failed.
			push_error_response("username_update_error", "144");
		}
	}
	
	//closing Database connection.
	closeDb();
	
	print_response();
	
	//localhost/istian/tpo/username_change.php?sessionid=tpolggd-1234&username=vishnu
?>