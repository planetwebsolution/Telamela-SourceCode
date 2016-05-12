<?php

require_once(CLASSES_PATH . 'class_email_template_bll.php');

/**
 * 
 * Class name : BulkUpload
 *
 * Parent module : None
 *
 * Author : Vivek Avasthi
 *
 * Last modified by : Arvind Yadav
 *
 * Comments : The BulkUpload class is used to maintain BulkUpload infomation.
 */
class BulkUpload extends Database {

    /**
     * function __construct
     *
     * Constructor of the class, will be called in PHP5
     *
     * @access public
     *
     */
    function __construct() {
        //$objCore = new Core();
        //default constructor for this class
    }

    /**
     * function countRows
     *
     * This function is used to display the countRows deatails.
     *
     * Database Tables used in this function are : 
     *
     * @access public
     *
     * @parameters 3 string
     *
     * @return string $varNum
     *
     * User instruction: $objBulkUpload->countRows($argTable = '', $arrClms = array(), $argWhere = '')
     */
    function countRows($argTable = '', $arrClms = array(), $argWhere = '') {
        $arrNum = $this->getNumRows($argTable, $arrClms, $argWhere);
        //pre($arrRes);
        return $varNum;
    }

    /**
     * function fetchRow
     *
     * This function is used to get the Row deatails.
     *
     * Database Tables used in this function are : 
     *
     * @access public
     *
     * @parameters 3 string
     *
     * @return string $arrRes
     *
     * User instruction: $objBulkUpload->fetchRow($argTable = '', $arrClms = array(), $argWhere = '')
     */
    function fetchRow($argTable = '', $arrClms = array(), $argWhere = '') {
        $arrRes = $this->select($varTable, $arrClms, $argWhere);
        //pre($arrRes);
        return $arrRes;
    }

    /**
     * function addRow
     *
     * This function is used to add the Row .
     *
     * Database Tables used in this function are : 
     *
     * @access public
     *
     * @parameters 2 string
     *
     * @return string $arrAddID
     *
     * User instruction: $objBulkUpload->addRow($argTable, $arrCols)
     */
    function addRow($argTable, $arrCols) {
        $arrAddID = $this->insert($argTable, $arrCols);
        return $arrAddID;
    }

    /**
     * function uploadProduct
     *
     * This function is used to upload the Product .
     *
     * Database Tables used in this function are : 
     *
     * @access public
     *
     * @parameters 2 string
     *
     * @return string $arrAddID
     *
     * User instruction: $objBulkUpload->uploadProduct($argTable, $arrCols) 
     */
    function uploadProduct($argTable, $arrCols) {
        $arrAddID = $this->insert($argTable, $arrCols);
        return $arrAddID;
    }

    /**
     * function findCategory
     *
     * This function is used to find the Category .
     *
     * Database Tables used in this function are : tbl_category
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $arrRes
     *
     * User instruction: $objBulkUpload->findCategory($argCat) 
     */
    function findCategory($argCat) {
        $varID = "TRIM(CategoryName) = '" . addslashes(html_entity_decode(trim($argCat), ENT_QUOTES)) . "'";
        $arrClms = array('pkCategoryId');
        $varTable = TABLE_CATEGORY;
        $arrRes = $this->select($varTable, $arrClms, $varID);
        return $arrRes[0]['pkCategoryId'];
    }

    /**
     * function findWholesaler
     *
     * This function is used to find the Wholesaler .
     *
     * Database Tables used in this function are : tbl_wholesaler
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $arrRes
     *
     * User instruction: $objBulkUpload->findWholesaler($argWhlslr) 
     */
    function findWholesaler($argWhlslr) {
        $varID = "TRIM(CompanyName) = '" . addslashes(html_entity_decode(trim($argWhlslr), ENT_QUOTES)) . "'";
        $arrClms = array('pkWholesalerID');
        $varTable = TABLE_WHOLESALER;
        $arrRes = $this->select($varTable, $arrClms, $varID);
        return $arrRes[0]['pkWholesalerID'];
    }

    /**
     * function findShippingGateway
     *
     * This function is used to find the Shipping Gateway .
     *
     * Database Tables used in this function are : tbl_shipping_gateways
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $arrRes
     *
     * User instruction: $objBulkUpload->findShippingGateway($argShipping)
     */
    function findShippingGateway($argShipping) {
        $varID = "ShippingTitle IN('".str_replace(',',"','",$argShipping)."') AND ShippingStatus = '1'";
        $arrClms = array("group_concat(`pkShippingGatewaysID`) AS pkShippingGatewaysID");
        $varTable = TABLE_SHIPPING_GATEWAYS;
        $arrRes = $this->select($varTable, $arrClms, $varID);
        return $arrRes[0]['pkShippingGatewaysID'];
    }

