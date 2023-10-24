<?php
header('Content-Type: application/json');
error_reporting(0);

/*
!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
!!! Ushbu Likeedan Video Yuklovchi Api qobilbek1 (Qobilbek Boltaboyev) tomonidan yozib chiqilgan !!!
!!!                    Mualliflik xuquqi o`g`irlanmasin !!!!!!                      !!!
!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
*/

if ($_GET['url'] == null) {
    $array = ['ok' => false, 'error' => "Mediani yuklash uchun havola kiritilmadi!", 'creator' => "Telegram: @qobilbek1",];
    echo json_encode($array, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    exit;
}

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, 'https://down2you.com/wp-json/aio-dl/video-data/');
curl_setopt($curl, CURLOPT_HTTPHEADER, array('referer: https://down2you.com/', 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.45 Safari/537.36'));
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, 'url=' . $_GET['url']);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($curl);
curl_close($curl);
$api = json_decode($result);
if ($api == null) {
    $array = ['ok' => false, 'error' => "Qanaqadir xatolik sodir bo'ldi :(", 'creator' => "Telegram: @qobilbek1",];
    echo json_encode($array, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    exit;
}

if (isset($api->url)) {
    $array = ['url' => $api->medias[0]->url,'thumb' => $api->thumbnail,'duration' => $api->duration, 'type' => $api->medias[0]->extension, 'quality'=>$api->medias[0]->quality,'title' => $api->title];
    $array = ['ok' => true, 'result' => $array, 'creator' => "Telegram: @qobilbek1",];
    echo json_encode($array, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
} 

/*
!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
!!! Ushbu Likeedan Video Yuklovchi  Api qobilbek1 (Qobilbek Boltaboyev) tomonidan yozib chiqilgan !!!
!!!                    Mualliflik xuquqi o`g`irlanmasin !!!!!!                      !!!
!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
*/

