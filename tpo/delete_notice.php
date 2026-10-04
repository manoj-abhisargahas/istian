<?php
	include("session.php");
	include("operations.php");
	include("db_server.php");
	
	set_session(get_session_id());
	is_old_session();
	set_empty_response();
	set_sessionid_response();
	include("db_conn.php");
	select_database(getenv('DB_NAME_ISTIAN_DB'));
	// include("login_validate.php");
	
	$upload_id = strtoupper(trim($_POST['upload_id']);
	$image_upload_id = "image-".$upload_id;
	$path = "../files";
	$rows = array();
	
	$stmt = $mysqli->stmt_init();
	$query ="select uploaded_file_name, uploaded_file_server_name
				from uploaded_files where upload_id=? or upload_id=concat('IMAGE-',?)";
	$stmt->prepare($query);
	$stmt->bind_param("ss", $upload_id, $upload_id);
	if($stmt->execute()) {
		$stmt->store_result();
		while($row = statement_fetch_assoc($stmt)) {
			$rows[] = $row;
		}
	}
	
	$query ="delete from uploaded_files where upload_id=? or upload_id=concat('IMAGE-',?)";
	$stmt->prepare($query);
	$stmt->bind_param("ss", $upload_id, $upload_id);
	$stmt->execute();
	
	$query ="delete from for_years where upload_id=?";
	$stmt->prepare($query);
	$stmt->bind_param("s", $upload_id);
	$stmt->execute();
	
	$query ="delete from for_branches where upload_id=?";
	$stmt->prepare($query);
	$stmt->bind_param("s", $upload_id);
	$stmt->execute();
	
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
	
	set_success_response("true");
	print_response();
	closeDb();
	
	//http://localhost/istian/tpo/delete_notice.php?sessionid=tpolggd-1234&upload_id=IMRAN-1234
?>