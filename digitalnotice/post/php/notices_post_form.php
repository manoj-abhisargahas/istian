<?php
	include("session.php");
	include("operations.php");
	include("info.php");
	
	set_session(get_session_cookie());
	is_old_session();
	set_session_cookie();
	//checking if session logged out/not.
	if(!isset($_SESSION['notice_by'])) {
		set_empty_response();
		push_error_response_id("121");
		print_response();
		exit();
	}
	$catg = $GLOBALS["category"][$_SESSION['notice_by']];
	$for_lbls_list = $GLOBALS["for_labels_list"][$catg];
?>
<form id="notices-post-form" method="POST" enctype="multipart/form-data">
	<?php
	include("new_notice_sec/notice_sec_cancel.php");
	?>
	<!--NOTICE SCROLLABLE SOME SECTIONS-->
	<div id="notice-some-sections">
		<div id="supp-notice-some-sections">
			<?php
			include("new_notice_sec/notice_sec_heading.php");
			?>
			<!--SECTIONS SEPERATOR-->
			<div id="bottom_border-notice_heading"></div>
			<?php
			include("new_notice_sec/notice_sec_text.php");
			include("new_notice_sec/notice_sec_image.php");
			include("new_notice_sec/notice_sec_files.php");
			?>
		</div>
	</div>
	<?php
	include("new_notice_sec/notice_sec_by.php");
	include("new_notice_sec/notice_sec_for.php");
	include("new_notice_sec/notice_sec_post.php");
	?>
	<!--FROM BLACK COVER-->
	<input id="form_black_cover" type="checkbox" style="display:none"/>
	<label class="cursor-pointer" id="label-form_black_cover"></label>
</form>