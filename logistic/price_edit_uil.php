<?php
require_once '../common/config/config.inc.php';

//pre(CONTROLLERS_LOGISTIC_PATH);
require_once CONTROLLERS_LOGISTIC_PATH . FILENAME_ZONE_PRICE_CTRL;
//pre($objPage->arrRow);
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
        <link rel="shortcut icon" href="../admin/img/favicon.ico" />
        <title><?php echo ADMIN_PANEL_NAME; ?> : Add-Zone</title>
        <?php require_once '../admin/inc/common_css_js.inc.php'; ?>
        <script type="text/javascript" src="<?php echo JS_PATH; ?>admin_js.js"></script>
        <style>
            .zone-country .input-xlarge{ width:210px !important}  
            .mapClass {
                height: 400px;
            }
            body .modal-body {
                width: 750px;
                margin-left:-100px;
            }
            .label-csc label{ display:  inline-block}
            .label-csc a{ display:inline-block; vertical-align: middle; margin-left:20px}
            .formactionleft{margin-left: 0px !important;
                            padding-left: 20px !important;}

        </style>
        <script>
            var modeli = null;
            var modelj = null;
            var fromTo = null;
            var randomCityVar = null;
            var noOfZones = [];

            var address = '<?php echo $_SESSION['sessLogisticCountry']; ?>';

            function validatezone() {
                var breakOut = false;
                $('select.countrycheck').each(function () {
                    var current = $(this).val();
                    if ($.trim(current) == '')
                    {
                        $(this).focus();
                        breakOut = true;
                        return false;
                    }

                });

                if (breakOut) {
                    alert(" From Country Name is Required!");
                    breakOut = false;
                    return false;
                }
                var breakto = false;
                $('select.countrytocheck').each(function () {
                    var current = $(this).val();
                    if ($.trim(current) == '')
                    {
                        $(this).focus();
                        breakto = true;
                        return false;
                    }

                });

                if (breakto) {
                    alert(" To Country Name is Required!");
                    breakto = false;
                    return false;
                }

//  alert(e);
//   
//    //country return""==e.frmCompanyName.value?(alert("Company Name is Required!"),e.frmCompanyName.focus(),!1):""==e.frmAboutCompany.value?(alert("About Company is Required!"),e.frmAboutCompany.focus(),!1):e.frmAboutCompany.value.length<200?(alert("Minimum 200 words required About Company"),e.frmAboutCompany.focus(),!1):""==e.frmCompanyAddress1.value?(alert("Address1 is Required!"),e.frmCompanyAddress1.focus(),!1):""==e.frmCompanyCity.value?(alert("City is Required!"),e.frmCompanyCity.focus(),!1):"0"==e.frmCompanyCountry.value?(alert("Please Select Country!"),e.frmCompanyCountry.focus(),!1):""==e.frmCompanyPostalCode.value?(alert("PostalCode is Required!"),e.frmCompanyPostalCode.focus(),!1):1==IsDigits(e.frmCompanyPostalCode.value)?(alert("Please enter valid PostalCode!"),e.frmCompanyPostalCode.focus(),!1):""==e.frmCompanyEmail.value?(alert("Company Email is Required!"),e.frmCompanyEmail.focus(),!1):0==AcceptEmail(e.frmCompanyEmail.value)?(alert("Please enter valid Company Email!"),e.frmCompanyEmail.focus(),!1):"1"==e.frmCEmail.value?(alert("Email Already in use. Please enter different email!"),e.frmCompanyEmail.focus(),!1):""==e.frmPassword.value?(alert("Password is Required!"),e.frmPassword.focus(),!1):6>$.trim(e.frmPassword.value.length)?(alert("Password should be atleast 6 character long!"),e.frmPassword.focus(),!1):""==e.frmConfirmPassword.value?(alert("Confirm Password is Required!"),e.frmConfirmPassword.focus(),!1):e.frmPassword.value!=e.frmConfirmPassword.value?(alert("Confirm Password must be same!"),e.frmConfirmPassword.focus(),!1):""==e.frmPaypalEmail.value?(alert("Paypal Email is Required!"),e.frmPaypalEmail.focus(),!1):0==AcceptEmail(e.frmPaypalEmail.value)?(alert("Please enter valid Paypals Email!"),e.frmPaypalEmail.focus(),!1):""==e.frmCompanyPhone.value?(alert("Company Phone is Required!"),e.frmCompanyPhone.focus(),!1):0==IsPhone(e.frmCompanyPhone.value)?(alert("Please enter Valid Phone Number!"),e.frmCompanyPhone.focus(),!1):""==e.frmContactPersonName.value?(alert("Contact Person Name is Required!"),e.frmContactPersonName.focus(),!1):""==e.frmContactPersonPosition.value?(alert("Contact Person Position is Required!"),e.frmContactPersonPosition.focus(),!1):""==e.frmContactPersonPhone.value?(alert("Contact Person Phone/Mobile is Required!"),e.frmContactPersonPhone.focus(),!1):0==IsPhone(e.frmContactPersonPhone.value)?(alert("Please enter valid phone number !"),e.frmContactPersonPhone.focus(),!1):""==e.frmContactPersonEmail.value?(alert("Contact Person Email is Required!"),e.frmContactPersonEmail.focus(),!1):0==AcceptEmail(e.frmContactPersonEmail.value)?(alert("Please enter valid Contact Person Email!"),e.frmContactPersonEmail.focus(),!1):""==e.frmContactPersonAddress.value?(alert("Contact Person Address is Required!"),e.frmContactPersonAddress.focus(),!1):""==e.frmOwnerName.value?(alert("Director/Owner Name is Required!"),e.frmOwnerName.focus(),!1):""==e.frmOwnerPhone.value?(alert("Director/Owner Phone is Required!"),e.frmOwnerPhone.focus(),!1):0==IsPhone(e.frmOwnerPhone.value)?(alert("Please enter valid phone number!"),e.frmOwnerPhone.focus(),!1):""==e.frmOwnerEmail.value?(alert("Director/Owner Email is Required!"),e.frmOwnerEmail.focus(),!1):0==AcceptEmail(e.frmOwnerEmail.value)?(alert("Please enter valid Director/Owner Email!"),e.frmOwnerEmail.focus(),!1):""==e.frmOwnerAddress.value?(alert("Director/Owner Address is Required!"),e.frmOwnerAddress.focus(),!1):""==e.frmRef1Name.value?(alert("Reference1 Name is Required!"),e.frmRef1Name.focus(),!1):""==e.frmRef1Phone.value?(alert("Reference1 Phone/mobile is Required!"),e.frmRef1Phone.focus(),!1):0==IsPhone(e.frmRef1Phone.value)?(alert("Please enter valid phone number!"),e.frmRef1Phone.focus(),!1):""==e.frmRef1Email.value?(alert("Reference1 Email is Required!"),e.frmRef1Email.focus(),!1):0==AcceptEmail(e.frmRef1Email.value)?(alert("Please enter valid Reference1 Email!"),e.frmRef1Email.focus(),!1):""==e.frmRef1CompanyName.value?(alert("Reference1 Company Name is Required!"),e.frmRef1CompanyName.focus(),!1):""==e.frmRef1CompanyAddress.value?(alert("Reference1 Address is Required!"),e.frmRef1CompanyAddress.focus(),!1):""==e.frmRef2Name.value?(alert("Reference2 Name is Required!"),e.frmRef2Name.focus(),!1):""==e.frmRef2Phone.value?(alert("Reference2 Phone/mobile is Required!"),e.frmRef2Phone.focus(),!1):0==IsPhone(e.frmRef2Phone.value)?(alert("Please enter valid phone number!"),e.frmRef2Phone.focus(),!1):""==e.frmRef2Email.value?(alert("Reference2 Email is Required!"),e.frmRef2Email.focus(),!1):0==AcceptEmail(e.frmRef2Email.value)?(alert("Please enter valid Reference2 Email!"),e.frmRef2Email.focus(),!1):""==e.frmRef2CompanyName.value?(alert("Reference2 Company Name is Required!"),e.frmRef2CompanyName.focus(),!1):""==e.frmRef2CompanyAddress.value?(alert("Reference2 Address is Required!"),e.frmRef2CompanyAddress.focus(),!1):""==e.frmRef3Name.value?(alert("Reference3 Name is Required!"),e.frmRef3Name.focus(),!1):""==e.frmRef3Phone.value?(alert("Reference3 Phone/mobile is Required!"),e.frmRef3Phone.focus(),!1):0==IsPhone(e.frmRef3Phone.value)?(alert("Please enter valid phone number!"),e.frmRef3Phone.focus(),!1):""==e.frmRef3Email.value?(alert("Reference3 Email is Required!"),e.frmRef3Email.focus(),!1):0==AcceptEmail(e.frmRef3Email.value)?(alert("Please enter valid Reference3 Email!"),e.frmRef3Email.focus(),!1):""==e.frmRef3CompanyName.value?(alert("Reference3 Company Name is Required!"),e.frmRef3CompanyName.focus(),!1):""==e.frmRef3CompanyAddress.value?(alert("Reference3 Address is Required!"),e.frmRef3CompanyAddress.focus(),!1):!0
//    return""==e.country.value?(alert("Country Name is Required!")):!0
            }
        </script>
    </head>
    <body>
        <?php // pre($_SESSION); ?>
        <?php require_once '../admin/inc/header_logistic.inc.php'; ?>
        <div class="container-fluid" id="content">
            <div id="main">
                <div class="container-fluid">
                    <div class="page-header">
                        <div class="pull-left">
                            <h1>Edit-Price</h1>
                        </div>

                    </div>
                    <div class="breadcrumbs">
                        <ul>
                            <li>
                                <a href="dashboard_uil.php">Home</a>
                                <i class="icon-angle-right"></i>
                            </li>

                            <li>
                                <a href="price_manage_uil.php">Price</a>
                                <i class="icon-angle-right"></i>
                            </li>

                            <li>
                                <span>Edit-Price</span>
                            </li>
                        </ul>
                        <div class="close-bread">
                            <a href="#"><i class="icon-remove"></i></a>
                        </div>
                    </div>


                    <?php //require_once('javascript_disable_message.php'); ?>
                    <?php if ($_SESSION['sessUserType'] == 'super-admin' || $_SESSION['sessLogistictype'] == 'logistic-admin') { ?>
                        <?php $httpRef = (isset($_REQUEST['httpRef'])) ? $_REQUEST['httpRef'] : $_SERVER['HTTP_REFERER']; ?>
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
                                        <h3>Edit-Price</h3>
                                        <a id="buttonDecoration" href="price_manage_uil.php" class="btn pull-right"><i class="icon-circle-arrow-left"></i> <?php echo ADMIN_BACK_BUTTON; ?></a>
                                    </div>
                                    <form action="" name="frmzoneadd" method="post" id="frm_page" onsubmit="return validateprice();" class='form-horizontal form-bordered'>
                                        <div class="box-content nopadding">
                                            <div class="row-fluid">
                                                <div class="span12">
                                                    <div class="box box-color box-bordered ">
                                                        <?php if (!empty($objPage->arrRow['detailById'])) { ?>
                                                            <div class="nopadding">                                                            
                                                                <div class="control-group"> 

                                                                    <div class="control-block" style="">
                                                                        <div class="TemplateBlock">
                                                                            <table class="table table-bordered dataTable-scroll-x" style="border: 1px solid #ccc;margin-bottom: 25px;float: left;">

                                                                                <tr>
                                                                                    <td> *Zone</td>
                                                                                    <td>
                                                                                        <?php
//                                                                                        pre($objPage->arrRow['detailById']);
//                                                                                        $currentzonearry = $objGeneral->zonelistofcurrentlogist($_SESSION['sessLogistic']);
//                                                                                        $SelectedZone = $objPage->arrRow['detailById'][0]['zonetitleid'];
//                                                                                        echo $objGeneral->zonelistofcurrentlogistichtml($currentzonearry, 'zoneid[]', 'zoneid', $SelectedZone, 'Select Zone', 0, 'class="select2-me1 input-xlarge zoneid" ', 1, 0, 1);
                                                                                        ?>
                                                                                        <input type="input" disabled="disabled"  value="<?php echo $objPage->arrRow['detailById'][0]['title']; ?>" >
                                                                                        <input type="hidden" name="zoneid[]" value="<?php echo $objPage->arrRow['detailById'][0]['zonetitleid']; ?>" >

                                                                                    </td>
                                                                                    <td>&nbsp;</td>
                                                                                    <td>&nbsp;</td>

                                                                                </tr>
                                                                                <tr>
                                                                                    <td> *Shipping Method</td>
                                                                                    <td>
                                                                                        <?php
//                                                                                        $shippingmethodarray = $objGeneral->shippingmethodlist();
//
//                                                                                        $SelectedMethod = $objPage->arrRow['detailById'][0]['shippingmethod'];
//
//                                                                                        echo $objGeneral->shippingmethodlisthtml($shippingmethodarray, 'shippingmethod[]', 'shippingmethodid', $SelectedMethod, 'Select Shipping Method', 0, 'class="select2-me1 input-xlarge" ', 1, 0, 1);
                                                                                        
                                                                                        ?>
                                                                                        <input type="input" disabled="disabled"  value="<?php echo $objPage->arrRow['detailById'][0]['MethodName']; ?>" >
                                                                                        <input type="hidden" name="shippingmethod[]" value="<?php echo $objPage->arrRow['detailById'][0]['shippingmethod']; ?>" >

                                                                                    </td>
                                                                                    <td>&nbsp;</td>
                                                                                    <td>&nbsp;</td>

                                                                                </tr>
                                                                                <tr>
                                                                                    <td> *Maximum Dimension(L*W*H)</td>
                                                                                    <td> <input type="number" name="length[]" min="0" step=0.01 value="<?php echo $objPage->arrRow['detailById'][0]['maxlength']; ?>" placeholder="cm"/></td>
                                                                                    <td> <input type="number" name="width[]" min="0" step=0.01 value="<?php echo $objPage->arrRow['detailById'][0]['maxwidth']; ?>" placeholder="cm"/></td>
                                                                                    <td> <input type="number" name="height[]" min="0" step=0.01 value="<?php echo $objPage->arrRow['detailById'][0]['maxheight']; ?>" placeholder="cm"/></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td> *Weight(kg)</td>
                                                                                    <td> <input type="number" name="minweight[]" min="0" step=0.01 value="<?php echo $objPage->arrRow['detailById'][0]['minkg']; ?>" placeholder="Min (kg)"/></td>
                                                                                    <td> <input type="number" name="maxweight[]" min="0" step=0.01 value="<?php echo $objPage->arrRow['detailById'][0]['maxkg']; ?>" placeholder="Max (kg)"/></td>
                                                                                    <td>&nbsp;</td>
                                                                                </tr>

                                                                                <tr>
                                                                                    <td> *Cost Per Kg</td>
                                                                                    <td> <input type="number" name="cost[]" min="0" step=0.01 value="<?php echo $objPage->arrRow['detailById'][0]['costperkg']; ?>" placeholder="cost"/></td>
                                                                                    <td>&nbsp;</td>
                                                                                    <td>&nbsp;</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td> Handling cost ($) per item</td>
                                                                                    <td> <input type="number" name="handlingcost[]" min="0" step=0.01 value="<?php echo $objPage->arrRow['detailById'][0]['handlingcost']; ?>" placeholder="handlingcost"/></td>
                                                                                    <td>&nbsp;</td>
                                                                                    <td>&nbsp;</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td> Fragile Handling cost ($)</td>
                                                                                    <td> <input type="number" name="fragilecost[]" step=0.01 min="0"value="<?php echo $objPage->arrRow['detailById'][0]['fragilecost']; ?>" placeholder="fragilecost"/></td>
                                                                                    <td>&nbsp;</td>
                                                                                    <td>&nbsp;</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td> *Delivery (Days)</td>
                                                                                    <td> <input type="number" name="deliveryday[]" min="0"value="<?php echo $objPage->arrRow['detailById'][0]['deliveryday']; ?>" placeholder="days"/></td>
                                                                                    <td>&nbsp;</td>
                                                                                    <td>&nbsp;</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td> Cubic weight (cm3/kg)</td>
                                                                                    <td> <input type="number" name="cubic[]" step=0.01 min="0"value="<?php echo $objPage->arrRow['detailById'][0]['cubicweight']; ?>" placeholder="cubicweight"/></td>
                                                                                    <td>&nbsp;</td>
                                                                                    <td>&nbsp;</td>
                                                                                </tr>
                                                                            </table>

                                                                        </div>
                                                                    </div>

                                                                </div>
                                                                <div class="form-actions formactionleft">     
                                                                    <input type="hidden" value="edit" name="frmHidenEdit" >
                                                                    <input type="hidden" value="<?php echo $objPage->arrRow['detailById'][0]['pkpriceid']; ?>" name="pkpriceid" >
                                                                    <input type="hidden" value="<?php echo $objPage->arrRow['detailById'][0]['pricestatus']; ?>" name="pricestatus" >
                                                                    <input type="hidden" value="<?php echo $objPage->arrRow['detailById'][0]['prepriceid']; ?>" name="prepriceid" >
                                                                    <button style="margin-left: -8px;" name="frmBtnSubmit" type="submit" class="btn btn-blue"  value="<?php echo ADMIN_SUBMIT_BUTTON; ?>" ><?php echo ADMIN_SUBMIT_BUTTON; ?></button>  
                                                                </div>

                                                            </div>
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
                                    </form>
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
            <?php require_once('../admin/inc/footer.inc.php'); ?>

        </div>

    </body>
</html>
