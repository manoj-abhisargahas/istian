function getNoticesFromServer_Ajax() {
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if(xhttp.readyState==4 && xhttp.status==200) {
			console.log(this.responseText);
			if(this.responseXML!=null) {
				displayNotices(this.responseXML.getElementsByTagName("notice"));
				
			}
			else {
				invokeDialog("cancel", errors_list["151"], "cancel", "cancelDialog()", null, null);
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
	
	xhttp.open("POST", "php/get_notices.php", true);
	xhttp.overrideMimeType("text/xml");
	xhttp.send();
}

function getLabels(for_labels, labelname) {
	if(for_labels.length == 1) {
		var label_tags = for_labels[0].getElementsByTagName(labelname);
		var labels = [];
		for(i = 0; i < label_tags.length; i++) {
			labels.push(label_tags[i].textContent);
		}
		return labels.join(", ");
	}
	else {
		return false;
	}
}

function displayNotices(noticeslist) {
	var notices = "";
	if(noticeslist.length==0) {
		notices+="<div class=\"no-notices\">No notices to display.</div>";
	}
	for(var i = 0; i < noticeslist.length; i++) {
		notice = noticeslist[i];
		var upload_id = notice.getElementsByTagName("upload_id");
		var notice_heading = notice.getElementsByTagName("notice_heading");
		var notice_text = notice.getElementsByTagName("notice_text");
		var notice_by = notice.getElementsByTagName("notice_by");
		var expire_time = notice.getElementsByTagName("expire_time");
		var upload_time = notice.getElementsByTagName("upload_time");
		var for_years = getLabels(notice.getElementsByTagName("for_years"), "year");
		var for_branchs = getLabels(notice.getElementsByTagName("for_branchs"), "branch");
		var for_sections = getLabels(notice.getElementsByTagName("for_sections"), "section");
		var uploaded_files = notice.getElementsByTagName("uploaded_files");
		
		var is_expired = isExpired(expire_time[0].textContent);
		var is_expires_next = is_Expires_Tomorrow(expire_time[0].textContent);
		var expired_class = (is_expired?"yes":"no")+"-notice_expired"+(is_expires_next?" notice_expires_next":"");
		// var expire_heading = (is_expired)?"Expired":"Expires On";
		
		notices+="<div id=\"posted-notice-"+i+"\">"+
			"<div class=\""+expired_class+"\">";
				//getting notice_heading.
				notices+="<input id=\"p-n-u_id-"+i+"\" type=\"hidden\" value=\""+upload_id[0].textContent+"\" />";
				notices+="<div class=\"p-n-sec-heading\">"+notice_heading[0].textContent+"</div>";
				
				//getting notice_text.
				if(notice_text.length==1)
				notices+="<div class=\"p-n-sec-text\">"+notice_text[0].textContent+"</div>";
				
				//getting notice_display_image and notice_files.
				if(uploaded_files.length == 1) {
				uploaded_files = uploaded_files[0];
				
				//getting notice_display_image.
				var img = uploaded_files.getElementsByTagName("display_img");
				if(img.length == 1) {
				img = img[0];
				var img_basename = img.getElementsByTagName("filebasename")[0].textContent;
				var img_server_basename = img.getElementsByTagName("fileserverbasename")[0].textContent;
				var is_img_exist = img.getElementsByTagName("isfileexist")[0].textContent=="yes";
				var img_size = img.getElementsByTagName("filesize")[0].textContent;
				var img_contain_class = "p-n-sec-image"+(is_img_exist?"":"-invalid");
				notices+="<div class=\""+img_contain_class+"\">"+
					(is_img_exist?
					("<img class=\"p-n_image\" width=\"100%\" height=\"auto\" src=\"files/"+img_server_basename+"\"/>")
					:("<span class=\"uploaded_image_error_msg\">Image not found.</span>"))+
				"</div>";
				}
				
				//getting notice_files.
				var files = uploaded_files.getElementsByTagName("file");
				if(files.length > 0) {
				notices+="<div class=\"p-n-sec-files\">";
					for(var f_no = 0; f_no < files.length; f_no++) {
					var file = files[f_no];
					var file_basename = file.getElementsByTagName("filebasename")[0].textContent;
					var file_server_basename = file.getElementsByTagName("fileserverbasename")[0].textContent;
					var is_file_exist = file.getElementsByTagName("isfileexist")[0].textContent=="yes";
					var file_size = file.getElementsByTagName("filesize")[0].textContent;
					file_size = get_file_size(Number(file_size));
					var file_contain_class = "p-n-uploaded_file"+(is_file_exist?"":"-invalid");
					notices+="<a class=\"link-up_f\" "+(is_file_exist?"href=\"files/"+file_server_basename+"\"":"")+">"+
						"<div class=\""+file_contain_class+"\">"+
							("<label class=\"cursor-pointer "+(is_file_exist?"":"error-")+"uploaded_file_icon-file"+"\">"+
								(is_file_exist?"":"<label class=\"cursor-pointer uploaded_file_error_msg\">File not found.</label>")+
							"</label>")+
							"<span class=\"uploaded_file_name\">"+file_basename+"</span>"+
							(is_file_exist?("<span class=\"uploaded_file_size\">"+file_size+"</span>"):"")+
						"</div>"+
					"</a>";
					}
				notices+="</div>";
				}
				}
				
				notices+="<div class=\"p-n-sec-info\">"
					//getting notice_by and notice_upload_time.
					notices+="<div class=\"p-n-info-sub-1\">"+
						"<div class=\"p-n-by_profile\">"+
							"<div class=\"by_profile dept_profile\">DEPT</div>"+
							"<div class=\"p-n-by\">"+
								"<span class=\"p-n-info-by\">"+notice_by[0].textContent+"</span>"+
								"<span class=\"p-n-info-upload_time\">"+getTimeAndDate(upload_time[0].textContent)+"</span>"+
							"</div>"+
						"</div>"+
					"</div>";
					
					//getting notice_for - years, branchs, sections.
					notices+="<div class=\"p-n-info-sub-2\">";
						notices+="<div class=\"label_icon_box\"><svg class=\"label_icon\" xmlns=\"http://www.w3.org/2000/svg\" xmlns:xlink=\"http://www.w3.org/1999/xlink\" width=\"0.20in\" height=\"0.125in\">\
									<path fill-rule=\"evenodd\" fill=\"rgb(213, 213, 213)\"\
									d=\"M17.637,6.127 C17.637,6.127 17.624,6.139 13.550,10.608 C13.277,10.908 13.053,10.960 12.488,11.000 C4.827,11.000 1.502,11.000 1.502,11.000 C0.673,11.000 -0.000,10.293 -0.000,9.421 L-0.000,1.580 C-0.000,0.707 0.672,-0.000 1.502,-0.000 C1.502,-0.000 4.823,-0.000 12.480,-0.000 C13.045,0.040 13.271,0.090 13.542,0.392 C17.626,4.938 17.627,4.875 17.627,4.875 C17.627,4.875 17.990,5.155 17.990,5.439 L18.000,5.563 C18.000,5.847 17.637,6.127 17.637,6.127 ZM12.733,3.879 C11.886,3.879 11.199,4.605 11.199,5.500 C11.199,6.395 11.886,7.121 12.733,7.121 C13.580,7.121 14.267,6.395 14.267,5.500 C14.267,4.605 13.580,3.879 12.733,3.879 Z\">\
									</path>\
								</svg></div>";
						//getting notice_for - years, branchs, sections
						notices+="<div class=\"p-n-for\">";
							if(for_years) {
							notices+="<div class=\"p-n-for-sub\">"+
								"<span class=\"sec-heading-for-years\">Years:</span><span class=\"p-n-info-for-years\">"+for_years+"</span>"+
							"</div>";
							}
							if(for_branchs) {
								// document.write(for_branchs);
							notices+="<div class=\"p-n-for-sub\">"+
										"<span class=\"sec-heading-for-branchs\">Branches:</span><span class=\"p-n-info-for-branchs\">"+for_branchs+"</span>"+
									"</div>";
							}
							if(for_sections) {
							notices+="<div class=\"p-n-for-sub\">"+
										"<span class=\"sec-heading-for-sections\">Sections:</span><span class=\"p-n-info-for-sections\">"+for_sections+"</span>"+
									"</div>";
							}
						notices+="</div>"+
					"</div>"+
					"<label class=\"cursor-pointer label-options-for-p_n-button\" for=\"options-for-p_n-button-"+i+"\">"+
						((is_expired||is_expires_next)?"<span class=\"option_symbol-for-p_n-expire_date-expired\"></span>":"")+
						"<span class=\"vellip\">&vellip;</span>"+
					"</label>"+
				"</div>"+
			"</div>";
			notices+="<button id=\"options-for-p_n-button-"+i+"\"></button>"+
				"<label class=\"options-sec-for-p_n\" for=\"options-for-p_n-button-"+i+"\">"+
					"<div class=\"options-for-p_n-list\">"+
						"<div id=\"option-for-p_n-delete-"+i+"\" class=\"option-for-p_n-active\" onclick=\"deletePostedNotice(this)\">"+
							"<span class=\"option_symbol-for-p_n-delete\"></span><span class=\"sec-heading\">Delete Post</span>"+
						"</div>"+
						//getting notice_expire_time.
						"<div id=\"option-for-p_n-expire_date-"+i+"\" >"+
							"<div class=\"p-n-heading-expire_date\">"+
								"<span class=\"option_symbol-for-p_n-expire_date\"></span>"+
								"<span class=\"sec-heading\">Expire Date:</span>"+//"<span class=\"expire_date-edit\"></span>"+
							"</div>"+
							"<span class=\"p-n-info-expire_date\">"+getDate(expire_time[0].textContent)+"</span>"+
						"</div>"+
					"</div>"+
				"</label>"+
				"<div class=\"post_cover_screen\"></div>"+
			"</div>"+
		"</div>";
	}
	
	document.getElementById("notices-view-body").innerHTML = notices;
}