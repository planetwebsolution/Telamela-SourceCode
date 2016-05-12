--This is added by Deepak for category table on date 16-Mar-2015
CREATE TABLE `tbl_category_update_status` (
`pkCategoryUpdateStatusID` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`CategoryUpdateStatus` ENUM( '0', '1' ) NOT NULL DEFAULT '0' COMMENT '''0:Not updated'',''1:updated''',
`CategoryUpdateStatusDate` DATE NOT NULL
) ENGINE = MYISAM ;
INSERT INTO `tbl_category_update_status` (`pkCategoryUpdateStatusID`, `CategoryUpdateStatus`, `CategoryUpdateStatusDate`) VALUES (NULL, '0', '2015-03-16');

ALTER TABLE `tbl_category_update_status` CHANGE `CategoryUpdateStatus` `CategoryUpdateReadByIphone` ENUM( '0', '1' ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '0' COMMENT '''0:No'',''1:yes''';
ALTER TABLE `tbl_category_update_status` ADD `CategoryUpdateReadByAndroid` ENUM( '0', '1' ) NOT NULL DEFAULT '0' COMMENT '''0:No'',''1:yes''' AFTER `CategoryUpdateReadByIphone` ;
--This is added by Deepak for tbl_gift_card table on date 27-Feb-2015
ALTER TABLE `tbl_gift_card` CHANGE `Amount` `Amount` DECIMAL( 15, 2 ) NOT NULL ,
CHANGE `TotalAmount` `TotalAmount` DECIMAL( 15, 2 ) NOT NULL ,
CHANGE `BalanceAmount` `BalanceAmount` DECIMAL( 15, 2 ) NOT NULL 
--This is added by Deepak for wholesaler template table on date 27-Feb-2015
INSERT INTO `tbl_wholesaler_template` (`pkTemplateId`, `templateName`, `templateDisplayName`, `templateDefault`) VALUES (NULL, 'template11', 'Template 11', '0');

--This is added by Deepak for wholesaler template table on date 19-Feb-2015
ALTER TABLE  `tbl_customer` ADD  `CustomerDob` DATE NOT NULL AFTER  `CustomerEmail`
INSERT INTO `tbl_wholesaler_template` (`pkTemplateId`, `templateName`, `templateDisplayName`, `templateDefault`) VALUES (NULL, 'template10', 'Template 10', '0')
--This is added by Deepak for wholesaler template table on date 16-Feb-2015
INSERT INTO `tbl_wholesaler_template` (`pkTemplateId`, `templateName`, `templateDisplayName`, `templateDefault`) VALUES (NULL, 'template9', 'Template 9', '0');

--This is added by Deepak for wholesaler template table on date 11-Feb-2015
INSERT INTO `tbl_wholesaler_template` (`pkTemplateId`, `templateName`, `templateDisplayName`, `templateDefault`) VALUES (NULL, 'template8', 'Template 8', '0');

--This is added by Deepak for wholesaler template table on date 09-Feb-2015
INSERT INTO `tbl_wholesaler_template` (`pkTemplateId`, `templateName`, `templateDisplayName`, `templateDefault`) VALUES (NULL, 'template7', 'Template 7', '0');

--This is added by Deepak for customer table on date 29-jan-2015
ALTER TABLE  `tbl_customer` ADD  `SameBillAsShip` ENUM(  '0',  '1' ) NOT NULL AFTER  `SameShipping` ;

CREATE TABLE IF NOT EXISTS `tbl_currency_price` (
  `currencyToconvert` varchar(255) NOT NULL,
  `currencyPrice` double NOT NULL,
  `currencyDate` date NOT NULL,
  `currencyTime` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_currency_price`
--

INSERT INTO `tbl_currency_price` (`currencyToconvert`, `currencyPrice`, `currencyDate`, `currencyTime`) VALUES
(' USD to USD ', 1, '2015-01-27', ' 3:23am \r\n'),
(' USD to AED ', 3.6732, '2015-01-27', ' 3:23am \r\n'),
(' USD to ARS ', 8.6262, '2015-01-27', ' 3:23am \r\n'),
(' USD to AUD ', 1.2612, '2015-01-27', ' 3:23am \r\n'),
(' USD to BGN ', 1.7337, '2015-01-27', ' 3:23am \r\n'),
(' USD to BOB ', 6.91, '2015-01-27', ' 3:23am \r\n'),
(' USD to BRL ', 2.5834, '2015-01-27', ' 3:23am \r\n'),
(' USD to CAD ', 1.2479, '2015-01-27', ' 3:23am \r\n'),
(' USD to CHF ', 0.9065, '2015-01-27', ' 3:23am \r\n'),
(' USD to CLP ', 623.595, '2015-01-27', ' 3:23am \r\n'),
(' USD to CNY ', 6.2456, '2015-01-27', ' 3:23am \r\n'),
(' USD to COP ', 2386.5, '2015-01-27', ' 3:23am \r\n'),
(' USD to CZK ', 24.587, '2015-01-27', ' 3:23am \r\n'),
(' USD to DKK ', 6.602, '2015-01-27', ' 3:23am \r\n'),
(' USD to EGP ', 7.4426, '2015-01-27', ' 3:23am \r\n'),
(' USD to EUR ', 0.8865, '2015-01-27', ' 3:24am \r\n'),
(' USD to GBP ', 0.6627, '2015-01-27', ' 3:24am \r\n'),
(' USD to HKD ', 7.7522, '2015-01-27', ' 3:23am \r\n'),
(' USD to HRK ', 6.8217, '2015-01-27', ' 3:23am \r\n'),
(' USD to HUF ', 276.84, '2015-01-27', ' 3:24am \r\n'),
(' USD to IDR ', 12461.4502, '2015-01-27', ' 3:24am \r\n'),
(' USD to ILS ', 3.9911, '2015-01-27', ' 3:24am \r\n'),
(' USD to INR ', 61.405, '2015-01-27', ' 3:24am \r\n'),
(' USD to JPY ', 118.102, '2015-01-27', ' 3:24am \r\n'),
(' USD to KRW ', 1077.65, '2015-01-27', ' 3:24am \r\n'),
(' USD to KWD ', 0.2951, '2015-01-27', ' 3:23am \r\n'),
(' USD to LTL ', 2.934, '2015-01-27', ' 3:23am \r\n'),
(' USD to MAD ', 9.599, '2015-01-27', ' 3:24am \r\n'),
(' USD to MXN ', 14.591, '2015-01-27', ' 3:24am \r\n'),
(' USD to MYR ', 3.6073, '2015-01-27', ' 3:23am \r\n'),
(' USD to NOK ', 7.7816, '2015-01-27', ' 3:24am \r\n'),
(' USD to NZD ', 1.3454, '2015-01-27', ' 3:24am \r\n'),
(' USD to PEN ', 3.026, '2015-01-27', ' 3:23am \r\n'),
(' USD to PHP ', 44.0455, '2015-01-27', ' 3:23am \r\n'),
(' USD to PKR ', 100.92, '2015-01-27', ' 3:23am \r\n'),
(' USD to PLN ', 3.739, '2015-01-27', ' 3:24am \r\n'),
(' USD to RON ', 3.966, '2015-01-27', ' 3:24am \r\n'),
(' USD to RSD ', 109.915, '2015-01-27', ' 3:23am \r\n'),
(' USD to RUB ', 67.9295, '2015-01-27', ' 3:24am \r\n'),
(' USD to SAR ', 3.7585, '2015-01-27', ' 3:23am \r\n'),
(' USD to SEK ', 8.2782, '2015-01-27', ' 3:24am \r\n'),
(' USD to SGD ', 1.3427, '2015-01-27', ' 3:24am \r\n'),
(' USD to THB ', 32.56, '2015-01-27', ' 3:24am \r\n'),
(' USD to TWD ', 31.1655, '2015-01-27', ' 3:23am \r\n'),
(' USD to UAH ', 15.86, '2015-01-27', ' 3:23am \r\n'),
(' USD to VEF ', 6.35, '2015-01-27', ' 3:23am \r\n'),
(' USD to VND ', 21345, '2015-01-27', ' 3:23am \r\n'),
(' USD to ZAR ', 11.463, '2015-01-27', ' 3:24am \r\n');

date 27-01-2015 till


ALTER TABLE `tbl_customer` ADD `CustomerDateUpdated` DATETIME NOT NULL AFTER `CustomerDateAdded` 


ALTER TABLE `tbl_product` ADD `discountPercent` INT( 11 ) NOT NULL AFTER `DiscountFinalPrice` ;

ALTER TABLE `tbl_customer` ADD `SameShipping` ENUM( '0', '1' ) NOT NULL AFTER `BillingPhone` ;


INSERT INTO `tbl_email_templates` (`pkEmailTemplateID`, `EmailTemplateTitle`, `EmailTemplateDisplayTitle`, `EmailTemplateSubject`, `EmailTemplateDescription`, `EmailTemplateStatus`, `EmailTemplateDateAdded`, `EmailTemplateDateModified`) VALUES (NULL, 'packagedeactive', 'Package has  been deactivated', 'Your package has been deactivated', '<table width="700" cellspacing="0" cellpadding="5" border="0">
    <tbody>
      <tr>
        <td width="25">
          <br /></td>
        <td width="600">
          <p><strong>Dear {CUSTOMER}, </strong>
            <br />
            <br />         
            
            <p> Your package has been deactivated because package product quantity are reach till 0.Kindly manage your product quantity.</p> 
            
          
        </p>
         </td>
      </tr>
    </tbody>
  </table>', 'Active', '2015-01-05 00:00:00', '2015-01-05 00:00:00');


UPDATE `tbl_email_templates` SET `EmailTemplateDescription` = '<table width="700" cellspacing="0" cellpadding="5" border="0"> <tbody> <tr> <td width="25"> <br /></td> <td width="600"> <p><strong>Dear {CUSTOMER}, </strong> <br /> <br /> <p> Your package has been deactivated because package product quantity are reach till 0.Kindly manage your product quantity.</p> Package Name:{PACKAGE} </p> </td> </tr> </tbody> </table>' WHERE `tbl_email_templates`.`pkEmailTemplateID` =58;

ALTER TABLE `tbl_attribute_option` ADD `optionColorCode` VARCHAR( 50 ) NOT NULL AFTER `OptionTitle` ;
ALTER TABLE `tbl_product` ADD `ProductColorImage` ENUM( '0', '1' ) NOT NULL DEFAULT '0' COMMENT 'if 1 then product has color full image else no color image' AFTER `ProductImage` ;

last update 10-12-2014

INSERT INTO `choice`.`tbl_category_images` (
`pkCategoryImageId` ,
`fkCategoryId` ,
`categoryName` ,
`categoryImageUrl` ,
`categoryImage` ,
`categoryImageAddDate` ,
`categoryImageUpdateDate`
)
VALUES (
NULL , '3', 'Men''s Apparel', 'http://localhost/telamela/common/uploaded_files/images/category/main_category2/', 'cat_img1.jpg', '2014-11-27 04:12:15', '2014-11-27 01:02:22'
);


--last update 27-11-2014

ALTER TABLE `tbl_cms` ADD `PagePrifix` VARCHAR( 256 ) NOT NULL AFTER `PageDisplayTitle` ;

UPDATE `choice`.`tbl_email_templates` SET `EmailTemplateTitle` = 'Margin Cost has been updated',
`EmailTemplateDisplayTitle` = 'Margin Cost has been updated',
`EmailTemplateSubject` = 'Margin Cost has been updated',
`EmailTemplateDescription` = '<table width="700" cellspacing="0" cellpadding="5" border="0"> <tbody> <tr> <td width="25"> </td> <td style="border-bottom: 1px solid rgb(170, 170, 170);"><strong>Dear {NAME},</strong> <br /> <br /> Margin Cost has been updated on {SITE_NAME}. <br /> Margin Cost:{CATEGORY_NAME} <br /> Please update your offline service. <br /> <br /> </td> </tr> </tbody> </table>' WHERE `tbl_email_templates`.`pkEmailTemplateID` =56;


INSERT INTO `choice`.`tbl_email_templates` (
`pkEmailTemplateID` ,
`EmailTemplateTitle` ,
`EmailTemplateDisplayTitle` ,
`EmailTemplateSubject` ,
`EmailTemplateDescription` ,
`EmailTemplateStatus` ,
`EmailTemplateDateAdded` ,
`EmailTemplateDateModified`
)
VALUES (
NULL , 'Shipping gateway price has been updated', 'Shipping gateway price has been updated', 'Shipping gateway price has been updated', '<table width="700" cellspacing="0" cellpadding="5" border="0"> <tbody> <tr> <td width="25"> </td> <td style="border-bottom: 1px solid rgb(170, 170, 170);"><strong>Dear {NAME},</strong> <br /> <br /> Shipping gateway price has been updated on {SITE_NAME}. <br /> Shipping gateway:{CATEGORY_NAME} <br /> Please update your offline service. <br /> <br /> </td> </tr> </tbody> </table>', 'Active', '2014-11-06 11:06:25', '2014-11-06 11:06:29'
);



INSERT INTO `choice`.`tbl_email_templates` (
`pkEmailTemplateID` ,
`EmailTemplateTitle` ,
`EmailTemplateDisplayTitle` ,
`EmailTemplateSubject` ,
`EmailTemplateDescription` ,
`EmailTemplateStatus` ,
`EmailTemplateDateAdded` ,
`EmailTemplateDateModified`
)
VALUES (
NULL , 'New Shipping gateway price has been added', 'New Shipping gateway price has been added', 'New Shipping gateway price has been added', '<table width="700" cellspacing="0" cellpadding="5" border="0"> <tbody> <tr> <td width="25"> </td> <td style="border-bottom: 1px solid rgb(170, 170, 170);"><strong>Dear {NAME},</strong> <br /> <br /> New Shipping gateway price has been added on {SITE_NAME}. <br /> Shipping gateway:{CATEGORY_NAME} <br /> Please update your offline service. <br /> <br /> </td> </tr> </tbody> </table>', 'Active', '2014-11-06 11:04:31', '2014-11-06 11:04:34'
);



INSERT INTO `choice`.`tbl_email_templates` (
`pkEmailTemplateID` ,
`EmailTemplateTitle` ,
`EmailTemplateDisplayTitle` ,
`EmailTemplateSubject` ,
`EmailTemplateDescription` ,
`EmailTemplateStatus` ,
`EmailTemplateDateAdded` ,
`EmailTemplateDateModified`
)
VALUES (
NULL , 'Shipping gateway has been deleted', 'Shipping gateway has been deleted', 'Shipping gateway has been deleted', '<table width="700" cellspacing="0" cellpadding="5" border="0"> <tbody> <tr> <td width="25"> </td> <td style="border-bottom: 1px solid rgb(170, 170, 170);"><strong>Dear {NAME},</strong> <br /> <br /> Shipping gateway has been deleted on {SITE_NAME}. <br /> Shipping gateway:{CATEGORY_NAME} <br /> Please update your offline service. <br /> <br /> </td> </tr> </tbody> </table>', 'Active', '2014-11-05 16:00:31', '2014-11-05 16:00:35'
);


INSERT INTO `choice`.`tbl_email_templates` (
`pkEmailTemplateID` ,
`EmailTemplateTitle` ,
`EmailTemplateDisplayTitle` ,
`EmailTemplateSubject` ,
`EmailTemplateDescription` ,
`EmailTemplateStatus` ,
`EmailTemplateDateAdded` ,
`EmailTemplateDateModified`
)
VALUES (
NULL , 'Shipping gateway has been updated', 'Shipping gateway has been updated', 'Shipping gateway has been updated', '<table width="700" cellspacing="0" cellpadding="5" border="0"> <tbody> <tr> <td width="25"> </td> <td style="border-bottom: 1px solid rgb(170, 170, 170);"><strong>Dear {NAME},</strong> <br /> <br /> Shipping gateway has been updated on {SITE_NAME}. <br /> Shipping gateway:{CATEGORY_NAME} <br /> Please update your offline service. <br /> <br /> </td> </tr> </tbody> </table>', 'Active', '2014-11-05 15:58:49', '2014-11-05 15:58:53'
);


INSERT INTO `choice`.`tbl_email_templates` (
`pkEmailTemplateID` ,
`EmailTemplateTitle` ,
`EmailTemplateDisplayTitle` ,
`EmailTemplateSubject` ,
`EmailTemplateDescription` ,
`EmailTemplateStatus` ,
`EmailTemplateDateAdded` ,
`EmailTemplateDateModified`
)
VALUES (
NULL , 'New Shipping gateway has been added', 'New Shipping gateway has been added', 'New Shipping gateway has been added', '<table width="700" cellspacing="0" cellpadding="5" border="0"> <tbody> <tr> <td width="25"> </td> <td style="border-bottom: 1px solid rgb(170, 170, 170);"><strong>Dear {NAME},</strong> <br /> <br /> New Shipping gateway has been added on {SITE_NAME}. <br /> Shipping gateway:{CATEGORY_NAME} <br /> Please update your offline service. <br /> <br /> </td> </tr> </tbody> </table>', 'Active', '2014-11-05 15:55:26', ''
);

UPDATE `choice`.`tbl_email_templates` SET `EmailTemplateDateModified` = '2014-11-05 00:00:00' WHERE `tbl_email_templates`.`pkEmailTemplateID` =52;

INSERT INTO `choice`.`tbl_email_templates` (
`pkEmailTemplateID` ,
`EmailTemplateTitle` ,
`EmailTemplateDisplayTitle` ,
`EmailTemplateSubject` ,
`EmailTemplateDescription` ,
`EmailTemplateStatus` ,
`EmailTemplateDateAdded` ,
`EmailTemplateDateModified`
)
VALUES (
NULL , 'Attribute has been deleted', 'Attribute has been deleted', 'Attribute has been deleted', '<table width="700" cellspacing="0" cellpadding="5" border="0"> <tbody> <tr> <td width="25"> </td> <td style="border-bottom: 1px solid rgb(170, 170, 170);"><strong>Dear {NAME},</strong> <br /> <br /> Attribute has been deleted on {SITE_NAME}. <br /> Attribute:{CATEGORY_NAME} <br /> Please update your offline service. <br /> <br /> </td> </tr> </tbody> </table>', 'Active', '2014-11-05 14:52:58', '2014-11-05 14:53:02'
);

INSERT INTO `choice`.`tbl_email_templates` (
`pkEmailTemplateID` ,
`EmailTemplateTitle` ,
`EmailTemplateDisplayTitle` ,
`EmailTemplateSubject` ,
`EmailTemplateDescription` ,
`EmailTemplateStatus` ,
`EmailTemplateDateAdded` ,
`EmailTemplateDateModified`
)
VALUES (
NULL , 'Attribute has been updated', 'Attribute has been updated', 'Attribute has been updated', '<table width="700" cellspacing="0" cellpadding="5" border="0"> <tbody> <tr> <td width="25"> </td> <td style="border-bottom: 1px solid rgb(170, 170, 170);"><strong>Dear {NAME},</strong> <br /> <br /> Attribute has been updated on {SITE_NAME}. <br /> Attribute:{CATEGORY_NAME} <br /> Please update your offline service. <br /> <br /> </td> </tr> </tbody> </table>', 'Active', '2014-11-05 14:43:13', '2014-11-05 14:43:17'
);

INSERT INTO `choice`.`tbl_email_templates` (
`pkEmailTemplateID` ,
`EmailTemplateTitle` ,
`EmailTemplateDisplayTitle` ,
`EmailTemplateSubject` ,
`EmailTemplateDescription` ,
`EmailTemplateStatus` ,
`EmailTemplateDateAdded` ,
`EmailTemplateDateModified`
)
VALUES (
NULL , 'New Attribute has been added', 'New Attribute has been added', 'New Attribute has been added', '<table width="700" cellspacing="0" cellpadding="5" border="0"> <tbody> <tr> <td width="25"> </td> <td style="border-bottom: 1px solid rgb(170, 170, 170);"><strong>Dear {NAME},</strong> <br /> <br /> New attribute has been added on {SITE_NAME}. <br /> Attribute:{CATEGORY_NAME} <br /> Please update your offline service. <br /> <br /> </td> </tr> </tbody> </table>', 'Active', '2014-11-05 14:40:47', '2014-11-05 14:40:51'
);

INSERT INTO `choice`.`tbl_email_templates` (
`pkEmailTemplateID` ,
`EmailTemplateTitle` ,
`EmailTemplateDisplayTitle` ,
`EmailTemplateSubject` ,
`EmailTemplateDescription` ,
`EmailTemplateStatus` ,
`EmailTemplateDateAdded` ,
`EmailTemplateDateModified`
)
VALUES (
NULL , 'Category has been moved from trash to main', 'Category has been moved from trash to main', 'Category has been moved from trash to main', '<table width="700" cellspacing="0" cellpadding="5" border="0"> <tbody> <tr> <td width="25"> </td> <td style="border-bottom: 1px solid rgb(170, 170, 170);"><strong>Dear {NAME},</strong> <br /> <br /> Category has been moved from trash to main on {SITE_NAME}. <br /> Category:{CATEGORY_NAME} <br /> Please update your offline service. <br /> <br /> </td> </tr> </tbody> </table>', 'Active', '2014-11-05 12:00:27', '2014-11-05 12:00:30'
);

INSERT INTO `choice`.`tbl_email_templates` (
`pkEmailTemplateID` ,
`EmailTemplateTitle` ,
`EmailTemplateDisplayTitle` ,
`EmailTemplateSubject` ,
`EmailTemplateDescription` ,
`EmailTemplateStatus` ,
`EmailTemplateDateAdded` ,
`EmailTemplateDateModified`
)
VALUES (
NULL , 'Category has been moved to trash', 'Category has been moved to trash', 'Category has been moved to trash', '<table width="700" cellspacing="0" cellpadding="5" border="0"> <tbody> <tr> <td width="25"> </td> <td style="border-bottom: 1px solid rgb(170, 170, 170);"><strong>Dear {NAME},</strong> <br /> <br /> Category has been moved to trash on {SITE_NAME}. <br /> Category:{CATEGORY_NAME} <br /> Please update your offline service. <br /> <br /> </td> </tr> </tbody> </table>', 'Active', '2014-11-05 10:43:49', '2014-11-05 10:43:53'
);


INSERT INTO `tbl_email_templates` (
`pkEmailTemplateID` ,
`EmailTemplateTitle` ,
`EmailTemplateDisplayTitle` ,
`EmailTemplateSubject` ,
`EmailTemplateDescription` ,
`EmailTemplateStatus` ,
`EmailTemplateDateAdded` ,
`EmailTemplateDateModified`
)
VALUES (
NULL , 'New category has been added.', 'New category added', 'New category has been added.', '<table width="700" cellspacing="0" cellpadding="5" border="0"> <tbody> <tr> <td width="25"> </td> <td style="border-bottom: 1px solid rgb(170, 170, 170);"><strong>Dear {NAME},</strong> <br /> <br /> New category has been added on {SITE_NAME}. <br /> <br /> Please update your offline service: <br /> <br /> </td> </tr> </tbody> </table>', 'Active', '2014-11-03 17:31:08', '2014-11-03 17:31:15'
);

UPDATE `tbl_email_templates` SET `EmailTemplateTitle` = 'New category has been added' WHERE `tbl_email_templates`.`pkEmailTemplateID` =45;

UPDATE `tbl_email_templates` SET `EmailTemplateDescription` = '<table width="700" cellspacing="0" cellpadding="5" border="0"> <tbody> <tr> <td width="25"> </td> <td style="border-bottom: 1px solid rgb(170, 170, 170);"><strong>Dear {NAME},</strong> <br /> <br /> New category has been added on {SITE_NAME}. <br /> Category:{CATEGORY_NAME} <br /> Please update your offline service: <br /> <br /> </td> </tr> </tbody> </table>' WHERE `tbl_email_templates`.`pkEmailTemplateID` =45;

UPDATE `tbl_email_templates` SET `EmailTemplateDescription` = '<table width="700" cellspacing="0" cellpadding="5" border="0"> <tbody> <tr> <td width="25"> </td> <td style="border-bottom: 1px solid rgb(170, 170, 170);"><strong>Dear {NAME},</strong> <br /> <br /> New category has been added on {SITE_NAME}. <br /> Category:{CATEGORY_NAME} <br /> Please update your offline service. <br /> <br /> </td> </tr> </tbody> </table>' WHERE `tbl_email_templates`.`pkEmailTemplateID` =45;


INSERT INTO `tbl_email_templates` (
`pkEmailTemplateID` ,
`EmailTemplateTitle` ,
`EmailTemplateDisplayTitle` ,
`EmailTemplateSubject` ,
`EmailTemplateDescription` ,
`EmailTemplateStatus` ,
`EmailTemplateDateAdded` ,
`EmailTemplateDateModified`
)
VALUES (
NULL , 'Category has been updated', 'Category has been updated', 'Category has been updated', '<table width="700" cellspacing="0" cellpadding="5" border="0"> <tbody> <tr> <td width="25"> </td> <td style="border-bottom: 1px solid rgb(170, 170, 170);"><strong>Dear {NAME},</strong> <br /> <br /> Category has been updated on {SITE_NAME}. <br /> Category:{CATEGORY_NAME} <br /> Please update your offline service. <br /> <br /> </td> </tr> </tbody> </table>', 'Active', '2014-11-04 18:35:52', '2014-11-04 18:35:56'
);


CREATE TABLE `updateCategoryAttrShipping` (
`id` INT( 11 ) NOT NULL ,
`action` ENUM( 'add', 'edit', 'delete' ) NOT NULL ,
`type` ENUM( 'category', 'attribute', 'shipping' ) NOT NULL
) ENGINE = MYISAM ;

ALTER TABLE `updateCategoryAttrShipping` ADD `name` VARCHAR( 256 ) NOT NULL AFTER `id` 
ALTER TABLE `updateCategoryAttrShipping` CHANGE `type` `type` ENUM( 'category', 'attribute', 'shipping', 'shippingcost' ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL 


date 3-11-2014 update



ALTER TABLE `tbl_product_rating` ADD `productReview` ENUM( '0', '1' ) NOT NULL DEFAULT '0' AFTER `Rating`;

ALTER TABLE `tbl_wholesaler_feedback` ADD `feedbackUpdate` ENUM( '0', '1' ) NOT NULL DEFAULT '0' AFTER `IsPositive` 
ALTER TABLE `tbl_support` ADD `DeletedBy` INT( 11 ) NOT NULL DEFAULT '0' COMMENT 'If column is not equel to 0 then delete row' AFTER `IsRead`
ALTER TABLE `tbl_review` ADD `ReviewWholesaler` ENUM( '0', '1' ) NOT NULL DEFAULT '0' AFTER `ApprovedStatus` 

------------------------15/09/14-----------------------
INSERT INTO `choice`.`tbl_wholesaler_template` (`pkTemplateId`, `templateName`, `templateDisplayName`, `templateDefault`) VALUES (NULL, 'template6', 'Template 6', '0');
INSERT INTO `choice`.`tbl_wholesaler_template` (`pkTemplateId`, `templateName`, `templateDisplayName`, `templateDefault`) VALUES (NULL, 'template4', 'Template 4', '0'), (NULL, 'template5', 'Template 5', '0');
------------------------15/09/14-----------------------
------------------------11/09/14-----------------------
ALTER TABLE `tbl_customer` ADD `BillingTown` VARCHAR( 50 ) NOT NULL AFTER `ShippingCountry`;
ALTER TABLE `tbl_customer` ADD `ShippingTown` VARCHAR( 50 ) NOT NULL AFTER `ShippingCountry`;
ALTER TABLE `tbl_customer` ADD `ResAddressLine1` VARCHAR( 255 ) NOT NULL AFTER `LastLogin`;
ALTER TABLE `tbl_customer` ADD `ResAddressLine2` VARCHAR( 256 ) NOT NULL AFTER `ResAddressLine1`;
ALTER TABLE `tbl_customer` ADD `ResPostalCode` VARCHAR( 8 ) NOT NULL AFTER `ResAddressLine2`;
ALTER TABLE `tbl_customer` ADD `ResCountry` INT( 11 ) NOT NULL AFTER `ResPostalCode`;    
ALTER TABLE `tbl_customer` ADD `ResTown` VARCHAR( 256 ) NOT NULL AFTER `ResCountry`;
ALTER TABLE `tbl_customer` ADD `ResPhone` VARCHAR( 256 ) NOT NULL AFTER `ResTown`;  
------------------------11/09/14-----------------------

ALTER TABLE `tbl_cart` ADD `CartReminderDate` DATETIME NOT NULL COMMENT 'Cart reminder date' AFTER `CartData`;


-----------------------------------------------
/* 6 march */   by kuldeep sharma   	//--------------- updated on iworklab  ---------------//
-----------------------------------------------
CREATE TABLE IF NOT EXISTS `advertisement` (
  `pkAddID` int(11) NOT NULL AUTO_INCREMENT,
  `addImage` varchar(225) NOT NULL,
  `addLink` varchar(225) NOT NULL,
  PRIMARY KEY (`pkAddID`)
);

INSERT INTO `advertisement` (`pkAddID`, `addImage`, `addLink`) VALUES
(1, '', 'google.com');


CREATE TABLE IF NOT EXISTS `office_video` (
  `pkOfficeVideoID` int(11) NOT NULL AUTO_INCREMENT,
  `officeVideoURL` varchar(1000) NOT NULL,
  `officeVideoLink` varchar(225) NOT NULL,
  PRIMARY KEY (`pkOfficeVideoID`)
);

INSERT INTO `office_video` (`pkOfficeVideoID`, `officeVideoURL`, `officeVideoLink`) VALUES
(1, 'google', 'google');

CREATE TABLE IF NOT EXISTS `terms_condition` (
  `pkTermsConditionID` int(11) NOT NULL AUTO_INCREMENT,
  `termsConditionDisplayTitle` varchar(225) NOT NULL,
  `termsConditionTitle` varchar(225) NOT NULL,
  `termsConditionContent` longtext NOT NULL,
  `termsConditionKeyword` text NOT NULL,
  `termsConditionDescription` text NOT NULL,
  `termsConditionDateUpdated` datetime NOT NULL,
  PRIMARY KEY (`pkTermsConditionID`)
);

INSERT INTO `terms_condition` (`pkTermsConditionID`, `termsConditionDisplayTitle`, `termsConditionTitle`, `termsConditionContent`, `termsConditionKeyword`, `termsConditionDescription`, `termsConditionDateUpdated`) VALUES
(1, 'Terms & Condition', 'Terms & Condition', '<p><span style="font-family: &quot;Lucida Grande&quot;,&quot;Lucida Sans Unicode&quot;,&quot;Lucida Sans&quot;,Geneva,Verdana,sans-serif;"><span style="font-size: x-small;">Terms &amp; Condition Terms &amp; Condition Terms &amp; Condition Terms &amp; ConditionTerms &amp; Condition Terms &amp; Condition  Terms &amp; Condition Terms &amp; </span></span></p>\r\n<p><span style="font-family: &quot;Lucida Grande&quot;,&quot;Lucida Sans Unicode&quot;,&quot;Lucida Sans&quot;,Geneva,Verdana,sans-serif;"><span style="font-size: x-small;">Terms &amp; Condition Terms &amp; Condition Terms &amp; Condition Terms  &amp; ConditionTerms &amp; Condition Terms &amp; Condition  Terms &amp;  Condition Terms &amp; Condition Terms &amp; Condition Terms &amp;  Condition Terms &amp; Condition</span></span></p>\r\n<p><span style="font-family: &quot;Lucida Grande&quot;,&quot;Lucida Sans Unicode&quot;,&quot;Lucida Sans&quot;,Geneva,Verdana,sans-serif;"><span style="font-size: x-small;">Terms &amp; Condition Terms &amp; Condition Terms &amp; Condition Terms  &amp; ConditionTerms &amp; Condition Terms &amp; Condition  Terms &amp;  Condition Terms &amp; Condition Terms &amp; Condition Terms &amp;  Condition Terms &amp; Condition</span></span></p>\r\n<p><span style="font-family: &quot;Lucida Grande&quot;,&quot;Lucida Sans Unicode&quot;,&quot;Lucida Sans&quot;,Geneva,Verdana,sans-serif;"><span style="font-size: x-small;">Terms &amp; Condition Terms &amp; Condition Terms &amp; Condition Terms  &amp; ConditionTerms &amp; Condition Terms &amp; Condition  Terms &amp;  Condition Terms &amp; Condition Terms &amp; Condition Terms &amp;  Condition Terms &amp; ConditionCondition Terms &amp; Condition Terms &amp; Condition Terms &amp; Condition</span></span></p>\r\n<p>&nbsp;</p>', 'Terms & ConditionTerms & Condition', 'Terms & ConditionTerms & Condition', '2013-03-08 17:45:05');


CREATE TABLE IF NOT EXISTS `privacy_policy` (
  `pkPrivacyPolicyID` int(11) NOT NULL AUTO_INCREMENT,
  `privacyPolicyDisplayTitle` varchar(225) NOT NULL,
  `privacyPolicyTitle` varchar(225) NOT NULL,
  `privacyPolicyContent` longtext NOT NULL,
  `privacyPolicyKeyword` text NOT NULL,
  `privacyPolicyDescription` text NOT NULL,
  `privacyPolicyDateUpdated` datetime NOT NULL,
  PRIMARY KEY (`pkPrivacyPolicyID`)
);

INSERT INTO `privacy_policy` (`pkPrivacyPolicyID`, `privacyPolicyDisplayTitle`, `privacyPolicyTitle`, `privacyPolicyContent`, `privacyPolicyKeyword`, `privacyPolicyDescription`, `privacyPolicyDateUpdated`) VALUES
(1, 'Privacy Policy', 'Privacy Policy', '<p><span style="font-size: x-small;"><span style="font-family: &quot;Lucida Grande&quot;,&quot;Lucida Sans Unicode&quot;,&quot;Lucida Sans&quot;,Geneva,Verdana,sans-serif;">Privacy PolicyPrivacy PolicyPrivacy PolicyPrivacy PolicyPrivacy PolicyPrivacy PolicyPrivacy PolicyPrivacy Policy v Privacy PolicyPrivacy PolicyPrivacy PolicyPrivacy PolicyPrivacy PolicyPrivacy PolicyPrivacy PolicyPrivacy Policy Privacy PolicyPrivacy PolicyPrivacy PolicyPrivacy PolicyPrivacy PolicyPrivacy PolicyPrivacy PolicyPrivacy Policy Privacy PolicyPrivacy PolicyPrivacy PolicyPrivacy PolicyPrivacy PolicyPrivacy PolicyPrivacy PolicyPrivacy Policy Privacy PolicyPrivacy PolicyPrivacy PolicyPrivacy PolicyPrivacy PolicyPrivacy PolicyPrivacy PolicyPrivacy Policy</span></span></p>\r\n<p><span style="font-size: x-small;"><span style="font-family: &quot;Lucida Grande&quot;,&quot;Lucida Sans Unicode&quot;,&quot;Lucida Sans&quot;,Geneva,Verdana,sans-serif;">Privacy PolicyPrivacy PolicyPrivacy PolicyPrivacy PolicyPrivacy PolicyPrivacy PolicyPrivacy PolicyPrivacy Policy</span></span></p>\r\n<p><span style="font-size: x-small;"><span style="font-family: &quot;Lucida Grande&quot;,&quot;Lucida Sans Unicode&quot;,&quot;Lucida Sans&quot;,Geneva,Verdana,sans-serif;">Privacy PolicyPrivacy PolicyPrivacy PolicyPrivacy PolicyPrivacy PolicyPrivacy PolicyPrivacy PolicyPrivacy Policy Privacy PolicyPrivacy PolicyPrivacy PolicyPrivacy PolicyPrivacy PolicyPrivacy PolicyPrivacy PolicyPrivacy Policy Privacy PolicyPrivacy PolicyPrivacy PolicyPrivacy PolicyPrivacy PolicyPrivacy PolicyPrivacy PolicyPrivacy Policy Privacy PolicyPrivacy PolicyPrivacy PolicyPrivacy PolicyPrivacy PolicyPrivacy PolicyPrivacy PolicyPrivacy Policy Privacy PolicyPrivacy PolicyPrivacy PolicyPrivacy PolicyPrivacy PolicyPrivacy PolicyPrivacy PolicyPrivacy Policy Privacy PolicyPrivacy PolicyPrivacy PolicyPrivacy PolicyPrivacy PolicyPrivacy PolicyPrivacy PolicyPrivacy Policy Privacy PolicyPrivacy PolicyPrivacy PolicyPrivacy PolicyPrivacy PolicyPrivacy PolicyPrivacy PolicyPrivacy Policy</span></span></p>', 'Privacy Policy', 'Privacy Policy', '2013-03-08 17:42:16');


-----------------------------------------------
/* 5 march */   by kuldeep sharma   //--------------- updated on iworklab  ---------------//
-----------------------------------------------
CREATE TABLE IF NOT EXISTS `main_management_team` (
  `pkMainManagementTeamID` int(11) NOT NULL AUTO_INCREMENT,
  `mainManagementTeamName` varchar(225) NOT NULL,
  `mainManagementTeamDesignation` varchar(225) NOT NULL,
  `mainManagementTeamDescription` text NOT NULL,
  `mainManagementTeamImage` varchar(225) NOT NULL,
  PRIMARY KEY (`pkMainManagementTeamID`)
);

CREATE TABLE IF NOT EXISTS `new_office` (
  `pkNewOfficeID` int(11) NOT NULL AUTO_INCREMENT,
  `newOfficeCity` varchar(200) NOT NULL,
  `newOfficeDescription` text NOT NULL,
  `newOfficeLink` varchar(225) NOT NULL,
  `newOfficeDateUpdated` datetime NOT NULL,
  PRIMARY KEY (`pkNewOfficeID`)
);


INSERT INTO `new_office` (`pkNewOfficeID`, `newOfficeCity`, `newOfficeDescription`, `newOfficeLink`, `newOfficeDateUpdated`) VALUES
(1, 'Lagos', '', '', '0000-00-00 00:00:00'),
(2, 'Accra', '', '', '0000-00-00 00:00:00'),
(3, 'London', '', '', '0000-00-00 00:00:00'),
(4, 'Nairobi', '', '', '0000-00-00 00:00:00'),
(5, 'New York', '', '', '0000-00-00 00:00:00'),
(6, 'Johannesburg', '', '', '0000-00-00 00:00:00'),
(7, 'Kampala', '', '', '0000-00-00 00:00:00');

CREATE TABLE IF NOT EXISTS `new_office_images` (
  `pkNewOfficeImageID` int(11) NOT NULL AUTO_INCREMENT,
  `fkNewOfficeID` int(11) NOT NULL,
  `newOfficeImage` varchar(225) NOT NULL,
  PRIMARY KEY (`pkNewOfficeImageID`)
);


-----------------------------------------------
/* 4 march */   by kuldeep sharma    //--------------- updated on iworklab  ---------------//
-----------------------------------------------
CREATE TABLE IF NOT EXISTS `main_board_director` (
  `pkMainBoardDirectorID` int(11) NOT NULL AUTO_INCREMENT,
  `mainBoardDirectorName` varchar(225) NOT NULL,
  `mainBoardDirectorDesignation` varchar(225) NOT NULL,
  `mainBoardDirectorDescription` text NOT NULL,
  `mainBoardDirectorImage` varchar(225) NOT NULL,
  PRIMARY KEY (`pkMainBoardDirectorID`)
);


-----------------------------------------------
/* 28 feb */   by kuldeep sharma		//--------------- updated on iworklab  ---------------//
-----------------------------------------------
CREATE TABLE `why_landmark` (
`pkWhyLandmarkID` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`whyLandmarkText` TEXT NOT NULL ,
`whyLandmarkManage` VARCHAR( 225 ) NOT NULL
);


CREATE TABLE IF NOT EXISTS `home_main_introduction_cms` (
  `pkHomeMainIntroduction` int(11) NOT NULL AUTO_INCREMENT,
  `homeMainIntroductionCms` text NOT NULL,
  PRIMARY KEY (`pkHomeMainIntroduction`)
) ;


INSERT INTO `home_main_introduction_cms` (`pkHomeMainIntroduction`, `homeMainIntroductionCms`) VALUES
(1, '');

ALTER TABLE `Testimonials` ADD `pkSiteNameID` INT( 11 ) NOT NULL AFTER `testId`;



+}++++++++++++++++++++++++++++++++++++++++++++++++++
22feb		//--------------- updated on iworklab  ---------------//
+}++++++++++++++++++++++++++++++++++++++++++++++++++

INSERT INTO `home_main_book_cms_images` (
`home_main_book_cms_imags_id` ,
`fk_home_main_book_cms_id` ,
`page_name` ,
`text` ,
`image_1` ,
`image_2` ,
`image_3` ,
`image_4`
)

UPDATE `landmark`.`home_main_book_cms` SET `page_name` = 'Home page' WHERE `home_main_book_cms`.`home_main_book_cms_id` =9;


INSERT INTO `landmark`.`home_main_book_cms` (
`home_main_book_cms_id` ,
`page_name` ,
`author` ,
`date_updated`
)
VALUES (
NULL , 'Home_page', 'SuperAdmin', '2013-02-22 10:54:31'
);


+++++++++++++++++++++++++++++++++++++++++++
21 feb  raju khatak			 //--------------- updated on iworklab  ---------------//
+++++++++++++++++++++++++++++++++++++++++++++

CREATE TABLE `subscribe` (
`subscribe_id` INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`subscribe_email` VARCHAR( 255 ) NOT NULL ,
`site_for_subscribe` VARCHAR( 255 ) NOT NULL ,
`subscribe_addDate` DATETIME NOT NULL
) ENGINE = MYISAM ;

________________________________
20 feb           //--------------- updated on iworklab  ---------------//
___________________________________________

ALTER TABLE `venues` ADD `title` VARCHAR( 255 ) NOT NULL AFTER `VenueType` 

_________________________________________________

-----------------------------------------------
/* 19 feb */   by kuldeep sharma
-----------------------------------------------
CREATE TABLE IF NOT EXISTS `home_office_images` (
  `pkHomeOfficeImageID` int(11) NOT NULL AUTO_INCREMENT,
  `homeOfficeImage` varchar(225) NOT NULL,
  `homeOfficeImageTitle` varchar(150) NOT NULL,
  `homeOfficeImageText` varchar(225) NOT NULL,
  PRIMARY KEY (`pkHomeOfficeImageID`)
);


INSERT INTO `home_office_images` (`pkHomeOfficeImageID`, `homeOfficeImage`, `homeOfficeImageTitle`, `homeOfficeImageText`) VALUES
(1, '', 'Landmark Towers', 'Landmark Towers Landmark Towers Landmark Towers'),
(2, '', 'Landmark Towers231', 'Landmark Towers Landmark Towers Landmark Towers'),
(3, '', 'Landmark Towers22', 'Landmark Towers Landmark Towers Landmark Towers'),
(4, '', 'Landmark Towers33', 'Landmark Towers Landmark Towers Landmark Towers');


CREATE TABLE IF NOT EXISTS `office_cms_category` (
  `pkOfficeCmsCategoryID` int(11) NOT NULL AUTO_INCREMENT,
  `officeCmsCategoryName` text NOT NULL,
  `fkAdminID` int(11) NOT NULL,
  `adminName` varchar(225) NOT NULL,
  `dateUpdated` datetime NOT NULL,
  `pageTitle` text NOT NULL,
  `pageContent` longtext NOT NULL,
  `pageKeywords` longtext NOT NULL,
  `pageDescription` longtext NOT NULL,
  PRIMARY KEY (`pkOfficeCmsCategoryID`)
);


INSERT INTO `office_cms_category` (`pkOfficeCmsCategoryID`, `officeCmsCategoryName`, `fkAdminID`, `adminName`, `dateUpdated`, `pageTitle`, `pageContent`, `pageKeywords`, `pageDescription`) VALUES
(1, 'Home', 1, 'SuperAdmin', '0000-00-00 00:00:00', '', '', '', ''),
(2, 'Our Profile', 1, 'SuperAdmin', '0000-00-00 00:00:00', '', '', '', ''),
(3, 'Products & Services', 1, 'SuperAdmin', '0000-00-00 00:00:00', '', '', '', ''),
(4, 'News & Events', 1, 'SuperAdmin', '0000-00-00 00:00:00', '', '', '', ''),
(5, 'Contact Us', 1, 'SuperAdmin', '0000-00-00 00:00:00', '', '', '', '');


CREATE TABLE IF NOT EXISTS `office_cms_sub_category` (
  `pkOfficeCmsSubCategoryID` int(11) NOT NULL AUTO_INCREMENT,
  `fkOfficeCmsCategoryID` int(11) NOT NULL,
  `fkCmsStatusID` int(11) NOT NULL,
  `officeSubCategoryName` text NOT NULL,
  `officeSubCategoryParentID` varchar(225) NOT NULL,
  `officeSubCategoryParentName` varchar(225) NOT NULL,
  `officeSubCategoryPathID` varchar(225) NOT NULL,
  `officeSubCategoryPathName` varchar(225) NOT NULL,
  `officeSubCategoryDateAdded` datetime NOT NULL,
  `officeSubCategoryDateUpdated` datetime NOT NULL,
  `fkAdminID` int(11) NOT NULL,
  `adminName` varchar(225) NOT NULL,
  `officeSubCategoryRejectedByAdminID` int(11) NOT NULL,
  `officeSubCategoryRejectedByAdminName` varchar(225) NOT NULL,
  `officeSubCategoryDisplayOrder` int(11) NOT NULL,
  `officeSubCategoryStatusUpdateDate` datetime NOT NULL,
  PRIMARY KEY (`pkOfficeCmsSubCategoryID`)
);

CREATE TABLE IF NOT EXISTS `office_cms` (
  `pkOfficePageID` int(11) NOT NULL AUTO_INCREMENT,
  `fkOfficeCmsSubCategoryID` int(11) NOT NULL,
  `pkAdminID` int(11) NOT NULL,
  `adminName` varchar(225) NOT NULL,
  `officePageName` varchar(250) NOT NULL,
  `officePageTitle` text NOT NULL,
  `officePageDisplayTitle` varchar(255) NOT NULL,
  `officePageContent` longtext NOT NULL,
  `officePageStatus` enum('Wating','Approve','Review','Publish','Reject') NOT NULL DEFAULT 'Publish',
  `officePageRejectContent` longtext NOT NULL,
  `officePageKeywords` longtext NOT NULL,
  `officePageDescription` longtext NOT NULL,
  `officePageDateAdded` datetime NOT NULL,
  `officePageDateModified` datetime NOT NULL,
  `fkCmsStatusID` int(11) NOT NULL,
  `officeSubCategoryRejectedByAdminID` int(11) NOT NULL,
  `officeSubCategoryRejectedByAdminName` varchar(225) NOT NULL,
  `officeCmsStatusUpdateDate` datetime NOT NULL,
  PRIMARY KEY (`pkOfficePageID`)
);

CREATE TABLE IF NOT EXISTS `office_address` (
  `pkOfficeAddressID` int(11) NOT NULL AUTO_INCREMENT,
  `officeAddressCity` varchar(225) NOT NULL,
  `officeAddress` text NOT NULL,
  `officeAddressDescription` text NOT NULL,
  `officeAddressLink` varchar(225) NOT NULL,
  `officeAddressImage` varchar(225) NOT NULL,
  `officeAddressDateUpdated` datetime NOT NULL,
  PRIMARY KEY (`pkOfficeAddressID`)
);

INSERT INTO `office_address` (`pkOfficeAddressID`, `officeAddressCity`, `officeAddress`, `officeAddressDescription`, `officeAddressLink`, `officeAddressImage`, `officeAddressDateUpdated`) VALUES
(1, 'Lagos', '', '', '', '', '0000-00-00 00:00:00'),
(2, 'Accra', '', '', '', '', '0000-00-00 00:00:00'),
(3, 'London', '', '', '', '', '0000-00-00 00:00:00'),
(4, 'Nairobi', '', '', '', '', '0000-00-00 00:00:00'),
(5, 'New York', '', '', '', '', '0000-00-00 00:00:00'),
(6, 'Johannesburg', '', '', '', '', '0000-00-00 00:00:00'),
(7, 'Kampala', '', '', '', '', '0000-00-00 00:00:00');

-----------------------------------------------
/* 17 feb */   by kuldeep sharma
-----------------------------------------------

CREATE TABLE IF NOT EXISTS `property_cms_category` (
  `pkPropertyCmsCategoryID` int(11) NOT NULL AUTO_INCREMENT,
  `propertyCmsCategoryName` text NOT NULL,
  `fkAdminID` int(11) NOT NULL,
  `adminName` varchar(225) NOT NULL,
  `dateUpdated` datetime NOT NULL,
  `pageTitle` text NOT NULL,
  `pageContent` longtext NOT NULL,
  `pageKeywords` longtext NOT NULL,
  `pageDescription` longtext NOT NULL,
  PRIMARY KEY (`pkPropertyCmsCategoryID`)
);

INSERT INTO `property_cms_category` (`pkPropertyCmsCategoryID`, `propertyCmsCategoryName`, `fkAdminID`, `adminName`, `dateUpdated`, `pageTitle`, `pageContent`, `pageKeywords`, `pageDescription`) VALUES
(1, 'Home', 1, 'SuperAdmin', '0000-00-00 00:00:00', '', '', '', ''),
(2, 'Our Profile', 1, 'SuperAdmin', '0000-00-00 00:00:00', '', '', '', ''),
(3, 'Products & Services', 1, 'SuperAdmin', '0000-00-00 00:00:00', '', '', '', ''),
(4, 'News & Media', 1, 'SuperAdmin', '0000-00-00 00:00:00', '', '', '', ''),
(5, 'Contact Us', 1, 'SuperAdmin', '0000-00-00 00:00:00', '', '', '', ''),
(6, 'On Site', 1, 'SuperAdmin', '0000-00-00 00:00:00', '', '', '', ''),
(7, 'Careers', 1, 'SuperAdmin', '0000-00-00 00:00:00', '', '', '', '');

CREATE TABLE `home_property_images` (
`pkHomePropertyImageID` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`homePropertyImage` VARCHAR( 225 ) NOT NULL ,
`homePropertyImageTitle` VARCHAR( 150 ) NOT NULL ,
`homePropertyImageText` VARCHAR( 225 ) NOT NULL
);

INSERT INTO `home_property_images` (
`pkHomePropertyImageID` ,
`homePropertyImage` ,
`homePropertyImageTitle` ,
`homePropertyImageText`
)
VALUES (
NULL , '', 'Landmark Towers', 'Landmark Towers Landmark Towers Landmark Towers'
), (
NULL , '', 'Landmark Towers', 'Landmark Towers Landmark Towers Landmark Towers'
), (
NULL , '', 'Landmark Towers', 'Landmark Towers Landmark Towers Landmark Towers'
), (
NULL , '', 'Landmark Towers', 'Landmark Towers Landmark Towers Landmark Towers'
);

CREATE TABLE IF NOT EXISTS `property_cms_sub_category` (
  `pkPropertyCmsSubCategoryID` int(11) NOT NULL AUTO_INCREMENT,
  `fkPropertyCmsCategoryID` int(11) NOT NULL,
  `fkCmsStatusID` int(11) NOT NULL,
  `propertySubCategoryName` text NOT NULL,
  `propertySubCategoryParentID` varchar(225) NOT NULL,
  `propertySubCategoryParentName` varchar(225) NOT NULL,
  `propertySubCategoryPathID` varchar(225) NOT NULL,
  `propertySubCategoryPathName` varchar(225) NOT NULL,
  `propertySubCategoryDateAdded` datetime NOT NULL,
  `propertySubCategoryDateUpdated` datetime NOT NULL,
  `fkAdminID` int(11) NOT NULL,
  `adminName` varchar(225) NOT NULL,
  `propertySubCategoryRejectedByAdminID` int(11) NOT NULL,
  `propertySubCategoryRejectedByAdminName` varchar(225) NOT NULL,
  `propertySubCategoryDisplayOrder` int(11) NOT NULL,
  `propertySubCategoryStatusUpdateDate` datetime NOT NULL,
  PRIMARY KEY (`pkPropertyCmsSubCategoryID`)
);

CREATE TABLE IF NOT EXISTS `property_cms` (
  `pkPropertyPageID` int(11) NOT NULL AUTO_INCREMENT,
  `fkPropertyCmsSubCategoryID` int(11) NOT NULL,
  `pkAdminID` int(11) NOT NULL,
  `adminName` varchar(225) NOT NULL,
  `propertyPageName` varchar(250) NOT NULL,
  `propertyPageTitle` text NOT NULL,
  `propertyPageDisplayTitle` varchar(255) NOT NULL,
  `propertyPageContent` longtext NOT NULL,
  `propertyPageStatus` enum('Wating','Approve','Review','Publish','Reject') NOT NULL DEFAULT 'Publish',
  `propertyPageRejectContent` longtext NOT NULL,
  `propertyPageKeywords` longtext NOT NULL,
  `propertyPageDescription` longtext NOT NULL,
  `propertyPageDateAdded` datetime NOT NULL,
  `propertyPageDateModified` datetime NOT NULL,
  `fkCmsStatusID` int(11) NOT NULL,
  `propertySubCategoryRejectedByAdminID` int(11) NOT NULL,
  `propertySubCategoryRejectedByAdminName` varchar(225) NOT NULL,
  `propertyCmsStatusUpdateDate` datetime NOT NULL,
  PRIMARY KEY (`pkPropertyPageID`)
);

CREATE TABLE `careers` (
`pkJobID` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`jobTitle` VARCHAR( 225 ) NOT NULL ,
`jobPositions` VARCHAR( 100 ) NOT NULL ,
`jobDescription` TEXT NOT NULL
);

ALTER TABLE `careers` ADD `jobDateAdded` DATETIME NOT NULL AFTER `jobDescription` ,
ADD `jobDateUpdated` DATETIME NOT NULL AFTER `jobDateAdded` ;

CREATE TABLE IF NOT EXISTS `consulting_cms_category` (
  `pkConsultingCmsCategoryID` int(11) NOT NULL AUTO_INCREMENT,
  `consultingCmsCategoryName` text NOT NULL,
  `fkAdminID` int(11) NOT NULL,
  `adminName` varchar(225) NOT NULL,
  `dateUpdated` datetime NOT NULL,
  `pageTitle` text NOT NULL,
  `pageContent` longtext NOT NULL,
  `pageKeywords` longtext NOT NULL,
  `pageDescription` longtext NOT NULL,
  PRIMARY KEY (`pkConsultingCmsCategoryID`)
);

INSERT INTO `consulting_cms_category` (`pkConsultingCmsCategoryID`, `consultingCmsCategoryName`, `fkAdminID`, `adminName`, `dateUpdated`, `pageTitle`, `pageContent`, `pageKeywords`, `pageDescription`) VALUES
(1, 'Home', 1, 'SuperAdmin', '0000-00-00 00:00:00', '', '', '', ''),
(2, 'Our Profile', 1, 'SuperAdmin', '0000-00-00 00:00:00', '', '', '', ''),
(3, 'Client Services', 1, 'SuperAdmin', '0000-00-00 00:00:00', '', '', '', ''),
(4, 'Insight & Publications', 1, 'SuperAdmin', '0000-00-00 00:00:00', '', '', '', ''),
(5, 'Contact Us', 1, 'SuperAdmin', '0000-00-00 00:00:00', '', '', '', ''),
(6, 'Market Report', 1, 'SuperAdmin', '0000-00-00 00:00:00', '', '', '', ''),
(7, 'Real Estate Search', 1, 'SuperAdmin', '0000-00-00 00:00:00', '', '', '', ''),
(8, 'Feasibility Study', 1, 'SuperAdmin', '0000-00-00 00:00:00', '', '', '', '');

CREATE TABLE IF NOT EXISTS `consulting_cms_sub_category` (
  `pkConsultingCmsSubCategoryID` int(11) NOT NULL AUTO_INCREMENT,
  `fkConsultingCmsCategoryID` int(11) NOT NULL,
  `fkCmsStatusID` int(11) NOT NULL,
  `consultingSubCategoryName` text NOT NULL,
  `consultingSubCategoryParentID` varchar(225) NOT NULL,
  `consultingSubCategoryParentName` varchar(225) NOT NULL,
  `consultingSubCategoryPathID` varchar(225) NOT NULL,
  `consultingSubCategoryPathName` varchar(225) NOT NULL,
  `consultingSubCategoryDateAdded` datetime NOT NULL,
  `consultingSubCategoryDateUpdated` datetime NOT NULL,
  `fkAdminID` int(11) NOT NULL,
  `adminName` varchar(225) NOT NULL,
  `consultingSubCategoryRejectedByAdminID` int(11) NOT NULL,
  `consultingSubCategoryRejectedByAdminName` varchar(225) NOT NULL,
  `consultingSubCategoryDisplayOrder` int(11) NOT NULL,
  `consultingSubCategoryStatusUpdateDate` datetime NOT NULL,
  PRIMARY KEY (`pkConsultingCmsSubCategoryID`)
);

CREATE TABLE IF NOT EXISTS `consulting_cms` (
  `pkConsultingPageID` int(11) NOT NULL AUTO_INCREMENT,
  `fkConsultingCmsSubCategoryID` int(11) NOT NULL,
  `pkAdminID` int(11) NOT NULL,
  `adminName` varchar(225) NOT NULL,
  `consultingPageName` varchar(250) NOT NULL,
  `consultingPageTitle` text NOT NULL,
  `consultingPageDisplayTitle` varchar(255) NOT NULL,
  `consultingPageContent` longtext NOT NULL,
  `consultingPageStatus` enum('Wating','Approve','Review','Publish','Reject') NOT NULL DEFAULT 'Publish',
  `consultingPageRejectContent` longtext NOT NULL,
  `consultingPageKeywords` longtext NOT NULL,
  `consultingPageDescription` longtext NOT NULL,
  `consultingPageDateAdded` datetime NOT NULL,
  `consultingPageDateModified` datetime NOT NULL,
  `fkCmsStatusID` int(11) NOT NULL,
  `consultingSubCategoryRejectedByAdminID` int(11) NOT NULL,
  `consultingSubCategoryRejectedByAdminName` varchar(225) NOT NULL,
  `consultingCmsStatusUpdateDate` datetime NOT NULL,
  PRIMARY KEY (`pkConsultingPageID`)
);

CREATE TABLE IF NOT EXISTS `home_consulting_images` (
  `pkHomeConsultingImageID` int(11) NOT NULL AUTO_INCREMENT,
  `homeConsultingImage` varchar(225) NOT NULL,
  `homeConsultingImageTitle` varchar(150) NOT NULL,
  `homeConsultingImageText` varchar(225) NOT NULL,
  PRIMARY KEY (`pkHomeConsultingImageID`)
);

INSERT INTO `home_consulting_images` (
`pkHomeConsultingImageID` ,
`homeConsultingImage` ,
`homeConsultingImageTitle` ,
`homeConsultingImageText`
)
VALUES (
NULL , '', 'Landmark Towers', 'Landmark Towers Landmark Towers Landmark Towers'
), (
NULL , '', 'Landmark Towers', 'Landmark Towers Landmark Towers Landmark Towers'
), (
NULL , '', 'Landmark Towers', 'Landmark Towers Landmark Towers Landmark Towers'
), (
NULL , '', 'Landmark Towers', 'Landmark Towers Landmark Towers Landmark Towers'
);






-----------------------------------------------
/* 24 feb */   by Raju khatak
-----------------------------------------------
ALTER TABLE `event_gallery_category` CHANGE `category_id` `category_id` INT( 11 ) NOT NULL AUTO_INCREMENT 

-----------------------------------------------
/* 23 feb */   by Raju khatak
-----------------------------------------------

CREATE TABLE `event_gallery_category` (
`category_id` INT( 11 ) NOT NULL ,
`category_name` VARCHAR( 255 ) NOT NULL ,
`category_status` ENUM( 'Active', 'Inactive' ) NOT NULL DEFAULT 'Active',
`category_addDate` DATETIME NOT NULL
) ENGINE = MYISAM ;


-----------------------------------------------
/* 22 feb */   by Raju khatak
-----------------------------------------------

CREATE TABLE `event_gallery` (
`gallery_id` INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`gallery_title` VARCHAR( 255 ) NOT NULL ,
`category_id` INT( 11 ) NOT NULL ,
`images` VARCHAR( 1000 ) NOT NULL ,
`status` ENUM( 'Active', 'Inactive' ) NOT NULL DEFAULT 'Active',
`gallery_addDate` DATETIME NOT NULL ,
`gallery_updated` DATETIME NOT NULL ,
`cover_image` VARCHAR( 255 ) NOT NULL ,
`year` VARCHAR( 255 ) NOT NULL
) ENGINE = MYISAM ;


-----------------------------------------------
/* 21 feb */   by Raju khatak
-----------------------------------------------


INSERT INTO `event_cms_category` (
`pkCmsCategoryID` ,
`cmsCategoryName` ,
`fkAdminID` ,
`adminName` ,
`dateUpdated` ,
`pageTitle` ,
`displayPageTitle` ,
`pageContent` ,
`pageKeywords` ,
`pageDescription`
)
VALUES (
NULL , 'Calendar', '1', 'SuperAdmin', '2013-02-15 14:54:48', 'Calendar', 'Calendar', 'Calendar CalendarCalendarCalendarCalendarCalendarCalendarCalendarCalendarCalendarCalendarCalendarCalendarCalendarCalendarCalendarCalendarCalendarCalendarCalendarCalendarCalendarCalendarCalendarCalendarCalendarCalendarCalendar', 'Calendar', 'Calendar'
);



-----------------------------------------------
/* 20 feb */   by Raju khatak
-----------------------------------------------

INSERT INTO `event_cms_category` (
`pkCmsCategoryID` ,
`cmsCategoryName` ,
`fkAdminID` ,
`adminName` ,
`dateUpdated` ,
`pageTitle` ,
`displayPageTitle` ,
`pageContent` ,
`pageKeywords` ,
`pageDescription`
)
VALUES (
NULL , 'Book an Event', '1', 'SuperAdmin', '2013-02-15 14:54:48', 'Book an Event', 'Book an Event', 'Book an Event Book an Event Book an Event Book an Event Book an Event Book an Event Book an Event Book an Event', 'Book an Event', 'Book an Event'
);


-----------------------------------------------
/* 19 feb */   by Raju khatak
-----------------------------------------------

ALTER TABLE `event_cms_category` ADD `displayPageTitle` TEXT NOT NULL AFTER `pageTitle` 

-----------------------------------------------
/* 19 feb */   by Raju khatak
-----------------------------------------------

CREATE TABLE `event_sub_category` (
`pkCmsSubCategoryID` int( 11 ) NOT NULL AUTO_INCREMENT ,
`fkCmsCategoryID` int( 11 ) NOT NULL ,
`fkCmsStatusID` int( 11 ) NOT NULL ,
`subCategoryName` text NOT NULL ,
`subCategoryParentID` varchar( 225 ) NOT NULL ,
`subCategoryParentName` varchar( 225 ) NOT NULL ,
`subCategoryPathID` varchar( 225 ) NOT NULL ,
`subCategoryPathName` varchar( 225 ) NOT NULL ,
`subCategoryDateAdded` datetime NOT NULL ,
`subCategoryDateUpdated` datetime NOT NULL ,
`fkAdminID` int( 11 ) NOT NULL ,
`adminName` varchar( 225 ) NOT NULL ,
`subCategoryRejectedByAdminID` int( 11 ) NOT NULL ,
`subCategoryRejectedByAdminName` varchar( 225 ) NOT NULL ,
`subCategoryDisplayOrder` int( 11 ) NOT NULL ,
`subCategoryStatusUpdateDate` datetime NOT NULL ,
PRIMARY KEY ( `pkCmsSubCategoryID` )
) ENGINE = MYISAM DEFAULT CHARSET = latin1;


-----------------------------------------------
/* 18 feb */   by Raju khatak
-----------------------------------------------

CREATE TABLE `event_status` (
`pkCmsStatusID` int( 11 ) NOT NULL AUTO_INCREMENT ,
`cmsStatusName` varchar( 225 ) NOT NULL ,
PRIMARY KEY ( `pkCmsStatusID` )
) ENGINE = MYISAM DEFAULT CHARSET = latin1;


-----------------------------------------------
/* 17 feb */   by Raju khatak
-----------------------------------------------

INSERT INTO `event_cms_category` (
`pkCmsCategoryID` ,
`cmsCategoryName` ,
`fkAdminID` ,
`adminName` ,
`dateUpdated` ,
`pageTitle` ,
`pageContent` ,
`pageKeywords` ,
`pageDescription`
)
VALUES (
NULL , 'Contact Us', '1', 'SuperAdmin', '2013-02-15 14:54:48', 'Contact Us', '', '', '');



-----------------------------------------------
/* 16 feb */   by Raju khatak
-----------------------------------------------


CREATE TABLE `event_cms_category` (
`pkCmsCategoryID` int( 11 ) NOT NULL AUTO_INCREMENT ,
`cmsCategoryName` text NOT NULL ,
`fkAdminID` int( 11 ) NOT NULL ,
`adminName` varchar( 225 ) NOT NULL ,
`dateUpdated` datetime NOT NULL ,
`pageTitle` text NOT NULL ,
`pageContent` longtext NOT NULL ,
`pageKeywords` longtext NOT NULL ,
`pageDescription` longtext NOT NULL ,
PRIMARY KEY ( `pkCmsCategoryID` )
) ENGINE = MYISAM DEFAULT CHARSET = latin1;

-----------------------------------------------
/* 15 feb */   by Raju khatak
-----------------------------------------------

CREATE TABLE `event_cms` ( `pkPageID` int( 11 ) NOT NULL AUTO_INCREMENT ,
`fkCmsSubCategoryID` int( 11 ) NOT NULL ,
`pkAdminID` int( 11 ) NOT NULL ,
`adminName` varchar( 225 ) NOT NULL ,
`PageName` varchar( 250 ) NOT NULL ,
`PageTitle` text NOT NULL ,
`PageDisplayTitle` varchar( 255 ) NOT NULL ,
`PageContent` longtext NOT NULL ,
`PageStatus` enum( 'Wating', 'Approve', 'Review', 'Publish', 'Reject' ) NOT NULL DEFAULT 'Publish',
`PageRejectContent` longtext NOT NULL ,
`PageKeywords` longtext NOT NULL ,
`PageDescription` longtext NOT NULL ,
`PageDateAdded` datetime NOT NULL ,
`PageDateModified` datetime NOT NULL ,
`fkCmsStatusID` int( 11 ) NOT NULL ,
`subCategoryRejectedByAdminID` int( 11 ) NOT NULL ,
`subCategoryRejectedByAdminName` varchar( 225 ) NOT NULL ,
`cmsStatusUpdateDate` datetime NOT NULL ,
PRIMARY KEY ( `pkPageID` ) )

-----------------------------------------------
/* 14 feb */   by kuldeep (done iworklab)
-----------------------------------------------
ALTER TABLE `main_news_media` CHANGE `mainNewsMediaDate` `mainNewsMediaDate` DATE NOT NULL 

-----------------------------------------------
/* 13 feb */   by kuldeep
-----------------------------------------------
CREATE TABLE `main_news_media` (
`pkMainNewsMediaID` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`mainNewsMediaTitle` TEXT NOT NULL ,
`mainNewsMediaDate` DATETIME NOT NULL ,
`mainNewsMediaDescription` LONGTEXT NOT NULL ,
`mainNewsMediaImage` VARCHAR( 225 ) NOT NULL
) ;

CREATE TABLE `siteName` (
`pkSiteNameID` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`siteName` VARCHAR( 225 ) NOT NULL
);

INSERT INTO `siteName` (`pkSiteNameID`, `siteName`) VALUES (NULL, 'Landmark Africa'), (NULL, 'Serviced Offices'), (NULL, 'Landmark Counsulting'), (NULL, 'Property Company'), (NULL, 'Landmark Event Center');

ALTER TABLE `main_news_media` ADD `fkSiteNameID` INT NOT NULL AFTER `pkMainNewsMediaID`; 

ALTER TABLE `main_news_media` ADD `mainNewsMediaDateAdded` DATETIME NOT NULL AFTER `mainNewsMediaDescription` ,
ADD `mainNewsMediaDateUpdated` DATETIME NOT NULL AFTER `mainNewsMediaDateAdded` ;

-----------------------------------------------
/* 12 feb */   by kuldeep 	done(iworklab)
-----------------------------------------------
ALTER TABLE `cms` ADD `cmsStatusUpdateDate` DATETIME NOT NULL AFTER `subCategoryRejectedByAdminName` 

ALTER TABLE `cms_sub_category` ADD `subCategoryStatusUpdateDate` DATETIME NOT NULL AFTER `subCategoryDisplayOrder`


-----------------------------------------------
/* 11 feb */   by Raju khatak 	done(iworklab)
-----------------------------------------------

CREATE TABLE IF NOT EXISTS `Testimonials` (
  `testId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'This is primary id of this table',
  `Testimonials_name` varchar(255) NOT NULL,
  `Testimonials_image` varchar(255) NOT NULL,
  `Testimonials_title` varchar(255) NOT NULL,
  `Testimonials_description` longtext NOT NULL,
  `Testimonials_status` enum('Active','Inactive') NOT NULL DEFAULT 'Inactive',
  `Testimonials_addDate` datetime NOT NULL,
  `Testimonials_updateDate` datetime NOT NULL,
  PRIMARY KEY (`testId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;



-----------------------------------------------
/* 11 feb */   by kuldeep 	done(iworklab)
-----------------------------------------------
INSERT INTO `site_logo` (`logo_id`, `site_name`, `site_logo`, `site_slogan`, `logoAddDate`, `logoUpdateDate`) VALUES (NULL, 'Serviced Offices', '', 'Serviced Offices', '', ''), (NULL, 'Landmark Consulting', '', 'Landmark Consulting', '', '');

INSERT INTO `site_logo` (`logo_id`, `site_name`, `site_logo`, `site_slogan`, `logoAddDate`, `logoUpdateDate`) VALUES (NULL, 'Property Company', '', 'Property Company', '', ''), (NULL, 'Landmark Event Centre', '', 'Landmark Event Centre', '', '');

CREATE TABLE IF NOT EXISTS `enquiryEmails` (
  `pkEnquiryEmailID` int(11) NOT NULL AUTO_INCREMENT,
  `enquiryFromPage` varchar(225) NOT NULL,
  `enquiryEmail` varchar(225) NOT NULL,
  PRIMARY KEY (`pkEnquiryEmailID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

INSERT INTO `enquiryEmails` (`pkEnquiryEmailID`, `enquiryFromPage`, `enquiryEmail`) VALUES
(1, 'Main Site - Contact Us', ''),
(2, 'Main Site - Enquiry', ''),
(3, 'Serviced office - Contact Us', ''),
(4, 'Serviced office - Enquiry', ''),
(5, 'Landmark Consulting - Contact Us', ''),
(6, 'Landmark Consulting - Enquiry', ''),
(7, 'Property Company - Contact Us', ''),
(8, 'Property Company - Enquiry', ''),
(9, 'Event Center - Contact Us', ''),
(10, 'Event Center - Enquiry', ''),
(11, 'Event Center - Book an Event', '');

ALTER TABLE `enquiryEmails` ADD `enquiryEmailDateUpdated` DATETIME NOT NULL AFTER `enquiryEmail` ;


-----------------------------------------------
/* 10 feb */   by kuldeep 	done(iworklab)
-----------------------------------------------
ALTER TABLE `cms_sub_category` ADD `subCategoryDisplayOrder` INT NOT NULL AFTER `subCategoryRejectedByAdminName` 

-----------------------------------------------
/* 8 feb */   by kuldeep 	done(iworklab)
-----------------------------------------------
ALTER TABLE `admin` ADD `oldPass` VARCHAR( 255 ) NOT NULL AFTER `UserType` 



-------------------------------------------------
/* 31 jan */     done(iworklab)  by kuldeep
-------------------------------------------------

CREATE TABLE IF NOT EXISTS `cms_status` (
`pkCmsStatusID` int( 11 ) NOT NULL AUTO_INCREMENT ,
`cmsStatusName` varchar( 225 ) NOT NULL ,
PRIMARY KEY ( `pkCmsStatusID` )
) ENGINE = MYISAM DEFAULT CHARSET = latin1 AUTO_INCREMENT =0;

INSERT INTO `cms_status` ( `pkCmsStatusID` , `cmsStatusName` )
VALUES ( 1, 'Waiting for Review' ) , ( 2, 'Waiting for Approval' ) , ( 3, 'Waiting for Publish' ) , ( 4, 'Published' ) , ( 5, 'Rejected' ) ;

============================================
ALTER TABLE `cms_sub_category` DROP `subCategoryApprovedByAdminID` ,
DROP `subCategoryApprovedByAdminName` ;
=============================================
ALTER TABLE `cms` DROP `subCategoryApprovedByAdminID` ,
DROP `subCategoryApprovedByAdminName` ;



-------------------------------------------------
/* 30 jan */ done(iworklab)		by kuldeep
-------------------------------------------------

ALTER TABLE `cms_sub_category` ADD `subCategoryApprovedByAdminID` INT NOT NULL AFTER `adminName` ,
ADD `subCategoryApprovedByAdminName` VARCHAR( 225 ) NOT NULL AFTER `subCategoryApprovedByAdminID` ,
ADD `subCategoryRejectedByAdminID` INT NOT NULL AFTER `subCategoryApprovedByAdminName` ,
ADD `subCategoryRejectedByAdminName` VARCHAR( 225 ) NOT NULL AFTER `subCategoryRejectedByAdminID` 
======================================================================
ALTER TABLE `cms` ADD `subCategoryApprovedByAdminID` INT NOT NULL AFTER `fkCmsStatusID` ,
ADD `subCategoryApprovedByAdminName` VARCHAR( 225 ) NOT NULL AFTER `subCategoryApprovedByAdminID` ,
ADD `subCategoryRejectedByAdminID` INT NOT NULL AFTER `subCategoryApprovedByAdminName` ,
ADD `subCategoryRejectedByAdminName` VARCHAR( 225 ) NOT NULL AFTER `subCategoryRejectedByAdminID` 
======================================================================


-------------------------------------------------
/* 29 jan */   done(iworklab)		by kuldeep
-------------------------------------------------

ALTER TABLE `cms` ADD `fkCmsStatusID` INT NOT NULL AFTER `PageDateModified` 
======================================================================
ALTER TABLE `cms` ADD `fkCmsSubCategoryID` INT NOT NULL AFTER `pkPageID`
=====================================================================
ALTER TABLE `cms` ADD `adminName` VARCHAR( 225 ) NOT NULL AFTER `pkAdminID` 
=====================================================================
ALTER TABLE `cms_sub_category` ADD `adminName` VARCHAR( 225 ) NOT NULL AFTER `fkAdminID` 
=====================================================================
ALTER TABLE `cms_category`  ADD `fkAdminID` INT NOT NULL AFTER `cmsCategoryName`,  ADD `adminName` VARCHAR(225) NOT NULL AFTER `fkAdminID`,  ADD `dateUpdated` DATETIME NOT NULL AFTER `adminName`,  ADD `pageTitle` TEXT NOT NULL AFTER `dateUpdated`,  ADD `pageContent` LONGTEXT NOT NULL AFTER `pageTitle`,  ADD `pageKeywords` LONGTEXT NOT NULL AFTER `pageContent`,  ADD `pageDescription` LONGTEXT NOT NULL AFTER `pageKeywords`;
=====================================================================
UPDATE `landmark`.`cms_category` SET `fkAdminID` = '1',
`adminName` = 'SuperAdmin' WHERE `cms_category`.`pkCmsCategoryID` =1;

UPDATE `landmark`.`cms_category` SET `fkAdminID` = '1',
`adminName` = 'SuperAdmin' WHERE `cms_category`.`pkCmsCategoryID` =2;

UPDATE `landmark`.`cms_category` SET `fkAdminID` = '1',
`adminName` = 'SuperAdmin' WHERE `cms_category`.`pkCmsCategoryID` =3;
 

-------------------------------------------------
/* 28 jan */		done(iworklab)	by kuldeep
-------------------------------------------------

CREATE TABLE `cms_status` (
`pkCmsStatusID` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`cmsStatusName` VARCHAR( 225 ) NOT NULL
) ENGINE = MYISAM ;
================================================

INSERT INTO `cms_status` (`pkCmsStatusID`, `cmsStatusName`) VALUES (NULL, 'Waiting for Review'), (NULL, 'Waiting for Approval'), (NULL, 'Waiting for Publish'), (NULL, 'Reviewed'), (NULL, 'Approved'), (NULL, 'Published'), (NULL, 'Rejected');
================================================

CREATE TABLE `cms_category` (
`pkCmsCategoryID` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`cmsCategoryName` TEXT NOT NULL
) ENGINE = MYISAM 

=========================================================
INSERT INTO `cms_category` (
`pkCmsCategoryID` ,
`cmsCategoryName`
)
VALUES (
NULL , 'Our Profile'
), (
NULL , 'News & Media'
), (
NULL , 'Contact Us'
);
=========================================================
CREATE TABLE `cms_sub_category` (
`pkCmsSubCategoryID` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`fkCmsCategoryID` INT NOT NULL ,
`fkCmsStatusID` INT NOT NULL ,
`subCategoryName` TEXT NOT NULL ,
`subCategoryParentID` VARCHAR( 225 ) NOT NULL ,
`subCategoryParentName` VARCHAR( 225 ) NOT NULL ,
`subCategoryPathID` VARCHAR( 225 ) NOT NULL ,
`subCategoryPathName` VARCHAR( 225 ) NOT NULL ,
`subCategoryDateUpdated` TIMESTAMP NOT NULL ,
`fkAdminID` INT NOT NULL
) ENGINE = MYISAM ;
=========================================================
ALTER TABLE `cms_sub_category` CHANGE `subCategoryDateUpdated` `subCategoryDateUpdated` DATETIME NOT NULL 
=========================================================
ALTER TABLE `cms_sub_category` ADD `subCategoryDateAdded` DATETIME NOT NULL AFTER `subCategoryPathName` 
=========================================================



---------------------------------------------------
/* 25 jan */   done(iworklab)		by kuldeep
---------------------------------------------------
CREATE TABLE `home_main_book_cms` (
`home_main_book_cms_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`page_name` VARCHAR( 225 ) NOT NULL ,
`author` VARCHAR( 225 ) NOT NULL ,
`date_updated` DATE NOT NULL
) ENGINE = MYISAM ;
================================================

ALTER TABLE `home_main_book_cms` CHANGE `date_updated` `date_updated` TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP

=========================================================
CREATE TABLE `landmark`.`home_main_book_cms_images` (
`home_main_book_cms_imags_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`fk_home_main_book_cms_id` INT NOT NULL ,
`page_name` VARCHAR( 255 ) NOT NULL ,
`text` TEXT NOT NULL ,
`image_1` VARCHAR( 255 ) NOT NULL ,
`image_2` VARCHAR( 255 ) NOT NULL ,
`image_3` VARCHAR( 255 ) NOT NULL ,
`image_4` VARCHAR( 255 ) NOT NULL
) ENGINE = MYISAM ; 


=========================================================
INSERT INTO `home_main_book_cms_images` (
`home_main_book_cms_imags_id` ,
`fk_home_main_book_cms_id` ,
`page_name` ,
`text` ,
`image_1` ,
`image_2` ,
`image_3` ,
`image_4`
)
VALUES (
NULL , '1', 'Book an Office Space', 'text Book an Office Space', '', '', '', ''
), (
NULL , '2', 'Book an Event Space', 'text Book an Event Space', '', '', '', ''
), (
NULL , '3', 'Book a Meeting Room', 'text Book a Meeting Room', '', '', '', ''
), (
NULL , '4', 'Book an Appartment', 'text Book an Appartment', '', '', '', ''
);
