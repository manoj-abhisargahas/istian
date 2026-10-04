<?php
	include("session.php");
	include("operations.php");
	include("info.php");
	include("db_server.php");
	
	set_session(get_session_cookie());
	is_old_session();
	set_session_cookie();
	set_empty_response();
	include("db_conn_for_async.php");
	include("login_validate_for_async.php");
	
	$is_notice_inserted = true;
	$upload_id = strtoupper(trim($_POST['upload_id']));
	$notice_heading = substr(trim($_POST['notice_heading']), 0, $ntc_headg_len);
	$notice_text = substr(trim($_POST['notice_text']), 0, $ntc_txt_len);
	// $years_sel = trim($_POST['years_sel']);
	$notice_expiry_date = $_POST['notice_expiry_date'];
	
	if($upload_id=="")
		//ERROR: upload_id is null
		push_error_response_id("101");
	if($notice_heading=="")
		//ERROR: notice heading is empty
		push_error_response_id("102");
	
	$catg = $GLOBALS["category"][$_SESSION['notice_by']];
	$for_lbls_list = $GLOBALS["for_labels_list"][$catg];
	$for_labels_sel = [];
	for($indx = 0; $indx < count($for_lbls_list); $indx++) {
		$for_label_sel = trim($_POST[$for_lbls_list[$indx]."s_sel"]);
		if($for_label_sel=="")
			push_error_response_id($for_lbls_list[$indx]);
		else
			$for_labels_sel[$for_lbls_list[$indx]] = $for_label_sel;
	}
	
	if($notice_expiry_date=="")
		//ERROR: notice expiry date is empty
		push_error_response_id("107");
	
	//insert [notice_heading, notice_text, notice_by, notice_expiry_date] into database.
	function insertNoticeData($upload_id, $notice_heading, $notice_text, $notice_by, $notice_expiry_date) {
		$upload_id = $upload_id;
		$notice_heading = escapeForXML($notice_heading);
		$notice_text = escapeForXML($notice_text);
		$notice_by = $notice_by;
		$notice_expiry_date = $notice_expiry_date;

		$stmt = $GLOBALS['mysqli']->stmt_init();
		$query = "insert into notices values(?, ?, ?, ?, UNIX_TIMESTAMP(?), UNIX_TIMESTAMP())";
		$stmt->prepare($query);
		$stmt->bind_param("sssss", $upload_id, 
								   $notice_heading, 
								   $notice_text, 
								   $notice_by, 
								   $notice_expiry_date);
		if(!$stmt->execute()) {
			$GLOBALS['is_notice_inserted'] = false;
		}
		$stmt->close();
	}
	
	//insert notice labels like for: years, branchs
	function insertNoticeLabels($upload_id, $labels_sel, $label_table) {
		$upload_id = escapeForXML($upload_id);

		$stmt = $GLOBALS['mysqli']->stmt_init();
		$query = "insert into ".$label_table." values(?, ?)";
		$stmt->prepare($query);
		foreach($labels_sel as $label) {
			$label = strtoupper(trim($label));
			$stmt->bind_param("ss", $upload_id, $label);
			$stmt->execute();
		}
		$stmt->close();
	}
	
	if(count($response['errors']) == 0) {
		insertNoticeData($upload_id, 
						$notice_heading, 
						$notice_text, 
						$_SESSION['notice_by'], 
						$notice_expiry_date);
		
		if($is_notice_inserted) {
			for($indx = 0; $indx < count($for_lbls_list); $indx++) {
				insertNoticeLabels($upload_id, 
								explode(",", $for_labels_sel[$for_lbls_list[$indx]]), 
								"for_".$for_lbls_list[$indx]."s");
			}
			
			set_success_response(true);
		}
		else
			//ERROR: data not uploaded into database
			push_error_response_id("108");
	}
	
	print_response();
	closeDb();
?>