<?php
	include("session.php");
	include("operations.php");
	include("db_server.php");
	
	set_session($_POST['sessionid']);
	is_old_session();
	set_empty_response();
	set_sessionid_response();
	include("db_conn.php");
	select_database(getenv('DB_NAME_ISTIAN_DB'));
	
	if(login_validate()) {
		set_success_response("true");
	}
	else {
		//ERROR: session loggedout.
		push_error_response("loggedout", "115");
	}
	
	//closing Database connection.
	closeDb();
	
	print_response();
	
	// localhost/istian/tpo/isloggedin.php?sessionid=tpolggd-1234
?>