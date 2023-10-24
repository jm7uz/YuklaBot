<?php
date_Default_timezone_set("Asia/Tashkent");
require("sql.php");
$token = "5245536788:AAFjQ8NQUEa-s-KZDHeIbH8BqYHp1NcsVqo";
$botid = explode(":", $token)[0];

$step = file_get_contents("step/$chat_id.txt");

$adminlist = mysqli_fetch_assoc(mysqli_query($connect,"SELECT user_id FROM admins WHERE `user_id` = '$chat_id'"))["user_id"];


$panel1 = json_encode([
    'inline_keyboard' => [
        [['text' => "📫 Xabar Yuborish", 'callback_data' => "send"], ['text' => "📬 Forward Yuborish", 'callback_data' => "sendf"]],
        [['text' => "🗯Reklama Info💬", 'callback_data' => "xabarinfo"]],
        [['text' => "Kanal ➕", 'callback_data' => "addchannel"], ['text' => "Kanal ➖", 'callback_data' => "delchannel"]],
        [['text' => "Admin ➕", 'callback_data' => "addadmin"], ['text' => "Admin ➖", 'callback_data' => "deladmin"]],
        [['text' => "Ban ➕", 'callback_data' => "ban+"], ['text' => "Ban ➖", 'callback_data' => "ban-"]],
        [['text' => "📄Kanallar", 'callback_data' => "channels"], ['text' => "📄Adminlar", 'callback_data' => "admins"]],
        [['text' => "📊 Statistika", 'callback_data' => "stat1"]],
    ]
]);

$xabarinfo = json_encode([
    'inline_keyboard' => [
        [['text' => "📮 Reklama Holati", 'callback_data' => "holat"], ['text' => "📬 Reklamani To'xtashish⛔️", 'callback_data' => "tugatish"]],
        [['text' => "🔙Orqaga", 'callback_data' => "ort"]]
    ]
]);



if ($text == "/panel" and $adminlist == true) {
    bot('SendMessage', [
        'chat_id' => $chat_id,
        'text' => "<b>Admin Paneliga Xush Kelibsiz, Marhamat Kerakli Menyuni Tanlang ¯\_(ツ)_/¯</b>",
        'parse_mode' => "html",
        'reply_markup' => $panel1,
    ]);
}

if ($data == "ort" and $adminlist == true) {
    unlink("step/$callcid.txt");
    bot('editmessagetext', [
        'chat_id' => $callcid,
        'text' => "<b>Marhamat Kerakli Menyuni tanlang!</b>",
        'parse_mode' => 'html',
        'message_id' => $callmid,
        'reply_markup' => $panel1,
    ]);
}


//Xabar Yuborish Qismi
if ($data == "send" and $adminlist == true) {
    bot('editmessagetext', [
        'chat_id' => $callcid,
        'message_id' => $callmid,
        'text' => "✏️<b>Hurmatli admin. Xabar yoki Reklama Yuborish uchun Chatni tanlang!</b>",
        'parse_mode' => 'html',
        'reply_markup' => json_encode([
            'inline_keyboard' => [
                [['text' => "👤Userlarga", 'callback_data' => "lichka"], ['text' => "👥Guruhlarga", 'callback_data' => "guruh"]],
                [['text' => "📡Kanallarga", 'callback_data' => "kanal"], ['text' => "🔙Orqaga", 'callback_data' => "ort"]]
            ]
        ])
    ]);
}



if ($data == "lichka" and $adminlist == true) {
    file_put_contents("step/$callcid.txt", "xabar_users");
    bot('editmessagetext', [
        'chat_id' => $callcid,
        'message_id' => $callmid,
        'text' => "✏️<b>Marhamat userlarga Yuboriladigan xabaringizni kiriting.</b>",
        'parse_mode' => 'html',
        'reply_markup' => json_encode([
            'inline_keyboard' => [
                [['text' => "🔙Orqaga", 'callback_data' => "ort"]]
            ]
        ])
    ]);
}

if ($data == "guruh" and $adminlist == true) {
    file_put_contents("step/$callcid.txt", "xabar_guruh");
    bot('editmessagetext', [
        'chat_id' => $callcid,
        'message_id' => $callmid,
        'text' => "✏️<b>Marhamat Guruhlarga Yuboriladigan xabaringizni kiriting.</b>",
        'parse_mode' => 'html',
        'reply_markup' => json_encode([
            'inline_keyboard' => [
                [['text' => "🔙Orqaga", 'callback_data' => "ort"]]
            ]
        ])
    ]);
}

if ($data == "kanal" and $adminlist == true) {
    file_put_contents("step/$callcid.txt", "xabar_kanal");
    bot('editmessagetext', [
        'chat_id' => $callcid,
        'message_id' => $callmid,
        'text' => "✏️<b>Marhamat Kanallarga Yuboriladigan xabaringizni kiriting.</b>",
        'parse_mode' => 'html',
        'reply_markup' => json_encode([
            'inline_keyboard' => [
                [['text' => "🔙Orqaga", 'callback_data' => "ort"]]
            ]
        ])
    ]);
}


