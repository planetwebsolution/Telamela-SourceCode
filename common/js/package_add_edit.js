function validatePackageForm() {
    var frmPackageImage = document.getElementById('file1');
    var attr = $('*').hasClass('pattr') ? "1" : "2";
    var attrDetailsId = $('*').hasClass('attrDetailsId') ? "1" : "2";
    var atr = 0;
    var atrOp = 0;
    $('.error_msg_attr').html('');
    $('.error_msg_attrOption').html('');
    $('.error_msg_sameproduct').html('');
    var atrAlertId = '';
    var atrOptionAlertId = '';
    var a = document.getElementsByName("frmProductId[]");
    var erM = 0;
    for (var o = 0; o < a.length; o++) {
        for (var u = o + 1; u < a.length; u++) {
            var pCl1 = a[o].className;
            var pCl2 = a[u].className;
            if (a[u].value == a[o].value) {
                var smpId = $('.' + pCl1).parent().attr('id');
                $('.create_cancle_btn .submit3').before('<div class="error_msg_sameproduct" id="error_msg_sameproduct_' + smpId + '" style="position:absolute"></div>');
                var error = errorMessageSameProduct('Same product cannot be added more than once in a package.', 'error_msg_sameproduct_' + smpId + '');
                $('#error_msg_sameproduct_' + smpId).html(error);
                a[u].focus();
                erM = 1;
                return false;
            }
        }
    }
    if (erM == 0) {
        $('.error_msg_sameproduct').remove();
    }
    if (attr == '1') {
        $('.pattr').each(function(x) {
            x++;
            var gtId = $(this).attr('id');
            if ($('#' + gtId).is(':checked') == false) {
                $('#' + gtId + ':checkbox').focus();
                atr = 1;
                atrAlertId = gtId;
            }
        });
        if (atr == 1) {
            //alert('Please select attribute');
            var laval = atrAlertId.split('_');
            laval = laval[2];
            $('.blank_Attribute_div_' + laval).css('position', 'relative');
            $('#' + atrAlertId).before('<div class="error_msg_attr" id="error_msg_attr_' + atrAlertId + '_' + laval + '" style="position:absolute"></div>');
            var error = errorMessageAttribute('All attributes required', 'error_msg_attr_' + atrAlertId + '_' + laval + '');
            $('#error_msg_attr_' + atrAlertId + '_' + laval).html(error);
            return false;
        }
    }
    if (attrDetailsId == '1') {
        $('.attrDetailsId').each(function(x) {
            var gtId = $(this).attr('id');
            var gtOpId = $('#' + gtId).find('input:radio').attr('class');
            if ($('.' + gtOpId).is(':checked') == false) {
                $('.' + gtOpId + ':radio').focus();
                atrOp = 1;
                atrAlertId = gtId;
            }
        });
        if (atrOp == 1) {
            var laval = atrAlertId.split('_');
            laval = laval[2];
            $('.blank_Attribute_div_' + laval).css('position', 'relative');
            $('#' + atrAlertId).before('<div class="error_msg_attrOption" id="error_msg_attrOption_' + atrAlertId + '_' + laval + '" style="position:absolute"></div>');
            var error = errorMessageAttributeOption('Please select one attribute option from all attributes', 'error_msg_attrOption_' + atrAlertId + '_' + laval + '');
            $('#error_msg_attrOption_' + atrAlertId + '_' + laval).html(error);
            //$('.formErrorContent').css('width','300px');
            return false;
        }
    }

    if (frmPackageImage.value != '') {
        var ff = frmPackageImage.value;

        var exte = ff.substring(ff.lastIndexOf('.') + 1);
        var ext = exte.toLowerCase();
        if (ext != 'jpg' && ext != 'jpeg' && ext != 'gif' && ext != 'png') {
            alert(ACCEPTED_IMAGE_FOR);
            // $('.ErrorProductImg').css('display','block');
            return false;

        }
    }
    if(ImageExist==0)
    {
        var frmDefaultImg = $('#file1').val();
        if(frmDefaultImg==''){
            alert("Please select an image");
            $('#file1').focus();
            return false;
        }
    }
}



