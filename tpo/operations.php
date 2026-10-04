<?php 
	// error_reporting(0);
	
	//set empty response.
	function set_empty_response() {
		$GLOBALS["response"] = ["sessionid"=>"", "success_msg"=>"false", "errors_count"=>0];
	}
	
	//set sessionid.
	function set_sessionid_response($sid = "set") {
		$GLOBALS["response"]["sessionid"] = (($sid=="set")?session_id():"");
	}
	
	//get sessionid.
	function get_session_id() {
		if(isset($_POST["sessionid"])) 
			return $_POST["sessionid"];
		
		return "none";
	}
	
	//set success_msg.
	function set_success_response($msg = "") {
		$GLOBALS["response"]["success_msg"] = $msg;
	}
	
	//push info into array.
	function push_info_response($info, $info_id) {
		$GLOBALS["response"][$info] = $info_id;
	}

	//push error into response.
	function push_error_response($error, $error_id) {
		$GLOBALS["response"][$error] = $error_id;
		$GLOBALS["response"]["errors_count"]++;
	}
	
	//returns errors count.
	function errorsCount() {
		return $GLOBALS["response"]["errors_count"];
	}
	
	//prints response in JSON.
	function print_response() {
		echo json_encode($GLOBALS["response"]);
	}
	
	function isEmailValid($email) {
		return preg_match("/^.+@.+\..+$/i", $email);
	}
	function isUsernameValid($username) {
		return preg_match("/^[0-9a-z\_]{5,10}$/i", $username);
	}
	function isPasswordValid($pword) {
		return preg_match("/^[0-9a-z\_\@\#\$\&]{8,16}$/i", $pword);
	}
	
	function generateOTP() {
		return rand(100000, 999999);
	}

	function escapeForXML(string $String):string {
		return htmlspecialchars($string, ENT_QUOTES | ENT_XML1, 'UTF-8');
	}
?>