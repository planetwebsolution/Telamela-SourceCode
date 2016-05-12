function bookmarksite(title, url) {
    if (window.sidebar) // firefox
        window.sidebar.addPanel(title, url, "");
    else if (window.opera && window.print) { // opera
        var elem = document.createElement('a');
        elem.setAttribute('href', url);
        elem.setAttribute('title', title);
        elem.setAttribute('rel', 'sidebar');
        elem.click();
    }
    else if (window.chrome) {
        alert(PRESS_CTRL_D_BOOK_MARK);
        return false;
    }
    else if (document.all)// ie
        window.external.AddFavorite(url, title);
}



function showHideLeftNavigation(containerId)
{
    $('.left_container').hide();
    $('#' + containerId).fadeIn();
}

function addMailingListEmail()
{
    //apply validation
    if ($('#mailingListEmail').val() == '' || $('#mailingListEmail').val() == INSERT_EMAIL)
    {
        $('#mailingListEmail_errMsg_container').show();
        $('#mailingListEmail_errMsg').html(ENTER_EMAIL).show();
        return false;
    }
    else if (!isEmail('#mailingListEmail', INVALID_EMAIL, true))
    {
        $('#mailingListEmail_errMsg_container').show();
        $('#mailingListEmail_errMsg').html(INVALID_EMAIL).show();
        return false;
    }
    else
    {
        $('#mailingListEmail_errMsg_container').hide();
    }

    var params = {'function': 'addMailingListEmail'};
    params['MailingListEmail'] = $('#mailingListEmail').val();

    $.post(SITE_ROOT_URL + 'common/ajax/ajax.php', params, function(data) {

        if (data != 0)
        {
            $('#emailpermission2').hide();
            $("#mailingListEmail_successMsg").html(data).show();
            $("#mailingListEmail").val(INSERT_EMAIL);
            return false;
        }
        else
        {
            $('#emailpermission2').hide();
            $("#mailingListEmail_successMsg").html(ERROR_DB_INSERT).show();
        }
    });


}


function flushValues(argID, argValue)
{
    if ($('#' + argID).val() == argValue)
    {
        $('#' + argID).val('');
    }
}



function sendFreeGiftEmail()
{
    //apply validation
    if ($('#frmFreeGiftUserEmail').val() == '' || $('#frmFreeGiftUserEmail').val() == INSERT_EMAIL)
    {
        $('#frmFreeGiftUserEmail_errMsg_container').show();
        $('#frmFreeGiftUserEmail_errMsg').html(ENTER_EMAIL).show();
        return false;
    }
    else if (!isEmail('#frmFreeGiftUserEmail', INVALID_EMAIL, true))
    {
        $('#frmFreeGiftUserEmail_errMsg_container').show();
        $('#frmFreeGiftUserEmail_errMsg').html(INVALID_EMAIL);
        return false;
    }
    else
    {
        $('#frmFreeGiftUserEmail_errMsg_container').hide();
    }

    var params = {'function': 'sendFreeGiftEmail'};
    params['FreeGiftUserEmail'] = $('#frmFreeGiftUserEmail').val();

    $.post(SITE_ROOT_URL + 'common/ajax/ajax.php', params, function(data) {
        if (data != 0)
        {
            $('#emailpermission').hide();
            $("#frmFreeGiftUserEmail_successMsg").html(data).show();
            return false;
        }
        else
        {
            $('#emailpermission').hide();
            $("#frmFreeGiftUserEmail_successMsg").html(ERROR_DB_INSERT).show();
        }
    });


}


function isEmail(id, message, focus) {

    var element = $(id);
    if (element) {
        str = element.val();		//alert(str);		
        str = jQuery.trim(str);		//alert(str);		str = jQuery.trim(str);
        if (Validate.isEmail(str)) {
            element.removeClass('error_input');
            $(id + '_errMsg').html('');
            $(id + '_errMsg').hide();
            return true;
        }
        else {
            element.addClass('error_input');
            if (focus)
                setFocus(element);
            $(id + '_errMsg').show();
            $(id + '_errMsg').html(message);
        }
    }
    return false;
}

function searchBrands(argBrandID)
{//alert(argBrandID);
    $('#selectedBrand').val(argBrandID);
}

function validateBrandSearchForm()
{
    if (($('#selectedBrand').val() == '' || $('#selectedBrand').val() == 0))
    {
        $('#search_Brands_error_container').show();
        $('#search_Brands_error').html(SEL_BRAND_NAME);
        return false;
    }
    else
    {
        $('#search_Brands_error_container').hide();
        $('#search_Brands_error').html('');
        return true;
    }
}

function validateProductkeywordSearchForm()
{
    if ($('#searchKeyword').val() == '' || $('#searchKeyword').val() == ENTER_KEYWORD)
    {
        $('#search_error_container').show();
        $('#search_error').html(ENTER_SEARCH_KEYWORD);
        return false;
    }
    else
    {
        $('#search_error_container').hide();
        $('#search_error').html('');
        return true;
    }
}

function setSearchKeyword()
{
    if ($('#searchKeyword').val() == '' && $('#searchKeyword').val() == ENTER_KEYWORD)
    {
        $('#searchKeyword').val(ENTER_KEYWORD);
    }

}

function blankSearchKeyword()
{
    if ($('#searchKeyword').val() == ENTER_KEYWORD)
    {
        $('#searchKeyword').val('');
    }

}

function showAllProducts(argRow, argTotalCount)
{
    if (argTotalCount > 5)
    {
        for (i = 6; i <= argTotalCount; i++)
        {
            $('#' + argRow + i).toggle();
            if ($('#' + argRow + i).is(':visible'))
            {
                $('.expand_list').html(CONTRACT_LIST);
            }
            else
            {
                $('.expand_list').html(EXPAND_LIST);
            }
        }
    }

}

function showAllShoppingHistory(argRow)
{

    for (i = 4; i <= 6; i++)
    {
        $('#' + argRow + i).toggle();
        if ($('#' + argRow + i).is(':visible'))
        {
            $('.expand_list').html(CONTRACT_LIST);
        }
        else
        {
            $('.expand_list').html(EXPAND_LIST);
        }
    }


}

function addProductToCart(argProductID, argProductSizeID, argProductQuantity, argProductName, argProductBrand, argCategoryID, argBrandID, argIsGiftSet, argSizeName, argProductCondition, argProductColor)
{

    $('#productID').val(argProductID);
    $('#productSizeID').val(argProductSizeID);
    $('#sizeData').val(argSizeName);
    //$('#productQuantity').val(argProductQuantity);
    $('#productName').val(argProductName);
    $('#productBrand').val(argProductBrand);
    $('#productBrandID').val(argBrandID);
    $('#productCategoryID').val(argCategoryID);
    $('#giftSet').val(argIsGiftSet);
    $('#Productcondition').val(argProductCondition);
    $('#ProductColor').val(argProductColor);
    $('#frmAddProductToCart').submit();

}
function addProductToCartByProductLandingPage(argProductID, argProductSizeID, argProductQuantity, argProductName, argProductBrand, argCategoryID, argBrandID, argIsGiftSet, argSizeName, argProductCurrentStock, argProductPrice)
{
    //alert(argProductPrice);
    //alert(argProductCurrentStock);

    var varProductCondition = $('#ProductCondition').val();
    if (varProductCondition == 'Tester')
    {
        if (!$('#testercondition').attr('checked'))
        {
            alert(CHECK_TESTER_CHECKBOX);
            return false;
        }

    }
    //////Validation for Color before add to cart
    var colorName = $("#Productcolor").val();

    if (colorName == '')
    {
        alert(SEL_PRODUCT_COLOR);
        return false;
    }
    var quantity = $("#cmbProductQuantity").val();
    var varproductSizeId = $('#productSizeID').val();
    var currnetStock = $('#Productquantity').val();
    var productPrice = $('#ProductUniquePrice').val();
    //alert(varproductSizeId);

    if (varproductSizeId == '')
    {
        //alert("under Selected");	
        currnetStock = argProductCurrentStock;
        quantity = argProductQuantity;
        productPrice = argProductPrice;
        $('#productSizeID').val(argProductSizeID);
        $('#ProductUniquePrice').val(argProductPrice);
        $('#ProductSizeName').val(argSizeName);

    }
    var productSize = $("#cmbProductSizeID").val();
    var sizeData = $("#productSizeData").val();

    /*
     if(!argSizeName)
     {
     var sizeData = $("#productSizeData").val();
     }else
     {
     var sizeData = argSizeName;
     }
     */
    // alert(quantity);
    //alert(currnetStock);
    // return false;
    if ((parseInt(quantity) > parseInt(currnetStock)))
    {

        //alert("here");
        //return false;
        var alertMessage = '';
        centerPopup_buynow('request_popup_outofstock_buynow', argProductID, productSize, quantity, argProductName, argProductBrand, argCategoryID, argBrandID, argIsGiftSet, sizeData, productPrice);
        loadPopup('request_popup_outofstock_buynow', '')
        //$('#frmLowStock').show();

        //alertMessage	 =	'Sorry! There is only <span>'+currnetStock+' '+argProductName+'</span> left on the e-shelves. ';
        //alertMessage	+=	'<a href="javascript:void(0)" onclick="return addProductToCartByProductBYclick(\''+argProductID+'\',\''+productSize+'\',\''+quantity+'\',\''+argProductName+'\',\''+argProductBrand+'\',\''+argCategoryID+'\',\''+argBrandID+'\',\''+argIsGiftSet+'\')">CLICK HERE if you still want '+$('#cmbProductQuantity').val()+' '+ argProductName+'.</a><br/>';
        //alertMessage	+=	' It might take us another business day to refill e-shelves.';
        //$('#frmLowStockMessage').html(alertMessage);
        check = '0';
        return false;
    }
    else
    {
        $('#frmLowStock').hide();









        $('#productQuantity').val(argProductQuantity);
        $('#productName').val(argProductName);
        $('#sizeData').val(sizeData);
        $('#productBrand').val(argProductBrand);
        $('#productCategoryID').val(argCategoryID);
        $('#productBrandID').val(argBrandID);
        $('#giftSet').val(argIsGiftSet);
        $('#productID').val(argProductID);

        //alert(varproductSizeId);

        //alert(argProductID+">>"+varproductSizeId+">>"+argProductQuantity+">>"+argProductName+">>"+argProductBrand+">>"+argCategoryID+">>"+argBrandID+">>"+argIsGiftSet+">>"+argSizeName);
        //return false;

        $('#frmAddProductToCart').submit();
    }
}


