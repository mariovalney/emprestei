<?php

/**
 * Index: receive all the requests and do the Magic...
 */

/**
 * Define the ROOT
 */
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(__FILE__) . DS);
define('APP_DIR', ROOT . DS . 'app');

/**
 * Turn on all the errors: it's nice to developers
 */
if (defined('DEBUG') && DEBUG) {
    error_reporting(E_ALL);
}

/**
 * Reading the configurations
 */
if (! file_exists(ROOT . 'config.php')) {
    die('I can\'t find the <code>config.php</code> file. <br> Please, check the file or create a new one.');
}

require_once(ROOT . 'config.php');

/**
 * Loading Core
 */
require_once(ROOT . 'vendor' . DS . 'autoload.php');

App\Kernel::getInstance()->init();
