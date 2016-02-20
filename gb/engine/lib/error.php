<?php
/**
* fjGuestbook 1.2
*
* Обработчик ошибок
*
* Copyright 2002--2004 Artem Sapegin
* http://sapegin.ru
*/

/* ВНИМАНИЕ! Этот модуль устанавливает свой обработчик ошибок
* при подключении (см. последнюю строку). Желательно подключать
* этот модуль как можно раньше.
*/

// типы ошибок
$ERROR_TYPES = array
(
	1    => 'Error',
	2    => 'Warning',
	4    => 'Parsing Error',
	8    => 'Notice',
	16   => 'Core Error',
	32   => 'Core Warning',
	64   => 'Compile Error',
	128  => 'Compile Warning',
	256  => 'User Error',
	512  => 'User Warning',
	1024 => 'User Notice',
);

/**
* Обработчик ошибок.
* Записывает сведения об ошибке в лог
* и сообщает пользователю, что произошла некая ошибка.
*/
ini_set('display_errors', false);
function error_handler($errno, $errmsg, $filename, $linenum)
{
	// если не использовался оператор @
	if (error_reporting())
	{
		$uri = $_SERVER['REQUEST_URI'];
		$errtype = $GLOBALS['ERROR_TYPES'][$errno];
		$errmsg = trim($errmsg);

		// Пишем ошибку в лог
		error_log(SID.'|'.$uri.'|'.$filename.'|'.$linenum.'|'.$errtype.'|'.$errmsg."\n", 3, ERROR_LOG_FILE);

		// Если тип ошибки не Notice
		if ('Notice' != $GLOBALS['ERROR_TYPES'][$errno])
		{
			// Отправляем уведомление администратору
			$message = 'SID:  '.SID."\n"
					 . 'URI:  '.$uri."\n"
					 . 'File: '.$filename."\n"
					 . 'Line: '.$linenum."\n"
					 . 'Type: '.$errtype."\n\n"
					 . $errmsg;
			error_log($message, 1, ADMIN_EMAIL);

			// Выводим в браузер сообщение об ошибке и завершаем выполнение
			ob_end_clean();
			exit('<html><head><title>Ошибка</title></head><body><h1>Ошибка</h1><p>На сайте произошла ошибка. Администратору отправлено уведомление.</p></body></html>');
		}
	}
}

// устанавливаем новый обработчик ошибок
$oeh = set_error_handler('error_handler');

?>