if ($data == "sendf" and $adminlist == true) {
    bot('editmessagetext', [
        'chat_id' => $callcid,
        'message_id' => $callmid,
        'text' => "✏️<b> Hurmatli admin Forward qilish uchun Chatni tanlang!</b>",
        'parse_mode' => 'html',
        'reply_markup' => json_encode([
            'inline_keyboard' => [
                [['text' => "👤Userlarga", 'callback_data' => "forlichka"], ['text' => "👥Guruhlarga", 'callback_data' => "forguruh"]],
                [['text' => "📡Kanallarga", 'callback_data' => "forkanal"], ['text' => "🔙Orqaga", 'callback_data' => "ort"]]
            ]
        ])
    ]);
}


if ($data == "forlichka" and $adminlist == true) {
    file_put_contents("step/$callcid.txt", "forward_users");
    bot('editmessagetext', [
        'chat_id' => $callcid,
        'message_id' => $callmid,
        'text' => "✏️<b>Marhamat userlarga forward qilinadigan xabaringizni kiriting.</b>",
        'parse_mode' => 'html',
        'reply_markup' => json_encode([
            'inline_keyboard' => [
                [['text' => "🔙Orqaga", 'callback_data' => "ort"]]
            ]
        ])
    ]);
}

if ($data == "forguruh" and $adminlist == true) {
    file_put_contents("step/$callcid.txt", "forward_guruh");
    bot('editmessagetext', [
        'chat_id' => $callcid,
        'message_id' => $callmid,
        'text' => "✏️<b>Marhamat Guruhlarga forward qilinadigan xabaringizni kiriting.</b>",
        'parse_mode' => 'html',
        'reply_markup' => json_encode([
            'inline_keyboard' => [
                [['text' => "🔙Orqaga", 'callback_data' => "ort"]]
            ]
        ])
    ]);
}

if ($data == "forkanal" and $adminlist == true) {
    file_put_contents("step/$callcid.txt", "forward_kanal");
    bot('editmessagetext', [
        'chat_id' => $callcid,
        'message_id' => $callmid,
        'text' => "✏️<b>Marhamat Kanallarga forward qilinadigan xabaringizni kiriting.</b>",
        'parse_mode' => 'html',
        'reply_markup' => json_encode([
            'inline_keyboard' => [
                [['text' => "🔙Orqaga", 'callback_data' => "ort"]]
            ]
        ])
    ]);
}


if (!isset($update->callback_query) and mb_stripos($step, "xabar") !== false and $adminlist == true) {
    $rex = file_get_contents("step/$chat_id.txt");
    $ex = explode("_", $rex);
    $tur = $ex[1];
    $vt = date('H:i', strtotime("1 minutes"));
    $soat = date('H:i');
    bot('sendMessage', [
        'chat_id' => $chat_id,
        'text' => "✅<b>Xabar yuborishga tayyor. ⏳ Xabar yuborish boshlanadi: $vt</b>",
        'parse_mode' => "html",
        'reply_markup' => json_encode([
            'inline_keyboard' => [
                [['text' => "🔙Orqaga", 'callback_data' => "ort"]]
            ]
        ])
    ]);
    $result = mysqli_query($connect, "SELECT * FROM `sendusers`");
    $bor = mysqli_num_rows($result);
    if ($bor > 0) {
        mysqli_query($connect, "UPDATE `sendusers` SET `mid`='$mid', `boshlash_vaqt`='$soat'");
        mysqli_query($connect, "UPDATE `sendusers` SET `soni`='0', `joriy_vaqt`='$vt', `status`='active', `send`='0', `holat`='copyMessage', `nosend`='0',`qayerga`='$tur'");
    } else {
        mysqli_query($connect, "INSERT INTO `sendusers` (`mid`,`boshlash_vaqt`,`soni`,`joriy_vaqt`,`status`,`send`,`holat`,`nosend`,`qayerga`) VALUES('$mid', '$vt', 0, '$soat', 'active', 0, 'copyMessage',0,'$tur')");
    }
    $keyb = $update->message->reply_markup;
    if (isset($keyb)) {
        file_put_contents("key.txt", file_get_contents('php://input'));
    }
    unlink("step/$chat_id.txt");
    exit();
}



if (!isset($update->callback_query) and mb_stripos($step, "forward") !== false and $adminlist == true) {
    $rex = file_get_contents("step/$chat_id.txt");
    $ex = explode("_", $rex);
    $tur = $ex[1];
    $vt = date('H:i', strtotime("1 minutes"));
    $soat = date('H:i');
    bot('sendmessage', [
        'chat_id' => $chat_id,
        'text' => "✅<b>Forward Xabar yuborishga tayyor. ⏳Xabar yuborish boshlanadi: $vt</b>",
        'parse_mode' => "html",
        'reply_markup' => json_encode([
            'inline_keyboard' => [
                [['text' => "🔙Orqaga", 'callback_data' => "ort"]]
            ]
        ])
    ]);
    $result = mysqli_query($connect, "SELECT * FROM `sendusers`");
    $bor = mysqli_num_rows($result);
    if ($bor > 0) {
        mysqli_query($connect, "UPDATE `sendusers` SET `mid`='$mid', `boshlash_vaqt`='$soat'");
        mysqli_query($connect, "UPDATE `sendusers` SET `soni`='0', `joriy_vaqt`='$vt', `status`='active', `send`='0', `holat`='forwardMessage',`nosend`='0',`qayerga`='$tur'");
    } else {
        mysqli_query($connect, "INSERT INTO `sendusers`(`mid`, `boshlash_vaqt`, `soni`, `joriy_vaqt`, `status`, `send`, `holat`,`nosend`,`qayerga`) VALUES('$mid', '$vt', 0, '$soat', 'active', 0, 'forwardMessage',0,'$tur')");
    }
    unlink("step/$chat_id.txt");
    exit();
}


