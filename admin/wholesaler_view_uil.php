<?php
require_once '../common/config/config.inc.php';
require_once CONTROLLERS_ADMIN_PATH . FILENAME_WHOLESALER_CTRL;
$varNum = count($objPage->arrRow[0]['pkWholesalerID']);
//pre($objPage->arrSoldProductDetails);
//print_r($objPage->arrPaidInvoiceProductDetails);
//print_r($objPage->arrUnPaidInvoiceProductDetails);
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
        <title><?php echo ADMIN_PANEL_NAME; ?> : View Wholesaler</title>
        <?php require_once 'inc/common_css_js.inc.php'; ?>
        <script type="text/javascript" src="<?php echo JS_PATH; ?>admin_js.js"></script>
    </head>
    <body>

        <?php require_once 'inc/header_new.inc.php';?>



        <div class="container-fluid" id="content">

            <div id="main">
                <div class="container-fluid">
                    <div class="page-header">
                        <div class="pull-left">
                            <h1>View Wholesaler</h1>
                        </div>

                    </div>
                    <div class="breadcrumbs">
                        <ul>
                            <li>
                                <a href="dashboard_uil.php">Home</a>
                                <i class="icon-angle-right"></i>
                            </li>
                            <li>
                                <a href="wholesaler_application_manage_uil.php">wholesaler</a>
                                <i class="icon-angle-right"></i>
                            </li>
                            <li>
