<?php
// change the following paths if necessary 
require_once 'common/config/config.inc.php';
require_once CLASSES_PATH . 'class_customer_user_bll.php';
require_once CLASSES_PATH . 'class_email_template_bll.php';
// change the following paths if necessary 
$config = COMPONENTS_SOURCE_ROOT_PATH . 'hybridauth-2.1.2/hybridauth/config.php';
require_once( COMPONENTS_SOURCE_ROOT_PATH . "hybridauth-2.1.2/hybridauth/Hybrid/Auth.php" );

try {
    $hybridauth = new Hybrid_Auth($config);
}
// if sometin bad happen
catch (Exception $e) {
    $message = "";

    switch ($e->getCode()) {
        case 0 : $message = "Unspecified error.";
            break;
        case 1 : $message = "Hybriauth configuration error.";
            break;
        case 2 : $message = "Provider not properly configured.";
            break;
        case 3 : $message = "Unknown or disabled provider.";
            break;
        case 4 : $message = "Missing provider application credentials.";
            break;
        case 5 : $message = "Authentication failed. The user has canceled the authentication or the provider refused the connection.";
            break;

        default: $message = "Unspecified error!";
    }
    ?>
    <style>
        PRE {
            background:#EFEFEF none repeat scroll 0 0;
            border-left:4px solid #CCCCCC;
            display:block;
            padding:15px;
            overflow:auto;
            width:740px;
        }
        HR {
            width:100%;
            border: 0;
            border-bottom: 1px solid #ccc; 
            padding: 50px;
        }
    </style>
    <script language="javascript"> 
        if(  window.opener ){
            try { window.opener.parent.$.colorbox.close(); } catch(err) {} 
            //alert("<?php echo $return_to; ?>");
            //window.opener.parent.location.href = "<?php echo $return_to; ?>";
        }

        window.self.close();
    </script>
    <table width="100%" border="0">
        <tr>
            <td align="center"><br /><img src="<?php echo IMAGES_URL ?>icons/alert.png" /></td>
        </tr>
        <tr>
            <td align="center"><br /><h3>Something bad happen!</h3><br /></td> 
        </tr>
        <tr>
            <td align="center">&nbsp;<?php echo $message; ?><hr /></td> 
        </tr>
        <tr>
            <td>
                <b>Exception</b>: <?php echo $e->getMessage(); ?>
                <pre><?php echo $e->getTraceAsString(); ?></pre>
            </td> 
        </tr>
    </table> 
    <?php
    // diplay error and RIP
    die();
}

$provider = "";

// handle logout request
if (isset($_GET["logout"])) {
    $provider = $_GET["logout"];

    $adapter = $hybridauth->getAdapter($provider);

    $adapter->logout();
    //die($provider);
    //header("Location: index.php");
    header('location:' . SITE_ROOT_URL);

    die();
}

