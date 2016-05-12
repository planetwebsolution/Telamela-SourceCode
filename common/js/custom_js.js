$(window).load(function(){  
    function equalHeight(group) {
        var tallest = 0;
        group.each(function() {
            var thisHeight = $(this).height();
            if(thisHeight > tallest) {
                tallest = thisHeight;
            }
        });
        //alert(tallest);
        group.height(tallest);
    }
    equalHeight($(".sec"));
});
$(document).ready(function(){
    $('body').on('blur','#frmCustomerEmail',function(){
        var email =$.trim($(this).val());
        if(email == '')
        {
            return false;
        }
        var url =$(this).attr('ajexU');
        //alert(url);
        $.ajax({
            url:url+'ajax/ajax.php',
            type: 'POST',
            data: {
                action:'verifyEmail',
                email:email
            },
            async: false, //blocks window close
            dataType: "json",
            success: function(data) {
                if($.trim(data.exist)==email){
                    $('#customerEmailExistsErrorMsg').show();
                    $('#frmCustomerEmail').val('');
                }else{
                    $('#customerEmailExistsErrorMsg').hide();
                }
            }
        });
    });
    $('#frmCompany1Email').on('blur',function(){
        var email =$.trim($(this).val()); 
        if(email == '')
        {
            return false;
        }
        var url =$(this).attr('ajexU');
        //alert(url);
        $.ajax({
            url:SITE_ROOT_URL+'common/ajax/ajax.php',
            type: 'POST',
            data: {
                action:'verifyEmailWholsaler',
                email:email
            },
            async: false, //blocks window close
            dataType: "json",
            success: function(data) { //alert(data.exist);
                if($.trim(data.exist)==email){
                    $('#customerEmailExistsErrorMsg').show();
                    $('#frmCompany1Email').val('');
                }else{
                    $('#customerEmailExistsErrorMsg').hide();
                }
            }
        });
    });
});   
  