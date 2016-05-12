$(document).ready(function(){
    
    //image store from temp dir to product folder
    
    $('#cropAfterCrop').live('click',function(){
       var obj =$(this);  
       var getImageSrc =obj.parent().find('.croppedImg').attr('src');
       var getImageName =getImageSrc.toString().replace('common/uploaded_files/images/temp/','');
       getImageName=$.trim(getImageName);
       var getCount=obj.attr('cls'); 
       getCount=getCount.match(/\d/g);
       getCount = getCount.join("");
       $.post(SITE_ROOT_URL+"common/ajax/ajax_uploader.php",{
            action:'saveImageAfterCrop',
            imageSrc:getImageSrc,
            imageName:getImageName
        },
        function(data)
        {
         $('#cropimg_'+getCount).hide();
         $('#after_cropimg_'+getCount).val(getImageName);
         $('#after_cropimg_default_'+getCount).val(getImageName);
         if(getCount==1){
         $('#after_cropimg_default_'+getCount).prop('checked','checked');    
         }
         if($('#after_cropimg_default_'+getCount).parent().next().next().hasClass('myImgSpan')==false){
         $('#after_cropimg_default_'+getCount).parent().next().after('<span class="myImgSpan" style="margin-left: 15px;"><img src="'+data+'"/></span>');
         }else{
             $('#after_cropimg_default_'+getCount).parent().next().next().html('<img src="'+data+'"/>');
         }
         parent.jQuery.fn.colorbox.close();
            
        });
       //alert(getImageSrc);return false;
    });
    
    $('#fkShippingID').change(function(){        
        if($('#fkShippingID').val()=='0' || $('#fkShippingID').val()==''){
            $('.ErrorfkShippingID').css('display','block');
            var error = errorMessage(); 
            
            $('.ErrorfkShippingID').html(error);
        }else{
            $('.ErrorfkShippingID').css('display','none');
        }
                    
    });
    
    
    $('#product1').find('select').sSelect(); 
    $('#product2').find('select').sSelect();
    
                
    $('#frmConfirmDelete').click(function(){
        var frmPackageName = document.getElementById('frmPackageName');                    
        var frmCategoryId = document.getElementsByName('frmCategoryId[]');
        var frmProductId = document.getElementsByName('frmProductId[]');
        var frmOfferPrice = document.getElementById('frmOfferPrice');
        $('#frmTotalPrice').val($('#asc').text());
        var frmTotalPrice = document.getElementById('frmTotalPrice');
               
        //alert(frmCategoryId.length);
    
        if(frmPackageName.value==''){
            alert(PACKAGE_R);
            frmPackageName.focus();
            return false;
        }  
                    
        for (var i = 0; i < frmCategoryId.length; i++) {
                       
            if(frmCategoryId[i].value==0){
                alert(SEL_CATEGORY);
                frmCategoryId[i].focus();
                return false;
            }else if(frmProductId[i].value==0){
                alert(SEL_PRODUCT);
                frmProductId[i].focus();
                return false;
            }   
        } 
        if(frmOfferPrice.value==''){
            alert(OFFER_PRICE);
            frmOfferPrice.focus();
            return false;
        }else if(AcceptDecimal(frmOfferPrice.value)==false){
            alert(ENTER_NUMRIC);
            frmOfferPrice.focus();
            return false;        
        }else if(IsLessThan(frmTotalPrice.value,frmOfferPrice.value)==false){
            alert("Offer Price should be less than Total Price !");
            frmOfferPrice.focus();
            return false;
        }                  
                       
        var proids = '';                       
        for (var i = 0; i < frmProductId.length; i++) {
            proids = proids+'-vss-'+frmProductId[i].value;                           
        }
        var whid = document.getElementById('frmWholesalerId');
        $('#PkgAdded').html('Package Added Successfuly !');            
        $.post("admin/ajax.php",{
            ajax_request:'valid',
            action:'AddPackage',
            pkgnm:frmPackageName.value,
            whid:whid.value,
            pids:proids,
            offerprice:frmOfferPrice.value
        },
        function(data)
        { 
            var res = data.split('skm#skm');
            $('#packages').html(res[1]);            
            $('#packages').find('select').sSelect();
            parent.jQuery.fn.colorbox.close();
            
        });
        
                    
                        
    }); 
    
    //attrbutes images

    $('.imagetype').live('change', function() {    
        var objAttr = $(this);
        var OptId = objAttr.val();        
        if(objAttr.is(':checked')){ 
            //var element='<a href="#cropimg_1" onclick="jCroppicPopupOpen('cropimg',1)" class="cropimg" style="z-index:9999999">Upload Image</a><input type="hidden" name="frmProductImg[]" id="after_cropimg_1" value=""/>';
            var element='<a href=\"#cropimg_'+OptId+'\" onclick="jCroppicPopupOpen(\'cropimg\',\''+OptId+'\')" class="cropimg" style="z-index:9999999">Upload Image</a><div id="cropimg_'+OptId+'" style="display:none"></div><input type="hidden" name="frmOptCaption['+OptId+']" value="'+objAttr.attr('caption')+'"><input type="hidden" name="frmAttrImg['+OptId+']" id="after_cropimg_'+OptId+'" value=""></div><span id="after_cropimg_default_'+OptId+'"></span>';
            //objAttr.siblings('.res_attr').html('<div class="responce"></div><input type="text" name="frmOptCaption['+OptId+']" value="'+objAttr.attr('caption')+'" style="width:100px;margin-bottom:5px;"><input name="file_upload_attr['+OptId+']" class="customfile1-input file file_upload_attr" id="fileAttr'+OptId+'" type="file" />');
            //$('#fileAttr'+OptId).customFileInput1();	
        //e.preventDefault();            
        objAttr.siblings('.res_attr').html(element);
        objAttr.siblings('.res_attr').after('<div></div>');
        }else{
            objAttr.siblings('.res_attr').html('');
            objAttr.siblings('.res_attr').next().remove();
        }
    });
    
    $('.otherstype').live('change', function() {       
        var objCaption = $(this);
        var OptId = objCaption.val();        
        if(objCaption.is(':checked')){            
            objCaption.siblings('.res_caption').html('<input type="text" name="frmOptCaption['+OptId+']" value="'+objCaption.attr('caption')+'" style="width:100px;">');
        }else{
            objCaption.siblings('.res_caption').html('');
        }
    });
                
});
            