function ShowProductForPackage(str, id) {
    var whid = $('#frmWholesalerId').val();

    if (str != 0) {
        var frmPrice = document.getElementsByName('frmPrice[]');
        var total = 0, i, p, a = 0;
        //alert(frmPrice[0].value);
        for (i = 0; i < frmPrice.length; i++) {
            p = parseFloat(frmPrice[i].value);
            if (!isNaN(p)) {
                total = total + p;
            }
        }
        total = total.toFixed(2);
        $('#asc').html(total);
        if (str == 0) {
            $('#product' + id).html('<select name="frmProductId[]" style="width:170px;"><option>Product</option></select>');
        } else {
            $.post("admin/ajax.php", {
                action: 'ShowProductForPackage',
                ajax_request: 'valid',
                catid: str,
                showid: id,
                whid: whid
            }, function(data) {
                $('#product' + id).html(data);
                $('#product' + id).find('select').sSelect();
            });
        }
    }
}

function ShowProductPriceForPackage(str, id, edit, pro) {
    if (str == 0) {
        $('#price' + id).html('<input type="hidden" name="frmPrice[]" class="input1" value="0.00" /><b>0.00</b>');
        var frmPrice = document.getElementsByName('frmPrice[]');
        var total = 0, i, p, a = 0;
        //alert(frmPrice[0].value);
        for (i = 0; i < frmPrice.length; i++) {
            p = parseFloat(frmPrice[i].value);
            if (!isNaN(p)) {
                total = total + p;
            }
        }
        total = total.toFixed(2);
        $('#asc').html(total);
        $(".blank_Attribute_div_" + id).remove();
        $("#price" + id).val('');
    } else {
        $.post("admin/ajax.php", {
            action: 'ShowProductPriceForPackageFront',
            ajax_request: 'valid',
            pid: str,
            showid: id
        }, function(data) {
            var e = data.split('++');
            var x = e[1];
            var y = e[0];

            var select_Attribute_edit = $('*').hasClass('editAttribute_' + pro + '') ? "1" : "2";
            if(select_Attribute_edit==1){
                $('.editAttribute_' + pro).remove();
            }
           
            if (x == 'attr') {
                var select_Attribute2 = $('*').hasClass('blank_Attribute_div_' + id + '') ? "1" : "2";
                if (select_Attribute2 == 2) {
                    $('#price' + id).after('<div class="blank_Attribute_div_' + id + ' blankAt" id="blank_Attribute_div_' + id + '"></div>');
                }
                $("#price" + id).after('<input type="hidden" id="hiddenPrice_' + id + '" value="' + e[2] + '">');

                $(".blank_Attribute_div_" + id).html(y);
                e[2] = parseFloat(e[2]).toFixed(2);
                $("#price" + id).val(e[2]);

            } else {
                $(".blank_Attribute_div_" + id).remove();
                y = parseFloat(y).toFixed(2);
                $('#price' + id).val(y);
            }

            var frmPrice = document.getElementsByName('frmPrice[]');

            var total = 0, i, p, a = 0;
            for (i = 0; i < frmPrice.length; i++) {
                if (frmPrice[i].value != '') {
                    p = parseFloat(frmPrice[i].value);
                    if (!isNaN(p)) {
                        total = total + p;
                    }
                }
            }
            total = total.toFixed(2);

            $('#frmTotalPrice').val(total);
        }
        );
    }
}

