
var noMoreMsg = '<p>No more result found !</p>';
var processingMsg = '<img src="'+SITE_ROOT_URL+'common/images/loader100.gif"/>';
    
$(document).ready(function(){
    $(".offPriceText").rotate(330);
    $('.slider_inner').bxSlider({
        auto:true
    });
    $('.my_dropdown').sSelect(); 
   
    lazyload();  
});

function showLandingProducts(sortby){

    var loaditem = '<div class="no_product_special"><img src="'+SITE_ROOT_URL+'common/images/loader100.gif" title="Loading..." alt="Loading..." /></div>';

    var cid = $('#cid').val();

    $('#marker-end').attr('limit','0');
    
    $('#marker-end').html('');
    $('#landingProduct').html(loaditem);
    $('#marker-end').attr('loaded',null);
    $('#marker-end').attr('processing',null);
    
    $.post(SITE_ROOT_URL+'common/ajax/ajax_landing.php',{
        action:'showLandingProducts',
        cid:cid,
        sortby:sortby,
        limit:$('#marker-end').attr('limit')
    },function(data){
        $('#landingProduct').html(data);
        var num = $(data).filter('li').size();
        if(num<pageLimit){            
            $('#marker-end').html(noMoreMsg);
            $('#marker-end').attr('data-end','1');            
        }else{
            $('#marker-end').html(processingMsg);
            $('#marker-end').attr('data-end','0');
            $('#marker-end').attr('limit',pageLimit);
        }
        
        lazyload();
         
        var totalLi = $('#landingProduct li').length;
        showInit(totalLi,num);
        
    });
}

function lazyload(){
    $(window).scroll(function() {
        //check if your div is visible to user
        // CODE ONLY CHECKS VISIBILITY FROM TOP OF THE PAGE
        if($('#marker-end').length>0){
        if ($(window).scrollTop() + $(window).height() >= $('#marker-end').offset().top) {
          
            if(!$('#marker-end').attr('processing')) {   
                
                $('#marker-end').attr('processing',true);                
                if(!$('#marker-end').attr('loaded')) {                   
                    //not in ajax.success due to multiple sroll events
                    $('#marker-end').attr('loaded', true);                
                
                    var cid = $('#cid').val();
                    var sortby = $('#sortby').val();
                    var dataEnd = $('#marker-end').attr('data-end');

                    if(dataEnd=='0'){
                        var limit = $('#marker-end').attr('limit');
                        var nextlimit = parseInt(limit)+pageLimit;
                        $('#marker-end').attr('limit',nextlimit);

                        $.ajax({
                            url: SITE_ROOT_URL+'common/ajax/ajax_landing.php',
                            dataType: "html",
                            type:'GET',
                            data:'action=showLandingProducts&cid='+cid+'&sortby='+sortby+'&limit='+limit
                        }).done(function (responseText) {
                            // add new elements
                            var num = $(responseText).filter('li').size();
                  
                            if(num<pageLimit){
                                $('#marker-end').html(noMoreMsg);
                                $('#marker-end').attr('data-end','1');                            
                            }else{
                                $('#marker-end').attr('loaded', null);
                            }
                     
                            $('#landingProduct').append($.parseHTML(responseText));                   
                            $('#marker-end').attr('processing',null);
                            var totalLi = $('#landingProduct li').length;
                            equalHeight($(".sec"));
                            showInit(totalLi,num);                    
                        });
                    }else{
                        $('#marker-end').html(noMoreMsg);
                    }
                }
            }
        } 
    }
    });
}
function equalHeight(group) { 
        var tallest = 0;
        group.each(function() {
            var thisHeight = $(this).height();
            if(thisHeight > tallest) {
                tallest = thisHeight;
            }
        });
        //alert(tallest);
        $(".sec").height(tallest);
    }
function showInit(totalLi,num){
    $(".offPriceText").rotate(330);
    
    for(var i=totalLi-num+1; i<=totalLi;i++){
        $('#landingProduct li:nth-child('+i+') .thumb_img').hover(function(){                           
            $(this).find(".miniBoxHoverSpecial").fadeIn(200);
        //return false
        });
                        
        $('#landingProduct li:nth-child('+i+') .thumb_img').mouseleave(function(){                             
            $(this).find(".miniBoxHoverSpecial").fadeOut(200);
        //return false
        });
    }
}