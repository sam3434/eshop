<?php 
	require_once "config_product.php";
	$num_products = orders_product_count_where_user($cat, $srch);
	$num_pages = ceil($num_products/$per_page_user);
	$page = isset($_GET['page']) ? $_GET['page'] : 1;
	if ($num_pages<$page) 
	{
		$page = $num_pages;
	}
	$start = abs(($page-1)*$per_page_user);
	$res = filter_products_user($start, $per_page_user, $cat, $srch, $psw);
	echo "<div class='row product_line'>";
	$index = 0;
	$href = "/eshop1/product.php?id=";
	while ($row = mysql_fetch_assoc($res))
	{
		$offset = " offset1";
		if (($index++)%3 == 0)
		{
			echo " </div> <hr>	<div class='row product_line'>";
			$offset = " ";
		}
		$prod_name = $row['name'];
		$prod_price = $row['price'];
		if (isset($_SESSION['login'])) {
			$add = "<input type='hidden' value='{$row['id']}' />
				<a href='' class='btn btn-success btn-block basket-btn'>
					<i class='icon-shopping-cart icon-white'></i>
					Добавить в корзину</a>";
		}
		else {
			$add = '';
		}

		$src = "http://placehold.it/150x95";
		if (is_file($_SERVER['DOCUMENT_ROOT']."/".$row['image']))
		{
			$src = "/".$row['image'];
		}

		
	$html=<<<__div
		<div class="span2 $offset product_block">
			<div class="text_product">
				<a href=" $href{$row['id']} ">$prod_name</a>
			</div> 
			<img src="$src" class="product_image">	
			<div class="product_price">
				$prod_price $
			</div> 
			<div class="tmp_div">
				$add
				<a href=" $href{$row['id']} " class="btn btn-info btn-block">
					<i class="icon-info-sign icon-white"></i>
					Инфо о товаре
				</a>
			</div>
		</div>
__div;
		echo $html;
	}
	echo "</div>";
 ?>