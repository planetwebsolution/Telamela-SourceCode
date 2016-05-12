function jscallQuickViewWishlist(t) {
    $("." + t).colorbox({
        inline: !0,
        width: "900px",
        height: "800px"
    }), setTimeout(function() {
        $("#" + t + " .product_img .jcarousel-clip ul").jcarousel()
    }, 500)
}

function jscallQuickView(t) {
    $("." + t).colorbox({
        height: 800,
        onComplete: function() {
            $(".jqzoom").jqzoom({
                zoomType: "standard",
                lens: !0,
                preloadImages: !1,
                alwaysOn: !1
            }), $("#" + t + " .product_img .jcarousel-clip ul").jcarousel()
        }
    })
}

function errorMessageHome() {
    var t = "* " + required;
    return '<div class="formError" style="opacity: 0.87; position:inherit; top: 180px; display: block; margin-top: 0px; left: 164px;"><div class="formErrorContent"> ' + t + '<br></div><div class="formErrorArrow"><div class="line10"><!-- --></div><div class="line9"><!-- --></div><div class="line8"><!-- --></div><div class="line7"><!-- --></div><div class="line6"><!-- --></div><div class="line5"><!-- --></div><div class="line4"><!-- --></div><div class="line3"><!-- --></div><div class="line2"><!-- --></div><div class="line1"><!-- --></div></div></div>'
}

function errorMessageHomeLowQuantity(t) {
    var i = "* Maximum value is " + t;
    return '<div class="formError" style="opacity: 0.87; position:inherit; top: 180px; display: block; margin-top: 0px; left: 164px;"><div class="formErrorContent"> ' + i + '<br></div><div class="formErrorArrow"><div class="line10"><!-- --></div><div class="line9"><!-- --></div><div class="line8"><!-- --></div><div class="line7"><!-- --></div><div class="line6"><!-- --></div><div class="line5"><!-- --></div><div class="line4"><!-- --></div><div class="line3"><!-- --></div><div class="line2"><!-- --></div><div class="line1"><!-- --></div></div></div>'
}

