<?php
require_once '../common/config/config.inc.php';
require_once CONTROLLERS_ADMIN_PATH . FILENAME_COUNTRY_PORTAL_ORDER_CTRL;
//pre($objPage->arrRows);
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
        <title><?php echo ADMIN_PANEL_NAME; ?> : Manage Country Portal</title>        
        <?php require_once 'inc/common_css_js.inc.php'; ?>
        <link rel="stylesheet" href="<?php echo ADMIN_CSS_PATH; ?>colorbox.css" />     
        <script type='text/javascript' src="<?php echo SITE_ROOT_URL; ?>colorbox/jquery.colorbox.js"></script>	    
        <script type="text/javascript" src="<?php echo SITE_ROOT_URL . "common/js/ajax_js.js"; ?>"></script>
        <script type="text/javascript">
           
            function test(ele){
                $(ele).attr('onclick','');
                window.location=$(ele).attr('href');
                return false;
            }
            
            function changeStatus(status,emailid,id){
                var showid = '#countryPortal'+id;                
                $.post("ajax.php",{action:'CountryPortalChangeStatus',status:status,emailid:emailid,id:id},
                function(data){
                    $(showid).html(data);
                });
            }
            
            function jscallSendWarningPopup(emailid,id){
                $(".warning").colorbox({inline:true, width:"500px", height:"290px"});
                
                $('#cancelWarn').click(function(){parent.jQuery.fn.colorbox.close();});

                $('#frmConfirmWarning').click(function(){

                    var WarningMsg = $('#WarningMsg').val();                 
                    
                    if(WarningMsg==''){
                        alert('Message is Required!');
                        $('#WarningMsg').focus();
                        return false;
                    }else{
                        $('#listed_Warning').html('<span class="green">Sending.....</span>');
                        $.post("ajax.php",{action:'SendWarningToCountryPortal',msg:WarningMsg,emailid:emailid,id:id},
                        function(data){                        
                            $('#listed_Warning').html('<span class="green">Warning Sent Successfully </span>');
                            //$('#listed_Warning').html(data);
                            setTimeout(function a(){parent.jQuery.fn.colorbox.close();location.reload();}, 1500);
                        }
                    );
                    }
                });
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
                            <h1>Country Portal - Orders</h1>
                        </div>
                    </div>
                    <?php require_once('javascript_disable_message.php'); ?>
                    <?php if ($_SESSION['sessUserType'] == 'user-admin' && in_array('listing-country-office-orders', $_SESSION['sessAdminPerMission'])) { ?>
                        <div class="breadcrumbs">
                            <ul>
                                <li><a href="dashboard_uil.php">Home</a><i class="icon-angle-right"></i></li>	 
                                <li><a href="country_portal_manage_uil.php">Country Portal</a><i class="icon-angle-right"></i></li>	
                                <li><span>Country Portal Orders</span></li>
                            </ul>
                            <div class="close-bread"><a href="#"><i class="icon-remove"></i></a></div>
                        </div>					
                        <div class="row-fluid">
                            <div class="span12">                        	
                                <?php
                                if ($objCore->displaySessMsg() <> '') {
                                    echo $objCore->displaySessMsg();
                                    $objCore->setSuccessMsg('');
                                    $objCore->setErrorMsg('');
                                }
                                ?>
                                <div class="box box-color box-bordered">
                                    <div class="box-title">
                                        <h3>
                                            Country Portal - Orders
                                        </h3>
                                    </div>
                                    <div class="box-content nopadding manage_categories">  
                                        <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper" role="grid">
                                            <?php if ($objPage->NumberofRows > 0) { ?>
                                                <form id="frmCategoryList" name="frmCategoryList" action="customer_action.php" method="post">                                           
                                                    <table class="table table-hover table-nomargin table-bordered usertable">
                                                        <thead>    
                                                            <tr>
                                                                <th>Month Year</th>
                                                                <th class='hidden-480'>No. of Sold Products</th>
                                                                <th class='hidden-480'>Total Sales( <?php echo ADMIN_CURRENCY_SYMBOL; ?>)</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $i = 1;
                                                            foreach ($objPage->arrRows as $val) {
                                                                ?>
                                                                <tr class="content">
                                                                    <td>                                                                        
                                                                        <?php echo $objCore->localDateTime($val['Dated'], DATE_FORMAT_MONTH_YEAR_SITE); ?>
                                                                    </td>
                                                                    <td class="hidden-480"><?php echo $val['TotalQty']; ?></td>
                                                                    <td class="hidden-480"><?php echo number_format($val['TotalAmount'], 2); ?></td>
                                                                    <td>
                                                                        <a class='btn' data-original-title="View" rel="tooltip" href="country_portal_order_wholesalers_uil.php?type=view&month=<?php echo $val['Dated'] ?>"><i class="icon-eye-open"></i></a>  
                                                                        <?php if ($val['inv'] > 0) { ?>
<a class="actionAdminLink" href="country_portal_order_wholesalers_uil.php?type=SendInvoice&month=<?php echo $val['Dated'] ?>" onClick="test(this)">Send Invoice to Telamela</a>
                                                                            <a href="<?php echo INVOICE_URL . 'country_portal/' . $val['InvoiceFileName']; ?>" target="_blank">View Invoice</a>
                                                                        <?php } else if ($val['DiffInv'] > 0) { ?>
                                                                            <a class="actionAdminLink" href="country_portal_order_wholesalers_uil.php?type=SendInvoice&month=<?php echo $val['Dated'] ?>" onClick="test(this)">Send Invoice to Telamela</a>
                                                                        <?php } ?>
                                                                    </td>
                                                                </tr>
                                                                <?php
                                                            }
                                                            ?>
                                                        </tbody>                                       
                                                    </table>
                                                    <div class="dataTables_paginate paging_full_numbers" id="DataTables_Table_0_paginate"><?php
                                                    if ($objPage->varNumberPages > 1) {
                                                        $objPage->displayPaging($_GET['page'], $objPage->varNumberPages, $objPage->varPageLimit);
                                                    }
                                                            ?></div>                            
                                                </form>
                                            <?php } else { ?>
                                                <table class="table table-hover table-nomargin table-bordered usertable">
                                                    <tr class="content">
                                                        <td colspan="10" style="text-align:center">
                                                            <strong>No record(s) found.</strong>
                                                        </td>
                                                    </tr>
                                                </table>        
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } else { ?>
                    <table width="100%">
                        <tr>
                            <th align="left"><?php echo ADMIN_USER_PERMISSION_TITLE; ?></th>
                        </tr>
                        <tr>
                            <td><?php echo ADMIN_USER_PERMISSION_MSG; ?></td>
                        </tr>
                    </table>
                <?php } ?>
            </div>
            <?php require_once('inc/footer.inc.php'); ?>
        </div>
        <script type="text/javascript">
<?php if (isset($_REQUEST['frmSearchPressed']) && $_REQUEST['frmSearchPressed'] == 'Yes') { ?>
        showSearchBox('search', 'show');
<?php } else { ?>
        showSearchBox('search', 'hide');
<?php } ?>
        
        

        </script>
        
    </body>
</html>