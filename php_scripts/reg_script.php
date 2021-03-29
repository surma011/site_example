<?php
	if(isset($_GET["reg_button"]))
	{
		$login=$_GET['login'];
		$pass=$_GET['pass'];
		$re_pass=$_GET['re_pass'];
		if(($login!=null)&&($pass!=null))
		{
			$pattern='/^([a-zа-я0-9])/is';
			if((strlen($login)>2)&&(strlen($login)<11)&&(strlen($pass)>2)&&(strlen($pass)<31)&&(preg_match($pattern,$login)))
			{
				if($pass==$re_pass)
				{
					if(@$db=mysqli_connect("localhost","user-ks-39","1","user-ks-39"))
					{
						mysqli_query($db,"SET NAMES utf8_general_ci");
						$db->set_charset("utf8_general_ci");
						$res=mysqli_query($db,"SELECT user FROM users");
						$coin=false;
						do
						{
							$row=mysqli_fetch_array($res);
							if($login==$row['user'])$coin=true;
						}
						while(($coin==false)&&($row));
						echo("<br>");
						if($coin==false)
						{
							setcookie("user",$login);
							$login=mysqli_real_escape_string($db,$login);
							$pass=mysqli_real_escape_string($db,$pass);
							mysqli_query($db,"INSERT INTO users (usergroup,user,pass) VALUES ('Users','".$login."','".$pass."')");
							$permitted_chars='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
							$key='';
							for($i=0;$i<30;$i++)
							{
								$random_character=$permitted_chars[mt_rand(0,61)];
								$key.=$random_character;
							}
							mysqli_query($db,"UPDATE users SET auth='".$key."' WHERE user='".$login."'");
							setcookie("key",$key);
							header('Location: private.php');
						}
						else echo("Пользователь с таким логином уже зарегестрирован");
						mysqli_close($db);
					}
					else echo("<br>DB not connected<br>");
				}
				else echo("Пароли не совпадают");
			}
			else echo("Логин или пароль не соответствуют требованиям");
		}
		else echo("<br>Придумйте себе логин и пароль");
	}
?>