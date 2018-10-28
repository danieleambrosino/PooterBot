<?php

/*
 * This file is part of the PooterBot project.
 * 
 * (c) 2018 Daniele Ambrosino <mail@danieleambrosino.it>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file distributed with this source code.
 */

$main = new SQLite3('main.sqlite3', SQLITE3_OPEN_READWRITE | SQLITE3_OPEN_CREATE);
$main->query(file_get_contents('mainDevDDL.sql'));
$main->close();

$resources = new SQLite3('resources.sqlite3', SQLITE3_OPEN_READWRITE | SQLITE3_OPEN_CREATE);
$resources->query(file_get_contents('resourcesDevDDL.sql'));
$resources->query(file_get_contents('resourcesData.sql'));
