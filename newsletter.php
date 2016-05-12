<?php
require_once 'common/config/config.inc.php';
require_once CONTROLLERS_PATH . FILENAME_NEWSLETTER_CTRL;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title><?php echo NEWSLETTER_TITLE; ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>		
        <?php include_once 'common/inc/comman_css_js.inc.php'; ?>
        <link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH ?>layout1.css"/>
        <script  type="text/javascript">
            $(document).ready(function(){ 
                $('.drop_down1').sSelect();
                $('#DateStart').datepick({dateFormat: 'dd-mm-yyyy',showTrigger:'<small><a href="javascript:void(0)"><img src="common/images/cal_icon.png" alt=""  class="trigger"/></a></small>'});
                $('#DateEnd').datepick({dateFormat: 'dd-mm-yyyy',showTrigger:'<small><a href="javascript:void(0)"><img src="common/images/cal_icon.png" alt=""  class="trigger"/></a></small>'});
				
                $("#spButton").click(function() {
                    $('.product_search1').slideToggle('slow');
                });
                $('.product_search1').addClass("<?php echo count($_POST) ? 'show' : 'hide'; ?>");

            });
        </script>
        <style>
            .product_search1 .input_sec{width:347px}
            .stylish-select .drop4 .newListSelected{width:324px;}            
            .stylish-select .drop4 .selectedTxt {background: url("common/images/select2.png") no-repeat scroll 126% 5px #fff;width: 269px; }
        </style>
    </head>
    <body>
        <em> <div id="navBar">
                <?php include_once INC_PATH . 'top-header.inc.php'; ?>
            </div>

        </em>
        <div class="header"><div class="layout"> </div>
            <?php include_once INC_PATH . 'header.inc.php'; ?>

        </div>

        <div id="ouderContainer" class="ouderContainer_1"><div class="wholesalerHeaderSection" style="width:100%;height:50px; padding-top:20px;	  border-bottom:1px solid #e7e7e7;"><div class="btn_top"><?php include_once 'common/inc/wholesaler.header.inc.php'; ?></div></div>
            <div class="layout" style="border-top:0px">
                <div>

                    <?php
                    if ($objCore->displaySessMsg())
                    {
                        ?>
                        <div class="successMessage">
                            <?php
                            echo $objCore->displaySessMsg();
                            $objCore->setSuccessMsg('');
                            $objCore->setErrorMsg('');
                            ?>
                        </div>
                    <?php }
                    ?>
                </div>
                <div class="add_pakage_outer" >
                    <div class="top_container">
                        <!--<div class="top_header border_bottom">
                            <h1><?php // echo NEWSLETTER;            ?></h1>
                        </div>-->

                    </div>
                    <?php include_once 'common/inc/wholesaler.header.inc.php'; ?>


                    <div class="body_inner_bg">
                        <div class="add_edit_pakage main_news_sec wish_sec">
                            
                            <div class="product_link">
							<a href="<?php echo $objCore->getUrl('create_newsletter.php', array('place' => 'create')); ?>" class="create"><?php echo CREATE_NEWS; ?></a>
                                <span class="add_link" id="spButton">Search Newsletter</span>
                            </div>
                            <div class="product_search1">
                                <form action="" method="post" name="filterList" id="order_filter" class="order_filter_input" >
                                    <ul class="left_sec myFullWidth">
                                        <li>
                                            <label>Newsletter Title</label>
                                            <input type="text" value="<?php echo @$_POST['Title'] ?>" name="Title" id="Title" />
                                        </li>
                                        <li class="toRight">
                                            <label>Created Date</label>
                                            <div class="input_sec input_sec2">
                                                <div class="cal_sec">
                                                    <!--<span><?php echo ST_DATE; ?></span>-->
                                                    <input id="DateStart" style="z-index: 33; " type="text" value="<?php echo $_POST['StartDate'] ?>" name="StartDate" class="text3"/>
                                                    <!--<small><a href="#"><img src="common/images/cal_icon.png" alt=""/></a></small>-->
                                                </div>
                                                <div class="cal_sec">
                                                    <span><?php echo TO; ?></span>
                                                    <input type="text" style="z-index: 33;" id="DateEnd" value="<?php echo $_POST['EndDate'] ?>" name="EndDate" class="text3"/>
                                                    <!--<small><a href="#"><img src="common/images/cal_icon.png" alt=""/></a></small>-->
                                                </div>
                                            </div>
                                        </li>
                                   
										
										<li class="cb">
                                            <label>Newsletter Status</label>
                                            <div class="drop4">
                                                <select class="drop_down1" name="NewsletterStatus" id="NewsletterStatus">
                                                    <option value="">Select Newsletter Status</option>
                                                    <option <?php echo $_POST['NewsletterStatus'] == 'Active' ? 'selected' : '' ?> value="Active">Active</option>
                                                    <option <?php echo $_POST['NewsletterStatus'] == 'Pending' ? 'selected' : '' ?> value="Pending"><?php echo PEN; ?></option>
                                                    <option <?php echo $_POST['NewsletterStatus'] == 'Delivered' ? 'selected' : '' ?> value="Delivered">Delivered</option>
                                                </select>
                                            </div>
                                        </li>
                                        
										<li class="cb">
                                            <label>&nbsp;</label>
                                            <input type="submit" class="submit2 submit3 my_submit_btn" value="Search" style="padding-left: 0px;"/>
                                            <!--<a href="<?php echo $objCore->getUrl('newsletter.php'); ?>">-->
                                                <input onclick="window.location.href='<?php echo $objCore->getUrl('newsletter.php'); ?>'" type="button" class="submit2 cancel" value="Cancel" style="margin-top:7px; height:39px;"/>
                                            <!--</a>-->

                                        </li>
                                    </ul>
                                   
                                    <input type="hidden" name="search" value="search" />
                                </form>
                            </div>

							<div class="table-responsive">
                            <table border="0" class="manage_table">
                                <tr>
                                    <th style="width:90px;"><?php echo DATE; ?></th>
                                    <th><?php echo TITLE; ?></th>
                                    <th><?php echo STATUS; ?></th>
                                    <th><?php echo ACTION; ?></th>
                                </tr>
                                <?php
                                $varCounter = 0;
                                if (count($objPage->arrNewsleterList) > 0)
                                {
                                    foreach ($objPage->arrNewsleterList as $varArray)
                                    {
                                        $varCounter++;
                                        ?>                        
                                        <tr class="<?php echo $varCounter % 2 == 0 ? 'even' : 'odd'; ?>">
                                            <td><?php echo $objCore->localDateTime($varArray['DeliveryDate'], DATE_FORMAT_SITE_FRONT); ?></td>
                                            <td><?php echo $varArray['Title'] ?></td>
                                            <td><?php echo $varArray['DeliveryStatus']; ?></td>
                                            <td><a title="view details" href="<?php echo $objCore->getUrl('view_newsletter.php', array('place' => 'view', 'nlid' => $varArray['pkNewsLetterID'])); ?>" class="viewbig active"><i class="fa fa-eye"></i></a></td>
                                        </tr>
                                        <?php
                                    }
                                }
                                else
                                {
                                    ?>
                                    <tr class="odd"><td colspan="4">
                                            <?php
                                            // if ($_POST['Title'])
                                            //{
                                            echo FRONT_WHOLESALER_PRODUCT_LIST_ERROR_MSG2;
                                            //}
                                            //else
                                            // {
                                            // echo FRONT_WHOLESALER_PRODUCT_LIST_ERROR_MSG5;
                                            //}
                                        }
                                        ?>
                                    </td>
                                </tr>
							
							</table> 
                            </div>
							<?php
                            if (count($objPage->arrNewsleterList) > 0)
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
