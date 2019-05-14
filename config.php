<?php

/**
 * You know what to do...
 */

/** Site Config **/
define('SITE_NAME', 'Emprestei');

/** URL Config **/
define('BASE_URL', 'http://dev.emprestei.com.br');

/**
 * Database configs
 * To deactivate the use of Database, exclude these 4 lines or set DB_NAME as empty: define('DB_NAME', '');
 */

define('DB_NAME', 'bancodedados');
define('DB_USER', 'bancodedados');
define('DB_PASS', 'bancodedados');
define('DB_PORT', '3306');
define('DB_HOST', '192.168.16.2');

/** Timezone config **/
date_default_timezone_set('America/Fortaleza');

/** Debug config **/
define('DEBUG', true);
