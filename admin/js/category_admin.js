$(document).ready(function(){
    $(document).on("click",".saveorder",function(){
   // $('.saveorder').click(function(){
        $("#frmCategoryList").submit();
    });         
});

function changeStatus(status,catid){
    var showid = '#cat'+catid;
    $.post("ajax.php",{
        action:'ChangeCategoryStatus',
        status:status,
        catid:catid
    },
    function(data)
    {
        $(showid).html(data);
    });
}

jQuery = jQuery.noConflict();
jQuery().ready(function() {
    jQuery("#autoFilledCategory").autocomplete("ajax.php?action=categoryAutocomplete&q="+jQuery("#autoFilledCategory").val, {
        width: 260,
        matchContains: true,
        selectFirst: false
    });
    
    jQuery('.parentCat').live("click",function(){
        
        var pcid = $(this).attr('href');
        var level = $(this).attr('level');
        
        $('#pcat').val(pcid);
        $('#pcat').attr('level',level);
        
        $(this).parent().parent().find('a').removeClass("clicked");
        $(this).addClass('clicked');        
        getChildCat();
        getChildCatDetails();
        getparentCatName();
        return false;
    });
    
    
    jQuery('.paginate_button').live("click",function(){
        /*alert($('#isTrashed').val());
        console.log($('#isTrashed').val());
        return false;*/
        if($('#isTrashed').val()=='no'){
            var page = $(this).attr('href');
            if(page!=undefined){
                getChildCatDetails(page);
            }
            return false;
        }
    });
    getparentCatName();
});

function getChildCat(){
    var pcid = $('#pcat').val();
    var level = $('#pcat').attr('level');    
    if(level=='0'){
        $('#parentCat').html('<li><img src="images/ajax_loader.gif" /></li>');                    
        $.get("",{
            action:'getChildCat',
            pcid:pcid
        },function(data){
            $('#parentCat').html(data);                   
        });
    } 
}

function order_validation(e,t){ //alert(e+'xcxv'+t);
    return isNaN(e)?(alert("Please enter numeric value for order!"),$("#"+t).val("0"),$("#"+t).focus(),!1):e<0?(alert("Please enter value greater than 1!"),$("#"+t).val("0"),$("#"+t).focus(),!1):void 0
}

function getChildCatDetails(page){
    $('#frmCategoryList').html('<table class="table table-hover table-nomargin table-bordered usertable"><tr class="content"><td colspan="10" style="text-align:center"><img src="images/ajax_loader.gif" /></td></tr></table>');
    var pcid = $('#pcat').val();
    var level = $('#pcat').attr('level');
    $.get("",{
        action:'getChildCatDetails',
        pcid:pcid,
        level:level,
        page:page
    },function(data){
        $('#frmCategoryList').html(data);
    //$(".select2-me").select2();
    });
}

function getSubChildCat(pcid,level){
    $('#pcat').val(pcid);
    $('#pcat').attr('level',level);
    getChildCat();
    getChildCatDetails();
}

function getparentCatName(){
    var nm = $('.clicked').last().html();    
    
    if(nm==undefined){
    //$('#catName').html('(Parent)');
    }else{
        $('#catName').html('('+nm+')');
    }
}

function addNew(){
    var pid,nm = $('.clicked').last().attr('href');
    
    if(nm==undefined){
        pid='0';
    }else{
        pid=nm;
    }
    window.location='category_add_uil.php?type=add&pcid='+pid;
}