<?php
	$normal_sess_life_time	= 60 * 60 * 24; // 1 day
	$logged_sess_recreate_id_time = 60 * 30; // 15minutes
	$otp_max_active_time	= 60 * 15; // 15 minutes
	
	function set_session($sessionid = "none") {
		ini_set('session.use_strict_mode', 0);
		//get session_id if sended-by-user or setted.
		if($sessionid!="none")
			session_id($sessionid);
		
		//start session.
		session_start();
		
		//updating last_active_time for sessions.
		$_SESSION["last_active_time"] = time();
		
		//setting created_time for new sessions.
		if(!isset($_SESSION["created_time"]) ||
			empty($_SESSION["created_time"])) {
			$_SESSION["created_time"] = $_SESSION["last_active_time"];
		}
	}
	
	function is_old_session() {
		$prefix = explode("-", session_id())[0];
		
		//for login session:
		if($prefix=="tpolggd") {
			//if recreated_time is old (>30 min) then recreate session_id
			//but without losing present session data.
			if(!isset($_SESSION["recreated_time"]) ||
			  empty($_SESSION["recreated_time"])) {
				session_destroy();
			}
			else if(time()-$_SESSION["recreated_time"] > $GLOBALS["logged_sess_recreate_id_time"]) {
				create_session_id("tpolggd");
			}
		}
		//for normal sessions:
		else if($prefix=="") {
			//if created_time is (>1 day) then destroy and start new session.
			if(!isset($_SESSION["created_time"]) ||
			  empty($_SESSION["created_time"]) ||
			 (time()-$_SESSION["created_time"] > $GLOBALS["normal_sess_life_time"])) {
				logout();
			}
		}
	}
	
	function create_session_id($prefix = "none") {
		//has to regenerate new_session_id if session_status = active.
		if(session_status()!==PHP_SESSION_ACTIVE)
			session_start();
		
		//store present_session values.
		$sess_arr = $_SESSION;
		//ends the present session but save old data.
		session_commit();
		
		ini_set('session.use_strict_mode', 0);
		$prefix.=($prefix=="none"?"":"-");
		session_id(session_create_id($prefix));
		session_start();
		
		//restore present_session(replaced with new session_id) values.
		$_SESSION = $sess_arr;
		
		$_SESSION["recreated_time"] = time();
		//setting created_time for new sessions.
		if(!isset($_SESSION["created_time"]) ||
			empty($_SESSION["created_time"])) {
			$_SESSION["created_time"] = $_SESSION["recreated_time"];
		}
	}
	
	function is_link_session_expired($time) {
		//checking expiry time for link.
		if(!isset($_SESSION["recreated_time"]) ||
		  empty($_SESSION["recreated_time"]) ||
		 (time()-$_SESSION["recreated_time"] > $time)) {
			 session_destroy();
			return true;
		}
		return false;
	}
	
	function logout() {
		session_destroy();
		set_session("");
	}
?>