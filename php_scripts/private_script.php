<?php
	function f_del_theme($db,$num,$theme)
	{
		mysqli_query($db,"DELETE FROM forum WHERE num='".$num."'");
		mysqli_query($db,"DROP TABLE ".$theme);
		echo("<script>document.location.href='private.php?forum_button=Форум';</script>");
	}
	function f_del_message($db,$num)
	{
		mysqli_query($db,"DELETE FROM feedback WHERE num='".$num."'");
		echo("<script>document.location.href='private.php?feedback_button=Обратная+связь';</script>");
	}
	function f_clear_feedback($db)
	{
		mysqli_query($db,"DROP TABLE feedback");
		mysqli_query($db,"CREATE TABLE feedback (num int(1),mail varchar(50),text varchar(500))");
		echo("<script>document.location.href='private.php?feedback_button=Обратная+связь';</script>");
	}
	function f_edit_account($db,$user)
	{
		$res=mysqli_query($db,"SELECT user,pass FROM users WHERE user='".$user."'");
		$row=mysqli_fetch_array($res);
		if($row['pass']==$_POST['old_pass'])
		{
			if($row['user']!=$_POST['login'])
			{
				$pattern='/^([a-zа-я0-9])/is';
				if((strlen($_POST['login'])>2)&&(strlen($_POST['login'])<11)&&(preg_match($pattern,$_POST['login'])))
				{
					$res=mysqli_query($db,"SELECT user FROM users");
					$coin=false;
					while($row=mysqli_fetch_array($res))if($row['user']==$_POST['login'])$coin=true;
					if($coin==false)
					{
						mysqli_query($db,"UPDATE users SET user='".$_POST['login']."' WHERE user='".$user."'");
						$res=mysqli_query($db,"SELECT num FROM forum");
						while($row=mysqli_fetch_array($res))mysqli_query($db,"UPDATE theme_".$row['num']." SET creator='".$_POST['login']."' WHERE creator='".$user."'");
						echo("Логин успешно обновлён<br>");
					}
					else echo("Пользователь с таким логином уже существует<br>");
					$res=mysqli_query($db,"SELECT user,pass FROM users WHERE user='".$user."'");
					$row=mysqli_fetch_array($res);
				}
				else echo("Новый логин не удовлетворяет требованиям<br>
				(Логин не может быть меньше 3 символов и больше 10.<br>
				Для логина можно использовать русские, латинские буквы и цифры.)<br>");
			}
			if($_POST['new_pass']!=null)
			{
				if($_POST['new_pass']==$_POST['re_pass'])
				{
					if((strlen($pass)>2)&&(strlen($pass)<31))
					{
						if($_POST['new_pass']!=$row['pass'])
						{
							mysqli_query($db,"UPDATE users SET pass='".$_POST['new_pass']."' WHERE user='".$user."'");
							echo("Пароль успешно обновлён<br>");
						}
						else echo("Новый пароль не должен совпадать со старым<br>");
					}
					else echo("Новый пароль не удовлетворяет требованиям<br>
					(Пароль не может быть меньше 3 символов и больше 30.)<br>");
				}
				else echo("Новый пароль не совпадает со своим повтором<br>");
			}
		}
		else echo("Старый пароль неверен<br>");
	}
	function f_add_theme($db)
	{
		$res=mysqli_query($db,"SELECT * FROM forum");
		$coin=false;
		$num=0;
		while(($row=mysqli_fetch_array($res))&&($coin==false))
		{
			if($_POST['new_theme']==$row['theme'])$coin=true;
			$num=$row['num']++;
		}
		if($coin!=true)
		{
			mysqli_query($db,"INSERT INTO forum (num,theme) VALUES ('".($num+1)."','".$_POST['new_theme']."')");
			mysqli_query($db,"CREATE TABLE theme_".($num+1)." (num int(1), creator varchar(10),text varchar(500))");
			echo("<script>document.location.href='private.php?forum_button=Форум';</script>");
		}
	}
	function f_enter_theme($num)
	{
		echo
		("<script>
			document.cookie='temp=".$num."';
			document.location.href='forum.php';
		</script>");
	}
	function f_change_group($db,$user,$change)
	{
		switch($change)
		{
			case('up'):
			{
				mysqli_query($db,"UPDATE users SET usergroup='Moders' WHERE user='".$user."'");
				echo("<script>document.location.href='private.php?user_management_button=Управление+пользователями';</script>");
				break;
			}
			case('down'):
			{
				mysqli_query($db,"UPDATE users SET usergroup='Users' WHERE user='".$user."'");
				echo("<script>document.location.href='private.php?user_management_button=Управление+пользователями';</script>");
				break;
			}
		}
	}
	function f_del_user($db,$user)
	{
		mysqli_query($db,"DELETE FROM users WHERE user='".$user."'");
		$res=mysqli_query($db,"SELECT num FROM forum");
		while($row=mysqli_fetch_array($res))mysqli_query($db,"DELETE FROM theme_".$row['num']." WHERE creator='".$user."'");
		echo("<script>document.location.href='private.php?user_management_button=Управление+пользователями';</script>");
	}
	function f_forum($db,$group)
	{
		echo("Темы форума:");
		$res=mysqli_query($db,"SELECT * FROM forum");
		$row=mysqli_fetch_array($res);
		if(($group=='Admins')||($group=='Moders'))
		{
			echo("<form class='del_theme_button' action='private.php?forum_button=Форум' method='POST'>");
			echo("<input  required type='text' name='new_theme' size=30 placeholder='Новая тема'>");
			echo("<input class='button' type='submit' name='add_theme_button' value='Создать тему'>");
			echo("</form>");
		}
		while($row)
		{
			echo("<div class='borders forum'>");
			echo($row['theme']);
			echo("<form class='del_theme_button' action='private.php?forum_button=Форум' method='POST'>");
			echo("<input class='button' type='submit' name='enter_theme_".$row['num']."_button' value='Войти'>");
			echo("</form>");
			if(($group=='Admins')||($group=='Moders'))
			{
				echo("<form class='del_theme_button' action='private.php?forum_button=Форум' method='POST'>");
				echo("<input class='button' type='submit' name='del_theme_".$row['num']."_button' value='Удалить тему'>");
				echo("</form>");
			}
			if(isset($_POST["enter_theme_".$row['num']."_button"]))f_enter_theme($row['num']);
			if(isset($_POST["del_theme_".$row['num']."_button"]))f_del_theme($db,$row['num'],$row['theme']);
			echo("</div>");
			$row=mysqli_fetch_array($res);
		}
		if(isset($_POST['add_theme_button']))f_add_theme($db);
	}
	function f_settings($db)
	{
		echo("Насткройки аккаунта<br>");
		$res=mysqli_query($db,"SELECT usergroup,user FROM users WHERE user='".f_user_name()."'");
		$row=mysqli_fetch_array($res);
		echo("Роль: ");
		switch($row['usergroup'])
		{
			case('Admins'):echo("Администратор<br>");break;
			case('Moders'):echo("Модератор<br>");break;
			case('Users'):echo("Пользователь<br>");break;
		}
		echo("<form action='private.php?settings_button=Настройки+аккаунта' method='POST'>");
		echo("Ваш логин:<input required type='text' name='login' size=15 maxlength=10 placeholder='Придумайте логин' value='".$row['user']."'><br>");
		echo("Новый пароль(по надобности):<input type='password' name='new_pass' size=30 maxlength=30 placeholder='Новый пароль'>");
		echo("<input type='password' name='re_pass' size=30 maxlength=30 placeholder='Повторите новый пароль'><br>");
		echo("Старый пароль для подтверждения изменений:<input required type='password' name='old_pass' size=30 maxlength=30 placeholder='Введите пароль'><br>");
		echo("<input class='button' type='submit' name='save_account' value='Сохранить изменения'><br>");
		echo("</form>");
		if(isset($_POST['save_account']))f_edit_account($db,$row['user']);
	}
	function f_feedback($db)
	{
		echo("Обратная связь:");
		echo("<form class='del_theme_button' action='private.php?feedback_button=Обратная+связь' method='POST'>");
		echo("<input class='button' type='submit' name='clear_feedback' value='Удалить всё'>");
		echo("</form>");
		if(isset($_POST["clear_feedback"]))f_clear_feedback($db);
		$res=mysqli_query($db,"SELECT * FROM feedback");
		while($row=mysqli_fetch_array($res))
		{
			echo("<div class='borders feedback_message'>");
			echo("От: ".$row['mail']."<br>");
			echo($row['text']);
			echo("<form class='del_theme_button' action='private.php?feedback_button=Обратная+связь' method='POST'>");
			echo("<input class='button' type='submit' name='del_message_".$row['num']."_button' value='Удалить отзыв'>");
			echo("</form>");
			echo("</div>");
			if(isset($_POST["del_message_".$row['num']."_button"]))f_del_message($db,$row['num']);
		}
	}
	function f_user_management($db)
	{
		echo("Управление пользователями<br>");
		$res=mysqli_query($db,"SELECT usergroup,user FROM users");
		while($row=mysqli_fetch_array($res))
		{
			echo("<div class='borders forum'>");
			echo("Пользователь:".$row['user']."&nbsp;&nbsp;&nbsp;&nbsp;Роль:");
			switch($row['usergroup'])
			{
				case('Admins'):echo("Администратор");break;
				case('Moders'):echo("Модератор");break;
				case('Users'):echo("Пользователь");break;
			}
			if($row['usergroup']!='Admins')
			{
				echo("<form class='del_theme_button' action='private.php?user_management_button=Управление+пользователями' method='POST'>");
				if($row['usergroup']=='Moders')
				{
					echo("<input class='button' type='submit' name='down_user_".$row['user']."_button' value='Понизить роль'>");
					if(isset($_POST["down_user_".$row['user']."_button"]))f_change_group($db,$row['user'],"down");
				}
				if($row['usergroup']=='Users')
				{
					echo("<input class='button' type='submit' name='up_user_".$row['user']."_button' value='Повысить роль'>");
					if(isset($_POST["up_user_".$row['user']."_button"]))f_change_group($db,$row['user'],"up");
				}
				echo("<input class='button' type='submit' name='del_user_".$row['user']."_button' value='Удалить пользователя'>");
				if(isset($_POST["del_user_".$row['user']."_button"]))f_del_user($db,$row['user']);
				echo("</form>");
			}
			echo("</div>");
		}
	}
	if(@$db=mysqli_connect("localhost","user-ks-39","1","user-ks-39"))
	{
		f_temp_clean();
		mysqli_query($db,"SET NAMES utf8_general_ci");
		$db->set_charset("utf8_general_ci");
		$group=f_user_group();
		switch($group)
		{
			case('Admins'):
			{
				echo("<form action='private.php' method='GET'>");
				echo("<input class='button private_button' type='submit' name='forum_button' value='Форум'>");
				echo("<input class='button private_button' type='submit' name='settings_button' value='Настройки аккаунта'>");
				echo("<input class='button private_button' type='submit' name='feedback_button' value='Обратная связь'>");
				echo("<input class='button private_button' type='submit' name='user_management_button' value='Управление пользователями'>");
				echo("</form>");
				echo("<div class='borders private_active_zone'>");
				if(isset($_GET["forum_button"]))f_forum($db,$group);
				if(isset($_GET["settings_button"]))f_settings($db);
				if(isset($_GET["feedback_button"]))f_feedback($db);
				if(isset($_GET["user_management_button"]))f_user_management($db);
				echo("</div>");
				break;
			}
			case('Moders'):
			{
				echo("<form action='private.php' method='GET'>");
				echo("<input class='button private_button' type='submit' name='forum_button' value='Форум'>");
				echo("<input class='button private_button' type='submit' name='settings_button' value='Настройки аккаунта'>");
				echo("<input class='button private_button' type='submit' name='feedback_button' value='Обратная связь'>");
				echo("</form>");
				echo("<div class='borders private_active_zone'>");
				if(isset($_GET["forum_button"]))f_forum($db,$group);
				if(isset($_GET["settings_button"]))f_settings($db);
				if(isset($_GET["feedback_button"]))f_feedback($db);
				echo("</div>");
				break;
			}
			case('Users'):
			{
				echo("<form action='private.php' method='GET'>");
				echo("<input class='button private_button' type='submit' name='forum_button' value='Форум'>");
				echo("<input class='button private_button' type='submit' name='settings_button' value='Настройки аккаунта'>");
				echo("</form>");
				echo("<div class='borders private_active_zone'>");
				if(isset($_GET["forum_button"]))f_forum($db,$group);
				if(isset($_GET["settings_button"]))f_settings($db);
				echo("</div>");
				break;
			}
		}
		mysqli_close($db);
	}
	else echo("<br>DB not connected<br>");
?>