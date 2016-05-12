<?php
require_once '../common/config/config.inc.php';
//require_once CONTROLLERS_LOGISTIC_PATH . FILENAME_ZONE_PRICE_CTRL;
?>
<div class="TemplateBlock">
    <div style="border: 1px solid #ccc;padding: 10px;float: left;width: 98%;text-align: left;background: #ddd;">Add new price</div>
    <table class="table table-bordered dataTable-scroll-x" style="border: 1px solid #ccc;margin-bottom: 25px;float: left;">
        <tr>
            <td> *Zone</td>
            <td>
                <?php
                $currentzonearry = $objGeneral->zonelistofcurrentlogist($_SESSION['sessLogistic']);

                $SelectedCountry = array();

                echo $objGeneral->zonelistofcurrentlogistichtml($currentzonearry, 'zoneid[]', 'zoneid', $SelectedCountry, 'Select Zone', 0, 'class="select2-me1 input-xlarge" ', 1, 0, 1);
                ?>

            </td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>

        </tr>
        <tr>
            <td> *Shipping Method</td>
            <td>
                <?php
                $shippingmethodarray = $objGeneral->shippingmethodlist();

                $SelectedCountry = array();

                echo $objGeneral->shippingmethodlisthtml($shippingmethodarray, 'shippingmethod[]', 'shippingmethodid', $SelectedCountry, 'Select Shipping Method', 0, 'class="select2-me input-xlarge zoneid" ', 1, 0, 1);
                ?>

            </td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>

        </tr>
        <tr>
            <td> *Maximum Dimension(L*W*H)</td>
            <td> <input type="text" name="length[]" placeholder="cm"/></td>
            <td> <input type="text" name="width[]" placeholder="cm"/></td>
            <td> <input type="text" name="height[]" placeholder="cm"/></td>
        </tr>
        <tr>
            <td> *Weight (kg)</td>
            <td> <input type="text" name="minweight[]" placeholder="Min (kg)"/></td>
            <td> <input type="text" name="maxweight[]" placeholder="Max (kg)"/></td>
            <td>&nbsp;</td>
        </tr>

        <tr>
            <td> *Cost Per Kg</td>
            <td> <input type="text" name="cost[]" placeholder="cost"/></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td> Handling cost ($) per item</td>
            <td> <input type="text" name="handlingcost[]" placeholder="handling cost"/></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td> Fragile Handling cost ($)</td>
            <td> <input type="text" name="fragilecost[]" placeholder="fragile cost"/></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td> *Delivery (Days)</td>
            <td> <input type="text" name="deliveryday[]" placeholder="days"/></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td> Cubic weight (cm3/kg)</td>
            <td> <input type="text" name="cubic[]" placeholder="cubic weight"/></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
    </table>
    <div style="float:left;margin-left: -21px;position: relative;left: 43px;display: inline-block; " class="PlusMinus">
        <i>
            <span style="cursor: pointer;width:51px;" class="plusPriceForm">
                <img src="../admin/images/plus.png">
            </span>
        </i>
<!--                                                                            <i><span valueOfJ="0" valueOfI="1" zoneid="11"style="cursor: pointer;width:51px;" title="Delete Complete zone" class="zoneeditRemove"><img src="../admin/images/minus.png"/></span></i>-->
    </div>
    <div style="float:left;margin-left: -22px;display: inline-block;position: relative;left: 64px;" class="">
        <i>
            <span style="cursor: pointer;width:51px;" title="Delete section" class="minusRemovePrice" >
                <img class="" src="../admin/images/minus.png">
            </span>
        </i>
    </div>

</div>