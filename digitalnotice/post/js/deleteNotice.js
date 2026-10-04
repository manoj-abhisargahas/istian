function deletePostedNotice(ele) {
	var u_id_no = ele.id.split("-");
	var u_id_no = u_id_no[u_id_no.length-1];
	invokeDialog("confirm", "Sure to delete the notice?", "Cancel", "cancelDialog()", "OK", "deletePostedNotice_Ajax("+u_id_no+")");
}

function deletePostedNotice_Ajax(u_id_no) {
	var upload_id = document.getElementById("p-n-u_id-"+u_id_no).value;
	var xhttp = new XMLHttpRequest();
	
	xhttp.onreadystatechange = function() {
		if(xhttp.readyState==4 && xhttp.status==200) {
			// document.write(this.responseText);
			var response = JSON.parse(this.responseText);
			if(response["success_msg"]) {
				document.getElementById("posted-notice-"+u_id_no).remove();
			}
			else if(isthere(response["errors"], "121")){
				window.location.href = "http://localhost/digitalnotice/post/login.php";
			}
			else if(isthere(response["errors"], "100")){
				invokeDialog("cancel", errors_list["100"], "cancel", "cancelDialog()", null, null);
			}
		}
	};
	xhttp.open("POST", "php/notice_delete.php", true);
	xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhttp.send("upload_id="+upload_id+"&notice_by="+notice_by);
}