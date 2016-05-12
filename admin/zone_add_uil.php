<?php
require_once '../common/config/config.inc.php';

//pre(CONTROLLERS_LOGISTIC_PATH);
require_once CONTROLLERS_ADMIN_PATH . FILENAME_ZONE_CTRL;
//pre($_SESSION);
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
                /*width: 350px;*/
            }
            body .modal-body {
                width: 750px;
                margin-left:-100px;
            }
            .label-csc label{ display:  inline-block}
            .label-csc a{ display:inline-block; vertical-align: middle; margin-left:20px}
            .formactionleft{margin-left: 0px !important;
                            padding-left: 20px !important;
            }
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
                //  countrytocheck 
                //    //country return""==e.frmCompanyName.value?(alert("Company Name is Required!"),e.frmCompanyName.focus(),!1):""==e.frmAboutCompany.value?(alert("About Company is Required!"),e.frmAboutCompany.focus(),!1):e.frmAboutCompany.value.length<200?(alert("Minimum 200 words required About Company"),e.frmAboutCompany.focus(),!1):""==e.frmCompanyAddress1.value?(alert("Address1 is Required!"),e.frmCompanyAddress1.focus(),!1):""==e.frmCompanyCity.value?(alert("City is Required!"),e.frmCompanyCity.focus(),!1):"0"==e.frmCompanyCountry.value?(alert("Please Select Country!"),e.frmCompanyCountry.focus(),!1):""==e.frmCompanyPostalCode.value?(alert("PostalCode is Required!"),e.frmCompanyPostalCode.focus(),!1):1==IsDigits(e.frmCompanyPostalCode.value)?(alert("Please enter valid PostalCode!"),e.frmCompanyPostalCode.focus(),!1):""==e.frmCompanyEmail.value?(alert("Company Email is Required!"),e.frmCompanyEmail.focus(),!1):0==AcceptEmail(e.frmCompanyEmail.value)?(alert("Please enter valid Company Email!"),e.frmCompanyEmail.focus(),!1):"1"==e.frmCEmail.value?(alert("Email Already in use. Please enter different email!"),e.frmCompanyEmail.focus(),!1):""==e.frmPassword.value?(alert("Password is Required!"),e.frmPassword.focus(),!1):6>$.trim(e.frmPassword.value.length)?(alert("Password should be atleast 6 character long!"),e.frmPassword.focus(),!1):""==e.frmConfirmPassword.value?(alert("Confirm Password is Required!"),e.frmConfirmPassword.focus(),!1):e.frmPassword.value!=e.frmConfirmPassword.value?(alert("Confirm Password must be same!"),e.frmConfirmPassword.focus(),!1):""==e.frmPaypalEmail.value?(alert("Paypal Email is Required!"),e.frmPaypalEmail.focus(),!1):0==AcceptEmail(e.frmPaypalEmail.value)?(alert("Please enter valid Paypals Email!"),e.frmPaypalEmail.focus(),!1):""==e.frmCompanyPhone.value?(alert("Company Phone is Required!"),e.frmCompanyPhone.focus(),!1):0==IsPhone(e.frmCompanyPhone.value)?(alert("Please enter Valid Phone Number!"),e.frmCompanyPhone.focus(),!1):""==e.frmContactPersonName.value?(alert("Contact Person Name is Required!"),e.frmContactPersonName.focus(),!1):""==e.frmContactPersonPosition.value?(alert("Contact Person Position is Required!"),e.frmContactPersonPosition.focus(),!1):""==e.frmContactPersonPhone.value?(alert("Contact Person Phone/Mobile is Required!"),e.frmContactPersonPhone.focus(),!1):0==IsPhone(e.frmContactPersonPhone.value)?(alert("Please enter valid phone number !"),e.frmContactPersonPhone.focus(),!1):""==e.frmContactPersonEmail.value?(alert("Contact Person Email is Required!"),e.frmContactPersonEmail.focus(),!1):0==AcceptEmail(e.frmContactPersonEmail.value)?(alert("Please enter valid Contact Person Email!"),e.frmContactPersonEmail.focus(),!1):""==e.frmContactPersonAddress.value?(alert("Contact Person Address is Required!"),e.frmContactPersonAddress.focus(),!1):""==e.frmOwnerName.value?(alert("Director/Owner Name is Required!"),e.frmOwnerName.focus(),!1):""==e.frmOwnerPhone.value?(alert("Director/Owner Phone is Required!"),e.frmOwnerPhone.focus(),!1):0==IsPhone(e.frmOwnerPhone.value)?(alert("Please enter valid phone number!"),e.frmOwnerPhone.focus(),!1):""==e.frmOwnerEmail.value?(alert("Director/Owner Email is Required!"),e.frmOwnerEmail.focus(),!1):0==AcceptEmail(e.frmOwnerEmail.value)?(alert("Please enter valid Director/Owner Email!"),e.frmOwnerEmail.focus(),!1):""==e.frmOwnerAddress.value?(alert("Director/Owner Address is Required!"),e.frmOwnerAddress.focus(),!1):""==e.frmRef1Name.value?(alert("Reference1 Name is Required!"),e.frmRef1Name.focus(),!1):""==e.frmRef1Phone.value?(alert("Reference1 Phone/mobile is Required!"),e.frmRef1Phone.focus(),!1):0==IsPhone(e.frmRef1Phone.value)?(alert("Please enter valid phone number!"),e.frmRef1Phone.focus(),!1):""==e.frmRef1Email.value?(alert("Reference1 Email is Required!"),e.frmRef1Email.focus(),!1):0==AcceptEmail(e.frmRef1Email.value)?(alert("Please enter valid Reference1 Email!"),e.frmRef1Email.focus(),!1):""==e.frmRef1CompanyName.value?(alert("Reference1 Company Name is Required!"),e.frmRef1CompanyName.focus(),!1):""==e.frmRef1CompanyAddress.value?(alert("Reference1 Address is Required!"),e.frmRef1CompanyAddress.focus(),!1):""==e.frmRef2Name.value?(alert("Reference2 Name is Required!"),e.frmRef2Name.focus(),!1):""==e.frmRef2Phone.value?(alert("Reference2 Phone/mobile is Required!"),e.frmRef2Phone.focus(),!1):0==IsPhone(e.frmRef2Phone.value)?(alert("Please enter valid phone number!"),e.frmRef2Phone.focus(),!1):""==e.frmRef2Email.value?(alert("Reference2 Email is Required!"),e.frmRef2Email.focus(),!1):0==AcceptEmail(e.frmRef2Email.value)?(alert("Please enter valid Reference2 Email!"),e.frmRef2Email.focus(),!1):""==e.frmRef2CompanyName.value?(alert("Reference2 Company Name is Required!"),e.frmRef2CompanyName.focus(),!1):""==e.frmRef2CompanyAddress.value?(alert("Reference2 Address is Required!"),e.frmRef2CompanyAddress.focus(),!1):""==e.frmRef3Name.value?(alert("Reference3 Name is Required!"),e.frmRef3Name.focus(),!1):""==e.frmRef3Phone.value?(alert("Reference3 Phone/mobile is Required!"),e.frmRef3Phone.focus(),!1):0==IsPhone(e.frmRef3Phone.value)?(alert("Please enter valid phone number!"),e.frmRef3Phone.focus(),!1):""==e.frmRef3Email.value?(alert("Reference3 Email is Required!"),e.frmRef3Email.focus(),!1):0==AcceptEmail(e.frmRef3Email.value)?(alert("Please enter valid Reference3 Email!"),e.frmRef3Email.focus(),!1):""==e.frmRef3CompanyName.value?(alert("Reference3 Company Name is Required!"),e.frmRef3CompanyName.focus(),!1):""==e.frmRef3CompanyAddress.value?(alert("Reference3 Address is Required!"),e.frmRef3CompanyAddress.focus(),!1):!0
                //    return""==e.country.value?(alert("Country Name is Required!")):!0
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
                            <h1>Add-Zone</h1>
                        </div>

                    </div>
                    <div class="breadcrumbs">
                        <ul>
                            <li>
                                <a href="dashboard_uil.php">Home</a>
                                <i class="icon-angle-right"></i>
                            </li>

                            <li>
                                <a href="zone_listing_uil.php?type=listingzones&LogisticId=<?php echo $objPage->logisticId; ?>&countryId=<?php echo $objPage->countryId; ?>">Zone</a>
                                <i class="icon-angle-right"></i>
                            </li>

                            <li>
                                <span>Add-Zone</span>
                            </li>
                        </ul>
                        <div class="close-bread">
                            <a href="#"><i class="icon-remove"></i></a>
                        </div>
                    </div>


                    <?php //require_once('javascript_disable_message.php'); ?>
                    <?php //if ($_SESSION['sessUserType'] == 'super-admin') { ?>
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
                                    <h3>Add-Zone</h3>
                                    <a id="buttonDecoration" href="setup_manage_uil.php" class="btn pull-right"><i class="icon-circle-arrow-left"></i> <?php echo ADMIN_BACK_BUTTON; ?></a>
                                </div>
                                <form action="" name="frmzoneadd" method="post" id="frm_page" onsubmit="return validatezone();" class='form-horizontal form-bordered'>
                                    <div class="box-content nopadding">
                                        <div class="row-fluid">
                                            <div class="span12">
                                                <div class="box box-color box-bordered ">
                                                    <div class="nopadding">                                                            


                                                        <div class="control-group multiplezonebolck">
                                                            <!--                                                                <label for="textarea" class="control-label">*Zone:</label>-->
                                                            <?php
                                                            $i = 0;
                                                            $j = 0;
                                                            ?>
                                                            <div class="controls1 controles_<?php echo $j; ?>  zone-country" style="padding: 20px ">

                                                                <div class="DyZoneDiv_<?php echo $j; ?>" style="float:left;border:1px solid #ccc; width: 90%;text-align: center; position:relative;padding:10px">
                                                                    <h4 class="h4ZoneEdit" style="top:0; left:20px">zone<?php echo $objPage->zoneTitleNo; ?></h4>

                                                                    <table  style="border: 1px solid #ccc;box-shadow: 0 0 6px #ccc; margin-bottom:10px;"class="table table-bordered dataTable-scroll-x" id="productRow tableClass_<?php echo $j . '_' . $i; ?>">

                                                                        <tr>
                                                                            <td>
                                                                                <label>From/Source</label>
                                                                            </td>
                                                                            <td>
                                                                                <?php
                                                                                $abc = $objGeneral->getCountry();
                                                                                //$frmStateid = '"frmStateid_' . $i . '"';
                                                                                $frmStateid = '"frmStateid_' . $j . '_' . $i . '"';
                                                                                $fcountry_id = 'frmcountryid_' . $j . '_' . $i;
                                                                                $frmdistance = 'frmdistance_' . $i;
                                                                                $incrvar = 'incrvar_' . $i;
                                                                                $dynamicmapid = '"map_' . $j . '_' . $i . '"';
                                                                                $SelectedCountry = $objPage->CmpcountryId;
                                                                                $stateidcurrentcountry = $objGeneral->statelistbycurrentlogincountry($objPage->CmpcountryId);
                                                                                // pre($_SESSION['sessLogisticPortal']);
                                                                                $html_entity = "DynamicMapId=$dynamicmapid onchange='showCountryState(this.value, 0, " . $frmStateid . ", this);' class='select2-me1 countrycheck input-xlarge changeAddress' style='width:auto' ";
                                                                                echo $objGeneral->CountryNameLogistic($abc, 'fcountry[' . $j . '][]', $fcountry_id, $SelectedCountry, 'Select Country', '', $html_entity, '1', '1');
                                                                                ?>
