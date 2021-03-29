<?php
	function f_return()
	{
		if(($_COOKIE['temp'][0]!='p')&&($_COOKIE['temp'][1]!='r')&&($_COOKIE['temp'][2]!='i')&&($_COOKIE['temp'][3]!='c')&&($_COOKIE['temp'][4]!='e')&&($_COOKIE['temp'][5]!='s'))
			echo("<script>document.location.href='".$_COOKIE['temp'].".php';</script>");
		else echo("<script>document.location.href='prices.php';</script>");
	}
	echo("<div class='content'>");
	if(($_COOKIE['temp'][0]!='p')&&($_COOKIE['temp'][1]!='r')&&($_COOKIE['temp'][2]!='i')&&($_COOKIE['temp'][3]!='c')&&($_COOKIE['temp'][4]!='e')&&($_COOKIE['temp'][5]!='s'))
	{
		if (@$db=mysqli_connect("localhost","user-ks-39","1","user-ks-39"))
		{
			mysqli_query($db,"SET NAMES utf8_general_ci");
			$db->set_charset("utf8_general_ci");
			$res=mysqli_query($db,"SELECT * FROM article WHERE url='".$_COOKIE['temp']."'");
			$row=mysqli_fetch_array($res);
			echo("<form method='POST'>");
			echo("<input class='add_post_button button' type='submit' name='return_button' value='Отмена'>");
			echo("</form>");
			if(isset($_POST['return_button']))f_return();
			echo("<form action='php_scripts/save_content_script.php' method='POST'>");
			echo("<input class='add_post_button button' type='submit' name='save_content_button' value='Сохранить'>");
			echo("<textarea required id='editor_head' class='theme text contenthead editor_head' name='head'>".$row['head']."</textarea>");
			echo("<textarea required id='editor_content' class='theme text contenttext editor_content' name='content'>".$row['content']."</textarea>");
			echo("</form>");
			echo("<div class='text'>Адреса изображений помещаются между '[' и ']'</div>");
		}
		else echo("<br>DB not connected<br>");
	}
	else
	{
		if($_COOKIE['temp']=="prices")
		{
			if (@$db=mysqli_connect("localhost","user-ks-39","1","user-ks-39"))
			{
				mysqli_query($db,"SET NAMES utf8_general_ci");
				$db->set_charset("utf8_general_ci");
				echo("<form class='product_editor' action='php_scripts/save_content_script.php' method='POST'>");
				echo("<input class='product_text_area' required type='url' name='url' placeholder='Введите адрес товара'><br>");
				echo("<input class='product_text_area' required type='text' name='img_url' placeholder='Введите адрес изображения товара'><br>");
				echo("<input class='product_text_area' required type='text' name='name' placeholder='Введите название товара'><br>");
				echo("<input class='product_text_area' required type='text' name='price' placeholder='Введите стоимость товара'><br>");
				echo("<input class='button product_editor_button' type='submit' name='save_product_button' value='Сохранить'><br>");
				echo("</form>");
				echo("<form class='product_return' method='POST'>");
				echo("<input class='button product_editor_button' type='submit' name='return_button' value='Отмена'>");
				echo("</form>");
				if(isset($_POST['return_button']))f_return();
			}
			else echo("<br>DB not connected<br>");
		}
		else
		{
			if (@$db=mysqli_connect("localhost","user-ks-39","1","user-ks-39"))
			{
				mysqli_query($db,"SET NAMES utf8_general_ci");
				$db->set_charset("utf8_general_ci");
				$res=mysqli_query($db,"SELECT * FROM products WHERE num='".$_COOKIE['temp'][7]."'");
				$row=mysqli_fetch_array($res);
				echo("<form class='product_editor' action='php_scripts/save_content_script.php' method='POST'>");
				echo("<input class='product_text_area' required type='url' name='url' placeholder='Введите адрес товара' value='".$row['url']."'><br>");
				echo("<input class='product_text_area' required type='text' name='img_url' placeholder='Введите адрес изображения товара' value='".$row['img_url']."'><br>");
				echo("<input class='product_text_area' required type='text' name='name' placeholder='Введите название товара' value='".$row['name']."'><br>");
				echo("<input class='product_text_area' required type='text' name='price' placeholder='Введите стоимость товара' value='".$row['price']."'><br>");
				echo("<input class='button product_editor_button' type='submit' name='save_product_button' value='Сохранить'><br>");
				echo("</form>");
				echo("<form class='product_return' method='POST'>");
				echo("<input class='button product_editor_button' type='submit' name='return_button' value='Отмена'>");
				echo("</form>");
				if(isset($_POST['return_button']))f_return();
			}
			else echo("<br>DB not connected<br>");
		}
	}
	echo("</div>");
	
?>