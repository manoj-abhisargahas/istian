function login_validate() {
	msgIndicate("error-indicate", false, "");
	
	var validate = true;
	var email_id = "login-email";
	var pword_id = "login-pword";
	var error_email_id = "error-indicate-login-email";
	var error_pword_id = "error-indicate-login-pword";
	var email_ele = document.getElementById(email_id);
	var pword_ele = document.getElementById(pword_id);
	var email_value = email_ele.value.trim();
	var pword_value = pword_ele.value;
	
	//checking if email empty/not
	if(email_value=="" || email_value==null) {
		email_ele.value = "";
		msgIndicate(error_email_id, true, errors_list["153"]);
		textfieldErrorShow(email_id, true);
		validate = false;
	}
	//checking if email format is valid/not
	else if(!isEmailValid(email_value)) {
		msgIndicate(error_email_id, true, errors_list["114"]);
		textfieldErrorShow(email_id, true);
		validate = false;
	}
	else {
		msgIndicate(error_email_id, false, "");
		textfieldErrorShow(email_id, false);
	}
	
	//checking if pword empty/not
	if(pword_value=="" || pword_value==null) {
		msgIndicate(error_pword_id, true, errors_list["154"]);
		textfieldErrorShow(pword_id, true);
		validate = false;
	}
	//checking pword length
	else if((pword_value.length < 8) || (pword_value.length > 16)) {
		msgIndicate(error_pword_id, true, errors_list["155"]);
		textfieldErrorShow(pword_id, true);
		validate = false;
	}
	else {
		msgIndicate(error_pword_id, false, "");
		textfieldErrorShow(pword_id, false);
	}
	
	return validate;
}