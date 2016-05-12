<?php

//**************************ADMIN MESSAGE *****************
define('ADMIN_LOGIN_ERROR', 'Either Username or Password is incorrect.');
define('ADMIN_SESSION_EXPIRED', 'Your session has been expired, please login again.');
define('ADMIN_LOGIN_REQUIRED', 'Your must login to access this page.');
define('ADMIN_INACTIVE_LOGIN', 'Sorry! Your account is inactive.Please contact Administrator at [' . ADMIN_EMAIL . '] for further enquiries.');
define('ADMIN_EMAIL_CHANGE_MSG', 'E-mail has been updated successfully.');
define('ADMIN_SUPPORT_TICKET_TYPE_MSG', 'Support ticket has been updated successfully.');
define('ADMIN_DISPUTED_COMMENT_LIST_MSG', 'Disputed additional comment has been updated successfully.');
define('ADMIN_KPI_SETTING_UPDATE_MSG', 'KPI Setting has been updated successfully.');
define('ADMIN_PRE_KPI_SETTING_UPDATE_MSG', 'Premium wholesaler kpi Setting has been updated successfully.');
define('ADMIN_DEFAULT_COMMISSION_MSG', 'Commission has been updated successfully.');
define('ADMIN_MARGIN_COST_MSG', 'Margin cost has been updated successfully.');
define('ADMIN_DELAY_TIME_MSG', 'Banner delay time has been updated successfully.');
define('ADMIN_SPECIAL_APPLICATION_UPDATED_MSG', 'Special Application Price has been updated successfully.');
define('ADMIN_REWARD_POINTS_UPDATED_MSG', 'Reward points has been updated successfully.');
define('ADMIN_BILLING_AGREEMENT_CHANGE_MSG', 'Billing agreements has been updated successfully.');
define('ADMIN_THEME_CHANGE_MSG', 'Theme has been changed successfully.');
define('ADMIN_WHOLESALER_DATA_CHANGE_MSG', 'Wholesaler data has been changed successfully.');
define('ADMIN_PAGE_LIMIT_CHANGE_MSG', 'Page Limit has been updated successfully.');
define('ADMIN_PAGE_LIMIT_LESSER_MSG', 'Page Limit less then 5 is not allowed.');
define('ADMIN_CHANGE_PASSWORD_ERR', 'Current password is not Correct, Please enter correct one.');
define('ADMIN_CHANGE_PASSWORD_MSG', 'Password has been changed successfully.');
define('ADMIN_SETTING_PAGE_PASSWORD_CHECK', 'Please enter password only using Alpha Numeric and a-z, A-Z, 0-9, -, _, #, @ or ! characters.');
define('ADMIN_NO_DEPARTMENT_INFO', 'No Department Information Available.');
define('ADMIN_DEPARTMENT_EMAIL_UPDATE_SUCCESS_MSG', 'Department Email updated successfully.');
define('INVALID_SECURITY_CODE_MSG', 'Incorrect verification code.');
define('EMAIL_NOT_EXIST_MSG', 'Email address is not correct.');
define('ADMIN_FORGOT_PASSWORD_MSG', 'Password has been sent successfully to your email address.');
define('ADMIN_FORGOT_PASSWORD_LINK_ALREADY_SENT', 'Reset password mail has been already sent to your email address.<br /> Kindly check your inbox/junk folder for the same.');
define('ADMIN_FORGOT_PASSWORD_CONFIRM_MSG', 'Thank You! <br> An email with the link to reset your password has been sent to your email address. Kindly check your email.');
define('ADMIN_PASS_NEW_PASS', 'New Password and Confirm New Password must be same.');
define('EMAILEMAIL_ALREADY_SENT_MSG', 'The account details for this account have been already sent. Kindly check your inbox.');
define('ADMIN_USER_PERMISSION_TITLE', 'Permission Denied!');
define('ADMIN_USER_PERMISSION_MSG', 'You do not have permission to access this page, please refer to your system administrator.');
define('ADMIN_SHIPPING_METHOD_ALREADY_EXISTS', 'Code already exist.');
define('ADMIN_SHIPPING_ALREADY_EXISTS', 'Shipping Code already exist.');
define('ADMIN_SHIPPING_NAME_ALREADY_EXISTS', 'Shipping name already exist.');
define('ADMIN_GATEWAY_ALREADY_EXISTS', 'Shipping gateway already exist.');
define('ADMIN_WHOLESALER_TEMPLATE_SETTING_UPDATE_MSG', 'Wholesaler default template has been updated successfully.');
//----------------------- Admin COMMON MESSAGE ----------------------------------------------------------------
define('ADMIN_ADD_SUCCUSS_MSG', 'Record added successfully');
define('ADMIN_ADD_ERROR_MSG', 'Error while submitting, Please try again.');
define('ADMIN_UPDATE_SUCCUSS_MSG', 'Record updated successfully.');
define('ADMIN_UPDATE_ERROR_MSG', 'Error while updating, Please try again.');
define('ADMIN_DELETE_SUCCUSS_MSG', 'Record deleted successfully.');
define('ADMIN_DELETE_ERROR_MSG', 'Record Not deleted.');
define('ADMIN_CURRENCY_CODE', 'USD');
define('ADMIN_CURRENCY_SYMBOL', '$ ');
define('ADMIN_NO_RECORD_FOUND', 'No record(s) found !');
//----------------------- End Admin COMMON MESSAGE ----------------------------------------------------------------
//----------------------- Admin KPI MESSAGE ----------------------------------------------------------------
define('PERCENTAGE_WARNING1', '97');
define('PERCENTAGE_WARNING2', '96');
define('PERCENTAGE_WARNING3', '95');

define('WARNING1', '1st warning (=' . PERCENTAGE_WARNING1 . '%)');
define('WARNING2', '2nd warning (=' . PERCENTAGE_WARNING2 . '%)');
define('WARNING3', '3rd warning (=' . PERCENTAGE_WARNING3 . '%)');


define('CP_PERCENTAGE_WARNING1', '94');
define('CP_PERCENTAGE_WARNING2', '93');
define('CP_PERCENTAGE_WARNING3', '92');

define('CP_WARNING1', '1st warning (=' . CP_PERCENTAGE_WARNING1 . '%)');
define('CP_WARNING2', '2nd warning (=' . CP_PERCENTAGE_WARNING2 . '%)');
define('CP_WARNING3', '3rd warning (=' . CP_PERCENTAGE_WARNING3 . '%)');
//----------------------- End Admin KPI MESSAGE ----------------------------------------------------------------
//----------------------- Admin CATEGORY MESSAGE ----------------------------------------------------------------
define('ADMIN_CATEGORY_ADD_SUCCUSS_MSG', 'Category has been added successfully');
define('ADMIN_CATEGORY_ADD_ERROR_MSG', 'Error while submitting, Please try again.');
define('ADMIN_CATEGORY_ALREADY_EXISTS', 'Category with entered name already exist.');
define('ADMIN_CATEGORY_UPDATE_SUCCUSS_MSG', 'Category has been updated successfully.');
define('ADMIN_CATEGORY_UPDATE_ERROR_MSG', 'Error while submitting, Please try again.');
define('ADMIN_Order_UPDATE_SUCCUSS_MSG', 'Order has been Updated successfully');
//----------------------- End Admin CATEGORY MESSAGE ----------------------------------------------------------------
//----------------------- Admin CMS MESSAGE ----------------------------------------------------------------
define('ADMIN_CMS_ADD_SUCCUSS_MSG', 'Record added successfully');
define('ADMIN_CMS_ADD_ERROR_MSG', 'Error while submitting, Please try again.');
define('ADMIN_CMS_UPDATE_SUCCUSS_MSG', 'Record updated successfully.');
define('ADMIN_CMS_UPDATE_ERROR_MSG', 'Error while updating, Please try again.');
//----------------------- End Admin CMS MESSAGE ----------------------------------------------------------------
//----------------------- Admin support MESSAGE ----------------------------------------------------------------
define('ADMIN_SUPPORT_ADD_SUCCUSS_MSG', 'Message has been sent successfully.');
define('ADMIN_SUPPORT_ADD_ERROR_MSG', 'Error while submitting, Please try again.');
define('ADMIN_SUPPORT_UPDATE_SUCCUSS_MSG', 'Record updated successfully.');
define('ADMIN_SUPPORT_UPDATE_ERROR_MSG', 'Error while updating, Please try again.');
define('ADMIN_SUPPORT_CUSTOMER_NOT_EXIST', 'Customer email not exist !');
//----------------------- End Admin CMS MESSAGE ----------------------------------------------------------------
//----------------------- Admin Product MESSAGE ----------------------------------------------------------------
define('ADMIN_PRODUCT_ADD_SUCCUSS_MSG', 'Product has been added successfully');
define('ADMIN_PRODUCT_ALREADY_EXISTS', 'Product with entered name already exist.');
define('ADMIN_PRODUCT_UPDATE_SUCCUSS', 'Product details have been updated successfully.');
define('ADMIN_PRODUCT_DEACTIVETED_MESSAGE', 'Selected Product(s) deactivated successfully.');
define('ADMIN_PRODUCT_ACTIVATE_MESSAGE', 'Selected Product(s) activated successfully.');
define('ADMIN_PRODUCT_OFFLINE_MESSAGE', 'Selected Product(s) Offlined successfully.');
define('ADMIN_PRODUCT_DELETE_MESSAGE', 'Selected Product(s) deleted successfully.');
define('ADMIN_PRODUCT_FEATURED_MESSAGE', 'Selected Product(s) Featured successfully.');
define('ADMIN_PRODUCT_UNFEATURED_MESSAGE', 'Selected Product(s) Featured to Normal successfully.');

