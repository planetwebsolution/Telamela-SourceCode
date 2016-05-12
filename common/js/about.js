function validateAddCandidateForm()
{
	errorFlag = 0;
	
	
	if($('#candidateFirstName').val() == '' || $('#candidateFirstName').val() == 'First Name')
	{
		$('#candidateFirstName_errMsg_container').show();
		$('#candidateFirstName_errMsg').html('Please enter first name.');
		errorFlag = 1;
	}
	else
	{
		$('#candidateFirstName_errMsg').html('');
		$('#candidateFirstName_errMsg_container').hide();
	}
	
	if($('#candidatePhone').val() == '' || $('#candidatePhone').val() == 'Phone')
	{
		$('#candidatePhone_errMsg_container').show();
		$('#candidatePhone_errMsg').html('Please enter phone number.');
		errorFlag = 1;
	}
	else
	{
		$('#candidatePhone_errMsg').html('');
		$('#candidatePhone_errMsg_container').hide();
	}
	
	if($('#candidateEmail').val() == '' || $('#candidateEmail').val() == 'Email')
	{
		$('#candidateEmail_errMsg_container').show();
		$('#candidateEmail_errMsg').html('Please enter email address.');
		errorFlag = 1;
	}
	else if(!isEmail('#candidateEmail', 'Please enter valid email addresss.', true))
	{
		$('#candidateEmail_errMsg_container').show();
		$('#candidateEmail_errMsg').html('Please enter valid email addresss.');
		errorFlag = 1;
	}
	else
	{
		$('#candidateEmail_errMsg').html('');
		$('#candidateEmail_errMsg_container').hide();
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
