jQuery(document).ready(function(){
    // binds form submission and fields to the validation engine
    //jQuery("#frmReview").validationEngine();
    jQuery("#frmRecommendform").validationEngine();
});

$(document).ready(function(){
    $('.tab_container').hide();
    $('.tab_container:first').show();
    $('ul.tab li:first').addClass('active');
    $('ul.tab li a').click(function(){
        $('ul.tab li').removeClass('active');
        $(this).parent().addClass('active');

        var currentTab = $(this).attr('href');
        $('.tab_container').hide();
        $(currentTab).show();
        $('.scroll-pane').jScrollPane();
        return false;
    });

    $('.check_box .GetAttributeValues[type="radio"]').each(function(){
        $(this).click(function(){
            if(this.checked == true){
                $(this).parent().find('.formError').hide();
            }else{
                $(this).parent().find('.formError').show();
            }
        });
    });

    $('.select_color_sec textarea').each(function(){
        $(this).keyup(function(){
            if($(this).val() != ''){
                $(this).parent().find('.formError').hide();
            }else{
                $(this).parent().find('.formError').show();
            }
        });
    });

    $('.drop_down2').sSelect();
    $('.scroll-pane').jScrollPane();
    rightSideCartwidth();

    $('.jqzoom').jqzoom({
        zoomType: 'standard',
        lens:true,
        preloadImages: false,
        alwaysOn:false
    });

    /*$('#thumblist').jcarousel();*/
    $('.left_product_gradient .left_products_sec .product_img .jcarousel-clip ul').each(function(i){
        $(this).jcarousel();
    });

});



function RemoveProductFromCompare(id){ //alert('test');return false;
    $.post(SITE_ROOT_URL+'common/ajax/ajax_compare.php',{
        action:'RemoveProductFromCompare',
        pid:id
    },function(data){ //alert(data);
        $.trim($(data).find('.heading1').html())=="Compare Products  (0)"?$('#ajaxAddToCompare').html(''):$('#ajaxAddToCompare').html(data);
        var pid = $('#frmProductId'+id).val();
        if(pid==id)
        {
            $('#CompareCheckBox'+id+' .checkbox').css('background-position','0px 0px');
            document.getElementById('addtoCompareCheckBox'+id).checked = false;
        }
        $('#addtoCompareMessage'+id).html('&nbsp; '+REMOVE_COMPARE_SUCC);
        setTimeout(function(){
            $('#addtoCompareMessage'+id).html('&nbsp')
        },4000);
        goToByScroll('ajaxAddToCompare');
    });


}

function goToByScroll(id){
    // Remove "link" from the ID
    id = id.replace("link", "");
    // Scroll
    $('html,body').animate({
        scrollTop: $("#"+id).offset().top
    },
    'slow');
}

function addToCompare(id,catid){ //alert('test');
    $('.succCart').hide();
    $('#addtoCompareMessage'+id).show();
    $.post(SITE_ROOT_URL+'common/ajax/ajax_compare.php',{
        action:'addToCompare',
        pid:id,
        cid:catid
    },function(data){
        if(data=='4'){
            //$('#addtoCompareMessage'+id).html('&nbsp; '+ADD_COMPARE_MAX_ERROR);
            alert(ADD_COMPARE_MAX_ERROR);
        }else if(data=='already'){
            $('#addtoCompareMessage'+id).html('<span class="red">'+ALREADY_COMPARE_LIST+'</span>');
            setTimeout(function(){
                $('#addtoCompareMessage'+id).html('&nbsp');
            },4000);
            setTimeout(function(){
                goToByScroll('ajaxAddToCompare');
            },4000);
        }else if(data=='notSameCategory'){
            $('#addtoCompareMessage'+id).html('<span class="red">'+NOT_SAME_CATE+'</span>');
            setTimeout(function(){
                $('#addtoCompareMessage'+id).html('&nbsp');
            },4000);
            setTimeout(function(){
                goToByScroll('ajaxAddToCompare');
            },4000);
        }else{
            $('#ajaxAddToCompare').html(data);
            $('#addtoCompareMessage'+id).html(ADD_COMPARE_SUCC);
            setTimeout(function(){
                $('#addtoCompareMessage'+id).html('&nbsp');
            },4000);
            setTimeout(function(){
                goToByScroll('ajaxAddToCompare');
            },4000);

        //goToByScroll('ajaxAddToCompare');
        }
    });
}


