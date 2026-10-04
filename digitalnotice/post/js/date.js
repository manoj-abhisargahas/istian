//Here, unixtime_s is in seconds
//(but javascript default, unixtime is in milliseconds)
function getTimeAndDate(unixtime_s) {
	var t_options = {hour12:true, hour:"2-digit", minute:"2-digit"};
	return getTime(unixtime_s)+", "+getDate(unixtime_s);
}

function getTime(unixtime_s) {
	var t_options = {hour12:true, hour:"2-digit", minute:"2-digit"};
	return getOptions(unixtime_s, t_options);
}

function getDate(unixtime_s) {
	var date = getDayLabels(unixtime_s);
	if(date=="") {
		var w_options = {hour12:true, weekday:"short"};
		var d_options = {hour12:true, day:"2-digit"};
		var m_options = {hour12:true, month:"short"};
		var y_options = {hour12:true, year:"numeric"};
		
		date = getOptions(unixtime_s, w_options)+" "+getOptions(unixtime_s, d_options)+" "+getOptions(unixtime_s, m_options)+", "+getOptions(unixtime_s, y_options);
	}
	return date;
}

function getOptions(unixtime_s, options) {
	return new Intl.DateTimeFormat('en-US', options).format(Number(unixtime_s) * 1000);
}

function getDayLabels(unixtime_s) {
	var dt1 = new Date(Number(unixtime_s) *1000);
	var dt2 = new Date();
	dt1 = new Date(dt1.getMonth()+"/"+dt1.getDate()+"/"+dt1.getFullYear());
	dt2 = new Date(dt2.getMonth()+"/"+dt2.getDate()+"/"+dt2.getFullYear());
	var dt_diff = (dt2-dt1)/(1000*60*60*24);
	
	if(dt_diff==1) {
		return "Yesterday";
	}
	else if(dt_diff==0) {
		return "Today";
	}
	else if(dt_diff==-1) {
		return "Tomorrow";
	}
	return "";
}

function onDateSelect(ele, datetext_ele_id) {
	var datetext_ele = document.getElementById(datetext_ele_id);
	var expired_indicator = document.getElementById("new_notice-expired_indicator");
	var required_notice_expiry_date = document.getElementById("required-notice_expiry_date");
	if(ele.value=="") {
		datetext_ele.innerHTML = "Select date";
		expired_indicator.checked = false;
	}
	else {
		var date_local_tz = new Date(ele.value);
		var actual_date_format = new Intl.DateTimeFormat('en-US');
		var date = new Date(actual_date_format.format(date_local_tz));
		unixtime_s = date.getTime()/1000;
		datetext_ele.innerHTML = getDate(unixtime_s);
		if(isExpired(unixtime_s)) {
			expired_indicator.checked = true;
		}
		else {
			expired_indicator.checked = false;
		}
		required_notice_expiry_date.checked = false;
	}
}

function isExpired(unixtime_s) {
	return ((Number(unixtime_s) - Math.trunc(Date.now()/1000)) <= 0);
}

function is_Expires_Tomorrow(unixtime_s) {
	return ((Number(unixtime_s) - Math.trunc(Date.now()/1000)) <= (60 * 60 * 24)); //60sec * 60min * 24hours = 1day
}