<?php

require_once '../config/config.inc.php';
require_once '../../classes/class_email_template_bll.php';

class CartReminderMail extends Database {
    
    public  $varDateOne;
    
    /** ****************************************
      Function name : runCron
      Comments : This function call the cron functions one by one.
      User instruction : $res = $objClass->runCron();
     * **************************************** */
   
   public function __construct(){
       $objCore = new Core();
       $this->varDateOne = $objCore->serverDateTime(date('Y-m-d H:i:s',  strtotime("-1 week")), DATE_TIME_FORMAT_DB);
       $this->runReminderMailCron();
    }

    
    function CustomerDetails($argCustomerId) {
        $arrClms = array(
            'pkCustomerID',
            'CustomerFirstName',
            'CustomerLastName',
            'CustomerEmail',
            'BillingFirstName',
            'BillingLastName',
            'BillingOrganizationName',
            'BillingAddressLine1',
            'BillingAddressLine2',
            'BillingCountry',
            'BillingPostalCode',
            'BillingPhone',
            'ShippingFirstName',
            'ShippingLastName',
            'ShippingOrganizationName',
            'ShippingAddressLine1',
            'ShippingAddressLine2',
            'ShippingCountry',
            'ShippingPostalCode',
            'ShippingPhone',
            'BusinessAddress'
        );
        $argWhere = "pkCustomerID='" . $argCustomerId . "' ";
        $arrRes = $this->select(TABLE_CUSTOMER, $arrClms, $argWhere);
        //pre($arrRes);
        return $arrRes;
    }
    
    
    /**
     * function productDetailsWithId
     *
     * This function is used for get seleted data from product table.
     *
     * Database Tables used in this function are : tbl_product
     *
     * @access public
     *
     * @parameters 1
     *
     * @return String $arrRes
     */
    function getProcuctDetails($productID = '') {

        $arrClms = array(
            'pkProductID',
            'ProductRefNo',
            'ProductName',
            'fkShippingID',
            'fkWholesalerID','Quantity', 'QuantityAlert', 'ProductImage','wholesalePrice','FinalPrice','DiscountPrice','fkCategoryID'
        );
        $varTable = TABLE_PRODUCT;
        $argWhere = "pkProductID =" . $productID."";
        $arrRes = $this->select($varTable, $arrClms, $argWhere);
        //pre($arrRes);
        return $arrRes;
    }
    
    function getPackageDetails($id=''){
        
        $arrClms = array(
            'pkPackageId',
            'fkWholesalerID',
            'PackageName',
            'PackageACPrice',
            'PackagePrice','PackageImage'
        );
        $varTable = TABLE_PACKAGE;
        $argWhere = "pkPackageId =" . $id."";
        $arrRes = $this->select($varTable, $arrClms, $argWhere);
        //pre($arrRes);
        return $arrRes;
    }
    
    
    function getCategoryDetails($productID = '') {

        $arrClms = array('CategoryName');
        $varTable = TABLE_CATEGORY;
        $argWhere = "pkCategoryId =" . $productID;
        $arrRes = $this->select($varTable, $arrClms, $argWhere);
        //pre($arrRes);
        return $arrRes;
    }
    
    
    
    /* * ****************************************
      Function name : runrunNewsletterCron
      Comments : This function send newsletter to customer & wholesaler.
      User instruction : $res = $objClass->runNewsletterCron();
     * **************************************** */

