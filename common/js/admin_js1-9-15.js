function validateCategory(e){
    return validateForm(e,"frmCategoryName","Category Name","R")?!0:!1
}
function validateModule(e){
    return validateForm(e,"frmRollName","Roll Name","R")?!0:!1
}
function showAttribute(e){
    0==e?$("#attribute").html('<input type="hidden" name="frmIsAttribute" value="0" class="input2" />Please select category !'):$.post("ajax.php",{
        action:"ShowAttribute",
        catid:e
    },function(d){
        $("#attribute").html(d)
    })
}
function showCurrencyInUSD(e){
    var t=$.trim($("#frmWholesalePrice"+e).val()),r=$("#frmCurrency"+e).val();
    if(e==1){
        $("#frmCurrency2").val(r);
        $("#frmWholesalePrice2").val('');
        $('#InUSD2').html('');
        $('#FinalPriceInUSD2').html('');
    }
    return""==t?($("#InUSD"+e).html(""),$("#frmWholesalePriceInUSD"+e).val(""),$("#FinalPriceInUSD"+e).html(""),$("#frmProductPrice"+e).val(""),!1):($("#InUSD"+e).html("Calculating.."),$.post("../common/ajax/ajax_converter.php",{
        action:"showCurrency",
        amount:t,
        from:r,
        to:"USD"
    },function(t){
        var r=t.split("--");
        $("#InUSD"+e).html("$ "+r[0]),$("#frmWholesalePriceInUSD"+e).val(r[0]),$("#FinalPriceInUSD"+e).html("$ "+r[1]),$("#frmProductPrice"+e).val(r[1])
    }),void 0)
}
function showFinalPriceForMultipleProduct(e){
    var t=$.trim($("#frmWholesalePrice"+e).val()),r=$("#frmMarginCast").val();
    if(""==t)return $("#FinalPrice"+e).html(""),$("#frmProductPrice"+e).val(""),!1;
    var a=parseFloat(t),i=parseFloat(r),n=a+a*i/100;
    $("#FinalPrice"+e).html("$"+n),$("#frmProductPrice"+e).val(n)
}
function showFinalDiscountPriceForMultipleProduct(e){
    var t=$.trim($("#frmDiscountPrice"+e).val()),r=$("#frmMarginCast").val();
    if(""==t)return $("#DiscountFinalPrice"+e).html(""),$("#frmDiscountFinalPrice"+e).val(""),!1;
    var a=parseFloat(t),i=parseFloat(r),n=a+a*i/100;
    $("#DiscountFinalPrice"+e).html("$"+n),$("#frmDiscountFinalPrice"+e).val(n)
}
function deleteImage(e){
    ""==e?$("#img"+e).html("Invalid Acton!"):$.post("ajax.php",{
        action:"deleteImage",
        imgid:e
    },function(t){
        $("#img"+e).html(t)
        setTimeout(function(){
            $('#img'+e).parent().remove();
        },3000);
    })
}
function ShowAttributeMultipleProduct(e,t){
    0==e?$("#attribute"+t).html('<input type="hidden" name="frmIsAttribute[]" value="0" class="input2" />Please select category !'):$.post("ajax.php",{
        action:"ShowAttributeMultipleProduct",
        catid:e,
        showid:t
    },function(e){
        $("#attribute"+t).html(e)
    })
}
function validateCouponForm(){
    var e,t=document.getElementById("frmCouponName"),r=document.getElementById("frmCouponCode"),a=document.getElementById("frmCoupon"),i=document.getElementById("frmDiscount"),n=document.getElementsByName("frmApplyOn");
    if(e=n[1].checked?0:1,""==trim(t.value))return alert("Coupon Name is Required!"),t.focus(),!1;
    if(""==trim(r.value))return alert("Coupon Code is Required!"),r.focus(),!1;
    if("1"==a.value)return alert("Coupon Code Already in use.Please enter different Coupon Code."),r.select(),!1;
    if(""==i.value)return alert("Discount is Required!"),i.focus(),!1;
    if(parseFloat(i.value) < 0.01)return alert("Discount should be greater than 0 !"),i.focus(),!1;
    if(0==AcceptDecimal(i.value))return alert("Please enter numeric or decimal value!"),i.select(),!1;
    if(i.value>100)return alert("Discount should be less than or equal to 100!"),i.select(),!1;
    if(0==e)for(var l=document.getElementsByName("frmCategoryId[]"),o=document.getElementsByName("frmProductId[]"),u=0;u<l.length;u++){
        if(0==l[u].value)return alert("Please Select Category!"),l[u].focus(),!1;
        if(0==o[u].value)return alert("Please Select Product!"),o[u].focus(),!1
    }
}
function validatePackageAddPageForm(){ 
    
    var attr=$('*').hasClass('pattr') ? "1" : "2";
    var attrDetailsId=$('*').hasClass('attrDetailsId') ? "1" : "2";
    var atr = 0;
    var atrOp = 0;
    var e=document.getElementById("frmPackageName"),t=document.getElementById("frmWholesalerId"),r=document.getElementsByName("frmCategoryId[]"),a=document.getElementsByName("frmProductId[]"),i=document.getElementById("frmOfferPrice"),n=document.getElementById("frmTotalPrice"),l=document.getElementById("frmPackageImage");
    if("0"==t.value)return alert("Please Select Wholesaler!"),t.focus(),!1;
    if(attr=='1'){
        $('.pattr').each(function(x){
            var gtId=$(this).attr('id');
            if($('#'+gtId).is(':checked')==false){
                $('#'+gtId+':checkbox').focus();
                atr=1;
            }
        });
        if(atr==1){
            alert('Please select attribute');
            return false;
        }
    }
    if(attrDetailsId=='1'){
        $('.attrDetailsId').each(function(x){
            var gtId=$(this).attr('id');
            var gtOpId=$('#'+gtId).find('input:radio').attr('class');
            if($('.'+gtOpId).is(':checked')==false){
                $('.'+gtOpId+':radio').focus();
                atrOp=1;
            }
        });
        if(atrOp==1){
            alert('Please select attribute option');
            return false;
        } 
    }
    for(var o=0;o<r.length;o++){
        if(0==r[o].value)return alert("Please Select Category!"),r[o].focus(),!1;
        if(0==a[o].value)return alert("Please Select Product!"),a[o].focus(),!1
    }
    
    for(var o=0;o<a.length;o++)for(var u=o+1;u<a.length;u++)if(a[o].value==a[u].value)return alert("Same product cannot be added more than once in a package."),a[u].focus(),!1;if(""==i.value)return alert("Offer Price is Required!"),i.focus(),!1;
    if(0==AcceptDecimal(i.value))return alert("Please Enter numeric or decimal value!"),i.focus(),!1;
    if(i.value<0)return alert("Offer Price should not be negitive!"),i.focus(),!1;
    if(0==IsLessThan(n.value,i.value))return alert("Offer Price should be less than Total Price !"),i.focus(),!1;
    if(""==trim(e.value))return alert("Package Name is Required!"),e.focus(),!1;
    if(""!=l.value){
        var s=l.value,m=s.substring(s.lastIndexOf(".")+1),c=m.toLowerCase();
        if("jpg"!=c&&"jpeg"!=c&&"gif"!=c&&"png"!=c)return alert("Accepted Image formats are: jpg, jpeg, gif, png"),l.focus(),!1
    }
    if(ImageExist==0 || ImageExist=='')
    {
        var frmDefaultImg = l.value;
        if(frmDefaultImg==''){
            alert("Please select an image");
            $('#file1').focus();
            return false;
        }
    }
}
function ShowRegion(e){
    ""==e?$("#regions").html('<select name="frmRegion" id="frmRegion"><option value="">Select Region</option></select>'):$.post("ajax.php",{
        action:"ShowRegion",
        ctyid:e
    },function(e){
        $("#regions").html(e)
    })
}
function ShowStateByCountry(e,t,r){
    ""==e?$("#"+t).html('<option value="">Select</option>'):$.post("ajax.php",{
        action:"ShowStateByCountry",
        ctyid:e,
        stateid:r
    },function(e){
        $("#"+t).html(e)
    })
}
function ShowProductForPackage(e,t){
    var r=$("#frmWholesalerId").val();
    $("#price"+t).html('<input type="hidden" name="frmPrice[]" class="input1" value="0.00" /><b>0.00</b>');
    var a,i,n=document.getElementsByName("frmPrice[]"),l=0;
    for(a=0;a<n.length;a++)i=parseFloat(n[a].value),l+=i;
    l=l.toFixed(2),$("#asc").html(l),$("#frmTotalPrice").val(l),0==e?$("#product"+t).html('<select name="frmProductId[]" class="packageProduct" style="width:170px;"><option value="0">Product</option></select>'):$.post("ajax.php",{
        action:"ShowProductForPackage",
        catid:e,
        whid:r,
        showid:t
    },function(e){
        $("#product"+t).html(e)
    })
}
function ResetProductForPackage(){
    $.post("ajax.php",{
        action:"ResetProductForPackage"
    },function(e){
        $(".packageCategory").html(e),$(".packageProduct").html('<option value="0">Product</option>'),$(".packageProductPrice").html("0.00"),$("#asc").html("0.00"),$("#frmTotalPrice").val("0.00")
    })
}
function ShowProductPriceForPackage(e,t,edit,pro){  //alert(e);alert(t);alert('test');
    if(0==e){
        $("#price"+t).html('<input type="hidden" name="frmPrice[]" class="input1" value="0.00" /><b class="packageProductPrice">0.00</b>');
        var r,a,i=document.getElementsByName("frmPrice[]"),n=0;
        for(r=0;r<i.length;r++)a=parseFloat(i[r].value),n+=a;
        n=n.toFixed(2),$("#asc").html(n),$("#frmTotalPrice").val(n)
    }else $.post("ajax.php",{
        action:"ShowProductPriceForPackage",
        pid:e,
        showid:t
    },function(e){ 
        e=e.split('++');
        x=e[1];
        y=e[0];
        if(edit=='edit'){
            $('.editAttribute_'+pro).hide();
        }
        if (x == 'attr') {
            var select_Attribute1=$('*').hasClass('select_Attribute') ? "1" : "2";
            var select_Attribute2=$('*').hasClass('blank_Attribute_td_'+t+'') ? "1" : "2";
            if(select_Attribute1==2){
                $('#productRow').find('tr:eq(0)').find('td:eq(2)').after('<td class="select_Attribute"><b>*Select Attribute</b></td>');
            }
            if(select_Attribute2==2){
                $('#productRow').find('tr:eq('+t+')').find('td:eq(2)').after('<td class="blank_Attribute_td_'+t+' blankAt"></td>');
            }
				
            $(".blank_Attribute_td_" + t).html(y);
            $("#price" + t).html(e[2]);
        } else {
            $(".blank_Attribute_td_" + t).remove();
            var select_Attribute=$('*').hasClass('blankAt') ? "1" : "2";
            if(select_Attribute==2){
                $(".select_Attribute").remove();
            }
            $("#price" + t).html(y);
        }
        //        var r,a,i=document.getElementsByName("frmPrice[]"),n=0;
        //        for(r=0;r<i.length;r++)a=parseFloat(i[r].value),n+=a;
        //        n=n.toFixed(2),$("#asc").html(n),$("#frmTotalPrice").val(n)
        
        var r,a,n=0;
        for(r=1;r<=t;r++){
            a=parseFloat($('#price'+r).find('b').html());
            n+=a;
        }
        n=n.toFixed(2);
        $("#asc").html(n);
        $("#frmTotalPrice").val(n);
    })
}
function checkProductRefNo(e){
    ""==e?$("#refmsg").html('<input type="hidden" name="frmIsRefNo" value="0" />'):$.post("ajax.php",{
        action:"checkProductRefNo",
        refno:e
    },function(e){
        $("#refmsg").html(e)
    })
}
function checkCouponCode(e){
    var t,r=$("#frmCouponCode").val();
    ""==r?$("#frmCoupon").val("0"):$.post("ajax.php",{
        action:"checkCouponCode",
        code:r,
        id:e
    },function(e){
        t="0"==e?"":"Coupon Code Already in use.<br />Please enter different Coupon Code.",$("#frmCoupon").val(e),$("#code").html(t)
    })
}
function checkProductRefNoForMultiple(e,t){
    ""==e?$("#refmsg"+t).html('<input type="hidden" name="frmIsRefNo[]" value="0" />'):$.post("ajax.php",{
        action:"checkProductRefNoForMultiple",
        refno:e,
        showid:t
    },function(e){
        $("#refmsg"+t).html(e)
    })
}
function validateAdminPageLimit(e){
    if(validateForm(e,"frmRecordPerpage","Record Per Page Limit","R")){
        var t=document.getElementById("frmRecordPerpage").value;
        return 1==IsDigits(trim(t))?(alert("Record Per Page Limit should be number"),!1):5>t?(alert("Record Per Page Limit should not be less than 5"),!1):!0
    }
    return!1
}
function checkWholeSalerEmail(e){
    var t,r=$("#frmCompanyEmail").val();
    ""==r?($("#frmCEmail").val("0"),$("#CompanyEmail").html("")):$.post("ajax.php",{
        action:"checkWholeSalerEmail",
        code:r,
        id:e
    },function(e){
        t="0"==e?"":" Email Already in use. Please enter different email.",$("#frmCEmail").val(e),$("#CompanyEmail").html(t)
    })
}
function checkCustomerEmail(e){
    var t,r=$.trim($("#frmEmail").val());
    if(r==''){
        return false;
    }
    ""==r?($("#frmCEmail").val("0"),$("#CustomerEmail").html("")):$.post("ajax.php",{
        action:"checkCustomerEmail",
        code:r,
        id:e
    },function(e){
        t="0"==e?"":" Email Already in use. Please enter different email.",$("#frmCEmail").val(e),$("#CustomerEmail").html(t)
    })
}