function addToCompareToggleId(id){
    var arr = $('#CompareCheckBox'+id+' .checkbox').css('backgroundPosition').split(" ");
    if (document.getElementById('addtoCompareCheckBox'+id).checked == true) {
        addToCompare(id);
    }
    else
    {
        RemoveProductFromCompare(id);

    }
}


function addToWishlist(prodid){
    $('#addtoCompareMessage'+prodid).hide();
    $('.succCart').show();
  
    $.post(SITE_ROOT_URL+'common/ajax/ajax_compare.php',{
        action:'addToWishlist',
        pid:prodid
    },function(data){
        $('#addtoCompareMessage'+prodid).html('&nbsp; '+ADD_WISHLIST_SUCC);
        setTimeout(function(){
            $('#addtoCompareMessage'+prodid).html('&nbsp')
        },4000);
    });
}

function RemoveProductFromWishlist(prodid)
{
    $.post(SITE_ROOT_URL+'common/ajax/ajax_compare.php',{
        action:'removeToWishlist',
        pid:prodid
    },function(data){
        $('#addtoCompareMessage'+prodid).html('&nbsp; '+REMOVED_WISHLIST_SUCC);
        setTimeout(function(){
            $('#addtoCompareMessage'+prodid).html('&nbsp')
        },4000);
    });
}

function addToWishlistToggleId(pid){

    $('#addtoWishListCheckBox'+pid).attr("checked")?$('#addtoWishListCheckBox'+pid).removeAttr("checked"):$('#addtoWishListCheckBox'+pid).prop('checked', true);
    if ($('#addtoWishListCheckBox'+pid).attr("checked")) {
        addToWishlist(pid);
    }
    else
    {
        RemoveProductFromWishlist(pid);
    }
}


function addToProductCart(id){
    var arraymerg = [];
    var checkId = [];
    var radioId = [];
    var numcount = 0;
    var all_att_val = $('#all_att_val').val();
    var quantity = $("#frmQuantity").val();
    var optPriceids='';

    if(all_att_val !="")
    {
        var attAry = all_att_val.split(';');
        for(var i = 0 ; i < attAry.length ; ++i)
        {
            var attAry2 = attAry[i].split(':');
            var counter = 0;

            //checkbox
            if(attAry2[1]=='checkbox')
            {
                $('input:checkbox[name=frmAttribute_'+attAry2[0]+']').each(function(i)
                {
                    if($(this).is(':checked'))
                    {
                        checkId[i] = $(this).val();
                        optPriceids += $(this).val()+',';
                        counter ++;
                    }
                });
                arraymerg[numcount] = attAry2[0]+':'+checkId.join(",")+':';
                numcount++;
            }

            //Redio button

            if(attAry2[1]=='radio' || attAry2[1]=='image')
            {
                $('input:radio[name=frmAttribute_'+attAry2[0]+']').each(function()
                {
                    if($(this).is(':checked'))
                    {
                        radioId = $(this).val();
                        optPriceids += $(this).val()+',';
                        counter ++;
                    }
                });

                arraymerg[numcount] = attAry2[0]+':'+radioId+':';
                numcount++;
            }


            //textArea
            if(attAry2[1]=='textarea')
            {
                var val2 = $('textarea[name=frmAttribute_'+attAry2[0]+']').val();
                if(val2 !="")
                {
                    counter ++;

                }

                arraymerg[numcount] = attAry2[0]+':'+':'+val2;
                numcount++;
            }

            //select box
            if(attAry2[1]=='select')
            {

                var val1 = $('#frmAttribute_'+attAry2[0]+' :selected').val();
                if(val1 !="")
                {
                    optPriceids += val1+',';
                    counter ++;
                }

                arraymerg[numcount] = attAry2[0]+':'+val1+':';
                numcount++;
            }

            //text
            if(attAry2[1]=='text')
            {
                var val3 = $('#frmAttribute_'+attAry2[0]).val();
                if(val3 !="")
                {
                    counter ++;

                }
                arraymerg[numcount] = attAry2[0]+':'+':'+val3;
                numcount++;
            }

            if(counter==0)
            {
                var error = errorMessageCartAdd();
                $('.errorBox_'+attAry2[0]).html(error);
                return false;
            }

            else
            {
                $('.errorBox_'+attAry2[0]).html('');
            }

        }
    }

    var quantity = parseInt($("#frmQuantity").val());
    if(quantity<=0 || isNaN(quantity))
    {
        var error = errorMessageCartAdd();
        $('.errorQuantity').html(error);
        return false;
    }

    else
    {
        $('.errorQuantity').html('');
    }

    //AtrrFormate-> #AttributeId : optionId : optionValue#
    var AttrFormate = arraymerg.join('#');
    //alert(AttrFormate);
    $.post(SITE_ROOT_URL+'common/ajax/ajax_cart.php',{
        action:'addToProductCart',
        pid:id,
        qty:quantity,
        attrFormate:AttrFormate,
        optIds:optPriceids,
        page:'pro'
    },function(data){
        // alert(data);return false;
        addToAjaxCartValue();//$("#cartValue").html(parseInt($("#cartValue").text())+1);
        addToAjaxCart();
        addToAjaxCartHeader();
        $(".scroll-pane").jScrollPane();
        // $('.addToCartMess').show();
        $('#addtoCompareMessage'+id).html('&nbsp;'+data);
        // $('.addToCartMess').html(data);
        setTimeout(function(){
            //$('.addToCartMess').show();
            $('#addtoCompareMessage'+id).html('&nbsp;');
        },4000);

        //        setTimeout(function(){
        //            goToByScroll('idAddToProductCart');
        //        },2000);

        $('#frmQuantity').val('1');
        $('.scroll-pane').jScrollPane();
        // setTimeout(function(){
        rightSideCartwidth();
    // },500);

    });
}


