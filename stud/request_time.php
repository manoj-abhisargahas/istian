<?php
	//change GET TO POST
	$request_time = "";
	if(isset($_GET['request_time'])) {
		$request_time = $_GET['request_time'];
	}
	if($request_time=="") {
		$datetime = new DateTime();
		$request_time = $datetime->getTimestamp();
	}
?>