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
	
	$path = "../files";
	$upload_id = strtoupper(trim($_POST['upload_id']));
	$file_server_basename = pathinfo($_POST["fileserverbasename"], PATHINFO_BASENAME);
	
	$file_server_name = pathinfo($file_server_basename, PATHINFO_FILENAME);
	
	$query = "delete from uploaded_files where upload_id='$upload_id' and uploaded_file_server_name='$file_server_name'";
	if($mysqli->query($query)) {
		set_success_response("true");
		
		//deletes file in the server
		if(file_exists($path."/".$file_server_basename))
			unlink($path."/".$file_server_basename);
	}
	else {
		//ERROR:file not deleted from database.
		push_error_response("delete_file_error", "118");
	}
	
	print_response();
	closeDb();
	// http://localhost/istian/tpo/delete_attached_file.php?sessionid=tpolggd-1234&upload_id=IMRAN-1234&fileserverbasename=abcdefgh.jpg
?>