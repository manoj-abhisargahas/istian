function resetNewPword_validate() {
	msgIndicate("error-indicate", false, "");
	
	var validate = true;
	var pword_id = "reset_new_pword-pword";
	var retype_pword_id = "reset_new_pword-retype_pword";
	var error_pword_id = "error-indicate-reset_new_pword-pword";
	var error_retype_pword_id = "error-indicate-reset_new_pword-retype_pword";
	var pword_ele = document.getElementById(pword_id);
	var retype_pword_ele = document.getElementById(retype_pword_id);
	var pword_value = pword_ele.value;
	var retype_pword_value = retype_pword_ele.value;
	
	//checking if pword empty/not
	if(pword_value=="" || pword_value==null) {
		msgIndicate(error_pword_id, true, errors_list["154"]);
		textfieldErrorShow(pword_id, true);
		validate = false;
	}
	//checking if pword valid/not
	else if(!isPasswordValid(pword_value)) {
		msgIndicate(error_pword_id, true, errors_list["156"]);
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
	
	//checking if retype-pword empty/not
	if(retype_pword_value=="" || retype_pword_value==null) {
		msgIndicate(error_retype_pword_id, true, errors_list["157"]);
		textfieldErrorShow(retype_pword_id, true);
		validate = false;
	}
	//checking if pword and retype-pword are equal/not
	else if(!(pword_value==retype_pword_value)) {
		msgIndicate(error_retype_pword_id, true, errors_list["158"]);
		textfieldErrorShow(retype_pword_id, true);
		validate = false;
	}
	else {
		msgIndicate(error_retype_pword_id, false, "");
		textfieldErrorShow(retype_pword_id, false);
	}
	
	return validate;
}