<?php
	include("request_time.php");
	include("session.php");
	include("operations.php");
	include("info.php");
	include("db_server.php");
	
	set_session($_POST["sessionid"]);
	is_old_session();
	set_empty_response();
	set_sessionid_response();
	include("db_conn.php");
	select_database(getenv('DB_NAME_DIGITAL_DB'));
	include("login_validate.php");
	
	$GLOBALS["response"]["query_index"] = "";
	
	$upload_id = strtoupper(trim($_GET["upload_id"]));
	$query = substr(trim($_GET["query"]), 0, $query_len);
	$ud = userDetails("email", "s", $_SESSION["email"], "rollno");
	$rollno = $ud["rollno"];
	
	if($query=="") {
		push_error_response("query_error", "140");
	}
	
	if(errorsCount()==0) {
		select_database(getenv('DB_NAME_ISTIAN_DB'));
		$query_index = insert_query_with_next_max_query_index($rollno, $upload_id, $query, $request_time);
		if($query_index!=null) {
			$GLOBALS["response"]["query_index"] = $query_index;
			set_success_response("true");
		}
		else {
			//ERROR: Query Not Inserted.
			push_error_response("ask_query_error", "124");
		}
	}
	
	//closing Database connection.
	closeDb();
	
	print_response();
	
	// http://localhost/istian/student/ask_query.php?sessionid=studlggd-dlqatganq518r87deau653abts&request_time=1587541060&upload_id=IMRAN-1234&query=what%20is%20it?
?>