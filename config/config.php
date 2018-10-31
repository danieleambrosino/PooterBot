<?php

/*
 * This file is part of the PooterBot project.
 * 
 * (c) 2018 Daniele Ambrosino <mail@danieleambrosino.it>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file distributed with this source code.
 */

require_once 'privateConfig.php';

define('DEVELOPMENT', TRUE);
define('SAVE_MESSAGES', FALSE);

###################
# Error reporting #
###################

if ( DEVELOPMENT )
{
  error_reporting(E_ALL);
}
else
{
  error_reporting(0);
}

###############
# Directories #
###############

define('ROOT_DIR', realpath(dirname(__DIR__)));
define('RES_DIR', realpath(ROOT_DIR . '/res'));
define('VENDOR_DIR', realpath(ROOT_DIR . '/vendor'));
define('DATABASE_DIR', realpath(ROOT_DIR . '/db/'));
define('DATABASE_SQLITE_PATH', realpath(DATABASE_DIR . '/main.sqlite3'));
define('DATABASE_RESOURCES_PATH', realpath(DATABASE_DIR . '/resources.sqlite3'));

################
# Dependencies #
################

if ( DEVELOPMENT )
{
  define('JQUERY_SLIM_URL', '/vendor/components/jquery/jquery.slim.js');
  define('MATERIALIZE_CSS_URL',
         '/vendor/Dogfalo/materialize/css/materialize.css');
  define('MATERIALIZE_JS_URL', '/vendor/Dogfalo/materialize/js/materialize.js');
}
else
{
  define('JQUERY_SLIM_URL', 'https://code.jquery.com/jquery-3.3.1.slim.min.js');
  define('MATERIALIZE_CSS_URL',
         'https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css');
  define('MATERIALIZE_JS_URL', 'https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js');
}