// if the user select a provider and authenticate with it 
// then the widget will return this provider name in "connected_with" argument 
elseif (isset($_GET["connected_with"]) && $hybridauth->isConnectedWith($_GET["connected_with"])) {
    $provider = $_GET["connected_with"];

    $adapter = $hybridauth->getAdapter($provider);

    $user_data = $adapter->getUserProfile();
    //pre($user_data);
    $user_res = (array) $user_data;
    //pre($user_res);
    // $user_res['email'] = 'ssuraj.maurya@mail.vinove.com';


    if ($user_res['identifier'] && $user_res['email'] <> '') {
        $objCustomer = new Customer();

        $_to = '';
        if (isset($_GET['_to'])) {
            if ($_GET['_to'] == 'checkout.php') {
                $_to = $objCore->getUrl('shipping_charge.php');
            } else if ($_GET['_to'] == 'product.php') {
                if (isset($_GET['_qryStr']) && $_GET['_qryStr'] <> '') {
                    $_arrQry = explode('@@', $_GET['_qryStr']);
                    $arrV = array();
                    foreach ($_arrQry as $val) {
                        list($k, $v) = explode('||', $val);
                        $arrV[$k] = $v;
                    }
                }
            }
        }


        $user_res['provider'] = $adapter->id;

        $resData = $objCustomer->getCustomerFromSocialProvider($user_res);
        $resData[0]['SocialProvider'] = $user_res['provider'];
        if ($resData[0]['pkCustomerID'] > 0) {
            $objCustomer->userLoginFromSocialProvider($resData);
            if (isset($arrV['type']) && $arrV['frmval'] <> '') {
                $objCustomer->ratingReviewFromSocialProvider($arrV);
                $_to = $objCore->getUrl('product.php', array('id' => $arrV['pid'], 'name' => $arrV['name'], 'refNo' => $arrV['refNo']));
            }
            if (!$_to) {
                $_to = $objCore->getUrl('dashboard_customer_account.php');
            }
            header('location:' . $_to);
            die;
        } else {
            $resData = $objCustomer->addCustomerFromSocialProvider($user_res);
            if ($resData[0]['pkCustomerID'] > 0) {
                //pre($resData);
                $objCustomer->userLoginFromSocialProvider($resData);
                if (isset($arrV['type']) && $arrV['frmval'] <> '') {
                    $objCustomer->ratingReviewFromSocialProvider($arrV);
                    $_to = $objCore->getUrl('product.php', array('id' => $arrV['pid'], 'name' => $arrV['name'], 'refNo' => $arrV['refNo']));
                }

                if (!$_to) {
                    $_to = $objCore->getUrl('edit_my_account.php', array('type' => 'edit'));
                }
                header('location:' . $_to);
                die;
            } else {
                header('location:' . SITE_ROOT_URL);
                die;
            }
        }
        //pre($resData);
    }
    //pre($resData);
    header('location:' . SITE_ROOT_URL);
    //echo '<pre>';
    //print_r($user_data);
    // include authenticated user view
    //include COMPONENTS_SOURCE_ROOT_PATH . "hybridauth-2.1.2/examples/widget_authentication/mywebsite/inc_authenticated_user.php";

    die();
} // if user connected to the selected provider 

$provider = @ $_GET["provider"];
$return_to = @ $_GET["return_to"];

if (!$return_to) {
    echo "Invalid params!";
}

if (!empty($provider) && $hybridauth->isConnectedWith($provider)) {

    $return_to = $return_to . ( strpos($return_to, '?') ? '&' : '?' ) . "connected_with=" . $provider . "&_to=" . $_GET['_to'] . '&_qryStr=' . $_GET['_qryStr'];
    ?>
    <script language="javascript"> 
        if(  window.opener ){
            try { window.opener.parent.$.colorbox.close(); } catch(err) {} 
            //alert("<?php echo $return_to; ?>");
            window.opener.parent.location.href = "<?php echo $return_to; ?>";
        }

        window.self.close();
    </script>
    <?php
    die();
}

if (!empty($provider)) {
    $params = array();

    if ($provider == "OpenID") {
        $params["openid_identifier"] = @ $_REQUEST["openid_identifier"];
    }

    if (isset($_REQUEST["redirect_to_idp"])) {
        $adapter = $hybridauth->authenticate($provider, $params);
    } else {
        // here we display a "loading view" while tryin to redirect the user to the provider
        ?>
        <table width="100%" border="0">            
            <tr>
                <td align="center"><br /><h3>Loading...</h3><br /></td> 
            </tr>
            <tr>
                <td align="center" height="190px" valign="middle"><img src="<?php echo IMAGES_URL ?>loader100.gif" /></td>
            </tr>
            <tr>
                <td align="center">Contacting <b><?php echo ucfirst(strtolower(strip_tags($provider))); ?></b>. Please wait.</td> 
            </tr> 
        </table>
        <script>
           setTimeout(function(){window.location.href = window.location.href + "&redirect_to_idp=1";},2000);           
        </script>
        <?php
    }

    die();
}
?>