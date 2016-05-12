<?php
require_once '../common/config/config.inc.php';
require_once CONTROLLERS_ADMIN_PATH . FILENAME_ADMIN_NEWSLETTER_CTRL;
require_once SOURCE_ROOT . 'components/html_editor/fckeditor/fckeditor.php';
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
        <title><?php echo ADMIN_PANEL_NAME; ?> : Manage Newsletters </title>
        <?php require_once 'inc/common_css_js.inc.php'; ?>

        <script type="text/javascript" src="<?php echo JS_PATH; ?>jquery-1.3.2.min.js"></script>
        <script type="text/javascript" src="<?php echo JS_PATH; ?>admin_js.js"></script>
        <style type="text/css">
            <!--
            .style1 {color: #FF0000}
            -->
            .cust_newsletter {margin:20px 50px}
            .whl_newsletter {margin:20px 50px}
            .newsletter_border{border-right:none !important;}
            .content td table {border:none;padding:0px;margin:0px;}
            .content td table td{border-right:none;border-bottom:none;}
            .content td table td table td{border-right:none;border-bottom:none;}
            .content td table td.head{background-color: #313647;color:#FFF;font-weight:bold;}
            .content td table td table tr.odd td{background-color:#CAD3F9;}
            .content td table tr.odd td{background-color:#CAD3F9;}
            .middle{border-bottom:1px solid #c3c4c6 !important;border-top:1px solid #c3c4c6;}
            form{background-color: #f6f6f6;}
            .control-group{margin-bottom: 0px;}
        </style>
    </head>
    <body>

        <?php require_once 'inc/header_new.inc.php'; ?>



        <div class="container-fluid" id="content">

            <div id="main">
                <div class="container-fluid">
                    <div class="page-header">
                        <div class="pull-left">
                            <h1>View Newsletters</h1>
                        </div>

                    </div>
                    <div class="breadcrumbs">
                        <ul>
                            <li><a href="dashboard_uil.php">Home</a><i class="icon-angle-right"></i></li>
                            <li><a href="newsletter_manage_uil.php">Newsletters</a><i class="icon-angle-right"></i></li>
<!--                            <li><a href="newsletter_view_uil.php?type=view&id=<?php echo $_GET['id']; ?>">View Newsletters</a></li>-->
                            <li><span>View Newsletters</span></li>
                        </ul>
                        <div class="close-bread">
                            <a href="#"><i class="icon-remove"></i></a>
                        </div>
                    </div>

                    <?php require_once('javascript_disable_message.php'); ?>
                    <?php
                    if ($_SESSION['sessUserType'] == 'super-admin' || in_array('listing-newsletters', $_SESSION['sessAdminPerMission'])) {
                        ?>


                        <div class="row-fluid">
                            <div class="span12">
                                <div class="box box-color box-bordered">
                                    <div class="box-title">
                                        <a id="buttonDecoration" href="<?php echo $_SERVER['HTTP_REFERER']; ?>" class="btn" style="float:right;"> <i class="icon-circle-arrow-left"></i> <?php echo ADMIN_BACK_BUTTON; ?></a>
                                        <h3>View Newsletter  </h3>
                                    </div>
                                    <div class="box-content nopadding">
                                        <form action="#" method="POST">
                                            <div class="span8 form-horizontal form-bordered">
                                                <div class="control-group">
                                                    <label for="textfield" class="control-label">Title:  </label>
                                                    <div class="controls">
                                                        <?php echo ucfirst($objPage->arrRow['newsDetails'][0]['Title']); ?>
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <label for="" class="control-label">Content:</label>
                                                    <div class="controls">
                                                        <?php
                                                        if (($objPage->arrRow['newsDetails'][0]['Template'] != "") && ($objPage->arrRow['newsDetails'][0]['Content'] != "")) {
                                                            echo ($objPage->arrRow['newsDetails'][0]['Content']);
                                                            $template = $objPage->arrRow['newsDetails'][0]['Template'];
                                                            ?>
                                                            <a href="<?php echo UPLOADED_FILES_URL; ?>images/newsletter/<?php echo $template; ?>" target="_blank"><img height="70" width="70" alt="template" src="<?php echo UPLOADED_FILES_URL; ?>images/newsletter/<?php echo $template; ?>"/></a>
                                                        <?php
                                                        } elseif ($objPage->arrRow['newsDetails'][0]['Template'] != "") {
                                                            $template = $objPage->arrRow['newsDetails'][0]['Template'];
                                                            ?>
                                                            <a href="<?php echo UPLOADED_FILES_URL; ?>images/newsletter/<?php echo $template; ?>" target="_blank"><img height="70" width="70" alt="template" src="<?php echo UPLOADED_FILES_URL; ?>images/newsletter/<?php echo $template; ?>"/></a>
                                                            <?php
                                                        } else {
                                                            ?>
                                                            <?php echo ($objPage->arrRow['newsDetails'][0]['Content']); ?>


                                                            <?php
                                                        }
                                                        ?>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="span4 form-vertical form-bordered right-side">
                                                <div class="control-group">
                                                    <table style="width:250px">
                                                        <tr>
                                                            <td><strong>Created By:</strong></td>
    <?php //pre($objPage->arrRow['newsDetails']);  ?>
                                                            <td><?php
    if ($objPage->arrRow['newsDetails'][0]['CreatedBy'] == 'Admin') {
        echo ucfirst($objPage->arrRow['newsDetails'][0]['CreatedBy']);
    } else {
        echo ucfirst($objPage->arrRow['newsDetails'][0]['CompanyName']);
    }
    ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Company Name:</strong></td>
                                                            <td><?php echo ucfirst($objPage->arrRow['newsDetails'][0]['Name']); ?></td>
                                                        </tr>
    <?php
    $deliveryDateTime = explode(" ", $objPage->arrRow['newsDetails'][0]['DeliveryDate']);
    ?>
                                                        <tr class="odd">
                                                            <td><strong>Date:</strong></td><td><?php echo $objCore->localDateTime($deliveryDateTime[0], DATE_FORMAT_SITE); ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Time:</strong></td><td><?php echo $deliveryDateTime[1]; ?></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="row-fluid">
                                                <div class="span12 form-horizontal form-bordered box box-bordered box-color lightgrey">
                                                    <div class="control-group">
                                                        <label for="textfield" class="control-label">Recipients: </label>
                                                        <div class="controls">

    <?php
    if (count($objPage->arrRow['RecipientDetails']) > 0) {
        ?>
                                                                <table    class="table table-nomargin table-bordered usertable">
                                                                    <tr>
                                                                        <td style="width:50%;vertical-align:top">
                                                                            <table width="100%">
                                                                                <tr><td class="news_Recipients" style="margin-right:5px; ">Customers</td>
                                                                                    <td  class="news_Recipients" >Email Id</td>
                                                                                </tr>
        <?php
        $countCustomer = 0;
        foreach ($objPage->arrRow['RecipientDetails'] as $valRecipient) {
            if ($valRecipient['SendTo'] == 'customer') {
                ?>
                                                                                        <tr <?php
                                                                                        if ($countCustomer % 2 == 1) {
                                                                                            ?> class="odd"<?php } ?>>
                                                                                            <td><?php echo $valRecipient['CustomerFirstName']; ?></td>
                                                                                            <td class="newsletter_border"><?php echo $valRecipient['CustomerEmail']; ?> </td>
                                                                                        </tr>
                                                                                        <?php
                                                                                        $countCustomer++;
                                                                                    }
                                                                                }

                                                                                if ($countCustomer == 0) {
                                                                                    ?>

                                                                                    <tr>
                                                                                        <td colspan="2" style="text-align:center" class="newsletter_border">No Customers</td>
                                                                                    </tr>
                                                                                    <?php
                                                                                }
                                                                                ?>
                                                                            </table>
                                                                        </td>
                                                                        <td style=" vertical-align:top">
                                                                            <table width="100%">
                                                                                <tr><td class="news_Recipients" style="margin-right:5px; ">Wholesalers</td>
                                                                                    <td class="news_Recipients">Email Id</td>
                                                                                </tr>
                                                                                <?php
                                                                                $countWholesaler = 0;
                                                                                foreach ($objPage->arrRow['RecipientDetails'] as $valRecipient) {
                                                                                    if ($valRecipient['SendTo'] == 'wholesaler') {
                                                                                        ?>
                                                                                        <tr <?php
                                                                                        if ($countWholesaler % 2 == 1) {
                                                                                            ?> class="odd"<?php } ?>>
                                                                                            <td><?php echo $valRecipient['CompanyName']; ?></td>
                                                                                            <td><?php echo $valRecipient['CompanyEmail']; ?> </td>
                                                                                        </tr>
                                                                                        <?php
                                                                                        $countWholesaler++;
                                                                                    }
                                                                                }


                                                                                if ($countWholesaler == 0) {
                                                                                    ?>

                                                                                    <tr>
                                                                                        <td colspan="2" style="text-align:center">No Wholesalers</td>
                                                                                    </tr>
                                                                                    <?php
                                                                                }
                                                                                ?>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                </table>

                                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>


    <?php
} else {
    ?>
                        <table width="100%">
                            <tr>
                                <th align="left"><?php echo ADMIN_USER_PERMISSION_TITLE; ?></th></tr>
                            <tr><td><?php echo ADMIN_USER_PERMISSION_MSG; ?></td></tr>
                        </table>

<?php }
?>


                </div>
            </div>

                    <?php require_once('inc/footer.inc.php'); ?>
        </div>

    </body>
</html>

