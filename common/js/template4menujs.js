//show menu while hover on category link
function showWholesalerMenu(conId, e)
{

    $('.' + conId).show();

}
//hide menu while hover out on category link
function hideWholesalerMenu(conId, e)
{
    //cheking while hover on child menu
    $('.Menubar').hover(function(e) {
        if ($(this).attr('class') == 'Menubar') {
            $('.' + conId).show();
        } else {
            $('.' + conId).fadeOut();
        }
    }, function() {
        $('.' + conId).hide();
    })
    $('.' + conId).hide();

}
$(document).ready(function(){
    

    $(document).on('click', '.categorySubMenuProduct', function() {
        var pId = $(this).parent().attr('id');
        var strArr = pId.split('_');
        var catProductId = strArr[0];
        var catWholId = strArr[1];
        $.ajax({
            url: "common/ajax/ajax.php",
            data: {action: 'getSubCategoryProduct', cid: catProductId, wid: catWholId},
            type: 'post',
            async: false,
            beforeSend: function() {
                $('#wh_product').html('<div class="products_outer"><div class="products_box"><img src="common/images/loader1.gif"/></div></div>');
                $('.main_div').hide();
                $('.min-height-box').css({'display': 'none'});
                $('#wh_product').css({'display': 'block'});
            },
            success: function(data) {

                $('#wh_product').html(data);
            }
        });
    });
    
    
    var pCatId=0;
    $("body").delegate('.categorySubMen','mouseenter mouseleave',function(e) { 
        var cId = $(this).parent().attr('id');
        if(pCatId!=cId){
        $('#'+pCatId).find('#contentBox').remove();
        }
        if(e.type === 'mouseenter'){
        $.ajax({
            url: SITE_ROOT_URL+"common/ajax/ajax.php",
            data: {action: 'getMainSubCategory', cid: cId, wid: wID},
            type: 'post',
            async: false,
            success: function(data) { //alert(data);return false;
                $('#' + cId).find('.categorySubMen').after(data);
            }
        });
        }else{
            pCatId=cId;
            $("body").delegate('#contentBox','mouseenter mouseleave',function(e) {
               if(e.type === 'mouseleave'){
                 $('#' + cId).find('#contentBox').remove();  
               } 
                
            });
        }
        
    })
    
    
    $("body").delegate('.childMenu','mouseenter mouseleave',function(e) {
        var cId = $(this).attr('id');
        if(e.type === 'mouseenter'){
        $.ajax({
            url: "common/ajax/ajax.php",
            data: {action: 'getSubCategory', cid: cId, wid: wID},
            type: 'post',
            async: false,
            success: function(data) {
               
                $('#' + cId).append(data);
            }
        });
        }else{
           $('#' + cId).find('.ContentSubmenu2').remove(); 
        }
    })
    
    
});