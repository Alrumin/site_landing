<?php
ini_set('error_reporting', E_ALL); // проверка и показ предупреждений и ошибок php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

header('Content-Type: text/html; charset=utf-8'); //ругается на Content-Type мозила, почему...

// объявляем  переменные и сразу проверяем на пробелы/спецсимволы
$name = htmlspecialchars( trim($_POST["name"]) );
$phone = htmlspecialchars( trim($_POST["phone"]) );
$email = htmlspecialchars( trim($_POST["email"]) );
$message = htmlspecialchars( trim($_POST["message"]) );

// Декодирование URL-кодированной строки
$name = urldecode($name);
$phone = urldecode($phone);
$email = urldecode($email);
$message = urldecode($message);

// проверяем корректность ввода номера телефона
$phone = str_replace(" ","", $phone);
if(!preg_match("%^[0-9]{11}$%", $phone) or mb_strlen($phone) != 11 ) {
  exit("Некорректный номер телефона!");
}
$phone = mb_substr($phone,0,1) . " ". mb_substr($phone,1,3) . " " . mb_substr($phone,4,3). " " . mb_substr($phone,7,2). " " . mb_substr($phone,9,2); // прописываем вид номера,кт нам необходим 7 999 999 99 99

/*if(preg_match('/^[0-9a-zA-Zа-яА-я!@#$%^&*]{10,}$/',$message) === 0) { 
  exit("Сообщении должно быть не менее 10 символов, используются латиница и кирилица, а также спец. символы !@#$%^& "); // в принципе излишне, достаточно ограничить кол-во символов либо в  html(реализовано), либо в js
  }*/
/*if(preg_match('/([\w\-]+\@[\w\-]+\.[\w\-]+)/',$email) === true) { // это функция нужна для OS.
  exit("Некорректный адрес имейла");
  }*/
  
//echo $phone;

/*echo $name. "<br>"; // проверка, что код работает
echo $phone. "<br>";
echo $pemail. "<br>";
echo $message;*/

// создаем шаблон письма с сайта
// кому
$to = 'logrum@ya.ru';// example2@mail.ru == существующий  имейл адрес сайта
// тема письма
$subject = 'Письмо с сайта ProExtirm';
// текст письма
$message = 'Пользователь: ' . $name. ' отправил Вам письмо: '  . $message . 
' Связаться с ним можно по email <a href="mailto:' . $email .'</a>' . '"и по телефону: ' . $phone ;

if(empty($name) or empty($phone) or empty($email) or empty($message)) { // в принципе, достаточно required
  exit("Не все поля заполнены"); // проверяем на пустоту формы.
} 
if (mail($to, $subject, $message)) {  // прописываем отправку письма и проверку ее[отправки] на корректность
   exit ("Сообщении успешно отправлено");
 } else {
    exit ("При отправке сообщения возникли ошибки");
}

?>