function RemoveProductFromCart(id,val,index){ 
    $('#cart'+id).html('');
    $.post(SITE_ROOT_URL+'common/ajax/ajax_cart.php',{
        action:'RemoveProductFromCartOnBox',
        pid:id,
        index:index
    },function(data){
        $('#cartValue').html(parseInt($('#cartValue').text())-parseInt(val));
        //$('.addToCartMsg').html(data);
        $('#idAddToProductCart').html(data);
        $('.scroll-pane').jScrollPane();
        rightSideCartwidth();
        location.reload();
    /* var dt = data.split(',');
                $('#myCartMassage').html('&nbsp;Success: You have Removed <a href="product.php?pid='+id+'">'+dt[1]+'</a> from your <a href="shopping_cart.php">shopping cart</a>!<img src="common/images/close.png" onclick="closeCartMassage();" width="15" height="15" alt="Close" style="cursor: pointer; float: right; padding: 2px;" />');
                  $('#cartValue').html(dt[0]);
                  //if(dt[0]==0){
                      location.reload();
                  //}

                setTimeout(function(){$('#myCartMassage').html('')},4000); */
    });


}
/*function jscall_recommend(id){
    $(".recommend").colorbox({
        inline:true,
        width:"600px"
    });
    $('#recommend_cancel').click(function(){
        parent.jQuery.fn.colorbox.close();
    });
// addToRecommend(id);
};*/

function addToRecommend(id){
    //alert(id);
    $.post(SITE_ROOT_URL+'common/ajax/ajax_compare.php',{
        action:'addToRecommend',
        pid:id
    },function(data){
        $('#ajaxAddToRecommend').html(data);
    });
}

function goToByScrollClass(cls){
    // Remove "link" from the ID
    cls = cls.replace("link", "");
    // Scroll
    $('html,body').animate({
        scrollTop: $("."+cls).offset().top
    },
    'slow');
}


