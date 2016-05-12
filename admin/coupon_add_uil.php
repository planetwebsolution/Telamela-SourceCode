<?php
require_once '../common/config/config.inc.php';
require_once CONTROLLERS_ADMIN_PATH . FILENAME_COUPON_CTRL;
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <!-- Apple devices fullscreen -->
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <!-- Apple devices fullscreen -->
        <meta names="apple-mobile-web-app-status-bar-style" content="black-translucent" />
        <title><?php echo ADMIN_PANEL_NAME; ?> : Add - Coupon</title>
        <?php require_once 'inc/common_css_js.inc.php'; ?>        
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
        <link type="text/css"  rel="stylesheet" href="<?php echo CALENDAR_URL; ?>jquery.datepick.css" />
        <script type="text/javascript" src="<?php echo CALENDAR_URL; ?>jquery.datepick.js"></script>
        <script type="text/javascript" src="<?php echo JS_PATH; ?>admin_js.js"></script>
       <style>#frmDateEnd{ cursor:pointer; cursor:hand}
							#frmDateStart{ cursor:pointer; cursor:hand}
							
							.datepick-trigger{ top:-3px; position:relative}</style> <script type="text/javascript">
            function ShowCategoryForCoupon(str){
                var addDiv = $('#addDropDown');
                
                if(str==1){
                    $(addDiv).html('<p>&nbsp;</p>');
                    return false; 
                    
                }
                var i = $('#addDropDown p').size() + 1;
                
                $.post("ajax.php",{action:'ShowCategoryForCoupon',showid:'1'},
                function(data)
                { 
                    $('<b>Choose Products..</b><p>'+data+'&nbsp;<i><a id="addNewDrop" href="#"><img title="Add more" alt="Add more" src="images/plus.png"></a></i></p>').appendTo(addDiv);
                    $('.dNone').hide();
                }
            );                  
                i++;	 
                return false;                  
            }
                              
            $(function() {
                var addDiv = $('#addDropDown');
                var i = $('#addDropDown p').size() + 1;                               
                
                $('#addNewDrop').live('click', function() {
                    $('#addDropDown p:last i').html('');                   
                    $.post("ajax.php",{action:'ShowCategoryForCoupon',showid:i},
                    function(data)
                    { 
                        $('<p>'+data+'&nbsp;<i><a id="addNewDrop" href="#"><img title="Add more" alt="Add more" src="images/plus.png"></a></i>&nbsp;<a href="#" id="remNewDrop"><img src="images/minus.png" alt="Remove" title="Remove" /></a> </p>').appendTo(addDiv);
                        $('.dNone').hide();
                    }
                );
                   
                    i++;	 
                    return false;
                });
	 
                $('#remNewDrop').live('click', function() {
                    if( i > 2 ) {
                        $(this).parents('p').remove();
                        i--;
                       
                        $("#addDropDown p:last i").html('<i><a href="#" id="addNewDrop"><img src="images/plus.png" alt="Add more" title="Add more" /></a></i>');
                    }
                    return false;
                });
            });
	 
        </script> 
        <script type="text/javascript">
            function ShowProductForCoupon(str,showid){
                $('#price'+showid).html('0.0000');
                if(str==0){
                    $('#pro'+showid).html('<select name="frmProductId[]" onchange="ShowProductPriceForCoupon(this.value,'+showid+');" style="width:170px; margin-left:10px;"><option value="0">Select Product</option></select>');
                    
                }else{
                    $.post("ajax.php",{action:'ShowProductForCoupon',showid:showid,catid:str},
                    function(data)
                    {
                        
                        $('#pro'+showid).html(data);
                    }); 
                    
                }               
            }    
        </script>        
        <script type="text/javascript">
            function ShowProductPriceForCoupon(str,showid){
                
                if(str==0){
                    $('#price'+showid).html('0.0000');
                    
                }else{
                    var p = str.split('vss');                        
                    $('#price'+showid).html(p[1]);   
                }
            }    
        </script>

    </head>
    <body>
        <?php require_once 'inc/header_new.inc.php'; ?>
        <div class="container-fluid" id="content">

            <div id="main">
                <div class="container-fluid">
                    <div class="page-header">
                        <div class="pull-left">
                            <h1>Add Discount Coupon</h1>
                        </div>
                    </div>
                    <div class="breadcrumbs">
                        <ul>
                            <li><a href="dashboard_uil.php">Home</a><i class="icon-angle-right"></i></li>
                            <li><a href="coupon_manage_uil.php">Discount Coupon</a><i class="icon-angle-right"></i></li>
                            <li><span>Add Discount Coupon</span></li>
                        </ul>
                        <div class="close-bread">
                            <a href="#"><i class="icon-remove"></i></a>
                        </div>
                    </div>

                    <div class="row-fluid">						
                        <div class="span12">
                            <div class="box box-bordered box-color top-box">
                                <!--<a id="buttonDecoration" href="<?php echo $_SERVER['HTTP_REFERER']; ?>"><input type="button" class="btn" name="btnTagSettings" value="<?php echo ADMIN_BACK_BUTTON; ?>" style="float:right; margin:6px 2px 0 0; width:107px; margin-right:10px;"/></a>-->

                                <div class="box-content nopadding">

                                    <div class="tab-content padding tab-content-inline tab-content-bottom">
                                        <div class="tab-pane active" id="tabs-2">
                                            <div class="row-fluid">
                                                <div class="span12">
                                                    <?php
                                                    if ($objCore->displaySessMsg()) {
                                                        ?>  

                                                        <?php
                                                        echo $objCore->displaySessMsg();
                                                        $objCore->setSuccessMsg('');
                                                        $objCore->setErrorMsg('');
                                                        ?>

                                                        <?php
                                                    }
                                                    ?>
                                                    <div class="box box-color box-bordered">
                                                        <div class="box-title">
                                                             <a id="buttonDecoration" href="<?php echo $_SERVER['HTTP_REFERER']; ?>" class="btn pull-right"><i class="icon-circle-arrow-left"></i> <?php echo ADMIN_BACK_BUTTON; ?></a>
                                                            <h3>                                                               
                                                                Create a new Discount Coupon
                                                            </h3>                                                            
                                                        </div>

                                                        <div class="box-content nopadding"> 
                                                            <?php require_once('javascript_disable_message.php'); ?>
                                                            <form action=""  method="post" id="frm_page" onSubmit="return validateCouponForm();" >
                                                                <?php if ($_SESSION['sessUserType'] == 'super-admin' || in_array('add-coupon', $_SESSION['sessAdminPerMission'])) { ?>                     
                                                                    <table  class="table table-hover table-nomargin table-bordered usertable">	

                                                                        <tr>
                                                                            <td>
                                                                                <table cellpadding="0" cellspacing="0" border="0" class="left_content" style="width:100%" >
                                                                                    <tr class="content">
                                                                                        <td valign="top"><span class="req">*</span><strong>Coupon Name:</strong>  </td>
                                                                                        <td width="30%"><input name="frmCouponName" id="frmCouponName" type="text" value="" class="input-large" /></td>
                                                                                        <td rowspan="2">
                                                                                            <script type="text/javascript">
                                                                                                $(function() {
    	
    	
                                                                                                    $('#frmDateStart').datepick({dateFormat: 'dd-mm-yyyy', showTrigger: '<img src="../common/images/calendar.gif" alt="Popup" class="trigger">',onSelect:calEqual,minDate: new Date()});
    	
                                                                                                    $('#frmDateEnd').datepick({dateFormat: 'dd-mm-yyyy', showTrigger: '<img src="../common/images/calendar.gif" alt="Popup" class="trigger">', onSelect:calDateCompare,minDate: new Date()});



                                                                                                });

                                                                                    			function calEqual(stDt,enDt)
                                                                                    			{
                                                                                    				$('#frmDateEnd').val($('#frmDateStart').val());
                                                                                    			}
                                                                                                function calDateCompare(SelectedDates)
                                                                                                { 
        
                                                                                                    var d = new Date(SelectedDates);
                                                                                                    var d_formatted = d.getDate() + '-' + d.getMonth() +'-' + d.getFullYear();
                                                                                                    var sdate = d_formatted.split("-");
       
                                                                                                    var StartDate = $('#frmDateStart').val();    
                                                                                                    var CurrDate  = StartDate.split("-");
                                                                                                    /*********************** From Date *****************/
                                                                                                    var CY = parseInt(CurrDate[2]);  //Year
                                                                                                    var CM = parseInt(CurrDate[1]);  //Month
                                                                                                    var CD = parseInt(CurrDate[0]);  //Date
                                                                                                    /******************* To Date *********************/

                                                                                                    var sY=parseInt(sdate[2]);  //Year
                                                                                                    var sM=parseInt(sdate[1])+1;  //Month
                                                                                                    var sD=parseInt(sdate[0]);  //Date

                                                                                                    var ctr=0;

                                                                                                    if(sY<CY){
                                                                                                        ctr=1;   
                                                                                                    }else if(sY==CY && sM<CM){
                                                                                                        ctr=1;  
                                                                                                    }else if(sY==CY && sM==CM && sD<CD){
                                                                                                        ctr=1;    
                                                                                                    }
                                                                                                    if(ctr==1){
                                                                                                        $('#frmDateEnd').val(StartDate);   
                                                                                                        alert('End Date should be greater than or equal to Start Date');
        
                                                                                                    }


                                                                                                }


                                                                                            </script>
                                                                                            <table align="left" width="50%" border="0" cellpadding="4" cellspacing="0">
                                                                                                <tr>
                                                                                                    <td><b>Start Date:</b></td>
                                                                                                    <td><b>End Date:</b></td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td>
                                                                                                        <div class="control-group">
                                                                                                            <div class="controls" style="float: left;width: 171px;">
                                                                                                                <input type="text" name="frmDateStart" id="frmDateStart" value="<?php echo $objCore->localDateTime(date(DATE_FORMAT_SITE), DATE_FORMAT_SITE); ?>" readonly class="input-medium" />
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </td>
                                                                                                    <td>
                                                                                                        <div class="control-group">
                                                                                                            <div class="controls" style="float: left;width: 171px;">
                                                                                                                <input type="text" name="frmDateEnd" id="frmDateEnd" value="<?php echo $objCore->localDateTime(date(DATE_FORMAT_SITE), DATE_FORMAT_SITE); ?>" readonly class="input-medium" />
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </td>
                                                                                                </tr>                                                    
                                                                                            </table>

                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr class="content">
                                                                                        <td valign="top"><span class="req">* </span><strong>Coupon Code:</strong></td>
                                                                                        <td>
                                                                                            <input name="frmCouponCode" id="frmCouponCode" type="text" class="input-large" value="" onKeyUp="checkCouponCode(0);" onChange="checkCouponCode(0);" />
                                                                                            <p id="code" class="req"></p><input type="hidden" name="frmCoupon" id="frmCoupon" value="0" />
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr class="content">
                                                                                        <td style="vertical-align:top;" onMouseMove="checkCouponCode(0);"><span class="req">*</span><strong> Discount %:</strong></td>
                                                                                        <td colspan="2" onMouseMove="checkCouponCode(0);">
                                                                                            <input type="text" name="frmDiscount" id="frmDiscount" class="input-large" />
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr class="content">
                                                                                        <td style="vertical-align:top;"><span class="req">*</span><strong>Apply on:</strong></td>
                                                                                        <td colspan="2" style="height:30px; padding-bottom:0px">

                                                                                            <input type="radio" name="frmApplyOn" value="1" checked="checked" onChange="ShowCategoryForCoupon(1);" />All Products&nbsp;
                                                                                            <input type="radio" name="frmApplyOn" value="0" onChange="ShowCategoryForCoupon(0);" />Selected Products 


                                                                                            <div id="addDropDown">
                                                                                                <p>&nbsp;</p></div>

                                                                                        </td>
                                                                                    </tr>
                                                                                  
                                                                                    <tr class="content">
                                                                                        <td>&nbsp;</td>
                                                                                        <td colspan="2">Note : <span class="req">*</span> Indicates mandatory fields.</td>
                                                                                    </tr>

                                                                                    <tr class="content">
                                                                                        <td>&nbsp; </td>
                                                                                        <td colspan="2"><input type="submit" class="btn"  name="btnPage" value="<?php echo ADMIN_SUBMIT_BUTTON; ?>" style="float:left; margin:5px 15px 0 0; width:80px;"/>
                                                                                            <a id="buttonDecoration" href="coupon_manage_uil.php">
                                                                                                <input type="button" class="btn"  name="btnTagSettings" value="<?php echo ADMIN_SEARCH_CANCEL_BUTTON; ?>" style="float:left; margin:5px 5px 0 0; width:80px;"/></a>                                                    
                                                                                            <input type="hidden" name="frmHidenAdd" id="frmHidnAddPage" value="add" />
                                                                                        </td>
                                                                                    </tr>

                                                                                </table>
                                                                            </td>
                                                                        </tr>

                                                                    </table> 
                                                                <?php } else { ?>
                                                                    <table class="table table-hover table-nomargin table-bordered usertable" >
                                                                        <tr>
                                                                            <th align="left"><br /><?php echo ADMIN_USER_PERMISSION_TITLE; ?></th></tr>
                                                                        <tr><td><?php echo ADMIN_USER_PERMISSION_MSG; ?></td></tr>
                                                                    </table>
                                                                <?php } ?>                         
                                                            </form>

                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <?php require_once('inc/footer.inc.php'); ?>
        </div>

    </body>
</html>