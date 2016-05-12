$(document).ready(function(){
    $("#click").click(function(){
        $("#click").css({
            "background-color":"#f00",
            color:"#fff",
            cursor:"inherit"
        }).text(OPEN_THIS_WINDOW);
        return false
    });
    setTimeout(function(){
        $(".language .goog-te-menu-value span").each(function(b){
            if(b!=0){
                $(this).hide()
            }
        })
    },3000);
    var a=$.cookie("googtrans");
    if(a=="/en/en"){
        $.cookie("googtrans",null)
    }
    $("#popupAddToCart .cross").click(function(){
        $("#popupAddToCart").hide();
        $("#fancybox-overlay").hide()
    });
    $("#frmUserEmailLn").change(function(){
        if($(this).val()==""||$(this).val()==null){
            var b=errorMessageLogin("");
            $(".frmUserEmailLn").html(b)
        }else{
            $(".frmUserEmailLn").html("")
        }
    });
    $("#frmUserPasswordLn").change(function(){
        if($(this).val()==""||$(this).val()==null){
            var b=errorMessageLogin("");
            $(".frmUserPasswordLn").html(b)
        }else{
            $(".frmUserPasswordLn").html("")
        }
    });
    $("#frmUserEmailFp").change(function(){
        if($(this).val()==""||$(this).val()==null){
            var b=errorMessageLogin("");
            $(".frmUserEmailFp").html(b)
        }else{
            $(".frmUserEmailFp").html("")
        }
    })
});
jQuery(document).ready(function(){
    jQuery("#frmGiftCard").validationEngine("attach",{
        scroll:false
    });
    jQuery(".send_gift_card").click(function(a){
        jQuery(".pop_up_sec").css({
            display:"block",
            "z-index":"100"
        });
        jQuery("#fancybox-overlay").css({
            display:"block"
        });
        a.preventDefault()
    });
    jQuery(".gift_card_close").click(function(a){
        jQuery(".pop_up_sec").css({
            display:"none"
        });
        jQuery("#fancybox-overlay").css({
            display:"none"
        });
        a.preventDefault()
    });
    $("#defaultInline").datepick({
        multiSelect:999,
        monthsToShow:1,
        onSelect:function(a){
            var c=a.toString().split(",");
            var b="";
            for(i=0;i<c.length;i++){
                date=new Date(c[i]);
                d=date.getDate();
                if(d<10){
                    d="0"+d
                }
                m=(date.getMonth()+1);
                if(m<10){
                    m="0"+m
                }
                y=date.getFullYear();
                if(b!=""){
                    b+=","+d+"-"+m+"-"+y
                }else{
                    b=d+"-"+m+"-"+y
                }
            }
            $("#giftCardCalender").val(b);
            if($("#giftCardCalender").val()!=""&&$("#giftCardCalender").val()!="NaN-NaN-NaN"){
                $("#dateRequiredValidation").val("1")
            }else{
                $("#dateRequiredValidation").val("")
            }
        }
    });


    //chaneHeaderMenu();

    $(window).resize(function() {
        chaneHeaderMenu();
    }).resize();

    $('.radio_btn .radio').live('click',function(){
        var tc = $("input:radio[name=frmUserTypeLn]:checked").val();
        if(tc=='customer'){
             $('.social_login_icons').show();
        }else{
             $('.social_login_icons').hide();
        }
    });
});


function chaneHeaderMenu(){    
    
    if($(window).width()>767){ 
        //alert('hover='+$(window).width());
        $('.menu_child').remove();
        
        $('.menu .last').nextAll().remove();
        $('.menu .last').show();  
        
        $(".dropdowns_inner").mouseenter(function(){
            $(this).find("li a").removeClass("active")
        });
                  
        $("ul.menu li").mouseenter(function(){
            $(this).parent().children(".dropdowns_outer").css("display","none");
            $(this).children(".dropdowns_outer").css("display","block");
            $(this).find(".dropdowns_inner > li:nth-child(1) > a").addClass("active");
            $(this).find(".dropdowns_inner li:nth-child(1)").find(".dropdetail_outer").css("display","block");

            var objm = $(this).find(".dropdowns_inner li");

            $(this).find(".dropdowns_inner li").hover(function() {
                objm.find(".dropdetail_outer").css("display","none");
                $(this).find('.dropdetail_outer').css('display','block');
            });
        });

        $("ul.menu li").mouseleave(function(){
            $(this).children(".dropdowns_outer").css("display","none")
        })

    }else{ 
        //alert('click='+$(window).width());       
        var htdata = $('.menu .last .dropdowns_inner').html();
        
        //$('.menu .last').next().html();
        if($('.menu .last').next().html()==undefined){
            htdata = htdata.replace(/dropdetail_outer/g, "dropdowns_outer");
            htdata = htdata.replace(/dropdetail_inner/g, "dropdowns_inner");        
            //$('.menu .last').hide();
            $('.menu .last').after(htdata);
            $('.menu .last').hide();  
        }
        if($('.menu_child').html()==undefined){
            $("ul.menu li a.childimg").after('<img class="show_child menu_child" src="'+SITE_ROOT_URL+'common/images/drop_down2.png" />');
        }
        
        $('.menu_child').parent().find('.dropdetail_outer').css('display','block');
        
        $('.menu_child').on('click',function(){
            $('.menu_child').not(this).parent().find('.dropdowns_outer').css('display','none');            
            //$(this).next().slideToggle();
            $(this).next().toggle();
        });
    }
}


