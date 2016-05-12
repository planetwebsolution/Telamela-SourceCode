$(document).ready(function(){ 
    $('.drop_down1').sSelect();
    $('#Date').datepick({
        dateFormat: 'dd-mm-yyyy'
    });
    
    
    var page = 1;
    var onePage = 15;
    var totalPages = totalRows/onePage;
    paging();          
    
    
    
    function paging(){
        
        $('.holder a').live('click',function(){
            $('.holder').find('a').css('font-weight','normal');
            $(this).css('font-weight','bold');
            var page1 = $(this).html();
            if(!isNaN(page1)){
                page = parseInt(page1);
                var startResult = page*onePage-9;
                var endResult = page*onePage;
                if(totalRows>endResult){
                    endResult = endResult;
                }else{
                    endResult=totalRows;
                }
                $('#resultCount').html(startResult+'-'+endResult);
            }else{
                if(page1=='Next'){
                    if(page<totalPages){
                        page++;
                        var startResult = page*onePage-9;
                        var endResult = page*onePage;
                        if(totalRows>endResult){
                            endResult = endResult;
                        }else{
                            endResult=totalRows;
                        }
                        $('#resultCount').html(startResult+'-'+endResult);
                    }
                }else{
                    if(page>1){
                        page--;
                        var startResult = page*onePage-9;
                        var endResult = page*onePage;
                        $('#resultCount').html(startResult+'-'+endResult);
                    }
                }
            }
        });
        $("div.holder").jPages({
            containerID : "itemContainer",
            perPage : onePage,
            next:'Next',
            previous    : "Previous"
        }); 
        
    }
    
    /* $("select").change(function(){
                      var newPerPage = parseInt( $(this).val() );
                      $("div.holder").jPages("destroy").jPages({
                        containerID   : "itemContainer",
                        perPage       : newPerPage
                      });
                    });
                    */
                      
    $('#s_all').click(function(){
        $('#itemContainer li').each(function(){
            if($(this).hasClass('jp-hidden') || $(this).css('display')=='none'){
            //$(this).find('input[type="checkbox"]').attr('checked',false);
            }else{
                $(this).find('input[type="checkbox"]').attr('checked',true);
            }
        });
    });
                      
    $('#un_all').click(function(){
        $('#itemContainer li').each(function(){
            if($(this).hasClass('jp-hidden') || $(this).css('display')=='none'){
            //$(this).find('input[type="checkbox"]').attr('checked',false);
            }else{
                $(this).find('input[type="checkbox"]').attr('checked',false);
            }
        });
    });
                      
    $('#sort_by').change(function(){
        var order = $(this).val();        
        if(order!=0){
            $('input[type="text"]').each(function(){
                $(this).removeClass('validate[required]');
            });
            $.post(SITE_ROOT_URL+'common/ajax/ajax_wholesaler.php',
            {
                action:'ShowRecipientListForNewsletter',
                sort_by:order
            },
            function(data){ 
                $('#itemContainer').html(data);    
                paging();   
            });
            
        //$('#sort').val(1);
        //$('#place').val('create');
        //$('#createNewsletter').submit();
        }
    });
                      
    $('#template').change(function(){
        $('#HtmlEditor').removeClass();
      
        var frmProductImg = document.getElementsByName('template');
        if(frmProductImg.length>0){
            for(var k=0;k<frmProductImg.length;k++){    
                
                var ff = frmProductImg[k].value;
                if(ff!=''){
                    var exte = ff.substring(ff.lastIndexOf('.') + 1);
                    var ext = exte.toLowerCase();
                    if(ext!='jpg' && ext!='jpeg' && ext!='gif' && ext!='png'){
                        //alert('Accepted Image formats are: jpg, jpeg, gif, png');
                        $('.upload_error').show();                    
                    }
                    else
                    {
                        
                        $('.upload_error').hide();
                    }
                }
            
            }
        }
        
    });
});
var validationFlag = false;
function validateNews(){
                
    function goToByScroll(id){
        // Remove "link" from the ID
        id = id.replace("link", "");
        // Scroll
        $('html,body').animate({
            scrollTop: $("#"+id).offset().top
        },
        'slow');
    }
    goToByScroll('require');
    var temp=checkVal=newsTitle=newsContent=newsDate=1;
    var isSort = $('#sort').val();
    if(isSort==1){
        return true;
    }
        
    var cntnt = $('#cke_HtmlEditor iframe').contents().find('.cke_editable');
    
    if((cntnt.html() == '<br>'))
    {
        newsContent=0;
    }
    else
    {
        $('.formContent').css('display','none');           
    }
    
    var frmProductImg = document.getElementsByName('template');
    if(frmProductImg.length>0){
        for(var k=0;k<frmProductImg.length;k++){    
                
            var ff = frmProductImg[k].value;
            if(ff!=''){
                var exte = ff.substring(ff.lastIndexOf('.') + 1);
                var ext = exte.toLowerCase();
                if(ext!='jpg' && ext!='jpeg' && ext!='gif' && ext!='png'){
                    //alert('Accepted Image formats are: jpg, jpeg, gif, png');
                    temp=0;
                    
                }
                else
                {
                    newsContent=1;
                    $('.formContent').css('display','none');
                    $('.upload_error').css('display','none');
                }
            }
            
        }
    }

    
    $('input[type="checkbox"]').each(function(){
        if($(this).attr('checked')=='checked'){
            validationFlag = true;
        }
    });
    
    if(validationFlag==false){
        checkVal=0;      
    }
    else{
        $('.check_error').css('display','none');
    }
    
    if($('#Date').val() == '')
    {
        newsDate = 0;
    }
    else
    {
        $('.DateformError').css('display','none');            
    }
    
    if(temp==0) $('.upload_error').css('display','block');
    if(checkVal==0) $('.check_error').css('display','block');
    if(newsContent==0) $('.formContent').css('display','block');
    if(newsDate==0) $('.DateformError').css('display','block');
    if(temp==0 || checkVal==0|| newsTitle==0 || newsContent==0||newsDate==0)
    {
        return false;
    }
    
    
    
    
}