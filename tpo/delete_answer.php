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
	$query_index = $_POST["query_index"];
	
	$params = [ "answered_status"=>"NO",
				"tpo_username"=>null,
				"answer"=>null,
				"answer_time"=>null,
				"answer_last_edited_time"=>null ];
	
	if(updateAnswer($upload_id, $query_index, $params)["updated"]) {
		set_success_response("true");
	}
	else {
		//ERROR: delete answer failed.
		push_error_response("delete_answer_error", "137");
	}
	
	//closing Database connection.
	closeDb();
	
	print_response();
	
	// http://localhost/istian/tpo/delete_answer.php?sessionid=studlggd-dlqatganq518r87deau653abts&upload_id=IMRAN-1234&query_index=0
?>