define('ADMIN_PRODUCT_SEASON_SPECIAL_ACTIVATED_MESSAGE', 'Selected Product(s) Activated Seasonal Product successfully.');
define('ADMIN_PRODUCT_SEASON_SPECIAL_INACTIVATED_MESSAGE', 'Selected Product(s) Inactivated Seasonal Product successfully.');

define('ADMIN_PRODUCT_CLEARANCE_SALE_ACTIVATED_MESSAGE', 'Selected Product(s) Activated Clearance Sale Product successfully.');
define('ADMIN_PRODUCT_CLEARANCE_SALE_INACTIVATED_MESSAGE', 'Selected Product(s) Inactivated Clearance Sale Product successfully.');

define('ADMIN_PRODUCT_BEST_SELLING_ACTIVATED_MESSAGE', 'Selected Product(s) Activated Best Selling Product successfully.');
define('ADMIN_PRODUCT_BEST_SELLING_INACTIVATED_MESSAGE', 'Selected Product(s) Inactivated Best Selling Product successfully.');

define('ADMIN_PRODUCT_NEW_ARRIVALS_ACTIVATED_MESSAGE', 'Selected Product(s) Activated New Arrivals successfully.');
define('ADMIN_PRODUCT_NEW_ARRIVALS_INACTIVATED_MESSAGE', 'Selected Product(s) Inactivated New Arrivals Product successfully.');

define('ADMIN_PRODUCT_HOT_DEAL_ACTIVATED_MESSAGE', 'Selected Product(s) Activated Hot Deal successfully.');
define('ADMIN_PRODUCT_HOT_DEAL_INACTIVATED_MESSAGE', 'Selected Product(s) Inactivated Hot Deal successfully.');
define('ADMIN_EMAIL_PRODUCT_REQUEST_MESSAGE', 'Your Product(s) request has been sent to admin.');
define('ADMIN_EMAIL_FRIEND_EMAIL_SUCCESS_MESSAGE', 'Email has been sent successfully.');

//----------------------- End Admin Product MESSAGE ----------------------------------------------------------------
//----------------------- Admin USERS MESSAGE -----------------------------------------------------------------
define('ADMIN_USER_ADD_SUCCUSS_MSG', 'User has been added successfully.');
define('PORTAL_USER_ADD_SUCCUSS_MSG', 'Country Portal has been added successfully.');
define('ADMIN_USER_SHIPPING_ADDRESS_ADD_SUCCUSS_MSG', 'User shipping address has been added successfully.');
define('ADMIN_USER_BILLING_ADDRESS_ADD_SUCCUSS_MSG', 'User billing address has been added successfully.');
define('ADMIN_USER_SHIPPING_ADDRESS_UPDATE_SUCCUSS_MSG', 'User shipping address has been updated successfully.');
define('ADMIN_USER_BILLING_ADDRESS_UPDATE_SUCCUSS_MSG', 'User billing address has been updated successfully.');
define('ADMIN_USER_UPDATE_SUCCUSS', 'User details have been updated successfully.');
define('PORTAL_USER_UPDATE_SUCCUSS', 'Country Portal details have been updated successfully.');
define('ADMIN_USER_DEACTIVETED_MESSAGE', 'Selected User(s) deactivated successfully.');
define('ADMIN_USER_ACTIVATE_MESSAGE', 'Selected User(s) activated successfully.');
define('ADMIN_USER_DELETE_MESSAGE', 'Selected User(s) deleted successfully.');
define('ADMIN_USER_PRIMARY_EMAIL_ALREADY_EXIST', 'Username is already exists.');
define('ADMIN_USER_NAME_ALREADY_EXIST', 'UserName is already exist.');
define('ADMIN_USE_EMAIL_ALREADY_EXIST', 'Email already exists.');
define('ADMIN_USE_REGION_ALREADY_TAKEN', 'This region has been taken');
define('ADMIN_USE_COUNTRY_ALREADY_TAKEN', 'This Country has been taken');
define('ADMIN_XXX', 'XXXXXX');
define('ADMIN_USE_PASSWORD_NOT_MATCH', 'Password and confirm password do not match.');
define('ADMIN_USE_COUNTRY_ALREADY_EXIST', 'Paypal account already exist for this country.');
define('ADMIN_COMMISION_ARCHIVE_ALREADY_EXIST', 'Archive already exists.');
define('ADMIN_COMMISION_ARCHIVE_ADD_SUCCESS', 'Successfuly moved to Archive kindly Update next Target');
define('ADMIN_ARCHIVE_SUCCUSS_MSG', 'Successfuly moved to Archive');
//----------------------- Admin MAILING LIST MESSAGE ----------------------------------------------------------------
define('ADMIN_MAILING_REQUEST_STATUS_APPROVE_SUCCESS_MSG', 'Request status has been approved successfully');
define('ADMIN_MAILING_REQUEST_STATUS_DISAPPROVE_SUCCESS_MSG', 'Request status has been disapproved successfully.');
define('ADMIN_MAILING_REQUEST_DELETE_SUCCUSS', 'Request has been deleted successfully.');
define('ADMIN_WHOLESALER_STATUS_MSG', 'Wholesaler status has been activated successfully');



//----------------------- Front End Contact Us MESSAGE ----------------------------------------------------------------
define('CONTACT_US_QUERY_SEND_SUCCESS', 'Your query has been sent. We will get back to you as soon as possible.');
define('CONTACT_US_QUERY_SEND_FAIL', 'Message Sending fail.Please try again.');