function showRegionForWholesaler(e,t){
    0==e?$("#"+t).html("<option>Select</option>"):$.post("ajax.php",{
        action:"showRegionForWholesaler",
        q:e
    },function(e){
        $("#"+t).html(e)
    })
}
function showTimezone(e,t){
    0==e?$("#"+t).html("<option>Select</option>"):$.post("ajax.php",{
        action:"getTimeZone",
        q:e
    },
function(e){
   
        $("#"+t).html(e)
    })
}

function validateWholesalerAddForm(e){
    var t=document.getElementsByName("frmShippingGateway[]");
    return""==e.frmCompanyName.value?(alert("Company Name is Required!"),e.frmCompanyName.focus(),!1):""==e.frmAboutCompany.value?(alert("About Company is Required!"),e.frmAboutCompany.focus(),!1):e.frmAboutCompany.value.length<200?(alert("Minimum 200 words required About Company"),e.frmAboutCompany.focus(),!1):""==e.frmCommission.value?(alert("Commission is Required!"),e.frmCommission.focus(),!1):0==IsChecked(t)?(alert("Shipping Gateway is Required !"),t[0].focus(),!1):0==AcceptDecimal(e.frmCommission.value)?(alert("Please Enter Valid Commission"),e.frmCommission.focus(),!1):""==e.frmCompanyAddress1.value?(alert("Address1 is Required!"),e.frmCompanyAddress1.focus(),!1):""==e.frmCompanyCity.value?(alert("City is Required!"),e.frmCompanyCity.focus(),!1):"0"==e.frmCompanyCountry.value?(alert("Please Select Country!"),e.frmCompanyCountry.focus(),!1):""==e.frmCompanyPostalCode.value?(alert("PostalCode is Required!"),e.frmCompanyPostalCode.focus(),!1):1==IsDigits(e.frmCompanyPostalCode.value)?(alert("Please enter valid PostalCode!"),e.frmCompanyPostalCode.focus(),!1):""==e.frmCompanyEmail.value?(alert("Company Email is Required!"),e.frmCompanyEmail.focus(),!1):0==AcceptEmail(e.frmCompanyEmail.value)?(alert("Please enter valid Email!"),e.frmCompanyEmail.focus(),!1):"1"==e.frmCEmail.value?(alert("Email Already in use. Please enter different email!"),e.frmCompanyEmail.focus(),!1):""==e.frmPassword.value?(alert("Password is Required!"),e.frmPassword.focus(),!1):6>$.trim(e.frmPassword.value).length?(alert("Password should be atleast 6 character long!"),e.frmPassword.focus(),!1):""==e.frmConfirmPassword.value?(alert("Confirm Password is Required!"),e.frmConfirmPassword.focus(),!1):e.frmPassword.value!=e.frmConfirmPassword.value?(alert("Confirm Password must be same!"),e.frmConfirmPassword.focus(),!1):""==e.frmPaypalEmail.value?(alert("Paypal Email is Required!"),e.frmPaypalEmail.focus(),!1):0==AcceptEmail(e.frmPaypalEmail.value)?(alert("Please enter valid Paypal Email!"),e.frmPaypalEmail.focus(),!1):""==e.frmCompanyPhone.value?(alert("Company Phone is Required!"),e.frmCompanyPhone.focus(),!1):0==IsPhone(e.frmCompanyPhone.value)?(alert("Please enter Valid Phone Number!"),e.frmCompanyPhone.focus(),!1):(8>$.trim(e.frmCompanyPhone.value).length || 20<$.trim(e.frmCompanyPhone.value).length)?(alert("Please enter valid Phone Number!"),e.frmCompanyPhone.focus(),!1):""==e.frmContactPersonName.value?(alert("Contact Person Name is Required!"),e.frmContactPersonName.focus(),!1):""==e.frmContactPersonPosition.value?(alert("Contact Person Position is Required!"),e.frmContactPersonPosition.focus(),!1):""==e.frmContactPersonPhone.value?(alert("Contact Person Phone/Mobile is Required!"),e.frmContactPersonPhone.focus(),!1):0==IsPhone(e.frmContactPersonPhone.value)?(alert("Please enter valid phone number !"),e.frmContactPersonPhone.focus(),!1):(8>$.trim(e.frmContactPersonPhone.value).length || 20<$.trim(e.frmContactPersonPhone.value).length)?(alert("Please enter valid Phone/Mobile Number!"),e.frmContactPersonPhone.focus(),!1):""==e.frmContactPersonEmail.value?(alert("Contact Person Email is Required!"),e.frmContactPersonEmail.focus(),!1):0==AcceptEmail(e.frmContactPersonEmail.value)?(alert("Please enter valid Contact Person Email!"),e.frmContactPersonEmail.focus(),!1):""==e.frmContactPersonAddress.value?(alert("Contact Person Address is Required!"),e.frmContactPersonAddress.focus(),!1):""==e.frmOwnerName.value?(alert("Director/Owner Name is Required!"),e.frmOwnerName.focus(),!1):""==e.frmOwnerPhone.value?(alert("Director/Owner Phone is Required!"),e.frmOwnerPhone.focus(),!1):0==IsPhone(e.frmOwnerPhone.value)?(alert("Please enter valid phone number!"),e.frmOwnerPhone.focus(),!1):(8>$.trim(e.frmOwnerPhone.value).length || 20<$.trim(e.frmOwnerPhone.value).length)?(alert("Please enter valid phone number!"),e.frmOwnerPhone.focus(),!1):""==e.frmOwnerEmail.value?(alert("Director/Owner Email is Required!"),e.frmOwnerEmail.focus(),!1):0==AcceptEmail(e.frmOwnerEmail.value)?(alert("Please enter valid Director/Owner Email!"),e.frmOwnerEmail.focus(),!1):""==e.frmOwnerAddress.value?(alert("Director/Owner Address is Required!"),e.frmOwnerAddress.focus(),!1):""==e.frmRef1Name.value?(alert("Reference1 Name is Required!"),e.frmRef1Name.focus(),!1):""==e.frmRef1Phone.value?(alert("Reference1 Phone/mobile is Required!"),e.frmRef1Phone.focus(),!1):0==IsPhone(e.frmRef1Phone.value)?(alert("Please enter valid phone number!"),e.frmRef1Phone.focus(),!1):(8>$.trim(e.frmRef1Phone.value).length || 20<$.trim(e.frmRef1Phone.value).length)?(alert("Please enter valid phone number!"),e.frmRef1Phone.focus(),!1):""==e.frmRef1Email.value?(alert("Reference1 Email is Required!"),e.frmRef1Email.focus(),!1):0==AcceptEmail(e.frmRef1Email.value)?(alert("Please enter valid Reference1 Email!"),e.frmRef1Email.focus(),!1):""==e.frmRef1CompanyName.value?(alert("Reference1 Company Name is Required!"),e.frmRef1CompanyName.focus(),!1):""==e.frmRef1CompanyAddress.value?(alert("Reference1 Address is Required!"),e.frmRef1CompanyAddress.focus(),!1):""==e.frmRef2Name.value?(alert("Reference2 Name is Required!"),e.frmRef2Name.focus(),!1):""==e.frmRef2Phone.value?(alert("Reference2 Phone/mobile is Required!"),e.frmRef2Phone.focus(),!1):0==IsPhone(e.frmRef2Phone.value)?(alert("Please enter valid phone number!"),e.frmRef2Phone.focus(),!1):""==e.frmRef2Email.value?(alert("Reference2 Email is Required!"),e.frmRef2Email.focus(),!1):(8>$.trim(e.frmRef2Phone.value).length || 20<$.trim(e.frmRef2Phone.value).length)?(alert("Please enter valid phone number!"),e.frmRef2Phone.focus(),!1):0==AcceptEmail(e.frmRef2Email.value)?(alert("Please enter valid Reference2 Email!"),e.frmRef2Email.focus(),!1):""==e.frmRef2CompanyName.value?(alert("Reference2 Company Name is Required!"),e.frmRef2CompanyName.focus(),!1):""==e.frmRef2CompanyAddress.value?(alert("Reference2 Address is Required!"),e.frmRef2CompanyAddress.focus(),!1):""==e.frmRef3Name.value?(alert("Reference3 Name is Required!"),e.frmRef3Name.focus(),!1):""==e.frmRef3Phone.value?(alert("Reference3 Phone/mobile is Required!"),e.frmRef3Phone.focus(),!1):0==IsPhone(e.frmRef3Phone.value)?(alert("Please enter valid phone number!"),e.frmRef3Phone.focus(),!1):(8>$.trim(e.frmRef3Phone.value).length || 20<$.trim(e.frmRef3Phone.value).length)?(alert("Please enter minimum 8 and maximum 20 digits in Reference3 Phone!"),e.frmRef3Phone.focus(),!1):""==e.frmRef3Email.value?(alert("Reference3 Email is Required!"),e.frmRef3Email.focus(),!1):0==AcceptEmail(e.frmRef3Email.value)?(alert("Please enter valid Reference3 Email!"),e.frmRef3Email.focus(),!1):""==e.frmRef3CompanyName.value?(alert("Reference3 Company Name is Required!"),e.frmRef3CompanyName.focus(),!1):""==e.frmRef3CompanyAddress.value?(alert("Reference3 Address is Required!"),e.frmRef3CompanyAddress.focus(),!1):!0

    return false;
}
function IsChecked(e){
    for(var t=0;t<e.length;t++)if(e[t].checked)return!0;return!1
}
function validateCustomerAddForm(e){
    return""==$.trim(e.CustomerFirstName.value)?(alert("Customer Name is Required!"),e.CustomerFirstName.focus(),!1):""==$.trim(e.frmEmail.value)?(alert("Customer Email is Required!"),e.frmEmail.focus(),!1):0==AcceptEmail(e.frmEmail.value)?(alert("Please enter valid Email!"),e.frmEmail.focus(),!1):""==$.trim(e.frmConfirmEmail.value)?(alert("Confirm Email must be same!"),e.frmEmail.focus(),!1):e.frmEmail.value!=e.frmConfirmEmail.value?(alert("Confirm Email must be same!"),e.frmConfirmEmail.focus(),!1):""==$.trim(e.frmPassword.value)?(alert("Password is Required!"),e.frmPassword.focus(),!1):6>$.trim(e.frmPassword.value.length)?(alert("Password should be atleast 6 character long!"),e.frmPassword.focus(),!1):""==$.trim(e.frmConfirmPassword.value)?(alert("Confirm Password is Required!"),e.frmConfirmPassword.focus(),!1):e.frmPassword.value!=e.frmConfirmPassword.value?(alert("Confirm Password must be same!"),e.frmConfirmPassword.focus(),!1):""==$.trim(e.frmResAddressLine1.value)?(alert("Residential address is Required!"),e.frmResAddressLine1.focus(),!1):"0"==e.frmResCountry1.value?(alert("Residential country is Required!"),e.frmResCountry1.focus(),!1):""==$.trim(e.ResPostalCode.value)?(alert("Residential zip code is Required!"),e.ResPostalCode.focus(),!1):""==$.trim(e.frmResPhone.value)?(alert("Residential phone is Required!"),e.frmResPhone.focus(),!1):""==$.trim(e.BillingFirstName.value)?(alert("Billing Recipient First Name is Required!"),e.BillingFirstName.focus(),!1):""==$.trim(e.BillingAddressLine1.value)?(alert("Billing Address Line1 is Required!"),e.BillingAddressLine1.focus(),!1):"0"==e.BillingCountry.value?(alert("Billing Country is Required!"),e.BillingCountry.focus(),!1):""==$.trim(e.BillingPostalCode.value)?(alert("Billing Postal Code is Required!"),e.BillingPostalCode.focus(),!1):0==IsPhone($.trim(e.BillingPhone.value))?(alert("Billing Phone should be numeric!"),e.BillingPhone.focus(),!1):""==$.trim(e.BillingPhone.value)?(alert("Billing Phone is Required!"),e.BillingPhone.focus(),!1):""==$.trim(e.ShippingFirstName.value)?(alert("Shipping Recipient First Name is Required!"),e.ShippingFirstName.focus(),!1):""==$.trim(e.ShippingAddressLine1.value)?(alert("Shipping Address Line1 is Required!"),e.ShippingAddressLine1.focus(),!1):"0"==e.ShippingCountry.value?(alert("Shipping Country is Required!"),e.ShippingCountry.focus(),!1):""==$.trim(e.ShippingPostalCode.value)?(alert("Shipping Postal Code is Required!"),e.ShippingPostalCode.focus(),!1):0==IsPhone($.trim(e.ShippingPhone.value))?(alert("Shipping Phone should be numeric!"),e.ShippingPhone.focus(),!1):""==$.trim(e.ShippingPhone.value)?(alert("Shipping Phone is Required!"),e.ShippingPhone.focus(),!1):!0
}
function validateProductAddForm(e,adit){ 
     
     
    //var t=(window.URL||window.webkitURL,document.getElementsByClassName("prod_img"),0);
    if(""==e.frmProductName.value)return alert("Product Name is Required!"),e.frmProductName.focus(),!1;
    if(""==e.frmProductRefNo.value)return alert("Product Ref No. is Required!"),e.frmProductRefNo.focus(),!1;
    if(1==e.frmIsRefNo.value)return alert("Product Ref No. allready Exist. Please change !"),e.frmProductRefNo.focus(),!1;
    if(0==e.frmfkCategoryID.value)return alert("Please Select Category !"),e.frmfkCategoryID.focus(),!1;
    if(e.frmWeight.value <= 0 || e.frmWeight.value=='')return alert("Weight can not be less then 1!"),e.frmWeight.focus(),!1;
    if(e.frmLength.value <= 0 || e.frmLength.value=='')return alert("Length can not be less then 1!"),e.frmLength.focus(),!1;
    if(e.frmWidth.value <= 0 || e.frmWidth.value=='')return alert("Width can not be less then 1!"),e.frmWidth.focus(),!1;
    if(e.frmHeight.value <= 0 || e.frmHeight.value=='')return alert("Height can not be less then 1!"),e.frmHeight.focus(),!1;
    if(""==e.frmWholesalePrice.value)return alert("Wholesale Price is Required!"),e.frmWholesalePrice.focus(),!1;
    if(e.frmWholesalePrice1.value < 0)return alert("Wholesale Price can not be less then 1!"),e.frmWholesalePrice1.focus(),!1;
    if(e.frmWholesalePrice2.value < 0)return alert("Discount Price can not be less then 1!"),e.frmWholesalePrice2.focus(),!1;
    if(parseFloat(e.frmWholesalePrice.value)<=parseFloat(e.frmDiscountPrice.value))return alert("Discount price should be less than wholesaler price!"),e.frmDiscountPrice.focus(),!1;
    if(0==AcceptDecimal(e.frmWholesalePrice.value))return alert("Please Enter numeric or decimal value!"),e.frmWholesalePrice.focus(),!1;
    if(""==e.frmQuantity.value)return alert("Stock Quantity is Required!"),e.frmQuantity.focus(),!1;
    if(e.frmQuantity.value < 0)return alert("Quantity can not be less then 1!"),e.frmQuantity.focus(),!1;
    if(e.frmQuantityAlert.value < 0)return alert("Quantity Alert can not be less then 1!"),e.frmQuantityAlert.focus(),!1;
    if(1==IsDigits(e.frmQuantity.value))return alert("Please Enter numeric value !"),e.frmQuantity.focus(),!1;
    if(""!=e.frmQuantityAlert.value&&1==IsDigits(e.frmQuantityAlert.value))return alert("Please Enter numeric value !"),e.frmQuantityAlert.focus(),!1;
    if(0==IsLessThan(e.frmQuantity.value,e.frmQuantityAlert.value))return alert("Sent alert message should be less than Stock Quantity !"),e.frmQuantityAlert.focus(),!1;
    if(0==e.frmCountryID.value)return alert("Please Select Country !"),e.frmCountryID.focus(),!1;
    if(0==e.frmfkWholesalerID.value)return alert("Please Select Wholesaler Name !"),e.frmfkWholesalerID.focus(),!1;
    if(e.frmfkWholesalerID.value>0){
        var r=document.getElementsByName("frmShippingGateway[]");
        if(0==IsChecked(r))return alert("Shipping Gateway is Required !"),r[0].focus(),!1
    }
    if(adit==0){
        var isImage = $('#addinput .responce').find('input:radio').val();    
        if(isImage==undefined){
            alert("Please Upload Product Images !");
            $('#addinput .file_upload').focus();
            return false;
        }
    }   
    
/*  
  var t=document.getElementsByClassName("image_error"),a="",i=0;
    for(i=0;i<t.length;i++)if(""!=document.getElementsByClassName("prod_img")[i].value&&0==t[i].value){
        a="error";
        break
    }
    if("error"==a){
        var n=document.getElementsByClassName("prod_img")[i],l=n.getAttribute("name");
        return"frmProductSliderImg"==l?(alert("Please upload image in between ("+MIN_PRODUCT_SLIDER_IMAGE_WIDTH+"-"+MAX_PRODUCT_IMAGE_WIDTH+")px width and ("+MIN_PRODUCT_IMAGE_HEIGHT+"-"+MAX_PRODUCT_IMAGE_HEIGHT+")px height!"),n.focus(),!1):"frmProductDefaultImg"==l?(alert("Please upload image in between ("+MIN_PRODUCT_IMAGE_WIDTH+"-"+MAX_PRODUCT_IMAGE_WIDTH+")px width and ("+MIN_PRODUCT_IMAGE_HEIGHT+"-"+MAX_PRODUCT_IMAGE_HEIGHT+")px height!"),n.focus(),!1):"frmProductImg"==l.substr(0,13)?(alert("Please upload image in between ("+MIN_PRODUCT_IMAGE_WIDTH+"-"+MAX_PRODUCT_IMAGE_WIDTH+")px width and ("+MIN_PRODUCT_DETAIL_IMAGE_HEIGHT+"-"+MAX_PRODUCT_IMAGE_HEIGHT+")px height!"),n.focus(),!1):(alert("Please enter valid image."),n.focus(),!1)
    }
    return!0
     */
}
function validateShipplingGatewaysForm(e){  //alert('test11');return false;
    var t=document.getElementsByName("frmWeight[]"),r=document.getElementsByName("frmA[]"),a=document.getElementsByName("frmB[]"),i=document.getElementsByName("frmC[]"),n=document.getElementsByName("frmD[]"),l=document.getElementsByName("frmE[]"),o=document.getElementsByName("frmF[]"),u=document.getElementsByName("frmG[]"),s=document.getElementsByName("frmH[]"),m=document.getElementsByName("frmI[]"),c=document.getElementsByName("frmJ[]"),d=document.getElementsByName("frmK[]");
    if(""==e.frmShippingGatewayID.value||"0"==e.frmShippingGatewayID.value)return alert("Shipping gateway is Required!"),e.frmShippingGatewayID.focus(),!1;
    if(""==e.frmShippingMethodID.value||"0"==e.frmShippingMethodID.value)return alert("Shipping method is Required!"),e.frmShippingMethodID.focus(),!1;
    if(!(t.length>0))return!0;
    for(var f=0;f<t.length;f++){
        if(""==t[f].value)return alert("Weight is Required!"),t[f].focus(),!1;
        if(t[f].value < 0)return alert("Weight should not be less then 1!"),t[f].focus(),!1;
        if(0==AcceptDecimal(t[f].value))return alert("Please Enter numeric or decimal value!"),t[f].select(),!1;
        
        if(""==r[f].value && ""==a[f].value && ""==i[f].value && ""==n[f].value && ""==l[f].value && ""==o[f].value && ""==u[f].value && ""==s[f].value && ""==m[f].value && ""==c[f].value && ""==d[f].value)return alert("Zone is Required!"),r[f].focus(),!1;
        if(r[f].value < 0){
        alert("Zone should not be less then 1!");
        r[f].focus();
        return false;
        }else if(a[f].value < 0){
        alert("Zone should not be less then 1!");
        a[f].focus();
        return false;    
        }else if(i[f].value < 0){
        alert("Zone should not be less then 1!");
        i[f].focus();
        return false;    
        }else if(n[f].value < 0){
        alert("Zone should not be less then 1!");
        n[f].focus();
        return false;    
        }else if(l[f].value < 0){
        alert("Zone should not be less then 1!");
        l[f].focus();
        return false;    
        }else if(o[f].value < 0){
        alert("Zone should not be less then 1!");
        o[f].focus();
        return false;    
        }else if(u[f].value < 0){
        alert("Zone should not be less then 1!");
        u[f].focus();
        return false;    
        }else if(s[f].value < 0){
        alert("Zone should not be less then 1!");
        s[f].focus();
        return false;    
        }else if(m[f].value < 0){
        alert("Zone should not be less then 1!");
        m[f].focus();
        return false;    
        }else if(c[f].value < 0){
        alert("Zone should not be less then 1!");
        c[f].focus();
        return false;    
        }else if(d[f].value < 0){
        alert("Zone should not be less then 1!");
        d[f].focus();
        return false;    
        }
        
        if(0==AcceptDecimal(r[f].value) && r[f].value!=''){
        alert("Please Enter numeric or decimal value!");
        r[f].select()
        return false;
        }else if(0==AcceptDecimal(a[f].value) && a[f].value!=''){
        alert("Please Enter numeric or decimal value!");
        a[f].select()
        return false;
        }else if(0==AcceptDecimal(i[f].value) && i[f].value!=''){
        alert("Please Enter numeric or decimal value!");
        i[f].select()
        return false;
        }else if(0==AcceptDecimal(n[f].value) && n[f].value!=''){
        alert("Please Enter numeric or decimal value!");
        n[f].select()
        return false;
        }else if(0==AcceptDecimal(l[f].value) && l[f].value!=''){
        alert("Please Enter numeric or decimal value!");
        l[f].select()
        return false;
        }else if(0==AcceptDecimal(o[f].value) && o[f].value!=''){
        alert("Please Enter numeric or decimal value!");
        o[f].select()
        return false;
        }else if(0==AcceptDecimal(u[f].value) && u[f].value!=''){
        alert("Please Enter numeric or decimal value!");
        u[f].select()
        return false;
        }else if(0==AcceptDecimal(s[f].value) && s[f].value!=''){
        alert("Please Enter numeric or decimal value!");
        s[f].select()
        return false;
        }else if(0==AcceptDecimal(m[f].value) && m[f].value!=''){
        alert("Please Enter numeric or decimal value!");
        m[f].select()
        return false;
        }else if(0==AcceptDecimal(c[f].value) && c[f].value!=''){
        alert("Please Enter numeric or decimal value!");
        c[f].select()
        return false;
        }else if(0==AcceptDecimal(d[f].value) && d[f].value!=''){
        alert("Please Enter numeric or decimal value!");
        d[f].select()
        return false;
        }
        
  
    }
}
function showShippingMethod(e,t,r){
    0==e||""==e?$("#"+r).html('<option value="0">Select Shipping Method</option>'):$.post("ajax.php",{
        action:"showShippingMethod",
        q:e,
        selId:t
    },function(e){
        $("#"+r).html(e)
    })
}
function validateShipplingMethodForm(e){
    return""==e.frmfkShippingGatewayID.value||"0"==e.frmfkShippingGatewayID.value?(alert("Shipping Gateways is Required!"),e.frmfkShippingGatewayID.focus(),!1):""==$.trim(e.frmMethodName.value)?(alert("Name/Title is Required!"),e.frmMethodName.focus(),!1):""==$.trim(e.frmMethodCode.value)?(alert("Code is Required!"),e.frmMethodCode.focus(),!1):!0
}
function validateShipplingForm(e){
    return""==$.trim(e.frmShippingName.value)?(alert("Shipping Title is Required!"),e.frmShippingName.focus(),!1):""==$.trim(e.frmShippingCode.value)?(alert("Shipping Code is Required!"),e.frmShippingCode.focus(),!1):!0
}