<!--                                                                                <input type="hidden" name="<?php echo $incrvar ?>" value="<?php echo $i ?>"/>-->
                                                                                <input type="hidden" name="title[<?php echo $j; ?>]" class="zonetitle"value="zone<?php echo $objPage->zoneTitleNo; ?>">
                                                                            </td>
                                                                            <?php //$frmcityid = 'frmcityid_' . $i; ?>
                                                                            <?php $frmcityid = 'frmcityid_' . $j . '_' . $i; ?>
                                                                            <td>

                                                                                <select name="fstate[<?php echo $j; ?>][]" onchange="showStateCity(this.value, 0, '<?php echo $frmcityid; ?>', this, '<?php echo $j; ?>', '<?php echo $i; ?>');" id="frmStateid_<?php echo $j . '_' . $i; ?>"class='select2-me1 input-large statecheck'>
                                                                                    <option value="0">Select State</option>
                                                                                    <?php
                                                                                    //foreach ($gatway as $kk => $vv) {
                                                                                    //if($selectedvalue == $vv['pkShippingGatewaysID'])
                                                                                    foreach ($stateidcurrentcountry as $vv) {
                                                                                        //in_array($gatway,)
                                                                                        echo '<option value=' . $vv['id'] . '>' . $vv['name'] . '</option>';
                                                                                    }
                                                                                    //}
                                                                                    //echo $objGeneral->CountryGatwaylHtml($gatway, 'countriesgatway', 'pkShippingGatewaysID', $SelectedCountry = array(), 'Select shipping Gateway', '', '" class="select2-me input-xlarge" style="width:auto"', '1', '1');
                                                                                    ?>
                                                                                </select>
                                                                            </td>
                                                                            <td>

                                                                                <select name="fcity[<?php echo $j; ?>][]"  id="frmcityid_<?php echo $j . '_' . $i; ?>" minusI = "<?php echo $i; ?>" minusJ = "<?php echo $j; ?>"class='select2-me1 input-large citycheck'>
                                                                                    <option value="0">Select City</option>
                                                                                </select>
                                                                            </td>
                                                                            <td><input type="text" disabled="disabled" name="frmdistance[<?php echo $j; ?>][]" id="frmdistance_<?php echo $j . '_' . $i; ?>" class="distancecheck" placeholder="Distance +Km" ></td>

                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <label>To/Destination</label>
                                                                            </td>
                                                                            <td>
                                                                                <?php
                                                                                //pre();
                                                                                $abc = $objGeneral->getCountry();
                                                                                $stateidcurrentcountry = $objGeneral->statelistbycurrentlogincountry($_SESSION['sessLogisticPortal']);
                                                                                //pre($statearraybycountryid);
                                                                                $SelectedCountry = array();
                                                                                $toStateid = '"toStateid_' . $j . '_' . $i . '"';
                                                                                $tcountry_id = 'tocountryid_' . $j . '_' . $i;
                                                                                $dynamicmapid = '"mapTo_' . $j . '_' . $i . '"';
                                                                                $html_entity = "DynamicMapId=$dynamicmapid onchange='showCountryState(this.value, 0, " . $toStateid . ", this );' class='select2-me1 countrytocheck input-xlarge' style='width:auto' ";
                                                                                echo $objGeneral->CountryNameLogistic($abc, 'tcountry[' . $j . '][]', $tcountry_id, $SelectedCountry, 'Select Country', '', $html_entity, '1', '1');
                                                                                ?>
                                                                            </td>
                                                                            <?php $tocityid = 'tocityid_' . $j . '_' . $i; ?>
                                                                            <td>

                                                                                <select name="tstate[<?php echo $j; ?>][]" onchange="showStateCity(this.value, 0, '<?php echo $tocityid; ?>', this, '<?php echo $j; ?>', '<?php echo $i; ?>');" id="toStateid_<?php echo $j . '_' . $i; ?>" class='select2-me1 input-large'>
                                                                                    <option value="0">Select State</option>
                                                                                    <?php
                                                                                    //foreach ($gatway as $kk => $vv) {
                                                                                    //if($selectedvalue == $vv['pkShippingGatewaysID'])
                                                                                    foreach ($stateidcurrentcountry as $vv) {
                                                                                        //in_array($gatway,)
                                                                                        echo '<option value=' . $vv['id'] . '>' . $vv['name'] . '</option>';
                                                                                    }
                                                                                    //}
                                                                                    //echo $objGeneral->CountryGatwaylHtml($gatway, 'countriesgatway', 'pkShippingGatewaysID', $SelectedCountry = array(), 'Select shipping Gateway', '', '" class="select2-me input-xlarge" style="width:auto"', '1', '1');
                                                                                    ?>
                                                                                </select>
                                                                            </td>
                                                                            <td>

                                                                                <select name="tcity[<?php echo $j; ?>][]"  id="tocityid_<?php echo $j . '_' . $i; ?>" minusI = "<?php echo $i; ?>" minusJ = "<?php echo $j; ?>"class='select2-me1 input-large citycheckto'>
                                                                                    <option value="0">Select City</option>
                                                                                </select>
                                                                            </td>
                                                                            <td><input type="text" disabled="disabled" name="todistance[<?php echo $j; ?>][]" id="todistance_<?php echo $j . '_' . $i; ?>" class="distancecheck"  placeholder="Distance +Km" ></td>
                                                                        <input type="hidden" value="<?php echo $objPage->zoneTitleNo; ?>" name="noOfZoneField" id="noOfZoneField" >
                                                                        </tr>

                                                                        <tr class="label-csc">
                                                                            <td colspan="3"><label>From</label><a href="#" data-toggle="modal" onclick="javascript: modeli = '<?php echo $i; ?>', modelj = '<?php echo $j; ?>', fromTo = 'from'"  data-target="#myModal"> <img src="../admin/images/Globe.png"/></a></td>

                                                                            <td colspan="2"><label>To</label> <a href="#" data-toggle="modal" onclick="javascript: modeli = '<?php echo $i; ?>', modelj = '<?php echo $j; ?>', fromTo = 'to'"  data-target="#myModal"> <img src="../admin/images/Globe.png"/></a></td>
                                                                        </tr>

                                                                    </table>

                                                                </div>
                                                                <div  style="float:left; margin-left: 30px; " class="PlusMinus">

