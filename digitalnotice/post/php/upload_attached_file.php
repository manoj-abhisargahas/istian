<?php
	include("session.php");
	include("operations.php");
	include("info.php");
	include("db_server.php");
	
	set_session(get_session_cookie());
	is_old_session();
	set_session_cookie();
	set_empty_response("fileserverbasename", "");
	include("db_conn_for_async.php");
	
	$path = "../files";
	$is_file_exists = false;
	$upload_id = strtoupper(trim($_POST['upload_id']));
	
	//retriving uploaded_file - tmp_name, basename, extension.
	foreach($_FILES as $file_indx => $file) {
		$file_tmp_name = $file["tmp_name"];
		$file_basename = pathinfo($file["name"], PATHINFO_BASENAME);
		$file_ext = pathinfo($file_basename, PATHINFO_EXTENSION);
		$is_file_exists = true;
		break;
	}
	
	if($is_file_exists) {
		//generating random_server_name for uploaded_file which is not existed till now.
		while(true) {
			$rand_file_name = bin2hex(random_bytes(5));
			$rand_file_basename = pathinfo($rand_file_name.($file_ext==""?"":".".$file_ext), PATHINFO_BASENAME);
			if(!file_exists($path."/".$rand_file_basename))
				break;
		}
		
		//move uploaded_file to server and file_info to database.
		if(move_uploaded_file($file_tmp_name, $path."/".$rand_file_basename)) {
			$stmt = $mysqli->stmt_init();
			$query = "insert into uploaded_files values(?, ?, ?)";
			$stmt->prepare($query);
			$stmt->bind_param("sss", $upload_id, $file_basename, $rand_file_name);
			if($stmt->execute()) {
				$response["fileserverbasename"] = $rand_file_basename;
			}
			else {
				//ERROR:file info not uploaded into database.
				push_error_response_id("120");
			}
			$stmt->close();
		}
		else {
			//ERROR:file not uploaded into server.
			push_error_response_id("119");
		}
	}
	
	print_response();
	closeDb();
?>