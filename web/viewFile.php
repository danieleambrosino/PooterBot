<?php

/*
 * This file is part of the PooterBot project.
 * 
 * (c) 2018 Daniele Ambrosino <mail@danieleambrosino.it>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file distributed with this source code.
 */

if ( empty($_GET['fileId']) )
{
  exit;
}

$fileId = filter_input(INPUT_GET, 'fileId', FILTER_SANITIZE_STRING);

require_once realpath(__DIR__ . '/../vendor/autoload.php');

$db = new SQLite3(DATABASE_SQLITE_PATH);
$mimeType = $db->querySingle("SELECT mimeType FROM Files WHERE id = '$fileId'");
$rowId = $db->querySingle("SELECT rowid FROM Files WHERE id = '$fileId'");
$res = $db->openBlob('Files', 'content', $rowId);
$fileContent = stream_get_contents($res);
fclose($res);
$db->close();
header('Content-Type: ' . $mimeType);
echo $fileContent;