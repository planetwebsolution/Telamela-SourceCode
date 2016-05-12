Cal(document).ready(function(){
    Cal('#cancel').click(function(){
        parent.jQuery.fn.colorbox.close();        
    });
    
    var addDiv = Cal('#addinput');                
    var i = Cal('#addinput .imgimg').size() + 1;

    Cal('#addNew').live('click', function() {  
        
        Cal('#addinput .imgimg :last span').html('');
        Cal('<div class="imgimg"><div class="responce"></div>Image'+i+'<input name="file_upload[]" class="file_upload" type="file" /><span>&nbsp;<a href="#" id="addNew"><img src="images/plus.png" alt="Add more" title="Add more" /></a></span>&nbsp;<a href="#" id="remNew"><img src="images/minus.png" alt="Remove" title="Remove" /></a></div>').appendTo(addDiv);          
        //$('<div class="imgimg"><input type="hidden" name="x1[]" class="x1" /><input type="hidden" name="y1[]" class="y1" /><div class="image_div"><img src="" class="load_img" /></div><br/>Image'+i+'<input name="frmProductImg[]" class="image_file" type="file" /><span>&nbsp;<a href="#" id="addNew"><img src="images/plus.png" alt="Add more" title="Add more" /></a></span>&nbsp;<a href="#" id="remNew"><img src="images/minus.png" alt="Remove" title="Remove" /></a></div>').appendTo(addDiv);
        //Cal('<p>Image'+i+' <input type="file" name="frmProductImg['+i+']" value="" class="prod_img"/><input type="hidden" name="image_error" value="0" class="image_error" id="image_error'+i+'"><span>&nbsp;<a href="#" id="addNew"><img src="images/plus.png" alt="Add more" title="Add more" /></a></span>&nbsp;<a href="#" id="remNew"><img src="images/minus.png" alt="Remove" title="Remove" /></a></p>').appendTo(addDiv);
        i++;
        addRemoveDeleteMoreImages();
        return false;
    });

    Cal('#remNew').live('click', function() {
        if( i > 2 ) {
            Cal(this).parents('.imgimg').remove();
            i--;
            Cal("#addinput .imgimg:last span").html('<span><a href="#" id="addNew"><img src="images/plus.png" alt="Add more" title="Add more" /></a></span>');

        }
        addRemoveDeleteMoreImages();
        return false;
    });
    
    
    Cal('#addNewColorImage').live('click', function() {  
        
        Cal('#addinput .imgimg :last span').html('');
        Cal('<div class="imgimg"><div class="responce"></div>Image'+i+'<input name="file_upload[]" class="file_upload" type="file" /><span>&nbsp;<a href="#" id="addNew"><img src="images/plus.png" alt="Add more" title="Add more" /></a></span>&nbsp;<a href="#" id="remNew"><img src="images/minus.png" alt="Remove" title="Remove" /></a></div>').appendTo(addDiv);          
        //$('<div class="imgimg"><input type="hidden" name="x1[]" class="x1" /><input type="hidden" name="y1[]" class="y1" /><div class="image_div"><img src="" class="load_img" /></div><br/>Image'+i+'<input name="frmProductImg[]" class="image_file" type="file" /><span>&nbsp;<a href="#" id="addNew"><img src="images/plus.png" alt="Add more" title="Add more" /></a></span>&nbsp;<a href="#" id="remNew"><img src="images/minus.png" alt="Remove" title="Remove" /></a></div>').appendTo(addDiv);
        //Cal('<p>Image'+i+' <input type="file" name="frmProductImg['+i+']" value="" class="prod_img"/><input type="hidden" name="image_error" value="0" class="image_error" id="image_error'+i+'"><span>&nbsp;<a href="#" id="addNew"><img src="images/plus.png" alt="Add more" title="Add more" /></a></span>&nbsp;<a href="#" id="remNew"><img src="images/minus.png" alt="Remove" title="Remove" /></a></p>').appendTo(addDiv);
        i++;
        addRemoveDeleteMoreImages();
        return false;
    });

    Cal('#remNewColorImage').live('click', function() {
        if( i > 2 ) {
            Cal(this).parents('.imgimg').remove();
            i--;
            Cal("#addinput .imgimg:last span").html('<span><a href="#" id="addNew"><img src="images/plus.png" alt="Add more" title="Add more" /></a></span>');

        }
        addRemoveDeleteMoreImages();
        return false;
    });

    //attrbutes images

    Cal('.imagetype').live('change', function() {        
        var objAttr = $(this);
        var OptId = objAttr.val();        
        if(objAttr.is(':checked')){            
            objAttr.siblings('.res_attr').html('<div class="responce"></div><input type="text" name="frmOptCaption['+OptId+']" value="'+objAttr.attr('caption')+'" class="input-small">&nbsp;&nbsp;<input name="file_upload_attr['+OptId+']" class="file_upload_attr" type="file" />');
        }else{
            objAttr.siblings('.res_attr').html('');
        }
    });
    
    Cal('.imagetype1').live('change', function() {        
        var objAttr = $(this);
        var OptId = objAttr.val();        
        if(objAttr.is(':checked')){            
            objAttr.siblings('.res_attr').html('<div class="responce"></div><input type="text" name="frmOptCaption['+OptId+']" value="'+objAttr.attr('caption')+'" class="input-small">');
        }else{
            objAttr.siblings('.res_attr').html('');
        }
    });
    
    
    Cal('.otherstype').live('change', function() { 
       
        var objCaption = $(this);
        var OptId = objCaption.val();        
        if(objCaption.is(':checked')){            
            objCaption.siblings('.res_caption').html('<input type="text" name="frmOptCaption['+OptId+']" value="'+objCaption.attr('caption')+'" class="input-small">');
        }else{
            objCaption.siblings('.res_caption').html('');
        }
    });

Cal('#ProductColorImage').on('click',function(){
    if(Cal('#ProductColorImage').is(':checked')==true){
       Cal('.colorimageDiv').show(); 
    }else{
       Cal('.colorimageDiv').hide();
    }
});

    
});