//Kanal Qo'shish Bo'limi
if ($data == "addchannel" and $adminlist == true) {
    file_put_contents("step/$callcid.txt", "addchannel");
    bot('editmessagetext', [
        'chat_id' => $callcid,
        'message_id' => $callmid,
        'text' => "<b>❗️Majburiz Azolik Uchun Qo'shadigan Kanaldan Birorta Post(Xabarni) Forward Shaklida Yuboring!!!</b>",
        'parse_mode' => 'html',
        'reply_markup' => json_encode([
            'inline_keyboard' => [
                [['text' => "🔙Orqaga", 'callback_data' => "ort"]]
            ]
        ])
    ]);
}




if ($step == "addchannel" and $text != "/start" and $adminlist == true) {
    $fid = $message->forward_from_chat->id;
    $forward = $message->forward_from_chat;
    $fwuser = $message->forward_from_chat->username;
    if ($forward == true) {
        file_put_contents("step/channel.id", $fid);

        bot('sendMessage', [
            'chat_id' => $chat_id,
            'text' => "*✅ Juda Soz! Endi Kanal Userini Yuboring! Namuna* `https://t.me/" . $fwuser . "`",
            'parse_mode' => 'markdown',
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [['text' => "🔙Orqaga", 'callback_data' => "ort"]]
                ]
            ])
        ]);
        file_put_contents("step/$chat_id.txt", "addurl");
    } else {
        bot('sendMessage', [
            'chat_id' => $chat_id,
            'text' => "*❎ Xatolik! Postni Botga Ulamoqchi Bo'lgan Kanaldan Forward Shaklida Yuboring!*",
            'parse_mode' => 'markdown',
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [['text' => "🔙Orqaga", 'callback_data' => "ort"]]
                ]
            ])
        ]);
    }
}

if (($step == "addurl") and (mb_stripos($text, "https://") !== false) and ($text != "/start") and $adminlist == true) {
    $fid = file_get_contents("step/channel.id");
    $result = mysqli_query($connect, "SELECT * FROM kanal WHERE chat_id = '$fid'");
    $rew = mysqli_fetch_assoc($result);
    if ($rew) {
        bot('sendMessage', [
            'chat_id' => $chat_id,
            'text' => "
<b>⛔️Ushbu Kanal Avval Qo'shilgan Boshqa Kanal ulashingiz mumkin</b>",
            'disable_web_page_preview' => true,
            'parse_mode' => 'html',
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [['text' => "🔙Orqaga", 'callback_data' => "ort"]]
                ]
            ])
        ]);
    } else {
        $gett = json_decode(file_get_contents("https://api.telegram.org/bot$token/getchatmember?chat_id=$fid&user_id=$botid"));
        $get = $gett->result->status;
        if ($get == "administrator") {
            mysqli_query($connect, "INSERT INTO kanal (chat_id,url) VALUES ('$fid','$text')");
            $a = json_decode(file_get_contents("https://api.telegram.org/bot$token/getchat?chat_id=$fid"));
            $titlee = $a->result->title;
            $link = $a->result->invite_link;
            bot('sendMessage', [
                'chat_id' => $chat_id,
                'text' => "
<b>✅Juda Soz Majburiy Azolik Uchun Kanal Muvaffaqiyatli Qo'shildi</b>

📢Ushbu Kanal | <b> <a href='$link'>$titlee</a></b>",
                'disable_web_page_preview' => true,
                'parse_mode' => 'html',
                'reply_markup' => json_encode([
                    'inline_keyboard' => [
                        [['text' => "🔙Orqaga", 'callback_data' => "ort"]]
                    ]
                ])
            ]);
        } else {
            bot('sendMessage', [
                'chat_id' => $chat_id,
                'text' => "
<b>⛔️Majburiy Azolik uchun ulamoqchi Kanalda bu Bot Admin Emas!
Xatolikni Tog'rilab qayta o'rinib Ko'ring😉</b>",
                'disable_web_page_preview' => true,
                'parse_mode' => 'html',
                'reply_markup' => json_encode([
                    'inline_keyboard' => [
                        [['text' => "🔙Orqaga", 'callback_data' => "ort"]]
                    ]
                ])
            ]);
        }
    }
}


if ($data == "channels" and $adminlist == true) {
    $result = mysqli_query($connect, "SELECT * FROM kanal");
    $row = mysqli_num_rows($result);
    if ($row == false) {
        bot('answercallbackquery', [
            'callback_query_id' => $update->callback_query->id,
            'text' => "📛Majburiy Azolik Uchun Kanallar Ulangan Emas!",
            'show_alert' => true,
        ]);
    } else {
        $result = mysqli_query($connect, "SELECT * FROM kanal");
        $row = mysqli_num_rows($result);
        if ($row > 0) {
            while ($rows = mysqli_fetch_assoc($result)) {
                $kanal .= $rows['chat_id'] . "\n";
                $kanalurl .= $rows['url'] . "\n";
            }

            $ids = explode("\n", $kanal);
            $soni = substr_count($kanal, "-100");

            $keyboards = [];
            $k = [];
            for ($for = 0; $for <= $row - 1; $for++) {
                $kanalurls = explode("\n", $kanalurl)[$for];
                $k = $for + 1;

                $a = json_decode(file_get_contents("https://api.telegram.org/bot$token/getchat?chat_id=$ids[$for]"));
                $titlee = $a->result->title;
                $keyboards[] = ["text" => "$titlee", "url" => $kanalurls];
            }
            $keyboard2 = array_chunk($keyboards, 1);
            $keyboard2[] = [["text" => "🔙Ortga", "callback_data" => "ort"]];
            $keyboard = json_encode([
                'inline_keyboard' => $keyboard2,
            ]);
        }
        bot('editmessagetext', [
            'chat_id' => $callcid,
            'message_id' => $callmid,
            'text' => "<b>📡Majburiy Azolik uchun ulangan kalanlar</b>",
            'parse_mode' => 'html',
            'reply_markup' => $keyboard,
        ]);
    }
}