function addToPackage(id){
    var quantity = 1;
    var AllAttrFormate = '';
    var count = 0;
    var totalProd = $('.left_products_sec').length;

    $('.left_products_sec').each(function(){
        var arraymerg = [];
        var checkId = [];
        var radioId = [];
        var numcount = 0;
        var all_att_val = $(this).find('.all_att_val').val();
        var prod_id = $(this).find('.proId').val();
        var quantity = 1;
        if(all_att_val !="")
        {
            var attAry = all_att_val.split(';');
            for(var i = 0 ; i < attAry.length ; ++i)
            {
                var attAry2 = attAry[i].split(':');
                var counter = 0;

                //checkbox
                if(attAry2[1]=='checkbox')
                {
                    $(this).find('input:checkbox[name=frmAttribute_'+attAry2[0]+'_'+prod_id+']').each(function(i)
                    {
                        if($(this).is(':checked'))
                        {
                            checkId[i] = $(this).val();
                            counter ++;
                        }
                    });
                    arraymerg[numcount] = attAry2[0]+':'+checkId.join(",")+':';
                    numcount++;
                }

                //Redio button

                if(attAry2[1]=='radio' || attAry2[1]=='image' )
                {
                    $(this).find('input:radio[name=frmAttribute_'+attAry2[0]+'_'+prod_id+']').each(function()
                    {
                        if($(this).is(':checked'))
                        {
                            radioId = $(this).val();
                            counter ++;
                        }
                    });

                    arraymerg[numcount] = attAry2[0]+':'+radioId+':';
                    numcount++;
                }


                //textArea
                if(attAry2[1]=='textarea')
                {
                    var val2 = $(this).find('textarea[name=frmAttribute_'+attAry2[0]+'_'+prod_id+']').val();
                    if(val2 !="")
                    {
                        counter ++;

                    }

                    arraymerg[numcount] = attAry2[0]+':'+':'+val2;
                    numcount++;
                }

                //select box
                //alert(attAry2[1]);
                if(attAry2[1]=='select')
                {

                    var val1 = $(this).find('.frmAttribute_'+attAry2[0]+'_'+prod_id).val();
                    if(val1 !="")
                    {
                        counter ++;
                    }

                    arraymerg[numcount] = attAry2[0]+':'+val1+':';
                    numcount++;
                }

                //text
                if(attAry2[1]=='text')
                {
                    var val3 = $(this).find('.frmAttribute_'+attAry2[0]+'_'+prod_id).val();
                    if(val3 !="")
                    {
                        counter ++;

                    }
                    arraymerg[numcount] = attAry2[0]+':'+':'+val3;
                    numcount++;
                }

                if(counter==0)
                {
                    $(this).find('.errorBox_'+attAry2[0]).css('display','block');
                    goToByScrollClass('errorBox_'+attAry2[0]);
                    return false;
                }

                else
                {
                    $(this).find('.errorBox_'+attAry2[0]).css('display','none');
                }

            }
        }
        var AttrFormate = arraymerg.join('#');
        AllAttrFormate += prod_id+'$'+AttrFormate+'|';
        count++;
    });
    if(count == totalProd)
    {
        $.post(SITE_ROOT_URL+'common/ajax/ajax_cart.php',{
            action:'addToPackage',
            pkPackageId:id,
            qty:quantity,
            attrFormate:AllAttrFormate
        },function(data){
            addToAjaxCartValue();//$("#cartValue").html(parseInt($("#cartValue").text())+1);
            addToAjaxCart();
            addToAjaxCartHeader();

            $('.scroll-pane').jScrollPane();
            $('#cartValue').html(parseInt($('#cartValue').text())+parseInt(quantity));
            $('.addToCartMsg').html(data);
            $('#idAddToProductCart').html(data);
            $('.successMessage').show();
            $('.success').show();
            goToByScrollClass('successMessage');

            setTimeout(function(){
                $('.success').hide();
            },10000);
            $('.scroll-pane').jScrollPane();
            rightSideCartwidth();
        //  $('#outerContainer').css('position','inherit');
        //$('.addToCart').css('display','block');

        });
    }
}


