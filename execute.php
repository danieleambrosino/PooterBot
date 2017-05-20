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

$text_to_send = $pooter->interpret();
if ($text_to_send === "") exit;


// set receiver
$chat_id = isset($update['message']['chat']['id']) ? $update['message']['chat']['id'] : "";

header("Content-Type: application/json");
$parameters = array('chat_id' => $chat_id, "text" => $text_to_send);
$parameters["method"] = "sendMessage";
echo json_encode($parameters);