function validateDefaultCommissionForm(e){
    return""==e.frmWholesalerSalesCommission.value?(alert("Wholesaler Sales Commission is Required!"),e.frmWholesalerSalesCommission.focus(),!1):0==AcceptDecimal(e.frmWholesalerSalesCommission.value) || e.frmWholesalerSalesCommission.value < 0?(alert("Please Enter positive numeric value!"),e.frmWholesalerSalesCommission.focus(),!1):""==e.frmAdminUsersCommission.value?(alert("Country Portal Sales Comission is Required!"),e.frmAdminUsersCommission.focus(),!1):0==AcceptDecimal(e.frmAdminUsersCommission.value) || e.frmAdminUsersCommission.value < 0?(alert("Please Enter positive numeric value!"),e.frmAdminUsersCommission.focus(),!1):""==e.frmAdminUsersPeriod.value||"0"==e.frmAdminUsersPeriod.value?(alert("Please select Comission Period !"),e.frmAdminUsersPeriod.focus(),!1):!0
}
function validateMarginCostForm(e){
    if(e.frmMarginCost.value<0){
        alert('Please Enter numeric');
        e.frmMarginCost.focus();
        return false;
    }
    
    return""==e.frmMarginCost.value?(alert("Margin Cost is Required!"),e.frmMarginCost.focus(),!1):0==AcceptDecimal(e.frmMarginCost.value)?(alert("Please Enter numeric or decimal value!"),e.frmMarginCost.focus(),!1):!0
}

function validateBannerDelayTimeForm(e){
    
    var q = e.frmDelayTime.value;
    
    if(q==''){
        alert("Delay Time is Required!");
        e.frmDelayTime.focus();
        return false;
    }else if(IsDigits(q)){
        alert("Please Enter numeric value!");
        e.frmDelayTime.focus();
        return false;
    }else if(q=='0'){
        alert("Delay Time Should be greater than 0!");
        e.frmDelayTime.focus();
        return false;
    }
}