function RemovePackageFromCart(id,val,pkgIndex){
    $('#RemoveFromCartPkg'+id).html('');
    $.post(SITE_ROOT_URL+'common/ajax/ajax_cart.php',{
        action:'RemovePackageFromCartOnBox',
        pid:id,
        pkgIndex: pkgIndex
    },function(data){
        $('#cartValue').html(parseInt($('#cartValue').text())-parseInt(val));
        $('.addToCartMsg').html(data);
        $('#idAddToProductCart').html(data);
        $('.scroll-pane').jScrollPane();
        rightSideCartwidth();
    });
}
function RemoveGiftCardFromCart(id,val)
{
    $('#RemoveGiftCard'+id).html('');
    $.post(SITE_ROOT_URL+'common/ajax/ajax_cart.php',{
        action:'RemoveGiftCardFromCartOnBox',
        pid:id
    },function(data){
        var qunt = parseInt($('#cartValue').text())-parseInt(val);
        if(isNaN(qunt))
        {
            var qnt = 0;
        }
        else
        {
            var qnt = qunt;
        }
        $('#cartValue').html(qnt);
        $('.addToCartMsg').html(data);
        $('#idAddToProductCart').html(data);
        $('.scroll-pane').jScrollPane();
        rightSideCartwidth();
    });
}


$(document).ready(function(){
    //Examples of how to assign the Colorbox event to elements


    $(".vimeo_review").colorbox({
        iframe:true,
        innerWidth:500,
        innerHeight:409
    });

    //Example of preserving a JavaScript event for inline calls.
    $("#click").click(function(){
        $('#click').css({
            "background-color":"#f00",
            "color":"#fff",
            "cursor":"inherit"
        }).text(OPEN_THIS_WINDOW);
        return false;
    });


});

$(document).ready(function(){
    $('#cancelSus').click(function(){
        parent.jQuery.fn.colorbox.close();
    });
});
//Rating of a product starts from here
function rate_value(rval,url)
{
    //var pid = $('#frmProductId').val();
    $('.rating .error_msg_rate').hide();
    $('#frmProductRateVal').val(rval);
    $('#ajax_rating a img').attr('src',url+'star0.png');
    for(var i=1;i<=rval;i++)
    {
        $('#ajax_rating a img#star0_'+i).attr('src',url+'star1.png');
    }

//    $.post(SITE_ROOT_URL+'common/ajax/ajax_compare.php',{
//        action:'AddRating',
//        pid:pid,
//        val:rval
//    },function(data){
//        $('#ajax_rating').html(data);
//        $('#ajaxRatingMessage').html("&nbsp; "+THANK_FOR_RATING);
//        setTimeout(function(){
//            $('#ajaxRatingMessage').html('&nbsp')
//        },4000);

//    });

}
function jscall_star(val,url){
    $('.rating .error_msg_rate').hide();
    $('#frmProductRateVal').val(val);
    $('#ajax_rating a img').attr('src',url+'star0.png');
    for(var i=1;i<=val;i++)
    {
        $('#ajax_rating a img#star0_'+i).attr('src',url+'star1.png');
    }

//    $(".star_color"+val).colorbox({
//        inline:true,
//        width:"500px",
//        height:"290px"
//    });
//    $('#cancelSus'+val).click(function(){
//        parent.jQuery.fn.colorbox.close();
//    });
//    $('#frmConfirmStar'+val).live('click',function(){
//        //alert(val);
//        var pid = $('#frmProductId').val();
//        $.post(SITE_ROOT_URL+'common/ajax/ajax_compare.php',{
//            action:'UpdateRating',
//            pid:pid,
//            val:val
//        },function(data){
//  parent.jQuery.fn.colorbox.close();
//            $('#ajax_rating').html(data);
//            $('#ajaxRatingMessage').html("&nbsp; "+THANK_FOR_RATING);
//            setTimeout(function(){
//                $('#ajaxRatingMessage').html('&nbsp')
//            },4000);

//        });
//    });
}
//Rating of a product ends here
$(document).ready(function(){
    $('#reviewId').click(function(){
        var frmMessage = $('#frmMessage').val();
        $('.error_msg').html('');
        if(frmMessage == "")
        {
            $('.error_msg').css('display','block');
            var error = errorMessageReview('');
            $('.error_msg').html(error);
            $('#frmMessage').focus();
            return false;
        }
        else
        {
            $('.error_msg').html('');
        }
        var frmProductId = $('#frmProductId').val();
        var reviewUrl = $('#frmReviewUrl').val();
        var reviewUpdateUrl = reviewUrl+'&frmProductId='+frmProductId+'&frmMessage='+frmMessage;
        $('#reviewId').attr("href",reviewUpdateUrl);

    });


});


