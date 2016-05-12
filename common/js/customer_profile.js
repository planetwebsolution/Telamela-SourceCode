
            
            function validateForm(){
                var ctr=0;
                if($('#frmBillingCountry').val()=='0' || $('#frmBillingCountry').val()==''){
                    $('.ErrorfrmBillingCountry').css('display','block');
                    var error = errorMessage();
                    $('.ErrorfrmBillingCountry').html(error);
                    goToByScroll('frmBillingAddressLine1');
                    return false;              
                }else 
                    if($('#frmShippingCountry').val()=='0' || $('#frmShippingCountry').val()==''){                    
                        $('.ErrorfrmShippingCountry').css('display','block');
                        var error = errorMessage();
                        $('.ErrorfrmShippingCountry').html(error);
                        goToByScroll('frmShippingAddressLine1');
                        return false;
                  
                    }
                
            }

            function goToByScroll(id){
                // Remove "link" from the ID
                id = id.replace("link", "");
                // Scroll
                $('html,body').animate({
                    scrollTop: $("#"+id).offset().top
                },
                'slow');
            }

            function errorMessage(){
                return '<div style="opacity: 0.87; position: absolute; top: 180px; margin-top: -213px; left: 395px;" class="formError"><div class="formErrorContent">* This field is required! <br/></div><div class="formErrorArrow"><div class="line10"><!-- --></div><div class="line9"><!-- --></div><div class="line8"><!-- --></div><div class="line7"><!-- --></div><div class="line6"><!-- --></div><div class="line5"><!-- --></div><div class="line4"><!-- --></div><div class="line3"><!-- --></div><div class="line2"><!-- --></div><div class="line1"><!-- --></div></div></div>';
                
            }