function addProductToCartByProductLandingPage_newarrival()
{

    //alert(argProductID+">>"+argProductSizeID+">>"+argProductQuantity+">>"+argProductName+">>"+argProductBrand+">>"+argCategoryID+">>"+argBrandID+">>"+argIsGiftSet+">>"+argSizeName);

    //return false;
    $('#frmAddProductToCart').submit();
}
function addProductToCartByProductBYBuyNow()
{

    //alert(argProductID+">>"+argProductSizeID+">>"+argProductQuantity+">>"+argProductName+">>"+argProductBrand+">>"+argCategoryID+">>"+argBrandID+">>"+argIsGiftSet+">>"+argSizeName);

    //return false;
    $('#frmAddProductToCart').submit();
}

function addProductToCartByProductDetailsPage(argProductID, argProductSizeID, argProductQuantity, argProductName, argProductBrand, argCategoryID, argBrandID, argIsGiftSet, argProductCurrentStock)
{

    var varProductCondition = $('#ProductCondition').val();
    if (varProductCondition == 'Tester')
    {
        if (!$('#testercondition').attr('checked'))
        {
            alert(CHECK_TESTER_CHECKBOX);
            return false;
        }

    }
    //////Validation for Color before add to cart
    var colorName = $("#Productcolor").val();

    if (colorName == '')
    {
        alert(SEL_PRODUCT_COLOR);
        return false;
    }
    //var argProductSizeID=$("#productSizeID").val();

    //alert(argProductID+">>"+argProductSizeID+">>"+argProductQuantity+">>"+argProductName+">>"+argProductBrand+">>"+argCategoryID+">>"+argBrandID+">>"+argIsGiftSet+">>"+argProductCurrentStock);
    //return false;
    var requiredQuantity = $('#cmbProductQuantity').val();
    var ProductStock = $('#Productquantity').val();
    var productSize = $("#productSizeID").val();
    var productSizeName = $('#ProductSizeName').val();
    //alert(productSizeName);
    if (ProductStock == '')
    {
        //alert(ProductStock);
        ProductStock = argProductCurrentStock;
        productSize = argProductSizeID;
    }
    //alert(productSize);
    //return false;
    //alert(requiredQuantity+">"+ProductStock);
    //return false;
    if (parseInt(requiredQuantity) > parseInt(ProductStock))
    {


        var alertMessage = '';
        $('#frmLowStock').show();

        alertMessage = SORRY_THERE_IS + ' <span>' + ProductStock + ' ' + argProductName + '</span> ' + LEFT_ON_THE;
        alertMessage += '<a  style="font-weight:bold;" href="javascript:void(0)" onclick="return addProductToCartByProductBYclick(\'' + argProductID + '\',\'' + productSize + '\',\'' + quantity + '\',\'' + argProductName + '\',\'' + argProductBrand + '\',\'' + argCategoryID + '\',\'' + argBrandID + '\',\'' + argIsGiftSet + '\')"> ' + CLICK_HERE_IF + $('#cmbProductQuantity').val() + ' ' + argProductName + '.</a><br/>';
        alertMessage += IT_MIGHT_TAKE_US_ANOTHER_BUSINESS_DAY;
        $('#frmLowStockMessage').html(alertMessage);
        return false;
    }
    else
    {

        $('#frmLowStock').hide();



        $('.add').hide();
        $('.loadingstatus').show();
        var quantity = $("#cmbProductQuantity").val();
        //var productSize = $("#cmbProductSizeID").val();

        var productSizeName = $('#ProductSizeName').val();
        var ProductchangedValues = $('#ProductchangedValues').val();
        var sizeData = $("#productSizeData").val();

        var ProductPrice = $("#ProductUniquePrice").val();
        var Productcondition = $("#Productcondition").val();
        var Productcolor = $("#Productcolor").val();
        //alert(ProductchangedValues);
        //alert(ProductPrice);
        var data = 'frmProductID=' + argProductID + '&frmProductSizeID=' + productSize + '&frmSizeData=' + sizeData + '&frmProductName=' + argProductName + '&frmProductQuantity='
                + quantity + '&frmProductBrand=' + argProductBrand + '&frmProductBrandID=' + argBrandID + '&frmProductCategoryID=' + argCategoryID + '&frmGiftSet=' + argIsGiftSet + '&frmaProductCurrentStock=' + argProductCurrentStock + '&frmSizename=' + productSizeName + '&frmProductprice=' + ProductPrice +
                '&ProductchangedValues=' + ProductchangedValues + '&Productcondition=' + Productcondition + '&frmProductColor=' + Productcolor + '&frmCartAction=addtocart&Productoffline=yes';
        //alert(data);
        //return false;

        $.ajax({
            //this is the php file that processes the data and send mail
            url: "cart.php",
            type: "POST",
            //pass the data        
        data: data,
            //Do not cache the page
            cache: false,
            //success

            success: function(data) {
                //alert(data);
                // 	return false;
                if (data == '')
                {
                    //alert("Sorry.There is insufficient inventory to process your order");
                    //centerPopup('request_popup');loadPopup('request_popup',argProductID);
                    $('.drop_but').show();
                    $('.loadingstatus').hide();
                    $('.add').show();
                    return false;
                }
                //(data)
                $('.drop_but').hide();
                $('.cartstatus').show();
                var message = argProductName + BY + argProductBrand + IS_ADD_TO_SHOPPING_CART;
                $('.drop_but').html('');
                $('.drop_but').html(data);
                $('.cartstatus').hide();
                $('.drop_but').show();
                $('.loadingstatus').hide();
                $('.add').show();
                $('#statusmessage').html('<img src="common/images/green_alert_top.jpg" alt=""  class="left" /><div class="mid">' + message + '</div><img src="common/images/green_alert_bottom.jpg" alt=""  class="left" />');

            }
        });
    }
}

//function addProductToWholesellerCart(argProductID, argProductSizeID, argProductName, argProductBrand, argCategoryID, argBrandID, argIsGiftSet, argSizeName)
function addProductToWholesellerCart(str, argProductID, argProductSizeID, quantity, user)
{
    //var quantity=$('#productQuantity_'+argProductID).val();
    //if(quantity=='')
    ///{
    //$('#validquantity_'+argProductID).text('Please enter valid quantity');
    // $('#validquantity_'+argProductID).css("color","red");
    //$('#validquantity_'+argProductID).show();
    //return false;
    //}
    //$('#producthide_'+argProductID).hide();
    //$('#productloadingstatus_'+argProductID).show();
    //$('#productID').val(argProductID);
    //$('#productSizeID').val(argProductSizeID);
    //$('#sizeData').val(argSizeName);
    //$('#productQuantity').val(argProductQuantity);
    $('#WholesalerShoppingcart').hide('');
    $('#cartloadingstatus').show();
    argProductName = $('#frmProductName_' + str).val();
    argProductPrice = $('#frmproductPrice_' + str).val();
    argProductSize = $('#productSize_' + str).val();

    argProductCondition = $('#frmproductCondition_' + str).val();
    argProductColor = $('#frmproductColor_' + str).val();

    argCategoryID = $('#categoryId').val();

    //alert(argProductCondition);
    //return false;

    //alert(argProductPrice);
    //alert(argProductName);
    //alert(argProductPrice);
    //alert(argProductSize);
    //alert(argCategoryID);
    //return false;

    //$('#productName').val(argProductName);
    //$('#productBrand').val(argProductBrand);
    //$('#productBrandID').val(argBrandID);
    //$('#productCategoryID').val(argCategoryID);
    //$('#giftSet').val(argIsGiftSet);
    //var data = 'frmProductID=' + argProductID+ '&frmProductSizeID=' +argProductSizeID+ '&frmSizeData=' +argSizeName+ '&frmProductName=' +argProductName+ '&frmProductQuantity='
    //+quantity+ '&frmProductBrand=' +argProductBrand+ '&frmProductBrandID=' +argBrandID+ '&frmProductCategoryID=' +argCategoryID+ '&frmGiftSet=' +argIsGiftSet+ '&frmCartAction=addtocart';
    //$('#frmAddProductToCart').submit();
    var data = 'frmProductID=' + argProductID + '&frmSizeData=' + argProductSize + '&frmProductName=' + argProductName + '&frmProductQuantity='
            + quantity + '&frmProductCategoryID=' + argCategoryID + '&frmProductPrice=' + argProductPrice + '&frmCartWholesalerAction=addtoWholesalercart&usertype=' + user + '&frmproductCondition=' + argProductCondition + '&frmproductColor=' + argProductColor;
    //alert(data);
    $.ajax({
        //this is the php file that processes the data and send mail
        url: "cart.php",
        type: "POST",
        //pass the data        
    data: data,
        //Do not cache the page
        cache: false,
        //success

        success: function(data) {
            //alert(data);
            //return false;
            /*
             if(data=='')
             {
             alert("Sorry.There is insufficient inventory to process your order");
             $('.drop_but').show();
             $('#productloadingstatus_'+argProductID).hide();
             $('#producthide_'+argProductID).show();
             
             //$('.add').show();
             return false;
             }
             */
            //(data)
            //$('#productloadingstatus_'+argProductID).hide();
            //$('#producthide_'+argProductID).show();
            //$('.drop_but').hide();
            //$('.cartstatus').show();
            //var message=argProductName +' by '+ argProductBrand +'is added to Shopping Cart.';
            $('.shoping_cart').html('');
            $('.shoping_cart').html(data);
            $('#cartloadingstatus').hide();
            $('#WholesalerShoppingcart').show('');

            //$('.shoping_cart').hide();

            //$('.loadingstatus').hide();
            //$('.add').show();
            //$('#validquantity_'+argProductID).text(message);
            // $('#validquantity_'+argProductID).css("color","green");

            //$('#validquantity_'+argProductID).show();

        }
    });

}


