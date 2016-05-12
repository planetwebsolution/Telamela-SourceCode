$(document).ready(function(){
var loadUrl=SITE_ROOT_URL+'common/images/loading_all.gif';    
var laodTime='';
laodTime=$('#newArrivalImage_1').attr('src');

if(typeof laodTime!=='undefined'){
var imglaodUrl=$('#newArrivalImage_1').next().attr('href');
var laodTimeImage =laodTime.replace('124x174','370x400');
$('.bidImage').css({width: "370px",height: "400px"});
$('.bidImage').attr('src',laodTimeImage);
$('.bidImage').parent().attr('href',imglaodUrl);
}
$('body').on('click','.small_image',function(){
$('.small_box').removeAttr('style');
 var imgString=$(this).attr('src');
 var imgStringId=$(this).attr('id');
 var imgUrl=$(this).next().attr('href');
  $('#'+imgStringId).parent().css('box-shadow','0px 0px 0px 1px black inset');
 var laodImage =$(this).attr('stroot')+'common/images/zoomloader.gif';
 var logImageString =imgString.replace('124x174','370x400');

 //$('.bidImage').css({width: "50px",height: "50px",margin:"160px"});
 //$('.bidImage').attr('src',loadUrl);
 
    $('.bidImageLoader').css({width: "50px",height: "50px",margin:"160px"});
    $('.bidImage').hide();
    $('.bidImageLoader').show();
 
    //setTimeout(function(){
        $('.bidImage').attr('src',logImageString)
        $('.bidImage').parent().attr('href',imgUrl)
        $('.bidImage').css({width: "370px",height: "400px",margin:"0px"});
        $('.bidImage').css("margin-top","70px");        
        
        $('.bidImage').css({position:"absolute",opacity: "0"});
        $('.bidImage').show();
        setTimeout(function(){
            $('.bidImageLoader').hide();
            $('.bidImage').css({opacity: "1"});
        }, 1500);
        //setTimeout(function(){  
        //       $('.bidImage').css({width: "370px",height: "400px",margin:"0px"});
        //       $('.bidImage').css("margin-top","70px");
        //}, 2000);
    //}, 1000);

 //$('.bidImage').attr('src',laodImage);
 });  
 //landing page banner manage from here
 
$('#banner-fade').bjqs({
           height      : 268,
           width       : 1134,
           responsive  : true,
           animspeed : 9000
         });
        
});
 $(document).ready(function() {


    var owl7 = $(".owl-demo7");

    owl7.owlCarousel({
        items: 4, //10 items above 1000px browser width
        itemsDesktop: [1000, 4], //5 items between 1000px and 901px
        itemsDesktopSmall: [900, 3], // 3 items betweem 900px and 601px
        itemsTablet: [767, 1], //2 items between 600 and 0;
        itemsMobile: false // itemsMobile disabled - inherit from itemsTablet option

    });

    // Custom Navigation Events
    $(".next7").click(function() {

        owl7.trigger('owl.next');
    })
    $(".prev7").click(function() {
        owl7.trigger('owl.prev');
    })

    var owl8 = $(".owl-demo8");

    owl8.owlCarousel({
        items: 4, //10 items above 1000px browser width
        itemsDesktop: [1000, 4], //5 items between 1000px and 901px
        itemsDesktopSmall: [900, 3], // 3 items betweem 900px and 601px
        itemsTablet: [767, 1], //2 items between 600 and 0;
        itemsMobile: false // itemsMobile disabled - inherit from itemsTablet option

    });

    // Custom Navigation Events
    $(".next8").click(function() {

        owl8.trigger('owl.next');
    })
    $(".prev8").click(function() {
        owl8.trigger('owl.prev');
    })


});

function RemoveProductFromCompare(id){ //alert('test');return false;
    $.post(SITE_ROOT_URL+'common/ajax/ajax_compare.php',{
        action:'RemoveProductFromCompare',
        pid:id
    },function(data){
        $('#ajaxAddToCompare').html(data);
        var gtClass=$('*').hasClass('myCompareUl')?'1':'2';
            if(gtClass=='1'){  //return false;
                $.post(SITE_ROOT_URL + 'common/ajax/ajax_compare.php', {
                    action: 'RemoveProductFromCompareCategory',
                    pid: id,
                }, function(data) { //alert(data);return false;
                    var dSplit=data.split("+++");
                    if(dSplit[0] < 2){
                        $('.compareButton').find('a').addClass('not-active');
                        var checkReduceQ=dSplit[0]>0?'Compare '+'('+dSplit[0]+')':'Compare';
                        dSplit[0]==0?$('.newCompareBox').hide():$('.newCompareBox').show();
                        $('.compareButton').find('a').html(checkReduceQ);
                    }else{
                        $('.compareButton').find('a').html('Compare '+'('+dSplit[0]+')');
                    }
                    
                    $('.myCompareUl').html(dSplit[1]);
                })  
            }
        $('#addtoCompareCheckBox'+id).removeAttr("checked");
        $('#addtoCompareMessage'+id).html('&nbsp; '+REMOVE_SUCCESSFULLY);
        setTimeout(function(){
            $('#addtoCompareMessage'+id).html('&nbsp')
        },4000);
        goToByScroll('ajaxAddToCompare');
    });
}