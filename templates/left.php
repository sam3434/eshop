<div class="span2 product_block">
	<div class="nav nav-list nav_right">
		<li class="nav-header">Категории товаров</li>
		<?php 
		    require_once "extensions/add_get.php";
		    require_once "database/select_tables.php";

			$cats = select_all_categories();
			$cls = "";
			$i = 0;
			$pos = -1;
			while ($row = mysql_fetch_assoc($cats))
			{
				$link = $_SERVER['REQUEST_URI'];
				if (strpos("$link", "index.php")===false)
				{
					$link = "/eshop1/index.php";
				}
				if (($pos=strpos($link, "cat="))!==false)
				{
					
					//str_replace("/cat={0,}&/", "cat={$row['name']}", $link);
					$link = add_get($link, "cat", "{$row['name']}");
				}
				else
				{
					if (strpos($link, "?")!==false)
					{
						$link .= "&";
					}
					else
					{
						$link .= "?";
					}
					$link .= "cat={$row['name']}";
				
				}
				if ($cat==$row['name'])
					$cls = "active";
				if (isset($_GET['id']))
				{
					$ccat = select_category_by_product(intval($_GET['id']));
					if ($ccat['name']==$row['name'])
						$cls = "active";
				}
				echo "<li class='$cls'>
						<a href='$link'>{$row['name']}</a>
					  </li>";
				$cls = "";
				$i++;
			}
		 ?>
	</div>
	
	<a href="" class="btn btn-primary btn-block disabled whats_new">Что нового?</a>
	<?php 
		$query = "select * from $tbl_product order by date_add desc limit 1";
		 $res = mysql_query($query);
		 $row = mysql_fetch_assoc($res);
	 ?>
	<div class="text_product">
		<a href="">
			<?php echo $row['name'] ?>
		</a>
	</div> 
	<?php 
		$src = "http://placehold.it/150x150";
		if (is_file($_SERVER['DOCUMENT_ROOT']."/".$row['image']))
		{
			$src = "/".$row['image'];
		}
	 ?>
	<img src="<?php echo $src; ?>" class="product_image">	
	<div class="product_price">
		<?php 
			echo $row['price']." $";
		 ?>
	</div> 
	<div class="tmp_div">
		
		<?php 
			$add = "<input type='hidden' value='{$row['id']}' />
			<a href='' class='btn btn-success btn-block'>
			<i class='icon-shopping-cart icon-white'></i>
			Добавить в корзину
		</a>";
			if (isset($_SESSION['login']))
				echo $add;
			$href = "/eshop1/product.php?id=".$row['id'];
			echo "<a href='$href' class='btn btn-info btn-block'>";
		 ?>
		
			<i class="icon-info-sign icon-white"></i>
			Инфо о товаре
		</a>
	</div>
</div>