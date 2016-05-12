<?php
require_once '../common/config/config.inc.php';
require_once CONTROLLERS_ADMIN_PATH . FILENAME_PRODUCT_CTRL;
require_once CLASSES_SYSTEM_PATH . 'class_session_redirect_bll.php';
unset($_SESSION['query_string']['admin']['products_listing']);
if(isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING']!=''){
    $_SESSION['query_string']['admin']['products_listing']=$_SERVER['QUERY_STRING'];
}
//echo $_SESSION['query_string']['wholesaler']['products_listing'];
$_SESSION['currentURLManageProducts']
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
        <title><?php echo ADMIN_PANEL_NAME; ?>: Manage Products</title>
        <?php require_once 'inc/common_css_js.inc.php'; ?>
        <link rel="stylesheet" href="css/colorbox.css" />
        <script src="../colorbox/jquery.colorbox.js"></script>
        <script type='text/javascript' src='<?php echo SITE_ROOT_URL . "common/js/jquery.autocomplete.js"; ?>'></script>
        <link rel="stylesheet" type="text/css" href="<?php echo SITE_ROOT_URL . 'common/css/jquery.autocomplete.css'; ?>" />
        <script>


           
            function  setEnquiryActiona(value, formname,listname)
            {
                if($("input[name='frmID[]']").serializeArray().length == 0) {
                    $('#modal-1').show();
                }else if($("input[name='frmID[]']").serializeArray().length > 0){
                    $('#modal-2').show();
                }else{
                    $('#modal-1').hide();
                }
            }
            function popupClose(){
                $('#modal-1').hide();
                $('#modal-2').hide();
                $('#modal-3').hide();

            }
            function changeStatus(status,pid){

                var showid = '#product'+pid;
                $.post("ajax.php",{action:'ChangeProductStatus',status:status,pid:pid},
                function(data)
                {
                    if(data=='offer')
                    {
                        alert("You have set this product as Today's offer, you can not deactivate this. If you want to deactivate this product then you have to change the Today's offer product.");
                        return false;
                    }
                    else
                    {
                        $(showid).html(data);
                    }
                }
            );
            }

            $().ready(function() {

          //alert('ddddd');
          //$("#frmfkCategoryID").each(function()
            //{
            //console.log($(this).val());
            //});


                $("#autofillProduct").autocomplete("ajax.php?action=productAutocomplete", {
                    width: 260,
                    matchContains: true,
                    selectFirst: false
                });
            });
        </script>
        </head>
        <body>
<div id="modal-1" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onClick="popupClose()">X</button>
    <h3 id="myModalLabel">Modal header</h3>
  </div>
          <div class="modal-body">
    <p>Please select at least one option to delete</p>
  </div>
          <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true" onClick="popupClose()">OK</button>
    <!--				<button class="btn btn-primary" data-dismiss="modal">Save changes</button>--> 
  </div>
        </div>
<div id="modal-2" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onClick="popupClose()">X</button>
    <h3 id="myModalLabel">Modal header</h3>
  </div>
          <div class="modal-body">
    <p>Are you sure to delete?</p>
  </div>
          <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true" onClick="return popupClose();">Cancel</button>
    <button class="btn btn-primary" data-dismiss="modal" onClick="formSubmit()">Delete</button>
  </div>
        </div>
<div id="modal-3" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onClick="popupClose()">X</button>
    <h3 id="myModalLabel">Delete Request</h3>
  </div>
          <div class="modal-body">
    <p>Are you sure to delete?</p>
  </div>
          <div class="modal-footer">
    <input type="hidden" id="deltid" value=""/>
    <button class="btn" data-dismiss="modal" aria-hidden="true" onClick="return popupClose();">Cancel</button>
    <button class="btn btn-primary" data-dismiss="modal" onClick="redir()">Delete</button>
  </div>
        </div>
