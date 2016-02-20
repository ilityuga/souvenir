<?php 
$xxx =$_POST["xxx"];

$name=$_POST["name"];
$email=$_POST["email"];
$mess=$_POST["mess"];  
if (isset ($name))
	{
		$name = substr($name,0,30); //Не может быть более 30 символов
	}
else
	{
		$name = "не указано";
	}
if (isset ($email))
	{
		$email = substr($email,0,30); //Не может быть более 30 символов
	}
else
	{
		$email = "не указано";
	}
if (isset ($mess))
	{
		$mess = substr($mess,0,1000); //Не может быть более 1000 символов
	}
else
	{
		$mess = "не указано";
	}
$i = "не указано";
if ($name == $i AND $email == $i AND $mess == $i)
	{
		echo "Ошибка ! Скрипту не были переданы параметры !";
		exit;
	}
//$to = "slisyanskiy@mail.ru";  /*МЕНЯЕШЬ НА СВОЙ АДРЕСС!*/
$to = "igor.litiuga@aval.ua";  /*МЕНЯЕШЬ НА СВОЙ АДРЕСС!*/
$subject = '=?UTF-8?B?' . base64_encode('От посетителя сайта souvenir') . '?=';
$message = "Имя:$name, Электронный адрес:$email, Сообщение:$mess";
$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
$headers .= 'MIME-Version: 1.0' . "\r\n";
mail ($to,$subject,$message,$headers) or print "Не могу отправить письмо.";
echo "<center><b>Спасибо за отправку вашего сообщения<br><a href=../dekorativnye-tarelki-dlya-tvorchestva.php>Нажмите</a>, чтобы вернуться на Главную страницу сайта";
exit;
?>
