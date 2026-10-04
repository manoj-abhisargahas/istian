<?php 
	include("php/session.php");
	include("php/operations.php");
	include("php/info.php");
	include("php/db_server.php");
	
	set_session(get_session_cookie());
	is_old_session();
	set_session_cookie();
	$conn = connectDb();
	if($conn) {
		$login_validate = login_validate();
		closeDb();
		if(!$login_validate) {
			//ERROR: session logged out.
			header("location:login.php");
			exit();
		}
	}
	$catg = $GLOBALS["category"][$_SESSION['notice_by']];
	$for_lbls_list = $GLOBALS["for_labels_list"][$catg];
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Digital Notice</title>
		<link href="v.ico" rel="icon">
		<link rel="stylesheet" href="css/items.css">
		<link rel="stylesheet" href="css/pseudo.css">
		<link rel="stylesheet" href="css/style.css">
		<link rel="stylesheet" media="all and (pointer:fine) and (hover:hover)" href="css/pointer_fine-hover_hover.css">
		<link rel="stylesheet" media="all and (pointer:fine) and (hover:hover) and (min-width:900px)" href="css/min_w_900px.css">
		<link rel="stylesheet" media="screen and (pointer:coarse) and (hover:none)" href="css/max_w_500px_with_mobility.css">
		<link rel="stylesheet" media="all and (max-width:700px), screen and (pointer:coarse) and (hover:none)" href="css/max_w_700px.css">
		<link rel="stylesheet" media="all and (max-device-width:500px) and (max-width:500px)" href="css/max_w_500px_with_mobility.css">
		<link rel="stylesheet" media="all and (max-device-width:500px) and (max-width:500px)" href="css/max_w_500px.css">
		<link rel="stylesheet" media="all and (max-device-width:410px) and (max-width:410px)" href="css/max_w_410px.css">
		<link rel="stylesheet" media="all and (max-device-width:350px) and (max-width:350px)" href="css/max_w_350px.css">
		<link rel="stylesheet" media="all and (max-device-width:320px) and (max-width:320px)" href="css/max_w_320px.css">
		<link rel="stylesheet" media="all and (max-device-width:270px) and (max-width:270px)" href="css/max_w_270px.css">
		<link rel="stylesheet" media="all and (max-device-width:250px) and (max-width:250px)" href="css/max_w_250px.css">
		<meta name="viewport" content="user-scalable=no, initial-scale=1, minimum-scale=1, maximum-scale=1, width=device-width, height=device-height"/>
		<meta name="theme-color" content="#eee" />
		<meta name="msapplication-navbutton-color" content="#eee" />
		<meta name="apple-mobile-web-app-capable" content="yes" />
		<meta name="apple-mobile-web-app-status-bar-style" content="#eee" />
	</head>
	<body>
		<input id="view-sections" type="hidden"/>
		<input id="view-ntc_img_options" type="hidden"/>
		<input id="view-ntc_sec_for_options" type="hidden"/>
		<header id="header">
			<div class="header-left">
				<div class="app-name-holder" id="app_name_holder">
					<a id="app-name" href="">
						<span id="app-name-part-digital_notice">
							<span>D</span><span>i</span><span>g</span><span>i</span><span>t</span><span>a</span><span>l</span>
							<span id="app-name-part-notice">Notice</span>
						</span>
					</a>
				</div>
				<div class="profile-holder">
					<button class="profile-button">
						<span class="by_profile dept_profile">DEPT</span>
						<span title="<?php echo $_SESSION["notice_by"]?>" id="app-name-part-notice_by"><?php echo $_SESSION["notice_by"]?></span>
					</button>
					<a href="php/logout.php" id="logout-button">Logout</a>
				</div>
			</div>
			<!--CREATE NEW POST BUTTON-->
			<div id="new_post-button" onclick="importNewPostBox_ajax(this)">
				<span class="new_post-icon">+</span>
				<span class="new_post-name">New Notice</span>
			</div>
		</header>
		<!--NOTICES VIEW-->
		<div id="notices-view-sec">
			<div id="notices-view-body"></div>
			<div id="notices-view-body-neigh"></div>
		</div>
		<!--NOTICES POST-->
		<div id="notices-post-sec">
			<div id="notices-post-body"></div>
		</div>
		<!--SHADE BODY FOR DIALOGS-->
		<div id="shade-body"></div>
<script>
window.onload = function() {
	getNoticesFromServer_Ajax();
	
	window.onscroll = headerStyling_OnScroll;
}
</script>
<?php
	//indicating: ERROR:DB Connection Error
	if(!$conn) {
		echo "<script>
			invokeDialog(\"cancel\", \"".$errors_list["100"]."\", \"cancel\", \"cancelDialog()\", \"null\", \"null\");
		</script>";
	}
?>
		<div class="app_info" style="display:none !important; visibility:hidden !important;">
			<span id="for_labels_list"><?php echo implode(",", $for_lbls_list); ?></span>
		</div>
		<script src="js/date.js"></script>
		<script src="js/js.js"></script>
		<script src="js/responsive.js"></script>
		<script src="js/getNotices.js"></script>
		<script src="js/deleteNotice.js"></script>
		<script src="js/newNotice.js"></script>
		<script src="js/attachedDisplayedImage.js"></script>
		<script src="js/attachedFiles.js"></script>
		<script src="js/sendNotice.js"></script>
	</body>
</html>