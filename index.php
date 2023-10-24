<?php
ini_set('display_errors', 1);
define('API_KEY', '5245536788:AAFjQ8NQUEa-s-KZDHeIbH8BqYHp1NcsVqo');
$admin = "818250253";
$bot = "ttsaxranitbot";
$sana = date('d.m.Y');
include("sql.php");


function bot($method, $datas = [])
{
    $url = "https://api.telegram.org/bot" . API_KEY . "/$method";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $datas);
    $res = curl_exec($ch);
    if (curl_error($ch)) {
        var_dump(curl_error($ch));
    } else {
        return json_decode($res);
    }
}


$update = json_decode(file_get_contents("php://input"));
if (isset($update->message)) {
    $message = $update->message;
    $chat_id = $message->chat->id;
    $mid = $message->message_id;
    $text = $message->text;
    $cty = $update->message->chat->type;
    $uid = $message->from->id;
    $user_id = $message->from->id;
    $ismi = $update->message->from->first_name;
    $ismi2 = $update->message->from->last_name;
    $username = $update->message->from->username;
    $name = "<a href='tg://user?id=$uid'> $ismi $ismi2 </a>";
}

if (isset($update->callback_query)) {
    $data = $update->callback_query->data;
    $callcid = $update->callback_query->message->chat->id;
    $chat_id = $update->callback_query->message->chat->id;
    $callmid = $update->callback_query->message->message_id;
    $from_id = $update->callback_query->from->id;
}


if (isset($update->my_chat_member)) {
    $newchatmember = $update->my_chat_member->new_chat_member;
    $newchatid = $update->my_chat_member->from->id;
    $userstatus = $newchatmember->status;
    $ty = $update->my_chat_member->chat->type;
    $cs = $update->my_chat_member->chat->id;
    $myid = $update->my_chat_member->chat->id;
}

if (isset($update->my_chat_member->new_chat_member)) {
    $block = $update->my_chat_member->new_chat_member;
    $status = $update->my_chat_member->new_chat_member->status;
    $cty = $update->my_chat_member->chat->type;
    $user_id = $update->my_chat_member->from->id;
    $chat_id = $update->my_chat_member->chat->id;
    $block_id = $update->my_chat_member->new_chat_member->user->id;
}

include("panel.php");

if (isset($text) and ($cty == "supergroup") or ($cty == "group")) {
    $res = mysqli_query($connect, "SELECT COUNT(chat_id) FROM `group` WHERE chat_id='$chat_id'");
    $a = mysqli_fetch_array($res)[0];
    if ($a == 0) {
        mysqli_query($connect, "INSERT INTO `group` (chat_id) VALUES ('$chat_id')");
    }
}

//Statistika Bo'limi
if (isset($text)  and $text == "/start") {
    if ($cty == "private") {
        if (mysqli_fetch_array(mysqli_query($connect, "SELECT COUNT(user_id) FROM users WHERE user_id='$uid'"))[0] == 0) {
            mysqli_query($connect, "INSERT INTO users (`user_id`,`status`,`ban`,`sana`,`language`) VALUES ('$uid','0','0','$sana','0')");
        } elseif (mysqli_fetch_array(mysqli_query($connect, "SELECT `status` FROM users WHERE user_id='$uid'"))['status'] == 1) {
            mysqli_query($connect, "UPDATE `users` SET `status` ='0' WHERE `user_id`='$uid' ");
        }
    }
}




if ($newchatmember and $ty == "private") {
    if ($userstatus == "kicked") {
        if (mysqli_fetch_assoc(mysqli_query($connect, "SELECT `status` FROM users WHERE user_id='$newchatid'"))["status"] != "1") {
            mysqli_query($connect, "UPDATE `users` SET `status` ='1', `language`='3' WHERE `user_id`='$newchatid' ");
        }
    }
}

//Block qilgan guruhlarni tekshirish
if (isset($block) and $cty == "supergroup" or $cty == "group") {
    if ($status == "left") {
    }
}

$leftchat = $update->message->left_chat_member;
if (isset($leftchat)) {
    mysqli_query($connect, "DELETE FROM `group` WHERE `chat_id`='$chat_id' ");
}

$result = mysqli_query($connect, "SELECT * FROM users WHERE user_id = '$chat_id'");
$row = mysqli_fetch_assoc($result);
$lang = $row["language"];

$info = str_replace("0", "Iltimos kuting...", $lang);
$info = str_replace("1", "Пожалуйста подождите...", $info);
$info = str_replace("2", "Wait, please ...", $info);
$info2 = str_replace("0", "😔 Afsuski, ushbu havoladan media faylni yuklab ololmadim:(", $lang);
$info2 = str_replace("1", "😔 К сожалению, я не смог скачать медиафайл по этой ссылке:(", $info2);
$info2 = str_replace("2", "😔 Unfortunately, I could not download the media file from this link:(", $info2);

