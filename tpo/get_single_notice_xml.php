<?php
	include("session.php");
	include("operations.php");
	include("db_server.php");
	include("db_server_get_notices_info.php");
	
	set_session(get_session_id());
	is_old_session();
	set_empty_response();
	set_sessionid_response();
	include("db_conn.php");
	select_database(getenv('DB_NAME_ISTIAN_DB'));
	// include("login_validate.php");
	
	$upload_id = strtoupper(trim($_POST["upload_id"]));
	$ud = userDetailsLogged("email", "s", $_SESSION["email"], "username");
	$username = $ud["username"];
	
	header("Content-type:text/xml");
	$xml =  "<?xml version='1.0' encoding='utf-8'?>";
	noticeXML($upload_id);
	echo $xml;
	
	//closing Database connection.
	closeDb();
	
	//http://localhost/istian/tpo/get_single_notice_xml.php?sessionid=studlggd-dlqatganq518r87deau653abts&upload_id=IMRAN-1587533897
?>