/*function showGiftProductPopup(argGiftProduct, argLoggedInUserID)
 {
 if(argGiftProduct == 'yes')
 {
 if(argLoggedInUserID == '')
 {
 location.href = SITE_ROOT_URL+'login.php';	
 }
 else
 {
 centerPopup('gift_popup');
 loadPopup('gift_popup','');
 }
 }
 else
 {
 location.href = SITE_ROOT_URL+'billing_address.php';
 }
 }*/


function showGiftProductPopup(argProductID, argProductSizeID, argProductQuantity, argProductName, argProductBrand, argCategoryID, argBrandID, argIsGiftSet, argSizeName, argLoggedInUserID)
{
    if (argLoggedInUserID == '')
    {
        location.href = SITE_ROOT_URL + 'login.php';
    }
    else
    {
        $('#productID').val(argProductID);
        $('#productSizeID').val(argProductSizeID);
        $('#sizeData').val(argSizeName);
        $('#productQuantity').val(argProductQuantity);
        $('#productName').val(argProductName);
        $('#productBrand').val(argProductBrand);
        $('#productBrandID').val(argBrandID);
        $('#productCategoryID').val(argCategoryID);
        $('#giftSet').val(argIsGiftSet);

        centerPopup('gift_popup');
        loadPopup('gift_popup', '');
    }
}


function addGiftsetValues()
{

    errorFlag = 0;

    if ($('#frmGiftReceiverName').val() == '')
    {
        $('#frmGiftReceiverName_errMsg_container').show();
        $('#frmGiftReceiverName_errMsg').html(ENTER_NAME);
        errorFlag = 1;
    }
    else
    {
        $('#frmGiftReceiverName_errMsg_container').hide();
        $('#frmGiftReceiverName_errMsg').html('');
    }

    if ($('#frmGiftReceiverEmail').val() == '')
    {
        $('#frmGiftReceiverEmail_errMsg_container').show();
        $('#frmGiftReceiverEmail_errMsg').html(ENTER_EMAIL);
        errorFlag = 1;
        //return false;
    }
    else if (!isEmail('#frmGiftReceiverEmail', INVALID_EMAIL2, true))
    {
        $('#frmGiftReceiverEmail_errMsg_container').show();
        $('#frmGiftReceiverEmail_errMsg').html(INVALID_EMAIL2);
        errorFlag = 1;
    }
    else
    {
        $('#frmGiftReceiverEmail_errMsg_container').hide();
        $('#frmGiftReceiverEmail_errMsg').html('');
    }

    if ($('#frmAddressLine1').val() == '')
    {
        $('#frmAddressLine1_errMsg_container').show();
        $('#frmAddressLine1_errMsg').html(ENTER_ADDRESS);
        errorFlag = 1;
    }
    else
    {
        $('#frmAddressLine1_errMsg_container').hide();
        $('#frmAddressLine1_errMsg').html('');
    }

    if ($('#country').val() == '')
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
    if ($('#frmState').val() == '')
    {
        $('#frmState_errMsg_container').show();
        $('#frmState_errMsg').html(SEL_STATE_NAME);
        errorFlag = 1;
    }
    else
    {
        $('#frmState_errMsg_container').hide();
        $('#frmState_errMsg').html('');
    }
    if ($('#frmCity').val() == '')
    {
        $('#frmCity_errMsg_container').show();
        $('#frmCity_errMsg').html(SEL_CITY_NAME);
        errorFlag = 1;
    }
    else
    {
        $('#frmCity_errMsg_container').hide();
        $('#frmCity_errMsg').html('');
    }
    if ($('#frmZipCode').val() == '')
    {
        $('#frmZipCode_errMsg_container').show();
        $('#frmZipCode_errMsg').html(ENTER_ZIP_CODE);
        errorFlag = 1;
    }
    else
    {
        $('#frmZipCode_errMsg_container').hide();
        $('#frmZipCode_errMsg').html('');
    }


    if (errorFlag)
    {
        return false;
    }
    else
    {
        //return true;
        var params = {'function': 'addGiftsetValues'};
        params['frmGiftReceiverName'] = $('#frmGiftReceiverName').val();
        params['frmGiftReceiverEmail'] = $('#frmGiftReceiverEmail').val();
        params['frmSenderComments'] = $('#frmSenderComments').val();
        params['frmAddressLine1'] = $('#frmAddressLine1').val();
        params['frmAddressLine2'] = $('#frmAddressLine2').val();
        params['country'] = $('#country').val();
        params['frmState'] = $('#frmState').val();
        params['frmCity'] = $('#frmCity').val();
        params['frmZipCode'] = $('#frmZipCode').val();
        params['productID'] = $('#productID').val();

        $.post(SITE_ROOT_URL + 'common/ajax/ajax.php', params, function(data) {
            if (data == 1)
            {
                $('#frmAddProductToCart').submit();
                //$("#frmState").html(data).show();
                //return true;

            }

        });
    }
}



function validateGiftSetForm(argID)
{
    errorFlag = 0;

    if ($('#frmGiftReceiverName').val() == '')
    {
        $('#frmGiftReceiverName_errMsg_container').show();
        $('#frmGiftReceiverName_errMsg').html(ENTER_NAME);
        errorFlag = 1;
    }
    else
    {
        $('#frmGiftReceiverName_errMsg_container').hide();
        $('#frmGiftReceiverName_errMsg').html('');
    }

    if ($('#frmGiftReceiverEmail').val() == '')
    {
        $('#frmGiftReceiverEmail_errMsg_container').show();
        $('#frmGiftReceiverEmail_errMsg').html(ENTER_EMAIL);
        errorFlag = 1;
        //return false;
    }
    else if (!isEmail('#frmGiftReceiverEmail', INVALID_EMAIL2, true))
    {
        $('#frmGiftReceiverEmail_errMsg_container').show();
        $('#frmGiftReceiverEmail_errMsg').html(INVALID_EMAIL2);
        errorFlag = 1;
    }
    else
    {
        $('#frmGiftReceiverEmail_errMsg_container').hide();
        $('#frmGiftReceiverEmail_errMsg').html('');
    }

    if (errorFlag)
    {
        return false;
    }
    else
    {
        return true;
    }
}





function sendUsToFriend(argID)
{
    errorFlag = 0;

    if ($('#senderFriendName').val() == '')
    {
        $('#senderFriendName_errMsg_container').show();
        $('#senderFriendName_errMsg').html(ENTER_FRIEND_NAME);
        errorFlag = 1;
    }
    else
    {
        $('#senderFriendName_errMsg_container').hide();
        $('#senderFriendName_errMsg').html('');
    }

    if ($('#senderFriendEmail').val() == '')
    {
        $('#senderFriendEmail_errMsg_container').show();
        $('#senderFriendEmail_errMsg').html(ENTER_FRIEND_EMAIL);
        errorFlag = 1;
        //return false;
    }
    else if (!isEmail('#senderFriendEmail', INVALID_EMAIL2, true))
    {
        $('#senderFriendEmail_errMsg_container').show();
        $('#senderFriendEmail_errMsg').html(INVALID_EMAIL2);
        errorFlag = 1;
    }
    else
    {
        $('#senderFriendEmail_errMsg_container').hide();
        $('#senderFriendEmail_errMsg').html('');
    }

    if (errorFlag)
    {
        return false;
    }
    else
    {
        return true;
    }
}


/// Code done by pankaj /////


