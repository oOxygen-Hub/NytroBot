<?php
	
$bot_token = "1036235226:AAEHiMaeIW0CRa34AvVG7H4JWuUBJn_poIM"; // Api TOKEN to our bot
$url = "https://api.telegram.org/bot$bot_token/sendMessage";
$content = file_get_contents('php://input');
$update = json_decode($content, TRUE);
$callback_query = $update['callbackQuery'];
$callback_data = $callback_query['data'];

$ser_update = serialize($update);
db_query("INSERT INTO prefix_telegram (text) VALUES ('".$ser_update."')");

if (isset($update['message']['text'])) {
    $text    = $update['message']['text'];
    $chat_id = $update['message']['chat']['id'];

    if (strpos($text, 'outi') !== false) {
        $reply = utf8_encode("Wähle einen Button!");
        $keyboard = array(
            "keyboard" =>   array(
                                    array(
                                        array(
                                            "text"  => "Button1",
                                            "callback_data" => "1",
                                        ),
                                        array(
                                            "text"  => "Button2",
                                            "callback_data" => "2",
                                        ),
                                    )
                                ),
                                "one_time_keyboard" => true,
                                "resize_keyboard" => true
        );

        $postfields = array(
            'chat_id'       => "$chat_id",
            'text'          => "$reply",
            'reply_markup'  => json_encode($keyboard)
        );

        if (!$curld = curl_init()) {
            exit;
        }

        curl_setopt($curld, CURLOPT_POST, true);
        curl_setopt($curld, CURLOPT_POSTFIELDS, $postfields);
        curl_setopt($curld, CURLOPT_URL,$url);
        curl_setopt($curld, CURLOPT_RETURNTRANSFER, true);

        $output = curl_exec($curld);

        curl_close ($curld);
    }
}