$down = str_replace("0", "@ttsaxranitbot orqali yuklab olindi 📥 ", $lang);
$down = str_replace("1", "Скачано через @ttsaxranitbot 📥", $down);
$down = str_replace("2", "Downloaded by @ttsaxranitbot 📥", $down);

$azo = str_replace("0", "Botdan to'liq foydalanish uchun quyidagi Kanallarga azo bo'ling va ✅Tekshirishni bosing", $lang);
$azo = str_replace("1", "Чтобы в полной мере использовать бота, подпишитесь на следующие каналы и нажмите ✅Проверить", $azo);
$azo = str_replace("2", "To get full use of the bot, subscribe to the following Channels and click ✅Check", $azo);

$azokey = str_replace("0", "Obuna boʻlish✅", $lang);
$azokey = str_replace("1", "Подписаться ✅", $azokey);
$azokey = str_replace("2", "Subscribe ✅", $azokey);

$tasdiqkey = str_replace("0", "Tekshirish✅", $lang);
$tasdiqkey = str_replace("1", "Подписаться ✅", $tasdiqkey);
$tasdiqkey = str_replace("2", "Confirmation ✅", $tasdiqkey);

$start = str_replace("0", "Instagram, TikTok, Youtube, LIKEE, Facebook ijtimoiy tarmoqlaridan Video yoki Rasm yuklash uchun 🔗Havola yuboring!
🇺🇿 Tilni o'zgartirish: /lang", $lang);
$start = str_replace("1", "🔗Отправьте ссылку для загрузки видео или картинки из социальных сетей Instagram, TikTok, Youtube, LIKEE, Facebook!
🇷🇺 Сменить язык: /lang", $start);
$start = str_replace("2", "🔗Send a link to upload a video or picture from Instagram, TikTok, Youtube, LIKEE, Facebook social networks!
🇬🇧 Change language: /lang", $start);

$grp = str_replace("0", "➕GURUHGA QOSHISH", $lang);
$grp = str_replace("1", "➕Добавить в  группу", $grp);
$grp = str_replace("2", "➕Add to Group", $grp);


$til = json_encode([
    'inline_keyboard' => [
        [['text' => "Русский 🇷🇺", 'callback_data' => "lang_1"], ['text' => "O'zbekcha 🇺🇿", 'callback_data' => "lang_0"]],
        [['text' => "English 🇺🇸", 'callback_data' => "lang_2"]],
    ]
]);

$ad = json_encode([
    'inline_keyboard' => [
        [["text" => " ➕ GURUHGA QUSHISH", "url" => "https://t.me/ttsaxranitbot?startgroup=on&admin=change_info+delete_messages+restrict_members+pin_messages+manage_video_chats+promote_members+invite_users"]],
    ]
]);

if ($update->message) {
    if ($lang == "3") {
        bot('sendmessage', [
            'chat_id' => $chat_id,
            'text' => "<b>🇺🇿 Tilni tanlang
🇷🇺 Выберите язык
🇺🇸 Choose language</b>",
            'parse_mode' => "html",
            'reply_markup' => $til,
        ]);
        exit();
    }
}

if (isset($text) and $cty == "private" and $chat_id != "1055802801") {
    $r = mysqli_query($connect, "SELECT COUNT(chat_id) FROM kanal");
    $row = mysqli_fetch_array($r)[0];
    if ($row > 0) {
        $result = mysqli_query($connect, "SELECT * FROM kanal");
        while ($rows = mysqli_fetch_assoc($result)) {
            $kanal = $rows['chat_id'];
            $url = $rows['url'];
            $a = json_decode(file_get_contents("https://api.telegram.org/bot" . API_KEY . "/getchatmember?chat_id=$kanal&user_id=$chat_id"));
            $get = $a->result->status;
            if ($get == "member" or $get == "administrator" or $get == "creator") {
                $tas = "✅";
                $keyboards[] = ["text" => "$azokey", "url" => "" . $url];
            } else {
                $tas = "❌";
                $keyboards[] = ["text" => "$azokey", "url" => "" . $url];
                $keyboard2 = array_chunk($keyboards, 1);
                $keyboard2[] = [["text" => "$tasdiqkey", "callback_data" => "result"]];
                $keyboard = json_encode([
                    'inline_keyboard' => $keyboard2,
                ]);
            }
        }
        if ($keyboard == true) {
            bot('sendMessage', [
                'chat_id' => $chat_id,
                'text' => $azo,
                'parse_mode' => 'markdown',
                'reply_to_message_id' => $mid,
                'reply_markup' => $keyboard,
            ]);
            exit();
        }
    }
}


if ($data == "result") {
    $r = mysqli_query($connect, "SELECT COUNT(chat_id) FROM kanal");
    $row = mysqli_fetch_array($r)[0];
    if ($row > 0) {
        $result = mysqli_query($connect, "SELECT * FROM kanal");
        while ($rows = mysqli_fetch_assoc($result)) {
            $kanal = $rows['chat_id'];
            $url = $rows['url'];
            $a = json_decode(file_get_contents("https://api.telegram.org/bot" . API_KEY . "/getchatmember?chat_id=$kanal&user_id=$chat_id"));
            $get = $a->result->status;
            $ab = json_decode(file_get_contents("https://api.telegram.org/bot" . API_KEY . "/getchat?chat_id=$kanal"));
            $titlee = $ab->result->title;
            if ($get == "member" or $get == "administrator" or $get == "creator") {
                $bor = true;
                $tas = "✅";
                $keyboards[] = ["text" => "$azokey", "url" => "" . $url];
            } else {
                $tas = "❌";
                $keyboards[] = ["text" => "$azokey", "url" => "" . $url];
                $keyboard2 = array_chunk($keyboards, 1);
                $keyboard2[] = [["text" => "$tasdiqkey", "callback_data" => "result"]];
                $keyboard = json_encode([
                    'inline_keyboard' => $keyboard2,
                ]);
            }
        }
        if ($keyboard == true) {
            bot('sendMessage', [
                'chat_id' => $callcid,
                'text' => $azo,
                'parse_mode' => 'markdown',
                'reply_markup' => $keyboard,
            ]);
            bot('deletemessage', [
                'chat_id' => $callcid,
                'message_id' => $callmid,
            ]);
            exit();
        } elseif ($bor) {
            bot('sendMessage', [
                'chat_id' => $callcid,
                'parse_mode' => 'html',
                'text' => $start,
                'reply_markup' => json_encode([
                    'inline_keyboard' => [
                        [['text' => "$grp", 'url' => "https://t.me/ttsaxranitbot?startgroup=new"]]
                    ]
                ])
            ]);
            bot('deletemessage', [
                'chat_id' => $callcid,
                'message_id' => $callmid,
            ]);
            exit();
        }
    }
}


if (mysqli_fetch_array(mysqli_query($connect, "SELECT ban FROM users WHERE user_id = '$chat_id'"))['ban'] == "1") {
    bot('sendMessage', [
        'chat_id' => $chat_id,
        'text' => "☹️Вы получили 🔴Бан от бота.",
        'parse_mode' => 'html',
    ]);
    return false;
}


if ($text == "/start" and $cty == "private") {
    if ($lang == "3") {
        bot('sendmessage', [
            'chat_id' => $chat_id,
            'text' => "<b>🇺🇿 Tilni tanlang
🇷🇺 Выберите язык
🇺🇸 Choose language</b>",
            'parse_mode' => "html",
            'reply_markup' => $til,
        ]);
        exit();
    } elseif ($lang == "0") {
        bot('sendmessage', [
            'chat_id' => $chat_id,
            'text' => "<b>Instagram, TikTok, Youtube, LIKEE, Facebook ijtimoiy tarmoqlaridan Video yoki Rasm yuklash uchun 🔗Havola yuboring!
🇺🇿 Tilni o'zgartirish: /lang</b>",
            'parse_mode' => "html",
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [['text' => "$grp", 'url' => "https://t.me/ttsaxranitbot?startgroup=new"]]
                ]
            ])
        ]);
        exit();
    } elseif ($lang == "1") {
        bot('sendmessage', [
            'chat_id' => $chat_id,
            'text' => "<b>🔗Отправьте ссылку для загрузки видео или картинки из социальных сетей Instagram, TikTok, Youtube, LIKEE, Facebook!
🇷🇺 Сменить язык: /lang</b>",
            'parse_mode' => "html",
            'disable_web_page_preview' => true,
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [['text' => "$grp", 'url' => "https://t.me/ttsaxranitbot?startgroup=new"]]
                ]
            ])
        ]);
        exit();
    } elseif ($lang == "2") {
        bot('sendmessage', [
            'chat_id' => $chat_id,
            'text' => "<b>🔗Send a link to upload a video or picture from Instagram, TikTok, Youtube, LIKEE, Facebook social networks!
🇬🇧 Change language: /lang</b>",
            'parse_mode' => "html",
            'disable_web_page_preview' => true,
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [['text' => "$grp", 'url' => "https://t.me/ttsaxranitbot?startgroup=new"]]
                ]
            ])
        ]);
        exit();
    }
}




