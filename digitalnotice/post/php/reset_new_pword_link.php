<?php
	include("session.php");
	include("info.php");
	include("db_server.php");
	
	//getting rnpid and setting as sessionid.
	set_session($_GET['rnpid']);
	is_link_session_expired($GLOBALS["reset_new_pword_link_life_time"], 0);
	$conn = ConnectDb();
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Digital Notice</title>
		<link href="../v.ico" rel="icon">
		<link rel="stylesheet" href="../css/items.css">
		<link rel="stylesheet" href="../css/pseudo.css">
		<link rel="stylesheet" href="../css/style.css">
		<link rel="stylesheet" media="all and (pointer:fine) and (hover:hover)" href="css/pointer_fine-hover_hover.css">
		<link rel="stylesheet" media="all and (pointer:fine) and (hover:hover) and (min-width:900px)" href="css/min_w_900px.css">
		<link rel="stylesheet" media="screen and (pointer:coarse) and (hover:none)" href="css/max_w_500px_with_mobility.css">
		<link rel="stylesheet" media="all and (max-width:700px), screen and (pointer:coarse) and (hover:none)" href="css/max_w_700px.css">
		<link rel="stylesheet" media="all and (max-device-width:500px) and (max-width:500px)" href="css/max_w_500px_with_mobility.css">
		<link rel="stylesheet" media="all and (max-device-width:500px) and (max-width:500px)" href="css/max_w_500px.css">
		<link rel="stylesheet" media="all and (max-device-width:410px) and (max-width:410px)" href="css/max_w_410px.css">
		<link rel="stylesheet" media="all and (max-device-width:320px) and (max-width:320px)" href="css/max_w_320px.css">
		<link rel="stylesheet" media="all and (max-device-width:250px) and (max-width:250px)" href="css/max_w_250px.css">
		<meta name="viewport" content="user-scalable=no, initial-scale=1, minimum-scale=1, maximum-scale=1, width=device-width, height=device-height"/>
		<meta name="theme-color" content="#eee" />
		<meta name="msapplication-navbutton-color" content="#eee" />
		<meta name="apple-mobile-web-app-capable" content="yes" />
		<meta name="apple-mobile-web-app-status-bar-style" content="#eee" />
	</head>
	<body>
		<div id="main-body">
			<header>
				<title>Digital Notice</title>
			</header>
			<div id="account-actions">
				<div id="app-name-head">
					<span id="app-name-part-digital_notice">
						<span>D</span><span>i</span><span>g</span><span>i</span><span>t</span><span>a</span><span>l</span>
						<span id="app-name-part-notice">Notice</span>
					</span>
				</div>
				<div id="account-actions-main-body">
					<h1 id="account-actions-heading">Reset New Password</h1>
					<form id="reset_new_pword-account-form" onsubmit="return resetNewPword_validate()" method="POST" action="reset_new_pword.php">
						<div id="error-indicate"></div>
						<input id="reset_new_pword-pword" name="reset_new_pword-pword" type="text" name="" placeholder="New Password"/>
						<div id="error-indicate-reset_new_pword-pword"></div>
						<input id="reset_new_pword-retype_pword" type="text" placeholder="Retype Password"/>
						<div id="error-indicate-reset_new_pword-retype_pword"></div>
						<input id="rnpid" name="rnpid" type="hidden" value="<?php echo $_GET["rnpid"]?>"/>
						<div id="account-actions-info">
							<span class="help-symbol">?</span>Password must contain 8 to 16 characters:
							<span class="padding-symbol">&nbsp;</span>Alphabets, Digits, Symbols<span class="symbols">_@#$& </span>
						</div>
						<div class="account-actions-switch-options">
							<input id="reset_new_pword-button" type="submit" value="Done"/>
						</div>
					</form>
				</div>
			</div>
			<!--SHADE BODY FOR DIALOGS-->
			<div id="shade-body"></div>
		</div>
		<script src="../js/js.js"></script>
		<script src="../js/reset_new_pword_link.js"></script>
		<?php
			if(!$conn) {
				echo "<script>
					invokeDialog(\"cancel\", \"".$errors_list["100"]."\", \"cancel\", \"cancelDialog()\", \"null\", \"null\");
				</script>";
			}
			else {
				closeDb();
			}
			
			//indicating: ERROR:Password update failed.
			if(isset($_SESSION['rnperr']) && $_SESSION['rnperr']=="113") {
				echo "<script>
					msgIndicate(\"error-indicate\", true, \"".$errors_list[$_SESSION["rnperr"]]."\");
				</script>";
				unset($_SESSION['rnperr']);
			}
			
			//indicating: ERROR:reset_new_pword-email invalid
			if(isset($_SESSION['rnppworderr']) && $_SESSION['rnppworderr']=="115") {
				echo "<script>
					msgIndicate(\"error-indicate-reset_new_pword-pword\", true, \"".$errors_list[$_SESSION["rnppworderr"]]."\");
					textfieldErrorShow(\"reset_new_pword-pword\", true);
				</script>";
				unset($_SESSION['rnppworderr']);
			}
		?>
	</body>
</html>