/******************************************
Function name : validator for category form in admin
Return type : boolean
Date created : 20th April 2011
Date last modified : 20th April 2011
Author : Ranjeet Singh
Last modified by : Ranjeet Singh
Comments : Function will return the true or error message after validating form
User instruction : validateCategory(formname)
 ******************************************/
function validateCategory(formname)
{
    if(validateForm(formname,'frmCategoryName', 'Category Name', 'R'))
    {	
        return true;
    }
    else
    {
        return false;
    }
		
}
/******************************************
Function name : validator for GarmentLocation form in admin
Return type : boolean
Date created : 20th April 2011
Date last modified : 20th April 2011
Author : Deepesh Pathak
Last modified by : Deepesh Pathak
Comments : Function will return the true or error message after validating form
User instruction : validateGarmentLocation(formname)
 ******************************************/
function validateModule(formname)
{
    if(validateForm(formname, 'frmRollName', 'Roll Name', 'R'))
    {	
        return true;
    }
    else
    {
        return false;
    }
		
}

/******************************************
Function name : Show all attribute list with its option  Acc to category
Return type : boolean
Date created : 06May2011
Date last modified : 06May2011
Author : Deepesh Pathak
Last modified by : Deepesh Pathak
Comments : Function will return the true or error message after validating form
User instruction : validateBrand(formname)
 ******************************************/
function showAttribute(str){
             
    if(str==0){
        $('#attribute').html('<input type="hidden" name="frmIsAttribute" value="0" class="input2" />'+SEL_CATEGORY);
    }else{
        $.post("admin/ajax.php",{
            action:'ShowAttribute',
            ajax_request:'valid',
            catid:str
        },
        function(data)
        {
            $('#attribute').html(data);
        }
        );
    }       
}

/******************************************
Function name : Show Currency and Margin Cost
Return type : boolean
Date created : 06May2011
Date last modified : 06May2011
Author : Deepesh Pathak
Last modified by : Deepesh Pathak
Comments : Function will return the true or error message after validating form
User instruction : validateBrand(formname)
 ******************************************/
function showCurrencyInUSD(showId){
    var amount = $.trim($('#frmWholesalePrice'+showId).val());
   
    var from = $('#frmCurrency'+showId).val();        
    if(amount==''){
        $('#InUSD'+showId).html('');
        $('#frmWholesalePriceInUSD'+showId).val('');
        $('#FinalPriceInUSD'+showId).html('');
        $('#frmProductPrice'+showId).val('');
        return false;
    }    
    $('#InUSD'+showId).html('Calculating..');
    
    $.post('../common/ajax/ajax_converter.php',{
        action:'showCurrency',
        amount:amount,
        from:from,
        to:'USD'
    },
    function(data){                
        var p = data.split("--");
        $('#InUSD'+showId).html('$ '+p[0]);
        $('#frmWholesalePriceInUSD'+showId).val(p[0]);
        $('#FinalPriceInUSD'+showId).html('$ '+p[1]);
        $('#frmProductPrice'+showId).val(p[1]);
    });
            
}
/******************************************
Function name : Show Final Price
Return type : boolean
Date created : 06May2011
Date last modified : 06May2011
Author : Deepesh Pathak
Last modified by : Deepesh Pathak
Comments : Function will return the true or error message after validating form
User instruction : validateBrand(formname)
 ******************************************/
function showFinalPriceForMultipleProduct(showid){ 
    var amount = $.trim($('#frmWholesalePrice'+showid).val());
    var margincast = $('#frmMarginCast').val();           
    if(amount==''){
        $('#FinalPrice'+showid).html('');
        $('#frmProductPrice'+showid).val('');
        return false;
    }else{
        var ac = parseFloat(amount);
        var mc = parseFloat(margincast);
        var finalprice= ac+(ac*mc/100);
        
        $('#FinalPrice'+showid).html('$'+finalprice);
        $('#frmProductPrice'+showid).val(finalprice);  
    }
            
}

function showDiscountPriceForMultipleProduct(showid){
    var amount = $.trim($('#frmDiscountPrice'+showid).val());
    var margincast = $('#frmMarginCast').val();           
    if(amount==''){
        $('#DiscountFinalPrice'+showid).html('');
        $('#frmDiscountFinalPrice'+showid).val('');
        return false;
    }else{
        var ac = parseFloat(amount);
        var mc = parseFloat(margincast);
        var finalprice= ac+(ac*mc/100);
        
        $('#DiscountFinalPrice'+showid).html('$'+finalprice);
        $('#frmDiscountFinalPrice'+showid).val(finalprice);  
    }
            
}


function checkPositive(val,id){ 
   var statrMsg=$('#'+id).attr('placeholder');
   if($.trim(val)!='' && $.trim(val)<=0){
      alert(statrMsg+' should be greator then 0');
      $('#'+id).val('');
      return false;
   }
}

/******************************************
Function name : Delete Image from product edit page 
Return type : boolean
Date created : 06May2011
Date last modified : 06May2011
Author : Deepesh Pathak
Last modified by : Deepesh Pathak
Comments : Function will return the true or error message after validating form
User instruction : validateBrand(formname)
 ******************************************/
function deleteImage(str){
    if(str==''){
        $('#img'+str).html(INVALID_ACTION);
    }else{
        $.post("admin/ajax.php",{
            action:'deleteImage',
            ajax_request:'valid',
            imgid:str
        },
        function(data)
        {
            $('#img'+str).html(data);
        }
        );
    }       
}

/******************************************
Function name : Show all attribute list with its option  Acc to category
Return type : boolean
Date created : 06May2011
Date last modified : 06May2011
Author : Deepesh Pathak
Last modified by : Deepesh Pathak
Comments : Function will return the true or error message after validating form
User instruction : validateBrand(formname)
 ******************************************/
function ShowAttributeMultipleProduct(str,id){
       
    if(str==0){
        $('#attribute'+id).html('<input type="hidden" name="frmIsAttribute[]" value="0" class="input2" />'+SEL_CATEGORY);
    }else{
        $.post("admin/ajax.php",{
            action:'ShowAttributeMultipleProduct',
            ajax_request:'valid',
            catid:str,
            showid:id
        },
        function(data)
        {
            
            $('#attribute'+id).html(data);
            
        }
        );
    }       
}

/******************************************
Function name : validation for Coupon add/edit page
Return type : boolean
Date created : 06May2011
Date last modified : 06May2011
Author : Deepesh Pathak
Last modified by : Deepesh Pathak
Comments : Function will return the true or error message after validating form
User instruction : validateBrand(formname)
 ******************************************/
function validateCouponForm(){
    var applyTo;
    var frmCouponName = document.getElementById('frmCouponName');
    var frmCouponCode = document.getElementById('frmCouponCode');
    var frmCoupon = document.getElementById('frmCoupon'); 
    var frmDiscount = document.getElementById('frmDiscount');
    var frmApplyOn = document.getElementsByName('frmApplyOn');      
        
    if(frmApplyOn[1].checked){
        applyTo=0;
         
    }else{
        applyTo=1;
    }
   
    
    if(frmCouponName.value==''){                        
        alert(COUPON_NAME_REQ);
        frmCouponName.focus();
        return false;
    }else if(frmCouponCode.value==''){                        
        alert(COUPON_CODE_REQ);
        frmCouponCode.focus();
        return false;
    }else if(frmCoupon.value=='1'){                        
        alert(COUPON_CODE_AL_USE);
        frmCouponCode.select();
        return false;
    }else if(frmDiscount.value==''){                        
        alert(DISCOUNT_REQ);
        frmDiscount.focus();
        return false;
    }else if(AcceptDecimal(frmDiscount.value)==false){                        
        alert(ENTER_NUMRIC_DECIMAL);
        frmDiscount.select();
        return false;
    }else if(frmDiscount.value > 100){                        
        alert(DISCOUNT_LESS_THEN_100);
        frmDiscount.select();
        return false;
    }else if(applyTo==0){
        var frmCategoryId = document.getElementsByName('frmCategoryId[]');
        var frmProductId = document.getElementsByName('frmProductId[]');
        
        for (var i = 0; i < frmCategoryId.length; i++) {              
                       
            if(frmCategoryId[i].value==0){
                alert(SEL_CATEGORY);
                frmCategoryId[i].focus();
                return false;
            }else if(frmProductId[i].value==0){
                alert(SEL_PRODUCT);
                frmProductId[i].focus();
                return false;
            }   
        }
    }
                    
        
}

/******************************************
Function name : validation for package add page
Return type : boolean
Date created : 06May2011
Date last modified : 06May2011
Author : Deepesh Pathak
Last modified by : Deepesh Pathak
Comments : Function will return the true or error message after validating form
User instruction : validateBrand(formname)
 ******************************************/
function validatePackageAddPageForm(str,id){
    var frmPackageName = document.getElementById('frmPackageName');
    var frmCategoryId = document.getElementsByName('frmCategoryId[]');
    var frmProductId = document.getElementsByName('frmProductId[]');
    var frmOfferPrice = document.getElementById('frmOfferPrice');
    //alert(frmCategoryId.length);
    
    if(frmPackageName.value==''){                        
        alert(PACKAGE_R);
        frmPackageName.focus();
        return false;
    }  
                    
    for (var i = 0; i < frmCategoryId.length; i++) {              
                       
        if(frmCategoryId[i].value==0){
            alert(SEL_CATEGORY);
            frmCategoryId[i].focus();
            return false;
        }else if(frmProductId[i].value==0){
            alert(SEL_PRODUCT);
            frmProductId[i].focus();
            return false;
        }   
    }
                    
    if(frmOfferPrice.value==''){
        alert(OFFER_PRICE);
        frmOfferPrice.focus();
        return false;
    }else if(AcceptDecimal(frmOfferPrice.value)==false){
        alert(ENTER_NUMRIC);
        frmOfferPrice.focus();
        return false;        
    }     
}

/******************************************
Function name : Show all attribute list with its option  Acc to category
Return type : boolean
Date created : 06May2011
Date last modified : 06May2011
Author : Deepesh Pathak
Last modified by : Deepesh Pathak
Comments : Function will return the true or error message after validating form
User instruction : validateBrand(formname)
 ******************************************/
function ShowRegion(str){
       
    if(str==''){
        $('#regions').html('<select name="frmRegion" id="frmRegion"><option value="">'+SEL_REG+'</option></select>');
    }else{
        $.post("admin/ajax.php",{
            action:'ShowRegion',
            ajax_request:'valid',
            ctyid:str
        },
        function(data)
        {
            
            $('#regions').html(data);
        }
        );
    }       
}

/******************************************
Function name : Show Product related to category 
Return type : boolean
Date created : 06May2011
Date last modified : 06May2011
Author : Deepesh Pathak
Last modified by : Deepesh Pathak
Comments : Function will return the true or error message after validating form
User instruction : validateBrand(formname)
 ******************************************/
function ShowProductForPackage(str,id){
    
    $('#price'+id).html('<input type="hidden" name="frmPrice[]" class="input1" value="0.00" /><b>0.00</b>');
    var frmPrice = document.getElementsByName('frmPrice[]');
    var total=0,i,p,a=0;
    //alert(frmPrice[0].value);
    for(i=0; i<frmPrice.length;i++)
    {
        p = parseFloat(frmPrice[i].value);
        total = total+p;
            
    }
        
    total = total.toFixed(2);
    $('#asc').html(total);
    if(str==0){
        $('#product'+id).html('<select name="frmProductId[]" style="width:170px;"><option>'+PRODUCT+'</option></select>');
        
    }else{
        $.post("admin/ajax.php",{
            action:'ShowProductForPackage',
            ajax_request:'valid',
            catid:str,
            showid:id
        },
        function(data)
        {
            $('#product'+id).html(data);
        }
        );
    }       
}
/******************************************
Function name : Show Product price
Return type : boolean
Date created : 06May2011
Date last modified : 06May2011
Author : Deepesh Pathak
Last modified by : Deepesh Pathak
Comments : Function will return the true or error message after validating form
User instruction : validateBrand(formname)
 ******************************************/
function ShowProductPriceForPackage(str,id){ 
      
    if(str==0){
        $('#price'+id).html('<input type="hidden" name="frmPrice[]" class="input1" value="0.00" /><b>0.00</b>');
        var frmPrice = document.getElementsByName('frmPrice[]');
        var total=0,i,p,a=0;
        //alert(frmPrice[0].value);
        for(i=0; i<frmPrice.length;i++)
        {
            p = parseFloat(frmPrice[i].value);
            total = total+p;
            
        }
        
        total = total.toFixed(2);
        $('#asc').html(total);
    }else{
        $.post("admin/ajax.php",{
            action:'ShowProductPriceForPackage',
            ajax_request:'valid',
            pid:str,
            showid:id
        },
        function(data)
        {
            $('#price'+id).html(data);
            var frmPrice = document.getElementsByName('frmPrice[]');
            var total=0,i,p,a=0;
            //alert(frmPrice[0].value);
            for(i=0; i<frmPrice.length;i++)
            {
                p = parseFloat(frmPrice[i].value);
                total = total+p;
            
            }
        
            total = total.toFixed(4);
            $('#asc').html(total); 
            
        }
        );
            
    }       
}