function ShowProductForPackage(str,id){    
    $('#price'+id).html('<input type="hidden" name="frmPrice[]" value="0.00" /><b>0.00</b>');
    var frmPrice = document.getElementsByName('frmPrice[]');
    var whid = document.getElementById('frmWholesalerId').value;
    var total=0,i,p,a=0;
    //alert(frmPrice[0].value);
    //                /alert(whid);
    for(i=0; i<frmPrice.length;i++)
    {
        p = parseFloat(frmPrice[i].value);
        total = total+p;
    }
    total = total.toFixed(2);
    $('#asc').html(total);
    if(str==0){
        $('#product'+id).html('<div class="drop4 dropdown_2" id ="product'+id+'"><select name="frmProductId[]" style="width:170px;"><option>'+PRODUCT+'</option></select></div>');
        $('#product'+id).find('select').sSelect();
    }else{
        $.post("admin/ajax.php",{
            action:'ShowProductForPackage',
            ajax_request:'valid',
            catid:str,
            showid:id,
            whid:whid
        },
        function(data)
        {
            $('#product'+id).html('<div class="drop4 dropdown_2" id ="product'+id+'">'+data+'</div>');
            $('#product'+id).find('select').sSelect();
        }
        );
    }
} 
            
function ShowProductPriceForPackage(str,id){
    if(str==0){
        $('#price'+id).html('<input type="hidden" name="frmPrice[]" class="input1" value="0.00" /><b>0.00</b>');
        var frmPrice = document.getElementsByName('frmPrice[]');
        var total=0,i,p,a=0;
        //alert(frmPrice[0].value);
        for(i=0; i<frmPrice.length;i++)
        {
            p = parseFloat(frmPrice[i].value);
            total = total+p;
        }
        total = total.toFixed(2);
        $('#asc').html(total);
    }else{
        $.post("admin/ajax.php",{
            action:'ShowProductPriceForPackage',
            ajax_request:'valid',
            pid:str,
            showid:id
        },
        function(data)
        {
            $('#price'+id).html(data);
            var frmPrice = document.getElementsByName('frmPrice[]');
            var total=0,i,p,a=0;
            //alert(frmPrice[0].value);
            for(i=0; i<frmPrice.length;i++)
            {
                p = parseFloat(frmPrice[i].value);
                total = total+p;
            }
            total = total.toFixed(4);
            $('#asc').html(total);
        }
        );
    }
} 
var ctr=2;                
function addDynamicRowToTableForPackage(TableID)
{
    var tbl = document.getElementById(TableID);
    
    var lastRow = tbl.rows.length;
    ctr++;
    // if there's no header row in the table, then iteration = lastRow + 1
    var count_R;
    count_R=ctr;
    count_R=parseInt(count_R);
    //document.getElementById(TableID).setAttribute("class", 'content');
    $('#'+TableID+' tr:last i').html('');
    //cellRight4.innerHTML='<a href="#" onclick="removeRowFromTableForPackage(\''+TableID+'\',\''+count_R+'\',this);return false;"><img src="images/minus.png" /></a>';
    var row = tbl.insertRow(lastRow);
    // left cell
    var valRegExp=/value=/g;
    row.insertCell(0).innerHTML='Product&nbsp;'+count_R+':';
    var cellRight1 = row.insertCell(1);
    $.post("admin/ajax.php",{
        action:'ShowCategoryForPackageFront',
        ajax_request:'valid',
        row:count_R
    },
    function(data){
        var asc = data;        
        cellRight1.innerHTML = '<div class="input_star"><div class="drop4 dropdown_2" id ="catid'+count_R+'">'+asc+'</div><small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small></div>';
        //$('#catid'+count_R).find('select').sSelect();
        $('#catid'+count_R).find('select').select2();
    //$(".select2-me").select2();
        
    });
    row.insertCell(2).innerHTML='<div class="input_star"><div class="drop4 dropdown_2" id="product'+count_R+'"><select name="frmProductId[]" style="width:170px;" onchange="ShowProductPriceForPackage(this.value,'+count_R+')"><option value="0">'+PRODUCT+'</option></select></div><small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small></div>';
    
    row.insertCell(3).innerHTML='<span id="price'+count_R+'" style="text-align:center"><input type="hidden" name="frmPrice[]" class="input1" value="0.00" /><b>0.00</b></span>';
    row.insertCell(4).innerHTML='<i class="my-icons" style="cursor: pointer;" onclick="addDynamicRowToTableForPackage('+"'productRow'"+');"><img src="admin/images/my_plus.png" /></i><a class="my-icons" href="#" onclick="removeRowFromTableForPackage(\''+TableID+'\',\''+count_R+'\',this);return false;"><img src="admin/images/my_minus.png" /></a>';    
    $('#product'+count_R).parent().find('select').sSelect(); 
//$(".select2-me").select2();
    
    
}
                    
                    
function removeRowFromTableForPackage(TableID,rowNo,elem)
{
    var sizecount= document.getElementById(TableID).value;
    var tbl = document.getElementById(TableID);
    var lastRow = elem.parentNode.parentNode.rowIndex;
    if (lastRow > 0) tbl.deleteRow(lastRow);
    sizecount--;
    $('#'+TableID+' tr:last i').html('<i style="cursor: pointer;" onclick="addDynamicRowToTableForPackage('+"'productRow'"+');"><img src="admin/images/my_plus.png" /></i>');
    document.getElementById(TableID).value=sizecount;
    var frmPrice = document.getElementsByName('frmPrice[]');
    var total=0,i,p,a=0;
    //alert(frmPrice[0].value);
    for(i=0; i<frmPrice.length;i++)
    {
        p = parseFloat(frmPrice[i].value);
        total = total+p;
    }
    total = total.toFixed(2);
    $('#asc').html(total);
//$('#TempCount').val(lastRow-1);
}


