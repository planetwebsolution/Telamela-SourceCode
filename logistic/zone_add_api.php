<?php
require_once '../common/config/config.inc.php';
//require_once CONTROLLERS_ADMIN_PATH . FILENAME_SHIPPING_NEW_CTRL;
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
/*            .mapClass {
                height: 200px;
                width: 350px;
            }*/
            body .modal-body {
                width: 750px;
                margin-left:-100px;
            }
        </style>
    </head>
    <body>

        <?php require_once '../admin/inc/header_logistic.inc.php'; ?>
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
                                <a href="setup_manage_uil.php">Zone</a>
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
                                <form action=""  method="post" id="frm_page" onsubmit="return validateShipplingFormAdd(this);" class='form-horizontal form-bordered'>
                                    <div class="box-content nopadding">
                                        <div class="row-fluid">
                                            <div class="span12">
                                                <div class="box box-color box-bordered ">
                                                    <div class="nopadding">                                                            


                                                        <div class="control-group">
                                                            <!--                                                                <label for="textarea" class="control-label">*Zone:</label>-->

                                                            <div class="controls1 zone-country" style="padding: 20px ">

                                                                <div  style="float:left;border:1px solid #ccc; width: 90%;text-align: center; position:relative">
                                                                    <h4 style="top:0; left:20px">Zone1</h4>

                                                                    <table class="table table-bordered dataTable-scroll-x" id="productRow">

                                                                        <tr>
                                                                            <td>
                                                                                <label>From/Source</label>
                                                                            </td>
                                                                            <td>
                                                                                <?php
                                                                                $i = 0;
                                                                                $abc = $objGeneral->getCountry();
                                                                                $frmStateid = 'frmStateid_' . $i;
//                                                                                $html_entity = "onchange='showCountryState(this.value, 0, " . $frmStateid . " );' class='select2-me input-xlarge' style='width:auto' ";
                                                                                $html_entity = "DynamicMapId='map' class='select2-me input-xlarge changeAddress' style='width:auto' ";
//                                                                                $html_entity = "";
                                                                                echo $objGeneral->CountryNameLogistic($abc, 'fcountry[]', 'country_id', $SelectedCountry = array(), 'Select Country ', '', $html_entity, '1', '1');
                                                                                ?>
                                                                            </td>
                                                                            <td>

                                                                                <select name="fstate[]" onchange="showStateCity(this.value, 0, 'frmcityid');" id="frmStateid_<?php echo $i ?>" class='select2-me input-large changeAddress'>
                                                                                    <option value="0">Select State</option>
                                                                                </select>
                                                                            </td>
                                                                            <td>

                                                                                <select name="fcity[]"  id="frmcityid" class='select2-me input-large changeAddress'>
                                                                                    <option value="0">Select Country</option>
                                                                                </select>
                                                                            </td>
                                                                            <td><input type="text" name="distance[]" id="distance" placeholder="Distance +Km" ></td>

                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <label>To/Destination</label>
                                                                            </td>
                                                                            <td>
                                                                                <?php
                                                                                $abc = $objGeneral->getCountry();
//                                                                                $html_entity = "onchange='showCountryState(this.value, 0, " . '"toStateid"' . " );' class='select2-me input-xlarge' style='width:auto' ";
                                                                                $html_entity = "DynamicMapId='mapTo' class='select2-me input-xlarge changeAddress' style='width:auto' ";