//----------------------- front User MESSAGE ----------------------------------------------------------------
define('FRONT_USER_ADD_SUCCUSS_MSG', 'You are successfully registered.');
define('FRONT_USER_ADD_ERROR_MSG', 'You are not successfully registered.');
define('WEEKLY_DRAWING_SUCCUSS_MSG', 'You request has been sent successfully.');
define('FRONT_WEEKLY_DRAWING_SUCCUSS_MSG', 'Your request has been submitted sucessfullly. ');
define('FRONT_USER_UPDATE_SUCCUSS', 'Your details have been updated successfully.');
define('FRONT_USER_EMAIL_ALREADY_EXIST', 'Email already exist.');
define('FRONT_WHOLESALER_EMAIL_ALREADY_EXIST', 'Email address already exist.');
define('FRONT_WHOLESALER_DOCUMENT_INVALID', 'Invalid Document Files.');
define('FRONT_WHOLESALER_LOGO_INVALID', 'Invalid logo image.');
define('FRONT_WHOLESALER_SLIDER_IMAGE_INVALID', 'Invalid slider image.');
define('FRONT_USER_NAME_ALREADY_EXIST', 'Email id is already Exist.');
define('FRON_END_USER_EMAIL_EXIST_ERROR', 'Email address does not exist in our database.');
define('FRON_END_USER_FORGET_PASSWORD_SEND', 'Your Login Details has been sent successfully on your email.<br />Please check your email.');
define('FRON_END_USER_LOGIN_ERROR', 'Incorrect user type or user id or password.');
define('FRON_END_USER_LOGIN_ERROR1', 'Incorrect user email or password.');
define('FRON_END_USER_ACCOUNT_DEACTIVATE_ERROR', 'Your account has not been activated.');
define('FRON_END_USER_LOGOUT', 'Successfully logout.');
define('FRONT_USER_UPDATE_SUCCUSS_MSG', 'Profile details have been updated successfully.');
define('FRONT_USER_SCREEN_NAME_AVAIL_MSG', 'Screen Name available.');
define('FRONT_USER_SCREEN_NAME_NOT_AVAIL_MSG', 'Screen Name not available.');
define('PRODUCT_ALREADY_EXIST', 'This product is already available in your saved list.');
define('COMPARE_PRODUCT_ALREADY_EXIST', 'This product is already available in your compare product list.');
define('USER_SUBSCRIPTION_SUCCESS_MSG', 'You are subscribed successfully.');
define('USER_UNSUBSCRIPTION_SUCCESS_MSG', 'You are unsubscribed successfully.');
define('FRONT_END_INVALID_CURENT_PASSWORD', 'Invalid Old Password.');
define('FRONT_END_INVALID_NEW_PASSWORD', 'Current Password and new password is same.');
define('ADDRESS_BOOK_CONTACT_SUCCUSS_MSG', 'Contact has been added successfully to your address book.');
define('WISHLIST_PRODUCT_ADD_SUCCUSS_MSG', 'Product has been added successfully to your saved list.');
define('RATING_PRODUCT_SUCCUSS_MSG', 'Thank you for rating product.');
define('COMPARE_PRODUCT_ADD_SUCCUSS_MSG', 'Product has been added successfully to your compare product list.');
define('USER_PROFILE_UPDATE_SUCCUSS_MSG', 'Your profile has been updated successfully.');
define('ADDRESS_BOOK_CONTACT_ALREADY_EXIST_MSG', 'This contact already exists in your address book.');
define('SELECTED_ADDRESS_SET_DEFAULT_MSG', 'Selected address has been successfully set as default.');
define('FRONT_END_PASSWORD_SUCC_CHANGE', 'Password has been changed successfully.');
define('CART_ITEM_DELETE_SUCC_MSG', 'Selected item has been removed successfully from the cart.');
define('CART_ITEM_MULTIPLE_DELETE_SUCC_MSG', 'Selected items have been removed successfully from the cart.');
define('CART_ITEM_UPDATE_SUCC_MSG', 'Cart items has been updated successfully.');
define('COUPON_NOT_EXIST_MSG', 'Coupon code is not valid.');
define('CART_PRICE_MUST_BE_BIGGER_MSG', 'Price in cart is below than minimum coupon price.');
define('COUPON_CODE_EXPIRED_MSG', 'Your coupon code has been expired.');
define('COUPON_AUTHORIZATION_ACCESS_MSG', 'You are not the authorized user to use this coupon.');
define('DISCOUNT_APPLIED_MSG', 'Discount has been applied successfully.');
define('ADDRESS_BOOK_CONTACT_DELETE_SUCCESS', 'Contact has been deleted successfully.');
define('WISHLIST_PRODUCT_DELETE_SUCCESS', 'Product has been deleted successfully from the list.');
define('ADMIN_ORDER_DELETE_SUCCESS', 'Your order has been deleted successfully.');
define('REVIEW_SUBMIT_MSG', 'Your review has been submitted for approval');
define('FRONT_UPDATE_ERROR_MSG', 'Error while updating, Please try again.');
define('FRONT_DELETE_SUCCUSS_MSG', 'Record deleted successfully.');
define('FRONT_DELETE_ERROR_MSG', 'Record Not deleted.');
define('FRONT_WHOLESALER_COMPOSE_ERROR_MSG', 'User does not exist.');
define('FRONT_WHOLESALER_PRODUCT_LIST_ERROR_MSG1', 'You don\'t have any Product!');
define('FRONT_WHOLESALER_PRODUCT_LIST_ERROR_MSG2', 'No Result Found!');
define('FRONT_WHOLESALER_PRODUCT_LIST_ERROR_MSG3', 'You don\'t have any package yet!');
define('FRONT_WHOLESALER_PRODUCT_LIST_ERROR_MSG4', 'No message to display!');
define('FRONT_WHOLESALER_PRODUCT_LIST_ERROR_MSG5', 'No Newsletter created yet!');
define('FRONT_WHOLESALER_PRODUCT_LIST_ERROR_MSG6', 'No Order yet!');
define('FRONT_WHOLESALER_PRODUCT_LIST_ERROR_MSG7', 'No Review Yet!');
define('FRONT_WHOLESALER_PRODUCT_LIST_ERROR_MSG8', 'No Feedback Given Yet!');
define('FRONT_CUSTOMER_WISHLIST_ERROR_MSG1', 'No Product in saved list!');
define('FRONT_CUSTOMER_ORDERLIST_ERROR_MSG1', 'No Order Placed Yet!');
define('FRONT_FEEDBACK_QUESTION1', 'Have you received the goods in the timeframe mentioned by the wholesaler?');
define('FRONT_FEEDBACK_QUESTION2', 'Does the product match the description provided by the wholesaler?');
define('FRONT_FEEDBACK_QUESTION3', 'Are you happy with the product?');
define('FRONT_USER_ENQUIRY_SUCCUSS_MSG', 'Your enquiry is sent successfully.');
define('FRONT_CUSTOMER_SUPPORT_ERROR_MSG', 'No message to display!');
define('FRONT_END_USER_SUPPORT_EMAIL_SEND', 'Email has been sent successfully.<br />Please check your email.');
define('FRONT_END_FORGET_PASSWORD_SUCCESS_MSG', 'Reset password link have been send to your email ID.');
define('FRONT_END_FORGET_PASSWORD_ERROR_MSG', 'Email ID does not exist.');
define('FRONT_CUSTOMER_DEACTIVE_ERROR_MSG', 'Your account has been deactivated. Please contact Administrator.');
define('FRONT_CUSTOMER_REJECT_ERROR_MSG', 'Your account has been rejected. Please contact Administrator.');
define('FRONT_CUSTOMER_PENDING_ERROR_MSG', 'Your account is pending. Please contact Administrator.');
define('FRONT_CUSTOMER_SUSPEND_ERROR_MSG', 'Your account had been suspended. Please contact Administrator.');
define('FRONT_CUSTOMER_REVIEW_DISPLAY_MSG', 'Thank you for submitted review. Review will be display after approval by Telamela.');
define('FRONT_SUPPORT_DELETE_SUCCUSS_MSG', 'Message deleted successfully.');
define('FRONT_SUPPORT_DELETE_ERROR_MSG', 'Message Not deleted.');
define('FRONT_SUPPORT_SUCCUSS_MSG', 'Message has been sent successfully.');
define('FRONT_SUPPORT_ERROR_INVALID_EMAIL_MSG', 'Customer Email ID not valid.');
define('FRONT_SUPPORT_DELETE_MSG', 'Message deleted successfully.');
define('FRONT_USER_RECOMMEND_EMAIL_SEND', 'Recommended email has been sent successfully.');
define('FRONT_USER_REFERAL_EMAIL_SEND_SUCCESS', 'Referal link has been sent successfully.');
define('FRON_EMAIL_VERIFICATION_SUCCESS', 'Your email successfully Verified ');
define('FRON_EMAIL_VERIFICATION_ERROR', 'url Link is not valid.');
define('EMAIL_NOT_VERIFIED_ERROR_MSG', 'Your Email Id is not verified yet!');
define('EMAIL_NOT_VERIFIED_ERROR_MSGWHOLSALER', 'Your Email Id is not verified yet! <a href="javascript:void(0)" onclick="resendmail()">Click Here For Reactivation Link</a>');
define('EMAIL_NOT_VERIFIED_ERROR_MSGCustomer', 'Your Email Id is not verified yet! <a href="javascript:void(0)" onclick="resendmailcustomer()">Click Here For Reactivation Link</a>');


//----------------------- Admin Coupon MESSAGE ----------------------------------------------------------------
define('ADMIN_COUPON_ADD_SUCCUSS_MSG', 'Coupon has been added successfully');
define('ADMIN_COUPON_ALREADY_EXISTS', 'Coupon with entered name already exist');
define('ADMIN_COUPON_UPDATE_SUCCUSS', 'Coupon details have been updated successfully.');
define('ADMIN_COUPON_DEACTIVETED_MESSAGE', 'Selected Coupon(s) deactivated successfully.');
define('ADMIN_COUPON_ACTIVATE_MESSAGE', 'Selected Coupon(s) activated successfully.');
define('ADMIN_COUPON_NOT_DELETE_MESSAGE', 'You can not delete Coupon as it belong to Product');
define('ADMIN_COUPON_DELETE_MESSAGE', 'Selected Coupon(s) deleted successfully.');
define('ADMIN_COUPON_CODE_SEND_SUCCESS', 'Coupon code has been sent successfully to user.');
//----------------------- End Admin Coupon MESSAGE ----------------------------------------------------------------
//----------------------- Admin Coupon MESSAGE ----------------------------------------------------------------
define('ADMIN_BANNER_ADD_SUCCUSS_MSG', 'Banner has been added successfully');
define('ADMIN_BANNER_ALREADY_EXISTS', 'Banner with entered name already exist.');
define('ADMIN_BANNER_UPDATE_SUCCUSS', 'Banner details have been updated successfully.');
define('ADMIN_BANNER_DEACTIVETED_MESSAGE', 'Selected Banner(s) deactivated successfully.');
define('ADMIN_BANNER_ACTIVATE_MESSAGE', 'Selected Banner(s) activated successfully.');
define('ADMIN_BANNER_NOT_DELETE_MESSAGE', 'You can not delete Banner as it belong to Product.');
define('ADMIN_BANNER_DELETE_MESSAGE', 'Selected Banner(s) deleted successfully.');
//----------------------- End Admin Coupon MESSAGE ----------------------------------------------------------------
//----------------------- Admin Shipping MESSAGE ----------------------------------------------------------------
define('ADMIN_COUNTRY_ADD_SUCCUSS_MSG', 'Country details has been added successfully.');
define('ADMIN_COUNTRY_UPDATED_SUCCUSS_MSG', 'Country details has been updated successfully.');
define('ADMIN_COUNTRY_ACTIVATE_SUCCUSS_MSG', 'Country has been activated successfully.');
define('ADMIN_COUNTRY_DEACTIVATE_SUCCUSS_MSG', 'Country has been deactivated successfully.');

