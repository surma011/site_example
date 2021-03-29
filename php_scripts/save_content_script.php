<?php
	if(isset($_POST['save_content_button']))
	{
		if (@$db=mysqli_connect("localhost","user-ks-39","1","user-ks-39"))
		{
			mysqli_query($db,"SET NAMES utf8_general_ci");
			$db->set_charset("utf8_general_ci");
			$res=mysqli_query($db,"SELECT * FROM article WHERE url='".$_COOKIE['temp']."'");
			mysqli_query($db,"UPDATE article SET head='".$_POST['head']."' WHERE url='".$_COOKIE['temp']."'");
			mysqli_query($db,"UPDATE article SET content='".$_POST['content']."' WHERE url='".$_COOKIE['temp']."'");
			mysqli_close($db);
			header("Location: /Practic/".$_COOKIE['temp'].".php");
		}
		else echo("<br>DB not connected<br>");
	}
	if(isset($_POST['save_product_button']))
	{
		if (@$db=mysqli_connect("localhost","user-ks-39","1","user-ks-39"))
		{
			mysqli_query($db,"SET NAMES utf8_general_ci");
			$db->set_charset("utf8_general_ci");
			if($_COOKIE['temp']=="prices")
			{
				$res=mysqli_query($db,"SELECT num FROM products");
				$num=0;
				while($row=mysqli_fetch_array($res))$num=$row['num'];
				$num++;
				mysqli_query($db,"INSERT INTO products (num,url,img_url,name,price) VALUES ('".$num."','".$_POST['url']."','".$_POST['img_url']."','".$_POST['name']."','".$_POST['price']."')");
				mysqli_close($db);
				header("Location: /Practic/prices.php");
			}
			else
			{
				mysqli_query($db,"UPDATE products SET url='".$_POST['url']."' WHERE num='".$_COOKIE['temp'][7]."'");
				mysqli_query($db,"UPDATE products SET img_url='".$_POST['img_url']."' WHERE num='".$_COOKIE['temp'][7]."'");
				mysqli_query($db,"UPDATE products SET name='".$_POST['name']."' WHERE num='".$_COOKIE['temp'][7]."'");
				mysqli_query($db,"UPDATE products SET price='".$_POST['price']."' WHERE num='".$_COOKIE['temp'][7]."'");
				mysqli_close($db);
				header("Location: /Practic/prices.php");
			}
		}
		else echo("<br>DB not connected<br>");
	}
?>