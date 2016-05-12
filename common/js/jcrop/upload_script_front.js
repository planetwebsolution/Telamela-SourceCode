$(function()
    {
        // Variable to store your files
        var files;
        var url = window.URL || window.webkitURL;
        // Add events
        //Cal('input[type=file]').live('change', prepareUpload);
        $('.file_upload').live('change', prepareUpload);
        $('.file_upload_attr').live('change', prepareUploadAttr);
       
        $('.file_upload_multi').live('change', prepareUploadMultiProducts);
        $('.file_upload_attr_multi').live('change', prepareUploadAttrMultiProducts);
          
        // $('.file_upload_multi').live('change', prepareUploadMultiProducts);
        //$('.file_upload_attr_multi').live('change', prepareUploadAttrMultiProducts);
        //$('form').on('submit', uploadFiles);

        // Grab the files and set them to our variable
        function prepareUpload(event){
            var obj = $(this);
            files = event.target.files;
            
            var chosen = this.files[0];
            if(chosen.name==''){
                return false;
            }
            obj.parent().siblings('.responce').html('<div>uploading..................</div>');
            var image = new Image();
            image.onload = function() {
                if (this.height < MIN_PRODUCT_IMAGE_HEIGHT || this.width < MIN_PRODUCT_IMAGE_WIDTH){
                    //alert('Please upload image in between ('+MIN_PRODUCT_IMAGE_WIDTH+'-'+MAX_PRODUCT_IMAGE_WIDTH+')px width and ('+MIN_PRODUCT_DETAIL_IMAGE_HEIGHT+'-'+MAX_PRODUCT_IMAGE_HEIGHT+')px height!');
                    //dd.parent().find('.image_error').val('0');
                    obj.parent().siblings('.responce').html('<div class="red">Please upload image in between ('+MIN_PRODUCT_IMAGE_WIDTH+')px width and ('+MIN_PRODUCT_IMAGE_HEIGHT+')px height!</div>');
                    // obj.focus();
                    obj.val('');
                    obj.siblings('.customfile1-feedback').html('No file selected...');
                    return false;
                }
                else
                {
                    uploadFiles(event,obj);
                }
            }

            image.onerror = function() {
                //alert('Not a valid file type: '+ chosen.type);
                obj.parent().siblings('.responce').html('<div class="red">Not a valid file type: '+ chosen.type+'</div>');
                obj.val('');
                obj.siblings('.customfile1-feedback').html('No file selected...');

            }
            image.src = url.createObjectURL(chosen);
        }

        // Catch the form submit and upload the files
        function uploadFiles(event,obj){
          
            if($("input:radio[name=default]").is(':checked')){
                var deflt = 0;
            }else{
                var deflt = 1;
            }           
            event.stopPropagation(); // Stop stuff happening
            event.preventDefault(); // Totally stop stuff happening

            // START A LOADING SPINNER HERE

            // Create a formdata object and add the files
            var data = new FormData();
            $.each(files, function(key, value)
            {

                data.append(key, value);
            });

            $.ajax({
                url: 'common/ajax/ajax_uploader.php?action=uploadProductImage&deflt='+deflt,
                type: 'POST',
                data: data,
                cache: false,
                //dataType: 'json',
                processData: false, // Don't process the files
                contentType: false, // Set content type to false as jQuery will tell the server its a query string request
                success: function(data, textStatus, jqXHR){
                    obj.parent().siblings('.responce').html(data);
                    cropInit();
                /*
                    if(typeof data.error === 'undefined')
                    {
                        // Success so call function to process the form
                        //submitForm(event, data,obj);
                        obj.siblings('.responce').html(data.response);
                        cropInit();

                    }
                    else
                    {
                        // Handle errors here
                        console.log('ERRORS: ' + data.error);
                    }
                    */
                },
                error: function(jqXHR, textStatus, errorThrown){
                    obj.parent().siblings('.responce').html(textStatus);
                // Handle errors here
                //
                //  console.log('ERRORS: ' + textStatus);
                // STOP LOADING SPINNER
                }
            });
        }

        function submitForm(event, data,obj){
            // Create a jQuery object from the form
            $form = $(event.target);

            // Serialize the form data
            var formData = $form.serialize();

            // You should sterilise the file names
            $.each(data.files, function(key, value)
            {
                formData = formData + '&filenames[]=' + value;
            });

            $.ajax({
                url: 'submit.php',
                type: 'POST',
                data: formData,
                cache: false,
                dataType: 'json',
                success: function(data, textStatus, jqXHR)
                {
                    if(typeof data.error === 'undefined')
                    {
                        // Success so call function to process the form
                        console.log('SUCCESS: ' + data.success);


                    }
                    else
                    {
                        // Handle errors here
                        console.log('ERRORS: ' + data.error);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown)
                {
                    // Handle errors here
                    console.log('ERRORS: ' + textStatus);
                },
                complete: function()
                {
                //obj.siblings('div').html(data.textStatus);
                // STOP LOADING SPINNER
                }
            });
        }


        // Grab the files and set them to our variable
        function prepareUploadAttr(event){

            var obj = $(this);
            files = event.target.files;
            
            var chosen = this.files[0];
            if(chosen.name==''){
                return false;
            }
            obj.parent().siblings('.responce').html('<div>uploading..................</div>');
            var image = new Image();
            image.onload = function() {
                if (this.height < MIN_PRODUCT_IMAGE_HEIGHT || this.width < MIN_PRODUCT_IMAGE_WIDTH){
                    //alert('Please upload image in between ('+MIN_PRODUCT_IMAGE_WIDTH+'-'+MAX_PRODUCT_IMAGE_WIDTH+')px width and ('+MIN_PRODUCT_DETAIL_IMAGE_HEIGHT+'-'+MAX_PRODUCT_IMAGE_HEIGHT+')px height!');
                    //dd.parent().find('.image_error').val('0');
                    obj.parent().siblings('.responce').html('<div class="red">Please upload image in between ('+MIN_PRODUCT_IMAGE_WIDTH+')px width and ('+MIN_PRODUCT_IMAGE_HEIGHT+')px height!');
                    // obj.focus();
                    obj.val('');
                    obj.siblings('.customfile1-feedback').html('No file selected...');
                    return false;
                }
                else
                {
                    uploadFilesAttr(event,obj);
                }
            }

            image.onerror = function() {
                //alert('Not a valid file type: '+ chosen.type);
                obj.parent().siblings('.responce').html('<div class="red">Not a valid file type: '+ chosen.type+'</div>');
                obj.val('');
                obj.siblings('.customfile1-feedback').html('No file selected...');

            }
            image.src = url.createObjectURL(chosen);
        }

        // Catch the form submit and upload the files
        function uploadFilesAttr(event,obj){
            var optid = obj.parent().parent().siblings('.imagetype').val();
            event.stopPropagation(); // Stop stuff happening
            event.preventDefault(); // Totally stop stuff happening

            // START A LOADING SPINNER HERE

            // Create a formdata object and add the files
            var data = new FormData();
            $.each(files, function(key, value)
            {

                data.append(key, value);
            });

            $.ajax({
                url: 'common/ajax/ajax_uploader.php?action=uploadProductImageAttr&optid='+optid,
                type: 'POST',
                data: data,
                cache: false,
                //dataType: 'json',
                processData: false, // Don't process the files
                contentType: false, // Set content type to false as jQuery will tell the server its a query string request
                success: function(data, textStatus, jqXHR){
                    //alert(data);
                    obj.parent().siblings('.responce').html(data);
                    cropInit();
                /*
                    if(typeof data.error === 'undefined')
                    {
                        // Success so call function to process the form
                        //submitForm(event, data,obj);
                        obj.siblings('.responce').html(data.response);
                        cropInit();

                    }
                    else
                    {
                        // Handle errors here
                        console.log('ERRORS: ' + data.error);
                    }
                    */
                },
                error: function(jqXHR, textStatus, errorThrown){
                    obj.parent().siblings('.responce').html(textStatus);
                // Handle errors here
                //
                //  console.log('ERRORS: ' + textStatus);
                // STOP LOADING SPINNER
                }
            });
        }
        
        
        
        // Grab the files and set them to our variable
        function prepareUploadMultiProducts(event){
           
            var obj = $(this);
            files = event.target.files;            
            
            var chosen = this.files[0];
            if(chosen.name==''){
                return false;
            }
            obj.parent().siblings('.responce').html('<div>uploading..................</div>');
            var image = new Image();
            image.onload = function() {
                if (this.height < MIN_PRODUCT_IMAGE_HEIGHT || this.width < MIN_PRODUCT_IMAGE_WIDTH){
                    //alert('Please upload image in between ('+MIN_PRODUCT_IMAGE_WIDTH+'-'+MAX_PRODUCT_IMAGE_WIDTH+')px width and ('+MIN_PRODUCT_DETAIL_IMAGE_HEIGHT+'-'+MAX_PRODUCT_IMAGE_HEIGHT+')px height!');
                    //dd.parent().find('.image_error').val('0');
                    obj.parent().siblings('.responce').html('<div class="red">Please upload image in between ('+MIN_PRODUCT_IMAGE_WIDTH+')px width and ('+MIN_PRODUCT_IMAGE_HEIGHT+')px height!</div>');
                    // obj.focus();
                    obj.val('');
                    obj.siblings('.customfile1-feedback').html('No file selected...');
                    return false;
                }
                else
                {
                    uploadFilesMultiProducts(event,obj);
                }
            }

            image.onerror = function() {
                //alert('Not a valid file type: '+ chosen.type);
                obj.parent().siblings('.responce').html('<div class="red">Not a valid file type: '+ chosen.type+'</div>');
                obj.val('');
                obj.siblings('.customfile1-feedback').html('No file selected...');

            }
            image.src = url.createObjectURL(chosen);
        }
        
        
        // Catch the form submit and upload the files
        function uploadFilesMultiProducts(event,obj){
            var rownum = obj.parent().parent().parent().attr('id');          
           
            if(obj.parent().parent().parent().find("input:radio[name=default]").is(':checked')){
                var deflt = 0;
            }else{
                var deflt = 1;
            }
            
            event.stopPropagation(); // Stop stuff happening
            event.preventDefault(); // Totally stop stuff happening

            // START A LOADING SPINNER HERE

            // Create a formdata object and add the files
            var data = new FormData();
            $.each(files, function(key, value)
            {

                data.append(key, value);
            });

            $.ajax({
                url: 'common/ajax/ajax_uploader.php?action=uploadProductImage&deflt='+deflt+'&rowNum='+rownum,
                type: 'POST',
                data: data,
                cache: false,
                //dataType: 'json',
                processData: false, // Don't process the files
                contentType: false, // Set content type to false as jQuery will tell the server its a query string request
                success: function(data, textStatus, jqXHR){
                    obj.parent().siblings('.responce').html(data);
                    cropInit();
                    var hit = parseInt($('.jspContainer').css('height'))+70+'px';                                                               
                    $('.jspContainer').css('height',hit);
                /*
                    if(typeof data.error === 'undefined')
                    {
                        // Success so call function to process the form
                        //submitForm(event, data,obj);
                        obj.siblings('.responce').html(data.response);
                        cropInit();

                    }
                    else
                    {
                        // Handle errors here
                        console.log('ERRORS: ' + data.error);
                    }
                    */
                },
                error: function(jqXHR, textStatus, errorThrown){
                    obj.parent().siblings('.responce').html(textStatus);
                // Handle errors here
                //
                //  console.log('ERRORS: ' + textStatus);
                // STOP LOADING SPINNER
                }
            });
        }
        
        
        
        // Grab the files and set them to our variable
        function prepareUploadAttrMultiProducts(event){

            var obj = $(this);
            files = event.target.files;
            
            var chosen = this.files[0];
            if(chosen.name==''){
                return false;
            }
            obj.siblings('.responce').html('<div>uploading..................</div>');
            var image = new Image();
            image.onload = function() {
                if (this.height < MIN_PRODUCT_IMAGE_HEIGHT || this.width < MIN_PRODUCT_IMAGE_WIDTH){
                    //alert('Please upload image in between ('+MIN_PRODUCT_IMAGE_WIDTH+'-'+MAX_PRODUCT_IMAGE_WIDTH+')px width and ('+MIN_PRODUCT_DETAIL_IMAGE_HEIGHT+'-'+MAX_PRODUCT_IMAGE_HEIGHT+')px height!');
                    //dd.parent().find('.image_error').val('0');
                    obj.parent().siblings('.responce').html('<div class="red">Please upload image in between ('+MIN_PRODUCT_IMAGE_WIDTH+')px width and ('+MIN_PRODUCT_IMAGE_HEIGHT+')px height!');
                    // obj.focus();
                    obj.val('');
                    obj.siblings('.customfile1-feedback').html('No file selected...');
                    return false;
                }
                else
                {
                    uploadFilesAttrMultiProducts(event,obj);
                }
            }

            image.onerror = function() {
                //alert('Not a valid file type: '+ chosen.type);
                obj.siblings('.responce').html('<div class="red">Not a valid file type: '+ chosen.type+'</div>');
                obj.val('');
                obj.siblings('.customfile1-feedback').html('No file selected...');

            }
            image.src = url.createObjectURL(chosen);
        }

        // Catch the form submit and upload the files
        function uploadFilesAttrMultiProducts(event,obj){
            
            var optid = obj.parent().siblings('.imagetype').val();
            var rowNum = obj.parent().attr('id');
           
            
            event.stopPropagation(); // Stop stuff happening
            event.preventDefault(); // Totally stop stuff happening

            // START A LOADING SPINNER HERE

            // Create a formdata object and add the files
            var data = new FormData();
            $.each(files, function(key, value)
            {

                data.append(key, value);
            });

            $.ajax({
                url: 'common/ajax/ajax_uploader.php?action=uploadProductImageAttr&optid='+optid+'&rowNum='+rowNum,
                type: 'POST',
                data: data,
                cache: false,
                //dataType: 'json',
                processData: false, // Don't process the files
                contentType: false, // Set content type to false as jQuery will tell the server its a query string request
                success: function(data, textStatus, jqXHR){
                    //alert(data);
                    obj.siblings('.responce').html(data);
                    cropInit();
                /*
                    if(typeof data.error === 'undefined')
                    {
                        // Success so call function to process the form
                        //submitForm(event, data,obj);
                        obj.siblings('.responce').html(data.response);
                        cropInit();

                    }
                    else
                    {
                        // Handle errors here
                        console.log('ERRORS: ' + data.error);
                    }
                    */
                },
                error: function(jqXHR, textStatus, errorThrown){
                    obj.parent().siblings('.responce').html(textStatus);
                // Handle errors here
                //
                //  console.log('ERRORS: ' + textStatus);
                // STOP LOADING SPINNER
                }
            });
        }
        
        
        
        
    });
