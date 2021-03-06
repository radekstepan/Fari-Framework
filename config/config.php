<?php if (!defined('FARI')) die();

/**
 * Fari Framework
 *
 * @copyright Copyright (c) 2008, 2010 Radek Stepan
 * @license   http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link      http://radekstepan.com
 * @category  Fari Framework
 */



/********************* application settings *********************/



// app directory; this directory contains your models, views & presenters
if (!defined('APP_DIR')) define('APP_DIR', 'application');
// application version
if (!defined('APP_VERSION')) define('APP_VERSION', 'Akrabat');
// application salt to differentiate between Fari apps saving to a SESSION
if (!defined('APP_SALT')) define('APP_SALT', '4336517919');
// default presenter for the application (pages in a CMS)
if (!defined('DEFAULT_PRESENTER')) define('DEFAULT_PRESENTER', 'Albums');



/********************* database settings *********************/



// mysql, pgsql, sqlite2, sqlite3
if (!defined('DB_DRIVER')) define('DB_DRIVER', 'sqlite3');
// localhost, 127.0.0.1
if (!defined('DB_HOST')) define('DB_HOST', 'localhost');
// database name
if (!defined('DB_NAME')) define('DB_NAME', 'db/database.php');
// database username
if (!defined('DB_USER')) define('DB_USER', '');
// database password
if (!defined('DB_PASS')) define('DB_PASS', '');



/********************* email settings *********************/



// SMTP hostname
if (!defined('SMTP_HOST')) define('SMTP_HOST', 'ssl://smtp.gmail.com');
// SMTP port
if (!defined('SMTP_PORT')) define('SMTP_PORT', 465);
// username
if (!defined('SMTP_USERNAME')) define('SMTP_USERNAME', '');
// password
if (!defined('SMTP_PASSWORD')) define('SMTP_PASSWORD', '');



/********************* other settings *********************/



// set a default timezone
date_default_timezone_set('BST');