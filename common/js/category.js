var loaditem = '<div class="product_list"><div class="loader"><img src="' + SITE_ROOT_URL + 'common/images/loader100.gif" title="Loading..." alt="Loading..." /></div></div>';
//var pageLimit = 60;
var noMoreMsg = '<p>No more result found !</p>';
var processingMsg = '<img src="' + SITE_ROOT_URL + 'common/images/loader100.gif"/>';


$(function () {
    $('.my_dropdown').sSelect();
    $('.attr_dropdown').sSelect();
    $('.ajax_category').live('click', function () {
        var catid = $(this).attr("href");
        return false;
    });

});


$(document).ready(function () {
    $(".offPriceText").rotate(330);
    //$('.slider_inner').bxSlider({auto:true});
    //$('.drop_down1').sSelect();        
    $('.scroll-pane').jScrollPane();
    $('.cross_icon').click(function () {
        $(this).parent().html('<div class="blankCompare"><div class="compareLoader"><img src="' + SITE_ROOT_URL + 'common/images/loader1.gif"></div></div>');
    });

    $('.parent_search input').live("keyup", function () {
        // get the value from text field
        var input = $(this).val();
        var obs1 = $(this).parent().parent().next().find('ul');

        // check wheather the matching element exists
        // by default every list element will be shown                    
        obs1.find('li').show();
        // Non related element will be hidden after input
        $.expr[":"].contains = $.expr.createPseudo(function (arg) {
            return function (elem) {
                return $(elem).text().toUpperCase().indexOf(arg.toUpperCase()) >= 0;
            };
        });
        if ($.trim(input) != '')
            obs1.find("li label:not(:contains('" + input + "'))").parent().hide();
        $(this).parent().parent().next().jScrollPane();
    });

    lazyload();
});
function RemoveProductFromCart(id, val, index) {
    $('#cart' + id).html('');


    $.post(SITE_ROOT_URL + 'common/ajax/ajax_cart.php', {
        action: 'RemoveProductFromCartOnBox',
        pid: id,
        index: index
    }, function (data) {
        $('#cartValue').html(parseInt($('#cartValue').text()) - parseInt(val));
        //$('.addToCartMsg').html(data);
        $('#idAddToProductCart').html(data);
        $('.scroll-pane').jScrollPane();
        location.reload();
    });
}
function RemovePackageFromCart(id, val, pkgIndex) {
    $('#RemoveFromCartPkg' + id).html('');
    $.post(SITE_ROOT_URL + 'common/ajax/ajax_cart.php', {
        action: 'RemovePackageFromCartOnBox',
        pid: id,
        pkgIndex: pkgIndex
    }, function (data) {
        $('#cartValue').html(parseInt($('#cartValue').text()) - parseInt(val));
        $('.addToCartMsg').html(data);
        $('#idAddToProductCart').html(data);
        location.reload();
    });
}

function RemoveGiftCardFromCart(id, val)
{
    $('#RemoveGiftCard' + id).html('');
    $.post(SITE_ROOT_URL + 'common/ajax/ajax_cart.php', {
        action: 'RemoveGiftCardFromCartOnBox',
        pid: id
    }, function (data) {
        var qunt = parseInt($('#cartValue').text()) - parseInt(val);
        if (isNaN(qunt))
        {
            var qnt = 0;
        }
        else
        {
            var qnt = qunt;
        }
        $('#cartValue').html(qnt);
        $('.addToCartMsg').html(data);
        $('#idAddToProductCart').html(data);
        location.reload();
    });
}

$(document).ready(function () {
    $(".topnav").accordion({
        accordion: false,
        speed: 500,
        closedSign: '[+]',
        openedSign: '[-]'
    });
    $(".category_list div").live('click', function () {
        //$(this).next('ul').toggle(400);
        $(this).next('.toggle').slideToggle('slow');
        $('img', this).attr('src', function (i, oldSrc) {
            return oldSrc == SITE_ROOT_URL + 'common/images/arrright.png' ? SITE_ROOT_URL + 'common/images/arrdown.png' : SITE_ROOT_URL + 'common/images/arrright.png';
        });
    });

});

