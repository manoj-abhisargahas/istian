<?php
	include("session.php");
	include("db_server.php");
	
	set_session(get_session_id());
	is_old_session();
	set_empty_response();
	set_sessionid_response();
	include("db_conn.php");
	select_database(getenv('DB_NAME_ISTIAN_DB'));
	include("login_validate.php");
	
	include("main_code/is_username_availabe.php");
	
	//closing Database connection.
	closeDb();
	
	print_response();
	
	//localhost/istian/tpo/is_username_available.php?sessionid=tpolggd-1234&username=vishnu
?>