function sendUsToMultipleFriend(argID)
{
    errorFlag = 0;

    var emailString = $('#senderFriendEmail').val();
    var emails = emailString.split(",");
    var emailsLength = emails.length;
    var senderFriendNameString = $('#senderFriendName').val();
    var senderFriendName = senderFriendNameString.split(",");
    var senderFriendNameLength = senderFriendName.length;

    //alert(senderFriendNameLength);
    //alert(emailsLength);
    var emailVal = checkAllEmail();
    //alert(emailVal);
    if (emailVal == false)
    {
        errorFlag = 1;
    }
    if ($('#senderFriendName').val() == '')
    {
        $('#senderFriendName_errMsg_container').show();
        $('#senderFriendName_errMsg').html(ENTER_FRIEND_NAME);
        errorFlag = 1;
    }
    else
    {
        $('#senderFriendName_errMsg_container').hide();
        $('#senderFriendName_errMsg').html('');
    }

    if ($('#senderFriendEmail').val() == '')
    {
        $('#senderFriendEmail_errMsg_container').show();
        $('#senderFriendEmail_errMsg').html(ENTER_FRIEND_EMAIL);
        errorFlag = 1;
        //return false;
    }

    else
    {
        $('#senderFriendEmail_errMsg_container').hide();
        $('#senderFriendEmail_errMsg').html('');
    }
    if (emailVal == true)
    {
        if (senderFriendNameLength != emailsLength)
        {

            $('#senderMultipleFriendEmail_errMsg_container').show();
            $('#senderMultipleFriendEmail_errMsg').html(NAME_EMAIL_DOES_NOT_MATCH);
            errorFlag = 1;


        }
        else
        {
            $('#senderMultipleFriendEmail_errMsg_container').hide();
            $('#senderMultipleFriendEmail_errMsg').html('');
        }

    }



    if (errorFlag)
    {
        return false;
    }
    else
    {
        return true;

    }
}




///////////////////////////////


function sendEmailToFriend(argID)
{




    errorFlag = 0;
    var emailString = $('#friendEmail').val();
    var emails = emailString.split(",");
    var emailsLength = emails.length;
    var senderFriendNameString = $('#friendName').val();
    var senderFriendName = senderFriendNameString.split(",");
    var senderFriendNameLength = senderFriendName.length;


    var emailVal = checkAllEmail();


    if (emailVal == false)
    {
        errorFlag = 1;
    }
    //alert(emailVal);
    if ($('#SenderName').val() == '')
    {
        $('#SenderNames_errMsg_container').show();
        $('#SenderName_errMsg').html(ENTER_NAME);
        errorFlag = 1;
    }
    else
    {
        $('#SenderNames_errMsg_container').hide();
        $('#SenderName_errMsg').html('');
    }
    if ($('#SenderEmail').val() == '')
    {
        $('#SenderEmail_errMsg_container').show();
        $('#SenderEmail_errMsg').html(ENTER_EMAIL);
        errorFlag = 1;
        //return false;
    }
    else if (!isEmail('#SenderEmail', INVALID_EMAIL2, true))
    {
        $('#SenderEmail_errMsg_container').show();
        $('#SenderEmail_errMsg').html(INVALID_EMAIL2);
        errorFlag = 1;
    }
    else
    {
        $('#SenderEmail_errMsg_container').hide();
        $('#SenderEmail_errMsg').html('');
    }
    if ($('#friendName').val() == '')
    {
        $('#friendNames_errMsg_container').show();
        $('#friendName_errMsg').html(ENTER_FRIEND_NAME);
        errorFlag = 1;
    }
    else
    {
        $('#friendNames_errMsg_container').hide();
        $('#friendName_errMsg').html('');
    }

    if ($('#friendEmail').val() == '')
    {
        $('#friendEmail_errMsg_container').show();
        $('#friendEmail_errMsg').html(ENTER_FRIEND_EMAIL);
        errorFlag = 1;
        //return false;
    }

    else if (emailVal == true)
    {
        $('#friendEmail_errMsg_container').hide();
        $('#friendEmail_errMsg').html('');
    }
    if (emailVal == true)
    {

        if (senderFriendNameLength != emailsLength)
        {

            $('#senderMultipleFriendEmails_errMsg_container').show();
            $('#senderMultipleFriendEmails_errMsg').html(NAME_EMAIL_DOES_NOT_MATCH);
            errorFlag = 1;


        }
        else
        {
            $('#senderMultipleFriendEmails_errMsg_container').hide();
            $('#senderMultipleFriendEmails_errMsg ').html('');

        }

    }


    if (errorFlag)
    {
        return false;
    }
    else
    {
        return true;
    }
}

//////Validation for share Favorite perfume form///


function shareFavPerfume(argID)
{



    errorFlag = 0;
    if ($('#name').val() == '')
    {

        $('#name_errMsg_container').show();
        $('#name_errMsg').html(ENTER_NAME);
        errorFlag = 1;
    }
    else
    {
        $('#name_errMsg_container').hide();
        $('#name_errMsg').html('');

    }
    if ($('#perfumename').val() == '')
    {

        $('#perfumename_errMsg_container').show();
        $('#perfumename_errMsg').html(FAVOURITE_PERFUME);
        errorFlag = 1;
    }
    else
    {
        $('#perfumename_errMsg_container').hide();
        $('#perfumename_errMsg').html('');
    }

    if ($('#Email').val() == '')
    {
        $('#Email_errMsg_container').show();
        $('#Email_errMsg').html(ENTER_EMAIL);
        errorFlag = 1;
        //return false;
    }
    else if (!isEmail('#Email', INVALID_EMAIL2, true))
    {
        $('#Email_errMsg_container').show();
        $('#Email_errMsg').html(INVALID_EMAIL2);
        errorFlag = 1;
    }
    else
    {
        $('#Email_errMsg_container').hide();
        $('#Email_errMsg').html('');
    }

    if (errorFlag)
    {
        return false;
    }
    else
    {
        return true;
    }
}



function validateWeeklyDrawingFooterForm()
{
    errorFlag = 0;

    if ($('#frmFavouritePerfumeUserEmail').val() == '' || $('#frmFavouritePerfumeUserEmail').val() == INSERT_EMAIL_ADDRESS)
    {
        $('#frmFavouritePerfumeUserEmail_errMsg_container').show();
        $('#frmFavouritePerfumeUserEmail_errMsg').html(ENTER_EMAIL);
        errorFlag = 1;

    }
    else if (!isEmail('#frmFavouritePerfumeUserEmail', INVALID_EMAIL2, true))
    {
        $('#frmFavouritePerfumeUserEmail_errMsg_container').show();
        $('#frmFavouritePerfumeUserEmail_errMsg').html(INVALID_EMAIL2);
        errorFlag = 1;//return false;
    }
    else
    {
        $('#frmFavouritePerfumeUserEmail_errMsg_container').hide();
        $('#frmFavouritePerfumeUserEmail_errMsg').html('');
    }

    if ($('#frmFavoritePerfume').val() == '' || $('#frmFavoritePerfume').val() == WHAT_FAVOURITE_PERFUME)
    {
        $('#frmFavoritePerfume_errMsg_container').show();
        $('#frmFavoritePerfume_errMsg').html(FAVOURITE_PERFUME);
        errorFlag = 1;

    }
    else
    {
        $('#frmFavoritePerfume_errMsg_container').hide();
        $('#frmFavoritePerfume_errMsg').html('');
    }


    if (errorFlag)
    {
        return false;
    }
    else
    {
        return true;
    }

}
function showNewsletterDetails(argContainerID)
{
    if ($('#' + argContainerID).is(':visible'))
    {
        $('#' + argContainerID).hide();
    }
    else
    {
        $('#' + argContainerID).show();
    }


}

function validateAddressBookForm()
{
    errorFlag = 0;

    if ($('#frmAddressBookUserNameID').val() == '')
    {
        $('#frmAddressBookUserNameID_errMsg_container').show();
        $('#frmAddressBookUserNameID_errMsg').html(ENTER_NAME);
        errorFlag = 1;

    }
    else
    {
        $('#frmAddressBookUserNameID_errMsg').html('');
        $('#frmAddressBookUserNameID_errMsg_container').hide();

    }
    if ($('#frmAddressBookUserEmailID').val() == '')
    {
        $('#frmAddressBookUserEmailID_errMsg_container').show();
        $('#frmAddressBookUserEmailID_errMsg').html(ENTER_EMAIL);
        errorFlag = 1;

    }
    else if (!isEmail('#frmAddressBookUserEmailID', INVALID_EMAIL2, true))
    {
        $('#frmAddressBookUserEmailID_errMsg_container').show();
        $('#frmAddressBookUserEmailID_errMsg').html(INVALID_EMAIL2);
        errorFlag = 1;
    }
    else
    {
        $('#frmAddressBookUserEmailID_errMsg').html('');
        $('#frmAddressBookUserEmailID_errMsg_container').hide();
    }

    if (errorFlag)
    {
        return false;
    }
    else
    {
        return true;
    }
}


function validateCompareProductList(argProductCount)
{

    var varCheckedID = $("input[@name=frmCompareProduct]:checked").attr('id');

    if (typeof(varCheckedID) == 'undefined')
    {
        $('#compareProduct_errMsg_container').show();
        $('#compareProduct_errMsg').html(SEL_ONE_PRODUCT);
        return false;

    }
    else
    {
        $('#compareProduct_errMsg').html('');
        $('#compareProduct_errMsg_container').hide();
        return true;

    }
}


function showState(argCountryID, argSelectedState, argShowName)
{
    //alert(argCountryID);
    var params = {'function': 'getCountryStates'};
    params['countryID'] = argCountryID;
    params['selected'] = argSelectedState;
    params['showName'] = argShowName;

    $.post(SITE_ROOT_URL + 'common/ajax/ajax.php', params, function(data) {
        if (data)
        {
            //alert(data)
            $("#frmState").html('');
            $("#frmState").html(data).show();
            return true;

        }

    });
}


