	<div class="content">
        <div class="text contenthead">Обратная связь</div>
		<div class="text contentcenter">Здесь вы можете связаться с нами</div>
		<form action="contacts.php" method="POST">
			<textarea required id=feedback_area class="theme text contentcenter feedback" name="feedback"></textarea><br>
			<input type="text" required name="mail" size=21 placeholder="Ваша почта"><br>
			<input type="submit" name="send_button" value="Отправить">
			<div class="text contentcenter"><?php require("php_scripts/feedback_script.php");?></div>
		</form>
    </div>