function AcceptDecimal(str) {
    str = trim(str);
    var regDecimal = /^[-+]?[0-9]+(\.[0-9]+)?$/;
    return regDecimal.test(str);
} 

function IsLessThan(max,min){
    
    max=parseFloat(max);
    min=parseFloat(min);
   
    if(min>max){
        return false;
    }else{
        return true;
    }
}
function trim(str) {
    return ltrim(rtrim(str));
} 
function ltrim(str) {
    for(var k = 0; k < str.length && isWhitespace(str.charAt(k)); k++);
    return str.substring(k, str.length);
} 
function rtrim(str) {
    for(var j=str.length-1; j>=0 && isWhitespace(str.charAt(j)) ; j--) ;
    return str.substring(0,j+1);
} 
                
function isWhitespace(charToCheck) {
    var whitespaceChars = " \t\n\r\f";
    return (whitespaceChars.indexOf(charToCheck) != -1);
} 
function jscallPackageAddBox(){   
    $(".create_pkg_color_box").colorbox({
        inline:true, 
        //width:"1200px", 
        height:"800px"
    });
   
    $('#cancel').click(function(){
        parent.jQuery.fn.colorbox.close();
    });
}

function jCropPopupOpen(str){    //alert(str);return false;    
    $("."+str).colorbox({
        inline:true
    });
    $('.ok').click(function(){
        parent.jQuery.fn.colorbox.close();
    });
}