function getAttrFormate() {

    var arraymerg = [];
    var checkId = [];
    var radioId = [];
    var numcount = 0;
    var all_att_val = $('#all_att_val').val();
    if (all_att_val != "")
    {
        var attAry = all_att_val.split(';');
        j = 0;
        for (var i = 0; i < attAry.length; ++i)
        {
            var attAry2 = attAry[i].split(':');
            //checkbox
            //10:checkbox;15:checkbox;21:checkbox;23:checkbox;24:checkbox;25:checkbox;26:checkbox;27:checkbox;28:checkbox;33:checkbox;5:checkbox;73:checkbox;88:checkbox;89:checkbox
            if (attAry2[1] == 'checkbox')
            {
                var checkId = new Array();
                j = 0;
                $('input:checkbox[name=frmAttribute_' + attAry2[0] + ']').each(function ()
                {
                    if ($(this).is(':checked'))
                    {
                        checkId[j++] = $(this).val();
                    }
                });
                if (checkId.length > 0)
                {
                    arraymerg[numcount] = attAry2[0] + ':' + checkId.join(",");
                    numcount++;

                }

            }
            //Redio button

            if (attAry2[1] == 'radio')
            {
                $('input:radio[name=frmAttribute_' + attAry2[0] + ']').each(function ()
                {
                    if ($(this).is(':checked'))
                    {
                        radioId = $(this).val();
                    }
                });
                if (radioId != "")
                {
                    arraymerg[numcount] = attAry2[0] + ':' + radioId;
                    numcount++;
                    radioId = '';
                }
            }

            //select box
            if (attAry2[1] == 'select')
            {

                var val1 = $('#frmAttribute_' + attAry2[0] + ' :selected').val();
                if (val1 != "")
                {
                    arraymerg[numcount] = attAry2[0] + ':' + val1;
                    numcount++;
                    val1 = '';
                }
            }
        }

    }
    var AttrFormate = arraymerg.join('#');
    /*if(AttrFormate.charAt(AttrFormate.length-1) == ',')
     {
     AttrFormate = AttrFormate.substr(0, AttrFormate.length - 1);
     }*/
    //alert(AttrFormate);
    return AttrFormate;
}
function showMiddleContent(sortingId, e) {

    var values = [];
    var wholeSalerid;
    $('.whl:checked').each(function (i) {
        values[i] = $(this).val();
        wholeSalerid = values.join(",");
    });
    //    $('html,body').animate({
    //        scrollTop: $("#middle_section").offset().top
    //    },'slow');
    var AttribueFormate = getAttrFormate();
    var catid = $('#chooseCategoryId').val();
    var priceid = $('#prc').val();
    var pagenum = $('#page').val();
    $('#middle_section').html();
    $('#middle_section').html(loaditem);
    var disPDiv = $('#showCurrentDiv').val() == 'orenge' ? 'orenge' : 'grey';
    var frmPriceFrom = e == 'left' ? getVal('#frmPriceFrom') : 0;
    $.post(SITE_ROOT_URL + 'common/ajax/ajax_category.php', {
        action: 'SelectProductCategory',
        pid: priceid,
        cid: catid,
        attr: AttribueFormate,
        type: getVal('#typ'),
        searchKey: getVal('#searchKey'),
        searchVal: getVal('#search'),
        frmPriceFrom: frmPriceFrom,
        frmPriceTo: getVal('#frmPriceTo'),
        wid: wholeSalerid,
        sortingId: sortingId,
        page: pagenum,
        disPDiv: disPDiv
    }, function (data) {
        var result = data.split('###skm###');
        $('#parent_top').html(result['0']);
        $('#middle_section').html(result['1']);
        //$('#middle_section').html(data);        
        //$('.my_dropdown').sSelect();

        equalHeight($(".sec"));
        showInit();
        jQuery("img.lazy").lazy({
            delay: 2000
        });
        imageSliderZoomer();
    });
//alert(SITE_ROOT_URL+'common/ajax/ajax_category.php?'+"action=SelectProductCategory&pid="+priceid+"&cid="+catid+"&attr="+AttribueFormate+"&type="+getVal('#typ')+"&searchKey="+getVal('#searchKey')+"&searchVal="+getVal('#search')+"&wholeSalerid="+wholeSalerid);
}