if ($data == "delchannel" and $adminlist == true) {
    $result = mysqli_query($connect, "SELECT * FROM kanal");
    $row = mysqli_num_rows($result);
    if ($row < 0) {
        bot('answercallbackquery', [
            'callback_query_id' => $update->callback_query->id,
            'text' => "📛Majburiy Azolik Uchun Kanallar Ulangan Emas!",
            'show_alert' => true,
        ]);
    } else {
        $result = mysqli_query($connect, "SELECT * FROM kanal");
        $row = mysqli_num_rows($result);
        if ($row > 0) {
            while ($rows = mysqli_fetch_assoc($result)) {
                $kanal .= $rows['chat_id'] . "\n";
                $kanalurl .= $rows['url'] . "\n";
            }

            $ids = explode("\n", $kanal);
            $soni = substr_count($kanal, "-100");

            $keyboards = [];
            $k = [];
            for ($for = 0; $for <= $row - 1; $for++) {
                $kanalurls = explode("\n", $kanalurl)[$for];
                $k = $for + 1;

                $a = json_decode(file_get_contents("https://api.telegram.org/bot$token/getchat?chat_id=$ids[$for]"));
                $titlee = $a->result->title;
                $keyboards[] = ["text" => "$titlee", "callback_data" => "del|$ids[$for]"];
                $keyboard2 = array_chunk($keyboards, 1);
                $keyboard2[] = [["text" => "⛔️Bekor Qilish", "callback_data" => "ort"]];
                $keyboard = json_encode([
                    'inline_keyboard' => $keyboard2,
                ]);
            }
            bot('editmessagetext', [
                'chat_id' => $callcid,
                'message_id' => $callmid,
                'text' => "<b>🗑Qaysi Kanalni O'chirmoqchisiz?</b>",
                'parse_mode' => 'html',
                'reply_markup' => $keyboard,
            ]);
        }
    }
}

if (mb_stripos($data, "del|") !== false and $adminlist == true) {
    $fid = explode("|", $data)[1];
    $a = json_decode(file_get_contents("https://api.telegram.org/bot$token/getchat?chat_id=$fid"));
    $titlee = $a->result->title;
    $link = $a->result->invite_link;
    mysqli_query($connect, "DELETE FROM kanal WHERE chat_id='$fid'");
    bot('editmessagetext', [
        'chat_id' => $callcid,
        'message_id' => $callmid,
        'text' => "❗️<b><a href='$link'>$titlee</a></b> - Kanal O'chirildi🗑",
        'parse_mode' => 'html',
        'disable_web_page_preview' => true,
        'reply_markup' => json_encode([
            'inline_keyboard' => [
                [['text' => "🔙Ortga", "callback_data" => "ort"]],
            ]
        ]),
    ]);
}



//Admin qoshish
if ($data == "addadmin" and $adminlist == true) {
    file_put_contents("step/$callcid.txt", "addadmin");
    bot('editmessagetext', [
        'chat_id' => $callcid,
        'message_id' => $callmid,
        'text' => "<b>❗️Botga Yangi Admin Qo'shish Uchun Foydalanuvchi ID raqamini kiriting:</b>",
        'parse_mode' => 'html',
        'message_id' => $callmid,
        'reply_markup' => json_encode([
            'inline_keyboard' => [
                [['text' => "🔙Orqaga", 'callback_data' => "ort"]]
            ]
        ])
    ]);
}


