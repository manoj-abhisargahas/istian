<?php
		//retrive notice files from database for upload_id.
	function noticeFiles($upload_id) {
		$query = "select uploaded_file_name, uploaded_file_server_name from uploaded_files where upload_id='image-$upload_id'";
		$result = $GLOBALS['mysqli']->query($query);
		$img_info = $result->fetch_assoc();
		$result->close();
		
		$query = "select uploaded_file_name, uploaded_file_server_name from uploaded_files where upload_id='$upload_id'";
		$result = $GLOBALS['mysqli']->query($query);
		
		if($result && ($result->num_rows > 0 || ($img_info!=null && count($img_info) == 2))) {
			$GLOBALS["xml"].= "<uploaded_files>";
			if($img_info!=NULL) {
				fileinfo($img_info, "display_img");
			}
			while($row = $result->fetch_assoc()) {
				fileinfo($row, "file");
			}
			$GLOBALS["xml"].="</uploaded_files>";
		}
		
		$result->close();
	}
	
	//retrive file info which is stored in server.
	function fileinfo($fnames, $ftype_tagname) {
		$path = "../tpo/files";
		$fbasename = pathinfo($fnames['uploaded_file_name'], PATHINFO_BASENAME);
		$fext = pathinfo($fbasename, PATHINFO_EXTENSION);
		$fserverbasename = pathinfo($fnames['uploaded_file_server_name'].($fext==""?"":".".$fext), PATHINFO_BASENAME);
		$isfexist = file_exists($path."/".$fserverbasename);
		$filesize = ($isfexist)?filesize($path."/".$fserverbasename):"";
		
		$GLOBALS["xml"].="<$ftype_tagname>
			<filebasename>".$fbasename."</filebasename>
			<fileserverbasename>".$fserverbasename."</fileserverbasename>
			<isfileexist>".($isfexist?"yes":"no")."</isfileexist>
			<filesize>".$filesize."</filesize>
		</$ftype_tagname>";
	}
	
	//retrive notice labels[for_years, for_branches] from database for upload_id.
	function noticeForLabels($label, $table_name, $column_name, $upload_id) {
		$query = "select $column_name from $table_name where upload_id='$upload_id'";
		$result = $GLOBALS['mysqli']->query($query);
		
		if($result && ($result->num_rows > 0)) {
			$GLOBALS["xml"].= "<$table_name>";
			while($row = $result->fetch_assoc()) {
				$GLOBALS["xml"].="<$label>".$row[$column_name]."</$label>";
			}
			$GLOBALS["xml"].="</$table_name>";
		}
		
		$result->close();
	}
	
	//retrive notice queries from database for upload_id.
	function noticeQueries($upload_id) {
		$query = "select query_index, student_rollno, query, query_time, answered_status, tpo_username, answer, answer_time, answer_last_edited_time from queries_answers
					where upload_id='$upload_id' and (student_rollno='".$GLOBALS['rollno']."' or answered_status='PUB') ORDER BY query_time DESC, query_index DESC";
		$result = $GLOBALS['mysqli']->query($query);
		if($result && ($result->num_rows > 0)) {
			$GLOBALS["xml"].="<queries_answers>";
			while($row = $result->fetch_array()) {
				$visible_query_by = ($GLOBALS['rollno']==$row['student_rollno'])?"YOU":"STUDENT";
				
				$GLOBALS["xml"].="<query_answer>
				<query_index>".$row['query_index']."</query_index>
				<student_rollno>".$visible_query_by."</student_rollno>
				<query>".$row['query']."</query>
				<query_time>".$row['query_time']."</query_time>
				<answered_status>".$row['answered_status']."</answered_status>";
				if(!($row['answered_status']=="NO")) {
					$GLOBALS["xml"].="<tpo_username>".$row['tpo_username']."</tpo_username>
					<answer>".$row['answer']."</answer>
					<answer_time>".$row['answer_time']."</answer_time>".
					(($row['answer_last_edited_time']==null)?"":"<answer_last_edited_time>".$row['answer_last_edited_time']."</answer_last_edited_time>");
				}
				$GLOBALS["xml"].="</query_answer>";
			}
			$GLOBALS["xml"].="</queries_answers>";
		}
		
		$result->close();
	}
	
	//retrive all notices [notice_heading, notice_text, notice_by, upload_time] from database for year, branch.
	function noticesListXML() {
		$query = "select upload_id, notice_heading, notice_text, notice_by, upload_time, last_edited_time from notices 
					where upload_id = any(select fb.upload_id from for_years fy, for_branches fb 
											where (fb.upload_id = fy.upload_id) and 
												  (fy.notice_for_year = 'ALL' or fy.notice_for_year = '".$GLOBALS['present_year']."') and 
												  (fb.notice_for_branch ='ALL' or fb.notice_for_branch = '".$GLOBALS['branch']."')) and 
						  (expire_time-unix_timestamp() >= 0) ORDER BY upload_time DESC";
		$rows = [];
		$result = $GLOBALS['mysqli']->query($query);
		if($result && ($result->num_rows > 0)) {
			while($row = $result->fetch_array()) { 
				array_push($rows, $row); 
			}
			$result->close();
		}
		
		$GLOBALS["xml"].="<noticeslist>";
		foreach($rows as $row) {
			$GLOBALS["xml"].="<notice>
				<upload_id>".$row['upload_id']."</upload_id>
				<notice_heading>".$row['notice_heading']."</notice_heading>".
				(($row['notice_text']==null)?"":"<notice_text>".$row['notice_text']."</notice_text>").
				"<notice_by>".$row['notice_by']."</notice_by>
				<upload_time>".$row['upload_time']."</upload_time>".
				(($row['last_edited_time']==null)?"":"<last_edited_time>".$row['last_edited_time']."</last_edited_time>");
			noticeFiles($row['upload_id']);
			noticeForLabels("year", "for_years", "notice_for_year", $row['upload_id']);
			noticeForLabels("branch", "for_branches", "notice_for_branch", $row['upload_id']);
			noticeQueries($row['upload_id']);
			$GLOBALS["xml"].="</notice>";
		}
		$GLOBALS["xml"].="</noticeslist>";
	}
	
	//retrive a notice [notice_heading, notice_text, notice_by, upload_time] from database for upload_id.
	function noticeXML($upload_id) {
		$query = "select upload_id, notice_heading, notice_text, notice_by, upload_time, last_edited_time from notices 
					where upload_id = '".$upload_id."'";
		$row = "";
		$result = $GLOBALS['mysqli']->query($query);
		if($result && ($result->num_rows > 0)) {
			$row = $result->fetch_array();-
			$result->close();
		}
		
		$GLOBALS["xml"].="<notice>";
		if(is_array($row)) {
			$GLOBALS["xml"].="
				<upload_id>".$row['upload_id']."</upload_id>
				<notice_heading>".$row['notice_heading']."</notice_heading>".
				(($row['notice_text']==null)?"":"<notice_text>".$row['notice_text']."</notice_text>").
				".<notice_by>".$row['notice_by']."</notice_by>
				<upload_time>".$row['upload_time']."</upload_time>".
				(($row['last_edited_time']==null)?"":"<last_edited_time>".$row['last_edited_time']."</last_edited_time>");
			noticeFiles($row['upload_id']);
			noticeForLabels("year", "for_years", "notice_for_year", $row['upload_id']);
			noticeForLabels("branch", "for_branches", "notice_for_branch", $row['upload_id']);
			noticeQueries($row['upload_id']);
		}
		$GLOBALS["xml"].="</notice>";
	}
?>