/******************************************
Function name : Check  Product Ref No 
Return type : boolean
Date created : 06May2011
Date last modified : 06May2011
Author : Deepesh Pathak
Last modified by : Deepesh Pathak
Comments : Function will return the true or error message after validating form
User instruction : validateBrand(formname)
 ******************************************/
function checkProductRefNo(str){
      
    if(str==''){
        $('#refmsg').html('<input type="hidden" name="frmIsRefNo" value="0" />');
    }else{
        $.post("admin/ajax.php",{
            action:'checkProductRefNo',
            ajax_request:'valid',
            refno:str
        },
        function(data)
        {
            $('#refmsg').html(data);
        }
        );
    }       
}

/******************************************
Function name : Check Coupon Code
Return type : boolean
Date created : 06May2011
Date last modified : 06May2011
Author : Deepesh Pathak
Last modified by : Deepesh Pathak
Comments : Function will return the true or error message after validating form
User instruction : checkCouponCode(formname)
 ******************************************/
function checkCouponCode(id){
    var d;
    var str = $('#frmCouponCode').val();
    
    if(str==''){
        $('#frmCoupon').val('0');
    }else{
        $.post("admin/ajax.php",{
            action:'checkCouponCode',
            ajax_request:'valid',
            code:str,
            id:id
        },
        function(data)
        {
            if(data=='0'){                
                d = ''; 
            }else{
                d=COUPON_CODE_AL_USE;
            }
            $('#frmCoupon').val(data);
            $('#code').html(d);
        }
        );
    }       
}

function checkProductRefNoForMultiple(str,showid){
    
    if(str==''){
        $('#refmsg'+showid).html('<input type="hidden" name="frmIsRefNo[]" value="0" />');
    }else{
        $.post("admin/ajax.php",{
            action:'checkProductRefNoForMultiple',
            ajax_request:'valid',
            refno:str,
            showid:showid
        },
        function(data)
        {
            $('#refmsg'+showid).html(data);
        }
        );
    }       
}
/******************************************
Function name : validator for form Admin page Limit
Return type : boolean
Date created : 06May2011
Date last modified : 06May2011
Author : Deepesh Pathak
Last modified by : Deepesh Pathak
Comments : Function will return the true or error message after validating form
User instruction : validateBrand(formname)
 ******************************************/
function validateAdminPageLimit(formname)
{
    if(validateForm(formname, 'frmRecordPerpage', 'Record Per Page Limit', 'R'))
    {	
        var varPageLimit=document.getElementById("frmRecordPerpage").value;
        if(IsDigits(trim(varPageLimit))==true)
        {
            alert(RECORD_PER_PAGE_LIMIT);
            return false;
        }
        else if(varPageLimit<5)
        {
            alert(RECORD_PER_PAGE_LIMIT_LESS_5);
            return false;
        }
        return true;
    } 
    else 
    {
        return false;
    } 
}



/******************************************
Function name : checkWholeSalerEmail
Return type : boolean
Date created : 06May2011
Date last modified : 06May2011
Author : Deepesh Pathak
Last modified by : Deepesh Pathak
Comments : Function will return the true or error message after validating form
User instruction : checkWholeSalerEmail(formname)
 ******************************************/
function checkWholeSalerEmail(id){
    var d;
    var str = $('#frmCompanyEmail').val();
    
    if(str==''){
        $('#frmCEmail').val('0');
        $('#CompanyEmail').html('');
    }else{
        $.post("admin/ajax.php",{
            action:'checkWholeSalerEmail',
            ajax_request:'valid',
            code:str,
            id:id
        },
        function(data)
        {
            if(data=='0'){                
                d = ''; 
            }else{
                d=EMAIL_AL_IN_USE;
            }
            $('#frmCEmail').val(data);
            $('#CompanyEmail').html(d);
        }
        );
    }       
}
/******************************************
Function name : showRegionForWholesaler
Return type : boolean
Date created : 06May2011
Date last modified : 06May2011
Author : Deepesh Pathak
Last modified by : Deepesh Pathak
Comments : Function will return the true or error message after validating form
User instruction : showRegionForWholesaler(formname)
 ******************************************/
function showRegionForWholesaler(str,showid){
      
    if(str==0){
        $('#'+showid).html('<option>'+SEL+'</option>');
    }else{
        $.post("admin/ajax.php",{
            action:'showRegionForWholesaler',
            ajax_request:'valid',
            q:str
        },
        function(data)
        {
            $('#'+showid).html(data);
        }
        );
    }       
}

/******************************************
Function name : validator for form Wholesaler Add 
Return type : boolean
Date created : 06May2011
Date last modified : 06May2011
Author : Deepesh Pathak
Last modified by : Deepesh Pathak
Comments : Function will return the true or error message after validating form
User instruction : validateBrand(formname)
 ******************************************/
function validateWholesalerAddForm(frm)
{
      
    if(frm.frmCompanyName.value==''){
        alert(COMPANY_NAME_REQ);
        frm.frmCompanyName.focus();
        return false;
    }else if(frm.frmAboutCompany.value==''){
        alert(AB_COM_REQ);
        frm.frmAboutCompany.focus();
        return false;
    }else if(frm.frmAboutCompany.value.length<200){
        alert(MINIM_200_REQ);   
        frm.frmAboutCompany.focus();
        return false;
    }else if(frm.frmCommission.value==''){
        alert(COMMIS_REQ);
        frm.frmCommission.focus();
        return false;
    }else if(IsChecked(frm.frmShippingGateway)==false){
        alert(SHIPP_GET_REQ);
        frm.frmShippingGateway[0].focus();
        return false;
    }else if(AcceptDecimal(frm.frmCommission.value)==false){
        alert(ENTER_VALID_COMMIS);
        frm.frmCommission.focus();
        return false;        
    }else if(frm.frmCompanyAddress1.value==''){
        alert(ADDRESS_REQ);
        frm.frmCompanyAddress1.focus();
        return false;
    }else if(frm.frmCompanyCity.value==''){
        alert(CITY_REQ);
        frm.frmCompanyCity.focus();
        return false;
    }else if(frm.frmCompanyCountry.value=='0'){
        alert(SEL_COUNTRY_NAME);
        frm.frmCompanyCountry.focus();
        return false;
    }else if(frm.frmCompanyPostalCode.value==''){
        alert(POSTCODE_REQ);
        frm.frmCompanyPostalCode.focus();
        return false;
    }else if(IsDigits(frm.frmCompanyPostalCode.value)==true){
        alert(ENTER_VALID_POSTALCODE);
        frm.frmCompanyPostalCode.focus();
        return false;
    }else if(frm.frmCompanyEmail.value==''){
        alert(COM_EMAIL_REQ);
        frm.frmCompanyEmail.focus();        
        return false;
    }else if(AcceptEmail(frm.frmCompanyEmail.value)==false){
        alert(ENTER_VALID_COM_EMAIL);
        frm.frmCompanyEmail.focus();
        return false;
    }else if(frm.frmCEmail.value==''){
        alert(EMAIL_AL_IN_USE);
        frm.frmCompanyEmail.focus();        
        return false;
    }else if(frm.frmPassword.value==''){
        alert(PASS_R);
        frm.frmPassword.focus();        
        return false;
    }else if(frm.frmConfirmPassword.value==''){
        alert(CON_PASS_REQ);
        frm.frmConfirmPassword.focus();        
        return false;
    }else if(frm.frmPassword.value!=frm.frmConfirmPassword.value){
        alert(PASS_CONFIRMPASS_SAME);
        frm.frmConfirmPassword.focus();        
        return false;
    }else if(frm.frmCompanyPhone.value==''){
        alert(COM_PHONE_REQ);
        frm.frmCompanyPhone.focus();        
        return false;
    }else if(IsPhone(frm.frmCompanyPhone.value)==false){
        alert(ENTER_VALID_PHONE);
        frm.frmCompanyPhone.focus();
        return false;
    }else if(frm.frmContactPersonName.value==''){
        alert(CONTACT_NAME_REQ);
        frm.frmContactPersonName.focus();        
        return false;
    }else if(frm.frmContactPersonPosition.value==''){
        alert(CONTACT_POSITION_REQ);
        frm.frmContactPersonPosition.focus();        
        return false;
    }else if(frm.frmContactPersonPhone.value==''){
        alert(CONTACT_PHONE_REQ);
        frm.frmContactPersonPhone.focus();        
        return false;
    }else if(IsPhone(frm.frmContactPersonPhone.value)==false){
        alert(ENTER_VALID_PHONE);
        frm.frmContactPersonPhone.focus();
        return false;
    }else if(frm.frmContactPersonEmail.value==''){
        alert(CONTACT_EMAIL_REQ);
        frm.frmContactPersonEmail.focus();        
        return false;
    }else if(AcceptEmail(frm.frmContactPersonEmail.value)==false){
        alert(ENTER_VALID_CONTACT_PERSON_EMAIL);
        frm.frmContactPersonEmail.focus();
        return false;
    }else if(frm.frmContactPersonAddress.value==''){
        alert(CONTACT_ADDRESS_REQ);
        frm.frmContactPersonAddress.focus();        
        return false;
    }else if(frm.frmOwnerName.value==''){
        alert(OWNER_NAME_REQ);
        frm.frmOwnerName.focus();        
        return false;
    }else if(frm.frmOwnerPhone.value==''){
        alert(OWNER_PHONE_REQ);
        frm.frmOwnerPhone.focus();        
        return false;
    }else if(IsPhone(frm.frmOwnerPhone.value)==false){
        alert(ENTER_VALID_PHONE);
        frm.frmOwnerPhone.focus();
        return false;
    }else if(frm.frmOwnerEmail.value==''){
        alert(OWNER_EMAIL_REQ);
        frm.frmOwnerEmail.focus();        
        return false;
    }else if(AcceptEmail(frm.frmOwnerEmail.value)==false){
        alert(OWNER_INVALID_EMAIL);
        frm.frmOwnerEmail.focus();
        return false;
    }else if(frm.frmOwnerAddress.value==''){
        alert(OWNER_ADDRESS_REQ);
        frm.frmOwnerAddress.focus();        
        return false;
    }else if(frm.frmRef1Name.value==''){
        alert(REF_NAME_REQ);
        frm.frmRef1Name.focus();        
        return false;
    }else if(frm.frmRef1Phone.value==''){
        alert(REF_PHONE_REQ);
        frm.frmRef1Phone.focus();        
        return false;
    }else if(IsPhone(frm.frmRef1Phone.value)==false){
        alert(ENTER_VALID_PHONE);
        frm.frmRef1Phone.focus();
        return false;
    }else if(frm.frmRef1Email.value==''){
        alert(REF_EMAIL_REQ);
        frm.frmRef1Email.focus();        
        return false;
    }else if(AcceptEmail(frm.frmRef1Email.value)==false){
        alert(REF_VALID_EMAIL_REQ);
        frm.frmRef1Email.focus();
        return false;
    }else if(frm.frmRef1CompanyName.value==''){
        alert(REF_COMPANY_NAME_REQ);
        frm.frmRef1CompanyName.focus();        
        return false;
    }else if(frm.frmRef1CompanyAddress.value==''){
        alert(REF_ADDRESS_REQ);
        frm.frmRef1CompanyAddress.focus();        
        return false;
    }else if(frm.frmRef2Name.value==''){
        alert(REF2_NAME_REQ);
        frm.frmRef2Name.focus();        
        return false;
    }else if(frm.frmRef2Phone.value==''){
        alert(REF2_PHONE_REQ);
        frm.frmRef2Phone.focus();        
        return false;
    }else if(IsPhone(frm.frmRef2Phone.value)==false){
        alert(ENTER_VALID_PHONE);
        frm.frmRef2Phone.focus();
        return false;
    }else if(frm.frmRef2Email.value==''){
        alert(REF2_EMAIL_REQ);
        frm.frmRef2Email.focus();        
        return false;
    }else if(AcceptEmail(frm.frmRef2Email.value)==false){
        alert(REF2_VALID_EMAIL_REQ);
        frm.frmRef2Email.focus();
        return false;
    }else if(frm.frmRef2CompanyName.value==''){
        alert(REF2_COMPANY_NAME_REQ);
        frm.frmRef2CompanyName.focus();        
        return false;
    }else if(frm.frmRef2CompanyAddress.value==''){
        alert(REF2_ADDRESS_REQ);
        frm.frmRef2CompanyAddress.focus();        
        return false;
    }else if(frm.frmRef3Name.value==''){
        alert(REF3_NAME_REQ);
        frm.frmRef3Name.focus();        
        return false;
    }else if(frm.frmRef3Phone.value==''){
        alert(REF3_PHONE_REQ);
        frm.frmRef3Phone.focus();        
        return false;
    }else if(IsPhone(frm.frmRef3Phone.value)==false){
        alert(ENTER_VALID_PHONE);
        frm.frmRef3Phone.focus();
        return false;
    }else if(frm.frmRef3Email.value==''){
        alert(REF3_EMAIL_REQ);
        frm.frmRef3Email.focus();        
        return false;
    }else if(AcceptEmail(frm.frmRef3Email.value)==false){
        alert(REF3_VALID_EMAIL_REQ);
        frm.frmRef3Email.focus();
        return false;
    }else if(frm.frmRef3CompanyName.value==''){
        alert(REF3_COMPANY_NAME_REQ);
        frm.frmRef3CompanyName.focus();        
        return false;
    }else if(frm.frmRef3CompanyAddress.value==''){
        alert(REF3_ADDRESS_REQ);
        frm.frmRef3CompanyAddress.focus();        
        return false;
    }else return true;
    
}



