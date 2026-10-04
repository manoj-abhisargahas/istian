<?php	
	if(!login_validate()) {
		//ERROR: session logged out.
		logout();
		push_error_response_id("121");
		closeDb();
		print_response();
		exit();
	}
?>