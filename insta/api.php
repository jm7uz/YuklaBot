<?php
ob_start();
error_reporting(0);
header('Content-Type: application/json');

function info($id){
    $curl = curl_init();   
    curl_setopt($curl, CURLOPT_URL, "https://save-from.net/api/convert");
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
    'Origin: https://save-from.net', 
    'Referer: https://save-from.net/', 
    'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win68; x68) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.46564.45 Safarli/537.36'));
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, "url=".$id);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    curl_close($curl);

    return $response;
}

$res = info($_GET["url"]);
$json = json_decode($res,1);
if(!empty($_GET['url'])) {
if(!empty($json[0])) {
for($i = 0; $i <= count($json)-1; $i++) {
$arrays["meta"]["title"] = $json[0]['meta']['title'];
$arrays["meta"]["source"] = $json[0]['meta']['source'];
if($json[$i]['url'][0]['type'] == "mp4") {
	$json[$i]['url'][1]['type'] = "video";
}elseif($json[$i]['url'][0]['type'] == "mp3") {
	$json[$i]['url'][0]['type'] = "audio";
}else{
	$json[$i]['url'][1]['type'] = "photo";
}
$arrays["results"][] = ["url"=> $json[$i]['url'][0]['url'], "type"=> $json[$i]['url'][0]['type'], "thumbnail"=> $json[$i]['thumb']];
}
echo json_encode($arrays,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
}elseif($json['url'][0]['url']) {
$arrays["meta"]["title"] = $json['meta']['title'];
$arrays["meta"]["source"] = $json['meta']['source'];
if($json[$i]['url'][0]['type'] == "mp4") {
	$json['url'][0]['type'] = "video";
}else{
	$json['url'][0]['type'] = "photo";
}

$arrays["results"][] = ["url"=> $json['url'][1]['url'], "type"=> $json['url'][0]['type'], "thumbnail"=> $json['thumb']];
if(! empty ($json['url'][0]['url'])) {
$arrays["results"][] = ["url"=> $json['url'][0]['url'], "type"=> 'audio', "thumbnail"=> $json['thumb']];
}
echo json_encode($arrays,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
}else{

	echo json_encode(array("error"=> "Media'ni yuklab bo'lmadi. Telegram: t.me/sol1khman"));
}
}else{
	echo json_encode(array("error"=> "Media'ni yuklab bo'lmadi. Telegram: t.me/sol1khman"));
}
?>