function showLeftContent(e) { //alert(e);  
    var values = [];
    var wholeSalerid;
    $('.whl:checked').each(function (i) {
        values[i] = $(this).val();
        wholeSalerid = values.join(",");
    });

    var AttribueFormate = getAttrFormate();
    var catid = $('#chooseCategoryId').val();
    var priceid = $('#prc').val();
    var pagenum = $('#page').val();
    var searchPageKey = $('#searchPageKey').val();
    var frmPriceFrom = (e == 'left') ? getVal('#frmPriceFrom') : 0;
//   var frmPriceFrom = getVal('#frmPriceFrom');
    $('#leftPanelId').addClass('hide');
    $.post(SITE_ROOT_URL + 'common/ajax/ajax_category.php', {
        action: 'SelectLeftPanel',
        pid: priceid,
        cid: catid,
        attr: AttribueFormate,
        type: getVal('#typ'),
        searchKey: getVal('#searchKey'),
        searchVal: getVal('#search'),
        frmPriceFrom: frmPriceFrom,
        frmPriceTo: getVal('#frmPriceTo'),
        defaultfromPrice: getVal('#defaultfromPrice'),
        defaultToPrice: getVal('#defaultToPrice'),
        wid: wholeSalerid,
        page: pagenum,
        searchPageKey: searchPageKey
    }, function (data) {
        //$('#leftPanelId').css('display','block');
        $('#leftPanelId').html(data);
        $('.scroll-pane').jScrollPane();
        $('#leftPanelId').removeClass('hide');

        //$('.attr_dropdown').sSelect();
        //$('.dropdown1').sSelect();
    });
//alert(SITE_ROOT_URL+'common/ajax/ajax_category.php?'+"action=SelectLeftPanel&pid="+priceid+"&cid="+catid+"&attr="+AttribueFormate+"&type="+getVal('#typ')+"&searchKey="+getVal('#searchKey')+"&searchVal="+getVal('#search')+"&wholeSalerid="+wholeSalerid);		
}
function showContent(e) {
    //if (e == 'left') {
        showLeftContent(e);
    //}
    showMiddleContent("", e);

}

function prc(ctr) {

    if (ctr == '0') {
        //putval($('#prc').val());
    }
    $('#page').val(0);
    showContent('left');
}

function putval(val) {
    var res = val.split("-");
    var fromPrc = res[0];
    var toPrc = res[1];
    $('#frmPriceFrom').val(fromPrc);
    $('#frmPriceTo').val(toPrc);

}


