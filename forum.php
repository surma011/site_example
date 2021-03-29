<?php
	require("main_menu.inc");
	if(f_user_name()=="Гость")header('Location: enter.php');
	require("side_menu.inc");
	require("banner.inc");
	require("php_scripts/forum_script.php");
	require("php_scripts/background_script.php");
	require("basement.inc");
?>