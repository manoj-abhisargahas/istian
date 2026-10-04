//Store all attached files.
var attached_files = new FormData();

//Stores uploaded files servername. 
var uploaded_files_basenames = {};

//total attached files size.
var total_attached_files_size = 0;

//total attached files count.
var total_attached_files_count = 0;

//total attached files count upto now.
var total_attached_files_count_upto_now = 0;

var upload_id = "";
var notice_by = "";

var upload_image_MB = 2;
var upload_file_MB = 2;
var upload_image_B = 1024 * 1024 * upload_image_MB;
var upload_file_B = 1024 * 1024 * upload_file_MB;

var img_file_indx = "image";
var prev_img_file_indx = "prev_image";
var img_src = "";

var NTC_IMG_MANIPULATE_BUTTONS_HEIGHT = "36px";

var align_flex_items = {
	"t"	: "flex-start",
	"l"	: "flex-start",
	"c"	: "center",
	"b"	: "flex-end",
	"r"	: "flex-end"
}

function toNumeric(value) {
	return value * 1;
}

function avg(a, b, scale) {
	return toNumeric(((a+b)/2).toFixed(scale));
}

function ratioPercent(a, b, scale) {
	return toNumeric(((b/a)*100).toFixed(scale));
}

var img_ratio_percent = {
	"9:16"	: ratioPercent(9, 16, 2),
	"3:4"	: ratioPercent(3, 4, 2),
	"1:1"	: ratioPercent(1, 1, 2),
	"4:3"	: ratioPercent(4, 3, 2),
	"16:9"	: ratioPercent(16, 9, 2),
	"21:9"	: ratioPercent(21, 9, 2)
}

var fit_img_to = {
	"width" :	{
		"width"	 : "",
		"height" : "",
		"top"	 : "",
		"left"	 : "",
		"transform" : ""
	},
	"height" :	{
		"width"	 : "auto",
		"height" : "100%",
		"top"	 : 0,
		"left"	 : "50%",
		"transform" : "translateX(-50%)"
	}
}

var delete_attached_file_url = "php/delele_attached_file.php";

//If all checkboxes checked(in a group) then checks all-checkbox button.
function verify_All_Checkboxes(chkbx) {
	var group_name = chkbx.id.split("-")[0];
	var all_chkbx = document.getElementById(group_name+"-all");
	if(is_All_Checkboxes_Checked(group_name)) {
		all_chkbx.checked = true;
	}
	else {
		all_chkbx.checked = false;
	}
	
	if(chkbx.checked)
		check_required_heading_for_label_checkbox(group_name, false);
}

//Returns true if all checkboxes checked (in a group).
function is_All_Checkboxes_Checked(group_name) {
	var chkbxs = document.getElementsByName(group_name);
	var checked =  true;
	for(let i = 0; i < chkbxs.length; i++) {
		if(!chkbxs[i].checked) {
			checked = false;
			break;
		}
	}
	return checked;
}

//On clicking all checkbox-button updates the checked-state of all checkboxes (of that group).
function check_All_Checkboxes(all_chkbx) {
	var group_name = all_chkbx.id.split("-")[0];
	var chkbxs = document.getElementsByName(group_name);
	for(let i = 0; i < chkbxs.length; i++) {
		chkbxs[i].checked = all_chkbx.checked;
	}
	
	if(all_chkbx.checked)
		check_required_heading_for_label_checkbox(group_name, false);
}

function check_required_heading_for_label_checkbox(group_name, to_check) {
	var required_heading_for_label = document.getElementById("required-heading_for_label-"+group_name+"s");
	required_heading_for_label.checked = to_check;
	
}

//On typing-overflow in the textarea adds additional row. 
function expandTextarea(txtarea, count, total_text_count) {
	txtarea.value = txtarea.value.substring(0, Number(total_text_count.innerHTML));
	
	txtarea_pad_top = convertUnitToDigit(window.getComputedStyle(txtarea).getPropertyValue('padding-top'));
	txtarea_pad_top = isDigit(txtarea_pad_top)?Number(txtarea_pad_top):0;
	txtarea_pad_bottom = convertUnitToDigit(window.getComputedStyle(txtarea).getPropertyValue('padding-bottom'));
	txtarea_pad_bottom = isDigit(txtarea_pad_bottom)?Number(txtarea_pad_bottom):0;
	txtarea.style.height = "auto";
	txtarea.style.height = (txtarea.scrollHeight - (txtarea_pad_top + txtarea_pad_bottom))+"px";
	
	if(txtarea.textLength <= Number(total_text_count.innerHTML))
		count.innerHTML = txtarea.textLength;
}

function replaceNewLineWithNull(ele) {
	ele.value = ele.value.replace("\n", "");
}

function msg(msg1, msg2, msg3) {
	document.getElementById("notice_text_field").value+=msg1+"-"+msg2+"-"+msg3+" ";
}

