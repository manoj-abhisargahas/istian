<!--NOTICE FOR-->
<div id="notice-sec-for">
	<div id="labels_visible_section">
		<input id="for_labels_closer" type="checkbox" style="display:none"/>
		<label class="cursor-pointer" id="label-for_labels_closer">
			<span class="top_down_arrow"></span>
		</label>
	<?php
	for($indx = 0; $indx < count($for_lbls_list); $indx++) {
		include("html/for_".$for_lbls_list[$indx]."s.html");
	}
		?>
	</div>
	<div id="new_notice-options-tool-bar">
		<div id="new_notice-options-group-1">
			<div class="holder-for_label_icon">
			<?php 
				include("../images/label_icon.svg");
				?>
			</div>
			<div class="holder-headings_for_labels">
			<?php
			for($indx = 0; $indx < count($for_lbls_list); $indx++) {
				include("html/heading_for_label_".$for_lbls_list[$indx]."s.html");
			}
				?>
			</div>
		</div>
		<div id="new_notice-options-group-2">
			<div id="notice_files_button-sec">
				<input id="notice_files_button" name="notice_files_button" type="file" style="display:none" multiple="" oninput="uploadFilesToServer(event)">
				<label class="cursor-pointer" id="label-notice_files_button" for="notice_files_button">
					<div id="notice_files_button_icon"></div>
					<div id="notice_files_button_name">Add Files</div>
				</label>
			</div>
		</div>
	</div>
</div>