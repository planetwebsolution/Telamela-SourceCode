// show the jquery block ui popup
function showPopUp(id)
{
  $.blockUI.defaults.css = {};
  var browser = navigator.appName;   			
  if(browser == MICRO_INT_EXP)
  {	
	$.blockUI({message: $("#"+id),  centerY: true, centerX: true, css: {top:'40%', left:'45%'}});
  }
  else
  {
	$.blockUI({message: $("#"+id)});  
  }
}



function hidePopUp(formId)
{
  $.unblockUI();
  resetForm(formId);	
}


var popupStatus = 0;  
function loadPopup(argID, argProductID)
{  
	/*if(popupStatus==0){  
		$("#backgroundPopup").css({"opacity": "0.7" });  
		$("#backgroundPopup").fadeIn("slow");  	
		$("#"+argID).fadeIn("slow");  
		popupStatus = 1;  
	}*/
	$('#sendMailProductID').val(argProductID);
	$.blockUI.defaults.css = {};
	var browser = navigator.appName;   			
	if(browser == MICRO_INT_EXP)
	{
	  //alert('in if');
	$.blockUI({message: $("#"+argID),  centerY: true, centerX: true, css: {top:'40%', left:'45%'}});
	}
	else
	{
	 
	$.blockUI({message: $("#"+argID)});
	}
} 




function disablePopup(argID){  
	/*if(popupStatus==1){  
		$("#backgroundPopup").fadeOut("slow");  
		$("#"+argID).fadeOut("slow");  
		popupStatus = 0;  
	}  */
	$.unblockUI();
	
	if((navigator.userAgent.match(/Android/i))||(navigator.userAgent.match(/iPhone/i)) || (navigator.userAgent.match(/iPod/i)) || (navigator.userAgent.match(/iPad/i)))
	{	
		$("body, html").css('overflow','visible');		
	}
}   

function centerPopup(argID){
 // alert(argID);
	var windowWidth = document.documentElement.clientWidth;  
	var windowHeight = document.documentElement.clientHeight;  
	var popupHeight = $("#"+argID).height();  
	var popupWidth = $("#"+argID).width();  
	$("#"+argID).css({"position": "absolute",  "top": windowHeight/2-popupHeight/2,  "left": windowWidth/2-popupWidth/2 });  
	$("#backgroundPopup").css({ "height": windowHeight });  
	if((navigator.userAgent.match(/Android/i))||(navigator.userAgent.match(/iPhone/i)) || (navigator.userAgent.match(/iPod/i)) || (navigator.userAgent.match(/iPad/i)))
	{	
		$("body, html").css('overflow','hidden');		
	}	
}


function centerPopup_newarrival(argID,argProductID,argProductSizeID,argQuantity,argProductName,argProductFor,argCategoryID,argBrandID,argisGiftProduct,argProductSizeData,argProductCondition,argProductColor){
  
  //alert(argID+">>"+argProductID+">>"+argProductSizeID+">>"+argQuantity+">>"+argProductName+">>"+argProductFor+">>"+argCategoryID+">>"+argBrandID+">>"+argisGiftProduct+">>"+argProductSizeData);
  
	var windowWidth = document.documentElement.clientWidth;  
	var windowHeight = document.documentElement.clientHeight;  
	var popupHeight = $("#"+argID).height();  
	var popupWidth = $("#"+argID).width();  
	$("#"+argID).css({"position": "absolute",  "top": windowHeight/2-popupHeight/2,  "left": windowWidth/2-popupWidth/2 });  
	$("#backgroundPopup").css({ "height": windowHeight });
	
	$('#productID').val(argProductID);
	$('#productSizeID').val(argProductSizeID);
	$('#productQuantity').val(argQuantity);
	$('#productName').val(argProductName);
	$('#sizeData').val(argProductSizeData);
	//$('#productBrand').val(argBrandID);
	$('#productBrandID').val(argBrandID);
	$('#productCategoryID').val(argCategoryID);
	$('#giftSet').val(argisGiftProduct);
	$('#Productcondition').val(argProductCondition);
	$('#ProductColor').val(argProductColor);
}

///////////////Function For for out of stock buy now///////
function centerPopup_buynow(argID,argProductID,argProductSizeID,argQuantity,argProductName,argProductFor,argCategoryID,argBrandID,argisGiftProduct,argProductSizeData,argproductPrice){
  
  //alert(argID+">>"+argProductID+">>"+argProductSizeID+">>"+argQuantity+">>"+argProductName+">>"+argProductFor+">>"+argCategoryID+">>"+argBrandID+">>"+argisGiftProduct+">>"+argProductSizeData+">>"+argproductPrice);
 //return false;
	var windowWidth = document.documentElement.clientWidth;  
	var windowHeight = document.documentElement.clientHeight;  
	var popupHeight = $("#"+argID).height();  
	var popupWidth = $("#"+argID).width();  
	$("#"+argID).css({"position": "absolute",  "top": windowHeight/2-popupHeight/2,  "left": windowWidth/2-popupWidth/2 });  
	$("#backgroundPopup").css({ "height": windowHeight });
	
	$('#productID').val(argProductID);
	//$('#productSizeID').val(argProductSizeID);
	$('#productQuantity').val(argQuantity);
	$('#productName').val(argProductName);
	$('#sizeData').val(argProductSizeData);
	//$('#productBrand').val(argBrandID);
	$('#productBrandID').val(argBrandID);
	$('#productCategoryID').val(argCategoryID);
	$('#giftSet').val(argisGiftProduct);
	$('#ProductUniquePrice').val(argproductPrice);
}


function shareFavoritePerfumePopup(argID){
 
	var windowWidth = document.documentElement.clientWidth;  
	var windowHeight = document.documentElement.clientHeight;  
	var popupHeight = $("#"+argID).height();  
	var popupWidth = $("#"+argID).width();  
	$("#"+argID).css({"position": "absolute",  "top": windowHeight,  "left": windowWidth/2-popupWidth/2 });  
	$("#backgroundPopup").css({ "height": windowHeight });  
}

$(document).ready(function(){  
	/*$(".popupbutton").click(function(){  
		centerPopup();  
		loadPopup();  
	});  
	
	$(".close_btn").click(function(){ 
	disablePopup();  
	});  
	
	$("#backgroundPopup").click(function(){  
		disablePopup();  
	});
	
	//Press Escape event!  
	$(document).keypress(function(e){  
		if(e.keyCode==27 & popupStatus==1){  
			disablePopup();  
		}  
	}); */
});

function mailForItemRequest(varProductID,code,name,brand)
{
  var sizeid=$('#cmbProductSizeID').val();
  $('.selve').hide();
   $('.loadingmailstatus').show();
  var data = 'varProductId=' +varProductID+ '&sizeid=' +sizeid+ '&productCode=' +code+ '&productname=' +name+ '&productBrand=' +brand+ '&frmProductRequest=yes';
  
   $.ajax({
                type:'POST',
                url: 'category_list_action.php',
                data: data,  
                success: function(data){
		 if(data=='')
		 {
		  alert(POST_ALREADY);
		  $('.loadingmailstatus').hide();
		  $('.selve').show();
		 }
		 else{
		  $('.loadingmailstatus').hide();
		  $('.selve').show();
                  
		 $('#statusmessage').html('<img src="common/images/green_alert_top.jpg" alt=""  class="left" /><div class="mid">'+data+'</div><img src="common/images/green_alert_bottom.jpg" alt=""  class="left" />');
		 return false;
		 }
                        //$("#response").html(data);                                                                                                    

                }
             }); 
}