<!DOCTYPE html>
<html lang="ru">

<head>
	<?php include('template/head.html');?>
	<title>Обратная связь</title>
	<meta name="description" content="Контакты - обратная связь">
	<meta name="keywords" content="обратная связь">
	<?php include('template/analytics.html');?>
</head>
<body>
<div id="feed">
	<b><a href="feedback.php">Выполнить заказ</a></b>
</div>
<div id="container">
	<img src="catalog/tarelki/tarelki_logo.jpg" width="1050" height="200">
	<?php include('menu.html');?>
	<div id="content">
		<h1 align="center">Обратная связь</h1><br />
		<form id="forma" action=template/mail.php method=post>
			<label for="name">Имя: </label><br />
			<input type="text" id="name" size=30 name="name" placeholder="Ваше имя" required><br />
			<label for="email">Email: </label><br />
			<input type="email" id="email" pattern="[^ @]*@[^ @]*" size=30 name="email" placeholder="Ваш email" equired><br />
			<label for="name">Сообщение: </label><br />
			<textarea rows=10 cols=50 name="mess" id="mess" placeholder="Ваше сообщение" required></textarea><br />
       		<button type="submit">Отправить</button>  
		</form>  
		<br />
	</div>
</div>
<div id="footer-clear"></div>
<?php include('footer.html'); ?>
</body>
	<?php include('template/script.html');?>
</html>
