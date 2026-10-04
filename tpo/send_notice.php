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
	$notice_heading = substr(trim($_POST['notice_heading']), 0, $ntc_headg_len);
	$notice_text = substr(trim($_POST['notice_text']), 0, $ntc_txt_len);
	$years_sel = trim($_POST['years_sel']);
	$branches_sel = trim($_POST['branches_sel']);
	$expire_time = trim($_POST['expire_time']);
	
	if($upload_id=="")
		//ERROR: upload_id is null
		push_error_response("upload_id_error", "126");
	if($notice_heading=="")
		//ERROR: notice heading is empty
		push_error_response("notice_heading_error", "127");
	if($years_sel=="")
		//ERROR: years not selected
		push_error_response("years_sel_error", "128");
	if($branches_sel=="")
		//ERROR: branches not selected
		push_error_response("branches_sel_error", "129");
	if($expire_time=="")
		//ERROR: notice expiry date is empty
		push_error_response("expire_time_error", "130");
	
	if(errorsCount() == 0) {
		$notice_by = userDetailsLogged("email", "s", $_SESSION['email'], "username")["username"];
		
		if(insertNoticeData($upload_id, $notice_heading, $notice_text, $notice_by, $expire_time, $request_time)) {
			//inserts label: years selected into database.
			insertNoticeLabels($upload_id, explode(",", $years_sel), "for_years");
			
			//inserts label: branches selected into database.
			insertNoticeLabels($upload_id, explode(",", $branches_sel), "for_branches");
			
			set_success_response("true");
		}
		else
			//ERROR: send notice failed.
			push_error_response("send_notice_error", "131");
	}
	
	print_response();
	closeDb();
	// http://localhost/istian/tpo/send_notice.php?sessionid=tpolggd-1234&request_time=1587511011&upload_id=IMRAN-1234&notice_heading=Test&notice_text=app%20testing&years_sel=III,IV&branches_sel=CSE,ECE,EEE&expire_time=1589150760
?>