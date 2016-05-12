<?php
require_once 'common/config/config.inc.php';
require_once CONTROLLERS_PATH . FILENAME_WHOLESALER_SPECIAL_FORM_CTRL;
$country = $objCore->countryList();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title><?php echo SPECIAL_APPLICATION; ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>		        
        <?php include_once 'common/inc/comman_css_js.inc.php'; ?>
        <link rel="stylesheet" href="<?php echo CSS_PATH ?>select2.css"/>           
        <script src="<?php echo JS_PATH ?>select2.min.js"></script>
        <script  type="text/javascript">
            $(document).ready(function(){ 
                // $('.drop_down1').sSelect();
                
                $('.sort').click(function(){
                    var order = $(this).attr('order');
                    var col = $(this).attr('col');
                    $('#sort_order').val(order);
                    $('#sort_column').val(col);
                    $('#filter_form').submit();
                });
                $('.order_sec').addClass('<?php echo count($_POST) ? "show" : "hide"; ?>');
                $(".select2-me").select2();
                $('#spButton').on('click', function() {
                    $('.order_sec').toggle();
                });
                $('#filter_form_cancel').on('click', function() {
                    $('.order_sec').hide();
                    window.location.reload();
                });
                
                
            });
            function showProducts(frmId){
                $('#'+frmId).submit();
            }
            
        </script>

    </head>
    <body>
        <style>.sort{cursor:pointer;}</style>
        <em> <div id="navBar">
                <?php include_once INC_PATH . 'top-header.inc.php'; ?>
            </div>

        </em>
        <div class="header"><div class="layout"> </div>
            <?php include_once INC_PATH . 'header.inc.php'; ?>

        </div>

        <div id="ouderContainer" class="ouderContainer_1">
            <div class="wholesalerHeaderSection" style="width:100%;height:50px; padding-top:16px;	  border-bottom:1px solid #e7e7e7;">
                <div class="btn_top"><?php include_once 'common/inc/wholesaler.header.inc.php'; ?></div></div>
            <div class="layout">

                <div class="add_pakage_outer">
                    <div class="top_container" style="padding: 19px 0 19px 0">
                        <!--                    <div class="top_header border_bottom">
                            <h1><?php echo SPECIAL; ?> <span> <?php echo APPLICATION; ?></h1>
                            </div>-->

                        <?php
                        if ($objCore->displaySessMsg())
                        {
                            echo '<div style="text-align:center;color:#629F20;">' . $objCore->displaySessMsg() . '</div>';
                            $objCore->setSuccessMsg('');
                            $objCore->setErrorMsg('');
                        }
                        ?>
                    </div>

                    <div class="body_inner_bg">
                        <div class="add_edit_pakage manage_sec wish_sec">
                            <div class="product_link">                                
                                <a class="multiple_link" href="<?php echo 'application_form_special.php?action=add'; ?>"><?php echo SEND_APPLICATION_FORM ?></a>                                
                                <span class="add_link" id="spButton" style="margin-left:10px">Search Special Application</span>
                            </div>
                            <div class="order_sec" style="margin-bottom:10px; width:100%;">
                                <form id="filter_form_search" action="" method="post" class="order_filter_input">
                                    <ul class="left_sec">
                                        <li style="margin-bottom:6px">
                                            <label>Specials/Events</label>
                                            <input name="frmFestivalTitle" id="frmFestivalTitle" type="text" value="<?php echo @$_POST['frmFestivalTitle'] ?>"/>

                                        </li>
                                        <li style="margin-bottom:10px; float:left;">
                                            <label>Country</label>
                                            <div class="drop4 dropdown_2">
                                                <select name="fkCountryID" class="select2-me" style="width:324px">
                                                    <option value="Select Country">Select Country</option>
                                                    <?php
                                                    foreach ($country as $con)
                                                    {
                                                        ?>
                                                    <option <?php if($con['country_id']==$_POST['fkCountryID']) { echo "selected"; } ?> value="<?php echo $con['country_id'] ?>"><?php echo $con['name'] ?></option>
                                                    <?php }
                                                    ?>
                                                </select>

                                            </div>
                                        </li>
                                        <li class="cb">
                                            <label>&nbsp;</label>
                                            <input class="submit2 submit3 my_submit_btn" type="submit" name="frmHidden" value="search" />
                                            <!--<a href="<?php echo $objCore->getUrl('manage_special_application.php'); ?>">-->
                                                <input onclick="window.location.href='<?php echo $objCore->getUrl('manage_special_application.php'); ?>'" style="margin-top:7px; height:39px;" class="submit2 cancel" type="button" id="filter_form_cancel" value="Cancel" />
                                            <!--</a>-->
                                        </li>

                                    </ul>
                                    <ul class="left_sec right">
                                        <li class="cb" style="float:left; margin-bottom:6px;">
                                            <label>Status</label>
                                            <div class="drop4">
                                                <select name="IsApproved" class="select2-me" style="width:324px">
                                                    <option value="Select Status">Select Status</option>
                                                    <option <?php echo $_POST['IsApproved'] == 'Pending' ? 'selected' : ''; ?> value="Pending">Pending</option>
                                                    <option <?php echo $_POST['IsApproved'] == 'Approved' ? 'selected' : ''; ?> value="Approved">Approved</option>
                                                </select>
                                            </div>
                                        </li>

                                    </ul>                                    
                                </form>
                            </div>
                            <form id="filter_form" action="" method="post">
                                <input type="hidden" name="sort_column" id="sort_column" value="" />
                                <input type="hidden" name="sort_order" id="sort_order" value="desc" />
                            </form>
                            
                            <div class="table-responsive">
                            <table border="0" class="manage_table">
                                <tr>
                                    <th>Transaction id</th>
                                    <th>Specials/Events</th>
                                    <th>Country</th>
                                    <th>Amount</th>
                                    <th>Added date</th>
                                    <th>Expiry date</th>
                                    <th class="sort linkCustomeHover" order="<?php echo $_POST['sort_order'] == 'desc' ? 'asc' : 'desc' ?>" col="CategoryName"><?php echo CATEGORY_TITLE; ?></th>
                                    <th class="sort linkCustomeHover" order="<?php echo $_POST['sort_order'] == 'desc' ? 'asc' : 'desc' ?>" col="ProductQty"><?php echo QUANTITY; ?></th>
                                    <th class="sort linkCustomeHover" order="<?php echo $_POST['sort_order'] == 'desc' ? 'asc' : 'desc' ?>" col="IsApproved"><?php echo STATUS; ?></th>
                                </tr>
                                <?php
                                if ($objPage->NumberofRows > 0)
                                {
                                    $varCounter = 0;
                                    //pre($objPage->arrRes);
                                    foreach ($objPage->arrRes as $val)
                                    {
                                        $varCounter++;
                                        $frmId = 'filter_form' . $varCounter;
                                        ?>                        
                                        <tr class="<?php echo $varCounter % 2 == 0 ? 'even' : 'odd'; ?>">
                                            <td><?php echo $val['TransactionID']; ?></td>
                                            <td><a href="<?php echo $objCore->getUrl('special.php', array('name' => $val['FestivalTitle'],'cid'=>$val['pkFestivalID'])); ?>" target="_bank" class="whl-app-link"><?php echo $val['FestivalTitle']; ?></a></td>
                                            <td><?php echo $val['CountryName']; ?></td>
                                            <td class="hidden-480"><?php echo $_SESSION['SiteCurrencySign'] . number_format($val['TotalAmount'], 2); ?></td>
                                            <td><?php echo date('Y-m-d', strtotime($val['FestivalStartDate'])); ?></td>
                                            <td><?php echo date('Y-m-d', strtotime($val['FestivalEndDate'])); ?></td>
                                            <td> <form id="<?php echo $frmId ?>" action="<?php echo $objCore->getUrl('manage_products.php'); ?>" method="post">
                                                    <input type="hidden" name="frmCategory" value="<?php echo $val['fkCategoryID'] ?>" />
                                                    <input type="hidden" name="frmInStock" value="1" />
                                                    <input type="hidden" name="frmHidden" value="search" />
                                                    <a class="whl-app-link" href="javascript:void(0)" onclick="showProducts('<?php echo $frmId; ?>')"><?php echo $val['CategoryName'] ?></a>
                                                </form></td>
                                            <td><?php echo $val['ProductQty']; ?></td>
                                            <td><?php echo $val['IsApproved']; ?></td>
                                        </tr>
                                        <?php
                                    }
                                }
                                else
                                {
                                    echo '<tr class="odd"><td colspan="8">' . FRONT_WHOLESALER_PRODUCT_LIST_ERROR_MSG2 . '</td></tr>';
                                }
                                ?>
                            </table>
                            </div>
                            <?php
                            if ($objPage->NumberofRows > 0)
                            {
                                ?>
                                <table width="100%">
                                    <tr><td colspan="10">&nbsp;</td></tr>
                                    <tr>
                                        <td colspan="10">
                                            <table width="100%" border="0" align="center">
                                                <tr>
                                                    <td style="font-weight:bolder; text-align:right;" colspan="10" align="right">
                                                        <?php
                                                        if ($objPage->varNumberPages > 1)
                                                        {
                                                            $objPage->displayFrontPaging($_GET['page'], $objPage->varNumberPages, $objPage->varPageLimit);
                                                        }
                                                        ?>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr></table>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include_once 'common/inc/footer.inc.php'; ?>
    </body>
</html> 