function showWholesellerState(argCountryID, argSelectedState, argShowName)
{
    //alert("sdsdsd");
    //alert(argCountryID);
    var params = {'function': 'getCountryStates'};
    params['countryID'] = argCountryID;
    params['selected'] = argSelectedState;
    params['showName'] = argShowName;

    $.post('../common/ajax/ajax.php', params, function(data) {
        if (data)
        {
            //alert(data)
            $("#frmState").html('');
            $("#frmState").html(data).show();
            return true;

        }

    });
}

function swapEmailToFriend()
{
    $('#friendName').val('');
    $('#friendEmail').val('');
    $('#comments').val('');
    $('#friendName_errMsg').html('');
    $('#friendEmail_errMsg').html('');
    $('#friendName_errMsg_container').hide();
    $('#friendEmail_errMsg_container').hide();

}


function flushGiftSetFormValues()
{
    $('#frmGiftReceiverName').val('');
    $('#frmGiftReceiverEmail').val('');
    $('#frmSenderComments').val('');
    $('#frmGiftReceiverName_errMsg').html('');
    $('#frmGiftReceiverEmail_errMsg').html('');
    $('#frmGiftReceiverName_errMsg_container').hide();
    $('#frmGiftReceiverEmail_errMsg_container').hide();

}


function deleteCartItem(argTotalCartProduct)
{
    var varFlag = 0;
    $('#frmCartAction').val('delete');
    for (i = 0; i < argTotalCartProduct; i++)
    {
        if ($('#productCart_' + i).attr('checked'))
        {
            $('#frmShoppingCart').submit();
            return true;

        }
        else
        {
            varFlag = 1;
        }
    }
    if (varFlag == 1)
    {
        alert(SEL_ONE_PRODUCT)
        return false;
        //centerPopup('cart_popup');
        //loadPopup('cart_popup','');
    }
    else
    {
        return true;
        //disablePopup('cart_popup');
    }
}

function changeCartItemPrice(argQuantity, argItemUnitPrice, argCount, argQuantityId)
{
    subTotal = 0;
    productPrice = 0;
    if (argQuantity == 0)
    {
        argQuantity = 1;
    }
    $('#productQuantity_' + argQuantityId).val(argQuantity);
    totalPrice = argItemUnitPrice * argQuantity;
    totalRows = $('#totalRows').val();
    $('#productPrice_' + argCount).html(totalPrice);
    $('#hiddenProductPrice_' + argCount).val(totalPrice);

    for (i = 0; i < totalRows - 1; i++)
    {
        productPrice = $('#hiddenProductPrice_' + i).val();
        subTotal = subTotal + parseInt(productPrice);
    }
    $('#subTotalContainer').html('$' + subTotal);
    grandTotal = subTotal - parseInt($('#frmCouponDiscount').val()) + parseInt($('#frmShippingCost').val()) + parseInt($('#frmTaxValue').val());
    $('#grandTotalContainer').html('$' + grandTotal);

}

function updateShoppingCart()
{
    $('#frmCartAction').val('update');
    $('#frmShoppingCart').submit();
}

function submitWholesellerOrder()
{

//$('#frmCartAction').val('update');
    $('#frmWholesellerCartfinalorder').submit();

}
$(document).ready
        (
                function()
                {
                    $('#frmShoppingCart input').keypress
                            (
                                    function(e)
                                    {
                                        if (e.keyCode == 13)
                                        {
                                            $('#frmCartAction').val('update');
                                            $('#frmShoppingCart').submit();
                                        }
                                    }
                            );
                }
        );

function applyCouponCode()
{
    if ($('#applyDiscountCoupon').val() == '')
    {
        $('#applyDiscountCoupon_errMsg_container').show();
        $('#applyDiscountCoupon_errMsg').html(ENTER_COUPON_CODE);
        return false;
    }
    else
    {
        $('#frmCartAction').val('applyCouponcode');
        $('#applyDiscountCoupon_errMsg').html('');
        $('#applyDiscountCoupon_errMsg_container').hide();
        $('#frmShoppingCart').submit();
    }
}

function validateAddressForm()
{
    errorFlag = 0;

    if ($('#frmAddressLine1').val() == '')
    {
        $('#frmAddressLine1_errMsg_container').show();
        $('#frmAddressLine1_errMsg').html(ENTER_ADDRESS);
        errorFlag = 1;

    }
    else
    {
        $('#frmAddressLine1_errMsg').html('');
        $('#frmAddressLine1_errMsg_container').hide();

    }
    if ($('#country').val() == '')
    {
        $('#country_errMsg_container').show();
        $('#country_errMsg').html(SEL_COUNTRY_NAME);
        errorFlag = 1;

    }
    else
    {
        $('#country_errMsg').html('');
        $('#country_errMsg_container').hide();
    }
    if ($('#frmState').val() == '')
    {
        $('#frmState_errMsg_container').show();
        $('#frmState_errMsg').html(SEL_STATE_NAME);
        errorFlag = 1;

    }
    else
    {
        $('#frmState_errMsg').html('');
        $('#frmState_errMsg_container').hide();
    }
    if ($('#city').val() == '')
    {
        $('#city_errMsg_container').show();
        $('#city_errMsg').html(SEL_CITY_NAME);
        errorFlag = 1;

    }
    else
    {
        $('#city_errMsg').html('');
        $('#city_errMsg_container').hide();
    }
    if ($('#zipCode').val() == '')
    {
        $('#zipCode_errMsg_container').show();
        $('#zipCode_errMsg').html(ENTER_ZIP_CODE);
        errorFlag = 1;

    }
    else
    {
        $('#zipCode_errMsg').html('');
        $('#zipCode_errMsg_container').hide();
    }
    if ($('#phone').val() == '')
    {
        $('#phone_errMsg_container').show();
        $('#phone_errMsg').html(ENTER_PHONE_NO);
        errorFlag = 1;

    }
    else
    {
        $('#phone_errMsg').html('');
        $('#phone_errMsg_container').hide();
    }

    if (errorFlag)
    {
        return false;
    }
    else
    {
        return true;
    }
}

function resetCountry()
{
    $('.selectedTxt').html(SEL_COUNTRY_NAME);
}

function sendToFriend()
{
    //alert($('#frmReferToFriendEmail').val());
    if ($('#frmReferToFriendEmail').val() == '' || $('#frmReferToFriendEmail').val() == EMAIL_IT_TO_FRIEND)
    {
        $('#frmReferToFriendEmail_errMsg_container').show();
        $('#frmReferToFriendEmail_errMsg').html(ENTER_FRIEND_EMAIL_ID);
        return false;

    }
    else if (!isEmail('#frmReferToFriendEmail', INVALID_EMAIL2, true))
    {
        $('#frmReferToFriendEmail_errMsg_container').show();
        $('#frmReferToFriendEmail_errMsg').html(INVALID_EMAIL2);
        return false;
    }
    else
    {
        $('#frmReferToFriendEmail_errMsg').html('');
        $('#frmReferToFriendEmail_errMsg_container').hide();
        $('#frmCartAction').val('sendUsToFriend');
        $('#frmSendEmailToFriendFor').val('Coupon');
        $('#frmShoppingCart').submit();
    }

}




function ismaxlength(obj)
{
    var mlength = obj.getAttribute ? parseInt(obj.getAttribute("maxlength")) : ""
    if (obj.getAttribute && obj.value.length > mlength)
        obj.value = obj.value.substring(0, mlength)
}

function deleteOrders(argOrderId)
{
    if (confirm(R_U_SURE_DELETE))
    {
        location.href = SITE_ROOT_URL + 'my_orders.php?oId=' + argOrderId + '&action=delete';
    }
    else
    {
        return false;
    }
}

function deleteWholesellerOrders(argOrderId)
{
    if (confirm(R_U_SURE_DELETE))
    {
        location.href = SITE_ROOT_URL + 'wholesale/wholeseller_order.php?oId=' + argOrderId + '&action=delete';
    }
    else
    {
        return false;
    }
}

function resetShippingForm()
{
    $('#frmAddressLine1').val('');
    $('#frmAddressLine2').val('');
    $('#frmState').val('');
    $('#city').val('');
    $('#zipCode').val('');
    $('#phone').val('');
    $('#phone').val('fax');
}


function validateSendEmailForm(argInputId)
{
    if ($('#frmEmailToFriend_' + argInputId).val() == '' || $('#frmEmailToFriend_' + argInputId).val() == EMAIL_IT_TO_FRIEND)
    {
        $('#frmEmailToFriend_' + argInputId + '_errMsg_container').show();
        $('#frmEmailToFriend_' + argInputId + '_errMsg').html(ENTER_EMAIL);
        return false;

    }
    else if (!isEmail('#frmEmailToFriend_' + argInputId, INVALID_EMAIL2, true))
    {
        $('#frmEmailToFriend_' + argInputId + '_errMsg_container').show();
        $('#frmEmailToFriend_' + argInputId + '_errMsg').html(INVALID_EMAIL2);
        return false;
    }
    else
    {
        $('#frmEmailToFriend_' + argInputId + '_errMsg').html('');
        $('#frmEmailToFriend_' + argInputId + '_errMsg_container').hide();

    }
}

