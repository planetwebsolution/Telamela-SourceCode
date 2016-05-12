$(document).ready(function(){ 
    var image_counter=1;
    $('#frmProductImg1').customFileInput1();
    $('#frmProductSliderImg1').customFileInput1();
    $('#frmProductDefaultImg1').customFileInput1();    
    $('.drop_down1').sSelect();
    $('#DateStart').datepick({
        dateFormat: 'dd-mm-yyyy', 
        showTrigger: '<img src="common/images/calendar.gif" alt="Popup" class="trigger">'
    });
    $('#DateEnd').datepick({
        dateFormat: 'dd-mm-yyyy', 
        showTrigger: '<img src="common/images/calendar.gif" alt="Popup" class="trigger">'
    });
    $('.delete_icon2').live('click',function(e){
        var row = $(this).parent().parent().attr('id');
        $(this).parent().remove();
        var hit = parseInt($('.jspContainer').css('height'))-82+'px';
        $('.jspContainer').css('height',hit);        
        addRemoveDeleteMoreImages(row);
        e.preventDefault();
    });
    $('.more_images').live('click',function(e){
        var row = $(this).attr('row');
        image_counter++;
        var file_input = '<div class="imgimg"><div class="responce"></div><input class="customfile1-input file file_upload_multi" id="frmProductImg1'+image_counter+'" type="file" name="frmProductImg[]" size="1"/><a href="#" class="delete_icon2" ></a></div>';
        $(this).parent().before(file_input);
        $('#frmProductImg1'+image_counter).customFileInput1();
        
        var hit = parseInt($('.jspContainer').css('height'))+82+'px';                                                               
        $('.jspContainer').css('height',hit);
        addRemoveDeleteMoreImages('addinput_'+row);
        e.preventDefault();
    });
                  
    $('.date1').datepick({
        dateFormat: 'dd-mm-yyyy'
    });
              
    $('input[numericOnly="yes"]').bind('keypress', function (event) {
        var regex = new RegExp("^[\!\@\#\$\%\^\&\*\(\)\'\"\;\:a-zA-Z]+$");
        var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
        if (regex.test(key)){
            event.preventDefault();
            return false;
        }
    });
    
    
    $('.imagetype').live('change', function() {        
        var objAttr = $(this);
        var OptId = objAttr.val();
        var rowNum = objAttr.parent().parent().attr('row');
        if(objAttr.is(':checked')){            
            objAttr.siblings('.res_attr').html('<div class="responce"></div><br/><br/><input type="text" name="frmOptCaption['+rowNum+']['+OptId+']" value="'+objAttr.attr('caption')+'" style="width:100px;"><input name="file_upload_attr['+OptId+']" id="'+OptId+'" class="file_upload_attr_multi" type="file" style="width:120px" size="1" />');
        //  $('#'+OptId).customFileInput1();
        }else{
            objAttr.siblings('.res_attr').html('');
        }
    });
    
    $('.otherstype').live('change', function() {       
        var objCaption = $(this);
        var OptId = objCaption.val();    
        var rowNum = objCaption.parent().parent().attr('row');
        if(objCaption.is(':checked')){            
            objCaption.siblings('.res_caption').html('<input type="text" name="frmOptCaption['+rowNum+']['+OptId+']" value="'+objCaption.attr('caption')+'" style="width:100px;">');
        }else{
            objCaption.siblings('.res_caption').html('');
        }
    });
    
              
});

function addRemoveDeleteMoreImages(row){
    var i=0;
    
    $("#"+row).find(".imgimg").each(function(){
        i++;
    });    
    
    if(i>1){   
        $("#"+row).find(".imgimg").first().find('.delete_icon2').show();        
    }else{        
        $("#"+row).find(".imgimg").first().find('.delete_icon2').hide();        
    }
}

function jCropPopupOpen(str){      
   
    $("."+str).colorbox({
        inline:true, 
        width:"850px", 
        height:"700px"
    });
   
    $('.ok').click(function(){
        parent.jQuery.fn.colorbox.close();
    });
}


function jscall33(arg1){
    $(".create_pkg_color_box").colorbox({
        inline:true, 
        width:"700px", 
        height:"700px"
    });
    $('#cancel'+arg1).click(function(){
        parent.jQuery.fn.colorbox.close();
    });
}   



var url = window.URL || window.webkitURL;
//var prod_img = document.getElementsByClassName("prod_img");
$(document).ready(function(){
    $('.filexxx').live('change',function(){
        var dd = $(this);
        
        var name = dd.attr('name');
        
        if( this.disabled ){
            alert(BROWS_NOT_SUPPORT);
        }else{
            var chosen = this.files[0];
            var image = new Image();
            var ImageSize = chosen.size;
            image.onload = function() {
                
                if (name.substr(0,20)=='frmProductDefaultImg' && (this.width < MIN_PRODUCT_IMAGE_WIDTH || this.height < MIN_PRODUCT_IMAGE_HEIGHT || this.width >MAX_PRODUCT_IMAGE_WIDTH || this.height > MAX_PRODUCT_IMAGE_HEIGHT || this.size > MAX_PRODUCT_IMAGE_SIZE)){
                    alert(UPLOAD_IMAGE_IN+'('+MIN_PRODUCT_IMAGE_WIDTH+'-'+MAX_PRODUCT_IMAGE_WIDTH+')'+PX_WIDTH_AND+'('+MIN_PRODUCT_IMAGE_HEIGHT+'-'+MAX_PRODUCT_IMAGE_HEIGHT+')'+PX_HEIGHT);                   
                    dd.parent().parent().children('.image_error').val('0');                   
                    this.focus();
                //$('#image_error').val(parseInt($('#image_error').val())+1);
                //return false;
                }else if (name.substr(0,13)=='frmProductImg' && (this.width < MIN_PRODUCT_IMAGE_WIDTH || this.height < MIN_PRODUCT_DETAIL_IMAGE_HEIGHT || this.width >MAX_PRODUCT_IMAGE_WIDTH || this.height > MAX_PRODUCT_IMAGE_HEIGHT || this.size > MAX_PRODUCT_IMAGE_SIZE)){
                    alert(UPLOAD_IMAGE_IN+'('+MIN_PRODUCT_IMAGE_WIDTH+'-'+MAX_PRODUCT_IMAGE_WIDTH+')'+PX_WIDTH_AND+'('+MIN_PRODUCT_DETAIL_IMAGE_HEIGHT+'-'+MAX_PRODUCT_IMAGE_HEIGHT+')'+PX_HEIGHT); 
                    dd.parent().parent().children('.image_error').val('0');                   
                    this.focus();
                //$('#image_error').val(parseInt($('#image_error').val())+1);
                //return false;
                }
                else
                {
                    dd.parent().parent().children('.image_error').val('1');                    
                }
               
            };
            image.onerror = function() {
                alert(VALID_FILE_TYPE+ chosen.type);
                dd.parent().parent().children('.image_error').val('0'); 
            };
            image.src = url.createObjectURL(chosen);                    
        }
                     
    });
});