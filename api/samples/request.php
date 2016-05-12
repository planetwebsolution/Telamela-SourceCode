<?php
    /************************************************************************* UserLogin - Done*************************************************************************/
        $z = '{"method":"userLogin","username":"rakesh.kumar1@mail.vinove.com","password":"test123"}';

	//response - failure - {"@attributes":{"status":"400"},"0":"Invalid username or password. Kindly check the request.\n "}
    //response - success -{"@attributes":{"status":"200"},"userInfo":{"@attributes":{"firstname":"Rakesh","lastname":"kumar","email":"rakesh.kumar1@mail.vinove.com","customer_id":"2"}}}
    /*************************************************************************Forgotpassword - Done*************************************************************************/
        $x = '{"method":"forgotPassword","email":"rakesh.kumar1@mail.vinove.com"}';

         //response - failure - {"@attributes":{"status":"400"},"0":"Email id not exist in database.\n "}
        //response - success -{"@attributes":{"status":"200"},"message":"Your new password sent to your mail'","UserInfo":{"firstname":"Rakesh","lastname":"kumar","email":"rakesh.kumar1@mail.vinove.com"}}}
    /*************************************************************************getCountry - Done*************************************************************************/
        $x = '{"method":"getCountry"}';

        //response - failure - {"@attributes":{"status":"400"},"0":"No data found.\n "}
        //response - success -{"country_id":"2","name":"Albania"}

    /*************************************************************************getCountryState - Done*************************************************************************/
        $x = '{"method":"getCountryState","country_id":"74"}';

         //response - failure - {"@attributes":{"status":"400"},"0":"No data found.\n "}
         //response - success -{"country_id":"2","state":{"name":"Albania","iso_code_2":"AL","iso_code_3":"ALB"}}

    /************************************************************************* User Register - Done*************************************************************************/
        $z = '{"method":"userRegister","firstname":"Bhavesh","lastname":"Choudhary","email":"bhavesh.kumar1@mail.vinove.com","telephone":"9015","fax":"140298","password":"bhavesh",
             "newsletter":"1","company":"vinove","address1":"Near Peeragarhi","address2":"F-2 Udhyog","city":"Delhi","postcode":"110041","country_id":"15","zone_id":"197","DeliveryBillingStatus":"1"}';
       //response - failure - {"@attributes":{"status":"400"},"0":"User name already exist.\n "}
      //response - success -{"@attributes":{"status":"200"},"message":"Registred successfully","Userinfo":{"firstname":"Rakesh","lastname":"kumar","email":"rakesh.kumar1@mail.vinove.com"}}}
/*************************************************************************getUserProfile - Done*************************************************************************/
        $x = '{"method":"getUserProfile","customer_id":"123"}';
         //response - failure - {"@attributes":{"status":"400"},"0":"Records not found!. "}
         //response - success -{"status":200,"userinfo":{"customer_id":"5560","firstname":"Bhaveshh","lastname":"Choudharyy","email":"bhavesh.kumar556@mail.vinove.com","telephone":"9015","fax":"140298"}}

/*************************************************************************updateUserProfile - Done*************************************************************************/
        $x = '{"method":"updateUserProfile","customer_id":"1234",firstname":"rakesh","lastname":"kumar","email":"rakesh@mail.com","fax":"1131","telephone":"31312"}';
         //response - failure - {"@attributes":{"status":"400"},"Message":"Email  already exist !.\n "}
         //response - success -{"status":200,"Message":"Profile updated successfully !"}

