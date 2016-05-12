function isEmail(id, message, focus) {
	
	var element = $(id);	
	if(element) {		
		str = element.val();		//alert(str);		
		str = jQuery.trim(str);		//alert(str);		str = jQuery.trim(str);
		if(Validate.isEmail(str)) {
			element.removeClass('error_input');
			$(id+'_errMsg').html('');
			$(id+'_errMsg').hide();
			return true;
		}
		else {
			element.addClass('error_input');
			if(focus)
				setFocus(element);			
			$(id+'_errMsg').show();
			$(id+'_errMsg').html(message);
		}
	}
	return false;
}

function isNotEmpty(id, message, focus) {	
	var element = $(id);
	if(element) {		
		str = element.val();		//alert(str);		
		str = jQuery.trim(str);		//alert(str);		str = jQuery.trim(str);
		if(Validate.isNotEmpty(str)) {
			element.removeClass('error_input');
			$(id+'_errMsg').html('');
			$(id+'_errMsg').hide();
			return true;
		}
		else {
			element.addClass('error_input');
			if(focus)
				setFocus(element);
			$(id+'_errMsg').show();
			$(id+'_errMsg').html(message);
		}
	}
	return false;
}




function isNotZero(id, message, focus) {	
	var element = $(id);
	if(element) {		
		str = element.val();		//alert(str);		
		str = jQuery.trim(str);		//alert(str);		str = jQuery.trim(str);
		if(Validate.isNotZero(str)) {
			element.removeClass('error_input');
			$(id+'_errMsg').html('');
			$(id+'_errMsg').hide();
			return true;
		}
		else {
			element.addClass('error_input');
			if(focus)
				setFocus(element);
			$(id+'_errMsg').show();
			$(id+'_errMsg').html(message);
		}
	}
	return false;
}



function isNumericFloat(id, message, focus) {	
	var element = $(id);
	if(element) {		
		str = element.val();		//alert(str);		
		str = jQuery.trim(str);		//alert(str);		str = jQuery.trim(str);
		if(Validate.isNumericFloat(str)) {
			element.removeClass('error_input');
			$(id+'_errMsg').html('');
			$(id+'_errMsg').hide();
			return true;
		}
		else {
			element.addClass('error_input');
			if(focus)
				setFocus(element);
			$(id+'_errMsg').show();
			$(id+'_errMsg').html(message);
		}
	}
	return false;
}



//if(checkNotEmpty('#negotiationScope'))
function checkNotEmpty(id) {	
	var element = $(id);
	if(element) {		
		str = element.val();		//alert(str);		
		str = jQuery.trim(str);		//alert(str);		str = jQuery.trim(str);
		if(Validate.isNotEmpty(str)) {		
			return true;
		}		
	}
	return false;
}






function checkLength(id, len, message, focus) { 	//alert(id);
	var element = $(id);
	if(element) {		
		str = element.val();		//alert(str);		
		str = jQuery.trim(str);		//alert(str);		str = jQuery.trim(str);
		if(Validate.isCompleteLength(str, len)) {
			element.removeClass('error_input');
			$(id+'_errMsg').html('');
			$(id+'_errMsg').hide();
			return true;
		}
		else {
			element.addClass('error_input');
			if(focus)
				setFocus(element);
			$(id+'_errMsg').show();
			$(id+'_errMsg').html(message);
		}
	}
	return false;
}

/*
 * 
 *
 * verifies if at least one checkbox is checked from check box array
 * if(!isMinCheckboxChecked('frmSiteModuleId[]', '#assignRoles_errMsg', 'select module'))
 * return false
 */

function isMinCheckboxChecked(checkboxArrayName, errorId, message)
{		
	if(checkboxCheckedCount(checkboxArrayName))
	{		
		$(errorId).html('').hide();
		return true;
	}
	else
	{
		$(errorId).show().html(message);
	}
	return false;
}




