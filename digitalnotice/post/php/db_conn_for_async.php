<?php	
	if(!ConnectDb()) {
		//ERROR: Database Connection Error.
		push_error_response_id("100");
		closeDb();
		print_response();
		exit();
	}
?>