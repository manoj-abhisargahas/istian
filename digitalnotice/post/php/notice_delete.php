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
	
	$upload_id = $_POST['upload_id'];
	$image_upload_id = "image-".$upload_id;
	$path = "../files";
	$rows = array();
	
	$stmt = $mysqli->stmt_init();
	$query ="select uploaded_file_name, uploaded_file_server_name
				from uploaded_files where upload_id=? or upload_id=concat('IMAGE-',?)";
	$stmt->prepare($query);
	$stmt->bind_param("ss", $upload_id, $upload_id);
	$stmt->execute();
	$stmt->store_result();
	while($row = statement_fetch_assoc($stmt)) {
		$rows[] = $row;
	}
	
	$query ="delete from uploaded_files where upload_id=? or upload_id=concat('IMAGE-',?)";
	$stmt->prepare($query);
	$stmt->bind_param("ss", $upload_id, $upload_id);
	$stmt->execute();
	
	$query ="delete from for_years where upload_id=?";
	$stmt->prepare($query);
	$stmt->bind_param("s", $upload_id);
	$stmt->execute();
	
	if($GLOBALS["category"][$_SESSION['notice_by']]==1) {
		$query ="delete from for_branchs where upload_id=?";
		$stmt->prepare($query);
		$stmt->bind_param("s", $upload_id);
		$stmt->execute();
	}
	
	if($GLOBALS["category"][$_SESSION['notice_by']]==2) {
		$query ="delete from for_sections where upload_id=?";
		$stmt->prepare($query);
		$stmt->bind_param("s", $upload_id);
		$stmt->execute();
	}
	
	$query ="delete from notices where upload_id=?";
	$stmt->prepare($query);
	$stmt->bind_param("s", $upload_id);
	$stmt->execute();
	
	$stmt->close();
	
	foreach($rows as $row) {
		$file_basename = pathinfo($row['uploaded_file_name'], PATHINFO_BASENAME);
		$file_ext = pathinfo($file_basename, PATHINFO_EXTENSION);
		$file_server_basename = $row['uploaded_file_server_name'].(($file_ext=="")?"":".".$file_ext);
		if(file_exists($path."/".$file_server_basename))
			unlink($path."/".$file_server_basename);
	}
	
	set_success_response(true);
	print_response();
	closeDb();
?>