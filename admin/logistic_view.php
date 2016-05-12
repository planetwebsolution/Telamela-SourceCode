<?php
require_once '../common/config/config.inc.php';
require_once CONTROLLERS_ADMIN_PATH . FILENAME_LOGICTIC_CTRL;
require_once CLASSES_SYSTEM_PATH . 'class_sort_bll.php';
require_once CLASSES_SYSTEM_PATH . 'class_session_redirect_bll.php';
//pre($objPage->arrorderdataitem);
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    <link rel="shortcut icon" href="http://dothejob.in/telamela-new/common/images//favicon.ico" />
        <title>Customer:Invoice || Statement</title>
        <link href="http://dothejob.in/telamela-new/common/css/invoice.css" rel="stylesheet" />
    </head>
    <body>
    
    

            <div class="dashboard_title" style="font-family:Arial, Helvetica, sans-serif; width: 99.3%;margin-bottom: 0px;color: #000;font-size: 13px;font-weight: bold;background-color: #FA990E;padding: 5px 4px 5px 5px;margin: 5px 0 0px 0;border-bottom: 1px #7986a9 solid;">Customer Invoice <span style="float: right;margin-right: 10px;font-size: 12px;font-weight: normal;"><a href="javascript:void(0)" onClick="window.print();" style="color:black" class="noPrint">Print</a></span></div>