<!--                                                                        <i><span style="cursor: pointer;width:51px;"  onclick="addDynamicRowTozone(<?php echo $fcountry_id . '.value' ?><?php echo $frmStateid ?>.value,<?php echo $frmcityid ?>.value,<?php echo $frmdistance ?>.value,<?php echo $incrvar ?>.value);"><img src="../admin/images/plus.png"/></span></i>-->
                                                                    <i><span valueOfI="<?php echo $i; ?>" valueOfJ="<?php echo $j; ?>" style="cursor: pointer;width:51px;" class="addnewzoneAdmin"><img src="../admin/images/plus.png"/></span></i>
                                                                </div>
                                                            </div>


                                                        </div>
                                                        <div class="form-actions formactionleft">                        
                                                            <button name="frmBtnSubmit" type="submit" class="btn btn-blue"  value="<?php echo ADMIN_SUBMIT_BUTTON; ?>" ><?php echo ADMIN_SUBMIT_BUTTON; ?></button>  

                                                            <button  valueOfJ="<?php echo $j; ?>"name="newzone" type="button" value="addnewzone" class="btn addnewzonebolckAdmin" >Add A New Zone</button>

                                                            <input type="hidden" name="frmHidenAdd" id="frmHidenAdd" value="add" />
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php // } else {       ?>
<!--                        <table width="100%">
                        <tr>
                            <th align="left"><?php echo ADMIN_USER_PERMISSION_TITLE; ?></th></tr>
                        <tr><td><?php echo ADMIN_USER_PERMISSION_MSG; ?></td></tr>
                    </table>-->

                    <?php //}
                    ?>



                </div>
            </div>
            <?php require_once('../admin/inc/footer.inc.php'); ?>

        </div>


    </body>
</html>

<div class="modal fade modalShowClass" style="display:none;" id="myModalTo_<?php echo $j . '_' . $i; ?>" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Modal Header</h4>
            </div>
            <div class="modal-body">
                <div class="mapClass" id="mapTo_<?php echo $j . '_' . $i; ?>"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>

<!-- Modal -->
<div class="modal fade modalShowClass" id="myModal" style="display:none;" role="dialog">
    <button type="button" class="close" data-dismiss="modal" style="
            position: absolute;
            width: 28px;
            left: 652px;
            background-color: #fff;
            top: -21px;
            ">×</button>
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <!--            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Modal Header</h4>
                        </div>-->
            <div class="modal-body mapClass" id="map">
                <!--<div class="mapClass" id="map"></div>-->
            </div>
            <!--            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>-->
        </div>

    </div>
</div>

<script>
    noOfZones = <?php echo json_encode($ZoneCountEdit); ?>;
    //console.log(noOfZones);
</script>
<script src="../common/js/google-api.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA8kl6Y5NayGiy9zHR7rn4Cmu6dNnxF-Fk&callback=initMap"
async defer></script>