function sendNotice() {
	var valid = true;
	var formdata = new FormData();
	
	function indicateInvalid_text(ele) {
		ele.style.color = "rgb(0, 0, 0)";
		setTimeout(function(){ele.style.color = "rgb(255, 0, 0)"}, 200);
		
	}
	
	function removeInvalid_text(ele) {
		ele.style.color = "";
	}
	
	function indicateInvalid_borderBottom(ele) {
		ele.style.borderBottom = "2px solid rgb(190, 190, 190)";
		setTimeout(function(){ele.style.borderBottom = "2px solid rgb(255, 0, 0)"} , 200);
	}
	
	function removeInvalid_borderBottom(ele) {
		ele.style.borderBottom = "";
	}
	
	function validateNoticeHeading(notice_heading) {
		var nhf_count = document.getElementById("n_h_f-text-count");
		var nhf_t_count = document.getElementById("n_h_f-total-text-count");
		var notice_heading_border = document.getElementById("bottom_border-notice_heading");
		var required_indicator = document.getElementById("required-"+notice_heading.id);
		required_indicator.checked = false;
		
		notice_heading.value = notice_heading.value.trim().substring(0, Number(nhf_t_count.innerHTML));
		expandTextarea(notice_heading, nhf_count, nhf_t_count);
		if(notice_heading.value=="") {
			//for animation-effect checking off and on checkbox.
			notice_heading.focus();
			animatePlaceholderText(notice_heading, "Notice Heading", 2);
			required_indicator.checked = false;
			setTimeout(function(){required_indicator.checked = true}, 200);
		}
	}
	
	function validateNoticeText(notice_text) {
		var ntf_count = document.getElementById("n_t_f-text-count");
		var ntf_t_count = document.getElementById("n_t_f-total-text-count");
		
		notice_text.value = notice_text.value.trim().substring(0, Number(ntf_t_count.innerHTML));
		expandTextarea(notice_text, ntf_count, ntf_t_count);
	}

	function validateLabelsSelected(label, labels_heading) {
		var labels_sel = document.getElementById(label+"-all");
		var required_heading_for_label = document.getElementById("required-heading_for_label-"+label+"s");
		
		if(labels_sel.checked!=true) {
			var labels = document.getElementsByName(label);
			labels_sel = [];
			
			for(var indx = 0; indx < labels.length; indx++) {
				if(labels[indx].checked) {
					label_name = document.getElementById("label-"+labels[indx].id).innerHTML;
					labels_sel.push(label_name.trim());
				}
			}
			if(labels_sel.length==0) {
				//for animation-effect checking off and on checkbox.
				required_heading_for_label.checked = false;
				setTimeout(function(){required_heading_for_label.checked = true}, 200);
				valid = false;
			}
			else {
				required_heading_for_label.checked = false;
			}
		}
		else {
			required_heading_for_label.checked = false;
			labels_sel = "all";
		}
		
		return labels_sel;
	}
	
	function validateExpireDate(notice_expiry_date) {
		var required_notice_expiry_date = document.getElementById("required-notice_expiry_date");
		
		if(notice_expiry_date.value=="") {
			//for animation-effect checking off and on checkbox.
			required_notice_expiry_date.checked = false;
			setTimeout(function(){required_notice_expiry_date.checked = true}, 200);
			valid = false;
		}
		else {
			required_notice_expiry_date.checked = false;
		}
	}
	
	var notice_heading = document.getElementById("notice_heading_field");
	validateNoticeHeading(notice_heading)
	
	var notice_text = document.getElementById("notice_text_field");
	validateNoticeText(notice_text);
	
	var for_labels_list = document.getElementById("for_labels_list").innerHTML;
	for_labels_list = for_labels_list.split(",");
	for(i = 0; i < for_labels_list.length; i++) {
		var for_label = validateLabelsSelected(for_labels_list[i], "for_"+for_labels_list[i]+"s");
		formdata.append(for_labels_list[i]+"s_sel", for_label);
	}
	
	var notice_expiry_date = document.getElementById("notice_expiry_date_field");
	validateExpireDate(notice_expiry_date);
	
	if(valid) {
		var xhttp = new XMLHttpRequest();
		
		xhttp.onreadystatechange = function() {
			if(xhttp.readyState==4 && xhttp.status==200) {
				try {
					var response = JSON.parse(this.responseText);
					if(response["errors"].length < 1) {
						invokeDialog("ok", "Successfully Posted the Notice.", null, null, "OK", "cancelDialog()");
						cancelNewPostBox();
						getNoticesFromServer_Ajax();
					}
					else if(isthere(response["errors"], "108")){
						showFileUploadError(errors_list["150"]);
					}
					else if(isthere(response["errors"], "121")){
						window.location.href = "http://localhost/digitalnotice/post/login.php";
					}
					else if(isthere(response["errors"], "100")){
						invokeDialog("cancel", errors_list["100"], "cancel", "cancelDialog()", null, null);
					}
				}
				catch(error) {
					console.log(error);
					invokeDialog("cancel", errors_list["000"], "Cancel", "cancelDialog()", null, null);
				}
			}
		};
		
		xhttp.onloadstart = function() {};
		xhttp.onprogress = function(e) {};
		xhttp.onabort = function() {};
		xhttp.onerror = function () {};
		xhttp.onload = function() {};
		xhttp.ontimeout = function() {};
		xhttp.onloadend = function() {};
		
		formdata.append("upload_id", upload_id);
		formdata.append("notice_heading", notice_heading.value);
		formdata.append("notice_text", notice_text.value);
		formdata.append("notice_expiry_date", notice_expiry_date.value);
		xhttp.open("POST", "php/send_notice.php", true);
		xhttp.send(formdata);
	}
}