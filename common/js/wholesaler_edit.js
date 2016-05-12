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
       //alert(getCount);return false;
       var action =getCount==1?'saveImageAfterCropLogo':'saveImageAfterCropSlider';
       $.post(SITE_ROOT_URL+"common/ajax/ajax_uploader.php",{
            action:action,
            imageSrc:getImageSrc,
            imageName:getImageName
        },
        function(data)
        {
         if(getCount==1){
         $('#fileLogo').val(getImageName);
         $('.afterCropLogo').html('<img src="'+data+'"/>');
         }else{
         $('#sliderimage_'+getCount).val(getImageName);
         $('.afterCropLogo_'+getCount).html('<img src="'+data+'"/>');
         }
         //alert(data);return false;
         $('#cropimg_'+getCount).hide();
         
         parent.jQuery.fn.colorbox.close();
            
        });
       //alert(getImageSrc);return false;
    });
      
    
                
});