   public function runReminderMailCron() { 
        global $objGeneral;
        global $objCore;
        $objTemplate = new EmailTemplate();
        $varWhere="CartReminderDate<='".$this->varDateOne."'";
        $arrCols = array('pkCartID', 'fkCustomerID', 'CartDetails', 'CartData', 'CartReminderDate', 'CartDateAdded');
        $varTbl = TABLE_CART;
        $arrReminDates = $this->select($varTbl, $arrCols, $varWhere);
        //echo '<pre>';print_r(unserialize($arrReminDates[0]['CartData']));die;       //echo  pre($arrReminDates);
        if(count($arrReminDates)>0){
        foreach($arrReminDates as $key=>$val){            
           $ProductDetails=unserialize($val['CartData']);  
           //echo pre($ProductDetails);die;
           $CustomerDetails=$this->CustomerDetails($val['fkCustomerID']);
           //echo $val['fkCustomerID'];die;
           //echo pre($CustomerDetails);die;
           $arrOrderDetail=$CustomerDetails[0];
           $varCustomerName = $arrOrderDetail['CustomerFirstName'] . ' ' . $arrOrderDetail['CustomerLastName'];
           //echo $arrOrderDetail['CustomerEmail'];
            if(is_array($ProductDetails)){
               
                $varEmailOrderDetails = '<table width="622" cellspacing="0" cellpadding="5" border="0" align="center"><tr><td style="font:700 17px arial;">Dear ' . $varCustomerName . ',</td></tr><tr><td height="50" style="font:400 15px/17px arial;">This is an reminder mail that you have add some product in your cart.</td></tr></table>';

        $varEmailOrderDetails .= '<table width="622" cellpadding="0" cellspacing="0" border="0" align="center" style="bgcolor="#fff";border:3px solid #ffb422;-webkit-border-radius:3px;-moz-border-radius:3px;-ms-border-radius:3px;-o-border-radius:3px;border-radius:3px;padding-top:32px;padding-bottom:52px;">
                     
                        <tr>
                            <td colspan="5">
                                <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                    <tr>
                                        
                                        <th width="117" bgcolor="#fa990e" height="43" style="border-right:1px solid #cbc5bb;font-size:11px;"><font color="#fff" face="Arial" size="2">Items Name</font></th>
                                        <th width="113" bgcolor="#fa990e" height="43" style="border-right:1px solid #cbc5bb;font-size:11px;"><font color="#fff" face="Arial" size="2">Item Image</font></th>
                                        <th width="53" bgcolor="#fa990e" height="43" style="border-right:1px solid #cbc5bb;font-size:11px;"><font color="#fff" face="Arial" size="2">Price</font></th>
                                        <th width="37" bgcolor="#fa990e" height="43" style="border-right:1px solid #cbc5bb;font-size:11px;"><font color="#fff" face="Arial" size="2">Qty.</font></th>
                                        
                                    </tr>';


        $in=0;
        //echo pre($ProductDetails['Product'][0][0]['qty']);die;
        foreach ($ProductDetails['Product'] as $k => $v) { 
            $in++;
            $key=array_keys($v);
            $key=explode('-',$key[0]);
            //echo ;die;
            $varProduct=$key[0];
            $getProcuctDetails =$this->getProcuctDetails($varProduct);
            $getProcuctDetails=$getProcuctDetails[0];
           // echo pre($getProcuctDetails);
            if (count($getProcuctDetails) >0) {
                
                $path = 'products/70x70';
                $varSrc = $objCore->getImageUrl($getProcuctDetails['ProductImage'], $path);
                $bgcolor = $in % 2 == 0 ? '#ffe7b9' : '#fffcf5';
                $ItemPrice = $getProcuctDetails['wholesalePrice'] + ($getProcuctDetails['FinalPrice'] / $getProcuctDetails['Quantity']);
                $ItemTotalPrice =$getProcuctDetails['FinalPrice']-$getProcuctDetails['DiscountPrice'];
            $varEmailOrderDetails .='<tr>
                                        
                                        <td width="117" bgcolor="' . $bgcolor . '" height="80" align="center" style="border-right:1px solid #cbc5bb;font-size:11px;"><font color="#222" face="Arial"><strong style="font-size:13px;">' . $getProcuctDetails['ProductName'] . '</strong><br />' . $val['CartDateAdded'] . '</font></td>
                                        <td width="113" bgcolor="' . $bgcolor . '" height="80" align="center" style="border-right:1px solid #cbc5bb;font-size:11px;"><font color="#222" face="Arial"><img src="' . $varSrc . '" alt="' . $getProcuctDetails['ProductName'] . '" /></font></td>
                                        <td width="53" bgcolor="' . $bgcolor . '" height="80" align="center" style="border-right:1px solid #cbc5bb;font-size:11px;"><font color="#222" face="Arial">' . ADMIN_CURRENCY_SYMBOL . number_format($ItemPrice, 2) . '</font></td>
                                        <td width="37" bgcolor="' . $bgcolor . '" height="80" align="center" style="border-right:1px solid #cbc5bb;font-size:11px;"><font color="#222" face="Arial">' . $key[0]['qty'] . '</font></td>
                                        </tr>';
                
                
                
            } 
        }
        $inP=0;
        foreach ($ProductDetails['package'] as $k => $vPKG) {
            $inP++;
            $key=array_keys($v);
            $key=explode('-',$key[0]);
            $varProduct=$key[0];
            $getProcuctDetails =$this->getPackageDetails($varProduct);
            //echo pre($getProcuctDetails);
            if (count($getProcuctDetails) >0) {
                
                $path = 'package/65x65';
                $varSrc = $objCore->getImageUrl($getProcuctDetails['PackageImage'], $path);
                $bgcolor = $inP % 2 == 0 ? '#ffe7b9' : '#fffcf5';
                $ItemPrice = $getProcuctDetails['PackageACPrice'] + ($getProcuctDetails['PackagePrice'] / $vPKG['qty']);
                
            $varEmailOrderDetails .='<tr>
                                       
                                        <td width="117" bgcolor="' . $bgcolor . '" height="80" align="center" style="border-right:1px solid #cbc5bb;font-size:11px;"><font color="#222" face="Arial"><strong style="font-size:13px;">' . $getProcuctDetails['PackageName'] . '</strong><br />' . $val['CartDateAdded'] . '</font></td>
                                        <td width="113" bgcolor="' . $bgcolor . '" height="80" align="center" style="border-right:1px solid #cbc5bb;font-size:11px;"><font color="#222" face="Arial"><img src="' . $varSrc . '" alt="' . $getProcuctDetails['PackageName'] . '" /></font></td>
                                        <td width="53" bgcolor="' . $bgcolor . '" height="80" align="center" style="border-right:1px solid #cbc5bb;font-size:11px;"><font color="#222" face="Arial">' . ADMIN_CURRENCY_SYMBOL . number_format($vPKG['PackagePrice'], 2) . '</font></td>
                                        <td width="37" bgcolor="' . $bgcolor . '" height="80" align="center" style="border-right:1px solid #cbc5bb;font-size:11px;"><font color="#222" face="Arial">' . $vPKG['qty'] . '</font></td>
                                        </tr>';
                
                
                
            } 
        }
        $ing=0;
        foreach ($ProductDetails['GiftCard'] as $key => $giftCards) { $ing++;
                                            $varCartSubTotal = $giftCards['qty'] * $giftCards['amount'];
                                            $bgcolor = $in % 2 == 0 ? '#ffe7b9' : '#fffcf5';
                                            $varSrc = $objCore->getImageUrl('', 'gift_card');
                $varEmailOrderDetails .='<tr>
                                       
                                        <td width="117" bgcolor="' . $bgcolor . '" height="80" align="center" style="border-right:1px solid #cbc5bb;font-size:11px;"><font color="#222" face="Arial"><strong style="font-size:13px;">' . $giftCards['message'] . '</strong><br />' . $val['CartDateAdded'] . '</font></td>
                                        <td width="113" bgcolor="' . $bgcolor . '" height="80" align="center" style="border-right:1px solid #cbc5bb;font-size:11px;"><font color="#222" face="Arial"><img src="' . $varSrc . '" alt="' . $giftCards['message'] . '" /></font></td>
                                        <td width="53" bgcolor="' . $bgcolor . '" height="80" align="center" style="border-right:1px solid #cbc5bb;font-size:11px;"><font color="#222" face="Arial">' . ADMIN_CURRENCY_SYMBOL . number_format($giftCards['amount'], 2) . '</font></td>
                                        <td width="37" bgcolor="' . $bgcolor . '" height="80" align="center" style="border-right:1px solid #cbc5bb;font-size:11px;"><font color="#222" face="Arial">' . $giftCards['qty'] . '</font></td>
                                       </tr>';
                                            
                                            //$varCartTotal += $varCartSubTotal;
                                        }

            
        }
        $varFrom = SITE_NAME;
        $varSubject = 'Telamela Cart Confirmation';
        $varHeading = 'Cart Confirmation';
        $varEmailOrderDetails .= '</table></td></tr></table>';
        $varEmailMessage = $varEmailOrderDetails; //str_replace($varKeyword, $varKeywordValues, $EmailTemplates);
        $objCore->sendMail($arrOrderDetail['CustomerEmail'], $varFrom, $varSubject, $varEmailMessage);
        $whereUp="fkCustomerID='".$val['fkCustomerID']."'";
        $this->update(TABLE_CART, array('CartReminderDate'=>date('Y-m-d H:i:s')), $whereUp);
        };
        }
    }
}

$objGiftCard = new CartReminderMail();
//$objGiftCard->runGiftCardMail();
?>