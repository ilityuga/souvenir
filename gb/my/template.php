<?php
/**
* fjGuestbook 1.2
*
* Шаблон страниц
*
* Copyright 2002--2004 Artem Sapegin
* http://sapegin.ru
*/

/**
* заголовок страницы
*/
function template_header($page)
{
?><html>
<head>
<title>page <?=$page?> &lt; Гостевая книга</title>
<!-- <link rel="stylesheet" type="text/css" href="markitup/skins/simple/style.css" /> -->
<!-- <link rel="stylesheet" type="text/css" href="markitup/sets/bbcode/style.css" /> -->
<style>
body{
padding: 15px;
margin: 0;
color: #333;
/*background-color: #eee;*/
background-color: #F8FCFF;
/*border-left: 30px solid #adba8e;*/
border-left: 30px solid #C08A66;
font: 500 .9em verdana, arial, helvetica;
}
a:link{color: #250;}
a:visited{color: #639;}
a:active,a:hover{
color: #c00;
text-decoration: underline;
}
h1 { font-size: 150%; }
h2 { font-size: 110%; }

.c{margin-bottom: 10px;}
.cn{
/*background-color: #d2d6bc;*/
background-color: #CDD5E0;
padding: 2px 4px;
margin-bottom: 4px;
}
</style>
</head>
<body>
<a href="../dekorativnye-tarelki-dlya-tvorchestva.php" target="_self">Назад на сайт</a>
<h1>Гостевая книга</h1><?php
}

/**
* окончание страницы
*/
function template_footer()
{
?></body>

</html><?php
}

/**
* форма добавления новой записи
*/
function template_form($name, $email, $www, $message, $error)
{
  // вывод сообщения об ошибке
  function error($error)
  {
    if($error) echo '<br><font color=#880000>'.$error.'</font>';
  }

  echo '<h2>Добавить новое сообщение</h2>
<p><table cellspacing="2" cellpadding="2" border="0"><form action='.PATH.'?add=1 method=post><tr>
<td>Имя<font color=#880000>*</font>:</td>
<td><input type=text name="name" size=30 maxlength=100 value="'.$name.'">';
  @error($error['name']);
  echo '</td>
</tr><tr>
<td>Email:</td>
<td><input type=text name="email" size=30 maxlength=100 value="'.$email.'">';
  @error($error['email']);
  echo '</td>
</tr><tr>
<td>Сайт:</td>
<td><input type=text name="www" size=30 maxlength=100 value="'.$www.'">';
  echo '</td>
</tr><tr>
<td>Сообщение<font color=#880000>*</font>:</td>
<td><textarea id="bbcode" cols=40 rows=5 name="message">'.$message.'</textarea>';
  @error($error['message']);
  echo '</td>
</tr><tr>
<td>&nbsp;</td>
<td><small><font color=#880000>*</font>&nbsp;&#151; Обязательные поля</small></td>
</tr><tr>
<td>&nbsp;</td>
<td><input name="sb" type=submit value="Добавить сообщение"></td>
</form></tr>
</table>';
}

/**
* печать одной записи гостевой книги
*/
function template_show_body($id, $name, $email, $www, $message, $datetime)
{
  $out = '<div class=c><div class=cn><b>'.$name.'</b> ';
  // если есть email или homepage -- печатаем их
  if($email || $www)
  {
    $out .= '( ';
    if($email)
      $out .= ' <a href=mailto:'.$email.'>email</a>';
    if($email && $www)
      $out .= ' | ';
    if($www)
      $out .= ' <a href='.$www.'>www</a>';
    $out .= ' )';
  }
  $out .= ' пишет '.$datetime.':</div>'.$message.'</div>';
  // если гостевую книгу просматривает администратор -- печатаем кнопку удаления записи
  if(auth_is_admin())
  {
    $out .= '<div class=c>[ <a href='.PATH.'?admin=1&del='.$id.'>удалить</a> ]</div>';
  }

  return $out;
}

?>