function ajax_review()
{
    var frmMessage = $.trim($('#frmMessage').val());
    var frmRateStar = $.trim($('#frmProductRateVal').val());
    var frmProductId = $.trim($('#frmProductId').val());
    $('.error_msg').html('');
    $('.error_msg_rate').html('');
    if(frmRateStar == "" || frmRateStar == 0)
    {       
        var error3 = errorMessageRate('');
        $('.error_msg_rate').html(error3);
        $('#frmMessage').focus();
        return false;
    }
    if(frmMessage == "")
    {
        $('.error_msg').css('display','block');
        var error2 = errorMessageReview('');
        $('.error_msg').html(error2);      
        $('#frmMessage').focus();
        return false;
    }
  

    $.post(SITE_ROOT_URL+'common/ajax/ajax_compare.php',{
        action:'AddToReview',
        frmMessage:frmMessage,
        frmProductId:frmProductId,
        frmRateStar:frmRateStar
    },function(data){
        $('#show_review').html(data);
        $('#frmMessage').val('');
        //        $('#showReviewMessage').html(SUBMITTED_REVIEW);
        $('#reviewSuccessMsg').html(SUBMITTED_REVIEW);
        setTimeout(function(){
            $('#showReviewMessage').html('');
            location.reload();
        },2000);

    });

//return false;
}


function reviewDelete(rid,pid)
{
    var t = confirm(R_U_SURE_DELETE);
    if(t==true)
    {
        $.post(SITE_ROOT_URL+'common/ajax/ajax_compare.php',{
            action:'deleteReview',
            rid:rid,
            pid:pid
        },function(data){
            $('#show_review').html(data);
            $('#frmMessage').val('');
            $('#showReviewMessage').html('&nbsp; '+REVIEW_DELETED);
            setTimeout(function(){
                $('#showReviewMessage').html('&nbsp')
            },4000);

        });

    }

}
function review_edit(val){
    $(".reviewEdit"+val).colorbox({
        inline:true,
        width:"500px",
        height:"290px"
    });
    $('#cancelUpdate'+val).click(function(){
        parent.jQuery.fn.colorbox.close();
    });
}

function confirmUpdate(val){

    var str = $('#ReviewMsg'+val).val();
    var pid = $('#ReviewProductId'+val).val();
    $.post(SITE_ROOT_URL+'common/ajax/ajax_compare.php',{
        action:'UpdateReview',
        rid:val,
        review:str,
        pid:pid
    },function(data){
        parent.jQuery.fn.colorbox.close();
        $('#show_review').html(data);
        $('#showReviewMessage').html('&nbsp; '+REVIEW_EDIT);
        setTimeout(function(){
            $('#showReviewMessage').html('&nbsp')
        },4000);

    });
}
function showProductPrice(sizeID)
{

    var params = {
        'function': 'showProductPrice'
    };
    params['sizeID'] = sizeID;

    $.post(SITE_ROOT_URL + 'common/ajax/ajax.php', params, function (data){
        if(data != 0)
        {
            arrData = data.split('||');
            $("#ourPriceRow").html('$'+arrData[0]);
            $("#retailPriceRow").html('$'+arrData[1]);
            $("#productSizeData").val(arrData[2]);
            return true;
        }
        else
        {
            //$("#mailingListEmail_successMsg").html('Error in DB insert.').show();
            return false;
        }
    });


}

function showRateBOx()
{

    $('#ratingContainer').toggle();
/*if($('#productRateValue').is(':visible'))
	{
		$('#ratingContainer').hide();
	}
	else
	{
		$('#ratingContainer').show();
	}*/
}