<?php require_once 'inc/header_new.inc.php'; ?>
<div class="container-fluid" id="content">
          <div id="main">
    <div class="container-fluid">
              <div class="page-header">
        <div class="pull-left">
                  <h1>Manage Products</h1>
                </div>
      </div>
              <?php require_once('javascript_disable_message.php'); ?>
              <?php
              //pre($_SESSION);
                    if ($_SESSION['sessUserType'] == 'super-admin' || in_array('listing-products', $_SESSION['sessAdminPerMission']))
                    {
                        ?>
              <div class="breadcrumbs">
        <ul>
                  <li> <a href="dashboard_uil.php">Home</a> <i class="icon-angle-right"></i> </li>
                  <li> <a href="catalog_manage_uil.php">Catalog</a> <i class="icon-angle-right"></i> </li>
                  <li> <span>Manage Products</span> </li>
                </ul>
        <div class="close-bread"> <a href="#"><i class="icon-remove"></i></a> </div>
      </div>
              <div class="row-fluid">
        <div class="span12 margin_top20">
                  <div style="float:left">
            <button class="btn btn-inverse" onClick="showSearchBox('search','show');">Search Products </button>
            <a href="product_add_uil.php?type=add">
                    <button class="btn btn-inverse">Add New Product</button>
                    </a> <a href="product_add_multiple_uil.php?type=addMultiple">
                    <button class="btn btn-inverse">Add Multiple Products</button>
                    </a> </div>
                  <div style="float:right;">
            <div class="export" style="float:left;">
                      <form action="" method="post">
                <div>
                          <div style="float:left;padding-right:10px;">
                    <label class="control-label" for="textfield">Export to: </label>
                  </div>
                          <div style="float:left;padding-right:10px;">
                    <select name="fileType">
                              <option value="csv">CSV</option>
                              <option value="excel">Excel</option>
                            </select>
                  </div>
                          <div style="float:left;padding-right:10px;">
                    <input type="submit" class="btn btn-primary" name="Export" value="Export" />
                  </div>
                        </div>
              </form>
                    </div>
          </div>
                </div>
      </div>
        <?php
//         echo '<pre>';
//                        print_r($objPage); die;
        ?>
              <div class="row-fluid" id="search">
        <div class="span12">
                  <div class="box box-color box-bordered">
            <div class="box-title">
                      <h3>Advance Search </h3>
                    </div>
            <div class="box-content nopadding">
                      <form id="frmSearch" method="get" action="" class="form-horizontal form-bordered" onSubmit="return dateCompare('frmSearch');">
                <div class="row-fluid">
                          <div class="row-fluid" style="margin-bottom:5px">
                    <div class="span4">
                              <div class="control-group">
                        <label for="textfield" class="control-label">Name: </label>
                        <div class="controls">
                                  <input type ="text" name="frmName" id="autofillProduct" value="<?php echo stripslashes($_GET['frmName']); ?>" class="input-large" placeholder="" />
                                </div>
                      </div>
                            </div>
                    <div class="span4">
                              <div class="control-group">
                        <label for="textfield" class="control-label">Price Range: </label>
                        <div class="controls">
                                  <input type ="text" name="frmPriceFrom" value="<?php echo stripslashes($_GET['frmPriceFrom']); ?>" class="input-large" placeholder="" style="width:50px" />
                                  &nbsp;To&nbsp;
                                  <input type ="text" name="frmPriceTo" value="<?php echo stripslashes($_GET['frmPriceTo']); ?>" class="input-large" placeholder="" style="width:50px" />
                                </div>
                      </div>
                            </div>
                    <div class="span4 ">
                              <div class="control-group">
                        <label for="textfield" class="control-label">Status: </label>
                        <div class="controls">
                                  <select name="frmStatus" class='select2-me input-large'>
                            <option value="1" <?php
                    if ($_GET['frmStatus'] == '1')
                    {
                        echo 'Selected';
                    }
                        ?>>Active</option>
                            <option value="0" <?php
                                                                        if ($_GET['frmStatus'] == '0')
                                                                        {
                                                                            echo 'Selected';
                                                                        }
                        ?>>Deactive</option>
                          </select>
                                </div>
                      </div>
                            </div>
                  </div>


                    <div class="row-fluid">
                 
                    <div class="span4 ">
                                                             <div class="control-group">
                                                                    <label for="textfield" class="control-label">*Category:</label>
                                                                    <div class="controls">
                                                                        <?php //pre($objPage->arrCat[3]); ?>

                                                                        <?php echo $objGeneral->CategoryHtml($objPage->arrCategoryDropDown, 'frmfkCategoryID', 'frmfkCategoryID', array(0), 'Select Category', 0, ' onchange="showAttribute(this.value);" class="select2-me input-large"'); ?>

                                                                    </div>
                                                                </div>
                    </div>




                    <div class="span4 ">
                              <div class="control-group">
                        <label for="textfield" class="control-label">WholeSaler: </label>
                        <div class="controls">
                                  <select name="frmWholesaler" class='select2-me input-large'>
                            <option value="0">Select Wholesaler</option>
                            <?php
                            //echo $_GET['frmWholesaler'];die;
                                                                    foreach ($objPage->arrWholesalerDropDown as $keyws => $valws)
                                                                    {
                                                                        ?>
                            <option value="<?php echo $valws['pkWholesalerID']; ?>" <?php
                            //echo $_GET['frmWholesaler']; die;
                                                                if ($valws['pkWholesalerID'] == $_GET['frmWholesaler'])
                                                                {
                                                                    echo 'Selected';
                                                                }
                                                                        ?>><?php echo $valws['CompanyName']; ?></option>
                            <?php } ?>
                          </select>
                                </div>
                      </div>
                            </div>
                  </div>
                          <div class="row-fluid">
                    <div class="form-actions span12  search">
                              <input type="hidden" name="frmSearchPressed" id="frmSearchPressed" value="Yes" />
                              <input type="submit" name="frmSearch" value="Search" class="btn btn-primary" />
                              <a <?php
                                                                        if (isset($_REQUEST['frmSearch']))
                                                                        {
                                                                                ?> href="product_manage_uil.php"<?php
                                                    }
                                                    else
                                                    {
                                                                                ?> onClick="showSearchBox('search', 'hide');" <?php } ?> class="btn"><?php echo ADMIN_SEARCH_CANCEL_BUTTON; ?></a> </div>
                  </div>
                        </div>
              </form>
                    </div>
          </div>
                </div>
      </div>
              <div class="row-fluid">
        <div class="span12">
                  <?php
                                if ($objCore->displaySessMsg() <> '')
                                {
                                    echo $objCore->displaySessMsg();
                                    $objCore->setSuccessMsg('');
                                    $objCore->setErrorMsg('');
                                }
                                ?>
                  <div class="box box-color box-bordered">
            <div class="box-title">
                      <h3> Products List </h3>
                    </div>
            <div class="box-content nopadding manage_categories">
                      <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper" role="grid">
                <?php
                                            if ($objPage->NumberofRows > 0)
                                            {
                                                ?>
                <form id="frmUsersList" name="frmUsersList" action="product_action.php" method="post">
                          <input type="hidden" name="frmProcess" id="frmProcess" value="ManipulateProduct" />
                          <table class="table table-hover table-nomargin table-bordered usertable">
                    <thead>
                              <tr>
                        <th class='with-checkbox hidden-480'><input style="width:20px; border:none; float:left;" type="checkbox" name="Main" value="1" id="Main" onClick="javascript:toggleOption(this);" /></th>
                        <?php echo $objPage->varSortColumn; ?>
                        <th class='hidden-480'>Status</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                    	<?php
                        	$i = 1;
                            foreach ($objPage->arrRows as $val)
                            {
                        ?>
                        <tr>
	                        <td class='with-checkbox hidden-480'><input style="width:20px; border:none;" type="checkbox" name="frmID[]" id="frmID[]"  value="<?php echo $val['pkProductID']; ?>" onClick="singleSelectClick(this,'singleCheck');" class="singleCheck"/></td>
	                        <td><?php echo $val['ProductName']; ?></td>
	                        <td class="hidden-480"><?php echo $val['ProductRefNo']; ?></td>
                         	<td class="hidden-480"><?php echo ucfirst($val['CategoryName']); ?></td>
<!--                        <td class="hidden-480"><?php
//                        echo '<pre>';
//                        print_r($val['CategoryName']);
//                        echo $objProduct->getCategoryHierarchy($objPage->arrRow['0']['CategoryHierarchy']);
                                                                       // echo $objProduct->getCategoryHierarchy($val['CategoryHierarchy']);
                                                                       // echo $val['CategoryName'];
//                                                                        if ($val['CategoryIsDeleted'] == 1)
//                                                                        {
//                                                                            echo ' <span class="req" style="font-size: 10px">(Trash)<span>';
//                                                                        }
                                                                        ?></td>-->
                        <td class="hidden-480"><?php echo ucfirst($val['CompanyName']); ?></td>
                        <td class="hidden-480"><?php echo $objCore->price_format($val['WholesalePrice']); ?></td>
                        <td><?php echo $objCore->price_format($val['FinalPrice']); ?></td>
                        <?php /*?>
                        <td><?php echo ($val['DiscountFinalPrice']) >0 ?$objCore->price_format($val['DiscountFinalPrice']):$objCore->price_format($val['FinalPrice']); ?></td>
                        <?php */?>
                        <td class='hidden-480'><span id="product<?php echo $val['pkProductID']; ?>">
                          <?php
                                                                            if (empty($val['ProductStatus']))
                                                                            {
                                                                                ?>
                          <a href="javascript:void(0);" class="active" onClick="changeStatus('1',<?php echo $val['pkProductID']; ?>)" title="Click here to active this product.">Active</a>
                          <?php
                                                            }
                                                            else
                                                            {
                                                                echo '<span class="label label-satgreen">Active</span>';
                                                            }

                                                            // echo $val['pkgid'];
                                                                            ?>
                          <?php
                                                                            if ($val['pkgid'] != '')
                                                                            {
                                                                                ?>
                          <?php
                                                                                if (!empty($val['ProductStatus']))
                                                                                {
                                                                                    ?>
                          <a href="javascript:void(0);" class="deactive" onClick="if(confirm('This product may be used in a package. If you deactivate the product then relative package will also deactivated.\n Are you sure want to deactivate this product.')){changeStatus('0',<?php echo $val['pkProductID']; ?>)}" title="Click here to deactive this product.">Deactive</a>
                          <?php
                                                            }
                                                            else
                                                            {
                                                                echo '<span  class="label label label-lightred">Deactive</span>';
                                                            }
                                                                                ?>
                          <?php
                                                                            }
                                                                            else
                                                                            {
                                                                                ?>
                          <?php
                                                                                if (!empty($val['ProductStatus']))
                                                                                {
                                                                                    ?>
                          <a href="javascript:void(0);" class="deactive" onClick="changeStatus('0',<?php echo $val['pkProductID']; ?>)" title="Click here to deactive this product.">Deactive</a>
                          <?php
                                                            }
                                                            else
                                                            {
                                                                echo '<span  class="label label label-lightred">Deactive</span>';
                                                            }
                                                                                ?>
                          <?php } ?>
                          </span></td>
                        <td>
                        	<a class="btn" href="product_view_uil.php?type=view&id=<?php echo $val['pkProductID']; ?>" rel="tooltip" data-original-title="View">
                        		<i class="icon-eye-open"></i>
                        	</a>
                        	<a class="btn" href="product_edit_uil.php?type=edit&id=<?php echo $val['pkProductID']; ?>" rel="tooltip" data-original-title="Edit"><i class="icon-edit"></i></a>
                                  <?php
                                                                         if($val['offer'] >0){ ?>
                                  <a class='btn' rel="tooltip" data-original-title="Delete" href="product_today_offer_uil.php?type=offer" onClick="return confirm('This product is associated with today offer.You can not delete this?')"><i class="icon-remove"></i></a>
                                  <?php }
                                                                        else if ($val['pkgid'] == '0')
                                                                        {
                                                                            ?>
                                  <a class='btn' rel="tooltip" data-original-title="Delete" href="product_action.php?frmID=<?php echo $val['pkProductID']; ?>&frmProcess=ManipulateProduct&frmChangeAction=Delete&deleteType=sD" onClick="return confirm('Are you sure you want to delete this product?')"><i class="icon-remove"></i></a>
                                  <?php
                                                                        }
                                                                        else
                                                                        {
                                                                            ?>
                                  <a  class='btn' rel="tooltip" data-original-title="Delete"  href="package_edit_uil.php?pkgid=<?php echo $val['fkPackageId']; ?>&type=edit" onClick="return confirm('Are you sure you want to delete this product?\nThis product is used in a package. Please update Package and delete it.\nWould you like to update packege ?')"><i class="icon-remove"></i></a>
                                  <?php } ?>
                                  <a class='btn hidden-480' rel="tooltip" data-original-title="Read Reviews" href="product_review_manage_uil.php?ProductId=<?php echo $val['pkProductID']; ?>&CustomerFirstName=&frmParentId=0&frmSearchPressed=Yes&frmSearch=Search">Reviews</a> <a class="btn hidden-480" href="product_price_uil.php?type=price&id=<?php echo $val['pkProductID']; ?>" rel="tooltip" data-original-title="Attributes price">Attributes price</a> <a class="btn hidden-480" href="product_inventory_uil.php?type=inventory&id=<?php echo $val['pkProductID']; ?>" rel="tooltip" data-original-title="Attribute wise inventory">Attribute wise inventory</a></td>
                      </tr>
                              <?php
                                                                $i++;
                                                            }
                                                            ?>
                            </tbody>
                  </table>
                          <div class="dataTables_paginate paging_full_numbers" id="DataTables_Table_0_paginate">
                    <?php
                                                    if ($objPage->varNumberPages > 1)
                                                    {
                                                        $objPage->displayPaging($_GET['page'], $objPage->varNumberPages, $objPage->varPageLimit);
                                                    }
                                                            ?>
                  </div>
                          <div class="controls hidden-480" style="margin: 1%;">
                    <select name="frmChangeAction" onChange="javascript:return setValidAction(this.value, this.form,'Products(s)');" ata-rule-required="true">
                              <option value="">-- Select Action --</option>
                              <option value="Delete All">Delete</option>
                            </select>
                    <label for="textfield" class="control-label">This action will be performed on the above selected record(s). </label>
                  </div>
                        </form>
                <?php
                                            }
                                            else
                                            {
                                                ?>
                <table class="table table-hover table-nomargin table-bordered usertable">
                          <tr class="content">
                    <td colspan="10" style="text-align:center"><strong>No record(s) found.</strong></td>
                  </tr>
                        </table>
                <?php } ?>
              </div>
                    </div>
          </div>
                </div>
      </div>
            </div>
    <?php
                }
                else
                {
                    ?>
    <table width="100%">
              <tr>
        <th align="left"><?php echo ADMIN_USER_PERMISSION_TITLE; ?></th>
      </tr>
              <tr>
        <td><?php echo ADMIN_USER_PERMISSION_MSG; ?></td>
      </tr>
            </table>
    <?php } ?>
  </div>
          <?php require_once('inc/footer.inc.php'); ?>
        </div>
<script type="text/javascript">
<?php
if (isset($_REQUEST['frmSearchPressed']) && $_REQUEST['frmSearchPressed'] == 'Yes')
{
    ?>
            showSearchBox('search', 'show');
    <?php
}
else
{
    ?>
            showSearchBox('search', 'hide');
<?php } ?>
        </script>
</body>
</html>