define('ADMIN_COUNTRY_EXIST_MSG', 'Country name already exists in database.');
define('ADMIN_STATE_EXIST_MSG', 'State name already exists in database.');
define('ADMIN_STATE_ADD_SUCCUSS_MSG', 'State details has been added successfully.');
define('ADMIN_COUNTRY_DELETE_SUCCUSS_MSG', 'Country has been deleted successfully.');
define('ADMIN_STATE_UPDATED_SUCCUSS_MSG', 'State details has been updated successfully.');
define('ADMIN_COUNTRY_STATUS_UPDATE_ERROR_MSG', 'You can\'t Inactivate this country as it is associated with the states.');
define('ADMIN_COUNTRY_DELETE_ERROR_MSG', 'You can\'t delete this country as it is associated with the states.');
define('ADMIN_STATE_INACTIVATE_ERROR_MSG', 'You can\'t inactivate this state as it is associated with the shipping cost.');
define('ADMIN_STATE_DELETE_ERROR_MSG', 'You can\'t delete this state as it is associated with the shipping cost.');

define('ADMIN_STATE_INACTIVATE_SUCCESS_MSG', 'State has been inactivated successfully.');
define('ADMIN_STATE_ACTIVATE_SUCCESS_MSG', 'State has been activated successfully.');
define('ADMIN_STATE_DELETE_SUCCESS_MSG', 'State has been deleted successfully.');

define('ADMIN_SEND_COUPON_CODE_SUCCESS_MSG', 'Coupon code has been sent successfully to the user.');

define('ADMIN_SHIPPING_COST_ACTIVATE_SUCCESS_MSG', 'Shipping cost has been activated successfully.');
define('ADMIN_SHIPPING_COST_DEACTIVATE_SUCCESS_MSG', 'Shipping cost has been deactivated successfully.');
define('ADMIN_SHIPPING_COST_DELETE_SUCCESS_MSG', 'Shipping cost has been deleted successfully.');
define('ADMIN_SHIPPING_COST_EXIST_MSG', 'Shipping cost for this location already exists in the database.');

define('ADMIN_DEFAULT_SHIPPING_COST_UPDATE_SUCCESS_MSG', 'Default shipping cost has been updated successfully.');
define('ADMIN_ORDER_STATUS_CHANGED', 'Order Status has been changed successfully.');
define('ADMIN_ORDER_DELETED', 'Order has been deleted successfully.');

//----------------------- End Admin Shipping MESSAGE ----------------------------------------------------------------
//----------------------- Contact MESSAGE ----------------------------------------------------------------
define('CONTACT_SUCCUSS_MSG', 'Your enquiry has been sent successfully.');
define('ADMIN_CONTACT_ACTIVATE_SUCCUSS_MSG', 'Contact details has been activated successfully.');
define('ADMIN_CONTACT_DEACTIVATE_SUCCUSS_MSG', 'Contact details has been deactivated successfully.');
define('ADMIN_CONTACT_DELETE_SUCCUSS_MSG', 'Contact details has been deleted successfully.');
//----------------------- Contact MESSAGE END ----------------------------------------------------------------
//-----------------------Admin Button ----------------------------------------------------------------

define('ADMIN_BACK_BUTTON', 'Back to listing');
define('ADMIN_SUBMIT_BUTTON', 'Submit');
define('ADMIN_ADDMORE_BUTTON', 'Save & Add More');
define('ADMIN_REPLY_BUTTON', 'Reply');
define('ADMIN_SEARCH_CANCEL_BUTTON', 'Cancel');
//-----------------------Admin Button ----------------------------------------------------------------
//-------------------------------------------Email Template---------------------------------------------------------

define('QUANTITY_NOTIFICATION', 'The product below has low quantity. Please order more stock if needed.');
define('QUANTITY_NOTIFICATION_SUBJECT', 'Quantity Notification');
define('ITEM', 'Items');
define('ITEM_IMAGE', 'Items Image');
define('QUANTITY', 'Quantity');
define('THANKYOU_PLACING_ORDER', 'Thank you for placing order.Your Order details');
define('ORDER_ID', 'Order ID');
define('APPLICATION_ID', 'Application ID');
define('TRANJECTION_ID', 'Transaction ID');
define('SUB_ORDER_ID', 'Sub Order ID');
define('PRICE', 'Price');
define('SHIPPING_CHARGE', 'Shipping Charge');
define('DISCOUNT', 'Discount');
define('SUBTOTAL', 'SubTotal');
define('GRAND_TOTAL', 'Grand Total');
define('ORDER_DETAILS', 'TelaMela : Order details');
define('ORDER_STATUS_CHANGES', 'TelaMela : Order status');
define('SPECIAL_EMAIL_SUBJECT', ' Tela Mela – Special Application Request Approval ');
define('SUPPORT_EMAIL_SUBJECT', ' Tela Mela Support ');
define('PLACE_ORDER', 'An order placed on ' . SITE_NAME . '. Order details');
define('AUTO_GENERATED', 'This is auto generated warnig warnig message.');
define('NAME', 'Name');
define('EMAIL_ADDRESS', 'Email Address');
define('MOBILE_NUMBER', 'Contact Number');
define('SUBJECT', 'Subject');
define('MESSAGE', 'Message');
define('REQUIRED_FIELD', 'Please enter required fields!');
define('NEW_MAILING_LIST', 'A new mailing list joining request has been received from the following Email Address');
define('REQUEST_RECEIVED', 'A new request has been received from the following Email Address -');
define('REQUEST_DEFINE', 'Your request has been submitted for admin approval.');



//-------------------------------------------Email Template---------------------------------------------------------
//-------------------------------------------label check INDEX-----------------------------------------------------------

define('INDEX_TITLE', 'Tela Mela');
define('LATEST', 'Latest');
define('PRODUCTS', 'Products');
define('TODAY', 'Today’s');
define('OFFER', 'Offer');
define('OFF', 'Off');
define('TOP_SELLEING', 'Top Selling');
define('ADD_TO_CART', 'Add to Cart');
define('OUT_OF_STOCK', 'Out Of Stock');
define('PRODUCT_DETAILS', 'Product Details');
define('QUICK_OVERVIEW', 'Quick view');
define('PRODUCT_ADD_IN_SHOPING_CART', 'Product has been added to your cart. Go to ');
define('COMP_PRODUCT_ADD_IN_SHOPING_CART', 'Product has been added to your cart');
define('PRODUCT_ADD_IN_SHOPING_CART_OUT_OF_STOCK', 'The quantity you have entered is out of stock');
define('SHOPPING_CART', 'Shopping Cart');
define('CON_SHOPING', 'Continue Shopping');
define('INDEX_TRIUMPH', 'triumph');
define('QTY', 'Quantity');
define('IN_STOCK', 'In Stock');
define('FEATURED', 'Featured');
define('RECENT_VIEW', 'Recently Viewed');
define('TOP_RATED', 'Top Rated');
define('VIEW_MORE', 'View More');
define('VIEW_ALL', 'View All');

//-------------------------------------------label check INDEX-------------------------------------------------------------
//-------------------------------------------label check Registration-------------------------------------------------------------
define('REGISTRATION_TITLE', 'Registration - Customer');
define('CUSTOMER', 'Customer');
define('REGISTRATION', 'Registration');
define('PERSONAL_DETAILS', 'Personal Details');
define('FILED_REQUIRED', 'Fields are required');
define('FIRST_NAME', 'First Name');
define('SCREEN_NAME', 'Screen Name');
define('SCREEN_NAME_MESSAGE','Screen name Should be unique.');
define('EMAIL', 'Email');
define('PASSWORD', 'Password');
define('LAST_NAME', 'Last Name');
define('CONFIRM_EMAIL', 'Confirm Email');
define('CONFIRM_PASSWORD', 'Confirm Password');
define('RECIPIENT_FIRST_NAME', 'Recipient First Name');
define('ORG_NAME', 'Organization Name');
define('ADD_2_ADDRESS', 'Address Line 2');
define('POSTAL_CODE_ZIP', 'Post Code or Zip Code');
define('TOWN', 'Suburb/Town');
define('CUST_TOWN', 'City');
define('REC_LAST_NAME', 'Recipient Last Name');
define('ADD_1_ADDRESS', 'Address Line 1');
define('COUNTRY', 'Country');
define('SPECIAL_EVENT', 'Events');
define('SPECIAL_PRICE', 'Special Price');
define('FINAL_SPECIAL_PRICE_IN_USD', 'Final Special Price in USD: &nbsp;');
define('SPECIAL_PRICE_IN_USD', 'Special Price in USD: &nbsp;');
define('ADD_TO_SPECIAL_EVENT', 'Add to specials/events/festivals');
define('SPECIAL_DATE', 'Date');
define('COUNTRY_REQ_MSG', 'Country required!');
define('TYPE_REQ_MSG', 'Type required!');
define('PHONE', 'Phone');
define('SHIPPING_ADD', 'Shipping Address');
define('BUSINESS_ADD', 'This is a Business Address');
define('BILLING_ADDRESS', 'Billing Address');
define('RES_ADDRESS', 'Residential Address');


//-------------------------------------------label check Registration-------------------------------------------------------------
//-------------------------------------------LABEL CHECK TOP HEADER-------------------------------------------------------------