function validateSpecialApplicationForm(e){
    
    var ap = e.SpecialApplicationPrice.value;
    var cp = e.SpecialApplicationCategoryPrice.value;
    var pp = e.SpecialApplicationProductPrice.value;
    
    if(ap==''){
        alert("Special Price is Required!");
        e.SpecialApplicationPrice.focus();
        return false;
    }else if(ap<0){
        alert("Special Price should not be negative price!");
        e.SpecialApplicationPrice.focus();
        return false;
    }else if(!AcceptDecimal(ap)){
        alert("Please Enter decimal value!");
        e.SpecialApplicationPrice.focus();
        return false;
    }else if(cp==''){
        alert("Special Category Price is Required!");
        e.SpecialApplicationCategoryPrice.focus();
        return false;
    }else if(cp<0){
        alert("Special Category should not be negative price!");
        e.SpecialApplicationCategoryPrice.focus();
        return false;
    }else if(!AcceptDecimal(cp)){
        alert("Please Enter decimal value!");
        e.SpecialApplicationCategoryPrice.focus();
        return false;
    }else if(pp==''){
        alert("Special Product Price is Required!");
        e.SpecialApplicationProductPrice.focus();
        return false;
    }else if(pp<0){
        alert("Special Product Price should not be negative price!");
        e.SpecialApplicationProductPrice.focus();
        return false;
    }else if(!AcceptDecimal(pp)){
        alert("Please Enter decimal value!");
        e.SpecialApplicationProductPrice.focus();
        return false;
    }
    
}


function validateRewardPointsForm(e){

    var RewardPointValue = e.RewardPointValue;
    var RewardMinimumPointToBuy = e.RewardMinimumPointToBuy;
    var RewardOnCustomerRegistration = e.RewardOnCustomerRegistration;
    var RewardOnNewsletterSubscribe = e.RewardOnNewsletterSubscribe;
    var RewardOnRecommendProduct = e.RewardOnRecommendProduct;    
    var RewardOnSocialMediaSharing = e.RewardOnSocialMediaSharing;
    var RewardOnReviewRatingProduct = e.RewardOnReviewRatingProduct;    
    var RewardOnOrderFeedback = e.RewardOnOrderFeedback;    
    var RewardOnOrder = e.RewardOnOrder;    
    var RewardOnReferal = e.RewardOnReferal;   
    
    if(RewardPointValue.value=='' ){
        alert("Point Value is Required!");
        RewardPointValue.focus();
        return false;
    }else if(!AcceptDecimal(RewardPointValue.value) || RewardPointValue.value < 0){
        alert("Please Enter positive decimal value!");
        RewardPointValue.focus();
        return false;
    }else if(!AcceptDecimal(RewardPointValue.value)){
        alert("Please Enter decimal value!");
        RewardPointValue.focus();
        return false;
    }else if(RewardMinimumPointToBuy.value==''){
        alert("Minimum Points is Required!");
        RewardMinimumPointToBuy.focus();
        return false;
    }else if(IsDigits(RewardMinimumPointToBuy.value)){
        alert("Please Enter integer value!");
        RewardMinimumPointToBuy.focus();
        return false;
    }else if(RewardOnCustomerRegistration.value==''){
        alert("Customer registration is Required!");
        RewardOnCustomerRegistration.focus();
        return false;
    }else if(IsDigits(RewardOnCustomerRegistration.value)){
        alert("Please Enter integer value!");
        RewardOnCustomerRegistration.focus();
        return false;
    }else if(RewardOnNewsletterSubscribe.value==''){
        alert("Subscribe newsletter is Required!");
        RewardOnNewsletterSubscribe.focus();
        return false;
    }else if(IsDigits(RewardOnNewsletterSubscribe.value)){
        alert("Please Enter integer value!");
        RewardOnNewsletterSubscribe.focus();
        return false;
    }else if(RewardOnRecommendProduct.value==''){
        alert("Recommend product is Required!");
        RewardOnRecommendProduct.focus();
        return false;
    }else if(IsDigits(RewardOnRecommendProduct.value)){
        alert("Please Enter integer value!");
        RewardOnRecommendProduct.focus();
        return false;
    }else if(RewardOnSocialMediaSharing.value==''){
        alert("Sharing products is Required!");
        RewardOnSocialMediaSharing.focus();
        return false;
    }else if(IsDigits(RewardOnSocialMediaSharing.value)){
        alert("Please Enter integer value!");
        RewardOnSocialMediaSharing.focus();
        return false;
    }else if(RewardOnReviewRatingProduct.value==''){
        alert("Review/Rating product is Required!");
        RewardOnReviewRatingProduct.focus();
        return false;
    }else if(IsDigits(RewardOnReviewRatingProduct.value)){
        alert("Please Enter integer value!");
        RewardOnReviewRatingProduct.focus();
        return false;
    }else if(RewardOnOrderFeedback.value==''){
        alert("Feedback on order is Required!");
        RewardOnOrderFeedback.focus();
        return false;
    }else if(IsDigits(RewardOnOrderFeedback.value)){
        alert("Please Enter integer value!");
        RewardOnOrderFeedback.focus();
        return false;
    }/*else if(RewardOnOrder.value==''){
        alert("Place an order is Required!");
        RewardOnOrder.focus();
        return false;
    }else if(IsDigits(RewardOnOrder.value)){
        alert("Please Enter integer value!");
        RewardOnOrder.focus();
        return false;
    }*/else if(RewardOnReferal.value==''){
        alert("Referal link is Required!");
        RewardOnReferal.focus();
        return false;
    }else if(IsDigits(RewardOnReferal.value)){
        alert("Please Enter integer value!");
        RewardOnReferal.focus();
        return false;
    }
}


function validateKPISettingForm(){
    for(var e=document.getElementsByName("frmCountryId[]"),t=document.getElementsByName("frmKPIVal[]"),r=1;r<e.length;r++){
        if(0==e[r].value)return alert("Please select country !"),e[r].focus(),!1;
        if(0==t[r].value)return alert("Please select value!"),t[r].focus(),!1
    }
    return!0
}

function validateKPIPremiumSettingForm(){ 
    var e=document.getElementById("frmPreKPIProductVal"),t=document.getElementById("frmPreKPIVal");
        if(0==e.value)return alert("Product sold required !"),e.focus(),!1;
        if(/^[0-9]+$/.test(e.value) ==false && e.value!='')return alert("Enter numeric value for product sold!"),e.focus(),!1;
        if(0==t.value)return alert("Kpi value required!"),t.focus(),!1;
        if(/^[0-9]+$/.test(t.value) ==false && t.value!='')return alert("Enter numeric value for Kpi!"),t.focus(),!1;
    return!0
}
function validateMultipleProductAddForm(){
    var e=document.getElementById("frmCountryID"),t=document.getElementById("frmfkWholesalerID"),r=document.getElementsByName("frmProductRefNo[]"),a=document.getElementsByName("frmIsRefNo[]"),i=document.getElementsByName("frmProductName[]"),n=document.getElementsByName("frmWholesalePrice[]"),nd=document.getElementsByName("frmDiscountPrice[]"),l=document.getElementsByName("frmQuantity[]"),o=document.getElementsByName("frmQuantityAlert[]"),u=document.getElementsByName("frmfkCategoryID[]");
    if(0==e.value)return alert("Plase Select Country!"),e.focus(),!1;
    if(0==t.value)return alert("Plase Select Wholesaler!"),t.focus(),!1;
    if(t.value>0){
        var s=document.getElementsByName("frmShippingGateway[]");
        if(0==IsChecked(s))return alert("Shipping Gateway is Required !"),s[0].focus(),!1
    }
    for(var m=0;m<r.length;m++){
        if(""==i[m].value)return alert("Product Name is Required!"),i[m].focus(),!1;
        if(""==r[m].value)return alert("Product Ref No. is Required!"),r[m].focus(),!1;
        if(1==a[m].value)return alert("Product Ref No. allready Exist.Please Change!"),r[m].focus(),!1;
        if(r.length>1)for(var c=0;c<r.length;c++)if(r[m].value==r[c].value&&m!=c)return alert("Product Ref No can not same!"),r[c].focus(),!1;if(""==n[m].value)return alert("Price is Required!"),n[m].focus(),!1;
        if(parseFloat(n[m].value)<=parseFloat(nd[m].value))return alert("Discount price should be less than wholesaler price!"),nd[m].focus(),!1;
        if(0==AcceptDecimal(n[m].value))return alert("Please Enter numeric or decimal value!"),n[m].focus(),!1;
        /*
      if(r.length>0){
            var d=m+1,f=document.getElementsByName("frmProductImg["+d+"][]");
            if(f.length>0)for(var p=0;p<f.length;p++){
                var v=f[p].value;
                if(""!=v){
                    var g=v.substring(v.lastIndexOf(".")+1),h=g.toLowerCase();
                    if("jpg"!=h&&"jpeg"!=h&&"gif"!=h&&"png"!=h)return alert("Accepted Image formats are: jpg, jpeg, gif, png"),f[p].focus(),!1
                }
            }
        }*/
        if(""==l[m].value)return alert("Quantity is Required!"),l[m].focus(),!1;
        if(1==IsDigits(l[m].value))return alert("Please Enter numeric value !"),l[m].focus(),!1;
        if(""!=o[m].value&&1==IsDigits(o[m].value))return alert("Please Enter numeric value !"),o[m].focus(),!1;
        if(0==IsLessThan(l[m].value,o[m].value))return alert("Sent alert message should be less than Stock Quantity !"),o[m].focus(),!1;
        if(0==u[m].value)return alert("Please Select Category!"),u[m].focus(),!1;
    /*
        var y=document.getElementsByClassName("image_error"),P="",m=0;
        for(m=0;m<y.length;m++)if(""!=document.getElementsByClassName("prod_img")[m].value&&0==y[m].value){
            P="error";
            break
        }
        if("error"==P){
            var C=document.getElementsByClassName("prod_img")[m],E=C.getAttribute("name");
            return"frmProductSliderImg"==E.substr(0,19)?(alert("Please upload image in between ("+MIN_PRODUCT_SLIDER_IMAGE_WIDTH+"-"+MAX_PRODUCT_IMAGE_WIDTH+")px width and ("+MIN_PRODUCT_IMAGE_HEIGHT+"-"+MAX_PRODUCT_IMAGE_HEIGHT+")px height!"),C.focus(),!1):"frmProductDefaultImg"==E.substr(0,20)?(alert("Please upload image in between ("+MIN_PRODUCT_IMAGE_WIDTH+"-"+MAX_PRODUCT_IMAGE_WIDTH+")px width and ("+MIN_PRODUCT_IMAGE_HEIGHT+"-"+MAX_PRODUCT_IMAGE_HEIGHT+")px height!"),C.focus(),!1):"frmProductImg"==E.substr(0,13)?(alert("Please upload image in between ("+MIN_PRODUCT_IMAGE_WIDTH+"-"+MAX_PRODUCT_IMAGE_WIDTH+")px width and ("+MIN_PRODUCT_IMAGE_HEIGHT+"-"+MAX_PRODUCT_IMAGE_HEIGHT+")px height!"),C.focus(),!1):(alert("Please enter valid image."),C.focus(),!1)
        }
         */
    }
    return!0
}
function validateBulkUpload(){
    var e=document.getElementById("frmContentName"),t=document.getElementById("frmPackageImages"),r=document.getElementById("frmImages"),a=document.getElementById("frmFile"),i=(document.getElementsByName("frmFields[]"),1);
    
    if(""==e.value)return alert("Please Select what you want to upload!"),e.focus(),!1;
    if($("#"+e.value+" .requiredUploadFields").each(function(){
        !this.checked&&i&&(alert("Please select the mandatory fields."),this.focus(),i=0)
    }),0==i)return!1;
    if(""==a.value)return alert("Please Select file!"),a.focus(),!1;
    if(""!=a.value){
        var n=a.value,l=n.substring(n.lastIndexOf(".")+1),l=l.toLowerCase();
        if("xls"!=l&&"xlsx"!=l&&"csv"!=l)return alert("Accepted File formats are: csv,xlsx,xls"),a.focus(),!1
    }
    if("product"==e.value && ""==r.value)return alert("Please upload a zip file of images !"),r.focus(),!1;    
    if("product"==e.value){
        var n=r.value,l=n.substring(n.lastIndexOf(".")+1),l=l.toLowerCase();
        if("zip"!=l)return alert("Accepted File formats is: zip"),r.focus(),!1
    }
    if("packages"==e.value && ""==t.value)return alert("Please upload a zip file of images !"),t.focus(),!1;
    if("packages"==e.value){
        var n=t.value,l=n.substring(n.lastIndexOf(".")+1),l=l.toLowerCase();
        if("zip"!=l)return alert("Accepted File formats is: zip"),t.focus(),!1
    }
            
// return"product"==e.value&&""==r.value?(alert("Please upload a zip file of images!"),r.focus(),!1):"packages"==e.value&&""==t.value?(alert("Please upload a zip file of images!"),t.focus(),!1):void 0
}
function validateWholeSalerProductForm(e){
    return validateForm(e,"frmWholeSalerMinimumPurchase","Wholesaler Minimum Product","R")?!0:!1
}
function validateBrand(e){
    return validateForm(e,"frmBrandName","Brand Name","R","frmCategoryID","Brand Category","R")?!0:!1
}
function validateCountry(e){
    return validateForm(e,"frmCountryName","Country Name","R")?!0:!1
}
function validateState(e){
    return validateForm(e,"frmStateName","State Name","R","frmCountry","Country Name","R")?!0:!1
}
function validateCoupon(e){
    if(!validateForm(e,"frmCouponCode","Coupon Code","R","frmCouponPriceValue","Price Value","RisDecimal","frmMinimumPurchaseAmount","Minimum Purchase Amount","RisDecimal","frmCouponPriceValue","Price Value","regDecimal","frmCouponActivateDate","Coupon Activate date","R","frmCouponExpiryDate","coupon expiry date","R"))return!1;
    var t=document.forms[0].frmCouponActivateDate.value,r=document.forms[0].frmCouponExpiryDate.value;
    return t>r?(alert("Sorry, we can not complete your request.\nKindly provide us the missing or incorrect information enclosed below.\n\n\n-Coupon expiry date should be greater than coupon active date."),!1):void 0
}
function validateGiftCard(e){
    return validateForm(e,"frmGiftCardName","Gift Card Name","R","frmGiftCardAmount","Gift Card Amount","R")?!0:!1
}
function validateApplyDiscount(e){
    return validateForm(e,"frmDiscountPercentage","Discount Percent","R")?!0:!1
}
function validateSendCoupon(e){
    return validateForm(e,"frmUserEmail","User Email","RisEmail")?!0:!1
}
function validateColor(e){
    return validateForm(e,"frmColorName","Color Name","R")?!0:!1
}
function validateSize(e){
    return validateForm(e,"frmSizeName","Size Name","R")?!0:!1
}
function showCategoryRow(e){
    "Category"==e?document.getElementById("categoryBannerRow").style.display="table-row":"WholesaleRegistration"==e||"WholesaleContactUs"==e?document.getElementById("bannerPosition").style.display="none":(document.getElementById("bannerPosition").style.display="table-row",document.getElementById("categoryBannerRow").style.display="none")
}
function validateAdsAddPageForm(e,t){ //alert($("#frmCountry").val()); return false;
    var r=$("#"+e+" input[type='radio']:checked").val();
    if("html"==r){
        if(""==trim($("#frmTitle").val()))return alert("Title is required!"),$("#frmTitle").focus(),!1;
        if(""==trim($("#frmHtmlCode").val()))return alert("Html Code is required!"),$("#frmHtmlCode").focus(),!1;
        if(""==trim($("#frmAdsPage").val()))return alert("Please select the page for advertiment!"),$("#frmAdsPage").focus(),!1;
        if($('#countryIds').is(':visible')){
         if(''==$("#frmCountry").val())return alert("Country is required!"),$("#frmCountry").focus(),!1;
        }
        if($('#addOrderIds').is(':visible')){
         if('0'==$("#addOrder").val())return alert("Order is required!"),$("#addOrder").focus(),!1;
        }
    }else{
        if(""==trim($("#frmTitle").val()))return alert("Title is required!"),$("#frmTitle").focus(),!1;
        if(""==trim($("#frmAdUrl").val()))return alert("URL Link is required!"),$("#frmAdUrl").focus(),!1;
        if($('#countryIds').is(':visible')){
        if(''==$("#frmCountry").val())return alert("Country is required!"),$("#frmCountry").focus(),!1;
        }
        if(0==IsUrlLink($("#frmAdUrl").val()))return alert("Please enter the valid URL link!"),$("#frmAdUrl").select(),!1;
        if(0==t&&""==$("#frmImg").val())return alert("Image is required!"),$("#frmImg").focus(),!1;
       
        if(("Product Listing Page"==$("#frmAdsPage").val()||"Menu Category Image"==$("#frmAdsPage").val())&&null==$("#frmCategory").val())return alert("Please select category(s)!"),$("#frmCategory").focus(),!1;
        if($('#addOrderIds').is(':visible')){
         if('0'==$("#addOrder").val())return alert("Order is required!"),$("#addOrder").focus(),!1;
        }
    }    
    if(trim($('#frmAdsPrice').val())!='' && (0==AcceptDecimal($('#frmAdsPrice').val()) || parseInt($('#frmAdsPrice').val())<0))return alert("Please Enter numeric or decimal value!"),$('#frmAdsPrice').focus(),!1;
    
}

