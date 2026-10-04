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
		if($login_validate) {
			//if already logged in redirecting to index page
			header("location:../post");
			exit();
		}
	}
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
					<h1 id="account-actions-heading">Login</h1>
					<div id="account-actions-sub-heading">with authorized person's account</div>
					<form id="login-account-form" method="POST" onsubmit="return login_validate()" action="php/dologin.php">
						<div id="error-indicate"></div>
						<input id="login-email" name="login-email" type="text" placeholder="Email"/>
						<div id="error-indicate-login-email"></div>
						<input id="login-pword" name="login-pword" type="password" placeholder="Password"/>
						<div id="error-indicate-login-pword"></div>
						<input id="present-url" name="present-url" type="hidden"/>
						<div class="account-actions-switch-options">
							<a href="forgot_pword.php" id="forgot-pword">Forgot Password?</a>
							<input id="login-button" type="submit" value="Login"/>
						</div>
					</form>
				</div>
			</div>
			<!--SHADE BODY FOR DIALOGS-->
			<div id="shade-body"></div>
		</div>
		<script src="js/js.js"></script>
		<script src="js/login.js"></script>
		<?php
			//indicating: ERROR:DB Connection Error
			if(!$conn) {
				echo "<script>
					invokeDialog(\"cancel\", \"".$errors_list["100"]."\", \"cancel\", \"cancelDialog()\", \"null\", \"null\");
				</script>";
			}
			
			//indicating: ERROR:login invalid
			if(isset($_SESSION['lgerr']) && $_SESSION['lgerr']=="109") {
				echo "<script>
					msgIndicate(\"error-indicate\", true, \"".$errors_list[$_SESSION["lgerr"]]."\");
					textfieldErrorShow(\"login-email\", true);
					textfieldErrorShow(\"login-pword\", true);
				</script>";
				unset($_SESSION['lgerr']);
			}
			
			//indicating: ERROR:No account with this email
			if(isset($_SESSION['lgerr']) && $_SESSION['lgerr']=="122") {
				echo "<script>
					msgIndicate(\"error-indicate-login-email\", true, \"".$errors_list[$_SESSION["lgerr"]]."\");
					textfieldErrorShow(\"login-email\", true);
				</script>";
				unset($_SESSION['lgerr']);
			}
			
			//retaining login-email
			if(isset($_SESSION['lgemail']) && $_SESSION['lgemail']!="") {
				echo "<script>
					setValue(\"login-email\", \"".$_SESSION['lgemail']."\");
				</script>";
				unset($_SESSION['lgemail']);
			}
			
			//indicating: ERROR:login-email invalid
			if(isset($_SESSION['lgemailerr']) && $_SESSION['lgemailerr']=="114") {
				echo "<script>
					msgIndicate(\"error-indicate-login-email\", true, \"".$errors_list[$_SESSION["lgemailerr"]]."\");
					textfieldErrorShow(\"login-email\", true);
				</script>";
				unset($_SESSION['lgemailerr']);
			}

			//indicating: ERROR:login-pword invalid
			if(isset($_SESSION['lgpworderr']) && $_SESSION['lgpworderr']=="115") {
				echo "<script>
					msgIndicate(\"error-indicate-login-pword\", true, \"".$errors_list[$_SESSION["lgpworderr"]]."\");
					textfieldErrorShow(\"login-pword\", true);
				</script>";
				unset($_SESSION['lgpworderr']);
			}
		?>
	</body>
</html>