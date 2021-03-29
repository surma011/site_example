<?php
	if(isset($_GET["exit_button"]))
	{
		if(@$db=mysqli_connect("localhost","user-ks-39","1","user-ks-39"))
		{
			mysqli_query($db,"SET NAMES utf8_general_ci");
			$db->set_charset("utf8_general_ci");
			mysqli_query($db,"UPDATE users SET auth='' WHERE user='".$_COOKIE["user"]."'");
			setcookie("key",$_SERVER["HTTP_REFERER"],time()-3600);
			//setcookie("user","Гость");
			header('Location: enter.php');
			mysqli_close($db);
		}
		else echo("<br>DB not connected<br>");
	}
?>