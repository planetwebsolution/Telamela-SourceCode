$(document).ready(function() {
    
    $('.first').on('click',function(){
        $(".asd").text(($(this).find('.cat').text()));
    });

    
    $("#owl-demo").owlCarousel({
        singleItem:true,
        autoPlay:true
    });
    
    var owl = $("#owl-demo1");

    owl.owlCarousel({
        items : 3, //10 items above 1000px browser width
        itemsDesktop : [1000,3], //5 items between 1000px and 901px
        itemsDesktopSmall : [900,3], // 3 items betweem 900px and 601px
        itemsTablet: [600,1], //2 items between 600 and 0;
        itemsMobile : false // itemsMobile disabled - inherit from itemsTablet option
    });

    // Custom Navigation Events
    $(".next1").click(function(){
        owl.trigger('owl.next');
    });
    $(".prev1").click(function(){
        owl.trigger('owl.prev');
    });

    var owl2 = $("#owl-demo2");

    owl2.owlCarousel({
        items : 3, //10 items above 1000px browser width
        itemsDesktop : [1000,3], //5 items between 1000px and 901px
        itemsDesktopSmall : [900,3], // 3 items betweem 900px and 601px
        itemsTablet: [600,1], //2 items between 600 and 0;
        itemsMobile : false // itemsMobile disabled - inherit from itemsTablet option
    });

    // Custom Navigation Events
    $(".next2").click(function(){
        owl2.trigger('owl.next');
    });
    $(".prev2").click(function(){
        owl2.trigger('owl.prev');
    });

    var owl3 = $("#owl-demo3");

    owl3.owlCarousel({
        items : 3, //10 items above 1000px browser width
        itemsDesktop : [1000,3], //5 items between 1000px and 901px
        itemsDesktopSmall : [900,3], // 3 items betweem 900px and 601px
        itemsTablet: [600,1], //2 items between 600 and 0;
        itemsMobile : false // itemsMobile disabled - inherit from itemsTablet option
    });

    // Custom Navigation Events
    $(".next3").click(function(){
        owl3.trigger('owl.next');
    });
    $(".prev3").click(function(){
        owl3.trigger('owl.prev');
    });

    var owl4 = $("#owl-demo4");

    owl4.owlCarousel({
        items : 3, //10 items above 1000px browser width
        itemsDesktop : [1000,3], //5 items between 1000px and 901px
        itemsDesktopSmall : [900,3], // 3 items betweem 900px and 601px
        itemsTablet: [600,1], //2 items between 600 and 0;
        itemsMobile : false // itemsMobile disabled - inherit from itemsTablet option
    });

    // Custom Navigation Events
    $(".next4").click(function(){
        owl4.trigger('owl.next');
    });
    $(".prev4").click(function(){
        owl4.trigger('owl.prev');
    });
});
//This function will display content pages
function showWholesalerContent(conId)
{
   
    $('#wh_product').hide();
    $('.main-div').hide();
    $('#show_catname').hide();
    $('#'+conId).css({
        'display':'block'
    });
    $('li').removeClass('current');
    $('#nav_'+conId).parent('li').addClass('current');
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