function IsChecked(objRadio){
    for(var i=0;i<objRadio.length;i++){
        if(objRadio[i].checked){
            return true;
            
        }
    }
    return false;
    
}
/******************************************
Function name : validator for form Product Add 
Return type : boolean
Date created : 06May2011
Date last modified : 06May2011
Author : Deepesh Pathak
Last modified by : Deepesh Pathak
Comments : Function will return the true or error message after validating form
User instruction : validateBrand(formname)
 ******************************************/
function validateProductAddForm(frm)
{
    var frmProductImg = document.getElementsByName('frmProductImg[]');
    //alert(frmProductImg.length);
   


    if(frm.frmCountryID.value==0){
        alert(SEL_COUNTRY_NAME);
        frm.frmCountryID.focus();        
        return false;
    }else if(frm.frmfkWholesalerID.value==0){
        alert(SEL_WHOL_NAME);
        frm.frmfkWholesalerID.focus();        
        return false;
    }else if(frm.frmfkShippingID.value==0){
        alert(SEL_SHIPP_GET);
        frm.frmfkShippingID.focus();        
        return false;
    }else if(frm.frmfkCategoryID.value==0){
        alert(SEL_CATEGORY);
        frm.frmfkCategoryID.focus();        
        return false;
    }else if(frm.frmProductRefNo.value==''){
        alert(PRODUCT_REF_REQ);
        frm.frmProductRefNo.focus();
        return false;
    }else if(frm.frmProductName.value==''){
        alert(PRODUCT_NAME_REQ);
        frm.frmProductName.focus();
        return false;
    }else if(frm.frmWholesalePrice.value==''){
        alert(WHOL_PRICE_REQ);
        frm.frmWholesalePrice.focus();
        return false;
    }else if(AcceptDecimal(frm.frmWholesalePrice.value)==false){
        alert(ENTER_NUMRIC);
        frm.frmWholesalePrice.focus();
        return false;        
    }else if(frmProductImg.length>0){
        for (var i = 0; i < frmProductImg.length; i++) {       
            var f = frmProductImg[i];
            var ff = f.value;
        
            if(ff!=''){
                var exte = ff.substring(ff.lastIndexOf('.') + 1);
                var ext = exte.toLowerCase();
                if(ext!='jpg' && ext!='jpeg' && ext!='gif' && ext!='png'){
                    alert(ACCEPTED_IMAGE_FOR);
                    frm.frmProductImg[i].focus();
                    return false;
                    
                }
            }
        }
    }
    if(frm.frmQuantity.value==''){
        alert(STOCK_QUA_REQ);
        frm.frmQuantity.focus();
        return false;
    }else if(IsDigits(frm.frmQuantity.value)==true){
        alert(ENTER_NUMRIC_VAL);
        frm.frmQuantity.focus();
        return false;
    }else if(frm.frmIsRefNo.value==1){
        alert(PRODUCT_REF_ALL_EXIST);
        frm.frmProductRefNo.focus();
        return false;
    }else return true;
    
}

/******************************************
Function name : validator for form Shipping Gateways Add 
Return type : boolean
Date created : 06May2011
Date last modified : 06May2011
Author : Deepesh Pathak
Last modified by : Deepesh Pathak
Comments : Function will return the true or error message after validating form
User instruction : validateBrand(formname)
 ******************************************/
function validateShipplingGatewaysForm(frm)
{
    var frmWeight = document.getElementsByName('frmWeight[]');
    var frmA = document.getElementsByName('frmA[]');
    var frmB = document.getElementsByName('frmB[]');
    var frmC = document.getElementsByName('frmC[]');
    var frmD = document.getElementsByName('frmD[]');
    var frmE = document.getElementsByName('frmE[]');
    var frmF = document.getElementsByName('frmF[]');
    var frmG = document.getElementsByName('frmG[]');
    var frmH = document.getElementsByName('frmH[]');
    var frmI = document.getElementsByName('frmI[]');
    var frmJ = document.getElementsByName('frmJ[]');
    var frmK = document.getElementsByName('frmK[]');
    
   
    if(frm.frmShippingTitle.value==''){
        alert(NAME_REQ);
        frm.frmShippingTitle.focus();
        return false;
    }else if(frmWeight.length>0){
        for(var i=0;i<frmWeight.length;i++){
            if(frmWeight[i].value==''){
                alert(WAIGHT_REQ);
                frmWeight[i].focus();
                return false;
            }else if(AcceptDecimal(frmWeight[i].value)==false){
                alert(ENTER_NUMRIC);
                frmWeight[i].select();
                return false;        
            }else if(frmA[i].value==''){
                alert(ZONE_A_REQ);
                frmA[i].focus();
                return false;
            }else if(AcceptDecimal(frmA[i].value)==false){
                alert(ENTER_NUMRIC);
                frmA[i].select();
                return false;        
            }else if(frmB[i].value==''){
                alert(ZONE_B_REQ);
                frmB[i].focus();
                return false;
            }else if(AcceptDecimal(frmB[i].value)==false){
                alert(ENTER_NUMRIC);
                frmB[i].select();
                return false;        
            }else if(frmC[i].value==''){
                alert(ZONE_C_REQ);
                frmC[i].focus();
                return false;
            }else if(AcceptDecimal(frmC[i].value)==false){
                alert(ENTER_NUMRIC);
                frmC[i].select();
                return false;        
            }else if(frmD[i].value==''){
                alert(ZONE_D_REQ);
                frmD[i].focus();
                return false;
            }else if(AcceptDecimal(frmD[i].value)==false){
                alert(ENTER_NUMRIC);
                frmD[i].select();
                return false;        
            }else if(frmE[i].value==''){
                alert(ZONE_E_REQ);
                frmE[i].focus();
                return false;
            }else if(AcceptDecimal(frmE[i].value)==false){
                alert(ENTER_NUMRIC);
                frmE[i].select();
                return false;        
            }else if(frmF[i].value==''){
                alert(ZONE_F_REQ);
                frmF[i].focus();
                return false;
            }else if(AcceptDecimal(frmF[i].value)==false){
                alert(ENTER_NUMRIC);
                frmF[i].select();
                return false;        
            }else if(frmG[i].value==''){
                alert(ZONE_G_REQ);
                frmG[i].focus();
                return false;
            }else if(AcceptDecimal(frmG[i].value)==false){
                alert(ENTER_NUMRIC);
                frmG[i].select();
                return false;        
            }else if(frmH[i].value==''){
                alert(ZONE_H_REQ);
                frmH[i].focus();
                return false;
            }else if(AcceptDecimal(frmH[i].value)==false){
                alert(ENTER_NUMRIC);
                frmH[i].select();
                return false;        
            }else if(frmI[i].value==''){
                alert(ZONE_I_REQ);
                frmI[i].focus();
                return false;
            }else if(AcceptDecimal(frmI[i].value)==false){
                alert(ENTER_NUMRIC);
                frmI[i].select();
                return false;        
            }else if(frmJ[i].value==''){
                alert(ZONE_J_REQ);
                frmJ[i].focus();
                return false;
            }else if(AcceptDecimal(frmJ[i].value)==false){
                alert(ENTER_NUMRIC);
                frmJ[i].select();
                return false;        
            }else if(frmK[i].value==''){
                alert(ZONE_K_REQ);
                frmK[i].focus();
                return false;
            }else if(AcceptDecimal(frmK[i].value)==false){
                alert(ENTER_NUMRIC);
                frmK[i].select();
                return false;        
            }
        }
        
    }else return true;
    
}


/******************************************
Function name : validator for form validate Default Commission update 
Return type : boolean
Date created : 06May2011
Date last modified : 06May2011
Author : Deepesh Pathak
Last modified by : Deepesh Pathak
Comments : Function will return the true or error message after validating form
User instruction : validateBrand(formname)
 ******************************************/
function validateDefaultCommissionForm(frm)
{   
    if(frm.frmWholesalerSalesCommission.value==''){
        alert(WHOL_SAL_COMMIS);
        frm.frmWholesalerSalesCommission.focus();
        return false;
    }else if(AcceptDecimal(frm.frmWholesalerSalesCommission.value)==false){
        alert(ENTER_NUMRIC);
        frm.frmWholesalerSalesCommission.focus();
        return false;        
    }else  if(frm.frmAdminUsersCommission.value==''){
        alert(COUNTRY_PORTAL_SAL_COMMIS_REQ);
        frm.frmAdminUsersCommission.focus();
        return false;
    }else if(AcceptDecimal(frm.frmAdminUsersCommission.value)==false){
        alert(ENTER_NUMRIC);
        frm.frmAdminUsersCommission.focus();
        return false;        
    }else return true;
    
}

/******************************************
Function name : validator for form validate validateMarginCostForm update 
Return type : boolean
Date created : 06May2011
Date last modified : 06May2011
Author : Deepesh Pathak
Last modified by : Deepesh Pathak
Comments : Function will return the true or error message after validating form
User instruction : validateMarginCostForm(formname)
 ******************************************/
function validateMarginCostForm(frm)
{   
    if(frm.frmMarginCost.value==''){
        alert(MARGIN_COST_REQ);
        frm.frmMarginCost.focus();
        return false;
    }else if(AcceptDecimal(frm.frmMarginCost.value)==false){
        alert(ENTER_NUMRIC);
        frm.frmMarginCost.focus();
        return false;        
    }else return true;
    
}

/*****************************
Function name : validateTicketForm
Return type : boolean
Date created : 10th September 2008
Date last modified : 
Author : Gulshan Verma
Last modified by :
Comments : This is used to validate admin password and confirm passwords.
User instruction : validateTicketForm(formname)
************************************/
function validateKPISettingForm()
{
    var frmCountryId = document.getElementsByName('frmCountryId[]');
    var frmKPIVal = document.getElementsByName('frmKPIVal[]');
   
    for (var i=1; i<frmCountryId.length; i++) {             
                       
        if(frmCountryId[i].value==0){
            alert(SEL_COUNTRY_NAME);
            frmCountryId[i].focus();
            return false;
        }else if(frmKPIVal[i].value==0){
            alert(SEL_VAL);
            frmKPIVal[i].focus();
            return false;
        }  
    }
    return true;

}
/******************************************
Function name : validator for form Multiple Product Add 
Return type : boolean
Date created : 06May2011
Date last modified : 06May2011
Author : Deepesh Pathak
Last modified by : Deepesh Pathak
Comments : Function will return the true or error message after validating form
User instruction : validateBrand(formname)
 ******************************************/
