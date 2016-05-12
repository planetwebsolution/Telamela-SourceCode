
jQuery(document).ready(function(){
    // binds form submission and fields to the validation engine
    //jQuery("#add_edit_product").validationEngine();

    //$('#country0').find('select').sSelect();
    $('#event0').find('select').sSelect();
    $("#countrySelect0").select2();
    var catHtml = $('#cat').html();
    var catName = 'frmCategory_0[]';
    var proName = 'frmProduct_0[]';

    catHtml = catHtml.replace("frmCategory[]",catName);
    catHtml = catHtml.replace("frmProduct[]",proName);


    $('.more_cat').parent().find('ul').append('<li>'+catHtml+'</li>');
    $('.more_cat').parent().find("ul li:last-child").find('select').select2();

    $('.remove_cat').live('click',function(e){
        $(this).parent().remove();
        e.preventDefault();
    });
    $('.remove_event').live('click',function(e){
        $(this).parent().parent().prev().remove();
        $(this).parent().parent().remove();
        e.preventDefault();
    });

    $('.more_cat').live('click',function(e){
        var objMore =  $(this);
        var numRow =  objMore.attr('row');
        var eventId = $('#frmEvent'+numRow).val();
        //var eventId = frmEvent.val();

        $.post('',{
            action:'showEventCategory',
            eventId:eventId,
            numRow:numRow,
            firstCat:'0'
        },function(data){
            objMore.prev().append(data);
            //objMore.parent().find('ul li:last-child').find('select').sSelect();
            objMore.parent().find('ul li:last-child').find('select').select2();
        });

        return false;
    });


    $('.more_fest').click(function(e){
        var rowNum = parseInt($(this).attr('row'));


        var catHtml = $('#cat').html();
        var catName = 'frmCategory_'+rowNum+'[]';
        var proName = 'frmProduct_'+rowNum+'[]';
        catHtml = catHtml.replace("frmCategory[]",catName);
        catHtml = catHtml.replace("frmProduct[]",proName);
        var str ='<li>&nbsp;</li><li id="liId'+rowNum+'"><input type="hidden" name="frmInd[]" value="'+rowNum+'" />';
        str +='<div style="border: 0px solid #ff0000; float: left;"><label>Country<strong>:</strong></label><div class="input_sec input_star"><div class="drop4 dropdown_2" id="country'+rowNum+'"><div class="errors" style="display: block;"></div><select name="frmCountry[]" class="select2-me" id="countrySelect'+rowNum+'" onchange="showEvent(this.value,'+rowNum+')">'+$('#country0').find('select').html()+'</select></div><small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small></div></div>';
        str +='<br/><br/><br/><div style="border: 0px solid #ff0000;  float: left;"><label>Specials/events<strong>:</strong></label><div class="input_sec input_star"><div class="drop4 dropdown_2" id="event'+rowNum+'"><div class="errors" style="display: block;"></div><select name="frmEvent[]" id="frmEvent'+rowNum+'" class="drop_down1" onchange="showDates(this.value,'+rowNum+');"><option value="0">Select Event</option></select></div><small class="star_icon"><img src="common/images/star_icon.png" alt=""/></small></div></div>';
        str +='<br/><br/><br/><div style="border: 0px solid #ff0000;  float: left;"><label>Specials Date<strong>:</strong></label><div class="input_sec"><span style="float: left;margin: 10px 2px 0 0;">From</span><input style="width: 113px; float: left;" type="text" name="fromDate[]" id="fromDate'+rowNum+'" readonly value="" /><span style="float: left;margin: 10px 2px 0 20px;">To</span><input style="width: 113px; float: left;" type="text" name="toDate[]" id="toDate'+rowNum+'" readonly value="" /></div></div>';
        str +='<br/><br/><br/><div class="special_remove_event"><a href="#" class="delete_icon3 remove_event" title="Remove event"></a></div><div class="cat"><ul><li>'+catHtml+'</li></ul><a class="more more_cat" href="#" row="'+rowNum+'"><small>Add more</small> +</a></div>';
        str +='</li>';

        $(this).parent().parent().before(str);
        //$('#country'+rowNum).find('select').sSelect();
        //$('#countrySelect'+rowNum).select2();
        $('#countrySelect'+rowNum).select2();
        $('#event'+rowNum).find('select').sSelect();
        //$('#liId'+rowNum).find('.more_cat').parent().find("ul li:last-child").find('select').sSelect();
        $('#liId'+rowNum).find('.more_cat').parent().find("ul li:last-child").find('select').select2();

        rowNum = rowNum+1;
        $(this).attr('row',rowNum);
        return false;
    });

});