function calculateOptPrice() {
    var t = $("#viewPageDetails").val();
    if (void 0 == t) var i = "detail",
        e = $(".attribute_detail_view");
    else var i = "quick",
        e = $(".attribute_quick_view");
    e.find(".price_details strong").stop(!0, !0).animate({
        fontSize: "23px"
    }, "slow");
    var a, r, s, l, o = new Array,
        c = e.find(".optPriceVal").val(),
        c = e.find(".optPriceVal").val(),
        n = "",
        d = 0;
    for (l = c.split(","), a = 0; a < l.length; a++) s = l[a].split("="), o['"' + s[0] + '"'] = s[1];
    var p = e.find(".recommmend_blog li");
    p.each(function() {
        var t = $(this).attr("type");
        if ("checkbox" == t && $(this).find("input").each(function() {
                $(this).is(":checked") && (n += $(this).val() + ",")
            }), ("radio" == t || "image" == t) && $(this).find("input").each(function() {
                $(this).is(":checked") && (n += $(this).val() + ",")
            }), "select" == t) {
            var i = $(this).find("select").val();
            "" != i && (n += i + ",")
        }
        "textarea" == t && $(this).find("textarea").val(), "text" == t && $(this).find("input[type=text]").val()
    });
    var u = n.split(","),
        v = 0;
    for (r = 0; r < u.length; r++) "" != u[r] && (d = getvalidPrice(o['"' + u[r] + '"']), v += d);
    var f = getvalidPrice(e.find(".optPriceVal").attr("productPrice")),
        m = v + f;
    setTimeout(function() {
        if (1 == e.find(".price_details").is(":has(small)")) {
            var t = e.find(".price_details small").html();
            t = t.replace(SiteCurrencySign, " ");
            var i = myPrice(m);
            i = i.replace(SiteCurrencySign, " "), t = t.replace(",", ""), i = i.replace(",", "");
            var a = t - i;
            a = a.toFixed(2), 0 > a ? $(".save_amt").hide() : $(".save_amt").show(), $(".save_amt").find("cite").html(SiteCurrencySign + a)
        }
        e.find(".price_details strong").html(myPrice(m)), e.find(".price_details strong").stop(!0, !0).animate({
            fontSize: "20px"
        }, "slow")
    }, 1e3);
    var h = e.find(".optPriceVal").attr("pid");
    $.ajax({
        type: "POST",
        url: SITE_ROOT_URL + "common/ajax/ajax_stock.php",
        data: {
            action: "getStock",
            optIds: n,
            pid: h
        },
        success: function(t) {
            var a = jQuery.parseJSON(t),
                r = a.opt;
            for (var s in r) {
                var l = r[s].fkAttributeId,
                    o = r[s].fkAttributeOptionId,
                    c = r[s].AttributeInputType;
                "image" == c ? $('input:radio[name="frmAttribute_' + l + '"]').is(":checked") : "radio" == c ? $('input:radio[name="frmAttribute_' + l + '"]').is(":checked") : "select" == c ? "" == $("#frmAttribute_" + l).val() ? ($("#frmAttribute_" + l).css("border", "1px solid #d2d2d2"), $("#frmAttribute_" + l).next().css("border", "1px solid #d2d2d2")) : ($("#frmAttribute_" + l).css("border", "1px solid red"), $("#frmAttribute_" + l).next().css("border", "1px solid red")) : "checkbox" == c && ($(".check_box").find('input:checkbox[value="' + o + '"]').next().css("border", "1px solid #6DB746"), $(".check_box").find('input:checkbox[value="' + o + '"]').is(":checked") && $(".check_box").find('input:checkbox[value="' + o + '"]').next().css("border", "0px solid #6DB746")), console.log(l + "=" + o + "=" + c)
            }
            t = a.stock; {
                var n = $(".blue").html(),
                    d = $(".varifiedUser").val(),
                    p = "loginuser" == d ? "addToWishlist(" + h + ")" : "addToWishlistLogin()",
                    u = 0 == t ? "#c3c3c3" : "#FFFFFF",
                    v = $(".compare_quick").attr("cmCid"),
                    f = h;
                SITE_ROOT_URL + "product_comparison.php"
            }
            if (e.find("#stock").html(t), "0" == t)
                if ("quick" == i) {
                    var m = '<div class="input_S"><div class="errorQuantity"></div><input type="hidden" value="0" name="frmQuantity" id="frmQuantity" maxlength="3" disabled /></div><div class="succCart">&nbsp;</div><div style="clear:both; margin-top:20px;"><div class="left_bottom"><p class="" style="background:none;"><a class="watch_link1" href="javascript:void();" onclick="' + p + '">Add to Save List</a><a cmCid="' + v + '" cmPid="' + f + '" id="CompareCheckBox' + f + '" class="compare_quick" onclick="addToCompare(' + f + "," + v + ",'" + SITE_ROOT_URL + 'product_comparison.php\',\'quickView\')" href="javascript:void(0);">Compare</a></p></div></div><div class="right_bottom"><a href="javascript:void(0);" class="out_of_stock_cart_link1">Out Of Stock</a></div><div id="addtoCompareMessage' + f + '" class="addtoCompareMessage"></div><div id="addtoCompareMessage_quick_' + f + '" class="addtoCompareMessage"></div><big></big>';
                    e.find(".qty_li_cls").html(m)
                } else {
                    var m = '<div class="input_S"><div class="errorQuantity"></div><input type="hidden" value="0" name="frmQuantity" id="frmQuantity" maxlength="3" disabled /></div><span class="red">Out Of Stock</span><big></big>';
                    e.find(".qty_li_cls").html(m), $("#cart_link").html("Out Of Stock"), $("#cart_link").attr("class", "cart_link campare_link"), $("#cart_link").attr("onclick", "return false;")
                } else if ("quick" == i) {
                var m = '<label>Quantity</label><div class="quantity"><div class="input_S"><div class="errorQuantity"></div></div><input type="text" name="frmQuantity" id="frmQty" value="1" maxlength="3" readonly="" /><input type="button" name="add" onclick="quantityPlusMinus(1,\'qv\')" value="+" class="plus" /><input type="button" name="subtract" onclick="quantityPlusMinus(0,\'qv\')" value="-" class="minus" /><span></span></div><p class="mylabelP"><span style="font-size:14px; color:#4b4c4e">Stock :</span><span style=" background:' + u + ';" class="inStockspan"> <span id="stock">' + t + '</span> In Stock&nbsp;&nbsp;</span></p><div style="clear:both; margin-top:20px;"><div class="left_bottom"><p class="" id="add_cart_link" style="padding-top:10px; background:none;"><a class="watch_link1" href="javascript:void(0);" onclick="' + p + '">Add to Save List</a><a cmCid="' + v + '" cmPid="' + f + '" id="CompareCheckBox' + f + '" class="compare_quick" onclick="addToCompare(' + f + "," + v + ",'" + SITE_ROOT_URL + 'product_comparison.php\',\'quickView\')" href="javascript:void(0);">Compare</a></p></div></div><div class="right_bottom"><a href="javascript:void(0);" class="cart_link1" pv="' + h + '" pmv="' + t + '">Add to Cart</a><div class="blue">' + n + '</div></div><div id="addtoCompareMessage' + f + '" class="addtoCompareMessage"></div><div id="addtoCompareMessage_quick_' + f + '" class="addtoCompareMessage"></div><div class="succCart">&nbsp;</div>';
                e.find(".qty_li_cls").html(m)
            } else {
                var m = '<label>Quantity</label><div class="quantity"><div class="input_S"><div class="errorQuantity"></div></div><input type="text" name="frmQuantity" id="frmQuantity" value="1" maxlength="3" readonly /><input type="button" name="add" onclick="quantityPlusMinus(1,\'\')" value="+" class="plus" /><input type="button" name="subtract" onclick="quantityPlusMinus(0,\'\')" value="-" class="minus" /><span></span></div><p class="mylabelP"><span style="font-size:14px; color:#4b4c4e">Stock :</span><span style="background:' + u + ';" class="inStockspan"> <span id="stock">"' + t + "</span> In Stock&nbsp;&nbsp;</span></p>";
                e.find(".qty_li_cls").html(m), $("#cart_link").html("Add to Cart"), $("#cart_link").attr("class", "cart_link1"), $("#cart_link").attr("onclick", "return addToProductCart(" + h + ");")
            }
        }
    })
}

