var Validate = {

	isEmail: function(value) {
		var email = value.toLowerCase();
		var emailReg = /^[a-z0-9!#_=~.+-]+@[a-z0-9\.\-]+\.[a-z]{2,4}$/;
		return emailReg.test(email);	
	},

	isNotEmpty: function(value) {
		return value;
	},
	
	isNotZero: function(value) {		
		return value > 0;
	},
	
	isNumericFloat: function(value) {
		var numericFloat = /^ *[0-9.]+ *$/;
		return numericFloat.test(value);	
	},
	
	isCompleteLength: function(value, len) { 		// alert(value.length);		alert(value.length >= len);
		return value.length >= len;
	},
			
	
	/*
	 
	Description

	(			    # 	Start of group
	(?=.*\d)		#   must contains one digit from 0-9
	(?=.*[a-z])		#   must contains one lowercase characters
	(?=.*[A-Z])		#   must contains one uppercase characters
	(?=.*[@#$%])	#   must contains one special symbols in the list "@#$%"
    .				#   match anything with previous condition checking
    {6,20}			#   length at least 6 characters and maximum of 20	
	)				# 	End of group
	
	*/
	
	isValidPassword: function(password) { 		// alert(value.length);		alert(value.length >= len);
		//var passwordReg = /^((?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[@#$%]).{6,40})$/
		//var passwordReg = /^((?=.*[a-zA-Z0-9@#$%^&*]).{6,40})$/
		var passwordReg = /^(?:[A-Za-z0-9-.,@:?!()$#/\\]+|&(?!#))+$/
		return (passwordReg.test(password))? true : false; //alert(t);		
	},
	
	
	isConfirmPassword: function(str1, str2) { 		// alert(value.length);		alert(value.length >= len);
		return str1 == str2;
	},

	isPhoneNumber: function(value) {
		//var phoneNumber = value.replace(new RegExp('^[0-9() -]', 'g'), '');
		//alert(value);
		var phoneNumber = /^[0-9()+ -]*$/.test(value);
		if(value.length < 10)
		{
			phoneNumber = false;
		}	

		return phoneNumber; // >= 10;
	},

	isUrl: function(value) {
		var url = value.toLowerCase();
		var urlReg = /^(https?:\/\/)?.+\..+$/i;	
		//var urlReg = /http:\/\/[A-Za-z0-9\.-]{3,}\.[A-Za-z]{3}/;
		return urlReg.test(url);
	},

	isCardNumber: function(value) {
		var creditCardNumber = value.replace(new RegExp('[^0-9]', 'g'), '');
		return creditCardNumber.length >= 13;
	}
}
