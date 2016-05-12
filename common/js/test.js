(jQuery),function(e,t,a){
    function r(a,r,i){
        var n=t.createElement(a);
        return r&&(n.id=K+r),i&&(n.style.cssText=i),e(n)
    } 
    
function addToAjaxCartHeader(){ 
    $.post("http://www.telamela.com.au/telamela/common/ajax/ajax_cart.php",{
        action:"addToAjaxCartHeader"
    },function(e){ //alert(e)
        //$(".cart_complete").html(e),$(".cart_row").show(),$(".scroll-pane").jScrollPane()
    })
}

/*function addToAjaxCart(){
    $.post("http://localhost/telamela/common/ajax/ajax_cart.php",{
        action:"addToAjaxCart"
    },function(e){
        $("#idAddToProductCart").html(e),$(".scroll-pane").jScrollPane()
    })
}*/
function addToAjaxCartValue(){
    var e="http://www.telamela.com.aushopping_cart.php";
    $.post("http://www.telamela.com.au/common/ajax/ajax_cart.php",{
        action:"addToAjaxCartValue"
    },function(t){ 
        1==t||t>1?$(".mycart_txt").parent().attr("href",e):"";
        var a=0==t||1==t?"<strong>"+t+"</strong>item":"<strong>"+t+"</strong>items";
        (t >0)?$('.cart').css('cursor','pointer'):$('.cart').css('cursor','pointer');
        $("#cartValue").html(a),$("#cartValue").removeAttr("style"),$("#cartValue").addClass("newCartCountColor"),$("#cartValue2").html(t),$.trim(t)>0?$(".cart_div").show():$(".cart_div").hide();
        var r=" item";
        r+="1"==t?"":"s",$(".cart_bottm").html("<p>You have "+t+r+' <br/>in your cart</p><span><a href="'+SITE_ROOT_URL+'shopping_cart.php">&#187;view cart </a></span>')
    })
}


function addToAjaxCart(n,c,v,m){ alert('call innsr fin');
//var n='7627';
//var c='1';
//var v='538,2068,2900,4032,4046';
//var m='';
    $.post("http://www.telamela.com.au/common/ajax/ajax_cart.php", {
            action: "addToProductCart",
            pid: n,
            qty: c,
            optIds: v,
            attrFormate: m
        }, function(t) {
            /*$(".succCart").show(), $(".succCart").html(t), addToAjaxCartValue(), addToAjaxCartHeader(), $(".scroll-pane").jScrollPane(), setTimeout(function() {
                $(".succCart").hide()
            }, 8e3)*/
            addToAjaxCartValue(); addToAjaxCartHeader();
        })
}
    
}