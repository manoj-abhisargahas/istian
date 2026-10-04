<?php
	$ntc_headg_len = 200;
	$ntc_txt_len = 500;
	
	// function category($notice_by) {
		// $notice_by = strtoupper($notice_by);
		// if($notice_by=="COLLEGE"||$notice_by=="LIBRARY")
			// return 1;
		// if($notice_by=="CIVIL"||$notice_by=="CSE"||$notice_by=="ECE"||$notice_by=="EEE"||$notice_by=="IT"||$notice_by=="MECK")
			// return 2;
	// }
	
	$category = [
	"COLLEGE"=>1,
	"LIBRARY"=>1,
	"CIVIL"=>2,
	"CSE"=>2,
	"ECE"=>2,
	"EEE"=>2,
	"IT"=>2,
	"MECH"=>2
	];
	
	$for_labels_list = [
	1=>["year", "branch"],
	2=>["year", "section"]
	];
	
	$errors_list = [
	"000"=>"Application Crashed.",
	"100"=>"Database Connection Failed.",
	"101"=>"",
	"102"=>"",
	"103"=>"",
	"104"=>"",
	"105"=>"",
	"106"=>"",
	"107"=>"",
	"108"=>"Data not uploaded into database.",
	"109"=>"Login Invalid.",
	"110"=>"Your email is not associated with the college as authorized.",
	"111"=>"Wrong OTP.",
	"112"=>"OTP Expired.",
	"113"=>"Password update failed.",
	"114"=>"Email Invalid.",
	"115"=>"Password Invalid.",
	"116"=>"Link send failed.",
	"117"=>"File not found in server.",
	"118"=>"File info not deleted from database.",
	"119"=>"File not uploaded into server.",
	"120"=>"File info not uploaded into database.",
	"121"=>"Session Logged Out.",
	"122"=>"No account with this email."
	];
?>