function showPackageProduct(val){
                
}   

function hideInputType(Id){
    document.getElementById(Id).innerHTML = '';
}
        
       
function showCurrencyInUSD(showId){
    var amount = $.trim($('#frmWholesalePrice'+showId).val());
    var from = $('#frmCurrency'+showId).val();
    $('#frmCurrency2').val(from)
    if(amount==''){
        $('#InUSD'+showId).html('');
        $('#frmWholesalePriceInUSD'+showId).val('');
        $('#FinalPriceInUSD'+showId).html('');
        $('#frmProductPrice'+showId).val('');
        return false;
    }
    $('#InUSD'+showId).html('Calculating..');
    $.post('common/ajax/ajax_converter.php',{
        action:'showCurrency',
        amount:amount,
        from:from,
        to:'USD'
    },
    function(data){
        var p = data.split("--");
        $('#InUSD'+showId).html('$ '+p[0]);
        $('#frmWholesalePriceInUSD'+showId).val(p[0]);
        $('#FinalPriceInUSD'+showId).html('$ '+p[1]);
        $('#frmProductPrice'+showId).val(p[1]);
    });
} 
            
            
function showAttribute(str){
    if(str=='0' || str==''){        
        $('.ErrorfkCategoryID').css('display','block');
        var error = errorMessage();            
        $('.ErrorfkCategoryID').html(error);
       
        $('#attribute').html('<input type="hidden" name="frmIsAttribute" value="0" class="input2" />'+SEL_CATEGORY);
    }else{
        
        showSpecialEvents(str);        
        $('.ErrorfkCategoryID').css('display','none');
        $.post("admin/ajax.php",{
            action:'ShowAttribute',
            ajax_request:'valid',
            catid:str
        },function(data){
            $('#attribute').html(data);
            $('.checkradios').checkradios();
        });
    }
}

function showSpecialEvents(str){      
    $.post(SITE_ROOT_URL+"common/ajax/ajax_wholesaler.php",{
        action:'showSpecialEvents',
        catid:str
    },function(data){                
        $('.special').html(data);
        if(data==''){
            $('.specialPrice').hide();
        }else{
            $('.specialPrice').show();            
            $('.specialPrice .selectedTxt').click(function(){               
                $('.specialPrice').find('ul.newList').css('height','300px');
            });
        }
    });   
}
            
function deleteImage(str){
    if(str==''){
        $('#img'+str).html(INVALID_ACTION);
    }else{
        $.post("admin/ajax.php",{
            action:'deleteImage',
            ajax_request:'valid',
            imgid:str
        },function(data){
            $('#img'+str).html(data);
            
            setTimeout(function(){
                $('#img'+str).parent().remove();
            },3000);
        });
    }
} 
             
