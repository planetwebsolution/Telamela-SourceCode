<?php

require_once '../common/config/config.inc.php';
require_once CLASSES_ADMIN_PATH . 'class_adminlogin_bll.php';
require_once $arrConfig['sourceRoot'] . 'components/class.validation.inc.php';
require_once CLASSES_PATH . 'class_email_template_bll.php';
require_once CLASSES_SYSTEM_PATH . 'class_upload_bll.php';

$objAdminLogin = new AdminLogin();
//check admin session
$objAdminLogin->isValidAdmin();

// ADMIN EMAIL IS UPDATING HERE.

if (isset($_POST['frmAdminEmail'])) {
    $objAdminLogin->changeAdminEmail($_POST);
    header('location:settings_frm_uil.php');
    exit;
}

// ADMIN PASSWORD IS UPDATING HERE.
if (isset($_POST['btnPasswordUpdate'])) {
    $objAdminLogin->changeAdminPassword($_POST);
    header('location:settings_frm_uil.php');
    exit;
}

// ADMIN PAGE LIMIT IS UPDATING HERE.
if (isset($_POST['btnPageLimitUpdate'])) {
    $objAdminLogin->changeAdminPageLimit($_POST);
    header('location:settings_frm_uil.php');
    exit;
}

// ADMIN Support Ticket Types IS UPDATING HERE.
if (isset($_POST['btnTicketUpdate'])) {
    $objAdminLogin->changeSupportTicket($_POST);
    header('location:settings_frm_uil.php');
    exit;
}
// ADMIN Support Ticket Types IS UPDATING HERE.
if (isset($_POST['btnDisputedUpdate'])) {
    $objAdminLogin->changeDisputedCommentTitle($_POST);
    header('location:settings_frm_uil.php');
    exit;
}

// ADMIN default Commission and margin IS UPDATING HERE.
if (isset($_POST['btnDefaultCommissionUpdate'])) {
    $objAdminLogin->changeDefaultCommission($_POST);
    header('location:settings_frm_uil.php');
    exit;
}

// ADMIN default Commission and margin IS UPDATING HERE.
if (isset($_POST['btnDelayTimeUpdate'])) {
    $objAdminLogin->changeDelayTime($_POST);
    header('location:settings_frm_uil.php');
    exit;
}

// ADMIN default Commission and margin IS UPDATING HERE.
if (isset($_POST['btnSpecialApplicationUpdate'])) {    
    $objAdminLogin->changeSpecialApplicationPrice($_POST);
    header('location:settings_frm_uil.php');
    exit;
}

// ADMIN default Commission and margin IS UPDATING HERE.
if (isset($_POST['btnRewardPointsUpdate'])) {    
   // pre($_POST);
    $objAdminLogin->changeRewardPoints($_POST);
    header('location:settings_frm_uil.php');
    exit;
}

// ADMIN default Commission and margin IS UPDATING HERE.
if (isset($_POST['btnMarginCostUpdate'])) {
    $objAdminLogin->changeMarginCost($_POST);
    header('location:settings_frm_uil.php');
    exit;
}

// ADMIN KPI Setting IS UPDATING HERE.
if (isset($_POST['btnKPIUpdate'])) {
    $objAdminLogin->changeKPISetting($_POST);
    header('location:settings_frm_uil.php');
    exit;
}

// ADMIN KPI Setting IS UPDATING HERE.
if (isset($_POST['btnKPIPreUpdate'])) {
    $objAdminLogin->changeKPIPreSetting($_POST);
    header('location:settings_frm_uil.php');
    exit;
}

// ADMIN KPI Setting IS UPDATING HERE.
if (isset($_POST['btnTemplateUpdate'])) {
    $objAdminLogin->changeDefaultTemplate($_POST);
    header('location:settings_frm_uil.php');
    exit;
}
?>