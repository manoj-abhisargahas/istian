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
	
	$rollno = $_POST['rollno'];
	
	$xml =  "<?xml version='1.0' encoding='utf-8'?>";
	$xml.="<student>";
	
	$placed_companies = getStudentPlacedCompanies($rollno);
	if(count($placed_companies) > 0) {
		$xml.="<placed_companies>";
		foreach($placed_companies as $company => $company_name) {
			$xml.="<company>".$company_name."</company>";
		}
		$xml.="</placed_companies>";
	}
	
	select_database(getenv('DB_NAME_DIGITAL_DB'));
	foreach(getStudentDetails($rollno) as $info => $info_value) {
		$xml.="<student_$info>".$info_value."</student_$info>";
	}
	
	$xml.="</student>";
	
	//closing Database connection.
	closeDb();
	
	header("Content-type:text/xml");
	echo $xml;
	//http://localhost/istian/tpo/get_student_full_details_xml.php?sessionid=tpolggd-1234&rollno=16kb1a05h3
?>