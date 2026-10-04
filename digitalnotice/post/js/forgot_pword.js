function forgotPword_validate() {
	msgIndicate("error-indicate", false, "");
	
	var validate = true;
	var email_id = "forgot_pword-email";
	var error_email_id = "error-indicate-forgot_pword-email";
	var email_ele = document.getElementById(email_id);
	var email_value = email_ele.value.trim();
	
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
	
	return validate;
}