<?php
	include("session.php");
	include("operations.php");
	include("db_server.php");
	
	set_session(get_session_id());
	is_old_session();
	set_empty_response();
	set_sessionid_response();
	// include("db_conn.php");
	// select_database(getenv('DB_NAME_DIGITAL_DB'));
	include("login_validate.php");
	
	include("main_code/otp_verify.php");
	
	//closing Database connection.
	// closeDb();
	
	print_response();
	
	//http://localhost/istian/stud/otp_verify.php?sessionid=1234&otp_sessionid=otp-ax&otp=123456
	//http://localhost/istian/stud/otp_verify.php?sessionid=studlgged-1234&otp_sessionid=otp-ax&otp=123456
?>