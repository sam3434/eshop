<div id="header">
	<img src="images/logo.gif" alt="" id="logo" />
	<?php 
		echo $_SESSION['login'];
		if (!isset($_SESSION['login'])) 
		{
			$s = <<<link
			<a href="register.php">Регистрация</a> <br>
			<a href="auth.php">Вход</a>
link;
			echo $s;
		}
		else
		{
			echo "<a href='index.php?out=out'>Выход</a>";
		}
	?>
	<div id="basket" class="round5">
		<img src="icons/basket.png" alt="" class="basket_logo" />
		Lorem ipsum dolor sit amet.	<br />
		0 Items
	</div>
</div>