function checkValidPassword(id, message, focus) {	
	var element = $(id);
	if(element) {		
		str = element.val();		//alert(str);		
		str = jQuery.trim(str);		//alert(str);		str = jQuery.trim(str);
		if(Validate.isValidPassword(str)) {
			element.removeClass('error_input');
			$(id+'_errMsg').html('');
			$(id+'_errMsg').hide();
			return true;
		}
		else {
			element.addClass('error_input');
			if(focus)
				setFocus(element);
			$(id+'_errMsg').show();
			$(id+'_errMsg').html(message);
		}
	}
	return false;
}



function confirmPassword(id1, id2, message, focus) { 	//alert(id);
	var element1 = $(id1);
	var element2 = $(id2);
	if(element1 && element2) {		
		str1 = element1.val();		//alert(str);		
		str1 = jQuery.trim(str1);		//alert(str);		str = jQuery.trim(str);
		
		str2 = element2.val();		//alert(str);		
		str2 = jQuery.trim(str2);		//alert(str);		str = jQuery.trim(str);
		
		if(Validate.isConfirmPassword(str1, str2)) {
			element2.removeClass('error_input');
			$(id2+'_errMsg').html('').hide();
			return true;
		}
		else {
			element2.addClass('error_input');
			if(focus)
				setFocus(element1);
			$(id2+'_errMsg').show();
			$(id2+'_errMsg').html(message);
		}
	}
	return false;
}




function isPhoneNumber(id, message, focus) {
	var element = $(id);
	if(element) {
		str = element.val();		//alert(str);		
		str = jQuery.trim(str);	
		if(Validate.isPhoneNumber(str)) {
			element.removeClass('error_input');
			$(id+'_errMsg').html('');
			$(id+'_errMsg').hide();
			return true;
		}
		else {
			element.addClass('error_input');
			if(focus)
				setFocus(element);
			$(id+'_errMsg').show();
			$(id+'_errMsg').html(message);
		}
	}
	return false;
}



function isUrl(id, message, focus) {
	
	var element = $(id);	
	if(element) {		
		str = element.val();		//alert(str);		
		str = jQuery.trim(str);		//alert(str);		str = jQuery.trim(str);
		if(Validate.isUrl(str)) {
			element.removeClass('error_input');
			$(id+'_errMsg').html('');
			$(id+'_errMsg').hide();
			return true;
		}
		else {
			element.addClass('error_input');
			if(focus)
				setFocus(element);			
			$(id+'_errMsg').show();
			$(id+'_errMsg').html(message);
		}
	}
	return false;		
}



function isCardNumber(id, message) {
	var element = $(id);
	if(element) {
		if(Validate.isCardNumber(element.val())) {
			element.removeClass('error_input');
			return true;
		}
		else {
			element.addClass('error_input');
			setFocus(element);
			alert(message);
		}
	}
	return false;
}

function checkSource(formId, linkId, message) {
	var link = $(linkId);
	var file = $('order-file');
	if(link && file) {
		if(Validate.isUrl(link.value) || Validate.isNotEmpty(file.value)) {
			link.removeClass('error_input');
			file.removeClass('error_input');
			return true;
		}
		else {
			link.addClass('error_input');
			file.addClass('error_input');
			setFocus(link);
			alert(message);
		}
	}
	return false;
}

function checkEmail(formId, emailId, message) {
	var emailElement = $(emailId);
	if(emailElement) {
		var email = emailElement.getProperty('value').trim().toLowerCase();
		var emailReg = /^[a-z]*\:\d*$/;
		if(Validate.isEmail(email) || emailReg.test(email)) {
			emailElement.removeClass('error_input');
			return true;
		}
		else {
			emailElement.addClass('error_input');
			setFocus(emailElement);
			alert(message);
		}
	}
	return false;
}



function setFocus(element) {
	try {
		element.focus();
	}
	catch(e) {}
}



//Function will validate website url of passed website
function validateUrl(value)
{
	var url = value.toLowerCase();
	var urlReg = /^(https?:\/\/)?.+\..+$/i;
	return urlReg.test(url);
}