<?php
	// echo preg_match("/^([0-9a-z]+(\,)?)+$/i", "cse,it");
	// echo preg_match("/^([0-9a-z]+(\,)?)+$/i", "1");
	// echo preg_match("/^([0-9a-z]+(\,)?)+$/i", "");
	// echo preg_match("/^([0-9a-z]+(\,)?)+$/i", "tcs, cognizant");
	// echo preg_match("/^(?<float>\d*\.?\d+)\-(?&float)$/", ".8-");
	// echo preg_match("/^(?<float>\d*\.\d+)\-(?&float)$/", "0.00-10.00");
	// echo preg_match("/^\d+$/", "1");
	
	include("session.php");
	include("operations.php");
	include("db_server.php");
	
	set_session(get_session_id());
	is_old_session();
	set_empty_response();
	set_sessionid_response();
	include("db_conn.php");
	select_database(getenv('DB_NAME_DIGITAL_DB'));
	// include("login_validate.php");
	
	$conditions_valid = true;
	$rows = [];
	
	$branches 			= format($_POST['branches']);
	$years 				= format($_POST['years']);
	$sections 			= format($_POST['sections']);
	$cgpa				= format($_POST['cgpa']);
	$backlogs 			= format($_POST['backlogs']);
	$placed_not_yet 	= format($_POST['p_notyet']);
	$placed_companies 	= format($_POST['p_companies']);
	
	function format($str) {
		return strtoupper(trim($str));
	}
	
	if(!preg_match("/^([0-9a-z]+(\,)?)+$/i", $branches)) {
		$conditions_valid = false; }
	if(!preg_match("/^([0-9a-z]+(\,)?)+$/i", $years)) {
		$conditions_valid = false; }
	if(!preg_match("/^([0-9a-z]+(\,)?)+$/i", $sections)) {
		$conditions_valid = false; }
	if(!(preg_match("/^([0-9a-z]+(\,)?)+$/i", $placed_companies) or 
			$placed_companies=="ALL" or $placed_companies=="FALSE")) {
		$conditions_valid = false; }
	if(!($placed_not_yet=="FALSE" or $placed_not_yet=="TRUE")) {
		$conditions_valid = false; } 
	if($placed_not_yet=="FALSE" and $placed_companies=="FALSE") {
		$conditions_valid = false; }
	if(!preg_match("/^(?<float>\d*\.?\d+)\-(?&float)$/", $cgpa)) {
		$conditions_valid = false; }
	if(($backlogs==null) or !(preg_match("/^\d+$/", $backlogs) or $backlogs=="FALSE")) {
		$conditions_valid = false; }
	
	//add query conditions for selected labels: branches, years, sections, placed_companies
	function addQueryConditions_ForLabel($labels, $labelname) {
		$labels = explode(",", $labels);
		$condition = "(".$labelname."='".$labels[0]."'";
		for($i = 1; $i < count($labels); $i++) {
			$condition.=" or ".$labelname."='".$labels[$i]."'";
		}
		return $condition.")";
	}
	
	if($conditions_valid) {
		$cgpa = explode("-", format($cgpa));
		$mincgpa = $cgpa[0];
		$maxcgpa = $cgpa[1];
		
		if($placed_not_yet=="TRUE" and $placed_companies=="ALL") {
			$placed_companies_query = "";
		}
		else {
			$any_company_condition = addQueryConditions_ForLabel($placed_companies, "placed_company");
			$placed_companies_query = "select distinct student_rollno from istian_db.students_placed where ";
			if($placed_companies=="ALL" or $placed_companies=="FALSE") {
				$placed_companies_query.="1";
			}
			else {
				if($placed_not_yet=="TRUE") {
					$placed_companies_query.="1 group by `student_rollno` having not `student_rollno` = any(".
												$placed_companies_query.
												$any_company_condition.")";
				}
				else if($placed_not_yet=="FALSE") {
					$placed_companies_query.=$any_company_condition;
				}
			}
		}
									
		$query = "select rollno, name from student where ".
					(($branches=="ALL")?"1":addQueryConditions_ForLabel($branches, "branch"))." and ".
					(($years=="ALL")?"1":addQueryConditions_ForLabel($years, "present_year"))." and ".
					(($sections=="ALL")?"1":addQueryConditions_ForLabel($sections, "section"))." and ".
					"(cgpa>='$mincgpa' and cgpa<='$maxcgpa') and ".
					(($backlogs=="FALSE")?"1":"backlogs<='$backlogs'")." and ".
					(($placed_companies_query=="")?"1":(($placed_not_yet=="TRUE" or $placed_companies=="FALSE")?" not ":"").
														"rollno=any($placed_companies_query)").
					" order by rollno asc";
		// echo $query;
		$result = $GLOBALS['mysqli']->query($query);
		if($result && ($result->num_rows > 0)) {
			while($row = $result->fetch_assoc()) { 
				array_push($rows, $row); 
			}
			$result->close();
		}
	}
	
	$xml =  "<?xml version='1.0' encoding='utf-8'?>";
	$xml.="<students>";
	foreach($rows as $row) {
		$xml.="<student>
			<student_rollno>".$row['rollno']."</student_rollno>
			<student_name>".$row['name']."</student_name>";
		$xml.="</student>";
	}
	$xml.="</students>";
	
	$mysqli->close();
	header("Content-type:text/xml");
	echo $xml;
	//http://localhost/istian/tpo/get_students_records_xml.php?sessionid=tpolggd-1234&branches=all&years=all&sections=all&cgpa=0.0-10&backlogs=10&p_notyet=true&p_companies=mindtree
	//select rollno, name from student where (branch='CSE') and (present_year='3' or present_year='4') and (section='A' or section='D') and (cgpa>='0' and cgpa<='10') and 1 and rollno= not any(select distinct student_rollno from istian_db.students_placed where (placed_company='TCS' or placed_company='COGNIZANT')) order by rollno asc
	?>