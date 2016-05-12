function customerRegistrationValidation()
{
    if(document.getElementById("frmCustomerFirstName").value=="")
    {       
       alert("Please enter first name.") ;
       document.getElementById("frmCustomerFirstName").focus();
       return false;
        
    }
    
   if(document.getElementById("frmCustomerEmail").value=="")
    {       
       alert("Please enter email address.") ;
       document.getElementById("frmCustomerEmail").focus();
       return false;
        
    }
    
    if(document.getElementById("frmCustomerEmail").value!="")
    {       
        
        var email = document.getElementById('frmCustomerEmail');
        var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

        if (!filter.test(email.value)) {
        alert('Please provide a valid email address');
        email.focus();
        return false;  
        }
       
    
        
    }   
    
    
    
    if(document.getElementById("frmCustomerConfirmEmail").value=="")
    {       
       alert("Please enter confirm email address.") ;
       document.getElementById("frmCustomerConfirmEmail").focus();
       return false;
        
    }
    
    if(document.getElementById('frmCustomerEmail').value!=document.getElementById('frmCustomerConfirmEmail').value)
    
        {
   
         alert('Email Id Do Not Match!');  
          document.getElementById('frmCustomerConfirmEmail').focus();
         return false;       
    
      }

    
    
    
  if(document.getElementById("frmCustomerPassword").value=="")
    {       
       alert("Please enter password.") ;
       document.getElementById("frmCustomerPassword").focus();
       return false;
        
    }
    
    
    
   if(document.getElementById("frmCustomerConfirmPassword").value=="")
    {       
       alert("Please enter confirm password.") ;
       document.getElementById("frmCustomerConfirmPassword").focus();
       return false;
        
    }
    
    if(document.getElementById('frmCustomerPassword').value!=document.getElementById('frmCustomerConfirmPassword').value)
        {  
          
         document.getElementById('frmCustomerPassword').value=="";
         document.getElementById('frmCustomerConfirmPassword').value=="";
         alert('Password Do Not Match!'); 
          document.getElementById('frmCustomerConfirmPassword').focus();
         return false;
           
         
       }
    

    
   if(document.getElementById("frmBillingFirstName").value=="")
    {       
       alert("Please enter recipient first name.") ;
       document.getElementById("frmBillingFirstName").focus();
       return false;
        
    }
    
    
   if(document.getElementById("frmBillingOrganizationName").value=="")
    {       
       alert("Please enter billing organization name.") ;
       document.getElementById("frmBillingOrganizationName").focus();
       return false;
        
    }
    
   if(document.getElementById("frmBillingAddressLine1").value=="")
    {       
       alert("Please enter billing address line 1.") ;
       document.getElementById("frmBillingAddressLine1").focus();
       return false;
        
    }
    
    
   if(document.getElementById("frmBillingCountry").value=="")
    {       
       alert("Please enter billing country.") ;
       document.getElementById("frmBillingCountry").focus();
       return false;
        
    }   
    
    
   if(document.getElementById("frmBillingPostalCode").value=="")
    {       
       alert("Please enter billing post code.") ;
       document.getElementById("frmBillingPostalCode").focus();
       return false;
        
    }   
    
    
    
  if(document.getElementById("frmBillingPhone").value=="")
    {       
       alert("Please enter billing phone.") ;
       document.getElementById("frmBillingPhone").focus();
       return false;
        
    }
    
      
   if(document.getElementById("frmShippingFirstName").value=="")
    {       
       alert("Please enter recipient first name.") ;
       document.getElementById("frmShippingFirstName").focus();
       return false;
        
    }
    
    
  if(document.getElementById("frmShippingOrganizationName").value=="")
    {       
       alert("Please enter shipping organization name.") ;
       document.getElementById("frmShippingOrganizationName").focus();
       return false;
        
    }
    
    if(document.getElementById("frmShippingAddressLine1").value=="")
    {       
        alert("Please enter shipping address line 1.") ;
       document.getElementById("frmShippingAddressLine1").focus();
       return false;
        
    }
    
    
   
   if(document.getElementById("frmShippingCountry").value=="")
    {       
       alert("Please enter shipping country.") ;
       document.getElementById("frmShippingCountry").focus();
       return false;
        
    }
    
    
   if(document.getElementById("frmShippingPostalCode").value=="")
    {       
      alert("Please enter shipping post code.") ;
       document.getElementById("frmShippingPostalCode").focus();
       return false;
        
    }   
      
    
   if(document.getElementById("frmShippingPhone").value=="")
    {       
       alert("Please enter shipping phone.") ;
       document.getElementById("frmShippingPhone").focus();
       return false;
        
    }
    
  
    
    
}