//                                                                                $html_entity = "";
                                                                                echo $objGeneral->CountryNameLogistic($abc, 'tcountry[]', 'country_idTo', $SelectedCountry = array(), 'Select Country ', '', $html_entity, '1', '1');
                                                                                ?>
                                                                            </td>
                                                                            <td>

                                                                                <select name="tstate[]" onchange="showStateCity(this.value, 0, 'tocityid');" id="toStateid" class='select2-me input-large changeAddress'>
                                                                                    <option value="0">Select State</option>
                                                                                </select>
                                                                            </td>
                                                                            <td>

                                                                                <select name="tcity[]"  id="tocityid" class='select2-me input-large changeAddress'>
                                                                                    <option value="0">Select Country</option>
                                                                                </select>
                                                                            </td>
                                                                            <td><input type="text" name="distance[]" id="distance" placeholder="Distance +Km" ></td>

                                                                        </tr>
                                                                        <tr>
                                                                            <td colspan="2">
                                                                                <div class="mapClass" id="map"></div>
                                                                            </td>
                                                                            <td colspan="2">
                                                                                <div class="mapClass" id="mapTo"></div>
                                                                            </td>
                                                                        </tr>

                                                                    </table>
                                                                    
                                                                    <table class="table table-bordered dataTable-scroll-x" id="productRow">

                                                                        <tr>
                                                                            <td>
                                                                                <label>From/Source</label>
                                                                            </td>
                                                                            <td>
                                                                                <?php
                                                                                $i = 0;
                                                                                $abc = $objGeneral->getCountry();
                                                                                $frmStateid = 'frmStateid_' . $i;
//                                                                                $html_entity = "onchange='showCountryState(this.value, 0, " . $frmStateid . " );' class='select2-me input-xlarge' style='width:auto' ";
                                                                                $html_entity = "DynamicMapId='map_1' class='select2-me input-xlarge changeAddress' style='width:auto' ";
//                                                                                $html_entity = "";
                                                                                echo $objGeneral->CountryNameLogistic($abc, 'fcountry[]', 'country_id', $SelectedCountry = array(), 'Select Country ', '', $html_entity, '1', '1');
                                                                                ?>
                                                                            </td>
                                                                            <td>

                                                                                <select name="fstate[]" onchange="showStateCity(this.value, 0, 'frmcityid');" id="frmStateid_<?php echo $i ?>" class='select2-me input-large changeAddress'>
                                                                                    <option value="0">Select State</option>
                                                                                </select>
                                                                            </td>
                                                                            <td>

                                                                                <select name="fcity[]"  id="frmcityid" class='select2-me input-large changeAddress'>
                                                                                    <option value="0">Select Country</option>
                                                                                </select>
                                                                            </td>
                                                                            <td><input type="text" name="distance[]" id="distance" placeholder="Distance +Km" ></td>

                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <label>To/Destination</label>
                                                                            </td>
                                                                            <td>
                                                                                <?php
                                                                                $abc = $objGeneral->getCountry();
//                                                                                $html_entity = "onchange='showCountryState(this.value, 0, " . '"toStateid"' . " );' class='select2-me input-xlarge' style='width:auto' ";
                                                                                $html_entity = "DynamicMapId='mapTo_1' class='select2-me input-xlarge changeAddress' style='width:auto' ";