function validateMultipleProductAddForm(frm){
    var frmfkWholesalerID = document.getElementById('frmfkWholesalerID');
    var frmProductRefNo = document.getElementsByName('frmProductRefNo[]');
    var frmIsRefNo = document.getElementsByName('frmIsRefNo[]');
    var frmProductName = document.getElementsByName('frmProductName[]');    
    
    var frmProductPrice = document.getElementsByName('frmProductPrice[]');
    var frmWholesalePrice = document.getElementsByName('frmWholesalePrice[]');
    var frmDiscountPrice = document.getElementsByName('frmDiscountFinalPrice[]');
    var frmDiscountPriceI = document.getElementsByName('frmDiscountPrice[]');
    
    var frmProductSliderImg = document.getElementsByName('frmProductSliderImg[]');
    var slider_image_error = document.getElementsByName('slider_image_error[]');
    var frmProductDefaultImg = document.getElementsByName('frmProductDefaultImg[]');
    var default_image_error = document.getElementsByName('default_image_error[]');
    
    var frmQuantity = document.getElementsByName('frmQuantity[]');
    var frmQuantityAlert = document.getElementsByName('frmQuantityAlert[]');
    var frmfkCategoryID = document.getElementsByName('frmfkCategoryID[]');
    //var frmfkShippingID = document.getElementsByName('frmfkShippingID[]');
    var frmWholesalePrice=document.getElementsByName('frmWholesalePrice[]');
    var frmDiscountPrice=document.getElementsByName('frmDiscountPrice[]');


    if(frmfkWholesalerID.value==0){
        alert(SEL_WHOL);
        frmfkWholesalerID.focus();
        return false;
    }   
    for (var i = 0; i < frmProductRefNo.length; i++) {              
        var frmfkShippingID = document.getElementsByName('frmShippingGateway['+i+'][]');
        
        if(frmProductRefNo[i].value==''){
            alert(PRODUCT_REF_REQ);
            frmProductRefNo[i].focus();
            return false;
        }else if(frmIsRefNo[i].value==1){
            alert(PRO_REF_NO_EXIST);
            frmProductRefNo[i].focus();
            return false;
        }else if(frmProductRefNo.length>1){
            for (var j = 0; j < frmProductRefNo.length; j++) {
                if(frmProductRefNo[i].value==frmProductRefNo[j].value && i!=j){
                    alert(PROD_REF_NO_SAME);
                    frmProductRefNo[j].focus();
                    return false;
                }
            }
        }
        if(parseInt(frmDiscountPrice[i].value) >= parseInt(frmWholesalePrice[i].value)){
           alert('Discount price should not be less then wholesale price');
            frmDiscountPrice[i].focus();
            return false; 
        }
        
        if(frmProductName[i].value==''){
            alert(PRODUCT_NAME_REQ);
            frmProductName[i].focus();
            return false;
        }else if(IsChecked(frmfkShippingID)==false){
            alert(SHIPP_GET_REQ);
            frmfkShippingID[i].focus();
            return false;
        }else if(frmProductPrice[i].value==''){
            alert(PRICE_REQ);
            frmWholesalePrice[i].focus();
            return false;
        }else if(AcceptDecimal(frmProductPrice[i].value)==false){
            alert(ENTER_NUMRIC);
            frmWholesalePrice[i].focus();
            return false;        
        }
        
        
        
        /*
        if(frmProductDefaultImg[i].value==''){
            alert(UPLOAD_DEFAULT);
            frmProductDefaultImg[i].focus();
            return false;        
        }else if(frmProductDefaultImg[i].value!=''){            
            var ff = frmProductDefaultImg[i].value;
            var exte = ff.substring(ff.lastIndexOf('.') + 1);
            var ext = exte.toLowerCase();
            if(ext!='jpg' && ext!='jpeg' && ext!='gif' && ext!='png'){
                alert(ACCEPTED_IMAGE_FOR);
                frmProductDefaultImg[i].focus();
                return false;
            }       
        }
        if (default_image_error[i].value=='0'){                            
            alert(UPLOAD_IMAGE_IN+'('+MIN_PRODUCT_IMAGE_WIDTH+'-'+MAX_PRODUCT_IMAGE_WIDTH+')'+PX_WIDTH_AND+'('+MIN_PRODUCT_IMAGE_HEIGHT+'-'+MAX_PRODUCT_IMAGE_HEIGHT+')'+PX_HEIGHT);            
            frmProductDefaultImg[i].focus();
            return false;
        }else if (default_image_error[i].value=='2'){               
            alert(IMAGE_SIZE_MUST+MAX_PRODUCT_IMAGE_SIZE_IN_KB+KB);
            frmProductDefaultImg[i].focus();
            return false;
        }   
        
        if(frmProductRefNo.length>0){
            var l=i+1;
            var frmProductImg = document.getElementsByName('frmProductImg['+l+'][]');
            var frmProductImgErr = document.getElementsByName('image_error['+l+'][]');
          
            if(frmProductImg.length>0){            
                for(var k=0;k<frmProductImg.length;k++){    
            
                    var ff = frmProductImg[k].value;
                    if(ff!=''){
                        var exte = ff.substring(ff.lastIndexOf('.') + 1);
                        var ext = exte.toLowerCase();
                        if(ext!='jpg' && ext!='jpeg' && ext!='gif' && ext!='png'){
                            alert(ACCEPTED_IMAGE_FOR);
                            frmProductImg[k].focus();
                            return false;
                        }
                    }
                    
                    if (frmProductImgErr[k].value==0){                            
                        alert(UPLOAD_IMAGE_IN+'('+MIN_PRODUCT_IMAGE_WIDTH+'-'+MAX_PRODUCT_IMAGE_WIDTH+')'+PX_WIDTH_AND+'('+MIN_PRODUCT_IMAGE_HEIGHT+'-'+MAX_PRODUCT_IMAGE_HEIGHT+')'+PX_HEIGHT);
                        frmProductImg[k].focus();
                        return false;
                    }
            
                    if (frmProductImgErr[k].value==2){               
                        alert(IMAGE_SIZE_MUST+MAX_PRODUCT_IMAGE_SIZE_IN_KB+KB);
                        frmProductImg[k].focus();
                        return false;
                    }
                    
                    
                }
            }
            
            
        }
        
        */
        if(frmfkCategoryID[i].value==0 || frmfkCategoryID[i].value==''){
            alert(SEL_CATEGORY);
            frmfkCategoryID[i].focus();
            return false;
        }else if(frmQuantity[i].value==''){
            alert(QUANTITY_REQ);
            frmQuantity[i].focus();
            return false;
        }else if(IsDigits(frmQuantity[i].value)==true){
            alert(ENTER_NUMRIC_VAL);
            frmQuantity[i].focus();
            return false;
        }else if(frmQuantityAlert[i].value!='' && IsDigits(frmQuantityAlert[i].value)==true){
            alert(ENTER_NUMRIC_VAL);
            frmQuantity[i].focus();
            return false;
        }else if(IsLessThan(frmQuantity[i].value,frmQuantityAlert[i].value)==false){
            alert("Sent alert message should be less than Stock Quantity !");
            frmQuantity[i].focus();
            return false;
        }
    }

}


/******************************************
Function name : validator for Bulk Upload products 
Return type : boolean
Date created : 06May2011
Date last modified : 06May2011
Author : Deepesh Pathak
Last modified by : Deepesh Pathak
Comments : Function will return the true or error message after validating form
User instruction : validateBrand(formname)
 ******************************************/
function validateBulkUpload(frm){
    
    var frmContentName = document.getElementById('frmContentName');
    var frmFile = document.getElementById('frmFile');
    var frmFields = document.getElementsByName('frmFields[]');  
 
    if(frmContentName.value==''){
        alert(SEL_WANT_TO_UPLOAD);
        frmContentName.focus();
        return false;
    }else if(frmFile.value==''){
        alert(SEL_FILE);
        frmContentName.focus();
        return false;
    }else if(frmFile.value!=''){
        var ff = frmFile.value;
        var ext = ff.substring(ff.lastIndexOf('.') + 1);
        if(ext!='xls' && ext!='xlsx' && ext!='csv'){
            alert(ACCEPTED_FILE);
            frmFile.focus();
            return false;                    
        }
    }
    if(frmContentName.value=='product'){
        for(var i = 0;i<frmFields.length; i++){ 
            if(frmFields[0].checked && frmFields[1].checked && frmFields[2].checked && frmFields[3].checked && frmFields[4].checked && frmFields[8].checked){
                return true;
            }else{
                alert(CHECK_MANDATORY_FIELDS);
                return false;
              
            }
        }
      
    }   
}
 
/******************************************
Function name : validator for form Admin page Limit
Return type : boolean
Date created : 06May2011
Date last modified : 06May2011
Author : Deepesh Pathak
Last modified by : Deepesh Pathak
Comments : Function will return the true or error message after validating form
User instruction : validateBrand(formname)
******************************************/
function validateWholeSalerProductForm(formname)
{
    if(validateForm(formname, 'frmWholeSalerMinimumPurchase', 'Wholesaler Minimum Product', 'R'))
    {	
        return true;
    } 
    else 
    {
        return false;
    } 
}

/******************************************
Function name : validator for Brand form in admin
Return type : boolean
Date created : 20th April 2011
Date last modified : 20th April 2011
Author : Deepesh Pathak
Last modified by : Deepesh Pathak
Comments : Function will return the true or error message after validating form
User instruction : validateBrand(formname)
******************************************/
function validateBrand(formname)
{
    if(validateForm(formname, 'frmBrandName', 'Brand Name', 'R', 'frmCategoryID', 'Brand Category', 'R'))
    {	
        return true;
    } 
    else 
    {
        return false;
    } 
}

/******************************************
Function name : validator for Brand form in admin
Return type : boolean
Date created : 20th April 2011
Date last modified : 20th April 2011
Author : Deepesh Pathak
Last modified by : Deepesh Pathak
Comments : Function will return the true or error message after validating form
User instruction : validateBrand(formname)
******************************************/
function validateCountry(formname)
{
    if(validateForm(formname, 'frmCountryName', 'Country Name', 'R'))
    {	
        return true;
    } 
    else 
    {
        return false;
    } 
}

/******************************************
Function name : validator for Brand form in admin
Return type : boolean
Date created : 20th April 2011
Date last modified : 20th April 2011
Author : Deepesh Pathak
Last modified by : Deepesh Pathak
Comments : Function will return the true or error message after validating form
User instruction : validateBrand(formname)
******************************************/
function validateState(formname)
{
    if(validateForm(formname, 'frmStateName', 'State Name', 'R', 'frmCountry', 'Country Name', 'R'))
    {	
        return true;
    } 
    else 
    {
        return false;
    } 
}



/******************************************
Function name : validator for coupon form in admin
Return type : boolean
Date created : 20th April 2011
Date last modified : 20th April 2011
Author : Deepesh Pathak
Last modified by : Deepesh Pathak
Comments : Function will return the true or error message after validating form
User instruction : validateCoupon(formname)
******************************************/
function validateCoupon(formname)
{
 
    if(validateForm(formname, 'frmCouponCode', 'Coupon Code', 'R','frmCouponPriceValue', 'Price Value', 'RisDecimal', 'frmMinimumPurchaseAmount', 'Minimum Purchase Amount', 'RisDecimal', 'frmCouponPriceValue', 'Price Value', 'regDecimal','frmCouponActivateDate', 'Coupon Activate date', 'R','frmCouponExpiryDate', 'coupon expiry date', 'R'))
    {	
    	
        var CouponActivateDate=document.forms[0].frmCouponActivateDate.value;
        var CouponExpiryDate=document.forms[0].frmCouponExpiryDate.value;
        if(CouponActivateDate > CouponExpiryDate)
        {
            alert(SORRY_CANT_COMPLETE_YOUR_REQ);
            return false;
        }
    } 
    else 
    {
        return false;
    } 
}

/******************************************
Function name : validator for coupon form in admin
Return type : boolean
Date created : 20th April 2011
Date last modified : 20th April 2011
Author : Deepesh Pathak
Last modified by : Deepesh Pathak
Comments : Function will return the true or error message after validating form
User instruction : validateGiftCard(formname)
******************************************/
function validateGiftCard(formname)
{
 
    if(validateForm(formname, 'frmGiftCardName', 'Gift Card Name', 'R','frmGiftCardAmount', 'Gift Card Amount', 'R'))
    {	
    	
        return true;
    } 
    else 
    {
        return false;
    } 
}

/******************************************
Function name : validator for coupon form in admin
Return type : boolean
Date created : 20th April 2011
Date last modified : 20th April 2011
Author : Deepesh Pathak
Last modified by : Deepesh Pathak
Comments : Function will return the true or error message after validating form
User instruction : validateCoupon(formname)
******************************************/
function validateApplyDiscount(formname)
{
 
    if(validateForm(formname, 'frmDiscountPercentage', 'Discount Percent', 'R'))
    {	
    	
        return true;
    } 
    else 
    {
        return false;
    } 
}



/******************************************
Function name : validator for coupon form in admin
Return type : boolean
Date created : 20th April 2011
Date last modified : 20th April 2011
Author : Deepesh Pathak
Last modified by : Deepesh Pathak
Comments : Function will return the true or error message after validating form
User instruction : validateCoupon(formname)
******************************************/
function validateSendCoupon(formname)
{
 
    if(validateForm(formname, 'frmUserEmail', 'User Email', 'RisEmail'))
    {	
        return true;
    } 
    else 
    {
        return false;
    } 
}

/******************************************
Function name : validator for Color form in admin
Return type : boolean
Date created : 25th April 2011
Date last modified : 25th April 2011
Author : Deepesh Pathak
Last modified by : Deepesh Pathak
Comments : Function will return the true or error message after validating form
User instruction : validateColor(formname)
******************************************/
function validateColor(formname)
{
    if(validateForm(formname, 'frmColorName', 'Color Name', 'R'))
    {	
        return true;
    } 
    else 
    {
        return false;
    } 
}

/******************************************
Function name : validator for Size form in admin
Return type : boolean
Date created : 25th April 2011
Date last modified : 25th April 2011
Author : Deepesh Pathak
Last modified by : Deepesh Pathak
Comments : Function will return the true or error message after validating form
User instruction : validateSize(formname)
******************************************/
function validateSize(formname)
{
    if(validateForm(formname, 'frmSizeName', 'Size Name', 'R'))
    {	
        return true;
    } 
    else 
    {
        return false;
    } 
}


