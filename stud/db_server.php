<?php
	$mysqli = "";
	
	function connectDb() {
		$host = getenv('DB_HOST');
		$user = getenv('DB_USER');
		$pass = getenv('DB_PASSWORD');
		$GLOBALS["mysqli"] = new mysqli($host, $user, $pass);
		$mysqli->set_charset("utf8mb4");
		return ($GLOBALS["mysqli"]->connect_errno==0);
	}
	
	//select database.
	function select_database($db_name) {
		$GLOBALS['mysqli']->select_db($db_name);
	}
	
	// closes database connection.
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
		$query = "select ".$details." from student where ".$cond_col."=?";
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
		$new_email = escapeForXML($new_email);
		$is_updated = Array("updated"=>null, "affected_rows"=>0);
		
		$stmt = $GLOBALS['mysqli']->stmt_init();
		$query = "UPDATE student SET
					email=?
					WHERE email=?";
		$stmt->prepare($query);
		$stmt->bind_param("ss", $new_email, $old_email);
		$is_updated["updated"] = $stmt->execute();
		$is_updated["affected_rows"] = $stmt->affected_rows;
		$stmt->close();
		
		return $is_updated;
	}
	
	//updates password
	function updatePassword($email, $pword) {
		$is_updated = Array("updated"=>null, "affected_rows"=>0);
		
		$stmt = $GLOBALS['mysqli']->stmt_init();
		$query = "UPDATE student SET
					pword=?
					WHERE email = ?";
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
		$subject = "Student Signup OTP";
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
	
	// get student placed companies.
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
	
	// gets student full details.
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
	
	// insert student asked query.
	function insert_query_with_next_max_query_index($student_rollno, $upload_id, $asked_query, $query_time) {
		$asked_query = escapeForXML($asked_query);
		$next_max_query_index = null;
		
		$stmt = $GLOBALS['mysqli']->stmt_init();
		$query = "SELECT insert_query_with_next_max_query_index(?, ?, ?, ?) as next_max_query_index;";
		$stmt->prepare($query);
		$stmt->bind_param("sssi", $upload_id, $student_rollno, $asked_query, $query_time);
		
		if($stmt->execute()) {
			$stmt->store_result();
			$stmt->bind_result($next_max_query_index);
			$stmt->fetch();
		}
		$stmt->close();
		
		return $next_max_query_index;
	}
	
	// delete student asked query.
	function delete_query($upload_id, $query_index) {
		$deleted = false;
		
		$stmt = $GLOBALS['mysqli']->stmt_init();
		$query = "delete from queries_answers where upload_id = ? and query_index = ?";
		$stmt->prepare($query);
		$stmt->bind_param("ss", $upload_id, $query_index);
		if($stmt->execute()) {
			$deleted = true;
		}
		$stmt->close();
		
		return $deleted;
	}
?>