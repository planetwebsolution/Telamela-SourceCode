var loaditem = '<div class="product_gradient"><div class="product_list"><div class="loader"><img src="'+SITE_ROOT_URL+'common/images/loader100.gif" title="Loading..." alt="Loading..." /></div></div></div>';
$(function(){
    $('.my_dropdown').sSelect();
    $('.attr_dropdown').sSelect();
    $('.scroll-pane').jScrollPane();
    $('.ajax_category').live('click',function(){    	
        var catid = $(this).attr("href");
        return false;
    });
});
function RemoveProductFromCart(id,val,index){
    $('#cart'+id).html('');


    $.post(SITE_ROOT_URL+'common/ajax/ajax_cart.php',{
        action:'RemoveProductFromCartOnBox',
        pid:id,
        index:index
    },function(data){
        $('#cartValue').html(parseInt($('#cartValue').text())-parseInt(val));
        //$('.addToCartMsg').html(data);
        $('#idAddToProductCart').html(data);
        $('.scroll-pane').jScrollPane();

    });
}
function RemovePackageFromCart(id,val,pkgIndex){
    $('#RemoveFromCartPkg'+id).html('');
    $.post(SITE_ROOT_URL+'common/ajax/ajax_cart.php',{
        action:'RemovePackageFromCartOnBox',
        pid:id,
        pkgIndex:pkgIndex
    },function(data){
        $('#cartValue').html(parseInt($('#cartValue').text())-parseInt(val));
        $('.addToCartMsg').html(data);
        $('#idAddToProductCart').html(data);
    });
}

function RemoveGiftCardFromCart(id,val)
{
    $('#RemoveGiftCard'+id).html('');
    $.post(SITE_ROOT_URL+'common/ajax/ajax_cart.php',{
        action:'RemoveGiftCardFromCartOnBox',
        pid:id
    },function(data){
    	var qunt = parseInt($('#cartValue').text())-parseInt(val);
    	if(isNaN(qunt))
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
    });
}

$(document).ready(function() {
    $(".topnav").accordion({
        accordion: false,
        speed: 500,
        closedSign: '[+]',
        openedSign: '[-]'
    });
    $(".category_list div").live('click',function() {
        //$(this).next('ul').toggle(400);
        $(this).next('ul').slideToggle('slow');
        $('img', this).attr('src', function(i, oldSrc) {
            return oldSrc == SITE_ROOT_URL+'common/images/arrright.png' ? SITE_ROOT_URL+'common/images/arrdown.png' : SITE_ROOT_URL+'common/images/arrright.png';
        });
    });

});

