<?php
//bazaga ulanish
include "../sql.php";

date_Default_timezone_set("Asia/Tashkent");
$soat=date('H:i');
$soatb=date('H:i', strtotime('1 minutes'));
$result=mysqli_query($connect, "SELECT * FROM `sendusers` WHERE `status`='active'"); 
while($row= mysqli_fetch_assoc($result)){
$jv=$row["joriy_vaqt"];   
} 
if($soat !=$jv and $soatb !=$jv){
mysqli_query($connect, "UPDATE `sendusers` SET `joriy_vaqt`='$soatb'");
}


$key=json_decode(file_get_contents("../key.txt"), true)['message']['reply_markup'];

//daqiqasiga nechta userga xabar jo'natish
$jonatish=300;

//bot tokeni
$tokenbot="5245536788:AAFjQ8NQUEa-s-KZDHeIbH8BqYHp1NcsVqo";

//Asosiy admin id
$admin="818250253"; 
date_Default_timezone_set("Asia/Tashkent");
$soat=date('H:i');
$result=mysqli_query($connect, "SELECT * FROM `sendusers` WHERE `status`='active'"); 
while($row= mysqli_fetch_assoc($result)){
$jv=$row["joriy_vaqt"];   
$mesid=$row["mid"];   
$limit=$row["soni"];   
$status=$row["status"];
$send=$row["send"];
$xturi=$row["holat"];
$nosend=$row["nosend"];
$qb=$row["qayerga"];
$kimdan=$row["kimdan"];
} 
if($qb == "users"){
	$bor = "users";
	$idlar = "user_id";
}elseif($qb=="guruh"){
	$bor = "group";
	$idlar = "chat_id";
}elseif($qb == "channels"){
	$bor = "channel";
	$idlar = "chat_id";
}
if($soat==$jv){
$res=mysqli_query($connect, "SELECT `$idlar` FROM `$bor` LIMIT $limit, $jonatish"); 
while($rowsend= mysqli_fetch_assoc($res)){
$id=$rowsend["$idlar"];   
$keyurl=file_get_contents("../key.txt");
usleep(80000); 
if(strlen($keyurl)<10){
$okk=file_get_contents("https://api.telegram.org/bot$tokenbot/$xturi?chat_id=$id&from_chat_id=$admin&message_id=$mesid");
}else{
$okk=file_get_contents("https://api.telegram.org/bot$tokenbot/$xturi?chat_id=$id&from_chat_id=$admin&message_id=$mesid&reply_markup=".urlencode(json_encode($key)));
}
$ok=json_decode($okk, true)["ok"];
if($ok){
$results=mysqli_query($connect, "SELECT * FROM `sendusers`"); 
while($row= mysqli_fetch_assoc($results)){
$sd=$row["send"];
$nosend=$row["nosend"];
}  
$sd+=1;
mysqli_query($connect, "UPDATE `sendusers` SET `send`='$sd'");
}else{
$nosend+=1;
mysqli_query($connect, "UPDATE `sendusers` SET `nosend`='$nosend'");
//mysqli_query($connect, "UPDATE `users` SET `status`='1' WHERE user_id = '$id'");
}
} 
$limit+=$jonatish;
$vt=date('H:i', strtotime("1 minutes"));
mysqli_query($connect, "UPDATE `sendusers` SET `joriy_vaqt`='$vt'");  
mysqli_query($connect, "UPDATE `sendusers` SET `soni`='$limit'");  
$rest=mysqli_query($connect, "SELECT * FROM `$bor` LIMIT $limit, 1"); 
$bor=mysqli_num_rows($rest); 
if($bor==0){
mysqli_query($connect, "UPDATE `sendusers` SET `status`='passive'");
$result=mysqli_query($connect, "SELECT * FROM `sendusers` WHERE `status`='passive'"); 
while($row= mysqli_fetch_assoc($result)){
$jv=$row["joriy_vaqt"];   
$bv=$row["boshlash_vaqt"];   
$sn=number_format($row["send"]);
$ds=number_format($row["nosend"]);
$all = number_format($sn + $ds);
} 

$txad=urlencode("
<b>
┌💡Reklama Yuborish Yakuniga Yetdi )✅
├🕔Boshlangan Vaqt: $bv 
├⏰Tugatilgan Vaqt: $jv 
├🎉Umumiy Xabar Yuborildi: $all
├✳️Xabarni qabul qilganlar: $sn
├⛔️Xabar qabul qilmaganlar: $ds
</b>");
file_get_contents("https://api.telegram.org/bot$tokenbot/sendmessage?chat_id=$admin&text=$txad&parse_mode=html");
//unlink("../key.txt");
exit();
} 
} 


?>