define('MY_CART', 'My Cart');
define('SEND_GIFT', 'Send a Gift Card');
define('SUBSCRIBE', 'Subscribe');
define('MY_AC', 'My Account');
define('MY_PASS', 'My Password');
define('MY_OR', 'My Orders');
define('MY_WISH', 'My Saved List');
define('SUPP', 'Support');
define('WH_NEW', "What's New");
define('SI_OUT', 'Sign Out');
define('LOGIN', 'Login');
define('SI_IN', 'Sign In');
define('SIGN_UP', 'Sign Up');
define('NEW_U_SI', 'New User? Sign Up');
define('WHOLESALER', 'Wholesaler');
define('LOGISTIC', 'Logistic');
define('EM_ID', 'Email Id');
define('CHOOSE_FOLLOWING', 'Choose one of the following');
define('WHOLESALER_BUTTON', 'Click on the Wholesaler button, if you want to fill the application form for Wholesaler account.');
define('EM_GIFT_CARD', 'Email Gift Card.');
define('MAIL_DEL', 'Mail Delivery Date');
define('FORGOT_PASSWORD', 'Forgot your password?');


//-------------------------------------------LABEL CHECK TOP HEADER-------------------------------------------------------------
//-------------------------------------------LABEL CHECK Wholsaler-------------------------------------------------------------

define('WHOL_TITLE', 'Application form - Wholesaler');
define('APP_FORM', 'Application form');
define('COM_NAME', 'Company Name');
define('ABT_COM', 'About Company');
define('PRIVACY_POLICY', 'Privacy Policy');
define('MIN_200', '(minimum 200 words required)');
define('BUS_PLAN', 'Business plan document');
define('WH_LOGO', 'Logo');
define('WH_LOGO_HEIGHT_WIDTH', '(180x90)');
define('WH_SLIDER_IMAGE', 'Slider Images');
define('WH_SLIDER_IMAGE_HEIGHT_WIDTH', '(820x310) [3 images can display]');
define('WH_FACEBOOK', 'Facebook');
define('WH_TWITTER', 'Twitter');
define('WH_LINKEDIN', 'LinkedIn');
define('WH_RSS', 'Rss');
define('WH_GOOGLEPLUS', 'Google+');
define('OPTION_BROW', '(Optional,  browse / upload document)');
define('OPTION_BROW_DOC', '(Optional/Allowed extension are:- jpg, jpeg, gif, png, doc, docx, ods, pdf, xls, xlsx)');
define('SERV', 'Services');
define('COM_ADD', 'Company Address');
define('CITY', 'City');
define('POS_CODE', 'Postal Code');
define('LOG_EMAIL', 'Login Email');
define('PAY_EMAIL', 'Paypal Email');
define('FEX', 'Fax');
define('TIMEZONE', 'Time zone');
define('REGION', 'Region');
define('HELP', 'help');
define('WB', 'Website');
define('COM_ADD2', 'Company Address2');
define('OP', '(Optional)');
define('COM_ADD3', 'Company Address3');
define('POS_ADD', 'Postal Address');
define('POS', 'Position');
define('OWNER_INFOR', 'Director/Owner Information');
define('TRADE_REF', 'Trade Reference');
define('REF_MUST', ' (3 References must Required) ');
define('REF_1', 'Reference 1');
define('REF_2', 'Reference 2');
define('REF_3', 'Reference 3');
define('BUS_DOC', 'Business Documents');
define('ADD_MORE', 'Add More');
define('DOC_1', 'Document 1');
define('DOC_2', 'Document 2');
define('DOC_3', 'Document 3');
define('BUS_REGIS', '(Business Registration Certificate must)');
define('SUBMIT', 'Submit');
define('ADD', 'Add');
define('CON_PERSON', 'Contact Person');
define('SEL_CON', 'Select Country');
define('SEL_REG', 'Select Region');
define('SEL_TIMEZONE', 'Select Time Zone');
define('SEL', 'Select');
define('SEND_APPLICATION_FORM', 'Create Special Application');
define('SPECIAL_APPLICATION', 'Special Application');
define('SPECIAL', 'Special');
define('APPLICATION', 'Application');

//-------------------------------------------LABEL CHECK Wholsaler-------------------------------------------------------------
//-------------------------------------------LABEL CHECK Shoping cart-------------------------------------------------------------

define('SHIPPING_TITLE', 'Shopping Cart');
define('SHOPPING', 'Shopping');
define('CART', 'Cart');
define('EMPTY_CART', 'Your shopping cart is empty!');
define('CONTI', 'Keep/Continue Shopping');
define('PROCESSED_TO', 'Proceed to Checkout');
define('UNIT_P', 'Product Price');
define('PRICE', 'Price');
define('BY', 'By');
define('PACKAGE', 'Wholesaler');
define('PACKAGE1', 'Package');
define('GIFT_CARD', 'Gift Card');
define('COUPON_CODE', 'Coupon Code');
define('ENTER_CODE', 'Enter your code here');
define('APPLY', 'Apply Coupon');
define('CLEAR_SHOP', 'Clear Shopping Cart');
define('UPDATE_SHOP', 'Update Shopping Cart');
define('COUPON', '(Coupon)');

//-------------------------------------------LABEL CHECK Shoping cart-------------------------------------------------------------
//-------------------------------------------LABEL CHECK Category-------------------------------------------------------------

define('CATEGORY_TITLE', 'Category');
define('CATEGORY_LANDING_TITLE', 'Category Landing Page');
define('REFINE', 'Refine');
define('RESULT', 'Results');
define('ENTER_KEY', 'Enter your keywords...');
define('ALL', 'All');
define('CATEGORY_PR_1', '$0.00- $49.00');
define('CATEGORY_PR_2', '$50.00- $99.00');
define('CATEGORY_PR_3', '$100.00 and above');
define('RECENT_ADD', 'Recently Added');
define('A-Z', 'A-Z');
define('Z-A', 'Z-A');
define('AZ', 'A-Z');
define('ZA', 'Z-A');
define('PRICE_LOW', 'Price (Low > High)');
define('PRICE_HIGH', 'Price (High > Low)');
define('POPULARITY', 'Popularity');
define('COMPARE', 'Compare');
define('NO_PRODUCT', 'No Products Available');



//-------------------------------------------LABEL CHECK Category-------------------------------------------------------------
//------------------------------------------LABEL CHECK Header.inc--------------------------------------------------------------

define('CURRENCY', 'Currency');
define('SL_CAT', 'Select Category');
define('SEARCH_FOR_BRAND', 'Search for a wholesaler, product or a specific item');
define('SEARCH_BY', 'Search by ');

//------------------------------------------LABEL CHECK Header.inc--------------------------------------------------------------
//------------------------------------------LABEL CHECK contact us--------------------------------------------------------------

define('CONTACT_TITLE', 'Contact');
define('REWARDS', 'Rewards');
define('NO_REWARDS', 'No Rewards');
define('US', 'Us');
define('SEL_SUB', 'Select Subject');
define('OFFICE_ADD', 'Office Address');
define('ADD1', 'Address1');
define('ADD2', 'Address2');
define('DUMMY_TEXT', 'Lorem Ipsum is simply Lorem Ipsum');
define('RESET', 'Reset');
define('PAGE', "Page");
define('CONTACT_EMAIL', 'abc@xyz.com');
define('CONTACT_PHONE', '2123456458');
define('NO_STATE', 'No State Found');
define('NO_CONDITION', 'No condition Found');

//------------------------------------------LABEL CHECK contact us--------------------------------------------------------------
//-------------------------------------------Payment Process-------------------------------------------------------------
define('SUCCESS_MESSAGE_GIFTCARD_APPLIED', 'Gift Card has been applied successfully.');
define('ERROR_MESSAGE_GIFTCARD_NOT_EXIST', 'This Gift Card does not exists.');
define('SUCCESS_MESSAGE_REWARDS_APPLIED', 'Reward points have been applied successfully.');
define('ERROR_MESSAGE_REWARDS_NOT_APPLIED', 'Reward points have not applied.');
define('PAYMENT_PAYNOW_BUTTON', 'Pay Now');
//-------------------------------------------label check JS-------------------------------------------------------------
//------------------------------------------LABEL CHECK Dashboard Customer--------------------------------------------------------------

define('DASHBOARD_CUSTOMER_AC', 'Dashboard-Customer-Account');
define('AC', 'Account');
define('EDIT_AC', 'Edit My Account');
define('EDIT_PS', 'Edit Password');
define('CHANGE_PS', 'Change Password');
define('REFER_YOUR_FRIEND', 'Refer Friends');

//------------------------------------------LABEL CHECK Dashboard Customer--------------------------------------------------------------
//------------------------------------------LABEL CHECK Edit Password--------------------------------------------------------------

define('EDIT_PASSWORD_TITLE', 'Edit Password - Customer');
define('EDIT', 'Edit');
define('CHANGE', 'Change');
define('BACK', 'Back');
define('CUR_PASS', 'Current Password');
define('NEW_PASS', 'New Password');
define('CON_NEW_PASS', 'Confirm New Password');
define('UPDATE', 'Update');
define('CANCEL', 'Cancel');


