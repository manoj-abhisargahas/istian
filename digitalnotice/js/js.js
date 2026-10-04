function msg(msg1, msg2, msg3) {
	document.getElementById("notices-view-sec").value+=msg1+"-"+msg2+"-"+msg3+" ";
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

function getNoticesOfFirstInList() {
	var ntcs_by = document.getElementsByName("ntcs-by");
	var ntcs_by_label = document.getElementsByClassName("ntcs-by");
	// 
	for(i = 0; i < ntcs_by.length; i++) {
		if(ntcs_by_label[i].textContent.toUpperCase()=="COLLEGE") {
			ntcs_by[i].checked = true;
			break;
		}
	}
	getNoticesBy_Ajax("COLLEGE");
}

function ChangeHeaderBottomBorder() {
    if((document.body.scrollTop > 10) || 
        (document.documentElement.scrollTop > 10)) {
        header.style.borderBottom = "1px solid #e5e5e5";
    }
    else {
        header.style.borderBottom = "";
        
    }
}

window.onload = function () {
	getNoticesByNames_Ajax();
	
	window.onscroll = function(){
		// ChangeHeaderBottomBorder();
	};
};
