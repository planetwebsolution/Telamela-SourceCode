$(document).ready(function(){       
    
    var addDiv = $('#addinput');
    var i = $('#addinput p').size() + 1;

    $('#addNew').live('click', function() {
        var inputType = $('#frmInputType').val();
                    
        if(inputType=='image'){
            var inputFile = '<input type="file" name="attr_img[]" value="" class="attr_img" size="1" />&nbsp;<input class="color {hash:true,caps:false}" value="66ff00" name="attributeColorCode[]">';
           
        }else if(inputType=='colorpicker'){
            var inputFile = '<input class="color {hash:true,caps:false}" value="66ff00" name="attributeColorCode[]">';
           
        }else{
            var inputFile = '';
        }
                     
        $('#addinput p:last span').html('');
        $('<p>'+inputFile+'<input type="text" name="options[]" value="" class="input1" /><span><a href="#" id="addNew"><img src="images/plus.png" alt="Add more" title="Add more" /></a></span>&nbsp;&nbsp;<a href="#" id="remNew"><img src="images/minus.png" alt="Remove" title="Remove" /></a> </p>').appendTo(addDiv);
        i++;
        jscolor.init();
        return false;
    });

    $('#remNew').live('click', function() {
        
        if( i > 1 ) {
            $(this).parents('p').remove();
            i--;
            $("#addinput p:last span").html('<span><a href="#" id="addNew"><img src="images/plus.png" alt="Add more" title="Add more" /></a></span>');
        }
        return false;
    });
            
    var addDivDrop = $('#addDropDown');
    var j = $('#addDropDown p').size() + 1;
    var asc ='';

    $('#addNewDrop').live('click', function() {
                    
        $('#addDropDown p:last span').html('');
        $.post("ajax.php",{
            action:'ShowCategory'
        },
        function(data){
            asc = data;
            $('<p>'+asc+'&nbsp;<span><a href="#" id="addNewDrop"><img src="images/plus.png" alt="Add more" title="Add more" /></a></span>&nbsp;<a href="#" id="remNewDrop"><img src="images/minus.png" alt="Remove" title="Remove" /></a></p>').appendTo(addDivDrop);
        }
        );

        j++;

        return false;
    });

    $('#remNewDrop').live('click', function() {
        if( j > 2 ) {
            $(this).parents('p').remove();
            j--;
            $("#addDropDown p:last span").html('<span><a href="#" id="addNewDrop"><img src="images/plus.png" alt="Add more" title="Add more" /></a></span>');
        }
        return false;
    });
});

function hidePlusButton(str){
    
    $('#frmAttributeInputValidation').show();
    $('#imageNote').css('display','none');
    
    
    if(str=='text' || str=='textarea' || str=='date'){
        document.getElementById('addinput').innerHTML = '<input type="hidden" name="options[]" id="options" value="" />';
    }else if(str=='image'){
        $('#frmAttributeInputValidation').hide();
        $('#imageNote').css('display','block');
        document.getElementById('addinput').innerHTML='<strong>Input (Options):</strong><p><input type="file" name="attr_img[]" value="" class="attr_img" size="1" />&nbsp;<input class="color {hash:true,caps:false}" value="66ff00" name="attributeColorCode[]">&nbsp;<input type="text" name="options[]" id="options" value="" class="input1" />&nbsp;<span><a href="#" id="addNew"><img src="images/plus.png" alt="Add more" title="Add more" /></a></span></p>';
    }else if(str=='radio' || str=='checkbox' || str=='select' || str=='image'){
         $('#frmAttributeInputValidation').hide();
         document.getElementById('addinput').innerHTML='<strong>Input (Options):</strong><p><input type="text" name="options[]" id="options" value="" class="input1" />&nbsp;<span><a href="#" id="addNew"><img src="images/plus.png" alt="Add more" title="Add more" /></a></span></p>';
    }else if(str=='colorpicker'){
         $('#frmAttributeInputValidation').hide();
         document.getElementById('addinput').innerHTML='<strong>Input (Options):</strong><p><input class="color {hash:true,caps:false}" value="ffffff" name="attributeColorCode[]">&nbsp;<input type="text" name="options[]" id="options" value="" class="input1" />&nbsp;<span><a href="#" id="addNew"><img src="images/plus.png" alt="Add more" title="Add more" /></a></span></p>';
    }else{
        document.getElementById('addinput').innerHTML='<strong>Input (Options):</strong><p><input type="text" name="options[]" id="options" value="" class="input1" />&nbsp;<span><a href="#" id="addNew"><img src="images/plus.png" alt="Add more" title="Add more" /></a></span></p>';

    }
    jscolor.init();
}



var url = window.URL || window.webkitURL;
//var prod_img = document.getElementsByClassName("prod_img");
$(document).ready(function(){
    
    var MIN_ATTR_IMAGE_WIDTH = '35';
    var MIN_ATTR_IMAGE_HEIGHT = '35';
    var MAX_ATTR_IMAGE_WIDTH = '35';
    var MAX_ATTR_IMAGE_HEIGHT = '35';
    
    $('.attr_img').live('change',function(){       
        var dd = $(this);
        var name = dd.attr('name');
        if( this.disabled ){
            alert('Your browser does not support File upload.');
        }else{
            var chosen = this.files[0];
            var image = new Image();
            image.onload = function() {
                if(this.width < MIN_ATTR_IMAGE_WIDTH || this.height < MIN_ATTR_IMAGE_HEIGHT || this.width >MAX_ATTR_IMAGE_WIDTH || this.height > MAX_ATTR_IMAGE_HEIGHT){
                    //alert('Please upload image in between ('+MIN_ATTR_IMAGE_WIDTH+'-'+MAX_ATTR_IMAGE_WIDTH+')px width and ('+MIN_ATTR_IMAGE_HEIGHT+'-'+MAX_ATTR_IMAGE_HEIGHT+')px height!');
                    alert('Please upload image in '+MIN_ATTR_IMAGE_WIDTH+'x'+MAX_ATTR_IMAGE_WIDTH+' px');
                    
                    dd.val('');
                    this.focus();
                }
            };
            image.onerror = function() {
                alert('Not a valid file type: '+ chosen.type);
                dd.val('');
            };
            image.src = url.createObjectURL(chosen);
        }

    });
});