    /**
     * function getAttributesAndOptions
     *
     * This function is used to get the Attribute Options .
     *
     * Database Tables used in this function are : tbl_attribute, tbl_attribute_to_category
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $arrRes
     *
     * User instruction: $objBulkUpload->getAttributesAndOptions($attributeCode)
     */
    function getAttributesAndOptions($catId) {

        $arrClms = array('pkAttributeID', 'AttributeCode', 'AttributeInputType');

        $varID = " fkCategoryID='" . $catId . "'";

        $varTable = TABLE_ATTRIBUTE_TO_CATEGORY . " INNER JOIN " . TABLE_ATTRIBUTE . " ON fkAttributeId = pkAttributeID";

        $arrRes = $this->select($varTable, $arrClms, $varID);

        //pre($arrRes); 

        return $arrRes;
    }

    /**
     * function getAttributeOptionId
     *
     * This function is used to get the Attribute Option Id .
     *
     * Database Tables used in this function are : tbl_attribute_option
     *
     * @access public
     *
     * @parameters 2 string
     *
     * @return string $result
     *
     * User instruction: $objBulkUpload->getAttributeOptionId($attrId, $attrOption)
     */
    function getAttributeOptionId($arrAttr, $attrOption) {
        $arrClms = array('pkOptionID', 'OptionTitle', 'OptionImage');
        $attrType = $arrAttr['AttributeInputType'];
        if ($attrType == 'textarea' || $attrType == 'text' || $attrType == 'date') {
            $varID = " fkAttributeId='" . $arrAttr['pkAttributeID'] . "'";
        } else {
            $varID = " fkAttributeId='" . $arrAttr['pkAttributeID'] . "' AND TRIM(OptionTitle) = '" . addslashes(html_entity_decode(trim($attrOption), ENT_QUOTES)) . "'";
        }
        $varTable = TABLE_ATTRIBUTE_OPTION;
        $arrRes = $this->select($varTable, $arrClms, $varID);

        return $arrRes[0];
    }

    /**
     * function getAttributeId
     *
     * This function is used to get the Attribute Id .
     *
     * Database Tables used in this function are : tbl_attribute, tbl_attribute_to_category
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $arrRes
     *
     * User instruction: $objBulkUpload->getAttributeId($attributeCode)
     */
    function getAttributeId($attributeCode, $cid) {
        $arrClms = array('pkAttributeID', 'AttributeInputType', 'AttributeCode');
        $varID = " AttributeCode='" . $attributeCode . "' AND fkCategoryID='" . $cid . "'";
        $varTable = TABLE_ATTRIBUTE_TO_CATEGORY . " INNER JOIN " . TABLE_ATTRIBUTE . " ON fkAttributeId = pkAttributeID";
        $arrRes = $this->select($varTable, $arrClms, $varID);

        return $arrRes[0];
    }

    /**
     * function checkAttributeType
     *
     * This function is used to check the Attribute Type.
     *
     * Database Tables used in this function are : tbl_attribute
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $arrRes
     *
     * User instruction: $objBulkUpload->checkAttributeType($attrId) 
     */
    function checkAttributeType($attrId) {
        $arrClms = array('AttributeInputType');
        $varID = " pkAttributeID='" . $attrId . "' ";
        $varTable = TABLE_ATTRIBUTE;
        $arrRes = $this->select($varTable, $arrClms, $varID);
        return $arrRes[0]['AttributeInputType'];
    }

    /**
     * function getAttributesList
     *
     * This function is used to get the Attribute List.
     *
     * Database Tables used in this function are : tbl_attribute
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $arrRes
     *
     * User instruction: $objBulkUpload->getAttributesList() 
     */
    function getAttributesList() {
        $arrClms = array('pkAttributeID', 'AttributeLabel', 'AttributeCode');
        $varTable = TABLE_ATTRIBUTE;
        $arrRes = $this->select($varTable, $arrClms, $varID);
        return $arrRes;
    }