function validateBannerPageForm(t){
    var step = $('#frmHidenStep').val();
    
    if(step=='1'){
        //if(""==$("#frmCountry").val())return alert("Please select country(s)!"),$("#frmCountry").focus(),!1;        
        if(""==$("#frmFestival").val())return alert("Please select festival!"),$("#frmFestival").focus(),!1;        
        if(""==$("#frmTitle").val())return alert("Banner title is required!"),$("#frmTitle").focus(),!1;        
        if(0==t&&""==$("#frmImg").val())return alert("Banner Image is required!"),$("#frmImg").focus(),!1;
        if(""!=$("#frmBannerOrder").val() && isNaN($("#frmBannerOrder").val()))return alert("Please enter numeric value for order!"),$("#frmBannerOrder").focus(),!1;     
    // if(null==$("#frmCountry").val())return alert("Please select country(s)!"),$("#frmCountry").focus(),!1;        
    }else{
        var tbl=document.getElementById('HomeBannerTbl'),i=tbl.rows.length;
        //alert(i);return false;
        if(i>1){            
            
            var error='0',msg='',foc;
            $("#HomeBannerTbl tr").each(function(){                
                var indx = parseInt($(this).find('i').attr('r'));
                if(indx>0 && error=='0'){
                    //var o = $(this).find('td input');
                    var c = $(this).find('td .frm_url');                    
                    /*
                    if(o.val()==''){
                        error='1';
                        msg='Offer is Required!';
                        foc = o;                   
                    }else if(AcceptDecimal(o.val())==0){
                        error='1';
                        msg='Please Enter numeric or decimal value in offer!';
                        foc = o;
                    }else 
                        */
                    if(c.val()=='' || c.val()==null){
                        
                        error='1';
                        msg='Url Link is Required!';
                        foc = c;
                    }else if(IsUrlLink(c.val())==0){
                        error='1';
                        msg='Please enter valid URL link!';
                        foc = c;                        
                    } 
                }
            });
            
            if(error=='1'){
                alert(msg);  
                foc.focus();
                return false;   
            }
            
        }else{
            alert('Please select Images Mapping and click on add button!');            
            return false;
        }        
    }
}

function validateFestivalPageForm(t){
    if(""==$("#frmTitle").val())return alert("festival title is required!"),$("#frmTitle").focus(),!1;            
    if(null==$("#frmCountry").val())return alert("Please select country(s)!"),$("#frmCountry").focus(),!1;        
    if(null==$("#frmCategoryId").val())return alert("Please select category(s)!"),$("#frmCategoryId").focus(),!1;
    if(""!=$("#frmBannerOrder").val() && isNaN($("#frmBannerOrder").val()))return alert("Please enter numeric value for order!"),$("#frmBannerOrder").focus(),!1;     
}