if (($text == "/start@ttsaxranitbot" or $text == "/start") and ($cty == "group" or $cty == "supergroup")) {
    bot('sendMessage', [
        'chat_id' => $chat_id,
        'text' => "<b>Instagram, TikTok, Youtube, LIKEE, Facebook ijtimoiy tarmoqlaridan Video yoki Rasm yuklash uchun 🔗Havola yuboring!</b>",
        'parse_mode' => 'html',
        'reply_to_message_id' => $mid,
        'reply_markup' => $ad,
        'disable_web_page_preview' => true,
    ]);
    $res = mysqli_query($connect, "SELECT COUNT(chat_id) FROM `group` WHERE chat_id='$chat_id'");
    $a = mysqli_fetch_array($res)[0];
    if ($a == 0) {
        mysqli_query($connect, "INSERT INTO `group` (chat_id) VALUES ('$chat_id')");
    }
    exit();
}

if (mb_stripos($data, "lang") !== false) {
    $lange = explode("_", $data)[1];
    mysqli_query($connect, "UPDATE users SET `language`='$lange' WHERE user_id='$chat_id'");
    $grp = str_replace("0", "➕GURUHGA QOSHISH", $lange);
    $grp = str_replace("1", "➕Добавить в  группу", $grp);
    $grp = str_replace("2", "➕Add to Group", $grp);
    bot('deleteMessage', [
        'chat_id' => $callcid,
        'message_id' => $callmid,
    ]);
    if ($lange == "0") {
        bot('sendmessage', [
            'chat_id' => $callcid,
            'text' => "<b>Instagram, TikTok, Youtube, LIKEE, Facebook ijtimoiy tarmoqlaridan Video yoki Rasm yuklash uchun 🔗Havola yuboring!
🇺🇿 Tilni o'zgartirish: /lang</b>",
            'parse_mode' => "html",
            'disable_web_page_preview' => true,
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [['text' => "$grp", 'url' => "https://t.me/ttsaxranitbot?startgroup=new"]]
                ]
            ])
        ]);
        exit();
    } elseif ($lange == "1") {
        bot('sendmessage', [
            'chat_id' => $callcid,
            'text' => "<b>🔗Отправьте ссылку для загрузки видео или картинки из социальных сетей Instagram, TikTok, Youtube, LIKEE, Facebook!
🇷🇺 Сменить язык: /lang</b>",
            'parse_mode' => "html",
            'disable_web_page_preview' => true,
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [['text' => "$grp", 'url' => "https://t.me/ttsaxranitbot?startgroup=new"]]
                ]
            ])
        ]);
        exit();
    } elseif ($lange == "2") {
        bot('sendmessage', [
            'chat_id' => $callcid,
            'text' => "<b>🔗Send a link to upload a video or picture from Instagram, TikTok, Youtube, LIKEE, Facebook social networks!
🇬🇧 Change language: /lang</b>",
            'parse_mode' => "html",
            'disable_web_page_preview' => true,
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [['text' => "$grp", 'url' => "https://t.me/ttsaxranitbot?startgroup=new"]]
                ]
            ])
        ]);
        exit();
    }
}

