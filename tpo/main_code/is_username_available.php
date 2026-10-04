<?php 
	$username = trim($_POST['username']);
	
	//validating username value
	if(!isUsernameValid($username)) {
		//ERROR: username invalid.
		push_error_response("username_error", "102");
	}
	
	//if no errors proceeding with verifying username.
	if(errorsCount() == 0) {
		if(!isUsernameExists($username)) {
			set_success_response("true");
		}
		else {
			//ERROR: username already exists.
			push_error_response("username_error", "122");
		}
	}
?>