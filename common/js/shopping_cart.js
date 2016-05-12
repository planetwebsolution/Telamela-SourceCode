jQuery(document).ready(function(){
    // binds form submission and fields to the validation engine
                        
    jQuery("#MyCart").validationEngine({
        'custom_error_messages': {            
            'max': {
                'message': "*The quantity you have entered is out of stock!"
            },
            'min': {
                'message': "*Minimum quantity is 1"
            }
        }
    });
    
    jQuery('body').on('click','.changeQuantityHeader',function(e){
        e.preventDefault();
        var showImgClass=$(this).next().attr('id');
        $('#'+showImgClass).show();
        var deleteType=$(this).attr('tp');
        var pid=$(this).attr('pid');
        var ind=$(this).attr('ind');
        var stUrl=$(this).attr('stUrl');
        var inr=$(this).attr('inr');
        var pri=$(this).attr('pri');
        ;
        var qty =$('#frmProductQuantity'+inr).val(); //console.info(qty);
        var oldQty=$('#frmProductQuantityOld'+inr).val();// console.info(oldQty); return false;
       console.log('2342');
        $.post(stUrl+'common/ajax/ajax_cart.php',{
        	
            action:'UpdateMyCartHeader',
            pid:pid,
            pkgIndex:ind,
            type:deleteType,
            qty:qty,
            pri:pri,
            oldQty:oldQty
        },function(data){    
        	//alert(data.Total);// alert(data.updatePrice);return false;
            //console.log('2342');
            var total = ($.trim(data.Total)==0 || $.trim(data.Total)==1)? '<strong>'+$.trim(data.Total)+ '</strong>item': '<strong>'+$.trim(data.Total)+ '</strong>items';
            $('#cartValue').html(total);
            $("#cartValue2").html(data.Total);
            $('.cartQuantityPriceUpdate'+inr).html(data.updatePrice);
            $('#frmProductQuantityOld'+inr).val(data.oldVal);
            $('#'+showImgClass).hide();
        
        },"json");
    
    });
		
});
        
function RemoveProductFromCart(id,index,count){ //alert(id+'...'+index+'...'+count);alert('test'); return false;
    $('#RemoveFromCart'+id+'_'+count).html('');
    $.post('common/ajax/ajax_cart.php',{
        action:'RemoveProductFromCart',
        pid:id, 
        index:index
    },function(data){
            
        //var dt = data.split(',');
        if(data.Total>0){
            $('#myCartMassage').css('display','block');
            $('#myCartMassage').html('&nbsp;'+YOU_HAVE_REMOVE+' '+data.ProductName+' '+FROM_YOUR+' '+SHOPPING_CART+'!');
            var total = ($.trim(data.Total)==0 || $.trim(data.Total)==1)? '<strong>'+$.trim(data.Total)+ '</strong>item': '<strong>'+$.trim(data.Total)+ '</strong>items';
            $('#cartValue').html(total);
            $('#cartValue2').html(data.Total);
            $('#RemoveFromCart'+id+'_'+count).remove();
//            var dHeight=parseInt($('.RemoveFromCart'+id).height());
//            var tHeight=parseInt($('.cart_complete').height());
//            var adHeight=tHeight-dHeight;
//            $('.cart_complete').height(adHeight);
            $('.RemoveFromCart'+id).remove();
            setTimeout(function(){
                $('#myCartMassage').css('display','none');
            },5000);
            location.reload();
        }else{
            location.reload(); 
        }
    },"json");
}
            
function RemoveGiftCardFromCart(id){           
                         
    $('#RemoveFromCartGiftCard'+id).html('');
    $.post('common/ajax/ajax_cart.php',{
        action:'RemoveGiftCardFromCart',
        pid:id
    },function(data){            
        var dt = data;
        if(dt>0){
            $('#myCartMassage').css('display','block');
            $('#myCartMassage').html('&nbsp;'+YOU_HAVE_REMOVE_GIFT+' <a href="shopping_cart.php">'+SHOPPING_CART+'</a>!');
            var total = ($.trim(dt)==0 || $.trim(dt)==1)? '<strong>'+$.trim(dt)+ '</strong>item': '<strong>'+$.trim(dt)+ '</strong>items';
            $('#cartValue').html(total);
            $('#cartValue2').html(dt);
            $('.RemoveGiftFromCart'+id).remove();
            setTimeout(function(){
                $('#myCartMassage').css('display','none');
            },5000);
            location.reload();
        }else{
            location.reload();
        }
    
    });
}
            
