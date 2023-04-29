<?php
defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);
defined('SITE_ROOT') ? null : define('SITE_ROOT', $_SERVER['DOCUMENT_ROOT']);
defined('LIB_PATH') ? null : define ('LIB_PATH', SITE_ROOT.DS. 'wp-includes');

require_once(LIB_PATH.DS."config.php"); //Database Connection
require_once(LIB_PATH.DS."product.php"); //Product
require_once(LIB_PATH.DS."category.php"); //Category 
require_once(LIB_PATH.DS."user.php"); //User 
require_once(LIB_PATH.DS."billing.php"); //Billing 
require_once(LIB_PATH.DS."transaction.php"); //Transaction 
?>