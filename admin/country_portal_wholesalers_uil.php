<?php
require_once '../common/config/config.inc.php';
require_once CONTROLLERS_ADMIN_PATH . FILENAME_COUNTRY_PORTAL_CTRL;
//pre($_SESSION);
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
        <title><?php echo ADMIN_PANEL_NAME; ?> : Manage Country Portal</title>
        <?php require_once 'inc/common_css_js.inc.php'; ?>
        <link rel="stylesheet" type="text/css" media="all" href="../components/cal/skins/aqua/theme.css" title="Aqua" /> 
       
    </head>
    <body>
        <?php require_once 'inc/header_new.inc.php'; ?>
        
        
         <div class="container-fluid" id="content">
            <div id="main">
                <div class="container-fluid">
                    <div class="page-header">
                        <div class="pull-left">
                            <h1>Country Portal - Wholesalers</h1>
                        </div>
                    </div>
                    <?php require_once('javascript_disable_message.php'); ?>
                    <?php if ($_SESSION['sessUserType'] == 'super-admin') { ?>
  				   </div>                            
                    
                    <div class="row-fluid" style="width:98%;margin:10px;">
                        <div class="span12">                        	
                                <?php if ($objCore->displaySessMsg() <> '') { 
                                        echo $objCore->displaySessMsg();
                                        $objCore->setSuccessMsg('');
                                        $objCore->setErrorMsg('');
                            		}
                                ?>
                                
                            <div class="box box-color box-bordered">
                            <a id="buttonDecoration" href="<?php echo $_SERVER['HTTP_REFERER']; ?>"><input type="button" class="btn" name="btnTagSettings" value="<?php  echo ADMIN_BACK_BUTTON;?>" style="float:right; margin:6px 2px 0 0; width:107px;"/></a>
                                <div class="box-title">
                                    <h3>
                                     Country Portal - Wholesalers
                                    </h3>
                                </div>
                                <div class="box-content nopadding manage_categories">  
                                	<div id="DataTables_Table_0_wrapper" class="dataTables_wrapper" role="grid">
                                   <?php if (count($objPage->arrRows) > 0) { ?>
                                        <table class="table table-hover table-nomargin table-bordered usertable">
                                        <thead>
                                            <tr>
                                              <?php echo $objPage->varSortColumn;  ?>
                                             </tr>
                                        </thead>
                                        <tbody>
                                           <?php
                                foreach ($objPage->arrRows as $val) {                                                                            
                                    ?>
                                    <tr class="content">
                                        <td class="hidden-480"><?php echo $val['pkWholesalerID']; ?></td>
                                        <td><?php echo $val['CompanyName']; ?></td>
                                        <td><?php echo $val['kpi']; ?></td>
                                        <td class="hidden-480"><?php echo $val['NoOfSoldItems']; ?></td>                                            
                                        <td class="hidden-480"><?php echo number_format($val['TotalSoldAmount'],2); ?></td>
                                        <td><?php echo number_format($val['AdminCommission'],2); ?></td>
                                    </tr>
                                    <?php
                                }?>
                                 </tbody>                                       
                                    </table>
                                   <div class="dataTables_paginate paging_full_numbers" id="DataTables_Table_0_paginate"><?php if ($objPage->varNumberPages > 1) { $objPage->displayPaging($_GET['page'], $objPage->varNumberPages, $objPage->varPageLimit); } ?></div>                            
                                  
                              <?php  } else {  ?>
									<table class="table table-hover table-nomargin table-bordered usertable">
		                                    <tr class="content">
		                                        <td colspan="10" style="text-align:center">
		                                            <strong>No record(s) found.</strong>
		                                        </td>
		                                    </tr>
		                            </table>        
                        			<?php } ?>
                        			</div>
                                </div>
                            </div>
                        </div>
                    </div>
                
                <?php }else{ ?>
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
    </body>
</html>
