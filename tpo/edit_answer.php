<?php
	include("request_time.php");
	include("session.php");
	include("operations.php");
	include("info.php");
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
	$answer = substr(trim($_POST["answer"]), 0, $ans_len);
				
	if($answer=="") {
		push_error_response("answer_error", 139);
	}
	
	if(errorsCount() == 0) {
		$params = [ "answer"=>$answer,
				"answer_last_edited_time"=>$request_time ];
		
		if(updateAnswer($upload_id, $query_index, $params)["updated"]) {
			set_success_response("true");
		}
		else {
			//ERROR: edit answer failed.
			push_error_response("edit_answer_error", "136");
		}
	}
	
	//closing Database connection.
	closeDb();
	
	print_response();
	
	// http://localhost/istian/tpo/edit_answer.php?sessionid=studlggd-dlqatganq518r87deau653abts&request_time=1587555073&upload_id=IMRAN-1234&query_index=0&answer=it%20is%20changed.
?>