if (!isset($update->callback_query) and $step == "addadmin" and $text != "/start") {
    $stat = file_get_contents("https://api.telegram.org/bot$token/getChatMember?chat_id=$text&user_id=" . $text);
    $statjson = json_decode($stat, true);
    $status = $statjson['ok'];
    $a = json_decode(file_get_contents("https://api.telegram.org/bot$token/getchat?chat_id=$text"));
    $titlee = $a->result->first_name;
    $result = mysqli_query($connect, "SELECT * FROM admins WHERE user_id = '$text'");
    $rew = mysqli_fetch_assoc($result);
    if ($rew and $status == true) {
        bot('sendMessage', [
            'chat_id' => $chat_id,
            'text' => "
<b>⛔️Ushbu Foydalanuvchi Bizning Botimizdagi Adminlar Ro'yxatida Mavjud!</b>",
            'disable_web_page_preview' => true,
            'parse_mode' => 'html',
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [['text' => "🔙Orqaga", 'callback_data' => "ort"]]
                ]
            ])
        ]);
        unlink("step/$chat_id.txt");
    } elseif ($status == false) {
        bot('sendMessage', [
            'chat_id' => $chat_id,
            'text' => "
<b>⛔️Ushbu Foydalanuvchi Bizning Botimiz Bazasida Mavjud Emas! Foydalanuvchi Botga /start Bosgan bo'lishi Kerak</b>",
            'disable_web_page_preview' => true,
            'parse_mode' => 'html',
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [['text' => "🔙Orqaga", 'callback_data' => "ort"]]
                ]
            ])
        ]);
    } else {
        mysqli_query($connect, "INSERT INTO admins (user_id) VALUES ('$text')");
        $a = json_decode(file_get_contents("https://api.telegram.org/bot$token/getchat?chat_id=$text"));
        $titlee = $a->result->first_name;
        bot('sendMessage', [
            'chat_id' => $chat_id,
            'text' => "<b>$titlee - Muvaffaqiyatli Tarzda Botga Admin Bo'ldi va Xabardor Qilindi✅</b>",
            'disable_web_page_preview' => true,
            'parse_mode' => 'html',
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [['text' => "🔙Orqaga", 'callback_data' => "ort"]]
                ]
            ])
        ]);
        bot('sendMessage', [
            'chat_id' => $text,
            'text' => "<b>Assalomu Aleykum! Hurmatloi Foydalanuvchi Siz Botda Muvaffaqiyatli Admin Bo'ldingiz</b>✅",
            'parse_mode' => 'html',
            'disable_web_page_preview' => true,
        ]);
    }
}


if ($data == "admins" and $adminlist == true) {
    $result = mysqli_query($connect, "SELECT * FROM admins");
    $row = mysqli_num_rows($result);
    if ($row == false) {
        bot('answercallbackquery', [
            'callback_query_id' => $update->callback_query->id,
            'text' => "📛Botda Adminlar Mavjud Emas!",
            'show_alert' => true,
        ]);
    } else {
        $result = mysqli_query($connect, "SELECT * FROM admins");
        $row = mysqli_num_rows($result);
        if ($row > 0) {
            while ($rows = mysqli_fetch_assoc($result)) {
                $adm .= $rows['user_id'] . "\n";
            }

            $ids = explode("\n", $adm);
            $soni = substr_count($adm, "\n");

            $keyboards = [];
            $k = [];
            for ($for = 0; $for <= $row - 1; $for++) {
                $kanalurls = explode("\n", $kanalurl)[$for];
                $k = $for + 1;

                $a = json_decode(file_get_contents("https://api.telegram.org/bot$token/getchat?chat_id=$ids[$for]"));
                $titlee = $a->result->first_name;
                $url = $a->result->username;
                if($url == false){
                    $url = "telegram";
                }
                $keyboards[] = ["text" => "$titlee", "url" => "https://t.me/$url"];
                $keyboard2 = array_chunk($keyboards, 1);
                $keyboard2[] = [['text' => "🔙Orqaga", 'callback_data' => "ort"]];
                $keyboard = json_encode([
                    'inline_keyboard' => $keyboard2,
                ]);
            }
            bot('editmessagetext', [
                'chat_id' => $callcid,
                'message_id' => $callmid,
                'text' => "<b>🤖Botdagi adminlar ro'yxati! | Profilini ochish uchun foydalanuvchi nomi ustiga bosing!</b>",
                'parse_mode' => 'html',
                'reply_markup' => $keyboard,
            ]);
        }
    }
}

if ($data == "deladmin" and $adminlist == true) {
    $result = mysqli_query($connect, "SELECT * FROM admins");
    $row = mysqli_num_rows($result);
    if ($row == false) {
        bot('answercallbackquery', [
            'callback_query_id' => $update->callback_query->id,
            'text' => "📛Botda Adminlar Mavjud Emas!",
            'show_alert' => true,
        ]);
    } else {
        $result = mysqli_query($connect, "SELECT * FROM admins");
        $row = mysqli_num_rows($result);
        if ($row > 0) {
            while ($rows = mysqli_fetch_assoc($result)) {
                $adm .= $rows['user_id'] . "\n";
            }

            $ids = explode("\n", $adm);
            $soni = substr_count($adm, "\n");

            $keyboards = [];
            $k = [];
            for ($for = 0; $for <= $row - 1; $for++) {
                $a = json_decode(file_get_contents("https://api.telegram.org/bot$token/getchat?chat_id=$ids[$for]"));
                $titlee = $a->result->first_name;
                $keyboards[] = ["text" => "$titlee", "callback_data" => "dadm|$ids[$for]"];
                $keyboard2 = array_chunk($keyboards, 1);
                $keyboard2[] = [["text" => "⛔️Bekor Qilish", "callback_data" => "ort"]];
                $keyboard = json_encode([
                    'inline_keyboard' => $keyboard2,
                ]);
            }
            bot('editmessagetext', [
                'chat_id' => $callcid,
                'message_id' => $callmid,
                'text' => "<b>👀Adminlikdan Olish Uchun Foydalanuvchi Nomi Ustiga Bosing!</b>",
                'parse_mode' => 'html',
                'reply_markup' => $keyboard,
            ]);
        }
    }
}
if (mb_stripos($data, "dadm|") !== false and $adminlist == true) {
    $fid = explode("|", $data)[1];
    if ($fid == $admin) {
        bot('answercallbackquery', [
            'callback_query_id' => $update->callback_query->id,
            'text' => "📛Bu Buyruqni Amalga oshirib bo'lmadi😁",
            'show_alert' => true,
        ]);
    } else {
        $a = json_decode(file_get_contents("https://api.telegram.org/bot$token/getchat?chat_id=$fid"));
        $name = $a->result->first_name;
        $user = $a->result->username;
        mysqli_query($connect, "DELETE FROM admins WHERE user_id='$fid'");
        bot('sendMessage', [
            'chat_id' => $callcid,
            'text' => "❗️<b>$name </b> - Muvaffaqiyatli Tarzda Adminlikdan olindi va Xabardor qilindi✅",
            'parse_mode' => 'html',
            'disable_web_page_preview' => true,
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [['text' => "🔙Ortga", "callback_data" => "ort"]],
                ]
            ]),
        ]);
        bot('sendMessage', [
            'chat_id' => $fid,
            'text' => "<b>Assalomu Aleykum! Hurmatli Foydalanuvchi! Siz Botda Adminlikdan Olindingiz</b>✅",
            'parse_mode' => 'html',
            'disable_web_page_preview' => true,
        ]);
    }
}