function swapValues(argId)
{
    if ($('#frmEmailToFriend_' + argId).val() != '')
    {
        if ($('#frmEmailToFriend_' + argId).val() == EMAIL_IT_TO_FRIEND)
        {
            $('#frmEmailToFriend_' + argId).val('');

        }

    }
    else
    {
        $('#frmEmailToFriend_' + argId).val(EMAIL_IT_TO_FRIEND);
    }
}

function retainValue(argId)
{
    if ($('#frmEmailToFriend_' + argId).val() == '')
    {
        $('#frmEmailToFriend_' + argId).val(EMAIL_IT_TO_FRIEND);

    }
}


function sendGiftCard(argFromName)
{
    var checkGiftCards = checkRadio(argFromName, "frmGiftCard");
    if (checkGiftCards == 0)
    {
        alert(SEL_GIFT_CARD);
        return false;
    }
    else
    {
        //set the values on the form
        checkedGiftCardID = $('input[name=frmGiftCard]:checked', '#' + argFromName).val();
        checkedGiftCardName = $('#frmGiftCardName_' + checkedGiftCardID).val();
        checkedGiftCardAmount = $('#frmGiftCardAmount_' + checkedGiftCardID).val();
        checkedGiftCardImage = $('#frmGiftCardImage_' + checkedGiftCardID).val();
        alert(checkedGiftCardImage);
        $('#frmGiftCardID').val(checkedGiftCardID);
        $('#frmGiftCardName').val(checkedGiftCardName);
        $('#frmGiftCardAmount').val(checkedGiftCardAmount);
        $('#frmGiftCardImage').val(checkedGiftCardImage);

        centerPopup('gift_cards_popup');
        loadPopup('gift_cards_popup', '');


    }

}


function validateGiftCardForm()
{
    errorFlag = 0;
    if ($('#frmGiftCardReceiverName').val() == '')
    {
        $('#frmGiftCardReceiverName_errMsg_container').show();
        $('#frmGiftCardReceiverName_errMsg').html(ENTER_NAME);
        errorFlag = 1;

    }
    else
    {
        $('#frmGiftCardReceiverName_errMsg').html('');
        $('#frmGiftCardReceiverName_errMsg_container').hide();

    }

    if ($('#frmGiftCardReceiverEmail').val() == '')
    {
        $('#frmGiftCardReceiverEmail_errMsg_container').show();
        $('#frmGiftCardReceiverEmail_errMsg').html(ENTER_EMAIL);
        errorFlag = 1;

    }
    else if (!isEmail('#frmGiftCardReceiverEmail', INVALID_EMAIL2, true))
    {
        $('#frmGiftCardReceiverEmail_errMsg_container').show();
        $('#frmGiftCardReceiverEmail_errMsg').html(INVALID_EMAIL2);
        errorFlag = 1;
    }
    else
    {
        $('#frmGiftCardReceiverEmail_errMsg').html('');
        $('#frmGiftCardReceiverEmail_errMsg_container').hide();

    }
    if ($('#frmCreditCardNumber').val() == '')
    {
        $('#frmCreditCardNumber_errMsg_container').show();
        $('#frmCreditCardNumber_errMsg').html(ENTER_CREADIT_CARD_NUMBER);
        errorFlag = 1;

    }
    else
    {
        $('#frmCreditCardNumber_errMsg').html('');
        $('#frmCreditCardNumber_errMsg_container').hide();

    }
    if ($('#frmCardVerificationNumber').val() == '')
    {
        $('#frmCardVerificationNumber_errMsg_container').show();
        $('#frmCardVerificationNumber_errMsg').html(CARD_VARIFICATION_NO);
        errorFlag = 1;

    }
    else
    {
        $('#frmCardVerificationNumber_errMsg').html('');
        $('#frmCardVerificationNumber_errMsg_container').hide();

    }
    if ($('#frmAddressLine1').val() == '')
    {
        $('#frmAddressLine1_errMsg_container').show();
        $('#frmAddressLine1_errMsg').html(CARD_VARIFICATION_NO);
        errorFlag = 1;

    }
    else
    {
        $('#frmAddressLine1_errMsg').html('');
        $('#frmAddressLine1_errMsg_container').hide();

    }
    if ($('#country').val() == '')
    {
        $('#country_errMsg_container').show();
        $('#country_errMsg').html(CARD_VARIFICATION_NO);
        errorFlag = 1;

    }
    else
    {
        $('#country_errMsg').html('');
        $('#country_errMsg_container').hide();

    }
    if ($('#frmState').val() == '')
    {
        $('#frmState_errMsg_container').show();
        $('#frmState_errMsg').html(CARD_VARIFICATION_NO);
        errorFlag = 1;

    }
    else
    {
        $('#frmState_errMsg').html('');
        $('#frmState_errMsg_container').hide();

    }
    if ($('#frmCity').val() == '')
    {
        $('#frmCity_errMsg_container').show();
        $('#frmCity_errMsg').html(CARD_VARIFICATION_NO);
        errorFlag = 1;

    }
    else
    {
        $('#frmCity_errMsg').html('');
        $('#frmCity_errMsg_container').hide();

    }
    if ($('#frmZipCode').val() == '')
    {
        $('#frmZipCode_errMsg_container').show();
        $('#frmZipCode_errMsg').html(CARD_VARIFICATION_NO);
        errorFlag = 1;

    }
    else
    {
        $('#frmZipCode_errMsg').html('');
        $('#frmZipCode_errMsg_container').hide();

    }
    if (errorFlag)
    {
        return false;
    }
    else
    {
        return true;
    }
}


function flushGiftCardFormValues()
{
    $('#frmGiftCardReceiverName').val('');
    $('#frmGiftCardReceiverEmail').val('');
    $('#frmGiftCardSenderComments').val('');
    $('#frmGiftCardReceiverName_errMsg').html('');
    $('#frmGiftCardReceiverEmail_errMsg').html('');
    $('#frmGiftCardReceiverName_errMsg_container').hide();
    $('#frmGiftCardReceiverEmail_errMsg_container').hide();

}


function checkRadio(frmName, rbGroupName) {

    var radios = document[frmName].elements[rbGroupName];
    for (var i = 0; i < radios.length; i++) {
        if (radios[i].checked) {
            return 1;
        }
    }
    return 0;
}


////////////////Function For Unsubscribe the user/////////////////////
function unsubscribeUser(str)
{
//alert(str);
    var params = {'function': 'addUnsubscribeMail'};

    $.post(SITE_ROOT_URL + 'common/ajax/ajax.php', params, function(data) {
        //alert(data);
        //return false;
        if (data != 0)
        {
            if (str == 'freegift')
            {
                $('#emailpermission').hide();
                $("#frmFreeGiftUserEmail_successMsg").html(data).show();
                $("#mailingListEmail").val(INSERT_EMAIL);
                return false;
            }
            else if (str == 'footermail')
            {
                $('#emailpermissionfooter').hide();
                $("#mailingListEmail_successMsgfooter").html(data).show();

                return false;
            }
            else if (str == 'coupanlist')
            {
                $('#emailcoupanpermission').hide();
                $("#sucessmessage").html(data).show();

                return false;
            }
            else
            {
                $('#emailpermission2').hide();
                $("#mailingListEmail_successMsg").html(data).show();
                $("#mailingListEmail").val(INSERT_EMAIL);
                return false;
            }
        }
        else
        {
            $("#mailingListEmail_successMsg").html(ERROR_DB_INSERT).show();
        }
    });

}


function submitOrder()
{

    $('#frmSubmitWholesellerOrder').submit();
}

//////function for validation of product request/////

function sendEmailforproductRequest(argID)
{

    errorFlag = 0;

    if ($('#Name').val() == '')
    {

        $('#Name_errMsg_container').show();
        $('#Name_errMsg').html(ENTER_NAME);
        errorFlag = 1;
    }
    else
    {
        $('#Name_errMsg_container').hide();
        $('#Name_errMsg').html('');
    }

    if ($('#yourEmail').val() == '')
    {
        $('#yourEmail_errMsg_container').show();
        $('#yourEmail_errMsg').html(ENTER_EMAIL);
        errorFlag = 1;
        //return false;
    }
    else if (!isEmail('#yourEmail', INVALID_EMAIL2, true))
    {
        $('#yourEmail_errMsg_container').show();
        $('#yourEmail_errMsg').html(INVALID_EMAIL2);
        errorFlag = 1;
    }
    else
    {
        $('#yourEmail_errMsg_container').hide();
        $('#yourEmail_errMsg').html('');
    }
    if ($('#productquantity').val() == '')
    {
        $('#productquantity_errMsg_container').show();
        $('#productquantity_errMsg').html(ENTER_QUANTITY);
        errorFlag = 1;
        //return false;
    }
    else if (isNaN($('#productquantity').val()))
    {
        $('#productquantity_errMsg').html('');
        $('#productquantity_errMsg_container').show();
        $('#productquantity_errMsg').html(ENTER_VALID_QUANTITY);
        errorFlag = 1;
    }
    else
    {
        $('#productquantity_errMsg_container').hide();
        $('#productquantity_errMsg').html('');
    }

    if (errorFlag)
    {
        return false;
    }
    else
    {
        return true;
    }
}

function onBlurTextBox(id, value)
{
    if (isNaN(value))
    {
        $('#' + id).val('');
    }
}