<!--                                <a href="wholesaler_view_uil.php?id=<?php echo $_GET['id']; ?>&type=edit">View Wholesaler</a>-->
                                <span>Wholesaler Support outbox view</span>
                            </li>
                        </ul>
                        <div class="close-bread">
                            <a href="#"><i class="icon-remove"></i></a>
                        </div>
                    </div>

                    <div class="row-fluid">
                        <div class="span12">
                            <div class="tab-pane active" id="tabs-2">
                                <div class="row-fluid">
                                    <div class="span12">
                                        <div class="box box-color box-bordered">
                                            <?php
                                            if ($objCore->displaySessMsg()) {
                                                echo $objCore->displaySessMsg();
                                                $objCore->setSuccessMsg('');
                                                $objCore->setErrorMsg('');
                                            }
                                            ?>
                                            <div class="box-title">
                                                <a id="buttonDecoration" href="<?php echo $_SERVER['HTTP_REFERER']; ?>" class="btn pull-right"><i class="icon-circle-arrow-left"></i> <?php echo ADMIN_BACK_BUTTON; ?></a>
                                                <?php if ($varNum > 0) { ?>
                                                    <!--<a id="buttonDecoration" href="wholesaler_edit_uil.php?id=<?php echo $objPage->arrRow[0]['pkWholesalerID']; ?>&type=edit" class="btn pull-right" style="margin-right: 10px;">Edit</a>-->
                                                <?php } ?>
                                                <h3>
                                                    View Wholesaler Details
                                                </h3>
                                            </div>
                                            <div class="box-content nopadding">

                                                <?php require_once('javascript_disable_message.php'); ?>


                                                <?php if ($_SESSION['sessUserType'] == 'super-admin' || in_array('listing-wholesalers', $_SESSION['sessAdminPerMission']) || in_array('manage-wholesaler-applications', $_SESSION['sessAdminPerMission'])) { ?>

                                                    <div >&nbsp;</div>
                                                    <form action=""  method="post" id="frm_page" onsubmit="return validateProductAddForm(this);" enctype="multipart/form-data" >
                                                        <table class="table table-hover table-nomargin table-bordered usertable">
                                                            <?php if ($varNum > 0) { ?>
                                                                <tbody>
                                                                    <tr>
                                                                        <td valign="top" colspan="3">
                                                                            <p style="text-align: right">
                                                                                <?php if ($objPage->arrRow[0]['WholesalerStatus'] <> 'pending') { ?>

                                                                                    <a href="customer_feedback_view_uil.php?frmfeedback=yes&wid=<?php echo $objPage->arrRow[0]['pkWholesalerID'] ?>&type=view" class="button1">Check Feedback</a>&nbsp;
                                                                                    <a href="wholesaler_support_compose_manage_uil.php?id=<?php echo $objPage->arrRow[0]['pkWholesalerID'] ?>" class="button1">Send a Message</a>&nbsp;
                                                                                <?php } ?>
                                                                            </p>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td valign="top">Company Name: </td>
                                                                        <td>
                                                                            <?php echo $objPage->arrRow[0]['CompanyName']; ?>
                                                                        </td>
                                                                        <td rowspan="15" style="width: 25%; vertical-align: top">
                                                                            <div class="hidden-480">
                                                                                <div style="border: 1px solid #999999; padding:5px 0 0 10px;">
                                                                                    <p><strong>Products Sold:</strong>&nbsp;<?php /*<a href="product_manage_uil.php?frmName=&frmPriceFrom=&frmPriceTo=&frmStatus=1&frmCategory=0&frmWholesaler=<?php echo $objPage->arrRow[0]['pkWholesalerID']; ?>&frmSearchPressed=Yes&frmSearch=Search"><?php echo $objPage->arrSoldProductDetails[0]['qty']; ?></a>*/?> <?php echo $objPage->arrSoldProductDetails[0]['qty']; ?></p>
                                                                                    <p><strong>Total Sale:</strong>&nbsp;$ <?php echo number_format((float) $objPage->arrSoldProductDetails[0]['ip'], 2); ?></p>
                                                                                    <p><strong>Sales Commission %:</strong>&nbsp;&nbsp;&nbsp;<?php echo $objPage->arrRow[0]['Commission']; ?> %
                                                                                        <br />
                                                                                        <span style="font-size: 9px;">*To be deducted by TelaMela</span>
                                                                                    </p>
                                                                                    <p><strong>Total Pending Invoices:</strong>&nbsp; <?php echo $objPage->arrUnPaidInvoiceProductDetails[0]['TransactionStatus']; ?></p>
                                                                                     <p><strong>Total Partial Paid Invoices:</strong>&nbsp; <?php echo $objPage->arrPartialPaidInvoiceProductDetails[0]['TransactionStatus']; ?></p>
                                                                                    <p><strong>Total Paid Invoices:</strong>&nbsp; <?php echo $objPage->arrPaidInvoiceProductDetails[0]['TransactionStatus']; ?><br /></p>
                                                                                </div>
                                                                                <div style="border: 1px solid #999999; margin-top: 20px; padding:5px 5px 0 10px;">
                                                                                    <p><strong>KPIs %:</strong>&nbsp;<?php
                                                                    $varkpi = $objGeneral->wholesalerKpi($objPage->arrRow[0]['pkWholesalerID']);
                                                                    echo $varkpi['kpi'];
                                                                            ?></p>


                                                                                    <p class="req"><strong>Warning!</strong></p>
                                                                                    <?php foreach ($objPage->arrWarning as $kWar => $valWar) { ?>
                                                                                        <p align="justify">
                                                                                            <?php echo $valWar['WarningText']; ?></p>
                                                                                        <p align="right" style="font-size: 10px;">
                                                                                            <?php echo $objCore->defaultDateTime($valWar['WarningDateAdded'], DATE_TIME_FORMAT_SITE); ?>
                                                                                        </p>
                                                                                        <p>&nbsp;</p>
                                                                                    <?php } ?>
                                                                                </div>
                                                                                <div style="border: 1px solid #999999; margin-top: 20px; padding:5px 5px 0 10px;">
                                                                                    <p><strong>Shipping Gateway(s):</strong>
                                                                                        <br /><br />

                                                                                        <?php
                                                                                        foreach ($objPage->arrShippingList as $kShip => $vShip) {
                                                                                            if (in_array($vShip['pkShippingGatewaysID'], $objPage->arrRow[0]['shippingDetails'])) {
                                                                                                echo $vShip['ShippingTitle'] . '<br /><br />';
                                                                                            }
                                                                                        }
                                                                                        ?>
                                                                                    </p>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>About Company: </td>
                                                                        <td>
                                                                            <p align="justify" style="word-break:break-all"><?php echo $objPage->arrRow[0]['AboutCompany']; ?></p>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Services: </td>
                                                                        <td>
                                                                            <?php echo $objPage->arrRow[0]['Services']; ?>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="2" class="detailshead">Company Address</td>

                                                                    </tr>
                                                                    <tr>
                                                                        <td>Address1: </td>
                                                                        <td>
                                                                            <?php echo $objPage->arrRow[0]['CompanyAddress1']; ?>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Address2: </td>
                                                                        <td>
                                                                            <?php echo $objPage->arrRow[0]['CompanyAddress2']; ?>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>City: </td>
                                                                        <td>
                                                                            <?php echo $objPage->arrRow[0]['CompanyCity']; ?>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Country: </td>
                                                                        <td>
                                                                            <?php echo $objPage->arrRow[0]['name']; ?>
                                                                        </td>
                                                                    </tr>
<!--                                                                    <tr>
                                                                        <td>Region: </td>
                                                                        <td>
                                                                            <?php //echo $objPage->arrRow[0]['RegionName']; ?>
                                                                        </td>
                                                                    </tr>-->
                                                                    <tr>
                                                                        <td>Postal Code: </td>
                                                                        <td>
                                                                            <?php echo $objPage->arrRow[0]['CompanyPostalCode']; ?>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Website: </td>
                                                                        <td>
                                                                            <?php echo $objPage->arrRow[0]['CompanyWebsite']; ?>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Login Email: </td>
                                                                        <td>
                                                                            <?php echo $objPage->arrRow[0]['CompanyEmail']; ?>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Paypal Email: </td>
                                                                        <td>
                                                                            <?php echo $objPage->arrRow[0]['PaypalEmail']; ?>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Phone: </td>
                                                                        <td>
                                                                            <?php echo $objPage->arrRow[0]['CompanyPhone']; ?>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Fax: </td>
                                                                        <td>
                                                                            <?php echo $objPage->arrRow[0]['CompanyFax']; ?>&nbsp;
                                                                        </td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td colspan="3" class="detailshead">Contact Person</td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td>Name: </td>
                                                                        <td colspan="2"><?php echo $objPage->arrRow[0]['ContactPersonName']; ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td> Position: </td>
                                                                        <td colspan="2"><?php echo $objPage->arrRow[0]['ContactPersonPosition']; ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td> Phone/mobile:</td>
                                                                        <td colspan="2"><?php echo $objPage->arrRow[0]['ContactPersonPhone']; ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td> Email:</td>
                                                                        <td colspan="2"><?php echo $objPage->arrRow[0]['ContactPersonEmail']; ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Postal Address:  </td>
                                                                        <td colspan="2"><?php echo $objPage->arrRow[0]['ContactPersonAddress']; ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="3" class="detailshead">Director/Owner Information</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Name:</td>
                                                                        <td colspan="2"><?php echo $objPage->arrRow[0]['OwnerName']; ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Phone/mobile:  </td>
                                                                        <td colspan="2"><?php echo $objPage->arrRow[0]['OwnerPhone']; ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Email:</td>
                                                                        <td colspan="2"><?php echo $objPage->arrRow[0]['OwnerEmail']; ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Postal Address:</td>
                                                                        <td colspan="2"><?php echo $objPage->arrRow[0]['OwnerAddress']; ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="3" class="detailshead">Trade Reference1</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Name:</td>
                                                                        <td colspan="2"><?php echo $objPage->arrRow[0]['Ref1Name']; ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Phone/mobile:</td>
                                                                        <td colspan="2"><?php echo $objPage->arrRow[0]['Ref1Phone']; ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Email: </td>
                                                                        <td colspan="2"><?php echo $objPage->arrRow[0]['Ref1Email']; ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Company Name: </td>
                                                                        <td colspan="2"><?php echo $objPage->arrRow[0]['Ref1CompanyName']; ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Company Address:</td>
                                                                        <td colspan="2"><?php echo $objPage->arrRow[0]['Ref1CompanyAddress']; ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="3" class="detailshead">Trade Reference 2</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Name:</td>
                                                                        <td colspan="2"><?php echo $objPage->arrRow[0]['Ref2Name']; ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Phone/mobile:</td>
                                                                        <td colspan="2"><?php echo $objPage->arrRow[0]['Ref2Phone']; ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Email: </td>
                                                                        <td colspan="2"><?php echo $objPage->arrRow[0]['Ref2Email']; ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Company Name: </td>
                                                                        <td colspan="2"><?php echo $objPage->arrRow[0]['Ref2CompanyName']; ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Company Address:</td>
                                                                        <td colspan="2"><?php echo $objPage->arrRow[0]['Ref2CompanyAddress']; ?></td>
                                                                    </tr>

                                                                    <tr>

                                                                        <td colspan="3" class="detailshead">Trade Reference 3</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Name:</td>
                                                                        <td colspan="2"><?php echo $objPage->arrRow[0]['Ref3Name']; ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Phone/mobile: </td>
                                                                        <td colspan="2"><?php echo $objPage->arrRow[0]['Ref3Phone']; ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Email: </td>
                                                                        <td colspan="2"><?php echo $objPage->arrRow[0]['Ref3Email']; ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Company Name: </td>
                                                                        <td colspan="2"><?php echo $objPage->arrRow[0]['Ref3CompanyName']; ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Company&nbsp;Address:</td>
                                                                        <td colspan="2"><?php echo $objPage->arrRow[0]['Ref3CompanyAddress']; ?></td>
                                                                    </tr>
                                                                     <tr>
                                                                        <td>Reference Doc:</td>
                                                                        <td colspan="2"><?php 
                                                                        $clientDoc=explode(',',$objPage->arrRow[0]['documentAttech']);
                                                                        $clientDoc1=explode(',',$objPage->arrRow[0]['documentNameAttech']);
                                                                         if(count($clientDoc)>1){
                                                                             foreach($clientDoc as $key=>$clientDocVal){ ?>
                                                                                <a href="<?php echo $_SERVER['PHP_SELF']?>?ac=down&file=<?php echo $clientDoc1[$key];?>"><?php echo $clientDocVal;?></a><br>
                                                                             <?php
                                                                             }
                                                                         }else{
                                                                             echo 'There are no documents uploaded by the applicant.
';
                                                                         }
                                                                         ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="3">
                                                                            <div class="form-actions">
                                                                                <?php
                                                                                $varsel = 'btn-blue';
                                                                                ?>
                                                                                <?php if ($objPage->arrRow[0]['WholesalerStatus'] == 'pending') { ?>

                                                                                    <a id="buttonDecoration" onclick="approveStatus('<?php echo $objPage->arrRow[0]['pkWholesalerID']; ?>','approve','<?php echo $objPage->arrRow[0]['CompanyEmail']; ?>');" class="btn <?php echo $varsel; ?>">Approve</a>
                                                                                    <a id="buttonDecoration" onclick="approveStatus('<?php echo $objPage->arrRow[0]['pkWholesalerID']; ?>','reject','<?php echo $objPage->arrRow[0]['CompanyEmail']; ?>');" class="btn">Reject</a>
                                                                                    <?php
                                                                                    $varsel = '';
                                                                                }
                                                                                ?>

                                                                                <!--<a id="buttonDecoration" href="wholesaler_edit_uil.php?id=<?php echo $objPage->arrRow[0]['pkWholesalerID']; ?>&type=edit" class="btn <?php echo $varsel; ?>">Edit</a>-->
                                                                                <a id="buttonDecoration" href="<?php echo $_SERVER['HTTP_REFERER']; ?>" class="btn"><i class="icon-circle-arrow-left"></i> <?php echo ADMIN_BACK_BUTTON; ?></a>


                                                                            </div>

                                                                        </td>
                                                                    </tr>

                                                                <?php } else { ?>
                                                                    <tr>
                                                                        <td><?php echo ADMIN_NO_RECORD_FOUND; ?></td>
                                                                    </tr>
                                                                <?php } ?>

                                                            </tbody>

                                                        </table>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php } else { ?>
                        <table width="100%">
                            <tr>
                                <th align="left"><?php echo ADMIN_USER_PERMISSION_TITLE; ?></th></tr>
                            <tr><td><?php echo ADMIN_USER_PERMISSION_MSG; ?></td></tr>
                        </table>

                    <?php }
                    ?>


                </div>
            </div>
             <?php require_once('inc/footer.inc.php'); ?>
        </div>

    </body>
</html>