//ban + - Qilish Bo'limi
if ($data == "ban+" and $adminlist == true) {
    file_put_contents("step/$callcid.txt", "ban+");
    bot('deletemessage', [
        'chat_id' => $callcid,
        'message_id' => $callmid,
    ]);
    bot('sendmessage', [
        'chat_id' => $callcid,
        'text' => "<b>❗️Foydalanuvchini Ban Qilish Uchun ID raqamini kiriting:</b>",
        'parse_mode' => 'html',
        'reply_markup' => json_encode([
            'inline_keyboard' => [
                [['text' => "⛔️Bekor Qilish", 'callback_data' => "ort"]]
            ]
        ])
    ]);
}


if ($step == "ban+" and $adminlist == true) {
    if (is_numeric($text)) {
        $a = json_decode(file_get_contents("https://api.telegram.org/bot$token/getChatMember?chat_id=$text&user_id=" . $text), true);
        $true = $a['result'];
        $result = mysqli_query($connect, "SELECT ban FROM users WHERE user_id = '$text'");
        $rew = mysqli_fetch_array($result)['ban'];
        if ($true == true) {
            if ($rew == "1") {
                bot('deletemessage', [
                    'chat_id' => $chat_id,
                    'message_id' => $mid - 1,
                ]);
                bot('sendMessage', [
                    'chat_id' => $chat_id,
                    'text' => "🤚Toxtang! bu *Foydalanuvchi* oldin *Ban* qilingan ekan Boshqa *foydalanuvchi* qoshishingiz mumkin ",
                    'parse_mode' => 'markdown',
                    'reply_markup' => json_encode([
                        'inline_keyboard' => [
                            [['text' => "⛔️Bekor Qilish", 'callback_data' => "ort"]]
                        ]
                    ])
                ]);
                exit();
            } else {
                mysqli_query($connect, "UPDATE users SET ban='1' WHERE user_id='$text'");
                $a = json_decode(file_get_contents("https://api.telegram.org/bot$token/getchat?chat_id=$text"));
                $firstname = $a->result->first_name;
                bot('deletemessage', [
                    'chat_id' => $chat_id,
                    'message_id' => $mid - 1,
                ]);
                bot('sendMessage', [
                    'chat_id' => $chat_id,
                    'text' => "👌*Juda Soz* $firstname - Muvaffaqiyatli tarzda *Ban* bo'ldi va *xabardor* qilindi✅",
                    'disable_web_page_preview' => true,
                    'parse_mode' => 'markdown',
                    'reply_markup' => json_encode([
                        'inline_keyboard' => [
                            [['text' => "⛔️Bekor Qilish", "callback_data" => "ort"]],
                        ]
                    ]),
                ]);
                bot('sendMessage', [
                    'chat_id' => $text,
                    'text' => "Salom Hurmatli $firstname Siz Botimizda *Ban* bo'ldingiz endi botdan *foydalana* olmaysiz!",
                    'parse_mode' => 'markdown',
                    'disable_web_page_preview' => true,
                ]);
                exit();
            }
        } else {
            bot('deletemessage', [
                'chat_id' => $chat_id,
                'message_id' => $mid - 1,
            ]);
            bot('sendMessage', [
                'chat_id' => $chat_id,
                'text' => "⛔️Ushbu *foydalanuvchi* botga *start* bosgan va botni *block* qilmagan bo'lishi kerak!",
                'parse_mode' => 'markdown',
                'reply_markup' => json_encode([
                    'inline_keyboard' => [
                        [['text' => "⛔️Bekor Qilish", 'callback_data' => "ort"]]
                    ]
                ])
            ]);
            exit();
        }
    } else {
        bot('deletemessage', [
            'chat_id' => $chat_id,
            'message_id' => $mid - 1,
        ]);
        bot('sendMessage', [
            'chat_id' => $chat_id,
            'text' => "⛔️Foydalanuvchining *ID raqami* faqat *raqamlardan* iborat bo'lsin!",
            'disable_web_page_preview' => true,
            'parse_mode' => 'markdown',
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [['text' => "⛔️Bekor Qilish", 'callback_data' => "ort"]]
                ]
            ])
        ]);
        exit();
    }
}