var image_counter =1;
$(function(){
    $('#file1').customFileInput1();
    $('#filePS2').customFileInput1();
    $('#fileDI3').customFileInput1();    
                
});
$(document).ready(function(){
                
    $('input[numericOnly="yes"]').bind('keypress', function (event) {
        var regex = new RegExp("^[\!\@\#\$\%\^\&\*\(\)\'\"\;\:a-zA-Z]+$");
        var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
        if (regex.test(key)) {
            event.preventDefault();
            return false;
        }
    });

              
    $('.drop_down1').sSelect();
    $('#DateStart').datepick({
        dateFormat: 'dd-mm-yyyy', 
        showTrigger: '<img src="common/images/calendar.gif" alt="Popup" class="trigger">'
    });
    $('#DateEnd').datepick({
        dateFormat: 'dd-mm-yyyy', 
        showTrigger: '<img src="common/images/calendar.gif" alt="Popup" class="trigger">'
    });
       
    $('.delete_icon3').live('click',function(e){
        $(this).parent().remove();
        //addRemoveDeleteMoreImages();
        e.preventDefault();
    });
      
//    $('.more_images').click(function(e){
//        image_counter++;
//        var file_input = '<div class="imgimg"><div class="responce"></div><input class="customfile1-input file file_upload" id="file'+image_counter+'" type="file" name="file_upload[]" style="top: 0; left: 0px!important;"/><a href="#" class="delete_icon3"></a><div>';
//        $(this).parent().before(file_input);
//        $('#file'+image_counter).customFileInput1();
//        addRemoveDeleteMoreImages();
//        e.preventDefault();
//    });
    
    $('.more_images').click(function(e){
        image_counter++;
        
        /* Commented by Krishna Gupta (Oct. 01, 2015) */
        //var element='<div class="imgimg"><a href=\"#cropimg_'+image_counter+'\" onclick="jCroppicPopupOpen(\'cropimg\',\''+image_counter+'\')" class="cropimg" style="z-index:9999999">Upload Another Image</a><div id="cropimg_'+image_counter+'" style="display:none"></div><input type="hidden" name="frmProductImg[]" id="after_cropimg_'+image_counter+'" value=""/><span class="defaultRadio"><input type="radio" name="default" class="default" value="" id="after_cropimg_default_'+image_counter+'"/>  <span class="innerDefault">Default</span></span><a title="Remove" href="#" class="delete_icon3 crossImage"></a></div>';
        var element='<div class="imgimg"><a href=\"#cropimg_'+image_counter+'\" onclick="jCroppicPopupOpen(\'cropimg\',\''+image_counter+'\', \'croppicLogo\')" class="cropimg" style="z-index:9999999">Upload Another Image</a><div id="cropimg_'+image_counter+'" style="display:none"></div><input type="hidden" name="frmProductImg[]" id="after_cropimg_'+image_counter+'" value=""/><span class="defaultRadio"><input type="radio" name="default" class="default" value="" id="after_cropimg_default_'+image_counter+'"/>  <span class="innerDefault">Default</span></span><a title="Remove" href="#" class="delete_icon3 crossImage"></a></div>';
        
        var file_input = '<div class="imgimg"><div class="responce"></div><input class="customfile1-input file file_upload" id="file'+image_counter+'" type="file" name="file_upload[]" style="top: 0; left: 0px!important;"/><a href="#" class="delete_icon3"></a><div>';
        $('.more_image_to_crop').append(element);
        
        //$(this).parent().before(file_input);
        //$('#file'+image_counter).customFileInput1();
        //addRemoveDeleteMoreImages();
        e.preventDefault();
    });
});

function addRemoveDeleteMoreImages(){
    var i=0;
    $(".imgimg").each(function(){
        i++;
    });    
    
    if(i>1){   
        $(".imgimg").first().find('.delete_icon3').show();        
    }else{        
        $(".imgimg").first().find('.delete_icon3').hide();        
    }
}



function checkProductRefNoForMultiple(str,showid,pid){
    if(str==''){
        $('#refmsg'+showid).html('<input type="hidden" name="frmIsRefNo[]" value="0" />');
    }else{
        $.post("admin/ajax.php",{
            action:'checkProductRefNoForMultiple',
            ajax_request:'valid',
            refno:str,
            showid:showid,
            pid:pid
        },function(data){
            $('#refmsg'+showid).html(data);
        });
    }       
}
            
