<!doctype html>
<html lang="ru">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" type="text/css" href="style.css">
	<title>pc.ru</title>
    <link rel="shortcut icon" type="image/png" href="img/icon.png">
</head>
<body>
	<div class="theme user text" id=user_block>Вы - 
		<?php require("php_scripts/main_script.php");?>
	</div>
	<div class="theme main_menu">
		<ul class="line">
			<li><a class="text linetext" href="index.php">Главная</a></li>
			<li><a class="text linetext" href="history.php">История развития</a></li>
			<li><a class="text linetext" href="contacts.php">Обратная связь</a></li>
			<li><a class="text linetext" href="about.php">Об авторе</a></li>
			<li><a class="text linetext" href="private.php?forum_button=Форум">
			<?php
				if(f_user_name()=="Гость") echo(" Вход");
				else echo("Личный Кабинет");
			?>
			</a>
			</li>
		</ul>
	</div>