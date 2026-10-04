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
	
	$upload_id = strtoupper(trim($_POST["upload_id"]));
	$query_index = intval($_POST["query_index"]);
	$answered_status = strtoupper(trim($_POST["answered_status"]));
	
	$params = [ "answered_status"=>$answered_status ];
	
	if(updateAnswer($upload_id, $query_index, $params)["updated"]) {
		set_success_response("true");
	}
	else {
		//ERROR: change Q&A privacy failed.
		push_error_response("change_query_ans_privacy_error", "139");
	}
	
	//closing Database connection.
	closeDb();
	
	print_response();
	
	// http://localhost/istian/tpo/change_query_ans_privacy.php?sessionid=studlggd-dlqatganq518r87deau653abts&upload_id=IMRAN-1234&query_index=0&answered_status=pub
?>