function getAttrFormate(){

    var arraymerg = [];
    var checkId = [];
    var radioId = [];
    var numcount = 0;
    var all_att_val = $('#all_att_val').val();
    if(all_att_val !="")
    {
        var attAry = all_att_val.split(';');
        j = 0;
        for(var i = 0 ; i < attAry.length ; ++i)
        {
            var attAry2 = attAry[i].split(':');
            //checkbox
			//10:checkbox;15:checkbox;21:checkbox;23:checkbox;24:checkbox;25:checkbox;26:checkbox;27:checkbox;28:checkbox;33:checkbox;5:checkbox;73:checkbox;88:checkbox;89:checkbox
            if(attAry2[1]=='checkbox')
            {
                var checkId=new Array();
                j=0;
                $('input:checkbox[name=frmAttribute_'+attAry2[0]+']').each(function()
                {
                    if($(this).is(':checked'))
                    {
                        checkId[j++] = $(this).val();
                    }
                });
                if(checkId.length>0)
                {
                    arraymerg[numcount] = attAry2[0]+':'+checkId.join(",");
                    numcount++;

                }

            }
            //Redio button

            if(attAry2[1]=='radio')
            {
                $('input:radio[name=frmAttribute_'+attAry2[0]+']').each(function()
                {
                    if($(this).is(':checked'))
                    {
                        radioId = $(this).val();
                    }
                });
                if(radioId!="")
                {
                    arraymerg[numcount] = attAry2[0]+':'+radioId;
                    numcount++;
                    radioId='';
                }
            }

            //select box
            if(attAry2[1]=='select')
            {

                var val1 = $('#frmAttribute_'+attAry2[0]+' :selected').val();
                if(val1!="")
                {
                    arraymerg[numcount] = attAry2[0]+':'+val1;
                    numcount++;
                    val1='';
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
function showMiddleContent(sortingId)
{
		var values = [];
        var wholeSalerid;
        $('.whl:checked').each(function(i){
            values[i] = $(this).val();
            wholeSalerid =values.join(",");
        });
        $('html,body').animate({
            scrollTop: $("#middle_section").offset().top
        },'slow');
        var AttribueFormate = getAttrFormate();
        var catid=$('#chooseCategoryId').val();
        var priceid=$('input:radio[name=frmProductPrice]:checked').val();
        var pagenum=$('#page').val();
        $('#middle_section').html();
        $('#middle_section').html(loaditem);

        $.post(SITE_ROOT_URL+'common/ajax/ajax_category.php',{
            action:'SelectProductCategory',
            pid:priceid,
            cid:catid,
            attr:AttribueFormate,
            type:getVal('#typ'),
            searchKey:getVal('#searchKey'),
            searchVal:getVal('#search'),
            frmPriceFrom:getVal('#frmPriceFrom'),
            frmPriceTo:getVal('#frmPriceTo'),
            wid:wholeSalerid,
            sortingId:sortingId,
            page:pagenum
        },function(data){
            $('#middle_section').html(data);
            $('.my_dropdown').sSelect();
            imageSliderZoomer();
        });
        //alert(SITE_ROOT_URL+'common/ajax/ajax_category.php?'+"action=SelectProductCategory&pid="+priceid+"&cid="+catid+"&attr="+AttribueFormate+"&type="+getVal('#typ')+"&searchKey="+getVal('#searchKey')+"&searchVal="+getVal('#search')+"&wholeSalerid="+wholeSalerid);
}
function showLeftContent()
{
		var values = [];
        var wholeSalerid;
        $('.whl:checked').each(function(i){
            values[i] = $(this).val();
            wholeSalerid =values.join(",");
        });
        var AttribueFormate = getAttrFormate();
        var catid=$('#chooseCategoryId').val();
        var priceid=$('input:radio[name=frmProductPrice]:checked').val();
        var pagenum=$('#page').val();

        $.post(SITE_ROOT_URL+'common/ajax/ajax_category.php',{
            action:'SelectLeftPanel',
            pid:priceid,
            cid:catid,
            attr:AttribueFormate,
            type:getVal('#typ'),
            searchKey:getVal('#searchKey'),
            searchVal:getVal('#search'),
            frmPriceFrom:getVal('#frmPriceFrom'),
            frmPriceTo:getVal('#frmPriceTo'),
            wid:wholeSalerid,
            page:pagenum
        },function(data){
            //$('#leftPanelId').css('display','block');
            $('#leftPanelId').html(data);
            $('.attr_dropdown').sSelect();
        });
		//alert(SITE_ROOT_URL+'common/ajax/ajax_category.php?'+"action=SelectLeftPanel&pid="+priceid+"&cid="+catid+"&attr="+AttribueFormate+"&type="+getVal('#typ')+"&searchKey="+getVal('#searchKey')+"&searchVal="+getVal('#search')+"&wholeSalerid="+wholeSalerid);		
}
function showContent()
{
	showLeftContent();
    showMiddleContent(""); 
}
$(function(){
    //category select
    $("#sidemenu a").click(function(event){
        event.preventDefault();
    });

    /***********/
    $('.ajax_category').live("click",function(){        
        var catid = $(this).attr("href");
        $('#chooseCategoryId').val(catid) ;
        $('#page').val(0) ;
        showContent();    
        return false;
    });
    $('.ajax_page').live("click",function(){        
        var page = $(this).attr("href");        
        $('#page').val(page) ;
        showContent();    
        return false;
    });
    /***********/
    $(".prc").live('change',function () {
    	$('#page').val(0) ;
    	showContent();
    });
    /**************/
    $(".whl").live('change',function () {
    	$('#page').val(0) ;
    	showContent();
    });
    /**********/
    $(".Attribute").live('change',function (){
    	$('#page').val(0) ;
    	showContent();
    });
});
function attr_select(){
    var values = [];
    var wholeSalerid;
    $('.whl:checked').each(function(i){
        values[i] = $(this).val();
        wholeSalerid =values.join(",");

    });

    var AttribueFormate = getAttrFormate();
    var catid=$('#chooseCategoryId').val();
    var priceid=$('input:radio[name=frmProductPrice]:checked').val();
    $.post(SITE_ROOT_URL+'common/ajax/ajax_category.php',{
        action:'SelectProductCategory',
        pid:priceid,
        cid:catid,
        attr:AttribueFormate,
        type:getVal('#typ'),
        wid:wholeSalerid
    },function(data){
        $('#middle_section').html(data);
        $('.my_dropdown').sSelect();
        imageSliderZoomer();
    });
}
$(function(){
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
$(function(){
    $('.search_btn').live('click',function(){
    	showContent();
    });
});
function RemoveProductFromCompare(id){
    $.post(SITE_ROOT_URL+'common/ajax/ajax_compare.php',{
        action:'RemoveProductFromCompare',
        pid:id
    },function(data){
        $('#ajaxAddToCompare').html(data);
        $('#addtoCompareCheckBox'+id).removeAttr("checked");
        $('#addtoCompareMessage'+id).html('&nbsp; '+REMOVE_SUCCESSFULLY);
        setTimeout(function(){
            $('#addtoCompareMessage'+id).html('&nbsp')
        },4000);
        goToByScroll('ajaxAddToCompare');
    });
}
function goToByScroll(id){
    // Remove "link" from the ID
    id = id.replace("link", "");
    // Scroll
    $('html,body').animate({
        scrollTop: $("#"+id).offset().top
    },
    'slow');
}
/*function scrollTo(hash) {
    alert(hash);
    window.location.hash = "#" + hash;
}*/
function addToCompare(id){
    //alert(id);
    $.post(SITE_ROOT_URL+'common/ajax/ajax_compare.php',{
        action:'addToCompare',
        pid:id
    },function(data){
        if(data=='5'){
            //$('#addtoCompareMessage'+id).html('&nbsp; '+ADD_COMPARE_MAX_ERROR);
            $('#addtoCompareCheckBox'+id).removeAttr( "checked");
            alert(ADD_COMPARE_MAX_ERROR);
            
        }else{
            $('#ajaxAddToCompare').html(data);
            $('#addtoCompareMessage'+id).html('&nbsp; '+ADD_SUCCESSFULLY);
            setTimeout(function(){
                $('#addtoCompareMessage'+id).html('&nbsp')
            },4000);
            goToByScroll('ajaxAddToCompare');
        }
    });
}
function addToCompareToggleId(id){

    if ($('#addtoCompareCheckBox'+id).attr("checked")) {
        addToCompare(id);
    }
    else
    {
        RemoveProductFromCompare(id);
    }
}
function sorting_product_up()
{
    var srtId=$('#sortingId').val();
    showMiddleContent(srtId); 
};
function sorting_product_down(){
    var srtId=$('#sortingId2').val();
    showMiddleContent(srtId);
};

function imageSliderZoomer(){

    $('.jqzoom').jqzoom({
        zoomType: 'standard',
        lens:true,
        preloadImages: false,
        alwaysOn:false
    });

    $('.product_img .jcarousel-clip ul').each(function(i){
        $(this).jcarousel();
    });
    
    $('.drop_down1').sSelect();
    $('.drop_down2').sSelect();
    
}

   
jQuery(document).ready(function(){
	jQuery("#search").live('click' , function(){
    jQuery("#search").autocomplete(SITE_ROOT_URL+"common/ajax/ajax_autocomplete.php?action=searchAutocomplete&catid="+$('#chooseCategoryId').val()+"&q="+jQuery("#search").val()+"&type="+jQuery("#typ").val()+"&searchKey="+jQuery("#searchKey").val(), {
        width: 140,
        matchContains: true,
        selectFirst: false
    });
	});
}); 
function getVal(fId){
    return $(fId).val();
}