function sendToGiftCard(j){ //alert('test');return false;
    var c=j.frmGiftCardAmount.value;
    var b=j.frmGiftCardFromName.value;
    var a=j.frmGiftCardToName.value;
    var g=j.frmGiftCardToEmail.value;
    var f=j.frmGiftCardMessage.value;
    var h=j.frmGiftCardQty.value;
    var e=j.giftCardCalender.value;
    var p=j.frmGiftCardPage.value;
    setTimeout(function(){
        if(j.getElementsByClassName("formError").length==0){
            $.ajax({
                type:"POST",
                url:SITE_ROOT_URL+"common/ajax/ajax_cart.php",
                data:{
                    action:"sentToGiftCard",
                    amount:c,
                    fromName:b,
                    toName:a,
                    toEmail:g,
                    message:f,
                    qty:h,
                    mailDeliveryDate:e
                },
                success:function(k){
                    $("#cartValue").html(parseInt($("#cartValue").text())+parseInt(h));
                    $("#idAddToProductCart").html(k);
                    $(".pop_up_sec").css("display","none");
                    $("#fancybox-overlay").css({
                        display:"none"
                    });
                    $("#myCartMassage").css("display","block");
                    $("#myCartMassage").html("Gift Cart Added To Your Shopping Cart.");
                    if(p == 'shopping_cart.php'){location.reload();}
                    $(".scroll-pane").jScrollPane();
                    rightSideCartwidth();
                }
            })
        }
    },1000)
}
$(function(){
    $(".moreLink").click(function(){
        $("#category_list").show();
        $("ul li.moreLink").hide();
        $("ul li.lessLink").show()
    });
    $(".lessLink").click(function(){
        $("#category_list").hide();
        $("ul li.moreLink").show();
        $("ul li.lessLink").hide()
    })
});
function changeCurrency(a){
    $.post(SITE_ROOT_URL+"common/ajax/ajax_converter.php",{
        action:"ChangeCurrency",
        currencyCode:a
    },function(b){
        location.reload()
    })
}

function addToCart(a){
    $("."+a).colorbox({
        height:800,
        onComplete:function(){
            addToAjaxCartValue();//$("#cartValue").html(parseInt($("#cartValue").text())+1);
            addToAjaxCart();
            addToAjaxCartHeader();
            $(".scroll-pane").jScrollPane();
            $(".close").click(function(){
                parent.jQuery.fn.colorbox.close()
            });
        }
    })
}

