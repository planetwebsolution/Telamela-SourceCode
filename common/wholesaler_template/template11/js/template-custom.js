$(document).ready(function() {

    $(".category > li").click(function(){
        var a = $(this).index();
        $(".category > li").removeClass("active");
        $(this).addClass("active");
        $(".itemsContainer").removeClass("shown");
        $(".itemsContainer").eq(a).addClass("shown");
         $("#product_cat").text($("#cat_name_show_"+a).text());
        // $("#test").text()
    });

    $("#owl-demo").owlCarousel({
        navigation : true, // Show next and prev buttons
        slideSpeed : 300,
        paginationSpeed : 400,
        singleItem:true,
        autoHeight:true,
        autoPlay:true
    });
    $("#owl-demo2").owlCarousel({
        singleItem:true,
        autoPlay:true
    });

    $(".mobileMenu").click(function(){
        $("ul.nav").slideToggle();

    });
});
//This function will display content pages
function showWholesalerContent(conId)
{
   
    $('#wh_product').hide();
    conId != 'home' ? $('.main_div').hide() : $('.main_div').show();
    $('.content-box').css({
        'display':'none'
    });
    $('#'+conId).css({
        'display':'block'
    });
    $('.nav li').removeClass();
    $('#nav_'+conId).parent().addClass('active');
    var divLoc = $('#'+conId).offset();
    $('html, body').animate({
        scrollTop: divLoc.top
    }, "slow");

}

function validateWhlFrm()
{
    var name=$.trim($('#name').val());
    var email=$.trim($('#email').val());
    var message=$.trim($('#message').val());
    var WholesaleEmail=$.trim($('#whlemail').val());

    if(validateWhlContatctForm(name,email,message))
    {       
        $.ajax({
            url:SITE_ROOT_URL+'common/ajax/ajax.php',
            type:'post',
            data:{
                email:email,
                name:name,
                message:message,
                WholesaleEmail:WholesaleEmail,
                whlTemContactTemp:'1'
            },
            success:function(responseText){
                if($.trim(responseText)==1)
                {
                    $('#messageTemplate').css('display','block');
                    $('#whlContactForm').find("input[type=text],input[type=email], textarea").val("");
                    setInterval(function(){
                        $('#messageTemplate').css('display','none');
                    }, 3000);
                }
            }
        });
    }
}
function validateWhlContatctForm(name, email, message){
    var flag = 0;
    if(email !='' && name!=''  && message!='')
    {
        if (!chkEmailValidation(email)){
            return false;
        }
        return true;
    }
    if(name==''){
        $('#name').css('border-color','red');
        flag = 1;
    }

    if (email==''){
        $('#email').css('border-color','red');
        flag = 1;
    }
    if (message==''){
        $('#message').css('border-color','red');
        flag = 1;
    }

    if(flag!=0){
        return false;
    }else{
        return true;
    }
}
function chkEmailValidation(varEmail){
    var regEmail = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    if(!regEmail.test(varEmail))
    {
        $('#email').val('');
        $('#email').attr('placeholder','Email not valid')
        $('#email').addClass('red');
        return false;
    }
    else{
        return true;
    }
}
function chkPhoneValidation(varPhone){
    var regPhone = /^[0-9-+]+$/;
    if(!regPhone.test(varPhone))
    {
        $('#phone').val('');
        $('#phone').attr('placeholder','Phone not valid')
        $('#phone').addClass('red');
        return false;
    }
    else{
        return true;
    }
}
function onKeySignUp(id){
    $('#'+id).removeClass('red');
}