function calculateOptPricePackage(t, i, e, a) {
    var r = $("#viewPageDetails").val();
    if (void 0 == r) var s = "detail",
        l = $("#products_detail_" + a);
    else var s = "quick",
        l = $(".attribute_quick_view"); {
        var o, c, n, d, p = new Array,
            u = l.find(".optPriceVal").val(),
            v = "",
            f = 0;
        l.find(".left_products_sec")
    }
    for (d = u.split(","), o = 0; o < d.length; o++) n = d[o].split("="), p['"' + n[0] + '"'] = n[1];
    var m = l.find(".recommmend_blog li");
    m.each(function() {
        var t = $(this).attr("type");
        if ("checkbox" == t && $(this).find("input").each(function() {
                $(this).is(":checked") && (v += $(this).val() + ",")
            }), ("radio" == t || "image" == t) && $(this).find("input").each(function() {
                $(this).is(":checked") && (v += $(this).val() + ",")
            }), "select" == t) {
            var i = $(this).find("select").val();
            "" != i && (v += i + ",")
        }
        "textarea" == t && $(this).find("textarea").val(), "text" == t && $(this).find("input[type=text]").val()
    });
    var h = v.split(","),
        b = 0;
    for (c = 0; c < h.length; c++) "" != h[c] && (f = getvalidPrice(p['"' + h[c] + '"']), b += f);
    var k = (getvalidPrice(l.find(".optPriceVal").attr("productPrice")), l.find(".optPriceVal").attr("pid")),
        _ = l.find(".optPriceVal").attr("pkgid");
    $.ajax({
        type: "POST",
        url: SITE_ROOT_URL + "common/ajax/ajax_stock.php",
        data: {
            action: "getStock",
            optIds: v,
            pid: k
        },
        success: function(t) {
            var i = jQuery.parseJSON(t),
                e = i.opt;
            $(".check_box").find("input:checkbox").next().css("border", "0px solid #6DB746"), $(".recommmend_blog").find(".newListSelected").css("border", "0px solid #CCCCCC"), $(".recommmend_blog").find("select").css("border", "");
            for (var r in e) {
                var o = e[r].fkAttributeId,
                    c = e[r].fkAttributeOptionId,
                    n = e[r].AttributeInputType;
                "image" == n ? $('input:radio[name="frmAttribute_' + o + "_" + a + '"]').is(":checked") ? $("#frmAttribute_" + c + "_" + a).css("border", "1px solid #C30008") : $("#frmAttribute_" + c + "_" + a).css("border", "1px solid #6DB746") : "radio" == n ? $('input:radio[name="frmAttribute_' + o + "_" + a + '"]').is(":checked") ? $("#frmAttribute_" + c + "_" + a).css("border", "1px solid #C30008") : $("#frmAttribute_" + c + "_" + a).css("border", "1px solid #6DB746") : "select" == n ? "" == $("#frmAttribute_" + o).val() ? ($("#frmAttribute_" + o + "_" + a).css("border", "1px solid #6DB746"), $("#frmAttribute_" + o + "_" + a).next().css("border", "1px solid #6DB746")) : ($("#frmAttribute_" + o + "_" + a).css("border", ""), $("#frmAttribute_" + o + "_" + a).next().css("border", "0px solid #6DB746")) : "checkbox" == n && ($(".check_box").find('input:checkbox[value="' + c + "_" + a + '"]').next().css("border", "1px solid #6DB746"), $(".check_box").find('input:checkbox[value="' + c + "_" + a + '"]').is(":checked") && $(".check_box").find('input:checkbox[value="' + c + "_" + a + '"]').next().css("border", "0px solid #6DB746")), console.log(o + "=" + c + "=" + n)
            }
            if (t = i.stock, l.find("#stock").html(t), "0" == t)
                if ("quick" == s);
                else {
                    var d = '<div class="right_bottom"> <a href="javascript:void(0);" class="out_of_stock_cart_link1">Out Of Stock</a></div>';
                    l.find(".qty_li_cls").html(d), $("#cart_link1").html("Out Of Stock"), $("#cart_link1").attr("class", "cart_link1 campare_link"), $("#cart_link1").attr("onclick", "return false;")
                } else if ("quick" == s);
            else {
                var d = '<label>Quantity</label><div class="quantity"></div><p> <span id="stock">' + t + "</span> In Stock</p>";
                l.find(".qty_li_cls").html(d), $("#cart_link1").html("Add to Cart"), $("#cart_link1").attr("class", "cart_link1"), $("#cart_link1").attr("onclick", "return addToPackage(" + _ + ");")
            }
        }
    })
}

