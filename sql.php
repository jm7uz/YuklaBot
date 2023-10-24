<?php
define("DB_SERVER", "localhost"); // Tegilmaydi
define("DB_USERNAME", "x_u_5437_ttsaxranit"); // Mysql baza nomi
define("DB_PASSWORD", "Qobilbek96"); // Mysql baza paroli
define("DB_NAME", "x_u_5437_ttsaxranit"); // Mysql baza nomi

$connect = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
mysqli_set_charset($connect, "utf8mb4");
if($connect){
    echo "Ulandi";
}
?>