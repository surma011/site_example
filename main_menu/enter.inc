	<div class="content">
        <div class="text contenthead">Вход</div>
		<div class="text contentcenter">
		<form action="enter.php" method="GET">
			<input type="text" name="login" size=15 maxlength=10 placeholder="Введите ваш логин" value="">
			<input type="password" name="pass" size=30 maxlength=30 placeholder="Введите ваш пароль"><br>
			<input type="submit" name="enter_button" value="Войти"><br>
			<input type="submit" name="reg_button" value="Регистрация">
			<?php require("php_scripts/enter_script.php");?>
		</form>
		</div>
    </div>