/*************************************************************************changePassword - Done*************************************************************************/
        $x = '{"method":"changePassword","customer_id":"5560",old_password":"bhavesh","new_password":"kumar","con_password":"kumar1"}';


        /*************************************************************************getBillingAddress - Done***************************************************************/
        $x = '{"method":"getBillingAddress","customer_id":"5560"}';
        //{"status":"200","billingAddress":{"address_id":"2740","customer_id":"5559","company":"vinove","address_1":"Near Peeragarhii","address_2":"F-2 Udhyogg","city":"Delhi","postcode":"110041","country_id":"15","zone_id":"197"}}

        /*************************************************************************updateBillingAddress - Done*********************************************************/
        $x = '{"method":"updateBillingAddress","customer_id":"5560","company":"vinove","address1":"Near Peeragarhi","address2":"F-2 Udhyog","city":"Delhi","postcode":"110041","country_id":"15","zone_id":"197"}';
        //{"status":"200","Message":"Billing address data updated successfully."}
        /*************************************************************************getShippingAddress - Done***********************************************************/
        $x = '{"method":"getShippingAddress","customer_id":"5560"}';
        //{"status":"200","billingAddress":{"address_id":"2741","customer_id":"5559","company":"vinoveeee","address_1":"Near Peeragarhiiii","address_2":"F-2 Udhyogggg","city":"Delhiiii","postcode":"110041111","country_id":"15","zone_id":"197"}}
        //{"status":"200","Message":"Billing & shipping address are same."}
        /*************************************************************************updateShippingAddress - Done********************************************************/
        $x = '{"method":"updateShippingAddress","customer_id":"5560","company":"vinove","address1":"Near Peeragarhi","address2":"F-2 Udhyog","city":"Delhi","postcode":"110041","country_id":"15","zone_id":"197"}';







/*************************************************************************userOrders - Done*************************************************************************/
        $x = '{"method":"userOrders","customer_id":"1234"}';
         //response - failure - {"@attributes":{"status":"400"},"0":"Order not found!.\n "}
         //response - {"status":200,"OrderInfo":[{"order_number":"31","total_price":"$298.76","date":"2011-08-15 16:04:08","order_status":"Voided"}]}

        /*************************************************************************userOrdersDetails - Done*************************************************************************/
        $x = '{"method":"userOrdersDetails","order_id":"12"}';
         //response - failure - {"@attributes":{"status":"400"},"0":"productr not found!.\n "}
         //response - success {"status":200,"ProductInfo":[{"order_id":"10001","product_name":"MC700X\/A Apple MacBook Pro 13","product_image":"data\/mountain-lion\/mb-pro-13.png","quantity":"1","price":"1765.1000","description":"<p>\r\n\t<b>MD101X\/A 13&quot; 2.5Ghz Overview of key features and specifications.}]}

 /*************************************************************************productCategoryListing - Done*************************************************************************/
        $x = '{"method":"productCategoryListing"}';
         //response - failure - {"@attributes":{"status":"400"},"0":"Category not found!.\n "}
        //response - {"status":200,"Product Category":[{"category_name":"iMac","category_id":"64"},
        //{"category_name":"MacBook Pro","category_id":"34"},{"category_name":"Mac Mini","category_id":"32"},
        //{"category_name":"iPad","category_id":"52"},{"category_name":"Mac Pro","category_id":"25"},
        //{"category_name":"MacBook Air","category_id":"23"},{"category_name":"Home Automation","category_id":"65"},
        //{"category_name":"Used","category_id":"57"}]}
