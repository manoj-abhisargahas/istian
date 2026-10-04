<?php
	include("session.php");
	include("operations.php");
	include("db_server.php");
	
	set_session($_POST["sessionid"]);
	is_old_session();
	set_empty_response();
	set_sessionid_response();
	include("db_conn.php");
	select_database(getenv('DB_NAME_DIGITAL_DB'));
	// include("login_validate.php");
	
	$ud = userDetails("email", "s", $_SESSION["email"], "rollno");
	$rollno = $ud["rollno"];
	
	$xml =  "<?xml version='1.0' encoding='utf-8'?>";
	$xml.="<student>";
	
	foreach(getStudentDetails($rollno) as $info => $info_value) {
		$xml.="<student_$info>".$info_value."</student_$info>";
	}
	
	select_database(getenv('DB_NAME_ISTIAN_DB'));
	$placed_companies = getStudentPlacedCompanies($rollno);
	if(count($placed_companies) > 0) {
		$xml.="<placed_companies>";
		foreach($placed_companies as $company => $company_name) {
			$xml.="<company>".$company_name."</company>";
		}
		$xml.="</placed_companies>";
	}
	
	
	
	$xml.="</student>";
	
	//closing Database connection.
	closeDb();
	
	header("Content-type:text/xml");
	echo $xml;
	//http://localhost/istian/student/get_student_full_details_xml.php?sessionid=studlggd-dlqatganq518r87deau653abts
?>