function showCategoryRow(argBannerPage)
{
               
    if(argBannerPage == 'Category')
    {
        document.getElementById("categoryBannerRow").style.display='table-row';
    //document.getElementById("categoryBannerRow").setAttribute("class", 'content'); //For Most Browsers
    //element.setAttribute("className", newClass); //For IE; harmless to other browsers.

    }
    else if(argBannerPage == 'WholesaleRegistration' || argBannerPage == 'WholesaleContactUs' )
    {
        //bannerPosition
            
        document.getElementById("bannerPosition").style.display="none";
    } 
    else
    {
        document.getElementById("bannerPosition").style.display="table-row";
        document.getElementById("categoryBannerRow").style.display='none';
    }
}
/*****************************
Function name : validateAdsAddPageForm
Return type : bollean
Date created : 28th February 2008
Date last modified : 28th February 2008
Author : Sandeep Kumar
Last modified by : Sandeep Kumar
Comments : This function is used to validate the CMS form.
User instruction : validateAdsAddPageForm(formname)
************************************/
function validateAdsAddPageForm(formname,isimage)
{
    var frmAdType = $("#"+formname+" input[type='radio']:checked").val();
    
    if(frmAdType=='html'){
        if($('#frmTitle').val() == ''){
            alert(TIT_REQ);
            $('#frmTitle').focus()
            return false;
        }else if($('#frmHtmlCode').val() == ''){
            alert(HTML_REQ);
            $('#frmHtmlCode').focus()
            return false;
        }
    }else{        
        if($('#frmTitle').val() == ''){
            alert(TIT_REQ);
            $('#frmTitle').focus()
            return false;
        }else if($('#frmAdUrl').val() == ''){
            alert(URL_LINK_REQ);
            $('#frmAdUrl').focus()
            return false;
        }else if(IsUrlLink($('#frmAdUrl').val()) ==false){            
            alert(ENTER_VALID_LINK);
            $('#frmAdUrl').select();
            return false;
        }
        
        if(isimage==0){
            if($('#frmImg').val() == ''){
                alert(IMG_REQ);
                $('#frmImg').focus()
                return false;
            }
        }
        if($('#frmImg').val() != ''){
            var ff = $('#frmImg').val();
            var exte = ff.substring(ff.lastIndexOf('.') + 1);
            var ext = exte.toLowerCase();
            if(ext!='jpg' && ext!='jpeg' && ext!='gif' && ext!='png'){
                alert(ACCEPTED_IMAGE_FOR);
                $('#frmImg').focus();
                return false;
            }
           
        }
    }
}
/******************************************
Function name : add new row into product variation table
Return type : boolean
Date created : 27th April 2011
Date last modified : 27th April 2011
Author : Deepesh Pathak
Last modified by : Deepesh Pathak
Comments : Function will add  row
User instruction : addRowToTable(TableID)
******************************************/

function addRowToTable(TableID)
{
    var sizecount= document.getElementById('ProductSizecount').value;
          
       
    var tbl = document.getElementById(TableID);
    var lastRow = tbl.rows.length;
         
    // if there's no header row in the table, then iteration = lastRow + 1
    var count_R;
    count_R=lastRow;
    count_R=parseInt(count_R);	 
    // count_R=count_R-1;
	  
    var row = tbl.insertRow(lastRow);
    //var fc1=document.getElementById('ColorTD').innerHTML;
    var fc2=document.getElementById('SizeTD').innerHTML;
    var fc3=document.getElementById('QtyTD').innerHTML;
    var fc4=document.getElementById('SubProductConditionTD').innerHTML;
    var fc5=document.getElementById('SubProductColorTD').innerHTML;
    var fc6=document.getElementById('PriceTD').innerHTML;
    var fc7=document.getElementById('RetailPriceTD').innerHTML;
    var fc8=document.getElementById('SalePriceTD').innerHTML;
    var fc8=document.getElementById('SalePriceTD').innerHTML;
    var fc9=document.getElementById('WeightTD').innerHTMl;
    var fc10=document.getElementById('LengthTD').innerHTMl;
    var fc11=document.getElementById('WidthTD').innerHTMl;
    var fc12=document.getElementById('HeightTD').innerHTMl;
    var fc13=document.getElementById('StatusTD').innerHTMl;
    var fc14=document.getElementById('WholesalerProductTD').innerHTMl;
    var fc15=document.getElementById('WholesalerBasePriceTD').innerHTMl;
         
    var no=parseInt(sizecount)-1;
    var newName='frmfkSubProductColorId_'+sizecount;
    var newConditionId='frmfkSubProductConditionId_'+sizecount;
    var newConditionId='frmfkSubProductConditionId_'+sizecount;
    var newConditionfunction='checkCondition(this.value,'+sizecount+')';
    var newSizeId='productSize_'+sizecount;
    // alert(newSizeId);
          
          
    fc2=fc2.replace("productSize_0",newSizeId);
    var fc20=fc5.replace("frmfkSubProductColorId_0",newName);
       
    fc4=fc4.replace("frmfkSubProductConditionId_0",newConditionId);
    checkCondition(this.value,'0');
    fc4=fc4.replace("checkCondition(this.value,'0')",newConditionfunction);
    var valRegExp=/value=/g;
	  
    // fc1=fc1.replace("selected","");
    fc2=fc2.replace("selected","");
    fc20=fc20.replace("selected","");
    fc20=fc20.replace("selected","");
    fc20=fc20.replace("selected","");
    fc20=fc20.replace("selected","");
    fc20=fc20.replace("selected","");
    fc4=fc4.replace("selected","");
    fc20=fc20.replace('selected="selected"','');
    fc20=fc20.replace('selected="selected"','');
    fc20=fc20.replace('selected="selected"','');
    fc20=fc20.replace('selected="selected"','');
    fc20=fc20.replace('selected="selected"','');
         
    /*fc3=fc3.replace(valRegExp,"value=\"\" /");
	  fc4=fc4.replace(valRegExp,"value=\"\" /");
	  fc5=fc5.replace(valRegExp,"value=\"\" /");
	  fc6=fc6.replace(valRegExp,"value=\"\" /");*/
	
    fc3='<input type="text" name="frmQuantity[]" onkeyup="AcceptDigits(this)" style="width:80px;" value="" />';
    /*fc4='<input type="text" name="frmMinQuantity[]" onkeyup="AcceptDigits(this)" style="width:80px;"  value=""/>';*/
    // fc5='<input type="file" name="frmProductImage[]" value="" /><input type="hidden" name="frmProductOldImage[]" value="" />';
    fc6='<input type="text" name="frmPrice[]" style="width:60px;" value="" />USD';
    fc7='<input type="text" name="frmRetailPrice[]" style="width:60px;" value="" />USD';
    fc8='<input type="text" name="frmSalePrice[]" style="width:60px;" value="" />USD';
    fc9='<input type="text" name="frmProductweight[]" style="width:40px;" value="" />(lbs)';
    fc10='<input type="text" name="frmShippingLength[]" style="width:40px;" value="" />(inch)';
    fc11='<input type="text" name="frmShippingWidth[]" style="width:40px;" value="" />(inch)';
    fc12='<input type="text" name="frmShippingHeight[]" style="width:40px;" value="" />(inch)';
    fc13='<table>';
    fc13 +='<tr ><td style="border:none;"><input type="radio" name="frmProductSizeStatus_'+sizecount+'" id="frmProductSizeStatus_'+sizecount+'1"  value="Active">Active</td></tr>';
    fc13 +='<tr ><td style="border:none;"><input type="radio" name="frmProductSizeStatus_'+sizecount+'" id="frmProductSizeStatus_'+sizecount+'2" value="Inactive">Inactive</td></tr>';
    fc13 +='<tr ><td style="border:none;"><input type="radio" name="frmProductSizeStatus_'+sizecount+'" id="frmProductSizeStatus_'+sizecount+'3" value="Offline">Offline</td></tr></table>';
    fc14='<table>';
    fc14 +='<tr ><td style="border:none;"><input type="radio" name="frmProductSizeForWholesaler_'+sizecount+'"  value="Yes">Yes</td></tr>';
    fc14 +='<tr ><td style="border:none;"><input type="radio" name="frmProductSizeForWholesaler_'+sizecount+'"  value="No">No</td></tr></table>';
    fc15='<input type="text" name="frmproduct_wholesale_price[]" style="width:50px;" value=""/>USD';
    fc16='<input type="text" name="frmSubproductskuId[]"  id="frmSubproductskuId_'+sizecount+'" style="width:70px;" value="" onblur="checkExistSubSkuID('+sizecount+',this.value,'+"'checkSkuIDexistence_'"+');"/>';
    fc16 +='<div id="checkSkuIDexistence_'+sizecount+'" style="color:red;"></div>';
    fc17='<input type="checkbox" name="frmDefaultSubproduct_'+sizecount+'" id="frmDefaultSubproduct_'+sizecount+'" onclick="disableCheckBoxes('+sizecount+')"  style="width:50px;" value=""/>';
    fc18='<input type="text" name="frmDefaultourPrice[]" style="width:40px;" value=""/>';
    //alert(fc15);
          
    // var cellRight = row.insertCell(0);
    //cellRight.innerHTML=fc1; 
    var cellRight1 = row.insertCell(0);
    cellRight1.innerHTML=fc2;
    var cellRight2 = row.insertCell(1);
    cellRight2.innerHTML=fc3; 
	  
    var cellRight5 = row.insertCell(2);
    cellRight5.innerHTML=fc6;
    var cellRight6 = row.insertCell(3);
    cellRight6.innerHTML=fc7;
    var cellRight7 = row.insertCell(4);
    cellRight7.innerHTML=fc8;
    var cellRight8=row.insertCell(5);
    cellRight8.innerHTML=fc9;
    var cellRight9=row.insertCell(6);
    cellRight8.innerHTML=fc9;
    var cellRight9=row.insertCell(6);
    cellRight9.innerHTML=fc10;
    var cellRight10=row.insertCell(7);
    cellRight10.innerHTML=fc11;
    var cellRight10=row.insertCell(8);
    cellRight10.innerHTML=fc12;
    var cellRight11=row.insertCell(9);
    cellRight11.innerHTML=fc13;
    var cellRight12=row.insertCell(10);
    cellRight12.innerHTML=fc14;
    var cellRight13=row.insertCell(11);
    cellRight13.innerHTML=fc15;
    var cellRight14 = row.insertCell(12);
    cellRight14.innerHTML=fc4;
    var cellRight15 = row.insertCell(13);
    cellRight15.innerHTML=fc20;
    var cellRight16 = row.insertCell(14);
    cellRight16.innerHTML=fc16;
    var cellRight17 = row.insertCell(15);
    cellRight17.innerHTML=fc18;
    var cellRight18 = row.insertCell(16);
    cellRight18.innerHTML=fc17;
           
    var cellRight18=row.insertCell(17);
          
    cellRight18.innerHTML='<a href="#" onclick="removeRowFromTable(\'ProductVariationsTable\',\''+count_R+'\',this);return false;"><img src="admin/images/bullet_toggle_minus.png" /></a>';
	  
    sizecount++;
    //alert(sizecount);
    document.getElementById('ProductSizecount').value=sizecount;
          

}





/******************************************
Function name : Add selected row of pupup package of product page
Return type : boolean
Date created : 27th April 2011
Date last modified : 27th April 2011
Author : Deepesh Pathak
Last modified by : Deepesh Pathak
Comments : Function will delete the selected row
User instruction : addDynamicRowToTableForShippingGateways(TableID)
******************************************/
function addDynamicRowToTableForShippingGateways(TableID)
{
    var tbl = document.getElementById(TableID);
    var lastRow = tbl.rows.length;
    
    // if there's no header row in the table, then iteration = lastRow + 1
    var count_R;
    count_R=lastRow;
    count_R=parseInt(count_R);	 
    //document.getElementById(TableID).setAttribute("class", 'content'); 
    $('#'+TableID+' tr:last i').html('');  
    var row = tbl.insertRow(lastRow);
    // left cell
	  
    var valRegExp=/value=/g;
	  
    row.insertCell(0).innerHTML='<input type="text" name="frmWeight[]" class="input0" />';
    
    row.insertCell(1).innerHTML='<input type="text" name="frmA[]" class="input0" />';

    row.insertCell(2).innerHTML='<input type="text" name="frmB[]" class="input0" />';
    
    row.insertCell(3).innerHTML='<input type="text" name="frmC[]" class="input0" />';
    
    row.insertCell(4).innerHTML='<input type="text" name="frmD[]" class="input0" />';
    
    row.insertCell(5).innerHTML='<input type="text" name="frmE[]" class="input0" />';    
   
    row.insertCell(6).innerHTML='<input type="text" name="frmF[]" class="input0" />';
    
    row.insertCell(7).innerHTML='<input type="text" name="frmG[]" class="input0" />';
    
    row.insertCell(8).innerHTML='<input type="text" name="frmH[]" class="input0" />';
    
    row.insertCell(9).innerHTML='<input type="text" name="frmI[]" class="input0" />';
    
    row.insertCell(10).innerHTML='<input type="text" name="frmJ[]" class="input0" />';
    
    row.insertCell(11).innerHTML='<input type="text" name="frmK[]" class="input0" />';
    
    row.insertCell(12).innerHTML='<i><span style="cursor: pointer;" onclick="addDynamicRowToTableForShippingGateways('+"'productRow'"+');"><img src="admin/images/plus.png" /></span></i><a href="#" onclick="removeDynamicRowToTableForShippingGateways(\''+TableID+'\',\''+count_R+'\',this);return false;"><img src="admin/images/minus.png" /></a>';
	  
	

}