if ($data == "ban-" and $adminlist == true) {
    $result = mysqli_query($connect, "SELECT ban  FROM users WHERE ban='1' ");
    if (mysqli_num_rows($result) == 0) {
        bot('answercallbackquery', [
            'callback_query_id' => $update->callback_query->id,
            'text' => "📛Botda Banlanganlar Mavjud Emas!",
            'show_alert' => true,
        ]);
        exit();
    }
    $result1 = mysqli_query($connect, "SELECT user_id  FROM users WHERE ban='1'");
    while ($rows = mysqli_fetch_assoc($result1)) {
        $id = $rows['user_id'];
        $getchat = json_decode(file_get_contents("https://api.telegram.org/bot$token/getchat?chat_id=$id"));
        $name = $getchat->result->first_name;
        $keyboards[] = ["text" => "$name", "callback_data" => "ban-|$id"];
    }
    $keyboard = array_chunk($keyboards, 1);
    $keyboard[] = [['text' => "⛔️Bekor Qilish", 'callback_data' => "ort"]];
    bot('deletemessage', [
        'chat_id' => $callcid,
        'message_id' => $callmid,
    ]);
    bot('sendmessage', [
        'chat_id' => $callcid,
        'text' => "👀Foydalanuvchini *Bandan* olish uchun *Profili* ustiga bosing",
        'parse_mode' => 'markdown',
        'reply_markup' => json_encode([
            'inline_keyboard' => $keyboard,
        ])
    ]);
    exit();
}


if (mb_stripos($data, "ban-|") !== false and $adminlist == true) {
    $fid = explode("|", $data)[1];
    $a = json_decode(file_get_contents("https://api.telegram.org/bot$token/getchat?chat_id=$fid"));
    $b = json_decode(file_get_contents("https://api.telegram.org/bot$token/getchat?chat_id=$chat_id"));
    $name = $a->result->first_name;
    $adname = $b->result->first_name;
    $adnamee = $b->result->last_name;
    mysqli_query($connect, "UPDATE users SET ban='0' WHERE user_id='$fid'");
    bot('deletemessage', [
        'chat_id' => $callcid,
        'message_id' => $callmid,
    ]);
    bot('sendmessage', [
        'chat_id' => $callcid,
        'text' => "👌*Juda Soz* $name  - Muvaffaqiyatli tarzda *Bandan* olindi, va *Xabardor* qilindi✅",
        'parse_mode' => 'markdown',
        'reply_markup' => json_encode([
            'inline_keyboard' => [
                [['text' => "⛔️Bekor Qilish", "callback_data" => "ort"]],
            ]
        ]),
    ]);
    bot('sendMessage', [
        'chat_id' => $fid,
        'text' => "Salom Hurmatli $name Siz Botimizda *Bandan* olindingiz Botdan bemalol *foyalanishingiz* mumkin! \nSizni *$adname $adnamee* Bandan oldi 😎",
        'parse_mode' => 'markdown',
    ]);
    exit();
}


//Statistika Bo'limi


if ($data == "stat1" and $adminlist == true) {
    $users = number_format(mysqli_fetch_array(mysqli_query($connect, "SELECT COUNT(user_id) FROM users "))[0]);
    $uz= number_format(mysqli_fetch_array(mysqli_query($connect, "SELECT COUNT(user_id) FROM users WHERE language='0'"))[0]);

    $ru= number_format(mysqli_fetch_array(mysqli_query($connect, "SELECT COUNT(user_id) FROM users WHERE language='1'"))[0]);

    $en= number_format(mysqli_fetch_array(mysqli_query($connect, "SELECT COUNT(user_id) FROM users WHERE language='2'"))[0]);

    $activ = number_format(mysqli_fetch_array(mysqli_query($connect, "SELECT COUNT(`status`) FROM users WHERE `status`='0'"))[0]);

    $block = number_format(mysqli_fetch_array(mysqli_query($connect, "SELECT COUNT(`status`) FROM users WHERE `status`='1'"))[0]);

    $bugun = number_format(mysqli_fetch_array(mysqli_query($connect, "SELECT COUNT(sana) FROM users WHERE `sana`='$sana'"))[0]);

    $ban = number_format( mysqli_fetch_array(mysqli_query($connect, "SELECT COUNT(ban) FROM users WHERE ban='1'"))[0]);

 $gro = number_format(mysqli_fetch_array(mysqli_query($connect, "SELECT COUNT(chat_id) FROM `group`"))[0]);

    $admins = mysqli_fetch_array(mysqli_query($connect, "SELECT COUNT(user_id) FROM admins"))[0];

    $kanallar = number_format(mysqli_fetch_array(mysqli_query($connect, "SELECT COUNT(chat_id) FROM kanal"))[0]);

$count=number_format(file_get_contents("video.txt"));

    bot('editmessagetext', [
        'chat_id' => $callcid,
        'message_id' => $callmid,
        'text' => "Bot statistics
👤 Users: *$activ* / -*$block* (+*$bugun*)
🇺🇿 *$uz* 🇷🇺 *$ru* 🇬🇧 *$en*

♻️ All: *$users*

🗣 Groups: *$gro*

📨 Requests: *$count*

🚫 Blocked: *$ban*

👨‍💻 Admins: *$admins*
📡 Connected channels: *$kanallar*",
        'parse_mode' => 'markdown',
        'reply_markup' => json_encode([
            'inline_keyboard' => [
[['text' => "♻️Yangilash", 'callback_data' => "stat1"]],
                [['text' => "🔙Orqaga", 'callback_data' => "ort"]]
            ]
        ])
    ]);
}





