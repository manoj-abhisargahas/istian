<!--NOTICE EXPIRE_DATE AND POST -->
<div id="notice-sec-post">
	<input id="required-notice_expiry_date" name="required-notice_expiry_date" type="checkbox" style="display:none">
	<input id="visibility-notice_expiry_date" name="visibility-notice_expiry_date" type="checkbox" style="display:none" oninput="formBlackCover_VisibilityBehind(this)">
	<label class="cursor-pointer" id="label-visibility-notice_expiry_date-enabled" for="visibility-notice_expiry_date">
	<?php include("../images/expire_time_icon(passive).svg"); ?>
	</label>
	<div id="label-visibility-notice_expiry_date-disabled">
		<?php include("../images/expire_time_icon(passive).svg"); ?>
	</div>
	<div id="notice_expiry_date">
		<div id="notice_expiry_date-name"><span id="ned-name-select">Select </span>Expire Date<span id="ned-name-colon">:</span></div>
		<input id="new_notice-expired_indicator" type="checkbox" style="display:none" />
		<div id="holder-notice_expiry_date_field">
			<div id="datetext-notice_expiry_date_field">Select date</div>
			<div class="calendar_icon"></div>
			<input id="notice_expiry_date_field" type="date" oninput="onDateSelect(this, 'datetext-notice_expiry_date_field')"/>
		</div>
		<span id="notice_expiry_date-info">Notice invisible to others from expire date onwards.</span>
		<label class="cursor-pointer" id="notice_expiry_date-cancel" for="visibility-notice_expiry_date"><span class="wrong_icon">+</span></label>
	</div>
	<div id="label-post_notice_button" onclick="sendNotice()">
		<span id="post_notice_button_name">POST</span>
		<div id="post_notice_button_icon"></div>
	</div>
</div>