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

function getDate(unixtime) {
	var date = getDayLabels(unixtime);
	if(date=="") {
		var w_options = {hour12:true, weekday:"short"};
		var d_options = {hour12:true, day:"2-digit"};
		var m_options = {hour12:true, month:"short"};
		var y_options = {hour12:true, year:"numeric"};
		
		date = getOptions(unixtime, w_options)+" "+getOptions(unixtime, d_options)+" "+getOptions(unixtime, m_options)+", "+getOptions(unixtime, y_options);
	}
	return date;
}

function getOptions(unixtime, options) {
	return new Intl.DateTimeFormat('en-US', options).format(Number(unixtime) * 1000);
}

function getDayLabels(unixtime) {
	var dt1 = new Date(Number(unixtime) *1000);
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