function isDisplayImageSizeLimited(files_size) {
	if(files_size >	upload_image_B) {
		// invokeDialog("ok", "Display image max. size "+upload_image_MB+"MB", null, null, "OK", "cancelDialog()");
		return false;
	}
	return true;
}

//Posts image(displayed) to server.
function uploadImageToServer_Ajax(file_indx) {
	var xhttp = new XMLHttpRequest();
	var ntc_img_viewer = document.getElementById("notice_image_viewer");
	var ntc_img = document.getElementById("notice_image");
	var ntc_img_progress = document.getElementById("progress-uploaded_image");
	var ntc_img_change_lbl = document.getElementById("label-change_notice_image_button");
	var ntc_img_delete_lbl = document.getElementById("label-delete_notice_image_button");
	var ntc_img_manipulate_buttons = document.getElementById("notice_image_manipulate_buttons");
	var ntc_img_adj = document.getElementById("notice_image_adj");
	
	function showImageUploadError(msg) {
		ntc_img_adj.style.backgroundImage = "url(images/error_icon.png) ";
		ntc_img_adj.innerHTML = "<span class=\"uploaded_image_error_msg\">"+msg+"</span>";
		fitImageTo("width", ntc_img);
		setImageViewerRatio("", ntc_img_viewer);
		changeToLastStageUI();
	}
	function changeToSuccessUI() {
		ntc_img_adj.style.display = "";
	}
	function changeToLastStageUI() {
		ntc_img_change_lbl.style.display = "flex";
	}
	
	ntc_img_delete_lbl.addEventListener("click", function() {
		xhttp.abort();
	});
	
	xhttp.onreadystatechange = function() {
		if(xhttp.readyState==2) {
			setImageRatio();
		}
		else if(xhttp.readyState==4 && xhttp.status==200) {
			try {
				var response = JSON.parse(this.responseText);
				testErrors(this.responseText);
				if(response["errors"].length < 1) {
					uploaded_files_basenames[file_indx] = response["fileserverbasename"];
					changeToSuccessUI();
					changeToLastStageUI();
					imageManipulateOptions_visibility();
				}
				else if(isthere(response["errors"], "119") || isthere(response["errors"], "120")){
					showImageUploadError(errors_list["152"]);
				}
				else if(isthere(response["errors"], "100")){
					invokeDialog("cancel", errors_list["100"], "cancel", "cancelDialog()", null, null);
				}
				else {
					showImageUploadError(errors_list["152"]);
				}
			}
			catch(error) {
				// invokeDialog("cancel", errors_list["000"], "cancel", "cancelDialog()", null, null);
				showImageUploadError(errors_list["152"]);
			}
		}
		else if(xhttp.readyState==4 && xhttp.status!=200){
			showImageUploadError(errors_list["152"]);
			}
	};
	
	xhttp.onloadstart = function() {
		ntc_img_progress.style.display = "initial";
	};
	xhttp.onprogress = function(e) {
		if(e.lengthComputable) {
			ntc_img_progress.max = e.total;
			ntc_img_progress.value = e.loaded;
		}	
	};
	xhttp.onabort = function() {};
	xhttp.onerror = function () {
		showImageUploadError(errors_list["152"]);
	};
	xhttp.onload = function() {};
	xhttp.timeout = 60 * 1000;
	xhttp.ontimeout = function() {
		showImageUploadError(errors_list["503"]);
	};
	xhttp.onloadend = function() {
		ntc_img_progress.style.display = "none";
	};
	
	if(isDisplayImageSizeLimited(attached_files.get(file_indx).size)) {
		var formdata = new FormData();
		formdata.append(file_indx, attached_files.get(file_indx));
		formdata.append("upload_id", file_indx+"-"+upload_id);
		xhttp.open("POST", "php/upload_attached_file.php", true);
		xhttp.send(formdata);
		// delete uploaded_files_basenames[file_indx];
	}
	else {
		showImageUploadError(errors_list["502"]);
	}
	ntc_img_manipulate_buttons.style.display = "flex";
}

//Deletes image from server.
function deleteImageFromServer_Ajax(file_indx) {
	var ntc_img_viewer = document.getElementById("notice_image_viewer");
	var ntc_img = document.getElementById("notice_image");
	var ntc_progress = document.getElementById("progress-uploaded_image");
	var ntc_img_manipulate_buttons = document.getElementById("notice_image_manipulate_buttons");
	var ntc_img_change_lbl = document.getElementById("label-change_notice_image_button");
	var ntc_img_adj = document.getElementById("notice_image_adj");
	// var ntc_img_button_adj = document.getElementById("notice_image_button_adj");
	
	function deleteUI() {
		ntc_img.src = "";
		ntc_progress.style.display = "";
		ntc_img_manipulate_buttons.style.display = "";
		ntc_img_change_lbl.style.display = "";
		ntc_img_adj.style.display = "";
		ntc_img_adj.style.backgroundImage = "";
		ntc_img_adj.innerHTML = "";
		// ntc_img_button_adj.style.display = "";
		ntc_img_viewer.htmlFor = "notice_image_button";
		ntc_img_viewer.style.backgroundColor = "";
		setImageViewerRatio("", ntc_img_viewer);
		fitImageTo("width", ntc_img);
	}
	
	if(isNothing(uploaded_files_basenames[file_indx])) {
		deleteUI();
		deleteFileData(file_indx);
	}
	else {
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
			if(xhttp.readyState==4 && xhttp.status==200) {
				try {
					var response = JSON.parse(this.responseText);
					if(response["success_msg"]) {
						deleteFileServerInfo(file_indx);
						deleteUI();
						deleteFileData(file_indx);
					}
					else if(isthere(response["errors"], "100")) {
						invokeDialog("cancel", errors_list["100"], "cancel", "cancelDialog()", null, null);
					}
				}
				catch(error) {
					// invokeDialog("cancel", errors_list["000"], "cancel", "cancelDialog()", null, null);
				}
			}
		};
		deleteImageFromServer_request(xhttp, file_indx);
	}
}