    /**
     * function bulkUploadProduct
     *
     * This function is used to upload the product List.
     *
     * Database Tables used in this function are : tbl_product, tbl_product_to_option, tbl_product_option_inventory, tbl_product_image
     *
     * @access public
     *
     * @parameters 5 string
     *
     * @return string $arrAddID
     *
     * User instruction: $objBulkUpload->bulkUploadProduct($argData, $argType, $argAtrributes, $argImages, $imagePath)
     */
    function bulkUploadProduct($argData, $argType, $argAtrributes, $argAttributesInventory, $argImages, $imagePath) {

        if ($argType == 'product') {

            $arrAddID = $this->insert(TABLE_PRODUCT, $argData);

            if (count($argAtrributes) > 0) {
                $arrInventory = array();
                $attrData['fkProductId'] = $arrAddID;

                foreach ($argAtrributes as $key => $attrValues) {



                    $attrData['fkAttributeId'] = $key;


                    foreach ($attrValues['options'] as $oKey => $oVal) {

                        if ($attrValues['AttributeInputType'] == 'image') {
                            $imageNm = '';
                            if ($oVal['newImage'] <> '') {
                                $imageNm = $this->processedProductImageName($oVal['newImage']);
                                mkdir(dirname(UPLOADED_FILES_SOURCE_PATH . 'images/products/'), 0777, true);
                                //rename($imagePath . $Image, UPLOADED_FILES_SOURCE_PATH . 'images/products/' . $imageName);                        
                                copy($imagePath . $oVal['newImage'], UPLOADED_FILES_SOURCE_PATH . 'images/products/' . $imageNm);

                                $this->imageUpload($imageNm);
                            }
                            $attrData['AttributeOptionImage'] = ($imageNm == '') ? $oVal['OptionImage'] : $imageNm;
                            $attrData['IsImgUploaded'] = ($imageNm == '') ? 0 : 1;
                        } else {
                            $attrData['AttributeOptionImage'] = '';
                        }
                        $attrOptId = $oKey;
                        $attrType = $attrValues['AttributeInputType'];

                        if (!empty($attrOptId)) {


                            $attrData['fkAttributeOptionId'] = $attrOptId;

                            $attrData['OptionExtraPrice'] = $oVal['price'];

                            if ($oVal['price'] > 0) {
                                $def = 0;
                            } else {
                                $def = 1;
                            }



                            $attrData['OptionIsDefault'] = $def;
							$attrData['AttributeOptionValue'] = $oVal['OptionTitle'];
						
                            /*if ($attrType == 'textarea' || $attrType == 'text' || $attrType == 'date') {
                                $attrData['AttributeOptionValue'] = $oVal['OptionTitle'];
                            } else {
                                $attrData['AttributeOptionValue'] = '';
                            }*/

                            $arrAttrAddID = $this->insert(TABLE_PRODUCT_TO_OPTION, $attrData);
                        }
                    }
                }

                $arrInventory = $this->processInventory($argAttributesInventory, $argAtrributes);

                foreach ($arrInventory as $kInv => $vInv) {
                    $vInv['fkProductID'] = $arrAddID;
                    $arrInvAddID = $this->insert(TABLE_PRODUCT_OPTION_INVENTORY, $vInv);
                }
            }

            if (!empty($argImages)) {
                $varProductImg = '';
                foreach ($argImages as $kImg => $Image) {

                    if (!empty($Image)) {
                        $imageName = $this->processedProductImageName($Image);
                        mkdir(dirname(UPLOADED_FILES_SOURCE_PATH . 'images/products/'), 0777, true);
                        //rename($imagePath . $Image, UPLOADED_FILES_SOURCE_PATH . 'images/products/' . $imageName);                        
                        copy($imagePath . $Image, UPLOADED_FILES_SOURCE_PATH . 'images/products/' . $imageName);

                        $this->imageUpload($imageName);

                        if ($kImg == 0) {
                            $arrProImgField = array('0' => 'ProductImage');
                            $arrProImg = array($arrProImgField[$kImg] => $imageName);
                            $this->update(TABLE_PRODUCT, $arrProImg, " pkProductID='" . $arrAddID . "' ");
                        }
                        $attrData = array('fkProductId' => $arrAddID, 'ImageName' => $imageName, 'ImageDateAdded' => date(DATE_TIME_FORMAT_DB));
                        $arrAttrAddID = $this->insert(TABLE_PRODUCT_IMAGE, $attrData);
                    }
                }
            }
        }

        return $arrAddID;
    }

