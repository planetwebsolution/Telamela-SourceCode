function validateContactForm()
{
	errorFlag = 0;
	
	if($('#firstName').val() == '')
	{
		$('#firstName_errMsg_container').show();
		$('#firstName_errMsg').html('Please enter first name.');
		errorFlag = 1;
		//return false;
	}
	else
	{
		$('#firstName_errMsg_container').hide();
		$('#firstName_errMsg').html('');
	}
	if($('#lastName').val() == '')
	{
		$('#lastName_errMsg_container').show();
		$('#lastName_errMsg').html('Please enter last name.');
		errorFlag = 1;
		//return false;
	}
	else
	{
		$('#lastName_errMsg_container').hide();
		$('#lastName_errMsg').html('');
	}
	if($('#email').val() == '')
	{
		$('#email_errMsg_container').show();
		$('#email_errMsg').html('Please enter email address.');
		errorFlag = 1;
		//return false;
	}
	else if(!isEmail('#email', 'Please enter valid email addresss.', true))
	{
		$('#email_errMsg_container').show();
		$('#email_errMsg').html('Please enter valid email addresss.');
		errorFlag = 1;return false;
	}
	else
	{
		$('#email_errMsg_container').hide();
		$('#email_errMsg').html('');
	}
	if($('#addressLine1').val() == '')
	{
		$('#addressLine1_errMsg_container').show();
		$('#addressLine1_errMsg').html('Please enter address.');
		errorFlag = 1;
		//return false;
	}
	else
	{
		$('#addressLine1_errMsg_container').hide();
		$('#addressLine1_errMsg').html('');
	}
	if($('#phone').val() == '')
	{
		$('#phone_errMsg_container').show();
		$('#phone_errMsg').html('Please enter phone number.');
		errorFlag = 1;
		//return false;
	}
	else
	{
		$('#phone_errMsg_container').hide();
		$('#phone_errMsg').html('');
	}
	if($('#country1').val() == '')
	{
		$('#country1_errMsg_container').show();
		$('#country1_errMsg').html('Please select country name.');
		errorFlag = 1;
		//return false;
	}
	else
	{
		$('#country1_errMsg_container').hide();
		$('#country1_errMsg').html('');
	}
	
	
	if(errorFlag)
	{
		return false;
	}
	else
	{
		return true;
	}

}
