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
	
	$upload_id = strtoupper(trim($_GET["upload_id"]));
	$ud = userDetails("email", "s", $_SESSION["email"], "rollno");
	$rollno = $ud["rollno"];
	
	select_database(getenv('DB_NAME_ISTIAN_DB'));
	
	header("Content-type:text/xml");
	$xml =  "<?xml version='1.0' encoding='utf-8'?>";
	noticeXML($upload_id);
	echo $xml;
	
	//closing Database connection.
	closeDb();
	
	//http://localhost/istian/student/get_tpo_single_notice_xml.php?sessionid=studlggd-dlqatganq518r87deau653abts&upload_id=IMRAN-1587533897
?>