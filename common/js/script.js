$(document).ready(function(){
    $(".flipFront").bind("click",function(){
        var a=$(this);
        if(a.data("flipped")){
            a.revertFlip();
            a.data("flipped",false)
        }else{
            a.flip({
                direction:"tb",
                speed:350,
                onBefore:function(){
                    a.html(a.siblings(".flipBack").html())
                }
            });
            a.data("flipped",true)
        }
    });
    $(".proImg").hover(function(){
        $(this).find(".miniBoxHover").fadeIn(200);
        return false
    });
    $(".proImg").mouseleave(function(){
        $(this).find(".miniBoxHover").fadeOut(200);
        return false
    });
    
    $(".thumb_img").hover(function(){
        $(this).find(".miniBoxHoverSpecial").fadeIn(200);
        return false
    });
    $(".thumb_img").mouseleave(function(){
        $(this).find(".miniBoxHoverSpecial").fadeOut(200);
        return false
    });
    
    $(".tabBlock .clrTabCon").hide();
    $(".tabBlock .clrTabCon:first").show();
    $(".tabBlock ul.colorTab li:first").addClass("active");
    $(".tabBlock ul.colorTab li a").click(function(){
        $(".tabBlock ul.colorTab li").removeClass("active");
        $(this).parent().addClass("active");
        var a=$(this).attr("href");
        $(".tabBlock .clrTabCon").hide();
        $(a).show();
        return false
    });
    $(".tab2Block .clrTabCon").hide();
    $(".tab2Block .clrTabCon:first").show();
    $(".tab2Block ul.colorTab li:first").addClass("active");
    $(".tab2Block ul.colorTab li a").click(function(){
        $(".tab2Block ul.colorTab li").removeClass("active");
        $(this).parent().addClass("active");
        var a=$(this).attr("href");
        $(".tab2Block .clrTabCon").hide();
        $(a).show();
        return false
    });
    $(".tab3Block .clrTabCon").hide();
    $(".tab3Block .clrTabCon:first").show();
    $(".tab3Block ul.colorTab li:first").addClass("active");
    $(".tab3Block ul.colorTab li a").click(function(){
        $(".tab3Block ul.colorTab li").removeClass("active");
        $(this).parent().addClass("active");
        var a=$(this).attr("href");
        $(".tab3Block .clrTabCon").hide();
        $(a).show();
        return false
    })
});


//$(".proSlide").bxSlider({auto:false,minSlides:5,maxSlides:5,slideWidth:125,slideMargin:10});$(".pro2Slide").bxSlider({auto:false,minSlides:5,maxSlides:5,slideWidth:125,slideMargin:10});
