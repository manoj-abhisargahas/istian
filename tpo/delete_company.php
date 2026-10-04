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
	
	$company_name = $_POST['comp_name'];
	
	if(deleteCompany($company_name)) {
		set_success_response("true");
	}
	
	//closing Database connection.
	closeDb();
	
	print_response();
	
	//localhost/istian/tpo/delete_company.php?sessionid=tpolggd-1234&comp_name=tcs
?>