<?php
  $botid = "1036235226:AAEHiMaeIW0CRa34AvVG7H4JWuUBJn_poIM";
  $website = "https://api.telegram.org/bot".$botToken;
  	$chatid = $FilejSon["message"]["chat"]["id"]; // get the User ID, this is unique
$reply = "Working";
$url = "https://api.telegram.org/bot$botid/sendMessage";
$keyboard = array(
'keyboard' => array(
array(
"button",
"\ud83d\ude08",
"\ud83d\udcaa",
"\ud83d\udcf2"
),
array(
"Currency",
"Menu"
),
array(
"1", "2", "3"
),
array(
"4"
)
),
'resize_keyboard' => true,
'one_time_keyboard' => false
);
$postfields = array(
'chat_id' => "$chatid",
'text' => "$reply",
'reply_markup' => json_encode($keyboard)
);

$str = str_replace('\\\\', '\\', $postfields);

print_r($str);
if (!$curld = curl_init()) {
exit;
}

curl_setopt($curld, CURLOPT_POST, true);
curl_setopt($curld, CURLOPT_POSTFIELDS, $str);
curl_setopt($curld, CURLOPT_URL,$url);
curl_setopt($curld, CURLOPT_RETURNTRANSFER, true);

$output = curl_exec($curld);

curl_close ($curld);