function checkProduct(str, productid, productsizeid, quantity, user)
{
    //alert('#productitem_'+str);
    //$('#productitem_'+str).attr('checked', 'true');

    $('#Chkbutton_' + str).toggleClass('btnchk');
    if ($('#Chkbutton_' + str).hasClass('btnchk'))
    {
        var quantity = $('#productQuantity_' + str).val();

        if (quantity == '')
        {

            if ($('#Chkbutton_' + str).attr('checked') == true)
            {
                $('#Chkbutton_' + str).attr('checked', false);
            }

            $('#productquantity_errMsg_container_' + str).show();
            $('#productQuantity_' + str).focus();
            $('#productquantity_errMsg_' + str).html(ENTER_QUANTITY);
            $('#Chkbutton_' + str).toggleClass('btnchk');
            return false;
        }
        else
        {
            $('#productquantity_errMsg_container_' + str).hide();
            $('#productquantity_errMsg_' + str).html('');
            addProductToWholesellerCart(str, productid, productsizeid, quantity, user);
            return true;
        }
        $('#productQuantity_' + str).focus();
        //$('#productitem_'+str).checked=true;
        $('#productitem_' + str).attr('checked', 'true');
    }
    else
    {

        $('#productitem_' + str).attr('checked', false);
    }

}

function validate(str, productid, productsizeid)
{
    var quantity = $('#productQuantity_' + str).val();
    //alert(quan);
    if (quantity == '')
    {
        alert('Please Enter Quantity');
        $('#productquantity_errMsg_container_' + str).show();
        $('#productQuantity_' + str).focus();
        $('#productquantity_errMsg_' + str).html(ENTER_QUANTITY);

        return false;
    }
    else
    {
        $('#productquantity_errMsg_container_' + str).hide();
        $('#productquantity_errMsg_' + str).html('');
        addProductToWholesellerCart(str, productid, productsizeid, quantity, user);
        return true;
    }


}

function addWholesellerCartItem(argTotalCartProduct)
{
    var errorFlag = 0;
    var varFlag = 0;
    var CheckFlag = 1;
    for (i = 0; i < argTotalCartProduct; i++)
    {
        if ($('#productitem_' + i).attr('checked'))
        {
            var quantity = $('#productQuantity_' + i).val();
            if (quantity == '')
            {
                $('#productquantity_errMsg_container_' + i).show();
                $('#productquantity_errMsg_' + i).html(ENTER_QUANTITY);
                errorFlag = 1;
                //return false;
            }
            else if (isNaN(quantity))
            {

                $('#productquantity_errMsg_container_' + i).show();
                $('#productquantity_errMsg_' + i).html(ENTER_VALID_QUANTITY);
                errorFlag = 1;
            }
            else
            {
                $('#productquantity_errMsg_container_' + i).hide();
                $('#productquantity_errMsg_' + i).html('');
            }
            var CheckFlag = 0;
            //$('#frmWholesellerCart').submit();
            //return true;

        }
        else
        {
            varFlag = 1;
        }
    }
    if (varFlag == 1 && CheckFlag == 1)
    {
        alert(SEL_ONE_PRODUCT)
        return false;

    }
    else
    {
        if (errorFlag == 1)
        {
            return false;

        }
        else
        {
            $('#frmWholesellerCart').submit();
            return true;
        }


        //disablePopup('cart_popup');
    }


}



function search_validation()
{

    if ($('#SearchKeyword').val() == '')
    {

        $('#SearchKeyword_errMsg_container').show();
        $('#SearchKeyword_errMsg').html(ENTER_KEYWORD);
        return false;
    }
    else
    {

        $('#SearchKeyword_errMsg_container').hide();
        $('#SearchKeyword_errMsg').html('');
        return true;
    }
}

function validation_disable()
{
    $('#SearchKeyword_errMsg_container').hide();
    $('#SearchKeyword_errMsg').html('');
}






$(document).ready(function() {
    $('.wholesale .product_information li:first').css('color', '#cedff7');
    $('.wholesale .product_information li:last').css('color', '#cedff7');
});

function takeid(str)
{
    //alert(str);
    $('#currentproductname').val(str);
}


function addProductToCartByProductBYclick(argProductID, argProductSizeID, argProductQuantity, argProductName, argProductBrand, argCategoryID, argBrandID, argIsGiftSet, argSizeName, argProductCurrentStock, argProductprice)
{


    //alert(argProductSizeID);
    var varproductSizeId = $('#productSizeID').val();
    currnetStock = $('#Productquantity').val();

    if (varproductSizeId == '')
    {
        var currnetStock = argProductCurrentStock;
        $('#productSizeID').val(argProductSizeID);

        $('#ProductUniquePrice').val(argProductprice);
        $('#ProductSizeName').val(argSizeName);
    }
    var quantity = $("#cmbProductQuantity").val();
    var productSize = $("#cmbProductSizeID").val();

    //alert(productSize);
    //alert(currnetStock);
    // return false;

    $('#frmLowStock').hide();


    if (!argSizeName)
    {
        var sizeData = $("#productSizeData").val();
    } else
    {
        var sizeData = argSizeName;
    }

    $('#productQuantity').val(quantity);
    $('#productName').val(argProductName);
    $('#sizeData').val(sizeData);
    $('#productBrand').val(argProductBrand);
    $('#productCategoryID').val(argCategoryID);
    $('#productBrandID').val(argBrandID);
    $('#giftSet').val(argIsGiftSet);
    $('#productID').val(argProductID);
    $('#Productquantity').val(quantity);
    $('#Productoffline').val('no');
    //alert(varproductSizeId);

    //alert(argProductID+">>"+varproductSizeId+">>"+argProductQuantity+">>"+argProductName+">>"+argProductBrand+">>"+argCategoryID+">>"+argBrandID+">>"+argIsGiftSet+">>"+argSizeName);
    //return false;

    $('#frmAddProductToCart').submit();

}
function updateShoppingCartByClick(productId, str)
{

    //alert('#frmProductQuantity_'+str);
    $('#productQuantity_' + str).val(productId);
    $('#productoffline').val('1');
    $('#frmCartAction').val('update');
    $('#frmShoppingCart').submit();
}

//////function to show condition

function ShowCondition(argProductID, argSelectedSize)
{
    //alert(argSelectedSize);
    var params = {'function': 'getSizesCondition'};
    params['sizeID'] = argSelectedSize;
    params['productId'] = argProductID;
    $('.loadingprice').show();
    $('#RetailpriceId').hide();
    $('#withsale').hide();

    $.post(SITE_ROOT_URL + 'common/ajax/ajax.php', params, function(data) {
        if (data)
        {
            //alert(data);

            //return false;
            $("#cmbProductCondition").html('');
            $("#cmbProductCondition").html(data);
            //$("#cmbProductCondition").html(data).show();
            var noOptions = $('#cmbProductCondition option').length;
            //alert(noOptions);
            if (noOptions == 1)
            {

                //$('#cmbProductCondition').text($(option).text());
                var opt = document.getElementById("cmbProductCondition").options[0].text;
                $("#singleCondition").text('');
                $("#singleCondition").text(': ' + opt);
                $("#multipleCondition").hide();
                $("#singleCondition").show();
            }
            else
            {
                $("#cmbProductCondition").html(data).show();
                $("#multipleCondition").show();
                $("#singleCondition").hide();
            }
            //alert( $('#cmbProductCondition option').length)
            var element = document.getElementById("cmbProductCondition").options[0].value;
            $('#Productcondition').val(element);
            //alert(element)
            if (element == 3)
            {
                $('#testerbox').show();
                $('#ProductCondition').val('Tester');
                //return false;
            }
            var argProductstatus = document.getElementById('sizeconditionStatus_' + argSelectedSize + element).value;
            if (argProductstatus == 'Offline')
            {
                $('.selve').show();
                $('#RedButton').hide();
                $('#GreyButton').show();
            }
            else
            {
                $('.selve').hide();
                $('#RedButton').show();
                $('#GreyButton').hide();
            }
            ShowColorFromSize(argSelectedSize, element);
            calculatePriceOnSize(argProductID, argSelectedSize, element);
            //$("#cmbProductColor").html('<option value="">Select</option>');

            return true;

        }

    });
}