$(function () {
    //category select
    $("#sidemenu a").click(function (event) {
        event.preventDefault();
    });

    /***********/
    $('.ajax_category').live("click", function () {
        var catid = $(this).attr("href");
        $('#chooseCategoryId').val(catid);
        $('#page').val(0);
        showContent();
        return false;
    });

    $('.ajax_page').live("click", function () {
        var page = $(this).attr("href");
        $('#page').val(page);
        showContent();
        return false;
    });
    /***********/
    /*
     $(".prc").live('change',function () {
     $('#page').val(0);        
     showContent();
     });
     */
    /**************/
    $(".whl").live('change', function () {
        $('#page').val(0);
        showContent();
    });
    /**********/
    $(".Attribute").live('change', function () {
        $('#page').val(0);
        showContent();
    });
});
function attr_select() {
    var values = [];
    var wholeSalerid;
    $('.whl:checked').each(function (i) {
        values[i] = $(this).val();
        wholeSalerid = values.join(",");

    });

    var AttribueFormate = getAttrFormate();
    var catid = $('#chooseCategoryId').val();
    var priceid = $('#prc').val();
    $.post(SITE_ROOT_URL + 'common/ajax/ajax_category.php', {
        action: 'SelectProductCategory',
        pid: priceid,
        cid: catid,
        attr: AttribueFormate,
        type: getVal('#typ'),
        wid: wholeSalerid
    }, function (data) {
        var result = data.split('###skm###');
        $('#parent_top').html(result['0']);
        $('#middle_section').html(result['1']);

        //$('.my_dropdown').sSelect();
        showInit();
        imageSliderZoomer();
    });
}
$(function () {
    /*$(".paging a").live('click',function(event){
     event.preventDefault();
     });
     $('.paging a').live('click',function(){
     var pagenum = $(this).attr('href');
     var arrUrl=pagenum.split('&');
     var pageNum = arrUrl[arrUrl.length-1].split('=');
     var pagenum = pageNum[1];
     var values = [];
     var wholeSalerid;
     $('.whl:checked').each(function(i){
     values[i] = $(this).val();
     wholeSalerid =values.join(",");
     
     });
     var catid=$('#chooseCategoryId').val();
     var priceid=$('input:radio[name=frmProductPrice]:checked').val();
     $('#middle_section').html(loaditem);
     $.post(SITE_ROOT_URL+'common/ajax/ajax_category.php',{
     action:'SelectProductCategory',
     wid:wholeSalerid,
     pid:priceid,
     cid:catid,
     type:getVal('#typ'),
     page:pagenum
     },function(data){
     $('#middle_section').html(data);
     $('.my_dropdown').sSelect();
     imageSliderZoomer();
     });
     });*/
});
$(function () {
    $('.search_btn').live('click', function () {
        showContent();
    });
});
function RemoveProductFromCompare(id) { //alert('test');return false;
    countCompare = 0;
    $.post(SITE_ROOT_URL + 'common/ajax/ajax_compare.php', {
        action: 'RemoveProductFromCompare',
        pid: id
    }, function (data) {
        $('#ajaxAddToCompare').html(data);
        var gtClass = $('*').hasClass('myCompareUl') ? '1' : '2';
        if (gtClass == '1') {  //return false;
            $.post(SITE_ROOT_URL + 'common/ajax/ajax_compare.php', {
                action: 'RemoveProductFromCompareCategory',
                pid: id,
            }, function (data) { //alert(data);return false;
                var dSplit = data.split("+++");
                countCompare = dSplit[0];
                if (dSplit[0] < 2) {
                    $('.compareButton').find('a').addClass('not-active');
                    var checkReduceQ = dSplit[0] > 0 ? 'Compare ' + '(' + dSplit[0] + ')' : 'Compare';
                    dSplit[0] == 0 ? $('.newCompareBox').hide() : $('.newCompareBox').show();
                    $('.compareButton').find('a').html(checkReduceQ);
                } else {
                    $('.compareButton').find('a').html('Compare ' + '(' + dSplit[0] + ')');
                }

                $('.myCompareUl').html(dSplit[1]);
            })
        }
        $('#addtoCompareCheckBox' + id).removeAttr("checked");
        $('#addtoCompareMessage' + id).html('&nbsp; ' + REMOVE_SUCCESSFULLY);
        //alert(countCompare);
        //ajaxAddToCompare
        setTimeout(function () {
            $('#addtoCompareMessage' + id).html('&nbsp')
        }, 4000);
        goToByScroll('ajaxAddToCompare');
    });
}
function goToByScroll(id) {
    // Remove "link" from the ID
    id = id.replace("link", "");
    // Scroll
    $('html,body').animate({
        scrollTop: $("#" + id).offset().top
    },
    'slow');
}
/*function scrollTo(hash) {
 alert(hash);
 window.location.hash = "#" + hash;
 }*/