if ($text == "/lang" and $cty == "private") {
    bot('sendmessage', [
        'chat_id' => $chat_id,
        'text' => "<b>🇺🇿 Tilni tanlang
🇷🇺 Выберите язык
🇺🇸 Choose language</b>",
        'parse_mode' => "html",
        'reply_markup' => $til,
    ]);
    exit();
}


if (mb_stripos($text, "tiktok.com/") !== false) {
    if ($cty == "private") {
        $ok = bot('sendmessage', [
            'chat_id' => $chat_id,
            'text' => $info,
            'parse_mode' => "html",
            'disable_web_page_preview' => true,
            'reply_markup' => $remove,
        ])->result->message_id;
        $ab = json_decode(file_get_contents("https://tikwm.com/api?url=$text"), true);
        $video = $ab['data']['play'];
        $nom = $ab['data']['title'];
        if ($ab) {
            file_put_contents("audio/$chat_id.mp4", file_get_contents($video));
            file_put_contents("audio/$chat_id.mp3", file_get_contents($video));
            $video = bot('sendvideo', [
                'chat_id' => $chat_id,
                'video' => new CURLFile("audio/$chat_id.mp4"),
                'caption' => " <b>$down</b>",
                'parse_mode' => "html",
                'disable_web_page_preview' => true,
                'reply_markup' => json_encode([
                    'inline_keyboard' => [
                        [['text' => "$grp", 'url' => "https://t.me/ttsaxranitbot?startgroup=new"]]
                    ]
                ])
            ])->ok;

            $audio = bot('sendAudio', [
                'chat_id' => $chat_id,
                'title' => "Tezkor Video Yuklovchi Bot",
                'performer' => "@ttsaxranitbot",
                'audio' => new CURLFile("audio/$chat_id.mp3"),
                'caption' => " <b>$down</b>",
                'parse_mode' => "html",
                'disable_web_page_preview' => true,
                'reply_markup' => json_encode([
                    'inline_keyboard' => [
                        [['text' => "$grp", 'url' => "https://t.me/ttsaxranitbot?startgroup=new"]]
                    ]
                ])
            ])->ok;
            bot('deleteMessage', [
                'chat_id' => $chat_id, 'message_id' => $ok,
            ]);
            if ($video) {
                $count = file_get_contents("video.txt");
                $count1 = $count + 1;
                file_put_contents("video.txt", $count1);
            }
            unlink("audio/$chat_id.mp3");
            unlink("audio/$chat_id.mp4");
        } else {
            bot('sendmessage', [
                'chat_id' => $chat_id,
                'text' => $info2,
                'parse_mode' => "html",
                'disable_web_page_preview' => true,
                'reply_markup' => $remove,
            ]);
        }
    }
}



