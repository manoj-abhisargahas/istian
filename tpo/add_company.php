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
	
	//company name validation.
	if(!preg_match("/^[0-9a-z\_]+$/i", $company_name)) {
		//ERROR: Company name invalid.
		push_error_response("company_name_error", "116");
	}
	//if company name valid then insert company name into db.
	else if(insertCompany($company_name)) {
		set_success_response("true");
	}
	
	//closing Database connection.
	closeDb();
	
	print_response();
	
	//localhost/istian/tpo/add_company.php?sessionid=tpolggd-1234&comp_name=tcs
?>