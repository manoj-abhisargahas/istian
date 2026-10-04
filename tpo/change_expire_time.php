<?php
	include("request_time.php");
	include("session.php");
	include("operations.php");
	include("info.php");
	include("db_server.php");
	include("db_server_send_notices.php");
	
	set_session(get_session_id());
	is_old_session();
	set_empty_response();
	set_sessionid_response();
	include("db_conn.php");
	select_database(getenv('DB_NAME_ISTIAN_DB'));
	include("login_validate.php");
	
	$upload_id = strtoupper(trim($_POST['upload_id']));
	$expire_time = trim($_POST['expire_time']);
	
	if($upload_id=="")
		//ERROR: upload_id is null
		push_error_response("upload_id_error", "126");
		
	if($expire_time=="")
		//ERROR: upload_id is null
		push_error_response("expire_time_error", "126");
	
	$_SESSION['email'] = "imran@gmail.com";
	if(errorsCount() == 0) {
		$notice_by = userDetailsLogged("email", "s", $_SESSION['email'], "username")["username"];
		
		if(updateNoticeExpireTime($upload_id, $expire_time)["updated"]) {
			set_success_response("true");
		}
		else
			//ERROR: update expire time failed.
			push_error_response("change_expire_time_error", "138");
	}
	
	print_response();
	closeDb();
	// http://localhost/istian/tpo/change_expire_time.php?sessionid=tpolggd-1234&upload_id=IMRAN-1234&expire_time=12
?>