function showEvent(countryId,numRow){
    if(countryId=='0' || countryId==''){
        return false;
    }else{
        $.post('',{
            action:'showEvent',
            countryId:countryId,
            numRow:numRow
        },function(data){ //console.log(data);
            $('#event'+numRow).html(data);
            $('#event'+numRow).find('select').sSelect();
        });
    }
}

function showDates(eventId,numRow){

    if(eventId=='0' || eventId==''){
        $('#fromDate'+numRow).val('');
        $('#toDate'+numRow).val('');
        return false;
    }else{
        $.post('',{
            action:'showEventDate',
            eventId:eventId,
            numRow:numRow
        },function(data){
            var res =data.split('##');
            $('#fromDate'+numRow).val(res[0]);
            $('#toDate'+numRow).val(res[1]);
        });

        $.post('',{
            action:'showEventCategory',
            eventId:eventId,
            numRow:numRow,
            firstCat:'1'
        },function(data){
            $('#liId'+numRow).find('.cat ul').html(data);
            //$('#liId'+numRow).find('ul li:last-child').find('select').sSelect();
            $('#liId'+numRow).find('ul li:last-child').find('select').select2();
        //$('#event'+numRow).find('select').sSelect();

        });
    }
}


function ValidateEventForm(){
    var frmCountry = document.getElementsByName('frmCountry[]');
    var frmEvent = document.getElementsByName('frmEvent[]');
    var err=errorMsg();
    var errP=errorMsgP('This field is required!');

    for (var i = 0; i < frmCountry.length; i++) {

        var objC = $(frmCountry[i]);

        if(frmCountry[i].value==''|| frmCountry[i].value=='0'){

            objC.siblings('.errors').html(err);
            //frmCountry[i].focus();
            //objC.parent().focus();
            goToByScroll(i);
            return false;
        }else{
            objC.siblings('.errors').html('');
        }

        var objE = $(frmEvent[i]);
        if(frmEvent[i].value=='' || frmEvent[i].value=='0'){
            objE.siblings('.errors').html(err);
            goToByScroll(i);
            return false;
        }else{
            objE.siblings('.errors').html('');
        }

        var frmCategory = document.getElementsByName('frmCategory_'+i+'[]');
        var frmProduct = document.getElementsByName('frmProduct_'+i+'[]');
        //alert(frmProduct[0].value);return false;
        for (var j = 0; j < frmCategory.length; j++) {

            //console.log(objCt);
            //alert(frmCategory[j].value);

            var objCt = $(frmCategory[j]);
            if(frmCategory[j].value==0 || frmCategory[j].value==''){
                objCt.siblings('.errors').html(err);

                //frmCategory[i][j].focus();
                //objCt.parent().focus();
                goToByScroll(i);
                return false;
            }else{
                objCt.siblings('.errors').html('');
            }

            var objP = $(frmProduct[j]);
            //alert(objP.className);
           // console.log(objCt);
            if(frmProduct[j].value==''){
                objP.siblings('.errorsP').html(errP);
                goToByScroll(i);
                return false;
            }else if(IsDigits(frmProduct[j].value)==true){
                errP=errorMsgP('Not a valid integer!');
                objP.siblings('.errorsP').html(errP);
                goToByScroll(i);
                return false;
            }else{
                objP.siblings('.errorsP').html('');
            }
        }
    }

}

function goToByScroll(i){

    $('html,body').animate({
        scrollTop: $("#liId"+i).offset().top
    },
    'slow');
}

function IsDigits(str){
    str = str;
    var regDigits = /[^\d]/g;
    return regDigits.test(str);

}
function errorMsg(){
    return '<div class="formError" style="opacity: 0.87; position: absolute; top: 0px; left: 386px; margin-top: -35px;"><div class="formErrorContent">*This field is required!<br></div><div class="formErrorArrow"><div class="line10"><!-- --></div><div class="line9"><!-- --></div><div class="line8"><!-- --></div><div class="line7"><!-- --></div><div class="line6"><!-- --></div><div class="line5"><!-- --></div><div class="line4"><!-- --></div><div class="line3"><!-- --></div><div class="line2"><!-- --></div><div class="line1"><!-- --></div></div></div>';
}
function errorMsgP(str){
    return '<div class="formError" style="opacity: 0.87; position: absolute; top: 0px; left: 168px; margin-top: -27px;"><div class="formErrorContent">*'+str+'<br></div><div class="formErrorArrow"><div class="line10"><!-- --></div><div class="line9"><!-- --></div><div class="line8"><!-- --></div><div class="line7"><!-- --></div><div class="line6"><!-- --></div><div class="line5"><!-- --></div><div class="line4"><!-- --></div><div class="line3"><!-- --></div><div class="line2"><!-- --></div><div class="line1"><!-- --></div></div></div>';
}