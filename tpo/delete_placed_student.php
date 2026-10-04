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
	
	$rollno = $_POST['rollno'];
	$company_name = $_POST['comp_name'];
	
	if(deleteStudentPlacedCompany($rollno, $company_name)) {
		set_success_response("true");
	}
	else {
		// ERROR: deleting student placed company failed.
		push_error_response("updating_placed_student_status_error", "134");
	}
	
	//closing Database connection.
	closeDb();
	
	print_response();
	
	// localhost/istian/tpo/delete_placed_student.php?sessionid=tpolggd-1234&rollno=16kb1a05b5&comp_name=tcs
?>