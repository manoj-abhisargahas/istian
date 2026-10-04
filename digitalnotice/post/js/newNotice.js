//Imports new_post-box(notices-post-body) code from server asynchronously.
function importNewPostBox_ajax(new_post_button) {
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if(xhttp.readyState==4 && xhttp.status==200) {
			try {
				var response = JSON.parse(this.responseText);
				if(response["errors"].length < 1) {
				}
				else if(isthere(response["errors"], "121")) {
					window.location.href = "http://localhost/digitalnotice/post/login.php";
				}
			}
			catch(error) {
				var notices_post_body = document.getElementById("notices-post-body");
				var notices_post_sec = document.getElementById("notices-post-sec");
				notices_post_body.innerHTML = this.responseText;
				notices_post_sec.style.display = "flex";
				new_post_button.style.display = "none";
				
				var now_date = Date.now();
				var notice_by = document.getElementById("notice-by").innerHTML;
				upload_id = notice_by.trim()+"-"+Math.trunc(now_date/1000).toString();
				
				postBox_Js();
				viewRemainingSections(true);
			}
		}
	};
	xhttp.open("POST", "php/notices_post_form.php", true);
	xhttp.send();
}

//Deletes new_post-box(notices-post-body) code.
function cancelNewPostBox() {
	postBox_Js_Remove();
	attached_files = new FormData();
	uploaded_files_basenames = {};
	total_attached_files_size = 0;
	total_attached_files_count = 0;
	total_attached_files_count_upto_now = 0;
	
	var notices_post_body = document.getElementById("notices-post-body");
	var notices_post_sec = document.getElementById("notices-post-sec");
	var new_post_button = document.getElementById("new_post-button");
	notices_post_sec.style.display = "";
	notices_post_body.innerHTML = "";
	new_post_button.style.display = "";
}

function deleteFilesFromServer_Ajax() {
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {		
		if(xhttp.readyState==4 && xhttp.status==200) {
			// document.write(this.responseText);
		}
	};
	
	xhttp.open("POST", "php/notice_cancel.php", true);
	xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhttp.send("upload_id="+upload_id);
	upload_id = "";
}

function postBox_Js_Remove() {
	viewRemainingSections(false);
	window.removeEventListener("resize", imageManipulateOptions_visibility);
}

function postBox_Js() {
	var nhf = document.getElementById("notice_heading_field");
	var ntf = document.getElementById("notice_text_field");
	
	var nhf_count = document.getElementById("n_h_f-text-count");
	var ntf_count = document.getElementById("n_t_f-text-count");
	
	var nhf_t_count = document.getElementById("n_h_f-total-text-count");
	var ntf_t_count = document.getElementById("n_t_f-total-text-count");
	
	nhf.maxLength = Number(nhf_t_count.innerHTML);
	ntf.maxLength = Number(ntf_t_count.innerHTML);
	
	nhf.addEventListener("input", function(){
		expandTextarea(this, nhf_count, nhf_t_count);
	});
	
	ntf.addEventListener("input", function(){
		expandTextarea(this, ntf_count, ntf_t_count);
	});
	
	var notice_some_sections = document.getElementById("notice-some-sections");
	var notice_heading_field = document.getElementById("notice_heading_field");
	var notice_text_field = document.getElementById("notice_text_field");
	window.addEventListener("resize", imageManipulateOptions_visibility);
	notice_some_sections.addEventListener("scroll", imageManipulateOptions_visibility);
	notice_heading_field.addEventListener("input", imageManipulateOptions_visibility);
	notice_text_field.addEventListener("input", imageManipulateOptions_visibility);
}

function viewRemainingSections(bool) {
	document.getElementById("view-sections").disabled = bool;
}

function imageManipulateOptions_visibility() {
	var ntc_img_visible_bottom = document.getElementById("notice_image_visible_bottom_calculate_ele");
	var view_ntc_sec_for_options = document.getElementById("view-ntc_sec_for_options");
	var view_ntc_img_options = document.getElementById("view-ntc_img_options");
	
	if((ntc_img_visible_bottom.offsetTop < 45) || (view_ntc_img_options.disabled && ntc_img_visible_bottom.offsetTop < 70)) {
		view_ntc_img_options.disabled = true;
	}
	else {
		view_ntc_img_options.disabled = false;
	}
	
	if((ntc_img_visible_bottom.offsetTop == 0) || (view_ntc_sec_for_options.disabled && ntc_img_visible_bottom.offsetTop < 45)) {
		view_ntc_sec_for_options.disabled = true;
	}
	else {
		view_ntc_sec_for_options.disabled = false;
	}
}