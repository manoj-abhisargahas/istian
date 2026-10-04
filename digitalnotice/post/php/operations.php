<?php
	// error_reporting(0);
	
	//push parameters into array.
	// function push_param($param_name, $param_value) {
		// array_push($GLOBALS["params"], $param_name."=".$param_value);
	// }
	
	function push_param($param_name, $param_value) {
		$GLOBALS["params"][$param_name] = $param_value;
	}
	
	//set success_msg to true;
	function set_success_response($msg) {
		$GLOBALS["response"]["success_msg"] = $msg;
	}

	//push errors into array.
	function push_error_response_id($error_id) {
		array_push($GLOBALS["response"]["errors"], $error_id);
	}
	
	//set empty response.
	function set_empty_response($success_msg_key = "success_msg", $msg = false) {
		$GLOBALS["response"] = [$success_msg_key=>$msg, "errors"=>[]];
	}
	
	//returns errors count.
	function errors_count() {
		return count($GLOBALS["response"]["errors"]);
	}
	
	//print response in JSON.
	function print_response() {
		echo json_encode($GLOBALS["response"]);
	}
	
	function isEmailValid($email) {
		return preg_match("/^.+@.+\..+$/i", $email);
	}
	function isPasswordValid($pword) {
		//"/^[0-9a-z\!\@\#\$\%\&\*\_\|\-\+\=]{8,16}$/i"
		return preg_match("/^[0-9a-z\_\@\#\$\&]{8,16}$/i", $pword);
	}
	
	function generateOTP() {
		return rand(100000, 999999);
	}

	function escapeForXML(string $string):string {
		return htmlspecialchars($string, ENT_QUOTES | ENT_XML1, 'UTF-8');
	}
?>