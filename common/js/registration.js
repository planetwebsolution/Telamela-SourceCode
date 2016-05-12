function validateRegistrationForm()
{
	
	errorFlag = 0;
	
	
	if($('#userEmail').val() == '')
	{
		$('#userEmail_errMsg_container').show();
		$('#userEmail_errMsg').html(ENTER_EMAIL);
		errorFlag = 1;
		
	}
	else if(!isEmail('#userEmail', 'Please enter your valid email addresss.', true))
	{
		$('#userEmail_errMsg_container').show();
		$('#userEmail_errMsg').html(ENTER_VALID_EMAIL);
		errorFlag = 1;
	}
	else
	{
		$('#userEmail_errMsg_container').hide();
		$('#userEmail_errMsg').html('');
	}
	
	if($('#userPassword').val() == '')
	{
		$('#userPassword_errMsg_container').show();
		$('#userPassword_errMsg').html(ENTER_PASSWORD);
		errorFlag = 1;
		
	}
	else if(!checkValidPassword('#userPassword', 'Please enter valid password.', true))
	{        
		$('#userPassword_errMsg_container').show();
		$('#userPassword_errMsg').html(ENTER_VALID_PASSWORD);
		errorFlag = 1;
	   
	}
	else
	{
		$('#userPassword_errMsg_container').hide();
		$('#userPassword_errMsg').html('');
	}
	
	if($('#userConfirmPassword').val() == '')
	{
		$('#userConfirmPassword_errMsg_container').show();
		$('#userConfirmPassword_errMsg').html(RE_ENTER_PASSWORD);
		errorFlag = 1;
		
	}
	else
	{
		$('#userConfirmPassword_errMsg_container').hide();
		$('#userConfirmPassword_errMsg').html('');
	}
	
	
	
	if($('#userConfirmPassword').val() != '')
	{
		if($('#userPassword').val() != $('#userConfirmPassword').val())
		{
			$('#userConfirmPassword_errMsg_container').show();
			$('#userConfirmPassword_errMsg').html(PASS_CONFIRMPASS_SAME);
			errorFlag = 1;
			
		}
		else
		{
			$('#userConfirmPassword_errMsg_container').hide();
			$('#userConfirmPassword_errMsg').html('');
		}
	}
	
	
	
	if($('#userFirstName').val() == '')
	{
		$('#userFirstName_errMsg_container').show();
		$('#userFirstName_errMsg').html(ENTER_FIRST_NAME);
		errorFlag = 1;
		
	}
	else
	{
		$('#userFirstName_errMsg_container').hide();
		$('#userFirstName_errMsg').html('');
	}
	
	if($('#userCountry').val() == '')
	{
		$('#userCountry_errMsg_container').show();
		$('#userCountry_errMsg').html(SEL_COUNTRY_NAME);
		errorFlag = 1;
		
	}
	else
	{
		$('#userCountry_errMsg_container').hide();
		$('#userCountry_errMsg').html('');
	}
	if(!$('#conditions').attr('checked'))
	{
		$('#conditions_errMsg_containerID').show();
		$('#conditions_errMsgID').html(T_C);
		errorFlag = 1;
		
	}
	else
	{
		$('#conditions_errMsg_containerID').hide();
		$('#conditions_errMsgID').html('');
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

function validateLoginForm()
{
	errorFlag = 0;
	
	
	if($('#userLoginEmail').val() == '' || $('#userLoginEmail').val() =='Enter Your Email')
	{
		$('#userLoginEmail_errMsg_container').show();
		$('#userLoginEmail_errMsg').html(ENTER_EMAIL);
		errorFlag = 1;
		//return false;
	}
	else if(!isEmail('#userLoginEmail', 'Please enter your valid email addresss.', true))
	{
		$('#userLoginEmail_errMsg_container').show();
		$('#userLoginEmail_errMsg').html(ENTER_VALID_EMAIL);
		errorFlag = 1;return false;
	}
	else
	{
		$('#userLoginEmail_errMsg_container').hide();
		$('#userLoginEmail_errMsg').html('');
	}
	
	if($('#userLoginPassword').val() == '' || $('#userLoginPassword').val() =='Enter Your Password')
	{
		$('#userLoginPassword_errMsg_container').show();
		$('#userLoginPassword_errMsg').html(ENTER_PASSWORD);
		errorFlag = 1;
		
	}
	else
	{
		$('#userLoginPassword_errMsg_container').hide();
		$('#userLoginPassword_errMsg').html('');
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

function validateForgotPasswordForm()
{
	errorFlag = 0;
	
	
	if($('#userLoginEmail').val() == '')
	{
		$('#userLoginEmail_errMsg_container').show();
		$('#userLoginEmail_errMsg').html(ENTER_EMAIL);
		errorFlag = 1;
		
	}
	else if(!isEmail('#userLoginEmail', 'Please enter your valid email addresss.', true))
	{
		$('#userLoginEmail_errMsg_container').show();
		$('#userLoginEmail_errMsg').html(ENTER_VALID_EMAIL);
		errorFlag = 1;return false;
	}
	else
	{
		$('#userLoginEmail_errMsg_container').hide();
		$('#userLoginEmail_errMsg').html('');
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

function validateWholeSalerRegistrationForm()
{
	errorFlag = 0;
	
	
	if($('#userFirstName').val() == '')
	{
		$('#userFirstName_errMsg_container').show();
		$('#userFirstName_errMsg').html(ENTER_FIRST_NAME);
		errorFlag = 1;
		
	}
	else
	{
		$('#userFirstName_errMsg_container').hide();
		$('#userFirstName_errMsg').html('');
	}
	
	if($('#userLastName').val() == '')
	{
		$('#userLastName_errMsg_container').show();
		$('#userLastName_errMsg').html(ENTER_LAST_NAME);
		errorFlag = 1;
		
	}
	else
	{
		$('#userLastName_errMsg_container').hide();
		$('#userLastName_errMsg').html('');
	}
	
	
	if($('#userEmail').val() == '')
	{
		$('#userEmail_errMsg_container').show();
		$('#userEmail_errMsg').html(ENTER_EMAIL);
		errorFlag = 1;
		
	}
	else if($('#userEmail').val()!='')
	{
		var varEmail = $('#userEmail').val();
		var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
		if(filter.test(varEmail))
		{
			$('#userEmail_errMsg_container').hide();
			$('#userEmail_errMsg').html('');
		}
		else
		{
			$('#userEmail_errMsg_container').show();
			$('#userEmail_errMsg').html(ENTER_VALID_EMAIL);
			errorFlag = 1;
		}
	}
	else
	{
		$('#userEmail_errMsg_container').hide();
		$('#userEmail_errMsg').html('');
	}
	
	if($('#userPassword').val() == '')
	{
		$('#userPassword_errMsg_container').show();
		$('#userPassword_errMsg').html(ENTER_PASSWORD);
		errorFlag = 1;
		
	}
	else
	{
		$('#userPassword_errMsg_container').hide();
		$('#userPassword_errMsg').html('');
	}
	/*if($('#userPassword').val() == '')
	{
		$('#userPassword_errMsg_container').show();
		$('#userPassword_errMsg').html('Please enter password.');
		errorFlag = 1;
		
	}
	else if(!checkValidPassword('#userPassword', 'Please enter valid password.', true))
	{        
		$('#userPassword_errMsg_container').show();
		$('#userPassword_errMsg').html('Please enter valid password.');
		errorFlag = 1;
	   
	}
	else
	{
		$('#userPassword_errMsg_container').hide();
		$('#userPassword_errMsg').html('');
	}
	
	/*if($('#userPhone').val() == '')
	{
		$('#userPhone_errMsg_container').show();
		$('#userPhone_errMsg').html('Please enter phone number.');
		errorFlag = 1;
		
	}
	else
	{
		$('#userPhone_errMsg_container').hide();
		$('#userPhone_errMsg').html('');
	}
	*/
	
	if($('#businessName').val() == '')
	{
		$('#businessName_errMsg_container').show();
		$('#businessName_errMsg').html(ENTER_BUSINESS_NAME);
		errorFlag = 1;
		
	}
	else
	{
		$('#businessName_errMsg_container').hide();
		$('#businessName_errMsg').html('');
	}
	
	if($('#businessAddress1').val() == '')
	{
		$('#businessAddress1_errMsg_container').show();
		$('#businessAddress1_errMsg').html(ENTER_EMAIL);
		errorFlag = 1;
		
	}
	else
	{
		$('#businessAddress1_errMsg_container').hide();
		$('#businessAddress1_errMsg').html('');
	}
	
	
	if($('#frmCountry').val() == '')
	{
		$('#country_errMsg_container').show();
		$('#country_errMsg').html(SEL_COUNTRY_NAME);
		errorFlag = 1;
		
	}
	else
	{
		$('#country_errMsg_container').hide();
		$('#country_errMsg').html('');
	}
	
	if($('#frmState').val() == '')
	{
		$('#statezip').show();
		$('#frmState_errMsg_container').show();
		$('#frmState_errMsg').html(SEL_STATE_NAME);
		errorFlag = 1;
		
	}
	else
	{
		$('#frmState_errMsg_container').hide();
		$('#frmState_errMsg').html('');
	}
	
	if($('#myzipCode').val() == '')
	{
		$('#statezip').show();
		$('#zipCode_errMsg_container').show();
		$('#zipCode_errMsg').html(ENTER_ZIP_CODE);
		errorFlag = 1;

	}
	else
	{
		$('#zipCode_errMsg_container').hide();
		$('#zipCode_errMsg').html('');
	}
		
	
	if($('#myzipCode').val()!='' && $('#frmState').val() != '' )
	{
		$('#statezip').hide();
	}
	
	
	
	if($('#frmCity').val() == '')
	{
		$('#city_errMsg_container').show();
		$('#city_errMsg').html(ENTER_CITY_NAME);
		errorFlag = 1;
		
	}
	else
	{
		$('#city_errMsg_container').hide();
		$('#city_errMsg').html('');
	}
	
	
	//VALIDATION FOR US MANDATORY FIELDS
	if($('#frmCountry').val()==2)
	{
		if($('#federalTaxID').val() == '')
		{
			$('#federalTaxID_errMsg_container').show();
			$('#federalTaxID_errMsg').html(ENTER_FEDRAL_TAX);
			errorFlag = 1;
			
		}
		else
		{
			$('#federalTaxID_errMsg_container').hide();
			$('#federalTaxID_errMsg').html('');
		}
		
		if($('#frmTaxFile').val() == '')
		{
			$('#taxFile_errMsg_container').show();
			$('#taxFile_errMsg').html(UPLOAD_BUSINESS_TEX);
			errorFlag = 1;
			
		}
		else
		{
			$('#taxFile_errMsg_errMsg_container').hide();
			$('#taxFile_errMsg').html('');
		}
	}
	
	if($('#businessPhone').val() == '')
	{
		$('#businessPhone_errMsg_container').show();
		$('#businessPhone_errMsg').html(ENTER_BUSINESS_PHONE);
		errorFlag = 1;
		
	}
	else
	{
		$('#businessPhone_errMsg_container').hide();
		$('#fbusinessPhone_errMsg').html('');
	}	
	
	if(!$('#conditions').attr('checked'))
	{
		$('#conditions_errMsg_container').show();
		$('#conditions_errMsg').html(ACCECPT_T_C);
		errorFlag = 1;
		
	}
	else
	{
		$('#conditions_errMsg_container').hide();
		$('#conditions_errMsg').html('');
	}
	
	
	
	
	if($('#captcha').val() == '')
	{
		$('#captcha_errMsg_container').show();
		$('#captcha_errMsg').html(ENTER_CHARACTER_IN_BOX);
		errorFlag = 1;
		
	}
	else
	{
		$('#captcha_errMsg_container').hide();
		$('#captcha_errMsg').html('');
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

function usfields(id)
{
	$('#usfields').show();
	if(id==2)
	{
		$('#usfields').show();
	}
	else
	{
		$('#usfields').hide();
	}
}

function showRegistrationForm()
{
	if($('#registrationFormHeadingContainer').is(':visible'))
	{
		$('#registrationFormHeadingContainer').hide();
		$('#registrationFormContainer').hide();
	}
	else
	{
		$('#registrationFormHeadingContainer').show();
		$('#registrationFormContainer').show();
		$('html, body').animate({ 
		scrollTop: $('#registrationFormHeadingContainer').offset().top 
		  }, 3000);

	}
}

function validateResetPasswordForm()
{
	errorFlag = 0;
	
	
	if($('#userOldPassword').val() == '')
	{
		$('#userOldPassword_errMsg_container').show();
		$('#userOldPassword_errMsg').html(ENTER_OLD_PASSWORD);
		errorFlag = 1;
		
	}
	else if(!checkValidPassword('#userOldPassword', 'Please enter valid password.', true))
	{        
		$('#userOldPassword_errMsg_container').show();
		$('#userOldPassword_errMsg').html(ENTER_VALID_PASSWORD);
		errorFlag = 1;
	   
	}	
	else
	{
		$('#userOldPassword_errMsg').html('');
		$('#userOldPassword_errMsg_container').hide();
		
	}
	if($('#userNewPassword').val() == '')
	{
		$('#userNewPassword_errMsg_container').show();
		$('#userNewPassword_errMsg').html(ENTER_NEW_PASSWORD);
		errorFlag = 1;
		
	}
	else if(!checkValidPassword('#userNewPassword', 'Please enter valid password.', true))
	{        
		$('#userNewPassword_errMsg_container').show();
		$('#userNewPassword_errMsg').html(ENTER_VALID_PASSWORD);
		errorFlag = 1;
	   
	}
	else
	{
		$('#userNewPassword_errMsg').html('');
		$('#userNewPassword_errMsg_container').hide();
	}
	if($('#userConfirmPassword').val() == '')
	{
		$('#userConfirmPassword_errMsg_container').show();
		$('#userConfirmPassword_errMsg').html(CON_NEW_PASSWORD);
		errorFlag = 1;
		
	}
	else if(!checkValidPassword('#userConfirmPassword', 'Please enter valid password.', true))
	{        
		$('#userConfirmPassword_errMsg_container').show();
		$('#userConfirmPassword_errMsg').html(ENTER_VALID_PASSWORD);
		errorFlag = 1;
	   
	}
	else if($('#userNewPassword').val() != $('#userConfirmPassword').val())
	{
		$('#userConfirmPassword_errMsg_container').show();
		$('#userConfirmPassword_errMsg').html(NEW_PASS_CONFIRMPASS_SAME);
		errorFlag = 1;
	}
	else
	{
		$('#userConfirmPassword_errMsg').html('');
		$('#userConfirmPassword_errMsg_container').hide();
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

$(document).ready(function() {
	
    $('#submit').click(function () {
	errorFlag = 0;
	var emailId = $("input#emailId").val();
	var PhoneNumber = $("input#PhoneNumber").val();
	if((emailId == ''||emailId == 'Insert your E-mail') && (PhoneNumber==''||PhoneNumber == 'Insert your Mobile Number'))
	{
		
		$('#userCoupanEmail_errMsg_container').show();
		$('#userCoupanEmail_errMsg').html(ENTER_EMAIL_MOBILE);
		errorFlag = 1;
		
	}
	else if(emailId!='' && emailId != 'Insert your E-mail')
	
		{
			
			if(!isEmail('#emailId', 'Please enter your valid email addresss.', true))
			{
				$('#userCoupanEmail_errMsg_container').show();
				$('#userCoupanEmail_errMsg').html(ENTER_VALID_EMAIL_ID);
				errorFlag = 1;
			}
			else
		        {
			
			$('#userCoupanEmail_errMsg_container').hide();
			$('#userCoupanEmail_errMsg').html('');
			errorFlag = 0;
		         }
			
		}
		
		
	
	if(PhoneNumber!='' && PhoneNumber != 'Insert your Mobile Number')
	{
	               if(!isPhoneNumber('#PhoneNumber', 'Please enter valid phone no.', true))
			{
				
				$('#userCoupanPhone_errMsg_container').show();
				$('#userCoupanPhone_errMsg').html(ENTER_VALID_PHONE_NO);
				errorFlag = 1;
			}
			else
			{
				$('#userCoupanPhone_errMsg_container').hide();
				$('#userCoupanPhone_errMsg').html('');
				errorFlag = 0;	
			}
	}
	
	if(errorFlag==0)
	{
	var data= 'emailId=' + emailId+ '&PhoneNumber=' + PhoneNumber+ '&action=submitcoupan';
	//alert(data);
	$.ajax({
            //this is the php file that processes the data and send mail
            url: "registration_action.php",
             
        
            type: "POST",
 
            //pass the data        
            data: data,    
             
            //Do not cache the page
            cache: false,
             
            //success
	   
            success: function (data) {
		
		//alert(data);
		
		var response=eval(data);
		var id=response[0].varId;
		//alert(id);
		var message=response[0].Message;
		//alert(message);
		if(id==false)
		{
		
		$('#userCoupanEmail_errMsg_container').show();
		$('#userCoupanEmail_errMsg').html(message);
		}
		else
		{
		$('#sucessmessage').html(message);	
		}
		
            }      
        });
	
	}
	return false;
    });
	
});