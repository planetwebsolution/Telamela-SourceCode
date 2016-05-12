<?php
require_once 'common/config/config.inc.php';
if (isset($_SESSION['sessUserInfo']['id']) && $_SESSION['sessUserInfo']['type'] == 'customer') {
    require_once CONTROLLERS_PATH . FILENAME_CUSTOMER_ACCOUNT_CTRL;
    $objCustomer = new Customer();
    $provider = $_SESSION['sessUserInfo']['provider'];
    $objCustomer->doCustomerLogout();
    if (isset($provider) && $provider <> '') {
        header('location: ' . $objCore->getUrl('social_login.php', array('logout' => $provider)));
        die;
    }
} else if (isset($_SESSION['sessUserInfo']['id']) && $_SESSION['sessUserInfo']['type'] == 'wholesaler') {
    require_once CONTROLLERS_PATH . FILENAME_WHOLESALER_ACNT_CTRL;
    $objWholesaler = new Wholesaler();
    $objWholesaler->doWholesalerLogout();
}

header('location: ' . SITE_ROOT_URL);
die;
?>