if (mb_stripos($text, "you") !== false) {
    if ($cty == "private") {
        $ok = bot('sendmessage', [
            'chat_id' => $chat_id,
            'text' => $info,
            'parse_mode' => "html",
            'disable_web_page_preview' => true,
            'reply_markup' => $remove,
        ])->result->message_id;
        $ab = json_decode(file_get_contents("https://uzkod.ru/api/youtube/sstube1.php?url=$text"), true);
             $video = $ab["data"]["videos"]["mp4"][0]["url"];
       
            file_put_contents("audio/$chat_id.mp4", file_get_contents($video));
        file_put_contents("audio/$chat_id.mp3", file_get_contents($video));
            $video = bot('sendvideo', [
                'chat_id' => $chat_id,
                'video' => new CURLFile("audio/$chat_id.mp4"),
                'caption' => " <b>$down</b>",
                'parse_mode' => "html",
                'disable_web_page_preview' => true,
                'reply_markup' => json_encode([
                    'inline_keyboard' => [
                        [['text' => "$grp", 'url' => "https://t.me/ttsaxranitbot?startgroup=new"]]
                    ]
                ])
            ])->ok;

            $audio = bot('sendAudio', [
                'chat_id' => $chat_id,
                'title' => "Tezkor Video Yuklovchi Bot",
                'performer' => "@ttsaxranitbot",
                'audio' => new CURLFile("audio/$chat_id.mp3"),
                'caption' => " <b>$down</b>",
                'parse_mode' => "html",
                'disable_web_page_preview' => true,
                'reply_markup' => json_encode([
                    'inline_keyboard' => [
                        [['text' => "$grp", 'url' => "https://t.me/ttsaxranitbot?startgroup=new"]]
                    ]
                ])
            ])->ok;
            bot('deleteMessage', [
                'chat_id' => $chat_id, 'message_id' => $ok,
            ]);
            if ($video) {
                $count = file_get_contents("video.txt");
                $count1 = $count + 1;
                file_put_contents("video.txt", $count1);
            }
            unlink("audio/$chat_id.mp3");
            unlink("audio/$chat_id.mp4");
        } else {
            bot('sendmessage', [
                'chat_id' => $chat_id,
                'text' => $info2,
                'parse_mode' => "html",
                'disable_web_page_preview' => true,
                'reply_markup' => $remove,
            ]);
        }
}


if (mb_stripos($text, "like") !== false) {
    if ($cty == "private") {
        $ok = bot('sendmessage', [
            'chat_id' => $chat_id,
            'text' => $info,
            'parse_mode' => "html",
            'disable_web_page_preview' => true,
            'reply_markup' => $remove,
        ])->result->message_id;
        $url = json_decode(file_get_contents("https://u5437.xvest5.ru/ttsavebot/insta/index.php?url=" . $text), true);
        $video = $url["result"]["url"];
        $nom = $url["title"];
        if ($video) {
            file_put_contents("audio/$chat_id.mp4", file_get_contents($video));
            file_put_contents("audio/$chat_id.mp3", file_get_contents($video));
            $video = bot('sendvideo', [
                'chat_id' => $chat_id,
                'video' => new CURLFile("audio/$chat_id.mp4"),
                'caption' => " <b>$down</b>",
                'parse_mode' => "html",
                'disable_web_page_preview' => true,
                'reply_markup' => json_encode([
                    'inline_keyboard' => [
                        [['text' => "$grp", 'url' => "https://t.me/ttsaxranitbot?startgroup=new"]]
                    ]
                ])
            ])->ok;

            $audio = bot('sendAudio', [
                'chat_id' => $chat_id,
                'title' => "Tezkor Video Yuklovchi Bot",
                'performer' => "@ttsaxranitbot",
                'audio' => new CURLFile("audio/$chat_id.mp3"),
                'caption' => " <b>$down</b>",
                'parse_mode' => "html",
                'disable_web_page_preview' => true,
                'reply_markup' => json_encode([
                    'inline_keyboard' => [
                        [['text' => "$grp", 'url' => "https://t.me/ttsaxranitbot?startgroup=new"]]
                    ]
                ])
            ])->ok;
            bot('deleteMessage', [
                'chat_id' => $chat_id, 'message_id' => $ok,
            ]);
            if ($video) {
                $count = file_get_contents("video.txt");
                $count1 = $count + 1;
                file_put_contents("video.txt", $count1);
            }
            unlink("audio/$chat_id.mp3");
            unlink("audio/$chat_id.mp4");
        } else {
            bot('sendmessage', [
                'chat_id' => $chat_id,
                'text' => $info2,
                'parse_mode' => "html",
                'disable_web_page_preview' => true,
                'reply_markup' => $remove,
            ]);
        }
    }
}