/*************************************************************************subCategoryListing - Done*************************************************************************/
        $x = '{"method":"subCategoryListing","category_id":"89"}'; 
         //response - failure - {"@attributes":{"status":"400"},"0":"Sub Category not found!.\n "}
        //response - {"status":200,"Sub Category":[{"category_name":"iMac","category_id":"64"},
        //{"category_name":"MacBook Pro","category_id":"34"},{"category_name":"Mac Mini","category_id":"32"},
        //{"category_name":"iPad","category_id":"52"},{"category_name":"Mac Pro","category_id":"25"},
        //{"category_name":"MacBook Air","category_id":"23"},{"category_name":"Home Automation","category_id":"65"},
        //{"category_name":"Used","category_id":"57"}]}

        /*************************************************************************productListing - Done*************************************************************************/
        $x = '{"method":"productListing","category_id":"52","category_name":"iPad"}';
         //response - failure - {"@attributes":{"status":"400"},"0":"product not found!.\n "}
        //response - {"status":200,"Category name":"iPad","Products info":[
        //{"product_name":"Apple iPad Wi-Fi 16Gb 4th Generation","product_price":"490.0000","product_id":"671","product_image":"data\/ipad3\/ipad3-white.png"},
        //{"product_name":"Apple iPad Wi-Fi 32Gb 4th Generation","product_price":"590.0000","product_id":"672","product_image":"data\/ipad3\/ipad3-white.png"}]}

        $x = '{"method":"productSearch","keywords":"text"}';
         //response - failure - {"@attributes":{"status":"400"},"0":"product not found!.\n "}
        //response - {"status":200,"Products info":[
        //{"product_name":"Apple iPad Wi-Fi 16Gb 4th Generation","product_price":"490.0000","product_id":"671","product_image":"data\/ipad3\/ipad3-white.png"},
        //{"product_name":"Apple iPad Wi-Fi 32Gb 4th Generation","product_price":"590.0000","product_id":"672","product_image":"data\/ipad3\/ipad3-white.png"}]}
        /*************************************************************************productDetails - Done*************************************************************************/
        $x = '{"method":"productDetails","product_id":"52"}';

         //response - failure - {"@attributes":{"status":"400"},"0":"product not found!.\n "}
        //response - {"status":200,"Products info":[{"product_name":"Roxio Toast 11 Titanium","product_id":"78","product_price":"122.7273","product_image":"data\/toast11titanium.jpg",
        //"product_description":"Toast 11 Titanium, the best selling Mac digital media app for over 10 years, makes it easier than ever to capture, burn, convert, copy and share digital media.
        // Use Toast 11 to take videos and music from almost any source, convert them to other popular formats to enjoy on your iPad, iPhone, HDTV, online and more. Toast’s new design,
        //  including both video and step-by-step tutorials, helps you optimize the digital files on your Mac. New features include faster processing speeds, disc burning from multiple drives,
        //  export to formats like Flash, MKV and DivX Plus HD, and direct video sharing to Facebook, YouTube and Vimeo.
        //  System Requirements:<\/strong>* Mac computer with an Intel processor running Mac OS X 10.5 or 10.6
        //  * 1GB RAM (2GB RAM recommended) and approximately 1GB of free space to install all components
        //  * VideoBoost requires a compatible NVIDIA card and 4 GB of RAM for optimal performance
        //  * DVD drive required for installation"}]}

        /*************************************************************************productOptionsList - Done*************************************************************************/
        $x = '{"method":"productOptionsList","product_id":"52"}';


         //response - failure - {"@attributes":{"status":"400"},"0":"options not found!.\n "}
        //response - {"status":200,"Product Id":"877","Options List":{"Apple USB Superdrive":[{"option_value":"No","value_id":"1377"},{"option_value":"Yes Please","value_id":"1378"}],"DisplayPort to DVI":[{"option_value":"No","value_id":"530"},{"option_value":"Yes","value_id":"529"}]}

        /*************************************************************************userEnquiry - Done*************************************************************************/
        $x = '{"method":"userEnquiry","name":"rakesh","email":"bhavesh.kumar@mail.vinove.com","enquiryMessage":"This is test mail"}';
          //response - failure - {"@attributes":{"status":"203"},"0":"Error to send enquiry! try again.\n "}
          //response - success -{"@attributes":{"status":"200"},"message":"Enquiry query sent successfully !"}}

        /*************************************************************************getSiteInfoTitle - Done*************************************************************************/
        $x = '{"method":"getSiteInfoTitle"}'; // here id in comma seperated with page name want to show in list
         //response - failure - {"@attributes":{"status":"400"},"0":"No data found.\n "}
         //response - success {"title":"About ZeroThree","information_id":"4"},{"title":"Education Store","information_id":"34"},{"title":"Platinum Store","information_id":"35"},{"title":"Corporate Store","information_id":"36"}

        /*************************************************************************getSiteInfoTitleContent - Done**************************************************************/
        $x = '{"method":"getSiteInfoTitleContent","info_title_id":"433"}';
         //response - failure - {"@attributes":{"status":"400"},"0":"Page content not found!.\n "}
         //response - success {"status":200,"SiteInfo":{"description":"<p>\r\n\t<strong>Who we are"}

       /************************************************************************* CustomerRewadsPoint*************************************************************************/
        $z = '{"method":"getCustomerRewards","cutomer_id":"0"}';


        //$json_datavalue='{"method":"userLogin","username":"rakesh.kumar122@mail.vinove.com","password":"kumar"}';
