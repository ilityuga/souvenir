<?php
/**
* fjGuestbook 1.2
*
* Основные функции гостевой книги
*
* Copyright 2002--2004 Artem Sapegin
* http://sapegin.ru
*/

/**
* Создание таблицы, если её ещё нет
*/
function gb_install()
{
	db_query(
		'CREATE TABLE IF NOT EXISTS gb (
			id int(10) unsigned NOT NULL auto_increment,
			datetime datetime NOT NULL default \'0000-00-00 00:00:00\',
			name varchar(100) NOT NULL default \'\',
			email varchar(100) default NULL,
			www varchar(100) default NULL,
			message text NOT NULL,
			PRIMARY KEY (id),
			INDEX (datetime)
		) TYPE=MyISAM;'
	);
}

/**
* Добавление записи в гостевую книгу
*/
function gb_add($name, $email, $www, $message, &$error)
{
	// проверяем правильность заполнения полей
	$error = '';
	if(empty($name))
		$error['name'] = 'Это обязательное поле';
	if(empty($message))
		$error['message'] = 'Это обязательное поле';
	if(!empty($email) && !strings_isemail($email))
		$error['email'] = 'Это не email';

	// если не было ошибок -- добавляем
	if(!$error)
	{
		// чистим данные
		$name = strings_clear($name);
		$message = strings_clear($message);
		$name = strings_stripstring($name, 15, 100);
		$email = strings_stripstring($email, 100, 100);
		$www = strings_stripstring($www, 100, 100);
		$message = strings_stripstring($message, 100, 2000);
		$message = nl2br($message);

		// если пользователь поленился написать http:// перед адресом -- сделаем это за него
		if(!empty($www) && 'http://' != substr($www, 0, 7))
			$www = 'http://'.$www;

		// запрос на добавление записи в базу данных
		db_query_ex('SET CHARACTER SET utf8');
		db_query_ex('SET NAMES utf8');
		db_query_ex('INSERT INTO gb (name, email, www, message, datetime) VALUES(?, ?, ?, ?, NOW())', $name, $email, $www, $message);
		// перекидываем браузер на первую страницу
		// это нужно, чтобы, если пользователь нажмет кнопку Refresh, запись не добавилась еще раз
//		header('Location: '.PATH."?page=1");
	}
}

// удаление записи из гостевой книги
function gb_delete($id)
{
  // запрос на удаление записи из базы данных
  // WHERE id = '.$id указывает на запись, которую следует удалить
  db_query_ex('DELETE FROM gb WHERE id = ?', $id);
//  header('Location: '.PATH."?page=1"); // ???
}

// вывод страницы с записями
function gb_show($page)
{
	// положение первой записи страницы
	$begin = ($page - 1) * 10;
	// выборка записей из базы данных
	// SELECT * FROM gb -- все поля из бд gb
	// ORDER BY datetime DESC -- сортировка по дате, новые сверху
	// LIMIT '.$begin.','.RECSPERPAGE -- ограничение: RECSPERPAGE (см. defines.php) записей начиная с $begin
	db_query('SET CHARACTER SET utf8');
	db_query('SET NAMES utf8');
	$result = db_query('SELECT * FROM gb ORDER BY datetime DESC LIMIT '.$begin.', '.RECSPERPAGE);
	$out = '';

	// цикл по всем выбранным записям
	while($row = mysql_fetch_array($result))
		$out .= template_show_body($row['id'], $row['name'], $row['email'], $row['www'], $row['message'], $row['datetime']);

	// уничтожаем результат
	mysql_free_result($result);

	echo $out;
}

// вывод списка страниц
function gb_showpages($current)
{
	// узнаем число записей в гостевой книге
	$result = db_query('SELECT * FROM gb');
	$rows = mysql_num_rows($result);
	if($rows)
	{
		$pages = ceil($rows / RECSPERPAGE);

		// печатаем ссылки на страницы (номер текущей страницы не является ссылкой)
		echo '<div class=c>';
		for($i = 1; $i <= $pages; $i++)
		{
			if($i != $current)
				echo ' | <a href='.PATH.'?page='.$i.'>'.$i.'</a>';
			else
				echo ' | '.$i;
		}
		echo ' |';

		// если это не полследняя страница печатаем ссылку "Дальше"
		if($current < $pages)
			echo ' <a href='.PATH.'?page='.($current + 1).'>Дальше &gt;&gt;</a>';
		echo '</div>';
	}
}

?>