//------------------------------------------LABEL CHECK Edit Password--------------------------------------------------------------
//------------------------------------------LABEL CHECK Edit Account--------------------------------------------------------------

define('EDIT_ACCOUNT_TITLE', 'Customer Profile');
define('UPDATE_STATUS', 'update successfully.');
define('UPDATE_STATUS_NOT', 'You Can not Cancel order.');


//------------------------------------------LABEL CHECK Account--------------------------------------------------------------
//------------------------------------------LABEL CHECK Product--------------------------------------------------------------

define('PRODUCT_SHARE_SUCC', 'Product share successfully !');
define('CUS_REVIEW', 'Review');
define('WRITE_REVIEW', 'Write a Review');
define('RECOMMEN', 'Recommend');
define('Y_NAME', 'Your Name');
define('REFERAL_LINK', 'Referal Link');
define('Y_EMAIL', 'Your Email');
define('FR_EMAIL', "Friend's Email");
define('COMMA_SAP', 'please write emails with commas separated');
define('REQUIRED', 'required!');
define('WISHLIST', 'saved list');
define('DETAILS', 'Details');
define('MAXDETAILS', 'Max 2000 character');
define('REC_BUY', 'Recent Buyers');
define('T_M', 'Terms &amp; Conditions');
define('BUY_NAME', 'Buyer Name');
define('DATE_OF_PUR', 'Date of Purchase');
define('NO_REC_BUYER', 'No recent buyers');
define('SAVE', 'Save');
define('PRODUCT_NO_EXIS', 'Product does not exist !');
define('ABOUT', 'About');
define('T_WHOL', 'the Wholesaler');
define('REVIEW', 'Review');
define('Y_RAT', 'Your Rating');
define('YOU_HAVE_RATED', 'You have rated this product. Do you want to change your rating?');
define('CONFIRM', 'Confirm');
define('COMMUNITY', 'Community');
define('WHO_BOUGHT', 'who bought this also bought');
define('SEARCH_GOOD', 'Search goods in');
define('STORE', 'Store');
define('KEYWORDS', 'Keywords');
define('SEND', 'Send');
define('HOT', 'Hot');
//------------------------------------------LABEL CHECK Product--------------------------------------------------------------
//------------------------------------------LABEL CHECK Footer--------------------------------------------------------------


define('ALL_RESERVE', '&#169; 2013 telamela. All Rights Reserved.');
define('SUBSCRIPTION', 'Subscription');
define('ENTER_EMAIL', 'Enter your email');
define('TEST_MESSAGE', 'Enter a valid email address');
define('LESS', 'Less');
define('MORE', 'More');

//------------------------------------------LABEL CHECK Footer--------------------------------------------------------------
//------------------------------------------LABEL CHECK My Order--------------------------------------------------------------


define('MY_ORDER_TITLE', 'My Orders');
define('MY', 'My');
define('ORDERS', 'Orders');
define('TOTAL_PRICE', 'Total Price');
define('OR_DATE', 'Order Date');
define('STATUS', 'Status');
define('INVOICE', 'Invoice');
define('ORDER_DISPUTED_SUCCESS_MESSAGE', 'Order Mark as Disputed successfuly');
define('ORDER_DISPUTED_FEEDBACK_SUCCESS_MESSAGE', 'Order disputed comment sent successfuly');
define('ORDER_DISPUTED_BY_CUSTOMER', 'Order Mark as Disputed By Customer. ');
define('ORDER_DISPUTED_FEEDBACK_BY_CUSTOMER', 'Customer sent feedback on  disputed order. ');
define('ORDER_DISPUTED_BY_WHOLESALER', 'Order Mark as Disputed By Wholesaler. ');
define('ORDER_DISPUTED_FEEDBACK_BY_WHOLESALER', 'Wholesaler sent feedback on disputed order. ');
define('ORDER_DISPUTED_BY_COUNTRY_PORTAL', 'Order Mark as Disputed By Country Portal. ');
define('ORDER_DISPUTED_FEEDBACK_BY_COUNTRY_PORTAL', 'Admin sent feedback on disputed order. ');


//------------------------------------------LABEL CHECK My Order--------------------------------------------------------------
//------------------------------------------LABEL CHECK My Wishlist--------------------------------------------------------------


define('MY_WISH_TITLE', 'My Wish List');
define('MY_WISH_SUB', 'My Wish');
define('MY_LIST', 'List');
define('PROD_NAME', 'Product Name');
define('PROD_PACKAGE', 'Linked To Product');
define('PROD_IMAGE', 'Product Image');
define('DATE', 'Date');
define('ACTION', 'Action');
define('R_U_SURE', 'Are you sure you want to delete this product from saved list?');

//------------------------------------------LABEL CHECK My Wishlist--------------------------------------------------------------
define('MY_REWARDS_TITLE', 'My Rewards Summary');
define('MY_REWARDS', 'My Rewards');
define('SUMMERY', 'Summary');
define('CREDIT_REWARDS', 'Credit Rewards');
define('DEBIT_REWARDS', 'Debit Rewards');
define('REWARDS_SUMMERY', 'Rewards Summary');
define('POINTS', 'Points');
define('TRANSTION_TYPE', 'Transaction Type');

//------------------------------------------LABEL CHECK My Rewards--------------------------------------------------------------
define('NO_SHIPPING_METHOD_FOUND', 'No shipping method found.');

define('MY_WISH_TITLE', 'My Wish List');


//------------------------------------------LABEL CHECK My Rewards--------------------------------------------------------------
//------------------------------------------LABEL CHECK Message Inbox--------------------------------------------------------------

define('MESSAGE_INBOX_TITLE', 'Messages - Inbox');
define('INBOX', 'Inbox');
define('OUTBOX', 'Sent Mail');
define('COMPOSE', 'Compose Mail');
define('TICK_ID', 'Ticket Id');
define('REC', 'Recipient');
define('TIME', 'Time');
define('VIEW_MESSAGE', 'Click to View Message');
define('WANT_DELETE', 'Do you want to delete this message ?');
//------------------------------------------LABEL CHECK Message Inbox--------------------------------------------------------------
//------------------------------------------LABEL CHECK Message Outbox--------------------------------------------------------------

define('MESSAGE_OUTBOX_TITLE', 'Messages - Outbox');

//------------------------------------------LABEL CHECK Message Outbox--------------------------------------------------------------
//------------------------------------------LABEL CHECK Message Compose--------------------------------------------------------------

define('MESSAGE_COMPOSE_TITLE', 'Compose a Message');
define('COMPOS_MAIL', 'Compose Mail');
define('TO', 'To');
define('ADMIN', 'Admin');
define('TYPE', 'Type');

//------------------------------------------LABEL CHECK Message Compose-------------------------------------------------------------- 
//------------------------------------------LABEL CHECK Message View Inbox--------------------------------------------------------------

define('MESSAGE_VIEW_INBOX_TITLE', 'View Inbox message');
define('MESSAGE_READ_INBOX_TITLE', 'Read Inbox message');
define('MESSAGE_READ', 'Read message');
define('REPLY', 'Reply');
define('SENDER', 'Sender');
define('SUPPORT_TYPE', 'Support Type');


//------------------------------------------LABEL CHECK Message View Inbox-------------------------------------------------------------- 
//------------------------------------------LABEL CHECK Wholesaler Dashboard----------------------------------------------------------

define('WHOLESALER_DASHBOARD_TITLE', 'Dashboard - Wholesaler Account');
define('KPI', 'KPIs');
define('WAR', 'Warning!');
define('NO_WAR', 'No Warnings!');


//------------------------------------------LABEL CHECK Wholesaler Dashboard-----------------------------------------------------------
//------------------------------------------LABEL CHECK Edit AC Wholesaler ---------------------------------------------------------- 

define('EDIT_WHOLESALER_TITLE', 'Edit My Account-Wholesaler');
define('COMP_EMAIL', 'Company Email ');

//------------------------------------------LABEL CHECK Edit AC Wholesaler -----------------------------------------------------------
//------------------------------------------LABEL CHECK MANAGE PRODUCT Wholesaler ----------------------------------------------------

define('MANAGE_PRODUCT_TITLE', 'Manage Products');
define('MANAGE', 'Manage');
define('ADD_MULTI_PRODUCT', 'Add Multiple Products');
define('SRCH_PRODUCTS', 'Search Product');
define('PRO_REF_NO', 'Product Ref No');
define('DIS_PRICE', 'Discounted Price');
define('SURE_DEL_PRODUCT', 'Are you sure you want to delete this product?');
define('OFFER_DEL_PRODUCT', 'This product is associated with today offer.You can not delete this.Please contact administrator.');
define('THIS_PRODUCT_USE_IN_PACKAGE', 'This product is used in a package.Please update Package and delete it.\n Would you sure to update packege ?');
//------------------------------------------LABEL CHECK MANAGE PRODUCT Wholesaler ----------------------------------------------------
//------------------------------------------LABEL CHECK Add Multiple product Wholesaler ----------------------------------------------

