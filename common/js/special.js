$(document).ready(function(){
    $('.jqzoom').jqzoom({
        zoomType: 'standard',
        lens:true,
        preloadImages: false,
        alwaysOn:false
    });
    
                
    $(".offPriceText").rotate(330);
    $(".deals_bg .offPriceText").rotate(52);

    
    $('.ajax_special').live("click",function(){        
        var catid = $(this).attr("href");
        showSpecialProducts(catid);    
        return false;
    });
    
    var owl = $(".owl-demo").attr('id');
    owl=owl.split('_');
    owl=owl[1];
    for(var x=1;x<=owl;x++){
    $('#owl-demo_'+x).owlCarousel({
        items: 4, //10 items above 1000px browser width
        itemsDesktop: [1000, 5], //5 items between 1000px and 901px
        itemsDesktopSmall: [900, 5], // 3 items betweem 900px and 601px
        itemsTablet: [600, 2], //2 items between 600 and 0;
        itemsMobile: false // itemsMobile disabled - inherit from itemsTablet option

    });

    // Custom Navigation Events
    $(".next"+x).click(function() {

        $('#owl-demo_'+x).trigger('owl.next');
    })
    $(".prev"+x).click(function() {
        $('#owl-demo_'+x).trigger('owl.prev');
    })
    }
});

function showSpecialProducts(cid){
    var loaditem = '<div class="no_product_special"><img src="'+SITE_ROOT_URL+'common/images/loader100.gif" title="Loading..." alt="Loading..." /></div>';    
    if(cid=='0' || cid==''){
        return false;
    }else{
        $('#SpecialProduct').html(loaditem);
        
        $.post(SITE_ROOT_URL+'common/ajax/ajax_special.php',{
            action:'showSpecialProducts',
            cid:cid
        },function(data){
            $('#SpecialProduct').html(data);
            
            $(".offPriceText").rotate(330);            
            $(".carousel_slider").owlCarousel({
                autoPlay: 6000,
                items : 5,
                itemsDesktop : [1000,5], //5 items between 1000px and 901px
                itemsDesktopSmall : [900,3], // betweem 900px and 601px
                itemsTablet: [600,2], //2 items between 600 and 0
                navigation : true    
            });
            $(".thumb_img").hover(function(){
                $(this).find(".miniBoxHoverSpecial").fadeIn(200);
                return false
            });
            $(".thumb_img").mouseleave(function(){
                $(this).find(".miniBoxHoverSpecial").fadeOut(200);
                return false
            });
        });
    }
}