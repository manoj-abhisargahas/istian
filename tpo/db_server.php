<?php
	$mysqli = "";
	
	function connectDb() {
		$host = getenv('DB_HOST');
		$user = getenv('DB_USER');
		$pass = getenv('DB_PASSWORD');
		$GLOBALS["mysqli"] = new mysqli($host, $user, $pass);
		return ($GLOBALS["mysqli"]->connect_errno==0);
	}
	
	//select database.
	function select_database($db_name) {
		$GLOBALS['mysqli']->select_db($db_name);
	}
	
	function closeDb() {
		$GLOBALS["mysqli"]->close();
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
			// call_user_func_array(array($stmt, "bind_result"), $params);
			if($stmt->fetch())
				return $result;
			else
				return null;
		}
		
		return null;
	}
	
	// gets user details from database by $cond_col.
	function userDetails($cond_col, $col_type, $col_value, ...$details) {
		$user_details = null;
		$stmt = $GLOBALS['mysqli']->stmt_init();
		$details = implode(", ", $details);
		$query = "select ".$details." from tpo_info where ".$cond_col."=?";
		$stmt->prepare($query);
		$stmt->bind_param($col_type, $col_value);
		if($stmt->execute()) {
			$stmt->store_result();
			if(($no_of_users = $stmt->num_rows) == 1) {
				$user_details = statement_fetch_assoc($stmt);
			}
			$stmt->free_result();
		}
		$stmt->close();
		
		return $user_details;
	}
	
	// gets user details from database by $cond_col.
	function userDetailsLogged($cond_col, $col_type, $col_value, ...$details) {
		$user_details = null;
		$stmt = $GLOBALS['mysqli']->stmt_init();
		$details = implode(", ", $details);
		$query = "select ".$details." from tpo where ".$cond_col."=?";
		$stmt->prepare($query);
		$stmt->bind_param($col_type, $col_value);
		if($stmt->execute()) {
			$stmt->store_result();
			if(($no_of_users = $stmt->num_rows) == 1) {
				$user_details = statement_fetch_assoc($stmt);
			}
			$stmt->free_result();
		}
		$stmt->close();
		
		return $user_details;
	}
	
	//checks if username exists or not.
	function isUsernameExists($username) {
		$is_exist = false;
		
		$stmt = $GLOBALS['mysqli']->stmt_init();
		$query = "SELECT count(*) FROM tpo WHERE username=?";
		$stmt->prepare($query);
		$stmt->bind_param("s", $username);
		if($stmt->execute()) {
			$stmt->store_result();
			$stmt->bind_result($count);
			$stmt->fetch();
			$is_exist = ($count >= 1);
		}
		$stmt->close();
		return $is_exist;
	}
	
	//creates a user account in tpo table.
	function activateAccount($email, $username, $pword) {
		$activated = false;
		$username = escapeForXML($username);
		
		$stmt = $GLOBALS['mysqli']->stmt_init();
		$query = "INSERT INTO tpo VALUES(?, ?, ?)";
		$stmt->prepare($query);
		$stmt->bind_param("sss", $email, $username, $pword);
		if($stmt->execute()) {
			$activated = true;
		}
		$stmt->close();
		
		return $activated;
	}
	
	function login_validate() {
		$is_valid = false;
		
		//if no login credentials are there in present session, redirects to login.
		if(isset($_SESSION['email']) && isset($_SESSION['pword'])) {
			$email = $_SESSION['email'];
			$pword = $_SESSION['pword'];
			$is_valid = verifyPassword($email, $pword);
		}
		
		return $is_valid;
	}
	
	function verifyPassword($email, $pword) {
		$is_correct = false;
		//if login fails, redirects to login.
		$user_details_logged = userDetailsLogged("email", "s", $email, "pword");
		if(is_array($user_details_logged)) {
			if($pword==$user_details_logged['pword']) {
				$is_correct = true;
			}
		}
		
		return $is_correct;
	}
	
	//updates password.
	function updateEmail($old_email, $new_email) {
		$is_updated = Array("updated"=>null, "affected_rows"=>0);
		$new_email = escapeForXML($new_email);
		
		$stmt = $GLOBALS['mysqli']->stmt_init();
		$query = "UPDATE tpo_info SET
					email=?
					WHERE email=?";
		$stmt->prepare($query);
		$stmt->bind_param("ss", $new_email, $old_email);
		$is_updated["updated"] = $stmt->execute();
		$is_updated["affected_rows"] = $stmt->affected_rows;
		$stmt->close();
		
		return $is_updated;
	}
	
	function updateUsername($email, $username) {
		$is_updated = Array("updated"=>null, "affected_rows"=>0);
		$username = escapeForXML($username);
		
		$stmt = $GLOBALS['mysqli']->stmt_init();
		$query = "UPDATE tpo SET
					username=?
					WHERE email=?";
		$stmt->prepare($query);
		$stmt->bind_param("ss", $username, $email);
		$is_updated["updated"] = $stmt->execute();
		$is_updated["affected_rows"] = $stmt->affected_rows;
		$stmt->close();
		
		return $is_updated;
	}
	
	//updates password.
	function updatePassword($email, $pword) {
		$is_updated = Array("updated"=>null, "affected_rows"=>0);
		
		$stmt = $GLOBALS['mysqli']->stmt_init();
		$query = "UPDATE tpo SET
					pword=?
					WHERE email=?";
		$stmt->prepare($query);
		$stmt->bind_param("ss", $pword, $email);
		$is_updated["updated"] = $stmt->execute();
		$is_updated["affected_rows"] = $stmt->affected_rows;
		$stmt->close();
		
		return $is_updated;
	}
	
	//mail otp to client.
	function mailOTP($email, $otp) {
		$is_mailed = false;
		$subject = "TPO Signup OTP";
		$message = "OTP: ".$otp;
		if(mail("$email", $subject, $message)) {
			$is_mailed = true;
		}
		else {
			//ERROR: email is not accepted by delivery system.
			push_error_response("mail_otp_error", "106");
		}
		return $is_mailed;
	}
	
	function insertCompany($company_name) {
		$inserted = false;
		$company_name = escapeForXML($company_name);
		
		$stmt = $GLOBALS['mysqli']->stmt_init();
		$query = "insert into companies values(?)";
		$stmt->prepare($query);
		$stmt->bind_param("s", $company_name);
		if($stmt->execute()) {
			$inserted = true;
		}
		//DB_ERROR: #1602 - Duplicate entry 'company_name' for key 'PRIMARY'
		//ERROR: company name already exists.
		else if($stmt->errno==1062) {
			push_error_response("add_company_error", "118");
		}
		$stmt->close();
		
		return $inserted;
	}
	
	function deleteCompany($company_name) {
		$deleted = false;
		
		$stmt = $GLOBALS['mysqli']->stmt_init();
		$query = "delete from companies where company=?";
		$stmt->prepare($query);
		$stmt->bind_param("s", $company_name);
		if($stmt->execute()) {
			$deleted = true;
		}
		//DB_ERROR: #1451 - Cannot delete or update a parent row: a foreign key constraint fails
		//ERROR: company cannot be deleted.
		else if($stmt->errno==1451) {
				push_error_response("delete_company_error", "119");
		}
		$stmt->close();
		
		return $deleted;
	}
	
	function insertPlacedStudents($rollnos, $company_name) {
		$company_name = escapeForXML($company_name);
		$all_inserted = true;
		$stmt = $GLOBALS['mysqli']->stmt_init();
		$query = "insert into students_placed values(?, ?)";
		$stmt->prepare($query);
		foreach(explode(",", $rollnos) as $rollno) {
			$stmt->bind_param("ss", $rollno, $company_name);
			if(!$stmt->execute() and !($stmt->errno=="1062")) {
				array_push($GLOBALS["response"]["errrollnums"], $rollno);
				array_push($GLOBALS["response"]["errrollnums"], $stmt->errno);
				$all_inserted = false;
			}
		}
		
		$stmt->close();
		return $all_inserted;
	}
	
	function insertStudentPlacedCompany($rollno, $company_name) {
		$is_inserted = false;
		$company_name = escapeForXML($company_name);
		
		$stmt = $GLOBALS['mysqli']->stmt_init();
		$query = "insert into students_placed values(?, ?)";
		$stmt->prepare($query);
		$stmt->bind_param("ss", $rollno, $company_name);
		if($stmt->execute() || $stmt->errno=="1062") {
			$is_inserted = true;
		}
		$stmt->close();
		
		return $deleted;
	}
	
	function deleteStudentPlacedCompany($rollno, $company_name) {
		$deleted = false;
		
		$stmt = $GLOBALS['mysqli']->stmt_init();
		$query = "delete from students_placed where student_rollno=? and placed_company=?";
		$stmt->prepare($query);
		$stmt->bind_param("ss", $rollno, $company_name);
		if($stmt->execute()) {
			$deleted = true;
		}
		$stmt->close();
		
		return $deleted;
	}
	
	function getCompaniesList() {
		$companies = [];
		$query = "select company from companies order by company asc";
		$result = $GLOBALS['mysqli']->query($query);
		if($result && ($result->num_rows > 0)) {
			while($company = $result->fetch_array()) {
				array_push($companies, $company['company']);
			}
		}
		return $companies;
	}
	
	function getStudentPlacedCompanies($rollno) {
		$placed_companies = [];
		$stmt = $GLOBALS['mysqli']->stmt_init();
		$query = "select placed_company from students_placed where student_rollno=?";
		$stmt->prepare($query);
		$stmt->bind_param("s", $rollno);
		if($stmt->execute()) {
			$stmt->store_result();
			$stmt->bind_result($comp_name);
			while($stmt->fetch()) {
				array_push($placed_companies, $comp_name);
			}
			$stmt->free_result();
		}
		$stmt->close();
		return $placed_companies;
	}
	
	function getStudentDetails($rollno) {
		$student = [];
		$stmt = $GLOBALS['mysqli']->stmt_init();
		$query = "select name, rollno, present_year, branch, section, cgpa, backlogs, batch, email from student where rollno=?";
		$stmt->prepare($query);
		$stmt->bind_param("s", $rollno);
		if($stmt->execute()) {
			$stmt->store_result();
			$stmt->bind_result($student['name'], 
							$student['rollno'], 
							$student['present_year'], 
							$student['branch'], 
							$student['section'], 
							$student['cgpa'], 
							$student['backlogs'], 
							$student['batch'], 
							$student['email']);
			$stmt->fetch();
			$stmt->free_result();
		}
		$stmt->close();
		return $student;
	}
	
	function updateAnswer($upload_id, $query_index, $params) {
		$is_updated = Array("updated"=>null, "affected_rows"=>0);
		$cols = [];
		$params_type = "";
		
		if(array_key_exists('answered_status', $params)) {
			$cols[] = "answered_status=?";
			$cols_value[] = $params['answered_status'];
			$params_type.="s";
		}
		
		if(array_key_exists('tpo_username', $params)) {
			$cols[] = "tpo_username=?";
			$cols_value[] = escapeForXML($params['tpo_username']);
			$params_type.="s";
		}
		
		if(array_key_exists('answer', $params)) {
			$cols[] = "answer=?";
			$cols_value[] = escapeForXML($params['answer']);
			$params_type.="s";
		}
		
		if(array_key_exists('answer_time', $params)) {
			$cols[] = "answer_time=?";
			$cols_value[] = $params['answer_time'];
			$params_type.="i";
		}
		
		if(array_key_exists('answer_last_edited_time', $params)) {
			$cols[] = "answer_last_edited_time=?";
			$cols_value[] = $params['answer_last_edited_time'];
			$params_type.="i";
		}
		
		$cols_value[] = $upload_id;
		$params_type.="s";
		
		$cols_value[] = $query_index;
		$params_type.="i";
		
		$stmt = $GLOBALS['mysqli']->stmt_init();
		$query = "UPDATE queries_answers SET
					".implode(",", $cols)."
					WHERE upload_id = ? and query_index = ?";
		$stmt->prepare($query);
		$stmt->bind_param($params_type, ...$cols_value);
		$is_updated["updated"] = $stmt->execute();
		$is_updated["affected_rows"] = $stmt->affected_rows;
		$stmt->close();
		
		return $is_updated;
	}
?>