function shAttr(i, id, pid, ids) {
    if ($('#' + ids).is(':checked') == true) {
        //$('.blank_Attribute_div_' + i).find('<br>').addClass('sunaina');
        $('.blank_Attribute_div_' + i+' #'+ids).next('br').after('<div id="attrDetailsId_' + ids + '" class="attrDetailsId"></div>');
        $.post("admin/ajax.php", {
            action: "attributeDetails",
            atId: id,
            pid: pid,
            inc: i
        }, function(d) {
            $('#attrDetailsId_' + ids).html(d);
        });
    } else {
        $('#attrDetailsId_' + ids).remove();
    }
}
var addHidValues = 1;
function getPric(pid, ids, inc, p,edit) {    //alert(pid);alert(ids);alert(inc);alert(p); return false;
    var pDivid = edit==''?$('#' + pid).parent().attr('id'):$('#' + pid).parent().attr('class');
    var lavalSelectedPrice = 0;
    if(edit==''){
        $('#' + pDivid + ' input[type="radio"]:checked').each(function(index) {
            lavalSelectedPrice += parseFloat($(this).attr('vl'));
        });
    }else{
        $('.' + pDivid + ' input[type="radio"]:checked').each(function(index) {
            lavalSelectedPrice += parseFloat($(this).attr('vl'));
        });
    }
    //alert(lavalSelectedPrice);return false;
    var pr = $('#hiddenPrice_' + inc).val();
    var nP = parseFloat(pr) + parseFloat(lavalSelectedPrice);
    nP = nP.toFixed(2);
    $('#price' + inc).val(nP);
    var r, a, n = 0;
    var frmPrice = document.getElementsByName('frmPrice[]');
    for (r = 1; r <= frmPrice.length; r++) {
        var inputPrice = $('#price' + r).val() != '' ? $('#price' + r).val() : 0;
        a = parseFloat(inputPrice);
        n += a;
    }
    n = n.toFixed(2);
    //$("#asc").html(n);
    $("#frmTotalPrice").val(n);
}

function errorMessageAttribute(errMsg, id) {
    var errMsg = '* ' + errMsg;
    var pos = $('#' + id).offset().top;
    $('body, html').animate({
        scrollTop: pos
    });

    return '<div style="opacity: 0.87; position: absolute; top: -73px; left: 12px;" class="formError"><div class="formErrorContent">' + errMsg + '<br/></div><div class="formErrorArrow"><div class="line10"><!-- --></div><div class="line9"><!-- --></div><div class="line8"><!-- --></div><div class="line7"><!-- --></div><div class="line6"><!-- --></div><div class="line5"><!-- --></div><div class="line4"><!-- --></div><div class="line3"><!-- --></div><div class="line2"><!-- --></div><div class="line1"><!-- --></div></div></div>';

}

function errorMessageAttributeOption(errMsg, id) {
    var errMsg = '* ' + errMsg;
    var pos = $('#' + id).offset().top;
    pos = parseInt(pos) + parseInt(300);
    console.log(pos);
    //alert(pos);
    $('body').animate({
        scrollTop: pos
    });
    return '<div style="opacity: 0.87; position: absolute; top: -68px; left: 94px;" class="formError"><div class="formErrorContent">' + errMsg + '<br/></div><div class="formErrorArrow"><div class="line10"><!-- --></div><div class="line9"><!-- --></div><div class="line8"><!-- --></div><div class="line7"><!-- --></div><div class="line6"><!-- --></div><div class="line5"><!-- --></div><div class="line4"><!-- --></div><div class="line3"><!-- --></div><div class="line2"><!-- --></div><div class="line1"><!-- --></div></div></div>';
}

function errorMessageSameProduct(errMsg, id) {
    var errMsg = '* ' + errMsg;
    var pos = $('#' + id).offset().top;
    pos = parseInt(pos) + parseInt(300);
    console.log(pos);
    //alert(pos);
    $('body').animate({
        scrollTop: pos
    });
    return '<div style="opacity: 0.87; position: absolute; top: -104px; left: 0px;" class="formError"><div class="formErrorContent">' + errMsg + '<br/></div><div class="formErrorArrow"><div class="line10"><!-- --></div><div class="line9"><!-- --></div><div class="line8"><!-- --></div><div class="line7"><!-- --></div><div class="line6"><!-- --></div><div class="line5"><!-- --></div><div class="line4"><!-- --></div><div class="line3"><!-- --></div><div class="line2"><!-- --></div><div class="line1"><!-- --></div></div></div>';
}

