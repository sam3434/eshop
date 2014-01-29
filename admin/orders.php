<?php 
    require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/admin/utils/security_mod.php";
	require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/stats/stats.php";
	require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/database/select_tables.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/products/config_product.php";
    $title = "Заголовок страницы";
    $pagename = "Заказы";
    $pag_search = "";
    echo $_GET['categories'];
    $pageinfo = <<<__PAGEINFO
    <strong>Инфо о странице</strong> <br>
    Просмотр списка заказов пользователей <br>
__PAGEINFO;
	require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/admin/utils/top.php";
?> 

</head>
<body>
	<div class="container">
    	<?php
    		require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/admin/utils/navbar.php";
            require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/admin/utils/pagename.php";
        ?>
        <?php 
            require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/admin/utils/users/page_info.php";
         ?>
         <hr>
		<div class="row">
			<div class="span12">
			<?php 

				$num_products = count_orders();
				$per_page = 10;

				$num_pages = ceil($num_products/$per_page);
				$page = isset($_GET['page']) ? $_GET['page'] : 1;
				if ($num_pages<$page) 
				{
					$page = $num_pages;
				}
				$start = abs(($page-1)*$per_page);
				$orders = select_all_orders($start, $per_page);
				
	    		while ($row=mysql_fetch_assoc($orders))
	    		{
	    			if ($row['is_active']==0)
	    			{
	    				$class = "alert-error";
	    				$sel = " удалил из корзины товар ";
	    			}
	    			elseif ($row['is_active']==1)
	    			{
	    				$class = "alert-info";
	    				$sel = " добавил в корзину товар ";
	    			}
	    			elseif ($row['is_active']==2)
	    			{
	    				$class = "alert-success";
	    				$sel = " приобрел товар ";
	    			}
	    			$user = select_user_by_id($row['id_user']);
	    			$product = select_product_by_id($row['id_product']);
	    			echo "<div class='alert $class'><strong>Пользователь ";
	    			echo $user['login']." $sel ";
	    			echo $product['name']." по цене ".$product['price'];
	    			echo "<br>".$row['date_add'];
	    			echo "</strong></div>";
	    		}
	    	 ?>
	    
		</div>
	</div>
	<div class="row" style="margin-bottom:40px;">
            <div class="span8 offset4">
                <?php 
        require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/utils/paginate.php";
         ?>     
            </div>
               
        </div>
       	 
    
</body>
</html>