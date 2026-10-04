<?php
	include("session.php");
	include("operations.php");
	include("db_server.php");
	include("db_server_get_notices_info.php");
	
	set_session($_POST["sessionid"]);
	is_old_session();
	set_empty_response();
	set_sessionid_response();
	include("db_conn.php");
	select_database(getenv('DB_NAME_DIGITAL_DB'));
	// include("login_validate.php");
	
	$ud = userDetails("email", "s", $_SESSION["email"], "rollno", "present_year", "branch");
	$rollno = $ud["rollno"];
	$present_year = $ud["present_year"];
	$branch = $ud["branch"];
	
	select_database(getenv('DB_NAME_ISTIAN_DB'));
	
	header("Content-type:text/xml");
	$xml =  "<?xml version='1.0' encoding='utf-8'?>";
	noticesListXML();
	echo $xml;
	
	//closing Database connection.
	closeDb();
	
	//http://localhost/istian/student/get_tpo_notices_xml.php?sessionid=studlggd-dlqatganq518r87deau653abts
?>