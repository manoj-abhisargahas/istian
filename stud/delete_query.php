<?php
	include("session.php");
	include("operations.php");
	include("db_server.php");
	
	set_session($_POST["sessionid"]);
	is_old_session();
	set_empty_response();
	set_sessionid_response();
	include("db_conn.php");
	select_database(getenv('DB_NAME_DIGITAL_DB'));
	include("login_validate.php");
	
	$upload_id = strtoupper(trim($_GET["upload_id"]));
	$query_index = strtoupper(trim($_GET["queryindex"]));
	
	select_database(getenv('DB_NAME_DIGITAL_DB'));
	if(delete_query($upload_id, $query_index)) {
		set_success_response("true");
	}
	else {
		//ERROR: Query Not Deleted.
		push_error_response("delete_query_error", "125");
	}
	
	//closing Database connection.
	closeDb();
	
	print_response();
	
	// http://localhost/istian/student/delete_query.php?sessionid=studlggd-dlqatganq518r87deau653abts&upload_id=IMRAN-1234&queryindex=1
?>