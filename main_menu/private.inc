<div class="content">
        <div class="text contenthead">Личный кабинет</div>
		<div class="text contentcenter">Вы вошли как <?php echo(f_user_name());?>
			<form action="private.php" method="GET">
				<input class="button" type="submit" name="exit_button" value="Выход">
				<?php require("php_scripts/exit_script.php");?>
			</form>
			<div class="private_area text contenttext"><?php require("php_scripts/private_script.php");?></div>
		</div>
    </div>