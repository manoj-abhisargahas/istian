<?php
	include("db_server.php");
	
	$notice_by = strtoupper($_GET["notice_by"]);

	function noticeFiles($upload_id) {
		$query = "select uploaded_file_name, uploaded_file_server_name from uploaded_files where upload_id='image-$upload_id'";
		$result = $GLOBALS['mysqli']->query($query);
		$img_info = $result->fetch_assoc();
		$result->close();
		
		$query = "select uploaded_file_name, uploaded_file_server_name from uploaded_files where upload_id='$upload_id'";
		$result = $GLOBALS['mysqli']->query($query);
		
		$xml = "";
		if($result && ($result->num_rows > 0 || ($img_info!=null && count($img_info) == 2))) {
			$xml = "<uploaded_files>";
			if($img_info!=NULL) {
				$xml.=fileinfo($img_info, "display_img");
			}
			while($row = $result->fetch_assoc()) {
				$xml.=fileinfo($row, "file");
			}
			$xml.="</uploaded_files>";
		}
		$result->close();
		return $xml;
	}
	
	function fileinfo($fnames, $ftype_tagname) {
		$path = "../post/files";
		$fbasename = pathinfo($fnames['uploaded_file_name'], PATHINFO_BASENAME);
		$fext = pathinfo($fbasename, PATHINFO_EXTENSION);
		$fserverbasename = pathinfo($fnames['uploaded_file_server_name'].($fext==""?"":".".$fext), PATHINFO_BASENAME);
		$isfexist = file_exists($path."/".$fserverbasename);
		$filesize = ($isfexist)?filesize($path."/".$fserverbasename):"";
		
		$xml = "<$ftype_tagname>
			<filebasename>".$fbasename."</filebasename>
			<fileserverbasename>".$fserverbasename."</fileserverbasename>
			<isfileexist>".($isfexist?"yes":"no")."</isfileexist>
			<filesize>".$filesize."</filesize>
		</$ftype_tagname>";
		
		return $xml;
	}
	function noticeForLabels($label, $table_name, $column_name, $upload_id) {
		$query = "select $column_name from $table_name where upload_id='$upload_id'";
		$result = $GLOBALS['mysqli']->query($query);
		
		$xml = "";
		if($result && ($result->num_rows > 0)) {
			$xml = "<$table_name>";
			while($row = $result->fetch_assoc()) {
				$xml.="<$label>".$row[$column_name]."</$label>";
			}
			$xml.="</$table_name>";
		}
		
		$result->close();
		return $xml;
	}
	
	//retrive [notice_heading, notice_text, notice_by, notice_expire_time] from database for ntc_by.
	function noticesListXML() {
		$query = "select upload_id, notice_heading, notice_text, notice_by, upload_time from notices where notice_by='".$GLOBALS['notice_by']."' and (expire_time-unix_timestamp() >= 0) ORDER BY upload_time DESC";
		$rows = [];
		$result = $GLOBALS['mysqli']->query($query);
		if($result && ($result->num_rows > 0)) {
			while($row = $result->fetch_array()) { 
				array_push($rows, $row); 
			}
		}
		$result->close();
		
		$xml =  "<?xml version='1.0' encoding='utf-8'?>";
		$xml.="<noticeslist>";
		foreach($rows as $row) {
			$xml.="<notice>
				<upload_id>".$row['upload_id']."</upload_id>
				<notice_heading>".$row['notice_heading']."</notice_heading>".
				(($row['notice_text']==null)?"":"<notice_text>".$row['notice_text']."</notice_text>").
				"<notice_by>".$row['notice_by']."</notice_by>
				<upload_time>".$row['upload_time']."</upload_time>";
			$xml.=noticeFiles($row['upload_id']);
			$xml.=noticeForLabels("year", "for_years", "notice_for_year", $row['upload_id']);
			if(category($GLOBALS['notice_by'])==1)
				$xml.=noticeForLabels("branch", "for_branchs", "notice_for_branch", $row['upload_id']);
			if(category($GLOBALS['notice_by'])==2)
				$xml.=noticeForLabels("section", "for_sections", "notice_for_section", $row['upload_id']);
			$xml.="</notice>";
		}
		$xml.="</noticeslist>";
		
		return $xml;
	}
	
	// header("Content-type:text/xml");
	echo noticesListXML();
	$mysqli->close();
?>