function addToCompare(id) {
    //alert(id);
    $.post(SITE_ROOT_URL + 'common/ajax/ajax_compare.php', {
        action: 'addToCompare',
        pid: id
    }, function (data) {
        if (data == '4') {
            //$('#addtoCompareMessage'+id).html('&nbsp; '+ADD_COMPARE_MAX_ERROR);
            $('#addtoCompareCheckBox' + id).removeAttr("checked");
            alert(ADD_COMPARE_MAX_ERROR);

        } else {
            $('#ajaxAddToCompare').html(data);
            $('#addtoCompareMessage' + id).html('&nbsp; ' + ADD_SUCCESSFULLY);
            setTimeout(function () {
                $('#addtoCompareMessage' + id).html('&nbsp')
            }, 4000);
            goToByScroll('ajaxAddToCompare');
        }
    });
}
function addToCompareToggleId(id) {

    if ($('#addtoCompareCheckBox' + id).attr("checked")) {
        addToCompare(id);
    }
    else
    {
        RemoveProductFromCompare(id);
    }
}
function sorting_product_up()
{
    var srtId = $('#sortingId').val();
    showMiddleContent(srtId);
}
;
function sorting_product_down() {
    var srtId = $('#sortingId2').val();
    showMiddleContent(srtId);
}
;

function imageSliderZoomer() {

    $('.jqzoom').jqzoom({
        zoomType: 'standard',
        lens: true,
        preloadImages: false,
        alwaysOn: false
    });

    $('.product_img .jcarousel-clip ul').each(function (i) {
        $(this).jcarousel();
    });

    setTimeout(function () {
        $('.drop_down1').sSelect();
    }, 1000);

    $('.drop_down2').sSelect();

}


jQuery(document).ready(function () {
    jQuery("#search").live('click', function () {
        jQuery("#search").autocomplete(SITE_ROOT_URL + "common/ajax/ajax_autocomplete.php?action=searchAutocomplete&catid=" + $('#chooseCategoryId').val() + "&q=" + jQuery("#search").val() + "&type=" + jQuery("#typ").val() + "&searchKey=" + jQuery("#searchKey").val(), {
            width: 140,
            matchContains: true,
            selectFirst: false
        });
    });
});
function getVal(fId) {
    return $(fId).val();
}

var getSearchedBy = function (x) {
    return $('#parent_top > li >strong').html();
}

function lazyload() {

    $('#middle_section').scroll(function () {
        //check if your div is visible to user
        // CODE ONLY CHECKS VISIBILITY FROM TOP OF THE PAGE

        if ($(window).scrollTop() + $(window).height() >= $('#marker-end').offset().top) {

            if (!$('#marker-end').attr('processing')) {

                $('#marker-end').attr('processing', true);
                if (!$('#marker-end').attr('loaded')) {
                    //not in ajax.success due to multiple sroll events
                    $('#marker-end').attr('loaded', true);

                    var cid = $('#cid').val();
                    var sortby = $('#sortby').val();
                    var dataEnd = $('#marker-end').attr('data-end');

                    if (dataEnd == '0') {
                        var limit = $('#marker-end').attr('limit');

                        var nextlimit = parseInt(limit) + pageLimit;

                        $('#marker-end').attr('limit', nextlimit);


                        var values = [];
                        var wholeSalerid;
                        $('.whl:checked').each(function (i) {
                            values[i] = $(this).val();
                            wholeSalerid = values.join(",");
                        });
                        var AttribueFormate = getAttrFormate();
                        var catid = $('#chooseCategoryId').val();
                        var priceid = $('#prc').val();
                        var pagenum = $('#page').val();
                        var showCurrentDiv = $('#showCurrentDiv').val();

                        $.post(SITE_ROOT_URL + 'common/ajax/ajax_category.php', {
                            action: 'productLazyLoading',
                            pid: priceid,
                            cid: catid,
                            attr: AttribueFormate,
                            type: getVal('#typ'),
                            searchKey: getSearchedBy('#searchKey'),
                            searchVal: getVal('#search'),
                            frmPriceFrom: getVal('#frmPriceFrom'),
                            frmPriceTo: getVal('#frmPriceTo'),
                            wid: wholeSalerid,
                            //sortingId:sortingId,
                            page: pagenum,
                            limit: limit,
                            showCurrentDiv: showCurrentDiv
                        }, function (data) {
                            //alert(data);
                            // add new elements

                            var num = $(data).filter('div').size();
                            //alert(num);
                            //alert(pageLimit);
                            if (num < pageLimit) {
                                $('#marker-end').html(noMoreMsg);
                                $('#marker-end').attr('data-end', '1');
                            } else {
                                $('#marker-end').attr('loaded', null);
                            }

                            $('#middle_section .datail_block').append(data);

                            $('#marker-end').attr('processing', null);
                            var totalLi = $('#middle_section .datail_block div').length;
                            equalHeight($(".sec"));
                            showInitLazy(totalLi, num);

                        });
                    } else {
                        $('#marker-end').html(noMoreMsg);
                    }
                }
            }
        }
    });
}

