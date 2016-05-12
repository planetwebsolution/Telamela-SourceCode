          
            $(document).ready(function(){               
                
                $('.drop_down1').sSelect();

                $("#frmProductName").autocomplete(SITE_ROOT_URL+"common/ajax/ajax_wholesaler.php?action=ProductAutocomplete", {
                    width: 425,
                    matchContains: true,
                    selectFirst: false
                });

                $('.sort').click(function(){
                    var order = $(this).attr('order');
                    var col = $(this).attr('col');
                    $('#sort_order').val(order);
                    $('#sort_column').val(col);
                    $('#filter_form').submit();
                });
                
                $("#spButton").click(function() {
                    $('.order_sec').slideToggle('slow');
                });
                
                
            });