function deleteImageFromServer_request(xhttp, file_indx) {
	var param1 = "upload_id="+img_file_indx+"-"+upload_id;
	var param2 = "fileserverbasename="+uploaded_files_basenames[file_indx];
	
	xhttp.open("POST", delete_attached_file_url, true);
	xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhttp.send(param1+"&"+param2);
}

function changeImageInServer_Ajax(old_file_indx, new_file_indx) {
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if(xhttp.readyState==4 && xhttp.status==200) {
			try {
				var response = JSON.parse(this.responseText);
				if(response["success_msg"]) {
					deleteFileServerInfo(old_file_indx);
					deleteFileServerInfo(img_file_indx);
					setUI_ImageSRC();
					uploadImageToServer_Ajax(new_file_indx);
				}
				else if(isthere(response["errors"], "100")) {
					invokeDialog("cancel", errors_list["100"], "cancel", "cancelDialog()", null, null);
				}
			}
			catch(error) {}
		}
	};
	deleteImageFromServer_request(xhttp, old_file_indx);
}

function changeUI_toViewImage() {
	var ntc_img_viewer = document.getElementById("notice_image_viewer");
	var ntc_img_manipulate_buttons = document.getElementById("notice_image_manipulate_buttons");
	
	ntc_img_viewer.htmlFor = "";
	ntc_img_viewer.style.backgroundColor = "#eee";
	ntc_img_manipulate_buttons.style.display = "none";
}

function setUI_ImageSRC() {
	var ntc_img_change_lbl = document.getElementById("label-change_notice_image_button");
	var ntc_img_adj = document.getElementById("notice_image_adj");
	var ntc_img = document.getElementById("notice_image");
	
	ntc_img_change_lbl.style.display = "";
	ntc_img_adj.style.backgroundImage = "";
	ntc_img_adj.innerHTML = "";
	ntc_img_adj.style.display = "flex";
	ntc_img.src = img_src;
}

//Displays and deletes the uploaded notice image.
function loadNoticeImage(event) {
	var file = event.target.files[0];
	img_src = URL.createObjectURL(file);
	attached_files.set(img_file_indx, file);
	var image_servername = uploaded_files_basenames[img_file_indx];
	
	changeUI_toViewImage();
	if(isNothing(image_servername)) {
		setUI_ImageSRC();
		uploadImageToServer_Ajax(img_file_indx);
	}
	else {
		uploaded_files_basenames[prev_img_file_indx] = image_servername;
		changeImageInServer_Ajax(prev_img_file_indx, img_file_indx);
	}
	event.target.value = "";
}

function setImageRatio() {
	var ntc_img_viewer = document.getElementById("notice_image_viewer");
	var ntc_img = document.getElementById("notice_image");
	var img_w = ntc_img.naturalWidth;
	var img_h = ntc_img.naturalHeight;
	//0/0 = NaN
	//1/0 = NaN
	//0/1 = 0
	var img_rp = ratioPercent(img_w, img_h, 2);
	var img_rp = isNaN(img_rp)?0:img_rp;
	var height_percent = "";
	
	if(img_rp < avg(img_ratio_percent["21:9"], img_ratio_percent["16:9"], 2)) {
		height_percent = "";
	}
	else if(img_rp < avg(img_ratio_percent["16:9"], img_ratio_percent["4:3"], 2)) {
		height_percent = img_ratio_percent["16:9"];
	}
	else if(img_rp < avg(img_ratio_percent["4:3"], img_ratio_percent["1:1"], 2)) {
		height_percent = img_ratio_percent["4:3"];
	}
	else if(img_rp < avg(img_ratio_percent["1:1"], img_ratio_percent["3:4"], 2)) {
		height_percent = img_ratio_percent["1:1"];
	}
	else if(img_rp < avg(img_ratio_percent["3:4"], img_ratio_percent["9:16"], 2)) {
		height_percent = img_ratio_percent["3:4"];
	}
	else {
		height_percent = img_ratio_percent["9:16"];
	}
	if(img_rp > img_ratio_percent["1:1"]) {
		fitImageTo("height", ntc_img);
	}
	else {
		fitImageTo("width", ntc_img);
	}

	setImageViewerRatio(height_percent, ntc_img_viewer);
}

function setImageViewerRatio(height_percent, img_viewer) {
	if(isDigit(height_percent))
		height_percent+="%";
	else
		height_percent = "";
	
	img_viewer.style.paddingTop = height_percent;
}

function fitImageTo(dim, img) {
	img.style.width		= fit_img_to[dim]["width"];
	img.style.height	= fit_img_to[dim]["height"];
	img.style.top		= fit_img_to[dim]["top"];
	img.style.left		= fit_img_to[dim]["left"];
	img.style.transform	= fit_img_to[dim]["transform"];
}