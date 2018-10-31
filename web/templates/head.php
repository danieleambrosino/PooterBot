<?php
/*
 * This file is part of the PooterBot project.
 * 
 * (c) 2018 Daniele Ambrosino <mail@danieleambrosino.it>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file distributed with this source code.
 */
session_start();
if ( !isset($_SESSION['userId']) && substr($_SERVER['SCRIPT_NAME'], -9) !== 'login.php' )
{
  exit('Unauthorized');
}
require_once realpath(__DIR__ . '/../../vendor/autoload.php');
?>
<head>
  <script src="<?= JQUERY_SLIM_URL ?>"></script>

  <link rel="stylesheet" href="<?= MATERIALIZE_CSS_URL ?>">
  <script src="<?= MATERIALIZE_JS_URL ?>"></script>

  <link rel="icon" type="image/jpg" href="favicon.jpg">
</head>