//Gets file-size (in B, KB, MB) to display.
function get_file_size(file_size) {
	if(file_size/1024 < 1)
		return String(file_size)+"B";
	
	file_size = file_size/1024;
	if(Number((file_size/1024).toFixed(1)) < 1)
		return Math.round(file_size)+"KB";
	else
		return (file_size/1024).toFixed(1)+"MB";
}

function invokeDialog(type, msg, cancel_text, cancel_callback, ok_text, ok_callback) {
	var shade_body = document.getElementById("shade-body");
	shade_body.innerHTML = "<div class=\"shade-fill-area\" onclick=\""+((type=="confirm")?"":"cancelDialog()")+"\"></div>"+
							"<div id=\"dialog-box\">"+
								"<div id=\"dialog-box-msg\">"+msg+"</div>"+
								"<div class=\"dialog-box-buttons\">"+
									(((type=="confirm")||(type=="cancel"))?"<button id=\"dialog-box-button-cancel\" onclick=\""+cancel_callback+"\">"+cancel_text+"</button>":"")+
									(((type=="confirm")||(type=="ok"))?"<button id=\"dialog-box-button-ok\" onclick=\""+ok_callback+"; cancelDialog()\">"+ok_text+"</button>":"")+
								"</div>"+
							"</div>";
	shade_body.style.display = "block";
}

function cancelDialog() {
	var shade_body = document.getElementById("shade-body");
	shade_body.style.display="none";
	shade_body.style.innerHTML="";
}

function msgIndicate(ele_id, is_error, msg) {
	var error = document.getElementById(ele_id);
	var error_symbol = "<span class=\"error-symbol\">!</span>";
	var is_error_msg = is_error && (msg!="");
	
	error.innerHTML = is_error_msg?error_symbol:"";
	error.innerHTML+= (msg!="")?msg:"";
	error.style.display = (msg!="")?"block":"";
}

function extraMsgIndicate(ele_id, msg) {
	var error = document.getElementById(ele_id);
	var ismsgempty = (error.innerHTML=="");
	error.innerHTML+= (ismsgempty?"":"</br>")+msg;
}

function textfieldErrorShow(ele_id, is_error) {
	var ele = document.getElementById(ele_id);
	ele.style.borderBottom = is_error?"2px solid red":"";
}

function setValue(ele_id, value) {
	var ele = document.getElementById(ele_id);
	ele.value = value;
}

function convertUnitToDigit(unit_value) {
	// /^\d+/g
	var regexp = new RegExp("^\\d+","g");
	var mathes = unit_value.match(regexp);
	if(mathes!=null) {
		return mathes[0];
	}
	return null;
}

function convertDigitToUnit(digit, unit) {
	var str = new String(digit);
	return str.toString()+unit;
}

function isEmailValid(email) {
	// /^.+@.+[\.].+$/i
	var regexp = new RegExp("^.+@.+[\.].+$","i");
	return regexp.test(email);
}

function isPasswordValid(pword) {
	// /^[0-9a-z\!\@\#\$\%\&\*\_\|\-\+\=]{8,16}$/
	var regexp = new RegExp("^[0-9a-z\_\@\#\$\&]+$","i");
	return regexp.test(pword);
}

function isInteger(value) {
	return ((typeof value)=='number') && isFinite(value) && (Math.floor(value)==value);
}

function isFloat(value) {
	return ((typeof value)=='number') && isFinite(value) && (Math.floor(value)!=value);
}

function isNumeric(value) {
	return isInteger(value) || isFloat(value);
}

function isDigit(value) {
	// /^\d*[\.]?\d+$/
	var str = new String(value);
	var regexp = new RegExp("^\\d*[\.]?\\d+$");
	return regexp.test(str);
}

function isthere(array, ele) {
	for(var i = 0; i < array.length; i++) {
		if(array[i]==ele)
			return true;
	}
	
	return false;
}

function alignScrollToBottom(ele) {
	scrollOptions = {
		left: 0,
		top: ele.scrollHeight,
		behaviour: "smooth" 
	};
	
	ele.scrollTo(scrollOptions);
}

