<?php
	include("db_server.php");

	//retrive notice_by name from database.
	function noticesByNamesList() {
		$stmt = $GLOBALS['mysqli']->stmt_init();
		$query = "select notice_by_name from notices_by";
		$stmt->prepare($query);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($notice_by_name);

		$xml =  "<?xml version='1.0' encoding='utf-8'?>";
		$xml.="<notice_by_name_list>";
		while($stmt->fetch()) {
			$xml.="<notice_by_name>".$notice_by_name."</notice_by_name>";
		}
		$xml.="</notice_by_name_list>";
		
		return $xml;
	}
	
	// header("Content-type:text/xml");
	echo noticesByNamesList();
	$mysqli->close();
?>