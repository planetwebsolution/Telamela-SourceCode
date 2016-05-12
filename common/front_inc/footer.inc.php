<?php
require_once 'common/config/config.inc.php';
require_once SOURCE_ROOT.'classes/class_common.php';
    
$common = new ClassCommon();
$arrSideList= $common->cmsOfficeAddressList();	 
$arrWhyLandmarkList= $common->whyLandmarkList();   
?>
<div class="footer">
<div class="outerLayout">
    <div class="layout">
        <div class="innerLayout">

            <div class="innerFooter">
                <div class="block1">
                    <h3>Our Profile</h3>
                    <?php
                    $abTable =TABLE_CMS_CATEGORY; 
                    $aboutTableField =array('pkCmsCategoryID','cmsCategoryName','dateUpdated','pageTitle','pageContent','pageKeywords','pageDescription','pkCmsSubCategoryID','	fkCmsCategoryID','fkCmsStatusID','subCategoryName','subCategoryParentID','subCategoryParentName','subCategoryPathID','subCategoryPathName','subCategoryDateAdded','subCategoryDateUpdated','subCategoryRejectedByAdminID','subCategoryRejectedByAdminName'); 
        
     $aboutWhere = "1 AND TSC.fkCmsCategoryID='1' AND TSC.fkCmsStatusID='4' AND TSC.subCategoryParentID='' AND TSC.subCategoryPathID=''";
     
     $aboutTable =TABLE_CMS_SUB_CATEGORY." as TSC LEFT JOIN ".$abTable." as TC on TSC.fkCmsCategoryID=TC.pkCmsCategoryID"; 
     
     $about = $common->getSubCategoryData($aboutTable,$aboutTableField,$aboutWhere);
                    
          // echo pre($about);         
                    ?>
                    <ul>
                        <?php
            if($about!=''){
                
                foreach($about as $key=>$abouts){ ?>
            <li><a href="details.php?id=<?php echo $abouts['pkCmsSubCategoryID']?>&cmsCatId=<?php echo $category[0][pkCmsCategoryID];?>"><?php echo stripslashes($abouts['subCategoryName']);?></a></li>
		    
                    
             <?php  }  } ?>
                       
                        <li><a href="testimonial.php" title="Testimonials">Testimonials</a></li>
                        
                    </ul>
                </div>
                <div class="block1 block2">
                    <h3>Our Locations</h3>
                    <ul>
                       <?php foreach($arrSideList as $key => $val)
                    { ?>
                        <li><a href="<?php echo $arrConfig['subSite1RootURL']; ?>office.php?oID=<?php echo $val['pkOfficeAddressID'];?>" title="<?php echo $val['officeAddressCity'];?>"><?php echo $val['officeAddressCity'];?></a></li>
                    <?php } ?>
                    </ul>
                </div>
                <div class="block1 block3">
                    <h3>Product and Services</h3>
                    
                    <?php 
                    $table =TABLE_OFFICE_CMS_CATEGORY;
                    $tableField =array('pkOfficeCmsCategoryID','officeCmsCategoryName','pageTitle','pageContent','pageKeywords','pageDescription','pkOfficeCmsSubCategoryID','fkOfficeCmsCategoryID','fkCmsStatusID','officeSubCategoryName','officeSubCategoryParentID','officeSubCategoryPathID'); 
        
     $where = "1 AND TSC.fkOfficeCmsCategoryID='3' AND TSC.fkCmsStatusID='4' AND TSC.officeSubCategoryParentID='' AND TSC.officeSubCategoryPathID=''";
     
     $jsTable =TABLE_OFFICE_CMS_SUB_CATEGORY." as TSC LEFT JOIN ".$table." as TC on TSC.fkOfficeCmsCategoryID=TC.pkOfficeCmsCategoryID"; 
     
     $product = $common->getSubCategoryDataOffices($jsTable,$tableField,$where);
             //echo pre($product);       
                    ?>
                    
                    <ul>
                        <?php
            									if($product!=''){         									
                                         		 foreach($product as $key=>$products){ ?>
                                         			<li><a href="<?php echo $arrConfig['subSite1RootURL'];?>details.php?id=<?php echo $products['pkOfficeCmsSubCategoryID']?>&cmsCatId=<?php echo $products['pkOfficeCmsCategoryID'];?>"><?php echo stripslashes($products['officeSubCategoryName']);?></a></li>
                                            		<?php }} ?>
                        
                    </ul>
                </div>
                <div class="block1 block4">
                    <h3>Investors Material</h3>
                    <?php
                    
                    $tableccc =TABLE_CMS_SUB_CATEGORY;
                    $tableFields =array('pkCmsSubCategoryID','fkCmsCategoryID','fkCmsStatusID','subCategoryName','subCategoryParentID','subCategoryPathID'); 

                    $varOrderBy = ' subCategoryDisplayOrder asc ';
                    // on iwork server consultingSubCategoryParentID ='26' and localserver it is 99 please note this
                    $whereLeftMenu =" 1 AND subCategoryParentID ='26' AND fkCmsStatusID=4";

                    $invest =$common->getCategoryData($tableccc,$tableFields,$whereLeftMenu, $varOrderBy);
                    ?>
                    <ul>
                         <?php
                                        if($invest!=''){
                                        foreach($invest as $key=>$invests){ ?>
                                        
                                            <li><a href="details.php?pid=<?php echo $invests['pkCmsSubCategoryID'];?>&cmsCatId=<?php echo $invests['fkCmsCategoryID'];?>&pg=<?php echo $invests['subCategoryName'];?>"><?php echo $invests['subCategoryName'];?></a></li>
                                      <?php  } } ?>
                       
                    </ul>
                </div>
                <div class="block1 block5">
                    <h3>Why Landmark</h3>
                    <div class="footerWhyLandmark">
                    <marquee direction="up" onmouseover="stop();" onmouseout="start();" scrollamount="2" style="padding: 2px;">
                    <?php foreach($arrWhyLandmarkList as $key => $val) { ?>   
                    <div class="footerWhyLandmarkInner">               
                    <p class="dummytext"><?php echo $val['whyLandmarkText']; ?></p>
                    <strong class="director"><?php echo $val['whyLandmarkManage']; ?></strong>
                    <br/><br/>
                    </div>
                    <br/>
                    <?php } ?>
                    </marquee>
                    </div>
                </div>
            </div>
            <!-- footer end here -->
            <div class="bottomSection">
                <p class="copyRight">Copyright © <?php echo date('Y');?> Landmark Africa. All rights reserved</p>
                <ul class="bottomNav">
                	<li><a href="#">Email</a></li>
                	<li><a href="#">Intranet</a></li>
                    <li><a href="privacy_policy.php">Privacy Policy</a></li>
                    <li><a href="terms_condition.php">Terms and Conditions</a></li>
                    <li class="last"><a href="site_map.php">Site Map</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
</div>
