<!--NOTICE IMAGE-->
<div id="notice-sec-image">
	<div id="notice-image-align-box">
		<input id="notice_image_button" name="notice_image_button" 
			type="file" accept="image/*" 
			oninput="loadNoticeImage(event)" style="display: none"/>
		<label class="cursor-pointer" id="notice_image_viewer" for="notice_image_button">
			<div id="notice_image_button_adj">
				<?php include("html/rectangle.html"); ?>
				<div id="notice_image_button_icon" ></div>
				<span id="notice_image_button_name">Upload Notice Image</span>
			</div>
			<img id="notice_image"/>
		</label>
		<div id="notice_image_adj"></div>
		<progress id="progress-uploaded_image"></progress>
		<div id="notice_image_manipulate_buttons">
			<label class="cursor-pointer" id="label-change_notice_image_button" for="notice_image_button">
				<div id="change_notice_image_button_icon"></div>
			</label>
			<label class="cursor-pointer" id="label-delete_notice_image_button" onclick="deleteImageFromServer_Ajax(img_file_indx)">
				<div id="delete_notice_image_button_icon"></div>
			</label>
		</div>
	</div>
	<div id="notice_image_visible_bottom_calculate_ele"></div>
</div>