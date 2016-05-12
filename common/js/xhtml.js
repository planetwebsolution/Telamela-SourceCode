function chaneHeaderMenu(){
    $(window).width()>767?$("body").find("ul.menu").length>0&&($(".menu_child").remove(),$(".menu .last").nextAll().remove(),$(".menu .last").show(),$(".dropdowns_inner").mouseenter(function(){
        $(this).find("li a").removeClass("active")
    }),$("ul.menu > li").hoverIntent({
        over:function(){
            $(this).find(".dropdowns_outer").slideDown(100),$(this).find(".dropdowns_inner > li:nth-child(1) > a").addClass("active"),$(this).find(".dropdowns_inner li:nth-child(1)").find(".dropdetail_outer").slideDown(100);
            $(this).find(".dropdowns_inner li");
            $(".menu .last").hover(function(){
                $("ul.menu li.last:hover a").not(":first").css("height","auto")
            })
        },
        out:function(){
            $(this).find(".dropdowns_outer").hide()
        }
    })):$("ul.menu li.last:hover a").not(":first").css("height","auto")
}
function sendToGiftCard(e){ 
    var t=e.frmGiftCardAmount.value,a=e.frmGiftCardFromName.value,r=e.frmGiftCardToName.value,i=e.frmGiftCardToEmail.value,n=e.frmGiftCardMessage.value,o=e.frmGiftCardQty.value,s=e.giftCardCalender.value,l=e.frmGiftCardPage.value;
    setTimeout(function(){
        0==e.getElementsByClassName("formError").length&&$.ajax({
            type:"POST",
            url:SITE_ROOT_URL+"common/ajax/ajax_cart.php",
            data:{
                action:"sentToGiftCard",
                amount:t,
                fromName:a,
                toName:r,
                toEmail:i,
                message:n,
                qty:o,
                mailDeliveryDate:s
            },
            success:function(e){
                addToAjaxCartValue(),addToAjaxCart(),addToAjaxCartHeader(),$("#cartValue").html(parseInt($("#cartValue").text())+parseInt(o)),$("#idAddToProductCart").html(e),$(".pop_up_sec").css("display","none"),$("#fancybox-overlay").css({
                    display:"none"
                }),"shopping_cart.php"==l?location.reload():window.location="shopping_cart.php",$(".scroll-pane").jScrollPane(),rightSideCartwidth()
            }
        })
    },1e3)
}
function changeCurrency(e){
    $.post(SITE_ROOT_URL+"common/ajax/ajax_converter.php",{
        action:"ChangeCurrency",
        currencyCode:e
    },function(){
    	//alert(currencyCode);
        location.reload()
    })
}
function addToCart(e){
    $("."+e).colorbox({
        height:400,
        onComplete:function(){
            addToAjaxCartValue(),addToAjaxCart(),addToAjaxCartHeader(),$(".scroll-pane").jScrollPane(),$(".close").click(function(){
                parent.jQuery.fn.colorbox.close()
            })
        }
    })
}
function addToCartClose(){
    $("#popupAddToCart .addtocart").html(""),$("#popupAddToCart").hide(),$("#fancybox-overlay").hide()
}
function closeCartMassage(){
    $("#myCartMassage").css("display","block"),$("#myCartMassage").html("")
}
function addToAjaxCart(){
    $.post(SITE_ROOT_URL+"common/ajax/ajax_cart.php",{
        action:"addToAjaxCart"
    },function(e){
        $("#idAddToProductCart").html(e),$(".scroll-pane").jScrollPane()
    })
}
function addToAjaxCartValue(){
    var e=SITE_ROOT_URL+"shopping_cart.php";
    $.post(SITE_ROOT_URL+"common/ajax/ajax_cart.php",{
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
function catKeySubmit(){ 
    var e=document.frmkeysearch.cid.value,t=document.frmkeysearch.cid.options[document.frmkeysearch.cid.selectedIndex].text,a=document.frmkeysearch.searchKey.value;
    if(/(^[0-9]|[a-z])/.test(a)==false){
       
        ($("#goodsMsgErMain").css("display","block"),setTimeout(function(){
        $("#goodsMsgErMain").css("display","none")
    },2e3));
    return false;
    }
    t=t.replace("'","-"),t=t.replace('"',"-"),t=t.replace("_","-"),t=t.replace(" ","-"),t=t.replace(".","-"),t=t.replace(",","-"),t=t.replace("&","-"),"0"==e&&(t="all"),a==SEARCH_BRAND_PRODUCT&&(a="");
    var r=SITE_ROOT_URL+"category/"+t+"/"+e+"/"+a;
    return document.frmkeysearch.action=r,document.frmkeysearch.submit(),!0
}
function goodsSearchSubmit(){
    var e=document.frmGoodsSearch.searchKey.value,t=document.frmGoodsSearch.frmPriceFrom.value,a=document.frmGoodsSearch.frmPriceTo.value;
    if(/(^[0-9]|[a-z])/.test(e)==false){
        ($("#goodsMsgEr").css("display","block"),setTimeout(function(){
        $("#goodsMsgEr").css("display","none")
    },2e3));
    return false;
    }
    e==SEARCH_BRAND_PRODUCT&&(e="");
    var r=SITE_ROOT_URL+"category/all/"+(t>0?t:0)+"/"+(a>0?a:0)+"/"+e;
    
    return""!=e?window.location.href=r:($("#goodsMsg").css("display","block"),setTimeout(function(){
        $("#goodsMsg").css("display","none")
    },2e3)),!1
}
function loginAction(){ 
    var e="0",t=/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/,a=$("input:radio[name=frmUserTypeLn]:checked").val(),r=$("#frmUserEmailLn").val(),i=$("#frmUserPasswordLn").val();
    if($("input:checkbox[name=remember_me]").is(":checked"))var n="yes";else var n="";
    if(""==r||null==r){
        $(".frmUserEmailLn").css("display","block");
        var o=errorMessageLogin("");
        return $(".frmUserEmailLn").html(o),$("#frmUserEmailLn").focus(),!1
    }
    if(!t.test(r)){
        $(".frmUserEmailLn").css("display","block");
        var o=errorMessageLogin("email");
        return $(".frmUserEmailLn").html(o),$("#frmUserEmailLn").focus(),!1
    }
    if(""==i||null==i){
        $(".frmUserPasswordLn").css("display","block");
        var o=errorMessageLogin("");
        return $(".frmUserPasswordLn").html(o),$("#frmUserPasswordLn").focus(),!1
    }
    //alert(a);return false;
    e="1","1"==e&&$.post(SITE_ROOT_URL+"common/ajax/ajax_login.php",{
        action:"Login",
        frmUserType:a,
        frmUserEmail:r,
        frmUserpassword:i,
        remember_me:n
    },function(e){
        $("#LoginErrorMsg").html(e),$("#frmUserPasswordLn").val("")
    })
}

function resendmail()
{
   // alert('resendmail');
    var a=$("#frmUserEmailLn").val(); 
   
    $.post(SITE_ROOT_URL+"common/ajax/ajax_login.php",{
            action:"Resendlink",
            frmUserEmail:a,
           
        },function(h){
            $("#LoginErrorMsg").html(h)
        })
}
function resendmailcustomer()
{
   // alert('resendmail');
    var a=$("#frmUserEmailLn").val(); 
   
    $.post(SITE_ROOT_URL+"common/ajax/ajax_login.php",{
            action:"Resendlinkcustomer",
            frmUserEmail:a,
          
        },function(h){
            $("#LoginErrorMsg").html(h)
        })
}
function loginActionCustomer(){
    var e="0",t=/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/,a="customer",r=$("#frmUserEmailLnRev").val(),i=$("#frmUserPasswordLnRev").val();
    if(""==r||null==r){
        $(".frmUserEmailLn").css("display","block");
        var n=errorMessageLogin("");
        return $(".frmUserEmailLn").html(n),$("#frmUserEmailLnRev").focus(),!1
    }
    if(!t.test(r)){
        $(".frmUserEmailLn").css("display","block");
        var n=errorMessageLogin("email");
        return $(".frmUserEmailLn").html(n),$("#frmUserEmailLnRev").focus(),!1
    }
    if($(".frmUserEmailLn").html(""),""==i||null==i){
        $(".frmUserPasswordLn").css("display","block");
        var n=errorMessageLogin("");
        return $(".frmUserPasswordLn").html(n),$("#frmUserPasswordLnRev").focus(),!1
    }
    $(".frmUserPasswordLn").html(""),e="1","1"==e&&$.post(SITE_ROOT_URL+"common/ajax/ajax_login.php",{
        action:"Login",
        frmUserType:a,
        frmUserEmail:r,
        frmUserpassword:i,
        pid:$("#Revpid").val(),
        name:$("#Revname").val(),
        refNo:$("#RevrefNo").val(),
        type:$("#CustomerLoginRev").attr("action"),
        frmval:$("#CustomerLoginRev").attr("val")
    },function(e){
        $("#LoginErrorMsgRev").html(e),$("#frmUserPasswordLnRev").val("")
    })
}
function forgetPasswordAction(){
    var e=/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/,t="0",a=$("input:radio[name=frmUserTypeFp]:checked").val(),r=$("#frmUserEmailFp").val();
    if(""==r||null==r){
        var i=errorMessageLogin("");
        return $(".frmUserEmailFp").html(i),$("#frmUserEmailFp").focus(),!1
    }
    if(!e.test(r)){
        var i=errorMessageLogin("email");
        return $(".frmUserEmailFp").html(i),$("#frmUserEmailFp").focus(),!1
    }
    t="1","1"==t&&$.post(SITE_ROOT_URL+"common/ajax/ajax_login.php",{
        action:"forgetPassword",
        frmUserType:a,
        frmUserEmail:r
    },function(e){
        1==$.trim(e)?($(".successForgotPass").show(),setTimeout(function(){
            $(".successForgotPass").fadeOut(4e3)
        },4e3),$("#ForgetPasswordErrorMsg").hide()):($("#ForgetPasswordErrorMsg").show(),setTimeout(function(){
            $("#ForgetPasswordErrorMsg").fadeOut(4e3)
        },4e3),$(".successForgotPass").hide())
    })
}
function jscallLoginBox(e,t){
    console.log(e,t)
    if($("."+e).colorbox({
        inline:!0,
        width:"700px"
    }),"1"==t){
        var a=$("input[name=frmUserTypeLn]:radio:checked").val();
        $("input[name=frmUserTypeFp][value="+a+"]").attr("checked","checked")
    }
}
function jscallLoginBoxCustomer(e,t,a){
    $("#frmProductToWish").val(a),$("#CustomerLoginRev").attr("action",t),$("#CustomerLoginRev").attr("val",a),$("."+e).colorbox({
        inline:!0,
        width:"500px"
    })
}
function errorMessageLogin(e){
    if("email"==e)var t="* "+varInvalidEmail;else var t="* "+required;
    return'<div style="opacity: 0.87; position: relative; top: 0px; margin-top: -80px; left: 248px;" class="formError"><div class="formErrorContent">'+t+'<br/></div><div class="formErrorArrow"><div class="line10"><!-- --></div><div class="line9"><!-- --></div><div class="line8"><!-- --></div><div class="line7"><!-- --></div><div class="line6"><!-- --></div><div class="line5"><!-- --></div><div class="line4"><!-- --></div><div class="line3"><!-- --></div><div class="line2"><!-- --></div><div class="line1"><!-- --></div></div></div>'
}
function textSelect(e,t,a,r){
    
    var i=$(".cart_link1").attr("tp");
    if("wholesaler"==i){
        if(1==$.trim(countType)){
            var n=$("*").hasClass("reviewErMessage")?"1":"2";
            2==n&&$(".cart_link1").after('<div id="userTypeError" class="reviewErMessage"><span style="color:red">Please login as customer to add this product into cart</span></div>'),countType=2
        }
        return setTimeout(function(){
            $("#userTypeError").remove(),countType=1
        },8e3),!1
    }
    
    if(void 0==r)var o=e,s=t;else var o=e+"_"+r,s=t+"_"+r;
    $("#attrdiv_"+s+" .errorBox").is(":visible")&&$("#attrdiv_"+s+" .errorBox").hide(),$("#attrdiv_"+s).find("image"==a?".rollover_1":".rollover_2").html(""),$("#attrdiv_"+s).find("image"==a?".pics":" a").css("border","1px solid #A3A4A6"),$("#check_"+o).html("<img src='"+SITE_ROOT_URL+"common/images/right_img2.png'>"),$("#frmAttribute_"+o).css("border","1px solid #FF0000");
    var l=$("input:radio[name=frmAttribute_"+s+"]");
    void 0==r?l.filter("[value="+o+"]").prop("checked",!0):l.filter("[namevalue="+o+"]").prop("checked",!0),calculateOptPrice(),$(".rollover_2").find("img").css("display","block")
    
}
function textSelectPackage(e,t,a,r){
    if(void 0==r)var i=e,n=t;else var i=e+"_"+r,n=t+"_"+r;
    $("#attrdiv_"+n).find("image"==a?".rollover_1":".rollover_2").html(""),$("#attrdiv_"+n).find("image"==a?".pics":" a").css("border","1px solid #A3A4A6"),$("#check_"+i).html("<img src='"+SITE_ROOT_URL+"common/images/right_img2.png'>"),$("#frmAttribute_"+i).css("border","1px solid #FF0000");
    var o=$("input:radio[name=frmAttribute_"+n+"]");
    void 0==r?o.filter("[value="+i+"]").prop("checked",!0):o.filter("[namevalue="+i+"]").prop("checked",!0),calculateOptPricePackage(e,t,a,r)
}
function jscall_recommend(){
    $(".recommend").colorbox({
        inline:!0,
        width:"600px"
    }),$("#recommend_cancel").click(function(){
        parent.jQuery.fn.colorbox.close()
    })
}
function quantityPlusMinus(e,t){
    if("qv"==t)var a="#frmQty";else var a="#frmQuantity";
    var r=$(a).val();
    "1"==e?(r=parseInt(r)+1,$(a).val(r)):(r=parseInt(r)-1,r>0&&$(a).val(r))
}
function start_auth(e){
    if("product.php"==RET_TO)var t="pid||"+$("#Revpid").val()+"@@name||"+$("#Revname").val()+"@@refNo||"+$("#RevrefNo").val()+"@@type||"+$("#CustomerLoginRev").attr("action")+"@@frmval||"+$("#CustomerLoginRev").attr("val");else var t="";
    start_url=SITE_ROOT_URL+"social_login.php"+e+"&return_to="+encodeURI(SITE_ROOT_URL+"social_login.php")+"&_ts="+(new Date).getTime()+"&_to="+RET_TO+"&_qryStr="+t,window.open(start_url,"hybridauth_social_sing_on","location=0,status=0,scrollbars=0,width=800,height=500")
}
function RemoveProductFromCart1(e,t,a,r,i){
    $.post(a+"common/ajax/ajax_cart.php",{
        action:"RemoveProductFromCart",
        pid:e,
        index:t,
        qty:i
    },function(t){
        if(t.Total>0){
            $("#RemoveFromCart"+e).length>0?$("#RemoveFromCart"+e).html(""):"",$(".cart"+r).length>0?$(".cart"+r).html(""):"",$(".RemoveFromCart"+r).length>0?$(".RemoveFromCart"+r).remove():"";
            var a=0==$.trim(t.Total)||1==$.trim(t.Total)?"<strong>"+$.trim(t.Total)+"</strong>item":"<strong>"+$.trim(t.Total)+"</strong>items";
            $("#cartValue").html(a),$("#cartValue2").html(t.Total),$(".scroll-pane").jScrollPane(),location.reload()
        }else location.reload()
    },"json")
}
function RemoveGiftCardFromCart1(e,t,a,r){
    $.post(t+"common/ajax/ajax_cart.php",{
        action:"RemoveGiftCardFromCart",
        pid:e,
        qty:r
    },function(t){
        var r=t;
        if(r>0){
            $("#RemoveFromCartGiftCard"+e).length>0?$("#RemoveFromCartGiftCard"+e).html(""):"",$(".cart"+a).length>0?$(".cart"+a).html(""):"",$(".RemoveFromCartGiftCard"+a).length>0?$(".RemoveFromCartGiftCard"+a).remove():"";
            var i=0==$.trim(r)||1==$.trim(r)?"<strong>"+$.trim(r)+"</strong>item":"<strong>"+$.trim(r)+"</strong>items";
            $("#cartValue").html(i),$("#cartValue2").html(r),$(".scroll-pane").jScrollPane(),location.reload()
        }else location.reload()
    })
}
function RemovePackageFromCart1(e,t,a,r,i){
    $.post(a+"common/ajax/ajax_cart.php",{
        action:"RemovePackageFromCart",
        pid:e,
        pkgIndex:t,
        qty:i
    },function(t){
        var a=t;
        if(a>0){
            $("#RemoveFromCartPkg"+e).length>0?$("#RemoveFromCartPkg"+e).html(""):"",$("#cart"+e).length>0?$("#cart"+e).html(""):"",$(".RemoveFromCartPkg"+r).length>0?$(".RemoveFromCartPkg"+r).remove():"";
            var i=0==$.trim(a)||1==$.trim(a)?"<strong>"+$.trim(a)+"</strong>item":"<strong>"+$.trim(a)+"</strong>items";
            $("#cartValue").html(i),$("#cartValue2").html(a),$(".scroll-pane").jScrollPane(),location.reload()
        }else location.reload()
    })
}
function addToAjaxCartHeader(){
    $.post(SITE_ROOT_URL+"common/ajax/ajax_cart.php",{
        action:"addToAjaxCartHeader"
    },function(e){
        $(".cart_complete").html(e),$(".cart_row").show(),$(".scroll-pane").jScrollPane()
    })
}
function loginActionCustomerToWish(){
    var e="0",t=/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/,a="customer",r=$("#frmUserEmailLnRev").val(),i=$("#frmUserPasswordLnRev").val();
    if(""==r||null==r){
        $(".frmUserEmailLn").css("display","block");
        var n=errorMessageLogin("");
        return $(".frmUserEmailLn").html(n),$("#frmUserEmailLnRev").focus(),!1
    }
    if(!t.test(r)){
        $(".frmUserEmailLn").css("display","block");
        var n=errorMessageLogin("email");
        return $(".frmUserEmailLn").html(n),$("#frmUserEmailLnRev").focus(),!1
    }
    if($(".frmUserEmailLn").html(""),""==i||null==i){
        $(".frmUserPasswordLn").css("display","block");
        var n=errorMessageLogin("");
        return $(".frmUserPasswordLn").html(n),$("#frmUserPasswordLnRev").focus(),!1
    }
    $(".frmUserPasswordLn").html(""),e="1","1"==e&&$.post(SITE_ROOT_URL+"common/ajax/ajax_login.php",{
        action:"LoginToSaveProduct",
        frmUserType:a,
        frmUserEmail:r,
        frmUserpassword:i,
        pid:$("#frmProductToWish").val()
    },function(h){
        if(h==1)
        {
            window.location.reload();
        }
        else
        {
            $("#LoginErrorMsgRev").html(h)
        }          
    })
}
function quantityCartPlusMinus(e,t,a,r,i,n,o,s,l,obj){
    //console.log(e+'=='+t+'=='+a+'=='+r+'=='+i+'=='+n+'=='+o+'=='+s+'=='+l+'=='+obj)
    if(a=a.replace(r,""),a=a.replace(",",""),a=a,t){
        var d="",c=parseFloat(a).toFixed(2),u=$("#frmCartQty_"+t+"_"+o),p=$("#cartValue >strong").html(),h=$("#cartValue2").html();
        //alert($(u).attr('id'));
        if(d=$(u).val(),parseInt(d)>=parseInt(l)&&"1"==e){
            if("product"==i)return $("#maxqty_"+t+"_"+o).show(),$("#maxqty_"+t+"_"+o).html("Maximum quantity is "+l),$(".product"+t+"_"+o).css("background","#e9666a"),!1;
            if("package"==i)return $(".package"+t+"_"+o).css("background","#e9666a"),!1
        }else if("product"==i&&($("#maxqty_"+t+"_"+o).hide(),$(".product"+t+"_"+o).css("background","#c0c0c0")),"package"==i&&$(".package"+t+"_"+o).css("background","#c0c0c0"),"1"==e?(d=parseInt(d)+1,$(u).val(d)):(d=parseInt(d)-1,d>0&&$(u).val(d)),"1"==e?(p=parseInt(p)+1,$("#cartValue").find("strong").html(p)):(p=parseInt(p)-1,d>0&&$("#cartValue > strong").html(p)),"1"==e?(h=parseInt(h)+1,$("#cartValue2").html(h)):(h=parseInt(h)-1,d>0&&$("#cartValue2").html(h)),d>=1){
            
            $(".sub_total #totalCartCost_"+t+"_"+o).html(r+(c*d).toFixed(2));
            var f=$("#subTotalP").html(),m=$("#DiscountCouponP").html(),g=$(".total_sec .last").find("strong").html();
            f=f.replace(r,""),m=m.replace("- "+r,""),g=g.replace(r,""),f="1"==e?parseFloat(f.replace(",",""))+parseFloat(c.replace(",","")):parseFloat(f.replace(",",""))-parseFloat(c.replace(",",""));
            var v=$("#DiscountCouponPValue").val();
            
            //alert(v+'=='+g);
            //g=0!=v?parseFloat(f)-parseFloat(a)*parseFloat(v)/100:f,$("#subTotalP").html(r+f.toFixed(2)),$("#DiscountCouponP").html(0!=v?r+(parseFloat(f)*parseFloat(v)/100).toFixed(2):r+" 0.00"),$(".total_sec .last").find("strong").html(r+g.toFixed(2));
            z=m.replace(r,"");
            z=z.replace("- "+r,"")
            z=z.replace("-","")
            y='0.00';
            if (i=='product') {
                if (0==e) {
                    y=0!=v?(parseFloat(z)-(parseFloat(a)*parseFloat(v)/100)).toFixed(2) : '0.00';
                }else{
                    y=0!=v?(parseFloat(z)+(parseFloat(a)*parseFloat(v)/100)).toFixed(2) : '0.00';
                }
            }else{
                y=z;
            }
            //console.log(y);
            
            g=0!=v?parseFloat(f)-parseFloat(y):f,$("#subTotalP").html(r+f.toFixed(2)),"product"==i ?$("#DiscountCouponP").html('-'+r+y) : '',$(".total_sec .last").find("strong").html(r+g.toFixed(2));
            //console.log('z='+z+'a='+a+'v='+v+'**m='+z+'**g='+g+'**r='+r+'**f='+f);
            //return false;
            var y=i,x=t,n=n,w=SITE_ROOT_URL,o=o,s=s,_=d,C=$(obj).parent().find('input:last').val();
            console.log(C);
            //$(obj).parent().find('input:last').val(e.qty)
            $.post(w+"common/ajax/ajax_cart.php",{
                action:"UpdateMyCartHeader",
                pid:x,
                pkgIndex:n,
                type:y,
                qty:_,
                pri:s,
                oldQty:C
            },function(e){
                console.log(e);
                //$("#frmProductQuantityOld"+o).val(e.oldVal)
                $(obj).parent().find('input:last').val(e.oldVal)
            },"json")
        }
    }
}!function(e){
    e("html").addClass("stylish-select"),Array.prototype.indexOf||(Array.prototype.indexOf=function(e){
        if(void 0===this||null===this)throw new TypeError;
        var t=Object(this),a=t.length>>>0;
        if(0===a)return-1;
        var r=0;
        if(arguments.length>0&&(r=Number(arguments[1]),r!==r?r=0:0!==r&&r!==1/0&&r!==-(1/0)&&(r=(r>0||-1)*Math.floor(Math.abs(r)))),r>=a)return-1;
        for(var i=r>=0?r:Math.max(a-Math.abs(r),0);a>i;i++)if(i in t&&t[i]===e)return i;return-1
    }),e.fn.extend({
        getSetSSValue:function(t){
            return t?(e(this).val(t).change(),this):e(this).find(":selected").val()
        },
        resetSS:function(){
            var t=e(this).data("ssOpts");
            $this=e(this),$this.next().remove(),$this.unbind(".sSelect").sSelect(t)
        }
    }),e.fn.sSelect=function(t){
        return this.each(function(){
            function a(t,a){
                var r=e(t).text(),i=e(t).val(),n=e(t).is(":disabled");
                n||e(t).parents().is(":disabled")||T.push(r.charAt(0).toLowerCase()),a.append(e("<li><a"+(n?' class="newListItemDisabled"':"")+' href="JavaScript:void(0);">'+r+"</a></li>").data({
                    key:i,
                    selected:e(t).is(":selected")
                }))
            }
            function r(){
                var t=x.offset().top,a=e(window).height(),r=e(window).scrollTop();
                F>parseInt(g.ddMaxHeight)&&(F=parseInt(g.ddMaxHeight)),t-=r,t+F>=a?(_.css({
                    height:F
                }),w.css({
                    top:"-"+F+"px",
                    height:F
                }),v.onTop=!0):(_.css({
                    height:F
                }),w.css({
                    top:S+"px",
                    height:F
                }),v.onTop=!1)
            }
            function i(){
                x.css("position","relative")
            }
            function n(){
                x.css({
                    position:"static"
                })
            }
            function o(e,t){
                1==e&&(b=C,v.change()),1==t&&(C=b,s(C)),w.hide(),n()
            }
            function s(e,t){
                if(-1==e)y.text(g.defaultText),f.removeClass("hiLite");
                else{
                    f.removeClass("hiLite").eq(e).addClass("hiLite");
                    var a=f.eq(e).text(),r=f.eq(e).parent().data("key");
                    try{
                        v.val(r)
                    }catch(i){
                        v[0].selectedIndex=e
                    }
                    if(y.text(a),1==t&&(b=e,v.change()),w.is(":visible"))try{
                        f.eq(e).focus()
                    }catch(i){}
                }
            }
            function l(t){
                e(t).unbind("keydown.sSelect").bind("keydown.sSelect",function(e){
                    var t=e.which;
                    switch(D=!0,t){
                        case 40:case 39:
                            return d(),!1;
                        case 38:case 37:
                            return c(),!1;
                        case 33:case 36:
                            return u(),!1;
                        case 34:case 35:
                            return p(),!1;
                        case 13:case 27:
                            return o(!0),!1;
                        case 9:
                            return o(!0),h(),!1
                    }
                    keyPressed=String.fromCharCode(t).toLowerCase();
                    var a=T.indexOf(keyPressed);
                    return"undefined"!=typeof a?(++C,C=T.indexOf(keyPressed,C),(-1==C||null==C||k!=keyPressed)&&(C=T.indexOf(keyPressed)),s(C),k=keyPressed,!1):void 0
                })
            }
            function d(){
                $-1>C&&(++C,s(C))
            }
            function c(){
                C>0&&(--C,s(C))
            }
            function u(){
                C=0,s(C)
            }
            function p(){
                C=$-1,s(C)
            }
            function h(){
                var t=e("body").find("button,input,textarea,select"),a=t.index(v);
                return a>-1&&a+1<t.length&&t.eq(a+1).focus(),!1
            }
            var f,m={
                defaultText:"Please select",
                animationSpeed:0,
                ddMaxHeight:"",
                containerClass:""
            },g=e.extend(m,t),v=e(this),y=e('<div class="selectedTxt"></div>'),x=e('<div class="newListSelected '+g.containerClass+(v.is(":disabled")?"newListDisabled":"")+'"></div>'),w=e('<div class="SSContainerDivWrapper" style="visibility:hidden;"></div>'),_=e('<ul class="newList"></ul>'),C=-1,b=-1,T=[],k=!1,D=!1;
            if(e(this).data("ssOpts",t),x.insertAfter(v),x.attr("tabindex",v.attr("tabindex")||"0"),y.prependTo(x),_.appendTo(x),_.wrap(w),w=_.parent(),v.hide(),!v.is(":disabled")){
                y.data("ssReRender",!y.is(":visible")),v.children().each(function(){
                    if(e(this).is("option"))a(this,_);
                    else{
                        var t=e(this).attr("label"),r=e('<li class="newListOptionTitle '+(e(this).is(":disabled")?"newListOptionDisabled":"")+'">'+t+"</li>"),i=e("<ul></ul>");
                        r.appendTo(_),i.appendTo(r),e(this).children().each(function(){
                            a(this,i)
                        })
                    }
                }),f=_.find("li a:not(.newListItemDisabled)").not(function(){
                    return e(this).parents().hasClass("newListOptionDisabled")
                }),f.each(function(t){
                    e(this).parent().data("selected")&&(g.defaultText=e(this).html(),C=b=t)
                });
                var F=_.height(),S=x.height(),$=f.length;
                -1!=C?s(C):y.text(g.defaultText),r(),e(window).bind("resize.sSelect scroll.sSelect",r),y.bind("click.sSelect",function(t){
                    t.stopPropagation(),e(this).data("ssReRender")&&(F=_.height("").height(),w.height(""),S=x.height(),e(this).data("ssReRender",!1),r()),e(".SSContainerDivWrapper").not(e(this).next()).hide().parent().css("position","static").removeClass("newListSelFocus"),w.toggle(),i(),-1==C&&(C=0);
                    try{
                        f.eq(C).focus()
                    }catch(a){}
                }),f.bind("click.sSelect",function(t){
                    var a=e(t.target);
                    C=f.index(a),D=!0,s(C,!0),o()
                }),f.bind("mouseenter.sSelect",function(t){
                    var a=e(t.target);
                    a.addClass("newListHover")
                }).bind("mouseleave.sSelect",function(t){
                    var a=e(t.target);
                    a.removeClass("newListHover")
                }),v.bind("change.sSelect",function(t){
                    var a=e(t.target);
                    if(1==D)return D=!1,!1;
                    var r=a.find(":selected");
                    C=a.find("option").index(r),s(C)
                }),x.bind("click.sSelect",function(e){
                    e.stopPropagation(),l(this)
                }),x.bind("focus.sSelect",function(){
                    e(this).addClass("newListSelFocus"),l(this)
                }),x.bind("blur.sSelect",function(){
                    e(this).removeClass("newListSelFocus")
                }),e(document).bind("click.sSelect",function(){
                    x.removeClass("newListSelFocus"),w.is(":visible")?o(!1,!0):o(!1)
                }),v.focus(function(){
                    v.next().focus()
                }),y.bind("mouseenter.sSelect",function(t){
                    var a=e(t.target);
                    a.parent().addClass("newListSelHover")
                }).bind("mouseleave.sSelect",function(t){
                    var a=e(t.target);
                    a.parent().removeClass("newListSelHover")
                }),w.css({
                    left:"0",
                    display:"none",
                    visibility:"visible"
                })
            }
        })
    }
}(jQuery),$(document).ready(function(){
    $(".my-dropdown").sSelect(),$("#shStep4").hide(),$(".setting").click(function(){
        return $(this).parents().find(".dropBlock").slideToggle(),$(this).toggleClass("active"),!1
    })
}),function(e,t,a){
    e.fn.jScrollPane=function(r){
        function i(r,i){
            function n(t){
                var i,s,d,u,p,h,g=!1,v=!1;
                if(H=t,q===a)p=r.scrollTop(),h=r.scrollLeft(),r.css({
                    overflow:"hidden",
                    padding:0
                }),W=r.innerWidth()+xt,V=r.innerHeight(),r.width(W),q=e('<div class="jspPane" />').css("padding",yt).append(r.children()),B=e('<div class="jspContainer" />').css({
                    width:W+"px",
                    height:"233px"
                }).append(q).appendTo(r);
                else{
                    if(r.css("width",""),g=H.stickToBottom&&S(),v=H.stickToRight&&$(),u=r.innerWidth()+xt!=W||r.outerHeight()!=V,u&&(W=r.innerWidth()+xt,V=r.innerHeight(),B.css({
                        width:W+"px",
                        height:V+"px"
                    })),!u&&wt==Y&&q.outerHeight()==z)return void r.width(W);
                    wt=Y,q.css("width",""),r.width(W),B.find(">.jspVerticalBar,>.jspHorizontalBar").remove().end()
                }
                q.css("overflow","auto"),Y=t.contentWidth?t.contentWidth:q[0].scrollWidth,z=q[0].scrollHeight,q.css("overflow",""),G=Y/W,K=z/V,Q=K>1,J=G>1,J||Q?(r.addClass("jspScrollable"),i=H.maintainPosition&&(et||rt),i&&(s=D(),d=F()),o(),l(),c(),i&&(T(v?Y-W:s,!1),b(g?z-V:d,!1)),A(),E(),I(),H.enableKeyboardNavigation&&L(),H.clickOnTrack&&f(),N(),H.hijackInternalLinks&&R()):(r.removeClass("jspScrollable"),q.css({
                    top:0,
                    width:B.width()-xt
                }),j(),M(),O(),m()),H.autoReinitialise&&!vt?vt=setInterval(function(){
                    n(H)
                },H.autoReinitialiseDelay):!H.autoReinitialise&&vt&&clearInterval(vt),p&&r.scrollTop(0)&&b(p,!1),h&&r.scrollLeft(0)&&T(h,!1),r.trigger("jsp-initialised",[J||Q])
            }
            function o(){
                Q&&(B.append(e('<div class="jspVerticalBar" />').append(e('<div class="jspCap jspCapTop" />'),e('<div class="jspTrack" />').append(e('<div class="jspDrag" />').append(e('<div class="jspDragTop" />'),e('<div class="jspDragBottom" />'))),e('<div class="jspCap jspCapBottom" />'))),it=B.find(">.jspVerticalBar"),nt=it.find(">.jspTrack"),X=nt.find(">.jspDrag"),H.showArrows&&(dt=e('<a class="jspArrow jspArrowUp" />').bind("mousedown.jsp",p(0,-1)).bind("click.jsp",P),ct=e('<a class="jspArrow jspArrowDown" />').bind("mousedown.jsp",p(0,1)).bind("click.jsp",P),H.arrowScrollOnHover&&(dt.bind("mouseover.jsp",p(0,-1,dt)),ct.bind("mouseover.jsp",p(0,1,ct))),u(nt,H.verticalArrowPositions,dt,ct)),st=V,B.find(">.jspVerticalBar>.jspCap:visible,>.jspVerticalBar>.jspArrow").each(function(){
                    st-=e(this).outerHeight()
                }),X.hover(function(){
                    X.addClass("jspHover")
                },function(){
                    X.removeClass("jspHover")
                }).bind("mousedown.jsp",function(t){
                    e("html").bind("dragstart.jsp selectstart.jsp",P),X.addClass("jspActive");
                    var a=t.pageY-X.position().top;
                    return e("html").bind("mousemove.jsp",function(e){
                        v(e.pageY-a,!1)
                    }).bind("mouseup.jsp mouseleave.jsp",g),!1
                }),s())
            }
            function s(){
                nt.height(st+"px"),et=0,ot=H.verticalGutter+nt.outerWidth(),q.width(W-ot-xt);
                try{
                    0===it.position().left&&q.css("margin-left",ot+"px")
                }catch(e){}
            }
            function l(){
                J&&(B.append(e('<div class="jspHorizontalBar" />').append(e('<div class="jspCap jspCapLeft" />'),e('<div class="jspTrack" />').append(e('<div class="jspDrag" />').append(e('<div class="jspDragLeft" />'),e('<div class="jspDragRight" />'))),e('<div class="jspCap jspCapRight" />'))),ut=B.find(">.jspHorizontalBar"),pt=ut.find(">.jspTrack"),tt=pt.find(">.jspDrag"),H.showArrows&&(mt=e('<a class="jspArrow jspArrowLeft" />').bind("mousedown.jsp",p(-1,0)).bind("click.jsp",P),gt=e('<a class="jspArrow jspArrowRight" />').bind("mousedown.jsp",p(1,0)).bind("click.jsp",P),H.arrowScrollOnHover&&(mt.bind("mouseover.jsp",p(-1,0,mt)),gt.bind("mouseover.jsp",p(1,0,gt))),u(pt,H.horizontalArrowPositions,mt,gt)),tt.hover(function(){
                    tt.addClass("jspHover")
                },function(){
                    tt.removeClass("jspHover")
                }).bind("mousedown.jsp",function(t){
                    e("html").bind("dragstart.jsp selectstart.jsp",P),tt.addClass("jspActive");
                    var a=t.pageX-tt.position().left;
                    return e("html").bind("mousemove.jsp",function(e){
                        x(e.pageX-a,!1)
                    }).bind("mouseup.jsp mouseleave.jsp",g),!1
                }),ht=B.innerWidth(),d())
            }
            function d(){
                B.find(">.jspHorizontalBar>.jspCap:visible,>.jspHorizontalBar>.jspArrow").each(function(){
                    ht-=e(this).outerWidth()
                }),pt.width(ht+"px"),rt=0
            }
            function c(){
                if(J&&Q){
                    var t=pt.outerHeight(),a=nt.outerWidth();
                    st-=t,e(ut).find(">.jspCap:visible,>.jspArrow").each(function(){
                        ht+=e(this).outerWidth()
                    }),ht-=a,V-=a,W-=t,pt.parent().append(e('<div class="jspCorner" />').css("width",t+"px")),s(),d()
                }
                J&&q.width(B.outerWidth()-xt+"px"),z=q.outerHeight(),K=z/V,J&&(ft=Math.ceil(1/G*ht),ft>H.horizontalDragMaxWidth?ft=H.horizontalDragMaxWidth:ft<H.horizontalDragMinWidth&&(ft=H.horizontalDragMinWidth),tt.width(ft+"px"),at=ht-ft,w(rt)),Q&&(lt=Math.ceil(1/K*st),lt>H.verticalDragMaxHeight?lt=H.verticalDragMaxHeight:lt<H.verticalDragMinHeight&&(lt=H.verticalDragMinHeight),X.height(lt+"px"),Z=st-lt,y(et))
            }
            function u(e,t,a,r){
                var i,n="before",o="after";
                "os"==t&&(t=/Mac/.test(navigator.platform)?"after":"split"),t==n?o=t:t==o&&(n=t,i=a,a=r,r=i),e[n](a)[o](r)
            }
            function p(e,t,a){
                return function(){
                    return h(e,t,this,a),this.blur(),!1
                }
            }
            function h(t,a,r,i){
                r=e(r).addClass("jspActive");
                var n,o,s=!0,l=function(){
                    0!==t&&_t.scrollByX(t*H.arrowButtonSpeed),0!==a&&_t.scrollByY(a*H.arrowButtonSpeed),o=setTimeout(l,s?H.initialDelay:H.arrowRepeatFreq),s=!1
                };

                l(),n=i?"mouseout.jsp":"mouseup.jsp",i=i||e("html"),i.bind(n,function(){
                    r.removeClass("jspActive"),o&&clearTimeout(o),o=null,i.unbind(n)
                })
            }
            function f(){
                m(),Q&&nt.bind("mousedown.jsp",function(t){
                    if(t.originalTarget===a||t.originalTarget==t.currentTarget){
                        var r,i=e(this),n=i.offset(),o=t.pageY-n.top-et,s=!0,l=function(){
                            var e=i.offset(),a=t.pageY-e.top-lt/2,n=V*H.scrollPagePercent,c=Z*n/(z-V);
                            if(0>o)et-c>a?_t.scrollByY(-n):v(a);
                            else{
                                if(!(o>0))return void d();
                                a>et+c?_t.scrollByY(n):v(a)
                            }
                            r=setTimeout(l,s?H.initialDelay:H.trackClickRepeatFreq),s=!1
                        },d=function(){
                            r&&clearTimeout(r),r=null,e(document).unbind("mouseup.jsp",d)
                        };

                        return l(),e(document).bind("mouseup.jsp",d),!1
                    }
                }),J&&pt.bind("mousedown.jsp",function(t){
                    if(t.originalTarget===a||t.originalTarget==t.currentTarget){
                        var r,i=e(this),n=i.offset(),o=t.pageX-n.left-rt,s=!0,l=function(){
                            var e=i.offset(),a=t.pageX-e.left-ft/2,n=W*H.scrollPagePercent,c=at*n/(Y-W);
                            if(0>o)rt-c>a?_t.scrollByX(-n):x(a);
                            else{
                                if(!(o>0))return void d();
                                a>rt+c?_t.scrollByX(n):x(a)
                            }
                            r=setTimeout(l,s?H.initialDelay:H.trackClickRepeatFreq),s=!1
                        },d=function(){
                            r&&clearTimeout(r),r=null,e(document).unbind("mouseup.jsp",d)
                        };

                        return l(),e(document).bind("mouseup.jsp",d),!1
                    }
                })
            }
            function m(){
                pt&&pt.unbind("mousedown.jsp"),nt&&nt.unbind("mousedown.jsp")
            }
            function g(){
                e("html").unbind("dragstart.jsp selectstart.jsp mousemove.jsp mouseup.jsp mouseleave.jsp"),X&&X.removeClass("jspActive"),tt&&tt.removeClass("jspActive")
            }
            function v(e,t){
                Q&&(0>e?e=0:e>Z&&(e=Z),t===a&&(t=H.animateScroll),t?_t.animate(X,"top",e,y):(X.css("top",e),y(e)))
            }
            function y(e){
                e===a&&(e=X.position().top),B.scrollTop(0),et=e;
                var t=0===et,i=et==Z,n=e/Z,o=-n*(z-V);
                (Ct!=t||Tt!=i)&&(Ct=t,Tt=i,r.trigger("jsp-arrow-change",[Ct,Tt,bt,kt])),_(t,i),q.css("top",o),r.trigger("jsp-scroll-y",[-o,t,i]).trigger("scroll")
            }
            function x(e,t){
                J&&(0>e?e=0:e>at&&(e=at),t===a&&(t=H.animateScroll),t?_t.animate(tt,"left",e,w):(tt.css("left",e),w(e)))
            }
            function w(e){
                e===a&&(e=tt.position().left),B.scrollTop(0),rt=e;
                var t=0===rt,i=rt==at,n=e/at,o=-n*(Y-W);
                (bt!=t||kt!=i)&&(bt=t,kt=i,r.trigger("jsp-arrow-change",[Ct,Tt,bt,kt])),C(t,i),q.css("left",o),r.trigger("jsp-scroll-x",[-o,t,i]).trigger("scroll")
            }
            function _(e,t){
                H.showArrows&&(dt[e?"addClass":"removeClass"]("jspDisabled"),ct[t?"addClass":"removeClass"]("jspDisabled"))
            }
            function C(e,t){
                H.showArrows&&(mt[e?"addClass":"removeClass"]("jspDisabled"),gt[t?"addClass":"removeClass"]("jspDisabled"))
            }
            function b(e,t){
                var a=e/(z-V);
                v(a*Z,t)
            }
            function T(e,t){
                var a=e/(Y-W);
                x(a*at,t)
            }
            function k(t,a,r){
                var i,n,o,s,l,d,c,u,p,h=0,f=0;
                try{
                    i=e(t)
                }catch(m){
                    return
                }
                for(n=i.outerHeight(),o=i.outerWidth(),B.scrollTop(0),B.scrollLeft(0);!i.is(".jspPane");)if(h+=i.position().top,f+=i.position().left,i=i.offsetParent(),/^body|html$/i.test(i[0].nodeName))return;s=F(),d=s+V,s>h||a?u=h-H.verticalGutter:h+n>d&&(u=h-V+n+H.verticalGutter),u&&b(u,r),l=D(),c=l+W,l>f||a?p=f-H.horizontalGutter:f+o>c&&(p=f-W+o+H.horizontalGutter),p&&T(p,r)
            }
            function D(){
                return-q.position().left
            }
            function F(){
                return-q.position().top
            }
            function S(){
                var e=z-V;
                return e>20&&e-F()<10
            }
            function $(){
                var e=Y-W;
                return e>20&&e-D()<10
            }
            function E(){
                B.unbind(Ft).bind(Ft,function(e,t,a,r){
                    var i=rt,n=et;
                    return _t.scrollBy(a*H.mouseWheelSpeed,-r*H.mouseWheelSpeed,!1),i==rt&&n==et
                })
            }
            function j(){
                B.unbind(Ft)
            }
            function P(){
                return!1
            }
            function A(){
                q.find(":input,a").unbind("focus.jsp").bind("focus.jsp",function(e){
                    k(e.target,!1)
                })
            }
            function M(){
                q.find(":input,a").unbind("focus.jsp")
            }
            function L(){
                function t(){
                    var e=rt,t=et;
                    switch(a){
                        case 40:
                            _t.scrollByY(H.keyboardSpeed,!1);
                            break;
                        case 38:
                            _t.scrollByY(-H.keyboardSpeed,!1);
                            break;
                        case 34:case 32:
                            _t.scrollByY(V*H.scrollPagePercent,!1);
                            break;
                        case 33:
                            _t.scrollByY(-V*H.scrollPagePercent,!1);
                            break;
                        case 39:
                            _t.scrollByX(H.keyboardSpeed,!1);
                            break;
                        case 37:
                            _t.scrollByX(-H.keyboardSpeed,!1)
                    }
                    return i=e!=rt||t!=et
                }
                var a,i,n=[];
                J&&n.push(ut[0]),Q&&n.push(it[0]),q.focus(function(){
                    r.focus()
                }),r.attr("tabindex",0).unbind("keydown.jsp keypress.jsp").bind("keydown.jsp",function(r){
                    if(r.target===this||n.length&&e(r.target).closest(n).length){
                        var o=rt,s=et;
                        switch(r.keyCode){
                            case 40:case 38:case 34:case 32:case 33:case 39:case 37:
                                a=r.keyCode,t();
                                break;
                            case 35:
                                b(z-V),a=null;
                                break;
                            case 36:
                                b(0),a=null
                        }
                        return i=r.keyCode==a&&o!=rt||s!=et,!i
                    }
                }).bind("keypress.jsp",function(e){
                    return e.keyCode==a&&t(),!i
                }),H.hideFocus?(r.css("outline","none"),"hideFocus"in B[0]&&r.attr("hideFocus",!0)):(r.css("outline",""),"hideFocus"in B[0]&&r.attr("hideFocus",!1))
            }
            function O(){
                r.attr("tabindex","-1").removeAttr("tabindex").unbind("keydown.jsp keypress.jsp")
            }
            function N(){
                if(location.hash&&location.hash.length>1){
                    var t,a,r=escape(location.hash.substr(1));
                    try{
                        t=e("#"+r+', a[name="'+r+'"]')
                    }catch(i){
                        return
                    }
                    t.length&&q.find(r)&&(0===B.scrollTop()?a=setInterval(function(){
                        B.scrollTop()>0&&(k(t,!0),e(document).scrollTop(B.position().top),clearInterval(a))
                    },50):(k(t,!0),e(document).scrollTop(B.position().top)))
                }
            }
            function R(){
                e(document.body).data("jspHijack")||(e(document.body).data("jspHijack",!0),e(document.body).delegate("a[href*=#]","click",function(a){
                    var r,i,n,o,s,l,d=this.href.substr(0,this.href.indexOf("#")),c=location.href;
                    if(-1!==location.href.indexOf("#")&&(c=location.href.substr(0,location.href.indexOf("#"))),d===c){
                        r=escape(this.href.substr(this.href.indexOf("#")+1));
                        try{
                            i=e("#"+r+', a[name="'+r+'"]')
                        }catch(u){
                            return
                        }
                        i.length&&(n=i.closest(".jspScrollable"),o=n.data("jsp"),o.scrollToElement(i,!0),n[0].scrollIntoView&&(s=e(t).scrollTop(),l=i.offset().top,(s>l||l>s+e(t).height())&&n[0].scrollIntoView()),a.preventDefault())
                    }
                }))
            }
            function I(){
                var e,t,a,r,i,n=!1;
                B.unbind("touchstart.jsp touchmove.jsp touchend.jsp click.jsp-touchclick").bind("touchstart.jsp",function(o){
                    var s=o.originalEvent.touches[0];
                    e=D(),t=F(),a=s.pageX,r=s.pageY,i=!1,n=!0
                }).bind("touchmove.jsp",function(o){
                    if(n){
                        var s=o.originalEvent.touches[0],l=rt,d=et;
                        return _t.scrollTo(e+a-s.pageX,t+r-s.pageY),i=i||Math.abs(a-s.pageX)>5||Math.abs(r-s.pageY)>5,l==rt&&d==et
                    }
                }).bind("touchend.jsp",function(){
                    n=!1
                }).bind("click.jsp-touchclick",function(){
                    return i?(i=!1,!1):void 0
                })
            }
            function U(){
                var e=F(),t=D();
                r.removeClass("jspScrollable").unbind(".jsp"),r.replaceWith(Dt.append(q.children())),Dt.scrollTop(e),Dt.scrollLeft(t),vt&&clearInterval(vt)
            }
            var H,q,W,V,B,Y,z,G,K,Q,J,X,Z,et,tt,at,rt,it,nt,ot,st,lt,dt,ct,ut,pt,ht,ft,mt,gt,vt,yt,xt,wt,_t=this,Ct=!0,bt=!0,Tt=!1,kt=!1,Dt=r.clone(!1,!1).empty(),Ft=e.fn.mwheelIntent?"mwheelIntent.jsp":"mousewheel.jsp";
            yt=r.css("paddingTop")+" "+r.css("paddingRight")+" "+r.css("paddingBottom")+" "+r.css("paddingLeft"),xt=(parseInt(r.css("paddingLeft"),10)||0)+(parseInt(r.css("paddingRight"),10)||0),e.extend(_t,{
                reinitialise:function(t){
                    t=e.extend({},H,t),n(t)
                },
                scrollToElement:function(e,t,a){
                    k(e,t,a)
                },
                scrollTo:function(e,t,a){
                    T(e,a),b(t,a)
                },
                scrollToX:function(e,t){
                    T(e,t)
                },
                scrollToY:function(e,t){
                    b(e,t)
                },
                scrollToPercentX:function(e,t){
                    T(e*(Y-W),t)
                },
                scrollToPercentY:function(e,t){
                    b(e*(z-V),t)
                },
                scrollBy:function(e,t,a){
                    _t.scrollByX(e,a),_t.scrollByY(t,a)
                },
                scrollByX:function(e,t){
                    var a=D()+Math[0>e?"floor":"ceil"](e),r=a/(Y-W);
                    x(r*at,t)
                },
                scrollByY:function(e,t){
                    var a=F()+Math[0>e?"floor":"ceil"](e),r=a/(z-V);
                    v(r*Z,t)
                },
                positionDragX:function(e,t){
                    x(e,t)
                },
                positionDragY:function(e,t){
                    v(e,t)
                },
                animate:function(e,t,a,r){
                    var i={};

                    i[t]=a,e.animate(i,{
                        duration:H.animateDuration,
                        easing:H.animateEase,
                        queue:!1,
                        step:r
                    })
                },
                getContentPositionX:function(){
                    return D()
                },
                getContentPositionY:function(){
                    return F()
                },
                getContentWidth:function(){
                    return Y
                },
                getContentHeight:function(){
                    return z
                },
                getPercentScrolledX:function(){
                    return D()/(Y-W)
                },
                getPercentScrolledY:function(){
                    return F()/(z-V)
                },
                getIsScrollableH:function(){
                    return J
                },
                getIsScrollableV:function(){
                    return Q
                },
                getContentPane:function(){
                    return q
                },
                scrollToBottom:function(e){
                    v(Z,e)
                },
                hijackInternalLinks:e.noop,
                destroy:function(){
                    U()
                }
            }),n(i)
        }
        return r=e.extend({},e.fn.jScrollPane.defaults,r),e.each(["mouseWheelSpeed","arrowButtonSpeed","trackClickSpeed","keyboardSpeed"],function(){
            r[this]=r[this]||r.speed
        }),this.each(function(){
            var t=e(this),a=t.data("jsp");
            a?a.reinitialise(r):(e("script",t).filter('[type="text/javascript"],:not([type])').remove(),a=new i(t,r),t.data("jsp",a))
        })
    },e.fn.jScrollPane.defaults={
        showArrows:!1,
        maintainPosition:!0,
        stickToBottom:!1,
        stickToRight:!1,
        clickOnTrack:!0,
        autoReinitialise:!1,
        autoReinitialiseDelay:500,
        verticalDragMinHeight:0,
        verticalDragMaxHeight:99999,
        horizontalDragMinWidth:0,
        horizontalDragMaxWidth:99999,
        contentWidth:a,
        animateScroll:!1,
        animateDuration:300,
        animateEase:"linear",
        hijackInternalLinks:!1,
        verticalGutter:4,
        horizontalGutter:4,
        mouseWheelSpeed:0,
        arrowButtonSpeed:0,
        arrowRepeatFreq:50,
        arrowScrollOnHover:!1,
        trackClickSpeed:0,
        trackClickRepeatFreq:70,
        verticalArrowPositions:"split",
        horizontalArrowPositions:"split",
        enableKeyboardNavigation:!0,
        hideFocus:!1,
        keyboardSpeed:0,
        initialDelay:300,
        speed:30,
        scrollPagePercent:.8
    }
}(jQuery,this);
var checkboxHeight="25",radioHeight="20",selectWidth="190";
document.write('<style type="text/css">input.styled { display: none; } select.styled { position: relative; width: '+selectWidth+"px; opacity: 0; filter: alpha(opacity=0); z-index: 5; } .disabled { opacity: 0.5; filter: alpha(opacity=50); }</style>");
var Custom={
    init:function(){
        var e,t,r,i=document.getElementsByTagName("input"),n=Array();
        for(a=0;a<i.length;a++)"checkbox"!=i[a].type&&"radio"!=i[a].type||"styled"!=i[a].className||(n[a]=document.createElement("span"),n[a].className=i[a].type,1==i[a].checked&&("checkbox"==i[a].type?(position="0 -"+2*checkboxHeight+"px",n[a].style.backgroundPosition=position):(position="0 -"+2*radioHeight+"px",n[a].style.backgroundPosition=position)),i[a].parentNode.insertBefore(n[a],i[a]),i[a].onchange=Custom.clear,i[a].getAttribute("disabled")?n[a].className=n[a].className+=" disabled":(n[a].onmousedown=Custom.pushed,n[a].onmouseup=Custom.check));
        for(i=document.getElementsByTagName("select"),a=0;a<i.length;a++)if("styled"==i[a].className){
            for(t=i[a].getElementsByTagName("option"),r=t[0].childNodes[0].nodeValue,e=document.createTextNode(r),b=0;b<t.length;b++)1==t[b].selected&&(e=document.createTextNode(t[b].childNodes[0].nodeValue));
            n[a]=document.createElement("span"),n[a].className="select",n[a].id="select"+i[a].name,n[a].appendChild(e),i[a].parentNode.insertBefore(n[a],i[a]),i[a].getAttribute("disabled")?i[a].previousSibling.className=i[a].previousSibling.className+=" disabled":i[a].onchange=Custom.choose
        }
        document.onmouseup=Custom.clear
    },
    pushed:function(){
        element=this.nextSibling,this.style.backgroundPosition=1==element.checked&&"checkbox"==element.type?"0 -"+3*checkboxHeight+"px":1==element.checked&&"radio"==element.type?"0 -"+3*radioHeight+"px":1!=element.checked&&"checkbox"==element.type?"0 -"+checkboxHeight+"px":"0 -"+radioHeight+"px"
    },
    check:function(){
        if(element=this.nextSibling,1==element.checked&&"checkbox"==element.type)this.style.backgroundPosition="0 0",element.checked=!1;
        else{
            if("checkbox"==element.type)this.style.backgroundPosition="0 -"+2*checkboxHeight+"px";else for(this.style.backgroundPosition="0 -"+2*radioHeight+"px",group=this.nextSibling.name,inputs=document.getElementsByTagName("input"),a=0;a<inputs.length;a++)inputs[a].name==group&&inputs[a]!=this.nextSibling&&(inputs[a].previousSibling.style.backgroundPosition="0 0");
            element.checked=!0
        }
    },
    clear:function(){
        inputs=document.getElementsByTagName("input");
        for(var e=0;e<inputs.length;e++)"checkbox"==inputs[e].type&&1==inputs[e].checked&&"styled"==inputs[e].className?inputs[e].previousSibling.style.backgroundPosition="0 -"+2*checkboxHeight+"px":"checkbox"==inputs[e].type&&"styled"==inputs[e].className?inputs[e].previousSibling.style.backgroundPosition="0 0":"radio"==inputs[e].type&&1==inputs[e].checked&&"styled"==inputs[e].className?inputs[e].previousSibling.style.backgroundPosition="0 -"+2*radioHeight+"px":"radio"==inputs[e].type&&"styled"==inputs[e].className&&(inputs[e].previousSibling.style.backgroundPosition="0 0")
    },
    choose:function(){
        for(option=this.getElementsByTagName("option"),d=0;d<option.length;d++)1==option[d].selected&&(document.getElementById("select"+this.name).childNodes[0].nodeValue=option[d].childNodes[0].nodeValue)
    }
};

window.onload=Custom.init,function(e){
    e.fn.validationEngineLanguage=function(){},e.validationEngineLanguage={
        newLang:function(){
            e.validationEngineLanguage.allRules={
                required:{
                    regex:NONE,
                    alertText:"*"+required,
                    alertTextCheckboxMultiple:"* "+SEL_OPTION,
                    alertTextCheckboxe:"* "+CHECKBOX_REQ,
                    alertTextDateRange:"* "+BOTH_DATE_RANGE_REQ
                },
                requiredInFunction:{
                    func:function(e){
                        return"test"==e.val()?!0:!1
                    },
                    alertText:"* "+FIELD_MUST_EQUAL
                },
                dateRange:{
                    regex:NONE,
                    alertText:"*  "+INVALID,
                    alertText2:DATE_RANGE
                },
                dateTimeRange:{
                    regex:"none",
                    alertText:"*  "+INVALID,
                    alertText2:DATE_TIME_RANGE
                },
                minSize:{
                    regex:NONE,
                    alertText:"* "+MINIMUM,
                    alertText2:" "+CHARACTERS_ALLOWED
                },
                minSizeWord:{
                    regex:NONE,
                    alertText:"* "+MINIMUM,
                    alertText2:" "+WORDS_ALLOWED
                },        
                maxSize:{
                    regex:NONE,
                    alertText:"* "+MINIMUM,
                    alertText2:" "+CHARACTERS_ALLOWED
                },
                groupRequired:{
                    regex:NONE,
                    alertText:"* "+MUST_FILL_ONE_FOLLOWING
                },
                min:{
                    regex:NONE,
                    alertText:"* "+MINIMUM_VAL
                },
                max:{
                    regex:NONE,
                    alertText:"* "+MAX_VAL
                },
                past:{
                    regex:NONE,
                    alertText:"* "+DATE_PRIOR
                },
                future:{
                    regex:NONE,
                    alertText:"* "+DATE_PAST
                },
                maxCheckbox:{
                    regex:NONE,
                    alertText:"*  "+MAX,
                    alertText2:" "+OPTION_ALLOW
                },
                minCheckbox:{
                    regex:NONE,
                    alertText:"* "+PLEASE_SELECT,
                    alertText2:" "+OPTIONS
                },
                equals:{
                    regex:NONE,
                    alertText:"* "+FILEDS_DOESNT_MATCH
                },
                equalss:{
                    regex:NONE,
                    alertText:"* "+FILEDS_DOESNT_MATCH
                },
                lessThan:{
                    regex:NONE,
                    alertText:"* "+FILEDS_DOESNT_MATCH
                },
                creditCard:{
                    regex:NONE,
                    alertText:"* "+INVALID_CREDIT_CARD_NO
                },
                phone:{
                    regex:/^([\+][0-9]{1,8}[\ \.\-])?([\(]{1}[0-9]{2,6}[\)])?([0-9\ \.\-\/]{8,20})((x|ext|extension)[\ ]?[0-9]{1,8})?$/,
                    alertText:"* "+INVALID_PHONE_NO
                },
                email:{
                    regex:/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/,
                    alertText:"* "+varInvalidEmail
                },
                multiemail:{
                    func:function(e){
                        var t=new RegExp(/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/),a=e.val().split(/[,]+/),r=1;
                        for(i=0;i<=a.length-1;i++){
                            var n=t.test(a[i]);
                            0==n&&(r=0)
                        }
                        return 0==r?!1:!0
                    },
                    alertText:"* "+varInvalidEmail
                },
                integer:{
                    regex:/^[\-\+]?\d+$/,
                    alertText:"* "+VALID_INTEGER
                },
                number:{
                    regex:/^[\-\+]?((([0-9]{1,3})([,][0-9]{3})*)|([0-9]+))?([\.]([0-9]+))?$/,
                    alertText:"* "+INVALID_FLO_DEC_NO
                },
                numberPositive:{
                    regex:/^[\+]?((([0-9]{1,3})([,][0-9]{3})*)|([0-9]+))?([\.]([0-9]+))?$/,
                    alertText:"* Value should not be negative."
                },
                date:{
                    func:function(e){
                        var t=new RegExp(/^(\d{4})[\/\-\.](0?[1-9]|1[012])[\/\-\.](0?[1-9]|[12][0-9]|3[01])$/),a=t.exec(e.val());
                        if(null==a)return!1;
                        var r=a[1],i=1*a[2],n=1*a[3],o=new Date(r,i-1,n);
                        return o.getFullYear()==r&&o.getMonth()==i-1&&o.getDate()==n
                    },
                    alertText:"* "+INVALID_DATE_FORMAT
                },
                ipv4:{
                    regex:/^((([01]?[0-9]{1,2})|(2[0-4][0-9])|(25[0-5]))[.]){3}(([0-1]?[0-9]{1,2})|(2[0-4][0-9])|(25[0-5]))$/,
                    alertText:"* "+INVALID_IP
                },
                url:{
                    regex:/(www.)(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(\#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i,
                    alertText:"* "+INVALID_URL
                },
                onlyNumberSp:{
                    regex:/^[0-9\ ]+$/,
                    alertText:"* "+NO_ONLY
                },
                onlyLetterSp:{
                    regex:/^[a-zA-Z\ \']+$/,
                    alertText:"* "+LETTER_ONLY
                },
                onlyLetterNumber:{
                    regex:/^[0-9a-zA-Z]+$/,
                    alertText:"* "+NO_SPC_CORREC_ALLOW
                },
                ajaxUserCall:{
                    url:"ajaxValidateFieldUser",
                    extraData:"name=eric",
                    alertText:"* "+USER_AL_TAKEN,
                    alertTextLoad:"* "+VALIDATING_WAIT
                },
                ajaxUserCallPhp:{
                    url:"phpajax/ajaxValidateFieldUser.php",
                    extraData:"name=eric",
                    alertTextOk:"* "+USER_AVILABLE,
                    alertText:"* "+USER_AL_TAKEN,
                    alertTextLoad:"* "+VALIDATING_WAIT
                },
                ajaxNameCall:{
                    url:"ajaxValidateFieldName",
                    alertText:"* "+NAME_AL_TAKEN,
                    alertTextOk:"* "+NAME_AVILABLE,
                    alertTextLoad:"* "+VALIDATING_WAIT
                },
                ajaxNameCallPhp:{
                    url:"phpajax/ajaxValidateFieldName.php",
                    alertText:"* "+NAME_AL_TAKEN,
                    alertTextLoad:"* "+VALIDATING_WAIT
                },
                validate2fields:{
                    alertText:"* "+INPUT_HELLO
                },
                dateFormat:{
                    regex:/^\d{4}[\/\-](0?[1-9]|1[012])[\/\-](0?[1-9]|[12][0-9]|3[01])$|^(?:(?:(?:0?[13578]|1[02])(\/|-)31)|(?:(?:0?[1,3-9]|1[0-2])(\/|-)(?:29|30)))(\/|-)(?:[1-9]\d\d\d|\d[1-9]\d\d|\d\d[1-9]\d|\d\d\d[1-9])$|^(?:(?:0?[1-9]|1[0-2])(\/|-)(?:0?[1-9]|1\d|2[0-8]))(\/|-)(?:[1-9]\d\d\d|\d[1-9]\d\d|\d\d[1-9]\d|\d\d\d[1-9])$|^(0?2(\/|-)29)(\/|-)(?:(?:0[48]00|[13579][26]00|[2468][048]00)|(?:\d\d)?(?:0[48]|[2468][048]|[13579][26]))$/,
                    alertText:"* "+INVALID_DATE
                },
                dateTimeFormat:{
                    regex:/^\d{4}[\/\-](0?[1-9]|1[012])[\/\-](0?[1-9]|[12][0-9]|3[01])\s+(1[012]|0?[1-9]){1}:(0?[1-5]|[0-6][0-9]){1}:(0?[0-6]|[0-6][0-9]){1}\s+(am|pm|AM|PM){1}$|^(?:(?:(?:0?[13578]|1[02])(\/|-)31)|(?:(?:0?[1,3-9]|1[0-2])(\/|-)(?:29|30)))(\/|-)(?:[1-9]\d\d\d|\d[1-9]\d\d|\d\d[1-9]\d|\d\d\d[1-9])$|^((1[012]|0?[1-9]){1}\/(0?[1-9]|[12][0-9]|3[01]){1}\/\d{2,4}\s+(1[012]|0?[1-9]){1}:(0?[1-5]|[0-6][0-9]){1}:(0?[0-6]|[0-6][0-9]){1}\s+(am|pm|AM|PM){1})$/,
                    alertText:"* "+INVALID_DATE_FOR,
                    alertText2:EXPECTED_FORMAT+": ",
                    alertText3:MM_DD,
                    alertText4:YY_MM_DD
                }
            }
        }
    },e.validationEngineLanguage.newLang()
}(jQuery),function(e){
    USE_STRICT;
    var t={
        init:function(a){
            var r=this;
            return r.data("jqv")&&null!=r.data("jqv")||(a=t._saveOptions(r,a),e(document).on("click",".formError",function(){
                e(this).fadeOut(150,function(){
                    e(this).parent(".formErrorOuter").remove(),e(this).remove()
                })
            })),this
        },
        attach:function(a){
            var r,i=this;
            return r=a?t._saveOptions(i,a):i.data("jqv"),r.validateAttribute=i.find("[data-validation-engine*=validate]").length?"data-validation-engine":"class",r.binded&&(i.on(r.validationEventTrigger,"["+r.validateAttribute+"*=validate]:not([type=checkbox]):not([type=radio]):not(.datepicker)",t._onFieldEvent),i.on("click","["+r.validateAttribute+"*=validate][type=checkbox],["+r.validateAttribute+"*=validate][type=radio]",t._onFieldEvent),i.on(r.validationEventTrigger,"["+r.validateAttribute+"*=validate][class*=datepicker]",{
                delay:300
            },t._onFieldEvent)),r.autoPositionUpdate&&e(window).bind("resize",{
                noAnimation:!0,
                formElem:i
            },t.updatePromptsPosition),i.on("click","a[data-validation-engine-skip], a[class*='validate-skip'], button[data-validation-engine-skip], button[class*='validate-skip'], input[data-validation-engine-skip], input[class*='validate-skip']",t._submitButtonClick),i.removeData("jqv_submitButton"),i.on("submit",t._onSubmitEvent),this
        },
        detach:function(){
            var a=this,r=a.data("jqv");
            return a.find("["+r.validateAttribute+"*=validate]").not("[type=checkbox]").off(r.validationEventTrigger,t._onFieldEvent),a.find("["+r.validateAttribute+"*=validate][type=checkbox],[class*=validate][type=radio]").off("click",t._onFieldEvent),a.off("submit",t._onSubmitEvent),a.removeData("jqv"),a.off("click","a[data-validation-engine-skip], a[class*='validate-skip'], button[data-validation-engine-skip], button[class*='validate-skip'], input[data-validation-engine-skip], input[class*='validate-skip']",t._submitButtonClick),a.removeData("jqv_submitButton"),r.autoPositionUpdate&&e(window).off("resize",t.updatePromptsPosition),this
        },
        validate:function(){
            var a=e(this),r=null;
            if(a.is("form")||a.hasClass("validationEngineContainer")){
                if(a.hasClass("validating"))return!1;
                a.addClass("validating");
                var i=a.data("jqv"),r=t._validateFields(this);
                setTimeout(function(){
                    a.removeClass("validating")
                },100),r&&i.onSuccess?i.onSuccess():!r&&i.onFailure&&i.onFailure()
            }else if(a.is("form")||a.hasClass("validationEngineContainer"))a.removeClass("validating");
            else{
                var n=a.closest("form, .validationEngineContainer"),i=n.data("jqv")?n.data("jqv"):e.validationEngine.defaults,r=t._validateField(a,i);
                r&&i.onFieldSuccess?i.onFieldSuccess():i.onFieldFailure&&i.InvalidFields.length>0&&i.onFieldFailure()
            }
            return i.onValidationComplete?!!i.onValidationComplete(n,r):r
        },
        updatePromptsPosition:function(a){
            if(a&&this==window)var r=a.data.formElem,i=a.data.noAnimation;else var r=e(this.closest("form, .validationEngineContainer"));
            var n=r.data("jqv");
            return r.find("["+n.validateAttribute+"*=validate]").not(":disabled").each(function(){
                var a=e(this);
                n.prettySelect&&a.is(":hidden")&&(a=r.find("#"+n.usePrefix+a.attr("id")+n.useSuffix));
                var o=t._getPrompt(a),s=e(o).find(".formErrorContent").html();
                o&&t._updatePrompt(a,e(o),s,void 0,!1,n,i)
            }),this
        },
        showPrompt:function(e,a,r,i){
            var n=this.closest("form, .validationEngineContainer"),o=n.data("jqv");
            return o||(o=t._saveOptions(this,o)),r&&(o.promptPosition=r),o.showArrow=1==i,t._showPrompt(this,e,a,!1,o),this
        },
        hide:function(){
            var a,r=e(this).closest("form, .validationEngineContainer"),i=r.data("jqv"),n=i&&i.fadeDuration?i.fadeDuration:.3;
            return a=e(this).is("form")||e(this).hasClass("validationEngineContainer")?"parentForm"+t._getClassName(e(this).attr("id")):t._getClassName(e(this).attr("id"))+"formError",e("."+a).fadeTo(n,.3,function(){
                e(this).parent(".formErrorOuter").remove(),e(this).remove()
            }),this
        },
        hideAll:function(){
            var t=this,a=t.data("jqv"),r=a?a.fadeDuration:300;
            return e(".formError").fadeTo(r,300,function(){
                e(this).parent(".formErrorOuter").remove(),e(this).remove()
            }),this
        },
        _onFieldEvent:function(a){
            var r=e(this),i=r.closest("form, .validationEngineContainer"),n=i.data("jqv");
            n.eventTrigger="field",window.setTimeout(function(){
                t._validateField(r,n),0==n.InvalidFields.length&&n.onFieldSuccess?n.onFieldSuccess():n.InvalidFields.length>0&&n.onFieldFailure&&n.onFieldFailure()
            },a.data?a.data.delay:0)
        },
        _onSubmitEvent:function(){
            var a=e(this),r=a.data("jqv");
            if(a.data("jqv_submitButton")){
                var i=e("#"+a.data("jqv_submitButton"));
                if(i&&i.length>0&&(i.hasClass("validate-skip")||"true"==i.attr("data-validation-engine-skip")))return!0
            }
            r.eventTrigger="submit";
            var n=t._validateFields(a);
            return n&&r.ajaxFormValidation?(t._validateFormWithAjax(a,r),!1):r.onValidationComplete?!!r.onValidationComplete(a,n):n
        },
        _checkAjaxStatus:function(t){
            var a=!0;
            return e.each(t.ajaxValidCache,function(e,t){
                return t?void 0:(a=!1,!1)
            }),a
        },
        _checkAjaxFieldStatus:function(e,t){
            return 1==t.ajaxValidCache[e]
        },
        _validateFields:function(a){
            var r=a.data("jqv"),i=!1;
            a.trigger("jqv.form.validating");
            var n=null;
            if(a.find("["+r.validateAttribute+"*=validate]").not(":disabled").each(function(){
                var o=e(this),s=[];
                if(e.inArray(o.attr("name"),s)<0){
                    if(i|=t._validateField(o,r),i&&null==n&&(o.is(":hidden")&&r.prettySelect?n=o=a.find("#"+r.usePrefix+t._jqSelector(o.attr("id"))+r.useSuffix):(o.data("jqv-prompt-at")instanceof jQuery?o=o.data("jqv-prompt-at"):o.data("jqv-prompt-at")&&(o=e(o.data("jqv-prompt-at"))),n=o)),r.doNotShowAllErrosOnSubmit)return!1;
                    if(s.push(o.attr("name")),1==r.showOneMessage&&i)return!1
                }
            }),a.trigger("jqv.form.result",[i]),i){
                if(r.scroll){
                    var o=n.offset().top,s=n.offset().left,l=r.promptPosition;
                    if("string"==typeof l&&-1!=l.indexOf(":")&&(l=l.substring(0,l.indexOf(":"))),"bottomRight"!=l&&"bottomLeft"!=l){
                        var d=t._getPrompt(n);
                        d&&(o=d.offset().top)
                    }
                    if(r.scrollOffset&&(o-=r.scrollOffset),r.isOverflown){
                        var c=e(r.overflownDIV);
                        if(!c.length)return!1;
                        var u=c.scrollTop(),p=-parseInt(c.offset().top);
                        o+=u+p-5;
                        var h=e(r.overflownDIV+":not(:animated)");
                        h.animate({
                            scrollTop:o
                        },1100,function(){
                            r.focusFirstField&&n.focus()
                        })
                    }else o-=250,e("html, body").animate({
                        scrollTop:o
                    },1100,function(){
                        r.focusFirstField&&n.focus()
                    }),e("html, body").animate({
                        scrollLeft:s
                    },1100)
                }else r.focusFirstField&&n.focus();
                return!1
            }
            return!0
        },
        _validateFormWithAjax:function(a,r){
            var i=a.serialize(),n=r.ajaxFormValidationMethod?r.ajaxFormValidationMethod:"GET",o=r.ajaxFormValidationURL?r.ajaxFormValidationURL:a.attr("action"),s=r.dataType?r.dataType:"json";
            e.ajax({
                type:n,
                url:o,
                cache:!1,
                dataType:s,
                data:i,
                form:a,
                methods:t,
                options:r,
                beforeSend:function(){
                    return r.onBeforeAjaxFormValidation(a,r)
                },
                error:function(e,a){
                    r.onFailure?r.onFailure(e,a):t._ajaxError(e,a)
                },
                success:function(i){
                    if("json"==s&&i!==!0){
                        for(var n=!1,o=0;o<i.length;o++){
                            var l=i[o],d=l[0],c=e(e("#"+d)[0]);
                            if(1==c.length){
                                var u=l[2];
                                if(1==l[1])if(""!=u&&u){
                                    if(r.allrules[u]){
                                        var p=r.allrules[u].alertTextOk;
                                        p&&(u=p)
                                    }
                                    r.showPrompts&&t._showPrompt(c,u,"pass",!1,r,!0)
                                }else t._closePrompt(c);
                                else{
                                    if(n|=!0,r.allrules[u]){
                                        var p=r.allrules[u].alertText;
                                        p&&(u=p)
                                    }
                                    r.showPrompts&&t._showPrompt(c,u,"",!1,r,!0)
                                }
                            }
                        }
                        r.onAjaxFormComplete(!n,a,i,r)
                    }else r.onAjaxFormComplete(!0,a,i,r)
                }
            })
        },
        _validateField:function(a,r,i){
            if(a.attr("id")||(a.attr("id","form-validation-field-"+e.validationEngine.fieldIdCounter),++e.validationEngine.fieldIdCounter),!r.validateNonVisibleFields&&(a.is(":hidden")&&!r.prettySelect||a.parent().is(":hidden")))return!1;
            var n=a.attr(r.validateAttribute),o=/validate\[(.*)\]/.exec(n);
            if(!o)return!1;
            var s=o[1],l=s.split(/\[|,|\]/),d=!1,c=a.attr("name"),u="",p="",h=!1,f=!1;
            r.isError=!1,r.showArrow=!0,r.maxErrorsPerField>0&&(f=!0);
            for(var m=e(a.closest("form, .validationEngineContainer")),g=0;g<l.length;g++)l[g]=l[g].replace(" ",""),""===l[g]&&delete l[g];
            for(var g=0,v=0;g<l.length;g++){
                if(f&&v>=r.maxErrorsPerField){
                    if(!h){
                        var y=e.inArray("required",l);
                        h=-1!=y&&y>=g
                    }
                    break
                }
                var x=void 0;
                switch(l[g]){
                    case"required":
                        h=!0,x=t._getErrorMessage(m,a,l[g],l,g,r,t._required);
                        break;
                    case"custom":
                        x=t._getErrorMessage(m,a,l[g],l,g,r,t._custom);
                        break;
                    case"groupRequired":
                        var w="["+r.validateAttribute+"*="+l[g+1]+"]",_=m.find(w).eq(0);
                        _[0]!=a[0]&&(t._validateField(_,r,i),r.showArrow=!0),x=t._getErrorMessage(m,a,l[g],l,g,r,t._groupRequired),x&&(h=!0),r.showArrow=!1;
                        break;
                    case"ajax":
                        x=t._ajax(a,l,g,r),x&&(p="load");
                        break;
                    case"minSize":
                        x=t._getErrorMessage(m,a,l[g],l,g,r,t._minSize);
                    break;
                    case"minSizeWord":
                    x=t._getErrorMessage(m,a,l[g],l,g,r,t._minSizeWord);
                    break;
                    case"maxSize":
                        x=t._getErrorMessage(m,a,l[g],l,g,r,t._maxSize);
                        break;
                    case"min":
                        x=t._getErrorMessage(m,a,l[g],l,g,r,t._min);
                        break;
                    case"max":
                        x=t._getErrorMessage(m,a,l[g],l,g,r,t._max);
                        break;
                    case"past":
                        x=t._getErrorMessage(m,a,l[g],l,g,r,t._past);
                        break;
                    case"future":
                        x=t._getErrorMessage(m,a,l[g],l,g,r,t._future);
                        break;
                    case"dateRange":
                        var w="["+r.validateAttribute+"*="+l[g+1]+"]";
                        r.firstOfGroup=m.find(w).eq(0),r.secondOfGroup=m.find(w).eq(1),(r.firstOfGroup[0].value||r.secondOfGroup[0].value)&&(x=t._getErrorMessage(m,a,l[g],l,g,r,t._dateRange)),x&&(h=!0),r.showArrow=!1;
                        break;
                    case"dateTimeRange":
                        var w="["+r.validateAttribute+"*="+l[g+1]+"]";
                        r.firstOfGroup=m.find(w).eq(0),r.secondOfGroup=m.find(w).eq(1),(r.firstOfGroup[0].value||r.secondOfGroup[0].value)&&(x=t._getErrorMessage(m,a,l[g],l,g,r,t._dateTimeRange)),x&&(h=!0),r.showArrow=!1;
                        break;
                    case"maxCheckbox":
                        a=e(m.find("input[name='"+c+"']")),x=t._getErrorMessage(m,a,l[g],l,g,r,t._maxCheckbox);
                        break;
                    case"minCheckbox":
                        a=e(m.find("input[name='"+c+"']")),x=t._getErrorMessage(m,a,l[g],l,g,r,t._minCheckbox);
                        break;
                    case"equals":
                        x=t._getErrorMessage(m,a,l[g],l,g,r,t._equals);
                        break;
                    case"equalss":
                        x=t._getErrorMessage(m,a,l[g],l,g,r,t._equals);
                        break;
                    case"lessThan":
                        x=t._getErrorMessage(m,a,l[g],l,g,r,t._lessThan);
                        break;
                    case"funcCall":
                        x=t._getErrorMessage(m,a,l[g],l,g,r,t._funcCall);
                        break;
                    case"creditCard":
                        x=t._getErrorMessage(m,a,l[g],l,g,r,t._creditCard);
                        break;
                    case"condRequired":
                        x=t._getErrorMessage(m,a,l[g],l,g,r,t._condRequired),void 0!==x&&(h=!0)
                }
                var C=!1;
                if("object"==typeof x)switch(x.status){
                    case"_break":
                        C=!0;
                        break;
                    case"_error":
                        x=x.message;
                        break;
                    case"_error_no_prompt":
                        return!0
                }
                if(C)break;
                "string"==typeof x&&(u+=x+"<br/>",r.isError=!0,v++)
            }!h&&!a.val()&&a.val().length<1&&l.indexOf("equals")<0&&(r.isError=!1);
            var b=a.prop("type"),T=a.data("promptPosition")||r.promptPosition;
            ("radio"==b||"checkbox"==b)&&m.find("input[name='"+c+"']").size()>1&&(a=e("inline"===T?m.find("input[name='"+c+"'][type!=hidden]:last"):m.find("input[name='"+c+"'][type!=hidden]:first")),r.showArrow=!1),a.is(":hidden")&&r.prettySelect&&(a=m.find("#"+r.usePrefix+t._jqSelector(a.attr("id"))+r.useSuffix)),r.isError&&r.showPrompts?t._showPrompt(a,u,p,!1,r):d||t._closePrompt(a),d||a.trigger("jqv.field.result",[a,r.isError,u]);
            var k=e.inArray(a[0],r.InvalidFields);
            return-1==k?r.isError&&r.InvalidFields.push(a[0]):r.isError||r.InvalidFields.splice(k,1),t._handleStatusCssClasses(a,r),r.isError&&r.onFieldFailure&&r.onFieldFailure(a),!r.isError&&r.onFieldSuccess&&r.onFieldSuccess(a),r.isError
        },
        _handleStatusCssClasses:function(e,t){
            t.addSuccessCssClassToField&&e.removeClass(t.addSuccessCssClassToField),t.addFailureCssClassToField&&e.removeClass(t.addFailureCssClassToField),t.addSuccessCssClassToField&&!t.isError&&e.addClass(t.addSuccessCssClassToField),t.addFailureCssClassToField&&t.isError&&e.addClass(t.addFailureCssClassToField)
        },
        _getErrorMessage:function(a,r,i,n,o,s,l){
            var d=jQuery.inArray(i,n);
            if("custom"===i||"funcCall"===i){
                var c=n[d+1];
                i=i+"["+c+"]",delete n[d]
            }
            var u,p=i,h=r.attr(r.attr("data-validation-engine")?"data-validation-engine":"class"),f=h.split(" ");
            if(u="future"==i||"past"==i||"maxCheckbox"==i||"minCheckbox"==i?l(a,r,n,o,s):l(r,n,o,s),void 0!=u){
                var m=t._getCustomErrorMessage(e(r),f,p,s);
                m&&(u=m)
            }
            return u
        },
        _getCustomErrorMessage:function(e,a,r,i){
            var n=!1,o=/^custom\[.*\]$/.test(r)?t._validityProp.custom:t._validityProp[r];
            if(void 0!=o&&(n=e.attr("data-errormessage-"+o),void 0!=n))return n;
            if(n=e.attr("data-errormessage"),void 0!=n)return n;
            var s="#"+e.attr("id");
            if("undefined"!=typeof i.custom_error_messages[s]&&"undefined"!=typeof i.custom_error_messages[s][r])n=i.custom_error_messages[s][r].message;
            else if(a.length>0)for(var l=0;l<a.length&&a.length>0;l++){
                var d="."+a[l];
                if("undefined"!=typeof i.custom_error_messages[d]&&"undefined"!=typeof i.custom_error_messages[d][r]){
                    n=i.custom_error_messages[d][r].message;
                    break
                }
            }
            return n||"undefined"==typeof i.custom_error_messages[r]||"undefined"==typeof i.custom_error_messages[r].message||(n=i.custom_error_messages[r].message),n
        },
        _validityProp:{
            required:"value-missing",
            custom:"custom-error",
            groupRequired:"value-missing",
            ajax:"custom-error",
            minSize:"range-underflow",
            minSizeWord:"range-underflow",
            maxSize:"range-overflow",
            min:"range-underflow",
            max:"range-overflow",
            past:"type-mismatch",
            future:"type-mismatch",
            dateRange:"type-mismatch",
            dateTimeRange:"type-mismatch",
            maxCheckbox:"range-overflow",
            minCheckbox:"range-underflow",
            equals:"pattern-mismatch",
            funcCall:"custom-error",
            creditCard:"pattern-mismatch",
            condRequired:"value-missing"
        },
        _required:function(t,a,r,i,n){
            switch(t.prop("type")){
                case"text":case"password":case"textarea":case"file":case"select-one":case"select-multiple":default:
                    var o=e.trim(t.val()),s=e.trim(t.attr("data-validation-placeholder")),l=e.trim(t.attr("placeholder"));
                    if(!o||s&&o==s||l&&o==l)return i.allrules[a[r]].alertText;
                    break;
                case"radio":case"checkbox":
                    if(n){
                        if(!t.attr("checked"))return i.allrules[a[r]].alertTextCheckboxMultiple;
                        break
                    }
                    var d=t.closest("form, .validationEngineContainer"),c=t.attr("name");
                    if(0==d.find("input[name='"+c+"']:checked").size())return 1==d.find("input[name='"+c+"']:visible").size()?i.allrules[a[r]].alertTextCheckboxe:i.allrules[a[r]].alertTextCheckboxMultiple
            }
        },
        _groupRequired:function(a,r,i,n){
            var o="["+n.validateAttribute+"*="+r[i+1]+"]",s=!1;
            return a.closest("form, .validationEngineContainer").find(o).each(function(){
                return t._required(e(this),r,i,n)?void 0:(s=!0,!1)
            }),s?void 0:n.allrules[r[i]].alertText
        },
        _custom:function(e,t,a,r){
            var i,n=t[a+1],o=r.allrules[n];
            if(!o)return void alert("jqv:custom rule not found - "+n);
            if(o.regex){
                var s=o.regex;
                if(!s)return void alert("jqv:custom regex not found - "+n);
                var l=new RegExp(s);
                if(!l.test(e.val()))return r.allrules[n].alertText
            }else{
                if(!o.func)return void alert("jqv:custom type not allowed "+n);
                if(i=o.func,"function"!=typeof i)return void alert("jqv:custom parameter 'function' is no function - "+n);
                if(!i(e,t,a,r))return r.allrules[n].alertText
            }
        },
        _funcCall:function(e,t,a,r){
            var i,n=t[a+1];
            if(n.indexOf(".")>-1){
                for(var o=n.split("."),s=window;o.length;)s=s[o.shift()];
                i=s
            }else i=window[n]||r.customFunctions[n];
            return"function"==typeof i?i(e,t,a,r):void 0
        },
        _equals:function(t,a,r,i){
            var n=a[r+1];
            return t.val()!=e("#"+n).val()?i.allrules.equals.alertText:void 0
        },
        _equalss:function(t,a,r,i){
            var n=a[r+1];
            return t.val()!=e("#"+n).val()?i.allrules.equals.alertText:void 0
        },
        _lessThan:function(t,a,r,i){
            var n=a[r+1],o=parseFloat(e("#"+n).val()),s=parseFloat(t.val());
            if(""!=o&&s>=o){
                var l=i.allrules.max;
                return l.alertText2?l.alertText+o+l.alertText2:l.alertText+" "+o
            }
        },
        _maxSize:function(e,t,a,r){
            var i=t[a+1],n=e.val().length;
            if(n>i){
                var o=r.allrules.maxSize;
                return o.alertText+i+o.alertText2
            }
        },
        _minSize:function(e,t,a,r){ 
            var i=t[a+1],n=e.val().length;
            if(i>n){
                var o=r.allrules.minSize;
                return o.alertText+i+o.alertText2
            }
        },
         _minSizeWord:function(e,t,a,r){ 
            var i=t[a+1],n=e.val().length;
            if(i>n){
                var o=r.allrules.minSizeWord;
                return o.alertText+i+o.alertText2
            }
        },
        _min:function(e,t,a,r){
            var i=parseFloat(t[a+1]),n=parseFloat(e.val());
            if(i>n){
                var o=r.allrules.min;
                return o.alertText2?o.alertText+i+o.alertText2:o.alertText+i
            }
        },
        _max:function(e,t,a,r){
            var i=parseFloat(t[a+1]),n=parseFloat(e.val());
            if(n>i){
                var o=r.allrules.max;
                return o.alertText2?o.alertText+i+o.alertText2:o.alertText+i
            }
        },
        _past:function(a,r,i,n,o){
            var s,l=i[n+1],d=e(a.find("*[name='"+l.replace(/^#+/,"")+"']"));
            if("now"==l.toLowerCase())s=new Date;
            else if(void 0!=d.val()){
                if(d.is(":disabled"))return;
                s=t._parseDate(d.val())
            }else s=t._parseDate(l);
            var c=t._parseDate(r.val());
            if(c>s){
                var u=o.allrules.past;
                return u.alertText2?u.alertText+t._dateToString(s)+u.alertText2:u.alertText+t._dateToString(s)
            }
        },
        _future:function(a,r,i,n,o){
            var s,l=i[n+1],d=e(a.find("*[name='"+l.replace(/^#+/,"")+"']"));
            if("now"==l.toLowerCase())s=new Date;
            else if(void 0!=d.val()){
                if(d.is(":disabled"))return;
                s=t._parseDate(d.val())
            }else s=t._parseDate(l);
            var c=t._parseDate(r.val());
            if(s>c){
                var u=o.allrules.future;
                return u.alertText2?u.alertText+t._dateToString(s)+u.alertText2:u.alertText+t._dateToString(s)
            }
        },
        _isDate:function(e){
            var t=new RegExp(/^\d{4}[\/\-](0?[1-9]|1[012])[\/\-](0?[1-9]|[12][0-9]|3[01])$|^(?:(?:(?:0?[13578]|1[02])(\/|-)31)|(?:(?:0?[1,3-9]|1[0-2])(\/|-)(?:29|30)))(\/|-)(?:[1-9]\d\d\d|\d[1-9]\d\d|\d\d[1-9]\d|\d\d\d[1-9])$|^(?:(?:0?[1-9]|1[0-2])(\/|-)(?:0?[1-9]|1\d|2[0-8]))(\/|-)(?:[1-9]\d\d\d|\d[1-9]\d\d|\d\d[1-9]\d|\d\d\d[1-9])$|^(0?2(\/|-)29)(\/|-)(?:(?:0[48]00|[13579][26]00|[2468][048]00)|(?:\d\d)?(?:0[48]|[2468][048]|[13579][26]))$/);
            return t.test(e)
        },
        _isDateTime:function(e){
            var t=new RegExp(/^\d{4}[\/\-](0?[1-9]|1[012])[\/\-](0?[1-9]|[12][0-9]|3[01])\s+(1[012]|0?[1-9]){1}:(0?[1-5]|[0-6][0-9]){1}:(0?[0-6]|[0-6][0-9]){1}\s+(am|pm|AM|PM){1}$|^(?:(?:(?:0?[13578]|1[02])(\/|-)31)|(?:(?:0?[1,3-9]|1[0-2])(\/|-)(?:29|30)))(\/|-)(?:[1-9]\d\d\d|\d[1-9]\d\d|\d\d[1-9]\d|\d\d\d[1-9])$|^((1[012]|0?[1-9]){1}\/(0?[1-9]|[12][0-9]|3[01]){1}\/\d{2,4}\s+(1[012]|0?[1-9]){1}:(0?[1-5]|[0-6][0-9]){1}:(0?[0-6]|[0-6][0-9]){1}\s+(am|pm|AM|PM){1})$/);
            return t.test(e)
        },
        _dateCompare:function(e,t){
            return new Date(e.toString())<new Date(t.toString())
        },
        _dateRange:function(e,a,r,i){
            return!i.firstOfGroup[0].value&&i.secondOfGroup[0].value||i.firstOfGroup[0].value&&!i.secondOfGroup[0].value?i.allrules[a[r]].alertText+i.allrules[a[r]].alertText2:t._isDate(i.firstOfGroup[0].value)&&t._isDate(i.secondOfGroup[0].value)&&t._dateCompare(i.firstOfGroup[0].value,i.secondOfGroup[0].value)?void 0:i.allrules[a[r]].alertText+i.allrules[a[r]].alertText2
        },
        _dateTimeRange:function(e,a,r,i){
            return!i.firstOfGroup[0].value&&i.secondOfGroup[0].value||i.firstOfGroup[0].value&&!i.secondOfGroup[0].value?i.allrules[a[r]].alertText+i.allrules[a[r]].alertText2:t._isDateTime(i.firstOfGroup[0].value)&&t._isDateTime(i.secondOfGroup[0].value)&&t._dateCompare(i.firstOfGroup[0].value,i.secondOfGroup[0].value)?void 0:i.allrules[a[r]].alertText+i.allrules[a[r]].alertText2
        },
        _maxCheckbox:function(e,t,a,r,i){
            var n=a[r+1],o=t.attr("name"),s=e.find("input[name='"+o+"']:checked").size();
            return s>n?(i.showArrow=!1,i.allrules.maxCheckbox.alertText2?i.allrules.maxCheckbox.alertText+" "+n+" "+i.allrules.maxCheckbox.alertText2:i.allrules.maxCheckbox.alertText):void 0
        },
        _minCheckbox:function(e,t,a,r,i){
            var n=a[r+1],o=t.attr("name"),s=e.find("input[name='"+o+"']:checked").size();
            return n>s?(i.showArrow=!1,i.allrules.minCheckbox.alertText+" "+n+" "+i.allrules.minCheckbox.alertText2):void 0
        },
        _creditCard:function(e,t,a,r){
            var i=!1,n=e.val().replace(/ +/g,"").replace(/-+/g,""),o=n.length;
            if(o>=14&&16>=o&&parseInt(n)>0){
                var s,l=0,a=o-1,d=1,c=new String;
                do s=parseInt(n.charAt(a)),c+=d++%2==0?2*s:s;while(--a>=0);
                for(a=0;a<c.length;a++)l+=parseInt(c.charAt(a));
                i=l%10==0
            }
            return i?void 0:r.allrules.creditCard.alertText
        },
        _ajax:function(a,r,i,n){
            var o=r[i+1],s=n.allrules[o],l=s.extraData,d=s.extraDataDynamic,c={
                fieldId:a.attr("id"),
                fieldValue:a.val()
            };

            if("object"==typeof l)e.extend(c,l);
            else if("string"==typeof l)for(var u=l.split("&"),i=0;i<u.length;i++){
                var p=u[i].split("=");
                p[0]&&p[0]&&(c[p[0]]=p[1])
            }
            if(d)for(var h=String(d).split(","),i=0;i<h.length;i++){
                var f=h[i];
                if(e(f).length){
                {
                    var m=a.closest("form, .validationEngineContainer").find(f).val();
                    f.replace("#","")+"="+escape(m)
                }
                c[f.replace("#","")]=m
                }
            }
            return"field"==n.eventTrigger&&delete n.ajaxValidCache[a.attr("id")],n.isError||t._checkAjaxFieldStatus(a.attr("id"),n)?void 0:(e.ajax({
                type:n.ajaxFormValidationMethod,
                url:s.url,
                cache:!1,
                dataType:"json",
                data:c,
                field:a,
                rule:s,
                methods:t,
                options:n,
                beforeSend:function(){},
                error:function(e,a){
                    n.onFailure?n.onFailure(e,a):t._ajaxError(e,a)
                },
                success:function(r){
                    var i=r[0],o=e("#"+i).eq(0);
                    if(1==o.length){
                        var l=r[1],d=r[2];
                        if(l){
                            if(n.ajaxValidCache[i]=!0,d){
                                if(n.allrules[d]){
                                    var c=n.allrules[d].alertTextOk;
                                    c&&(d=c)
                                }
                            }else d=s.alertTextOk;
                            n.showPrompts&&(d?t._showPrompt(o,d,"pass",!0,n):t._closePrompt(o)),"submit"==n.eventTrigger&&a.closest("form").submit()
                        }else{
                            if(n.ajaxValidCache[i]=!1,n.isError=!0,d){
                                if(n.allrules[d]){
                                    var c=n.allrules[d].alertText;
                                    c&&(d=c)
                                }
                            }else d=s.alertText;
                            n.showPrompts&&t._showPrompt(o,d,"",!0,n)
                        }
                    }
                    o.trigger("jqv.field.result",[o,n.isError,d])
                }
            }),s.alertTextLoad)
        },
        _ajaxError:function(e,t){
            0==e.status&&null==t?alert("The page is not served from a server! ajax call failed"):"undefined"!=typeof console&&console.log("Ajax error: "+e.status+" "+t)
        },
        _dateToString:function(e){
            return e.getFullYear()+"-"+(e.getMonth()+1)+"-"+e.getDate()
        },
        _parseDate:function(e){
            var t=e.split("-");
            return t==e&&(t=e.split("/")),t==e?(t=e.split("."),new Date(t[2],t[1]-1,t[0])):new Date(t[0],t[1]-1,t[2])
        },
        _showPrompt:function(a,r,i,n,o,s){
            a.data("jqv-prompt-at")instanceof jQuery?a=a.data("jqv-prompt-at"):a.data("jqv-prompt-at")&&(a=e(a.data("jqv-prompt-at")));
            var l=t._getPrompt(a);
            s&&(l=!1),e.trim(r)&&(l?t._updatePrompt(a,l,r,i,n,o):t._buildPrompt(a,r,i,n,o))
        },
        _buildPrompt:function(a,r,i,n,o){
            var s=e("<div>");
            switch(s.addClass(t._getClassName(a.attr("id"))+"formError"),s.addClass("parentForm"+t._getClassName(a.closest("form, .validationEngineContainer").attr("id"))),s.addClass("formError"),i){
                case"pass":
                    s.addClass("greenPopup");
                    break;
                case"load":
                    s.addClass("blackPopup")
            }
            n&&s.addClass("ajaxed");
            var l=(e("<div>").addClass("formErrorContent").html(r).appendTo(s),a.data("promptPosition")||o.promptPosition);
            if(o.showArrow){
                var d=e("<div>").addClass("formErrorArrow");
                if("string"==typeof l){
                    var c=l.indexOf(":");
                    -1!=c&&(l=l.substring(0,c))
                }
                switch(l){
                    case"bottomLeft":case"bottomRight":
                        s.find(".formErrorContent").before(d),d.addClass("formErrorArrowBottom").html('<div class="line1"><!-- --></div><div class="line2"><!-- --></div><div class="line3"><!-- --></div><div class="line4"><!-- --></div><div class="line5"><!-- --></div><div class="line6"><!-- --></div><div class="line7"><!-- --></div><div class="line8"><!-- --></div><div class="line9"><!-- --></div><div class="line10"><!-- --></div>');
                        break;
                    case"topLeft":case"topRight":
                        d.html('<div class="line10"><!-- --></div><div class="line9"><!-- --></div><div class="line8"><!-- --></div><div class="line7"><!-- --></div><div class="line6"><!-- --></div><div class="line5"><!-- --></div><div class="line4"><!-- --></div><div class="line3"><!-- --></div><div class="line2"><!-- --></div><div class="line1"><!-- --></div>'),s.append(d)
                }
            }
            o.addPromptClass&&s.addClass(o.addPromptClass);
            var u=a.attr("data-required-class");
            if(void 0!==u)s.addClass(u);
            else if(o.prettySelect&&e("#"+a.attr("id")).next().is("select")){
                var p=e("#"+a.attr("id").substr(o.usePrefix.length).substring(o.useSuffix.length)).attr("data-required-class");
                void 0!==p&&s.addClass(p)
            }
            s.css({
                opacity:0
            }),"inline"===l?(s.addClass("inline"),"undefined"!=typeof a.attr("data-prompt-target")&&e("#"+a.attr("data-prompt-target")).length>0?s.appendTo(e("#"+a.attr("data-prompt-target"))):a.after(s)):a.before(s);
            var c=t._calculatePosition(a,s,o);
            return s.css({
                position:"inline"===l?"relative":"absolute",
                top:c.callerTopPosition,
                left:c.callerleftPosition,
                marginTop:c.marginTopSize,
                opacity:0
            }).data("callerField",a),o.autoHidePrompt&&setTimeout(function(){
                s.animate({
                    opacity:0
                },function(){
                    s.closest(".formErrorOuter").remove(),s.remove()
                })
            },o.autoHideDelay),s.animate({
                opacity:.87
            })
        },
        _updatePrompt:function(e,a,r,i,n,o,s){
            if(a){
                "undefined"!=typeof i&&("pass"==i?a.addClass("greenPopup"):a.removeClass("greenPopup"),"load"==i?a.addClass("blackPopup"):a.removeClass("blackPopup")),n?a.addClass("ajaxed"):a.removeClass("ajaxed"),a.find(".formErrorContent").html(r);
                var l=t._calculatePosition(e,a,o),d={
                    top:l.callerTopPosition,
                    left:l.callerleftPosition,
                    marginTop:l.marginTopSize
                };

                s?a.css(d):a.animate(d)
            }
        },
        _closePrompt:function(e){
            var a=t._getPrompt(e);
            a&&a.fadeTo("fast",0,function(){
                a.parent(".formErrorOuter").remove(),a.remove()
            })
        },
        closePrompt:function(e){
            return t._closePrompt(e)
        },
        _getPrompt:function(a){
            var r=e(a).closest("form, .validationEngineContainer").attr("id"),i=t._getClassName(a.attr("id"))+"formError",n=e("."+t._escapeExpression(i)+".parentForm"+t._getClassName(r))[0];
            return n?e(n):void 0
        },
        _escapeExpression:function(e){
            return e.replace(/([#;&,\.\+\*\~':"\!\^$\[\]\(\)=>\|])/g,"\\$1")
        },
        isRTL:function(t){
            var a=e(document),r=e("body"),i=t&&t.hasClass("rtl")||t&&"rtl"===(t.attr("dir")||"").toLowerCase()||a.hasClass("rtl")||"rtl"===(a.attr("dir")||"").toLowerCase()||r.hasClass("rtl")||"rtl"===(r.attr("dir")||"").toLowerCase();
            return Boolean(i)
        },
        _calculatePosition:function(e,t,a){
            var r,i,n,o=e.width(),s=e.position().left,l=e.position().top,d=(e.height(),t.height());
            r=i=0,n=-d;
            var c=e.data("promptPosition")||a.promptPosition,u="",p="",h=0,f=0;
            switch("string"==typeof c&&-1!=c.indexOf(":")&&(u=c.substring(c.indexOf(":")+1),c=c.substring(0,c.indexOf(":")),-1!=u.indexOf(",")&&(p=u.substring(u.indexOf(",")+1),u=u.substring(0,u.indexOf(",")),f=parseInt(p),isNaN(f)&&(f=0)),h=parseInt(u),isNaN(u)&&(u=0)),c){
                default:case"topRight":
                    i+=s+o-30,r+=l;
                    break;
                case"topLeft":
                    r+=l,i+=s;
                    break;
                case"centerRight":
                    r=l+4,n=0,i=s+e.outerWidth(!0)+5;
                    break;
                case"centerLeft":
                    i=s-(t.width()+2),r=l+4,n=0;
                    break;
                case"bottomLeft":
                    r=l+e.height()+5,n=0,i=s;
                    break;
                case"bottomRight":
                    i=s+o-30,r=l+e.height()+5,n=0;
                    break;
                case"inline":
                    i=0,r=0,n=0
            }
            return i+=h,r+=f,{
                callerTopPosition:r+"px",
                callerleftPosition:i+"px",
                marginTopSize:n+"px"
            }
        },
        _saveOptions:function(t,a){
            if(e.validationEngineLanguage)var r=e.validationEngineLanguage.allRules;else e.error("jQuery.validationEngine rules are not loaded, plz add localization files to the page");
            e.validationEngine.defaults.allrules=r;
            var i=e.extend(!0,{},e.validationEngine.defaults,a);
            return t.data("jqv",i),i
        },
        _getClassName:function(e){
            return e?e.replace(/:/g,"_").replace(/\./g,"_"):void 0
        },
        _jqSelector:function(e){
            return e.replace(/([;&,\.\+\*\~':"\!\^#$%@\[\]\(\)=>\|])/g,"\\$1")
        },
        _condRequired:function(e,a,r,i){
            var n,o;
            for(n=r+1;n<a.length;n++)if(o=jQuery("#"+a[n]).first(),o.length&&void 0==t._required(o,["required"],0,i,!0))return t._required(e,["required"],0,i)
        },
        _submitButtonClick:function(){
            var t=e(this),a=t.closest("form, .validationEngineContainer");
            a.data("jqv_submitButton",t.attr("id"))
        }
    };

    e.fn.validationEngine=function(a){
        var r=e(this);
        return r[0]?"string"==typeof a&&"_"!=a.charAt(0)&&t[a]?("showPrompt"!=a&&"hide"!=a&&"hideAll"!=a&&t.init.apply(r),t[a].apply(r,Array.prototype.slice.call(arguments,1))):"object"!=typeof a&&a?void e.error("Method "+a+" does not exist in jQuery.validationEngine"):(t.init.apply(r,arguments),t.attach.apply(r)):r
    },e.validationEngine={
        fieldIdCounter:0,
        defaults:{
            validationEventTrigger:"blur",
            scroll:!0,
            focusFirstField:!0,
            showPrompts:!0,
            validateNonVisibleFields:!1,
            promptPosition:"topRight",
            bindMethod:"bind",
            inlineAjax:!1,
            ajaxFormValidation:!1,
            ajaxFormValidationURL:!1,
            ajaxFormValidationMethod:"get",
            onAjaxFormComplete:e.noop,
            onBeforeAjaxFormValidation:e.noop,
            onValidationComplete:!1,
            doNotShowAllErrosOnSubmit:!1,
            custom_error_messages:{},
            binded:!0,
            showArrow:!0,
            isError:!1,
            maxErrorsPerField:!1,
            ajaxValidCache:{},
            autoPositionUpdate:!1,
            InvalidFields:[],
            onFieldSuccess:!1,
            onFieldFailure:!1,
            onSuccess:!1,
            onFailure:!1,
            validateAttribute:"class",
            addSuccessCssClassToField:"",
            addFailureCssClassToField:"",
            autoHidePrompt:!1,
            autoHideDelay:1e4,
            fadeDuration:.3,
            prettySelect:!1,
            addPromptClass:"",
            usePrefix:"",
            useSuffix:"",
            showOneMessage:!1
        }
    },e(function(){
        e.validationEngine.defaults.promptPosition=t.isRTL()?"topLeft":"topRight"
    })
}(jQuery),function(e){
    function t(){
        this._defaults={
            pickerClass:"",
            showOnFocus:!0,
            showTrigger:null,
            showAnim:"show",
            showOptions:{},
            showSpeed:"normal",
            popupContainer:null,
            alignment:"bottom",
            fixedWeeks:!1,
            firstDay:0,
            calculateWeek:this.iso8601Week,
            monthsToShow:1,
            monthsOffset:0,
            monthsToStep:1,
            monthsToJump:12,
            useMouseWheel:!0,
            changeMonth:!0,
            yearRange:"c-10:c+10",
            shortYearCutoff:"+10",
            showOtherMonths:!1,
            selectOtherMonths:!1,
            defaultDate:null,
            selectDefaultDate:!1,
            minDate:null,
            maxDate:null,
            dateFormat:"mm/dd/yyyy",
            autoSize:!1,
            rangeSelect:!1,
            rangeSeparator:" - ",
            multiSelect:0,
            multiSeparator:",",
            onDate:null,
            onShow:null,
            onChangeMonthYear:null,
            onSelect:null,
            onClose:null,
            altField:null,
            altFormat:null,
            constrainInput:!0,
            commandsAsDateFormat:!1,
            commands:this.commands
        },this.regional=[],this.regional[""]={
            monthNames:["January","February","March","April","May","June","July","August","September","October","November","December"],
            monthNamesShort:["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"],
            dayNames:["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"],
            dayNamesShort:["Sun","Mon","Tue","Wed","Thu","Fri","Sat"],
            dayNamesMin:["Su","Mo","Tu","We","Th","Fr","Sa"],
            dateFormat:"mm/dd/yyyy",
            firstDay:0,
            renderer:this.defaultRenderer,
            prevText:"&lt;Prev",
            prevStatus:"Show the previous month",
            prevJumpText:"&lt;&lt;",
            prevJumpStatus:"Show the previous year",
            nextText:"Next&gt;",
            nextStatus:"Show the next month",
            nextJumpText:"&gt;&gt;",
            nextJumpStatus:"Show the next year",
            currentText:"Current",
            currentStatus:"Show the current month",
            todayText:"Today",
            todayStatus:"Show today's month",
            clearText:"Clear",
            clearStatus:"Clear all the dates",
            closeText:"Close",
            closeStatus:"Close the datepicker",
            yearStatus:"Change the year",
            monthStatus:"Change the month",
            weekText:"Wk",
            weekStatus:"Week of the year",
            dayStatus:"Select DD, M d, yyyy",
            defaultStatus:"Select a date",
            isRTL:!1
        },e.extend(this._defaults,this.regional[""]),this._disabled=[]
    }
    function a(t,a){
        return"option"==t&&(0==a.length||1==a.length&&"string"==typeof a[0])?!0:e.inArray(t,r)>-1
    }
    e.extend(t.prototype,{
        markerClassName:"hasDatepick",
        propertyName:"datepick",
        _popupClass:"datepick-popup",
        _triggerClass:"datepick-trigger",
        _disableClass:"datepick-disable",
        _monthYearClass:"datepick-month-year",
        _curMonthClass:"datepick-month-",
        _anyYearClass:"datepick-any-year",
        _curDoWClass:"datepick-dow-",
        commands:{
            prev:{
                text:"prevText",
                status:"prevStatus",
                keystroke:{
                    keyCode:33
                },
                enabled:function(e){
                    var t=e.curMinDate();
                    return!t||i.add(i.day(i._applyMonthsOffset(i.add(i.newDate(e.drawDate),1-e.options.monthsToStep,"m"),e),1),-1,"d").getTime()>=t.getTime()
                },
                date:function(e){
                    return i.day(i._applyMonthsOffset(i.add(i.newDate(e.drawDate),-e.options.monthsToStep,"m"),e),1)
                },
                action:function(e){
                    i._changeMonthPlugin(this,-e.options.monthsToStep)
                }
            },
            prevJump:{
                text:"prevJumpText",
                status:"prevJumpStatus",
                keystroke:{
                    keyCode:33,
                    ctrlKey:!0
                },
                enabled:function(e){
                    var t=e.curMinDate();
                    return!t||i.add(i.day(i._applyMonthsOffset(i.add(i.newDate(e.drawDate),1-e.options.monthsToJump,"m"),e),1),-1,"d").getTime()>=t.getTime()
                },
                date:function(e){
                    return i.day(i._applyMonthsOffset(i.add(i.newDate(e.drawDate),-e.options.monthsToJump,"m"),e),1)
                },
                action:function(e){
                    i._changeMonthPlugin(this,-e.options.monthsToJump)
                }
            },
            next:{
                text:"nextText",
                status:"nextStatus",
                keystroke:{
                    keyCode:34
                },
                enabled:function(e){
                    var t=e.get("maxDate");
                    return!t||i.day(i._applyMonthsOffset(i.add(i.newDate(e.drawDate),e.options.monthsToStep,"m"),e),1).getTime()<=t.getTime()
                },
                date:function(e){
                    return i.day(i._applyMonthsOffset(i.add(i.newDate(e.drawDate),e.options.monthsToStep,"m"),e),1)
                },
                action:function(e){
                    i._changeMonthPlugin(this,e.options.monthsToStep)
                }
            },
            nextJump:{
                text:"nextJumpText",
                status:"nextJumpStatus",
                keystroke:{
                    keyCode:34,
                    ctrlKey:!0
                },
                enabled:function(e){
                    var t=e.get("maxDate");
                    return!t||i.day(i._applyMonthsOffset(i.add(i.newDate(e.drawDate),e.options.monthsToJump,"m"),e),1).getTime()<=t.getTime()
                },
                date:function(e){
                    return i.day(i._applyMonthsOffset(i.add(i.newDate(e.drawDate),e.options.monthsToJump,"m"),e),1)
                },
                action:function(e){
                    i._changeMonthPlugin(this,e.options.monthsToJump)
                }
            },
            current:{
                text:"currentText",
                status:"currentStatus",
                keystroke:{
                    keyCode:36,
                    ctrlKey:!0
                },
                enabled:function(e){
                    var t=e.curMinDate(),a=e.get("maxDate"),r=e.selectedDates[0]||i.today();
                    return(!t||r.getTime()>=t.getTime())&&(!a||r.getTime()<=a.getTime())
                },
                date:function(e){
                    return e.selectedDates[0]||i.today()
                },
                action:function(e){
                    var t=e.selectedDates[0]||i.today();
                    i._showMonthPlugin(this,t.getFullYear(),t.getMonth()+1)
                }
            },
            today:{
                text:"todayText",
                status:"todayStatus",
                keystroke:{
                    keyCode:36,
                    ctrlKey:!0
                },
                enabled:function(e){
                    var t=e.curMinDate(),a=e.get("maxDate");
                    return(!t||i.today().getTime()>=t.getTime())&&(!a||i.today().getTime()<=a.getTime())
                },
                date:function(){
                    return i.today()
                },
                action:function(){
                    i._showMonthPlugin(this)
                }
            },
            clear:{
                text:"clearText",
                status:"clearStatus",
                keystroke:{
                    keyCode:35,
                    ctrlKey:!0
                },
                enabled:function(){
                    return!0
                },
                date:function(){
                    return null
                },
                action:function(){
                    i._clearPlugin(this)
                }
            },
            close:{
                text:"closeText",
                status:"closeStatus",
                keystroke:{
                    keyCode:27
                },
                enabled:function(){
                    return!0
                },
                date:function(){
                    return null
                },
                action:function(){
                    i._hidePlugin(this)
                }
            },
            prevWeek:{
                text:"prevWeekText",
                status:"prevWeekStatus",
                keystroke:{
                    keyCode:38,
                    ctrlKey:!0
                },
                enabled:function(e){
                    var t=e.curMinDate();
                    return!t||i.add(i.newDate(e.drawDate),-7,"d").getTime()>=t.getTime()
                },
                date:function(e){
                    return i.add(i.newDate(e.drawDate),-7,"d")
                },
                action:function(){
                    i._changeDayPlugin(this,-7)
                }
            },
            prevDay:{
                text:"prevDayText",
                status:"prevDayStatus",
                keystroke:{
                    keyCode:37,
                    ctrlKey:!0
                },
                enabled:function(e){
                    var t=e.curMinDate();
                    return!t||i.add(i.newDate(e.drawDate),-1,"d").getTime()>=t.getTime()
                },
                date:function(e){
                    return i.add(i.newDate(e.drawDate),-1,"d")
                },
                action:function(){
                    i._changeDayPlugin(this,-1)
                }
            },
            nextDay:{
                text:"nextDayText",
                status:"nextDayStatus",
                keystroke:{
                    keyCode:39,
                    ctrlKey:!0
                },
                enabled:function(e){
                    var t=e.get("maxDate");
                    return!t||i.add(i.newDate(e.drawDate),1,"d").getTime()<=t.getTime()
                },
                date:function(e){
                    return i.add(i.newDate(e.drawDate),1,"d")
                },
                action:function(){
                    i._changeDayPlugin(this,1)
                }
            },
            nextWeek:{
                text:"nextWeekText",
                status:"nextWeekStatus",
                keystroke:{
                    keyCode:40,
                    ctrlKey:!0
                },
                enabled:function(e){
                    var t=e.get("maxDate");
                    return!t||i.add(i.newDate(e.drawDate),7,"d").getTime()<=t.getTime()
                },
                date:function(e){
                    return i.add(i.newDate(e.drawDate),7,"d")
                },
                action:function(){
                    i._changeDayPlugin(this,7)
                }
            }
        },
        defaultRenderer:{
            picker:'<div class="datepick"><div class="datepick-nav">{link:prev}{link:today}{link:next}</div>{months}{popup:start}<div class="datepick-ctrl">{link:clear}{link:close}</div>{popup:end}<div class="datepick-clear-fix"></div></div>',
            monthRow:'<div class="datepick-month-row">{months}</div>',
            month:'<div class="datepick-month"><div class="datepick-month-header">{monthHeader}</div><table><thead>{weekHeader}</thead><tbody>{weeks}</tbody></table></div>',
            weekHeader:"<tr>{days}</tr>",
            dayHeader:"<th>{day}</th>",
            week:"<tr>{days}</tr>",
            day:"<td>{day}</td>",
            monthSelector:".datepick-month",
            daySelector:"td",
            rtlClass:"datepick-rtl",
            multiClass:"datepick-multi",
            defaultClass:"",
            selectedClass:"datepick-selected",
            highlightedClass:"datepick-highlight",
            todayClass:"datepick-today",
            otherMonthClass:"datepick-other-month",
            weekendClass:"datepick-weekend",
            commandClass:"datepick-cmd",
            commandButtonClass:"",
            commandLinkClass:"",
            disabledClass:"datepick-disabled"
        },
        setDefaults:function(t){
            return e.extend(this._defaults,t||{}),this
        },
        _ticksTo1970:24*(718685+Math.floor(492.5)-Math.floor(19.7)+Math.floor(4.925))*60*60*1e7,
        _msPerDay:864e5,
        ATOM:"yyyy-mm-dd",
        COOKIE:"D, dd M yyyy",
        FULL:"DD, MM d, yyyy",
        ISO_8601:"yyyy-mm-dd",
        JULIAN:"J",
        RFC_822:"D, d M yy",
        RFC_850:"DD, dd-M-yy",
        RFC_1036:"D, d M yy",
        RFC_1123:"D, d M yyyy",
        RFC_2822:"D, d M yyyy",
        RSS:"D, d M yy",
        TICKS:"!",
        TIMESTAMP:"@",
        W3C:"yyyy-mm-dd",
        formatDate:function(e,t,a){
            if("string"!=typeof e&&(a=t,t=e,e=""),!t)return"";
            e=e||this._defaults.dateFormat,a=a||{};

            for(var r=a.dayNamesShort||this._defaults.dayNamesShort,i=a.dayNames||this._defaults.dayNames,n=a.monthNamesShort||this._defaults.monthNamesShort,o=a.monthNames||this._defaults.monthNames,s=a.calculateWeek||this._defaults.calculateWeek,l=function(t,a){
                for(var r=1;h+r<e.length&&e.charAt(h+r)==t;)r++;
                return h+=r-1,Math.floor(r/(a||1))>1
            },d=function(e,t,a,r){
                var i=""+t;
                if(l(e,r))for(;i.length<a;)i="0"+i;
                return i
            },c=function(e,t,a,r){
                return l(e)?r[t]:a[t]
            },u="",p=!1,h=0;h<e.length;h++)if(p)"'"!=e.charAt(h)||l("'")?u+=e.charAt(h):p=!1;else switch(e.charAt(h)){
                case"d":
                    u+=d("d",t.getDate(),2);
                    break;
                case"D":
                    u+=c("D",t.getDay(),r,i);
                    break;
                case"o":
                    u+=d("o",this.dayOfYear(t),3);
                    break;
                case"w":
                    u+=d("w",s(t),2);
                    break;
                case"m":
                    u+=d("m",t.getMonth()+1,2);
                    break;
                case"M":
                    u+=c("M",t.getMonth(),n,o);
                    break;
                case"y":
                    u+=l("y",2)?t.getFullYear():(t.getFullYear()%100<10?"0":"")+t.getFullYear()%100;
                    break;
                case"@":
                    u+=Math.floor(t.getTime()/1e3);
                    break;
                case"!":
                    u+=1e4*t.getTime()+this._ticksTo1970;
                    break;
                case"'":
                    l("'")?u+="'":p=!0;
                    break;
                default:
                    u+=e.charAt(h)
            }
            return u
        },
        parseDate:function(e,t,a){
            if(null==t)throw"Invalid arguments";
            if(t="object"==typeof t?t.toString():t+"",""==t)return null;
            e=e||this._defaults.dateFormat,a=a||{};

            var r=a.shortYearCutoff||this._defaults.shortYearCutoff;
            r="string"!=typeof r?r:this.today().getFullYear()%100+parseInt(r,10);
            for(var i=a.dayNamesShort||this._defaults.dayNamesShort,n=a.dayNames||this._defaults.dayNames,o=a.monthNamesShort||this._defaults.monthNamesShort,s=a.monthNames||this._defaults.monthNames,l=-1,d=-1,c=-1,u=-1,p=!1,h=!1,f=function(t,a){
                for(var r=1;x+r<e.length&&e.charAt(x+r)==t;)r++;
                return x+=r-1,Math.floor(r/(a||1))>1
            },m=function(e,a){
                var r=f(e,a),i=[2,3,r?4:2,11,20]["oy@!".indexOf(e)+1],n=new RegExp("^-?\\d{1,"+i+"}"),o=t.substring(y).match(n);
                if(!o)throw"Missing number at position {0}".replace(/\{0\}/,y);
                return y+=o[0].length,parseInt(o[0],10)
            },g=function(e,a,r,i){
                for(var n=f(e,i)?r:a,o=0;o<n.length;o++)if(t.substr(y,n[o].length).toLowerCase()==n[o].toLowerCase())return y+=n[o].length,o+1;throw"Unknown name at position {0}".replace(/\{0\}/,y)
            },v=function(){
                if(t.charAt(y)!=e.charAt(x))throw"Unexpected literal at position {0}".replace(/\{0\}/,y);
                y++
            },y=0,x=0;x<e.length;x++)if(h)"'"!=e.charAt(x)||f("'")?v():h=!1;else switch(e.charAt(x)){
                case"d":
                    c=m("d");
                    break;
                case"D":
                    g("D",i,n);
                    break;
                case"o":
                    u=m("o");
                    break;
                case"w":
                    m("w");
                    break;
                case"m":
                    d=m("m");
                    break;
                case"M":
                    d=g("M",o,s);
                    break;
                case"y":
                    var w=x;
                    p=!f("y",2),x=w,l=m("y",2);
                    break;
                case"@":
                    var _=this._normaliseDate(new Date(1e3*m("@")));
                    l=_.getFullYear(),d=_.getMonth()+1,c=_.getDate();
                    break;
                case"!":
                    var _=this._normaliseDate(new Date((m("!")-this._ticksTo1970)/1e4));
                    l=_.getFullYear(),d=_.getMonth()+1,c=_.getDate();
                    break;
                case"*":
                    y=t.length;
                    break;
                case"'":
                    f("'")?v():h=!0;
                    break;
                default:
                    v()
            }
            if(y<t.length)throw"Additional text found at end";
            if(-1==l?l=this.today().getFullYear():100>l&&p&&(l+=-1==r?1900:this.today().getFullYear()-this.today().getFullYear()%100-(r>=l?0:100)),u>-1){
                d=1,c=u;
                for(var C=this.daysInMonth(l,d);c>C;C=this.daysInMonth(l,d))d++,c-=C
            }
            var _=this.newDate(l,d,c);
            if(_.getFullYear()!=l||_.getMonth()+1!=d||_.getDate()!=c)throw"Invalid date";
            return _
        },
        determineDate:function(e,t,a,r,n){
            a&&"object"!=typeof a&&(n=r,r=a,a=null),"string"!=typeof r&&(n=r,r="");
            var o=function(e){
                try{
                    return i.parseDate(r,e,n)
                }catch(t){}
                e=e.toLowerCase();
                for(var o=(e.match(/^c/)&&a?i.newDate(a):null)||i.today(),s=/([+-]?[0-9]+)\s*(d|w|m|y)?/g,l=null;l=s.exec(e);)o=i.add(o,parseInt(l[1],10),l[2]||"d");
                return o
            };

            return t=t?i.newDate(t):null,e=null==e?t:"string"==typeof e?o(e):"number"==typeof e?isNaN(e)||1/0==e||e==-1/0?t:i.add(i.today(),e,"d"):i.newDate(e)
        },
        daysInMonth:function(e,t){
            return t=e.getFullYear?e.getMonth()+1:t,e=e.getFullYear?e.getFullYear():e,this.newDate(e,t+1,0).getDate()
        },
        dayOfYear:function(e,t,a){
            var r=e.getFullYear?e:this.newDate(e,t,a),i=this.newDate(r.getFullYear(),1,1);
            return Math.floor((r.getTime()-i.getTime())/this._msPerDay)+1
        },
        iso8601Week:function(e,t,a){
            var r=e.getFullYear?new Date(e.getTime()):this.newDate(e,t,a);
            r.setDate(r.getDate()+4-(r.getDay()||7));
            var i=r.getTime();
            return r.setMonth(0,1),Math.floor(Math.round((i-r)/864e5)/7)+1
        },
        today:function(){
            return this._normaliseDate(new Date)
        },
        newDate:function(e,t,a){
            return e?e.getFullYear?this._normaliseDate(new Date(e.getTime())):new Date(e,t-1,a,12):null
        },
        _normaliseDate:function(e){
            return e&&e.setHours(12,0,0,0),e
        },
        year:function(e,t){
            return e.setFullYear(t),this._normaliseDate(e)
        },
        month:function(e,t){
            return e.setMonth(t-1),this._normaliseDate(e)
        },
        day:function(e,t){
            return e.setDate(t),this._normaliseDate(e)
        },
        add:function(e,t,a){
            if("d"==a||"w"==a)this._normaliseDate(e),e.setDate(e.getDate()+t*("w"==a?7:1));
            else{
                var r=e.getFullYear()+("y"==a?t:0),n=e.getMonth()+("m"==a?t:0);
                e.setTime(i.newDate(r,n+1,Math.min(e.getDate(),this.daysInMonth(r,n+1))).getTime())
            }
            return e
        },
        _applyMonthsOffset:function(t,a){
            var r=a.options.monthsOffset;
            return e.isFunction(r)&&(r=r.apply(a.target[0],[t])),i.add(t,-r,"m")
        },
        _attachPlugin:function(t,a){
            if(t=e(t),!t.hasClass(this.markerClassName)){
                var r=e.fn.metadata?t.metadata():{},n={
                    options:e.extend({},this._defaults,r,a),
                    target:t,
                    selectedDates:[],
                    drawDate:null,
                    pickingRange:!1,
                    inline:e.inArray(t[0].nodeName.toLowerCase(),["div","span"])>-1,
                    get:function(t){
                        return e.inArray(t,["defaultDate","minDate","maxDate"])>-1?i.determineDate(this.options[t],null,this.selectedDates[0],this.options.dateFormat,n.getConfig()):this.options[t]
                    },
                    curMinDate:function(){
                        return this.pickingRange?this.selectedDates[0]:this.get("minDate")
                    },
                    getConfig:function(){
                        return{
                            dayNamesShort:this.options.dayNamesShort,
                            dayNames:this.options.dayNames,
                            monthNamesShort:this.options.monthNamesShort,
                            monthNames:this.options.monthNames,
                            calculateWeek:this.options.calculateWeek,
                            shortYearCutoff:this.options.shortYearCutoff
                        }
                    }
                };

                t.addClass(this.markerClassName).data(this.propertyName,n),n.inline?(n.drawDate=i._checkMinMax(i.newDate(n.selectedDates[0]||n.get("defaultDate")||i.today()),n),n.prevDate=i.newDate(n.drawDate),this._update(t[0]),e.fn.mousewheel&&t.mousewheel(this._doMouseWheel)):(this._attachments(t,n),t.bind("keydown."+this.propertyName,this._keyDown).bind("keypress."+this.propertyName,this._keyPress).bind("keyup."+this.propertyName,this._keyUp),t.attr("disabled")&&this._disablePlugin(t[0]))
            }
        },
        _optionPlugin:function(t,a,r){
            t=e(t);
            var n=t.data(this.propertyName);
            if(!a||"string"==typeof a&&null==r){
                var o=a;
                return a=(n||{}).options,a&&o?a[o]:a
            }
            if(t.hasClass(this.markerClassName)){
                if(a=a||{},"string"==typeof a){
                    var o=a;
                    a={},a[o]=r
                }
                if(a.calendar&&a.calendar!=n.options.calendar){
                    var s=function(e){
                        return"object"==typeof n.options[e]?null:n.options[e]
                    };

                    a=e.extend({
                        defaultDate:s("defaultDate"),
                        minDate:s("minDate"),
                        maxDate:s("maxDate")
                    },a),n.selectedDates=[],n.drawDate=null
                }
                var l=n.selectedDates;
                e.extend(n.options,a),this._setDatePlugin(t[0],l,null,!1,!0),n.pickingRange=!1,n.drawDate=i.newDate(this._checkMinMax((n.options.defaultDate?n.get("defaultDate"):n.drawDate)||n.get("defaultDate")||i.today(),n)),n.inline||this._attachments(t,n),(n.inline||n.div)&&this._update(t[0])
            }
        },
        _attachments:function(t,a){
            t.unbind("focus."+this.propertyName),a.options.showOnFocus&&t.bind("focus."+this.propertyName,this._showPlugin),a.trigger&&a.trigger.remove();
            var r=a.options.showTrigger;
            a.trigger=r?e(r).clone().removeAttr("id").addClass(this._triggerClass)[a.options.isRTL?"insertBefore":"insertAfter"](t).click(function(){
                i._isDisabledPlugin(t[0])||i[i.curInst==a?"_hidePlugin":"_showPlugin"](t[0])
            }):e([]),this._autoSize(t,a);
            var n=this._extractDates(a,t.val());
            n&&this._setDatePlugin(t[0],n,null,!0);
            var o=a.get("defaultDate");
            a.options.selectDefaultDate&&o&&0==a.selectedDates.length&&this._setDatePlugin(t[0],i.newDate(o||i.today()))
        },
        _autoSize:function(e,t){
            if(t.options.autoSize&&!t.inline){
                var a=i.newDate(2009,10,20),r=t.options.dateFormat;
                if(r.match(/[DM]/)){
                    var n=function(e){
                        for(var t=0,a=0,r=0;r<e.length;r++)e[r].length>t&&(t=e[r].length,a=r);
                        return a
                    };

                    a.setMonth(n(t.options[r.match(/MM/)?"monthNames":"monthNamesShort"])),a.setDate(n(t.options[r.match(/DD/)?"dayNames":"dayNamesShort"])+20-a.getDay())
                }
                t.target.attr("size",i.formatDate(r,a,t.getConfig()).length)
            }
        },
        _destroyPlugin:function(t){
            if(t=e(t),t.hasClass(this.markerClassName)){
                var a=t.data(this.propertyName);
                a.trigger&&a.trigger.remove(),t.removeClass(this.markerClassName).removeData(this.propertyName).empty().unbind("."+this.propertyName),a.inline&&e.fn.mousewheel&&t.unmousewheel(),!a.inline&&a.options.autoSize&&t.removeAttr("size")
            }
        },
        multipleEvents:function(){
            var e=arguments;
            return function(){
                for(var t=0;t<e.length;t++)e[t].apply(this,arguments)
            }
        },
        _enablePlugin:function(t){
            if(t=e(t),t.hasClass(this.markerClassName)){
                var a=t.data(this.propertyName);
                a.inline?t.children("."+this._disableClass).remove().end().find("button,select").removeAttr("disabled").end().find("a").attr("href","javascript:void(0)"):(t.prop("disabled",!1),a.trigger.filter("button."+this._triggerClass).removeAttr("disabled").end().filter("img."+this._triggerClass).css({
                    opacity:"1.0",
                    cursor:""
                })),this._disabled=e.map(this._disabled,function(e){
                    return e==t[0]?null:e
                })
            }
        },
        _disablePlugin:function(t){
            if(t=e(t),t.hasClass(this.markerClassName)){
                var a=t.data(this.propertyName);
                if(a.inline){
                    var r=t.children(":last"),i=r.offset(),n={
                        left:0,
                        top:0
                    };

                    r.parents().each(function(){
                        return"relative"==e(this).css("position")?(n=e(this).offset(),!1):void 0
                    });
                    var o=t.css("zIndex");
                    o=("auto"==o?0:parseInt(o,10))+1,t.prepend('<div class="'+this._disableClass+'" style="width: '+r.outerWidth()+"px; height: "+r.outerHeight()+"px; left: "+(i.left-n.left)+"px; top: "+(i.top-n.top)+"px; z-index: "+o+'"></div>').find("button,select").attr("disabled","disabled").end().find("a").removeAttr("href")
                }else t.prop("disabled",!0),a.trigger.filter("button."+this._triggerClass).attr("disabled","disabled").end().filter("img."+this._triggerClass).css({
                    opacity:"0.5",
                    cursor:"default"
                });
                this._disabled=e.map(this._disabled,function(e){
                    return e==t[0]?null:e
                }),this._disabled.push(t[0])
            }
        },
        _isDisabledPlugin:function(t){
            return t&&e.inArray(t,this._disabled)>-1
        },
        _showPlugin:function(t){
            t=e(t.target||t);
            var a=t.data(i.propertyName);
            if(i.curInst!=a&&(i.curInst&&i._hidePlugin(i.curInst,!0),a)){
                a.lastVal=null,a.selectedDates=i._extractDates(a,t.val()),a.pickingRange=!1,a.drawDate=i._checkMinMax(i.newDate(a.selectedDates[0]||a.get("defaultDate")||i.today()),a),a.prevDate=i.newDate(a.drawDate),i.curInst=a,i._update(t[0],!0);
                var r=i._checkOffset(a);
                a.div.css({
                    left:r.left,
                    top:r.top
                });
                var n=a.options.showAnim,o=a.options.showSpeed;
                if(o="normal"==o&&e.ui&&e.ui.version>="1.8"?"_default":o,e.effects&&e.effects[n]){
                    var s=a.div.data();
                    for(var l in s)l.match(/^ec\.storage\./)&&(s[l]=a._mainDiv.css(l.replace(/ec\.storage\./,"")));a.div.data(s).show(n,a.options.showOptions,o)
                }else a.div[n||"show"](n?o:"")
            }
        },
        _extractDates:function(e,t){
            if(t!=e.lastVal){
                e.lastVal=t,t=t.split(e.options.multiSelect?e.options.multiSeparator:e.options.rangeSelect?e.options.rangeSeparator:"\x00");
                for(var a=[],r=0;r<t.length;r++)try{
                    var n=i.parseDate(e.options.dateFormat,t[r],e.getConfig());
                    if(n){
                        for(var o=!1,s=0;s<a.length;s++)if(a[s].getTime()==n.getTime()){
                            o=!0;
                            break
                        }
                        o||a.push(n)
                    }
                }catch(l){}
                return a.splice(e.options.multiSelect||(e.options.rangeSelect?2:1),a.length),e.options.rangeSelect&&1==a.length&&(a[1]=a[0]),a
            }
        },
        _update:function(t,a){
            t=e(t.target||t);
            var r=t.data(i.propertyName);
            r&&((r.inline||i.curInst==r)&&(!e.isFunction(r.options.onChangeMonthYear)||r.prevDate&&r.prevDate.getFullYear()==r.drawDate.getFullYear()&&r.prevDate.getMonth()==r.drawDate.getMonth()||r.options.onChangeMonthYear.apply(t[0],[r.drawDate.getFullYear(),r.drawDate.getMonth()+1])),r.inline?t.html(this._generateContent(t[0],r)):i.curInst==r&&(r.div||(r.div=e("<div></div>").addClass(this._popupClass).css({
                display:a?"none":"static",
                position:"absolute",
                left:t.offset().left,
                top:t.offset().top+t.outerHeight()
            }).appendTo(e(r.options.popupContainer||"body")),e.fn.mousewheel&&r.div.mousewheel(this._doMouseWheel)),r.div.html(this._generateContent(t[0],r)),t.focus()))
        },
        _updateInput:function(t,a){
            var r=e.data(t,this.propertyName);
            if(r){
                for(var n="",o="",s=r.options.multiSelect?r.options.multiSeparator:r.options.rangeSeparator,l=r.options.altFormat||r.options.dateFormat,d=0;d<r.selectedDates.length;d++)n+=a?"":(d>0?s:"")+i.formatDate(r.options.dateFormat,r.selectedDates[d],r.getConfig()),o+=(d>0?s:"")+i.formatDate(l,r.selectedDates[d],r.getConfig());
                r.inline||a||e(t).val(n),e(r.options.altField).val(o),!e.isFunction(r.options.onSelect)||a||r.inSelect||(r.inSelect=!0,r.options.onSelect.apply(t,[r.selectedDates]),r.inSelect=!1)
            }
        },
        _getBorders:function(e){
            var t=function(e){
                return{
                    thin:1,
                    medium:3,
                    thick:5
                }
                [e]||e
            };

            return[parseFloat(t(e.css("border-left-width"))),parseFloat(t(e.css("border-top-width")))]
        },
        _checkOffset:function(t){
            var a=t.target.is(":hidden")&&t.trigger?t.trigger:t.target,r=a.offset(),i=e(window).width(),n=e(window).height();
            if(0==i)return r;
            var o=!1;
            e(t.target).parents().each(function(){
                return o|="fixed"==e(this).css("position"),!o
            });
            var s=document.documentElement.scrollLeft||document.body.scrollLeft,l=document.documentElement.scrollTop||document.body.scrollTop,d=r.top-(o?l:0)-t.div.outerHeight(),c=r.top-(o?l:0)+a.outerHeight(),u=r.left-(o?s:0),p=r.left-(o?s:0)+a.outerWidth()-t.div.outerWidth(),h=r.left-s+t.div.outerWidth()>i,f=r.top-l+t.target.outerHeight()+t.div.outerHeight()>n;
            t.div.css("position",o?"fixed":"absolute");
            var m=t.options.alignment;
            return r="topLeft"==m?{
                left:u,
                top:d
            }:"topRight"==m?{
                left:p,
                top:d
            }:"bottomLeft"==m?{
                left:u,
                top:c
            }:"bottomRight"==m?{
                left:p,
                top:c
            }:"top"==m?{
                left:t.options.isRTL||h?p:u,
                top:d
            }:{
                left:t.options.isRTL||h?p:u,
                top:f?d:c
            },r.left=Math.max(o?0:s,r.left),r.top=Math.max(o?0:l,r.top),r
        },
        _checkExternalClick:function(t){
            if(i.curInst){
                var a=e(t.target);
                a.parents().andSelf().hasClass(i._popupClass)||a.hasClass(i.markerClassName)||a.parents().andSelf().hasClass(i._triggerClass)||i._hidePlugin(i.curInst)
            }
        },
        _hidePlugin:function(t,a){
            if(t){
                var r=e.data(t,this.propertyName)||t;
                if(r&&r==i.curInst){
                    var n=a?"":r.options.showAnim,o=r.options.showSpeed;
                    o="normal"==o&&e.ui&&e.ui.version>="1.8"?"_default":o;
                    var s=function(){
                        r.div&&(r.div.remove(),r.div=null,i.curInst=null,e.isFunction(r.options.onClose)&&r.options.onClose.apply(t,[r.selectedDates]))
                    };

                    if(r.div.stop(),e.effects&&e.effects[n])r.div.hide(n,r.options.showOptions,o,s);
                    else{
                        var l="slideDown"==n?"slideUp":"fadeIn"==n?"fadeOut":"hide";
                        r.div[l](n?o:"",s)
                    }
                    n||s()
                }
            }
        },
        _keyDown:function(t){
            var a=t.target,r=e.data(a,i.propertyName),n=!1;
            if(r.div)if(9==t.keyCode)i._hidePlugin(a);
                else if(13==t.keyCode)i._selectDatePlugin(a,e("a."+r.options.renderer.highlightedClass,r.div)[0]),n=!0;
                else{
                    var o=r.options.commands;
                    for(var s in o){
                        var l=o[s];
                        if(l.keystroke.keyCode==t.keyCode&&!!l.keystroke.ctrlKey==!(!t.ctrlKey&&!t.metaKey)&&!!l.keystroke.altKey==t.altKey&&!!l.keystroke.shiftKey==t.shiftKey){
                            i._performActionPlugin(a,s),n=!0;
                            break
                        }
                    }
                }else{
                var l=r.options.commands.current;
                l.keystroke.keyCode==t.keyCode&&!!l.keystroke.ctrlKey==!(!t.ctrlKey&&!t.metaKey)&&!!l.keystroke.altKey==t.altKey&&!!l.keystroke.shiftKey==t.shiftKey&&(i._showPlugin(a),n=!0)
            }
            return r.ctrlKey=t.keyCode<48&&32!=t.keyCode||t.ctrlKey||t.metaKey,n&&(t.preventDefault(),t.stopPropagation()),!n
        },
        _keyPress:function(t){
            var a=e.data(t.target,i.propertyName);
            if(a&&a.options.constrainInput){
                var r=String.fromCharCode(t.keyCode||t.charCode),n=i._allowedChars(a);
                return t.metaKey||a.ctrlKey||" ">r||!n||n.indexOf(r)>-1
            }
            return!0
        },
        _allowedChars:function(e){
            for(var t=e.options.multiSelect?e.options.multiSeparator:e.options.rangeSelect?e.options.rangeSeparator:"",a=!1,r=!1,i=e.options.dateFormat,n=0;n<i.length;n++){
                var o=i.charAt(n);
                if(a)"'"==o&&"'"!=i.charAt(n+1)?a=!1:t+=o;else switch(o){
                    case"d":case"m":case"o":case"w":
                        t+=r?"":"0123456789",r=!0;
                        break;
                    case"y":case"@":case"!":
                        t+=(r?"":"0123456789")+"-",r=!0;
                        break;
                    case"J":
                        t+=(r?"":"0123456789")+"-.",r=!0;
                        break;
                    case"D":case"M":case"Y":
                        return null;
                    case"'":
                        "'"==i.charAt(n+1)?t+="'":a=!0;
                        break;
                    default:
                        t+=o
                }
            }
            return t
        },
        _keyUp:function(t){
            var a=t.target,r=e.data(a,i.propertyName);
            if(r&&!r.ctrlKey&&r.lastVal!=r.target.val())try{
                var n=i._extractDates(r,r.target.val());
                n.length>0&&i._setDatePlugin(a,n,null,!0)
            }catch(t){}
            return!0
        },
        _doMouseWheel:function(t,a){
            var r=i.curInst&&i.curInst.target[0]||e(t.target).closest("."+i.markerClassName)[0];
            if(!i._isDisabledPlugin(r)){
                var n=e.data(r,i.propertyName);
                n.options.useMouseWheel&&(a=0>a?-1:1,i._changeMonthPlugin(r,-n.options[t.ctrlKey?"monthsToJump":"monthsToStep"]*a)),t.preventDefault()
            }
        },
        _clearPlugin:function(t){
            var a=e.data(t,this.propertyName);
            if(a){
                a.selectedDates=[],this._hidePlugin(t);
                var r=a.get("defaultDate");
                a.options.selectDefaultDate&&r?this._setDatePlugin(t,i.newDate(r||i.today())):this._updateInput(t)
            }
        },
        _getDatePlugin:function(t){
            var a=e.data(t,this.propertyName);
            return a?a.selectedDates:[]
        },
        _setDatePlugin:function(t,a,r,n,o){
            var s=e.data(t,this.propertyName);
            if(s){
                e.isArray(a)||(a=[a],r&&a.push(r));
                var l=s.get("minDate"),d=s.get("maxDate"),c=s.selectedDates[0];
                s.selectedDates=[];
                for(var u=0;u<a.length;u++){
                    var p=i.determineDate(a[u],null,c,s.options.dateFormat,s.getConfig());
                    if(p&&(!l||p.getTime()>=l.getTime())&&(!d||p.getTime()<=d.getTime())){
                        for(var h=!1,f=0;f<s.selectedDates.length;f++)if(s.selectedDates[f].getTime()==p.getTime()){
                            h=!0;
                            break
                        }
                        h||s.selectedDates.push(p)
                    }
                }
                if(s.selectedDates.splice(s.options.multiSelect||(s.options.rangeSelect?2:1),s.selectedDates.length),s.options.rangeSelect){
                    switch(s.selectedDates.length){
                        case 1:
                            s.selectedDates[1]=s.selectedDates[0];
                            break;
                        case 2:
                            s.selectedDates[1]=s.selectedDates[0].getTime()>s.selectedDates[1].getTime()?s.selectedDates[0]:s.selectedDates[1]
                    }
                    s.pickingRange=!1
                }
                s.prevDate=s.drawDate?i.newDate(s.drawDate):null,s.drawDate=this._checkMinMax(i.newDate(s.selectedDates[0]||s.get("defaultDate")||i.today()),s),o||(this._update(t),this._updateInput(t,n))
            }
        },
        _isSelectablePlugin:function(t,a){
            var r=e.data(t,this.propertyName);
            return r?(a=i.determineDate(a,r.selectedDates[0]||this.today(),null,r.options.dateFormat,r.getConfig()),this._isSelectable(t,a,r.options.onDate,r.get("minDate"),r.get("maxDate"))):!1
        },
        _isSelectable:function(t,a,r,i,n){
            var o="boolean"==typeof r?{
                selectable:r
            }:e.isFunction(r)?r.apply(t,[a,!0]):{};

            return 0!=o.selectable&&(!i||a.getTime()>=i.getTime())&&(!n||a.getTime()<=n.getTime())
        },
        _performActionPlugin:function(t,a){
            var r=e.data(t,this.propertyName);
            if(r&&!this._isDisabledPlugin(t)){
                var i=r.options.commands;
                i[a]&&i[a].enabled.apply(t,[r])&&i[a].action.apply(t,[r])
            }
        },
        _showMonthPlugin:function(t,a,r,n){
            var o=e.data(t,this.propertyName);
            if(o&&(null!=n||o.drawDate.getFullYear()!=a||o.drawDate.getMonth()+1!=r)){
                o.prevDate=i.newDate(o.drawDate);
                var s=this._checkMinMax(null!=a?i.newDate(a,r,1):i.today(),o);
                o.drawDate=i.newDate(s.getFullYear(),s.getMonth()+1,null!=n?n:Math.min(o.drawDate.getDate(),i.daysInMonth(s.getFullYear(),s.getMonth()+1))),this._update(t)
            }
        },
        _changeMonthPlugin:function(t,a){
            var r=e.data(t,this.propertyName);
            if(r){
                var n=i.add(i.newDate(r.drawDate),a,"m");
                this._showMonthPlugin(t,n.getFullYear(),n.getMonth()+1)
            }
        },
        _changeDayPlugin:function(t,a){
            var r=e.data(t,this.propertyName);
            if(r){
                var n=i.add(i.newDate(r.drawDate),a,"d");
                this._showMonthPlugin(t,n.getFullYear(),n.getMonth()+1,n.getDate())
            }
        },
        _checkMinMax:function(e,t){
            var a=t.get("minDate"),r=t.get("maxDate");
            return e=a&&e.getTime()<a.getTime()?i.newDate(a):e,e=r&&e.getTime()>r.getTime()?i.newDate(r):e
        },
        _retrieveDatePlugin:function(t,a){
            var r=e.data(t,this.propertyName);
            return r?this._normaliseDate(new Date(parseInt(a.className.replace(/^.*dp(-?\d+).*$/,"$1"),10))):null
        },
        _selectDatePlugin:function(t,a){
            var r=e.data(t,this.propertyName);
            if(r&&!this._isDisabledPlugin(t)){
                var n=this._retrieveDatePlugin(t,a);
                if(r.options.multiSelect){
                    for(var o=!1,s=0;s<r.selectedDates.length;s++)if(n.getTime()==r.selectedDates[s].getTime()){
                        r.selectedDates.splice(s,1),o=!0;
                        break
                    }!o&&r.selectedDates.length<r.options.multiSelect&&r.selectedDates.push(n)
                }else r.options.rangeSelect?(r.pickingRange?r.selectedDates[1]=n:r.selectedDates=[n,n],r.pickingRange=!r.pickingRange):r.selectedDates=[n];
                r.prevDate=i.newDate(n),this._updateInput(t),r.inline||r.pickingRange||r.selectedDates.length<(r.options.multiSelect||(r.options.rangeSelect?2:1))?this._update(t):this._hidePlugin(t)
            }
        },
        _generateContent:function(t,a){
            var r=a.options.monthsToShow;
            r=e.isArray(r)?r:[1,r],a.drawDate=this._checkMinMax(a.drawDate||a.get("defaultDate")||i.today(),a);
            for(var n=i._applyMonthsOffset(i.newDate(a.drawDate),a),o="",s=0;s<r[0];s++){
                for(var l="",d=0;d<r[1];d++)l+=this._generateMonth(t,a,n.getFullYear(),n.getMonth()+1,a.options.renderer,0==s&&0==d),i.add(n,1,"m");
                o+=this._prepare(a.options.renderer.monthRow,a).replace(/\{months\}/,l)
            }
            var c=this._prepare(a.options.renderer.picker,a).replace(/\{months\}/,o).replace(/\{weekHeader\}/g,this._generateDayHeaders(a,a.options.renderer)),u=function(e,r,n,o,s){
                if(-1!=c.indexOf("{"+e+":"+o+"}")){
                    var l=a.options.commands[o],d=a.options.commandsAsDateFormat?l.date.apply(t,[a]):null;
                    c=c.replace(new RegExp("\\{"+e+":"+o+"\\}","g"),"<"+r+(l.status?' title="'+a.options[l.status]+'"':"")+' class="'+a.options.renderer.commandClass+" "+a.options.renderer.commandClass+"-"+o+" "+s+(l.enabled(a)?"":" "+a.options.renderer.disabledClass)+'">'+(d?i.formatDate(a.options[l.text],d,a.getConfig()):a.options[l.text])+"</"+n+">")
                }
            };

            for(var p in a.options.commands)u("button",'button type="button"',"button",p,a.options.renderer.commandButtonClass),u("link",'a href="javascript:void(0)"',"a",p,a.options.renderer.commandLinkClass);if(c=e(c),r[1]>1){
                var h=0;
                e(a.options.renderer.monthSelector,c).each(function(){
                    var t=++h%r[1];
                    e(this).addClass(1==t?"first":0==t?"last":"")
                })
            }
            var f=this;
            c.find(a.options.renderer.daySelector+" a").hover(function(){
                e(this).addClass(a.options.renderer.highlightedClass)
            },function(){
                (a.inline?e(this).parents("."+f.markerClassName):a.div).find(a.options.renderer.daySelector+" a").removeClass(a.options.renderer.highlightedClass)
            }).click(function(){
                f._selectDatePlugin(t,this)
            }).end().find("select."+this._monthYearClass+":not(."+this._anyYearClass+")").change(function(){
                var a=e(this).val().split("/");
                f._showMonthPlugin(t,parseInt(a[1],10),parseInt(a[0],10))
            }).end().find("select."+this._anyYearClass).click(function(){
                e(this).css("visibility","hidden").next("input").css({
                    left:this.offsetLeft,
                    top:this.offsetTop,
                    width:this.offsetWidth,
                    height:this.offsetHeight
                }).show().focus()
            }).end().find("input."+f._monthYearClass).change(function(){
                try{
                    var r=parseInt(e(this).val(),10);
                    r=isNaN(r)?a.drawDate.getFullYear():r,f._showMonthPlugin(t,r,a.drawDate.getMonth()+1,a.drawDate.getDate())
                }catch(i){
                    alert(i)
                }
            }).keydown(function(t){
                13==t.keyCode?e(t.target).change():27==t.keyCode&&(e(t.target).hide().prev("select").css("visibility","visible"),a.target.focus())
            }),c.find("."+a.options.renderer.commandClass).click(function(){
                if(!e(this).hasClass(a.options.renderer.disabledClass)){
                    var r=this.className.replace(new RegExp("^.*"+a.options.renderer.commandClass+"-([^ ]+).*$"),"$1");
                    i._performActionPlugin(t,r)
                }
            }),a.options.isRTL&&c.addClass(a.options.renderer.rtlClass),r[0]*r[1]>1&&c.addClass(a.options.renderer.multiClass),a.options.pickerClass&&c.addClass(a.options.pickerClass),e("body").append(c);
            var m=0;
            return c.find(a.options.renderer.monthSelector).each(function(){
                m+=e(this).outerWidth()
            }),c.width(m/r[0]),e.isFunction(a.options.onShow)&&a.options.onShow.apply(t,[c,a]),c
        },
        _generateMonth:function(t,a,r,n,o,s){
            var l=i.daysInMonth(r,n),d=a.options.monthsToShow;
            d=e.isArray(d)?d:[1,d];
            var c=a.options.fixedWeeks||d[0]*d[1]>1,u=a.options.firstDay,p=(i.newDate(r,n,1).getDay()-u+7)%7,h=c?6:Math.ceil((p+l)/7),f=a.options.selectOtherMonths&&a.options.showOtherMonths,m=a.pickingRange?a.selectedDates[0]:a.get("minDate"),g=a.get("maxDate"),v=o.week.indexOf("{weekOfYear}")>-1,y=i.today(),x=i.newDate(r,n,1);
            i.add(x,-p-(c&&x.getDay()==u?7:0),"d");
            for(var w=x.getTime(),_="",C=0;h>C;C++){
                for(var b=v?'<span class="dp'+w+'">'+(e.isFunction(a.options.calculateWeek)?a.options.calculateWeek(x):0)+"</span>":"",T="",k=0;7>k;k++){
                    var D=!1;
                    if(a.options.rangeSelect&&a.selectedDates.length>0)D=x.getTime()>=a.selectedDates[0]&&x.getTime()<=a.selectedDates[1];else for(var F=0;F<a.selectedDates.length;F++)if(a.selectedDates[F].getTime()==x.getTime()){
                        D=!0;
                        break
                    }
                    var S=e.isFunction(a.options.onDate)?a.options.onDate.apply(t,[x,x.getMonth()+1==n]):{},$=(f||x.getMonth()+1==n)&&this._isSelectable(t,x,S.selectable,m,g);
                    T+=this._prepare(o.day,a).replace(/\{day\}/g,($?'<a href="javascript:void(0)"':"<span")+' class="dp'+w+" "+(S.dateClass||"")+(D&&(f||x.getMonth()+1==n)?" "+o.selectedClass:"")+($?" "+o.defaultClass:"")+((x.getDay()||7)<6?"":" "+o.weekendClass)+(x.getMonth()+1==n?"":" "+o.otherMonthClass)+(x.getTime()==y.getTime()&&x.getMonth()+1==n?" "+o.todayClass:"")+(x.getTime()==a.drawDate.getTime()&&x.getMonth()+1==n?" "+o.highlightedClass:"")+'"'+(S.title||a.options.dayStatus&&$?' title="'+(S.title||i.formatDate(a.options.dayStatus,x,a.getConfig()))+'"':"")+">"+(a.options.showOtherMonths||x.getMonth()+1==n?S.content||x.getDate():"&nbsp;")+($?"</a>":"</span>")),i.add(x,1,"d"),w=x.getTime()
                }
                _+=this._prepare(o.week,a).replace(/\{days\}/g,T).replace(/\{weekOfYear\}/g,b)
            }
            var E=this._prepare(o.month,a).match(/\{monthHeader(:[^\}]+)?\}/);
            E=E[0].length<=13?"MM yyyy":E[0].substring(13,E[0].length-1),E=s?this._generateMonthSelection(a,r,n,m,g,E,o):i.formatDate(E,i.newDate(r,n,1),a.getConfig());
            var j=this._prepare(o.weekHeader,a).replace(/\{days\}/g,this._generateDayHeaders(a,o));
            return this._prepare(o.month,a).replace(/\{monthHeader(:[^\}]+)?\}/g,E).replace(/\{weekHeader\}/g,j).replace(/\{weeks\}/g,_)
        },
        _generateDayHeaders:function(e,t){
            for(var a="",r=0;7>r;r++){
                var i=(r+e.options.firstDay)%7;
                a+=this._prepare(t.dayHeader,e).replace(/\{day\}/g,'<span class="'+this._curDoWClass+i+'" title="'+e.options.dayNames[i]+'">'+e.options.dayNamesMin[i]+"</span>")
            }
            return a
        },
        _generateMonthSelection:function(e,t,a,r,n,o){
            if(!e.options.changeMonth)return i.formatDate(o,i.newDate(t,a,1),e.getConfig());
            for(var s=e.options["monthNames"+(o.match(/mm/i)?"":"Short")],l=o.replace(/m+/i,"\\x2E").replace(/y+/i,"\\x2F"),d='<select class="'+this._monthYearClass+'" title="'+e.options.monthStatus+'">',c=1;12>=c;c++)(!r||i.newDate(t,c,i.daysInMonth(t,c)).getTime()>=r.getTime())&&(!n||i.newDate(t,c,1).getTime()<=n.getTime())&&(d+='<option value="'+c+"/"+t+'"'+(a==c?' selected="selected"':"")+">"+s[c-1]+"</option>");
            d+="</select>",l=l.replace(/\\x2E/,d);
            var u=e.options.yearRange;
            if("any"==u)d='<select class="'+this._monthYearClass+" "+this._anyYearClass+'" title="'+e.options.yearStatus+'"><option>'+t+'</option></select><input class="'+this._monthYearClass+" "+this._curMonthClass+a+'" value="'+t+'">';
            else{
                u=u.split(":");
                var p=i.today().getFullYear(),h=u[0].match("c[+-].*")?t+parseInt(u[0].substring(1),10):(u[0].match("[+-].*")?p:0)+parseInt(u[0],10),f=u[1].match("c[+-].*")?t+parseInt(u[1].substring(1),10):(u[1].match("[+-].*")?p:0)+parseInt(u[1],10);
                d='<select class="'+this._monthYearClass+'" title="'+e.options.yearStatus+'">',h=i.add(i.newDate(h+1,1,1),-1,"d"),f=i.newDate(f,1,1);
                var m=function(e){
                    0!=e&&(d+='<option value="'+a+"/"+e+'"'+(t==e?' selected="selected"':"")+">"+e+"</option>")
                };

                if(h.getTime()<f.getTime()){
                    h=(r&&r.getTime()>h.getTime()?r:h).getFullYear(),f=(n&&n.getTime()<f.getTime()?n:f).getFullYear();
                    for(var g=h;f>=g;g++)m(g)
                }else{
                    h=(n&&n.getTime()<h.getTime()?n:h).getFullYear(),f=(r&&r.getTime()>f.getTime()?r:f).getFullYear();
                    for(var g=h;g>=f;g--)m(g)
                }
                d+="</select>"
            }
            return l=l.replace(/\\x2F/,d)
        },
        _prepare:function(e,t){
            var a=function(t,a){
                for(;;){
                    var r=e.indexOf("{"+t+":start}");
                    if(-1==r)return;
                    var i=e.substring(r).indexOf("{"+t+":end}");
                    i>-1&&(e=e.substring(0,r)+(a?e.substr(r+t.length+8,i-t.length-8):"")+e.substring(r+i+t.length+6))
                }
            };

            a("inline",t.inline),a("popup",!t.inline);
            for(var r=/\{l10n:([^\}]+)\}/,i=null;i=r.exec(e);)e=e.replace(i[0],t.options[i[1]]);
            return e
        }
    });
    var r=["getDate","isDisabled","isSelectable","retrieveDate"];
    e.fn.datepick=function(e){
        var t=Array.prototype.slice.call(arguments,1);
        return a(e,t)?i["_"+e+"Plugin"].apply(i,[this[0]].concat(t)):this.each(function(){
            if("string"==typeof e){
                if(!i["_"+e+"Plugin"])throw"Unknown command: "+e;
                i["_"+e+"Plugin"].apply(i,[this].concat(t))
            }else i._attachPlugin(this,e||{})
        })
    };

    var i=e.datepick=new t;
    e(function(){
        e(document).mousedown(i._checkExternalClick).resize(function(){
            i._hidePlugin(i.curInst)
        })
    })
}(jQuery),function(e,t,a){
    function r(a,r,i){
        var n=t.createElement(a);
        return r&&(n.id=K+r),i&&(n.style.cssText=i),e(n)
    }
    function i(e){
        var t=_.length,a=(I+e)%t;
        return 0>a?t+a:a
    }
    function n(e,t){
        return Math.round((/%/.test(e)?("x"===t?C.width():C.height())/100:1)*parseInt(e,10))
    }
    function o(e){
        return A.photo||/\.(gif|png|jp(e|g|eg)|bmp|ico)((#|\?).*)?$/i.test(e)
    }
    function s(){
        var t,a=e.data(R,G);
        null==a?(A=e.extend({},z),console&&console.log&&console.log("Error: cboxElement missing settings object")):A=e.extend({},a);
        for(t in A)e.isFunction(A[t])&&"on"!==t.slice(0,2)&&(A[t]=A[t].call(R));A.rel=A.rel||R.rel||e(R).data("rel")||"nofollow",A.href=A.href||e(R).attr("href"),A.title=A.title||R.title,"string"==typeof A.href&&(A.href=e.trim(A.href))
    }
    function l(t,a){
        e.event.trigger(t),a&&a.call(R)
    }
    function d(){
        var e,t,a,r=K+"Slideshow_",i="click."+K;
        A.slideshow&&_[1]?(t=function(){
            S.html(A.slideshowStop).unbind(i).bind(Z,function(){
                (A.loop||_[I+1])&&(e=setTimeout(B.next,A.slideshowSpeed))
            }).bind(X,function(){
                clearTimeout(e)
            }).one(i+" "+et,a),f.removeClass(r+"off").addClass(r+"on"),e=setTimeout(B.next,A.slideshowSpeed)
        },a=function(){
            clearTimeout(e),S.html(A.slideshowStart).unbind([Z,X,et,i].join(" ")).one(i,function(){
                B.next(),t()
            }),f.removeClass(r+"on").addClass(r+"off")
        },A.slideshowAuto?t():a()):f.removeClass(r+"off "+r+"on")
    }
    function c(t){
        W||(R=t,s(),_=e(R),I=0,"nofollow"!==A.rel&&(_=e("."+Q).filter(function(){
            var t,a=e.data(this,G);
            return a&&(t=e(this).data("rel")||a.rel||this.rel),t===A.rel
        }),I=_.index(R),-1===I&&(_=_.add(R),I=_.length-1)),H||(H=q=!0,f.show(),A.returnFocus&&e(R).blur().one(tt,function(){
            e(this).focus()
        }),h.css({
            opacity:+A.opacity,
            cursor:A.overlayClose?"pointer":"auto"
        }).show(),A.w=n(A.initialWidth,"x"),A.h=n(A.initialHeight,"y"),B.position(),it&&C.bind("resize."+nt+" scroll."+nt,function(){
            h.css({
                width:C.width(),
                height:C.height(),
                top:C.scrollTop(),
                left:C.scrollLeft()
            })
        }).trigger("resize."+nt),l(J,A.onOpen),P.add(D).hide(),j.html(A.close).show()),B.load(!0))
    }
    function u(){
        !f&&t.body&&(Y=!1,C=e(a),f=r(ot).attr({
            id:G,
            "class":rt?K+(it?"IE6":"IE"):""
        }).hide(),h=r(ot,"Overlay",it?"position:absolute":"").hide(),k=r(ot,"LoadingOverlay").add(r(ot,"LoadingGraphic")),m=r(ot,"Wrapper"),g=r(ot,"Content").append(b=r(ot,"LoadedContent","width:0; height:0; overflow:hidden"),D=r(ot,"Title"),F=r(ot,"Current"),$=r(ot,"Next"),E=r(ot,"Previous"),S=r(ot,"Slideshow").bind(J,d),j=r(ot,"Close")),m.append(r(ot).append(r(ot,"TopLeft"),v=r(ot,"TopCenter"),r(ot,"TopRight")),r(ot,!1,"clear:left").append(y=r(ot,"MiddleLeft"),g,x=r(ot,"MiddleRight")),r(ot,!1,"clear:left").append(r(ot,"BottomLeft"),w=r(ot,"BottomCenter"),r(ot,"BottomRight"))).find("div div").css({
            "float":"left"
        }),T=r(ot,!1,"position:absolute; width:9999px; visibility:hidden; display:none"),P=$.add(E).add(F).add(S),e(t.body).append(h,f.append(m,T)))
    }
    function p(){
        return f?(Y||(Y=!0,M=v.height()+w.height()+g.outerHeight(!0)-g.height(),L=y.width()+x.width()+g.outerWidth(!0)-g.width(),O=b.outerHeight(!0),N=b.outerWidth(!0),f.css({
            "padding-bottom":M,
            "padding-right":L
        }),$.click(function(){
            B.next()
        }),E.click(function(){
            B.prev()
        }),j.click(function(){
            B.close()
        }),h.click(function(){
            A.overlayClose&&B.close()
        }),e(t).bind("keydown."+K,function(e){
            var t=e.keyCode;
            H&&A.escKey&&27===t&&(e.preventDefault(),B.close()),H&&A.arrowKey&&_[1]&&(37===t?(e.preventDefault(),E.click()):39===t&&(e.preventDefault(),$.click()))
        }),e(t).delegate("."+Q,"click",function(e){
            e.which>1||e.shiftKey||e.altKey||e.metaKey||(e.preventDefault(),c(this))
        })),!0):!1
    }
    var h,f,m,g,v,y,x,w,_,C,b,T,k,D,F,S,$,E,j,P,A,M,L,O,N,R,I,U,H,q,W,V,B,Y,z={
        transition:"elastic",
        speed:300,
        width:!1,
        initialWidth:"600",
        innerWidth:!1,
        maxWidth:!1,
        height:!1,
        initialHeight:"450",
        innerHeight:!1,
        maxHeight:!1,
        scalePhotos:!0,
        scrolling:!0,
        inline:!1,
        html:!1,
        iframe:!1,
        fastIframe:!0,
        photo:!1,
        href:!1,
        title:!1,
        rel:!1,
        opacity:.9,
        preloading:!0,
        current:"image {current} of {total}",
        previous:"previous",
        next:"next",
        close:'<img src="'+SITE_ROOT_URL+'/common/images/login_cross.png" alt="close" />',
        xhrError:"This content failed to load.",
        imgError:"This image failed to load.",
        open:!1,
        returnFocus:!0,
        reposition:!0,
        loop:!0,
        slideshow:!1,
        slideshowAuto:!0,
        slideshowSpeed:2500,
        slideshowStart:"start slideshow",
        slideshowStop:"stop slideshow",
        onOpen:!1,
        onLoad:!1,
        onComplete:!1,
        onCleanup:!1,
        onClosed:!1,
        overlayClose:!0,
        escKey:!0,
        arrowKey:!0,
        top:!1,
        bottom:!1,
        left:!1,
        right:!1,
        fixed:!1,
        data:void 0
    },G="colorbox",K="cbox",Q=K+"Element",J=K+"_open",X=K+"_load",Z=K+"_complete",et=K+"_cleanup",tt=K+"_closed",at=K+"_purge",rt=!e.support.opacity&&!e.support.style,it=rt&&!a.XMLHttpRequest,nt=K+"_IE6",ot="div";
    e.colorbox||(e(u),B=e.fn[G]=e[G]=function(t,a){
        var r=this;
        if(t=t||{},u(),p()){
            if(!r[0]){
                if(r.selector)return r;
                r=e("<a/>"),t.open=!0
            }
            a&&(t.onComplete=a),r.each(function(){
                e.data(this,G,e.extend({},e.data(this,G)||z,t))
            }).addClass(Q),(e.isFunction(t.open)&&t.open.call(r)||t.open)&&c(r[0])
        }
        return r
    },B.position=function(e,t){
        function a(e){
            v[0].style.width=w[0].style.width=g[0].style.width=e.style.width,g[0].style.height=y[0].style.height=x[0].style.height=e.style.height
        }
        var r,i,o,s=0,l=0,d=f.offset();
        C.unbind("resize."+K),f.css({
            top:-9e4,
            left:-9e4
        }),i=C.scrollTop(),o=C.scrollLeft(),A.fixed&&!it?(d.top-=i,d.left-=o,f.css({
            position:"fixed"
        })):(s=i,l=o,f.css({
            position:"absolute"
        })),l+=A.right!==!1?Math.max(C.width()-A.w-N-L-n(A.right,"x"),0):A.left!==!1?n(A.left,"x"):Math.round(Math.max(C.width()-A.w-N-L,0)/2),s+=A.bottom!==!1?Math.max(C.height()-A.h-O-M-n(A.bottom,"y"),0):A.top!==!1?n(A.top,"y"):Math.round(Math.max(C.height()-A.h-O-M,0)/2),f.css({
            top:d.top,
            left:d.left
        }),e=f.width()===A.w+N&&f.height()===A.h+O?0:e||0,m[0].style.width=m[0].style.height="9999px",r={
            width:A.w+N,
            height:A.h+O,
            top:s,
            left:l
        },0===e&&f.css(r),f.dequeue().animate(r,{
            duration:e,
            complete:function(){
                a(this),q=!1,m[0].style.width=A.w+N+L+"px",m[0].style.height=A.h+O+M+"px",A.reposition&&setTimeout(function(){
                    C.bind("resize."+K,B.position)
                },1),t&&t()
            },
            step:function(){
                a(this)
            }
        })
    },B.resize=function(e){
        H&&(e=e||{},e.width&&(A.w=n(e.width,"x")-N-L),e.innerWidth&&(A.w=n(e.innerWidth,"x")),b.css({
            width:A.w
        }),e.height&&(A.h=n(e.height,"y")-O-M),e.innerHeight&&(A.h=n(e.innerHeight,"y")),e.innerHeight||e.height||(b.css({
            height:"auto"
        }),A.h=b.height()),b.css({
            height:A.h
        }),B.position("none"===A.transition?0:A.speed))
    },B.prep=function(t){
        function a(){
            return A.w=A.w||b.width(),A.w=A.mw&&A.mw<A.w?A.mw:A.w,A.w
        }
        function n(){
            return A.h=A.h||b.height(),A.h=A.mh&&A.mh<A.h?A.mh:A.h,A.h
        }
        if(H){
            var s,d="none"===A.transition?0:A.speed;
            b.remove(),b=r(ot,"LoadedContent").append(t),b.hide().appendTo(T.show()).css({
                width:a(),
                overflow:A.scrolling?"auto":"hidden"
            }).css({
                height:n()
            }).prependTo(g),T.hide(),e(U).css({
                "float":"none"
            }),it&&e("select").not(f.find("select")).filter(function(){
                return"hidden"!==this.style.visibility
            }).css({
                visibility:"hidden"
            }).one(et,function(){
                this.style.visibility="inherit"
            }),s=function(){
                function t(){
                    rt&&f[0].style.removeAttribute("filter")
                }
                var a,n,s,c,u,p,h,m=_.length,g="frameBorder",v="allowTransparency";
                if(H){
                    if(c=function(){
                        clearTimeout(V),k.detach().hide(),l(Z,A.onComplete)
                    },rt&&U&&b.fadeIn(100),D.html(A.title).add(b).show(),m>1){
                        if("string"==typeof A.current&&F.html(A.current.replace("{current}",I+1).replace("{total}",m)).show(),$[A.loop||m-1>I?"show":"hide"]().html(A.next),E[A.loop||I?"show":"hide"]().html(A.previous),A.slideshow&&S.show(),A.preloading)for(a=[i(-1),i(1)];n=_[a.pop()];)h=e.data(n,G),h&&h.href?(u=h.href,e.isFunction(u)&&(u=u.call(n))):u=n.href,o(u)&&(p=new Image,p.src=u)
                    }else P.hide();
                    A.iframe?(s=r("iframe")[0],g in s&&(s[g]=0),v in s&&(s[v]="true"),A.scrolling||(s.scrolling="no"),e(s).attr({
                        src:A.href,
                        name:(new Date).getTime(),
                        "class":K+"Iframe",
                        allowFullScreen:!0,
                        webkitAllowFullScreen:!0,
                        mozallowfullscreen:!0
                    }).one("load",c).one(at,function(){
                        s.src="//about:blank"
                    }).appendTo(b),A.fastIframe&&e(s).trigger("load")):c(),"fade"===A.transition?f.fadeTo(d,1,t):t()
                }
            },"fade"===A.transition?f.fadeTo(d,0,function(){
                B.position(0,s)
            }):B.position(d,s)
        }
    },B.load=function(t){
        var a,i,d=B.prep;
        q=!0,U=!1,R=_[I],t||s();
        var c=R;
        l(at),l(X,A.onLoad),A.h=A.height?n(A.height,"y")-O-M:A.innerHeight&&n(A.innerHeight,"y"),A.w=A.width?n(A.width,"x")-N-L:A.innerWidth&&n(A.innerWidth,"x"),c.toString().indexOf("#view_details")>0&&(A.w=830,A.h=460),A.mw=A.w,A.mh=A.h,A.maxWidth&&(A.mw=n(A.maxWidth,"x")-N-L,A.mw=A.w&&A.w<A.mw?A.w:A.mw),A.maxHeight&&(A.mh=n(A.maxHeight,"y")-O-M,A.mh=A.h&&A.h<A.mh?A.h:A.mh),a=A.href,V=setTimeout(function(){
            k.show().appendTo(g)
        },100),A.inline?(r(ot).hide().insertBefore(e(a)[0]).one(at,function(){
            e(this).replaceWith(b.children())
        }),d(e(a))):A.iframe?d(" "):A.html?d(A.html):o(a)?(e(U=new Image).addClass(K+"Photo").error(function(){
            A.title=!1,d(r(ot,"Error").html(A.imgError))
        }).load(function(){
            var e;
            U.onload=null,A.scalePhotos&&(i=function(){
                U.height-=U.height*e,U.width-=U.width*e
            },A.mw&&U.width>A.mw&&(e=(U.width-A.mw)/U.width,i()),A.mh&&U.height>A.mh&&(e=(U.height-A.mh)/U.height,i())),A.h&&(U.style.marginTop=Math.max(A.h-U.height,0)/2+"px"),_[1]&&(A.loop||_[I+1])&&(U.style.cursor="pointer",U.onclick=function(){
                B.next()
            }),rt&&(U.style.msInterpolationMode="bicubic"),setTimeout(function(){
                d(U)
            },1)
        }),setTimeout(function(){
            U.src=a
        },1)):a&&T.load(a,A.data,function(t,a){
            d("error"===a?r(ot,"Error").html(A.xhrError):e(this).contents())
        })
    },B.next=function(){
        !q&&_[1]&&(A.loop||_[I+1])&&(I=i(1),B.load())
    },B.prev=function(){
        !q&&_[1]&&(A.loop||I)&&(I=i(-1),B.load())
    },B.close=function(){
        H&&!W&&(W=!0,H=!1,l(et,A.onCleanup),C.unbind("."+K+" ."+nt),h.fadeTo(200,0),f.stop().fadeTo(300,0,function(){
            f.add(h).css({
                opacity:1,
                cursor:"auto"
            }).hide(),l(at),b.remove(),setTimeout(function(){
                W=!1,l(tt,A.onClosed)
            },1)
        }))
    },B.remove=function(){
        e([]).add(f).add(h).remove(),f=null,e("."+Q).removeData(G).removeClass(Q),e(t).undelegate("."+Q)
    },B.element=function(){
        return e(R)
    },B.settings=z)
}(jQuery,document,window),function(e){
    e.fn.extend({
        autocomplete:function(t,a){
            var r="string"==typeof t;
            return a=e.extend({},e.Autocompleter.defaults,{
                url:r?t:null,
                data:r?null:t,
                delay:r?e.Autocompleter.defaults.delay:10,
                max:a&&!a.scroll?1e4:150
            },a),a.highlight=a.highlight||function(e){
                return e
            },a.formatMatch=a.formatMatch||a.formatItem,this.each(function(){ 
                new e.Autocompleter(this,a)
            })
        },
        result:function(e){ 
            return this.bind("result",e)
        },
        search:function(e){ 
            return this.trigger("search",[e])
        },
        flushCache:function(){
            return this.trigger("flushCache")
        },
        setOptions:function(e){ 
            return this.trigger("setOptions",[e])
        },
        unautocomplete:function(){
            return this.trigger("unautocomplete")
        }
    }),e.Autocompleter=function(t,a){
        function r(){
            var r=b.selected();
            if(!r)return!1;
            var i=r.result;
            //replace selector into text format
            i=$(i).text();
            if(x=i,a.multiple){
                var o=n(y.val());
                if(o.length>1){
                    var s,l=a.multipleSeparator.length,c=e(t).selection().start,u=0;
                    e.each(o,function(e,t){
                        return u+=t.length,u>=c?(s=e,!1):void(u+=l)
                    }),o[s]=i,i=o.join(a.multipleSeparator)
                }
                i+=a.multipleSeparator
            }
            return y.val(i),d(),y.trigger("result",[r.data,r.value]),!0
        }
        function i(e,t){
            if(m==v.DEL)return void b.hide();
            var r=y.val();
            (t||r!=x)&&(x=r,r=o(r),r.length>=a.minChars?(y.addClass(a.loadingClass),a.matchCase||(r=r.toLowerCase()),u(r,c,d)):(h(),b.hide()))
        }
        function n(t){
            return t?a.multiple?e.map(t.split(a.multipleSeparator),function(a){
                return e.trim(t).length?e.trim(a):null
            }):[e.trim(t)]:[""]
        }
        function o(r){
            if(!a.multiple)return r;
            var i=n(r);
            if(1==i.length)return i[0];
            var o=e(t).selection().start;
            return i=n(o==r.length?r:r.replace(r.substring(o),"")),i[i.length-1]
        }
        function s(r,i){
            a.autoFill&&o(y.val()).toLowerCase()==r.toLowerCase()&&m!=v.BACKSPACE&&(y.val(y.val()+i.substring(o(x).length)),e(t).selection(x.length,x.length+i.length))
        }
        function l(){
            clearTimeout(f),f=setTimeout(d,200)
        }
        function d(){
            b.visible();
            b.hide(),clearTimeout(f),h(),a.mustMatch&&y.search(function(e){
                if(!e)if(a.multiple){
                    var t=n(y.val()).slice(0,-1);
                    y.val(t.join(a.multipleSeparator)+(t.length?a.multipleSeparator:""))
                }else y.val(""),y.trigger("result",null)
            })
        }
        function c(e,t){
            t&&t.length&&_?(h(),b.display(t,e),s(e,t[0].value),b.show()):d()
        }
        function u(r,i,n){
            a.matchCase||(r=r.toLowerCase());
            var s=w.load(r);
            if(s&&s.length)i(r,s);
            else if("string"==typeof a.url&&a.url.length>0){
                var l={
                    timestamp:+new Date
                };

                e.each(a.extraParams,function(e,t){
                    l[e]="function"==typeof t?t():t
                }),e.ajax({
                    mode:"abort",
                    port:"autocomplete"+t.name,
                    dataType:a.dataType,
                    url:a.url,
                    data:e.extend({
                        q:o(r),
                        limit:a.max
                    },l),
                    success:function(e){
                        var t=a.parse&&a.parse(e)||p(e);
                        w.add(r,t),i(r,t)
                    }
                })
            }else b.emptyList(),n(r)
        }
        function p(t){
            for(var r=[],i=t.split("\n"),n=0;n<i.length;n++){
                var o=e.trim(i[n]);
                o&&(o=o.split("|"),r[r.length]={
                    data:o,
                    value:o[0],
                    result:a.formatResult&&a.formatResult(o,o[0])||o[0]
                })
            }
            return r
        }
        function h(){
            y.removeClass(a.loadingClass)
        }
        var f,m,g,v={
            UP:38,
            DOWN:40,
            DEL:46,
            TAB:9,
            RETURN:13,
            ESC:27,
            COMMA:188,
            PAGEUP:33,
            PAGEDOWN:34,
            BACKSPACE:8
        },y=e(t).attr("autocomplete","off").addClass(a.inputClass),x="",w=e.Autocompleter.Cache(a),_=0,C={
            mouseDownOnSelect:!1
        },b=e.Autocompleter.Select(a,t,r,C);
        e.browser.opera&&e(t.form).bind("submit.autocomplete",function(){
            return g?(g=!1,!1):void 0
        }),y.bind((e.browser.opera?"keypress":"keydown")+".autocomplete",function(t){
            switch(_=1,m=t.keyCode,t.keyCode){
                case v.UP:
                    t.preventDefault(),b.visible()?b.prev():i(0,!0);
                    break;
                case v.DOWN:
                    t.preventDefault(),b.visible()?b.next():i(0,!0);
                    break;
                case v.PAGEUP:
                    t.preventDefault(),b.visible()?b.pageUp():i(0,!0);
                    break;
                case v.PAGEDOWN:
                    t.preventDefault(),b.visible()?b.pageDown():i(0,!0);
                    break;
                case a.multiple&&","==e.trim(a.multipleSeparator)&&v.COMMA:case v.TAB:case v.RETURN:
                    if(r())return t.preventDefault(),g=!0,!1;
                    break;
                case v.ESC:
                    b.hide();
                    break;
                default:
                    clearTimeout(f),f=setTimeout(i,a.delay)
            }
        }).focus(function(){
            _++
        }).blur(function(){
            _=0,C.mouseDownOnSelect||l()
        }).click(function(){ 
            _++>1&&!b.visible()&&i(0,!0)
        }).bind("search",function(){
            function t(e,t){
                var r;
                if(t&&t.length)for(var i=0;i<t.length;i++)if(t[i].result.toLowerCase()==e.toLowerCase()){
                    r=t[i];
                    break
                }
                "function"==typeof a?a(r):y.trigger("result",r&&[r.data,r.value])
            }
            var a=arguments.length>1?arguments[1]:null;
            e.each(n(y.val()),function(e,a){
                u(a,t,t)
            })
        }).bind("flushCache",function(){
            w.flush()
        }).bind("setOptions",function(){
            e.extend(a,arguments[1]),"data"in arguments[1]&&w.populate()
        }).bind("unautocomplete",function(){
            b.unbind(),y.unbind(),e(t.form).unbind(".autocomplete")
        })
    },e.Autocompleter.defaults={
        inputClass:"ac_input",
        resultsClass:"ac_results",
        loadingClass:"ac_loading",
        minChars:2,
        delay:400,
        matchCase:!1,
        matchSubset:!0,
        matchContains:!1,
        cacheLength:10,
        max:100,
        mustMatch:!1,
        extraParams:{},
        selectFirst:!0,
        formatItem:function(e){
            return e[0]
        },
        formatMatch:null,
        autoFill:!1,
        width:0,
        multiple:!1,
        multipleSeparator:", ",
        highlight:function(e,t){
            return e.replace(new RegExp("(?![^&;]+;)(?!<[^<>]*)("+t.replace(/([\^\$\(\)\[\]\{\}\*\.\+\?\|\\])/gi,"\\$1")+")(?![^<>]*>)(?![^&;]+;)","gi"),"<strong>$1</strong>")
        },
        scroll:!0,
        scrollHeight:500
    },e.Autocompleter.Cache=function(t){
        function a(e,a){
            t.matchCase||(e=e.toLowerCase());
            var r=e.indexOf(a);
            return"word"==t.matchContains&&(r=e.toLowerCase().search("\\b"+a.toLowerCase())),-1==r?!1:0==r||t.matchContains
        }
        function r(e,a){
            s>t.cacheLength&&n(),o[e]||s++,o[e]=a
        }
        function i(){
            if(!t.data)return!1;
            var a={},i=0;
            t.url||(t.cacheLength=1),a[""]=[];
            for(var n=0,o=t.data.length;o>n;n++){
                var s=t.data[n];
                s="string"==typeof s?[s]:s;
                var l=t.formatMatch(s,n+1,t.data.length);
                if(l!==!1){
                    var d=l.charAt(0).toLowerCase();
                    a[d]||(a[d]=[]);
                    var c={
                        value:l,
                        data:s,
                        result:t.formatResult&&t.formatResult(s)||l
                    };
                    
                    a[d].push(c),i++<t.max&&a[""].push(c)
                }
            }
            e.each(a,function(e,a){
                t.cacheLength++,r(e,a)
            })
        }
        function n(){
            o={},s=0
        }
        var o={},s=0;
        return setTimeout(i,25),{
            flush:n,
            add:r,
            populate:i,
            load:function(r){
                if(!t.cacheLength||!s)return null;
                if(!t.url&&t.matchContains){
                    var i=[];
                    for(var n in o)if(n.length>0){
                        var l=o[n];
                        e.each(l,function(e,t){
                            a(t.value,r)&&i.push(t)
                        })
                    }
                    return i
                }
                if(o[r])return o[r];
                if(t.matchSubset)for(var d=r.length-1;d>=t.minChars;d--){
                    var l=o[r.substr(0,d)];
                    if(l){
                        var i=[];
                        return e.each(l,function(e,t){
                            a(t.value,r)&&(i[i.length]=t)
                        }),i
                    }
                }
                return null
            }
        }
    },e.Autocompleter.Select=function(t,a,r,i){
        function n(){
            y&&(h=e("<div/>").hide().addClass(t.resultsClass).css("position","absolute").appendTo(document.body),f=e("<ul/>").appendTo(h).mouseover(function(t){
                o(t).nodeName&&"LI"==o(t).nodeName.toUpperCase()&&(g=e("li",f).removeClass(m.ACTIVE).index(o(t)),e(o(t)).addClass(m.ACTIVE))
            }).click(function(t){
                return e(o(t)).addClass(m.ACTIVE),r(),a.focus(),!1
            }).mousedown(function(){
                i.mouseDownOnSelect=!0
            }).mouseup(function(){
                i.mouseDownOnSelect=!1
            }),t.width>0&&h.css("width",t.width),y=!1)
        }
        function o(e){
            for(var t=e.target;t&&"LI"!=t.tagName;)t=t.parentNode;
            return t?t:[]
        }
        function s(e){
            u.slice(g,g+1).removeClass(m.ACTIVE),l(e);
            var a=u.slice(g,g+1).addClass(m.ACTIVE);
            if(t.scroll){
                var r=0;
                u.slice(0,g).each(function(){
                    r+=this.offsetHeight
                }),r+a[0].offsetHeight-f.scrollTop()>f[0].clientHeight?f.scrollTop(r+a[0].offsetHeight-f.innerHeight()):r<f.scrollTop()&&f.scrollTop(r)
            }
        }
        function l(e){
            g+=e,0>g?g=u.size()-1:g>=u.size()&&(g=0)
        }
        function d(e){
            return t.max&&t.max<e?t.max:e
        }
        function c(){
            f.empty();
            for(var a=d(p.length),r=0;a>r;r++)if(p[r]){
                var i=t.formatItem(p[r].data,r+1,a,p[r].value,v);
                if(i!==!1){
                    var n=e("<li/>").html(t.highlight(i,v)).addClass(r%2==0?"ac_even":"ac_odd").appendTo(f)[0];
                    i.indexOf("<b>")>=0?e.data(n,"heading",p[r]):e.data(n,"ac_data",p[r])
                }
            }
            u=f.find("li"),t.selectFirst&&(u.slice(0,1).addClass(m.ACTIVE),g=0),e.fn.bgiframe&&f.bgiframe()
        }
        var u,p,h,f,m={
            ACTIVE:"ac_over"
        },g=-1,v="",y=!0;
        return{
            display:function(e,t){
                n(),p=e,v=t,c()
            },
            next:function(){
                s(1)
            },
            prev:function(){
                s(-1)
            },
            pageUp:function(){
                s(0!=g&&0>g-8?-g:-8)
            },
            pageDown:function(){
                s(g!=u.size()-1&&g+8>u.size()?u.size()-1-g:8)
            },
            hide:function(){
                h&&h.hide(),u&&u.removeClass(m.ACTIVE),g=-1
            },
            visible:function(){
                return h&&h.is(":visible")
            },
            current:function(){
                return this.visible()&&(u.filter("."+m.ACTIVE)[0]||t.selectFirst&&u[0])
            },
            show:function(){
                var r=e(a).offset();
                if(h.css({
                    width:"string"==typeof t.width||t.width>0?t.width:e(a).width(),
                    top:r.top+a.offsetHeight,
                    left:r.left
                }).show(),t.scroll&&(f.scrollTop(0),f.css({
                    maxHeight:t.scrollHeight,
                    overflow:"auto"
                }),e.browser.msie&&"undefined"==typeof document.body.style.maxHeight)){
                    var i=0;
                    u.each(function(){
                        i+=this.offsetHeight
                    });
                    var n=i>t.scrollHeight;
                    f.css("height",n?t.scrollHeight:i),n||u.width(f.width()-parseInt(u.css("padding-left"))-parseInt(u.css("padding-right")))
                }
            },
            selected:function(){
                var t=u&&u.filter("."+m.ACTIVE).removeClass(m.ACTIVE);
                return t&&t.length&&e.data(t[0],"ac_data")
            },
            emptyList:function(){
                f&&f.empty()
            },
            unbind:function(){
                h&&h.remove()
            }
        }
    },e.fn.selection=function(e,t){
        if(void 0!==e)return this.each(function(){
            if(this.createTextRange){
                var a=this.createTextRange();
                void 0===t||e==t?(a.move("character",e),a.select()):(a.collapse(!0),a.moveStart("character",e),a.moveEnd("character",t),a.select())
            }else this.setSelectionRange?this.setSelectionRange(e,t):this.selectionStart&&(this.selectionStart=e,this.selectionEnd=t)
        });
        var a=this[0];
        if(a.createTextRange){
            var r=document.selection.createRange(),i=a.value,n="<->",o=r.text.length;
            r.text=n;
            var s=a.value.indexOf(n);
            return a.value=i,this.selection(s,s+o),{
                start:s,
                end:s+o
            }
        }
        return void 0!==a.selectionStart?{
            start:a.selectionStart,
            end:a.selectionEnd
        }:void 0
    }
}(jQuery);
var countType=1;
$(document).ready(function(){
    $("#click").click(function(){
        return $("#click").css({
            "background-color":"#f00",
            color:"#fff",
            cursor:"inherit"
        }).text(OPEN_THIS_WINDOW),!1
    });
    var e=$.cookie("googtrans");
    "/en/en"==e&&$.cookie("googtrans",null),$("#popupAddToCart .cross").click(function(){
        $("#popupAddToCart").hide(),$("#fancybox-overlay").hide()
    }),$("#frmUserEmailLn").change(function(){
        if(""==$(this).val()||null==$(this).val()){
            var e=errorMessageLogin("");
            $(".frmUserEmailLn").html(e)
        }else $(".frmUserEmailLn").html("")
    }),$("#frmUserPasswordLn").change(function(){
        if(""==$(this).val()||null==$(this).val()){
            var e=errorMessageLogin("");
            $(".frmUserPasswordLn").html(e)
        }else $(".frmUserPasswordLn").html("")
    }),$("#frmUserEmailFp").change(function(){
        if(""==$(this).val()||null==$(this).val()){
            var e=errorMessageLogin("");
            $(".frmUserEmailFp").html(e)
        }else $(".frmUserEmailFp").html("")
    })
}),jQuery(document).ready(function(){
    jQuery("#frmGiftCard").validationEngine("attach",{
        scroll:!1
    }),jQuery(".send_gift_card").click(function(e){
        jQuery(".pop_up_sec").css({
            display:"block",
            "z-index":"100"
        }),jQuery("#fancybox-overlay").css({
            display:"block"
        }),e.preventDefault()
    }),jQuery(".gift_card_close").click(function(e){
        jQuery(".pop_up_sec").css({
            display:"none"
        }),jQuery("#fancybox-overlay").css({
            display:"none"
        }),e.preventDefault()
    }),$("#defaultInline").datepick({
        multiSelect:999,
        monthsToShow:1,
        minDate:new Date,
        onSelect:function(e){
            var t=e.toString().split(","),a="";
            for(i=0;i<t.length;i++)date=new Date(t[i]),d=date.getDate(),10>d&&(d="0"+d),m=date.getMonth()+1,10>m&&(m="0"+m),y=date.getFullYear(),""!=a?a+=","+d+"-"+m+"-"+y:a=d+"-"+m+"-"+y;
            $("#giftCardCalender").val(a),$("#dateRequiredValidation").val(""!=$("#giftCardCalender").val()&&"NaN-NaN-NaN"!=$("#giftCardCalender").val()?"1":"")
        }
    }),$(window).resize(function(){
        chaneHeaderMenu()
    }).resize(),$(".radio_btn .radio").live("click",function(){
        var e=$("input:radio[name=frmUserTypeLn]:checked"),t=e.val(),a=e.attr("u"),r=e.attr("p");
        ""==a?($("input:checkbox[name=remember_me]").removeAttr("checked"),$("input:checkbox[name=remember_me]").prev().attr("style","background-position: 0px 0px")):($("input:checkbox[name=remember_me]").attr("checked","checked"),$("input:checkbox[name=remember_me]").prev().attr("style","background-position: 0px -50px")),$("#frmUserEmailLn").val(a),$("#frmUserPasswordLn").val(r),"customer"==t?$(".social_login_icons").show():$(".social_login_icons").hide()
    })
}),$(function(){
    $(".moreLink").click(function(){
        $("#category_list").show(),$("ul li.moreLink").hide(),$("ul li.lessLink").show()
    }),$(".lessLink").click(function(){
        $("#category_list").hide(),$("ul li.moreLink").show(),$("ul li.lessLink").hide()
    })
}),jQuery(document).ready(function(){
    jQuery("#searchKey").live("click",function(){
        jQuery("#searchKey").autocomplete(SITE_ROOT_URL+"common/ajax/ajax_autocomplete.php?action=searchKeyAutocomplete&catid="+jQuery("#searchcid").val()+"&q="+jQuery("#searchKey").val(),{
            width:390,
            matchContains:!0,
            selectFirst:!1
        })
    })
}),jQuery(document).ready(function(){
    jQuery("#searchKey").live("click",function(){
        jQuery("#searchKey").autocomplete(SITE_ROOT_URL+"common/ajax/ajax_autocomplete.php?action=searchKeyAutocomplete&catid="+jQuery("#searchcid").val()+"&q="+jQuery("#searchKey").val(),{
            width:390,
            matchContains:!0,
            selectFirst:!1
        })
    })
});
var idp=null;
$(function(){
    $(".idpico").click(function(){
        idp=$(this).attr("idp"),start_auth("?provider="+idp)
    })
}),$(document).ready(function(){
    $(document).click(function(e){
        0==$(e.target).parents(".cart_div").length
    }),$("body").on("click",".deletecart_button",function(e){
        e.preventDefault(),$(".scroll-pane").jScrollPane();
        var t=$(this).parent().parent().attr("class");
        t=t.split(" "),t=$("."+t[1]).height();
        var a=($(".cart_complete").height()-t,$(".jspTrack").height()-t,$(this).next().attr("id"));
        $("#"+a).show();
        var r=$(this).attr("tp"),i=$(this).attr("pid"),n=$(this).attr("ind"),o=$(this).attr("stUrl"),s=$(this).attr("inr"),l=$("#frmProductQuantity"+s).val();
        "product"==r?RemoveProductFromCart1(i,n,o,s,l):"package"==r?RemovePackageFromCart1(i,n,o,s,l):"giftcard"==r?RemoveGiftCardFromCart1(i,o,s,l):"",$(".scroll-pane").jScrollPane()
    }),$("body").on("click",".topCartClose",function(e){
        e.preventDefault(),$(".nt-example1-container").hide()
    }),$("body").on("change","#countries",function(){
        var e=this.value;
        $.post(SITE_ROOT_URL+"common/ajax/ajax_converter.php",{
            action:"ChangeCurrency",
            currencyCode:e
        },function(){
            location.reload()
        })
    }),$("body").stop().on("click",".saveTowishlist",function(e){
        e.preventDefault(),$(this).off("click");
        var t=$(this).attr("Pid"),a=$(this).attr("btcheck"),r=($(this).prev().attr("class"),$(this).attr("tp"));
        "recomended"==r?$("<a href='#' class='info afterSavedInWishList' style='background:red;color:white;padding: 5px 20px 5px 20px;float: left;'>Saved</a>").insertBefore("#"+t):"category_grey"==r||"category_orenge"==r?($("<a href='#' class='cart_link_1 afterSavedInWishList' style='background:red;color:white'>Saved</a>").insertBefore("."+t),$("<a href='#' class='info afterSavedInWishList' style='background:red;color:white;'>Saved</a>").insertBefore(".orenge_"+t)):$("<a href='#' class='info afterSavedInWishList' style='background:red;color:white;'>Saved</a>").insertBefore("."+a),$("."+t).hide(),$(".orenge_"+t).hide(),$("#"+t).hide(),$("."+a).hide(),$.post(SITE_ROOT_URL+"common/ajax/ajax_customer.php",{
            action:"addTowish",
            pid:t
        },function(){})
    }),$("body").on("click",".afterSavedInWishList",function(e){
        e.preventDefault()
    })
    
});