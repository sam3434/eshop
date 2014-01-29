<?php 
	require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/database/utils.php";
	require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/products/config_product.php";
	//$num_products = orders_count($tbl_product);
	$num_products = orders_product_count_where();
	$num_pages = ceil($num_products/$per_page);
	$page = isset($_GET['page']) ? $_GET['page'] : 1;
	if ($num_pages<$page) 
	{
		$page = $num_pages;
	}
	$start = abs(($page-1)*$per_page);
	$res = filter_products($start, $per_page);
	echo "<div class='row'>";
	echo "<div class='offset1 span10'>";
	echo "<h3>Список товаров ($num_products всего)</h3>";
	while ($row = mysql_fetch_assoc($res)) 
	{
		$category = get_category_by_product($row['id']);
		$chars = chars_of_product($row['id']);
		$src = "http://placehold.it/150x95";
		if (is_file($_SERVER['DOCUMENT_ROOT']."/".$row['image']))
		{
			$src = "/".$row['image'];
		}
		$html=<<<__html
		<div class="well">
			<div class="row">
				<div class="span3">
					<a href="" class="thumbnail">
					<img src="$src" alt="">
					</a>
				</div>
				<div class="span6">
					<h4>{$row['name']} 
						<i class="icon-camera edit_image" style="float:right"></i>
 						<a href="#ModalDeleteProduct"  data-toggle="modal" class="remove_product">
 						<i class="icon-remove" style="float:right"></i>
						</a>
						<i class="icon-edit edit_product" style="float:right"></i>
						<input type="hidden" name="" value="{$row['id']}">
						<span class="price">{$row['price']} $  </span>

					 </h4>
					<span class="label label-info">$category</span>
					<h5>Краткое описание</h5>
					<p>{$row['small_descr']}</p>
					<hr>
					<h5>Список характеристик</h5>
					
					<table class="table table-condensed">
						<thead>
							<tr>
								<th>Характеристика</th>
								<th>Значение</th>
							</tr>
						</thead>
							<tbody>
__html;
		echo $html;
		while ($row_ch = mysql_fetch_assoc($chars))
		{
			echo "<tr>";
			echo "<td>{$row_ch['name']}</td>";
			echo "<td>{$row_ch['value']}</td>";
			echo "</tr>";
		}
		echo "</tbody>";
		echo "</table>";
		$html=<<<__html
		<h5>Полное описание</h5>
		<p>{$row['descr']}</p>
			<hr>
			<h5>Дата добавления</h5>
			<p> {$row['date_add']} </p>   
			</div>
		  </div>
		</div>
__html;
		echo $html;
	}
	echo "</div> </div>";
?>
