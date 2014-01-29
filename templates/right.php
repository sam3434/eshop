<?php if (isset($_SESSION['login'])): ?>

<?php 
	require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/config.php";
	require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/database/select_tables.php";
	$user_id = $_SESSION['id_user'];
	$count_products = select_from_basket($user_id, "COUNT(*)");
	$price = select_from_basket($user_id, "SUM(b.price)");
	if (isset($_SESSION['login'])) :
 ?>
<a href="" class="btn btn-primary btn-block disabled basket">
	Корзина
</a>
<?php echo $count_products; ?> товар(а) в корзине
<hr>
Всего <?php echo ($price!=0) ? $price : 0;  ?> $
<i class="icon-shopping-cart icon-3x basket_icon"></i>
<?php endif; ?>
<?php endif; ?>