if (mb_stripos($text, "instag") !== false) {
    if ($cty == "private") {
        $ok = bot('sendmessage', [
            'chat_id' => $chat_id,
            'text' => $info,
            'parse_mode' => "html",
            'disable_web_page_preview' => true,
            'reply_markup' => $remove,
        ])->result->message_id;
        $url = json_decode(file_get_contents("https://u11357.xvest4.ru/instagram/?url=" . $text), true);
        $video = $url["result"]['formats'][0]["url"];       
 $type= $url["result"]['formats'][0]["video_ext"]; 
 if ($type == "mp4") {
            file_put_contents("audio/$chat_id.mp4", file_get_contents($video));
            file_put_contents("audio/$chat_id.mp3", file_get_contents($video));
            $video = bot('sendvideo', [
                'chat_id' => $chat_id,
                'video' => new CURLFile("audio/$chat_id.mp4"),
                'caption' => " <b>$down</b>",
                'parse_mode' => "html",
                'disable_web_page_preview' => true,
                'reply_markup' => json_encode([
                    'inline_keyboard' => [
                        [['text' => "$grp", 'url' => "https://t.me/ttsaxranitbot?startgroup=new"]]
                    ]
                ])
            ])->ok;

            $audio = bot('sendAudio', [
                'chat_id' => $chat_id,
                'title' => "Tezkor Video Yuklovchi Bot",
                'performer' => "@ttsaxranitbot",
                'audio' => new CURLFile("audio/$chat_id.mp3"),
                'caption' => " <b>$down</b>",
                'parse_mode' => "html",
                'disable_web_page_preview' => true,
                'reply_markup' => json_encode([
                    'inline_keyboard' => [
                        [['text' => "$grp", 'url' => "https://t.me/ttsaxranitbot?startgroup=new"]]
                    ]
                ])
            ])->ok;
            bot('deleteMessage', [
                'chat_id' => $chat_id, 'message_id' => $ok,
            ]);
            if ($video) {
                $count = file_get_contents("video.txt");
                $count1 = $count + 1;
                file_put_contents("video.txt", $count1);
            }
            unlink("audio/$chat_id.mp3");
            unlink("audio/$chat_id.mp4");
        } elseif($type == "photo") {
            file_put_contents("audio/$chat_id.jpg", file_get_contents($video));
            $video = bot('sendphoto', [
                'chat_id' => $chat_id,
                'photo' => new CURLFile("audio/$chat_id.jpg"),
                'caption' => " <b>$down</b>",
                'parse_mode' => "html",
                'disable_web_page_preview' => true,
                'reply_markup' => json_encode([
                    'inline_keyboard' => [
                        [['text' => "$grp", 'url' => "https://t.me/ttsaxranitbot?startgroup=new"]]
                    ]
                ])
            ])->ok;
            unlink("audio/$chat_id.jpg");
        } else {
            bot('sendmessage', [
                'chat_id' => $chat_id,
                'text' => $info2,
                'parse_mode' => "html",
                'disable_web_page_preview' => true,
                'reply_markup' => $remove,
            ]);
        }
    }
}

if (mb_stripos($text, "tiktok.com/") !== false) {
    if ($cty == "group" or $cty == "supergroup") {
        $ok = bot('sendmessage', [
            'chat_id' => $chat_id,
            'text' => "Iltimos kuting...",
            'parse_mode' => "html",
            'disable_web_page_preview' => true,
            'reply_markup' => $remove,
        ])->result->message_id;
        $ab = json_decode(file_get_contents("https://tikwm.com/api?url=$text"), true);
        $video = $ab['data']['play'];
        $nom = $ab['data']['title'];
        if ($ab) {
            file_put_contents("audio/$chat_id.mp4", file_get_contents($video));
            file_put_contents("audio/$chat_id.mp3", file_get_contents($video));
            $video = bot('sendvideo', [
                'chat_id' => $chat_id,
                'video' => new CURLFile("audio/$chat_id.mp4"),
                'caption' => " <b>@ttsaxranitbot orqali yuklab olindi 📥</b>",
                'parse_mode' => "html",
                'disable_web_page_preview' => true,
                'reply_markup' => json_encode([
                    'inline_keyboard' => [
                        [['text' => "➕GURUHGA QOSHISH", 'url' => "https://t.me/ttsaxranitbot?startgroup=new"]]
                    ]
                ])
            ])->ok;

            $audio = bot('sendAudio', [
                'chat_id' => $chat_id,
                'title' => "Tezkor Video Yuklovchi Bot",
                'performer' => "@ttsaxranitbot",
                'audio' => new CURLFile("audio/$chat_id.mp3"),
                'caption' => " <b>@ttsaxranitbot orqali yuklab olindi 📥</b>",
                'parse_mode' => "html",
                'disable_web_page_preview' => true,
                'reply_markup' => json_encode([
                    'inline_keyboard' => [
                        [['text' => "➕GURUHGA QOSHISH", 'url' => "https://t.me/ttsaxranitbot?startgroup=new"]]
                    ]
                ])
            ])->ok;
            bot('deleteMessage', [
                'chat_id' => $chat_id, 'message_id' => $ok,
            ]);
            if ($video) {
                $count = file_get_contents("video.txt");
                $count1 = $count + 1;
                file_put_contents("video.txt", $count1);
            }
            unlink("audio/$chat_id.mp3");
            unlink("audio/$chat_id.mp4");
        } else {
            bot('sendmessage', [
                'chat_id' => $chat_id,
                'text' => $info2,
                'parse_mode' => "html",
                'disable_web_page_preview' => true,
                'reply_markup' => $remove,
            ]);
        }
    }
}



