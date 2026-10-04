<?php
	include("php/session.php");
	include("php/operations.php");
	include("php/info.php");
	include("php/db_server.php");
	
	set_session(get_session_cookie());
	is_old_session();
	set_session_cookie();
	$conn = connectDb();
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
		<link rel="stylesheet" media="all and (max-device-width:320px) and (max-width:320px)" href="css/max_w_320px.css">
		<link rel="stylesheet" media="all and (max-device-width:250px) and (max-width:250px)" href="css/max_w_250px.css">
		<meta name="viewport" content="user-scalable=no, initial-scale=1, minimum-scale=1, maximum-scale=1, width=device-width, height=device-height"/>
		<meta name="theme-color" content="#eee" />
		<meta name="msapplication-navbutton-color" content="#eee" />
		<meta name="mobile-web-app-capable" content="yes" />
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
					<h1 id="account-actions-heading">Forgot Password?</h1>
					<div id="account-actions-sub-heading">Enter your account email</div>
					<form id="forgot_pword-account-form" onsubmit="return forgotPword_validate()" method="GET" action="php/reset_new_pword_link_send.php">
						<div id="error-indicate"></div>
						<input id="forgot_pword-email" name="forgot_pword-email" type="text" placeholder="Email"/>
						<div id="error-indicate-forgot_pword-email"></div>
						<div id="success-indicate"></div>
						<div class="account-actions-switch-options">
							<input id="forgot_pword-button" type="submit" value="Submit"/>
						</div>
					</form>
				</div>
			</div>
			<!--SHADE BODY FOR DIALOGS-->
			<div id="shade-body"></div>
		</div>
		<script src="js/js.js"></script>
		<script src="js/forgot_pword.js"></script>
		<?php
			if(!$conn) {
				echo "<script>
					invokeDialog(\"cancel\", \"".$errors_list["100"]."\", \"cancel\", \"cancelDialog()\", \"null\", \"null\");
				</script>";
			}
			else {
				closeDb();
			}
			
			//indicating: success sending reset pword link
			//if(isset($_SESSION['lnksend']) && $_SESSION['lnksend']=="true") {
			if(isset($_SESSION['lnksend']) && $_SESSION['lnksend']!="") {
				$tick = "<span class='tick-mark'></span>";
				$reset_pword_link = "<a class='txt-dec-retain' target='_blank' href='".$_SESSION['lnksend']."'>Password Reset Link, Click here!</a>";
				echo "<script>
					msgIndicate(\"success-indicate\", false, \"".$tick.$reset_pword_link."\");
				</script>";
				unset($_SESSION['lnksend']);
			}
			
			//indicating: ERROR:No account with this email.
			if(isset($_SESSION['lnksenderr']) && $_SESSION['lnksenderr']=="122") {
				echo "<script>
					msgIndicate(\"error-indicate-forgot_pword-email\", true, \"".$errors_list[$_SESSION["lnksenderr"]]."\");
					textfieldErrorShow(\"forgot_pword-email\", true);
				</script>";
				unset($_SESSION['lnksenderr']);
			}
			
			//retaining forgot_pword-email
			if(isset($_SESSION['fpemail']) && $_SESSION['fpemail']!="") {
				echo "<script>
					setValue(\"forgot_pword-email\", \"".$_SESSION['fpemail']."\");
				</script>";
				unset($_SESSION['fpemail']);
			}
			
			//indicating: ERROR:forgot_pword-email invalid
			if(isset($_SESSION['fpemailerr']) && $_SESSION['fpemailerr']=="114") {
				echo "<script>
					msgIndicate(\"error-indicate-forgot_pword-email\", true, \"".$errors_list[$_SESSION['fpemailerr']]."\");
					textfieldErrorShow(\"forgot_pword-email\", true);
				</script>";
				unset($_SESSION['fpemailerr']);
			}
		?>
	</body>
</html>