$(document).ready(function() {
    $('#file1').customFileInput1();
    $('input[numericOnly="yes"]').bind('keypress', function(event) {
        var regex = new RegExp("^[\!\@\#\$\%\^\&\*\(\)\'\"\;\:a-zA-Z]+$");
        var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
        if (regex.test(key)) {
            event.preventDefault();
            return false;
        }
    });
    
    $('#cropAfterCrop').live('click',function(){ 
       var obj =$(this);  
       var getImageSrc =obj.parent().find('.croppedImg').attr('src');
       var getImageName =getImageSrc.toString().replace('common/uploaded_files/images/temp/','');
       getImageName=$.trim(getImageName);
       var getCount=obj.attr('cls'); 
       getCount=getCount.match(/\d/g);
       getCount = getCount.join("");
       //alert(getCount);return false;
       $.post(SITE_ROOT_URL+"common/ajax/ajax_uploader.php",{
            action:'savePackageImageAfterCrop',
            imageSrc:getImageSrc,
            imageName:getImageName
        },
        function(data)
        {
           
         $('#cropimg_'+getCount).hide();
         $('#after_cropimg_'+getCount).val(getImageName);
         $('.myImgSpan').html('<img src="'+data+'"/>');
     
         parent.jQuery.fn.colorbox.close();
            
        });
       //alert(getImageSrc);return false;
    });


    $('#frmPackageName').on('blur', function() {
        var pk = $(this).val();
        var package = $(this).attr('package');
        var oldP = $(this).attr('oldP');
        $.post(SITE_ROOT_URL + "common/ajax/ajax_wholesaler.php", {
            action: 'varifyDuplicatePackage',
            pk: pk,
            package: package
        }, function(d) {
            if (d == 1) {
                $('#frmPackageName').val('');
                var existPackageMessage = $('*').hasClass('existPackage') ? 1 : 2;
                if (existPackageMessage == 2) {
                    $('#frmPackageName').before('<div class="existPackage"><span style="color:red;font-size:12px">This package name already exists.</span></div>');
                }
                setTimeout(function() {
                    if (oldP != '') {
                        $('#frmPackageName').val(oldP);
                    }
                    $('.existPackage').remove();
                }, 5000);
            }

        });
    });

    $('.drop_down1').sSelect();

    $('.delete_icon1').live('click', function(e) {
        $(this).parent().remove();
        var frmPrice = document.getElementsByName('frmPrice[]');
        var total = 0, i, p, a = 0;
        for (i = 0; i < frmPrice.length; i++) {
            p = parseFloat(frmPrice[i].value);
            if (!isNaN(p)) {
                total = total + p;
            }
        }
        total = total.toFixed(4);
        $('#frmTotalPrice').val(total);
        e.preventDefault();
    });
    $('.add_product').click(function(e) { //alert('test'); return false;
        var thiselement = $(this);
        var frmPrice = document.getElementsByName('frmPrice[]');
        var elementCounter = frmPrice.length;
        var nextelement = elementCounter + 1;
        var html = '';
        // $('.submit3').trigger('click');
        //$('.offer_price').find('.formError').css('margin-top','70px');
        //$('#frmPackageName').prev('.formError').css('margin-top','83px');
        $.post("admin/ajax.php", {
            action: 'ShowCategoryForPackageFront',
            ajax_request: 'valid',
            row: nextelement
        }, function(data) {
            html += '<li><div class="edit_left_sec edit_left_sec1"><h3> ' + SEL_PRODUCT + nextelement + '<span class="price">' + ORG_PRICE + '</span></h3>';
            html += '<div class="drop3 dropdown_2">' + data;
            html += '</div><div class="drop1 dropdown_4 dropdown_4_txt " id="product' + nextelement + '"><select onchange="ShowProductPriceForPackage(this.value,' + nextelement + ')" name="frmProductId[]" class="drop_down1"><option>Select Product</option></select>';
            html += '</div><input id="price' + nextelement + '" readonly="true" name="frmPrice[]" class="validate[required]" type="text" value=""/></div><a href="#" class="delete_icon1"></a></li>';
            thiselement.parent().before(html);
            thiselement.parent().prev().find('select').last().sSelect();
            thiselement.parent().prev().find('select').first().select2();

        });
        e.preventDefault();
    });
});