
function jCroppicPopupOpen(str, con) {    //alert(str);return false;    
    $('#cropimg_' + con).show();

    var htmlCrop = '<div class="col-lg-6 cropHeaderWrapper"><div id="croppic' + con + '" class="croppic"></div><span class="btn cropContainerHeaderButton" id="cropContainerHeaderButton' + con + '" style="cursor:pointer;margin-right:10px;">Upload Image</span></div>';
    $('#cropimg_' + con).html(htmlCrop);
    $("." + str).colorbox({
        inline: true
    });
    var croppicHeaderOptions = {
        //uploadUrl:'img_save_to_file.php',
        cropData: {"dummyData": 1, "dummyData2": "asdas"},
        cropUrl: 'img_crop_to_file.php',
        customUploadButtonId: 'cropContainerHeaderButton' + con + '',
        modal: false,
        processInline: true,
        loaderHtml: '<div class="loader bubblingG"><span id="bubblingG_1"></span><span id="bubblingG_2"></span><span id="bubblingG_3"></span></div> ',
        onBeforeImgUpload: function() {
            console.log('onBeforeImgUpload')
        },
        onAfterImgUpload: function() {
            console.log('onAfterImgUpload')
        },
        onImgDrag: function() {
            console.log('onImgDrag')
        },
        onImgZoom: function() {
            console.log('onImgZoom')
        },
        onBeforeImgCrop: function() {
            console.log('onBeforeImgCrop')
        },
        onAfterImgCrop: function() {
            console.log('onAfterImgCrop')
        },
        onError: function(errormessage) {
            console.log('onError:' + errormessage)
        }
    }
    var croppic = new Croppic('croppic' + con + '', croppicHeaderOptions);


    var croppicContainerModalOptions = {
        uploadUrl: 'img_save_to_file.php',
        cropUrl: 'img_crop_to_file.php',
        modal: true,
        imgEyecandyOpacity: 0.4,
        loaderHtml: '<div class="loader bubblingG"><span id="bubblingG_1"></span><span id="bubblingG_2"></span><span id="bubblingG_3"></span></div> '
    }
    var cropContainerModal = new Croppic('cropContainerModal', croppicContainerModalOptions);


    var croppicContaineroutputOptions = {
        uploadUrl: 'img_save_to_file.php',
        cropUrl: 'img_crop_to_file.php',
        outputUrlId: 'cropOutput',
        modal: false,
        loaderHtml: '<div class="loader bubblingG"><span id="bubblingG_1"></span><span id="bubblingG_2"></span><span id="bubblingG_3"></span></div> '
    }
    var cropContaineroutput = new Croppic('cropContaineroutput', croppicContaineroutputOptions);

    var croppicContainerEyecandyOptions = {
        uploadUrl: 'img_save_to_file.php',
        cropUrl: 'img_crop_to_file.php',
        imgEyecandy: false,
        loaderHtml: '<div class="loader bubblingG"><span id="bubblingG_1"></span><span id="bubblingG_2"></span><span id="bubblingG_3"></span></div> '
    }
    var cropContainerEyecandy = new Croppic('cropContainerEyecandy', croppicContainerEyecandyOptions);

    var croppicContaineroutputMinimal = {
        uploadUrl: 'img_save_to_file.php',
        cropUrl: 'img_crop_to_file.php',
        modal: false,
        doubleZoomControls: false,
        rotateControls: false,
        loaderHtml: '<div class="loader bubblingG"><span id="bubblingG_1"></span><span id="bubblingG_2"></span><span id="bubblingG_3"></span></div> '
    }
    var cropContaineroutput = new Croppic('cropContainerMinimal', croppicContaineroutputMinimal);

    var croppicContainerPreloadOptions = {
        uploadUrl: 'img_save_to_file.php',
        cropUrl: 'img_crop_to_file.php',
        loadPicture: 'assets/img/night.jpg',
        enableMousescroll: true,
        loaderHtml: '<div class="loader bubblingG"><span id="bubblingG_1"></span><span id="bubblingG_2"></span><span id="bubblingG_3"></span></div> '
    }
    var cropContainerPreload = new Croppic('cropContainerPreload', croppicContainerPreloadOptions);

    $('#cboxClose,#cboxOverlay').click(function() {
        $('#cropimg_' + con).hide();
        parent.jQuery.fn.colorbox.close();
    });


}