function errorMessageRate(){
    var errMsg = '* '+required;
    return '<div style="opacity: 0.87; position: absolute; top: -53px; left: 173px;" class="formError"><div class="formErrorContent">'+errMsg+'<br/></div><div class="formErrorArrow"><div class="line10"><!-- --></div><div class="line9"><!-- --></div><div class="line8"><!-- --></div><div class="line7"><!-- --></div><div class="line6"><!-- --></div><div class="line5"><!-- --></div><div class="line4"><!-- --></div><div class="line3"><!-- --></div><div class="line2"><!-- --></div><div class="line1"><!-- --></div></div></div>';

}

function errorMessageReview(){
    var errMsg = '* '+required;
    return '<div style="opacity: 0.87; position: absolute; top: 0px; margin-top: 83px; left: 632px;" class="formError"><div class="formErrorContent">'+errMsg+'<br/></div><div class="formErrorArrow"><div class="line10"><!-- --></div><div class="line9"><!-- --></div><div class="line8"><!-- --></div><div class="line7"><!-- --></div><div class="line6"><!-- --></div><div class="line5"><!-- --></div><div class="line4"><!-- --></div><div class="line3"><!-- --></div><div class="line2"><!-- --></div><div class="line1"><!-- --></div></div></div>';

}

function errorMessageCartAdd(){
    var errMsg = '* '+required;
    return '<div class="formError" style="opacity: 0.87; position:inherit; top: 180px; display: block; margin-top: 0px; left: 164px;"><div class="formErrorContent">'+errMsg+'<br></div><div class="formErrorArrow"><div class="line10"><!-- --></div><div class="line9"><!-- --></div><div class="line8"><!-- --></div><div class="line7"><!-- --></div><div class="line6"><!-- --></div><div class="line5"><!-- --></div><div class="line4"><!-- --></div><div class="line3"><!-- --></div><div class="line2"><!-- --></div><div class="line1"><!-- --></div></div></div>';
}

function rightSideCartwidth(){
    setTimeout(function(){
        if($('.my_cart').html()!=undefined){
            if($('.my_cart .my_cart_inner').find('.jspScrollable').html()==undefined){
                $('.my_cart .my_cart_inner ul').css('width','169px');
                $('.my_cart .my_cart_inner ul li .details').css('width','115px');
                $('.my_cart .my_cart_inner ul li .delete').css('left','150px');

            }else{
                $('.my_cart .my_cart_inner ul').css('width','146px');
                $('.my_cart .my_cart_inner ul li .details').css('width','96px');
                $('.my_cart .my_cart_inner ul li .delete').css('left','129px');
            }
        //alert($('.my_cart .my_cart_inner').find('.jspScrollable').html());
        }
    },500);
}
!function(d,s,id){
    var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';
    if(!d.getElementById(id)){
        js=d.createElement(s);
        js.id=id;
        js.src=p+'://platform.twitter.com/widgets.js';
        fjs.parentNode.insertBefore(js,fjs);
    }
}(document, 'script', 'twitter-wjs');
$(document).ready(function(){


    //Examples of how to assign the ColorBox event to elements
    $(".zoomPup").colorbox({
        rel:'zoomPup',
        slideshow:true
    });
    var PHeight=$('.offer_sec').height();

   // $('.package_price').height(PHeight);
    $('.equel_sec').height(PHeight);
    //$('.package_bg').css('margin-top',(PHeight-150)/2);
    //$('.equel_con').css('margin-top',(PHeight-150)/2);

    //$(".jscallLoginBoxReview").colorbox({rel:'jscallLoginBoxReview'});
    $('.scroll-pane').jScrollPane();
    var owl = $(".proSlider .proSlide");
    owl.owlCarousel({
        navigation : true,
        items : 5, //10 items above 1000px browser width
        itemsDesktop : [1000,5], //5 items between 1000px and 901px
        itemsDesktopSmall : [900,3], // 3 items betweem 900px and 601px
        itemsTablet: [600,3], //2 items between 600 and 0;
        itemsMobile :[479,2] // itemsMobile disabled - inherit from itemsTablet option

    });

    var owl1 = $(".slider");
    owl1.owlCarousel({
        navigation : true, // Show next and prev buttons
        slideSpeed : 300,
        paginationSpeed : 400,
        singleItem:true
    });


});
function wholesaler_details(){
    $(".wholesaler_details").colorbox({
        inline:!0,
        width:"70%"
    }),$("#recommend_cancel").click(function(){
        parent.jQuery.fn.colorbox.close()
    })
}
function product_review_page(){
    $('.bottom_wholesale').show();
    $(".review_txt").colorbox({
        inline:!0,
        width:"60%"
    }),$("#cboxClose").click(function(){
        parent.jQuery.fn.colorbox.close();
        $('.wholesale_contain').hide();
    },$('#cboxOverlay').on('click',function(){
        $('.wholesale_contain').hide();
    }))
    
}

