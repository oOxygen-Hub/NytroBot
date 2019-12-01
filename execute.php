<?php
	
	include "config.php"; // relative url to code that contains credential to access to our database

	$botToken = "API_TOKEN"; // Api TOKEN to our bot
	$website = "https://api.telegram.org/bot".$botToken;

	$FilejSon = file_get_contents("php://input"); // Take the url input, in this case will be executed method getUpdates that return Update.
	$FilejSon = json_decode($FilejSon, TRUE); // Decode the variable before because now we can search with key (because it's a dictionary)

	$FirstName = $FilejSon["message"]["chat"]["first_name"]; // Get the name that user set
	$UserChatId = $FilejSon["message"]["chat"]["id"]; // get the User ID, this is unique
	$Message = $FilejSon["message"]["text"]; // Get the message sent from user

	// Variable only for Inline Keyboard
	$CallBackID = $FilejSon["callback_query"]["from"]["id"];
	$CallBackData = $FilejSon["callback_query"]["data"];

	/*

		This Tutorial use 2 Table:

		'TutoriaKeyboard' has these rows:
			UniqueID -> Integer value and this is the ID of Keyboard
			NomeLeyout -> The Layout Name (used to identiry the keyboard)
			CodiceTastiera -> The Keyboard's code ( e.g. &reply_markup={"keyboard":[[{"text":"This is an example Keyboard Code saved in DB"}]]} )
			Type -> Not useful in this Tutorial (useful later) identify the Keyboard Type (e.g. inline_keboard, keyboard, ...)

		'TutorialCMD' has these rows:
			ID -> Integer value and this is the ID of command
			NomeCMD -> The command and how this will be called back (e.g. saved Hello, when user send 'Hello' bot take the reply from this DB)
			Messaggio -> Message that bot send when 'NomeCMD' was identified
			LayoutTastiera -> The Keyboard that you wanna show with message (the same of 'NomeLeyout' in 'TutoriaKeyboard' DB)
			TypeKey -> Not useful in this Tutorial (useful later) identify the Keyboard Type (e.g. inline_keboard, keyboard, ...)

	*/

	if ($UserChatId == 23326587) // Specific chat_id to insert automatically specific command in our DataBase
	{
		if (substr_count($Message, "-") == 2) // In our case we need to insert 3 elements so there are only 2 ' - ' 
		{ 
			$NewMessage = explode("-", $Message); 
			// pattern: Array[0] = NAme Comand, Array[1] = What bot Reply, Array[2] = Name Layout Keyboard

			$Insert = mysql_query("INSERT INTO `TutorialCMD` (`ID`, `NomeCMD`, `Messaggio`, `LayoutTastiera`) VALUES (NULL, '$NewMessage[0]', '$NewMessage[1]', '$NewMessage[2]')");
			$msg = "Name Command: ".$NewMessage[0]." \nWhat bot Reply: ".$NewMessage[1]." \nName Keyboard: ".$NewMessage[2];
			sendMessage($UserChatId, $msg, "");
		}
	}

	switch ($Message)
	{
		case '/start':
			$msg = "Welcome $GLOBALS[FirstName]! I'm a Tutorial Bot.";
			sendMessage($UserChatId, $msg, "help");
			break;

		case "chatid":
			$msg = $UserChatId;
			sendMessage($UserChatId, $msg, "help");
			break;

		default:

			if (callback($FilejSon)) // check if input is a callback
			{
				if ($CallBackData == "Click") // Check if inline button data has that value
				{
					sendMessage($CallBackID, "Ottimo! Sei stato bravo!", "");
				}
			}

			else
			{
				$Search = mysql_query("SELECT * FROM `TutorialCMD` WHERE `NomeCMD` LIKE '%$Message%'");
				while ($Row = mysql_fetch_assoc($Search)) 
				{
					$Text = $Row["Messaggio"]; // What this bot reply to user
					$CMD = $Row["NomeCMD"]; // not useful, this will never be used...
					$ID = $Row["ID"]; // Like CMD, this is not useful so we can delete this code.
					$NameLayoutKeyboard = $Row["LayoutTastiera"]; // Here we take the name of Keyboard (this will be used in another table of DataBase)
				}
				sendMessage($UserChatId, $Text, $NameLayoutKeyboard);
			}

			break;

	}
	

	function sendMessage($chat_id, $text, $LayoutKey) // Function that send a message
	{

		if ($LayoutKey == "") // If LayoutKey is invalid this code will be execute
		{
			$url = $GLOBALS[website]."/sendMessage?chat_id=".$chat_id."&text=".urlencode($text);
			file_get_contents($url); // Execute that URL
		}

		else
		{
			$Search2 = mysql_query("SELECT * FROM `TutoriaKeyboard` WHERE `NomeLeyout` LIKE '%$LayoutKey%'"); // Takes the name of Keyboard and takes the jSon code from a specific Table of DataBase that contains jSon codes.
			while ($Row = mysql_fetch_assoc($Search2)) 
			{
				$jSonCodeKeyboard = $Row["CodiceTastiera"]; // this takes a jSon code from our Table.
			}

			$url = $GLOBALS[website]."/sendMessage?chat_id=".$chat_id."&text=".urlencode($text).$jSonCodeKeyboard;
			file_get_contents($url);
		}
	}

	// Function that try to access to callback, if it can be done, will be returned correct values else will be returned false
	function callback($getUpdate)
	{
		if ($getUpdate["callback_query"]) // is possibile to access to 'callback_query' key? If true return true, else return false
			return true;
		else
			return false;
	}

?>
