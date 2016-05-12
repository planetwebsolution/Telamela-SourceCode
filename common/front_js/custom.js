$(document).ready(function(){

$('.tab-container').hide();
	$('.tab-container:first').show();
	$('.weddingTab li:first').addClass('active'); 
  	$('.weddingTab li a').click(function(){
  	$('.weddingTab li').removeClass('active');
	$(this).parent().addClass('active');
	var currentTab = $(this).attr('href');
	$('.tab-container').hide();
	$(currentTab).show();
	return false;
	});
   $('.slider1').bxSlider({
	auto: true,
	pager: true,	
	control:true

});

$('#carousel').flexslider({
    animation: "slide",
    controlNav: false,
    animationLoop: false,
    slideshow: true,
    itemWidth: 123,
    itemMargin: 5,
	minSlides: 1,
		maxSlides: 1,
		moveSlides: 7,
    asNavFor: '#slider'
  });
   
  $('#slider').flexslider({
    animation: "slide",
    controlNav: false,
    animationLoop: false,
    slideshow: true,
    sync: "#carousel"
  });
});