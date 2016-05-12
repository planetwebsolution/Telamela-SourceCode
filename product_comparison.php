<?php
require_once 'common/config/config.inc.php';
require_once CONTROLLERS_PATH . FILENAME_PRODUCT_COMPARISON_CTRL;
require_once CONTROLLERS_PATH . FILENAME_COMMON_CTRL;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Product Comparison</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <?php include_once 'common/inc/comman_css_js.inc.php'; ?>
        <script type="text/javascript">
            function RemoveFromComparison(id){
                $.post('common/ajax/ajax_compare.php',{action:'RemoveFromComparison',pid:id},function(data){
                    //$('#ajaxRemoveFromComparisonId').html(data);
                    $('#product_'+id).remove();
                    $('.removeCompareProduct').html('Product Removed Successfully! ');
                    if(data==''){
                        location.reload();
                    }
                });
            }
            function addToCartMsg(pid)
            {
                $("#addCompCartSuc_"+pid).css('display','block');
                setTimeout(function(){$("#addCompCartSuc_"+pid).css('display','none');},4000);
            }
        </script>
        <style>
            #cboxContent{ height:auto !important }
            /* #cboxLoadedContent{width:424px !important;}*/
            .cart_inner .detail_right {
                float: left;
                margin-left: 13px;
                width: 220px;
                box-sizing: border-box;}
            .cart_inner .proimg {
                border: 1px solid #cdcdcd;
                float: left;
                height: auto;
                position: relative;
                width: 150px;
                padding: 10px;
                box-sizing: border-box;
                background-color: #fff;}
            .cart_inner .cart_button {
                float: left;
                margin-top: 6px;}

        </style>

    </head>
    <body>
        <div id="navBar">
            <?php include_once 'common/inc/top-header.inc.php'; ?>
        </div>
        <div class="header"><div class="layout">

            </div>
        </div><?php include_once INC_PATH . 'header.inc.php'; ?>
        <div class="addToCart">
            <div class="addToCartClose" onclick="addToCartClose();">&nbsp;&nbsp;&nbsp;&nbsp;</div>
            <div class="addToCartMsg"></div>
        </div>           
        <div id="ouderContainer" class="ouderContainer_1">
            <div class="layout">
                <div class="add_pakage_outer">
                    <div class="top_header border_bottom">
                        <h1>COMPARE PRODUCT</h1>

                    </div>
                    <?php
                    // echo count($objPage->arrData['arrCompareDetails']);
                    if (count($objPage->arrData['arrCompareDetails']) > 0)
                    {
                        ?>

                        <div style="padding-bottom: 15px; color: green" class="removeCompareProduct"></div>
                        <div class="table-container">

<!--                            <table>
                                <tr>
                                    <td class="first">Compare</td>
                                    <td></td>
                                    <td></td>


                                </tr>
                                <tr>
                                    <td class="first">Quick View</td>
                                    <td></td>
                                    <td></td>

                                </tr>
                                <tr>
                                    <td class="first">Price</td>
                                    <td></td>
                                    <td></td>

                                </tr>
                                <tr>
                                    <td class="first">Wholesaler</td>
                                    <td></td>
                                    <td></td>

                                </tr>
                                <tr>
                                    <td class="first">Brand</td>
                                    <td></td>
                                    <td></td>

                                </tr>

                            </table>-->

                            <div class="comparision_1 smallerComparison" style="">
                                <table border="0"  cellpadding="0" cellspacing="0" class="width border-none">
                                    <tbody>
                                        <tr>
                                            <th style="border:none" ><div class="compare_txt"> Compare
                                                    <div class="mob_txt"><?php echo $objPage->arrData['arrCompareDetails'][0][0]['CategoryName']; ?></div></div></th>
                                        </tr>
                                        <tr class="compare_table">
                                            <td class="highlights height_1" >Quick View</td>
                                        </tr>
                                        <tr class="compare_table  odd" >
                                            <td  class="highlights height_2">Price</td>
                                        </tr>
                                        <tr class="compare_table">
                                            <td class="highlights height_3">Wholesaler</td>
                                        </tr>
                                        <tr class="compare_table  odd">
                                            <td  class="highlights height_4">
                                                <?php
                                                $varCountComp = 0;
                                               

                                                    $attr = array();
                                                    foreach ($objPage->arrData['arrCompareAttributeDetails'][$varCountComp] as $attribArray)
                                                    {
                                                        $attr[$attribArray['pkAttributeId']] = $attribArray['OptionTitle'];
                                                    }
                                                    foreach ($objPage->arrData['arrAttributeList'][$varCountComp] as $valueAttr)
                                                    {
                                                        // pre($objPage->arrData['arrCompareAttributeDetails'][6]);

                                                        echo '<li style="font-weight:bold;padding-left:0px;background:none;" class="high_lights">' . $valueAttr['AttributeLabel'] . '</li>';
                                                    }
                                               
                                                ?>
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                            <?php
                            $varCountComp = 0;
                            //AttributeLabel
                            //OptionTitle

                            foreach (array_slice($objPage->arrData['arrCompareDetails'], 0, 4) as $valProductCompare)
                            {
                                $varSrc = $objCore->getImageUrl($valProductCompare[0]['ImageName'], 'products/' . $arrProductImageResizes['global']);

                                $attr = array();
                                foreach ($objPage->arrData['arrCompareAttributeDetails'][$varCountComp] as $attribArray)
                                {
                                    $attr[$attribArray['pkAttributeId']] = $attribArray['OptionTitle'];
                                }
                                ?>
                                <div class="comparision_1" id="product_<?php echo $valProductCompare[0]['pkProductID']; ?>">
                                    <table border="0" style="border-collapse: collapse" class="width" align="center">
                                        <tr>
                                            <th bgcolor="#FFFFFF"  style="padding-bottom:47px" class="<?php echo ($varCountComp % 2 == 1) ? 'grey_td_blue' : 'grey_td' ?>">
                                                <a id="link" href="<?php echo $objCore->getUrl('product.php', array('id' => $valProductCompare[0]['pkProductID'], 'name' => $valProductCompare[0]['ProductName'], 'refNo' => $valProductCompare[0]['ProductRefNo'])); ?>">
                                                    <?php echo $objCore->getProductName($valProductCompare[0]['ProductName'], 20); ?>
                                                </a>
                                                <div class="close_icon"><img src="common/images/close.png" onclick="RemoveFromComparison(<?php echo $valProductCompare[0]['pkProductID']; ?>);" style="cursor:pointer;"/> </div>
                                                <div class="product_bx">
                                                    <a href="<?php echo $objCore->getUrl('product.php', array('id' => $valProductCompare[0]['pkProductID'], 'name' => $valProductCompare[0]['ProductName'], 'refNo' => $valProductCompare[0]['ProductRefNo'])); ?>">
                                                        <img align="middle" alt="" src="<?php echo $varSrc; ?>" style="vertical-align: middle; float:none;" />
                                                    </a>
                                                </div>
                                            </th>
                                        </tr>
                                        <tr>
                                            <td align="center" class=" height_1">

                                                <span class="success" style="margin-left:0px;display:none" id="addCompCartSuc_<?php echo $valProductCompare[0]['pkProductID']; ?>"><?php echo PRODUCT_ADD_IN_SHOPING_CART; ?></span>
                                                <div class="btn_buy">
                                                    <?php
                                                    $varAddCartUrl = '';

                                                    if ($valProductCompare[0]['Attribute'] == 0)
                                                    {
                                                        $varAddCartUrl = 'href="' . $objCore->getUrl('common/ajax/ajax_cart.php', array('action' => 'addToCart', 'pid' => $valProductCompare[0]['pkProductID'], 'qty' => '1')) . '" class="cart2 addCart ' . $valProductCompare[0]['pkProductID'] . '" onclick="addToCart(' . $valProductCompare[0]['pkProductID'] . ')" ';
                                                    }
                                                    else
                                                    {
                                                        $varAddCartUrl = 'href="' . $objCore->getUrl('product.php', array('id' => $valProductCompare[0]['pkProductID'], 'name' => $valProductCompare[0]['ProductName'], 'refNo' => $valProductCompare[0]['ProductRefNo'], 'add' => 'addCart')) . '#addCart"';
                                                    }
                                                    ?><a <?php echo $varAddCartUrl; ?> class="buy_nw_btn cart2" >BUY NOW</a>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="odd  height_2" >
                                                <?php
                                                if ($valProductCompare[0]['DiscountFinalPrice'] > 0)
                                                {
                                                    echo '<small>' . $objCore->getPrice($valProductCompare[0]['FinalPrice']) . '</small><br /><strong>' . $objCore->getPrice($valProductCompare[0]['DiscountFinalPrice']) . '</strong>';
                                                }
                                                else
                                                {

                                                    echo '<strong>' . $objCore->getPrice($valProductCompare[0]['FinalPrice']) . '</strong>';
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="height_3"><div class="available_txt"><?php echo ucfirst($valProductCompare[0]['WholeSalerName']); ?></div>

                                        </tr>
                                        <tr>
                                            <td class=" odd height_4"><ul>
                                                    <?php
                                                    foreach ($objPage->arrData['arrAttributeList'][$varCountComp] as $valueAttr)
                                                    {
                                                        // pre($objPage->arrData['arrCompareAttributeDetails'][6]);

                                                        echo '<li class="high_lights">';

                                                        if ($attr[$valueAttr['pkAttributeId']] != "")
                                                        {
                                                            echo $attr[$valueAttr['pkAttributeId']];
                                                        }
                                                        else
                                                        {
                                                            echo "NA";
                                                        }
                                                        echo '</li>';
                                                    }
                                                    ?>
                                                </ul></td>
                                        </tr>

                                    </table>
                                </div>
                                <?php
//                                if ($varCountComp == 3)
//                                {
//                                    break;
//                                }

                                $varCountComp++;
                            }
                            ?>

                        </div>
                        <?php
                    }
                    else
                    {
                        ?>
                        <div style="float: left; text-align: center; border: 0px solid #FF0000; width:1140px"> <a href="<?php echo SITE_ROOT_URL; ?>" style="float:right" class="con_shoping clear_cart "><span><?php echo BACK; ?></span></a> <br/>

                            <p style="width:100%; text-align:center;">No Products Available</p>
                        </div>
                    <?php } ?>




                </div>
            </div>
        </div>


        <script>
            $(window).load(function() {
                function equalHeight(group) { 
                    var tallest = 0;
                    var e=0;
                    
                    group.each(function() {
                        thisHeight = $(this).height();
                        if(thisHeight > tallest) {
                            tallest = thisHeight;
                        }
                
                    });
                    group.height(tallest); 
                }
                equalHeight($(".height_4"));
                equalHeight($(".height_2"));
            });   
        </script>            
        <?php include_once 'common/inc/footer.inc.php'; ?>
    </body>
</html>