function validateBannerSpclPageForm(t){ 
    if(""==$("#frmTitle").val())return alert("Banner title is required!"),$("#frmTitle").focus(),!1; 
    if($.trim($("#frmBannerPage").val())=='Select Page'){
        alert("Page is required!");
        $("#frmBannerPage").focus();
        return false;
    }
    if($('#eventPages').is(':visible')){
        if($.trim($("#frmBannerEvent").val())=='Select Event'){
            alert("Event is required!");
            $("#frmBannerEvent").focus();
            return false;
        }
    }
    if($('#categoryPages').is(':visible')){
        if($.trim($("#frmCategory").val())==0){
            alert("Category is required!");
            $("#frmCategory").focus();
            return false;
        }
    }
    if($('#frmLink').val()!=''){
      if(/^(http:\/\/www\.|https:\/\/www\.)[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/.test($('#frmLink').val())){
        } else {
            alert("Please enter the invalid url");
            $('#frmLink').focus();
            return false;
        }
    }
    
    if(0==t&&""==$("#frmImg").val())return alert("Banner Image is required!"),$("#frmImg").focus(),!1;     
    if(""!=$("#frmBannerOrder").val() && isNaN($("#frmBannerOrder").val()))return alert("Please enter numeric value for order!"),$("#frmBannerOrder").focus(),!1;     
}




function addRowToTable(e){
    var t,r=document.getElementById("ProductSizecount").value,a=document.getElementById(e),i=a.rows.length;
    t=i,t=parseInt(t);
    var n=a.insertRow(i),l=document.getElementById("SizeTD").innerHTML,o=document.getElementById("QtyTD").innerHTML,u=document.getElementById("SubProductConditionTD").innerHTML,s=document.getElementById("SubProductColorTD").innerHTML,m=document.getElementById("PriceTD").innerHTML,c=document.getElementById("RetailPriceTD").innerHTML,d=document.getElementById("SalePriceTD").innerHTML,d=document.getElementById("SalePriceTD").innerHTML,f=document.getElementById("WeightTD").innerHTMl,p=document.getElementById("LengthTD").innerHTMl,v=document.getElementById("WidthTD").innerHTMl,g=document.getElementById("HeightTD").innerHTMl,h=document.getElementById("StatusTD").innerHTMl,y=document.getElementById("WholesalerProductTD").innerHTMl,P=document.getElementById("WholesalerBasePriceTD").innerHTMl,C=(parseInt(r)-1,"frmfkSubProductColorId_"+r),E="frmfkSubProductConditionId_"+r,E="frmfkSubProductConditionId_"+r,R="checkCondition(this.value,"+r+")",I="productSize_"+r;
    l=l.replace("productSize_0",I);
    var w=s.replace("frmfkSubProductColorId_0",C);
    u=u.replace("frmfkSubProductConditionId_0",E),checkCondition(this.value,"0"),u=u.replace("checkCondition(this.value,'0')",R);
    l=l.replace("selected",""),w=w.replace("selected",""),w=w.replace("selected",""),w=w.replace("selected",""),w=w.replace("selected",""),w=w.replace("selected",""),u=u.replace("selected",""),w=w.replace('selected="selected"',""),w=w.replace('selected="selected"',""),w=w.replace('selected="selected"',""),w=w.replace('selected="selected"',""),w=w.replace('selected="selected"',""),o='<input type="text" name="frmQuantity[]" onkeyup="AcceptDigits(this)" style="width:80px;" value="" />',m='<input type="text" name="frmPrice[]" style="width:60px;" value="" />USD',c='<input type="text" name="frmRetailPrice[]" style="width:60px;" value="" />USD',d='<input type="text" name="frmSalePrice[]" style="width:60px;" value="" />USD',f='<input type="text" name="frmProductweight[]" style="width:40px;" value="" />(lbs)',p='<input type="text" name="frmShippingLength[]" style="width:40px;" value="" />(inch)',v='<input type="text" name="frmShippingWidth[]" style="width:40px;" value="" />(inch)',g='<input type="text" name="frmShippingHeight[]" style="width:40px;" value="" />(inch)',h="<table>",h+='<tr ><td style="border:none;"><input type="radio" name="frmProductSizeStatus_'+r+'" id="frmProductSizeStatus_'+r+'1"  value="Active">Active</td></tr>',h+='<tr ><td style="border:none;"><input type="radio" name="frmProductSizeStatus_'+r+'" id="frmProductSizeStatus_'+r+'2" value="Inactive">Inactive</td></tr>',h+='<tr ><td style="border:none;"><input type="radio" name="frmProductSizeStatus_'+r+'" id="frmProductSizeStatus_'+r+'3" value="Offline">Offline</td></tr></table>',y="<table>",y+='<tr ><td style="border:none;"><input type="radio" name="frmProductSizeForWholesaler_'+r+'"  value="Yes">Yes</td></tr>',y+='<tr ><td style="border:none;"><input type="radio" name="frmProductSizeForWholesaler_'+r+'"  value="No">No</td></tr></table>',P='<input type="text" name="frmproduct_wholesale_price[]" style="width:50px;" value=""/>USD',fc16='<input type="text" name="frmSubproductskuId[]"  id="frmSubproductskuId_'+r+'" style="width:70px;" value="" onblur="checkExistSubSkuID('+r+",this.value,'checkSkuIDexistence_');\"/>",fc16+='<div id="checkSkuIDexistence_'+r+'" style="color:red;"></div>',fc17='<input type="checkbox" name="frmDefaultSubproduct_'+r+'" id="frmDefaultSubproduct_'+r+'" onclick="disableCheckBoxes('+r+')"  style="width:50px;" value=""/>',fc18='<input type="text" name="frmDefaultourPrice[]" style="width:40px;" value=""/>';
    var S=n.insertCell(0);
    S.innerHTML=l;
    var b=n.insertCell(1);
    b.innerHTML=o;
    var A=n.insertCell(2);
    A.innerHTML=m;
    var T=n.insertCell(3);
    T.innerHTML=c;
    var $=n.insertCell(4);
    $.innerHTML=d;
    var D=n.insertCell(5);
    D.innerHTML=f;
    var M=n.insertCell(6);
    D.innerHTML=f;
    var M=n.insertCell(6);
    M.innerHTML=p;
    var N=n.insertCell(7);
    N.innerHTML=v;
    var N=n.insertCell(8);
    N.innerHTML=g;
    var x=n.insertCell(9);
    x.innerHTML=h;
    var k=n.insertCell(10);
    k.innerHTML=y;
    var B=n.insertCell(11);
    B.innerHTML=P;
    var F=n.insertCell(12);
    F.innerHTML=u;
    var _=n.insertCell(13);
    _.innerHTML=w;
    var q=n.insertCell(14);
    q.innerHTML=fc16;
    var H=n.insertCell(15);
    H.innerHTML=fc18;
    var L=n.insertCell(16);
    L.innerHTML=fc17;
    var L=n.insertCell(17);
    L.innerHTML="<a href=\"#\" onclick=\"removeRowFromTable('ProductVariationsTable','"+t+'\',this);return false;"><img src="images/bullet_toggle_minus.png" /></a>',r++,document.getElementById("ProductSizecount").value=r
}
function addDynamicRowToTableForShippingGateways(e){
    var t=document.getElementById(e),r=t.rows.length;
    r-=0;
    var a;
    a=r,a=parseInt(a),$("#"+e+":last i").html("");
    var i=t.insertRow(r);
    i.insertCell(0).innerHTML='<input type="text" name="frmWeight[]" class="input0" style="width:51px" />',i.insertCell(1).innerHTML='<input type="text" name="frmA[]" class="input0" style="width:51px"/>',i.insertCell(2).innerHTML='<input type="text" name="frmB[]" class="input0" style="width:51px"/>',i.insertCell(3).innerHTML='<input type="text" name="frmC[]" class="input0" style="width:51px" />',i.insertCell(4).innerHTML='<input type="text" name="frmD[]" class="input0" style="width:51px"/>',i.insertCell(5).innerHTML='<input type="text" name="frmE[]" class="input0" style="width:51px"/>',i.insertCell(6).innerHTML='<input type="text" name="frmF[]" class="input0" style="width:51px"/>',i.insertCell(7).innerHTML='<input type="text" name="frmG[]" class="input0" style="width:51px"/>',i.insertCell(8).innerHTML='<input type="text" name="frmH[]" class="input0" style="width:51px"/>',i.insertCell(9).innerHTML='<input type="text" name="frmI[]" class="input0" style="width:51px"/>',i.insertCell(10).innerHTML='<input type="text" name="frmJ[]" class="input0" style="width:51px"/>',i.insertCell(11).innerHTML='<input type="text" name="frmK[]" class="input0" style="width:51px"/>',i.insertCell(12).innerHTML='<i><span style="cursor: pointer;" onclick="addDynamicRowToTableForShippingGateways(\'productRow\');"><img src="images/plus.png" /></span></i><a href="#" onclick="removeDynamicRowToTableForShippingGateways(\''+e+"','"+a+'\',this);return false;"><img src="images/minus.png" /></a>'
}
function removeDynamicRowToTableForShippingGateways(e,t,r){
    var a=document.getElementById(e).value,i=document.getElementById(e),n=r.parentNode.parentNode.rowIndex;   
    n>0&&i.deleteRow(n),a--,$("#"+e+" tr:nth-last-child(1) i").html('<span style="cursor: pointer;" onclick="addDynamicRowToTableForShippingGateways(\'productRow\');"><img src="images/plus.png" /></span>'),document.getElementById(e).value=a;
    
}
function addDynamicRowToTableForPackage(e){
    var t,r=document.getElementById(e),a=r.rows.length;
    t=a,t=parseInt(t),$("#"+e+" tr:last i").html("");
    var i=r.insertRow(a);
    i.insertCell(0).innerHTML="Product&nbsp;"+t+":";
    var n=i.insertCell(1);
    $.post("ajax.php",{
        action:"ShowCategoryForPackage",
        row:t
    },function(e){
        var t=e;
        n.innerHTML=t;
        $(".select2-me").select2();
    }),i.insertCell(2).innerHTML='<span id="product'+t+'"><select name="frmProductId[]" class="packageProduct select2-me input-large" onchange="ShowProductPriceForPackage(this.value,'+t+')"><option value="0">Product</option></select></span>',i.insertCell(3).innerHTML='<span id="price'+t+'"><input type="hidden" name="frmPrice[]" class="input-large" value="0.00" /><b>0.00</b></span>',i.insertCell(4).innerHTML='<i style="cursor: pointer;" onclick="addDynamicRowToTableForPackage(\'productRow\');"><img src="images/plus.png" /></i><a href="#" onclick="removeRowFromTableForPackage(\''+e+"','"+t+'\',this);return false;"><img src="images/minus.png" /></a>'
 
}
function removeRowFromTableForPackage(e,t,r){
    var a=document.getElementById(e).value,i=document.getElementById(e),n=r.parentNode.parentNode.rowIndex;
    n>0&&i.deleteRow(n),a--,$("#"+e+" tr:last i").html('<i style="cursor: pointer;" onclick="addDynamicRowToTableForPackage(\'productRow\');"><img src="images/plus.png" /></i>'),document.getElementById(e).value=a;
    var l,o,u=document.getElementsByName("frmPrice[]"),s=0;
    for(l=0;l<u.length;l++)o=parseFloat(u[l].value),s+=o;
    s=s.toFixed(2),$("#asc").html(s),$("#frmTotalPrice").val(s)
}
function addDynamicRowToTableForMultipleProduct(e){
    var t,r=document.getElementById(e),a=r.rows.length;
    t=a,t=parseInt(t),$("tr").addClass("content"),$("#"+e+" tr:last i").html("");
    var i=r.insertRow(a);
    i.insertCell(0).innerHTML='<input name="frmProductName[]" type="text" value="" placeholder="Product Name" class="input-medium" /><br /><br /><input name="frmProductRefNo[]" type="text" value="" placeholder="Product Ref No." class="input-medium" autocomplete="off" onkeyup="checkProductRefNoForMultiple(this.value,'+t+');" onmousemove="checkProductRefNoForMultiple(this.value,'+t+');" onchange="checkProductRefNoForMultiple(this.value,'+t+');" /><br/><span id="refmsg'+t+'" class="req"><input type="hidden" name="frmIsRefNo[]" value="0" /></span>',
    i.insertCell(1).innerHTML='<input name="frmWholesalePrice[]" id="frmWholesalePrice'+t+'" type="text" value="" placeholder="Wholesale Price" autocomplete="off" class="input-medium" onkeyup="showFinalPriceForMultipleProduct('+t+');" onchange="showFinalPriceForMultipleProduct('+t+');" /><br/><span id="FinalPrice'+t+'"></span><input name="frmProductPrice[]" id="frmProductPrice'+t+'" type="hidden" value="" class="input0" /><br/><br/><input name="frmDiscountPrice[]" id="frmDiscountPrice'+t+'" type="text" value="" placeholder="Discount Price" autocomplete="off" class="input-medium" onkeyup="showFinalDiscountPriceForMultipleProduct('+t+');" onchange="showFinalDiscountPriceForMultipleProduct('+t+');" /><br/><span id="DiscountFinalPrice'+t+'"></span><input name="frmDiscountFinalPrice[]" id="frmDiscountFinalPrice'+t+'" type="hidden" value=""/>',
    i.insertCell(2).innerHTML='<div id="addinput_'+t+'"><div class="imgimg" id="'+t+'1"><div class="responce"></div><input type="file" name="file_upload[]" class="file_upload_multi" size="1" style="width:120px" /><span><a href="javascript:void(0);" onclick="addImage('+t+')" id="addNew"><img src="images/plus.png" alt="Add more" title="Add more" /></a></span><a id="remNew" onclick="hideImg('+t+','+t+'1)" href="javascript:void(0)" style="display: none"><img title="Remove" alt="Remove" src="images/minus.png"></a></div>';
    //i.insertCell(2).innerHTML='<div id="addinput'+t+'"><p><input type="hidden" name="image_error" value="0" class="image_error"><input type="file" size="1" style="width:122px;" name="frmProductImg['+t+'][1]" id="frmProductImg1" value="" class="prod_img small"/>&nbsp;&nbsp;&nbsp;<span><a href="javascript:void(0)" onclick="addImage('+t+')"  id="addNew"><img src="images/plus.png" alt="Add more" title="Add more" /></a></span></p></div>',
    i.insertCell(3).innerHTML='<input name="frmQuantity[]" type="text" value="" class="input-small" /><br><span class="req">Quantity alert:</span><br><input type="text" name="frmQuantityAlert[]" class="input-small" value="" />';
    var n=i.insertCell(4);
    $.post("ajax.php",{
        action:"ShowCategoryForMultipleProduct",
        row:t
    },function(e){
        var t=e;
        n.innerHTML=t
    });
    var l=i.insertCell(5);
    $.post("ajax.php",{
        action:"ShowPackageForMultipleProduct",
        row:t,
        wid:$('#frmfkWholesalerID option:selected').val()
    },
    function(e){
        var r=e;
        l.innerHTML=r;
    //+'<br /><input type="checkbox" name="frmIsFeatured['+--t+']" value="1" />&nbsp;Featured'
    }),
    // i.insertCell(6).innerHTML='Date Start<br/><input type="text" name="frmDateStart[]" class="inputDate input-small" value="00-00-0000" readonly="true" /><br/><br/>Date End<br/><input type="text" name="frmDateEnd[]" class="inputDate input-small" value="00-00-0000" readonly="true" />',
    i.insertCell(6).innerHTML='<select name="frmWeightUnit[]" class="select2-me input-small"><option selected="selected" value="kg">Kilogram</option><option value="g">Gram</option><option value="lb">Pound </option><option value="oz">Ounce</option></select><br /><br /><input type="text" name="frmWeight[]" value="" placeholder="Weight" class="input-small" />',
    i.insertCell(7).innerHTML='<select name="frmDimensionUnit[]" class="select2-me input-medium"><option selected="selected" value="cm">Centimeter</option><option value="mm">Millimeter</option><option value="in">Inch</option></select><br /><br /><input type="text" name="frmLength[]" value="" placeholder="Length" class="input-small" /><br/><input type="text" name="frmWidth[]" value="" placeholder="Width" class="input-small" /><br/><input type="text" name="frmHeight[]" value="" placeholder="Height" class="input-small" />',
    i.insertCell(8).innerHTML='<textarea name="frmProductDescription[]" rows="1" class="input-block-level textarea-small" placeholder="Description" maxlength="250" ></textarea><br/><textarea name="frmProductTerms[]" rows="1" placeholder="Terms & Condition" class="input-block-level textarea-small" ></textarea><br/><span class="text-danger">https://www.youtube.com/embed/ </span><br/><input type="text" name="frmYoutubeCode[]" placeholder="Youtube Code" class="input-medium"/>',
    i.insertCell(9).innerHTML='<textarea name="frmMetaTitle[]" rows="1" class="input-block-level textarea-small" placeholder="Meta Title"></textarea><br/><textarea name="frmMetaKeywords[]" rows="1" class="input-block-level textarea-small" placeholder="Meta Keywords"></textarea><br/><textarea name="frmMetaDescription[]" rows="1" class="input-block-level textarea-small" placeholder="Meta Description" ></textarea>',
    i.insertCell(10).innerHTML='<span id="shwhde'+t+'"><input onclick="createEditor('+t+');" type="button" class="btn" value="Show Editor" /></span><div id="editorcontents'+t+'" style="display: none"></div><div style="display: none"><textarea name="frmHtmlEditor[]" id="frmHtmlEditor'+t+'"></textarea></div><div id="editor'+t+'" style="z-index: 999; position: absolute; width:420px; margin-left: -220px"></div>',
    i.insertCell(11).innerHTML='<i><span style="cursor: pointer;" onclick="addDynamicRowToTableForMultipleProduct(\''+e+'\');"><img src="images/plus.png" /><span></i>&nbsp;<a href="#" onclick="removeRowFromTableForMultipleProduct(\''+e+"','"+t+'\',this);return false;"><img src="images/minus.png" /></a>'
//    Cal(".inputDate").datepick({
//        dateFormat:"dd-mm-yyyy"
//    })
}
function removeRowFromTableForMultipleProduct(e,t,r){
    var a=document.getElementById(e).value,i=document.getElementById(e),n=r.parentNode.parentNode.rowIndex;
    n>0&&i.deleteRow(n),a--,$("#"+e+" tr:last i").html('<span style="cursor: pointer;" onclick="addDynamicRowToTableForMultipleProduct(\''+e+'\');"><img src="images/plus.png" /></span>'),document.getElementById(e).value=a
}


function addDynamicRowToTableForHomeBanner(){
    
    var t,e='HomeBannerTbl',r=document.getElementById(e),a=r.rows.length;
    t=a,t=parseInt(t),$("#"+e+" tr:last i").html("");     
    //if(a>0)$('#'+e).css('display','block');
    
    var ctr = parseInt($("#"+e+" tr:last i").attr('r'))+1;
    // alert(ctr);return false;
    $('#col1 textarea').html($('.canvas-area').val());
     
    var col1 =$('#col1').html().replace("frmCoOrdinates[]",'frmCoOrdinates['+ctr+']');
    // var col3 =$('#col3').html().replace("frmOffer[]",'frmOffer['+ctr+']');
    var col4 =$('#col4').html().replace("frmUrl[]",'frmUrl['+ctr+']');
       
    
    var i=r.insertRow(a);
           
    i.insertCell(0).innerHTML=col1,
    //i.insertCell(1).innerHTML=$('#col2').html(),
    // i.insertCell(1).innerHTML=col3,
    i.insertCell(1).innerHTML=col4,
    i.insertCell(2).innerHTML='<a href="#" onclick="removeRowFromTableForHomeBanner(\''+e+"','"+t+'\',this);return false;"><img src="images/minus.png" title="Remove link" /></a><i r="'+ctr+'"></i>';
    ctr++;
   
}
function removeRowFromTableForHomeBanner(e,t,r){
    var a=document.getElementById(e).value,i=document.getElementById(e),n=r.parentNode.parentNode.rowIndex;
    n>0&&i.deleteRow(n),a--,
    document.getElementById(e).value=a;
// if(i.rows.length==1)$('#'+e).css('display','none');
}


function addDynamicRowToTable(e){
    var t,r=document.getElementById(e),a=r.rows.length;
    t=a,t=parseInt(t);
    var i=r.insertRow(a),n="hi",l=i.insertCell(0);
    l.innerHTML=n;
    var o=i.insertCell(1);
    o.innerHTML="<a href=\"#\" onclick=\"removeRowFromTable('asc','"+t+'\',this);return false;"><img src="images/bullet_toggle_minus.png" />hi</a>'
}
function removeRowFromTable(e,t,r){
    var a=document.getElementById(e).value,i=document.getElementById(e),n=r.parentNode.parentNode.rowIndex;
    n>0&&i.deleteRow(n),a--,document.getElementById(e).value=a
}
function AcceptDigits(e){
    var t=/[^\d]/g;
    e.value=e.value.replace(t,"")
}
function IsDigits(e){
    e=trim(e);
    var t=/[^\d]/g;
    return t.test(e)
}
function IsLessThan(e,t){
    return e=parseFloat(e),t=parseFloat(t),t>e?!1:!0
}
function IsPhone(e){
    //alert("sg");
    e=trim(e);
    var t=/^[0-9()+ -]*$/;
    return t.test(e)
}
function IsUrlLink(e){
    e=trim(e);
    var t=/(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
    return t.test(e)
}
function AcceptEmail(e){
    e=trim(e);
    var t=/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    return t.test(e)
}
function AcceptDecimal(e){
    e=trim(e);
    var t=/^[-+]?[0-9]+(\.[0-9]+)?$/;
    return t.test(e)
}
function openProductImagewindow(e){
    window.open(e,"ProductImage","menubar=1,resizable=1,width=350,height=250")
}
function openCouponImagewindow(e){
    window.open(e,"couponImage","menubar=1,resizable=1,width=350,height=250")
}
function validateAttributeAddPageForm(frm,addit){
    
    var e=document.getElementsByName("frmCategoryId[]");
    if(""==$("#frmAttributeCode").val())return alert("Attribute Code is required!"),$("#frmAttributeCode").focus(),!1;
    if("0"==$("#isUniqueCode").val())return alert("Attribute Code already Exist. Please change!"),$("#frmAttributeCode").select(),!1;
    if(""==$("#frmAttributeTitle").val())return alert("Attribute Label is required!"),$("#frmAttributeTitle").focus(),!1;
    if($("#frmInputType").val()=='image' && addit==0){      
        var f=document.getElementsByName("attr_img[]");
        for(var t=0;t<f.length;t++)if(0==f[t].value)return alert("Please select image!"),f[t].focus(),!1;
    }
    for(var t=0;t<e.length;t++)if(0==e[t].value)return alert("Please select Category!"),e[t].focus(),!1;
    
    
}
function checkAttributeCode(e,t){
    ""==e?($("#isUniqueCode").val("1"),$("#UniqueCodeMsg").html("")):$.post("ajax.php",{
        action:"checkAttributeCode",
        code:e,
        id:t
    },function(e){
        "0"==e?($("#UniqueCodeMsg").html("Attribute Code already Exist. Please change."),$("#isUniqueCode").val("0")):($("#UniqueCodeMsg").html(""),$("#isUniqueCode").val("1"))
    })
}
function inArray(e,t){
    for(var r=t.length,a=0;r>a;a++)if(t[a]==e)return!0;return!1
}
function validateCMSAddPageForm(){
    return""==$.trim($("#frmDisplayPageTitle").val())?(alert("Page Display Title is required!"),$("#frmDisplayPageTitle").focus(),!1):""==$.trim($("#frmPageTitle").val())?(alert("Page Title is required!"),$("#frmPageTitle").focus(),!1):""==$.trim($("#frmPagePrifix").val())?(alert("Prifix is required!"),$("#frmPagePrifix").focus(),!1):""==$.trim($("#frmPageDisplayOrder").val())?(alert("Page display order is required!"),$("#frmPageDisplayOrder").focus(),!1):isNaN($("#frmPageDisplayOrder").val())?(alert("Please enter numeric value for order!"),$("#frmPageDisplayOrder").focus(),!1):void 0
}
function validateCategoryAddEditForm(t){
    return""==$("#frmName").val()?(alert("Category Name is required!"),$("#frmName").focus(),!1):""!=$("#frmCategoryOrdering").val()&&isNaN($("#frmCategoryOrdering").val())?(alert("Please enter numeric value for order!"),$("#frmCategoryOrdering").focus(),!1):(0==t&&""==$("#frmCategoryImage").val()&&2!=$("#findCategoryLavel").val())? (alert("Category Image is required!"),$("#frmCategoryImage").focus(),!1):void 0
}
function order_validation(e,t){ alert(e+'...'+t);
    return isNaN(e)?(alert("Please enter numeric value for order!"),$("#"+t).val("0"),$("#"+t).focus(),!1):void 0
}
function validateOfficeAddressEditForm(){
    var e=!0,t=new Array("jpg","jpeg","gif","png");
    return""==$("#frmAddressTitle").val()?(alert("Office Location is required!"),$("#frmAddressTitle").focus(),!1):""==$("#frmAddressImage").val()||validateFileExtension($("#frmAddressImage").val(),t,"#frmAddressImage","Accepted Image formats are:",e)?void 0:!1
}
function validateFileExtensionNew(e,t,r,a){
    $(r);
    for(i=0;i<t.length;i++)allowedEx=t[i].toUpperCase(),a=a+allowedEx+",";
    if(a=a.substring(0,a.length-1),e=jQuery.trim(e),""!=e){
        var n=e.split(".").pop().toLowerCase();
        return-1==jQuery.inArray(n,t)?1:0
    }
}
function validateFileExtension(e,t,r,a){
    var n=$(r);
    for(i=0;i<t.length;i++)allowedEx=t[i].toUpperCase(),a=a+allowedEx+",";
    if(a=a.substring(0,a.length-1),e=jQuery.trim(e),""!=e){
        var l=e.split(".").pop().toLowerCase();
        return-1==jQuery.inArray(l,t)?(alert(a),n.focus(),!1):!0
    }
}
function validateEnquiryEmailsForm(){
    var e=/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    if(""==document.frmAddEditEmail.frmEnquiryEmail.value)return alert("Please enter email address!"),document.frmAddEditEmail.frmEnquiryEmail.focus(),!1;
    if(""!=document.frmAddEditEmail.frmEnquiryEmail.value)for(var t=document.frmAddEditEmail.frmEnquiryEmail.value.split(","),r=0;r<t.length;r++)if(!e.test(t[r]))return alert(t[r]+" Email arddress seems wrong!"),document.frmAddEditEmail.frmEnquiryEmail.focus(),!1
}
function getRBtnName(e){
    for(var t=document.getElementsByName(e),r=-1,a="",i=0;i<t.length;i++)1==t[i].checked&&(a=t[i].value,r=i);
    return r
}
function validateUser(e){
    return validateForm(e,"frmTitle","User Title","R","frmFirstName","User Name","R","frmUserEmail","Email Address ","RisEmail","frmPassword","Password","R","frmPassword","Password ","isMin","frmConfirmPassword","Confirm Password ","RisEqualfrmPassword: Password ","frmAdminRoll","Role","R","frmCommission","Commission","R","frmSalesTarget","Sales Target","R","frmSalesTargetStartDate","Sales Target Date","R")?!0:!1
}
function validateMessage(e){
    return validateForm(e,"frmSendToIds","Select Users","R","frmMessageType","Message Type","R","frmMessageSubject","message Subject","R")?!0:!1
}
function validateBillingAddress(e){
    return validateForm(e,"frmAddressLine1","Address","R","frmCountry","Country","R","frmState","State","R","frmCity","City","R","frmZipCode","Zip Code","R")?!0:!1
}
function validateNewsLetterForm(e){
    return validateForm(e,"frmNewsLetterName","Newsletter Name","R")?!0:!1
}
function validateNewsLetterMailForm(e){
    return validateForm(e,"frmNewsLetterName","Title","R","frmSubscriberList","Subscriber","R")?!0:!1
}
function enableList(e){
    document.getElementById("frmSubscriberList[]").disabled="Subscriber(s)"==e?!1:!0
}
function disableList(e){
    document.getElementById("frmSubscriberList[]").disabled="AllSubscribers"==e?!0:!1
}
function showMemberOtherDetails(e){
    "WholeSaler"==e?document.getElementById("wholeSalerRow_1").style.display="none":"Member"==e&&(document.getElementById("wholeSalerRow_1").style.display="")
}
function showState(e,t){
    var r={
        "function":"getCountryStates"
    };
    
    r.countryID=e,r.selected=t,$.post(SITE_ROOT_URL+"common/ajax/ajax.php",r,function(e){
        if(e){
            if($("#frmShippingCostState").is(":visible"))return $("#frmShippingCostState").html(e).show(),!0;
            if($("#frmState").is(":visible"))return $("#frmState").html(e).show(),!0
        }
    })
}
function validateShippingCostForm(e){
    return validateForm(e,"frmCountry","Country Name","R","frmShippingCostState","State Name","R","frmShippingCost","Shipping Cost","R")?"Percentage"==$("#frmShippingCostType").val()&&$("#frmShippingCost").val()>100?(alert("Shipping Cost Percentage should not be greater than 100."),$("#frmShippingCost").focus(),!1):!0:!1
}
function validateDefaultShippingCostForm(e){
    return validateForm(e,"frmShippingCost","Shipping Cost","R")?!0:!1
}
function deSelectMasterCheckbox(e){
    document.getElementById(e).checked=!1
}
function AllowNumeric(e){
    return isIE=document.all?1:0,keyEntry=isIE?event.keyCode:e.which,keyEntry>="48"&&"57">=keyEntry||"8"==keyEntry||"0"==keyEntry||"9"==keyEntry||"	"==keyEntry||"\r"==keyEntry||"127"==keyEntry||"13"==keyEntry||"11"==keyEntry||"9"==keyEntry||"46"==keyEntry?!0:!1
}
function AllowAlphabetOnly(e){
    return isIE=document.all?1:0,keyEntry=isIE?event.keyCode:e.which,keyEntry>="65"&&"90">=keyEntry||keyEntry>="97"&&"122">=keyEntry||"127"==keyEntry||"8"==keyEntry?!0:!1
}
function changeAdminOrderStatus(e,t){
    var r=confirm("Are you sure, you want to change the order status ?");
    return r?(document.getElementById("frmOrderID").value=t,document.getElementById("frmOrderStatus").value=e,document.forms.frmOrderStatus.submit(),void 0):!1
}
function checkCondition(e,t){
    for(var r=document.getElementById("ProductSizecount").value,a=0;r>a;a++)if(a!=t){
        var i=document.getElementById("productSize_"+a).value,n=document.getElementById("frmfkSubProductConditionId_"+a).value,l=document.getElementById("productSize_"+t).value,o=document.getElementById("frmfkSubProductConditionId_"+t).value;
        i==l&&n==o&&(alert("This condition is already selected "),$("#frmfkSubProductConditionId_"+t).prop("selectedIndex",0))
    }
}
function deleteRecord(e,t,r,a){
    confirm("Are you sure you want to delete this record?")&&($("#"+r).val(e),$("#frmProcess").val(a),$("#"+t).submit())
}
function deleteEnquiries(e,t,r,a){
    confirm("Are you sure you want to delete this Enquiries?")&&($("#frmEnquirieID").val(e),$("#frmProcess").val(a),$("#"+t).submit())
}
function deleteMessage(e,t,r,a){
    confirm("Are you sure you want to delete this Message?")&&($("#frmMessageID").val(e),$("#frmProcess").val(a),$("#"+t).submit())
}
function validateNewsletterAddForm(){    
    if(""==$.trim($("#frmTitle").val()))return alert("Title is required!"),$("#frmTitle").focus(),!1;    
    
    if(("<br>"==$.trim($('#cke_frmHtmlEditor iframe').contents().find('.cke_editable').html()) || "<p><br></p>"==$.trim($('#cke_frmHtmlEditor iframe').contents().find('.cke_editable').html()) || "<p><br><br></p>"==$.trim($('#cke_frmHtmlEditor iframe').contents().find('.cke_editable').html())) && $('#template').val()=='')return alert("Content is required!"),$("#frmHtmlEditor").focus(),!1;
    
    var e=document.getElementsByName("template");
    if(e.length>0)for(var t=0;t<e.length;t++){
        var r=e[t].value;
        if(""!=r){
            var a=r.substring(r.lastIndexOf(".")+1),i=a.toLowerCase();
            if("jpg"!=i&&"jpeg"!=i&&"gif"!=i&&"png"!=i)return alert("Accepted Image formats are: jpg, jpeg, gif, png"),e[t].focus(),!1
        }
    }
    if(""==$.trim($("#frmDeliveryDate").val()))return alert("Schedule Delivery Time is required!"),$("#frmDeliveryDate").focus(),!1;
    if("00"==$.trim($("#frmHH").val()))return alert("HH is required!"),$("#frmHH").focus(),!1;
    if("00"==$.trim($("#frmMM").val()))return alert("MM is required!"),$("#frmMM").focus(),!1;
    var n=0;
    if($(".recipient").each(function(){
        $(this).is(":checked")&&n++
    }),0==n)return alert("Please checked checkbox!"),!1;
    var l=0;
    return $(".recipietId").each(function(){
        $(this).is(":checked")&&l++
    }),0==l?(alert("Please checked atleast one checkbox!"),!1):void 0;
    
    
    
    
    

}
function approveStatus(e,t,r){
    $.post("ajax.php",{
        action:"wholesalerStatusApprove",
        id:e,
        status:t,
        emailid:r
    },function(){
        window.location="wholesaler_application_manage_uil.php"
    })
}

function approveStatusLogistic(e,t,r){
    $.post("ajax.php",{
        action:"logisticStatusApprove",
        id:e,
        status:t,
        emailid:r
    },function(){
        window.location="logistic_application_manage_uil.php"
    })
}
function validateCustomerCompose(){
    return ""==$("#autoFilledCustomer").val()?(alert("Customer Email is required!"),$("#autoFilledCustomer").focus(),!1):0==AcceptEmail	($("#autoFilledCustomer").val())?(alert("Please enter valid customer email!"),$("#autoFilledCustomer").focus(),!1):"0"==$("#frmSupportType").val()?(alert("Type is required!"),$("#frmSupportType").focus(),!1):""==$("#frmSubject").val().trim()?(alert("Subject is required!"),$("#frmSubject").focus(),!1):""==$("#frmMessage").val().trim()?(alert("Message is required!"),$("#frmMessage").focus(),!1):void 0
}
function validateWholesalerCompose(){
    return""==$("#frmWholesaler").val()?(alert("Plesae Select is Wholesaler!"),$("#frmWholesaler").focus(),!1):""==$("#frmSubject").val()?(alert("Subject is required!"),$("#frmSubject").focus(),!1):""==$("#frmMessage").val()?(alert("Message is required!"),$("#frmMessage").focus(),!1):void 0
}
function validatePaypalEmail(){
    var e=$("#frmEmail").val();
    if(""==$("#frmEmail").val())return alert("Email Id is required!"),!1;
    var t=/^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return t.test(e)?!0:(alert("Please enter valid email Id"),!1)
}
function checkExists(e,id,pid,lave){
    $.post("ajax.php",{
        action:"checkExistsCategory",
        catName:e,
        cid:id,
        pid:pid,
        lave:lave
    },function(d){
        if(d==1){
            alert('This category name already exist');
            $('#frmName').val('');
            $('#frmName').focus();
            return false;
        }
    //$("#attribute").html(d)
    });
}
function checkEditExists(e,id,pid,lave){
    $.post("ajax.php",{
        action:"checkEditExistsCategory",
        catName:e,
        cid:id,
        pid:pid,
        lave:lave
    },function(d){
        if(d==1){
            alert('This category name already exist');
            $('#frmName').val('');
            $('#frmName').focus();
            return false;
        }
    //$("#attribute").html(d)
    });
}       
function checkCmsExists1(e,id,checktitle){
    $.post("ajax.php",{
        action:"checkCmsExists",
        checkExist:e,
        title:checktitle
    },function(d){
        if(d==1){
            alert(checktitle+' already exist');
            $('#'+id).val('');
            $('#'+id).focus();
            return false;
        }
    //$("#attribute").html(d)
    });
} 
function checkCmsExists2(e,id,checktitle){
    $.post("ajax.php",{
        action:"checkCmsExists",
        checkExist:e,
        title:checktitle
    },function(d){
        if(d==1){
            alert(checktitle+' already exist');
            $('#'+id).val('');
            $('#'+id).focus();
            return false;
        }
    //$("#attribute").html(d)
    });
} 
function checkCmsExists3(e,id,checktitle){
    $.post("ajax.php",{
        action:"checkCmsExists",
        checkExist:e,
        title:checktitle
    },function(d){
        if(d==1){
            alert(checktitle+' already exist');
            $('#'+id).val('');
            $('#'+id).focus();
            return false;
        }
    //$("#attribute").html(d)
    });
} 
        
function shAttr(i,id,pid,ids){
    if($('#'+ids).is(':checked')==true){
        $('.blank_Attribute_td_'+i).append('<div id="attrDetailsId_'+ids+'" class="attrDetailsId"></div>');
        $.post("ajax.php",{
            action:"attributeDetails",
            atId:id,
            pid:pid,
            inc:i
        },function(d){
            $('#attrDetailsId_'+ids).html(d);
        });
    }else{
        $('#attrDetailsId_'+ids).remove();
    }
}
var addHidValues=1;
function getPric(ids,inc,p){
    if(addHidValues==1){
        $('#'+ids).after('<input type="hidden" value="" id="hiddenids"/>');
        $('#hiddenids').after('<input type="hidden" value="" id="hiddenPrices"/>');
        addHidValues+=1;
        $('#hiddenids').val(ids);
        $('#hiddenPrices').val(p);
    }
    var hiddenids=$('#hiddenids').val();
		 
		 
    var pr=$('#price'+inc).find('b').html();
		 
    var nP=parseFloat(pr)+parseFloat(p);
    nP=nP.toFixed(2);
    $('#price'+inc).find('b').html(nP);
    var r,a,n=0;
    for(r=1;r<=inc;r++){
        a=parseFloat($('#price'+r).find('b').html());
        n+=a;
    }
    n=n.toFixed(2);
    $("#asc").html(n);
    $("#frmTotalPrice").val(n);
}

function validateLogisticAddForm(e){
    //var t=document.getElementsByName("frmShippingGateway[]");
    return""==e.frmCompanyName.value?(alert("Company Name is Required!"),e.frmCompanyName.focus(),!1):""==e.frmAboutCompany.value?(alert("About Company is Required!"),e.frmAboutCompany.focus(),!1):e.frmAboutCompany.value.length<200?(alert("Minimum 200 words required About Company"),e.frmAboutCompany.focus(),!1):""==e.frmCompanyAddress1.value?(alert("Address1 is Required!"),e.frmCompanyAddress1.focus(),!1):""==e.frmCompanyCity.value?(alert("City is Required!"),e.frmCompanyCity.focus(),!1):"0"==e.frmCompanyCountry.value?(alert("Please Select Country!"),e.frmCompanyCountry.focus(),!1):""==e.frmCompanyPostalCode.value?(alert("PostalCode is Required!"),e.frmCompanyPostalCode.focus(),!1):1==IsDigits(e.frmCompanyPostalCode.value)?(alert("Please enter valid PostalCode!"),e.frmCompanyPostalCode.focus(),!1):""==e.frmCompanyEmail.value?(alert("Company Email is Required!"),e.frmCompanyEmail.focus(),!1):0==AcceptEmail(e.frmCompanyEmail.value)?(alert("Please enter valid Company Email!"),e.frmCompanyEmail.focus(),!1):"1"==e.frmCEmail.value?(alert("Email Already in use. Please enter different email!"),e.frmCompanyEmail.focus(),!1):""==e.frmPassword.value?(alert("Password is Required!"),e.frmPassword.focus(),!1):6>$.trim(e.frmPassword.value.length)?(alert("Password should be atleast 6 character long!"),e.frmPassword.focus(),!1):""==e.frmConfirmPassword.value?(alert("Confirm Password is Required!"),e.frmConfirmPassword.focus(),!1):e.frmPassword.value!=e.frmConfirmPassword.value?(alert("Confirm Password must be same!"),e.frmConfirmPassword.focus(),!1):""==e.frmPaypalEmail.value?(alert("Paypal Email is Required!"),e.frmPaypalEmail.focus(),!1):0==AcceptEmail(e.frmPaypalEmail.value)?(alert("Please enter valid Paypals Email!"),e.frmPaypalEmail.focus(),!1):""==e.frmCompanyPhone.value?(alert("Company Phone is Required!"),e.frmCompanyPhone.focus(),!1):0==IsPhone(e.frmCompanyPhone.value)?(alert("Please enter Valid Phone Number!"),e.frmCompanyPhone.focus(),!1):""==e.frmContactPersonName.value?(alert("Contact Person Name is Required!"),e.frmContactPersonName.focus(),!1):""==e.frmContactPersonPosition.value?(alert("Contact Person Position is Required!"),e.frmContactPersonPosition.focus(),!1):""==e.frmContactPersonPhone.value?(alert("Contact Person Phone/Mobile is Required!"),e.frmContactPersonPhone.focus(),!1):0==IsPhone(e.frmContactPersonPhone.value)?(alert("Please enter valid phone number !"),e.frmContactPersonPhone.focus(),!1):""==e.frmContactPersonEmail.value?(alert("Contact Person Email is Required!"),e.frmContactPersonEmail.focus(),!1):0==AcceptEmail(e.frmContactPersonEmail.value)?(alert("Please enter valid Contact Person Email!"),e.frmContactPersonEmail.focus(),!1):""==e.frmContactPersonAddress.value?(alert("Contact Person Address is Required!"),e.frmContactPersonAddress.focus(),!1):""==e.frmOwnerName.value?(alert("Director/Owner Name is Required!"),e.frmOwnerName.focus(),!1):""==e.frmOwnerPhone.value?(alert("Director/Owner Phone is Required!"),e.frmOwnerPhone.focus(),!1):0==IsPhone(e.frmOwnerPhone.value)?(alert("Please enter valid phone number!"),e.frmOwnerPhone.focus(),!1):""==e.frmOwnerEmail.value?(alert("Director/Owner Email is Required!"),e.frmOwnerEmail.focus(),!1):0==AcceptEmail(e.frmOwnerEmail.value)?(alert("Please enter valid Director/Owner Email!"),e.frmOwnerEmail.focus(),!1):""==e.frmOwnerAddress.value?(alert("Director/Owner Address is Required!"),e.frmOwnerAddress.focus(),!1):""==e.frmRef1Name.value?(alert("Reference1 Name is Required!"),e.frmRef1Name.focus(),!1):""==e.frmRef1Phone.value?(alert("Reference1 Phone/mobile is Required!"),e.frmRef1Phone.focus(),!1):0==IsPhone(e.frmRef1Phone.value)?(alert("Please enter valid phone number!"),e.frmRef1Phone.focus(),!1):""==e.frmRef1Email.value?(alert("Reference1 Email is Required!"),e.frmRef1Email.focus(),!1):0==AcceptEmail(e.frmRef1Email.value)?(alert("Please enter valid Reference1 Email!"),e.frmRef1Email.focus(),!1):""==e.frmRef1CompanyName.value?(alert("Reference1 Company Name is Required!"),e.frmRef1CompanyName.focus(),!1):""==e.frmRef1CompanyAddress.value?(alert("Reference1 Address is Required!"),e.frmRef1CompanyAddress.focus(),!1):""==e.frmRef2Name.value?(alert("Reference2 Name is Required!"),e.frmRef2Name.focus(),!1):""==e.frmRef2Phone.value?(alert("Reference2 Phone/mobile is Required!"),e.frmRef2Phone.focus(),!1):0==IsPhone(e.frmRef2Phone.value)?(alert("Please enter valid phone number!"),e.frmRef2Phone.focus(),!1):""==e.frmRef2Email.value?(alert("Reference2 Email is Required!"),e.frmRef2Email.focus(),!1):0==AcceptEmail(e.frmRef2Email.value)?(alert("Please enter valid Reference2 Email!"),e.frmRef2Email.focus(),!1):""==e.frmRef2CompanyName.value?(alert("Reference2 Company Name is Required!"),e.frmRef2CompanyName.focus(),!1):""==e.frmRef2CompanyAddress.value?(alert("Reference2 Address is Required!"),e.frmRef2CompanyAddress.focus(),!1):""==e.frmRef3Name.value?(alert("Reference3 Name is Required!"),e.frmRef3Name.focus(),!1):""==e.frmRef3Phone.value?(alert("Reference3 Phone/mobile is Required!"),e.frmRef3Phone.focus(),!1):0==IsPhone(e.frmRef3Phone.value)?(alert("Please enter valid phone number!"),e.frmRef3Phone.focus(),!1):""==e.frmRef3Email.value?(alert("Reference3 Email is Required!"),e.frmRef3Email.focus(),!1):0==AcceptEmail(e.frmRef3Email.value)?(alert("Please enter valid Reference3 Email!"),e.frmRef3Email.focus(),!1):""==e.frmRef3CompanyName.value?(alert("Reference3 Company Name is Required!"),e.frmRef3CompanyName.focus(),!1):""==e.frmRef3CompanyAddress.value?(alert("Reference3 Address is Required!"),e.frmRef3CompanyAddress.focus(),!1):!0
}

function checkLogisticEmail(e){
    var t,r=$("#frmCompanyEmail").val();
    ""==r?($("#frmCEmail").val("0"),$("#CompanyEmail").html("")):$.post("ajax.php",{
        action:"checkLogisticEmail",
        code:r,
        id:e
    },function(e){
        t="0"==e?"":" Email Already in use. Please enter different email.",$("#frmCEmail").val(e),$("#CompanyEmail").html(t)
    })
}