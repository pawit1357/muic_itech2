<?php
session_start();
require_once(dirname(__FILE__).'/framework/yii.php');
$config=dirname(__FILE__).'/protected/config/main.php';



require_once dirname(__FILE__).'/protected/utilities/DateTimeUtil.php';
require_once dirname(__FILE__).'/protected/utilities/XMLUtil.php';
require_once dirname(__FILE__).'/protected/utilities/CommonUtil.php';
require_once dirname(__FILE__).'/protected/utilities/ConfigUtil.php';
require_once dirname(__FILE__).'/protected/utilities/MenuUtil.php';
require_once dirname(__FILE__).'/protected/utilities/HttpRequestUtil.php';
require_once dirname(__FILE__).'/protected/utilities/UserLoginUtil.php';
require_once dirname(__FILE__).'/protected/utilities/Encoding.php';
require_once dirname(__FILE__).'/protected/utilities/FeedUtil.php';
require_once dirname(__FILE__).'/protected/utilities/APNSUtil.php';
require_once dirname(__FILE__).'/protected/utilities/PHPExcel/Classes/PHPExcel/IOFactory.php';
require_once dirname(__FILE__).'/protected/utilities/GridUtil.php';
//Yii::createWebApplication($config)->run();

$app = Yii::createWebApplication($config);
Yii::app()->setTimeZone('UTC');
$app->run();

// Yii::import('ext.yiiexcel.YiiExcel', true);
// Yii::registerAutoloader(array('YiiExcel', 'autoload'), true);

// // Optional:
// //  As we always try to run the autoloader before anything else, we can use it to do a few
// //      simple checks and initialisations
// PHPExcel_Shared_ZipStreamWrapper::register();

// if (ini_get('mbstring.func_overload') & 2) {
// 	throw new Exception('Multibyte function overloading in PHP must be disabled for string functions (2).');
// }
// PHPExcel_Shared_String::buildCharacterSets();