/******************************************
Function name : remove selected row of pupup package of product page
Return type : boolean
Date created : 27th April 2011
Date last modified : 27th April 2011
Author : Deepesh Pathak
Last modified by : Deepesh Pathak
Comments : Function will delete the selected row
User instruction : removeDynamicRowToTableForShippingGateways(TableID,rowNo,elem)
******************************************/

function removeDynamicRowToTableForShippingGateways(TableID,rowNo,elem)
{
                       
    var sizecount= document.getElementById(TableID).value;     
                
    var tbl = document.getElementById(TableID);
    
    var lastRow = elem.parentNode.parentNode.rowIndex;
    if (lastRow > 0) tbl.deleteRow(lastRow);
    sizecount--;
    $('#'+TableID+' tr:last i').html('<span style="cursor: pointer;" onclick="addDynamicRowToTableForShippingGateways('+"'productRow'"+');"><img src="admin/images/plus.png" /></span>');
    document.getElementById(TableID).value=sizecount;
    
//$('#TempCount').val(lastRow-1);
}

/******************************************
Function name : Add selected row of pupup package of product page
Return type : boolean
Date created : 27th April 2011
Date last modified : 27th April 2011
Author : Deepesh Pathak
Last modified by : Deepesh Pathak
Comments : Function will delete the selected row
User instruction : addDynamicRowToTableForPackage(TableID)
******************************************/
function addDynamicRowToTableForPackage(TableID)
{
    var tbl = document.getElementById(TableID);
    var lastRow = tbl.rows.length;
    
    // if there's no header row in the table, then iteration = lastRow + 1
    var count_R;
    count_R=lastRow;
    count_R=parseInt(count_R);	 
    //document.getElementById(TableID).setAttribute("class", 'content'); 
    $('#'+TableID+' tr:last i').html('');  
    //cellRight4.innerHTML='<a href="#" onclick="removeRowFromTableForPackage(\''+TableID+'\',\''+count_R+'\',this);return false;"><img src="admin/images/minus.png" /></a>';
	  
    var row = tbl.insertRow(lastRow);
    // left cell
	  
    var valRegExp=/value=/g;
	  
    row.insertCell(0).innerHTML='Product&nbsp;'+count_R+':';
    
    var cellRight1 = row.insertCell(1);
    $.post("admin/ajax.php",{
        action:'ShowCategoryForPackageFront',
        ajax_request:'valid',
        row:count_R
    },
    function(data)
    {
        var asc = data; 
        cellRight1.innerHTML = asc;
    }
    );    
    
    row.insertCell(2).innerHTML='<span id="product'+count_R+'"><select name="frmProductId[]" style="width:170px;" onchange="ShowProductPriceForPackage(this.value,'+count_R+')"><option value="0">'+PRODUCT+'</option></select></span>';
    
    row.insertCell(3).innerHTML='<span id="price'+count_R+'"><input type="hidden" name="frmPrice[]" class="input1" value="0.00" /><b>0.00</b></span>';
    
    row.insertCell(4).innerHTML='<i style="cursor: pointer;" onclick="addDynamicRowToTableForPackage('+"'productRow'"+');"><img src="admin/images/plus.png" /></i><a href="#" onclick="removeRowFromTableForPackage(\''+TableID+'\',\''+count_R+'\',this);return false;"><img src="admin/images/minus.png" /></a>';
    
//$('#product'+count_R).sSelect();
}

/******************************************
Function name : remove selected row of pupup package of product page
Return type : boolean
Date created : 27th April 2011
Date last modified : 27th April 2011
Author : Deepesh Pathak
Last modified by : Deepesh Pathak
Comments : Function will delete the selected row
User instruction : removeRowFromTableForPackage(TableID,rowNo,elem)
******************************************/

function removeRowFromTableForPackage(TableID,rowNo,elem)
{
                       
    var sizecount= document.getElementById(TableID).value;     
                
    var tbl = document.getElementById(TableID);
    
    var lastRow = elem.parentNode.parentNode.rowIndex;
    if (lastRow > 0) tbl.deleteRow(lastRow);
    sizecount--;
    $('#'+TableID+' tr:last i').html('<i style="cursor: pointer;" onclick="addDynamicRowToTableForPackage('+"'productRow'"+');"><img src="admin/images/plus.png" /></i>');
    document.getElementById(TableID).value=sizecount;
    
    var frmPrice = document.getElementsByName('frmPrice[]');
    var total=0,i,p,a=0;
    //alert(frmPrice[0].value);
    for(i=0; i<frmPrice.length;i++)
    {
        p = parseFloat(frmPrice[i].value);
        total = total+p;
            
    }
        
    total = total.toFixed(2);
    $('#asc').html(total); 
    
//$('#TempCount').val(lastRow-1);
}


/******************************************
Function name : Add selected row of pupup package of product page
Return type : boolean
Date created : 27th April 2011
Date last modified : 27th April 2011
Author : Deepesh Pathak
Last modified by : Deepesh Pathak
Comments : Function will delete the selected row
User instruction : addDynamicRowToTableForPackage(TableID)
******************************************/
var ctrr = 2;
function addDynamicRowToTableForMultipleProduct(TableID)
{
    //alert('hi');return false;
    var tbl = document.getElementById(TableID);
    var lastRow = tbl.rows.length;
   
    // if there's no header row in the table, then iteration = lastRow + 1
    var count_R;
    count_R=ctrr++;
        
        
    
    count_R=parseInt(count_R);
    
    var hit = (count_R-1) * 130+321+'px';
    $('.jspContainer').css('height',hit);
    
    $('tr').addClass("content");
    
    $('#'+TableID+' tr:last i').html('');  
    
    var row = tbl.insertRow(lastRow);
    // left cell
	  
    var valRegExp=/value=/g;
    
    var Shipping =  SHIPPINGDETAILS.replace(/0/g, (count_R-1));
    	  
    var cellRight0 = row.insertCell(0);
    cellRight0.innerHTML='<div class="input_star"><input name="frmProductRefNo[]" type="text" value="" class="input1 validate[required,custom[integer]]" onkeyup="checkProductRefNoForMultiple(this.value,'+count_R+');" onmousemove="checkProductRefNoForMultiple(this.value,'+count_R+');" onchange="checkProductRefNoForMultiple(this.value,'+count_R+');" /><small class="star_icon"><img alt="" src="common/images/star_icon.png"></small></div><span id="refmsg'+count_R+'" class="req"><input type="hidden" name="frmIsRefNo[]" value="0" /></span>';
    
    var cellRight1 = row.insertCell(1);
    cellRight1.innerHTML='<div class="input_star"><input name="frmProductName[]" type="text" value="" class="input1 validate[required]" /><small class="star_icon"><img alt="" src="common/images/star_icon.png"></small></div>';
    
    row.insertCell(2).innerHTML = Shipping;
    
    row.insertCell(3).innerHTML='<div class="input_star"><input style="margin-bottom: 5px;" placeholder="Wholesale Price" name="frmWholesalePrice[]" id="frmWholesalePrice'+count_R+'" type="text" value="" class="input0 validate[required,custom[integer]]" onBlur="checkPositive(this.value,this.id);" onkeyup="showFinalPriceForMultipleProduct('+count_R+');" onchange="showFinalPriceForMultipleProduct('+count_R+');" /><small class="star_icon"><img alt="" src="common/images/star_icon.png"></small></div><br /><input  name="frmDiscountPrice[]" placeholder="Discount Price" id="frmDiscountPrice'+count_R+'" type="text" value="" class="input0 validate[required,custom[integer]]" onkeyup="showDiscountPriceForMultipleProduct('+count_R+');" onchange="showDiscountPriceForMultipleProduct('+count_R+');" onBlur="checkPositive(this.value,this.id);"/>';
    
    
    row.insertCell(4).innerHTML='<span id="FinalPrice'+count_R+'"></span><input name="frmProductPrice[]" id="frmProductPrice'+count_R+'" type="hidden" value="" class="input0" /><br/><span style="line-height: 28px;" id="DiscountFinalPrice'+count_R+'"></span><input name="frmDiscountFinalPrice[]" id="frmDiscountFinalPrice'+count_R+'" type="hidden" value="" class="input0" />';
    
    var cellRight5 = row.insertCell(5);
    cellRight5.innerHTML='<div id="addinput_'+count_R+'"><div class="imgimg"><div class="responce"></div><input type="file" name="frmProductImg[]" id="frmProductImg'+count_R+'" class="customfile1-input file file_upload_multi" value="" size="1" /><a class="delete_icon2" href="#" style="display: none;"></a></div><div class="add_more_images"><a href="#" class="more more_images" row="'+count_R+'"><small class="multi">Add More +</small></a></div></div>';
    
   
    
    var cellRight6 = row.insertCell(6);
    $.post("admin/ajax.php",{
        action:'ShowCategoryForMultipleProductFront',
        ajax_request:'valid',
        row:count_R
    },
    function(data){        
        var asc = data; 
        cellRight6.innerHTML = asc;
        //$('#frmfkCategory'+count_R).sSelect();
        $('#frmfkCategory'+count_R).select2();
    }
    );
    
    var cellRight7 = row.insertCell(7);
    $.post("admin/ajax.php",{
        action:'ShowPackageForMultipleProductFront',
        ajax_request:'valid',
        row:count_R
    },
    function(data)
    {
        var asc = data; 
        cellRight7.innerHTML = asc;
        $('#frmfkPackageId'+count_R).sSelect();
    }
    );
    
    var cellRight8 = row.insertCell(8);
    cellRight8.innerHTML='<div class="input_star"><input name="frmQuantity[]" id="frmQuantity_'+count_R+'" placeholder="Stock Quantity" type="text" value="" class="input0 validate[required,custom[integer]]" onBlur="checkPositive(this.value,this.id);"/><small class="star_icon"><img alt="" src="common/images/star_icon.png"></small></div>';
    
    var cellRight9 = row.insertCell(9);
    cellRight9.innerHTML='<input name="frmQuantityAlert[]" id="frmQuantityAlert_'+count_R+'" type="text" value="" placeholder="Stock Quantity Alert" class="input0 validate[required,custom[integer]]" onBlur="checkPositive(this.value,this.id);"/>&nbsp;&nbsp;';
    
    var cellRight10 = row.insertCell(10);
    cellRight10.innerHTML='<div class="drop6"><select class="drop_down1" id="frmWeightUnit'+count_R+'" name="frmWeightUnit[]" style="width:83px;"><option value="kg" >Kilogram</option><option value="g">Gram</option><option value="lb" >Pound </option><option value="oz" >Ounce</option></select><br/><input style="margin: 10px 0 0 0; width: 158px !important;" type="text" name="frmWeight[]" id="Weight'+count_R+'" value="" class="input1" /></div>';
    
    var cellRight11 = row.insertCell(11);
    cellRight11.innerHTML='<div class="drop6"><select class="drop_down1" name="frmDimensionUnit[]" id="frmDimensionUnit'+count_R+'" style="width:83px;"><option selected="selected" value="cm" >Centimeter</option><option value="mm" >Millimeter</option><option value="in" >Inch</option></select><br/><input placeholder="L" style=" margin: 10px 10px 0 0;width: 41px !important; float: left;" type="text" name="frmLength[]" id="Length'+count_R+'" value="" class="input1" />&nbsp;<input placeholder="W" style=" margin: 4px 10px 0 0;width: 41px !important; float: left;" type="text" name="frmWidth[]" id="Width'+count_R+'" value="" class="input1" />&nbsp;<input placeholder="H" style="margin: 4px 0 0 0; width: 41px !important; float: left;" type="text" name="frmHeight[]" id="Height'+count_R+'" value="" class="input1" /></div>';

    var cellRight12 = row.insertCell(12);
    cellRight12.innerHTML='<textarea style="width: 300px; margin:0 10px 10px 0;" name="frmProductDescription[]" rows="3" class="input1" maxlength="250" ></textarea>';
    
    var cellRight13 = row.insertCell(13);
    cellRight13.innerHTML='<textarea style="width: 300px; margin:0 10px 10px 0;" name="frmProductTerms[]" rows="3" class="input1"></textarea>';
    
    var cellRight14 = row.insertCell(14);
    cellRight14.innerHTML='<textarea style="width: 300px; margin:0 10px 10px 0;" name="frmYoutubeCode[]" rows="3" class="input1" ></textarea>';
    
    
    var cellRight15 = row.insertCell(15);
    cellRight15.innerHTML='<textarea style="width: 300px; margin:0 10px 10px 0;" name="frmMetaTitle[]" rows="3" class="input1" maxlength="250" ></textarea>';
    
    var cellRight16 = row.insertCell(16);
    cellRight16.innerHTML='<textarea style="width: 300px; margin:0 10px 10px 0;" name="frmMetaKeywords[]" rows="3" class="input1"></textarea>';
    
    var cellRight17 = row.insertCell(17);
    cellRight17.innerHTML='<textarea style="width: 300px; margin:0 10px 10px 0;" name="frmMetaDescription[]" rows="3" class="input1" ></textarea>';
    
    
    
    
    var cellRight18 = row.insertCell(18);
    cellRight18.innerHTML='<span id="shwhde'+count_R+'"><input onclick="createEditor('+count_R+');" type="button" value="Show Editor" class="show_editor" /></span><div id="editorcontents'+count_R+'" style="display: none"></div><div style="display: none"><textarea name="frmHtmlEditor[]" id="frmHtmlEditor'+count_R+'"></textarea></div><div id="editor'+count_R+'" class="html_editor" style="z-index: 999; position: absolute; width:500px; margin-left: -200px"></div>';
    
    var cellRight19 = row.insertCell(19);
    cellRight19.innerHTML='<i><span style="cursor: pointer;" onclick="addDynamicRowToTableForMultipleProduct('+"'"+TableID+"'"+');"><img src="common/images/addmore.png" /><span></i>&nbsp;<a href="#" onclick="removeRowFromTableForMultipleProduct(\''+TableID+'\',\''+count_R+'\',this);return false;"><img src="common/images/remove.png" /></a>';
    //row.insertCell(17).innerHTML='&nbsp;';
    $('#frmProductImg'+count_R).customFileInput1();
    $('#frmProductSliderImg'+count_R).customFileInput1();
    $('#frmProductDefaultImg'+count_R).customFileInput1();
    $('#frmWeightUnit'+count_R).sSelect();
    $('#frmDimensionUnit'+count_R).sSelect();
    $('#frmfkShippingID'+count_R).html($('#frmfkShippingID1').html()); 
    $('#frmfkShippingID'+count_R).sSelect();
    $('#DateEnd'+count_R).datepick({
        dateFormat: 'dd-mm-yyyy'
    });
    $('#DateStart'+count_R).datepick({
        dateFormat: 'dd-mm-yyyy'
    });
}

