$(function(){    
    $('#file1').customFileInput1();
    $('#frmImages').customFileInput1();
  
});
$(document).ready(function(){
    $('.drop_down1').sSelect();
    $('#upload_type').change(function(){
        var type = $(this).val();
        if(type=='products'){
            $('.package_options input[type="checkbox"]').each(function(){
                var req = $(this).attr('req');
                if(req=='yes' || req=='no'){
                    $(this).attr('req','no');
                }
            });
            $('.product_options input[type="checkbox"]').each(function(){
                var req = $(this).attr('req');
                if(req=='yes' || req=='no'){
                    $(this).attr('req','yes');
                }
            });
            $('.product_options').css('display','block');
            $('.package_options').css('display','none');
        }else if(type=='packages'){
            $('.product_options input[type="checkbox"]').each(function(){
                var req = $(this).attr('req');
                if(req=='yes' || req=='no'){
                    $(this).attr('req','no');
                }
            });
            $('.package_options input[type="checkbox"]').each(function(){
                var req = $(this).attr('req');
                if(req=='yes' || req=='no'){
                    $(this).attr('req','yes');
                }
            });
            $('.product_options').css('display','none');
            $('.package_options').css('display','block');
        }else{
            $('.product_options').css('display','none');
            $('.package_options').css('display','none');
        }
    });
});
function validate(){
    var flag = true;
    var product_options =$('.product_options').is(':visible');
    var package_options=$('.package_options').is(':visible');
     
    var type = $('#upload_type').val();
    if(type==''){
        $('#upload_type').parent().parent().find('.req_field').html(FILL_REQ_FIELD);
    }else{
        $('#upload_type').parent().parent().find('.req_field').html('');
    }
    
    $('input[type="checkbox"]').each(function(){
        var req = $(this).attr('req');
        if(req=='yes'){
            if($(this).prop('checked')==false){
                if($(this).parent().find('p[class="req_field"]').length){

                }else{
                    $(this).parent().append('<p class="req_field">'+FILL_REQ_FIELD+'</p>');
                }
                flag = false;
                
                
                if(product_options==true || package_options==true){
                $('html, body').animate({
                    scrollTop: 300
                }, 500);
                }else{
                $('html, body').animate({
                    scrollTop: 80
                }, 500);    
                }
            }else{
                $(this).parent().find('p[class="req_field"]').remove();
            }
        }
    });

    if(flag==false){
        return flag;
    }
    var frmProductImg = document.getElementsByName('file');
    if(frmProductImg.length>0){
        for(var k=0;k<frmProductImg.length;k++){
            var ff = frmProductImg[k].value;
            if(ff!=''){
                var exte = ff.substring(ff.lastIndexOf('.') + 1);
                var ext = exte.toLowerCase();
                if(ext!='xls' && ext!='csv' && ext!='xlsx' ){
                    alert(ACCEPTED_ONLY_EXCEL);
                    frmProductImg[k].focus();
                    return false;
                }
            }else{
                alert(SEL_VALID_EXCEL);
                frmProductImg[k].focus();
                return false;
            }
        }
    }
                
    var frmProductZip = document.getElementById("frmImages");
    if(frmProductZip.value==""){
                   
        alert(ACCEPTED_ONLY_ZIP);
        frmProductZip.focus();
        return false; 
    }
}
function checkAll(str){
    
    if($('#'+str).attr('checked')){
        $('.'+str+' .styled').attr('checked','checked');
        $('.'+str+' .checkbox').css('background-position','0px -50px');
        
    }
    else{
        $('.'+str+' .styled').attr('checked',null);
        $('.'+str+' .checkbox').css('background-position','0px 0px');
    }

}