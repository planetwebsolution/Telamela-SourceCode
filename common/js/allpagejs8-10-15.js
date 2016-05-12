//function addToCompare(e, t, a, o) {
//    $(".succCart").hide(), $("#addtoCompareMessage" + e).show(), $("#addtoCompareMessage_quick_" + e).show(), $.post(SITE_ROOT_URL + "common/ajax/ajax_compare.php", {action: "addToCompare", pid: e, cid: t}, function(t) {
//        "4" == t ? alert(ADD_COMPARE_MAX_ERROR) : "already" == t ? ("quickView" == o && "undefined" != o ? $("#addtoCompareMessage_quick_" + e).html('<span class="red">' + ALREADY_COMPARE_LIST + "</span>") : $("#addtoCompareMessage" + e).html('<span class="red" >' + ALREADY_COMPARE_LIST + "</span>"), setTimeout(function() {
//            $("#addtoCompareMessage" + e).html("&nbsp"), $("#addtoCompareMessage_quick_" + e).html("&nbsp")
//        }, 4e3)) : "notSameCategory" == t ? ("quickView" == o && "undefined" != o ? $("#addtoCompareMessage_quick_" + e).html('<span class="red">' + NOT_SAME_CATE + "</span>") : $("#addtoCompareMessage" + e).html('<span class="red" >' + NOT_SAME_CATE + "</span>"), setTimeout(function() {
//            $("#addtoCompareMessage" + e).html("&nbsp"), $("#addtoCompareMessage_quick_" + e).html("&nbsp")
//        }, 4e3)) : ($("#ajaxAddToCompare").html(t),
//           "quickView" == o && "undefined" != o ? $("#addtoCompareMessage_quick_" + e).html(ADD_COMPARE_SUCC + "&nbsp; <a href=" + a + ' style="color:blue" class="v_compare"><strong>View compare</strong></a>') : $("#addtoCompareMessage" + e).html(ADD_COMPARE_SUCC + "&nbsp; <a href=" + a + ' style="color:blue" class="v_compare"><strong>View compare</strong></a>'),
//           
//    setTimeout(function() {
//            $("#addtoCompareMessage" + e).html("&nbsp")
//        }, 4e3))
//    })
//}
//$(document).on('contextmenu', function() {
//  return false;
//});
function addToCompare(id, catid, lnk,quickView) { // alert(lnk);return false; alert()
    //alert(quickView);
    $('.succCart').hide();
    $('#addtoCompareMessage' + id).show();
    $('#addtoCompareMessage_quick_'+id).show();
    var gtClass=$('*').hasClass('myCompareUl')?'1':'2';
    if(gtClass=='1'){
        $('.myCompareUl').find('li .blankCompare:first').html('<div class="compareLoader"><img src="'+SITE_ROOT_URL+'common/images/loader1.gif"></div>');
    }
    //return false;
    $.post(SITE_ROOT_URL + 'common/ajax/ajax_compare.php', {
        action: 'addToCompare',
        pid: id,
        cid: catid
    }, function(data) {
        if (data == '4') {
            //$('#addtoCompareMessage'+id).html('&nbsp; '+ADD_COMPARE_MAX_ERROR);
            alert(ADD_COMPARE_MAX_ERROR);
            
        } else if (data == 'already') {
             if(quickView=='quickView' && quickView!='undefined'){ 
                $('#addtoCompareMessage_quick_'+id).html('<span class="red">' + ALREADY_COMPARE_LIST + '</span>');
             }else{  
              $('#addtoCompareMessage' + id).html('<span class="red" >' + ALREADY_COMPARE_LIST + '</span>');
             }
            setTimeout(function() {
                $('#addtoCompareMessage'+id).html('&nbsp');
                $('#addtoCompareMessage_quick_'+id).html('&nbsp');
            }, 4000);

        } else if (data == 'notSameCategory') {
            if(quickView=='quickView' && quickView!='undefined'){ 
            $('#addtoCompareMessage_quick_'+id).html('<span class="red">' + NOT_SAME_CATE + '</span>');
            }else{ 
                $('#addtoCompareMessage' + id).html('<span class="red" >' + NOT_SAME_CATE + '</span>');
            }
            setTimeout(function() {
                $('#addtoCompareMessage'+id).html('&nbsp');
                $('#addtoCompareMessage_quick_'+id).html('&nbsp');
            }, 4000);

        } else {
            $('#ajaxAddToCompare').html(data);
            if(quickView=='quickView' && quickView!='undefined'){ 
            $('#addtoCompareMessage_quick_'+id).html(ADD_COMPARE_SUCC + '&nbsp; <a href=' + lnk + ' style="color:blue" class="v_compare"><strong>View compare</strong></a>');
            }else{
            $('#addtoCompareMessage' + id).html(ADD_COMPARE_SUCC + '&nbsp; <a href=' + lnk + ' style="color:blue" class="v_compare"><strong>View compare</strong></a>');
            }
            $('.newCompareBox').show();
            var gtClass=$('*').hasClass('myCompareUl')?'1':'2';
            if(gtClass=='1'){
                $.post(SITE_ROOT_URL + 'common/ajax/ajax_compare.php', {
                    action: 'addToCompareCategory',
                    pid: id,
                    cid: catid
                }, function(data) { //alert(data);return false;
                    var dSplit=data.split("+++");
                    //alert(dSplit[0]+'---'+dSplit[1]);return false;
                    if(dSplit[0] >=2){
                        $('.compareButton').find('a').removeClass('not-active');
                        $('.compareButton').find('a').html('Compare '+'('+dSplit[0]+')');
                    }else{
                        $('.compareButton').find('a').html('Compare '+'('+dSplit[0]+')');
                        //$('.v_compare')
                    }
                    $('.myCompareUl').html(dSplit[1]);
                })  
            }
            setTimeout(function() {
                $('#addtoCompareMessage' + id).html('&nbsp');
            }, 4000);


        //goToByScroll('ajaxAddToCompare');
        }
        var gtClass1=$('*').hasClass('myCompareUl')?'1':'2';
        if(gtClass1=='1'){
        $('.myCompareUl').find('li .blankCompare:first').html('Add another product');
       }
    });
}
function addToWishlist(e) {
    $("#addtoCompareMessage" + e).hide(), $(".succCart").show(), $.post(SITE_ROOT_URL + "common/ajax/ajax_compare.php", {action: "addToWishlist", pid: e}, function() {
        $(".succCart").html("&nbsp; " + ADD_WISHLIST_SUCC), $("#" + e).html("&nbsp; " + ADD_WISHLIST_SUCC), setTimeout(function() {
            $(".succCart").html("&nbsp"), $("#" + e).html("&nbsp")
        }, 4e3)
    })
}
function addToWishlistLogin(e) {
    $("#addtoCompareMessage" + e).hide(), $(".succCart").show(), $(".succCart").html('<span class="red">&nbsp; Please login as customer to add in save list.</span>'), $("#" + e).html('<span class="red">&nbsp; Please login as customer to add in save list.</span>'), setTimeout(function() {
        $(".succCart").html("&nbsp")
    }, 4e3)
}
function hideLanguage() {
    $("#LanguageMenu").hide()
}
function currencyConvert(e) {
    var t = $.trim($("#" + e).val());
    $.post("common/ajax/ajax_converter.php", {action: "currencyConvert", amount: t}, function(t) {
        $("#" + e).val(t)
    })
}
$(document).ready(function() {
    $("#countries").msDropdown(), $(".Currency #countries_msdd .ddTitle #countries_title").on("click", function() {
        $("#__LanguageMenu_popup").hide()
    }), $(".language").on("click", function() {
        $("#__LanguageMenu_popup").show(), $("#countries_child").hide()
    }), $(".Currency #countries_msdd .ddTitle .arrow").on("click", function() {
        $("#__LanguageMenu_popup").hide()
    }), $(".nt-example-images").newsTicker({row_height: 200,autostart:0, max_rows: $.trim($(".nt-example-images").find("li").length) <= 3 ? $.trim($(".nt-example-images").find("li").length) : 3, pauseOnHover: $.trim($(".nt-example-images").find("li").length) > 3 ? 1 : 0, duration: 4e3, prevButton: $(".nt-example-images-prev"), nextButton: $(".nt-example-images-next")}),
    $(".nt-example1").newsTicker({row_height: 200, max_rows: $.trim($(".nt-example1").find("li").length) <= 2 ? $.trim($(".nt-example1").find("li").length) : 2, autostart: $.trim($(".nt-example1").find("li").length) > 3 ? 1 : 0, duration: 4e3, prevButton: $(".nt-example1-prev"), nextButton: $(".nt-example1-next")}), 
    $(".nt-example2").newsTicker({row_height: 200, max_rows: $.trim($(".nt-example2").find("li").length) <= 2 ? $.trim($(".nt-example2").find("li").length) : 2, autostart: $.trim($(".nt-example2").find("li").length) > 2 ? 1 : 0, duration: 4e3, prevButton: $(".nt-example2-prev"), nextButton: $(".nt-example2-next")}),
    $(".nt-example3").newsTicker({row_height: 200, max_rows: $.trim($(".nt-example3").find("li").length) <= 2 ? $.trim($(".nt-example3").find("li").length) : 2, autostart: $.trim($(".nt-example3").find("li").length) > 2 ? 1 : 0, duration: 4e3, prevButton: $(".nt-example3-prev"), nextButton: $(".nt-example3-next")}), 
    $(".nt-example4").newsTicker({row_height: 200, max_rows: $.trim($(".nt-example4").find("li").length) <= 2 ? $.trim($(".nt-example4").find("li").length) : 3, autostart: $.trim($(".nt-example4").find("li").length) > 3 ? 1 : 0, duration: 4e3, prevButton: $(".nt-example4-prev"), nextButton: $(".nt-example4-next")}),$(".nt-example5").newsTicker({row_height: 200, max_rows: $.trim($(".nt-example5").find("li").length) <= 2 ? $.trim($(".nt-example5").find("li").length) : 3, autostart: $.trim($(".nt-example5").find("li").length) > 3 ? 1 : 0, duration: 4e3, prevButton: $(".nt-example5-prev"), nextButton: $(".nt-example5-next")}), $("body").height() > 980 && $(window).scroll(function() {
        $(this).scrollTop() > 40 ? $(".tpsction").addClass("f-nav") : $(".tpsction").removeClass("f-nav")
    }), $("input").each(function() {
        var e = $(this).val();
        if ($.isNumeric(e)) {
            var t = e.split(".");
            "undefined" != typeof t[1] && $(this).val(parseFloat($(this).val()).toFixed(2))
        }
    }), $("#checkShippingAvilable").on("click", function() {
        var e = $.trim($("#productShippingCountry").val()), t = $.trim($("#checkShippingByPincode").val()), a = $.trim($("#checkShippingByProductId").val()), o = $("#productShippingCountry option:selected").text(), n = 0;
        return 0 == e ? ($(".select2-container .select2-choice").css({borderColor: "red"}), !1) : (e > 0 && (n = 1, $(".select2-container .select2-choice").css({borderColor: "grey"})), "" == t ? ($("#checkShippingByPincode").css({borderColor: "red"}), !1) : ("" != t && (n = 1, $("#checkShippingByPincode").css({borderColor: "grey"})), void(1 == n && ($(".productShippingMsg").html('<span style="color:green;font-size:12px;clear:both;">Please wait we verified.....</span>'), $.ajax({url: SITE_ROOT_URL + "common/ajax/ajax_shipping_charge.php", type: "POST", data: {action: "checkShippingAvilable", productShippingCountry: e, checkShippingByPincode: t, checkShippingByProductId: a, productShippingCountryName: o}, async: !1, beforeSend: function() {
                $(".productShippingMsg").html('<span style="color:green;font-size:12px;clear:both;">Please wait we verified.....</span>')
            }, success: function(e) {
                $(".productShippingMsg").html("available" == e.toString() ? '<span style="color:green;font-size:12px;clear:both;">Shipping is available for this product</span>' : '<span style="color:red;font-size:12px;clear:both;">Sorry ! Shipping is not available for this product. Please change shipping address.</span>'), setTimeout(function() {
                    $(".productShippingMsg").html("")
                }, 5e3)
            }})))))
    }),$('#closeCompareSection').on('click',function(e){
        e.preventDefault();
        $(this).parent().parent().hide();
    })
}), $(function() {
    $(".scroll-pane").jScrollPane()
}), $(document).ready(function() {
    $(".horizontalTab").easyResponsiveTabs({type: "default", width: "1000px", fit: !0, closed: "accordion", activate: function() {
            var e = $(this), t = $("#tabInfo"), a = $("span", t);
            a.text(e.text()), t.show()
        }}), $(".verticalTab").easyResponsiveTabs({type: "vertical", width: "auto", fit: !0})
}), $(function() {
    $("body").scrollTop(0)
}), $(document).ready(function() {
    $(".successMessage").fadeOut(8e3), $("body").on("click", "#feedbackUpdate", function() {
        var e = $(this).attr("fid");
        $.ajax({type: "POST", url: SITE_ROOT_URL + "common/ajax/ajax.php", data: {action: "updateFeedback", fid: e}, dataType: "json", success: function(e) {
                console.log(e)
            }})
    });
    var e = 220, t = 500;
    $(window).scroll(function() {
        $(this).scrollTop() > e ? $(".back-to-top").fadeIn(t) : $(".back-to-top").fadeOut(t)
    }), $(".back-to-top").click(function(e) {
        return e.preventDefault(), $("html,body").animate({scrollTop: 0}, t), !1
    });
    $(".redio_color a").click(function() {
        var e = $(this).attr("id");
        $("#" + e).css("border", "1px solid red"), $(".redio_color").find("div").removeClass("double"), $("#" + e).wrap("<div/>").parent().addClass("double")
    });
    $(".imagecheckbox span a").click(function() {
        var e = $(this).attr("id");
        $("#" + e).find("div").find("a").css("border", "1px solid red"), $(".imagecheckbox").find("div").removeClass("double"), $("#" + e).wrap("<div/>").parent().addClass("double")
    });
    var a = 1;
    $("body").on("click", ".customer_review_before_login", function() {
        var e = $(this).parent();
        $.trim(a) <= 1 && ($('<div class="reviewErMessage">Please login as customer to add review.</div>').insertAfter(e), a = parseInt(a) + 1), setTimeout(function() {
            $(".reviewErMessage").remove(), a = parseInt(a) - 1
        }, 4e3)
    }), $(".submitrev").click(function() {
        location.reload()
    });
    var o = 1;
    $(".submit4,.compare_btn,.v_compare").live("click", function(e) {
//        e.preventDefault();
        var a = $(this).attr("class");
        $.post(SITE_ROOT_URL + "common/ajax/ajax_compare.php", {action: "checkCompareCount"}, function(e) {
            2 > e && 1 == o && ($("." + a).after('<div id="checkCompareCount_id"><span style="color:red;font-size:12px;">There should be at least two product in the compare list to compare.</span></div>'), o = 2), e >= 2, setTimeout(function() {
                o = 1, $("#checkCompareCount_id").remove()
            }, 4e3)
        })
    }), $("#frmCurrentCustomerPassword").on("blur", function() {
        var e = $.trim($("#frmCurrentCustomerPassword").val());
        $.post(SITE_ROOT_URL + "common/ajax/ajax_customer.php", {action: "checkCurrentCustomerPassword", pid: e}, function(e) {
            2 == e && ($("#passError span").html("Current password does not match with our record."), $("#frmCurrentCustomerPassword").val("")), 1 == e && $("#passError span").html(""), setTimeout(function() {
                $("#passError span").html("")
            }, 4e3)
        })
    }),
     $("#frmCurrentLogisticPassword").on("blur", function() {
        var e = $.trim($("#frmCurrentLogisticPassword").val());
        $.post(SITE_ROOT_URL + "common/ajax/ajax_login.php", {action: "checkCurrentLogicticPassword", pid: e}, function(e) {
            2 == e && ($("#passError span").html("Current password does not match with our record."), $("#frmCurrentLogisticPassword").val("")), 1 == e && $("#passError span").html(""), setTimeout(function() {
                $("#passError span").html("")
            }, 4e3)
        })
    })
});