<?php

/**
 * Index: receive all the requests and do the Magic...
 */

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(__FILE__) . DS);

/**
 * Load Paths
 */
require_once(ROOT . DS . 'configs' . DS . 'paths.php');

/**
 * Load configs
 */
require_once(CONFIG_DIR . DS . 'database.php');
require_once(CONFIG_DIR . DS . 'app.php');

/**
 * Turn on all the errors: it's nice to developers
 */
if (! defined('DEBUG')) {
    define('DEBUG', false);
}

if (DEBUG) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}

/**
 * Loading Core
 */
require_once(VENDOR_DIR . DS . 'autoload.php');

try {
    App\Kernel::getInstance()->init();
} catch (Exception $e) {
    // TODO: A better debug UI
    echo '<h1>Exceção ' . $e->getCode() . '</h1>';
    echo '<p>Exceção ' . $e->getMessage() . '</p>';

    debug_print_backtrace();
}


