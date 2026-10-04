<!DOCTYPE html>
<html>
<head>
	<style>
		body {
			margin: 0;
		}
		.outer-container {
			width: 1000px;
			position: absolute;
		}
		.main-container {
			width: 100%;
			padding-top: 100%;
			position: relative;
		}
		.main-container > *{
			position: absolute;
			top: 0;
			right: 0;
			bottom: 0;
			left: 0;
		}
	</style>
</head>
<body style="margin:0;">
<div class="outer-container">
<div class="main-container" >
	<?php include("dotted_rectangle.svg") ;?>
</div>
</div>
</body>
</html>