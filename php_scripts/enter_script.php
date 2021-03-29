<?php
	if(isset($_GET["enter_button"]))
	{
		$login=$_GET['login'];
		$pass=$_GET['pass'];
		if(($login!=null)&&($pass!=null))
		{
			if(@$db=mysqli_connect("localhost","user-ks-39","1","user-ks-39"))
			{
				mysqli_query($db,"SET NAMES utf8_general_ci");
				$db->set_charset("utf8_general_ci");
				$res=mysqli_query($db,"SELECT user,pass,auth FROM users");
				$auth=0;
				do
				{
					$row=mysqli_fetch_array($res);
					if(($login==$row['user'])&&($pass==$row['pass']))$auth=1;
				}
				while(($auth==0)&&($row));
				echo("<br>");
				if($auth==1)
				{
					//setcookie("user",$login);
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
				else echo("Неверный логин или пароль");
				mysqli_close($db);
			}
			else echo("<br>DB not connected<br>");
		}
		else echo("<br>Введите свой логин и пароль");
	}
	if(isset($_GET["reg_button"]))header('Location: reg.php');	
?>