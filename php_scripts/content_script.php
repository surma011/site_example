<?php
	function f_edit_content($url)
	{
		echo
		("<script>
			document.cookie='temp=".$url."';
			document.location.href='editor.php';
		</script>");
	}
	function f_del_content($db,$num)
	{
		mysqli_query($db,"DELETE FROM products WHERE num='".$num."'");
		mysqli_close($db);
		echo("<script>document.location.href='prices.php';</script>");
	}
	function f_content_read($url)
	{
		f_temp_clean();
		echo("<div class='content'>");
		if(@$db=mysqli_connect("localhost","user-ks-39","1","user-ks-39"))
		{
			mysqli_query($db,"SET NAMES utf8_general_ci");
			$db->set_charset("utf8_general_ci");
			$res=mysqli_query($db,"SELECT * FROM article WHERE url='".$url."'");
			$row=mysqli_fetch_array($res);
			echo("<div id='content_head' class='text contenthead'>".$row['head']);
			if((f_user_group()=="Admins")||(f_user_group()=="Moders"))
			{
				echo("<form class='add_post_button content_form' action='".$url.".php' method='POST'>");
				echo("<input class='button' type='submit' name='edit_content_button' value='Редактировать'>");
				echo("</form>");
				if(isset($_POST['edit_content_button']))f_edit_content($url);
			}
			echo("</div>");
			$content=$row['content'];
			$len=iconv_strlen($content);
			if($url!="about")echo("<div id='content_text' class='text contenttext'>");
			else echo("<div id='content_text' class='text contentcenter'>");
			$content=str_replace("[","<img class='contentimg' src='",$content);
			$content=str_replace("]","'>",$content);
			echo($content);
			echo("</div>");
		}
		else echo("<br>DB not connected<br>");
		echo("</div>");
	}
	function f_content_prices()
	{
		f_temp_clean();
		echo("<div class='content'>");
		if((f_user_group()=="Admins")||(f_user_group()=="Moders"))
		{
			echo("<form class='add_post_button' action='prices.php' method='POST'>");
			echo("<input class='button' type='submit' name='add_product_button' value='Добавить'>");
			echo("</form>");
			if(isset($_POST['add_product_button']))f_edit_content('prices');
		}
		echo("<div class='catalog'>");
		if(@$db=mysqli_connect("localhost","user-ks-39","1","user-ks-39"))
		{
			mysqli_query($db,"SET NAMES utf8_general_ci");
			$db->set_charset("utf8_general_ci");
			$row="SELECT * FROM products";
			$res=mysqli_query($db,$row);
			while($row=mysqli_fetch_array($res))
			{
				echo("<div class='product'><div class='product_inf'>");
				echo("<a class='text producttext' href='".$row['url']."'>");
				echo("<img class='product_img' src='".$row['img_url']."'>");
				echo($row['name']."<br>".$row['price']." ₽</a></div>");
				if((f_user_group()=="Admins")||(f_user_group()=="Moders"))
				{
					echo("<form class='product_control' action='prices.php' method='POST'>");
					echo("<input class='button product_button' type='submit' name='edit_product_".$row['num']."_button' value='Изменить'>");
					echo("<input class='button product_button' type='submit' name='del_product_".$row['num']."_button' value='Удалить'>");
					echo("</form>");
					if(isset($_POST["edit_product_".$row['num']."_button"]))f_edit_content('prices_'.$row['num']);
					if(isset($_POST["del_product_".$row['num']."_button"]))f_del_content($db,$row['num']);
				}
				echo("</div>");
			}
			mysqli_close($db);
		}
		else echo("<br>DB not connected<br>");
		echo("</div>");
		echo("</div>");
	}
?>