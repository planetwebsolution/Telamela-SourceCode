<?php
require_once '../common/config/config.inc.php';
require_once CLASSES_ADMIN_PATH . 'class_adminuser_bll.php';

$objAdminLogin = new AdminLogin();
//echo '<pre>';print_r($_SESSION);die;
//check admin session
$objAdminLogin->isValidAdmin();
//************ Get Admin Email here
$varWhr = "AND AdminUserName = '" . $_SESSION['sessAdminUserName'] . "'";
$arrResult = $objAdminLogin->getAdminEmail($varWhr);


if ($_SESSION["arrPost"] != '')
{
    @extract($_SESSION["arrPost"]);
    $varAdminEmail = $frmAdminEmail;
}

if ($arrResult)
{
    $varAdminEmail = $arrResult[0]['AdminEmail'];
    $varAdminPageLimit = $arrResult[0]['AdminPageLimit'];
}
$objUser = new AdminUser();
$arrCountry = $objUser->getCountry();
$arrPeriod = $objGeneral->getCommissionPeriod();
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
        <title><?php echo ADMIN_PANEL_NAME; ?> : Manage Settings </title>
        <?php require_once 'inc/common_css_js.inc.php'; ?>
        <script>var SITE_ROOT_URL = '<?php echo SITE_ROOT_URL; ?>';</script>
        <script type="text/javascript" src="<?php echo JS_PATH; ?>jquery-1.8.3.min.js"></script>
        <script type="text/javascript" src="<?php echo JS_PATH; ?>admin_js.js"></script>
        <script type="text/javascript">
            $(function() {
                var addDiv = $('#addinput');
                var i = $('#addinput p').size() + 1;

                $('#addNew').live('click', function() {
                    $('#addinput p:last span').html('');
                    $('<p><input type="text" name="frmSupportTicket[]" style="width:250px;" value="" maxlength="60"/>&nbsp;<span><a href="#" id="addNew"><img src="images/plus.png" alt="Add more" title="Add more" /></a></span>&nbsp;<a href="#" id="remNew"><img src="images/minus.png" alt="Remove" title="Remove" /></a></p>').appendTo(addDiv);
                    i++;

                    return false;
                });

                $('#remNew').live('click', function() {
                    if( i > 2 ) {
                        $(this).parents('p').remove();
                        i--;
                        $("#addinput p:last span").html('<a href="#" id="addNew"><img src="images/plus.png" alt="Add more" title="Add more" /></a>');
                    }
                    return false;
                });
            });
        </script>
        <script type="text/javascript">
            $(function() {
                var addDiv = $('#addinputDisputed');
                var i = $('#addinputDisputed p').size() + 1;

                $('#addNewDisputed').live('click', function() {
                    $('#addinputDisputed p:last span').html('');
                    $('<p><input type="text" name="frmDisputedCommentTitle[]" style="width:250px;" value="" maxlength="76"/>&nbsp;<span><a href="#" id="addNewDisputed"><img src="images/plus.png" alt="Add more" title="Add more" /></a></span>&nbsp;<a href="#" id="remNewDisputed"><img src="images/minus.png" alt="Remove" title="Remove" /></a></p>').appendTo(addDiv);
                    i++;

                    return false;
                });

                $('#remNewDisputed').live('click', function() {
                    if( i > 2 ) {
                        $(this).parents('p').remove();
                        i--;
                        $("#addinputDisputed p:last span").html('<a href="#" id="addNewDisputed"><img src="images/plus.png" alt="Add more" title="Add more" /></a>');
                    }
                    return false;
                });
            });
        </script>
        <script type="text/javascript">
            $(function() {
                var addDiv = $('#addKPIinput');
                var i = $('#addKPIinput p').size() + 1;

                $('#addNewKPI').live('click', function() {
                    var KPIval ='';
                    for(var j=10;j<101;j=j+5){
                        KPIval +='<option value="'+j+'">'+j+'</option>';
                    }
<?php
$va = '';
foreach ($arrCountry as $valct)
{
    $va .='<option value="' . $valct['country_id'] . '">' . str_replace("'", '&lsquo;', $valct['name']) . '</option>';
}
?>
            var ctry = '<?php echo $va; ?>';

            $('<p><select name="frmCountryId[]" style="width:120px;"><option value="0">Select Country</option>'+ctry+'</select><select name="frmKPIVal[]" style="margin-left: 10px; width:90px;"><option value="0">Select Value</option>'+KPIval+'</select>&nbsp;<a href="#" id="remNewKPI"><img src="images/minus.png" alt="Remove" title="Remove" /></a></p>').appendTo(addDiv);
            i++;

            return false;
        });

        $('#remNewKPI').live('click', function() {

            if( i > 1 ) {
                $(this).parents('p').remove();
                i--;
            }
            return false;
        });
    });
        </script>
    </head>
    <body>
        <?php require_once 'inc/header_new.inc.php'; ?>
        <div class="container-fluid" id="content">

            <div id="main">
                <div class="container-fluid">
                    <div class="page-header">
                        <div class="pull-left">
                            <h1>Setting </h1>
                        </div>

                    </div>
                    <div class="breadcrumbs">
                        <ul>
                            <li><a href="dashboard_uil.php">Home</a><i class="icon-angle-right"></i></li>
                            <li><span>Setting</span></li>
                        </ul>
                        <div class="close-bread">
                            <a href="#"><i class="icon-remove"></i></a>
                        </div>
                    </div>

                    <div class="row-fluid">
                        <div class="span12">
                            <div class="box box-bordered box-color top-box">
                                <div class="box-content nopadding">
                                    <div class="tab-content padding tab-content-inline tab-content-bottom">
                                        <div class="tab-pane active" id="tabs-2">
                                            <div class="row-fluid">
                                                <div class="span12">
                                                    <?php
                                                    if ($objCore->displaySessMsg())
                                                    {
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
                                                            <h3>
                                                                Change Password
                                                            </h3>
                                                        </div>
                                                        <div class="box-content nopadding">
                                                            <?php require_once('javascript_disable_message.php'); ?>
                                                            <form action="settings_action.php" method="post" id="frm_password" onsubmit="return validateChangePassword('frm_password');">
                                                                <input type="hidden" value="<?php echo $_SESSION['sessUser']; ?>" name="AdminID" />
                                                                <div class="row-fluid">
                                                                    <div class="span12 form-horizontal form-bordered box box-bordered box-color lightgrey">
                                                                        <div class="control-group">
                                                                            <label for="textfield" class="control-label">*Current Password:   </label>
                                                                            <div class="controls">
                                                                                <input type="password" name="frmAdminOldPassword" class="input-large" value="" />
                                                                            </div>
                                                                        </div>
                                                                        <div class="control-group">
                                                                            <label for="textfield" class="control-label">*New Password: </label>
                                                                            <div class="controls">
                                                                                <input type="password" name="frmAdminNewPassword" class="input-large" value="" />
                                                                                <span>( Password should contain only <strong>a-z, A-Z, 0-9, -, _, #, @ or !</strong> characters. )</span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="control-group">
                                                                            <label for="" class="control-label">*Confirm New Password:</label>
                                                                            <div class="controls">
                                                                                <input type="password" name="frmAdminConfirmPassword"  class="input-large" value="" />
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-actions">
                                                                            <input type="submit" class="btn" name="btnPasswordUpdate"  value="Change My Password"  <?php /*style="float:left; margin:5px 100px 0 0; width:150px;"*/ ?> />
                                                                        </div>
                                                                        <div class="note">Note : * Indicates mandatory fields.</div>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    <div class="box box-color box-bordered">
                                                        <div class="box-title">
                                                            <h3>
                                                                Change Notification Email ID
                                                            </h3>
                                                        </div>
                                                        <div class="box-content nopadding">
                                                            <form action="settings_action.php" method="post" id="frm_email" onsubmit="return validateEmailChange('frm_email');">
                                                                <input type="hidden" value="<?php echo $_SESSION['sessUser']; ?>" name="AdminID">
                                                                <div class="row-fluid">
                                                                    <div class="span12 form-horizontal form-bordered box box-bordered box-color lightgrey">
                                                                        <div class="control-group">
                                                                            <label for="textfield" class="control-label">*E-mail:  </label>
                                                                            <div class="controls">
                                                                                <input type="text" name="frmAdminEmail" class="input-large" value="<?php echo ($varAdminEmail) ? $varAdminEmail : $_SESSION['sessAdminEmail']; ?>" />
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-actions">
                                                                            <input type="submit" class="btn" name="btnEmailUpdate" value="Change My Email ID" style="float:left; margin:5px 100px 0 0; width:150px;" />
                                                                        </div>
                                                                        <div class="note">Note : * Indicates mandatory fields.</div>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    <div class="box box-color box-bordered">
                                                        <div class="box-title">
                                                            <h3>
                                                                Admin Paging
                                                            </h3>
                                                        </div>

                                                        <div class="box-content nopadding">
                                                            <form action="settings_action.php" method="post" id="frm_page_limit" onsubmit="return validateAdminPageLimit('frm_page_limit');">
                                                                <input  type="hidden" value="<?php echo $_SESSION['sessUser']; ?>" name="AdminID">

                                                                <div class="row-fluid">
                                                                    <div class="span12 form-horizontal form-bordered box box-bordered box-color lightgrey">

                                                                        <div class="control-group">
                                                                            <label for="textfield" class="control-label">*Record Per Page Limit:   </label>
                                                                            <div class="controls">

                                                                                <input type="text" size="4" maxlength="4" id="frmRecordPerpage" name="frmRecordPerpage" value="<?php echo ($varAdminPageLimit) ? $varAdminPageLimit : $_SESSION['sessAdminPageLimit']; ?>" class="input-large"/>
                                                                            </div>
                                                                        </div>

                                                                        <div class="form-actions">
                                                                            <input type="submit" class="btn" name="btnPageLimitUpdate" value="Update" style="float:left; margin:5px 100px 0 0; width:150px;" />
                                                                        </div>
                                                                        <div class="note">Note : * Indicates mandatory fields.</div>

                                                                    </div>
                                                                </div>

                                                            </form>
                                                        </div>

                                                    </div>
                                                    <?php
                                                    if ($_SESSION['sessUserType'] == 'super-admin')
                                                    {
                                                        $arrSupportTicket = $objAdminLogin->getSupportTicket();
                                                        $arrCommision = $objAdminLogin->getDefaultCommission(1);
                                                        ?>
                                                        <div class="box box-color box-bordered">
                                                            <div class="box-title">
                                                                <h3>
                                                                    Support Ticket Types
                                                                </h3>
                                                            </div>

                                                            <div class="box-content nopadding">
                                                                <form action="settings_action.php" method="post" id="frm_ticket" onsubmit="return validateTicketForm();">
                                                                    <input  type="hidden" value="<?php echo $_SESSION['sessUser']; ?>" name="AdminID">

                                                                    <div class="row-fluid">
                                                                        <div class="span12 form-horizontal form-bordered box box-bordered box-color lightgrey">

                                                                            <div class="control-group">
                                                                                <label for="textfield" class="control-label">*Enter Type:   </label>
                                                                                <div class="controls">
                                                                                    <div id="addinput">
                                                                                        <?php
                                                                                        $varLastST = count($arrSupportTicket);
                                                                                        foreach ($arrSupportTicket as $keyT => $valT)
                                                                                        {
                                                                                            ?>
                                                                                            <p>
                                                                                                <input type="text" name="frmSupportTicket[]" class="input-large" value="<?php echo $valT['TicketTitle']; ?>" maxlength="60"/>

                                                                                                <span>
                                                                                                    <?php
                                                                                                    if ($keyT == $varLastST - 1)
                                                                                                    {
                                                                                                        ?>
                                                                                                        <a href="#" id="addNew"><img src="images/plus.png" alt="Add more" title="Add more" /></a><?php } ?>
                                                                                                </span>

                                                                                                <?php
                                                                                                if ($keyT > 0)
                                                                                                {
                                                                                                    ?><a id="remNew" href="#"><img src="images/minus.png" alt="Remove" title="Remove" /></a><?php } ?>

                                                                                            </p>
    <?php } ?>
                                                                                    </div>

                                                                                </div>
                                                                            </div>

                                                                            <div class="form-actions">
                                                                                <input type="submit" class="btn" name="btnTicketUpdate" value="Update" style="float:left; margin:5px 100px 0 0; width:150px;" />
                                                                            </div>
                                                                            <div class="note">Note : * Indicates mandatory fields.</div>

                                                                        </div>
                                                                    </div>

                                                                </form>
                                                            </div>

                                                        </div>

                                                        <div class="box box-color box-bordered">
                                                            <div class="box-title">
                                                                <h3>
                                                                    Disputed Additional Comment List
                                                                </h3>
                                                            </div>
    <?php $arrDisputedCommentList = $objAdminLogin->getDisputedCommentList(); ?>
                                                            <div class="box-content nopadding">
                                                                <form action="settings_action.php" method="post" id="frm_disputed" onsubmit="return validateDisputedForm();">
                                                                    <input  type="hidden" value="<?php echo $_SESSION['sessUser']; ?>" name="AdminID">
                                                                    <div class="row-fluid">
                                                                        <div class="span12 form-horizontal form-bordered box box-bordered box-color lightgrey">
                                                                            <div class="control-group">
                                                                                <label for="textfield" class="control-label">* Comment Title:   </label>
                                                                                <div class="controls">
                                                                                    <div id="addinputDisputed">
                                                                                        <?php
                                                                                        $varLastSD = count($arrDisputedCommentList);
                                                                                        if ($varLastSD > 0)
                                                                                        {
                                                                                            foreach ($arrDisputedCommentList as $keyD => $valD)
                                                                                            {
                                                                                                ?>
                                                                                                <p>
                                                                                                    <input type="text" name="frmDisputedCommentTitle[]" class="input-large" value="<?php echo $valD['Title']; ?>" maxlength="76"/>
                                                                                                    <span>
                                                                                                        <?php
                                                                                                        if ($keyD == $varLastSD - 1)
                                                                                                        {
                                                                                                            ?>
                                                                                                            <a href="#" id="addNewDisputed"><img src="images/plus.png" alt="Add more" title="Add more" /></a><?php } ?>
                                                                                                    </span>
                                                                                                <?php
                                                                                                if ($keyD > 0)
                                                                                                {
                                                                                                    ?><a id="remNewDisputed" href="#"><img src="images/minus.png" alt="Remove" title="Remove" /></a><?php } ?>
                                                                                                </p>
                                                                                                <?php
                                                                                            }
                                                                                        }
                                                                                        else
                                                                                        {
                                                                                            ?>
                                                                                            <p>
                                                                                                <input type="text" name="frmDisputedCommentTitle[]" style="width:250px;" value="<?php echo $valT['Title']; ?>" maxlength="76"/>
                                                                                                <span>
                                                                                                    <a href="#" id="addNewDisputed"><img src="images/plus.png" alt="Add more" title="Add more" /></a>
                                                                                                </span>
                                                                                            </p>
    <?php } ?>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-actions">
                                                                                <input type="submit" class="btn" name="btnDisputedUpdate" value="Update" style="float:left; margin:5px 100px 0 0; width:150px;" />
                                                                            </div>
                                                                            <div class="note">Note : * Indicates mandatory fields.</div>

                                                                        </div>
                                                                    </div>

                                                                </form>
                                                            </div>

                                                        </div>
    <?php
    $arrSetting = $objAdminLogin->getAllSetting();
    //pre($arrSetting);
    ?>

                                                        <div class="box box-color box-bordered">
                                                            <div class="box-title">
                                                                <h3>
                                                                    Rewards Points
                                                                </h3>
                                                            </div>
                                                            <div class="box-content nopadding">
                                                                <form action="settings_action.php" method="post" id="frm_commission" onsubmit="return validateRewardPointsForm(this);">
                                                                    <div class="row-fluid">
                                                                        <div class="span12 form-horizontal form-bordered box box-bordered box-color lightgrey">
                                                                            <div class="control-group">
                                                                                <label for="textfield" class="control-label">*Reward Status</label>
                                                                                <div class="controls">
                                                                                    <input type="radio" name="RewardStatus" value="1" <?php echo ($arrSetting['RewardStatus']['SettingValue'] == '1') ? 'checked="checked"' : '' ?>>Enable
                                                                                    <input type="radio" name="RewardStatus" value="0" <?php echo ($arrSetting['RewardStatus']['SettingValue'] == '0') ? 'checked="checked"' : '' ?>>Disable
                                                                                </div>
                                                                            </div>
                                                                            <div class="control-group">
                                                                                <label for="textfield" class="control-label">*Unit Point Value (in $USD)</label>
                                                                                <div class="controls">
                                                                                    <input type="text" name="RewardPointValue" class="input-large" value="<?php echo $arrSetting['RewardPointValue']['SettingValue']; ?>" />
                                                                                </div>
                                                                            </div>
                                                                            <div class="control-group">
                                                                                <label for="textfield" class="control-label">*Minimum Points to Redeem</label>
                                                                                <div class="controls">
                                                                                    <input type="text" name="RewardMinimumPointToBuy" class="input-large" value="<?php echo $arrSetting['RewardMinimumPointToBuy']['SettingValue']; ?>" />
                                                                                </div>
                                                                            </div>
                                                                            <div class="control-group">
                                                                                <label for="textfield" class="control-label">&nbsp;</label>
                                                                                <div class="controls">
                                                                                    Reward Points for customer action
                                                                                </div>
                                                                            </div>
                                                                            <div class="control-group">
                                                                                <label for="textfield" class="control-label">*Customer registration</label>
                                                                                <div class="controls">
                                                                                    <input type="text" name="RewardOnCustomerRegistration" class="input-large" value="<?php echo $arrSetting['RewardOnCustomerRegistration']['SettingValue']; ?>" />
                                                                                </div>
                                                                            </div>
                                                                            <div class="control-group">
                                                                                <label for="textfield" class="control-label">*Subscribe newsletter</label>
                                                                                <div class="controls">
                                                                                    <input type="text" name="RewardOnNewsletterSubscribe" class="input-large" value="<?php echo $arrSetting['RewardOnNewsletterSubscribe']['SettingValue']; ?>" />
                                                                                </div>
                                                                            </div>
                                                                            <div class="control-group">
                                                                                <label for="textfield" class="control-label">*Recommend product</label>
                                                                                <div class="controls">
                                                                                    <input type="text" name="RewardOnRecommendProduct" class="input-large" value="<?php echo $arrSetting['RewardOnRecommendProduct']['SettingValue']; ?>" />
                                                                                </div>
                                                                            </div>
                                                                            <div class="control-group">
                                                                                <label for="textfield" class="control-label">*Sharing products
                                                                                    <br/>
                                                                                    <span style="font-size: 10px;" class="req">
                                                                                        on social media networks (facebook, twitter, google+)</span></label>
                                                                                <div class="controls">
                                                                                    <input type="text" name="RewardOnSocialMediaSharing" class="input-large" value="<?php echo $arrSetting['RewardOnSocialMediaSharing']['SettingValue']; ?>" />
                                                                                </div>
                                                                            </div>
                                                                            <div class="control-group">
                                                                                <label for="textfield" class="control-label">*Review/Rating product</label>
                                                                                <div class="controls">
                                                                                    <input type="text" name="RewardOnReviewRatingProduct" class="input-large" value="<?php echo $arrSetting['RewardOnReviewRatingProduct']['SettingValue']; ?>" />
                                                                                </div>
                                                                            </div>
<!--                                                                            <div class="control-group">
                                                                                <label for="textfield" class="control-label">*Feedback on order</label>
                                                                                <div class="controls">
                                                                                    <input type="text" name="RewardOnOrderFeedback" class="input-large" value="<?php echo $arrSetting['RewardOnOrderFeedback']['SettingValue']; ?>" />
                                                                                </div>
                                                                            </div>-->
<!--                                                                            
                                                                            <div class="control-group">
                                                                                <label for="textfield" class="control-label">*Place an order</label>
                                                                                <div class="controls">
                                                                                    <input type="text" name="RewardOnOrder" class="input-large" value="<?php echo $arrSetting['RewardOnOrder']['SettingValue']; ?>" />
                                                                                </div>
                                                                            </div>-->
                                                                            <div class="control-group">
                                                                                <label for="textfield" class="control-label">*Feedback on order</label>
                                                                                <div class="controls">
                                                                                    <input type="text" name="RewardOnOrderFeedback" class="input-large" value="<?php echo $arrSetting['RewardOnOrderFeedback']['SettingValue']; ?>" />
                                                                                </div>
                                                                            </div>
                                                                            
                                                                            <div class="control-group">
                                                                                <label for="textfield" class="control-label">*Referal link</label>
                                                                                <div class="controls">
                                                                                    <input type="text" name="RewardOnReferal" class="input-large" value="<?php echo $arrSetting['RewardOnReferal']['SettingValue']; ?>" />
                                                                                </div>
                                                                            </div>
                                                                            
                                                                            <div class="control-group">
                                                                                <label for="textfield" class="control-label">* Threshold limit for reward point</label>
                                                                                <div class="controls">
                                                                                    <input type="text" name="thresholdlimit" class="input-large" value="<?php echo $arrSetting['thresholdlimit']['SettingValue']; ?>" />
                                                                                </div>
                                                                            </div>
                                                                            
                                                                            <div class="control-group">
                                                                                <label for="textfield" class="control-label">*Time limit place on order In Days</label>
                                                                                <div class="controls">
                                                                                    <input type="text" name="ordertime" class="input-large" value="<?php echo $arrSetting['ordertime']['SettingValue']; ?>" />
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-actions">
                                                                                <input type="submit" class="btn btn-blue" name="btnRewardPointsUpdate" value="Update" />
                                                                            </div>
                                                                            <div class="note">Note : * Indicates mandatory fields.</div>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                        <div class="box box-color box-bordered">
                                                            <div class="box-title">
                                                                <h3>
                                                                    Home Banner delay Time
                                                                </h3>
                                                            </div>
                                                            <div class="box-content nopadding">
                                                                <form action="settings_action.php" method="post" id="frm_commission" onsubmit="return validateBannerDelayTimeForm(this);">
                                                                    <input  type="hidden" value="<?php echo $_SESSION['sessUser']; ?>" name="AdminID">
                                                                    <div class="row-fluid">
                                                                        <div class="span12 form-horizontal form-bordered box box-bordered box-color lightgrey">

                                                                            <div class="control-group">
                                                                                <label for="textfield" class="control-label">
                                                                                    *Time in Second:
                                                                                    <br/>
<!--                                                                                    <span style="font-size: 10px;" class="req">Time in Second</span>-->
                                                                                </label>
                                                                                <div class="controls">
                                                                                    <div id="addinput">
                                                                                        <input type="text" name="frmDelayTime" class="input-large" value="<?php echo $arrSetting['HomeBannerDelayTime']['SettingValue']; ?>" />
                                                                                        <input type="hidden" name="frmSettingAlias" class="input-large" value="HomeBannerDelayTime" />
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-actions">
                                                                                <input type="hidden" name="frmCommissionId" value="<?php echo $arrCommision[0]['pkCommissionID']; ?>" />
                                                                                <input type="submit" class="btn" name="btnDelayTimeUpdate" value="Update" style="float:left; margin:5px 100px 0 0; width:150px;" />
                                                                            </div>
                                                                            <div class="note">Note : * Indicates mandatory fields.</div>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                        <div class="box box-color box-bordered">
                                                            <div class="box-title">
                                                                <h3>
                                                                    Special Application Price
                                                                </h3>
                                                            </div>

                                                            <div class="box-content nopadding">
                                                                <form action="settings_action.php" method="post" id="frm_commission" onsubmit="return validateSpecialApplicationForm(this);">
                                                                    <input  type="hidden" value="<?php echo $_SESSION['sessUser']; ?>" name="AdminID">
                                                                    <div class="row-fluid">
                                                                        <div class="span12 form-horizontal form-bordered box box-bordered box-color lightgrey">
                                                                            <div class="control-group">
                                                                                <label for="textfield" class="control-label">
                                                                                    *Special Price
                                                                                </label>
                                                                                <div class="controls">
                                                                                    <div id="addinput">
                                                                                        <input type="text" name="SpecialApplicationPrice" class="input-large" value="<?php echo $arrSetting['SpecialApplicationPrice']['SettingValue']; ?>" />
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="control-group">
                                                                                <label for="textfield" class="control-label">
                                                                                    *Special Category Price
                                                                                </label>
                                                                                <div class="controls">
                                                                                    <div id="addinput">
                                                                                        <input type="text" name="SpecialApplicationCategoryPrice" class="input-large" value="<?php echo $arrSetting['SpecialApplicationCategoryPrice']['SettingValue']; ?>" />
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="control-group">
                                                                                <label for="textfield" class="control-label">
                                                                                    *Special Product Price
                                                                                </label>
                                                                                <div class="controls">
                                                                                    <div id="addinput">
                                                                                        <input type="text" name="SpecialApplicationProductPrice" class="input-large" value="<?php echo $arrSetting['SpecialApplicationProductPrice']['SettingValue']; ?>" />
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-actions">
                                                                                <input type="submit" class="btn" name="btnSpecialApplicationUpdate" value="Update" style="float:left; margin:5px 100px 0 0; width:150px;" />
                                                                            </div>
                                                                            <div class="note">Note : * Indicates mandatory fields.</div>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>

                                                        <div class="box box-color box-bordered">
                                                            <div class="box-title">
                                                                <h3>
                                                                    Margin Cost
                                                                </h3>
                                                            </div>

                                                            <div class="box-content nopadding">
                                                                <form action="settings_action.php" method="post" id="frm_commission" onsubmit="return validateMarginCostForm(this);">
                                                                    <input  type="hidden" value="<?php echo $_SESSION['sessUser']; ?>" name="AdminID">

                                                                    <div class="row-fluid">
                                                                        <div class="span12 form-horizontal form-bordered box box-bordered box-color lightgrey">

                                                                            <div class="control-group">
                                                                                <label for="textfield" class="control-label">*Margin Cost %:   </label>
                                                                                <div class="controls">
                                                                                    <div id="addinput">
                                                                                        <input type="text" name="frmMarginCost" class="input-large" value="<?php echo $arrCommision[0]['MarginCast']; ?>" />
                                                                                    </div>

                                                                                </div>
                                                                            </div>

                                                                            <div class="form-actions">
                                                                                <input type="hidden" name="frmCommissionId" value="<?php echo $arrCommision[0]['pkCommissionID']; ?>" />
                                                                                <input type="submit" class="btn" name="btnMarginCostUpdate" value="Update" style="float:left; margin:5px 100px 0 0; width:150px;" />
                                                                            </div>
                                                                            <div class="note">Note : * Indicates mandatory fields.</div>

                                                                        </div>
                                                                    </div>

                                                                </form>
                                                            </div>

                                                        </div>

                                                        <div class="box box-color box-bordered">
                                                            <div class="box-title">
                                                                <h3>
                                                                    Commission
                                                                </h3>
                                                            </div>

                                                            <div class="box-content nopadding">
                                                                <form action="settings_action.php" method="post" id="frm_commission" onsubmit="return validateDefaultCommissionForm(this);">
                                                                    <input  type="hidden" value="<?php echo $_SESSION['sessUser']; ?>" name="AdminID">

                                                                    <div class="row-fluid">
                                                                        <div class="span12 form-horizontal form-bordered box box-bordered box-color lightgrey">

                                                                            <div class="control-group">
                                                                                <label for="textfield" class="control-label">*Default Wholesaler Sales Commission %:<br />
                                                                                    <span style="font-size: 10px;" class="req">Will be Paid to Wholesaler</span>   </label>
                                                                                <div class="controls">
                                                                                    <div id="addinput">
                                                                                        <input type="text" name="frmWholesalerSalesCommission" class="input-large" value="<?php echo $arrCommision[0]['Wholesalers']; ?>" />
                                                                                    </div>

                                                                                </div>
                                                                            </div>

                                                                            <div class="control-group">
                                                                                <label for="textfield" class="control-label">*Default Country Portal Sales Comission %:<br />
                                                                                    <span style="font-size: 10px;" class="req">Will be paid to country portal</span>   </label>
                                                                                <div class="controls">
                                                                                    <div id="addinput">

                                                                                        <input type="text" name="frmAdminUsersCommission" class="input-large" value="<?php echo $arrCommision[0]['AdminUsers']; ?>" />
                                                                                    </div>

                                                                                </div>
                                                                            </div>
                                                                            <div class="control-group">
                                                                                <label for="textfield" class="control-label">*Comission Period:</label>
                                                                                <div class="controls">
                                                                                    <div id="addinput">

                                                                                        <select name="frmAdminUsersPeriod" class="select2-me input-large nomargin">
                                                                                            <?php
                                                                                            foreach ($arrPeriod as $key => $val)
                                                                                            {
                                                                                                ?>
                                                                                                <option value="<?php echo $key; ?>" <?php
                                                                                                if ($key == $arrCommision[0]['SalesPeriod'])
                                                                                                {
                                                                                                    echo 'selected="selected"';
                                                                                                }
                                                                                                ?>><?php echo $val; ?></option>
    <?php } ?>
                                                                                        </select>
                                                                                    </div>

                                                                                </div>
                                                                            </div>

                                                                            <div class="form-actions">
                                                                                <input type="hidden" name="frmCommissionId" value="<?php echo $arrCommision[0]['pkCommissionID']; ?>" />
                                                                                <input type="submit" class="btn" name="btnDefaultCommissionUpdate" value="Update" style="float:left; margin:5px 100px 0 0; width:150px;" />
                                                                            </div>
                                                                            <div class="note">Note : * Indicates mandatory fields.</div>

                                                                        </div>
                                                                    </div>

                                                                </form>
                                                            </div>

                                                        </div>
                                                        <div class="box box-color box-bordered">
                                                            <div class="box-title">
                                                                <h3>
                                                                    KPI Performance Settings
                                                                </h3>
                                                            </div>
    <?php $arrKPISetting = $objAdminLogin->getKPISetting(); ?>
                                                            <div class="box-content nopadding">
                                                                <form action="settings_action.php" method="post" id="frm_ticket" onsubmit="return validateKPISettingForm();">
                                                                    <input  type="hidden" value="<?php echo $_SESSION['sessUser']; ?>" name="AdminID">

                                                                    <div class="row-fluid">
                                                                        <div class="span12 form-horizontal form-bordered box box-bordered box-color lightgrey">

                                                                            <div class="control-group">
                                                                                <label for="textfield" class="control-label">*Default Products Sold:</label>
                                                                                <div class="controls">
                                                                                    <div id="addinput">
                                                                                        <input type="hidden" name="frmCountryId[]" value="0" />
                                                                                        <select name="frmKPIVal[]" class="select2-me input-large nomargin">
                                                                                            <?php
                                                                                            for ($i = 10; $i < 101; $i = $i + 5)
                                                                                            {
                                                                                                ?>
                                                                                                <option value="<?php echo $i; ?>" <?php
                                                                                                if ($arrKPISetting[0] == $i)
                                                                                                {
                                                                                                    echo 'selected="selected"';
                                                                                                }
                                                                                                ?>><?php echo $i; ?></option>
    <?php } ?>
                                                                                        </select>&nbsp
                                                                                    </div>

                                                                                </div>
                                                                            </div>

                                                                            <div class="control-group">
                                                                                <label for="textfield" class="control-label">*#:</label>
                                                                                <div class="controls">
                                                                                    <div id="addKPIinput">
                                                                                        <?php
                                                                                        foreach ($arrKPISetting as $kct => $val)
                                                                                        {
                                                                                            if ($kct == 0)
                                                                                            {
                                                                                                continue;
                                                                                            }
                                                                                            ?>
                                                                                            <p>
                                                                                                <select name="frmCountryId[]" style="width:120px;">
                                                                                                    <option value="0">Select Country</option>
                                                                                                    <?php
                                                                                                    foreach ($arrCountry as $valct)
                                                                                                    {
                                                                                                        ?>
                                                                                                        <option value="<?php echo $valct['country_id']; ?>" <?php
                                                                                                    if ($kct == $valct['country_id'])
                                                                                                    {
                                                                                                        echo 'selected="selected"';
                                                                                                    }
                                                                                                        ?>><?php echo $valct['name']; ?></option>
                                                                                                    <?php } ?>
                                                                                                </select>
                                                                                                <select name="frmKPIVal[]" style="margin-left: 10px; width:90px;">
                                                                                                    <option value="0">Select Value</option>
                                                                                                    <?php
                                                                                                    for ($i = 10; $i < 101; $i = $i + 5)
                                                                                                    {
                                                                                                        ?>
                                                                                                        <option value="<?php echo $i; ?>" <?php
                                                                                                        if ($val == $i)
                                                                                                        {
                                                                                                            echo 'selected="selected"';
                                                                                                        }
                                                                                                        ?>><?php echo $i; ?></option>
        <?php } ?>
                                                                                                </select>
                                                                                                &nbsp;<a id="remNewKPI" href="#"><img title="Remove" alt="Remove" src="images/minus.png"></a>

                                                                                            </p>
    <?php } ?>
                                                                                    </div>
                                                                                    <div style="text-align: right; width: 250px;" >
                                                                                        <a href="#" id="addNewKPI"><img src="images/plus.png" alt="Add More" title="Add More" /></a></div>

                                                                                </div>
                                                                            </div>


                                                                            <div class="form-actions">
                                                                                <input type="submit" class="btn" name="btnKPIUpdate" value="Update" style="float:left; margin:5px 100px 0 0; width:150px;" />
                                                                            </div>
                                                                            <div class="note">Note : * Indicates mandatory fields.</div>

                                                                        </div>
                                                                    </div>

                                                                </form>
                                                            </div>

                                                        </div>
                                                         <div class="box box-color box-bordered">
                                                            <div class="box-title">
                                                                <h3>
                                                                   Premium Wholesaler KPI Performance Settings
                                                                </h3>
                                                            </div>
    <?php //$arrKPISetting = $objAdminLogin->getKPIPreSetting(); ?>
                                                            <div class="box-content nopadding">
                                                                <form action="settings_action.php" method="post" id="frm_ticket" onsubmit="return validateKPIPremiumSettingForm();">
                                                                    <input  type="hidden" value="<?php echo $_SESSION['sessUser']; ?>" name="AdminID">

                                                                    <div class="row-fluid">
                                                                        <div class="span12 form-horizontal form-bordered box box-bordered box-color lightgrey">

                                                                            <div class="control-group">
                                                                                <label for="textfield" class="control-label">*Default Products Sold:</label>
                                                                                <div class="controls">
                                                                                    <div id="addinput">
                                                                                       <input class="input-large" type="text" value="<?php echo $arrKPISetting[0]['productSold']?>" name="frmPreKPIProductVal" id="frmPreKPIProductVal">
                                                                                        
                                                                                            
                                                                                    </div>

                                                                                </div>
                                                                            </div>
                                                                            <div class="control-group">
                                                                                <label for="textfield" class="control-label">*Default kpi Value:</label>
                                                                                <div class="controls">
                                                                                    <div id="addinput">
                                                                                       <input class="input-large" type="text" value="<?php echo $arrKPISetting[0]['KPIValue']?>" name="frmPreKPIVal" id="frmPreKPIVal">          
                                                                                    </div>

                                                                                </div>
                                                                            </div>

                                                                            


                                                                            <div class="form-actions">
                                                                                <input type="submit" class="btn" name="btnKPIPreUpdate" value="Update" style="float:left; margin:5px 100px 0 0; width:150px;" />
                                                                            </div>
                                                                            <div class="note">Note : * Indicates mandatory fields.</div>

                                                                        </div>
                                                                    </div>

                                                                </form>
                                                            </div>

                                                        </div>
                                                        <div class="box box-color box-bordered">
                                                            <div class="box-title">
                                                                <h3>
                                                                    Wholesaler Template Setting
                                                                </h3>
                                                            </div>
    <?php $arrTempalteSetting = $objAdminLogin->getWholesalerTemplatesSetting(); ?>
                                                            <div class="box-content nopadding">
                                                                <form action="settings_action.php" method="post" id="frm_ticket">
                                                                    <input  type="hidden" value="<?php echo $_SESSION['sessUser']; ?>" name="AdminID">
                                                                    <div class="row-fluid">
                                                                        <div class="span12 form-horizontal form-bordered box box-bordered box-color lightgrey">

                                                                            <div class="control-group">
                                                                                <label for="textfield" class="control-label">*Default Template:</label>
                                                                                <div class="controls">
                                                                                    <div id="addinput">
                                                                                        <?php
                                                                                        //echo"<pre>";print_r($arrTempalteSetting);die;  
                                                                                        ?>
                                                                                        <select name="frmTemplateId" class="select2-me input-large nomargin">
    <?php
      foreach ($arrTempalteSetting as $template)
    {
        ?>
                                                                                                <option value="<?php echo $template['pkTemplateId']; ?>" <?php echo $template['templateDefault'] == 1 ? 'selected' : ''; ?>><?php echo $template['templateName']; ?></option>
    <?php } ?>
                                                                                        </select>
                                                                                    </div>

                                                                                </div>
                                                                            </div>
                                                                            <div class="form-actions">
                                                                                <input type="submit" class="btn" name="btnTemplateUpdate" value="Update" style="float:left; margin:5px 100px 0 0; width:150px;" />
                                                                            </div>
                                                                            <div class="note">Note : * Indicates mandatory fields.</div>

                                                                        </div>
                                                                    </div>

                                                                </form>
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
                    </div>




                </div>
            </div>

<?php require_once('inc/footer.inc.php'); ?>
        </div>

    </body>
</html>