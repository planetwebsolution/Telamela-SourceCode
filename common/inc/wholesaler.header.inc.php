<style>
    #classA,#classO,#classR,#classFeed,#classIn,#classRat{position: relative;}
    #classA .classB,#classO .classOr,#classR .classRv,#classFeed .classFe,#classIn .classIn,#classRat .classRat{position: absolute;top:-10px;right: 4px;font-weight:bold;color: #fff;
    background-image: url('<?php echo IMAGE_PATH_URL;?>notification_img.png');
    width:22px;height:25px; text-align:center; font:9px/25px arial;
    }
</style>

<?php
$notify=json_decode($objCore->getNotification($_SESSION['sessUserInfo']['type'],$_SESSION['sessUserInfo']['id'])); 
$menu = basename($_SERVER['PHP_SELF']); $act_class = 'class="active"'; ?>
<ul class="my_menu">
  <li class="first"><a href="<?php echo $objCore->getUrl('dashboard_wholesaler_account.php');?>" <?php  echo strpos($menu,'dashboard_wholesaler_account.php')!==FALSE || strpos($menu,'edit_my_account_wholesaler.php')!==FALSE?$act_class:''; ?> >My Account</a></li>
  
  <li><a href="<?php echo $objCore->getUrl('manage_products.php');?>" <?php  echo strpos($menu,'manage_products.php')!==FALSE||strpos($menu,'add_edit_product.php')!==FALSE||strpos($menu,'add_multi_product.php')!==FALSE||strpos($menu,'add_edit_product_inventory.php')!==FALSE||strpos($menu,'add_edit_product_price.php')!==FALSE?$act_class:''; ?> id="classRat">Manage Products 
         <?php if(($notify->wholesaleProductRating>0)){ ?> <span class="classRat ratingWholesaler"><?php echo $notify->wholesaleProductRating;?></span><?php } ?>
      </a></li>
  
  <li><a href="<?php echo $objCore->getUrl('manage_packages.php');?>" <?php  echo strpos($menu,'manage_packages.php')!==FALSE||strpos($menu,'edit_package.php')!==FALSE||strpos($menu,'add_new_package.php')!==FALSE?$act_class:''; ?> >Manage Packages</a></li>
  
  <li><a href="<?php echo $objCore->getUrl('customer_orders.php');?>" <?php  echo strpos($menu,'order')!==FALSE?$act_class:''; ?> id="classO">Orders 
          <?php if(($notify->wholesalerOrder>0)){ ?> <span class="classOr orderWholesaler"><?php echo $notify->wholesalerOrder;?></span><?php } ?>
      </a></li>
  
  <li><a href="<?php echo $objCore->getUrl('manage_invoice.php');?>" <?php  echo strpos($menu,'manage_invoice')!==FALSE?$act_class:''; ?> id="classIn">Invoices 
         <?php if(($notify->wholesaleInvoive>0)){ ?>   <span class="classIn invoiceWholesaler"><?php echo $notify->wholesaleInvoive;?></span><?php } ?>
      </a></li>
  
  <li><a href="<?php echo $objCore->getUrl('customer_feedbacks.php');?>" <?php  echo strpos($menu,'customer_feedbacks.php')!==FALSE?$act_class:''; ?> id="classFeed">Feedbacks 
          <?php if(($notify->wholesaleFeedback>0)){ ?>  <span class="classFe feedbackWholesaler"><?php echo $notify->wholesaleFeedback;?></span><?php } ?>
      </a></li>
  
  <li><a href="<?php echo $objCore->getUrl('product_reviews.php');?>" <?php  echo strpos($menu,'reviews.php')!==FALSE?$act_class:''; ?> id="classR">Reviews 
         <?php if(($notify->wholesaleReview>0)){ ?>   <span class="classRv reviewWholesaler"><?php echo $notify->wholesaleReview;?></span><?php } ?>
      </a></li>
  
  <li><a href="<?php echo $objCore->getUrl('wholesaler_messages_inbox.php',array('place'=>'inbox'));?>" <?php  echo strpos($menu,'wholesaler_messages_inbox.php')!==FALSE||strpos($menu,'wholesaler_outbox_messages.php')!==FALSE||strpos($menu,'wholesaler_compose_message.php')!==FALSE||strpos($menu,'read_inbox_message.php')!==FALSE||strpos($menu,'read_outbox_message.php')!==FALSE?$act_class:''; ?> id="classA">Support 
      <?php if($notify->wholesalerSupport>0){?><span class="classB supportWholesaler"><?php echo $notify->wholesalerSupport;?></span><?php } ?>
      </a></li>
  
  <li><a href="<?php echo $objCore->getUrl('newsletter.php');?>" <?php  echo strpos($menu,'newsletter.php')!==FALSE?$act_class:''; ?> >Newsletters</a></li> 
  <li><a href="<?php echo $objCore->getUrl('bulk_uploads.php');?>" <?php  echo strpos($menu,'bulk_uploads.php')!==FALSE?$act_class:''; ?> >Bulk Uploads</a></li> 
  <li class="last"><a href="<?php echo $objCore->getUrl('manage_special_application.php');?>" <?php  echo strpos($menu,'manage_special_application.php')!==FALSE || strpos($menu,'application_form_special.php')!==FALSE?$act_class:''; ?> >Special Application</a></li> 
</ul>