function myPrice(t) {
    var i = $(".optPriceVal").attr("currencyCode"),
        e = t.toFixed(2),
        a = e.replace(/(\d)(?=(\d{3})+\.)/g, "$1,"),
        r = i + a;
    return r
}

function getvalidPrice(t) {
    var i = $(".optPriceVal").attr("currencyCode"),
        e = t.replace(i, ""),
        a = e.replace(",", ""),
        r = parseFloat(a),
        s = 0;
    return s = isNaN(r) ? 0 : r
}

function setCategoryViewAllLink(t, i) {
    document.getElementById(t).href = i
}
$(document).ready(function() {
    var t = 1;
    $('.aacheck_box .GetAttributeValues[type="radio"]').each(function() {
        $(this).click(function() {
            1 == this.checked ? $(this).parent().find(".formError").hide() : $(this).parent().find(".formError").show()
        })
    }), $(".aaaselect_color_sec textarea").each(function() {
        $(this).keyup(function() {
            "" != $(this).val() ? $(this).parent().find(".formError").hide() : $(this).parent().find(".formError").show()
        })
    }), $(".changePriceCheckBox").live("change", function() {
        calculateOptPrice()
    }), $(".changePriceSelect").on("change", function() {
        calculateOptPrice()
    }), $(".changePriceSelect").live("change", function() {
        calculateOptPrice()
    }), $(".drop_down1").sSelect(), $(".drop_down2").sSelect(), $(".cart_link1").live("click", function() {
        var i = $(this).attr("tp");
        if ("wholesaler" == i) {
            if (1 == $.trim(t)) {
                var e = $("*").hasClass("reviewErMessage") ? "1" : "2";
                2 == e && ($(this).after('<div id="userTypeError" class="reviewErMessage"><span style="color:red">Please login as customer to add this product into cart</span></div>'), t = 2)
            }
            return setTimeout(function() {
                $("#userTypeError").remove(), t = 1
            }, 8e3), !1
        }
        var a = $(this),
            r = [],
            s = [],
            l = [],
            o = 0,
            c = parseInt($("#frmQty").val()),
            n = parseInt(a.attr("pv")),
            d = parseInt(a.attr("pmv")),
            p = 0,
            u = a.parent().parent().parent().parent().find("li.MyAttr"),
            v = "";
        if (u.each(function() {
                var t = 0,
                    i = $(this).attr("type"),
                    e = $(this).attr("attrId");
                if ("checkbox" == i) $(this).find("input").each(function(i) {
                    $(this).is(":checked") && (s[i] = $(this).val(), v += $(this).val() + ",", t++)
                }), r[o] = e + ":" + s.join(",") + ":", o++;
                else if ("radio" == i || "image" == i) $(this).find("input").each(function() {
                    $(this).is(":checked") && (l = $(this).val(), v += $(this).val() + ",", t++)
                }), r[o] = e + ":" + l + ":", o++;
                else if ("select" == i) {
                    var a = $(this).find("select").val();
                    "" != a && (v += a + ",", t++), r[o] = e + ":" + a + ":", o++
                } else if ("textarea" == i) {
                    var c = $(this).find("textarea").val();
                    "" != c && t++, r[o] = e + "::" + c, o++
                } else if ("text" == i) {
                    var n = $(this).find("input[type=text]").val();
                    "" != n && t++, r[o] = e + "::" + n, o++
                }
                if (0 == t) {
                    p = 1;
                    var d = errorMessageHome();
                    return $(this).find(".errorBox").html(d), !1
                }
                $(this).find(".errorBox").html("")
            }), 1 == p) return !1;
        if (0 >= c || isNaN(c)) {
            var f = errorMessageHome();
            return a.parent().parent().parent().find(".errorQuantity").html(f), !1
        }
        if (c > d) return f = errorMessageHomeLowQuantity(d), a.parent().parent().parent().find(".errorQuantity").html(f), !1;
        if (a.parent().parent().parent().find(".errorQuantity").html(""), 0 >= n || isNaN(n)) return a.parent().parent().parent().find(".errorQuantity").html('<span style="color:red">Product is no longer available!<span>'), !1;
        var m = r.join("#");
        $(".succCart").html("Adding...."), $.post(SITE_ROOT_URL + "common/ajax/ajax_cart.php", {
            action: "addToProductCart",
            pid: n,
            qty: c,
            optIds: v,
            attrFormate: m
        }, function(t) {
            $(".succCart").show(), $(".succCart").html(t), addToAjaxCartValue(), addToAjaxCart(), addToAjaxCartHeader(), $(".scroll-pane").jScrollPane(), setTimeout(function() {
                $(".succCart").hide()
            }, 8e3)
        })
    })
}), $(document).ready(function() {
    $(".flipFront").bind("click", function() {
        var t = $(this);
        t.data("flipped") ? (t.revertFlip(), t.data("flipped", !1)) : (t.flip({
            direction: "tb",
            speed: 350,
            onBefore: function() {
                t.html(t.siblings(".flipBack").html())
            }
        }), t.data("flipped", !0))
    }), $(".proImg").hover(function() {
        return $(this).find(".miniBoxHover").fadeIn(200), !1
    }), $(".proImg").mouseleave(function() {
        return $(this).find(".miniBoxHover").fadeOut(200), !1
    }), $(".thumb_img").hover(function() {
        return $(this).find(".miniBoxHoverSpecial").fadeIn(200), !1
    }), $(".thumb_img").mouseleave(function() {
        return $(this).find(".miniBoxHoverSpecial").fadeOut(200), !1
    }), $(".tabBlock .clrTabCon").hide(), $(".tabBlock .clrTabCon:first").show(), $(".tabBlock ul.colorTab li:first").addClass("active"), $(".tabBlock ul.colorTab li a").click(function() {
        $(".tabBlock ul.colorTab li").removeClass("active"), $(this).parent().addClass("active");
        var t = $(this).attr("href");
        return $(".tabBlock .clrTabCon").hide(), $(t).show(), !1
    }), $(".tab2Block .clrTabCon").hide(), $(".tab2Block .clrTabCon:first").show(), $(".tab2Block ul.colorTab li:first").addClass("active"), $(".tab2Block ul.colorTab li a").click(function() {
        $(".tab2Block ul.colorTab li").removeClass("active"), $(this).parent().addClass("active");
        var t = $(this).attr("href");
        return $(".tab2Block .clrTabCon").hide(), $(t).show(), !1
    }), $(".tab3Block .clrTabCon").hide(), $(".tab3Block .clrTabCon:first").show(), $(".tab3Block ul.colorTab li:first").addClass("active"), $(".tab3Block ul.colorTab li a").click(function() {
        $(".tab3Block ul.colorTab li").removeClass("active"), $(this).parent().addClass("active");
        var t = $(this).attr("href");
        return $(".tab3Block .clrTabCon").hide(), $(t).show(), !1
    }), $(".tab4Block .clrTabCon").hide(), $(".tab4Block .clrTabCon:first").show(), $(".tab4Block ul.colorTab li:first").addClass("active"), $(".tab4Block ul.colorTab li a").click(function() {
        $(".tab4Block ul.colorTab li").removeClass("active"), $(this).parent().addClass("active");
        var t = $(this).attr("href");
        return $(".tab4Block .clrTabCon").hide(), $(t).show(), !1
    })
}), $(document).ready(function() {
    $(".jqzoom").jqzoom({
        zoomType: "standard",
        lens: !0,
        preloadImages: !1,
        alwaysOn: !1
    });
    var t = $(".slider");
    t.owlCarousel({
        navigation: !0,
        slideSpeed: 1000,
        paginationSpeed: 2000,
        singleItem: !0,
        autoPlay: 9000        
    })
}), $(document).ready(function() {
    var t = $(".owl-demo1");
    t.owlCarousel({
        items :3, //10 items above 1000px browser width
        itemsDesktop : [1000,3], //5 items between 1000px and 901px
        itemsDesktopSmall : [900,3], // 3 items betweem 900px and 601px
        itemsTablet: [767,1], //2 items between 600 and 0;
        itemsMobile : false // itemsMobile disabled - inherit from itemsTablet option
        
    }), $(".next").click(function() {
        t.trigger("owl.next")
    }), $(".prev").click(function() {
        t.trigger("owl.prev")
    });
    var i = $(".owl-demo2");
    i.owlCarousel({
        items :3, //10 items above 1000px browser width
        itemsDesktop : [1000,3], //5 items between 1000px and 901px
        itemsDesktopSmall : [900,3], // 3 items betweem 900px and 601px
        itemsTablet: [767,1], //2 items between 600 and 0;
        itemsMobile : false // itemsMobile disabled - inherit from itemsTablet option
    }), $(".next1").click(function() {
        i.trigger("owl.next")
    }), $(".prev1").click(function() {
        i.trigger("owl.prev")
    });
    var e = $(".owl-demo3");
    e.owlCarousel({
       items :4, //10 items above 1000px browser width
        itemsDesktop : [1000,3], //5 items between 1000px and 901px
        itemsDesktopSmall : [900,3], // 3 items betweem 900px and 601px
        itemsTablet: [767,1], //2 items between 600 and 0;
        itemsMobile : false // itemsMobile disabled - inherit from itemsTablet option
    }), $(".next2").click(function() {
        e.trigger("owl.next")
    }), $(".prev2").click(function() {
        e.trigger("owl.prev")
    });
    var a = $(".owl-demo4");
    a.owlCarousel({
      items :3, //10 items above 1000px browser width
        itemsDesktop : [1000,3], //5 items between 1000px and 901px
        itemsDesktopSmall : [900,3], // 3 items betweem 900px and 601px
        itemsTablet: [767,1], //2 items between 600 and 0;
        itemsMobile : false // itemsMobile disabled - inherit from itemsTablet option
    }), $(".next3").click(function() {
        a.trigger("owl.next")
    }), $(".prev3").click(function() {
        a.trigger("owl.prev")
    });
    var r = $(".owl-demo5");
    r.owlCarousel({
       items :4, //10 items above 1000px browser width
        itemsDesktop : [1000,4], //5 items between 1000px and 901px
        itemsDesktopSmall : [900,3], // 3 items betweem 900px and 601px
        itemsTablet: [767,1], //2 items between 600 and 0;
        itemsMobile : false // itemsMobile disabled - inherit from itemsTablet option
        
    }), $(".next4").click(function() {
        r.trigger("owl.next")
    }), $(".prev4").click(function() {
        r.trigger("owl.prev")
    });
    var s = $(".owl-demo6");
    s.owlCarousel({
        items :1, //10 items above 1000px browser width
        itemsDesktop : [1000,1], //5 items between 1000px and 901px
        itemsDesktopSmall : [900,3], // 3 items betweem 900px and 601px
        itemsTablet: [767,1], //2 items between 600 and 0;
        itemsMobile : false // itemsMobile disabled - inherit from itemsTablet option
    }), $(".next6").click(function() {
        s.trigger("owl.next")
    }), $(".prev6").click(function() {
        s.trigger("owl.prev")
    }), $("body").on("click", ".productPointer", function() {
        var t = $(this).prev().find("a").attr("href");
        window.location.href = t
    })
});