function addToCartClose(){
    $("#popupAddToCart .addtocart").html("");
    $("#popupAddToCart").hide();
    $("#fancybox-overlay").hide()
}
function closeCartMassage(){
    $("#myCartMassage").css("display","block");
    $("#myCartMassage").html("")
}
function addToAjaxCart(){
    $.post(SITE_ROOT_URL+"common/ajax/ajax_cart.php",{
        action:"addToAjaxCart"
    },function(a){
        $("#idAddToProductCart").html(a);
        $(".scroll-pane").jScrollPane()
    })
}
function addToAjaxCartValue(){
    $.post(SITE_ROOT_URL+"common/ajax/ajax_cart.php",{
        action:"addToAjaxCartValue"
    },function(a){
        $("#cartValue").html(a);
        var item = ' item';
        item += (a=='1')?'':'s';
        $(".cart_bottm").html('<p>You have '+a+item+' <br/>in your cart</p><span><a href="'+SITE_ROOT_URL+'shopping_cart.php">&#187;view cart </a></span>');
    })
}
function catKeySubmit(){
    var e=document.frmkeysearch.cid.value;
    var a=document.frmkeysearch.cid.options[document.frmkeysearch.cid.selectedIndex].text;
    var c=document.frmkeysearch.searchKey.value;
    a=a.replace("'","-");
    a=a.replace('"',"-");
    a=a.replace("_","-");
    a=a.replace(" ","-");
    a=a.replace(".","-");
    a=a.replace(",","-");
    a=a.replace("&","-");
    if(e=="0"){
        a="all"
    }
    if(c==SEARCH_BRAND_PRODUCT){
        c=""
    }
    var b=SITE_ROOT_URL+"category/"+a+"/"+e+"/"+c;
    document.frmkeysearch.action=b;
    document.frmkeysearch.submit();
    return true
}
function goodsSearchSubmit(){ 
    var c=document.frmGoodsSearch.searchKey.value;
    var e=document.frmGoodsSearch.frmPriceFrom.value;
    var a=document.frmGoodsSearch.frmPriceTo.value;
    if(c==SEARCH_BRAND_PRODUCT){
        c=""
    }
    var b=SITE_ROOT_URL+"category/goods/"+(e>0?e:0)+"/"+(a>0?a:0)+"/"+c;
    if(c!=""||e!=""||a!=""){
        window.location.href=b
    }else{
        $("#goodsMsg").css("display","block");
        setTimeout(function(){
            $("#goodsMsg").css("display","none")
        },2000)
    }
    return false;
}
function loginAction(){ 
    var f="0";
    var e=/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    var c=$("input:radio[name=frmUserTypeLn]:checked").val();
    var a=$("#frmUserEmailLn").val();
    var g=$("#frmUserPasswordLn").val();
    if(a==""||a==null){
        $(".frmUserEmailLn").css("display","block");
        var b=errorMessageLogin("");
        $(".frmUserEmailLn").html(b);
        $("#frmUserEmailLn").focus();
        return false
    }else{
        if(!e.test(a)){
            $(".frmUserEmailLn").css("display","block");
            var b=errorMessageLogin("email");
            $(".frmUserEmailLn").html(b);
            $("#frmUserEmailLn").focus();
            return false
        }else{
            if(g==""||g==null){
                $(".frmUserPasswordLn").css("display","block");
                var b=errorMessageLogin("");
                $(".frmUserPasswordLn").html(b);
                $("#frmUserPasswordLn").focus();
                return false
            }else{
                f="1"
            }
        }
    }
    if(f=="1"){
        $.post(SITE_ROOT_URL+"common/ajax/ajax_login.php",{
            action:"Login",
            frmUserType:c,
            frmUserEmail:a,
            frmUserpassword:g
        },function(h){
            $("#LoginErrorMsg").html(h)
        })
    }
}

function resendmail()
{
    alert('resendmail');
}
function loginActionCustomer(){
    var f="0";
    var e=/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    var c="customer";
    var a=$("#frmUserEmailLnRev").val();
    var g=$("#frmUserPasswordLnRev").val();
    if(a==""||a==null){
        $(".frmUserEmailLn").css("display","block");
        var b=errorMessageLogin("");
        $(".frmUserEmailLn").html(b);
        $("#frmUserEmailLnRev").focus();
        return false
    }else{
        if(!e.test(a)){
            $(".frmUserEmailLn").css("display","block");
            var b=errorMessageLogin("email");
            $(".frmUserEmailLn").html(b);
            $("#frmUserEmailLnRev").focus();
            return false
        }else{
            $(".frmUserEmailLn").html('');

            if(g==""||g==null){
                $(".frmUserPasswordLn").css("display","block");
                var b=errorMessageLogin("");
                $(".frmUserPasswordLn").html(b);
                $("#frmUserPasswordLnRev").focus();
                return false
            }else{
                $(".frmUserPasswordLn").html('');
                f="1"
            }
        }
    }
    if(f=="1"){
        $.post(SITE_ROOT_URL+"common/ajax/ajax_login.php",{
            action:"Login",
            frmUserType:c,
            frmUserEmail:a,
            frmUserpassword:g,
            pid:$("#Revpid").val(),
            name:$("#Revname").val(),
            refNo:$("#RevrefNo").val(),
            type:$("#CustomerLoginRev").attr("action"),
            frmval:$("#CustomerLoginRev").attr("val")
        },function(h){
            $("#LoginErrorMsgRev").html(h)
        })
    }
}
function forgetPasswordAction(){
    var f=/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    var e="0";
    var c=$("input:radio[name=frmUserTypeFp]:checked").val();
    var a=$("#frmUserEmailFp").val();
    if(a==""||a==null){
        var b=errorMessageLogin("");
        $(".frmUserEmailFp").html(b);
        $("#frmUserEmailFp").focus();
        return false
    }else{
        if(!f.test(a)){
            var b=errorMessageLogin("email");
            $(".frmUserEmailFp").html(b);
            $("#frmUserEmailFp").focus();
            return false
        }else{
            e="1"
        }
    }
    if(e=="1"){
        $.post(SITE_ROOT_URL+"common/ajax/ajax_login.php",{
            action:"forgetPassword",
            frmUserType:c,
            frmUserEmail:a
        },function(g){
            $("#ForgetPasswordErrorMsg").html(g)
        })
    }
}
function jscallLoginBox(c,b){

    $("."+c).colorbox({
        inline:true,
        width:"500px"
    });
    if(b=="1"){
        var a=$("input[name=frmUserTypeLn]:radio:checked").val();
        $("input[name=frmUserTypeFp][value="+a+"]").attr("checked","checked")
    }
}
//jQuery(document).ready(function(){
//    jQuery("#searchKey").live("click",function(){
//        jQuery("#searchKey").autocomplete(SITE_ROOT_URL+"common/ajax/ajax_autocomplete.php?action=searchKeyAutocomplete&catid="+jQuery("#searchcid").val()+"&q="+jQuery("#searchKey").val(),{
//            width:390,
//            matchContains:true,
//            selectFirst:false
//        })
//    })
//});
function jscallLoginBoxCustomer(c,a,b){
    $("#CustomerLoginRev").attr("action",a);
    $("#CustomerLoginRev").attr("val",b);
    $("."+c).colorbox({
        inline:true,
        width:"500px"
    })
}
jQuery(document).ready(function(){
    jQuery("#searchKey").live("click",function(){
        jQuery("#searchKey").autocomplete(SITE_ROOT_URL+"common/ajax/ajax_autocomplete.php?action=searchKeyAutocomplete&catid="+jQuery("#searchcid").val()+"&q="+jQuery("#searchKey").val(),{
            width:390,
            matchContains:true,
            selectFirst:false
        })
    })
});
function errorMessageLogin(b){
    if(b=="email"){
        var a="* "+varInvalidEmail
    }else{
        var a="* "+required
    }
    return'<div style="opacity: 0.87; position: relative; top: 0px; margin-top: -80px; left: 248px;" class="formError"><div class="formErrorContent">'+a+'<br/></div><div class="formErrorArrow"><div class="line10"><!-- --></div><div class="line9"><!-- --></div><div class="line8"><!-- --></div><div class="line7"><!-- --></div><div class="line6"><!-- --></div><div class="line5"><!-- --></div><div class="line4"><!-- --></div><div class="line3"><!-- --></div><div class="line2"><!-- --></div><div class="line1"><!-- --></div></div></div>'
};