function equalHeight(group) {
    var tallest = 0;
    group.each(function () {
        var thisHeight = $(this).height();
        if (thisHeight > tallest) {
            tallest = thisHeight;
        }
    });
    //alert(tallest);
    $(".sec").height(tallest);
}

function showInitLazy(totalLi, num) {
    $(".offPriceText").rotate(330);
    $('.scroll-pane').jScrollPane();

    for (var i = totalLi - num + 1; i <= totalLi; i++) {
        $('#middle_section .datail_block li:nth-child(' + i + ') .thumb_img').hover(function () {
            $(this).find(".miniBoxHoverSpecial").fadeIn(200);
            //return false
        });

        $('#middle_section .datail_block li:nth-child(' + i + ') .thumb_img').mouseleave(function () {
            $(this).find(".miniBoxHoverSpecial").fadeOut(200);
            //return false
        });
    }
}
function showInit() {

    $('.scroll-pane').jScrollPane();
    $(".offPriceText").rotate(330);
    $('.thumb_img').hover(function () {
        $(this).find(".miniBoxHoverSpecial").fadeIn(200);
        //return false
    });

    $('.thumb_img').mouseleave(function () {
        $(this).find(".miniBoxHoverSpecial").fadeOut(200);
        //return false
    });

}

$(document).ready(function () {
    $('body').on('click', '.orenge', function (event) {
        event.preventDefault();
        $(this).css('background', '#ffb11b');
        $(this).css('color', '#fff');
        $('.parent_child_mid').width('780');
        $('.grey').css('background', '#e9e9e9');
        $('.grey').css('color', '#838383');
        $('.category_orenge').fadeIn('1000');
        $('.category_orenge_ajax').fadeIn();
        $('.category_grey').fadeOut();
        $('.category_grey_ajax').fadeOut();
        $('#showCurrentDiv').val('orenge');
        $('.orengeActive').hide();
        $('.parent_right_panel').show();
        $('.category_mid').jScrollPane();
        $('.jspContainer').width('auto');
    });
    $('body').on('click', '.grey', function (event) {
        event.preventDefault();
        $(this).css('background', '#ffb11b');
        $(this).css('color', '#fff');
        $('.orengeActive').show();
        $('.parent_right_panel').hide();
        $('.parent_child_mid').width('830');
        $('.orenge').css('background', '#e9e9e9');
        $('.orenge').css('color', '#838383');
        $('.category_grey').fadeIn('1000');
        $('.category_grey_ajax').fadeIn();
        $('.category_orenge').fadeOut();
        $('.category_orenge_ajax').fadeOut();
        $('#showCurrentDiv').val('grey');
        $('.category_mid').jScrollPane();
    });
    $('body').on('click', '.clear_search', function (event) {
        event.preventDefault();
        location.reload();
    });
    $('body').on('click', '#ajex_all_category', function (event) {
        event.preventDefault();
        location.reload();
    });
    $('body').on('click', '.clear_search', function (event) {
        event.preventDefault();
        location.reload();
    });
    $('body').delegate('.active_lisitng', 'click', function (event) {
        location.reload();
    });

    $('body').on('click', '.ajax_category', function (event) {
        $(this).parent().parent().prev().removeClass('active_lisitng');
        $(this).parent().parent().find('li').find('a').find('label').removeClass('active_achor_category');

        $('.mainCatText').find('label').removeClass('active_achor_category');
        $(this).find('label').addClass('active_achor_category');

    });










});