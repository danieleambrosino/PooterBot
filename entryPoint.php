<?php

/*
 * This file is part of the PooterBot project.
 * 
 * (c) 2018 Daniele Ambrosino <mail@danieleambrosino.it>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file distributed with this source code.
 */

$update = file_get_contents('php://input');

if ( empty($update) )
{
  http_response_code(204);
  exit;
}

