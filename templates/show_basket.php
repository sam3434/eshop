<?php 
    session_start();
    require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/config.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/database/delete_tables.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/database/select_tables.php";
    
    if (isset($_POST['delete_id']))
    {
        delete_order($_POST['delete_id']);
    }
	$user_id = $_SESSION['id_user'];
	$prod = select_products_from_basket($user_id);
    $count_products = select_from_basket($user_id, "COUNT(*)");
	$price = select_from_basket($user_id, "SUM(b.price)");
    if ($count_products==0)
    {
        $html=<<<__div
        <h3>
            Корзина пуста
        </h3>        
__div;
        echo $html;
        exit();
    }
    $html=<<<__div
	<h3>
        Всего товаров -  $count_products
        <span class="price">
            $price $
        </span> 
    </h3>
    
    <a href="" class="btn btn-primary make_order">
        Сделать заказ на все товары в корзине
    </a>
    <input type="hidden" value="$user_id" />
    <br> <br>
__div;
	echo $html;
    while ($row = mysql_fetch_assoc($prod)) 
	{
        $cat_arr = select_category_by_product($row['id']);
        $cat = $cat_arr['name'];
        $src = "http://placehold.it/150x95";
        if (is_file($_SERVER['DOCUMENT_ROOT']."/".$row['image']))
        {
            $src = "/".$row['image'];
        }
		$html=<<<__div
		<div class="well">
            <div class="row">
                <div class="span2"> 
                    <img src="$src">    
                </div>
                <div class="span5">
                    <h4>{$row['name']} 
                        <span class="price">
                            {$row['price']} $
                        </span> 
                    </h4>
                    (категория $cat)
                    <br> <br> <br> <br>
                    <a href="#" class="btn btn-danger delete_from_basket">Удалить из корзины</a>
                    <input type="hidden" name="" value="{$row['id_order']}">
                </div>
            </div>
        </div>
__div;
		echo $html;
	}

 ?>