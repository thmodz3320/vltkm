<?php

    date_default_timezone_set("Asia/kolkata");
    //Data From Webhook
    $content = file_get_contents("php://input");
    $update = json_decode($content, true);
    $chat_id = $update["message"]["chat"]["id"];
    $message = $update["message"]["text"];
    $message_id = $update["message"]["message_id"];
    $id = $update["message"]["from"]["id"];
    $username = $update["message"]["from"]["username"];
    $firstname = $update["message"]["from"]["first_name"];
    $chatname = $_ENV['CHAT']; 
 /// for broadcasting in Channel
$channel_id = "-100xxxxxxxxxx";

/////////////////////////

    //Extact match Commands
    if($message == "/start"){
        send_message($chat_id,$message_id, "Hey $firstname \nUse /cmds to view commands \n$chatname");
    }

$SV = explode(" ", $message)[1];
$CauLenh = explode(" ", $message)[2];
if (strpos($message, "/help") === 0)
{
    send_message("⭕️ /rsmoc tensvviettat tentk");
    send_message("⭕️ /online tensvviettat");
    send_message("⭕️ /allonline tensvviettat");
}
if(!$SV or !ServerList($SV)){
	    send_message("❎ Vui lòng điền thêm Máy chủ [GÕ] /help để xem các lệnh.");
}
if (strpos($message, "/rsmoc") === 0)
{
    $return = file_get_contents(ServerList($SV) . "rsmoc.php?sv=" . $CauLenh);
    if ($return == "true")
    {
        send_message("✅ [MỐC] - MÁY CHỦ:" . ServerListName($SV) . " - TÀI KHOẢN:" . $CauLenh . " => đã được Reset.");
    }
    else
    {
        send_message("❎ " . $return);
    }
}
if (strpos($message, "/online") === 0)
{
    $curl_scraped_page = file_get_contents(ServerList($SV) . "Online.php?sv=" . $CauLenh);
    send_message("✅ [ONLINE] - MÁY CHỦ:" . ServerListName($SV) . " " . $curl_scraped_page);
}
if (strpos($message, "/allonline") === 0)
{
    $curl_scraped_page = file_get_contents(ServerList($SV) . "Onlineall.php");
    if (!$curl_scraped_page or $curl_scraped_page == "true")
    {
        send_message("❎ Câu lệnh thất bại.");
    }
    else
    {
        $cachdong = explode('<br/>', $curl_scraped_page);
        for ($i = 0;$i <= count($cachdong);$i++)
        {
            send_message("" . $cachdong[$i]);
        }
    }
}
if (strpos($message, "/sendthu") === 0)
{
$IDNHANVAT = explode(" ", $message)[3];
$LISTITEM = explode(" ", $message)[4];
    $curl_scraped_page = file_get_contents(ServerList($SV) . "sendmailist.php?sv=".$CauLenh."@idnhanvat=".$IDNHANVAT."@list=".$LISTITEM);
    if (!$curl_scraped_page or $curl_scraped_page == "true")
    {
        send_message("✅ Gửi thư thành công.");
    }
    else
    {
        send_message("❎ Gửi thư thất bại.".$curl_scraped_page);
    }
}
///Send Message (Global)
    function send_message($chat_id,$message_id, $message){
        $text = urlencode($message);
        $apiToken = $_ENV['API_TOKEN'];  
        file_get_contents("https://api.telegram.org/bot$apiToken/sendMessage?chat_id=$chat_id&reply_to_message_id=$message_id&text=$text");
    }
    
//Send Messages with Markdown (Global)
      function send_MDmessage($chat_id,$message_id, $message){
        $text = urlencode($message);
        $apiToken = $_ENV['API_TOKEN'];  
        file_get_contents("https://api.telegram.org/bot$apiToken/sendMessage?chat_id=$chat_id&reply_to_message_id=$message_id&text=$text&parse_mode=Markdown");
    }
///Send Message to Channel
      function send_Cmessage($channel_id, $message){
        $text = urlencode($message);
        $apiToken = $_ENV['API_TOKEN'];
        file_get_contents("https://api.telegram.org/bot$apiToken/sendMessage?chat_id=$channel_id&text=$text");
    }

//Send Dice (dynamic emoji)
function sendDice($chat_id,$message_id, $message){
        $apiToken = $_ENV['API_TOKEN'];  
        file_get_contents("https://api.telegram.org/bot$apiToken/sendDice?chat_id=$chat_id&reply_to_message_id=$message_id&text=$message");
    }


?>
