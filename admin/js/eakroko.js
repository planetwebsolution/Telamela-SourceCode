function icheck(){$(".icheck-me").length>0&&$(".icheck-me").each(function(){var e=$(this),a=void 0!==e.attr("data-skin")?"_"+e.attr("data-skin"):"",t=void 0!==e.attr("data-color")?"-"+e.attr("data-color"):"",s={checkboxClass:"icheckbox"+a+t,radioClass:"iradio"+a+t,increaseArea:"10%"};e.iCheck(s)})}function resize_chosen(){$(".chzn-container").each(function(){var e=$(this);e.css("width",e.parent().width()+"px"),e.find(".chzn-drop").css("width",e.parent().width()-2+"px"),e.find(".chzn-search input").css("width",e.parent().width()-37+"px")})}!function(e){e.fn.retina=function(a){var t={retina_part:"-2x"};return a&&jQuery.extend(t,{retina_part:a}),window.devicePixelRatio>=2&&this.each(function(a,s){if(e(s).attr("src")){var r=new RegExp("(.+)("+t.retina_part+"\\.\\w{3,4})");if(!r.test(e(s).attr("src"))){var l=e(s).attr("src").replace(/(.+)(\.\w{3,4})$/,"$1"+t.retina_part+"$2");e.ajax({url:l,type:"HEAD",success:function(){e(s).attr("src",l)}})}}}),this}}(jQuery),$(document).ready(function(){var e=!1,a=!0;/Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent)&&(e=!0),icheck(),$(".complexify-me").length>0&&$(".complexify-me").complexify(function(e,a){40>a?$(this).parent().find(".progress .bar").removeClass("bar-green").addClass("bar-red"):$(this).parent().find(".progress .bar").addClass("bar-green").removeClass("bar-red"),$(this).parent().find(".progress .bar").width(Math.floor(a)+"%").html(Math.floor(a)+"%")}),$(".chart").length>0&&$(".chart").each(function(){var e="#881302",a=$(this),t=a.attr("data-trackcolor");a.attr("data-color")?e=a.attr("data-color"):parseInt(a.attr("data-percent"))<=25?e="#046114":parseInt(a.attr("data-percent"))>25&&parseInt(a.attr("data-percent"))<75&&(e="#dfc864"),a.easyPieChart({animate:1e3,barColor:e,lineWidth:5,size:80,lineCap:"square",trackColor:t})}),$(".calendar").length>0&&($(".calendar").fullCalendar({header:{left:"",center:"prev,title,next",right:"month,agendaWeek,agendaDay,today"},buttonText:{today:"Today"},editable:!0}),$(".fc-button-effect").remove(),$(".fc-button-next .fc-button-content").html("<i class='icon-chevron-right'></i>"),$(".fc-button-prev .fc-button-content").html("<i class='icon-chevron-left'></i>"),$(".fc-button-today").addClass("fc-corner-right"),$(".fc-button-prev").addClass("fc-corner-left")),a&&(e||$("[rel=tooltip]").tooltip()),$(".notify").click(function(){{var e=$(this),a=e.attr("data-notify-title"),t=e.attr("data-notify-message"),s=e.attr("data-notify-time"),r=e.attr("data-notify-sticky");e.attr("data-notify-overlay")}$.gritter.add({title:"undefined"!=typeof a?a:"Message - Head",text:"undefined"!=typeof t?t:"Body",image:"undefined"!=typeof image?image:null,sticky:"undefined"!=typeof r?r:!1,time:"undefined"!=typeof s?s:3e3})}),$(".mask_date").length>0&&$(".mask_date").mask("9999/99/99"),$(".mask_phone").length>0&&$(".mask_phone").mask("(999) 999-9999"),$(".mask_serialNumber").length>0&&$(".mask_serialNumber").mask("9999-9999-99"),$(".mask_productNumber").length>0&&$(".mask_productNumber").mask("aaa-9999-a"),$(".tagsinput").length>0&&$(".tagsinput").each(function(){$(this).tagsInput({width:"auto",height:"auto"})}),$(".datepick").length>0&&$(".datepick").datepicker(),$(".daterangepick").length>0&&$(".daterangepick").daterangepicker(),$(".timepick").length>0&&$(".timepick").timepicker({defaultTime:"current",minuteStep:1,disableFocus:!0,template:"dropdown"}),$(".colorpick").length>0&&$(".colorpick").colorpicker(),$(".uniform-me").length>0&&$(".uniform-me").uniform({radioClass:"uni-radio",buttonClass:"uni-button"}),$(".chosen-select").length>0&&$(".chosen-select").each(function(){var e=$(this),a="true"===e.attr("data-nosearch")?!0:!1,t={};a&&(t.disable_search_threshold=9999999),e.chosen(t)}),$(".select2-me").length>0&&$(".select2-me").select2(),$(".multiselect").length>0&&$(".multiselect").each(function(){var e=$(this),a=e.attr("data-selectableheader"),t=e.attr("data-selectionheader");void 0!=a&&(a="<div class='multi-custom-header'>"+a+"</div>"),void 0!=t&&(t="<div class='multi-custom-header'>"+t+"</div>"),e.multiSelect({selectionHeader:t,selectableHeader:a})}),$(".spinner").length>0&&$(".spinner").spinner(),$(".filetree").length>0&&$(".filetree").each(function(){var e=$(this),a={};a.debugLevel=0,e.hasClass("filetree-callbacks")&&(a.onActivate=function(e){$(".activeFolder").text(e.data.title),$(".additionalInformation").html("<ul style='margin-bottom:0;'><li>Key: "+e.data.key+"</li><li>is folder: "+e.data.isFolder+"</li></ul>")}),e.hasClass("filetree-checkboxes")&&(a.checkbox=!0,a.onSelect=function(e,a){var t=a.tree.getSelectedNodes(),s=$.map(t,function(e){return"["+e.data.key+"]: '"+e.data.title+"'"});$(".checkboxSelect").text(s.join(", "))}),e.dynatree(a)}),$(".colorbox-image").length>0&&$(".colorbox-image").colorbox({maxWidth:"90%",maxHeight:"90%",rel:$(this).attr("rel")}),$(".plupload").length>0&&$(".plupload").each(function(){var e=$(this);e.pluploadQueue({runtimes:"html5,gears,flash,silverlight,browserplus",url:"js/plupload/upload.php",max_file_size:"10mb",chunk_size:"1mb",unique_names:!0,resize:{width:320,height:240,quality:90},filters:[{title:"Image files",extensions:"jpg,gif,png"},{title:"Zip files",extensions:"zip"}],flash_swf_url:"js/plupload/plupload.flash.swf",silverlight_xap_url:"js/plupload/plupload.silverlight.xap"}),$(".plupload_header").remove();var a=e.pluploadQueue();e.hasClass("pl-sidebar")?($(".plupload_filelist_header,.plupload_progress_bar,.plupload_start").remove(),$(".plupload_droptext").html("<span>Drop files to upload</span>"),$(".plupload_progress").remove(),$(".plupload_add").text("Or click here..."),a.bind("FilesAdded",function(e){setTimeout(function(){e.start()},500)}),a.bind("QueueChanged",function(){$(".plupload_droptext").html("<span>Drop files to upload</span>")}),a.bind("StateChanged",function(){$(".plupload_upload_status").remove(),$(".plupload_buttons").show()})):($(".plupload_progress_container").addClass("progress").addClass("progress-striped"),$(".plupload_progress_bar").addClass("bar"),$(".plupload_button").each(function(){$(this).hasClass("plupload_add")?$(this).attr("class","btn pl_add btn-primary").html("<i class='icon-plus-sign'></i> "+$(this).html()):$(this).attr("class","btn pl_start btn-success").html("<i class='icon-cloud-upload'></i> "+$(this).html())}))}),$(".form-wizard").length>0&&$(".form-wizard").formwizard({formPluginEnabled:!0,validationEnabled:!0,focusFirstInput:!1,disableUIStyles:!0,validationOptions:{errorElement:"span",errorClass:"help-block error",errorPlacement:function(e,a){a.parents(".controls").append(e)},highlight:function(e){$(e).closest(".control-group").removeClass("error success").addClass("error")},success:function(e){e.addClass("valid").closest(".control-group").removeClass("error success").addClass("success")}},formOptions:{success:function(e){alert("Response: \n\n"+e.say)},dataType:"json",resetForm:!0}}),$(".form-validate").length>0&&$(".form-validate").each(function(){var e=$(this).attr("id");$("#"+e).validate({errorElement:"span",errorClass:"help-block error",errorPlacement:function(e,a){a.parents(".controls").append(e)},highlight:function(e){$(e).closest(".control-group").removeClass("error success").addClass("error")},success:function(e){e.addClass("valid").closest(".control-group").removeClass("error success").addClass("success")}})}),$(".dataTable").length>0&&$(".dataTable").each(function(){if(!$(this).hasClass("dataTable-custom")){var e={sPaginationType:"full_numbers",oLanguage:{sSearch:"<span>Search:</span> ",sInfo:"Showing <span>_START_</span> to <span>_END_</span> of <span>_TOTAL_</span> entries",sLengthMenu:"_MENU_ <span>entries per page</span>"},sDom:"lfrtip"};if($(this).hasClass("dataTable-noheader")&&(e.bFilter=!1,e.bLengthChange=!1),$(this).hasClass("dataTable-nofooter")&&(e.bInfo=!1,e.bPaginate=!1),$(this).hasClass("dataTable-nosort")){var a=$(this).attr("data-nosort");a=a.split(",");for(var t=0;t<a.length;t++)a[t]=parseInt(a[t]);e.aoColumnDefs=[{bSortable:!1,aTargets:a}]}$(this).hasClass("dataTable-scroll-x")&&(e.sScrollX="100%",e.bScrollCollapse=!0,$(window).resize(function(){s.fnAdjustColumnSizing()})),$(this).hasClass("dataTable-scroll-y")&&(e.sScrollY="300px",e.bPaginate=!1,e.bScrollCollapse=!0,$(window).resize(function(){s.fnAdjustColumnSizing()})),$(this).hasClass("dataTable-reorder")&&(e.sDom="R"+e.sDom),$(this).hasClass("dataTable-colvis")&&(e.sDom="C"+e.sDom,e.oColVis={buttonText:"Change columns <i class='icon-angle-down'></i>"}),$(this).hasClass("dataTable-tools")&&(e.sDom="T"+e.sDom,e.oTableTools={sSwfPath:"js/plugins/datatable/swf/copy_csv_xls_pdf.swf"}),$(this).hasClass("dataTable-scroller")&&(e.sScrollY="300px",e.bDeferRender=!0,e.sDom=$(this).hasClass("dataTable-tools")?"TfrtiS":"frtiS",e.sAjaxSource="js/plugins/datatable/demo.txt"),$(this).hasClass("dataTable-grouping")&&"expandable"==$(this).attr("data-grouping")&&(e.bLengthChange=!1,e.bPaginate=!1);var s=$(this).dataTable(e);if($(this).css("width","100%"),$(".dataTables_filter input").attr("placeholder","Search here..."),$(".dataTables_length select").wrap("<div class='input-mini'></div>").chosen({disable_search_threshold:9999999}),$("#check_all").click(function(){$("input",s.fnGetNodes()).prop("checked",this.checked)}),$(this).hasClass("dataTable-fixedcolumn")&&new FixedColumns(s),$(this).hasClass("dataTable-columnfilter")&&s.columnFilter({sPlaceHolder:"head:after"}),$(this).hasClass("dataTable-grouping")){var r={};"expandable"==$(this).attr("data-grouping")&&(r.bExpandableGrouping=!0),s.rowGrouping(r)}s.fnDraw(),s.fnAdjustColumnSizing()}}),resize_chosen(),$(".file-manager").length>0&&$(".file-manager").elfinder({url:"js/plugins/elfinder/php/connector.php"}),$(".slider").length>0&&$(".slider").each(function(){var e=$(this),a=parseInt(e.attr("data-min")),t=parseInt(e.attr("data-max")),s=parseInt(e.attr("data-step")),r=e.attr("data-range"),l=parseInt(e.attr("data-rangestart")),n=parseInt(e.attr("data-rangestop")),i={min:a,max:t,step:s,slide:function(a,t){e.find(".amount").html(t.value)}};if(void 0!==r&&(i.range=!0,i.values=[l,n],i.slide=function(a,t){e.find(".amount").html(t.values[0]+" - "+t.values[1]),e.find(".amount_min").html(t.values[0]+"$"),e.find(".amount_max").html(t.values[1]+"$")}),e.slider(i),void 0!==r){var o=e.slider("values");e.find(".amount").html(o[0]+" - "+o[1]),e.find(".amount_min").html(o[0]+"$"),e.find(".amount_max").html(o[1]+"$")}else e.find(".amount").html(e.slider("value"))}),$(".ckeditor").length>0&&CKEDITOR.replace("ck"),$(".retina-ready").retina("@2x")}),$(window).resize(function(){resize_chosen()});