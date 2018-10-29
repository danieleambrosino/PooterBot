<?php

/*
 * This file is part of the PooterBot project.
 * 
 * (c) 2018 Daniele Ambrosino <mail@danieleambrosino.it>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file distributed with this source code.
 */

require_once realpath(__DIR__ . '/../vendor/autoload.php');

$db = new mysqli(DATABASE_MYSQL_HOST, DATABASE_MYSQL_USERNAME,
                 DATABASE_MYSQL_PASSWORD, DATABASE_MYSQL_DBNAME,
                 DATABASE_MYSQL_PORT);

$ddl = file_get_contents('mainProdDDL.sql');
$db->query($ddl);
$db->close();
