<?php

require_once '../common/config/config.inc.php';

require_once SOURCE_ROOT . 'components/class.validation.inc.php';
require_once CLASSES_SYSTEM_PATH . 'class_upload_bll.php';
require_once CLASSES_ADMIN_PATH . 'class_user_bll.php';
require_once CLASSES_PATH . 'class_common.php';
require_once CLASSES_ADMIN_PATH . 'class_country_portal_bll.php';
//check admin session
$objUser = new User();
//echo '<pre>';print_r($_REQUEST);die;
$varProcess = $_REQUEST['frmProcess'];

if ($_SESSION['sessUserType'] == 'super-admin') {

    switch ($varProcess) {
        case 'EditUser':
            // echo "<pre>";print_r($_POST);die;

            if ($objUser->editUser($_POST)) {

                header('location:country_portal_manage_uil.php');
                exit;
            } else {
                header('location:user_add_uil.php?UserID=' . $_POST['frmUserID'] . '&type=portal');
                exit;
            }

            break;

        case 'EditModeratorUser':

            if ($objUser->editModeratorUser($_POST)) {
                header('location:user_manage_uil.php');
                exit;
            } else {
                header('location:admin_user_add_uil.php?UserID=' . $_POST['frmUserID']);
                exit;
            }

            break;

        case 'AddArchive':
            //pre($_REQUEST);

            if ($objUser->insertArchive($_POST)) {
                header('location:user_add_uil.php?UserID=' . $_POST['frmUserID']);
                exit;
            } else {
                header('location:user_add_uil.php?UserID=' . $_POST['frmUserID']);
                exit;
            }

            break;


        case 'AddUser':
            //echo "<pre>"; print_r($_POST);die;

            if ($objUser->addUser($_POST)) {
                header('location:country_portal_manage_uil.php');
                die;
            } else {
                header('location:user_add_uil.php');
                exit;
            }

            break;

        case 'AddModeratorUser':

            if ($objUser->addModeratorUser($_POST)) {
                header('location:user_manage_uil.php');
                die;
            } else {
                header('location:admin_user_add_uil.php');
                exit;
            }

            break;

        case 'deleteUser':
            //echo "<pre>"; print_r($_GET);die;
            if ($objUser->deleteUser($_REQUEST)) {
                header('location:user_manage_uil.php');
                die;
            } else {
                header('location:user_manage_uil.php');
                exit;
            }
            break;

        case 'ManipulateUser':
            if ($_POST['frmChangeAction'] == 'Active' || $_POST['frmChangeAction'] == 'Inactive') {
                if ($objUser->setUserStatus($_POST)) {
                    if ($_REQUEST['page']) {
                        header('location:user_list_uil.php?page=' . $_REQUEST['page']);
                        exit;
                    } else {
                        header('location:user_list_uil.php');
                        exit;
                    }
                }
            } else if (!empty($_REQUEST['frmUsersID'])) {
                if ($objUser->removeUserInformation($_POST)) {
                    if ($_REQUEST['page']) {
                        header('location:user_manage_uil.php?page=' . $_REQUEST['page']);
                        exit;
                    } else {
                        header('location:user_manage_uil.php');
                        exit;
                    }
                }
            }

            break;
    }
} else {
    $objCore->setSuccessMsg(ADMIN_USER_PERMISSION_TITLE);
    header('location:' . $_SERVER['HTTP_REFERER']);
    exit;
}
?>