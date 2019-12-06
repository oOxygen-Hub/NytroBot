<?php
	
	$botToken = "1036235226:AAEHiMaeIW0CRa34AvVG7H4JWuUBJn_poIM"; // Api TOKEN to our bot
	$website = "https://api.telegram.org/bot".$botToken;

	$FilejSon = file_get_contents("php://input"); // Take the url input, in this case will be executed method getUpdates that return Update.
	$FilejSon = json_decode($FilejSon, TRUE); // Decode the variable before because now we can search with key (because it's a dictionary)

	$FirstName = $FilejSon["message"]["chat"]["first_name"]; // Get the name that user set
	$ChatID = $FilejSon["message"]["chat"]["id"]; // get the User ID, this is unique
	$Message = $FilejSon["message"]["text"]; // Get the message sent from user
    $messageId = $FilejSon["message"]["message_id"]; // get the User ID, this is unique
	
	switch ($Message)
	{
		case '/start':
			$msg = "Benvenuto $FirstName! Io non sono umano sono un Robot.";
			showKeyboard($ChatID, $msg);
			break;

		case '/keyboard': // Command to show normal Keyboard
			$msg = "Questo è il comando tastiera.";
			showKeyboard($ChatID, $msg);
			break;

		case "chatid":
			$msg = $ChatID;
			sendMessage($ChatID, $msg);
			break;

		case "Tastiera Normale": // This is the same text inside a Keyboard
			$msg = "Abracadabra la tastiera appare!";
			showKeyboard($ChatID, $msg);
			break;
			
		case "Nascondi Tastiera": // This is the same text inside a Keyboard
		    //$msg = "Welcome $messageId! I'm a Tutorial Bot.";
			 $message_body = "<b>Questi sono i tuoi dettagli</b> \n $FirstName \n $ChatID \n $messageId \n https://www.carspecs.us/photos/c8447c97e355f462368178b3518367824a757327-2000.jpg";
			sendMessageParseHtml($ChatID, $message_body);
			break;

		case "Inline Keyboard": // This is the same text inside a Keyboard
			$msg = "Abracadabra and inline keyboard will appear!";
			inlineKeyboard($ChatID, $msg);
			break;

		case "Rimuovi Tastiera": // This is the same text inside a Keyboard
			$msg = "Abracadabra la tastiera scompare!";
			removeKeyboard($ChatID, $msg);
			break;
			
		case "Invia Immagine": // This is the same text inside a Keyboard
			$msg = "Abracadabra la tastiera scompare!";
			$photoUrl ="http://3d-world.ooxygen.tech/images/misc/security.png"; 
			$photoDesc ="Immagine Inviata";
			sendImage($ChatID, $photoUrl, $photoDesc);
			break;

		default:
			$msg = "Unknown Command!";
			sendMessage($ChatID, $msg);
			break;
	} 
	

	function sendMessage($chat_id, $text)
	{
		$url = $GLOBALS[website]."/sendMessage?chat_id=".$chat_id."&text=".urlencode($text);
		file_get_contents($url);
	}

	function sendMessageParseHtml($chat_id, $text)
	{
		$url = $GLOBALS[website]."/sendMessage?chat_id=$chat_id&parse_mode=HTML&text=".urlencode($text);
		file_get_contents($url);
	}

	function showKeyboard($chat_id, $text)
	{
		$jSonCodeKeyboard = '&reply_markup={"keyboard":[["Tastiera%20Normale"],["Nascondi%20Tastiera","Rimuovi%20Tastiera"]["Invia%20Immagine"],],"resize_keyboard":true}';
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
	
	function deleteMessage($chat_id, $querymsgid) // This is an useless type of this keyboard, in a specific Tutorial I show an useful usage of this keyboard.
	{
	    $url = $GLOBALS[website]."/deleteMessage?chat_id=$ChatID&message_id=$querymsgid";
        file_get_contents($url);
	}
	
	function sendImage($chat_id, $photoUrl, $photoDesc) // This is an useless type of this keyboard, in a specific Tutorial I show an useful usage of this keyboard.
	{
	    $url = $GLOBALS[website]."/sendPhoto?chat_id=".$chat_id."&photo=".$photoUrl."&caption=".urlencode($photoDesc);
	    file_get_contents($url);
	}