function reviewVal() {
    var frmMess = $('#frmMessage').val();
    if (frmMess == '') {
        var error = errorMessageReview('');
        $('.error_msg').html(error);

        return false;
    } else {
        $('#RevfrmMessage').val(frmMess);
        jscallLoginBoxCustomer('jscallLoginBoxReview', 'review', frmMess);
    }
}
$(document).ready(function(){
    var owl1 = $(".owl-demo7");

    owl1.owlCarousel({

        items :3, //10 items above 1000px browser width
        itemsDesktop : [1000,3], //5 items between 1000px and 901px
        itemsDesktopSmall : [900,3], // 3 items betweem 900px and 601px
        itemsTablet: [767,1], //2 items between 600 and 0;
        itemsMobile : false // itemsMobile disabled - inherit from itemsTablet option

    });

    // Custom Navigation Events
    $(".next7").click(function(){

        owl1.trigger('owl.next');
    })
    $(".prev7").click(function(){
        owl1.trigger('owl.prev');
    })
    var countClick=1;
    $('.show_attribute_details').live('click',function(){
        var ids=$(this).next().attr('id'); 
        var cl =$('#'+ids).attr('class');
        $('#'+ids).show();
        $('#'+ids).prev().html('hide Attribute details');
        $(this).attr('class','hide_attribute_details');
    });
    $('.hide_attribute_details').live('click',function(){
        $('.pro_info_tooltip_attr').hide();
        $('.hide_attribute_details').html('show Attribute details');
        $(this).attr('class','show_attribute_details');
    });
});

//Show review popup here
function product_reviews(){
    $('#show_review').show();
    $(".reviews").colorbox({
        inline:!0,
        width:"60%"
    }),$("#cboxClose").click(function(){
        parent.jQuery.fn.colorbox.close();
        $('#show_review').hide();
    })
}
var countType=1
function addToCartPackage(id,cls,usertype){
     var userType=$('.cart_link1').attr('tp');
        if(userType=='wholesaler'){
        if($.trim(countType)==1){
           var userTypeError=$('*').hasClass('reviewErMessageForPackage') ? "1" : "2";
           if(userTypeError==2){
           $('.'+cls).after('<div id="userTypeError" class="reviewErMessageForPackage" style="margin-top:10px;"><span style="color:red;font-size:12px">Please login as customer to add this product into cart</span></div>');
           }
            countType=2;
        }
        setTimeout(function() {
            $('#reviewErMessageForPackage').remove();
            countType=1;
        }, 8000);
        return false;
        }
    
    var quantity = 1;
    var AllAttrFormate = $('#AllAttrFormate').val();
    var count = 0;
    $.post(SITE_ROOT_URL+'common/ajax/ajax_cart.php',{
        action:'addToPackage',
        pkPackageId:id,
        qty:quantity,
        attrFormate:AllAttrFormate
    },function(data){
        addToAjaxCartValue();//$("#cartValue").html(parseInt($("#cartValue").text())+1);
        addToAjaxCart();
        addToAjaxCartHeader();
        $('#cartValue').html(parseInt($('#cartValue').text())+parseInt(quantity));
        $('.addToCartMsg').html(data);
        $('#idAddToProductCart').html(data);
        $('.kuchbhee .add_cart_link').css({margin:"0px"});
        $('.'+cls).removeAttr('onclick');
        $('.'+cls).css({cursor:"default"});
        $('.'+cls).css('text-transform',"none");
        $('.'+cls).css('padding','10px');
        $('.'+cls).css('background','green');
         $('.'+cls).css('width','250px');
        $('.'+cls).html('Successfully Added into cart');
    });
   
}