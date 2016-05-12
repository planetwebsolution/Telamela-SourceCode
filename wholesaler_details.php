 <a class="wholesaler_nme" style="font-style:italic; width:100%; float:left; margin-bottom:10px;" href="<?php echo $objCore->getUrl('wholesaler_profile_customer_view.php', array('action' => 'view', 'wid' => $objPage->arrproductDetails[0]['pkWholesalerID'])); ?>"><strong><?php echo ucfirst($objPage->arrproductDetails[0]['CompanyName']); ?></strong></a>
                                                    <?php
                                                        $template=$objPage->arrproductDetails[0]['fkTemplateId'];
                                                        switch ($template) {
                                                        case 1:?>
                                                        <iframe id="desc_ifr" class="" style="height:1460px;width:100%;" marginheight="0" marginwidth="0" frameborder="0" src="<?php echo $objCore->getUrl('wholesaler_template1.php', array('tmpid' => $objPage->arrproductDetails[0]['fkTemplateId'],'id'=>$objPage->arrproductDetails[0]['pkProductID']));?>" title="Seller's description of item"></iframe>
                                                        <?php 
                                                        break;
                                                        case 2:?>
                                                        <iframe id="desc_ifr" class="" style="height:1820px;width:100%;" marginheight="0" marginwidth="0" frameborder="0" src="<?php echo $objCore->getUrl('wholesaler_template2.php', array('tmpid' => $objPage->arrproductDetails[0]['fkTemplateId'],'id'=>$objPage->arrproductDetails[0]['pkProductID']));?>" title="Seller's description of item"></iframe>                 
                                                        <?php
                                                        break;
                                                        case 3:?>
                                                        <iframe id="desc_ifr" class="" style="height:1460px;width:100%;" marginheight="0" marginwidth="0" frameborder="0" src="<?php echo $objCore->getUrl('wholesaler_template3.php', array('tmpid' => $objPage->arrproductDetails[0]['fkTemplateId'],'id'=>$objPage->arrproductDetails[0]['pkProductID']));?>" title="Seller's description of item"></iframe>
                                                        <?php 
                                                        break;
                                                        case 4:?>
                                                        <iframe id="desc_ifr" class="" style="height:1280px;width:100%;" marginheight="0" marginwidth="0" frameborder="0" src="<?php echo $objCore->getUrl('wholesaler_template4.php', array('tmpid' => $objPage->arrproductDetails[0]['fkTemplateId'],'id'=>$objPage->arrproductDetails[0]['pkProductID']));?>" title="Seller's description of item"></iframe>
                                                        <?php
                                                        break;
                                                         case 5:?>
                                                        <iframe id="desc_ifr" class="" style="height:1460px;width:100%;" marginheight="0" marginwidth="0" frameborder="0" src="<?php echo $objCore->getUrl('wholesaler_template5.php', array('tmpid' => $objPage->arrproductDetails[0]['fkTemplateId'],'id'=>$objPage->arrproductDetails[0]['pkProductID']));?>" title="Seller's description of item"></iframe>
                                                        <?php
                                                        break;
                                                        case 6:?>
                                                        <iframe id="desc_ifr" class="" style="height:1760px;width:100%;" marginheight="0" marginwidth="0" frameborder="0" src="<?php echo $objCore->getUrl('wholesaler_template6.php', array('tmpid' => $objPage->arrproductDetails[0]['fkTemplateId'],'id'=>$objPage->arrproductDetails[0]['pkProductID']));?>" title="Seller's description of item"></iframe>
                                                        <?php
                                                        break;
                                                        default:?>
                                                         <iframe id="desc_ifr" class="" style="height:1460px;width:100%;" marginheight="0" marginwidth="0" frameborder="0" src="<?php echo $objCore->getUrl('wholesaler_template1.php', array('tmpid' => 1,'id'=>$objPage->arrproductDetails[0]['pkProductID']));?>" title="Seller's description of item"></iframe>
                                                       <?php  break;
                                                        }
                                                    ?>