//$json_datavalue='{"method":"userRegister","firstname":"rakesh","lastname":"kumar","email":"rakesh.kumar1@mail.vinove.com","fax":"01234","telephone":"7777","password":"test123","newsletter":"1","company":"vinove","address1":"aaa","address2":"bbb"}';
//$json_datavalue = '{"method":"forgotPassword","email":"bhavesh.kumar@mail.vinove.com"}';
//$json_datavalue = '{"method":"getCountry"}{"method":"getSiteInfoTitle"}';
//$json_datavalue = '{"method":"userEnquiry","name":"rakesh","email":"bhavesh.kumar@mail.vinove.com","enquiryMessage":"This is test mail"}';
//$json_datavalue = '{"method":"userRegister","firstname":"Bhaveshh","lastname":"Choudharyy","email":"bhavesh.kumar556@mail.vinove.com","telephone":"9015","fax":"140298","password":"bhavesh","newsletter":"1","company":"vinove","address1":"Near Peeragarhii","address2":"F-2 Udhyogg","city":"Delhi","postcode":"110041","country_id":"15","zone_id":"197","DeliveryBillingStatus":"1"}';
//$json_datavalue = '{"method":"userOrders","customer_id":"3459"}';
//$json_datavalue = '{"method":"updateUserProfile","customer_id":"5560","firstname":"mukund","lastname":"jha","email":"mukund@mail.com","fax":"1131","telephone":"31312"}';
//$json_datavalue = '{"method":"changePassword","customer_id":"5560","old_password":"bhavesh","new_password":"kumar","con_password":"kumar"}';
//$json_datavalue = '{"method":"updateBillingAddress","customer_id":"5560","company":"vinove","address1":"Near Peeragarhi","address2":"F-2 Udhyog","city":"Delhi","postcode":"110041","country_id":"15","zone_id":"197"}';

$x='{
        "method":"saveOrderDetails",
        "payment_method" : "bank_transfer",
        "customer_id":"5571",
        "IP":"111111",
        "tax":"100",
        "shipping_cost":"100",
        "shipping_method":"Pickup From Store",
        "order_total":"200",
        "Credit_card_detail":   {
                                    "CardNumber" :"4111111111111111",
                                    "CardCVVNo" :"555",
                                    "CardExpiryMonth" :"10",
                                    "CardExpiryYear" :"15",
                                    "CardType" :"visa",
                                    "NameOnCard" :"Bhavesh kumar choudhary"
                                }
        "Product_details":[{"product_id":"32","qty":"2", "price":"100","flag":"0"},
                           {"product_id":"74","qty":"74", "price":"74"},
                           {"product_id":"74","qty":"74", "price":"74","flag":"0"},
                           {"product_id":"74","qty":"74", "price":"74","flag":"0"},
                           {"product_id":"38","qty":"2", "price":"100","flag":"1","options_details":[{"product_option_id":"508","product_option_value_id":"1415"}]}
                          ]
    }'
        //"payment_type" : "bank_transfer","credit_card","cash_on_collection","paypal","post","FedEx"
        //"order_status_id":"5",       -   removed due to value depend on payment method
        //"shipping_method":"Pickup From Store","NURC","NIC","NEC","FedEX","post"?>
    </body>
</html>
$a = json_decode($x,true);
$b = json_decode($y,true);
echo $c = json_encode($a);
echo '12<pre>';print_r($a);
echo '12<pre>';print_r($b);die;
$sxml = simplexml_load_string($varXmlStr);
return json_encode($sxml);