if ($data == "xabarinfo" and $adminlist == true) {
    bot('editmessagetext', [
        'chat_id' => $callcid,
        'message_id' => $callmid,
        'text' => "<b>🔆Marhamat Menyulardan Birini Tanlang!😉</b>",
        'parse_mode' => 'html',
        'reply_markup' => $xabarinfo,
    ]);
}

if ($data == "tugatish" and $adminlist == true) {
    $qb = mysqli_query($connect, "SELECT * FROM sendusers");
    $row = mysqli_fetch_assoc($qb);
    $status = $row["status"];
    if ($status == "passive") {
        bot('answercallbackquery', [
            'callback_query_id' => $update->callback_query->id,
            'text' => "📛Xabar Yuborish Holati Majud Emas! ",
            'show_alert' => true,
        ]);
    } else {
        bot('editmessagetext', [
            'chat_id' => $callcid,
            'message_id' => $callmid,
            'text' => "<b>
😳Reklamani Haqiqatdanham To'xtatmoqchimisiz?
😕Bu Amalni Ortga Qaytarib Bo'lmaydi!
😁Hamasini Yaxshilab O'ylab Chiqing Va Tanlang</b>",
            'parse_mode' => 'html',
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [['text' => "Ha✅", 'callback_data' => "hada"], ['text' => "Yo'q⛔️", 'callback_data' => "yoq"]],
                ]
            ])
        ]);
    }
}


if ($data == "hada" and $adminlist == true) {
    mysqli_query($connect, "UPDATE `sendusers` SET `status`='passive'");
    bot('editmessagetext', [
        'chat_id' => $callcid,
        'message_id' => $callmid,
        'text' => "<b>👋Reklama Muvaffaqiyatli To'xtatildi! Endi Boshqa Reklama Jonatishingiz Mumkin!</b>",
        'parse_mode' => 'html',
        'reply_markup' => json_encode([
            'inline_keyboard' => [
                [['text' => "🔙Orqaga", 'callback_data' => "ort"]]
            ]
        ])
    ]);
}

if ($data == "yoq" and $adminlist == true) {
    bot('editmessagetext', [
        'chat_id' => $callcid,
        'message_id' => $callmid,
        'text' => "<b>👋Reklamani To'xtaish  Muvaffaqiyatli Bekor Qilindi!✅</b>",
        'parse_mode' => 'html',
        'reply_markup' => json_encode([
            'inline_keyboard' => [
                [['text' => "🔙Orqaga", 'callback_data' => "ort"]]
            ]
        ])
    ]);
}


if ($data == "holat" and $adminlist == true) {
    $qb = mysqli_query($connect, "SELECT * FROM sendusers");
    $row = mysqli_fetch_assoc($qb);
    $jv = $row["boshlash_vaqt"];
    $limit = $row["soni"];
    $status = $row["status"];
    $send = number_format($row["send"]);
    $xturi = $row["holat"];
    $nosend = number_format($row["nosend"]);
    if ($status == "passive") {
        bot('answercallbackquery', [
            'callback_query_id' => $update->callback_query->id,
            'text' => "📛Xabar Yuborish Holati Majud Emas!",
            'show_alert' => true,
        ]);
    } else {
        bot('editmessagetext', [
            'chat_id' => $callcid,
            'message_id' => $callmid,
            'text' => "<b>
┌💡Reklama Holati✅
├🕔Boshlangan Vaqt: $jv 
├⭐️Status: $status  
├✳️Xabarni Yuborildi: $send
├⛔️Xabar Yuborilmadi: $nosend
└♨️Xabar Yuborish turi: $xturi

- Ushbu Ma'lumot soat $soat Hisobiga Ko'ra Taqdim Etildi.</b>",
            'parse_mode' => 'html',
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [['text' => "♻️Yangilash", 'callback_data' => "update"]],
                    [['text' => "🔙Orqaga", 'callback_data' => "ort"]]
                ]
            ])
        ]);
    }
}


if ($data == "update" and $adminlist == true) {
    $qb = mysqli_query($connect, "SELECT * FROM sendusers");
    $row = mysqli_fetch_assoc($qb);
    $jv = $row["boshlash_vaqt"];
    $limit = $row["soni"];
    $status = $row["status"];
    $send = number_format($row["send"]);
    $xturi = $row["holat"];
    $nosend = number_format($row["nosend"]);
    if ($status == "passive") {
        bot('answercallbackquery', [
            'callback_query_id' => $update->callback_query->id,
            'text' => "📛Xabar Yuborish Holati Majud Emas!",
            'show_alert' => true,
        ]);
    } else {
        bot('editmessagetext', [
            'chat_id' => $callcid,
            'message_id' => $callmid,
            'text' => "<b>
┌💡Reklama Holati✅
├🕔Boshlangan Vaqt: $jv 
├⭐️Status: $status  
├✳️Xabarni Yuborildi: $send
├⛔️Xabar Yuborilmadi: $nosend
└♨️Xabar Yuborish turi: $xturi

- #Yangilandi Ushbu Ma'lumot soat $soat Hisobiga Ko'ra Taqdim Etildi.</b>",
            'parse_mode' => 'html',
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [['text' => "♻️Yangilash", 'callback_data' => "update"]],
                    [['text' => "🔙Orqaga", 'callback_data' => "ort"]]
                ]
            ])
        ]);
    }
}