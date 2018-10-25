<?php

/*
 * This file is part of the PooterBot project.
 * 
 * (c) 2018 Daniele Ambrosino <mail@danieleambrosino.it>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file distributed with this source code.
 */

define('DEVELOPMENT', TRUE);
define('SAVE_MESSAGES', TRUE);

define('ROOT_DIR', realpath(__DIR__));
define('VENDOR_DIR', realpath(ROOT_DIR . '/vendor'));
define('DATABASE_DIR', realpath(ROOT_DIR . '/db/'));
define('DATABASE_SQLITE_PATH', realpath(DATABASE_DIR . '/main.sqlite3'));
define('DATABASE_RESOURCES_PATH', realpath(DATABASE_DIR . '/resources.sqlite3'));

define('OPENWEATHERMAP_TOKEN', 'b51e0621209ed4c587aac8ac21f7db2f');
define('TELEGRAM_TOKEN', '395202945:AAGPr7enEsDpMaELIZpRUKw55u0PasJzz5c');
preg_match('/\d+/', TELEGRAM_TOKEN, $matches);
define('TELEGRAM_BOT_ID', $matches[0]);
unset($matches);

define('MATERIALIZE_CSS_URL', '/vendor/Dogfalo/materialize/css/materialize.css');
define('MATERIALIZE_JS_URL', '/vendor/Dogfalo/materialize/js/materialize.js');
define('JQUERY_SLIM_URL', 'https://code.jquery.com/jquery-3.3.1.slim.min.js');
define('DATATABLES_CSS_URL',
       'https://cdn.datatables.net/1.10.18/css/jquery.dataTables.min.css');
define('DATATABLES_JS_URL',
       'https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js');
