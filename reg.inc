	<div class="content">
        <div class="text contenthead">Регистрация</div>
		<div class="text contentcenter">
		<form action="reg.php" method="GET">
			<input type="text" name="login" size=15 maxlength=10 placeholder="Придумайте логин">
			<input type="password" name="pass" size=30 maxlength=30 placeholder="Придумайте пароль"><br>
			<input type="password" name="re_pass" size=30 maxlength=30 placeholder="Повторите пароль"><br>
			<input type="submit" name="reg_button" value="Зарегестрироваться"><br>
			<?php require("php_scripts/reg_script.php");?>
		</form>
		</div>
		<div class="text"><br>Логин не может быть меньше 3 символов и больше 10.<br>Для логина можно использовать
		русские, латинские буквы и цифры.<br>Пароль не может быть меньше 3 символов и больше 30.<br>Для пароля можно использовать 
		любые символы.
		</div>
    </div>