function RemovePackageFromCart(id,pkgIndex){           
    $('#RemoveFromCartPkg'+id).html('');
    $.post('common/ajax/ajax_cart.php',{
        action:'RemovePackageFromCart',
        pid:id,
        pkgIndex:pkgIndex
    },function(data){            
        var dt = data;
        if(dt>0){
            $('#myCartMassage').css('display','block');
            $('#myCartMassage').html('&nbsp;'+YOU_HAVE_REMOVE_PACKAGE+' <a href="shopping_cart.php">'+SHOPPING_CART+'</a>!');
            var total = ($.trim(dt)==0 || $.trim(dt)==1)? '<strong>'+$.trim(dt)+ '</strong>item': '<strong>'+$.trim(dt)+ '</strong>items';
            $('#cartValue').html(total);
            $('#cartValue2').html(dt);
            $('.RemovePackageFromCart'+id).remove();
            $('.RemoveFromCartPkg'+id).remove();
            setTimeout(function(){
                $('#myCartMassage').css('display','none');
            
            },5000);
            location.reload();
        }else{
            location.reload();
        }
   
    });
}
       
function RemoveCart(){  
    $('#cart').html('');
    $.post('common/ajax/ajax_cart.php',{
        action:'RemoveCart'
    },function(data){
            
        var dt = data.split(','); 
        $('#myCartMassage').css('display','block');
        $('#myCartMassage').html('&nbsp;'+SHOPPING_CART_EMPTY+' ');
        $('#cartValue > strong').html(0);
        $('#cartValue2').html(0);
        setTimeout(function(){
            $('#myCartMassage').css('display','none');
            location.reload();
        },2000); 
    //if(dt[0]==0){
                
    //}
    });
}
function ApplyCouponCode(cls){       
    var code = $('#frmCouponCode').val();
    var checkForCoupan=$('.'+cls).attr('coupanCheck');        
    if(code == ENTER_CODE_HERE){
        alert(ENTER_CODE_HERE);
        $('#frmCouponCode').focus();
        return false;
    }
    if(checkForCoupan==0){
        $('#coupancodenoteligable').show();
        $('#frmCouponCode').focus();
        setTimeout(function(){
            $('#coupancodenoteligable').hide();
        },4000); 
        return false;
    }       
    
    $.post('common/ajax/ajax_cart.php',{
        action:'ApplyCouponCode',
        code:code
    },function(data){           
                    
        if(data=='0'){
            $('#CouponCodeMsg').html('<p class="req" style="color:red;">'+COUPON_CODE_EXPIRED+'</p>');
            setTimeout(function(){
                $('#CouponCodeMsg').html(''); /*$('#frmCouponCode').val(ENTER_CODE_HERE);*/
            },6000); 
        }else if(data=='1'){
            $('#CouponCodeMsg').html('<p class="req" style="color:red;">'+COUPON_CODE_NOTVALID+'</p>');
            setTimeout(function(){
                $('#CouponCodeMsg').html('');/*$('#frmCouponCode').val(ENTER_CODE_HERE);*/
            },6000); 
        }else{                
            $('#CouponCodeMsg').html('<p style="color:green;">'+COUPON_CODE_APPLIED_SUCC+'</p>');
            $('#total_sec').html(data);
        //setTimeout(function(){$('#CouponCodeMsg').html('');},6000);                
        }
    });
}
                    
function ApplyGiftCards(){           
    var code = $('#frmGiftCart').val();
    alert(code);
    $.post('common/ajax/ajax_cart.php',{
        action:'ApplyGiftCards',
        code:code
    },function(data){
            
        // var dt = data.split(','); 
        //$('#myCartMassage').html('&nbsp;Success: Your shopping cart is empty! <img src="common/images/close.png" onclick="closeCartMassage();" width="15" height="15" alt="Close" style="cursor: pointer; float: right; padding: 2px;" />');
        //  $('#cartValue').html(dt[0]);            
        //setTimeout(function(){$('#myCartMassage').html('');location.reload();},1000); 
        //if(dt[0]==0){
                
        //}
        });
}

function checkQuantity()
{
    var res = true;
    $.post('common/ajax/ajax_cart.php',{
        action:"checkCartProductQuantity"
    },
    function(data){
        if(data==0)
        {
            $('.cartMessage').html('');
            $('#myCartMassage').css('display','block');                           
            $('#myCartMassage').addClass('errorMessage');
            $('#myCartMassage').html('<div class="success">'+QUANTITY_OUT_OF_STOCK+'</div>');
            $(document).scrollTop(180)
        }
        else
        {
            window.location = 'checkout.php';
        }
    });
}