function jCropPopup(str){    
    $("."+str).colorbox({
        inline:true,
        width:"650px",
        height:"500px",
        onComplete:function(){
            cropInit();            
        }
    });
    $('.ok').click(function(){
        parent.jQuery.fn.colorbox.close();
    });
}

function jCropPopupOpen(str){    
    $('#'+str).show();
    $('#CropDynId').val(str);
    //$('#TargetDynId').val(str);
    //cropInit();
    //$('.target').Jcrop();
    
}
function jCropPopupClose(str){
    $('#'+str).hide();
}


function packagePopup(){
    $(".delete").colorbox({
        inline:true,
        width:"650px",
        height:"530px"
    });
    

    $('#frmConfirmDelete').click(function(){
        var frmPackageName = document.getElementById('frmPackageName');
        var frmWholesalerId = document.getElementById('frmWholesalerId');
        var frmCategoryId = document.getElementsByName('frmCategoryId[]');
        var frmProductId = document.getElementsByName('frmProductId[]');
        var frmOfferPrice = document.getElementById('frmOfferPrice');
        var frmTotalPrice = document.getElementById('frmTotalPrice');

        if(frmPackageName.value==''){
            alert('Package Name is Required!');
            frmPackageName.focus();
            return false;
        }
        if(frmWholesalerId.value=='0'){
            alert('Please Select wholesaler!');
            frmWholesalerId.focus();
            return false;
        }

        for (var i = 0; i < frmCategoryId.length; i++) {

            if(frmCategoryId[i].value==0){
                alert('Please Select Category!');
                frmCategoryId[i].focus();
                return false;
            }else if(frmProductId[i].value==0){
                alert('Please Select Product!');
                frmProductId[i].focus();
                return false;
            }
        }

        if(frmOfferPrice.value==''){
            alert('Offer Price is Required!');
            frmOfferPrice.focus();
            return false;
        }else if(AcceptDecimal(frmOfferPrice.value)==false){
            alert("Please Enter numeric or decimal value!");
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
        $.post("ajax.php",{
            action:'AddPackage',
            pkgnm:frmPackageName.value,
            whid:frmWholesalerId.value,
            pids:proids,
            offerprice:frmOfferPrice.value
        },
        function(data)
        {
            var res = data.split('skm#skm');
            $('#packages').html(res[1]);
            showPackageProduct(res[0]);
        }
        );
        parent.jQuery.fn.colorbox.close();

    });
}


function ShowWholesaler() {

    var str = $('#frmCountryID').val();

    $.post("ajax.php",{
        action:'ShowWholesaler',
        ctid:str
    },
    function(data){
        $('#frmfkWholesalerID').siblings('.select2-container').find('a span').html('Select Wholesaler');
        $('#frmfkWholesalerID').html(data);
    });
}

function ShowWholesalerShippingGateway(str) { 
    if(str=='0' || str==''){
        $('#shippingGateways').html('Please Select Wholesaler');
    }else{
        $.post("ajax.php",{
            action:'ShowWholesalerShippingGateway',
            wid:str
        },
        function(data){
            $('#shippingGateways').html('<input type="checkbox" value="All" name="all[]" id="sAll" onclick="javascript:toggleShippingOption(this);"> Select All <br>'+data);
        });
    }
}

function showPackageProduct(str) {
    $('#showPackageProduct').css('display', 'none');
    if(str==0){
        $('#showPackageProduct').html('');
        $('#shwhde').html('');
        return;
    }
    $('#shwhde').html('Please wait...');
    $.post("ajax.php",{
        action:'showPackageProduct',
        pkgid:str
    },
    function(data)
    {
        $('#showPackageProduct').html(data);
        $('#shwhde').html(' <a href="javascript:void(0)" onclick="showPkgDet()">Show Package Detail</a>');
    });
}

function hideInputType(Id){
    document.getElementById(Id).innerHTML = '';
}


function addRemoveDeleteMoreImages(){
    var i=0;
    $(".imgimg").each(function(){
        i++;
    });    
   // alert(i);
    if(i>1){   
        $(".imgimg").first().find('a').show();        
    }else{        
         $(".imgimg").first().find('a').last().hide();        
    }
}