function ValidateForm(){
    var frmProductRefNo = document.getElementsByName('ProductRefNo');
    var frmIsRefNo = document.getElementsByName('frmIsRefNo[]');
    
    if(frmIsRefNo[0].value==1){
        alert(PRO_REF_NO_EXIST);
        frmProductRefNo[0].focus();
        return false;
    }
    // var shipId = $('#fkShippingID').val();
    /*
    var frmShippingGateway = document.getElementsByName("frmShippingGateway[]");
    if(IsChecked(frmShippingGateway)==false){
        var error = errorMessage();
        $('.ErrorfkShippingID').html(error);
        goToByScroll('ErrorfkShippingID');
        return false; 
    }
    
    if(shipId=='0' || shipId==''){
        $('.ErrorfkShippingID').css('display','block');
        var error = errorMessage();
        $('.ErrorfkShippingID').html(error);
        goToByScroll('ProductRefNo');
        return false; 
       
    }*/
    else if($('#fkCategoryID').val()=='0' || $('#fkCategoryID').val()==''){
        $('.ErrorfkCategoryID').css('display','block');
        var error = errorMessage();
        $('.ErrorfkCategoryID').html(error);
        goToByScroll('add_edit_product');
        return false;        
    }
    
    if(ImageExist==0)
    {
        var frmDefaultImg = $('#file1').val();
        if(frmDefaultImg==''){
            alert("Please select an image");
            $('#file1').focus();
            return false;
        }
    }
    //    var frmDefaultImgErr = $('#default_image_error').val();
    //    var frmDefaultmgName = $('#frmProductDefaultImgName').val();
    //
    //
    //    if(frmDefaultImg=='' && frmDefaultmgName==''){
    //        alert(UPLOAD_DEFAULT);
    //        $('#fileDI3').focus();
    //        return false;
    //    }else if(frmDefaultImg!=''){
    //        var exte = frmDefaultImg.substring(frmDefaultImg.lastIndexOf('.') + 1);
    //        var ext = exte.toLowerCase();
    //        if(ext!='jpg' && ext!='jpeg' && ext!='gif' && ext!='png'){
    //            alert(ACCEPTED_IMAGE_FOR);
    //            $('#fileDI3').focus();
    //            return false;
    //        }
    //    }else if (frmDefaultImgErr==0){
    //        alert(UPLOAD_IMAGE_IN+'('+MIN_PRODUCT_IMAGE_WIDTH+'-'+MAX_PRODUCT_IMAGE_WIDTH+')'+PX_WIDTH_AND+'('+MIN_PRODUCT_IMAGE_HEIGHT+'-'+MAX_PRODUCT_IMAGE_HEIGHT+')'+PX_HEIGHT);
    //        $('#fileDI3').focus();
    //        return false;
    //    }else   if (frmDefaultImgErr==2){
    //        alert(DEF_IMAGE_SIZE+MAX_PRODUCT_IMAGE_SIZE_IN_KB+KB);
    //        $('#fileDI3').focus();
    //        return false;
    //    }
   
    
    
    var frmProductImg = document.getElementsByName('frmProductImg[]');
    var frmProductImgErr = document.getElementsByName('image_error[]');
    
    
    if(frmProductImg.length>0){
        for(var k=0;k<frmProductImg.length;k++){
            var ff = frmProductImg[k].value;
            if(ff!=''){
                var exte = ff.substring(ff.lastIndexOf('.') + 1);
                var ext = exte.toLowerCase();
                if(ext!='jpg' && ext!='jpeg' && ext!='gif' && ext!='png'){
                    alert(AcceptedImageFormats);
                    frmProductImg[k].focus();
                    return false;
                }
            }
            
            if (frmProductImgErr[k].value==0){                            
                alert(UPLOAD_IMAGE_IN+'('+MIN_PRODUCT_IMAGE_WIDTH+'-'+MAX_PRODUCT_IMAGE_WIDTH+')'+PX_WIDTH_AND+'('+MIN_PRODUCT_DETAIL_IMAGE_HEIGHT+'-'+MAX_PRODUCT_IMAGE_HEIGHT+')'+PX_HEIGHT); 
                frmProductImg[k].focus();
                return false;
            }
            
            if (frmProductImgErr[k].value==2){               
                alert(IMAGE_SIZE_MUST+MAX_PRODUCT_IMAGE_SIZE_IN_KB+KB);
                frmProductImg[k].focus();
                return false;
            }
                        
        }
    }
}


var url = window.URL || window.webkitURL;
//var prod_img = document.getElementsByClassName("prod_img");
$(document).ready(function(){
    $('.file').live('change',function(){
        var dd = $(this);
        var name = dd.attr('name');
        
        if( this.disabled ){
            alert(BROWS_NOT_SUPPORT);
        }else{
            var chosen = this.files[0];                            
            var image = new Image();
            var ImageSize = chosen.size;
                           
            image.onload = function() {
                
                if (name=='frmProductDefaultImg' && (this.width < MIN_PRODUCT_IMAGE_WIDTH || this.height < MIN_PRODUCT_IMAGE_HEIGHT || this.width >MAX_PRODUCT_IMAGE_WIDTH || this.height > MAX_PRODUCT_IMAGE_HEIGHT || this.size > MAX_PRODUCT_IMAGE_SIZE)){
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

function IsChecked(objRadio1){
  
    for(var i=0;i<objRadio1.length;i++){
        if(objRadio1[i].checked){
            return true;            
        }
    }
    return false;    
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

function errorMessage(){
    return '<div style="opacity: 0.87; position: absolute; top: 180px; margin-top: -213px; left: 395px;" class="formError"><div class="formErrorContent">* '+required+'<br/></div><div class="formErrorArrow"><div class="line10"><!-- --></div><div class="line9"><!-- --></div><div class="line8"><!-- --></div><div class="line7"><!-- --></div><div class="line6"><!-- --></div><div class="line5"><!-- --></div><div class="line4"><!-- --></div><div class="line3"><!-- --></div><div class="line2"><!-- --></div><div class="line1"><!-- --></div></div></div>';
                
}