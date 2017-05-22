<?php
/**
 * Created by PhpStorm.
 * User: danie
 * Date: 18/05/2017
 * Time: 20:12
 */

$content = file_get_contents("php://input");
$update = json_decode($content, true);

if (!$update) {
    exit;
}

include 'PooterBrain.php';
$pooter = new PooterBrain($update);

$response = $pooter->answer();
if ($response === NULL) exit;

// set receiver
$chat_id = isset($update['message']['chat']['id']) ? $update['message']['chat']['id'] : "";

header("Content-Type: application/json");
$response['chat_id'] = $chat_id;
echo json_encode($response);