function textSelect(optId, attrId, oType, oProdId){ 
    //alert('df');
    if(oProdId==undefined){
        var optPro = optId;
        var attrPro = attrId;
    }else{
        var optPro = optId+'_'+oProdId;
        var attrPro = attrId+'_'+oProdId;
    }

    $('#attrdiv_'+attrPro).find(oType=='image'?'.rollover_1':'.rollover_2').html('');
    $('#attrdiv_'+attrPro).find(oType=='image'?'.pics':' a').css('border','1px solid #A3A4A6');

    $('#check_'+optPro).html("<img src='" + SITE_ROOT_URL+"common/images/right_img2.png" + "'>");

    $('#frmAttribute_'+optPro).css('border','1px solid #FF0000');

    var $radios = $('input:radio[name=frmAttribute_'+attrPro+']');
    if(oProdId==undefined){
        $radios.filter('[value='+optPro+']').prop('checked', true);
    } else{
        $radios.filter('[namevalue='+optPro+']').prop('checked', true);
    }
    calculateOptPrice();
}
function jscall_recommend(id){
    $(".recommend").colorbox({
        inline:true,
        width:"600px"
    });
    $('#recommend_cancel').click(function(){
        parent.jQuery.fn.colorbox.close();
    });
// addToRecommend(id);
}

function quantityPlusMinus(str,sho){
    if(sho=='qv'){
        var qId = '#frmQty';
    }else{
        var qId = '#frmQuantity';
    }

    var qty = $(qId).val();
    if(str=='1'){
        qty = parseInt(qty)+1;
        $(qId).val(qty);
    }else{
        qty = parseInt(qty)-1;
        if(qty>0){
            $(qId).val(qty);
        }
    }
}
//Hybrid Auth Social Icons [Start]
var idp = null;

$(function() { 
    $(".idpico").click(
        function(){ 
    alert('testtt');
            idp = $( this ).attr( "idp" );
            start_auth("?provider=" + idp );
        }
        ); 
});

function start_auth( params ){    
    if(RET_TO=='product.php'){    
        var qryStr = 'pid||'+$("#Revpid").val()+'@@name||'+$("#Revname").val()+'@@refNo||'+$("#RevrefNo").val()+'@@type||'+$("#CustomerLoginRev").attr("action")+'@@frmval||'+$("#CustomerLoginRev").attr("val");                        
    }else{
        var qryStr = '';
    }
    start_url = SITE_ROOT_URL+"social_login.php"+params + "&return_to="+encodeURI(SITE_ROOT_URL+"social_login.php") + "&_ts=" + (new Date()).getTime()+'&_to='+RET_TO;
    window.open(
        start_url, 
        "hybridauth_social_sing_on", 
        "location=0,status=0,scrollbars=0,width=800,height=500"
        );  
}
//Hybrid Auth Social Icons [End]
