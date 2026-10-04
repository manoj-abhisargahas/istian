function getNoticesByNames_Ajax() {
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if(xhttp.readyState==4 && xhttp.status==200) {
			if(this.responseXML!=null) {
				displayNoticesByNames(this.responseXML.getElementsByTagName("notice_by_name"));
				getNoticesOfFirstInList();
				// console.log(this.responseXML);
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
	
	xhttp.open("GET", "php/get_notices_by_names.php", true);
	xhttp.overrideMimeType("text/xml");
	xhttp.send();
}

function displayNoticesByNames(notice_by_names_list) {
	var list_notices_by = document.getElementById("list-notices-by");
	var notice_by_names = "";
	var name = "";
	for(var i = 0; i < notice_by_names_list.length; i++) {
		name = notice_by_names_list[i].textContent.toLowerCase(); 
		notice_by_names+="<input type=\"radio\" name=\"ntcs-by\" id=\"notices-by-"+name+"\"	onclick=\"getNoticesBy_Ajax('"+name+"')\" />"+
						 "<label class=\"ntcs-by\" for=\"notices-by-"+name+"\">"+name.toUpperCase()+"</label>";
	}
	list_notices_by.innerHTML = notice_by_names;
	list_notices_by.style.display = "flex";
}