define('WHOLESALER_ADD_MULTI_PRODUCT_TITLE', 'Manage Products');
define('SHIPPING_GATEWAY', 'Shipping Gateway');
define('IN_D', '(in $)');
define('FIN', 'Final');
define('UPLOAD_IMAGE', 'Upload Image (600x600)');
define('SEL_PACK', 'Select Package');
define('SEL_EVENT', 'Event');
define('SEL_EVENT_FRM', 'Select Event');
define('STOCK_QUAN', 'Stock Quantity');
define('STOCK_ALERT', 'Stock Quantity Alert');
define('SEND_ALERT_MESSAGE', 'Sent alert message when quantity is');
define('WAIGHT', 'Weight');
define('DIMEN', 'Dimensions&nbsp;(L&nbsp;x&nbsp;W&nbsp;x&nbsp;H)');
define('TC', 'Terms & Conditions');
define('YOUTUBE_EMB', 'Youtube Embedd Code');
define('META_TITLE', 'Meta Title');
define('META_KEY', 'Meta Keywords');
define('META_DES', 'Meta Description');
define('HTML_EDI', 'More Details');
define('SEL_SHIIP', 'Select Shipping');
define('HOME_SLIDER', 'Home Slider Image (800x600)');
define('DEF_IMAGE', 'Default Image (600x600)');
define('PRO_IMAGE_600_800', 'Product Images (600x600)');
define('SEL_CAT', 'Select Category');
define('ATTR', 'Attributes');
define('ATTR_INVTRY', 'Attributes Inventory');
define('ADD_ATTR', 'Add Attribute');
define('SEL_ATTR', 'Select Attributes');
define('CENTI', 'Centimeter');
define('MILLI', 'Millimeter');
define('INCH', 'Inch');
define('HIDE_OPEN_EDITOR', 'Please hide open editor !');
define('MANDATORY', 'Indicates mandatory fields.');
define('NOTE', 'Note');



//------------------------------------------LABEL CHECK Add Multiple product Wholesaler ----------------------------------------------
//------------------------------------------LABEL CHECK Add Edit product Wholesaler ----------------------------------------------

define('ADD_EDIT_PRODUCT_TITLE', 'Add/Edit Product');
define('SPECIAL_APPLICATION_FORM_TITLE', 'Special Application form');
define('ADD_EDIT_PRODUCT_PRICE_TITLE', 'Add/Edit Product Price');
define('ADD_EDIT_PRODUCT_INVENTORY_TITLE', 'Add/Edit Product inventory');
define('WHOL_PRICE', 'Wholesale Price');
define('SEL_CURR', 'Choose Currency');
define('PRICE_IN_USD', 'Price in USD: &nbsp;');
define('FINAL_PRODUCT_PRICE', 'Final Product Price (in USD):&nbsp;');
define('NO_ATTR', 'There is no attribute in this category !');
define('CREATE_NEW_PACKAGE', 'Create New Package');
define('KIL', 'Kilogram');
define('GRA', 'Gram');
define('POU', 'Pound');
define('OUN', 'Ounce');
define('UP_PRODUCTS', 'Upload Products');
define('ADD_NEW_PACKAGE', '<span>Add</span> New Package');
define('PACKAGE_NAME', 'Package Name');
define('ORG_PRICE', 'Original Price');
define('PRO_1', 'Product 1');
define('PRO_2', 'Product 2');
define('OFF_PRICE', 'Offer Price');

//------------------------------------------LABEL CHECK Add Edit product Wholesaler ----------------------------------------------
//------------------------------------------LABEL CHECK Bulk Upload product Wholesaler ----------------------------------------------

define('BULK_UPLOAD_TITLE', 'Bulk Uploads');

define('BULK', 'Bulk');

define('UPLOADS', 'Uploads');

define('SEL_WANT_UPLOAD', 'Select what you want to upload');

define('DOWNLOAD', 'Download');

define('CSV_SAM', 'CSV Sample');


define('XLS_SAM', 'XLS Sample');

define('SHIPP_METHOD', 'Shipping Method');
define('NO_SHIPP_METHOD_AVAIL', 'Sorry, we are not shipping to your region at this time.');

define('ST_QUAN', 'Stock Quanity');
define('ALERT_ON_QUAN', 'Aleret on Quanity');

define('DIMEN_UNIT', 'Dimension Unit');


define('LENG', 'Length');

define('HEIGHT', 'Height');

define('WIDTH', 'Width');

define('WEIGHT_UNIT', 'Weight Unit');
define('WEIGHT_HELP_UNIT', '(Ex: kg (i.e "Kilogram") / g (i.e "Gram") / lb (i.e "Pound") / oz (i.e "Ounce")');
define('DIMEN_HELP_UNIT', '(Ex: cm (i.e "Centimeter") / mm (i.e "Millimeter") / in (i.e "Inch")');
define('ATTR_SHOULD', '(Ex: Attributes should be:: AttrCode1 (i.e "Size")#Opt1 (i.e "Large")=price1 (i.e "20.00")=img1 (i.e "1.jpg")|Opt2 (i.e "small")=price2 (i.e "10.00")=img2 (i.e "2.jpg");AttrCode2 (i.e "Color")#Opt1 (i.e "Red")=price1 (i.e "10.00")|Opt2 (i.e "Yellow")=price2 (i.e "5.00"))');
define('ATTR_INVTRY_SHOULD', '(Ex: should be:: AttrCode1 (i.e "Size")#Opt1 (i.e "Large")|AttrCode2 (i.e "Color")#Opt1(i.e "Red")=qty1 (i.e "5");AttrCode1 (i.e "Size")#Opt1 (i.e "Large")|AttrCode2 (i.e "Color")#Opt2 (i.e "Red")=qty2 (i.e "5");AttrCode1#Opt2|AttrCode2#Opt1=qty3;AttrCode1#Opt2|AttrCode2#Opt2=qty4)');

define('PRO_DES', 'Product Description');


define('PRO_TERMS', 'Product Terms');


define('YOUTUBE_CODE', 'Youtube Code');

define('PRO_SLI_IMG', 'Home Slider Image (800x600)');
define('PRO_DEF_IMG', 'Default Image (600x600)');
define('PRO_IMG', 'Product Images (600x600)');
define('PACK_PRICE', 'Package Price');
define('PACK_IMG', 'Package Image');

define('BR_CSV', 'Browse CSV/XLS');
define('BR_IMG', 'Please upload a zip file of images.');


define('SKIP_ROW', 'Skip First Row');

//------------------------------------------LABEL CHECK Bulk Upload product Wholesaler ----------------------------------------------
//------------------------------------------LABEL CHECK Manage Package Wholesaler ----------------------------------------------

define('MANAGE_PACKAGE_TITLE', 'Manage Packages');

define('R_U_SURE_DELETE_PACKAGE', 'Are you sure you want to delete this package!');

//------------------------------------------LABEL CHECK Manage Package Wholesaler ----------------------------------------------
//------------------------------------------LABEL CHECK Add New Package Wholesaler ----------------------------------------------

define('ADD_PACKAGE_TITLE', 'Add New Package');

define('CREATE', 'Create');

define('A_NEW_PACK', 'a new Package');

define('SEL_PRO_1', 'Choose Product 1');

define('SEL_PRO_2', 'Choose Product 2');

define('ADD_MORE_PRODUCT', 'Add More Product');

define('UPLOAD_PACKAGE_IMAGE', 'Upload Package Image');


//------------------------------------------LABEL CHECK Add New Package Wholesaler ----------------------------------------------
//------------------------------------------LABEL CHECK Edit Package Wholesaler ----------------------------------------------

define('EDIT_PACKAGE_TITLE', 'Edit Package');

define('SEL_PRO', 'Choose Product');

define('NO_FILE', 'No file selected...');

define('BROW', 'Browse...');


//------------------------------------------LABEL CHECK Edit Package Wholesaler ----------------------------------------------
//------------------------------------------LABEL CHECK Customer Order Wholesaler ----------------------------------------------

define('CUS_ORDER_TITLE', 'Customer Orders');
define('UPDATE_SUCC', 'Updated successfully');
define('SEARCH_ORDER', 'Search Order');
define('ORDER_STATUS', 'Order Status');
define('SEL_ORDER_STATUS', 'Select Order Status');
define('PEN', 'Pending');
define('DEL', 'Posted');
define('COM', 'Completed');
define('CANCELED', 'Canceled');
define('DISPUTED', 'Disputed');
define('DISPUTE_RESOLVED', 'Dispute Resolved');
define('ST_DATE', 'Start Date');
define('SEARCH_PACKAGE', 'Search Package');



//------------------------------------------LABEL CHECK Customer Order Wholesaler ----------------------------------------------
//------------------------------------------LABEL CHECK Customer Order Details Wholesaler ----------------------------------------------
define('ORDER_DETAILS_TITLE', 'Order Details');
define('SEND_INVOICE_TELA', 'Send Invoice To Telamela');
define('AC_INFO', 'Account Information');
define('CUS_NAME', 'Customer Name');
define('CUS_EMAIL', 'Customer Email');
define('BILL_INFO', 'Billing Information');
define('SHIPP_INFO', 'Shipping Information');
define('COMM_HIS', 'Comments History');
define('SHIPP_HAND', 'Shipping &amp; Handling');


