<?php
  $botToken = "1036235226:AAEHiMaeIW0CRa34AvVG7H4JWuUBJn_poIM";
  $website = "https://api.telegram.org/bot".$botToken;
  
  $update = file_get_contents('php://input');
  $update = json_decode($update, TRUE);
  $chatId = $update['message']['from']['id'];
  $nome = $update['message']['from']['first_name'];
  $text = $update['message']['text'];
  $query = $update['callback_query'];
  $queryid = $query['id'];
  $queryUserId = $query['from']['id'];
  $queryusername = $query['from']['username'];
  $querydata = $query['data'];
  $querymsgid = $query['message']['message_id'];
  $inlinequery = $update['inline_query'];
  $inlineid = $inlinequery['id'];
  $inlineUserId = $inlinequery['from']['id'];
  $inlinequerydata = $inlinequery['query'];
  if(isset($update['inline_query'])) {
    gestisciInlineQuery($inlineid,$inlineUserId,$inlinequerydata,$inlinequery['from']['username'],$inlinequery['from']['first_name'],$inlinequery['from']['last_name']);
    exit();
  }
  $agg = json_encode($update,JSON_PRETTY_PRINT);
  if($querydata == "StampaMessaggio"){
    answerQuery($queryid,"Ciao $queryusername! Come stai?!");
    exit();
  }
  if($querydata == "InfoBot"){
    answerQuery($queryid,"Io Sono un Robot!");
    exit();
  }
   if(strpos($text,"+")!==false){
          sendMessage($chatId,eval('return '.$text.';'));
         exit();
   }

   $tastierainline = '[{"text":"Forum","url":"http://ooxygen.tech"},{"text":"Inline","switch_inline_query":"Ciao!"}],[{"text":"Testo","callback_data":"StampaMessaggio"},{"text":"Bot","callback_data":"InfoBot"}]';
   
  switch($text){
    case "/start":
        $tastierabenvenuto = '["Menu","Links"],["'.$nome.'","Info Bot"],[{"text":"Testo","callback_data":"StampaMessaggio"}]';
        sendMessage($chatId,"Ciao <b>$nome</b>! Come posso esserti utile?",$tastierabenvenuto,"fisica");
        break;
    case "Official Channel":
	    $message_body = "<b>Questi sono i tuoi dettagli</b> \n $nome \n $chatId \n $queryusername \n https://it.gearbest.com/3d-printers-3d-printer-kits/pp_428455.html"; 
        sendMessage($chatId,$message_body,$tastierabenvenuto,"fisica");
        break;
    case "Menu":
        sendMessage($chatId,"NytroBot Master Links",$tastierainline,"inline");
        break;
    case "Links":
        sendMessage($chatId,"http://ooxygen.tech",$tastierabenvenuto,"fisica");
    default:
      //$tastierabenvenuto = '["che"],["palle"],["'.$nome.'"]';
      //sendMessage($chatId,"Ciao <b>$nome</b>! Come stai?",$tastierabenvenuto,"fisica");
      break;
  }
  
  function sendMessage($chatId,$text,$tastiera,$tipo){
    if(isset($tastiera)){
      if($tipo == "fisica"){
        $tastierino = '&reply_markup={"keyboard":['.urlencode($tastiera).'],"resize_keyboard":true}';
      }
      else {
        $tastierino = '&reply_markup={"inline_keyboard":['.urlencode($tastiera).'],"resize_keyboard":true}';
      }
    }
    $url = $GLOBALS[website]."/sendMessage?chat_id=$chatId&parse_mode=HTML&text=".urlencode($text).$tastierino;
    file_get_contents($url);
  }
  
  function answerQuery($callback_query_id,$text){
    $url = $GLOBALS[website]."/answerCallbackQuery?callback_query_id=$callback_query_id&text=".urlencode($text);
    file_get_contents($url);
  }

  function gestisciInlineQuery($queryId,$chatId,$querydata,$username,$name,$cognome)
  {
      $risultati = json_encode($risultati,true);
      $url = $GLOBALS[website]."/answerInlineQuery?inline_query_id=$queryId&results=$risultati&cache_time=0&switch_pm_text=Vai al Bot&switch_pm_parameter=123";
      file_get_contents($url);
      exit();
  }
