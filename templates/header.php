<div class="row">
	<div id="header_img">
		<div class="span4">
			<img src="http://placehold.it/250x100">
		</div>
		<div class="span8">
			<img src="http://placehold.it/767x100">
		</div>
	</div>
</div>

<div class="navbar navbar_user">
	<div class="navbar-inner">
		<a class="brand" href="index.php">Магазин</a>
		<ul class="nav">
			<!-- <li><a href="#">Мой аккаунт</a></li>
			<li><a href="#">О нас</a></li> -->

			<?php if (isset($_SESSION['login'])): ?>
				<li><a href="basket.php">Корзина</a></li>
				<li><a href="index.php?out=1">Выход</a></li>
			<?php else: ?>
				<li><a href="auth.php">Вход</a></li>
			<?php endif; ?>
			<li><a href="admin/products.php">Админка</a></li>
		</ul>
	</div>
</div>