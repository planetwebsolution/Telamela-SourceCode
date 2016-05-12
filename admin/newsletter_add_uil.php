<?php
require_once '../common/config/config.inc.php';
require_once CONTROLLERS_ADMIN_PATH . FILENAME_ADMIN_NEWSLETTER_ADD_CTRL;
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
        <title><?php echo ADMIN_PANEL_NAME; ?> : Manage Newsletter </title>
        <?php require_once 'inc/common_css_js.inc.php'; ?>        
        <script type="text/javascript" src="<?php echo JS_PATH; ?>admin_js.js"></script>
        <script type="text/javascript" src="<?php echo JS_PATH; ?>jquery-1.8.3.min.js"></script>
        <link type="text/css" rel="stylesheet" href="<?php echo CALENDAR_URL; ?>jquery.datepick.css" />
        <script type="text/javascript" src="<?php echo CALENDAR_URL; ?>jquery.datepick.js"></script>
        <script type="text/javascript">
            $(function () {
                $('.datepicks').datepick({dateFormat: 'dd-mm-yyyy', showTrigger: '<img src="../common/images/calendar.gif" alt="Popup" class="trigger">', minDate: new Date()});
            });
        </script>
        <script type="text/javascript" src="<?php echo SITE_ROOT_URL; ?>common/js/jPages.min.js"></script>
        <script>
            $(document).ready(function () {
                var page = 1;
                var pagepage = 1;
                var onePage = 5;
                var totalWholesalerRow = '<?php echo count($objPage->arrWholesalerRows) ?>';
                var totalCustomerRow = '<?php echo count($objPage->arrCustomerRows) ?>';
                var totalCustomerPages = totalCustomerRow / onePage;
                var totalWholesalerPages = totalWholesalerRow / onePage;

                $('#customerList').click(function () {
                    //console.log($('#itemContainer2 li').length);
//                    $('#showCustomer').toggle();
                    if ($('#customerList').is(':checked')) {
                        var page = 1;




                        $('#showCustomer').css('display', 'block');
                        $('.holder2 a').live('click', function () {
                            $('.holder2').find('a').css('font-weight', 'normal');
                            $('.holder2').find('a').css('cursor', 'pointer');
                            $('.holder2').find('a').css('text-decoration', 'underline');
                            $(this).css('font-weight', 'bold');
                            $(this).css('text-decoration', 'none');
                            var page1 = $(this).html();

                            if ((page1 == 1) || (page1 == 'previous')) {

                                $('#showCustomer .holder2').find('a').first().css({'text-decoration': 'none', 'cursor': 'default', 'color': '#555'});
                            } else {
                                $('#showCustomer .holder2').find('a').first().css({'color': '#368ee0'});
                            }
                            if ((page1 == Math.ceil(totalCustomerPages)) || (page1 == 'next')) {
                                $('#showCustomer .holder2').find('a').last().css({'text-decoration': 'none', 'cursor': 'default', 'color': '#555'});

                            } else {
                                $('#showCustomer .holder2').find('a').last().css({'color': '#368ee0'});
                            }
                            if (!isNaN(page1)) {

                                page = parseInt(page1);
                                var startResult = page * onePage - 2;
                                var endResult = page * onePage;
                                if (totalCustomerRow > endResult) {
                                    endResult = endResult;
                                } else {
                                    endResult = totalCustomerRow;
                                }
                                $('#resultCount2').html(startResult + '-' + endResult);
                            } else {
                                if (page1 == 'next') {

                                    $('.holder2 a').each(function () {

                                        if (($(this).text() == Math.ceil(totalCustomerPages)) && (page == Math.ceil(totalCustomerPages))) {
                                            $(this).css('text-decoration', 'none');
                                        }

                                    });

                                    if (page < totalCustomerPages) {
                                        page++;

                                        /*  Start - For Disable previus next buttom */
                                        if (page == Math.ceil(totalCustomerPages)) {
                                            $('#showCustomer .holder2').find('a').last().css({'text-decoration': 'none', 'cursor': 'default', 'color': '#555'});

                                            $('.holder2 a').each(function () {
                                                if ($(this).text() == page) {
                                                    $(this).css('text-decoration', 'none');
//                                                $('#itemContainer2 li').removeClass('jp-hidden');
                                                }

                                            });

                                        } else {
                                            $('#showCustomer .holder2').find('a').last().css({'color': '#368ee0'});
                                        }
                                        $('.holder2 a').each(function () {
                                            if (($(this).text() == page)) {
                                                $(this).css('text-decoration', 'none');
                                            }

                                        });

                                        /*  End For Disable previus next buttom */


                                        var startResult = page * onePage - 2;
                                        var endResult = page * onePage;
                                        if (totalCustomerRow > endResult) {
                                            endResult = endResult;
                                        } else {
                                            endResult = totalCustomerRow;
                                        }
                                        $('#resultCount2').html(startResult + '-' + endResult);
                                    }
                                } else {

                                    /* Start For Disable previus next buttom */

                                    if ((page == 2) || (page == 1)) {
                                        $('#showCustomer .holder2').find('a').first().css({'text-decoration': 'none', 'cursor': 'default', 'color': '#555'});

                                        /* Start For Current Page active */
                                        $('.holder2 a').each(function () {
                                            if ($(this).text() == 1) {
                                                $(this).css('text-decoration', 'none');
//                                                $('#itemContainer2 li').removeClass('jp-hidden');
                                            }

                                        });
                                        /* End For Current Page active */

                                    } else {
                                        $('#showCustomer .holder2').find('a').first().css({'color': '#368ee0'});
                                    }
                                    /* End For Disable previus next buttom */

                                    if (page > 1) {
                                        page--;
                                        var startResult = page * onePage - 2;
                                        var endResult = page * onePage;
                                        $('#resultCount2').html(startResult + '-' + endResult);

                                        /* Start For Current Page active */
                                        $('.holder2 a').each(function () {
                                            if ($(this).text() == page) {
                                                $(this).css('text-decoration', 'none');
//                                                $('#itemContainer2 li').removeClass('jp-hidden');
                                            }

                                        });
                                        /* End For Current Page active */

                                    }
                                }
                            }
                        });

                        $("div.holder2").jPages({
                            containerID: "itemContainer2",
                            perPage: 5,
                            next: 'next',
                            previous: "previous",
                            //links       : "blank"
                        });
                        /* $("select").change(function(){
                         var newPerPage = parseInt( $(this).val() );
                         $("div.holder").jPages("destroy").jPages({
                         containerID   : "itemContainer",
                         perPage       : newPerPage
                         });
                         });
                         */

                        $('#s_all2').click(function () {
                            if ($('#s_all2').is(':checked')) {
                                $('#itemContainer2 li').each(function () {
                                    if ($(this).hasClass('jp-hidden') || $(this).css('display') == 'none') {
                                        //$(this).find('input[type="checkbox"]').attr('checked',false);
                                    } else {
                                        $(this).find('input[type="checkbox"]').attr('checked', true);
                                    }
                                });
                            } else {
                                $('#itemContainer2 li').each(function () {
                                    if ($(this).hasClass('jp-hidden') || $(this).css('display') == 'none') {
                                        //$(this).find('input[type="checkbox"]').attr('checked',false);
                                    } else {
                                        $(this).find('input[type="checkbox"]').attr('checked', false);
                                    }
                                });
                            }
                        });

                        $('.holder2 a').each(function () {
                            $(this).css({'text-decoration': 'underline'});
                            if (($(this).text() == 1)) {
                                $(this).css({'cursor': 'default', 'text-decoration': 'none'});
                            }
                            if (($(this).text() == 'previous')) {
                                $(this).css({'color': '#555', 'cursor': 'default', 'text-decoration': 'none'});
                            }

                        });

                    } else {
                        $('#showCustomer').css('display', 'none');

                        $('#itemContainer2 li').each(function () {
                            $('#itemContainer2 li').css('display', '');
                            $('#itemContainer2 li').removeClass('jp-hidden');
                        });


                        $("div.holder2").jPages({
                            containerID: "itemContainer2",
                            perPage: 5,
                            next: 'next',
                            previous: "previous",
                            //links       : "blank"
                        });

                    }

                });


                //wholesaler          
                $('#wholesalerList').click(function () {

                    //$('#showWholesaler').toggle();
                    if ($('#wholesalerList').is(':checked')) {
                        $('#showWholesaler').css('display', 'block');
                        var pagepage = 1;
                        $('.holder a').live('click', function () {
                            $('.holder').find('a').css('font-weight', 'normal');
                            $('.holder').find('a').css('cursor', 'pointer');
                            $('.holder').find('a').css('text-decoration', 'underline');
                            $(this).css('font-weight', 'bold');
                            $(this).css('text-decoration', 'none');
                            var page11 = $(this).html();

                            if ((page11 == '1') || (page11 == 'previous')) {
                                $('#showWholesaler .holder').find('a').first().css({'text-decoration': 'none', 'cursor': 'default', 'color': '#555'});
                            } else {
                                $('#showWholesaler .holder').find('a').first().css({'color': '#368ee0'});
                            }
                            if ((page11 == Math.ceil(totalWholesalerPages))) {
                                $('#showWholesaler .holder').find('a').last().css({'text-decoration': 'none', 'cursor': 'default', 'color': '#555'});

                                $('.holder a').each(function () {
                                    if ($(this).text() == Math.ceil(totalWholesalerPages)) {
                                        $(this).css('text-decoration', 'none');
//                                                $('#itemContainer2 li').removeClass('jp-hidden');
                                    }

                                });
                            } else {
                                $('#showWholesaler .holder').find('a').last().css({'color': '#368ee0'});
                            }

                            if (!isNaN(page11)) {
                                pagepage = parseInt(page11);
                                var startResult = pagepage * onePage - 2;
                                var endResult = pagepage * onePage;
                                if (totalWholesalerRow > endResult) {
                                    endResult = endResult;
                                } else {
                                    endResult = totalWholesalerRow;
                                }
                                $('#resultCount').html(startResult + '-' + endResult);
                            } else {
                                if (page11 == 'next') {

                                    $('.holder a').each(function () {

                                        if (($(this).text() == Math.ceil(totalWholesalerPages)) && (pagepage == Math.ceil(totalWholesalerPages))) {
                                            $(this).css('text-decoration', 'none');
                                        }
                                        if (($(this).text() == 'next') && (pagepage == Math.ceil(totalWholesalerPages))) {
                                            $(this).css('color', '#555');
                                        }
                                    });


                                    if (pagepage < totalWholesalerPages) {
                                        pagepage++;


                                        /*  Start For Disable previus next buttom */
                                        if (pagepage == Math.ceil(totalWholesalerPages)) {
                                            $('#showWholesaler .holder').find('a').last().css({'text-decoration': 'none', 'cursor': 'default', 'color': '#555'});

                                            $('.holder a').each(function () {
                                                if ($(this).text() == pagepage) {
                                                    $(this).css('text-decoration', 'none');
//                                                $('#itemContainer2 li').removeClass('jp-hidden');
                                                }

                                            });

                                        } else {
                                            $('#showWholesaler .holder').find('a').last().css({'color': '#368ee0'});
                                        }
                                        $('.holder a').each(function () {

                                            if ($(this).text() == pagepage) {
                                                $(this).css('text-decoration', 'none');
//                                                $('#itemContainer2 li').removeClass('jp-hidden');
                                            }

                                        });
                                        /*  End For Disable previus next buttom */


                                        var startResult = pagepage * onePage - 2;
                                        var endResult = pagepage * onePage;
                                        if (totalWholesalerRow > endResult) {
                                            endResult = endResult;
                                        } else {
                                            endResult = totalWholesalerRow;
                                        }
                                        $('#resultCount').html(startResult + '-' + endResult);
                                    }
                                } else {

                                    /* Start For Disable previus next buttom */
                                    if ((pagepage == 2) || (pagepage == 1)) {
                                        $('#showWholesaler .holder').find('a').first().css({'text-decoration': 'none', 'cursor': 'default', 'color': '#555'});

                                        /* Start For Current Page active */
                                        $('.holder a').each(function () {
                                            if ($(this).text() == 1) {
                                                $(this).css('text-decoration', 'none');
//                                                $('#itemContainer2 li').removeClass('jp-hidden');
                                            }

                                        });
                                        /* End For Current Page active */

                                    } else {
                                        $('#showWholesaler .holder').find('a').first().css({'color': '#368ee0'});
                                    }
                                    /* End For Disable previus next buttom */

                                    if (pagepage > 1) {
                                        pagepage--;
                                        var startResult = pagepage * onePage - 2;
                                        var endResult = pagepage * onePage;
                                        $('#resultCount').html(startResult + '-' + endResult);

                                        /* Start For Current Page active */
                                        $('.holder a').each(function () {
                                            if ($(this).text() == pagepage) {
                                                $(this).css('text-decoration', 'none');
//                                                $('#itemContainer2 li').removeClass('jp-hidden');
                                            }

                                        });
                                        /* End For Current Page active */
                                    }
                                }
                            }


                        });
                        $("div.holder").jPages({
                            containerID: "itemContainer",
                            perPage: 5,
                            next: 'next',
                            previous: "previous"
                        });
                        /* $("select").change(function(){
                         var newPerPage = parseInt( $(this).val() );
                         $("div.holder").jPages("destroy").jPages({
                         containerID   : "itemContainer",
                         perPage       : newPerPage
                         });
                         });
                         */


                        $('#s_all').click(function () {
                            if ($('#s_all').is(':checked')) {
                                $('#itemContainer li').each(function () {
                                    if ($(this).hasClass('jp-hidden') || $(this).css('display') == 'none') {
                                        //$(this).find('input[type="checkbox"]').attr('checked',false);
                                    } else {
                                        $(this).find('input[type="checkbox"]').attr('checked', true);
                                    }
                                });
                            } else {
                                $('#itemContainer li').each(function () {
                                    if ($(this).hasClass('jp-hidden') || $(this).css('display') == 'none') {
                                        //$(this).find('input[type="checkbox"]').attr('checked',false);
                                    } else {
                                        $(this).find('input[type="checkbox"]').attr('checked', false);
                                    }
                                });
                            }
                        });

                        $('.holder a').each(function () {
                            $(this).css({'text-decoration': 'underline'});
                            if (($(this).text() == 1)) {
                                $(this).css({'cursor': 'default', 'text-decoration': 'none'});
                            }
                            if (($(this).text() == 'previous')) {
                                $(this).css({'color': '#555', 'cursor': 'default', 'text-decoration': 'none'});
                            }

                        });
                    } else {
                        $('#showWholesaler').css('display', 'none');

                        $('#itemContainer li').each(function () {
                            $('#itemContainer li').css({'display': '', 'opacity': ''});
                            $('#itemContainer li').removeClass('jp-hidden');
                        });
//                        var pagepage = 1;
//                        var page11 = 1;
//                        var page1 = 1;

                        $("div.holder").jPages({
                            containerID: "itemContainer",
                            perPage: 5,
                            next: 'next',
                            previous: "previous",
                            //links       : "blank",
                        });

                        $('.holder').html('');

                    }

                });


            });
        </script>

        <style>
            .input_sec{margin:10px;}
            .feebacks_sec {
                margin-top: 0;
                float: left;
                width: 100%;
            }
            .feebacks_sec li.heading {
                width: 100%;
            }

            .feebacks_sec li {
                width: 100%;
                clear:both;
            }

            .feebacks_sec li.heading div {
                width: 150px;
                background-color: #313647;
                color: #FFF;
                float:left;
                font-weight:bold;
                height:20px;
            }

            .feebacks_sec li div{
                text-align:left;
                float:left;
                padding: 5px 0 0 5px
            }
            .feebacks_sec li div.chk{
                width: 30px !important;
            }
            .feebacks_sec li div.nme{
                width: 450px !important;
            }
            .feebacks_sec li div.date{
                width: 100px !important;
            }
            .holder2, .holder {margin-left:43px}
            .left_content .holder2 a, .left_content .holder a{cursor:pointer;}
            .holder2 a,.holder a{padding: 0px 4px 0px 4px;}
        </style>
        <link type="text/css" rel="stylesheet" href="//cdn.datatables.net/1.10.10/css/jquery.dataTables.min.css" />
        <script type="text/javascript" src="//cdn.datatables.net/1.10.10/js/jquery.dataTables.min.js"></script>
        <script>
            $(document).ready(function () {
                //$('#example').DataTable();
            });


        </script>
    </head>
    <body>

        <?php require_once 'inc/header_new.inc.php'; ?>



        <div class="container-fluid" id="content">

            <div id="main">
                <div class="container-fluid">
                    <div class="page-header">
                        <div class="pull-left">
                            <h1>Add Newsletter</h1>
                        </div>

                    </div>
                    <div class="breadcrumbs">
                        <ul>
                            <li><a href="dashboard_uil.php">Home</a><i class="icon-angle-right"></i></li>
                            <li><a href="newsletter_manage_uil.php">Newsletter</a><i class="icon-angle-right"></i></li>
                            <li><span>Add Newsletter</span></li>
                        </ul>
                        <div class="close-bread">
                            <a href="#"><i class="icon-remove"></i></a>
                        </div>
                    </div>

                    <?php require_once('javascript_disable_message.php'); ?>
                    <?php
                    if ($_SESSION['sessUserType'] == 'super-admin' || in_array('add-newsletters', $_SESSION['sessAdminPerMission'])) {
                        ?>

                        <div class="row-fluid">
                            <div class="span12">
                                <div class="box box-color box-bordered">
                                    <a id="buttonDecoration" href="<?php echo $_SERVER['HTTP_REFERER']; ?>"><input type="button" class="btn" name="btnTagSettings" value="<?php echo ADMIN_BACK_BUTTON; ?>" style="float:right; margin:6px 2px 0 0; width:107px;"/></a>
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
                                    <div class="box-title">
                                        <h3>Create Newsletter </h3>
                                    </div>
                                    <div class="box-content nopadding">
                                        <form action=""  method="post" id="frm_page" onsubmit="return validateNewsletterAddForm('frm_page');" enctype="multipart/form-data" class='form-horizontal form-bordered' >
                                            <div class="control-group">
                                                <label for="textfield" class="control-label">*Title: </label>
                                                <div class="controls">
                                                    <input type="text" name="frmTitle" id="frmTitle" placeholder="" class="input-large">
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label for="" class="control-label">*Content:</label>
                                                <div class="controls">
                                                    <div class='form-wysiwyg'>
                                                        <textarea name="Content" id="frmHtmlEditor" class='ckeditor span12' rows="5"></textarea>
                                                    </div>
                                                    OR<br />
                                                    <input type="file" name="template" id="template" />
                                                    <span style="color: red;">&nbsp;(Maxsize is 2mb and Allowed extensions are: jpg,jpeg,gif,png)</span>
                                                    <!--
                                                    <div class="fileupload fileupload-new" data-provides="fileupload">
                                                        <div class="input-append">
                                                            <div class="uneditable-input span3">
                                                                <i class="icon-file fileupload-exists"></i>
                                                                <span class="fileupload-preview"></span>
                                                            </div>
                                                            <span class="btn btn-file">
                                                                <span class="fileupload-new">Select file</span>
                                                                <span class="fileupload-exists">Change</span>
                                                                <input type="file" name="template" id="template" />
                                                            </span>
                                                            <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                                                        </div>
                                                    </div>
                                                    -->
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label">*Send To:</label>
                                                <div class="controls">
                                                    <label class='checkbox'>
                                                        <input type="checkbox" name="" value="" id="customerList" class="recipient"  /> Customers &nbsp;
                                                    </label>
                                                    <label class='checkbox'>
                                                        <input type="checkbox" name="" value="" id="wholesalerList" class="recipient"  /> Wholesalers<br/>
                                                    </label>
    <!--                                                    <table id="example" class="display select" cellspacing="0" width="50%">
                                                        <thead>
                                                            <tr>
                                                                <th><input name="select_all" value="1" type="checkbox"></th>
                                                                <th>Name</th>
                                                            </tr>
                                                        </thead>
                                                        <tfoot>
                                                            <tr>
                                                                <th></th>
                                                                <th>Name</th>

                                                            </tr>
                                                        </tfoot>
                                                        <tbody>
                                                            <tr>
                                                                <td></td>
                                                                <td>Tiger Nixon</td>
                                                            </tr>
                                                            <tr>
                                                                <td></td>
                                                                <td>Garrett Winters</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>-->
                                                    <div id="showCustomer" style="display:none;padding:50px">
                                                        <span><strong>Customer List :</strong></span>
                                                        <div class="input_sec">
                                                            <ul class="feebacks_sec" style="list-style:none">
                                                                <li class="heading">
                                                                    <div class="chk" id="check_status"><input type="checkbox" id="s_all2" value="0" name="wall" /></div>
                                                                    <div class="nme">Name</div>
                                                                    <div class="date">Member Since</div>
                                                                </li>
                                                            </ul>
                                                            <ul class="feebacks_sec" id="itemContainer2"  style="list-style:none">

                                                                <?php
                                                                if (count($objPage->arrCustomerRows) > 0) {
                                                                    $varCounter = 0;
                                                                    foreach ($objPage->arrCustomerRows as $varList) {
                                                                        $varCounter++;
                                                                        ?>
                                                                        <li <?php echo $varCounter % 2 == 0 ? 'class="bg_color"' : ''; ?> >
                                                                            <div class="chk"><input type="checkbox" value="<?php echo $varList['pkCustomerID'] ?>" name="recipienCustomerId[]" class="recipietId"/></div>
                                                                            <div class="nme"><?php echo $varList['CustomerFirstName'] . ' ' . $varList['CustomerLastName'] ?></div>
                                                                            <div class="date"><?php echo $objCore->localDateTime($varList['CustomerDateAdded'], DATE_FORMAT_SITE); ?></div>
                                                                        </li>
                                                                        <?php
                                                                    }
                                                                }
                                                                ?>
                                                            </ul>
                                                            <div class="holder2"></div>
                                                        </div>
                                                    </div>
                                                    <div id="showWholesaler" style="display:none;padding:50px">
                                                        <span><strong>Wholesaler List :</strong></span>
                                                        <div class="input_sec">
                                                            <ul class="feebacks_sec" style="list-style:none">
                                                                <li class="heading">
                                                                    <div class="chk" id="check_status"><input type="checkbox" id="s_all" value="0" name="wall" /></div>
                                                                    <div class="nme">Name</div>
                                                                    <div class="date">Member Since</div>
                                                                </li>
                                                            </ul>
                                                            <ul class="feebacks_sec" id="itemContainer"  style="list-style:none">
                                                                <?php
                                                                if (count($objPage->arrWholesalerRows) > 0) {
                                                                    $varCounter = 0;
                                                                    foreach ($objPage->arrWholesalerRows as $varList) {
                                                                        $varCounter++;
                                                                        ?>
                                                                        <li <?php echo $varCounter % 2 == 0 ? 'class="bg_color"' : ''; ?> >
                                                                            <div class="chk"><input type="checkbox" value="<?php echo $varList['pkWholesalerID'] ?>" name="recipienWholesalerId[]" class="recipietId"/></div>
                                                                            <div class="nme"><?php echo $varList['CompanyName']; ?></div>
                                                                            <div class="date"><?php echo $objCore->localDateTime($varList['WholesalerDateAdded'], DATE_FORMAT_SITE); ?></div>
                                                                        </li>
                                                                        <?php
                                                                    }
                                                                }
                                                                ?>
                                                                </li>
                                                            </ul>
                                                            <div class="holder"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label for="textarea" class="control-label">*Schedule Delivery Time:</label>
                                                <div class="controls">
                                                    <input type="text" name="frmDeliveryDate" id="frmDeliveryDate" class="input-medium datepicks" placeholder="Select Date"><br><br>

                                                    <div class="bootstrap-timepicker">
                                                        <select name="frmHH" class="select2-me input-small" id="frmHH">
                                                            <option value="00">HH</option>
                                                            <option value="00">00</option>
                                                            <?php
                                                            for ($i = 1; $i < 24; $i++) {
                                                                $j = ($i < 10) ? '0' . $i : $i;
                                                                ?>
                                                                <option value="<?php echo $j; ?>"><?php echo $j; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                        <select name="frmMM" class="select2-me input-small" id="frmMM">
                                                            <option value="00">MM</option>
                                                            <option value="00">00</option>
                                                            <?php
                                                            for ($i = 5; $i < 60; $i = $i + 5) {
                                                                $j = ($i < 10) ? '0' . $i : $i;
                                                                ?>
                                                                <option value="<?php echo $j; ?>"><?php echo $j; ?></option>
                                                            <?php } ?>

                                                        </select>
                                                        <input type="hidden" name="frmSS" value="00" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="note">Note : * Indicates mandatory fields.</div>
                                            <div class="form-actions">
                                                <button type="submit" class="btn btn-primary"><?php echo ADMIN_SUBMIT_BUTTON; ?></button>
                                                <a id="buttonDecoration" href="newsletter_manage_uil.php"><button type="button" class="btn">Cancel</button></a>
                                                <input type="hidden" name="frmHidenAdd" id="frmHidnAddPage" value="add" />
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
