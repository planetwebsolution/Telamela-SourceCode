<?php
    require_once SOURCE_ROOT.'classes/class_common.php';
    
    $common = new ClassCommon();
    
    $tableField =array('pkCmsCategoryID','cmsCategoryName','fkAdminID','adminName','dateUpdated','pageTitle','pageContent','pageKeywords','pageDescription'); 
    
    $table =TABLE_CMS_CATEGORY; 
    
    $where = 1;
    $category =$common->getCategoryData($table,$tableField,$where);
//    /echo'<pre>';print_r($category);die;
    
    if($category[0][cmsCategoryName]!=''){
    
     $tableField =array('pkCmsCategoryID','cmsCategoryName','dateUpdated','pageTitle','pageContent','pageKeywords','pageDescription','pkCmsSubCategoryID','	fkCmsCategoryID','fkCmsStatusID','subCategoryName','subCategoryParentID','subCategoryParentName','subCategoryPathID','subCategoryPathName','subCategoryDateAdded','subCategoryDateUpdated','subCategoryRejectedByAdminID','subCategoryRejectedByAdminName'); 
        
     $where = "1 AND TSC.fkCmsCategoryID='".$category[0][pkCmsCategoryID]."' AND TSC.fkCmsStatusID='4' AND TSC.subCategoryParentID='' AND TSC.subCategoryPathID=''";
     
     $jsTable =TABLE_CMS_SUB_CATEGORY." as TSC LEFT JOIN ".$table." as TC on TSC.fkCmsCategoryID=TC.pkCmsCategoryID"; 
     
     $about = $common->getSubCategoryData($jsTable,$tableField,$where);
     //echo "<pre>";print_r($about);die;
    }
    if($category[1][cmsCategoryName]!=''){
    
     $tableField =array('pkCmsCategoryID','cmsCategoryName','dateUpdated','pageTitle','pageContent','pageKeywords','pageDescription','pkCmsSubCategoryID','	fkCmsCategoryID','fkCmsStatusID','subCategoryName','subCategoryParentID','subCategoryParentName','subCategoryPathID','subCategoryPathName','subCategoryDateAdded','subCategoryDateUpdated','subCategoryRejectedByAdminID','subCategoryRejectedByAdminName'); 
        
     $where = "1 AND TSC.fkCmsCategoryID='".$category[1]['pkCmsCategoryID']."' AND TSC.fkCmsStatusID='4' AND TSC.subCategoryParentID='' AND TSC.subCategoryPathID=''";
     
     $jsTable =TABLE_CMS_SUB_CATEGORY." as TSC LEFT JOIN ".$table." as TC on TSC.fkCmsCategoryID=TC.pkCmsCategoryID"; 
     
     $newMedia = $common->getSubCategoryData($jsTable,$tableField,$where);
//echo "<pre>";print_r($newMedia);die;
    }
    if($category[2][cmsCategoryName]!=''){
    
     $tableField =array('pkCmsCategoryID','cmsCategoryName','dateUpdated','pageTitle','pageContent','pageKeywords','pageDescription','pkCmsSubCategoryID','	fkCmsCategoryID','fkCmsStatusID','subCategoryName','subCategoryParentID','subCategoryParentName','subCategoryPathID','subCategoryPathName','subCategoryDateAdded','subCategoryDateUpdated','subCategoryRejectedByAdminID','subCategoryRejectedByAdminName'); 
        
     $where = "1 AND TSC.fkCmsCategoryID='".$category[2][pkCmsCategoryID]."' AND TSC.fkCmsStatusID='4' AND TSC.subCategoryParentID='' AND TSC.subCategoryPathID=''";
     
     $jsTable =TABLE_CMS_SUB_CATEGORY." as TSC LEFT JOIN ".$table." as TC on TSC.fkCmsCategoryID=TC.pkCmsCategoryID"; 
     
     $contact = $common->getSubCategoryData($jsTable,$tableField,$where);
     //echo "<pre>";print_r($about);die;
    }
    
?>
<div class="menu">
	<ul class="nav">
	    <li><a href="index.php" class="icon1" title="HOME"></a></li>
	    <li><a style="cursor:pointer;" href="details.php?cmsCatId=<?php echo $category[0]['pkCmsCategoryID'];?>&id=" title="<?php echo $category[0][cmsCategoryName]; ?>"><?php echo $category[0][cmsCategoryName]; ?></a>
		<ul class="innerList">
		    <?php
            if($about!=''){
                
                foreach($about as $key=>$abouts){ ?>
            <li><a href="details.php?id=<?php echo $abouts['pkCmsSubCategoryID']?>&cmsCatId=<?php echo $category[0][pkCmsCategoryID];?>"><?php echo stripslashes($abouts['subCategoryName']);?></a></li>
		    
                    
             <?php  }  } ?>
           <li><a href="testimonial.php">Testimonials</a></li> 
            
		</ul>
	    </li>
	    <li><a href="#" title="Companies" style="cursor:default;">Companies</a>
		<ul class="innerList">
                       
		    <li><a href="<?php echo $arrConfig['subSite1RootURL'];?>">Serviced offices</a></li>
		    <li><a href="<?php echo $arrConfig['subSite2RootURL'];?>">Landmark Consulting</a></li>
		    <li><a href="<?php echo $arrConfig['subSite3RootURL'];?>">Property Company</a></li>
		    <li><a href="<?php echo SITE_EVENT_ROOT_URL?>">Landmark event Center</a></li>
		</ul>
	    </li>
	    <li><a style="cursor:pointer;" href="news_media.php" title="News &amp; Media"><?php echo $category[1][cmsCategoryName]; ?></a>
        <ul class="innerList">
        <?php
        if($newMedia!=''){ 
                foreach($newMedia as $key=>$newMedias){ ?>
            <li><a href="details.php?id=<?php echo $newMedias['pkCmsSubCategoryID']?>&cmsCatId=<?php echo $category[1][pkCmsCategoryID];?>"><?php echo stripslashes($newMedias['subCategoryName']);?></a></li>
             <?php  }  } ?>
            </ul>
        </li>
	    <li  title="Contact Us"><a href="contact_us.php"><?php echo $category[2][cmsCategoryName]; ?></a>
		<ul class="innerList">
            <?php
            if($contact!=''){
                
                foreach($contact as $key=>$contacts){ ?>
            <li><a href="details.php?id=<?php echo $contacts['pkCmsSubCategoryID']?>&cmsCatId=<?php echo $category[2][pkCmsCategoryID];?>"><?php echo stripslashes($contacts['subCategoryName']);?></a></li>
		    
                    
             <?php  }  } ?>
		    <li><a href="enquiry.php">Enquiry</a></li>
		</ul>
	    </li>
	</ul>
<div class="searching">
<form method="get" action="search.php">
    <input type="text" name="q" value="Search" class="textBox" onFocus="if(this.value=='Search')this.value=''" onBlur="if(this.value=='')this.value='Search'"/>
    <input type="submit" name="" value="" class="sub-btn"/>
</form>
</div>
</div>