if (mb_stripos($text, "you") !== false) {
    if ($cty == "group" or $cty == "supergroup") {
        $ok = bot('sendmessage', [
            'chat_id' => $chat_id,
            'text' => "Iltimos kuting...",
            'parse_mode' => "html",
            'disable_web_page_preview' => true,
            'reply_markup' => $remove,
        ])->result->message_id;
        $ab = json_decode(file_get_contents("https://uzkod.ru/api/youtube/sstube.php?url=$text"), true);
             $video = $ab["data"]["videos"]["mp4"][0]["url"];
        if ($ab) {
            file_put_contents("audio/$chat_id.mp4", file_get_contents($video));
            file_put_contents("audio/$chat_id.mp3", file_get_contents($video));
            $video = bot('sendvideo', [
                'chat_id' => $chat_id,
                'video' => new CURLFile("audio/$chat_id.mp4"),
                'caption' => " <b>@ttsaxranitbot orqali yuklab olindi 📥</b>",
                'parse_mode' => "html",
                'disable_web_page_preview' => true,
                'reply_markup' => json_encode([
                    'inline_keyboard' => [
                        [['text' => "➕GURUHGA QOSHISH", 'url' => "https://t.me/ttsaxranitbot?startgroup=new"]]
                    ]
                ])
            ])->ok;

            $audio = bot('sendAudio', [
                'chat_id' => $chat_id,
                'title' => "Tezkor Video Yuklovchi Bot",
                'performer' => "@ttsaxranitbot",
                'audio' => new CURLFile("audio/$chat_id.mp3"),
                'caption' => " <b>@ttsaxranitbot orqali yuklab olindi 📥</b>",
                'parse_mode' => "html",
                'disable_web_page_preview' => true,
                'reply_markup' => json_encode([
                    'inline_keyboard' => [
                        [['text' => "➕GURUHGA QOSHISH", 'url' => "https://t.me/ttsaxranitbot?startgroup=new"]]
                    ]
                ])
            ])->ok;
            bot('deleteMessage', [
                'chat_id' => $chat_id, 'message_id' => $ok,
            ]);
            if ($video) {
                $count = file_get_contents("video.txt");
                $count1 = $count + 1;
                file_put_contents("video.txt", $count1);
            }
            unlink("audio/$chat_id.mp3");
            unlink("audio/$chat_id.mp4");
        } else {
            bot('sendmessage', [
                'chat_id' => $chat_id,
                'text' => $info2,
                'parse_mode' => "html",
                'disable_web_page_preview' => true,
                'reply_markup' => $remove,
            ]);
        }
    }
}


if (mb_stripos($text, "like") !== false) {
    if ($cty == "group" or $cty == "supergroup") {
        $ok = bot('sendmessage', [
            'chat_id' => $chat_id,
            'text' => "Iltimos kuting...",
            'parse_mode' => "html",
            'disable_web_page_preview' => true,
            'reply_markup' => $remove,
        ])->result->message_id;
        $url = json_decode(file_get_contents("https://u5437.xvest5.ru/ttsavebot/insta/index.php?url=" . $text), true);
        $video = $url["result"]["url"];
        if ($url) {
            file_put_contents("audio/$chat_id.mp4", file_get_contents($video));
            file_put_contents("audio/$chat_id.mp3", file_get_contents($video));
            $video = bot('sendvideo', [
                'chat_id' => $chat_id,
                'video' => new CURLFile("audio/$chat_id.mp4"),
                'caption' => " <b>$down</b>",
                'parse_mode' => "html",
                'disable_web_page_preview' => true,
                'reply_markup' => json_encode([
                    'inline_keyboard' => [
                        [['text' => "➕GURUHGA QOSHISH", 'url' => "https://t.me/ttsaxranitbot?startgroup=new"]]
                    ]
                ])
            ])->ok;

            $audio = bot('sendAudio', [
                'chat_id' => $chat_id,
                'title' => "Tezkor Video Yuklovchi Bot",
                'performer' => "@ttsaxranitbot",
                'audio' => new CURLFile("audio/$chat_id.mp3"),
                'caption' => " <b>@ttsaxranitbot orqali yuklab olindi 📥</b>",
                'parse_mode' => "html",
                'disable_web_page_preview' => true,
                'reply_markup' => json_encode([
                    'inline_keyboard' => [
                        [['text' => "➕GURUHGA QOSHISH", 'url' => "https://t.me/ttsaxranitbot?startgroup=new"]]
                    ]
                ])
            ])->ok;
            bot('deleteMessage', [
                'chat_id' => $chat_id, 'message_id' => $ok,
            ]);
            if ($video) {
                $count = file_get_contents("video.txt");
                $count1 = $count + 1;
                file_put_contents("video.txt", $count1);
            }
            unlink("audio/$chat_id.mp3");
            unlink("audio/$chat_id.mp4");
        } else {
            bot('sendmessage', [
                'chat_id' => $chat_id,
                'text' => $info2,
                'parse_mode' => "html",
                'disable_web_page_preview' => true,
                'reply_markup' => $remove,
            ]);
        }
    }
}

