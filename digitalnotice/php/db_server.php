<?php
	//setting up connection to database.
	$host = getenv('DB_HOST');
	$user = getenv('DB_USER');
	$pass = getenv('DB_PASSWORD');
	$db = getenv('DB_NAME_DIGITAL_DB');
	$mysqli = new mysqli($host, $user, $pass, $db);
	$mysqli->set_charset("utf8mb4");
	
	if($mysqli->connect_errno) {
		push_error_msg("Connection error.");
		print_response();
		exit();
	}
	
	//set success_msg to true;
	function set_success_msg($msg) {
		$GLOBALS["response"]['success_msg'] = $msg;
	}
	
	//push errors into array.
	function push_error_msg($error_msg) {
		array_push($GLOBALS["response"]["errors"], $error_msg);
	}
	
	//prints response in JSON.
	function print_response() {
		echo json_encode($GLOBALS["response"]);
	}
	
	function category($notice_by) {
		if($notice_by=="COLLEGE" || $notice_by=="LIBRARY")
			return 1;
		if($notice_by=="CIVIL"||$notice_by=="CSE"||$notice_by=="ECE"||$notice_by=="EEE"||$notice_by=="IT"||$notice_by=="MECH")
			return 2;
	}
?>