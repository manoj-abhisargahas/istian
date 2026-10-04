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
	// include("login_validate.php");
	
	$GLOBALS["response"]["errrollnums"] = [];
	
	$company_name = $_POST['comp_name'];
	$rollnos = $_POST['rollnos'];
	
	//Company name validation.
	if($company_name==null || $company_name=="") {
		//ERROR: Company name invalid.
		push_error_response("company_name_error", "116");
	}
	//student roll numbers validation.
	if(!preg_match("/^([0-9a-z]+(\,)?)+$/i", $rollnos)) {
		//ERROR: student roll numbers invalid.
		push_error_response("rollno_numbers_error", "117");
	}
	
	if(errorsCount() == 0) {
		if(insertPlacedStudents($rollnos, $company_name)) {
			set_success_response("true");
		}
	}
	
	//closing Database connection.
	closeDb();
	
	print_response();
	
	// localhost/istian/tpo/add_placed_students.php?sessionid=tpolggd-1234&comp_name=tcs&rollnos=16kb1a05g8,16kb1a0501
?>