<?php
require_once 'common/config/config.inc.php';
require_once CONTROLLERS_PATH . FILENAME_WHOLESALER_INVOICE_CTRL;

$arrData = $objPage->arrInvoices;
$rowsNum = count($arrData);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title><?php echo CUS_INVOICE_TITLE; ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <?php include_once 'common/inc/comman_css_js.inc.php'; ?>
        <script  type="text/javascript">
            $(document).ready(function(){
                $('.drop_down1').sSelect();
                $('.datePicker').datepick({dateFormat: 'dd-mm-yyyy',showTrigger:'<small><a href="javascript:void(0);"><img src="common/images/cal_icon.png" alt=""/></a></small>'});

                $("#spButton").click(function() {
                    $('.order_sec').slideToggle('slow');
                });

                $('.order_sec').addClass('<?php echo count($_POST) ? "show" : "hide"; ?>');

            });
        </script>
        <style>.drop4{width:140px;}.stylish-select .drop4 .newListSelected{ width:100%;}
            .stylish-select .drop4 .selectedTxt{ background: url("common/images/select2.png") no-repeat scroll 186% 6px #fff;}
            /*.add_edit_pakage label{ font-weight:100}*/
            .stylish-select .drop4 .selectedTxt{ height:31px;width:73% !important;}
@media screen and (max-width: 1024px){
     .stylish-select .drop4 .selectedTxt{ height:31px;width:100% !important;}
}

        </style>
    </head>
    <body>
        <em> <div id="navBar">
                <?php include_once INC_PATH . 'top-header.inc.php'; ?>
            </div>

        </em>
        <div class="header"><div class="layout"></div>
            <?php include_once INC_PATH . 'header.inc.php'; ?>

        </div>

        <div id="ouderContainer" class="ouderContainer_1"><div class="wholesalerHeaderSection" style="width:100%; height:50px; padding-top:16px;	  border-bottom:1px solid #e7e7e7;"><div class="btn_top"><?php include_once 'common/inc/wholesaler.header.inc.php'; ?></div></div>
            <div class="layout">
                <div class="">

                    <?php
                    if ($objCore->displaySessMsg())
                    {
                        ?>
                        <div class="successMessage">
                            <?php
                            echo $objCore->displaySessMsg();
                            $objCore->setSuccessMsg('');
                            $objCore->setErrorMsg('');
                            ?>
                        </div>
                    <?php }
                    ?>
                </div>
                <div class="add_pakage_outer">
                    <div class="top_container " style="padding: 0px 0 19px 0">

                    </div>

                    <div class="body_inner_bg">
                        <div class="add_edit_pakage aapplication_form aapplication_form2 manage_product wish_sec">
                            <div class="manage_sec2">
                                <div class="product_link">
                                    <span class="add_link" id="spButton"><?php echo SEARCH_INVOICE; ?></span>
                                </div>
                                <div class="order_sec" style="margin-bottom:20px;">
                                    <form action="" method="post" name="invoice_filter" id="invoice_filter" class="order_filter_input" >
                                        <ul class="left_sec">
                                            <li>
                                                <label><?php echo INV_ID; ?></label>
                                                <input type="text" value="<?php echo @$_POST['pkInvoiceID'] ?>" name="pkInvoiceID" id="pkInvoiceID" />
                                            </li>
                                            <li>
                                                <label><?php echo ORDER_ID; ?></label>
                                                <input type="text" value="<?php echo @$_POST['fkSubOrderID'] ?>" name="fkSubOrderID" id="fkSubOrderID" />
                                            </li>
                                            <li>

                                                <label><?php echo OR_DATE; ?></label>
                                                <div class="input_sec input_sec2">
                                                    <div class="cal_sec">
                                                        <input type="text" value="<?php echo @$_POST['OrderStartDate'] ?>" name="OrderStartDate" id="OrderStartDate" class="text3 datePicker"/>                                                        
                                                    </div>
                                                    <div class="cal_sec">
                                                        <span><?php echo TO; ?></span>
                                                        <input type="text" value="<?php echo @$_POST['OrderEndDate'] ?>" name="OrderEndDate" id="OrderEndDate" class="text3 datePicker"/>                                                        
                                                    </div>
                                                </div>
                                            </li>
                                            
                                        </ul>
                                        <ul class="left_sec right">
                                            <li>
                                                <label><?php echo INV_DATE; ?></label>
                                                <div class="input_sec input_sec2">
                                                    <div class="cal_sec">                                                        
                                                        <input type="text" value="<?php echo @$_POST['InvoiceStartDate'] ?>" name="InvoiceStartDate" id="InvoiceStartDate" class="text3 datePicker"/>                                                        
                                                    </div>
                                                    <div class="cal_sec">
                                                        <span><?php echo TO; ?></span>
                                                        <input type="text" value="<?php echo @$_POST['InvoiceEndDate'] ?>" name="InvoiceEndDate" id="InvoiceEndDate" class="text3 datePicker"/>                                                        
                                                    </div>
                                                </div>
                                                <div class="cb"></div>
                                            </li>
                                            <li class="cb">
                                                <label><?php echo AMT_PAY; ?></label>
                                                <input type="text" class="input_2" value="<?php echo @$_POST['AmountPayableStart']; ?>" name="AmountPayableStart" id="AmountPayableStart" />

                                                <SPAN class="to"> To</SPAN> <input type="text" class="input_2" value="<?php echo @$_POST['AmountPayableEnd']; ?>" name="AmountPayableEnd" id="AmountPayableEnd" />
                                            </li>
                                            <li>
                                                <label><?php echo STATUS; ?></label>
                                                <div class="drop4">
                                                    <select class="drop_down1" name="TransactionStatus" id="TransactionStatus">
                                                        <option value=""><?php echo SEL; ?> <?php echo STATUS; ?></option>
                                                        <option <?php echo $_POST['TransactionStatus'] == 'Pending' ? 'selected' : '' ?> value="Pending"><?php echo PEN; ?></option>
                                                        <option <?php echo $_POST['TransactionStatus'] == 'Partial' ? 'selected' : '' ?> value="Partial"><?php echo PARTIAL; ?></option>
                                                        <option <?php echo $_POST['TransactionStatus'] == 'Completed' ? 'selected' : '' ?> value="Completed"><?php echo COM; ?></option>
                                                    </select>

                                                </div>
                                            </li>
                                        </ul>

                                         <ul class="left_sec">
                                            <li>
                                                <label>&nbsp;</label>
                                                <input type="submit" class="submit2 submit3 my_submit_btn" value="Search" />
                                                <!--<a href="<?php echo $objCore->getUrl('manage_invoice.php'); ?>">-->
                                                    <input onclick="window.location.href='<?php echo $objCore->getUrl('manage_invoice.php'); ?>'" type="button" class="submit2 cancel" value="Cancel"  style="margin-top:7px; height:39px;">
                                                <!--</a>-->
                                            </li>
                                        </ul>
                                    </form>
                                </div>

<div class="table-responsive">
                                <table border="0" class="manage_table">
                                    <tr>
                                        <th><?php echo INV_ID; ?></th>
                                        <th><?php echo INV_DATE; ?></th>
                                        <th><?php echo ORDER_ID; ?></th>
                                        <th><?php echo ORDER_DATE; ?></th>
                                        <th><?php echo AMT_PAY; ?></th>
                                        <th><?php echo AMT_DUE; ?></th>
                                        <th><?php echo STATUS; ?></th>
                                        <th><?php echo ACTION; ?></th>

                                    </tr>
                                    <?php
                                    if ($rowsNum > 0)
                                    {
                                        foreach ($arrData as $key => $value)
                                        {
                                        	/* echo '<pre>';
                                        	print_r($value);
                                        	echo '</pre>';
                                        	die; */
                                            $cls = ($value['TransactionStatus'] == 'Completed') ? 'green' : '';
                                            ?>
                                            <tr class="<?php echo $key % 2 == 1 ? 'even' : 'odd'; ?>">
                                                <td><?php echo $value['pkInvoiceID'] ?></td>
                                                <td><?php echo $objCore->localDateTime($value['InvoiceDateAdded'], DATE_FORMAT_SITE_FRONT); ?></td>
                                                <td><?php echo $value['fkSubOrderID'] ?></td>
                                                <td><?php echo $objCore->localDateTime($value['OrderDateAdded'], DATE_FORMAT_SITE_FRONT); ?></td>
                                                <td><?php echo $objCore->getPrice($value['AmountPayable']); ?></td>
                                                  <td><?php echo $objCore->getPrice($value['AmountDue']); ?></td>
                                                <td class="<?php echo $cls; ?>"><?php echo $value['TransactionStatus'] ?>
                                                    <?php
                                                    if ($value['pkInvoiceID'] > 0)
                                                    {
                                                        ?>
                                                        <a href="<?php echo INVOICE_URL . 'wholesaler/' . $value['InvoiceFileName']; ?>" target="_blank" class="viewbig" title="View Invoice">&nbsp;</a>
                                                    <?php } ?> </td>
                                                 
                                                 <!-- Created to provide facility to see invoice detail By: Krishna Gupta (09-10-2015) -->
                                                 <td id="view_invoice">
                                                      <?php 
                                                      $filename = INVOICE_URL . 'wholesaler/' . $value['InvoiceFileName'];
                                                      
                                                      $file_headers = @get_headers($filename);
                                                      // print_r($file_headers);
                                                      (string) $file_headers[3];
                                                      
                                                      if(substr($file_headers[3], -7) == '404.php') {
                                                      	$exists = false;
                                                      }
                                                      else {
                                                      	$exists = true;
                                                      }
                                                      
                                                      //if(!empty($value['InvoiceFileName'])) 
                                                      if($exists)
                                                      { ?>
                                                      	<a class="btn"  style=" float :none !important;"href="<?php echo INVOICE_URL . 'wholesaler/' . $value['InvoiceFileName']; ?>" rel="tooltip" title="" data-original-title="View" target="_blank"><i class="fa fa-eye" title="View Detail" style="color: #4169E1; font-size: 20px; "></i></a>
                                                      <?php } ?>
                                                 </td>
                                                 <!-- Created to provide facility to see invoice detail By: Krishna Gupta (09-10-2015) ends -->

                                            </tr>
                                            <?php
                                        }
                                    }
                                    else
                                    {
                                        ?>
                                        <tr class="odd"><td colspan="6">
                                                <?php
                                                echo FRONT_WHOLESALER_PRODUCT_LIST_ERROR_MSG2;
                                                ?>
                                            </td></tr>
                                    <?php } ?>

                                </table>       
</div>
                                <?php
                                if ($rowsNum > 0)
                                {
                                    ?>
                                    <table width="100%">
                                        <tr><td colspan="10">&nbsp;</td></tr>
                                        <tr>
                                            <td colspan="10">
                                                <table width="100%" border="0" align="center">
                                                    <tr>
                                                        <td style="font-weight:bolder; text-align:right;" colspan="10" align="right">
                                                            <?php
                                                            if ($objPage->varNumberPages > 1)
                                                            {
                                                                $objPage->displayFrontPaging($_GET['page'], $objPage->varNumberPages, $objPage->varPageLimit);
                                                            }
                                                            ?>
                                                        </td>
                                                    </tr>

                                                </table>
                                            </td>
                                        </tr></table>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include_once 'common/inc/footer.inc.php'; ?>
    </body>
</html>