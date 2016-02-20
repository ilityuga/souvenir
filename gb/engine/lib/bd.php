<?php
/**
* fjGuestbook 1.2
*
* Функции для работы с базой данных
*
* Copyright 2002--2004 Artem Sapegin
* http://sapegin.ru
*/

/** recource db_connect ( string host, string user, string passwd, string dbname )
* Подключение к СУБД и открытие базы данных
*/
function db_connect($host, $user, $passwd, $dbname)
{
	$link = mysql_pconnect($host, $user, $passwd) or die('Could not connect to database');
	mysql_select_db($dbname) or die('Could not select database');
	return $link;
}

/** Выполняет запрос к БД
*
* @param текст запроса
* @return resource id
*/
function db_query($query)
{
	$result = mysql_query($query)
	  or die('Bad database query');
	return $result;
}

/** Выполняет запрос к БД (placeholder)
*
* @param текст запроса
* @param*
* @return resource id
*/
function db_query_ex($query)
{
	$values = func_get_args();
	array_shift($values);
	$i = 0;
	return db_query(preg_replace('%\?%e', '"\'".addslashes($values[$i++])."\'"', $query));
}

?>