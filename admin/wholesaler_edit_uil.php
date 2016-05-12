<?php
require_once '../common/config/config.inc.php';
require_once CONTROLLERS_ADMIN_PATH . FILENAME_WHOLESALER_CTRL;
require_once CLASSES_ADMIN_PATH . 'class_adminuser_bll.php';
$varNum = count($objPage->arrRow[0]['pkWholesalerID']);
//pre($objPage->arrRow);

$objUser = new AdminUser();
$arrPortal = $objUser->getPortal();

foreach ($arrPortal as $k => $v) {
    $PortalIDs[] = $v['AdminCountry'];
}
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
        <title><?php echo ADMIN_PANEL_NAME; ?> : Manage Wholesaler </title>
        <?php require_once 'inc/common_css_js.inc.php'; ?>        
        <script type="text/javascript" src="<?php echo JS_PATH; ?>admin_js.js"></script>
        <script type="text/javascript">
             function ShowWholesaler() {
                var str = $('#frmCompanyCountry').val();
//                $.post("ajax.php", {action: 'ShowWholesaler', ctid: str},
//                function (data)
//                {
//                    $('#frmfkWholesalerID').html(data);
//                }
//                );
                ShowcountryportalShippingGateway(str); 
                getstatenamebycountryid(str);
            }

            function ShowcountryportalShippingGateway(str) { 
            	   
            	$.post("ajax.php",{
                    action:'Showcurrentcountrygateway',
                    ctid:str
                },
                function(data){
                        $('#shippingGateways').html('<input type="checkbox" value="All" name="all[]" id="sAll" onclick="javascript:toggleShippingOption(this);"> Select All <br>'+data);
                    });
            }
            
             function getstatenamebycountryid(countryid)
            {
                var countryid = countryid;
               $('#frmCompanyState').select2("val", "");
             $('#frmCompanyCity1').select2("val", "");
                $.ajax({
                    type: "POST",
                    url: 'ajax.php',
                    data: {action: 'showCountryState', q: countryid, },
                    success: function (data) {
                        //    console.log(data);
                        $('#frmCompanyState').html(data);
                    }
                });
            }

            function showstate()
            {
               $('#frmCompanyCity1').select2("val", "");
                var stateid = $('#frmCompanyState').val();
                //alert(countryid);
                $.ajax({
                    type: "POST",
                    url: 'ajax.php',
                    data: {action: 'showStateCity', q: stateid, },
                    success: function (data) {
                        //  console.log(data);
                        $('#frmCompanyCity1').html(data);
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
                            <h1>Edit Wholesaler</h1>
                        </div>

                    </div>
                    <div class="breadcrumbs">
                        <ul>
                            <li><a href="dashboard_uil.php">Home</a><i class="icon-angle-right"></i></li>
                            <li><a href="wholesaler_manage_uil.php">Wholesaler</a><i class="icon-angle-right"></i></li>
                            <!--<li><a href="wholesaler_edit_uil.php?id=<?php echo $_GET['id']; ?>&type=edit">Edit Wholesaler</a></li>-->
                            <li><span>Edit Wholesaler</span></li>
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
                                                <h3>
                                                    Edit Wholesaler
                                                </h3>
                                            </div>

                                            <div class="box-content nopadding">

                                                <?php require_once('javascript_disable_message.php'); ?>


                                                <?php
                                                if ($_SESSION['sessUserType'] == 'super-admin' || in_array('edit-wholesalers', $_SESSION['sessAdminPerMission'])) {
                                                    ?>

                                                    <div >&nbsp;</div>
                                                    <?php
                                                    if ($varNum > 0) {
                                                        ?>
                                                        <form action=""  method="post" id="frm_page" onsubmit="return validateWholesalerAddForm(this);" >
                                                            <div class="span8 form-horizontal form-bordered">
                                                                <div class="control-group">
                                                                    <label for="textfield" class="control-label">*Company Name:  </label>
                                                                    <div class="controls">

                                                                        <input name="frmCompanyName" id="frmCompanyName"  placeholder=""  type="text" class="input-large" value="<?php echo $objPage->arrRow[0]['CompanyName']; ?>" />
                                                                    </div>
                                                                </div>
                                                                <div class="control-group">
                                                                    <label for="" class="control-label">*About Company: <small>(minimum 200 words required) </small></label>
                                                                    <div class="controls">
                                                                        <textarea name="frmAboutCompany" id="frmAboutCompany" rows="6" class="input-block-level" ><?php echo $objPage->arrRow[0]['AboutCompany']; ?></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="control-group">
                                                                    <label for="" class="control-label">  Services:</label>
                                                                    <div class="controls">

                                                                        <textarea  name="frmServices" id="Services" rows="6" class="input-block-level"><?php echo $objPage->arrRow[0]['Services']; ?></textarea>
                                                                    </div>
                                                                </div>





                                                            </div>
                                                            <div class="span4 form-vertical form-bordered right-side">

                                                                <div class="control-group">
                                                                    <label for="textfield" class="control-label"> *Enter Commission Value(in % ): </label>
                                                                    <div class="controls">
                                                                        <input  name="frmCommission" id="frmCommission" type="text" class="input-small" value="<?php echo $objPage->arrRow[0]['Commission']; ?>" />&nbsp;
                                                                        <span>Ex- 0.00%</span>
                                                                    </div>
                                                                </div>
                                                                <div class="control-group">
                                                                    <label class="control-label">*Choose Logistic Company(s):</label>
                                                                    <div class="controls" id="shippingGateways">

                                                                        <?php
                                                                        foreach ($objPage->arrShippingList as $kShip => $vShip) {
                                                                            ?>
                                                                        <label class='checkbox'><input disabled="disabled" class="input-large" type="checkbox" name="frmShippingGateway[]" value="<?php echo $vShip['logisticportalid']; ?>" <?php
                                                                                if (in_array($vShip['logisticportalid'], $objPage->arrRow[0]['shippingDetails'])) {
                                                                                    echo 'checked="checked"';
                                                                                }
                                                                                ?> />&nbsp;<?php echo $vShip['logisticTitle']; ?></label>
                                                                            <?php } ?>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row-fluid">
                                                                <div class="span12 form-horizontal form-bordered box box-bordered box-color lightgrey">
                                                                    <div class="box-title nomargin"><h3>Company Address</h3></div>
                                                                    <div class="control-group">
                                                                        <label for="textfield" class="control-label">*Address1:   </label>
                                                                        <div class="controls">
                                                                            <input name="frmCompanyAddress1" id="frmCompanyAddress1" type="text" class="input-large" value="<?php echo $objPage->arrRow[0]['CompanyAddress1']; ?>" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="control-group">
                                                                        <label for="textfield" class="control-label">Address2: </label>
                                                                        <div class="controls">
                                                                            <input name="frmCompanyAddress2" id="frmCompanyAddress2" type="text" class="input-large" value="<?php echo $objPage->arrRow[0]['CompanyAddress2']; ?>" />

                                                                        </div>
                                                                    </div>
                                                                    
                                                                    <div class="control-group">
                                                                        <label for="" class="control-label">*Country:</label>
                                                                        <div class="controls">
                                                                            <select name="frmCompanyCountry" id="frmCompanyCountry" onchange="ShowWholesaler()" class='select2-me input-large'>
                                                                                <option value="0">Select</option>
                                                                                <?php
                                                                                //showRegionForWholesaler(this.value, 'frmCompanyRegion');
                                                                                foreach ($objPage->arrCountryList as $vCT) {
                                                                                    if (in_array($vCT['country_id'], $PortalIDs)) {
                                                                                        ?>
                                                                                        <option value="<?php echo $vCT['country_id']; ?>" <?php
                                                                                        if ($vCT['country_id'] == $objPage->arrRow[0]['CompanyCountry']) {
                                                                                            echo 'selected="selected"';
                                                                                        }
                                                                                        ?>><?php echo $vCT['name']; ?></option>
                                                                                                <?php
                                                                                            }
                                                                                        }
                                                                                        ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="control-group">
                                                                            <label for="textfield" class="control-label">*State:  </label>
                                                                            <div class="controls">
                                                                                <select name="CompanyState" id="frmCompanyState" onchange ="showstate()"class='select2-me input-large resCheck'>
                                                                                    <option value="0">Select State</option>
                                                                                    <?php
                                                                                 $statearraybycountryid = $objGeneral->statelistbycountryid($objPage->arrRow[0]['CompanyCountry']);
                                                                                                foreach ($statearraybycountryid as $vv) {
                                                                                                    //in_array($gatway,)
                                                                                                    
                                                                                                    if ($objPage->arrRow[0]['CompanyState'] == $vv['id'])
                                                                                                        echo '<option selected value=' . $vv['id'] . '>' . $vv['name'] . '</option>';
                                                                                                    else {
                                                                                                        echo '<option value=' . $vv['id'] . '>' . $vv['name'] . '</option>';
                                                                                                    }
                                                                                                }
                                                                                                ?>
                                                                                </select> 
                                                                            </div>
                                                                        </div>
                                                                        <div class="control-group">
                                                                            <label for="textfield" class="control-label">*City:  </label>
                                                                            <div class="controls">
                                                                                <select name="CompanyCity" id="frmCompanyCity1" class='select2-me input-large resCheck'>
                                                                                    <option value="0">Select City</option>
                                                                                    <?php
                                                                                  $cityarraybystateid = $objGeneral->countrylistbynewstateid($objPage->arrRow[0]['CompanyState']);               
                                                                                                foreach ($cityarraybystateid as $vv) {

                                                                                                    //in_array($gatway,)
                                                                                                    if ($objPage->arrRow[0]['CompanyCity'] == $vv['id']) {
                                                                                                        $frmDistanceEnable = true;
                                                                                                        echo '<option selected value=' . $vv['id'] . '>' . $vv['name'] . '</option>';
                                                                                                    } else {
                                                                                                        echo '<option value=' . $vv['id'] . '>' . $vv['name'] . '</option>';
                                                                                                    }
                                                                                                }
                                                                                                
                                                                                                ?>
                                                                                </select>
                                                                            </div>
                                                                        </div>
<!--                                                                    <div class="control-group">
                                                                        <label for="" class="control-label">Region:</label>
                                                                        <div class="controls">
                                                                            <select name="frmCompanyRegion" id="frmCompanyRegion" class='select2-me input-large'>
                                                                                <option value="0">Select</option>
                                                                                <?php
                                                                                //foreach ($objPage->arrRegion as $vRegion) {
                                                                                    ?>
                                                                                    <option value="<?php// echo $vRegion['pkRegionID']; ?>" <?php
                                                                                  //  if ($vRegion['pkRegionID'] == $objPage->arrRow[0]['CompanyRegion']) {
                                                                                    //    echo 'selected="selected"';
                                                                                   // }
                                                                                    //?>><?php //echo $vRegion['RegionName']; ?></option>
                                                                                        <?php //} ?>
                                                                            </select>

                                                                        </div>
                                                                    </div>-->
                                                                    <div class="control-group">
                                                                        <label for="textarea" class="control-label">*Postal Code:   </label>
                                                                        <div class="controls">

                                                                            <input name="frmCompanyPostalCode" id="frmCompanyPostalCode" type="text" class="input-large" value="<?php echo $objPage->arrRow[0]['CompanyPostalCode']; ?>" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="control-group">
                                                                        <label for="textarea" class="control-label">Website:   </label>
                                                                        <div class="controls">
                                                                            <input name="frmCompanyWebsite" id="frmCompanyWebsite" type="text" class="input-large" placeholder="" value="<?php echo $objPage->arrRow[0]['CompanyWebsite']; ?>" />
                                                                            <span class="help-block">Ex- http://www.example.com </span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="control-group">
                                                                        <label for="textarea" class="control-label">*Login Email :   </label>
                                                                        <div class="controls">

                                                                            <input name="frmCompanyEmail" id="frmCompanyEmail" type="text" class="input-large" value="<?php echo $objPage->arrRow[0]['CompanyEmail']; ?>" onkeyup="checkWholeSalerEmail(<?php echo $objPage->arrRow[0]['pkWholesalerID']; ?>);" onchange="checkWholeSalerEmail(<?php echo $objPage->arrRow[0]['pkWholesalerID']; ?>);" autocomplete="off" />
                                                                            <input type="hidden" name="frmCEmail" id="frmCEmail" value="0" /> <span id="CompanyEmail" class="help-block"></span>


                                                                        </div>
                                                                    </div>
                                                                    <div class="control-group">
                                                                        <label for="textarea" class="control-label">*Password:   </label>
                                                                        <div class="controls">


                                                                            <input name="frmPassword" id="frmPassword" type="password" class="input-large" value="<?php echo ADMIN_XXX; ?>" />
                                                                            <input name="frmOldPassword" id="frmOldPassword" type="hidden" value="<?php echo $objPage->arrRow[0]['CompanyPassword']; ?>" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="control-group">
                                                                        <label for="textarea" class="control-label">*Confirm Password:    </label>
                                                                        <div class="controls">
                                                                            <input name="frmConfirmPassword" id="frmConfirmPassword" type="password" class="input-large" value="<?php echo ADMIN_XXX; ?>" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="control-group">
                                                                        <label for="textarea" class="control-label">*Paypal Email :  </label>
                                                                        <div class="controls">
                                                                            <input name="frmPaypalEmail" id="frmPaypalEmail" type="text" class="input-large" value="<?php echo $objPage->arrRow[0]['PaypalEmail']; ?>" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="control-group">
                                                                        <label for="textarea" class="control-label">*Phone:    </label>
                                                                        <div class="controls">
                                                                            <input name="frmCompanyPhone" id="frmCompanyPhone" type="text" class="input-large" value="<?php echo $objPage->arrRow[0]['CompanyPhone']; ?>" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="control-group">
                                                                        <label for="textarea" class="control-label">Fax:   </label>
                                                                        <div class="controls">
                                                                            <input name="frmCompanyFax" id="frmCompanyFax" type="text" class="input-large" value="<?php echo $objPage->arrRow[0]['CompanyFax']; ?>" />
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                            <div class="row-fluid">
                                                                <div class="span12 form-horizontal form-bordered box box-bordered box-color lightgrey">
                                                                    <div class="box-title nomargin"><h3 onmousemove="checkWholeSalerEmail(<?php echo $objPage->arrRow[0]['pkWholesalerID']; ?>);">Contact Person</h3></div>
                                                                    <div class="control-group">
                                                                        <label for="textarea" class="control-label">*Name:   </label>
                                                                        <div class="controls">
                                                                            <input name="frmContactPersonName" id="frmContactPersonName" type="text" class="input-large" value="<?php echo $objPage->arrRow[0]['ContactPersonName']; ?>" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="control-group">
                                                                        <label for="textarea" class="control-label">*Position:   </label>
                                                                        <div class="controls">
                                                                            <input name="frmContactPersonPosition" id="frmContactPersonPosition" type="text" class="input-large" value="<?php echo $objPage->arrRow[0]['ContactPersonPosition']; ?>" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="control-group">
                                                                        <label for="textarea" class="control-label">*Phone/mobile:    </label>
                                                                        <div class="controls">
                                                                            <input name="frmContactPersonPhone" id="frmContactPersonPhone" type="text" class="input-large" value="<?php echo $objPage->arrRow[0]['ContactPersonPhone']; ?>" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="control-group">
                                                                        <label for="textarea" class="control-label">*Email:   </label>
                                                                        <div class="controls">
                                                                            <input name="frmContactPersonEmail" id="frmContactPersonEmail" type="text" class="input-large" value="<?php echo $objPage->arrRow[0]['ContactPersonEmail']; ?>" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="control-group">
                                                                        <label for="textarea" class="control-label">*Postal Address:   </label>
                                                                        <div class="controls">
                                                                            <input name="frmContactPersonAddress" id="frmContactPersonAddress" type="text" class="input-large" value="<?php echo $objPage->arrRow[0]['ContactPersonAddress']; ?>" />
                                                                        </div>
                                                                    </div>


                                                                </div>
                                                            </div>
                                                            <div class="row-fluid">
                                                                <div class="span12 form-horizontal form-bordered box box-bordered box-color lightgrey">
                                                                    <div class="box-title nomargin"><h3>Director/Owner Information</h3></div>
                                                                    <div class="control-group">
                                                                        <label for="textarea" class="control-label">*Name: </label>
                                                                        <div class="controls">
                                                                            <input name="frmOwnerName" id="frmOwnerName" type="text" class="input-large" value="<?php echo $objPage->arrRow[0]['OwnerName']; ?>" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="control-group">
                                                                        <label for="textarea" class="control-label">*Phone/mobile:   </label>
                                                                        <div class="controls">
                                                                            <input name="frmOwnerPhone" id="frmOwnerPhone" type="text" class="input-large" value="<?php echo $objPage->arrRow[0]['OwnerPhone']; ?>" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="control-group">
                                                                        <label for="textarea" class="control-label">*Email:   </label>
                                                                        <div class="controls">
                                                                            <input name="frmOwnerEmail" id="frmOwnerEmail" type="text" class="input-large" value="<?php echo $objPage->arrRow[0]['OwnerEmail']; ?>" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="control-group">
                                                                        <label for="textarea" class="control-label">*Postal Address:   </label>
                                                                        <div class="controls">
                                                                            <input name="frmOwnerAddress" id="frmOwnerAddress" type="text" class="input-large" value="<?php echo $objPage->arrRow[0]['OwnerAddress']; ?>" />
                                                                        </div>
                                                                    </div>


                                                                </div>
                                                            </div>
                                                            <div class="row-fluid">
                                                                <div class="span12 form-horizontal form-bordered box box-bordered box-color lightgrey">
                                                                    <div class="box-title nomargin"><h3>Trade Reference 1</h3></div>
                                                                    <div class="control-group">
                                                                        <label for="textarea" class="control-label">*Name: </label>
                                                                        <div class="controls">
                                                                            <input name="frmRef1Name" id="frmRef1Name" type="text" class="input-large" value="<?php echo $objPage->arrRow[0]['Ref1Name']; ?>" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="control-group">
                                                                        <label for="textarea" class="control-label">*Phone/mobile:   </label>
                                                                        <div class="controls">
                                                                            <input name="frmRef1Phone" id="frmRef1Phone" type="text" class="input-large" value="<?php echo $objPage->arrRow[0]['Ref1Phone']; ?>" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="control-group">
                                                                        <label for="textarea" class="control-label">*Email:   </label>
                                                                        <div class="controls">
                                                                            <input name="frmRef1Email" id="frmRef1Email" type="text" class="input-large" value="<?php echo $objPage->arrRow[0]['Ref1Email']; ?>" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="control-group">
                                                                        <label for="textarea" class="control-label">*Company Name:   </label>
                                                                        <div class="controls">
                                                                            <input name="frmRef1CompanyName" id="frmRef1CompanyName" type="text" class="input-large" value="<?php echo $objPage->arrRow[0]['Ref1CompanyName']; ?>" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="control-group">
                                                                        <label for="textarea" class="control-label">*Company Address:    </label>
                                                                        <div class="controls">
                                                                            <input name="frmRef1CompanyAddress" id="frmRef1CompanyAddress" type="text" class="input-large" value="<?php echo $objPage->arrRow[0]['Ref1CompanyAddress']; ?>" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="box-title nomargin"><h3>Trade Reference 2</h3></div>

                                                                    <div class="control-group">
                                                                        <label for="textarea" class="control-label">*Name: </label>
                                                                        <div class="controls">
                                                                            <input name="frmRef2Name" id="frmRef2Name" type="text" class="input-large" value="<?php echo $objPage->arrRow[0]['Ref2Name']; ?>" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="control-group">
                                                                        <label for="textarea" class="control-label">*Phone/mobile:   </label>
                                                                        <div class="controls">
                                                                            <input name="frmRef2Phone" id="frmRef2Phone" type="text" class="input-large" value="<?php echo $objPage->arrRow[0]['Ref2Phone']; ?>" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="control-group">
                                                                        <label for="textarea" class="control-label">*Email:   </label>
                                                                        <div class="controls">
                                                                            <input name="frmRef2Email" id="frmRef2Email" type="text" class="input-large" value="<?php echo $objPage->arrRow[0]['Ref2Email']; ?>" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="control-group">
                                                                        <label for="textarea" class="control-label">*Company Name:   </label>
                                                                        <div class="controls">
                                                                            <input name="frmRef2CompanyName" id="frmRef2CompanyName" type="text" class="input-large" value="<?php echo $objPage->arrRow[0]['Ref2CompanyName']; ?>" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="control-group">
                                                                        <label for="textarea" class="control-label">*Company Address:    </label>
                                                                        <div class="controls">
                                                                            <input name="frmRef2CompanyAddress" id="frmRef2CompanyAddress" type="text" class="input-large" value="<?php echo $objPage->arrRow[0]['Ref2CompanyAddress']; ?>" />
                                                                        </div>
                                                                    </div>

                                                                    <div class="box-title nomargin"><h3>Trade Reference 3</h3></div>
                                                                    <div class="control-group">
                                                                        <label for="textarea" class="control-label">*Name: </label>
                                                                        <div class="controls">
                                                                            <input name="frmRef3Name" id="frmRef3Name" type="text" class="input-large" value="<?php echo $objPage->arrRow[0]['Ref3Name']; ?>" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="control-group">
                                                                        <label for="textarea" class="control-label">*Phone/mobile:   </label>
                                                                        <div class="controls">
                                                                            <input name="frmRef3Phone" id="frmRef3Phone" type="text" class="input-large" value="<?php echo $objPage->arrRow[0]['Ref3Phone']; ?>" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="control-group">
                                                                        <label for="textarea" class="control-label">*Email:   </label>
                                                                        <div class="controls">
                                                                            <input name="frmRef3Email" id="frmRef3Email" type="text" class="input-large" value="<?php echo $objPage->arrRow[0]['Ref3Email']; ?>" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="control-group">
                                                                        <label for="textarea" class="control-label">*Company Name:   </label>
                                                                        <div class="controls">
                                                                            <input name="frmRef3CompanyName" id="frmRef3CompanyName" type="text" class="input-large" value="<?php echo $objPage->arrRow[0]['Ref3CompanyName']; ?>" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="control-group">
                                                                        <label for="textarea" class="control-label">*Company Address:</label>
                                                                        <div class="controls">
                                                                            <input name="frmRef3CompanyAddress" id="frmRef3CompanyAddress" type="text" class="input-large" value="<?php echo $objPage->arrRow[0]['Ref3CompanyAddress']; ?>" />
                                                                        </div>
                                                                    </div>




                                                                    <div class="control-group">
                                                                        <label for="textarea" class="control-label">*Wholesaler Account Status:</label>
                                                                        <div class="controls">
                                                                            <?php $status = $objPage->arrRow[0]['WholesalerStatus']; ?>
                                                                            <input type="hidden" name="frmWholesalerOldStatus" value="<?php echo $status; ?>" />
                                                                            <?php
                                                                            if ($_SESSION['sessUserType'] == 'super-admin') {
                                                                                ?>
                                                                                <select name="frmWholesalerStatus" id="frmWholesalerStatus" class="select2-me input-large">
                                                                                    <option value = "active" <?php
                                                                                    if ($status == 'active') {
                                                                                        echo "selected";
                                                                                    }
                                                                                    ?>>Active</option>
                                                                                    <option value = "deactive" <?php
                                                                                    if ($status == 'deactive') {
                                                                                        echo "selected";
                                                                                    }
                                                                                    ?>>Deactive</option>
                                                                                    <option value = "pending" <?php
                                                                                    if ($status == 'pending') {
                                                                                        echo "selected";
                                                                                    }
                                                                                    ?>>Pending</option>
                                                                                    <option value = "suspend" <?php
                                                                                    if ($status == 'suspend') {
                                                                                        echo "selected";
                                                                                    }
                                                                                    ?>>Suspend</option>
                                                                                    <option value = "reject" <?php
                                                                                    if ($status == 'reject') {
                                                                                        echo "selected";
                                                                                    }
                                                                                    ?>>Reject</option>
                                                                                </select>
                                                                                <?php
                                                                            } else {
                                                                                ?>
                                                                                <input type="hidden" name="frmWholesalerStatus" value="<?php echo $status; ?>" /><?php echo ucfirst($status); ?>
                                                                            <?php } ?>
                                                                        </div>
                                                                    </div>
                                                                    <div class="note">Note : * Indicates mandatory fields.</div>

                                                                    <div class="form-actions">
        <!--                                        <input type="submit" class="btn" name="btnPage" value="<?php echo ADMIN_SUBMIT_BUTTON; ?>" style="float:left; margin:5px 15px 0 0; width:80px;"/>-->
                                                                        <button type="submit" class="btn btn-blue"><?php echo ADMIN_SUBMIT_BUTTON; ?></button>

                                                                                                                                                                                <!--                                        <a id="buttonDecoration" href="wholesaler_manage_uil.php"><input type="button" class="btn" name="btnTagSettings" value="<?php echo ADMIN_SEARCH_CANCEL_BUTTON; ?>" style="float:left; margin:5px 5px 0 0; width:80px;"/></a>                                              -->


                                                                        <a id="buttonDecoration" href="wholesaler_manage_uil.php"><button type="button" class="btn"><?php echo ADMIN_SEARCH_CANCEL_BUTTON; ?></button></a>                                       <input type="hidden" name="id" value="<?php echo $objPage->arrRow[0]['pkWholesalerID']; ?>" />
                                                                        <input type="hidden" name="frmHidenEdit" id="frmHidnAddPage" value="edit" />
                                                                    </div>

                                                                </div>

                                                            </div>

                                                        </form>
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <div class="control-group">

                                                            <div class="controls">
                                                                <?php echo ADMIN_NO_RECORD_FOUND; ?>
                                                            </div>
                                                        </div>

                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php
                    } else {
                        ?>
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
