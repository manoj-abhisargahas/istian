<?php	
	if(!ConnectDb()) {
		//ERROR: Database Connection Error.
		push_error_response("db_error", "100");
		closeDb();
		print_response();
		exit();
	}
?>