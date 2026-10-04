<?php
	//inserts [notice_heading, notice_text, notice_by, expire_time] into database.
	function insertNoticeData($upload_id, $notice_heading, $notice_text, $notice_by, $expire_time, $upload_time) {
		$is_inserted = false;
		$notice_heading = escapeForXML($notice_heading);
		$notice_text = escapeForXML($notice_text);
		
		$stmt = $GLOBALS['mysqli']->stmt_init();
		$query = "insert into notices(upload_id, notice_heading, notice_text, notice_by, expire_time, upload_time) 
					values(?, ?, ?, ?, ?, ?)";
		$stmt->prepare($query);
		$stmt->bind_param("ssssii", $upload_id, 
								    $notice_heading, 
								    $notice_text, 
								    $notice_by,  
								    $expire_time,
								    $upload_time);
		if($stmt->execute()) {
			$is_inserted = true;
		}
		else{
			
			echo $stmt->error;
		}
		$stmt->close();

		return $is_inserted;
	}
	
	//updates [notice_heading, notice_text, notice_by, expire_time] in database.
	function updateNoticeData($upload_id, $notice_heading, $notice_text, $edited_time) {
		$is_updated = Array("updated"=>null, "affected_rows"=>0);
		$notice_heading = escapeForXML($notice_heading);
		$notice_text = escapeForXML($notice_text);

		$stmt = $GLOBALS['mysqli']->stmt_init();
		$query = "update notices set notice_heading=?,
									 notice_text=?, 
									 last_edited_time=?
					where upload_id=?";
		$stmt->prepare($query);
		$stmt->bind_param("ssis", $notice_heading, 
								  $notice_text,
								  $edited_time,
								  $upload_id);					   
		$is_updated["updated"] = $stmt->execute();
		$is_updated["affected_rows"] = $stmt->affected_rows;
		$stmt->close();

		return $is_updated;
	}
	
	//updates [notice_heading, notice_text, notice_by, notice_expiry_date] in database.
	function updateNoticeExpireTime($upload_id, $expire_time) {
		$is_updated = Array("updated"=>null, "affected_rows"=>0);

		$stmt = $GLOBALS['mysqli']->stmt_init();
		$query = "update notices set expire_time=?
					where upload_id=?";
		$stmt->prepare($query);
		$stmt->bind_param("is", $expire_time,
								  $upload_id);					   
		$is_updated["updated"] = $stmt->execute();
		$is_updated["affected_rows"] = $stmt->affected_rows;
		$stmt->close();

		return $is_updated;
	}
	
	//inserts notice labels like for: years, branches
	function insertNoticeLabels($upload_id, $labels_sel, $label_table) {
		$is_inserted = false;
		
		$stmt = $GLOBALS['mysqli']->stmt_init();
		$query = "insert into ".$label_table." values(?, ?)";
		$stmt->prepare($query);
		foreach($labels_sel as $label) {
			$label = strtoupper(trim($label));
			$stmt->bind_param("ss", $upload_id, $label);
			if($stmt->execute()) {
				$is_inserted = true;
			}
		}
		$stmt->close();

		return $is_inserted;
	}
	
	//deletes notice labels like for: years, branches
	function deleteNoticeLabels($upload_id, $label_table) {
		$is_deleted = false;
		$stmt = $GLOBALS['mysqli']->stmt_init();
		$query = "delete from ".$label_table." where upload_id=?";
		$stmt->prepare($query);
		$stmt->bind_param("s", $upload_id);
		if($stmt->execute()) {
			$is_deleted = true;
		}
		$stmt->close();
		
		return $is_deleted;
	}
?>