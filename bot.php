<?php
header('Content-Type: text/html; charset=utf-8');

$path = "https://api.telegram.org/bot1774522961:AAFkfzcSEAaVkKxtT0f_g3AIfRSd3Vb4Ucg";

$update = json_decode(file_get_contents("php://input") , true);

$chatId = $update["message"]["chat"]["id"];
$message = $update["message"]["text"];
function ServerList($sv)
{
    switch ($sv)
    {
        case 'sg':
            return 'https://nap.volamsaigon.mobi/config/Telegram/';
        break;

        case 'cc':
            return 'https://nap.jxcucai.net/config/Telegram/';
        break;

        case 'hm':
            return 'https://nap.jxhoanmy.com/config/Telegram/';
        break;
    }
}
function ServerListName($sv)
{
    switch ($sv)
    {
        case 'sg':
            return "Sài Gòn";
        break;

        case 'cc':
            return "Củ Cải";
        break;

        case 'hm':
            return "Hoàn Mỹ";
        break;
		
		default:
		return false;
		break;
    }
}
$SV = explode(" ", $message)[1];
$CauLenh = explode(" ", $message)[2];
if (strpos($message, "/help") === 0)
{
    file_get_contents($path . "/sendmessage?chat_id=" . $chatId . "&text=⭕️ /rsmoc tensvviettat tentk");
    file_get_contents($path . "/sendmessage?chat_id=" . $chatId . "&text=⭕️ /online tensvviettat");
    file_get_contents($path . "/sendmessage?chat_id=" . $chatId . "&text=⭕️ /allonline tensvviettat");
}
if(!$SV or !ServerList($SV)){
	    file_get_contents($path . "/sendmessage?chat_id=" . $chatId . "&text=❎ Vui lòng điền thêm Máy chủ [GÕ] /help để xem các lệnh.");
}
if (strpos($message, "/rsmoc") === 0)
{
    $return = file_get_contents(ServerList($SV) . "rsmoc.php?sv=" . $CauLenh);
    if ($return == "true")
    {
        file_get_contents($path . "/sendmessage?chat_id=" . $chatId . "&text=✅ [MỐC] - MÁY CHỦ:" . ServerListName($SV) . " - TÀI KHOẢN:" . $CauLenh . " => đã được Reset.");
    }
    else
    {
        file_get_contents($path . "/sendmessage?chat_id=" . $chatId . "&text=❎ " . $return);
    }
}
if (strpos($message, "/online") === 0)
{
    $curl_scraped_page = file_get_contents(ServerList($SV) . "Online.php?sv=" . $CauLenh);
    file_get_contents($path . "/sendmessage?chat_id=" . $chatId . "&text=✅ [ONLINE] - MÁY CHỦ:" . ServerListName($SV) . " " . $curl_scraped_page);
}
if (strpos($message, "/allonline") === 0)
{
    $curl_scraped_page = file_get_contents(ServerList($SV) . "Onlineall.php");
    if (!$curl_scraped_page or $curl_scraped_page == "true")
    {
        file_get_contents($path . "/sendmessage?chat_id=" . $chatId . "&text=❎ Câu lệnh thất bại.");
    }
    else
    {
        $cachdong = explode('<br/>', $curl_scraped_page);
        for ($i = 0;$i <= count($cachdong);$i++)
        {
            file_get_contents($path . "/sendmessage?chat_id=" . $chatId . "&text=" . $cachdong[$i]);
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
        file_get_contents($path . "/sendmessage?chat_id=" . $chatId . "&text=✅ Gửi thư thành công.");
    }
    else
    {
        file_get_contents($path . "/sendmessage?chat_id=" . $chatId . "&text=❎ Gửi thư thất bại.".$curl_scraped_page);
    }
}
exit();

?>
