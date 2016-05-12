<?php
require_once 'common/config/config.inc.php';

if (isset($_SESSION['sessUserInfo']['id']) && $_SESSION['sessUserInfo']['type'] == 'wholesaler') {

    require_once CLASSES_PATH . 'class_wholesaler_bll.php';
    $objWholesaler = new Wholesaler();

    $varID = $objCore->getFormatValue($_REQUEST['sgid']);
    $arrData = $objWholesaler->getQuickViewMethods($varID);
    //pre($arrData);
    ?>
    <div class="methods_quickview"> 
        <div class="quick_color">
            <table cellspacing="0" cellpadding="0" border="0" style="width:100%">
                <tbody>
                    <tr>
                        <td colspan="12"><h2><label><?php echo $arrData['ShippingTitle']; ?></label></h2></td>
                    </tr>

                    <?php
                    if (count($arrData['methods']) > 0) {
                        foreach ($arrData['methods'] as $val) {
                            ?>
                            <tr>
                                <td colspan="12">&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="12"><label>Shipping Method:  <?php echo $val['MethodName'] . ' (' . $val['MethodName'] . ')'; ?></label></td>
                            </tr><tr>
                                <td colspan="12">&nbsp;</td>
                            </tr>
                            <tr class="content">      
                                <td valign="top"><label>Weight</label></td>
                                <td valign="top"><label>ZoneA</label></td>
                                <td valign="top"><label>ZoneB</label></td>
                                <td valign="top"><label>ZoneC</label></td>
                                <td valign="top"><label>ZoneD</label></td>
                                <td valign="top"><label>ZoneE</label></td>
                                <td valign="top"><label>ZoneF</label></td>
                                <td valign="top"><label>ZoneG</label></td>
                                <td valign="top"><label>ZoneH</label></td>
                                <td valign="top"><label>ZoneI</label></td>
                                <td valign="top"><label>ZoneJ</label></td>
                                <td valign="top"><label>ZoneK</label></td>                            
                            </tr>
                            <?php
                            foreach ($val['methodsPrice'] as $kp => $vp) {
                                ?>
                                <tr class="content">      
                                    <td valign="top"><?php echo $vp['Weight'] ?></td>
                                    <td valign="top"><?php echo $vp['ZoneA'] ?></td>
                                    <td valign="top"><?php echo $vp['ZoneB'] ?></td>
                                    <td valign="top"><?php echo $vp['ZoneC'] ?></td>
                                    <td valign="top"><?php echo $vp['ZoneD'] ?></td>
                                    <td valign="top"><?php echo $vp['ZoneE'] ?></td>
                                    <td valign="top"><?php echo $vp['ZoneF'] ?></td>
                                    <td valign="top"><?php echo $vp['ZoneG'] ?></td>
                                    <td valign="top"><?php echo $vp['ZoneH'] ?></td>
                                    <td valign="top"><?php echo $vp['ZoneI'] ?></td>
                                    <td valign="top"><?php echo $vp['ZoneJ'] ?></td>                                
                                    <td valign="top"><?php echo $vp['ZoneK'] ?></td>
                                </tr>
                                <?php
                            }
                            ?>

                            <?php
                        }
                    } else {
                        ?>
                                <tr>
                                <td colspan="12">&nbsp;</td>
                            </tr>
                        <tr>
                            <td colspan="12"><?php echo NO_SHIPPING_METHOD_FOUND ?></td>
                        </tr>
                        <tr>
                                <td colspan="12">&nbsp;</td>
                            </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
<?php } else { ?>
    <?php echo NO_SHIPPING_METHOD_FOUND ?>

    <?php
}?>