<?php
	
	$botToken = "1036235226:AAEHiMaeIW0CRa34AvVG7H4JWuUBJn_poIM"; // Api TOKEN to our bot
	$website = "https://api.telegram.org/bot".$botToken;

	$FilejSon = file_get_contents("php://input"); // Take the url input, in this case will be executed method getUpdates that return Update.
	$FilejSon = json_decode($FilejSon, TRUE); // Decode the variable before because now we can search with key (because it's a dictionary)

	$FirstName = $FilejSon["message"]["chat"]["first_name"]; // Get the name that user set
	$ChatID = $FilejSon["message"]["chat"]["id"]; // get the User ID, this is unique
	$Message = $FilejSon["message"]["text"]; // Get the message sent from user
    $querymsgid = $query['message']['message_id'];
	
	
	
	
	
	
	switch ($Message)
	{
		case '/start':
			$msg = "Welcome $FirstName! I'm a Tutorial Bot.";
			SendGenericMenu($ChatID);
			break;

		case '/keyboard': // Command to show normal Keyboard
			$msg = "This is a Tutorial, this Keyboard has 3 buttons, click one to test.";
			showKeyboard($ChatID, $msg);
			break;

		case "chatid":
			$msg = $ChatID;
			sendMessage($ChatID, $msg);
			break;

		case "Normal Keyboard": // This is the same text inside a Keyboard
			$msg = "Abracadabra and keyboard will appear!";
			showKeyboard($ChatID, $msg);
			break;
			
		case "Hide Keyboard": // This is the same text inside a Keyboard
			$msg = "Test Remove $querymsgid";
			sendMessage($ChatID, $msg);
			break;

		case "Inline Keyboard": // This is the same text inside a Keyboard
			$msg = "Abracadabra and inline keyboard will appear!";
			inlineKeyboard($ChatID, $msg);
			break;

		case "Remove Keyboard": // This is the same text inside a Keyboard
			$msg = "Abracadabra and keyboard will disappear!";
			removeKeyboard($ChatID, $msg);
			break;

		default:
			$msg = "Unknown Command! So sorry ;(";
			sendMessage($ChatId, $msg);
			break;
	} 
	

	function sendMessage($chat_id, $text)
	{
		$url = $GLOBALS[website]."/sendMessage?chat_id=".$chat_id."&text=".urlencode($text);
		file_get_contents($url);
	}

	function showKeyboard($chat_id, $text)
	{
		$jSonCodeKeyboard = '&reply_markup={"keyboard":[["Normal%20Keyboard"],["Hide%20Keyboard","Remove%20Keyboard"]],"resize_keyboard":true}';
		//$jSonCodeKeyboard = '&reply_markup={"keyboard":["text":"Prova","callback_data":"Remove Keyboard"]}';
		$url = $GLOBALS[website]."/sendMessage?chat_id=".$chat_id."&text=".urlencode($text).$jSonCodeKeyboard;
		file_get_contents($url);
	}

	function removeKeyboard($chat_id, $text)
	{
		$jSonCodeKeyboard = '&reply_markup={"remove_keyboard":true}';
		$url = $GLOBALS[website]."/sendMessage?chat_id=".$chat_id."&text=".urlencode($text).$jSonCodeKeyboard;
		file_get_contents($url);
	}

	function inlineKeyboard($chat_id, $text) // This is an useless type of this keyboard, in a specific Tutorial I show an useful usage of this keyboard.
	{
		$jSonCodeKeyboard = '&reply_markup={"inline_keyboard":[[{"text":"API%20Bot%20Telegram","url":"https://core.telegram.org/bots/api"},{"text":"Google","url":"https://www.google.com"}]]}';
		$url = $GLOBALS[website]."/sendMessage?chat_id=".$chat_id."&text=".urlencode($text).$jSonCodeKeyboard;
		file_get_contents($url);
	}
	function SendGenericMenu ($chatid) {
$lista=array("A", "B", "C");
$text="Choose:";
global $bottoken;
$replyMarkup = array(
    'keyboard' => $lista,
);
$encodedMarkup = json_encode($replyMarkup);
$content = array(
    'chat_id' => $chatid,
    'reply_markup' => $encodedMarkup,
    'text' => "$text"
);

$ch = curl_init();
$url="https://api.telegram.org/bot$bottoken/SendMessage";
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($content));
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

// receive server response ...
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$server_output = curl_exec ($ch);
curl_close ($ch);
var_dump($server_output);

}
