$(function() {
    var pull= $('#pull');
    menu = $('nav ul');
    menuHeight= menu.height();
    $(pull).on('click', function(e) {
        e.preventDefault();
        menu.slideToggle();
    });
    $(window).resize(function(){
        var w = $(window).width();
        if(w > 320 && menu.is(':hidden')) {
            menu.removeAttr('style');
        }
    });

    // Slideshow 4
    $("#slider4").responsiveSlides({
        auto: true,
        pager: false,
        nav: true,
        speed: 500,
        namespace: "callbacks",
        before: function () {
            $('.events').append("<li>before event fired.</li>");
        },
        after: function () {
            $('.events').append("<li>after event fired.</li>");
        }
    });

});
//This function will display content pages
function showWholesalerContent(conId)
{
    conId != 'home' ? $('.main_div').hide() : $('.main_div').show();
    $('.min-height-box').css({
        'display':'none'
    });
    $('#'+conId).css({
        'display':'block'
    });
    $('nav').find('a').removeClass();
    $('#nav_'+conId).addClass('active');   
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
        $('#email').css('border-color','red');
        return false;
    }
    else{
        return true;
    }
}
function onKeySignUp(id){
    $('#'+id).css('border-color','#424335');
}
