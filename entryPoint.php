<?php

/*
 * This file is part of the PooterBot project.
 * 
 * (c) 2018 Daniele Ambrosino <mail@danieleambrosino.it>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file distributed with this source code.
 */

require_once realpath(__DIR__ . '/vendor/autoload.php');

if ( !DEVELOPMENT )
{
  $ipAddress = $_SERVER['REMOTE_ADDR'];
  if ( substr($ipAddress, 0, 12) !== '149.154.167.' ||
       (substr($ipAddress, 12, 3) >= 197 && substr($ipAddress, 12, 3) <= 233) )
  {
    http_response_code(403);
    exit;
  }
}

$update = file_get_contents('php://input');

if ( empty($update) )
{
  http_response_code(204);
  exit;
}

$director = new Director($update);
$director->handleUpdate();
if ( SAVE_MESSAGES )
{
  $director->storeData();
}