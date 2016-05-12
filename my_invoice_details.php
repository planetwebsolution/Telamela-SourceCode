<?php
require_once 'common/config/config.inc.php';
require_once CONTROLLERS_PATH . FILENAME_CUSTOMER_ORDERDETAIL_CTRL;
$arrData = $objPage->arrData['arrInvoice'];
$rowsNum = count($arrData);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>My Invoice Detail</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <link type="text/css" rel="stylesheet" href="<?php echo CSS_PATH; ?>/invoice.css" />
        <link type="text/css" rel="stylesheet" href="<?php echo CSS_PATH; ?>print.css" media="print" />
    </head>
    <body>
        <table border="0" width="100%" class="no-print">
            <tr>
                <td align="right"><button onclick="window.close();"> Close</button>&nbsp;&nbsp;<button onclick="window.print();">Print</button></td>
            </tr>
        </table>

        <?php
        if ($rowsNum > 0) {
            foreach ($arrData as $key => $value) {
                ?>
                <?php echo html_entity_decode($value['InvoiceDetails']); ?>
                <div style="height: 50px; clear: both;"></div>
                <?php
            }
        } else {
            echo '<p align="center">No Results Found!</p>';
        }
        ?>
    </body>
</html>
