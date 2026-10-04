<?php
	$prefix = explode("-", session_id())[0];
	
	if($prefix=="studlggd") {
		if(!login_validate()) {
			//ERROR: session logged out.
			logout();
			push_error_response("loggedout", "115");
			print_response();
			exit();
		}
	}
?>