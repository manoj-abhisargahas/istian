<!--NOTICE HEADING-->
<label class="cursor-pointer" id="notice-sec-heading" for="notice_heading_field">
	<input id="required-notice_heading_field" name="required-notice_heading_field" type="checkbox" style="display:none;">
	<div id="label-required-notice_heading_field"></div>
	<textarea id="notice_heading_field" rows="1" placeholder="Notice Heading" 
	oninput="requiredIndication_Hide(this); replaceNewLineWithNull(this)">Greetings For New Year!</textarea>
</label>
<label class="cursor-pointer text-count" for="notice_heading_field">
	<span id="n_h_f-text-count">0</span>/<span id="n_h_f-total-text-count"><?php echo $ntc_headg_len ?></span>
</label>