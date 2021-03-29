<?php
	//доделать редактирование поста
	function f_del_post($db,$num)
	{
		mysqli_query($db,"DELETE FROM theme_".$_COOKIE['temp']." WHERE num='".$num."'");
		header('Location: forum.php');
	}
	function f_add_post($db)
	{
		$res=mysqli_query($db,"SELECT num FROM theme_".$_COOKIE['temp']);
		$num=0;
		while($row=mysqli_fetch_array($res))$num=$row['num']++;
		$num++;
		mysqli_query($db,"INSERT INTO theme_".$_COOKIE['temp']." (num,creator,text) VALUES ('".$num."','".f_user_name()."','".$_POST["add_post"]."')");
		header('Location: forum.php');
	}
	/*function f_edit_post($db,$num,$text)
	{
		echo
		("<script>
			document.getElementById('post_textarea').value='".$text."';
			document.getElementById('post_button').value='Сохранить';
			document.getElementById('post_button').name='edit_post_button';
			document.getElementById('edit_post_".$num."_button').value='Отмена';
			document.getElementById('edit_post_".$num."_button').name='noedit_button';
		</script>");
		if(isset($_POST['edit_post_button']))
		{
			mysqli_query($db,"UPDATE theme_".$_COOKIE["theme_num"]." SET text='".$_POST[add_post]."' WHERE num='".$num."'");
			echo
			("<script>
				document.getElementById('post_textarea').value='';
				document.getElementById('post_button').value='Отправить';
				document.getElementById('post_button').name='add_post_button';
				document.getElementById('edit_post_".$num."_button').value='Редактировать';
				document.getElementById('edit_post_".$num."_button').name='edit_post_".$row['num']."_butto';
			</script>");
		}
		if(isset($_POST['noedit_button']))
		{
			echo
			("<script>
				document.getElementById('post_textarea').value='';
				document.getElementById('post_button').value='Отправить';
				document.getElementById('post_button').name='add_post_button';
				document.getElementById('edit_post_".$num."_button').value='Редактировать';
				document.getElementById('edit_post_".$num."_button').name='edit_post_".$row['num']."_butto';
			</script>");
		}
		echo("<script>document.getElementById('post_".$num."').remove();</script>");
	}*/
	function f_post_creator($db,$user)
	{
		$res=mysqli_query($db,"SELECT usergroup FROM users WHERE user='".$user."'");
		$row=mysqli_fetch_array($res);
		return $row['usergroup'];
	}
	echo("<div class='content'>");
	if(@$db=mysqli_connect("localhost","user-ks-39","1","user-ks-39"))
	{
		mysqli_query($db,"SET NAMES utf8_general_ci");
		$db->set_charset("utf8_general_ci");
		echo("<div class='text contenttext borders private_active_zone forum_page'>");
		$res=mysqli_query($db,"SELECT theme FROM forum WHERE num=".$_COOKIE["temp"]);
		$row=mysqli_fetch_array($res);
		echo("Темa: ".$row['theme']."<br>");
		$res=mysqli_query($db,"SELECT * FROM theme_".$_COOKIE["temp"]);
		while($row=mysqli_fetch_array($res))
		{
			echo("<div id='post_".$row['num']."'class='borders forum_active_zone'>");
			echo("Автор: ".$row['creator']."<br>".$row['text']);
			if((f_user_group()=="Admins")||(f_user_name()==$row['creator'])||((f_post_creator($db,$row['creator'])=='Users')&&(f_user_group()=="Moders")))
			{
				echo("<form class='private_button del_theme_button' action='forum.php' method='POST'>");
				echo("<input class='button' type='submit' name='del_post_".$row['num']."_button' value='Удалить'>");
				//echo("<input id='edit_post_".$row['num']."_button' class='button' type='submit' name='edit_post_".$row['num']."_button' value='Редактировать'>");
				echo("</form>");
			}
			if(isset($_POST["del_post_".$row['num']."_button"]))f_del_post($db,$row['num']);
			echo("<br>");
			echo("</div>");
		}
		if(isset($_POST['add_post_button']))f_add_post($db);
		echo("</div>");
		echo("<form id='add_post_area' class='add_post' action='forum.php' method='POST'>");
		echo("<textarea required id='post_textarea' class='theme text contentcenter add_post_area' name='add_post'></textarea>");
		echo("<input id='post_button' class='button add_post_button' type='submit' name='add_post_button' value='Отправить'>");
		echo("</form>");
		mysqli_close($db);
	}
	else echo("<br>DB not connected<br>");
	echo("</div>");
?>