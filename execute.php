<?php
$content = file_get_contents("php://input");
$update = json_decode($content, true);
if(!$update)
{
  exit;
}
$message = isset($update['message']) ? $update['message'] : "";
$messageId = isset($message['message_id']) ? $message['message_id'] : "";
$chatId = isset($message['chat']['id']) ? $message['chat']['id'] : "";
$firstname = isset($message['chat']['first_name']) ? $message['chat']['first_name'] : "";
$lastname = isset($message['chat']['last_name']) ? $message['chat']['last_name'] : "";
$username = isset($message['chat']['username']) ? $message['chat']['username'] : "";
$date = isset($message['date']) ? $message['date'] : "";
$text = isset($message['text']) ? $message['text'] : "";
$text = trim($text);
$text = strtolower($text);
header("Content-Type: application/json");
$response = '';
   $esempiotastierainline = '[{"text":"Testo","url":"http://yt.alexgaming.me"},{"text":"Inline","switch_inline_query":"Ciao!"}],[{"text":"Testo","callback_data":"StampaMessaggio"},{"text":"Modifica Messaggio","callback_data":"ModificaMessaggio"}]';

if($text =="/start")
{
$nomeatuascelta = '["CIAO"]';
$nomeatuascelta = '["CIAO"],["CIAO"]';
$nomeatuascelta = '["Ciao","Ciao"]';

}
elseif($text=="ciao")
{
	$response = "Ciao, benvenuto $firstname";
}
elseif($text=="oxy")
{
	$response = "oOxygen è il mio Creatore cosa vuoi da lui?";

}
$parameters = array('chat_id' => $chatId, "text" => $response);
$parameters["method"] = "sendMessage";
echo json_encode($parameters);
