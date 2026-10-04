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
	
	$_SESSION['email'] = "imran@gmail.com";
	if(errorsCount() == 0) {
		
		if(updateNoticeData($upload_id, $notice_heading, $notice_text, $request_time)["updated"]) {
			//deletes label: years from database.
			deleteNoticeLabels($upload_id, "for_years");
			
			//deletes label: branches from database.
			deleteNoticeLabels($upload_id, "for_branches");
			
			//inserts label: years selected into database.
			insertNoticeLabels($upload_id, explode(",", $years_sel), "for_years");
			
			//inserts label: branches selected into database.
			insertNoticeLabels($upload_id, explode(",", $branches_sel), "for_branches");
			
			set_success_response("true");
		}
		else
			//ERROR: edit notice failed.
			push_error_response("edit_notice_error", "132");
	}
	
	print_response();
	closeDb();
	// http://localhost/istian/tpo/edit_notice.php?sessionid=tpolggd-1234&request_time=1587521025&upload_id=IMRAN-1234&notice_heading=Test1&notice_text=app%20testing&years_sel=III,IV&branches_sel=CSE,ECE,EEE
?>