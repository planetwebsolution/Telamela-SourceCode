jQuery(function($){

    //cropInit();
     
    });


function cropInit(){
    var jcrop_api;
    $(document).on('mouseover','.target',function(){
         //alert($(this).html());
        var dd = $(this);
      
        dd .Jcrop({
            minSize: [MIN_PRODUCT_IMAGE_WIDTH, MIN_PRODUCT_IMAGE_HEIGHT], // min crop size
            //maxSize:[MIN_PRODUCT_IMAGE_WIDTH, MIN_PRODUCT_IMAGE_HEIGHT],
            setSelect: [ 0, 0, MIN_PRODUCT_IMAGE_WIDTH, MIN_PRODUCT_IMAGE_HEIGHT],
//            addClass: 'jcrop-dark',
//            jcrop_api:setOptions({ allowResize: false }),
            onChange:  function (c) {   
                
                showCoords(c,dd);
                showPreview(c);
            },
            onSelect: function (c) {   
                //console.log(c);
                showCoords(c,dd);
                showPreview(c);
            }
        //onRelease:  clearCoords
        },function(){
          
            jcrop_api = this;
        //alert($(jcrop_api).attr('id'));
          
        });
    });
}


function showPreview(coords)
{
        //console.log(coords);
	var rx = 85 / coords.w;
	var ry = 67 / coords.h;
        
        var preview = $('#CropDynId').val();
        
        photoX = $("#target_"+preview).width();
        photoY = $("#target_"+preview).height();
        
        rx = (rx == 0) ? 1 : rx;
        ry = (ry == 0) ? 1 : ry;
    
        //console.log(photoX);
        //console.log(photoY);
        
        //console.log('preview_'+preview);
	$('#preview_'+preview).css({
                width: Math.round(rx * photoX) + 'px',
		height: Math.round(ry * photoY) + 'px',
		marginLeft: '-' + Math.round(rx * coords.x) + 'px',
		marginTop: '-' + Math.round(ry * coords.y) + 'px'
	});
}





// Simple event handler, called from onChange and onSelect
// event handlers, as per the Jcrop invocation above
function showCoords(c,dd)
{
    
    
    //alert(dd.siblings('.x1').val());
    dd.siblings('.x1').val(c.x);
    dd.siblings('.y1').val(c.y);
    dd.siblings('.x2').val(c.x2);
    dd.siblings('.y2').val(c.y2);
// dd.siblings('.w').val(c.w);
//dd.siblings('.h').val(c.h);
};

function clearCoords()
{
    $('.coords input').val('');
};


