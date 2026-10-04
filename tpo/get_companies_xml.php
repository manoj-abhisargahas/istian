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
	
	$xml =  "<?xml version='1.0' encoding='utf-8'?>";
	$xml.="<companies>";
	foreach(getCompaniesList() as $company => $company_name) {
		$xml.="<company>".$company_name."</company>";
	}
	$xml.="</companies>";
	
	//closing Database connection.
	closeDb();
	
	header("Content-type:text/xml");
	echo $xml;
	//http://localhost/istian/tpo/get_companies_xml.php?sessionid=tpolggd-1234
?>