<?php

$db = new SQLite3('db.sqlite3');
$res = $db->openBlob('Files', 'content', 1, 'main');
header('Content-Type: audio/mpeg');
echo stream_get_contents($res);
fclose($res);
$db->close();