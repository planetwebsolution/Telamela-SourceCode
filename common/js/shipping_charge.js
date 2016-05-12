
$(document).ready(function(){
    $('.scroll-pane').jScrollPane();
    $('.drop_down1').sSelect();
//setTimeout(function(){$('.scroll-pane').jScrollPane();},3000);
});

/*
 $(window).on( "load", function() {
    
});*/

$(window).bind("load", function() {
    $('.scroll-pane').jScrollPane();
});

            
function showShippingMethod(obj){
    var showid = '#'+$(obj).val();   
    
    $(obj).parent().parent().find('div.sgm').css('display','none');
    // $(showid).html('<img src="'+SITE_ROOT_URL+'common/images/loader16.gif" title="Loading..." alt="Loading..." />');
    $(showid).css('display','block');
    
    //$(showid).find('input').attr('checked','checked');
    
    
    $('.scroll-pane').jScrollPane();
    
    calculatePrice();
    
/*
    return true; 
    
    

    $.post("common/ajax/ajax_shipping_charge.php",{
        action:'showShippingMethod',
        q:sgId,
        type:type,
        pid:pid,
        qty:qty,
        name:name                    
    },
    function(data){                                       
        //alert(data);
        $(showid).html(data);
    //$(showid).jScrollPane();
    //$('.scroll-pane').jScrollPane();                    
    });*/
}
            
function showShippingPrice(obj,sgId,smId,type,pid,qty){
    calculatePrice();
    //return ;
    
    
    $(obj).parent().find('span.amt').css('display','inline-block');
    var price = $(obj).parent().find('span.amt').html();
    //$(obj).parent().parent().parent().find('span.amt').css('display','none');
    $(obj).parent().find('span.amt').css('display','inline-block'); 
                
    if(price==''){ 
        $(obj).parent().find('span.amt').html('<img src="'+SITE_ROOT_URL+'common/images/loader16.gif" title="Loading..." alt="Loading..." />');
        
        $.post("common/ajax/ajax_shipping_charge.php",{
            action:'showShippingPrice',
            q:sgId,
            smId:smId,                    
            type:type,
            pid:pid,
            qty:qty
        },
        function(data){            
            var res = data.split('skm');                        
            $(obj).parent().find('span.amt').html(res[0]);
            var rVal = sgId+'-'+smId+'-'+res[1];                        
            $(obj).val(rVal);
            calculatePrice();
           
        });
    }else{     
        calculatePrice();
        return;
    }    
}

function calculatePrice(){
    
    var currencyCode = $('#customerCurrencyCode').val();
    
    var grandSubTotalPrice = 0;    
    var subTotalPrice = 0;
    
    
    var obj = $('#shoping_cart').find('li.myItem');
    
    obj.each(function(){
        var item = $(this).find('div.price_sec').find('p').html();
       
        var itemPrice = getvalidPrice(item);
        
        var objship = $(this).find('div.shipping_type').find('div.sgm');
        var ship = currencyCode;

        objship.each(function(){
            if($(this).css('display')=='block'){
                $(this).find('input').each(function(){
                    if($(this).is(':checked')){                         
                        ship = $(this).parent().find('span.amt').html();
                        
                    }
                });
            }
        });

        var shipPrice = getvalidPrice(ship);             

        subTotalPrice = itemPrice+shipPrice;            
             
        grandSubTotalPrice = grandSubTotalPrice+subTotalPrice;
          
        $(this).find('div.sub_total').find('p').html(myPrice(subTotalPrice));        
    });  
        
    $('#subTot').html(myPrice(grandSubTotalPrice));
    
    var disc = $('#discountTot').html();
    var discPrice = getvalidPrice(disc);
    
    var grandTotal  = grandSubTotalPrice-discPrice;
    $('#grandTot').html(myPrice(grandTotal));
    
}

function myPrice(str){
    var currencyCode = $('#customerCurrencyCode').val();
    
    var p0 = str.toFixed(2);    
    var p1 = p0.replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
    var price = currencyCode+p1;
    return price;
}

function getvalidPrice(str){
    var currencyCode = $('#customerCurrencyCode').val();
    
    var p0 = str.replace(currencyCode,"");
    var p1 = p0.replace(',','');
    var p2 = parseFloat(p1);   
    var price = 0;
    
    if(isNaN(p2)){
        price = 0;
    }else{
        price = p2;
    }
    
    return price;    
}