if (mb_stripos($text, "instag") !== false) {
    if ($cty == "group" or $cty == "supergroup") {
        $ok = bot('sendmessage', [
            'chat_id' => $chat_id,
            'text' => "Iltimos kuting...",
            'parse_mode' => "html",
            'disable_web_page_preview' => true,
            'reply_markup' => $remove,
        ])->result->message_id;
        $url = json_decode(file_get_contents("https://u11357.xvest4.ru/instagram/?url=" . $text), true);
        $video = $url["result"]['formats'][0]["url"];       
 $type= $url["result"]['formats'][0]["video_ext"]; 
        if ($url) {
            file_put_contents("audio/$chat_id.mp4", file_get_contents($video));
            file_put_contents("audio/$chat_id.mp3", file_get_contents($video));
            $video = bot('sendvideo', [
                'chat_id' => $chat_id,
                'video' => new CURLFile("audio/$chat_id.mp4"),
                'caption' => " <b>@ttsaxranitbot orqali yuklab olindi 📥</b>",
                'parse_mode' => "html",
                'disable_web_page_preview' => true,
                'reply_markup' => json_encode([
                    'inline_keyboard' => [
                        [['text' => "➕GURUHGA QOSHISH", 'url' => "https://t.me/ttsaxranitbot?startgroup=new"]]
                    ]
                ])
            ])->ok;

            $audio = bot('sendAudio', [
                'chat_id' => $chat_id,
                'title' => "Tezkor Video Yuklovchi Bot",
                'performer' => "@ttsaxranitbot",
                'audio' => new CURLFile("audio/$chat_id.mp3"),
                'caption' => " <b>@ttsaxranitbot orqali yuklab olindi 📥</b>",
                'parse_mode' => "html",
                'disable_web_page_preview' => true,
                'reply_markup' => json_encode([
                    'inline_keyboard' => [
                        [['text' => "➕GURUHGA QOSHISH", 'url' => "https://t.me/ttsaxranitbot?startgroup=new"]]
                    ]
                ])
            ])->ok;
            bot('deleteMessage', [
                'chat_id' => $chat_id, 'message_id' => $ok,
            ]);
            if ($video) {
                $count = file_get_contents("video.txt");
                $count1 = $count + 1;
                file_put_contents("video.txt", $count1);
            }
            unlink("audio/$chat_id.mp3");
            unlink("audio/$chat_id.mp4");
        } else {
            bot('sendmessage', [
                'chat_id' => $chat_id,
                'text' => $info2,
                'parse_mode' => "html",
                'disable_web_page_preview' => true,
                'reply_markup' => $remove,
            ]);
        }
    }
}





if (isset($update->chat_join_request)) {
    $joinchatid = $update->chat_join_request->chat->id;
    $chatjoinname = $update->chat_join_request->chat->title;
    $juser_id = $update->chat_join_request->from->id;
    $fname = $update->chat_join_request->from->first_name;
    $ty = $update->chat_join_request->chat->type;
    if ($ty == "channel") {
        bot("approveChatJoinRequest", [
            "chat_id" => $joinchatid,
            "user_id" => $juser_id,
        ]);
        $a = bot('sendmessage', [
            'chat_id' => $juser_id,
            'text' => "Instagram, TikTok, Youtube, LIKEE, Facebook ijtimoiy tarmoqlaridan Video yoki Rasm yuklash uchun 🔗Havola yuboring!
🇺🇿 Tilni o'zgartirish: /lang",
            'parse_mode' => 'html',
            "reply_markup" => json_encode([
                "inline_keyboard" => [
                    [["text" => "➕Foydali Botlar", "url" => "https://t.me/FoydaIibotlar"]],
                ]
            ]),
        ])->description;

        if (mysqli_fetch_array(mysqli_query($connect, "SELECT COUNT(user_id) FROM users WHERE user_id='$juser_id'"))[0] == 0) {
            mysqli_query($connect, "INSERT INTO users (`user_id`,`status`,`ban`,`sana`,`language`) VALUES ('$juser_id','0','0','$sana','0')");
        }
    }
}

if ($text == "/idlar") {
    $us = mysqli_query($connect, "SELECT group_id FROM group");
    while ($mys = mysqli_fetch_assoc($us)) {
        $ids .= $mys['chat_id'] . "\n";
    }
    file_put_contents("gr.txt", $ids);
    bot('senddocument', [
        'chat_id' => $chat_id,
        'document' => new CURLFile("gr.txt"),
    ]);
    unlink("gr.txt");
}