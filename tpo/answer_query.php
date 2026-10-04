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
	$answered_status = strtoupper(trim($_POST["answered_status"]));
	$answer = substr(trim($_POST["answer"]), 0, $ans_len);
	$ud = userDetailsLogged("email", "s", $_SESSION["email"], "username");
	$username = $ud["username"];
	
	if($answer=="") {
		push_error_response("answer_error", 139);
	}
	
	if(errorsCount() == 0) {
		$params = [ "answered_status"=>$answered_status,
				"tpo_username"=>$username,
				"answer"=>$answer,
				"answer_time"=>$request_time ];
		
		if(updateAnswer($upload_id, $query_index, $params)["updated"]) {
			set_success_response("true");
		}
		else {
			//ERROR: answered failed.
			push_error_response("answer_query_error", "135");
		}
	}
	
	//closing Database connection.
	closeDb();
	
	print_response();
	
	// http://localhost/istian/tpo/answer_query.php?sessionid=studlggd-dlqatganq518r87deau653abts&request_time=1587545073&upload_id=IMRAN-1234&query_index=0&answered_status=pri&answer=it%20is%20it.
?>