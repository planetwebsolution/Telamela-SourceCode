$(document).ready(function(){
    $('.drop_down1').sSelect();
                
    $('.update_status').change(function(){
        var status = $(this).val();
        var arrIDs=($(this).attr('id')).split('_');
        var ReviewID = arrIDs[0];
        var RateID=arrIDs[1];      
        if(status!=''){
            $.ajax({
                url:SITE_ROOT_URL+'common/ajax/ajax_wholesaler.php',
                data:{
                    id:ReviewID,
                    rateID:RateID,
                    status:status,
                    action:'updateReviewStatus'
                },
                type:'post',
                success:function(data){
                    if(data=='updated'){
                        $('#msg'+ReviewID).html('<div style="margin-bottom: -11px; margin-top: 4px;">'+REVIEW_UPDATE+'</div>');
                        setTimeout(function(){
                            $('#msg'+ReviewID).html('');
                        },2500);
                    }
                }
                      
            });
        }
    });
                  
    $('.red_cross2').click(function(e){
        var arrIDs=($(this).attr('id')).split('_');
        var ReviewID = arrIDs[0];
        var RateID=arrIDs[1]; 
        var tt =$(this);
        //alert(ReviewID);alert(RateID);alert(tt); return false;
        if(confirm(R_U_SURE_DELETE)){
            $.ajax({
                url:SITE_ROOT_URL+'common/ajax/ajax_wholesaler.php',
                data:{
                    id:ReviewID,
                    rateID:RateID,
                    action:'delteReview'
                },
                type:'post',
                success:function(data){
                    if(data=='deleted'){
                        tt.parent().parent().parent().remove();
                    }
                }
                      
            });
        }
        e.preventDefault();
    });
});