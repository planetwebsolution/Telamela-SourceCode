$(document).ready(function(){
		$('.slider').bxSlider({
			auto:false,
			controls:true,
			pager:false
		});
	//$('.flipFront').hover(function(){
	$('.flipFront').bind("click",function(){
		var elem = $(this);
		if(elem.data('flipped'))
		{
		elem.revertFlip();
		elem.data('flipped',false)
		}
		else
		{
		elem.flip({
				direction:'tb',
				speed: 350,
				onBefore: function(){
					elem.html(elem.siblings('.flipBack').html());
				}
			});
			
			elem.data('flipped',true);
		}
	});
	
});