//------------------------------------------LABEL CHECK Customer Order Details Wholesaler ----------------------------------------------
//------------------------------------------LABEL CHECK Customer FeedBack Wholesaler ----------------------------------------------

define('FEEDBACK_TITLE', 'Customer Feedbacks');
define('FEED', 'Feedbacks');
define('PRO_ID', 'Product ID');
define('FEED_DATE', 'Feedback Date');
define('REED_FEED', 'Read Feedback');
define('COMMENTS', 'Comments');

//------------------------------------------LABEL CHECK Customer FeedBack Wholesaler ----------------------------------------------
//------------------------------------------LABEL CHECK Customer INVOICE Wholesaler ----------------------------------------------

define('CUS_INVOICE_TITLE', 'Manage Invoice');
define('SEARCH_INVOICE', 'Search Invoice');
define('INV_ID', 'Invoice ID');
define('INV_DATE', 'Invoice Date');
define('ORDER_DATE', 'Order Date');
define('AMT_PAY', 'Amount Payable');
define('AMT_DUE', 'Amount Due');
define('PARTIAL', 'Partial');


//------------------------------------------LABEL CHECK Customer INVOICE Wholesaler ----------------------------------------------
//------------------------------------------LABEL CHECK Customer Product Review Wholesaler ----------------------------------------------


define('REVIEW_TITLE', 'Product Reviews');
define('PRO_CAT', 'Product Category');


//------------------------------------------LABEL CHECK Customer Product Review Wholesaler ----------------------------------------------
//------------------------------------------LABEL CHECK Customer Product READ Review Wholesaler ----------------------------------------------


define('READ_REVIEW_TITLE', 'read reviews');
define('READ', 'Read');
define('REVIEWER_NAME', 'Reviewer Name');
define('ALLOW', 'Allow');
define('DISALLOW', 'Disallow');

//------------------------------------------LABEL CHECK Customer Product READ Review Wholesaler ----------------------------------------------
//------------------------------------------LABEL CHECK Customer NewsLetter Wholesaler -------------------------------------

define('NEWSLETTER_TITLE', 'Newsletter');
define('NEWSLETTER', 'Newsletter');
define('TITLE', 'Title');
define('CREATE_NEWS', 'Create Newsletter');
define('ADD_COMPARE', 'Add to Compare');
define('ADD_WISH', 'Add to Save List');
define('SEL_SHIPP_GAT', 'Choose Shipping Gateway(s)');
define('SEL_TEMPLATE_DEFAULT', 'Choose default template');


//------------------------------------------LABEL CHECK Customer NewsLetter Wholesaler -------------------------------------
//------------------------------------------LABEL CHECK Customer NewsLetter Review Wholesaler -------------------------------------

define('NEWSLETTER_REVIEW_TITLE', 'View Newsletter');
define('VW', 'View');
define('CONTENT', 'Content');
define('TEMPLATE', 'Template');


//------------------------------------------LABEL CHECK Customer NewsLetter Review Wholesaler -------------------------------------
//------------------------------------------LABEL CHECK Customer Create NewsLetter Wholesaler -------------------------------------

define('NEWSLETTER_CREATE_TITLE', 'Create Newsletter');
define('ACCPT_IMAGE', 'Accepted Image formats are: jpg, jpeg, gif, png');
define('OR_COM', 'OR');
define('SEND_TO', 'Send To');
define('PL_SL_ONE', 'Please select at least one Recipient');
define('UN_SL_ALL', 'UnSelect All');
define('ID', 'ID');
define('SNO', 'SNo.');
define('MAM_SIN', 'Member Since');
define('VING', 'Viewing');
define('SORT_BY', 'Sort by');
define('POPULAR', 'Popular');
define('SCH_DEL_DATE', 'Schedule Delivery Date');
define('SCH_DEL_TIME', 'Schedule Delivery Time');
define('HH', 'HH');
define('MM', 'MM');


//------------------------------------------LABEL CHECK Customer Create NewsLetter Wholesaler -------------------------------------
//------------------------------------------LABEL CHECK wholeseler Create NewsLetter Wholesaler -------------------------------------

define('WHOL_INBOX_TITLE', 'Messages - Inbox');
define('CHOOSE', 'Choose');
define('PLZ_SEL', 'Please Select');
define('VIEW_INV', 'View Invoice');

//------------------------------------------LABEL CHECK wholeseler Create NewsLetter Wholesaler -------------------------------------


define('SHIPMENT_ADD_SUCCESS', 'Shipment added successfully');
define('SHIPMENT_ADD_ERROR', 'Shipment not added successfully');
define('SHIPMENT_UPDATE_SUCCESS', 'Shipment updated successfully');
define('SHIPMENT_UPDATE_ERROR', 'Shipment not updated successfully');
define('SHIPMENT_DELETE_SUCCESS', 'Shipment Delete successfully');


//--------------------------------------------  Ajax--------------------------------------------------------------

define('NO_COLOR', 'No Color Found');
define('XL', 'XL');
define('CHECKOUT', 'Checkout');
define('NO_ITEMS_ADD', 'No items added into the cart');
define('OF', 'of');
define('REMOVE_LIST', 'Remove from the list');
define('RECOMEN_BY', 'Recomended by');
define('PEOPLE', 'people');
define('SEL_WHOL', 'Select Wholesaler');
define('CLOSE', 'Close');
define('PRINT_DATA', 'Print');


//--------------------------------------------  Ajax--------------------------------------------------------------
//--------------------------------------------  Billing & shipping Address----------------------------------------

define('BILL_SHIPP_ADD', 'Billing &amp; Shipping Address');
define('BILL_SHIPP', 'Billing &amp; Shipping');
define('ADDRESS', 'Address');
define('SAME_BILLING_ADDRESS', 'Same as Billing Address');
define('SAME_RES_ADDRESS', 'Same as Residential Address');


//--------------------------------------------  Billing & shipping Address----------------------------------------
//--------------------------------------------  Checkout ----------------------------------------

define('CHECKOUT_TITLE', 'Checkout');
define('EXIST_CUS', 'Existing Customer?');
define('REMEMBER_ME', 'Remember me');
define('FORGOT_PASS', 'Forgot password ?');
define('NEW_CUS', 'New Customer?');


//--------------------------------------------  Checkout ----------------------------------------
//--------------------------------------------  Compose----------------------------------------

define('COMPOSE_TITLE', 'Compose');
define('COMPOSE_NO', '999');
define('LAN', 'Language');
define('ALL_CAT', 'All Categories');
define('CAT_1', 'Categories 1');
define('CAT_2', 'Categories 2');
define('MENS', 'Mens');
define('WOMENS', 'Womens');
define('BABY', 'Baby');
define('KID', 'Kids');
define('HOM_TRA', 'Home & Travel');
define('HEALTH_FIT', 'Health & Fitness');
define('SPOR', 'Sports');
define('ELEC', 'Electronics');
define('AUTO', 'Automotive');
define('PHA_EQES', 'Phasellus egestas');
define('ACC_RHO', 'Accumsan rhoncus');
define('CRAS_BLA', 'Cras blandit');
define('LIB_DAP', 'Libero dapibu');
define('CRAS_FEU', 'Cras feugiat rhoncus Purus');
define('QUI_LOB', 'quis lobortis');
define('SED_CON', 'Sed congue gravida mi');
define('FUS_MAL', 'Fusce malesuada Venenatis');
define('LAC_TEM', 'lacus tempor');
define('TOYS', 'Toys');
define('LOREM', 'Lorem Ipsum');
define('ABOUT_US', 'About us');
define('HELP_CEN', 'Help Center');
define('CONTACT_US', 'Contact Us');
define('PRI_POL', 'Privacy Policy');



//--------------------------------------------  Compose----------------------------------------
//--------------------------------------------  fORGOT PASSWORD----------------------------------------   

define('FORGOT_PASS_TITLE', 'Tela Mela');

//--------------------------------------------  fORGOT PASSWORD----------------------------------------   
//--------------------------------------------  LOGIN----------------------------------------   


define('LOGIN_TITLE', 'Tela Mela');
define('WINDOW_AGAIN', 'Open this window again and this message will still be here.');

//--------------------------------------------  LOGIN----------------------------------------   
//------------------------------------------LABEL CHECK My Order--------------------------------------------------------------


define('MY_COUPON_TITLE', 'My Coupons');
define('COUPONS', 'Coupons');
define('COUPON_TITLE', 'Coupon Title');
define('COUPON_PRICE', 'Coupon Price');
//------------------------------------------LABEL CHECK My Order--------------------------------------------------------------    
//------------------------------------------GIFT CARD--------------------------------------------------------------


define('MY_GIFT_TITLE', 'My Gifts');
define('GIFTS', 'Gifts');
define('GIFT_TITLE', 'Gift Card Title');
define('GIFT_PRICE', 'Gift Card Price');
define('SHIPPING_METHOD', 'Shipping Method');
//------------------------------------------GIFT CARD--------------------------------------------------------------
define('NO_RESULT_FOUND', 'No Result found');
?>