//                                                                                $html_entity = "";
                                                                                echo $objGeneral->CountryNameLogistic($abc, 'tcountry[]', 'country_idTo', $SelectedCountry = array(), 'Select Country ', '', $html_entity, '1', '1');
                                                                                ?>
                                                                            </td>
                                                                            <td>

                                                                                <select name="tstate[]" onchange="showStateCity(this.value, 0, 'tocityid');" id="toStateid" class='select2-me input-large'>
                                                                                    <option value="0">Select State</option>
                                                                                </select>
                                                                            </td>
                                                                            <td>

                                                                                <select name="tcity[]"  id="tocityid" class='select2-me input-large'>
                                                                                    <option value="0">Select Country</option>
                                                                                </select>
                                                                            </td>
                                                                            <td><input type="text" name="distance[]" id="distance" placeholder="Distance +Km" ></td>

                                                                        </tr>
                                                                        <tr>
                                                                            <td colspan="2">
                                                                                <div class="mapClass" id="map_1"></div>
                                                                            </td>
                                                                            <td colspan="2">
                                                                                <div class="mapClass" id="mapTo_1"></div>
                                                                            </td>
                                                                        </tr>

                                                                    </table>
                                                                </div>
                                                                <div  style="float:left; margin-left: 30px; " class="PlusMinus">
                                                                    <i><span style="cursor: pointer;width:51px;"  onclick="addDynamicRowTozone(country_id.value);"><img src="../admin/images/plus.png"/></span></i>
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <div class="form-actions">                        
                                                            <button name="frmBtnSubmit" type="submit" class="btn btn-blue" value="<?php echo ADMIN_SUBMIT_BUTTON; ?>" ><?php echo ADMIN_SUBMIT_BUTTON; ?></button>  
                                                            <a id="buttonDecoration" href="<?php echo $httpRef; ?>">
                                                                <button name="frmCancel" type="button" value="Cancel" class="btn" ><?php echo ADMIN_SEARCH_CANCEL_BUTTON; ?></button>
                                                            </a>                                                                           
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
                    <?php // } else { ?>
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
<script>
//    var map;
//    var mapTo;
    function initMap(mapId) {


//        if (typeof mapId == 'undefined') {
//
//            mapId = 'map';
//        }
//        if ((typeof lat == 'undefined') || (typeof lng == 'undefined')) {
//            lat = -34.397;
//            lng = 150.644;
//        }
//
//        if (mapId == 'map') {
//            map = new google.maps.Map(document.getElementById(mapId), {
//                center: {lat: lat, lng: lng},
//                zoom: 8
//            });
//        }
//        if (mapId == 'mapTo') {
//            mapTo = new google.maps.Map(document.getElementById(mapId), {
//                center: {lat: lat, lng: lng},
//                zoom: 8
//            });
//        }
    }


    function setMapObj(mapId) {

        map = new google.maps.Map(document.getElementById(mapId), {
            //center: {lat: lat, lng: lng},
            zoom: 8
        });
        return map;
    }

    $(document).on('change', '.changeAddress', function () {
        var geocoder = new google.maps.Geocoder();
        var CountryName = $('option:selected', this).text();
        var mapDivId = $(this).attr('dynamicmapid');
        var returnMap = setMapObj(mapDivId);
        geocodeAddress(geocoder, returnMap, CountryName);

    });
//    $(document).on('click', '.mapClass', function (event) {
//        console.log(event);
//        var mapShowId = $(this).attr('id');
//        var returnMap = setMapObj(mapShowId);
//    });
//    $(document).on('change', '.changeAddress', function () {
//        var geocoder = new google.maps.Geocoder();
//        var CountryName = $('option:selected', this).text();
//        var mapDivId = $(this).attr('dynamicmapid');
//        var returnMap = setMapObj(mapDivId);
//        geocodeAddressTo(geocoder, returnMap, CountryName);
//
//    });

    function geocodeAddress(geocoder, resultsMap, CountryName) {
        var infowindow = new google.maps.InfoWindow;
        //var address = document.getElementById('address').value;
        geocoder.geocode({'address': CountryName}, function (results, status) {
            if (status === google.maps.GeocoderStatus.OK) {
                
                resultsMap.setCenter(results[0].geometry.location);
                var marker = new google.maps.Marker({
                    map: resultsMap,
                    position: results[0].geometry.location
                });
                infowindow.setContent(results[0].formatted_address);
                infowindow.open(resultsMap, marker);
            } else {
                alert('Geocode was not successful for the following reason: ' + status);
            }
        });
    }
    function geocodeAddressTo(geocoder, resultsMap, CountryName) {
        var infowindow = new google.maps.InfoWindow;
        //var address = document.getElementById('address').value;
        geocoder.geocode({'address': CountryName}, function (results, status) {
            if (status === google.maps.GeocoderStatus.OK) {
                resultsMap.setCenter(results[0].geometry.location);
                var marker = new google.maps.Marker({
                    map: resultsMap,
                    position: results[0].geometry.location
                });
                console.log(resultsMap);
                infowindow.setContent(results[0].formatted_address);
                infowindow.open(resultsMap, marker);
            } else {
                alert('Geocode was not successful for the following reason: ' + status);
            }
        });
    }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA8kl6Y5NayGiy9zHR7rn4Cmu6dNnxF-Fk&callback=initMap"
async defer></script>
