function isUploadedFileSizeLimited(file_size) {
	if(file_size >	upload_file_B) {
		return false;
	}
	return true;
}

//Stores attached-file in (attached_files)array and creates block for the that file.
function storeAttachedFile(file) {
	var file_indx = total_attached_files_count_upto_now;
	attached_files.append(file_indx, file);
	total_attached_files_count_upto_now++;
	return file_indx;
}

//Stores attached-file in (attached_files)array and creates block for the that file.
function CreateAttachedFileBox(file_indx, file) {
	uploaded_files.innerHTML+="<div id=\"uploaded_file-"+file_indx+"\">"+
	"<label id=\"uploaded_file_head-"+file_indx+"\" class=\"cursor-pointer uploaded_file_icon-file\"></label>"+
	"<progress id=\"progress-uploaded_file-"+file_indx+"\"></progress>"+
	"<span class=\"uploaded_file_name\">"+ file.name+"</span>"+
	"<span class=\"uploaded_file_size\">["+get_file_size(file.size)+"]</span>"+
	"<label class=\"cursor-pointer uploaded_file_delete\" id=\"del_file-"+file_indx+"\" onclick=\"deleteFileFromServer_Ajax(this)\">"+
	"<span class=\"wrong_icon\">+</span>"+
	"</label>"+
	"</div>";
}

//Posts each attached file to server (one at a time).
function uploadEachFileToServer_Ajax(file_indx) {						
	var upf = document.getElementById("uploaded_file-"+file_indx);
	var upf_head = document.getElementById("uploaded_file_head-"+file_indx);
	var upf_progress = document.getElementById("progress-uploaded_file-"+file_indx);
	var upf_delete = document.getElementById("del_file-"+file_indx);
	
	function moveToNextFile() {
		while(!(attached_files.has(++file_indx)) && (file_indx < total_attached_files_count_upto_now));
		if(attached_files.has(file_indx))
		uploadEachFileToServer_Ajax(file_indx);
	}
	
	function showFileUploadError(msg) {
		upf.style.backgroundColor = "#ffcfcf";
		upf_head.className = upf_head.className+" error-uploaded_file_icon-file";
		upf_head.innerHTML = "<label class=\"cursor-pointer uploaded_file_error_msg\">"+msg+"</label>";
	}
	function changeToSuccessUI() {
		upf.style.backgroundColor = "#fffc95";
	}
	var xhttp = new XMLHttpRequest();
	
	xhttp.onreadystatechange = function() {
		if(xhttp.readyState==4) {
			if(xhttp.status==200) {
				try {
					var response = JSON.parse(this.responseText);
					testErrors(this.responseText);
					if(response["errors"].length < 1) {
						uploaded_files_basenames[file_indx] = response["fileserverbasename"];
						add_TotalAttachedFilesInfo(file_indx);
						changeToSuccessUI();
						updateUI_TotalAttachedFilesInfo();
						// alignScrollToBottom(document.getElementById("notice-some-sections"));
					}
					else if(isthere(response["errors"], "119") || isthere(response["errors"], "120")){
						showFileUploadError(errors_list["152"]);
					}
					else if(isthere(response["errors"], "100")){
						invokeDialog("cancel", errors_list["100"], "cancel", "cancelDialog()", null, null);
					}
					else {
						showFileUploadError(errors_list["152"]);
					}
				}
				catch(error) {
					// invokeDialog("cancel", errors_list["000"], "cancel", "cancelDialog()", null, null);
					showFileUploadError(errors_list["152"]);
				}
			}
			else if(xhttp.status!=200) {
				showFileUploadError(errors_list["152"]);
			}
			moveToNextFile();
		}
	};
	
	// upf_delete.onclick = function() {
	// xhttp.abort();
	// };
	upf_delete.addEventListener("click", function() {
		xhttp.abort();
	});
	
	xhttp.onloadstart = function() {
		upf_progress.style.display = "initial";
	};
	xhttp.onprogress = function(e) {
		if(e.lengthComputable) {
			upf_progress.max = e.total;
			upf_progress.value = e.loaded;
		}
	};
	xhttp.onerror = function () {
		showFileUploadError( errors_list["152"]);
	};
	xhttp.onload = function() {};
	xhttp.timeout = 60 * 1000;
	xhttp.ontimeout = function() {
		showImageUploadError(errors_list["503"]);
	};
	xhttp.onloadend = function() {
		upf_progress.style.display = "none";
	};
	
	//checking uploaded file_size, 
	//if file_size within limits then uploading to server.
	//else showing file_size error.
	if(isUploadedFileSizeLimited(attached_files.get(file_indx).size)) {
		var formdata = new FormData();
		formdata.append(file_indx, attached_files.get(file_indx));
		formdata.append("upload_id", upload_id);
		xhttp.open("POST", "php/upload_attached_file.php", true);
		xhttp.send(formdata);
	}
	else {
		showFileUploadError(errors_list["501"]);
		moveToNextFile();
	}
	}
	
	//Gets files on attaching and prepare them to upload to server.
	function uploadFilesToServer(event) {
	var files = event.target.files;
	var pres_files_first_index = total_attached_files_count_upto_now;
	elementDisplay("total-attached-files-info", "flex");
	
	for(var indx = 0; indx < files.length; indx++) {
	//Store attached file 
	var file_indx = storeAttachedFile(files[indx]);
	
	//Create box for attached file
	CreateAttachedFileBox(file_indx, files[indx]);
	}
	//uploads each file to server asynchronously one after the other.
	uploadEachFileToServer_Ajax(pres_files_first_index);
	event.target.value = "";
	}
	
	//Deletes file from server.
	function deleteFileFromServer_Ajax(upf_del) {
	var file_indx = upf_del.id.split("-")[1];
	var upf = document.getElementById("uploaded_file-"+file_indx);
	
	function deleteUI() {
	upf.remove();
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
	remove_TotalAttachedFilesInfo(file_indx);
	deleteUI();
	deleteFileData(file_indx);
	updateUI_TotalAttachedFilesInfo();
	}
	else if(isthere(response["errors"], "100")){
	invokeDialog("cancel", errors_list["100"], "cancel", "cancelDialog()", null, null);
	}
	}
	catch(error) {
	// invokeDialog("cancel", errors_list["000"], "cancel", "cancelDialog()", null, null);
	}
	}
	};
	
	var param1 = "upload_id="+upload_id;
	var param2 = "fileserverbasename="+uploaded_files_basenames[file_indx];
	
	xhttp.open("POST", delete_attached_file_url, true);
	xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhttp.send(param1+"&"+param2);
	}
	updateUI_TotalAttachedFilesInfo();
	}
	
	function add_TotalAttachedFilesInfo(file_indx) {
	total_attached_files_size+=attached_files.get(file_indx).size;
	total_attached_files_count+=1;
	}
	
	function remove_TotalAttachedFilesInfo(file_indx) {
	total_attached_files_size-=attached_files.get(file_indx).size;
	total_attached_files_count-=1;
	}
	
	function updateUI_TotalAttachedFilesInfo() {
	// var total_attached_files_count = Object.keys(uploaded_files_basenames).length;
	if(total_attached_files_count == 0) {
	elementDisplay("total-attached-files-info", "");
	}
	else if(total_attached_files_count >= 1){
	elementDisplay("total-attached-files-info", "flex");
	}
	
	document.getElementById("t-a-f-size").innerHTML = get_file_size(total_attached_files_size);
	document.getElementById("t-a-f-count").innerHTML = "("+total_attached_files_count+")";
	}	