function forLabels_Visibility(heading_for_label, for_label_id) {
	var supp_heading_for_label = document.getElementById("supp_"+heading_for_label.id);
	var for_labels_checked_group = document.querySelectorAll("input[name='heading_for_label']");
	var supp_for_labels_checked_group = document.querySelectorAll("input[name='supp_heading_for_label']");
	var for_label = document.getElementById(for_label_id);
	var labels_visible_section = document.getElementById("labels_visible_section");
	var for_labels_closer = document.getElementById("for_labels_closer");
	var label_for_labels_closer = document.getElementById("label-for_labels_closer");
	
	//checks current-checkbox's supported-checkbox
	if(heading_for_label.checked) {
		supp_heading_for_label.checked = true;
	}
	else {
		for_labels_closer.checked = false;
		label_for_labels_closer.htmlFor = "";
	}
	
	//uncheck all checkboxes except current-checkbox
	for(i = 0; i < for_labels_checked_group.length; i++) {
		if(!(for_labels_checked_group[i].id==heading_for_label.id)) {
			for_labels_checked_group[i].checked = false;
		}
	}
	
	//uncheck all supported-checkboxes except current-checkbox's supported-checkbox
	for(i = 0; i < supp_for_labels_checked_group.length; i++) {
		if(!(supp_for_labels_checked_group[i].id==supp_heading_for_label.id)) {
			supp_for_labels_checked_group[i].checked = false;
		}
	}
	
	//setting current-checkbox's for_label-element height to 
	//labels_visible_section if current-checkbox checked
	if(heading_for_label.checked) {
		labels_visible_section.style.height = for_label.scrollHeight+"px";
		setTimeout(function() {labels_visible_section.style.height = "auto"}, 400);
		for_labels_closer.checked = true;
		label_for_labels_closer.htmlFor = heading_for_label.id;
		zIndex_set("notice-sec-for", 1);
	}
	else {
		labels_visible_section.style.height = for_label.scrollHeight+"px";
		setTimeout(function() {labels_visible_section.style.height = ""});
		zIndex_set("notice-sec-for", "unset");
	}
}

function formBlackCover_VisibilityBehind(front_ele) {
	var black_cover = document.getElementById("form_black_cover");
	var label_black_cover = document.getElementById("label-form_black_cover");
	
	if(label_black_cover.htmlFor!="") {
		var pres_front_ele = document.getElementById(label_black_cover.htmlFor);
		pres_front_ele.checked = false;
	}
	
	if(front_ele.checked) {
		label_black_cover.htmlFor = front_ele.id;
		black_cover.checked = true;
	}
	else {
		label_black_cover.htmlFor = "";
		black_cover.checked = false;
	}
}

function zIndex_set(ele_id, index) {
	document.getElementById(ele_id).style.zIndex = index;
}

function requiredIndication_Hide(field) {
	var required_indicator = document.getElementById("required-"+field.id);
	required_indicator.checked = false;
}

function animatePlaceholderText(ele, ptext, delay) {
	ele.placeholder = "";
	setTimeout(function(){
		for(i = 0; i < ptext.length; i++) {
			addPlaceholderletter(ele, ptext[i], i);
		}
	}, delay*100);
}

function addPlaceholderletter(ele, pletter, interval) {
	setTimeout(function(){ele.placeholder+=pletter}, interval*20);
}

function elementDisplay(ele_id, displayOption) {
	document.getElementById(ele_id).style.display = displayOption;
}

var errors_list = {
"000":"Application not responding.",
"100":"Database Connection Failed.",
"101":"",
"102":"",
"103":"",
"104":"",
"105":"",
"106":"",
"107":"",
"108":"Data not uploaded into database.",
"109":"Login Invalid.",
"110":"Your email is not associated with the college.",
"111":"Wrong OTP.",
"112":"OTP Expired.",
"113":"Password update failed.",
"114":"Email Invalid.",
"115":"Password Invalid.",
"116":"Link send failed.",
"117":"File not found in server.",
"118":"File info not deleted from database.",
"119":"File not uploaded into server.",
"120":"File info not uploaded into database.",
"121":"Session Logged Out.",
"122":"No account with this email.",
"150":"Notice Sended Failed.",
"151":"An error ocured while fetching notices.",
"152":"An error occured while uploading.",
"153":"Type Email.",
"154":"Type Password.",
"155":"Password should be 8 to 16 characters.",
"156":"Only Allowed Symbols _ @ # $ &.",
"157":"Retype Password.",
"158":"Retyped Password should match Password.",
"501":"File size is large (> "+upload_file_MB+"MB).",
"502":"Image size is large (> "+upload_image_MB+"MB).",
"503":"Time Out Uploading.",
"504":"File delete failed."
};

// window.addEventListener("load", function (event) {
	// alert("Sure to cancel post.");
// });

function isNothing(value) {
	return (value==undefined || value==null || value=="");
}

function deleteFileServerInfo(file_indx) {
	if(!isNothing(uploaded_files_basenames[file_indx]))
		delete uploaded_files_basenames[file_indx];
}

function deleteFileData(file_indx) {
	if(attached_files.has(file_indx))
		attached_files.delete(file_indx);
}

function headerStyling_OnScroll(){
		if((document.body.scrollTop > 10) || 
			(document.documentElement.scrollTop > 10)) {
			header.style.borderBottom = "1px solid #ddd";
		}
		else {
			header.style.borderBottom = "";
		}
}

function testErrors(msg) {
// 	notice_text_field.value = msg;
}