function ShowColor(argconditionId)
{

    //alert(argconditionId);
    //alert(argconditionId);
    if (argconditionId == 3)
    {

        $('#testerbox').show();
        $('#ProductCondition').val('Tester');
    }
    else
    {
        $('#testerbox').hide();
        $('#ProductCondition').val('');
    }

    $('.loadingprice').show();
    $('#RetailpriceId').hide();
    $('#withsale').hide();
    //alert("test");
    // $('#ProductCondition').val('');
    var argProductID = document.getElementById('productID').value;
    //alert(argProductID);
    var argproductSizeId = document.getElementById('varproductSizeIDOnchange').value;
    //alert('sizeconditionStatus_'+argproductSizeId+argconditionId);
    var argProductStatus = document.getElementById('sizeconditionStatus_' + argproductSizeId + argconditionId).value;

    //alert(argProductID);
    //alert(argproductSizeId);
    //alert(argProductStatus);
    //return false;
    $('#Productcondition').val(argconditionId);
    if (argProductStatus == 'Offline')
    {
        $('.selve').show();
        $('#RedButton').hide();
        $('#GreyButton').show();
    }
    else
    {
        $('.selve').hide();
        $('#RedButton').show();
        $('#GreyButton').hide();
    }
    var params = {'function': 'getSizesColor'};
    //params['sizeID'] = argSelectedSize;
    params['productId'] = argProductID;
    params['conditionId'] = argconditionId;
    params['SizeId'] = argproductSizeId;


    $.post(SITE_ROOT_URL + 'common/ajax/ajax.php', params, function(data) {
        if (data)
        {

            $("#cmbProductColor").html('');
            $("#cmbProductColor").html(data).show();

            $('#singleColor').hide();
            $('#multipleColor').show();

            var noColorOptions = $('#cmbProductColor option').length;
            //alert(noColorOptions);
            if (noColorOptions == 2)
            {

                //$('#cmbProductCondition').text($(option).text());
                var opt = document.getElementById("cmbProductColor").options[1].text;
                //alert(opt);
                $('#Productcolor').val(opt);
                $("#singleColor").text('');
                $("#singleColor").text(': ' + opt);
                $("#multipleColor").hide();
                $("#singleColor").show();
            }
            else
            {
                $('#Productcolor').val('');
            }
            calculatePrice(argProductID, argproductSizeId, argconditionId);
            return true;

        }

    });
}
function ShowColorFromSize(argSelectedSize, argConditionId)
{
    //alert(argConditionId);
    //$('.loadingprice').show();
    //$('#RetailpriceId').hide();
    //$('#withsale').hide();
    //$('#testerbox').hide();
    if (argSelectedSize == 3)
    {
        $('#ProductCondition').val('Tester');
    }
    else
    {
        //$('#ProductCondition').val('');
    }

    var argProductID = document.getElementById('productID').value;
    var argproductSizeId = document.getElementById('varproductSizeIDOnchange').value;

    //alert(argConditionId);
    var params = {'function': 'getColorOnSizeChange'};
    //params['sizeID'] = argSelectedSize;
    params['productId'] = argProductID;
    //params['conditionId'] = argconditionId;
    params['SizeId'] = argSelectedSize;
    params['ConditionId'] = argConditionId;
    //var totalColor=gettotalcolor(argProductID,argSelectedSize);
    //alert('totalColor'+totalColor);
    $.post(SITE_ROOT_URL + 'common/ajax/ajax.php', params, function(data) {
        if (data)
        {
            //alert(data);
            $('#singleColor').hide();
            $('#multipleColor').show();

            $("#cmbProductColor").html('');
            $("#cmbProductColor").html(data).show();
            var noColorOptions = $('#cmbProductColor option').length;
            //var colorid=document.getElementById("cmbProductColor").options[1].value;

            //alert(noColorOptions);
            if (noColorOptions == 2)
            {

                //$('#cmbProductCondition').text($(option).text());
                var opt = document.getElementById("cmbProductColor").options[1].text;
                //alert(opt);
                $('#Productcolor').val(opt);
                $("#singleColor").text('');
                $("#singleColor").text(': ' + opt);
                $("#multipleColor").hide();
                $("#singleColor").show();
            }
            else
            {
                $('#Productcolor').val('');
            }

            //calculatePrice(argProductID,argproductSizeId,argconditionId);
            return true;

        }

    });
}

function calculatePrice(argProductID, argproductSizeId, argconditionId)
{



    var params = {'function': 'getSizesprice'};
    //params['sizeID'] = argSelectedSize;
    params['productId'] = argProductID;
    params['conditionId'] = argconditionId;
    params['SizeId'] = argproductSizeId;


    $.post(SITE_ROOT_URL + 'common/ajax/ajax.php', params, function(data) {
        if (data)
        {
            //alert(data);
            //return false;
            var myObject = eval('(' + data + ')');
            obj = JSON.parse(data);
            var retailPrice = myObject.retailprice;
            var ourPrice = myObject.ourprice;
            var salePrice = myObject.saleprice;
            var pkProductSizeID = myObject.pkProductSizeID;
            var productQuantity = myObject.productQuantity;
            var productSizeName = myObject.SizeName;
            //alert(productQuantity);
            $('#RetailpriceId').text("Retail: $" + retailPrice);
            $('#ProductpriceId').text("Our Price: $" + ourPrice);
            $('#SalepriceId').text("Sale Price: $" + salePrice);
            $('#WithoutProductpriceId').text("Our Price: $" + ourPrice);
            $('#productSizeID').val(pkProductSizeID);
            $('#ProductSizeName').val(productSizeName);
            $('#ProductUniquePrice').val(salePrice);
            // $('#Productquantity').val(quantity);
            $('#ProductchangedValues').val('1');
            $('#Productquantity').val(productQuantity);


            if (salePrice == '0.00')
            {
                $('.loadingprice').hide();
                $('#withsale').hide();
                $('#withoutsale').show();
                $('#RetailpriceId').show();
                $('.discount').hide();
                $('.per').hide();


            }
            else
            {
                $('.loadingprice').hide();
                $('#withsale').show();
                $('#withoutsale').hide();
                $('#RetailpriceId').show();
                $('.discount').show();
                $('.per').show();
                $('.right').show();
            }

            if (parseInt(retailPrice) > parseInt(salePrice))
            {

                var Save = parseInt(retailPrice) - parseInt(salePrice);
                var Savepercentage = (Save / retailPrice) * 100;
                var Percenatge = Math.round(Savepercentage);
            }
            else
            {
                Percenatge = '0';
            }
            //alert("Percenatge"+Percenatge);

            $('.two').text(Percenatge + '%');
            $('.per').text("YOU SAVE " + Percenatge + "% OFF RETAIL");
            return true;

        }

    });
}

function calculatePriceOnSize(argProductID, argproductSizeId, argConditionId)
{



    var params = {'function': 'getPriceOnSizes'};
    //params['sizeID'] = argSelectedSize;
    params['productId'] = argProductID;
    //params['conditionId'] = argconditionId;
    params['SizeId'] = argproductSizeId;
    params['ConditionId'] = argConditionId;
    //alert(argConditionId);

    $.post(SITE_ROOT_URL + 'common/ajax/ajax.php', params, function(data) {
        if (data)
        {

            var myObject = eval('(' + data + ')');
            obj = JSON.parse(data);
            var retailPrice = myObject.retailprice;
            var ourPrice = myObject.ourprice;
            var salePrice = myObject.saleprice;
            var pkProductSizeID = myObject.pkProductSizeID;
            var productQuantity = myObject.productQuantity;
            var productSizeName = myObject.SizeName;
            //alert(productQuantity);
            $('#RetailpriceId').text("Retail: $" + retailPrice);
            $('#ProductpriceId').text("Our Price: $" + ourPrice);
            $('#SalepriceId').text("Sale Price: $" + salePrice);
            $('#WithoutProductpriceId').text("Our Price: $" + ourPrice);
            $('#productSizeID').val(pkProductSizeID);
            $('#ProductSizeName').val(productSizeName);
            $('#ProductUniquePrice').val(salePrice);
            // $('#Productquantity').val(quantity);
            $('#ProductchangedValues').val('1');
            $('#Productquantity').val(productQuantity);

            if (salePrice == '0.00')
            {
                $('.loadingprice').hide();
                $('#withsale').hide();
                $('#withoutsale').show();
                $('#RetailpriceId').show();
                $('.discount').hide();
                $('.per').hide();


            }
            else
            {
                $('.loadingprice').hide();
                $('#withsale').show();
                $('#withoutsale').hide();
                $('#RetailpriceId').show();
                $('.discount').show();
                $('.per').show();
                $('.right').show();
            }

            if (parseInt(retailPrice) > parseInt(salePrice))
            {

                var Save = parseInt(retailPrice) - parseInt(salePrice);
                var Savepercentage = (Save / retailPrice) * 100;
                var Percenatge = Math.round(Savepercentage);
            }
            else
            {
                Percenatge = '0';
            }
            //alert("Percenatge"+Percenatge);

            $('.two').text(Percenatge + '%');
            $('.per').text("YOU SAVE " + Percenatge + "% OFF RETAIL");
            return true;

        }

    });
}
function sendReviews()
{
    if ($('#frmProductComments').val() == '')
    {


        $('#SenderComments_errMsg_container').show();
        $('#SenderComments_errMsg').html(ENTER_COMMENTS);
        errorFlag = 1;
    }
    else
    {
        $('#SenderComments_errMsg_container').hide();
        $('#SenderComments_errMsg').html('');
    }
    if (errorFlag)
    {
        return false;
    }
    else
    {
        return true;
    }
}

function gettotalcolor(argProductID, argSelectedSize)
{
    var params = {'function': 'gettotalcolor'};
    params['productId'] = argProductID;
    params['SizeId'] = argSelectedSize;

    $.post(SITE_ROOT_URL + 'common/ajax/ajax.php', params, function(data) {
        if (data)
        {
            //alert(data);

            return data;

        }

    });
}

$(document).ready(function()
{
    $('#addButton').click(function()
    {

        var ElementCount = $('#noOffriends').val();
        var $ctrl = $('<input/>').attr({type: 'text', name: 'text', value: 'text'}).addClass("text");
        //var newTextBoxDiv = $(document.createElement('div')).attr("id", 'TextBoxDiv' + ElementCount);

        //newTextBoxDiv.after().html('this is for testr');
        $("#newRows").append($ctrl);
        newTextBoxDiv.appendTo("#newRows");
        //alert(ElementCount);

    }
    );

}

);