/******************************************
Function name : remove selected row of pupup package of product page
Return type : boolean
Date created : 27th April 2011
Date last modified : 27th April 2011
Author : Deepesh Pathak
Last modified by : Deepesh Pathak
Comments : Function will delete the selected row
User instruction : removeRowFromTableForPackage(TableID,rowNo,elem)
******************************************/

function removeRowFromTableForMultipleProduct(TableID,rowNo,elem)
{
                       
    var sizecount= document.getElementById(TableID).value;     
                
    var tbl = document.getElementById(TableID);
    
    var lastRow = elem.parentNode.parentNode.rowIndex;
    
    var hit = (lastRow-2) * 130+321+'px';
    $('.jspContainer').css('height',hit);
    
    if (lastRow > 0) tbl.deleteRow(lastRow);
    sizecount--;
    
    $('#'+TableID+' tr:last i').html('<span style="cursor: pointer;" onclick="addDynamicRowToTableForMultipleProduct('+"'"+TableID+"'"+');"><img src="common/images/addmore.png" /></span>');
    
    document.getElementById(TableID).value=sizecount;   
     
//$('#TempCount').val(lastRow-1);
}





/******************************************
Function name : Add selected row 
Return type : boolean
Date created : 27th April 2011
Date last modified : 27th April 2011
Author : Deepesh Pathak
Last modified by : Deepesh Pathak
Comments : Function will delete the selected row
User instruction : addDynamicRowToTableForPackage(TableID)
******************************************/
function addDynamicRowToTable(TableID)
{
    var tbl = document.getElementById(TableID);
    var lastRow = tbl.rows.length;
    
    // if there's no header row in the table, then iteration = lastRow + 1
    var count_R;
    count_R=lastRow;
    count_R=parseInt(count_R);	 
	  
    var row = tbl.insertRow(lastRow);
    var fc2='hi';
	
    // left cell
	  
    var valRegExp=/value=/g;
	  
    var cellRight1 = row.insertCell(0);
    cellRight1.innerHTML=fc2;
    var cellRight7 = row.insertCell(1);
    cellRight7.innerHTML='<a href="#" onclick="removeRowFromTable(\'asc\',\''+count_R+'\',this);return false;"><img src="admin/images/bullet_toggle_minus.png" />hi</a>';
	

}

/******************************************
Function name : remove selected row of product variation table
Return type : boolean
Date created : 27th April 2011
Date last modified : 27th April 2011
Author : Deepesh Pathak
Last modified by : Deepesh Pathak
Comments : Function will delete the selected row
User instruction : removeRowFromTable(TableID,rowNo,elem)
******************************************/
function removeRowFromTable(TableID,rowNo,elem)
{
                       
    var sizecount= document.getElementById(TableID).value;     
                
    var tbl = document.getElementById(TableID);
    
    var lastRow = elem.parentNode.parentNode.rowIndex;
    if (lastRow > 0) tbl.deleteRow(lastRow);
    sizecount--;
    document.getElementById(TableID).value=sizecount;     
//$('#TempCount').val(lastRow-1);
}
/******************************************
Function name : return only digits when input enter on text box
Return type : digits
Date created : 27th April 2011
Date last modified : 27th April 2011
Author : Deepesh Pathak
Last modified by : Deepesh Pathak
Comments : Function will return digits
User instruction : AcceptDigits(objtextbox)
******************************************/
function AcceptDigits(objtextbox)
{
    var exp = /[^\d]/g;
    objtextbox.value = objtextbox.value.replace(exp,'');
}

/******************************************
Function name : return only true if text is number
Return type : boolean
Date created : 27th April 2011
Date last modified : 27th April 2011
Author : Deepesh Pathak
Last modified by : Deepesh Pathak
Comments : return only true if text is number
User instruction : AcceptDigits(objtextbox)
******************************************/
function IsDigits(str){
    str = trim(str);    
    var regDigits = /[^\d]/g;
    return regDigits.test(str);
    
}

/******************************************
Function name : return only true if text is number
Return type : boolean
Date created : 27th April 2011
Date last modified : 27th April 2011
Author : Deepesh Pathak
Last modified by : Deepesh Pathak
Comments : return only true if text is number
User instruction : AcceptDigits(objtextbox)
******************************************/
function IsLessThan(max,min){
    
    max=parseFloat(max);
    min=parseFloat(min);
   
    if(min>max){
        return false;
    }else{
        return true;
    }
}


/******************************************
Function name : return only true if text is number
Return type : boolean
Date created : 27th April 2011
Date last modified : 27th April 2011
Author : Deepesh Pathak
Last modified by : Deepesh Pathak
Comments : return only true if text is number
User instruction : AcceptDigits(objtextbox)
******************************************/
function IsPhone(str){
    str = trim(str);    
    var regPhone = /^[0-9()+ -]*$/;
    return regPhone.test(str);
    
}

/******************************************
Function name : return only true if text is number
Return type : boolean
Date created : 27th April 2011
Date last modified : 27th April 2011
Author : Deepesh Pathak
Last modified by : Deepesh Pathak
Comments : return only true if text is number
User instruction : AcceptDigits(objtextbox)
******************************************/
function IsUrlLink(str){
    str = trim(str);    
    var regURL = /http:\/\/[A-Za-z0-9\.-]{3,}\.[A-Za-z]{3}/;
    ;
    return regURL.test(str);
    
}
/******************************************
Function name : return true if input string is valid email id
Return type : boolean
Date created : 27th April 2011
Date last modified : 27th April 2011
Author : Deepesh Pathak
Last modified by : Deepesh Pathak
Comments : return true if input string is decimal number
User instruction : AcceptDecimal(str)
******************************************/
function AcceptEmail(str) {
    //http://lawrence.ecorp.net/inet/samples/regexp-validate2.php
    str = trim(str);
    var regEmail = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;    
    return regEmail.test(str);
}

/******************************************
Function name : return true if input string is decimal number
Return type : boolean
Date created : 27th April 2011
Date last modified : 27th April 2011
Author : Deepesh Pathak
Last modified by : Deepesh Pathak
Comments : return true if input string is decimal number
User instruction : AcceptDecimal(str)
******************************************/
function AcceptDecimal(str) {
    //http://lawrence.ecorp.net/inet/samples/regexp-validate2.php
    str = trim(str);
    var regDecimal = /^[-+]?[0-9]+(\.[0-9]+)?$/;
    return regDecimal.test(str);
}
/******************************************
Function name : open product image window
Return type : boolean
Date created : 28th April 2011
Date last modified : 28th April 2011
Author : Deepesh Pathak
Last modified by : Deepesh Pathak
Comments : open product image window
User instruction : openProductImagewindow(productImage)
******************************************/
function openProductImagewindow(productImage)
{
    window.open(productImage,"ProductImage","menubar=1,resizable=1,width=350,height=250"); 
}

/******************************************
Function name : open product image window
Return type : boolean
Date created : 28th April 2011
Date last modified : 28th April 2011
Author : Deepesh Pathak
Last modified by : Deepesh Pathak
Comments : open product image window
User instruction : openProductImagewindow(productImage)
******************************************/
function openCouponImagewindow(couponImage)
{
    window.open(couponImage,"couponImage","menubar=1,resizable=1,width=350,height=250"); 
}


/*****************************
Function name : validateCMSForm
Return type : bollean
Date created : 28th February 2008
Date last modified : 28th February 2008
Author : Sandeep Kumar
Last modified by : Sandeep Kumar
Comments : This function is used to validate the CMS form.
User instruction : validateCMSForm(formname)
************************************/
function validateAttributeAddPageForm(formname)
{
    var frmCategoryId = document.getElementsByName("frmCategoryId[]");
    
    if($('#frmAttributeCode').val() == '')
    {
        alert(ATTR_CODE_REQ);
        $('#frmAttributeCode').focus();
        return false;
    }
    if($('#frmAttributeTitle').val() == '')
    {
        alert(ATTR_TIT_REQ);
        $('#frmAttributeTitle').focus();
        return false;
    }
    
    for(var i=0;i<frmCategoryId.length;i++){
        if(frmCategoryId[i].value == 0)
        {
            alert(SEL_CATEGORY);
            frmCategoryId[i].focus();
            return false;
        } 
        
    }  

}

function inArray(needle, haystack) {
    var length = haystack.length;
    for(var i = 0; i < length; i++) {
        if(haystack[i] == needle) return true;
    }
    return false;
}



/*****************************
Function name : validateCMSForm
Return type : bollean
Date created : 28th February 2008
Date last modified : 28th February 2008
Author : Sandeep Kumar
Last modified by : Sandeep Kumar
Comments : This function is used to validate the CMS form.
User instruction : validateCMSForm(formname)
************************************/
function validateCMSAddPageForm(formname)
{
    
    if($('#frmDisplayPageTitle').val() == '')
    {
        alert(PAGE_DISP_TITLE);
        $('#frmDisplayPageTitle').focus()
        return false;
    }
    if($('#frmPageTitle').val() == '')
    {
        alert(PAGE_TIT_REQ);
        $('#frmPageTitle').focus()
        return false;
    }   
    if($('#frmPageDisplayOrder').val() == '' )
    {
        alert(PAGE_ORDER_REQ);
        $('#frmPageDisplayOrder').focus()
        return false;
    }   
    
}

/*****************************
Function name : validateCMSAddPageForm
Return type : bollean
Comments : This function is used to validate the CMS form.
User instruction : validateCMSAddPageForm(formname)
************************************/
function validateCategoryAddEditForm(formname)
{
    var inputFocus = true;
	
    if($('#frmName').val() == '')
    {
        alert(CATE_NAME_REQ);
        $('#frmName').focus();
        return false;
    }
   
}

/*****************************
Function name : validateOfficeAddressEditForm
Return type : bollean
Comments : This function is used to validate the CMS form.
User instruction : validateOfficeAddressEditForm(formname)
************************************/
function validateOfficeAddressEditForm(formname)
{
    var inputFocus = true;
    var allowedExtensions = new Array('jpg','jpeg','gif','png');
    if($('#frmAddressTitle').val() == '')
    {
        alert(OFF_LOC_REQ);
        $('#frmAddressTitle').focus();
        return false;
    } 
    if($('#frmAddressImage').val() != '')
    {
        if(!validateFileExtension($('#frmAddressImage').val(), allowedExtensions, '#frmAddressImage' , ACCEPT_FORMAT, inputFocus))
        {
            return false;
        }
    }
}


/****************************
Function will validate uploaded file extension
/****************************/
function validateFileExtensionNew(fileName, arrAllowExt, id, message, focus)
{
    //alert(fileName);return false;
    var element = $(id);
	
    for(i=0; i<arrAllowExt.length;i++)
    {
        allowedEx=arrAllowExt[i].toUpperCase();
        message = message + allowedEx+',';
    }
	
    message = message.substring(0, message.length-1);
    fileName = jQuery.trim(fileName);
    //alert(fileName);return false;
    if(fileName != '')
    {
        var ext = fileName.split('.').pop().toLowerCase();
	
        if(jQuery.inArray(ext, arrAllowExt) == -1)
        {
            return 1;
        }else{
            return 0;
        }
	  
    }
}