<table width="99%" border="0" cellspacing="0" cellpadding="0" style="font-family:Arial, Helvetica, sans-serif; float: left;width: 100%;border: 1px solid #c3c4c6;padding: 0px;border-top: none;border-bottom: none;border-right: none;" class="left_content">
  <tr class="content">
    <td width="48%" valign="top" align="left" style="font-family:Arial, Helvetica, sans-serif; border:0; text-align: left;color: #333;padding: 4px 4px 4px 6px;font-size: 12px;"><table cellpadding="0" cellspacing="0" border="0" class="left_content table_border" style="font-family:Arial, Helvetica, sans-serif; width: 100%;border: 1px solid #c3c4c6;padding: 0px;border-top: none;border-bottom: none;border-right: none;">
        <tr class="content">
          <td colspan="2" class="heading" style="font-family:Arial, Helvetica, sans-serif; text-align: left;color: #333;padding: 4px 4px 4px 6px;font-size: 14px;font-weight: bold;background-color: #E9E9E8;">Order Details </td>
        </tr>
        <tr class="content">
          <td colspan="2" style="font-family:Arial, Helvetica, sans-serif; text-align: left;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">&nbsp;</td>
        </tr>
        <tr class="content">
          <td class="admin_left_text" style="font-family:Arial, Helvetica, sans-serif; text-align: left;width: 50%;font-weight: bold;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">Order ID</td>
          <td class="admin_left_input" style="font-family:Arial, Helvetica, sans-serif; text-align: left;width: 50%;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;"><?php echo $objPage->arrlogistic[0][fkOrderID]?> </td>
        </tr>
        <tr class="content">
          <td class="admin_left_text" style="font-family:Arial, Helvetica, sans-serif; text-align: left;width: 50%;font-weight: bold;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">Order Date</td>
          <td class="admin_left_input" style="font-family:Arial, Helvetica, sans-serif; text-align: left;width: 50%;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;"><?php echo $objPage->arrlogistic[0][OrderDateAdded]?></td>
        </tr>
        <tr class="content">
          <td class="admin_left_text" style="font-family:Arial, Helvetica, sans-serif; text-align: left;width: 50%;font-weight: bold;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">Order Status</td>
          <td class="admin_left_input" style="font-family:Arial, Helvetica, sans-serif; text-align: left;width: 50%;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px; background-color:<?php echo ($objPage->arrlogistic[0][Status]=='Canceled') ? 'RED !important':''?>"><?php echo $objPage->arrlogistic[0][Status]?></td>
        </tr>
      </table></td>
    <td width="2%" style="font-family:Arial, Helvetica, sans-serif; border: none;text-align: left;color: #333;padding: 4px 4px 4px 6px;font-size: 12px;">&nbsp;</td>
    <td width="48%" valign="top" align="left" style="font-family:Arial, Helvetica, sans-serif; border: none;text-align: left;color: #333;padding: 4px 4px 4px 6px;font-size: 12px;"><table cellpadding="0" cellspacing="0" border="0" class="left_content table_border" style="font-family:Arial, Helvetica, sans-serif; width: 100%;border: 1px solid #c3c4c6;padding: 0px;border-top: none;border-bottom: none;border-right: none;">
        <tr class="content">
          <td colspan="2" class="heading" style="font-family:Arial, Helvetica, sans-serif; text-align: left;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 14px;font-weight: bold;background-color: #E9E9E8;">Account Information</td>
        </tr>
        <tr class="content">
          <td colspan="2" style="font-family:Arial, Helvetica, sans-serif; text-align: left;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">&nbsp;</td>
        </tr>
        <tr class="content">
          <td class="admin_left_text" style="font-family:Arial, Helvetica, sans-serif; text-align: left;width: 50%;font-weight: bold;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;"> Customer Name:</td>
          <td class="admin_left_input" style="font-family:Arial, Helvetica, sans-serif; text-align: left;width: 50%;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;"><?php echo $objPage->arrorderdata[0][CustomerFirstName].' '.$objPage->arrorderdata[0][CustomerLastName]?></td>
        </tr>
        <tr class="content">
          <td class="admin_left_text" style="font-family:Arial, Helvetica, sans-serif; text-align: left;width: 50%;font-weight: bold;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;"> Email:</td>
          <td class="admin_left_input" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;"><?php echo $objPage->arrorderdata[0][CustomerEmail] ?></td>
        </tr>
        <tr class="content">
          <td class="admin_left_text" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;font-weight: bold;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">Phone</td>
          <td class="admin_left_input" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;"><?php echo $objPage->arrorderdata[0][CustomerPhone] ?></td>
        </tr>
      </table></td>
  </tr>
  <tr class="content">
    <td colspan="3" style="font-family:Arial, Helvetica, sans-serif; border: none;text-align: left;color: #333;padding: 4px 4px 4px 6px;font-size: 12px;">&nbsp;</td>
  </tr>
  <tr class="content">
    <td width="48%" valign="top" align="left" style="font-family:Arial, Helvetica, sans-serif;border: none;text-align: left;color: #333;padding: 4px 4px 4px 6px;font-size: 12px;"><table cellpadding="0" cellspacing="0" border="0" class="left_content table_border" style="font-family:Arial, Helvetica, sans-serif;width: 100%;border: 1px solid #c3c4c6;padding: 0px;border-top: none;border-bottom: none;border-right: none;">
        <tr class="content">
          <td colspan="2" class="heading" style="font-family:Arial, Helvetica, sans-serif;text-align: left;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 14px;font-weight: bold;background-color: #E9E9E8;">Billing Information</td>
        </tr>
        <tr class="content">
          <td colspan="2" style="font-family:Arial, Helvetica, sans-serif;text-align: left;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">&nbsp;</td>
        </tr>
        <tr class="content">
          <td class="admin_left_text" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;font-weight: bold;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;"> Recipient First Name:</td>
          <td class="admin_left_input" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;"><?php echo $objPage->arrorderdata[0][BillingFirstName] ?></td>
        </tr>
        <tr class="content">
          <td class="admin_left_text" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;font-weight: bold;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;"> Recipient Last Name:</td>
          <td class="admin_left_input" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;"><?php echo $objPage->arrorderdata[0][BillingLastName] ?></td>
        </tr>
        
        <tr class="content">
          <td class="admin_left_text" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;font-weight: bold;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;"> Address Line 1:</td>
          <td class="admin_left_input" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;"><?php echo $objPage->arrorderdata[0][BillingAddressLine1] ?></td>
        </tr>
        <tr class="content">
          <td class="admin_left_text" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;font-weight: bold;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">Address Line 2</td>
          <td class="admin_left_input" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;"><?php echo $objPage->arrorderdata[0][BillingAddressLine2] ?>&nbsp;</td>
        </tr>
        <tr class="content">
          <td class="admin_left_text" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;font-weight: bold;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;"> Country</td>
          <td class="admin_left_input" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;"><?php 
          $countrybill=$objGeneral->getCountrynamebyid($objPage->arrorderdata[0][BillingCountry]);
          echo $countrybill[0]['name'];
           ?></td>
        </tr>
        <tr class="content">
          <td class="admin_left_text" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;font-weight: bold;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;"> Post Code or Zip Code:</td>
          <td class="admin_left_input" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;"><?php echo $objPage->arrorderdata[0][BillingPostalCode] ?></td>
        </tr>
        <tr class="content">
          <td class="admin_left_text" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;font-weight: bold;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;"> Phone:</td>
          <td class="admin_left_input" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;"><?php echo $objPage->arrorderdata[0][BillingPhone] ?></td>
        </tr>
      </table></td>
    <td width="2%" style="font-family:Arial, Helvetica, sans-serif;border: none;text-align: left;color: #333;padding: 4px 4px 4px 6px;font-size: 12px;">&nbsp;</td>
    <td width="48%" valign="top" align="left" style="font-family:Arial, Helvetica, sans-serif;border: none;text-align: left;color: #333;padding: 4px 4px 4px 6px;font-size: 12px;"><table cellpadding="0" cellspacing="0" border="0" class="left_content table_border" style="font-family:Arial, Helvetica, sans-serif;width: 100%;border: 1px solid #c3c4c6;padding: 0px;border-top: none;border-bottom: none;border-right: none;">
        <tr class="content">
          <td colspan="2" class="heading" style="font-family:Arial, Helvetica, sans-serif;text-align: left;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 14px;font-weight: bold;background-color: #E9E9E8;">Shipping Information</td>
        </tr>
        <tr class="content">
          <td colspan="2" style="font-family:Arial, Helvetica, sans-serif;text-align: left;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">&nbsp;</td>
        </tr>
        <tr class="content">
          <td class="admin_left_text" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;font-weight: bold;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;"> Recipient First Name:</td>
          <td class="admin_left_input" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;"><?php echo $objPage->arrorderdata[0][ShippingFirstName] ?></td>
        </tr>
        <tr class="content">
          <td class="admin_left_text" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;font-weight: bold;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;"> Recipient Last Name:</td>
          <td class="admin_left_input" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;"><?php echo $objPage->arrorderdata[0][ShippingLastName] ?></td>
        </tr>
       
        <tr class="content">
          <td class="admin_left_text" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;font-weight: bold;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;"> Address Line 1:</td>
          <td class="admin_left_input" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;"><?php echo $objPage->arrorderdata[0][ShippingAddressLine1] ?></td>
        </tr>
        <tr class="content">
          <td class="admin_left_text" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;font-weight: bold;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">Address Line 2</td>
          <td class="admin_left_input" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;"><?php echo $objPage->arrorderdata[0][ShippingAddressLine2] ?>&nbsp;</td>
        </tr>
        <tr class="content">
          <td class="admin_left_text" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;font-weight: bold;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;"> Country</td>
          <td class="admin_left_input" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;"><?php 
          $countryship=$objGeneral->getCountrynamebyid($objPage->arrorderdata[0][ShippingCountry]);
          echo $countryship[0]['name'];
            ?></td>
        </tr>
        <tr class="content">
          <td class="admin_left_text" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;font-weight: bold;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;"> Post Code or Zip Code:</td>
          <td class="admin_left_input" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;"><?php echo $objPage->arrorderdata[0][ShippingPostalCode] ?></td>
        </tr>
        <tr class="content">
          <td class="admin_left_text" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;font-weight: bold;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;"> Phone:</td>
          <td class="admin_left_input" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;"><?php echo $objPage->arrorderdata[0][ShippingPhone] ?></td>
        </tr>
      </table></td>
  </tr>
  <tr class="content">
    <td width="48%" colspan="3" valign="top" align="left" style="font-family:Arial, Helvetica, sans-serif;border: none;text-align: left;color: #333;padding: 4px 4px 4px 6px;font-size: 12px;"><table cellpadding="0" cellspacing="0" border="0" class="left_content table_border" style="font-family:Arial, Helvetica, sans-serif;width: 100%;border: 1px solid #c3c4c6;padding: 0px;border-top: none;border-bottom: none;border-right: none;">
        <tr class="content">
          <td class="heading1" style="font-family:Arial, Helvetica, sans-serif;text-align: center;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 14px;font-weight: bold;background-color: #E9E9E8;">Sub Order Id</td>
          <td class="heading1" style="font-family:Arial, Helvetica, sans-serif;text-align: center;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 14px;font-weight: bold;background-color: #E9E9E8;">Items Ordered</td>
          <td class="heading1" style="font-family:Arial, Helvetica, sans-serif;text-align: center;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 14px;font-weight: bold;background-color: #E9E9E8;">Items Image</td>
          <td class="heading1" style="font-family:Arial, Helvetica, sans-serif;text-align: center;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 14px;font-weight: bold;background-color: #E9E9E8;">Qty.</td>
          
          <td class="heading1" style="font-family:Arial, Helvetica, sans-serif;text-align: center;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 14px;font-weight: bold;background-color: #E9E9E8;">Shipping Total</td>
        </tr>
         
         <?php 
         $totalprice=0.0;
         foreach ($objPage->arrorderdataitem as $value) {
         	
         	?>
         <tr class="content">
          <td style="font-family:Arial, Helvetica, sans-serif;text-align: center;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;"><?php echo $objPage->arrlogistic[0][fkSubOrderID]?></td>
          <td style="font-family:Arial, Helvetica, sans-serif;text-align: center;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;"><b><?php echo $value[ItemName]?></b><br/><br>
            Weight <?php echo $objGeneral->convertproductweight($value['WeightUnit'],$value['Weight']).' '.'kg';//round($objPage->arrproductweight[0][Weight], 2).' '.$objPage->arrproductweight[0][WeightUnit]?><br></td>
           <?php $imgsrc=$value[ItemImage];
           $varProductImageUrl = SITE_ROOT_URL . 'common/uploaded_files/images/products/85x67/'.$imgsrc;
           ?>
          <td style="font-family:Arial, Helvetica, sans-serif;text-align: center;color: #333;border-right: 1px solid #c3
          c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;"> <img src="<?php echo $varProductImageUrl?>" alt="Canon" style="font-family:Arial, Helvetica, sans-serif;float: none;border: none;" /></td>
          <td style="font-family:Arial, Helvetica, sans-serif;text-align: center;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;"><?php echo $value[Quantity]?></td>
          
          <td style="font-family:Arial, Helvetica, sans-serif;text-align: center;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;"> $ <?php   echo $objCore->price_format($value[ShippingPrice])?></td>
        </tr>	
      <?php 
      
      $totalprice= $totalprice + $value[ShippingPrice];
         }
         ?>
         
        
        
      </table></td>
  </tr>
  <tr class="content">
    <td colspan="3" style="font-family:Arial, Helvetica, sans-serif;border: none;text-align: left;color: #333;padding: 4px 4px 4px 6px;font-size: 12px;">&nbsp;</td>
  </tr>
  <tr class="content">
    <td width="48%" valign="top" align="left" style="font-family:Arial, Helvetica, sans-serif;border: none;text-align: left;color: #333;padding: 4px 4px 4px 6px;font-size: 12px;"><table cellpadding="0" cellspacing="0" border="0" class="left_content table_border" style="font-family:Arial, Helvetica, sans-serif;width: 100%;border: 1px solid #c3c4c6;padding: 0px;border-top: none;border-bottom: none;border-right: none;">

      </table></td>
    <td width="2%" style="font-family:Arial, Helvetica, sans-serif;border: none;text-align: left;color: #333;padding: 4px 4px 4px 6px;font-size: 12px;">&nbsp;</td>
    <td width="48%" valign="top" align="left" style="font-family:Arial, Helvetica, sans-serif;border: none;text-align: left;color: #333;padding: 4px 4px 4px 6px;font-size: 12px;"><table cellpadding="0" cellspacing="0" border="0" class="left_content table_border" style="font-family:Arial, Helvetica, sans-serif;width: 100%;border: 1px solid #c3c4c6;padding: 0px;border-top: none;border-bottom: none;border-right: none;">
        <tr class="content">
          <td colspan="2" class="heading" style="font-family:Arial, Helvetica, sans-serif;text-align: left;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 14px;font-weight: bold;background-color: #E9E9E8;">Shipping Totals</td>
    
        </tr>
        
        
        <tr class="content">
          <td class="admin_left_text" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;font-weight: bold;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;">Total</td>
          <td class="admin_left_input" style="font-family:Arial, Helvetica, sans-serif;text-align: left;width: 50%;color: #333;border-right: 1px solid #c3c4c6;border-bottom: 1px solid #c3c4c6;padding: 4px 4px 4px 6px;font-size: 12px;"> $ <?php  echo $objCore->price_format($totalprice)?></td>
        </tr>
      </table></td>
  </tr>
  <tr class="content">
    <td colspan="3" style="font-family:Arial, Helvetica, sans-serif;border: none;text-align: left;color: #333;padding: 4px 4px 4px 6px;font-size: 12px;">&nbsp;</td>
  </tr>
</table></body></html>