    /**
     * function attributeCategory
     *
     * This function is used to get the attribute Category.
     *
     * Database Tables used in this function are : tbl_attribute_to_category
     *
     * @access public
     *
     * @parameters 2 string
     *
     * @return string true
     *
     * User instruction: $objBulkUpload->attributeCategory($atrrId, $catId)
     */
    function attributeCategory($atrrId, $catId) {
        $arrClms = array('pkID');
        $varWher = "fkAttributeId = '" . $atrrId . "' AND fkCategoryID={$catId}";
        $varTable = TABLE_ATTRIBUTE_TO_CATEGORY;
        $arrRes = $this->select($varTable, $arrClms, $varWher);
        if (!empty($arrRes[0]['pkID'])) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * function processInventory
     *
     * This function is used to get the attribute Category.
     *
     * Database Tables used in this function are : none
     *
     * @access public
     *
     * @parameters 2 string
     *
     * @return string true
     *
     * User instruction: $objBulkUpload->processInventory($atrrId, $catId)
     */
    function processInventory($argAttributesInventory, $argAtrributes) {

        $arrAttrInv = explode(';', $argAttributesInventory);

        foreach ($arrAttrInv as $key => $val) {

            if ($val) {
                $arrOptQty = explode('=', $val);

                $qty = (int) $arrOptQty[1];
                $optIds = array();
                $arrAttr = explode('|', $arrOptQty[0]);

                foreach ($arrAttr as $k1 => $v1) {
                    list($attr, $opt) = explode('#', $v1);

                    foreach ($argAtrributes as $kA => $vA) {

                        if (strtolower($attr) == strtolower($vA['AttributeCode'])) {
                            foreach ($vA['options'] as $kO => $vO) {

                                if (strtolower($opt) == strtolower($vO['OptionTitle'])) {
                                    $optIds[] = $vO['pkOptionID'];
                                }
                            }
                        }
                    }
                }
                if (count($optIds) > 0) {
                    sort($optIds);
                    $strOptIds = implode(',', $optIds);
                    $arrAttrInventory[$key] = array('OptionQuantity' => $qty, 'OptionIDs' => $strOptIds);
                }
            }
        }

        //pre($arrAttrInventory);
        return $arrAttrInventory;
    }

    /**
     * function isUniqueReferenceNumber
     *
     * This function is used to get the Unique Reference Number.
     *
     * Database Tables used in this function are : tbl_product
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string true
     *
     * User instruction: $objBulkUpload->isUniqueReferenceNumber($argReferenceNumber)
     */
    function isUniqueReferenceNumber($argReferenceNumber) {
        $arrClms = array('count(*) as count');
        $varWher = "ProductRefNo = '" . addslashes(trim($argReferenceNumber)) . "' ";
        $varTable = TABLE_PRODUCT;
        $arrRes = $this->select($varTable, $arrClms, $varWher);
//        pre($arrRes);
        if ($arrRes[0]['count'] > 0) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * function processedProductImageName
     *
     * This function is used to processed the Product ImageName.
     *
     * Database Tables used in this function are : none
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $ImageName
     *
     * User instruction: $objBulkUpload->processedProductImageName($argName)
     */
    function processedProductImageName($argName) {
        $infoExt = pathinfo($argName);
        $arrName = basename($argName, '.' . $infoExt['extension']);
        //$ImageName = preg_replace('/\s\s+/', '_', $arrName);
        $ImageName = date('Ymd_his') . '_' . rand() . '.' . $infoExt['extension'];
        return $ImageName;
    }

    /**
     * function imageUpload
     *
     * This function is used to upload the product Image.
     *
     * Database Tables used in this function are : none
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $varFileName
     *
     * User instruction: $objBulkUpload->imageUpload($argFile)
     */
    function imageUpload($argFile) {
        global $arrProductImageResizes;

        $objCore = new Core();
        $objUpload = new upload();

        $ImageName = $argFile;



        $varDirLocation = UPLOADED_FILES_SOURCE_PATH . 'images/products/';

        // Set Directory
        $objUpload->setDirectory($varDirLocation);
        // CHECKING FILE TYPE.
        $arrValidImg = array("jpg", "jpeg", "gif", "png");
        $arrExt = explode(".", $ImageName);


        $varIsImage = strtolower(end($arrExt));
        //$objUpload->IsImageValid($varDirLocation.$ImageName);

        if (in_array($varIsImage, $arrValidImg)) {
            $varImageExists = 'yes';
        } else {
            $varImageExists = 'no';
            return;
        }


        if ($varImageExists == 'yes') {

            $objUpload->setFileName($ImageName);
            // Start Copy Process
            $objUpload->startCopy();
            // If there is error write the error message
            // resizing the file
            //$objUpload->resize();

            $varFileName = $objUpload->userFileName;

            // Set a thumbnail name

            $thumbnailName = 'original' . '/';
            $objUpload->setThumbnailName($thumbnailName);
            // create thumbnail
            $objUpload->createThumbnail();
            // change thumbnail size
            // $objUpload->setThumbnailSize($width, $height);
            // Set a thumbnail name

            $crop = $arrProductImageResizes['detailHover'] . '/';
            list($width, $height) = explode('x', $arrProductImageResizes['detailHover']);

            $objUpload->setThumbnailName();
            $objUpload->createThumbnail();
            $objUpload->setThumbnailSizeNew($width, $height);


            foreach ($arrProductImageResizes as $key => $val) {
                $thumbnailName = $val . '/';
                list($width, $height) = explode('x', $val);
                $objUpload->setThumbnailName($thumbnailName);
                // create thumbnail
                $objUpload->createThumbnail();
                // change thumbnail size
                $objUpload->setThumbnailSizeNew($width, $height);
            }


            //Get file name from the class public variable
            //Get file extention
            $varExt = substr(strrchr($varFileName, "."), 1);
            $varThumbFileNameNoExt = substr($varFileName, 0, -(strlen($varExt) + 1));
            //Create thumb file name
            $varThumbFileName = $varThumbFileNameNoExt . '.' . $varExt;
            return $varFileName;
        }
    }
	
    /**
     * function recursiveRemoveDirectory
     *
     * This function remove all the files in a given directory.
     *
     * Database Tables used in this function are : none
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $varFileName
     *
     * User instruction: $objBulkUpload->recursiveRemoveDirectory($argFile)
     */
    /*
    function recursiveRemoveDirectory($directory) {
        foreach (glob("{$directory}/*") as $file) {
            if (is_dir($file)) {
                $this->recursiveRemoveDirectory($file);
            } else {
                unlink($file);
            }
        }
        //rmdir($directory);
    }*/
    function recursiveRemoveDirectory($directory = null)
    {
        if(!empty($directory)){
            foreach (glob("{$directory}/*") as $file)
            {
                if (is_dir($file))
                {
                    $this->recursiveRemoveDirectory($file);
                }
                else
                {
                    unlink($file);
                }
            }
        }
    }

    /**
     * function isValidEmailID
     *
     * This function validate an email address and return 1 or 0.
     *
     * Database Tables used in this function are : none
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $varFileName
     *
     * User instruction: $objBulkUpload->isValidEmailID($argFile)
     */
   
    function isValidEmailID($argEmail) {
        return preg_match('/^[_A-z0-9-]+((\.|\+)[_A-z0-9-]+)*@[A-z0-9-]+(\.[A-z0-9-]+)*(\.[A-z]{2,4})$/', $argEmail);
    }

    /**
     * function findCountryCode
     *
     * This function returns the country id of a given country.
     *
     * Database Tables used in this function are : tbl_country
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $varFileName
     *
     * User instruction: $objBulkUpload->findCountryCode($argFile)
     */
    
    function findCountryCode($argCountryName) {
        $arrClms = array('country_id');
        $varID = "name='" . trim($argCountryName) . "'";
        $varTable = TABLE_COUNTRY;
        $arrRes = $this->select($varTable, $arrClms, $varID);
        return $arrRes[0]['country_id'];
    }

    /**
     * function findCountryRegionCode
     *
     * This function returns the resion code of a given resion in a country.
     *
     * Database Tables used in this function are : tbl_region
     *
     * @access public
     *
     * @parameters 2 string
     *
     * @return string $varFileName
     *
     * User instruction: $objBulkUpload->findCountryRegionCode($argFile)
     */
    
    function findCountryRegionCode($argCountryName, $argCountryRegion) {
        $arrClms = array('pkRegionID');
        $varID = "RegionName='" . trim($argCountryRegion) . "' AND fkCountryId='" . $this->findCountryCode($argCountryName) . "'";
        $varTable = TABLE_REGION;
        $arrRes = $this->select($varTable, $arrClms, $varID);
        return $arrRes[0]['pkRegionID'];
    }

    /**
     * function isValidUrl
     *
     * This function validate a url and return 0 or 1..
     *
     * Database Tables used in this function are : none
     *
     * @access public
     *
     * @parameters 2 string
     *
     * @return string $varFileName
     *
     * User instruction: $objBulkUpload->isValidUrl($argFile)
     */
    
    function isValidUrl($argURL) {
        $reg_exp = "/^(http(s?):\/\/)?(www\.)+[a-zA-Z0-9\.\-\_]+(\.[a-zA-Z]{2,3})+(\/[a-zA-Z0-9\_\-\s\.\/\?\%\#\&\=]*)?$/";
        return preg_match($reg_exp, trim($argURL));
    }

    /**
     * function isUniqueCompanyName
     *
     * This function check whether the given company name is unique or not. It returns id if already exist.
     *
     * Database Tables used in this function are : tbl_wholesaler
     *
     * @access public
     *
     * @parameters 2 string
     *
     * @return string $varFileName
     *
     * User instruction: $objBulkUpload->isUniqueCompanyName($argFile)
     */

    function isUniqueCompanyName($argCompanyName) {
        $arrClms = array('count(*) as count');
        $varID = "TRIM(CompanyName)='" . trim($argCompanyName) . "'";
        $varTable = TABLE_WHOLESALER;
        $arrRes = $this->select($varTable, $arrClms, $varID);
        if ($arrRes[0]['count'] > 0) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * function isUniqueCompanyEmail
     *
     * This function check whether the given company email is unique or not. It returns id if already exist.
     *
     * Database Tables used in this function are : tbl_wholesaler
     *
     * @access public
     *
     * @parameters 2 string
     *
     * @return string $varFileName
     *
     * User instruction: $objBulkUpload->isUniqueCompanyEmail($argFile)
     */

    function isUniqueCompanyEmail($argCompanyEmail) {
        $arrClms = array('count(*) as count');
        $varID = "TRIM(CompanyEmail)='" . trim($argCompanyEmail) . "'";
        $varTable = TABLE_WHOLESALER;
        $arrRes = $this->select($varTable, $arrClms, $varID);
        if ($arrRes[0]['count'] > 0) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * function bulkUploadWholesaler
     *
     * This function insert the information into database and return the id of the wholesaler.
     *
     * Database Tables used in this function are : tbl_wholesaler, tbl_wholesaler_to_shipping_gateway
     *
     * @access public
     *
     * @parameters 2 string
     *
     * @return string $varFileName
     *
     * User instruction: $objBulkUpload->bulkUploadWholesaler($argFile)
     */

    function bulkUploadWholesaler($argData, $argShippingMethod) {
        $objTemplate = new EmailTemplate();
        $arrAddID = $this->insert(TABLE_WHOLESALER, $argData);
        $processedShippingMethod = $this->processedWholesalerShippingMethod($argShippingMethod);
        foreach ($processedShippingMethod AS $method) {
            $arrShippingData = array('fkWholesalerID' => $arrAddID, 'fkShippingGatewaysID' => $method);
            $this->insert(TABLE_WHOLESALER_TO_SHIPPING_GATEWAY, $arrShippingData);
        }
        unset($arrData);
        unset($arrShippingData);
        return $arrAddID;
    }

    /**
     * function processWholesalerDataArray
     *
     * This function adding the additional information into wholesaler Data Array.
     *
     * Database Tables used in this function are : none
     *
     * @access public
     *
     * @parameters 2 string
     *
     * @return string $varFileName
     *
     * User instruction: $objBulkUpload->processWholesalerDataArray($argFile)
     */

    function processWholesalerDataArray($arrWholesalerData) {

        //$arrWholesalerData['CompanyPassword'] = md5(trim($arrWholesalerData['CompanyPassword']));
        $arrWholesalerData['WholesalerStatus'] = 'active';
        $arrWholesalerData['WholesalerDateAdded'] = date(DATE_TIME_FORMAT_DB);
        $arrWholesalerData['IsEmailVerified'] = '1';
        return $arrWholesalerData;
    }

    /**
     * function processedWholesalerShippingMethod
     *
     * This function adding the additional information into wholesaler Data Array.
     *
     * Database Tables used in this function are : tbl_shipping_gateways
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $varFileName
     *
     * User instruction: $objBulkUpload->processedWholesalerShippingMethod($argFile)
     */

    function processedWholesalerShippingMethod($arrShippingMethod) {
        $tempArr = array();
        $i = 0;
        foreach ($arrShippingMethod AS $shippingMethod) {
            $arrClms = array('pkShippingGatewaysID');
            $varID = "TRIM(ShippingTitle)='" . trim($shippingMethod) . "'";
            $varTable = TABLE_SHIPPING_GATEWAYS;
            $arrRes = $this->select($varTable, $arrClms, $varID);
            if (!empty($arrRes[0]['pkShippingGatewaysID'])) {
                $tempArr[$i++] = $arrRes[0]['pkShippingGatewaysID'];
            }
        }
        unset($i);
        return $tempArr;
    }

    /**
     * function processedCategoryData
     *
     * This function adding the actual data into category data array to insert into database.
     *
     * Database Tables used in this function are : tbl_category
     *
     * @access public
     *
     * @parameters 2 string
     *
     * @return string $varFileName
     *
     * User instruction: $objBulkUpload->processedCategoryData($argFile)
     */

    function processedCategoryData($categoryDataArray) {
        if (!empty($categoryDataArray['CategoryParentId'])) {
            $arrClms = array('CategoryHierarchy', 'CategoryLevel');
            $varID = "pkCategoryId='" . $categoryDataArray['CategoryParentId'] . "'";
            $varTable = TABLE_CATEGORY;
            $arrRes = $this->select($varTable, $arrClms, $varID);
            $categoryDataArray['CategoryLevel'] = $arrRes[0]['CategoryLevel'] + 1;
            $categoryDataArray['CategoryHierarchy'] = $arrRes[0]['CategoryHierarchy'];
        } else {
            $categoryDataArray['CategoryLevel'] = 0;
        }
        $categoryDataArray['CategoryStatus'] = '1';
        $categoryDataArray['CategoryIsDeleted'] = '0';
        $categoryDataArray['CategoryDateAdded'] = date(DATE_TIME_FORMAT_DB);
        return $categoryDataArray;
    }

    /**
     * function bulkUploadCategory
     *
     * This function inserting the category data into database.
     *
     * Database Tables used in this function are : tbl_category
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $varFileName
     *
     * User instruction: $objBulkUpload->bulkUploadCategory($argFile)
     */

    function bulkUploadCategory($arrCategoryData) {
        $CategoryHierarchy = $arrCategoryData['CategoryHierarchy'];
        $arrAddID = $this->insert(TABLE_CATEGORY, $arrCategoryData);

        if (!empty($CategoryHierarchy)) {
            $CategoryHierarchy .=":" . $arrAddID;
        } else {
            $CategoryHierarchy = $arrAddID;
        }

        $varID = "pkCategoryId='" . $arrAddID . "'";
        $arrAddID = $this->update(TABLE_CATEGORY, array('CategoryHierarchy' => $CategoryHierarchy), $varID);

        unset($arrCategoryData['CategoryHierarchy']);
        unset($CategoryHierarchy);
        return $arrAddID;
    }

    /**
     * function findCustomer
     *
     * This function get the customer id if exist.
     *
     * Database Tables used in this function are : tbl_customer
     *
     * @access public
     *
     * @parameters 2 string
     *
     * @return string $varFileName
     *
     * User instruction: $objBulkUpload->findCustomer($argFile)
     */

    function findCustomer($argCustomerEmail) {
        $arrClms = array('pkCustomerID');
        $varID = "TRIM(CustomerEmail)='" . trim($argCustomerEmail) . "'";
        $varTable = TABLE_CUSTOMER;
        $arrRes = $this->select($varTable, $arrClms, $varID);
        return $arrRes[0]['pkCustomerID'];
    }

    /**
     * function processedCustomerData
     *
     * This function adding the actual data into customer data array to insert into database.
     *
     * Database Tables used in this function are : none
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $varFileName
     *
     * User instruction: $objBulkUpload->processedCustomerData($argFile)
     */

    function processedCustomerData($customerDataArray) {
        $customerDataArray['CustomerDateAdded'] = date(DATE_TIME_FORMAT_DB);
        $customerDataArray['IsEmailVerified'] = '1';
        return $customerDataArray;
    }

    /**
     * function bulkUploadCustomer
     *
     * This function inserting the customer data into database.
     *
     * Database Tables used in this function are : tbl_customer
     *
     * @access public
     *
     * @parameters 2 string
     *
     * @return string $varFileName
     *
     * User instruction: $objBulkUpload->bulkUploadCustomer($argFile)
     */

    function bulkUploadCustomer($arrCustomerData) {
        global $objGeneral;
        $arrAddID = $this->insert(TABLE_CUSTOMER, $arrCustomerData);
        $objGeneral->createReferalId($arrAddID);
        return $arrAddID;
    }

    /**
     * function findPackage
     *
     * This function return the package id of a given package name .
     *
     * Database Tables used in this function are : tbl_package
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $varFileName
     *
     * User instruction: $objBulkUpload->findPackage($argFile)
     */

    function findPackage($argPackageName) {
        $arrClms = array('pkPackageId');
        $varID = "TRIM(PackageName)='" . trim($argPackageName) . "'";
        $varTable = TABLE_PACKAGE;
        $arrRes = $this->select($varTable, $arrClms, $varID);
        return $arrRes[0]['pkPackageId'];
    }

    /**
     * function processedPackageProducts
     *
     * This function get the id of the products by using their reference number and returns a array of product IDs in the package.
     *
     * Database Tables used in this function are : tbl_product
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $varFileName
     *
     * User instruction: $objBulkUpload->processedPackageProducts($argFile)
     */

    function processedPackageProducts($argProductsReferenceNumbers) {
        $arrProductsReferenceNumbers = explode("|", $argProductsReferenceNumbers);
        $tempArr = array();
        $i = 0;
        foreach ($arrProductsReferenceNumbers AS $productsReferenceNumbers) {
            $arrClms = array('pkProductID');
            $varID = "TRIM(ProductRefNo)='" . trim($productsReferenceNumbers) . "'";
            $varTable = TABLE_PRODUCT;
            $arrRes = $this->select($varTable, $arrClms, $varID);
            if (!empty($arrRes[0]['pkProductID'])) {
                $tempArr[$i++] = $arrRes[0]['pkProductID'];
            }
        }
        unset($i);
        return $tempArr;
    }

    /**
     * function processedPackageProducts
     *
     * This function get the package price of the products by using their reference number and returns a array of product IDs in the package.
     *
     * Database Tables used in this function are : tbl_product
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $varFileName
     *
     * User instruction: $objBulkUpload->processedPackageProducts($argFile)
     */

    function processedPackageProductsPrice($argProductsReferenceNumbers) {
        $arrProductsReferenceNumbers = explode(",", $argProductsReferenceNumbers);
        $tempArr = array();
        $i = 0;
        $totalPrice = 0;
        foreach ($arrProductsReferenceNumbers AS $productsReferenceNumbers) {
            $arrClms = array('FinalPrice');
            $varID = "TRIM(ProductRefNo)='" . trim($productsReferenceNumbers) . "'";
            $varTable = TABLE_PRODUCT;
            $arrRes = $this->select($varTable, $arrClms, $varID);
            if (!empty($arrRes[0]['FinalPrice'])) {
                $totalPrice = $totalPrice + $arrRes[0]['FinalPrice'];
            }
        }
        unset($i);
        return $totalPrice;
    }

    /**
     * function processedPackageData
     *
     * This function adding the actual data into package data array to insert into database.
     *
     * Database Tables used in this function are : none
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $varFileName
     *
     * User instruction: $objBulkUpload->processedPackageData($argFile)
     */

    function processedPackageData($packageDataArray) {
        $packageDataArray['PackageDateAdded'] = date(DATE_TIME_FORMAT_DB);
        return $packageDataArray;
    }

    /**
     * function bulkUploadPackage
     *
     * This function insert the package information into database and return the id of the package.
     *
     * Database Tables used in this function are : tbl_package, tbl_product_to_package
     *
     * @access public
     *
     * @parameters 4 string
     *
     * @return string $varFileName
     *
     * User instruction: $objBulkUpload->bulkUploadPackage($argFile)
     */

    function bulkUploadPackage($arrPackageData, $argPackageImage, $arrPackageProduct, $imagePath) {
        $arrAddID = $this->insert(TABLE_PACKAGE, $arrPackageData);
        if (!empty($argPackageImage)) {
            $imageName = $this->processedProductImageName($argPackageImage);
            mkdir(dirname(UPLOADED_FILES_SOURCE_PATH . 'images/package/'), 0777, true);

            if (copy($imagePath . $argPackageImage, UPLOADED_FILES_SOURCE_PATH . 'images/package/' . $imageName)) {// or die('error');
                $this->packageImageUpload($imageName);
                $attrData = array('PackageImage' => $imageName);
                $varId = "pkPackageId = '" . $arrAddID . "'";
                $this->update(TABLE_PACKAGE, $attrData, $varId);
            }
        }
        foreach ($arrPackageProduct AS $product) {
            $attrData = array('fkPackageId' => $arrAddID, 'fkProductId' => $product);
            $this->insert(TABLE_PRODUCT_TO_PACKAGE, $attrData);
        }

        return $arrAddID;
    }

    /**
     * function packageImageUpload
     *
     * This function insert the package image name into database and upload the package image.
     *
     * Database Tables used in this function are : none
     *
     * @access public
     *
     * @parameters 1 string
     *
     * @return string $varFileName
     *
     * User instruction: $objBulkUpload->packageImageUpload($argFile)
     */

    function packageImageUpload($argFile) {
        $objCore = new Core();
        $objUpload = new upload();
        $ImageName = $argFile;
        $varDirLocation = UPLOADED_FILES_SOURCE_PATH . 'images/package/';
        // Set Directory
        $objUpload->setDirectory($varDirLocation);
        // CHECKING FILE TYPE.
        $arrValidImg = array("jpg", "jpeg", "gif", "png");
        $arrExt = explode(".", $ImageName);
        $varIsImage = strtolower(end($arrExt));
        //$objUpload->IsImageValid($varDirLocation.$ImageName);
        if (in_array($varIsImage, $arrValidImg)) {
            $varImageExists = 'yes';
        } else {
            $varImageExists = 'no';
            return;
        }

        if ($varImageExists == 'yes') {

            $objUpload->setFileName($ImageName);
            // Start Copy Process
            $objUpload->startCopy();
            // If there is error write the error message
            // resizing the file
            $objUpload->resize();

            $varFileName = $objUpload->userFileName;

            // Set a thumbnail name
            $thumbnailName1 = PACKAGE_IMAGE_RESIZE1 . '/';
            list($width, $height) = explode('x', PACKAGE_IMAGE_RESIZE1);
            $objUpload->setThumbnailName($thumbnailName1);
            // create thumbnail
            $objUpload->createThumbnail();
            // change thumbnail size
            $objUpload->setThumbnailSize($width, $height);
            //Get file name from the class public variable
            //Get file extention
            $varExt = substr(strrchr($varFileName, "."), 1);
            $varThumbFileNameNoExt = substr($varFileName, 0, -(strlen($varExt) + 1));
            //Create thumb file name
            $varThumbFileName = $varThumbFileNameNoExt . '.' . $varExt;
            return $varFileName;
        }
    }

}

?>