/****************************
 Function will validate uploaded file extension
/****************************/
function validateFileExtension(fileName, arrAllowExt, id, message, focus)
{
    var element = $(id);
    for(i=0; i<arrAllowExt.length;i++)
    {
        allowedEx=arrAllowExt[i].toUpperCase();
        message = message + allowedEx+',';
    }
	
    message = message.substring(0, message.length-1);
    fileName = jQuery.trim(fileName);
    if(fileName != '')
    {
        var ext = fileName.split('.').pop().toLowerCase();
	
        if(jQuery.inArray(ext, arrAllowExt) == -1)
        {
            alert(message);
            element.focus();
            return false;
        }
        else
        {
            return true;
        }
    }
}

/*****************************
Function name : validateEnquiryEmailsForm
************************************/
function validateEnquiryEmailsForm()
{
    var regEmail = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    if(document.frmAddEditEmail.frmEnquiryEmail.value == "")
    {
        alert(ENTER_EMAIL);
        document.frmAddEditEmail.frmEnquiryEmail.focus() ;
        return false;
    }
    if(document.frmAddEditEmail.frmEnquiryEmail.value != "")
    {
        var result = document.frmAddEditEmail.frmEnquiryEmail.value.split(",");
        // alert(result);
        for(var i = 0;i < result.length;i++)
        {
            if(!regEmail.test(result[i])) 
            {
                alert(result[i]+EMAIL_SEEMS_WRONG); 		
                document.frmAddEditEmail.frmEnquiryEmail.focus();
                return false;
            }
        }
    }
}


/*****************************
Function name : validateUser
Return type : bolean
Date created : 29th April 2008
Date last modified : 29th February 2008
Author : Deepesh Pathak
Last modified by : Deepesh Pathak
Comments : This function is used to validate user form.
User instruction : validateUser(formname)
************************************/
function getRBtnName(GrpName) {
    var sel = document.getElementsByName(GrpName);
    var fnd = -1;
    var str = '';
    for (var i=0; i<sel.length; i++) {
        if (sel[i].checked == true) {
            str = sel[i].value;
            fnd = i;
        }
    }
    return fnd;  
} 

function validateUser(formname)
{
    if(validateForm(formname,'frmFirstName', 'User Name', 'R', 'frmUserEmail', 'Email Address', 'RisEmail', 'frmPassword', 'Password','R','frmConfirmPassword', 'Confirm Password', 'RisEqualfrmPassword:Password','frmAdminRoll', 'Role','R','frmCommission', 'Commission','R','frmSalesTarget', 'Sales Target','R')) //,'UserType', 'Role','RisRadio'
    {
        return true;
    } 
    else 
    {
        return false;
    } 
}



/*****************************
Function name : validateMessage
Return type : bolean
Date created : 26th Oct 2012
Date last modified : 26th Oct 2012
Author : Aditya Pratap Singh
Last modified by : Aditya Pratap Singh
Comments : This function is used to validate send message form.
User instruction : validateMessage(formname)
************************************/
function validateMessage(formname)
{
	
    if(validateForm(formname,'frmSendToIds', 'Select Users', 'R', 'frmMessageType', 'Message Type', 'R', 'frmMessageSubject', 'message Subject', 'R'))
    {	
		
		
        return true;
    } 
    else 
    {
        return false;
    } 
}


/*****************************
Function name : validateBillingAddress
Return type : bolean
Date created : 29th April 2008
Date last modified : 29th February 2008
Author : Deepesh Pathak
Last modified by : Deepesh Pathak
Comments : This function is used to validate user form.
User instruction : validateUser(formname)
************************************/
function validateBillingAddress(formname)
{
	
    if(validateForm(formname,'frmAddressLine1', 'Address', 'R','frmCountry', 'Country', 'R', 'frmState', 'State','R', 'frmCity', 'City', 'R', 'frmZipCode', 'Zip Code', 'R'))
    {	
		
		
        return true;
    } 
    else 
    {
        return false;
    } 
}

/*****************************
Function name : validateNewsLetterForm
Return type : none
Date created :02May2011
Date last modified : 02May2011
Author : Deepesh Pathak
Last modified by : Deepesh Pathak
Comments : This function is used to validate the news letter form
User instruction :  validateNewsLetterForm(formID)
************************************/
function validateNewsLetterForm(formID)
{
    if(validateForm(formID, 'frmNewsLetterName', 'Newsletter Name', 'R'))
    {  
        return true;
    } 
    else 
    {
        return false;
    }
}
/*****************************
Function name : validateNewsLetterMailForm
Return type : none
Date created :02May2011
Date last modified : 02May2011
Author : Deepesh Pathak
Last modified by : Deepesh Pathak
Comments : This function is used to validate the news letter mail form
User instruction :  validateNewsLetterMailForm(formID)
************************************/
function validateNewsLetterMailForm(formID)
{
    if(validateForm(formID, 'frmNewsLetterName', 'Title', 'R','frmSubscriberList','Subscriber','R'))
    {  
        return true;
    } 
    else 
    {
        return false;
    }
}
/******************************************
Function name : enableList
Return type : none
Date created : 14th November 2008
Date last modified : 14th November 2008
Author : Shardendu Singh
Last modified by :Shardendu Singh
Comments : Function will enable the subscriber list select box
User instruction : askConfirm(argValue)
******************************************/
function enableList(argValue)
{
    if(argValue=="Subscriber(s)")
    {
        document.getElementById('frmSubscriberList[]').disabled=false;	
    }
    else
    {
        document.getElementById('frmSubscriberList[]').disabled=true;
    }
}
/******************************************
Function name : disableList
Return type : none
Date created : 14th November 2008
Date last modified : 14th November 2008
Author : Shardendu Singh
Last modified by :Shardendu Singh
Comments : Function will disable the subscriber list select box
User instruction : disableList(argValue)
******************************************/
function disableList(argValue)
{
    if(argValue=="AllSubscribers")
    {
        document.getElementById('frmSubscriberList[]').disabled=true;	
    }
    else
    {
        document.getElementById('frmSubscriberList[]').disabled=false;
    }
}
/******************************************
Function name : disableList
Return type : none
Date created : 14th November 2008
Date last modified : 14th November 2008
Author : Shardendu Singh
Last modified by :Shardendu Singh
Comments : Function will disable the subscriber list select box
User instruction : disableList(argValue)
******************************************/
function showMemberOtherDetails(argValue)
{
    //alert(argValue);
    if(argValue == 'WholeSaler')
    {
        document.getElementById('wholeSalerRow_1').style.display='none';
    }
    else if(argValue == 'Member')
    {
        document.getElementById('wholeSalerRow_1').style.display='';
    }
}

/******************************************
Function name : showState
Return type : none
Date created : 10th June 2011
Date last modified : 10th June 2011
Author : Ghazala Anjum
Last modified by : Ghazala Anjum
Comments : Function will return the states of the selected country.
User instruction : showState(argCountryID)
******************************************/
function showState(argCountryID, argSelectedState, argShowName)
{
    var params = {
        'function': 'getCountryStates'
    };
    params['countryID'] = argCountryID;
    params['selected'] = argSelectedState;
    params['ajax_request'] = 'valid';
    //params['showName'] = argShowName;
	
    $.post(SITE_ROOT_URL + 'common/ajax/ajax.php', params, function (data){ 
        if(data)
        {
            if($("#frmShippingCostState").is(':visible'))
            {
                $("#frmShippingCostState").html(data).show();
                return true;
            }
            if($("#frmState").is(':visible'))
            {
                $("#frmState").html(data).show();
                return true;
            }
        }
		
    });
}

/*****************************
Function name : validateShippingCostForm
Return type : none
Date created :02May2011
Date last modified : 02May2011
Author : Deepesh Pathak
Last modified by : Deepesh Pathak
Comments : This function is used to validate the news letter mail form
User instruction :  validateShippingCostForm(formID)
************************************/
function validateShippingCostForm(formID)
{
    if(validateForm(formID, 'frmCountry', 'Country Name', 'R','frmShippingCostState','State Name','R','frmShippingCost','Shipping Cost','R'))
    {  
        if($('#frmShippingCostType').val() == 'Percentage')
        {
            if($('#frmShippingCost').val() > 100)
            {
                alert(SHIPP_COST_PERCEN);
                $('#frmShippingCost').focus();
                return false;
            }
        }
		
        return true;
    } 
    else 
    {
        return false;
    }
}


/*****************************
Function name : validateShippingCostForm
Return type : none
Date created :02May2011
Date last modified : 02May2011
Author : Deepesh Pathak
Last modified by : Deepesh Pathak
Comments : This function is used to validate the news letter mail form
User instruction :  validateShippingCostForm(formID)
************************************/
function validateDefaultShippingCostForm(formID)
{
    if(validateForm(formID, 'frmShippingCost','Shipping Cost','R'))
    {  
        return true;
    } 
    else 
    {
        return false;
    }
}



// this function deselects the checkbox given checkbox ID
function deSelectMasterCheckbox(argCheckboxId)
{
    document.getElementById(argCheckboxId).checked = false;	
}


function AllowNumeric(e)
{
    isIE=document.all? 1:0
    keyEntry = !isIE? e.which:event.keyCode;//alert(keyEntry);
	
    if(((keyEntry >= '48') && (keyEntry <= '57')) || keyEntry == '8' || keyEntry == '0' || keyEntry == '9' || keyEntry == '\t' || keyEntry == '\r' || keyEntry == '127' || keyEntry == '13' || keyEntry == '11' || keyEntry == '9' || keyEntry == '46')
    {
        return true;
    }
    else
    {
        return false;
    }
}


function AllowAlphabetOnly(e)
{
    isIE=document.all? 1:0
    keyEntry = !isIE? e.which:event.keyCode;//alert(keyEntry);
	
    if(((keyEntry >= '65') && (keyEntry <= '90')) || ((keyEntry >= '97') && (keyEntry <= '122')) ||  keyEntry == '127' ||  keyEntry == '8')
    {
        return true;
    }
    else
    {
        return false;
    }
}


function changeAdminOrderStatus(orderStatus,orderID)
{
    var res=confirm(CHANGE_ORDER_STATUS);
	
    if(res)
    {
        document.getElementById('frmOrderID').value=orderID;
        document.getElementById('frmOrderStatus').value=orderStatus;
        document.forms["frmOrderStatus"].submit();
    }
    else
    {
        return false;
    }
}

function checkCondition(id,element)
{
    //  alert(element);            
    var TotalcheckBoxes=document.getElementById('ProductSizecount').value;
    for(var i=0;i<TotalcheckBoxes;i++)
    {
        //    alert(i);
        //    alert(element);
        if(i!=element)
        {
             
            var Size =document.getElementById('productSize_'+i).value;
            var Condition =document.getElementById('frmfkSubProductConditionId_'+i).value;
            var CurrentSize=document.getElementById('productSize_'+element).value;
            var CurrentCondition =document.getElementById('frmfkSubProductConditionId_'+element).value;
        
            if(Size==CurrentSize&&Condition==CurrentCondition)
            {
                //   alert(Size);
                //  alert(CurrentSize);
                //    alert(CurrentCondition);
                //   alert(Condition);
                alert(ALL_SEL_CONDITION);
                $('#frmfkSubProductConditionId_'+element).prop('selectedIndex',0);
            //  return false;
            }
        }	
    }
}

/******************************************
Function name : Function for deleting records
Return type : boolean
Date created : 15 Oct 2012  
Date last modified : 15 Oct 2012  
Author : Aditya Pratap Singh
Last modified by : Aditya Pratap Singh
Comments : Function will set the values into form for performing deletion 
User instruction : deleteRecord(formname)
******************************************/
function deleteRecord(argCategoryID, argFormName, argInputID, argAction)
{
    if(confirm(R_U_SURE_DELETE))
    {
        $('#'+argInputID).val(argCategoryID);
        $('#frmProcess').val(argAction);
        $('#'+argFormName).submit();

    }

}
  
/******************************************
    Function name : Function for deleting Enquiries
    Return type : void
    Date created : 19 Oct 2012  
    Date last modified : 19 Oct 2012  
    Author : Aditya Pratap Singh
    Last modified by : Aditya Pratap Singh
    Comments : Function will set the values into form for performing deletion 
    User instruction : deleteEnquiries(formname)
******************************************/

function deleteEnquiries(argEnquirieID, argFormName, argInputID, argAction)
{
    if(confirm(R_U_SURE_DELETE))
    {
        $('#frmEnquirieID').val(argEnquirieID);
        $('#frmProcess').val(argAction);
        $('#'+argFormName).submit();

    }

}
    
/******************************************
    Function name : Function for deleting Message
    Return type : void
    Date created : 29 Oct 2012  
    Date last modified : 29 Oct 2012  
    Author : Aditya Pratap Singh
    Last modified by : Aditya Pratap Singh
    Comments : Function will set the values into form for performing deletion 
    User instruction : deleteMessage(formname)
******************************************/

function deleteMessage(argMessageID, argFormName, argInputID, argAction)
{
    if(confirm(R_U_SURE_DELETE))
    {
        $('#frmMessageID').val(argMessageID);
        $('#frmProcess').val(argAction);
        $('#'+argFormName).submit();

    }

}