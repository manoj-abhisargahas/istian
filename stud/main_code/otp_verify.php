<?php
	$otp = trim($_POST['otp']);
	
	if($otp=="") {
		//ERROR: otp empty.
		push_error_response("otp_error", "142");
	}
	
	if(errorsCount()==0) {
		$otp_session = trim($_POST["otp_sessionid"]);
		set_session($otp_session);
		
		//checking if OTP expired or not.
		if(!is_link_session_expired($GLOBALS["otp_max_active_time"])) {
			
			//checking if OTP correct or not.
			if($otp==$_SESSION["otp"]) {
				set_success_response("true");
				session_destroy();
			}
			else {
				//ERROR: Wrong OTP.
				push_error_response("otp_error", "107");
			}
		}
		else {
			//ERROR: OTP Expired.
			push_error_response("otp_error", "109");
		}
	}
?>