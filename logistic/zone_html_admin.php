<?php
require_once '../common/config/config.inc.php';
//require_once CONTROLLERS_ADMIN_PATH . FILENAME_SHIPPING_NEW_CTRL;
$state_id = $_REQUEST['c'];
$i = $_REQUEST['i'] + 1;
$j = $_REQUEST['j'];
$SelectedCountry = $_REQUEST['frmcountryid'];
?>
<!--<style>
    .zone-country .input-xlarge{ width:210px !important}  

</style>-->
<table  style="border: 1px solid #ccc;box-shadow: 0 0 6px #ccc;margin-bottom: 10px;float: left;"class="table table-bordered dataTable-scroll-x tableClass_<?php echo $j . '_' . $i; ?>" id="productRow">

    <tr>
        <td>
            <label>From/Source</label>
        </td>
        <td>
            <?php
            //pre($state_id);
            //$i = 0;
            $abc = $objGeneral->getCountry();
            $frmStateid = '"frmStateid_' . $j . '_' . $i . '"';
            $fcountry_id = 'frmcountryid_' . $j . '_' . $i;
            $frmdistance = 'frmdistance_' . $j .'_'. $i;
            $incrvar = 'incrvar_' . $i;
            $dynamicmapid = '"map_' . $j . '_' . $i . '"';
            $html_entity = "DynamicMapId=$dynamicmapid onchange='showCountryState(this.value, 0, " . $frmStateid . ", this );' class='select2-me1 countrycheck input-xlarge' style='width:auto' ";
            echo $objGeneral->CountryNameLogistic($abc, 'fcountry[' . $j . '][]', $fcountry_id, $SelectedCountry, 'Select Country', '', $html_entity, '1', '1');
            ?>
            <input type="hidden" name="<?php echo $incrvar ?>" value="<?php echo $i ?>"/>
        </td>
        <?php $frmcityid = 'frmcityid_' . $j . '_' . $i; ?>
        <td>

            <select name="fstate[<?php echo $j; ?>][]" onchange="showStateCity(this.value, 0, '<?php echo $frmcityid; ?>', this, '<?php echo $j; ?>',  '<?php echo $i; ?>');" id="frmStateid_<?php echo $j . '_' . $i; ?>" class='select2-me1 input-large statecheck'>
                <option value="0">Select State</option>
            </select>
        </td>
        <td>

            <select name="fcity[<?php echo $j; ?>][]"  id="frmcityid_<?php echo $j . '_' . $i; ?>"minusI = "<?php echo $i; ?>" minusJ = "<?php echo $j; ?>" class='select2-me1 input-large  citycheck'>
                <option value="0">Select City</option>
            </select>
        </td>
        <td><input type="text" name="frmdistance[<?php echo $j; ?>][]" id="<?php echo $frmdistance ?>"  class="distancecheck" disabled="disabled" placeholder="Distance +Km" ></td>

    </tr>
    <tr>
        <td>
            <label>To/Destination</label>
        </td>
        <td>
            <?php
            $abc = $objGeneral->getCountry();
            $toStateid = '"toStateid_' . $j . '_' . $i . '"';
            $tcountry_id = 'tocountryid_' . $j . '_' . $i;
            $dynamicmapid = '"mapTo_' . $j . '_' . $i . '"';
            $html_entity = "DynamicMapId=$dynamicmapid onchange='showCountryState(this.value, 0, " . $toStateid . ", this );' class='select2-me1 countrytocheck input-xlarge' style='width:auto' ";
            echo $objGeneral->CountryNameLogistic($abc, 'tcountry[' . $j . '][]', $tcountry_id, $SelectedCountry = array(), 'Select Country', '', $html_entity, '1', '1');
            ?>
        </td>
        <?php $tocityid = 'tocityid_' . $j . '_' . $i; ?>
        <td>

            <select name="tstate[<?php echo $j; ?>][]" onchange="showStateCity(this.value, 0, '<?php echo $tocityid; ?>');" id="toStateid_<?php echo $j . '_' . $i; ?>" class='select2-me1 input-large'>
                <option value="0">Select State</option>
            </select>
        </td>
        <td>

            <select name="tcity[<?php echo $j; ?>][]"  id="tocityid_<?php echo $j . '_' . $i; ?>" minusI = "<?php echo $i; ?>" minusJ = "<?php echo $j; ?>"class='select2-me1 input-large  citycheckto'>
                <option value="0">Select City</option>
            </select>
        </td>
        <td><input type="text" name="todistance[<?php echo $j; ?>][]" id="todistance_<?php echo $j.'_'.$i ?>" class="distancecheck" disabled="disabled" placeholder="Distance +Km" ></td>

    </tr>
    <tr class="label-csc">
        <td colspan="3"><label>From</label><a href="#" data-toggle="modal" onclick="javascript: modeli = '<?php echo $i; ?>', modelj = '<?php echo $j; ?>', fromTo = 'from'"  data-target="#myModal"> <img src="../admin/images/Globe.png"/></a></td>

        <td colspan="2"><label>To</label> <a href="#" data-toggle="modal" onclick="javascript: modeli = '<?php echo $i; ?>', modelj = '<?php echo $j; ?>', fromTo = 'to'"  data-target="#myModal"> <img src="../admin/images/Globe.png"/></a></td>
    </tr>

</table>

<div style="float:left;margin-left: -22px;display: inline-block;position: relative;left: 64px;" class="PlusMinus_<?php echo $j . '_' . $i; ?>"  >
    <i><span valueofi="1" valueofj="0" style="cursor: pointer;width:51px;" title="Delete section" class="minusRemove" minusI = "<?php echo $i; ?>" minusJ = "<?php echo $j; ?>" ><img class="" src="../admin/images/minus.png"></span></i>
</div>
<script>
    $(document).on('click', '.minusRemove', function () {
        var minusI = $(this).attr('minusI');
        var minusJ = $(this).attr('minusJ');
        $('.tableClass_' + minusJ + '_' + minusI).remove();
        $('.PlusMinus_' + minusJ + '_' + minusI).remove();
    });
    
</script>