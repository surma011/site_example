<?php
	$send=false;
	if($_COOKIE['temp']!='+')$send=true;
	if(isset($_COOKIE['temp']))f_temp_clean();
	if($send==true)echo("Ваш отзыв отправлен");
	if(isset($_POST["send_button"]))
	{
		$text=$_POST['feedback'];
		$mail=$_POST['mail'];
		if(($text!=null)&&($mail!=null))
		{
			$pattern='/^([a-z0-9_.-]+)@(([a-z0-9-]+\.)+[a-z]{2,6})$/is';
			if(preg_match($pattern,$mail))
			{
				//mail("surkov.do-36@urtt.ru","Feedback",$text,"From: ".$mail." \r\n");
				if (@$db=mysqli_connect("localhost","user-ks-39","1","user-ks-39"))
				{
					mysqli_query($db,"SET NAMES utf8_general_ci");
					$db->set_charset("utf8_general_ci");
					$text=mysqli_real_escape_string($db,$text);
					$mail=mysqli_real_escape_string($db,$mail);
					$res=mysqli_query($db,"SELECT num FROM feedback");
					$num=0;
					while($row=mysqli_fetch_array($res))$num=$row['num'];
					$num++;
					mysqli_query($db,"INSERT INTO feedback (num,mail,text) VALUES ('".$num."','".$mail."','".$text."')");
					mysqli_close($db);
					echo
					("<script>
						document.cookie='temp=+';
						document.location.href='contacts.php';
					</script>");
				}
				else echo("<br>DB not connected<br>");
			}
			else echo("Адрес почты некорректен");
		}
		else echo("Нужно заполнить все поля");
	}
?>