$(function(){
	if((navigator.userAgent.match(/iPhone/i)) || (navigator.userAgent.match(/iPod/i)) || (navigator.userAgent.match(/iPad/i))){
		//$("#header").css('width' , '1024px');         
		$("#header ul.top_listing li.worldwide").css('margin-left', '6px');
		$("#header ul.top_listing li").css('padding', '5px');
		$("#header ul.top_listing li.last").css('padding-right', '0px');
		$("#header ul.top_listing li.worldwide").css('padding-left', '25px');
		$("#menu").css('padding-top', '16px');
		
		$(".search_box .input_box input.input_text").css('cssText', 'background: url("../images/white_strip.gif") repeat-x');
		$(".search_box .input_box input.input_text").css('padding', '0');
		$(".coupon_list .input_box input").css('cssText', 'background: url("../images/wstrip_gray.gif") repeat-x');
		$(".coupon_list .input_box input").css('padding', '0');
		
		$(".product_information .heading").css('height', '32px');
		$(".product_information .heading.blue_strip").css('height', '31px');
		$(".product_information .heading.red_strip").css('height', '31px');
		$(".product_information .heading.blue_strip").css('background-position', '0px -34px');
		$(".product_information .heading.red_strip").css('background-position', '0px -67px');
	}
});
