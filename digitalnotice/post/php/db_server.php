<?php
	$mysqli = "";
	
	function connectDb() {
		$host = getenv('DB_HOST');
		$user = getenv('DB_USER');
		$pass = getenv('DB_PASSWORD');
		$db = getenv('DB_NAME_DIGITAL_DB');
		$GLOBALS["mysqli"] = new mysqli($host, $user, $pass, $db);
		return ($GLOBALS["mysqli"]->connect_errno==0);
	}
	
	function closeDb() {
		$GLOBALS["mysqli"]->close();
	}
	
	function redirectWithDBError($url) {
		header("location:".$url."?dberr=100");
		exit();
	}
	
	//fetch result as association array for statement object.
	function statement_fetch_assoc($stmt) {
		if($stmt->num_rows > 0) {
			$result = array();
			$params = array();
			$fields = $stmt->result_metadata();
			while($field = $fields->fetch_field()) {
				$params[] = &$result[$field->name];
			}	
			$stmt->bind_result(...$params);
			call_user_func_array(array($stmt, "bind_result"), $params);
			if($stmt->fetch())
				return $result;
			else
				return null;
		}
		
		return null;
	}
	
	function userDetails($email) {
		$query = "select notice_by_name, notice_by_email, notice_by_pword from notices_by where notice_by_email='$email'";
		$result = $GLOBALS['mysqli']->query($query);
		if($result->num_rows == 1) {
			$row = $result->fetch_assoc();
			return $row;
		}
		return null;
	}
	
	function login_validate() {
		$validate = false;
		
		//if no login credentials are there in present session, redirects to login.
		if(isset($_SESSION['email']) && isset($_SESSION['pword'])) {
			$email = $_SESSION['email'];
			$pword = $_SESSION['pword'];
			
			//if login fails, redirects to login.
			$user_details = userDetails($email);
			if(is_array($user_details)) {
				if($pword==$user_details['notice_by_pword']) {
					$GLOBALS["notice_by"] = $user_details['notice_by_name'];
					$validate = true;
				}
			}
		}
		
		return $validate;
	}
	
	//updates noticer password
	function updatePassword($email, $pword) {
		$is_updated = Array("updated"=>null, "affected_rows"=>0);
		
		$stmt = $GLOBALS['mysqli']->stmt_init();
		$query = "UPDATE notices_by SET
					notice_by_pword=?
					WHERE notice_by_email = ?";
		$stmt->prepare($query);
		$stmt->bind_param("ss", $pword, $email);
		$is_updated["updated"] = $stmt->execute();
		$is_updated["affected_rows"] = $stmt->affected_rows;
		$stmt->close();
		
		return $is_updated;
	}
?>