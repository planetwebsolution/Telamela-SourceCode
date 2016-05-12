<?php
require_once 'common/config/config.inc.php';
require_once CONTROLLERS_PATH . FILENAME_WHOLESALER_SPECIAL_FORM_CTRL;

$paypal_id = SPECIAL_PAYPAL_ID;

function amountFormat($amount)
{
    return number_format($amount, 2, '.', ',');
}
?>
<html>
    <head>
          <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH ?>xhtml.css"/>
    </head>
    <body>
        <div id="loading">
            <div id="loader_container">
                <!--<div id="loader_text"><img src="<?php echo SITE_ROOT_URL?>common/images/loading-blue.gif" width="100px" height="100px"/></div>-->
                <div id="loader_text">Your payment request is being processed...<br/> Please do not refresh page or press back button</div>
            </div>
        </div> 
        <?php
        if (isset($_POST['frmButtonPaypal']) && $_POST['frmButtonPaypal'] == PAYMENT_PAYNOW_BUTTON)
        { // Process Gift Card
            ?>
            <form action="<?php echo PAYPAL_URL; ?>" method="post" name="frmPayPal1">
                <input type="hidden" name="business" value="<?php echo $paypal_id; ?>">
                <input type="hidden" name="cmd" value="_cart">
                <input type="hidden" name="upload" value="1">
                <?php
                foreach ($_POST['frmCountry'] as $key => $val)
                {
                    $specialQty++;

                    foreach ($_POST['frmCategory'][$key] as $k => $v)
                    {
                        $catQty++;
                        $proQty += (int) $_POST['frmProductQty'][$key][$k];
                    }
                }

                $arrData = array(
                    '0' => array('title' => 'Specials', 'price' => $objPage->arrSetting['SpecialApplicationPrice']['SettingValue'], 'qty' => $specialQty),
                    '1' => array('title' => 'Categories', 'price' => $objPage->arrSetting['SpecialApplicationCategoryPrice']['SettingValue'], 'qty' => $catQty),
                    '2' => array('title' => 'Products', 'price' => $objPage->arrSetting['SpecialApplicationProductPrice']['SettingValue'], 'qty' => $proQty)
                );

                $cnt = 1;
                foreach ($arrData as $key => $val)
                {
                    ?> 
                    <input type="hidden" name="item_name_<?php echo $cnt ?>" value="<?php echo $val['title']; ?>">
                    <input type="hidden" name="amount_<?php echo $cnt ?>" value="<?php echo amountFormat($val['price']); ?>">
                    <input type="hidden" name="quantity_<?php echo $cnt ?>" value="<?php echo $val['qty']; ?>">
        <?php
        $cnt++;
    }
    ?>
                <input type="hidden" name="cpp_header_image" value="<?php echo SITE_ROOT_URL; ?>common/images/logo.png">
                <input type="hidden" name="currency_code" value="USD">
                <input type="hidden" name="rm" value="2">
                <input type="hidden" name="cbt" value="<?php echo RETURN_TO_TELAMELA; ?>">
                <input type="hidden" name="custom" value='<?php echo base64_encode("ApplicationIds-" . $objPage->insertId . ""); ?>'>
                <input type="hidden" name="notify_url" value="<?php echo SITE_ROOT_URL; ?>payment_notify_special.php" />
                <input type="hidden" name="cancel_return" value="<?php echo SITE_ROOT_URL; ?>payment_cancel.php">
                <input type="hidden" name="return" value="<?php echo SITE_ROOT_URL; ?>payment_success_special.php">
            </form>
            <script>
                document.frmPayPal1.submit();
            </script>
<?php }
?>
    </body>
</html>