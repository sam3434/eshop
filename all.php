Z:/home/localhost/www/eshop1/admin/add_product.php<br><?php 
    require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/admin/utils/security_mod.php";
	require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/stats/stats.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/database/select_tables.php";
    if (isset($_GET['id'])) 
    {
        $pagename = "Изменение товара";
        $button = "Изменить";    
        $pageinfo = <<<__PAGEINFO
    <strong>Изменение товара</strong> <br>
__PAGEINFO;
        $id = intval($_GET['id']);
        $product = select_product_by_id($id);
        $chars = select_chars_by_product($id);
    }
    else
    {
        $pagename = "Добавление товара";
        $button = "Создать";    
        $pageinfo = <<<__PAGEINFO
    <strong>Добавление товара</strong> <br>
__PAGEINFO;
    }
    $title = "Заголовок страницы";
      
	require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/admin/utils/top.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/database/select_tables.php";
?> 
<script src="utils/js/add_product.js" type="text/javascript"></script>
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

         <div class="modal hide" id="ModalDeleteChar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel">Удаление характеристики </h3>
            </div>
            <div class="modal-body">
                <p>Вы уверены что хотите удалить характеристику для этого товара?</p>
            </div>
            <div class="modal-footer">
                <a class="btn" data-dismiss="modal" aria-hidden="true" id="confirm_btn_char">Да</a>
                <a class="btn btn-primary" data-dismiss="modal"  aria-hidden="true">Нет, отменить</a>
            </div>
        </div>

        <div class="modal hide" id="ModalCreateChar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel">Создание характеристики </h3>
            </div>
            <div class="modal-body">
                <p>Наименование характеристики</p>
                <input type="text" name="" id="name_character"> <br>
                <p>Значение характеристики</p>
                <input type="text" name="" id="value_character">
            </div>
            <div class="modal-footer">
                <a class="btn" data-dismiss="modal" aria-hidden="true" id="confirm_btn_crt_char">Создать</a>
                <a class="btn btn-primary" data-dismiss="modal"  aria-hidden="true">Нет, отменить</a>
            </div>
        </div>
        <?php 
            require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/admin/utils/products/form.php";
         ?>
            
    </div>
</body>
</html>Z:/home/localhost/www/eshop1/admin/auth.php<br><?php 
    $title = "Авторизация";
    require_once "stats/stats.php";
    require_once "templates/top.php";
 ?>
 <script src="ajax/js/register.js"></script>
</head>
<body>
	<div class="container">
		<?php 
			require_once "templates/header.php";
		 ?>

    	<div class="row">
    		<?php 
    			require_once "templates/left.php";
    		 ?>
    		<div class="span8">
    			<?php 
    				require_once "templates/info_block.php";
    			 ?>
                <div class="row">
                    <div class="offset2 span6">
                        <?php 
                require_once "users/auth_form.php"
            ?>
                    </div>
                </div>    			
    		</div>
    	</div>
       
	<?php 
		require_once "templates/footer.php";
	 ?>
	</div>
</body>
</html>Z:/home/localhost/www/eshop1/admin/change_image.php<br><?php 
	require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/stats/stats.php";
	if (isset($_FILES['filename']['name']))
	{
		$id = intval($_POST['id']);
		$saveto = $_SERVER['DOCUMENT_ROOT']."/eshop1/images/".$id.".jpg";
		move_uploaded_file($_FILES['filename']['tmp_name'], $saveto);
		$typeok = true;
		switch ($_FILES['filename']['type']) {
			case 'image/gif':
				$src = imagecreatefromgif($saveto);
				break;
			case 'image/jpeg':
			case 'image/pjpeg':
				$src = imagecreatefromjpeg($saveto);
				break;
			case 'image/png':
				$src = imagecreatefrompng($saveto);
				break;
			default:
				$typeok = false;
				break;
		}
		if ($typeok)
		{
			list($w, $h) = getimagesize($saveto);
			$max = 150;
			$tw = $w;
			$th = $h;
			if ($w > $h && $max < $w)
			{
				$th = $max / $w * $h;
				$tw =  $max;
			}
			elseif ($h>$w && $max<$h)
			{
				$tw = $max/$h*$w;
				$th = $max;
			}
			elseif ($max<$w)
			{
				$tw = $th = $max;
			}
			$tmp = imagecreatetruecolor($tw, $th);
			imagecopyresampled($tmp, $src, 0, 0, 0, 0, $tw, $th, $w, $h);
			imageconvolution($tmp, array(
				array(-1, -1, -1),
				array(-1, 16, -1),
				array(-1, -1, -1),
				), 8, 0);
			imagejpeg($tmp, $saveto);
			imagedestroy($tmp);
			imagedestroy($src);
		}
		global $tbl_product;
		//echo $saveto;
		$save = "eshop1/images/".$id.".jpg";
		$query = "update $tbl_product set image='$save' where id=$id";
		mysql_query($query);
		//echo $query.mysql_error();
	}
	
 //    require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/admin/utils/security_mod.php";
	// require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/database/select_tables.php";
 //    require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/products/config_product.php";
    $title = "Заголовок страницы";
    $pagename = "Установить изображение";
    $pag_search = "";
    $pageinfo = <<<__PAGEINFO
    <strong>Установить изображение товару</strong> <br>
    
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

				<div class="well">
					<?php if (!isset($_FILES['filename']['name'])): ?>
					<form action="change_image.php" method="post" enctype="multipart/form-data">
	      				<input type="file" name="filename"><br>  <br>
	      				<input type="hidden" name="id" value="<?php echo isset($_GET['id']) ? $_GET['id'] : -1; ?>">
	      				<input type="submit" value="Загрузить" class="btn btn-primary"><br>
	      			</form>
	      			<?php else: ?>
	      			<h3>Изображение установлено</h3>
	      		<?php endif; ?>
				</div>	
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
</html>Z:/home/localhost/www/eshop1/admin/data.php<br><?php

include 'php-ofc-library/open-flash-chart.php';

$data = array();
$year = array();
for ($i=0; $i < 10; $i++) { 
	$data[] = $i+1;
}

$data[0] = 7;


$year[] = "Пон";
$year[] = "Вторник";
$year[] = "Среда";
$year[] = "Четверг";
$year[] = "Пятница";
$year[] = "Суббота";
$year[] = "Вторник";
$year[] = "Среда";
$year[] = "Четверг";
$year[] = "Пятница";

$chart = new open_flash_chart();

$area = new area();
$area->set_colour( '#5B56B6' );
$area->set_values( $data );
$area->set_key( 'Data', 12 );
$chart->add_element( $area );

$x_labels = new x_axis_labels();
$x_labels->set_steps( 1 );
$x_labels->set_size(15);
//$x_labels->set_vertical();
$x_labels->set_colour( '#000' );
$x_labels->set_labels( $year );

$x = new x_axis();
$x->set_colour( '#A2ACBA' );
$x->set_grid_colour( '#D7E4A3' );
$x->set_offset( false );
$x->set_steps(4);
// Add the X Axis Labels to the X Axis
$x->set_labels( $x_labels );

$chart->set_x_axis( $x );



$y = new y_axis();
$y->set_range( 0, 150, 30 );
$chart->add_y_axis( $y );

echo $chart->toPrettyString();


?>
Z:/home/localhost/www/eshop1/admin/data_30.php<br><?php

include 'php-ofc-library/open-flash-chart.php';
require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/stats/stats.php";
$date = " where DATE_SUB(CURDATE(), INTERVAL 30 DAY)<=begin_date";
require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/admin/utils/stats/pages_count.php";

$title = new title( 'Посещаемость страниц за 30 дней' );
$title->set_style('color: #00000; font-size: 20px');
$pies = array();
foreach ($arr as $row) 
{
    $pies[] = new pie_value(intval($row['count(p.address)']), "");
    $pies[count($pies)-1]->set_label($row['address'], null, "17");

}
$pie = new pie();
$pie->alpha(0.5)
    ->add_animation( new pie_fade() )
    ->start_angle( 0 )
    ->tooltip( 'Radius: #radius#' )
    ->colours(array("#d01f3c","#356aa0","#C79810", "#1a5c69"))
    ->values( $pies )
    ->radius(250);
$pie->set_tooltip( '#val# of #total#<br>#percent# of 100%' );
$pie->set_gradient_fill();
$chart = new open_flash_chart();
$chart->set_title( $title );
$chart->add_element( $pie );
$chart->set_bg_colour('#ffffff');

echo $chart->toPrettyString();Z:/home/localhost/www/eshop1/admin/data_7.php<br><?php

include 'php-ofc-library/open-flash-chart.php';
require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/stats/stats.php";
 $date = " where DATE_SUB(CURDATE(), INTERVAL 7 DAY)<=begin_date";
 require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/admin/utils/stats/pages_count.php";

$title = new title( 'Посещаемость страниц за 7 дней' );
$title->set_style('color: #00000; font-size: 20px');
$pies = array();
foreach ($arr as $row) 
{
    $pies[] = new pie_value(intval($row['count(p.address)']), "");
    $pies[count($pies)-1]->set_label($row['address'], null, "17");

}
$pie = new pie();
$pie->alpha(0.5)
    ->add_animation( new pie_fade() )
    ->start_angle( 0 )
    ->tooltip( 'Radius: #radius#' )
    ->colours(array("#d01f3c","#356aa0","#C79810", "#1a5c69"))
    ->values( $pies )
    ->radius(250);
$pie->set_tooltip( '#val# of #total#<br>#percent# of 100%' );
$pie->set_gradient_fill();
$chart = new open_flash_chart();
$chart->set_title( $title );
$chart->add_element( $pie );
$chart->set_bg_colour('#ffffff');

echo $chart->toPrettyString();Z:/home/localhost/www/eshop1/admin/data_br.php<br><?php

include 'php-ofc-library/open-flash-chart.php';
require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/stats/stats.php";
require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/admin/utils/stats/br_count.php";

$title = new title( 'Самые популярные операционные системы' );
$title->set_style('color: #00000; font-size: 20px');
$pies = array();
foreach ($arr as $row) 
{
    $pies[] = new pie_value(intval($row['count(o.name)']), "");
    $pies[count($pies)-1]->set_label($row['name'], null, "17");

}
$pie = new pie();
$pie->alpha(0.5)
    ->add_animation( new pie_fade() )
    ->start_angle( 0 )
    ->tooltip( 'Radius: #radius#' )
    ->colours(array("#d01f3c","#356aa0","#C79810", "#1a5c69"))
    ->values( $pies )
    ->radius(250);
$pie->set_tooltip( '#val# of #total#<br>#percent# of 100%' );
$pie->set_gradient_fill();
$chart = new open_flash_chart();
$chart->set_title( $title );
$chart->add_element( $pie );
$chart->set_bg_colour('#ffffff');

echo $chart->toPrettyString();Z:/home/localhost/www/eshop1/admin/data_cat.php<br><?php

include 'php-ofc-library/open-flash-chart.php';
require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/stats/stats.php";
require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/admin/utils/stats/cat_count.php";

$title = new title( 'Самые популярные категории по просмотрам' );
$title->set_style('color: #00000; font-size: 20px');
$pies = array();
foreach ($arr as $row) 
{
    $pies[] = new pie_value(intval($row['count(p.name)']), "");
    $pies[count($pies)-1]->set_label($row['name'], null, "17");

}
$pie = new pie();
$pie->alpha(0.5)
    ->add_animation( new pie_fade() )
    ->start_angle( 0 )
    ->tooltip( 'Radius: #radius#' )
    ->colours(array("#d01f3c","#356aa0","#C79810", "#1a5c69"))
    ->values( $pies )
    ->radius(250);
$pie->set_tooltip( '#val# of #total#<br>#percent# of 100%' );
$pie->set_gradient_fill();
$chart = new open_flash_chart();
$chart->set_title( $title );
$chart->add_element( $pie );
$chart->set_bg_colour('#ffffff');

echo $chart->toPrettyString();Z:/home/localhost/www/eshop1/admin/data_hits.php<br><?php

include 'php-ofc-library/open-flash-chart.php';
require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/stats/stats.php";
require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/admin/utils/stats/hits_order_count.php";

$data = array();
$year = array();
$max = -1;
for ($i=0; $i < count($arr); $i++) { 
	$data[] = intval($arr[$i][1]);
	$year[] = $arr[$i][0];
	if (intval($arr[$i][1])>$max)
		$max = intval($arr[$i][1]);
}

$chart = new open_flash_chart();

$area = new area();
$area->set_colour( '#5B56B6' );
$area->set_values( $data );
$area->set_key( 'Количество хитов', 16 );
$chart->add_element( $area );

$x_labels = new x_axis_labels();
$x_labels->set_steps( 1 );
$x_labels->set_size(15);
$x_labels->set_vertical();
$x_labels->set_colour( '#000' );
$x_labels->set_labels( $year );

$x = new x_axis();
$x->set_colour( '#000' );
$x->set_grid_colour( '#dddddd' );
$x->set_offset( false );
$x->set_steps(4);
// Add the X Axis Labels to the X Axis
$x->set_labels( $x_labels );

$chart->set_x_axis( $x );



$y = new y_axis();
$y->set_grid_colour( '#dddddd' );
$y->set_colour( '#000' );
$step = intval($max/30);
$y->set_range( 0, $max+$step, $step );
$chart->add_y_axis( $y );
$chart->set_bg_colour('#ffffff');
echo $chart->toPrettyString();

?>
Z:/home/localhost/www/eshop1/admin/data_os.php<br><?php

include 'php-ofc-library/open-flash-chart.php';
require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/stats/stats.php";
require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/admin/utils/stats/os_count.php";

$title = new title( 'Самые популярные операционные системы' );
$title->set_style('color: #00000; font-size: 20px');
$pies = array();
foreach ($arr as $row) 
{
    $pies[] = new pie_value(intval($row['count(o.name)']), "");
    $pies[count($pies)-1]->set_label($row['name'], null, "17");

}
$pie = new pie();
$pie->alpha(0.5)
    ->add_animation( new pie_fade() )
    ->start_angle( 0 )
    ->tooltip( 'Radius: #radius#' )
    ->colours(array("#d01f3c","#356aa0","#C79810", "#1a5c69"))
    ->values( $pies )
    ->radius(250);
$pie->set_tooltip( '#val# of #total#<br>#percent# of 100%' );
$pie->set_gradient_fill();
$chart = new open_flash_chart();
$chart->set_title( $title );
$chart->add_element( $pie );
$chart->set_bg_colour('#ffffff');

echo $chart->toPrettyString();Z:/home/localhost/www/eshop1/admin/data_products.php<br><?php

include 'php-ofc-library/open-flash-chart.php';
require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/stats/stats.php";
require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/admin/utils/stats/products_count.php";

$title = new title( 'Самые популярные товары по просмотрам' );
$title->set_style('color: #00000; font-size: 20px');
$pies = array();
foreach ($arr as $row) 
{
    $pies[] = new pie_value(intval($row['count(p.name)']), "");
    $pies[count($pies)-1]->set_label($row['name'], null, "17");

}
$pie = new pie();
$pie->alpha(0.5)
    ->add_animation( new pie_fade() )
    ->start_angle( 0 )
    ->tooltip( 'Radius: #radius#' )
    ->colours(array("#d01f3c","#356aa0","#C79810", "#1a5c69"))
    ->values( $pies )
    ->radius(250);
$pie->set_tooltip( '#val# of #total#<br>#percent# of 100%' );
$pie->set_gradient_fill();
$chart = new open_flash_chart();
$chart->set_title( $title );
$chart->add_element( $pie );
$chart->set_bg_colour('#ffffff');

echo $chart->toPrettyString();Z:/home/localhost/www/eshop1/admin/data_today.php<br><?php

include 'php-ofc-library/open-flash-chart.php';
require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/stats/stats.php";
$date = " where DATE(begin_date) = DATE(NOW())";
require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/admin/utils/stats/pages_count.php";

$title = new title( 'Посещаемость страниц сегодня' );
$title->set_style('color: #00000; font-size: 20px');
$pies = array();
foreach ($arr as $row) 
{
    $pies[] = new pie_value(intval($row['count(p.address)']), "");
    $pies[count($pies)-1]->set_label($row['address'], null, "17");

}
$pie = new pie();
$pie->alpha(0.5)
    ->add_animation( new pie_fade() )
    ->start_angle( 0 )
    ->tooltip( 'Radius: #radius#' )
    ->colours(array("#d01f3c","#356aa0","#C79810", "#1a5c69"))
    ->values( $pies )
    ->radius(250);
$pie->set_tooltip( '#val# of #total#<br>#percent# of 100%' );
$pie->set_gradient_fill();
$chart = new open_flash_chart();
$chart->set_title( $title );
$chart->add_element( $pie );
$chart->set_bg_colour('#ffffff');

echo $chart->toPrettyString();Z:/home/localhost/www/eshop1/admin/data_yest.php<br><?php

include 'php-ofc-library/open-flash-chart.php';
require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/stats/stats.php";
$date = " where date(begin_date) = DATE_SUB(CURDATE(), INTERVAL 1 DAY)";
require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/admin/utils/stats/pages_count.php";

$title = new title( 'Посещаемость страниц вчера' );
$title->set_style('color: #00000; font-size: 20px');
$pies = array();
foreach ($arr as $row) 
{
    $pies[] = new pie_value(intval($row['count(p.address)']), "");
    $pies[count($pies)-1]->set_label($row['address'], null, "17");

}
$pie = new pie();
$pie->alpha(0.5)
    ->add_animation( new pie_fade() )
    ->start_angle( 0 )
    ->tooltip( 'Radius: #radius#' )
    ->colours(array("#d01f3c","#356aa0","#C79810", "#1a5c69"))
    ->values( $pies )
    ->radius(250);
$pie->set_tooltip( '#val# of #total#<br>#percent# of 100%' );
$pie->set_gradient_fill();
$chart = new open_flash_chart();
$chart->set_title( $title );
$chart->add_element( $pie );
$chart->set_bg_colour('#ffffff');

echo $chart->toPrettyString();Z:/home/localhost/www/eshop1/admin/index.php<br><?php 
    require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/admin/utils/security_mod.php";
	require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/stats/stats.php";
    $title = "Заголовок страницы";
    $pagename = "Главная";
    $pageinfo = "Описание страницы";
	require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/admin/utils/top.php";
?> 

</head>
<body>
	<div class="container">
    	<?php
    		require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/admin/utils/navbar.php";
            require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/utils/paginate.php";
            require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/admin/utils/pagename.php";
        ?>

    </div>
</body>
</html>Z:/home/localhost/www/eshop1/admin/orders.php<br><?php 
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
</html>Z:/home/localhost/www/eshop1/admin/products.php<br><?php 
    require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/admin/utils/security_mod.php";
	require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/stats/stats.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/products/config_product.php";
    $title = "Заголовок страницы";
    $pagename = "Товары";
    $pag_search = "";
    echo $_GET['categories'];
    $pageinfo = <<<__PAGEINFO
    <strong>Инфо о странице</strong> <br>
    Просмотр списка товаров с возможностью фильтрации по разным полям <br>
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

         <div class="modal hide" id="ModalCreateCategory" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel">Создание категории </h3>
            </div>
            <div class="modal-body">
                <div class="control-group">
                    <label for="" class="control-label">Наименование категории</label>
                    <div class="controls">
                        <input type="text" name="" id="name_category" placeholder="Наименование">
                    </div>
                </div>
                <div class="control-group">
                    <label for="" class="control-label">Описание категории</label>
                    <div class="controls">
                        <textarea name="" id="desc_category" cols="60" rows="7" style='width:300px' maxlength="300"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a class="btn" id="confirm_btn_crt_category">Создать</a>
                <a class="btn btn-primary" data-dismiss="modal"  aria-hidden="true">Нет, отменить</a>
            </div>
        </div>

        <div class="modal hide" id="ModalDeleteProduct" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel">Действительно хотите удалить этот товар?</h3>
            </div>
            <div class="modal-body">
                <p>Удаление товара</p>
            </div>
            <div class="modal-footer">
                <a class="btn" id="confirm_btn_del_prod">Удалить</a>
                <a class="btn btn-primary" data-dismiss="modal"  aria-hidden="true">Нет, отменить</a>
            </div>
        </div>

        
        <div class="row" id="products">
            <?php 
                require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/admin/utils/products/show_filters.php";
             ?>
        </div>
        <hr>
        <div id="show_products">
        <?php 
            require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/admin/utils/products/show_products.php"; 
         ?>
        </div>        
        <div class="row">
        <div class="row" style="margin-bottom:40px;">
            <div class="span8 offset4">
                <?php 
        require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/utils/paginate.php";
         ?>     
            </div>
               
        </div>
    </div>
    
</body>
</html>Z:/home/localhost/www/eshop1/admin/stats.php<br><?php 
/*
Страница 1017 php 2
табличка
count.php
utils.hits.php
*/

 ?>
<?php 
    session_start();
    require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/admin/utils/security_mod.php";
	require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/stats/stats.php";
    $title = "Статистика";
    $pagename = "Статистика";
    $pag_search = "";
    echo $_GET['categories'];
    $pageinfo = <<<__PAGEINFO
    <strong>Инфо о странице</strong> <br>
    Просмотр статистики <br>
__PAGEINFO;
	require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/admin/utils/top.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/admin/php-ofc-library/open-flash-chart-object.php";
?> 

<script type="text/javascript" src="js/swfobject.js"></script>
<script type="text/javascript">
    swfobject.embedSWF("open-flash-chart.swf", "sed", "1150", "650", "9.0.0", "expressInstall.swf", {"data-file":"data_today.php"} );
    swfobject.embedSWF("open-flash-chart.swf", "sed2", "1150", "650", "9.0.0", "expressInstall.swf", {"data-file":"data_yest.php"} );
    swfobject.embedSWF("open-flash-chart.swf", "sed3", "1150", "650", "9.0.0", "expressInstall.swf", {"data-file":"data_7.php"} );
    swfobject.embedSWF("open-flash-chart.swf", "sed4", "1150", "650", "9.0.0", "expressInstall.swf", {"data-file":"data_30.php"} );
    swfobject.embedSWF("open-flash-chart.swf", "sed5", "1150", "650", "9.0.0", "expressInstall.swf", {"data-file":"data_all.php"} );
    swfobject.embedSWF("open-flash-chart.swf", "sed6", "1150", "650", "9.0.0", "expressInstall.swf", {"data-file":"data_products.php"} );
    swfobject.embedSWF("open-flash-chart.swf", "sed7", "1150", "650", "9.0.0", "expressInstall.swf", {"data-file":"data_os.php"} );
    swfobject.embedSWF("open-flash-chart.swf", "sed8", "1150", "650", "9.0.0", "expressInstall.swf", {"data-file":"data_cat.php"} );
    swfobject.embedSWF("open-flash-chart.swf", "sed9", "1150", "650", "9.0.0", "expressInstall.swf", {"data-file":"data_hits.php"} );
    swfobject.embedSWF("open-flash-chart.swf", "sed10", "1150", "650", "9.0.0", "expressInstall.swf", {"data-file":"data_br.php"} );
    //swfobject.embedSWF("open-flash-chart.swf", "sed2", "1150", "650", "9.0.0", "expressInstall.swf", {"data-file":"data_pages.php"} );
    //swfobject.embedSWF("open-flash-chart.swf", "sed", "950", "400", "9.0.0", "expressInstall.swf", {"data-file":"data.php"} );
</script>

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
            <ul class="nav nav-tabs" id="myTab">
                <li class="active"><a href="#hosts"  data-toggle="tab">Хиты и хосты</a></li>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        Посещаемость страниц 
                        <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a data-toggle="tab" href="#pages_today">
                            Сегодня
                            </a>
                        </li>
                        <li>
                            <a data-toggle="tab" href="#pages_yest">
                            Вчера
                            </a>
                        </li>
                        <li><a data-toggle="tab" href="#pages_7">
                            За 7 дней
                            </a>
                        </li>
                        <li>
                            <a data-toggle="tab" href="#pages_30">
                            За 30 дней
                            </a>
                        </li>
                        <li>
                            <a data-toggle="tab" href="#pages_all">
                            За все время
                            </a>
                        </li>
                    </ul>
                </li>
                <li><a href="#products"  data-toggle="tab">Продукты</a></li>
                <li><a href="#os"  data-toggle="tab">Операционные системы</a></li>
                <li><a href="#br"  data-toggle="tab">Браузеры</a></li>
                <li><a href="#cat"  data-toggle="tab">Категории</a></li>
                <li><a href="#hits"  data-toggle="tab">Месячный отчет по хитам</a></li>
            </ul>
     
        <div class="tab-content">
            <div class="tab-pane active" id="hosts">
                <?php 
                    require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/admin/utils/stats/hits.php";
                ?>                
            </div>
            <div class="tab-pane" id="profile">
                <!-- <div id="sed"></div> -->
                <?php 
                    //open_flash_chart_object( 300, 300, $_SERVER['SERVER_NAME'] .'/eshop1/admin/utils/stats/data_pages.php' );
                 ?>
            </div>
            <div class="tab-pane" id="pages_today">
                <?php 
                    $date = " where DATE(begin_date) = DATE(NOW())";
                    require $_SERVER['DOCUMENT_ROOT']."/eshop1/admin/utils/stats/pages.php";
                ?>  
                <div id="sed"></div>

            </div>
            <div class="tab-pane" id="pages_yest">
                <?php 
                    $date = " where date(begin_date) = DATE_SUB(CURDATE(), INTERVAL 1 DAY)";
                    require $_SERVER['DOCUMENT_ROOT']."/eshop1/admin/utils/stats/pages.php";
                ?>  
                <div id="sed2"></div>
            </div>
            <div class="tab-pane" id="pages_7">
                <?php 
                    $date = " where DATE_SUB(CURDATE(), INTERVAL 7 DAY)<=begin_date";
                    require $_SERVER['DOCUMENT_ROOT']."/eshop1/admin/utils/stats/pages.php";
                ?>  
                <div id="sed3"></div>
            </div>
            <div class="tab-pane" id="pages_30">
                <?php 
                    $date = " where DATE_SUB(CURDATE(), INTERVAL 30 DAY)<=begin_date";
                    require $_SERVER['DOCUMENT_ROOT']."/eshop1/admin/utils/stats/pages.php";
                ?>  
                <div id="sed4"></div>
            </div>
            <div class="tab-pane" id="pages_all">
                <?php 
                    $date = "";
                    require $_SERVER['DOCUMENT_ROOT']."/eshop1/admin/utils/stats/pages.php";
                ?>  
                <div id="sed5"></div>
            </div>
            <div class="tab-pane" id="products">
                <?php 
                    require $_SERVER['DOCUMENT_ROOT']."/eshop1/admin/utils/stats/products.php";
                 ?>
                 <div id="sed6"></div>
            </div>
            <div class="tab-pane" id="os">
                <?php 
                    require $_SERVER['DOCUMENT_ROOT']."/eshop1/admin/utils/stats/os.php";
                 ?>
                 <div id="sed7"></div>
            </div>
            <div class="tab-pane" id="br">
                <?php 
                    require $_SERVER['DOCUMENT_ROOT']."/eshop1/admin/utils/stats/br.php";
                 ?>
                 <div id="sed10"></div>
            </div>
            <div class="tab-pane" id="cat">
                <?php 
                    require $_SERVER['DOCUMENT_ROOT']."/eshop1/admin/utils/stats/cat.php";
                 ?>
                 <div id="sed8"></div>
            </div>
            <div class="tab-pane" id="hits">
                <?php 
                    require $_SERVER['DOCUMENT_ROOT']."/eshop1/admin/utils/stats/hits_order.php";
                 ?>
                 
            </div>

        </div>

    </div>
</body>
</html>
Z:/home/localhost/www/eshop1/admin/users.php<br><?php 
    require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/admin/utils/security_mod.php";
	require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/stats/stats.php";
    $title = "Заголовок страницы";
    $pagename = "Пользователи";
    $pageinfo = <<<__PAGEINFO
    <strong>Инфо о странице</strong> <br>
    Просмотр списка пользователей с возможностью фильтрации по разным полям <br>
    Список доступных действий: <br>
    &nbsp;&nbsp; <i class="icon-edit"></i> - изменение информации о пользователе <br>
    &nbsp;&nbsp;<i class="icon-info-sign"></i> - детальная информация о пользователе <br>
    &nbsp;&nbsp;<i class="icon-remove"></i> - заблокировать пользователя <br>
    &nbsp;&nbsp;<i class="icon-plus"></i> - разблокировать пользователя
    <br> TODO - сортировка по полям <br> поиск по найти <br> изменение данных(возможно, в блоке информация о польозователе)
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
        <!-- 
        МОДАЛЬНОЕ ОКНО
         -->
         <!-- <a href="#myModal" role="button" class="btn" data-toggle="modal">Delete user</a> -->
        <div class="modal hide" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel">Delete user? </h3>
            </div>
            <div class="modal-body">
                <p>Are you sure that you want delete this user?</p>
            </div>
            <div class="modal-footer">
                <a class="btn" data-dismiss="modal" aria-hidden="true" id="confirm_btn">Да</a>
                <a class="btn btn-primary" data-dismiss="modal"  aria-hidden="true">Нет, отменить</a>
            </div>
        </div>
         <!-- 
        /МОДАЛЬНОЕ ОКНО
         -->

       
        <?php 
            require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/admin/utils/users/page_info.php";
         ?>
        <!-- 
        ИНФОРМАЦИЯ О ПОЛЬЗОВАТЕЛЕ (И ФИЛЬТРЫ)
         -->
        <div class="row">
            <div class="span7" id="info_users">
                <?php 
                    require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/admin/utils/users/info_users.php";
                 ?>
            </div>

            
            <?php 
                require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/admin/utils/users/show_filters.php";
             ?>
        </div>
        <hr>
        <!-- 
        ТАБЛИЦА ПОЛЬЗОВАТЕЛЕЙ
         -->
        <div class="row">
            <div class="span12">
                <div id="show_users">
                <?php 
                    require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/admin/utils/users/show_users.php";
                 ?>
                </div>
            </div>
        </div>
        <div class="row" style="margin-bottom:40px;">
            <div class="span8 offset4">
                <?php 
        require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/utils/paginate.php";
         ?>     
            </div>
               
        </div>
    </div>

</body>
</html>Z:/home/localhost/www/eshop1/admin/utils/bottom.php<br>0Z:/home/localhost/www/eshop1/admin/utils/index2.php<br><?php 
	require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/stats/stats.php";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>Bootstrap</title>

	<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">

	<script src="http://code.jquery.com/jquery-latest.js"></script>
	<script src="bootstrap/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="bootstrap/js/bootstrap-dropdown.js"></script>
	<link rel="stylesheet" href="../css/style.css">
	<script type="text/javascript">  
        $(document).ready(function () {  
            $('.dropdown-toggle').dropdown();  
        });  
   </script>  

</head>
<body>
	<div class="container">
    	<div class="navbar navbar-inverse">
	    	<div class="navbar-inner">
	    		<a class="brand" href="#">Админка</a>
	    		<ul class="nav">
	    			<li class="active"><a href="#">Главная</a></li>
	    			<li><a href="#">Товары</a></li>
	    			<li><a href="#">Пользователи</a></li>
	    			<li class="divider-vertical"></li>
	    			<li><a href="#">Статистика</a></li>
	    			<li class="dropdown">
			    		<a href="" class="dropdown-toggle" data-toggle="dropdown">
			    			Добавить<b class="caret"></b>
			    		</a>
			    		<ul class="dropdown-menu">
			    			<li>
			    				<a href="">Пользователей</a>
			    			</li>
			    			<li>
			    				<a href="">Товары</a>
			    			</li>
			    			<li class="divider"></li>
			    			<li>
			    				<a href="">Зависимости</a>
			    			</li>
			    		</ul>
			    	</li>
	    		</ul>
	    	</div>
    	</div>
    	<div class="row">
    		<div class="span10 offset1">
    			<ul class="breadcrumb">
			    	<li><a href="#">Главная</a> <span class="divider">/</span></li>
			    	<li><a href="#">Библиотека</a> <span class="divider">/</span></li>
			    	<li class="active">Данные</li>
			    </ul>		
    		</div>
    	</div>
    </div>
</body>
</html>Z:/home/localhost/www/eshop1/admin/utils/js/add_product.js<br>jQuery(document).ready(function($) {
	$('ul.nav-list li>a').on('click', function(event) {
		event.preventDefault();
		$("ul.nav-list li.active").removeClass("active");
		$(this).parent().addClass("active");
		
	});

});Z:/home/localhost/www/eshop1/admin/utils/js/navbar.js<br>jQuery(document).ready(function($) {
	var pagename = $('#pagename').html();
    $('.nav a').filter(function(index) {
        if ($.trim(this.innerHTML)==$.trim(pagename))
    	{
    		return true;
    	}
    }).parent().addClass('active');
});Z:/home/localhost/www/eshop1/admin/utils/js/search_paginate.js<br>function is_int(n)
{
    return n%1 == 0;
}

function search_paginate() 
{
    var search_link_html = $(this).html();
    var page="";
    if (is_int(search_link_html))
    {
        page = "page="+search_link_html;
    }
    if (search_link_html=="...")
    {
        var tmp = $(this).attr("href");
        var page = tmp.substring(tmp.indexOf("=")+1, tmp.length);
        page = "page="+page;
    }        
    var ref = location.href;
    if (ref.indexOf("page=")===-1)
    {
        if (ref.indexOf("?")!==-1)
        {
            ref += "&";
        }
        else
        {
            ref += "?";
        }
        ref += "page=1";
    }

    var arr = ref.split("page=");
    if (arr.length==1)
    {
        location.href = ref+"?"+page;
    }
    else
    {
        var index_ask;
        if ((index_ask=arr[1].indexOf("&"))!==-1)
        {
            var substr = arr[1].substring(index_ask, arr[1].length);
            location.href = arr[0]+page+substr;
        }
        else
        {
            location.href = arr[0]+page;
        }
    }
    return false;
}Z:/home/localhost/www/eshop1/admin/utils/js/top.js<br>function is_int(n)
{
    return n%1 == 0;
}

function get_parametr_from_url(param)
{
    var query = window.location.search.substring(1);
    var vars = query.split("&");
    for (var i = 0; i < vars.length; i++) {
        var pair = vars[i].split("=");
        if (pair[0]==param)
            return pair[1];
    };
    return -1;
}

$(document).ready(function () {  
    $('.dropdown-toggle').dropdown();

    $(document).on('dblclick', '#characters tr td:nth-child(2)', function(event) {
        event.preventDefault();
        if ($(this).prev().html()=="")
        {
            return false;
        }
        text = $(this).html();
        $(this).html('<input type="text" name="" id="">');
        $input = $(this).find("input");
        $input.val(text);
        $input.blur(function(){
            $(this).parent().html($input.val());
        });
        $input.focus();        
        // Act on the event
    });
   
    $(document).on('click', '#confirm_btn_char', function(event) {
        event.preventDefault();
        $removed_icon.parent().parent().parent().hide('400', function(){
            $(this).remove();
        });
    });

    $(document).on('click', '#confirm_btn_crt_char', function(event) {
        var name = $('#name_character').val();
        var value = $('#value_character').val();
        $('#tr_insert').before("<tr><td>"+name+"</td><td>"+value+"</td><td><a href='#ModalDeleteChar' data-toggle='modal'><i class='icon-remove remove_char'></i></a></td></tr>");
        // $('i.icon-remove').click(function(event) {
        //     $removed_icon = $(this);
        // });
    });

    $(document).on('click', 'i.remove_char', function(event) {
        event.preventDefault();
        $removed_icon = $(this);
    });

    $('#create_product').submit(function(event) {
        var name = $('#name').val();
        var small_pic = $('#small_pic').val();
        var big_pic = $('#big_pic').val();
        var price = $('#price').val();
        var short_desc = $('#short_desc').val();
        var long_desc = $('#long_desc').val();
        var trs_length = $('#characters tr').length;
        var mode;
        var id = get_parametr_from_url("id");
        if ($.trim($('#main_button').html())=="Изменить")
        {
            mode = "edit";
        }
        else
        {
            mode = "create";
        }
        var chars = {};
        $('#characters tr').each(function(index, val) {
            if ((index!=0) && (index!=trs_length-1))
            {
                var childs = $(val).children();
                chars[$(childs[0]).html()] = $(childs[1]).html();
            } 
        });
        var category_id = $('ul.nav-list li.active a').next().val();
        $.post("utils/products/prod_ajax.php", {"chars":chars, name : name,
            small_pic:small_pic, big_pic:big_pic, price:price, 
            short_desc:short_desc, long_desc:long_desc, category_id:category_id, mode:mode, id:id},{},"json")
        .done(
            function(data) {
                var array = ["name", "price"];
                var $first_error;
                for (var i in array)
                {
                    if (data[array[i]])
                    {
                        $first_error = $first_error||$("#"+array[i]);
                        $("#"+array[i]).parent().parent().addClass("error");
                        $("#"+array[i]).after("<span class='help-inline'>"+data[array[i]]+"</span>")
                    }
                    else
                    {
                           
                    }   
                }
                if (data['href']) 
                {
                    window.location.href = data['href'];
                }
                else
                {
                    $("html, body").animate({scrollTop: $first_error.offset().top-10}, 300);
                }
        })
        .fail(
            function(){
                //alert("Извините, ошибка. Внимательно просмотрите все поля")
                window.location.href = "products.php";
            }
        );
        return false;
    });

    $(document).on('click', '#confirm_btn_crt_category', function(event) {
        event.preventDefault();
        var name_category = $("#name_category").val();
        var desc_category = $("#desc_category").val();      
        $.post('utils/products/create_category.php', {name_category: name_category,
        desc_category : desc_category}, function(data, textStatus, xhr) {
            alert(data["err"])
            var array = ["name_category", "desc_category"];
            for (var i in array)
            {
                if (data[array[i]])
                {
                    $("#"+array[i]).parent().parent().addClass("error");
                    $("#"+array[i]).after("<span class='help-inline'>"+data[array[i]]+"</span>")
                }
            }
        }, "json");
        $('#ModalCreateCategory').modal("hide");
        return false;
    });

    $(document).on('click', '#confirm_btn_del_prod', function(event) {
        //var delete_id = $(this).next().val();
        $.post('utils/products/delete_product.php', {delete_id: delete_id}, 
            function(data, textStatus, xhr) {
                window.location.href = "products.php";
        });
        
    });    

    $(document).on('click', 'a.remove_product', function(event) {
        delete_id = $(this).next().next().val();
    });

    $(document).on('click', 'i.edit_product', function(event) {
        edit_id = $(this).next().val();
        window.location.href = "add_product.php?id="+edit_id;
    });

    $(document).on('click', 'i.edit_image', function(event) {
        edit_id = $(this).next().next().next().val();
        window.location.href = "change_image.php?id="+edit_id;
    });

    function search_product(event)
    {
        var search_date_added = $('#date_added').val();
        var search_categories = $.trim($('#categories option:selected').text());
        var search_price = $('#price').val();
        var search_sorting = $('#sorting').val();
        page = "page=1";
        var str;
        if ((index = location.href.indexOf("?"))!=-1)
        {
            str = location.href.substring(0, index+1);
        }
        else
        {
            str = location.href+"?";
        }
        location.href = str+page+(page=="" ? "" : "&")+"search_categories="+search_categories+"&search_date_added="+search_date_added
        +"&search_price="+search_price+"&search_sorting="+search_sorting;
        return false;
    }

    $(document).on('click', '#search', search_product);
    $(document).on('click', 'a.paginate', search_paginate);    
}); 


Z:/home/localhost/www/eshop1/admin/utils/navbar.php<br><div class="navbar navbar-inverse">
	    	<div class="navbar-inner">
	    		<a class="brand" href="/eshop1/index.php">Магазин</a>
	    		<ul class="nav">
	    			<!-- <li><a href="index.php">Главная</a></li> -->
	    			<li><a href="products.php">Товары</a></li>
	    			<li><a href="users.php">Пользователи</a></li>
	    			<li><a href="orders.php">Заказы</a></li>
	    			<!-- <li class="divider-vertical"></li> -->
	    			<li><a href="stats.php">Статистика</a></li>
	    			<!-- <li class="dropdown">
			    		<a href="" class="dropdown-toggle" data-toggle="dropdown">
			    			Добавить<b class="caret"></b>
			    		</a>
			    		<ul class="dropdown-menu">
			    			<li>
			    				<a href="">Пользователей</a>
			    			</li>
			    			<li>
			    				<a href="">Товар</a>
			    			</li>
			    			<li class="divider"></li>
			    			<li>
			    				<a href="">Зависимости</a>
			    			</li>
			    		</ul>
			    	</li> -->
	    		</ul>
	    	</div>
    	</div>Z:/home/localhost/www/eshop1/admin/utils/pagename.php<br><h1 id="pagename">
    <?php 
        echo $pagename;
    ?>
</h1>Z:/home/localhost/www/eshop1/admin/utils/products/br_count.php<br>br_count.phpZ:/home/localhost/www/eshop1/admin/utils/products/clear_session.php<br><?php 
	echo "string";
	if (isset($_POST['clear']))
	{
		//session_start();
		session_unset();
		//session_destroy();
	}
 ?>Z:/home/localhost/www/eshop1/admin/utils/products/correct_fields.php<br><?php 
	function correct_name($name)
	{
		global $errors;		
		//$errors['name'] = "asd"; 
		return true;
	}

	function correct_price($price)
	{
		global $errors;
		//$errors['price'] = "asd";		 
		return true;
	}

	function correct_chars($name, $value)
	{
		return true;
	}

	function correct_name_category($name_category)
	{
		global $errors;
		//$errors['name_category'] = "asd";
		return true;
	}
	function correct_desc_category($desc_category)
	{
		return true;
	}

 ?>Z:/home/localhost/www/eshop1/admin/utils/products/create_category.php<br><?php 
	require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/users/config_user.php";
	require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/admin/utils/products/correct_fields.php";
	require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/database/insert_tables.php";
	if (isset($_POST['name_category'])) 
	{
		global $errors;
		$name_category = trim(fix_string($_POST['name_category']));
		$desc_category = trim(fix_string($_POST['desc_category']));
		correct_name_category($name_category);
		correct_desc_category($desc_category);
		if (count($errors)==0) 
		{
			insert_into_category($name_category, $desc_category);
			echo json_encode($errors);
		}
		else
		{
			echo json_encode($errors);
		}		
	}
?>Z:/home/localhost/www/eshop1/admin/utils/products/delete_product.php<br><?php 
	require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/database/delete_tables.php";
	require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/config.php";
	if (isset($_POST['delete_id'])) 
	{
		$id = intval($_POST['delete_id']);
		$ret = delete_product($id);
		echo $ret;
	}
 ?>Z:/home/localhost/www/eshop1/admin/utils/products/form.php<br><div class="row">
    <div class="span12"> 
        <div class="row">
        <div class="span3">
            <ul class="nav nav-list">
                <li class="nav-header">Категории</li>
                <?php 
                    $categories = select_all_categories();
                    $active = false;
                    while ($row=mysql_fetch_assoc($categories))
                    {
                        echo "<li ";
                        if ($product==null && !$active)
                        {
                            $active = true;
                            echo "class='active'";   
                        }
                        if ($product['id_category']==$row['id'])
                        {
                            echo "class='active'";
                        }
                        echo ">";
                        echo "<a href='index.php'>{$row['name']}</a>";
                        echo "<input type='hidden' name='' value='{$row['id']}'>";
                    }
                ?>
            </ul>
        </div>
        <div class="span9">
            <form action="index.php" class="form-horizontal" id="create_product">
                <div class="control-group">
                    <label for="name" class="control-label">Имя товара</label>
                    <div class="controls">
                        <input type="text" name="" id="name" placeholder="Имя товара"
                        value="<?php echo $product['name']; ?>"
                        >
                    </div>
                </div>
                <div class="control-group">
                    <label for="price" class="control-label">Цена</label>
                    <div class="controls">
                        <input type="text" name="" id="price" placeholder="Цена"
                        value="<?php echo $product['price']; ?>"
                        >
                    </div>
                </div>
                <div class="control-group">
                    <label for="" class="control-label">Картинка</label>
                    <div class="controls">
                        <input type="text" name="" id="small_pic" placeholder="Картинка"
                        value="<?php echo $product['small_image']; ?>"
                        >
                    </div>
                </div>
                <div class="control-group">
                    <label for="" class="control-label">Картинка</label>
                    <div class="controls">
                        <input type="text" name="" id="big_pic" placeholder="Картинка"
                        value="<?php echo $product['image']; ?>"
                        >
                    </div>
                </div>
                <div class="control-group">
                    <!-- <div class="controls"> -->
                        <table class="table table-condensed table-hover" id="characters">
                <tr>
                    <th>Характеристика</th>
                    <th>Значение</th>
                    <th></th>
                </tr>
                <?php 
                    if ($chars)
                    {
                        while ($row=mysql_fetch_assoc($chars))
                        {
                            $html=<<<__html
                            <tr>
                                <td>{$row['name']}</td>
                                <td>{$row['value']}</td>
                                <td>
                                    <a href="#ModalDeleteChar" data-toggle="modal"><i class="icon-remove remove_char"></i></a>
                                </td> 
                            </tr>        
__html;
                            echo $html;
                        }
                    }
                 ?>
                <tr id="tr_insert">
                    <td></td>
                    <td></td>
                    <td>
                        <a href="#ModalCreateChar" data-toggle="modal"><i class="icon-plus"></i></a>
                    </td>
                </tr>
            </table>
                    <!-- </div> -->
                </div>
                <div class="control-group">
                    <label for="short_desc" class="control-label">Краткое описание</label>
                    <div class="controls">
                        <textarea name="" id="short_desc" class="field span5" rows="7"><?php echo $product['small_descr'];; ?></textarea>
                    </div>
                </div>
                <div class="control-group">
                    <label for="long_desc" class="control-label">Полное описание</label>
                    <div class="controls">
                        <textarea name="" id="long_desc" class="field span5" rows="15"><?php echo $product['descr'];; ?></textarea>
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <button class="btn" type="submit" id="main_button">
                            <?php echo $button; ?>
                        </button>
                    </div>
                </div>
            </form>
        </div>
        </div>
    </div>  
</div>Z:/home/localhost/www/eshop1/admin/utils/products/prod_ajax.php<br><?php 
	require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/users/config_user.php";
	require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/admin/utils/products/correct_fields.php";
	require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/database/insert_tables.php";
	require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/database/update_tables.php";
	global $errors;
	$errors = array();
	$name = trim(fix_string($_POST['name']));
	$small_pic = trim(fix_string($_POST['small_pic']));
	$big_pic = trim(fix_string($_POST['big_pic']));
	$price = trim(fix_string($_POST['price']));
	$short_desc = trim(fix_string($_POST['short_desc']));
	$long_desc = trim(fix_string($_POST['long_desc']));
	$mode = $_POST['mode'];
	$category_id = intval($_POST['category_id']);
	$chars = $_POST['chars'];
	$id = $_POST['id'];
	correct_name($name);
	correct_price($price);
	if (count($chars)!=0)
	{
		foreach ($chars as $key => $value) 
		{
			correct_chars($key, $value);
		}	
	}
	if (count($errors)==0) 
	{
		$errors['href'] = "products.php";
		if ($mode=="create")
		{
			$errors['er'] = insert_into_product($name, $small_pic, $big_pic, $price, $short_desc, $long_desc, $category_id, $chars);
		}
		else
		{
			$errors['er'] = update_into_product($id, $name, $small_pic, $big_pic, $price, $short_desc, $long_desc, $category_id, $chars);	
		}
		echo json_encode($errors);
	}
	else
	{
		echo json_encode($errors);
	}
?>Z:/home/localhost/www/eshop1/admin/utils/products/show_filters.php<br><?php 
	$html=<<<__html
	<div class="span12">            
        <div class="span3">
            <strong>Фильтрация</strong>  <br> <br>
            <p>По дате добавления</p>
            <select id="date_added">
__html;
	echo $html;
	if (isset($_GET['search_date_added']))
		$date_value = $_GET['search_date_added'];
	else
		$date_value = 1;
	$dates = array("Любое значение", "Первый день", "Менее недели", "Менее 30 дней", 
		"Менее года", "Более года");
	for ($i=1; $i <= count($dates); $i++) 
	{ 
		$opt = "<option value='".$i."'";
		echo $opt;
		if ($i==$date_value)
			echo " selected";
		echo ">".$dates[$i-1]."</option>";
	}

	$html=<<<__html
	</select>
        </div>
        <div class="span3">
            <br> <br>
            <p>По категориям</p>
            <select id="categories">
            <option value="1">Любое значение</option>
                        
__html;
	echo $html;
	$categ_value = $_GET['search_categories'];
	$cats = get_all_categories();
    $index = 2;
    //echo $cats;
    while ($row=mysql_fetch_row($cats))
    {
    	$str_tmp = "";
    	if ($categ_value==$row[0])
    		$str_tmp = "selected";
    	echo "<option value='$index' ".$str_tmp.">{$row[0]}</option>";
        //echo $row[0];
        $index++;
    }

    $html=<<<__html
	</select>
	    </div>
	    <div class="span3">
	        <br> <br> 
	        <p>По цене</p>
	        <select id="price">                        
__html;
	echo $html;
	if (isset($_GET['search_price']))
		$price_value = $_GET['search_price'];
	else
		$price_value = 1;
	$prices = array("Любое значение", "Дешевле 1$", "От 1$ до 100$", 
		"От 100$ до 1000$", "От 1000$ до 10.000$", "Более 10.000$");
	for ($i=1; $i <= count($prices); $i++) 
	{ 
		$opt = "<option value='".$i."'";
		echo $opt;
		if ($i==$price_value)
			echo " selected";
		echo ">".$prices[$i-1]."</option>";
	}

	$html=<<<__html
		</select>
        </div>
    </div>
    <div class="span12">
      
        <div class="span3">
            <strong>Сортировка</strong>  <br> <br>
            <p>Сортировка значений</p>
            <select id="sorting">                       
__html;
	echo $html;
	if (isset($_GET['search_sorting']))
		$sort_value = $_GET['search_sorting'];
	else
		$sort_value = 1;
	$sortes = array("От дешевых к дорогим", "От дорогих к дешевым", 
		"Последние добавленные");
	for ($i=1; $i <= count($sortes); $i++) 
	{ 
		$opt = "<option value='".$i."'";
		echo $opt;
		if ($i==$sort_value)
			echo " selected";
		echo ">".$sortes[$i-1]."</option>";
	}

	$html=<<<__html
	     </select>
            </div> 
              
            
            <div class="span8">
            	<a href="" class="btn btn-primary" id="search">
                <i class="icon-search icon-white"></i>
                Найти</a>
            
                <a href="add_product.php" class="btn btn-success  btn-primary">
                    <i class="icon-plus icon-white"></i>
                    Добавить товар</a>
                <a href="#ModalCreateCategory" data-toggle="modal" class="btn btn-success">
                    <i class="icon-plus icon-white"></i>
                    Добавить категорию</a>
            </div>
        </div>
__html;
	echo $html;
 ?>Z:/home/localhost/www/eshop1/admin/utils/products/show_products.php<br><?php 
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
Z:/home/localhost/www/eshop1/admin/utils/security_mod.php<br><?php 
	function unauthorized()
	{
		header("WWW-Authenticate: Basic realm=\"Admin Page\"");
		header("HTTP/1.0 401 Unauthorized");
		exit();
	}

	require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/config.php";
	//Если пользователь не авторизован - авторизуем
	if (!isset($_SERVER['PHP_AUTH_USER'])) 
	{
		unauthorized();	
	}
	else
	{
		if (!get_magic_quotes_gpc()) 
		{
			$_SERVER['PHP_AUTH_USER'] = mysql_real_escape_string($_SERVER['PHP_AUTH_USER']);
			$_SERVER['PHP_AUTH_PW'] = mysql_real_escape_string($_SERVER['PHP_AUTH_PW']);
		}
		$query = "select password from admin where login='".$_SERVER['PHP_AUTH_USER']."'";
		$res = @mysql_query($query);
		if (!$res) 
		{
			unauthorized();
		}
		if (mysql_num_rows($res) == 0) 
		{
			unauthorized();
		}
		$pass = mysql_fetch_array($res);
		if (md5($_SERVER['PHP_AUTH_PW']) != $pass['password']) 
		{
			unauthorized();	
		}
	}
	
 ?>Z:/home/localhost/www/eshop1/admin/utils/stats/br.php<br><?php 
	require_once "br_count.php";
?>

<div class="row">
        <div class="span12">
            <div class="alert alert-info">
                На этой странице вы видите статистику посещений по браузерам
            </div>
        </div>
    </div>
    <table class="table table-bordered">
		<tr>
		    <th>Браузер</th>
		    <th>Количество посещений</th>
		</tr>
		<?php 
			for ($i=0; $i < count($arr); $i++) 
			{ 
				echo "<tr>";
				echo "<td>{$arr[$i]['name']}</td>";	
				echo "<td>{$arr[$i]['count(o.name)']}</td>";
				echo "</tr>";
			}
		 ?>
	</table>
Z:/home/localhost/www/eshop1/admin/utils/stats/br_count.php<br><?php 
	global $tbl_stats, $tbl_browsers;
	$query = "select o.name, count(o.name), s.id_browser from $tbl_stats as s join $tbl_browsers as o
	on s.id_browser=o.id  group by o.name order by count(o.name) desc limit 10";
	$res = mysql_query($query);
	$arr = array();
	$count = 0;
	while ($row=mysql_fetch_assoc($res))
	{
		$count += $row['count(o.name)'];
		array_push($arr, $row);		
	}
	$query = "select count(*) from $tbl_stats where id_browser is not NULL ";
	$res = mysql_query($query);
	$count_all = mysql_result($res, 0);
	array_push($arr, array('name'=>'Остальные', 'count(o.name)'=>$count_all-$count, 'id_browser'=>'-1'));
	//echo $count;
?>Z:/home/localhost/www/eshop1/admin/utils/stats/cat.php<br><?php 
	require_once "cat_count.php";
?>

<div class="row">
        <div class="span12">
            <div class="alert alert-info">
                На этой странице вы видите список количества посещений страниц категорий
            </div>
        </div>
    </div>
    <table class="table table-bordered">
		<tr>
		    <th>Товар</th>
		    <th>Количество посещений</th>
		</tr>
		<?php 
			for ($i=0; $i < count($arr); $i++) 
			{ 
				echo "<tr>";
				if ($arr[$i]['name']!=="Остальные")
				{
					echo "<td><a href='"."/eshop1/index.php?cat=".$arr[$i]['name']."' >{$arr[$i]['name']}</a></td>";
				}
				else
				{
					echo "<td>{$arr[$i]['name']}</td>";	
				}
				echo "<td>{$arr[$i]['count(p.name)']}</td>";
				echo "</tr>";
			}
		 ?>
	</table>
Z:/home/localhost/www/eshop1/admin/utils/stats/cat_count.php<br><?php 
	global $tbl_stats, $tbl_category;
	$query = "select p.name, count(p.name), s.id_category from $tbl_stats as s join $tbl_category as p 
	on s.id_category=p.id  group by p.name order by count(p.name) desc limit 20";
	$res = mysql_query($query);
	$arr = array();
	$count = 0;
	while ($row=mysql_fetch_assoc($res))
	{
		$count += $row['count(p.name)'];
		array_push($arr, $row);		
	}
	$query = "select count(*) from $tbl_stats where id_category is not NULL ";
	$res = mysql_query($query);
	$count_all = mysql_result($res, 0);
	array_push($arr, array('name'=>'Остальные', 'count(p.name)'=>$count_all-$count, 'id_category'=>'-1'));
	//echo $count;
?>Z:/home/localhost/www/eshop1/admin/utils/stats/hits.php<br><?php 
	$stats = array();
            
    global $tbl_stats, $tbl_os;
    $query = "select id from $tbl_os where name='none'";
    $res = mysql_query($query);
    $os_none = mysql_result($res, 0);
    /*
    ХИТЫ, ЗАСЧИТАНЫЕ ХИТЫ
    */
    for ($i=0; $i <= 1; $i++) 
    { 
        if ($i==0)
        {
            $and = "";
            $and_all = "";
        }
        else
        {
            $and = " and id_os!='$os_none'";
            $and_all = " where id_os!='$os_none'";
        }
        $stats[$i] = array();
        $query = "select count(*) from $tbl_stats where DATE(begin_date) = DATE(NOW())".$and;
        $res = mysql_query($query);
        array_push($stats[$i], mysql_result($res, 0));

        $query = "select count(*) from $tbl_stats where date(begin_date) = DATE_SUB(CURDATE(), INTERVAL 1 DAY)".$and;
        $res = mysql_query($query);
        array_push($stats[$i], mysql_result($res, 0));

        $query = "select count(*) from $tbl_stats where DATE_SUB(CURDATE(), INTERVAL 7 DAY)<=begin_date".$and;
        $res = mysql_query($query);
        array_push($stats[$i], mysql_result($res, 0));

        $query = "select count(*) from $tbl_stats where DATE_SUB(CURDATE(), INTERVAL 30 DAY)<=begin_date".$and;
        $res = mysql_query($query);
        array_push($stats[$i], mysql_result($res, 0));

        $query = "select count(*) from $tbl_stats".$and_all;
        $res = mysql_query($query);
        array_push($stats[$i], mysql_result($res, 0));    
    }
    /*
    ВСЕГО ХОСТОВ
    */
    $stats[2] = array();
    $query = "select count(distinct ip) from $tbl_stats where DATE(begin_date) = DATE(NOW())";
    $res = mysql_query($query);
    array_push($stats[2], mysql_result($res, 0));

    $query = "select count(distinct ip) from $tbl_stats where date(begin_date) = DATE_SUB(CURDATE(), INTERVAL 1 DAY)";
    $res = mysql_query($query);
    array_push($stats[2], mysql_result($res, 0));

    $query = "select count(distinct ip) from $tbl_stats where DATE_SUB(CURDATE(), INTERVAL 7 DAY)<=begin_date";
    $res = mysql_query($query);
    array_push($stats[2], mysql_result($res, 0));

    $query = "select count(distinct ip) from $tbl_stats where DATE_SUB(CURDATE(), INTERVAL 30 DAY)<=begin_date";
    $res = mysql_query($query);
    array_push($stats[2], mysql_result($res, 0));

    $query = "select count(distinct ip) from $tbl_stats";
    $res = mysql_query($query);
    array_push($stats[2], mysql_result($res, 0)); 

    /*
    ЧИСТЫХ ХОСТОВ
    */
    $and = "o.name != 'none' AND
             o.name != 'robot_yandex' AND
             o.name != 'robot_google' AND
             o.name != 'robot_rambler' AND
             o.name != 'robot_aport' AND
             o.name != 'robot_msnbot'";
    $stats[3] = array();
    $query = "select count(distinct ip) from $tbl_stats as s join $tbl_os as o on o.id=s.id_os where DATE(begin_date) = DATE(NOW()) and ".$and;
    $res = mysql_query($query);
    array_push($stats[3], mysql_result($res, 0));

    $query = "select count(distinct ip) from $tbl_stats as s join $tbl_os as o on o.id=s.id_os  where date(begin_date) = DATE_SUB(CURDATE(), INTERVAL 1 DAY) and ".$and;
    $res = mysql_query($query);
    array_push($stats[3], mysql_result($res, 0));

    $query = "select count(distinct ip) from $tbl_stats as s join $tbl_os as o on o.id=s.id_os  where DATE_SUB(CURDATE(), INTERVAL 7 DAY)<=begin_date and ".$and;
    $res = mysql_query($query);
    array_push($stats[3], mysql_result($res, 0));

    $query = "select count(distinct ip) from $tbl_stats as s join $tbl_os as o on o.id=s.id_os  where DATE_SUB(CURDATE(), INTERVAL 30 DAY)<=begin_date and ".$and;
    $res = mysql_query($query);
    array_push($stats[3], mysql_result($res, 0));

    $query = "select count(distinct ip) from $tbl_stats as s join $tbl_os as o on o.id=s.id_os  where ".$and;
    $res = mysql_query($query);
    $rr = mysql_fetch_assoc($res);
    array_push($stats[3], mysql_result($res, 0)); 

 ?>

<div class="row">
        <div class="span12">
            <div class="alert alert-info">
                На этой странице вы видите общую статистику по посетителям сайта. <br>
                Хосты - это количество уникальных посетителей вашего сайта, <br>
                хиты - это общее количество показов сайта. 
            </div>
        </div>
    </div>
    <table class="table table-bordered">
<tr>
    <th></th>
    <th>Сегодня</th>
    <th>Вчера</th>
    <th>За 7 дней</th>
    <th>За 30 дней</th>
    <th>За все время</th>
</tr>
<?php 
    $caption = array("Хиты", "Засчитанные хиты", "Хосты", "Засчитанные хосты",);
    for ($i=0; $i < 4; $i++) 
    { 
        echo "<tr>";
        echo "<td><b>{$caption[$i]}</b></td>";
        for ($j=0; $j < 5; $j++) 
        { 
            echo "<td>{$stats[$i][$j]}</td>";
        }
        echo "</tr>";
    }
 ?>
</table>

Z:/home/localhost/www/eshop1/admin/utils/stats/hits_order.php<br><?php 
	require_once "hits_order_count.php";
?>

<div class="row">
        <div class="span12">
            <div class="alert alert-info">
                На этой странице вы видите количество хитов за последние 30 дней
            </div>
        </div>
    </div>
    <div id="sed9"></div>
    <br> <br>
    <table class="table table-bordered">
		<tr>
		    <th>Дата</th>
		    <th>Хиты</th>
		</tr>
		<?php 
			for ($i=0; $i < count($arr); $i++) 
			{ 
				echo "<tr>";
				echo "<td>{$arr[$i][0]}</td>";	
				echo "<td>{$arr[$i][1]}</td>";
				echo "</tr>";
			}
		 ?>
	</table>
Z:/home/localhost/www/eshop1/admin/utils/stats/hits_order_count.php<br><?php 
	global $tbl_stats;
	//$query = "select date(begin_date), count(date(begin_date)) from $tbl_stats ";
	$arr = array();
	for ($i=30; $i >= 0; $i--) 
	{ 
		// $date = " where date(begin_date) = DATE_SUB(CURDATE(), INTERVAL $i DAY)";
		// $res = mysql_query($query.$date." group by date(begin_date)");		
		$query = "select DATE_SUB(CURDATE(), INTERVAL $i DAY)";
		$res = mysql_query($query);
		$date_t = mysql_result($res, 0);
		$query = "select count(*) from $tbl_stats where date(begin_date) = DATE_SUB(CURDATE(), INTERVAL $i DAY)";
		$res = mysql_query($query);
		$count = mysql_result($res, 0);
		array_push($arr, array($date_t, $count));		
	}
?>Z:/home/localhost/www/eshop1/admin/utils/stats/os.php<br><?php 
	require_once "os_count.php";
?>

<div class="row">
        <div class="span12">
            <div class="alert alert-info">
                На этой странице вы видите статистику посещений по операционным системам
            </div>
        </div>
    </div>
    <table class="table table-bordered">
		<tr>
		    <th>ОС</th>
		    <th>Количество посещений</th>
		</tr>
		<?php 
			for ($i=0; $i < count($arr); $i++) 
			{ 
				echo "<tr>";
				echo "<td>{$arr[$i]['name']}</td>";	
				echo "<td>{$arr[$i]['count(o.name)']}</td>";
				echo "</tr>";
			}
		 ?>
	</table>
Z:/home/localhost/www/eshop1/admin/utils/stats/os_count.php<br><?php 
	global $tbl_stats, $tbl_os;
	$query = "select o.name, count(o.name), s.id_os from $tbl_stats as s join $tbl_os as o
	on s.id_os=o.id  group by o.name order by count(o.name) desc limit 10";
	$res = mysql_query($query);
	$arr = array();
	$count = 0;
	while ($row=mysql_fetch_assoc($res))
	{
		$count += $row['count(o.name)'];
		array_push($arr, $row);		
	}
	$query = "select count(*) from $tbl_stats where id_os is not NULL ";
	$res = mysql_query($query);
	$count_all = mysql_result($res, 0);
	array_push($arr, array('name'=>'Остальные', 'count(o.name)'=>$count_all-$count, 'id_os'=>'-1'));
	//echo $count;
?>Z:/home/localhost/www/eshop1/admin/utils/stats/pages.php<br><?php 
	global $tbl_stats, $tbl_pages;
	$query = "select p.address, count(p.address), s.id_page from $tbl_stats as s join $tbl_pages as p 
	on s.id_page=p.id ".$date." group by p.address order by count(p.address) desc limit 9";
	$res = mysql_query($query);
	$arr = array();
	$count = 0;
	while ($row=mysql_fetch_assoc($res))
	{
		$count += $row['count(p.address)'];
		array_push($arr, $row);		
	}
	$query = "select count(*) from $tbl_stats ".$date;
	$res = mysql_query($query);
	$count_all = mysql_result($res, 0);
	array_push($arr, array('address'=>'Остальные', 'count(p.address)'=>$count_all-$count, 'id_page'=>'-1'));
	//echo $count;
?>

<div class="row">
        <div class="span12">
            <div class="alert alert-info">
                На этой странице вы видите общую статистику по посещаемости страниц
            </div>
        </div>
    </div>
    <table class="table table-bordered">
		<tr>
		    <th>Страница</th>
		    <th>Количество посещений</th>
		    <th>Последнее посещение</th>
		</tr>
		<?php 
			for ($i=0; $i < count($arr); $i++) 
			{ 
				echo "<tr>";
				if ($arr[$i]['address']!=="Остальные")
				{
					echo "<td><a href='{$arr[$i]['address']}' >{$arr[$i]['address']}</a></td>";
				}
				else
				{
					echo "<td>{$arr[$i]['address']}</td>";	
				}
				echo "<td>{$arr[$i]['count(p.address)']}</td>";
				if ($arr[$i]['id_page']!=-1)
				{
					$query = "select begin_date from $tbl_stats where id_page={$arr[$i]['id_page']} order by begin_date desc limit 1";
					$res = mysql_query($query);
					$tmp = mysql_result($res, 0);
				}
				else
				{
					$tmp = "";
				}
				echo "<td>".$tmp."</td>";
				echo "</tr>";
			}
		 ?>
	</table>
Z:/home/localhost/www/eshop1/admin/utils/stats/pages_count.php<br><?php 
	global $tbl_stats, $tbl_pages;
	$query = "select p.address, count(p.address), s.id_page from $tbl_stats as s join $tbl_pages as p 
	on s.id_page=p.id ".$date." group by p.address order by count(p.address) desc limit 9";
	$res = mysql_query($query);
	$arr = array();
	$count = 0;
	while ($row=mysql_fetch_assoc($res))
	{
		$count += $row['count(p.address)'];
		array_push($arr, $row);		
	}
	$query = "select count(*) from $tbl_stats ".$date;
	$res = mysql_query($query);
	$count_all = mysql_result($res, 0);
	array_push($arr, array('address'=>'Остальные', 'count(p.address)'=>$count_all-$count, 'id_page'=>'-1'));
	//echo $count;
?>Z:/home/localhost/www/eshop1/admin/utils/stats/products.php<br><?php 
	require_once "products_count.php";
?>

<div class="row">
        <div class="span12">
            <div class="alert alert-info">
                На этой странице вы видите список количества посещений страниц 
                 самых популярных товаров
            </div>
        </div>
    </div>
    <table class="table table-bordered">
		<tr>
		    <th>Товар</th>
		    <th>Количество посещений</th>
		</tr>
		<?php 
			for ($i=0; $i < count($arr); $i++) 
			{ 
				echo "<tr>";
				if ($arr[$i]['name']!=="Остальные")
				{
					echo "<td><a href='"."/eshop1/product.php?id=".$arr[$i]['id_product']."' >{$arr[$i]['name']}</a></td>";
				}
				else
				{
					echo "<td>{$arr[$i]['name']}</td>";	
				}
				echo "<td>{$arr[$i]['count(p.name)']}</td>";
				echo "</tr>";
			}
		 ?>
	</table>
Z:/home/localhost/www/eshop1/admin/utils/stats/products_count.php<br><?php 
	global $tbl_stats, $tbl_product;
	$query = "select p.name, count(p.name), s.id_product from $tbl_stats as s join $tbl_product as p 
	on s.id_product=p.id  group by p.name order by count(p.name) desc limit 20";
	$res = mysql_query($query);
	$arr = array();
	$count = 0;
	while ($row=mysql_fetch_assoc($res))
	{
		$count += $row['count(p.name)'];
		array_push($arr, $row);		
	}
	$query = "select count(*) from $tbl_stats where id_product is not NULL ";
	$res = mysql_query($query);
	$count_all = mysql_result($res, 0);
	array_push($arr, array('name'=>'Остальные', 'count(p.name)'=>$count_all-$count, 'id_product'=>'-1'));
	//echo $count;
?>Z:/home/localhost/www/eshop1/admin/utils/top.php<br><?php 
	//require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/stats/stats.php";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>
		<?php 
		echo $title;
		 ?>
	</title>
	<link href="utils/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
	<link href="utils/bootstrap/css/bootstrap-responsive.css" rel="stylesheet" media="screen">
	<script src="http://code.jquery.com/jquery-latest.js"></script>
	<script src="utils/bootstrap/js/bootstrap.min.js"></script>
	
	<script type="text/javascript" src="utils/bootstrap/js/bootstrap-dropdown.js"></script>
	<script type="text/javascript" src="utils/bootstrap/js/bootstrap-tab.js"></script>
	<?php 
		$script_name = $_SERVER['PHP_SELF'];
		$js_users=<<<__js
		<script src="../ajax/js/user_info.js"></script>
		<script src="../ajax/js/user_search.js"></script>	
__js;

$js_products=<<<__js
		<script type="text/javascript" src="utils/js/top.js"></script>
__js;
		if (strpos($script_name, "users.php")!==false)
			echo $js_users;
		if (strpos($script_name, "products.php")!==false)
			echo $js_products;
		if (strpos($script_name, "add_product.php")!==false)
			echo $js_products;
		echo '<script type="text/javascript" src="utils/js/search_paginate.js"></script>';
	?>		
	<script src="utils/js/navbar.js"></script>
	<link rel="stylesheet" href="../css/style.css">
	<script>
		jQuery(document).ready(function($) {
			$('.dropdown-toggle').dropdown();
		});
	</script>
	Z:/home/localhost/www/eshop1/admin/utils/users/info_users.php<br><?php 
    require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/users/config_user.php";
    if (isset($_GET['info_id'])) 
    {
        $id = intval($_GET['info_id']);
    }
    else
    {
        $id = 1;
    }
    $user = user($id);
    if ($user!=null && empty($user['mail'])) 
    {
        $user['mail'] = "не указано";
    }
    $html=<<<_html
    <h5>Информация о пользователе</h5>
    <table class="table">
        <tr>
            <td>Логин</td>
            <td>{$user['login']}</td>
        </tr>
        <tr>
            <td>ФИО</td>
            <td>{$user['fio']}</td>
        </tr>
        <tr>
            <td>Email</td>
            <td>{$user['mail']}</td>
        </tr>
        <tr>
            <td>Моб. телефон</td>
            <td>{$user['tel']}</td>
        </tr>
        <tr>
            <td>Адрес</td>
            <td>{$user['address']}</td>
        </tr>
        <tr>
            <td>Дата регистрации</td>
            <td>{$user['date_reg']}</td>
        </tr>
        <tr>
            <td>Скидка</td>
            <td>{$user['discount']}</td>
        </tr>
        <tr>
            <td>Дата рождения</td>
            <td>{$user['date_b']}</td>
        </tr>
    </table>
_html;
    if ($user!=null)
    {
        echo $html;
    }
?>Z:/home/localhost/www/eshop1/admin/utils/users/page_info.php<br><div class="row">
    <div class="span12">
        <div class="alert alert-info">
            <?php 
                echo $pageinfo;
             ?>
        </div>
    </div>
</div>Z:/home/localhost/www/eshop1/admin/utils/users/show_filters.php<br><?php 
	$html=<<<__div
	<div class="span3 offset2">
        <strong>Фильтрация</strong>  <br> <br>
        <p>Зарегистрирован на сайте</p>
        <select id="site">
__div;
	echo $html;
	if (isset($_GET['s_site']))
		$date_value = $_GET['s_site'];
	else
		$date_value = 1;
	$dates = array("Любое значение", "Первый день", "Менее недели", "Менее 30 дней", 
		"Менее года", "Более года");
	for ($i=1; $i <= count($dates); $i++) 
	{ 
		$opt = "<option value='".$i."'";
		echo $opt;
		if ($i==$date_value)
			echo " selected";
		echo ">".$dates[$i-1]."</option>";
	}
	$html=<<<__div
	</select>
	    <p>Возраст</p>
	    <select id="age">
__div;
	echo $html;

	if (isset($_GET['s_age']))
		$age_value = $_GET['s_age'];
	else
		$age_value = 1;
	$ages = array("Любое значение", "Менее 18 лет", "От 18 до 40", "Старше 40");
	for ($i=1; $i <= count($ages); $i++) 
	{ 
		$opt = "<option value='".$i."'";
		echo $opt;
		if ($i==$age_value)
			echo " selected";
		echo ">".$ages[$i-1]."</option>";
	}

	$html=<<<__div
	</select>
        <p>Город</p>
        <select id="city">
__div;
	//echo $html;
	echo "</select>";

	// echo "<option value='-1'>Любое значение</option>";
 //    for ($i=0; $i < count($city_user_array); $i++) 
 //    { 
 //        echo "<option value='$i'>{$city_user_array[$i]}</option>";
 //    }
    $html=<<<__div
    
        <br>
        <br>
        <a href="" class="btn btn-primary" id="search_user">
            <i class="icon-search icon-white"></i>
           Отобрать</a>
    </div>
__div;
	echo $html;
?>Z:/home/localhost/www/eshop1/admin/utils/users/show_users.php<br><?php 
    require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/database/utils.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/users/config_user.php";
    $num_users = orders_count($tbl_user);
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $start = abs(($page-1)*$per_page);
    //$res = filter_users($start, $per_page);
    $ar = filter_users($start, $per_page);
    $res = $ar[0];
    $num_users = $ar[1];
    $num_pages = ceil($num_users/$per_page);
    if ($num_pages<$page) 
    {
        $page = $num_pages;
    }
       
    echo "<h4>Пользователи</h4>";
    $html=<<<_html
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Логин</th>
                
                <th>Дата регистрации</th>
                <th>Телефон</th>
                <th>Действие</th>
            </tr>
        </thead>
_html;
    echo $html;
    echo "<tbody>";
    while ($row = mysql_fetch_assoc($res)) 
    {
        if ($row['block']=="block") 
        {
            $icon_class = "icon-plus";
            $icon_text = "Разблокировать";
            $tr_class = "error";
        }
        else
        {
            $icon_class = "icon-remove";
            $icon_text = "Блокировать";
            $tr_class = "success";
        }
        echo "<tr class='$tr_class'>";
        echo "<td>";        echo $row['login'];        echo "</td>";
        echo "<td>";        
        echo $row['date_reg'];
        echo "</td>";
        echo "<td>";        echo $row['tel'];        echo "</td>";
        $info_id = $row['id'];
        $html=<<<_html
        <td>
            <div class="btn-group">
                <a href="" class="btn disabled" onclick="return false">
                <i class="icon-edit"></i>
                Изменить
                </a>
                <a href="#" class="btn info">
                <i class="icon-info-sign"></i>
                    Инфо
                </a>

                <input type="hidden" class="info" value="$info_id">
                <span class="div_block">
                <a href="#myModal" class="btn btn-danger block" data-toggle="modal">
                <i class="$icon_class icon-large icon-white"> </i> 
                $icon_text
                </a>
                </span>
            </div>
        </td>
_html;
        echo $html;    
    }
    echo "</tbody>";
    echo "</table>";
?>
Z:/home/localhost/www/eshop1/admin/utils/users/user_block_ajax.php<br><?php 
	require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/users/config_user.php";
	require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/database/update_tables.php";
    if (isset($_GET['block_id'])) 
    {
        $id = intval($_GET['block_id']);
    }
    else
    {
        $id = 1;
    }
    $user = user($id);
    $msgs = array();
    if ($user['block']=="block") 
    {
    	$icon_class = "icon-remove";
        $icon_text = "Блокировать";
    	update_user_block($id, 'unblock');
    }
    else
    {
    	$icon_class = "icon-plus";
        $icon_text = "Разблокировать";
    	update_user_block($id, 'block');    	
    }

//     $html=<<<_html
// 	    <a href="#myModal" class="btn btn-danger block" data-toggle="modal">
// 	    <i class="$icon_class icon-large icon-white"> </i> 
// 	    $icon_text
// 	    </a>
// _html;
// 	echo $html;
 ?>Z:/home/localhost/www/eshop1/ajax/auth_ajax.php<br><?php 
	session_start();
	require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/users/correct_fields.php";
	require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/users/config_user.php";
	if (isset($_POST['login'])) 
	{
		$login = trim(fix_string($_POST['login']));
		$pass = trim(fix_string($_POST['pass']));
		$res = enter($login, $pass);
		if (!$res) 
		{
			echo "Ошибка авторизации";
		}
		elseif ($res<0)
		{
			echo "Ваш аккаунт заблокирован. <br> Обратитесь к администратору!";
		}
		else
		{
			echo "";
		}
	}
?>Z:/home/localhost/www/eshop1/ajax/js/auth.js<br>jQuery(document).ready(function($) {
		$(':text, :password').val("");
		$("._form input[type='text'],._form input[type='password']")
		.focus(function(event) {
			$(this).css("box-shadow", "0px 0px 7px rgb(0, 102, 255)");
		}).blur(function(event) {
			$(this).css("box-shadow", "0px 0px 0px");				
		});	

		$('._form').submit(function(event) {
			var _login = $('#login').val();
			var _pass = $('#password').val();
			$.ajax({
				url: "ajax/auth_ajax.php",
				type: "POST",
				dataType: "text",
				success: function (data) {
					//alert(data);
					if (data!="")
					{
						$('#auth_error').html(data);	
					}
					else
					{
						document.location.href = "index.php";
					}			
				},
				error: function (obj, err) {
					alert("Error "+err);
				},
				data: {login: _login, pass: _pass}
			});
			return false;			
		});
	});Z:/home/localhost/www/eshop1/ajax/js/register.js<br>var global_data;
$(function() {
	$( document ).tooltip({
		//track:true
	});
});

jQuery(document).ready(function($) {
	$(':text, :password, textarea').val("");
	$('._form').submit(function(event) {
		var _login = $('#login').val();
		var _pass = $("#pass").val();
		var _pass_rpt = $('#pass_rpt').val();
		var _fam = $('#fam').val();
		var _im = $('#im').val();
		var _ot = $('#ot').val();
		var _email = $('#email').val();
		var _tel = $('#tel').val();
		var _addr = $('#addr').val();
		$.ajax({
			url: "ajax/register_ajax.php",
			type: "POST",
			dataType: "json",
			success: function (data) {
				/*
				Глобально запоминаем ошибки, чтоб знать нужно ли при blur
				соотв. input выделять его красным (ошибочный) или белым
				*/
				global_data = data;
				var array = ["login", "pass", "pass_rpt", 
				"fam", "im", "ot", "email", "tel", "addr"];
				/*
				Выводим сообщения об ошибках заполнения полей при регистрации
				В array названия полей, для которых ошибка определена
				Идентификаторы input полей в форме совпадают с именами свойств
				в объекте data. Это позволило к свойствам data обращаться как к 
				data[array[i]], а к input через jQuery как $('#'+array[i]).					
				*/
				var first_error = null;
				for (var i in array)
				{
					if (data[array[i]])
					{
						first_error = first_error || array[i];
						$('#'+array[i]).next().html(data[array[i]]);
						$('#'+array[i]).css("box-shadow", "0px 0px 7px rgb(185, 74, 72)");
					}
					else
					{
						$('#'+array[i]).next().html("");
						$('#'+array[i]).css("box-shadow", "0px 0px 0px");	
					}	
				}
				$("html, body").animate({scrollTop: $("#"+first_error).offset().top-70}, 300);
						
				if (data['href']) 
				{
					window.location.href = data['href'];
				}
				
			},
			error: function (obj, err) {
				alert("Error "+err);
			},
			data: {login: _login, pass: _pass, pass_rpt: _pass_rpt,
			fam: _fam, im: _im, ot: _ot, email: _email, 
			tel: _tel, addr: _addr}
		});
		return false;			
	});

	$("._form input[type='text'],._form input[type='password'],._form textarea")
	.focus(function(event) {
		$(this).css("box-shadow", "0px 0px 7px rgb(0, 102, 255)");
	}).blur(function(event) {
		if (typeof(global_data) == "undefined")
		{
			$(this).css("box-shadow", "0px 0px 0px");	
		}
		else
		{
			if (typeof(global_data[$(this).attr('id')]) == "undefined") 
			{
				$(this).css("box-shadow", "0px 0px 0px");	
			}
			else
			{
				$(this).css("box-shadow", "0px 0px 7px rgb(185, 74, 72)");
			}				
		}
		
	});

});Z:/home/localhost/www/eshop1/ajax/js/user_info.js<br>jQuery(document).ready(function($) {
	$(document).on('click', '.info', function(event) {
		event.preventDefault();
		var _id = parseInt($(this).next("input.info").val());
		$.ajax({
			url: "utils/users/info_users.php",
			type: "GET",
			dataType: "text",
			success: function (data) {
				$("#info_users").html(data);
				$("html, body").animate({scrollTop: $("#info_users").offset().top}, 300);
			},
			error: function (obj, err) {
				alert("Error "+err);
			},
			data: {info_id: _id}
		});
		return false;
	});

	$(document).on('click', '.block', function(event) {
		event.preventDefault();
		id = parseInt($(this).parent().prev("input.info").val());
		link = $(this);
		var html = link.html();
		if (html.indexOf("Разблокировать")==-1) 
		{
			$('#myModalLabel').html('Блокировка пользователя');
			$('.modal-body p').html('Вы уверены что хотите заблокировать пользователя?');
		}
		else
		{
			$('#myModalLabel').html('Разблокирование пользователя');
			$('.modal-body p').html('Вы уверены что хотите разблокировать пользователя?');	
		}
	});

	$(document).on('click', '#myModal #confirm_btn', function(event) {
		event.preventDefault();
		$.ajax({
			url: "utils/users/user_block_ajax.php",
			type: "GET",
			dataType: "text",
			success: function (data) {
				//alert(data);
				window.location.href="users.php";
			},
			error: function (obj, err) {
				alert("Error "+err);
			},
			data: {block_id: id}
		});	
	});
});Z:/home/localhost/www/eshop1/ajax/js/user_search.js<br>function is_int(n)
{
    return n%1 == 0;
}

jQuery(document).ready(function($) {

	$(document).on('click', '#search_user', search_user);
	$(document).on('click', 'a.paginate', search_paginate);

	function search_user(event)
    {
    	var s_site = $("#site").val();
    	var s_age = $("#age").val();
    	var s_city = $("#city").val();
        page = "page=1";
        var str;
        if ((index = location.href.indexOf("?"))!=-1)
        {
            str = location.href.substring(0, index+1);
        }
        else
        {
            str = location.href+"?";
        }
        location.href = str+page+(page=="" ? "" : "&")+"s_site="+s_site+
        "&s_age="+s_age+"&s_city="+s_city;
        return false;
    }
});Z:/home/localhost/www/eshop1/ajax/register_ajax.php<br><?php 
	//header('Content-type: application/json');
	session_start();
	require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/users/correct_fields.php";
	require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/users/config_user.php";
	require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/database/insert_tables.php";
	global $errors;
	$errors = array();
	$login = trim(fix_string($_POST['login']));
	$pass = trim(fix_string($_POST['pass']));
	$pass_rpt = trim(fix_string($_POST['pass_rpt']));
	$fam = trim(fix_string($_POST['fam']));
	$im = trim(fix_string($_POST['im']));
	$ot = trim(fix_string($_POST['ot']));
	$email = trim(fix_string($_POST['email']));
	$tel = trim(fix_string($_POST['tel']));
	$addr = trim(fix_string($_POST['addr']));
	$fio = $fam." ".$im." ".$ot;
	correct_login($login);
	correct_pass($pass, $pass_rpt);
	correct_fam($fam);
	correct_im($im);
	correct_ot($ot);
	correct_email($email);
	correct_tel($tel);
	correct_addr($addr);
	if (count($errors)==0) 
	{
		$errors['href'] = "index.php";
		$pass = encrypt($pass);
		$errors['er'] = insert_into_user($fio, $email, $addr, date("m/d/y g:i A", time()), $login, $tel, $pass);
		$_SESSION['login'] = $login;
		echo json_encode($errors);
	}
	else
	{
		echo json_encode($errors);
	}
?>Z:/home/localhost/www/eshop1/auth.php<br><?php 
    $title = "Авторизация";
    require_once "stats/stats.php";
    require_once "templates/top.php";
 ?>
 <script src="ajax/js/auth.js"></script>
</head>
<body>
	<div class="container">
		<?php 
			require_once "templates/header.php";
		 ?>

    	<div class="row">
    		<?php 
    			require_once "templates/left.php";
    		 ?>
    		<div class="span8">
    			<?php 
    				//require_once "templates/info_block.php";
    			 ?>
                <div class="row">
                    <div class="offset2 span6">
                        <?php 
                require_once "users/auth_form.php"
            ?>
                    </div>
                </div>    			
    		</div>
    	</div>
       
	<?php 
		require_once "templates/footer.php";
	 ?>
	</div>
</body>
</html>Z:/home/localhost/www/eshop1/basket.php<br><?php 
    session_start();
    require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/only_auth.php";
    require_once "config.php";
    require_once "templates/top.php";
        
 ?>
</head>
<body>
	<div class="container">
		<?php 
			require_once "templates/header.php";
		 ?>
    	<div class="row">
    		<?php 
    			require_once "templates/left.php";
    		 ?>
             <div class="span8">
                <?php 
                    //require_once "templates/info_block.php";
                ?>
                <div id="basket_ajax">
                    <?php 
                        require_once "templates/show_basket.php";
                     ?>
                </div>
                
            </div>
            <div class="span2">
                <?php 
                    //require_once "templates/right.php";
                 ?>
            </div>
    		
    	</div>
        <?php 
            require_once "templates/footer.php";
        ?>
	</div>

</body>
</html>Z:/home/localhost/www/eshop1/config.php<br><?php 
	$server = "localhost";
	$db_name = "eshop";
	$db_user = "root";
	$db_password = "";

	/*
	Соль
	*/
	$salt = "#v5g!7$";
	/*
	Количество элементов в одной странице при пагинации
	*/
	$per_page = 3;
	$per_page_user = 9;

	/*
		Имена баз данных
	*/
	//Сессии пользователя (статистика)
	$tbl_sessions = "sessions";
	//Список страниц сайта с адресами
	$tbl_pages = "pages";
	//Браузеры
	$tbl_browsers = "browsers";
	//Статистика посещения страниц
	$tbl_stats = "stats";
	// 	Характеристика товара
	$tbl_charact = "charact";
	//Таблица товаров
	$tbl_product = "product";
	//Категории товаров
	$tbl_category = "category";
	// Комментарии к товару
	$tbl_prod_comm = "prod_comm";
	// Заказ
	$tbl_order = "order_prod";
	// Пользователь
	$tbl_user = "user";
	// Связанные товары
	$tbl_link = "link";
	// Операционные системы
	$tbl_os = "os";
	// Операционные системы
	$tbl_unique = "unique_users";

	/*
	Всплывающие подсказки для полей при регистрации
	*/
	// Логин
	$tool_login = "Логин должен быть не менее 6 и не более 30 символов";
	// Пароль
	$tool_pass = "";
	// Пароль повторно
	$tool_rpt = "";
	// Фамилия
	$tool_fam = "";
	// Имя
	$tool_im = "";
	// Отчество
	$tool_ot = "";
	// Электронная почта
	$tool_email = "";
	// Телефон мобильный
	$tool_tel = "";
	// Адрес доставки
	$tool_addr = "";

	/*
	Массив городов для фильтрации по пользователям
	*/
	$city_user_array = array("Киев",	"Харьков",	"Севастополь",	"Луцк", "Чернигов");
	$a = array(1,2,3);
	/*
	Подключение к БД
	*/
	$server_root = $_SERVER['DOCUMENT_ROOT']."/eshop1/";
	$handle = @mysql_connect($server, $db_user, $db_password);
	if (!$hanlde) 
	{
		$query = "create database if not exists $db_name";
		mysql_query($query);
		$handle = @mysql_connect($server, $db_user, $db_password);
		if (!$handle) 
		{
			exit("<p>Ошибка подключения к БД</p>".mysql_error());	
		}		
	}
	if (! @mysql_select_db($db_name, $handle)) 
	{
		exit("<p>Ошибка выбора БД</p>".mysql_error());
	}
	mysql_query("SET NAMES 'utf8'");
	//mysql_query('SET NAMES "utf8"', $db);
	mysql_query("set character_set_connection=utf8");
	mysql_query("set names utf8");

	function fix_string($string)
	{
		return htmlentities(sql_fix_string($string), ENT_QUOTES, 'UTF-8');
	}

	function sql_fix_string($string)
	{
		if (get_magic_quotes_gpc()) 
		{
			$string = stripslashes($string);
		}
		return mysql_real_escape_string($string);
	}

	/*
	Создание всех таблиц при попытке подключения к бд с помощью if no exists

	*/
	//require_once "database/create_tables.php";
 ?>Z:/home/localhost/www/eshop1/css/style.css<br>html, body{
	border: 0;
	margin: 0;
	padding: 0;
	font-family: tahoma;
}

#container{
	width: 980px;
	/*border: 1px solid red;*/
	margin: 0 auto;
}

#header{
	padding: 15px;
}

#logo{
	float: left;
}

#top_menu{
	border: 2px solid grey;
	padding: 10px;
	margin-bottom: 25px;
	overflow: hidden;
}

#categories{
	width: 220px;
	float: left;
	margin-bottom: 30px;
}

#main_content{
	margin-left: 220px;
	padding: 20px;
	padding-left: 45px;
	border: 2px solid yellow;
}


#top_menu a{
	margin-left: 30px;
}

#basket{
	margin-left: 640px;
	border: 2px solid grey;
	padding: 15px;
}

.basket_logo{
	float: left;
	margin-right: 10px;
}

.round5{
	-webkit-border-radius: 5px;
	-moz-border-radius: 5px;
	border-radius: 5px;

}

.search{
	float: right;
}

#footer{
	clear:both;
	margin: 20px;
	margin-top: 85px;
	border-top: 2px solid grey;
	text-align: center;
}

.product{
	border: 2px solid black;
	overflow: hidden;
	width: 600px;
	float: left;
}

.product img{
	float: left;
	margin-left: 25px;
}

.product_comment{
	padding-top: 15px;
	margin-left: 180px;
}

#categories a{
	background: url(../images/bg.png) repeat scroll 0px 0px transparent;
	width: 200px;
	height: 30px;
	color: #fff;
	font-style: 12px;
	font-family: tahoma;
	cursor:pointer;
	padding: 8px;
}

#categories a:hover{
	background: url(../images/bg.png) repeat scroll 0px -44px transparent;
}

#categories a span{
	font-size: 9px;
	color: rgb(177, 177, 177);
}

#categories a, #top_menu a{
	display: block;
	text-decoration: none;

}

#top_menu a{
	float: left;
	color: #000;
}

#top_menu a:hover{
	color: rgb(177, 177, 177);	
}

.ratings, .ratings div{
	background-image: url(../images/ratings.png);
	background-repeat: no-repeat;
	width: 70px;
	height: 14px;
}

.ratings{
	background-position: 0px -20px;
}

.ratings2 div{
	background-position: 0px -436px;
}

.ratings2, .ratings2 div{
	background-image: url(../images/ratings.png);
	background-repeat: no-repeat;
	width: 200px;
	height: 46px;

}

.ratings2{
	background-position: 0px -477px;
}

.navbar-inner{
	padding-left: 30px !important;
}

._form{
	padding-left: 60px;
}

._form input[type="text"], ._form input[type="password"]{
	-webkit-border-radius: 5px;
	-moz-border-radius: 5px;
	border-radius: 5px;
	padding: 4px;
	margin-bottom: 40px;
	margin-top: 3px;
	width: 40%;
	/*background-color: Azure;*/
}

.error_message{
	color: red;
}

._form textarea{
	resize: none;
	padding: 5px;
}

._form input[type="text"], ._form input[type="password"],
._form textarea{
	border-width: 1px;
}

.ui-tooltip{
	font-size: 10pt;
}

.error_form{
	color: rgb(185, 74, 72);
	margin-left: 20px;
}

#auth_form{
	/*margin-left: 140px;*/
}

#remember{
	display: inline-block;
	padding-left: 40px;
}

#auth_error{
	color: rgb(185, 74, 72);
	height: 40px;
	margin-bottom: 10px;
}

a.thumbnail{
	padding: 30px 4px;
}
.price{
	float: right;
	color:green;
	margin-right: 150px;
}

#products .span8{
	margin-top: 68px;
}

#short_desc, #long_desc{
	resize:none;
}

icon.icon-remove:hover, .icon-camera:hover{
	cursor:pointer;
}

.icon-remove{
	margin-right: 10px;
}

#characters tr>th:nth-child(1){
	width: 45%;
}
#characters tr>th:nth-child(2){
	width: 45%;
}
#characters tr>th:nth-child(3){
	width: 5%;
}

.myerror{
	border: 1px solid red !important;
}

.well{
	margin-bottom: 40px;
}

.edit_product{
	cursor: pointer;
	margin-right: 10px;
}

#header_img{
	margin-top: 20px;
}

.navbar_user{
	margin: 10px 0px;
}

.error_form{
	position: relative;
	top: -17px;
}

.well{
    background-color: rgb(250, 250, 250);
    background-image: linear-gradient(to bottom, rgb(255, 255, 255), rgb(242, 242, 242));
    background-repeat: repeat-x;
    border: 1px solid rgb(212, 212, 212);
    box-shadow: 0px 1px 4px rgba(0, 0, 0, 0.067);
}









Z:/home/localhost/www/eshop1/database/create_tables.php<br><?php 
	require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/config.php";

	//Сессии пользователя (статистика)
	$query = "CREATE TABLE IF NOT EXISTS $tbl_sessions(
					id int unsigned NOT NULL auto_increment, 
					id_user int unsigned,
					begin_date datetime, 
					exit_date datetime, 
					primary key(id)) engine=myisam";
	mysql_query($query);

	//Список страниц сайта с адресами
	$query = "CREATE TABLE IF NOT EXISTS $tbl_pages(
					id smallint unsigned NOT NULL auto_increment, 
					address varchar(1024), 
					primary key(id)) engine=myisam";
	mysql_query($query);

	//Уникальные посетители
	$query = "CREATE TABLE IF NOT EXISTS $tbl_unique(
					id smallint unsigned NOT NULL auto_increment, 
					mdate datetime,
					count smallint, 
					primary key(id)) engine=myisam";
	mysql_query($query);

	//Браузеры
	$query = "CREATE TABLE IF NOT EXISTS $tbl_browsers(
					id smallint unsigned NOT NULL auto_increment, 
					name varchar(128), 
					PRIMARY key(id)) engine=myisam";
	mysql_query($query);

	//Операционные системы
	$query = "CREATE TABLE IF NOT EXISTS $tbl_os(
					id smallint unsigned NOT NULL auto_increment, 
					name varchar(128), 
					PRIMARY key(id)) engine=myisam";
	mysql_query($query);

	//Посещаемость страниц
	$query = "CREATE TABLE IF NOT EXISTS $tbl_stats(
					id bigint unsigned NOT NULL auto_increment, 
					id_browser smallint unsigned, 
					id_os smallint unsigned,
					ip varchar(128), 
					host_name varchar(128), 
					ref_address varchar(1024), 
					begin_date datetime, 
					id_page smallint unsigned, 
					id_user int unsigned default null, 
					id_product int unsigned default null, 
					PRIMARY key(id)) engine=myisam";
	mysql_query($query);

	// 	Характеристика товара
	$query = "CREATE TABLE IF NOT EXISTS $tbl_charact(
					id smallint unsigned NOT NULL auto_increment, 
					id_product bigint unsigned, 
					name varchar(128), 
					value varchar(128), 
					PRIMARY key(id)) engine=myisam";
	mysql_query($query);
	debug(mysql_error(), 1);

	//Таблица товаров
	$query = "CREATE TABLE IF NOT EXISTS $tbl_product(
					id bigint unsigned NOT NULL auto_increment, 
					id_category smallint unsigned, 
					name varchar(350), 
					small_descr varchar(1024), 
					descr text, 
					small_image varchar(512), 
					image varchar(512), 
					price float, 
					date_add datetime, 
					PRIMARY key(id)) engine myisam";
	mysql_query($query);
	debug(mysql_error(), 1);

	//Категории товаров
	$query = "CREATE TABLE IF NOT EXISTS $tbl_category(
					id smallint unsigned NOT NULL auto_increment,
					name varchar(256), 
					description text, 
					PRIMARY key(id))engine=myisam";
	mysql_query($query);

	// Комментарии к товару
	$query = "CREATE TABLE IF NOT EXISTS $tbl_prod_comm(
					id int unsigned NOT NULL auto_increment, 
					id_user int unsigned, 
					id_product bigint unsigned, 
					comm varchar(2048), 
					prod_mark tinyint, 
					date_add datetime, 
					comm_mark tinyint, 
					PRIMARY key(id)) engine=myisam";
	mysql_query($query);

	// Заказ
	$query = "CREATE TABLE IF NOT EXISTS $tbl_order(
					id_order int unsigned NOT NULL auto_increment, 
					id_user int unsigned, 
					id_product bigint unsigned, 
					is_active tinyint default 1,
					date_add datetime, 
					PRIMARY key(id)) engine=myisam";
	mysql_query($query);

	// Пользователь
	$query = "CREATE TABLE IF NOT EXISTS $tbl_user(
					id int unsigned NOT NULL auto_increment, 
					fio varchar(256), 
					mail varchar(256), 
					address varchar(256), 
					date_b datetime, 
					login varchar(256),
					tel varchar(24), 
					password varchar(512), 
					image varchar(512), 
					discount decimal, 
					date_reg datetime,
					block ENUM('block', 'unblock') not null default 'unblock', 
					PRIMARY key(id)) engine=myisam";
	mysql_query($query);

	// Связанные товары
	$query = "CREATE TABLE IF NOT EXISTS $tbl_link(
					id_product bigint unsigned, 
					id_linked bigint unsigned) engine=myisam";
	mysql_query($query);

	$query = "CREATE TABLE IF NOT EXISTS admin( 
					login tinytext, 
					password tinytext) engine=myisam";
	mysql_query($query);
	$pswd = md5("root");
	$query = "insert ignore into admin
					set login='root', password='$pswd'";
	mysql_query($query);
 ?>Z:/home/localhost/www/eshop1/database/delete_tables.php<br><?php 
	function delete_product($id)
	{
		global $tbl_product, $tbl_charact;
		$query = "delete from $tbl_product where id='$id'";
		mysql_query($query);
		$query2 = "delete from $tbl_charact where id_product='$id'";
		mysql_query($query2);
		return $id.mysql_error().$query;
	}

	function delete_order($id)
	{
		global $tbl_order;
		//$query = "delete from $tbl_order where id_order='$id'";
		$query = "update $tbl_order set is_active=0 where id_order='$id'";
		mysql_query($query);
	}
	
 ?>Z:/home/localhost/www/eshop1/database/insert_tables.php<br><?php 
	function insert_into_stats($id_browser, $ip, $host, $ref, $id_page, $id_user, 
		$id_product, $id_os, $id_category)
	{
		global $tbl_stats;
		if ($id_product===null)
		{
			$id_product = "NULL";
		}
		else
		{
			$id_product = "'$id_product'";
		}
		if ($id_user===null)
		{
			$id_user = "NULL";
		}
		else
		{
			$id_user = "'$id_user'";
		}
		if ($id_category===null)
		{
			$id_category = "NULL";
		}
		else
		{
			$id_category = "'$id_category'";
		}
		$query = "INSERT INTO $tbl_stats(id_browser, ip, begin_date, id_page, id_user, id_product, id_os, id_category) 
						values('$id_browser', '$ip', now(), '$id_page', $id_user, $id_product, '$id_os', $id_category)";
		mysql_query($query);
		//echo $query.mysql_error();
		debug(__FILE__, 1);
	}

	function insert_into_user($fio, $mail, $address, $date_b, $login, $tel, $password, $image="")
	{
		global $tbl_user;
		$query = "insert into $tbl_user(fio, mail, address, date_b, login,
			       tel, password, image, discount, date_reg) values('$fio', '$mail', '$address', 
			       '$date_b', '$login',
			       '$tel', '$password', '$image', '0', now())";
		mysql_query($query);
		return mysql_error();
	}

	function insert_into_session($id_user)
	{
		global $tbl_sessions;
		$query = "insert into $tbl_sessions(id_user, begin_date) values('$id_user', now())";
		mysql_query($query);
	}

	function insert_into_product($name, $small_pic, $big_pic, $price, $short_desc, $long_desc, $category_id, $chars)
	{
		global $tbl_product;
		$query = "insert into $tbl_product(id_category, name, small_descr, 
			descr, small_image, image, price, date_add) values('$category_id', 
			'$name', '$short_desc',	'$long_desc', '$small_pic', '$big_pic', '$price', now())";
		mysql_query($query);
		$query = "select last_insert_id()";
		$res = mysql_query($query);
		if (mysql_num_rows($res)>0)
		{
			$row = mysql_fetch_row($res);
			$id = $row[0];
		}
		foreach ($chars as $name => $value) 
		{
			insert_into_chars($id, $name, $value);
		}
		return mysql_error().$query.$small_pic;
	}

	function insert_into_chars($id_product, $name, $value)
	{
		global $tbl_charact;
		$query = "insert into $tbl_charact(id_product, name, value) 
		values('$id_product', '$name', '$value')";
		mysql_query($query);
	}

	function insert_into_category($name, $desc)
	{
		global $tbl_category;
		$query = "insert into $tbl_category(name, description) values('$name', '$desc')";
		mysql_query($query);
	}

	function insert_into_order($prod, $user)
	{
		global $tbl_order;
		$query = "insert into $tbl_order(id_user, id_product, is_active, date_add) values('$user', '$prod', '1', now())";
		mysql_query($query);
		echo $query.mysql_error();	
	}
 ?>Z:/home/localhost/www/eshop1/database/select_tables.php<br><?php 
	function select_all_categories($limit=-1)
	{
		global $tbl_category;
		$str_limit = ($limit==-1) ? "" : " limit $limit";
		$query = "select * from $tbl_category order by name".$str_limit;
		return mysql_query($query);
	}

	function select_category_by_name($name)
	{
		global $tbl_category;
		$query = "select * from $tbl_category where name='$name'";
		$res = mysql_query($query);
		return mysql_fetch_assoc($res);
	}

	function select_product_by_id($id)
	{
		global $tbl_product;
		$query = "select * from $tbl_product where id='$id'";
		$res = mysql_query($query);
		return mysql_fetch_assoc($res);
	}

	function select_user_by_id($id)
	{
		global $tbl_user;
		$query = "select * from $tbl_user where id='$id'";
		$res = mysql_query($query);
		return mysql_fetch_assoc($res);
	}

	function select_chars_by_product($id_product)
	{
		global $tbl_charact;
		$query = "select * from $tbl_charact where id_product='$id_product'";
		$res = mysql_query($query);
		return $res;
	}

	function select_category_by_product($id_product)
	{
		global $tbl_product, $tbl_category;
		$query = "select * from $tbl_product as prod join $tbl_category
		as cat on cat.id=prod.id_category where prod.id='$id_product'";
		$res = mysql_query($query);
		return mysql_fetch_assoc($res);
	}

	function select_products_from_basket($user_id)
	{
		global $tbl_order, $tbl_product;
		$query = "select * from $tbl_order as a join $tbl_product as b on a.id_product=b.id
		where a.id_user='$user_id' and a.is_active='1'";
		$res = mysql_query($query);
		return $res;	
	}

	function select_from_basket($user_id, $func)
	{
		global $tbl_order, $tbl_product;
		$query = "select ".$func." from $tbl_order as a join $tbl_product as b
		on a.id_product=b.id where a.id_user=$user_id and a.is_active=1";
		$res = mysql_query($query);
		$ar = mysql_fetch_assoc($res);	
		return $ar[$func];	
	}

	function select_all_orders($start, $per_page)
	{
		global $tbl_order;
		$query = "select * from $tbl_order order by date_add DESC limit $start, $per_page";
		return mysql_query($query);
	}

	function count_orders()
	{
		global $tbl_order;
		$query = "select COUNT(*) from $tbl_order";
		$res = mysql_query($query);
		$ar = mysql_fetch_row($res);
		return $ar[0];

	}

?>Z:/home/localhost/www/eshop1/database/update_tables.php<br><?php 
	require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/database/insert_tables.php";

	function update_user_block($id, $block)
	{
		global $tbl_user;
		$query = "update $tbl_user set block='$block' where id='$id'";
		mysql_query($query);
	}

	function update_into_product($id, $name, $small_pic, $big_pic, $price, $short_desc, $long_desc, $category_id, $chars)
	{
		global $tbl_product, $tbl_charact;
		$query = "update $tbl_product
		set name='$name', small_image='$small_pic', image='$big_pic', small_descr='$short_desc',
			descr='$long_desc', price='$price', id_category='$category_id'
		where id='$id'
		";
		mysql_query($query);
		$query = "delete from $tbl_charact where id_product='$id'";
		mysql_query($query);
		if (count($chars)!=0)
		{
			foreach ($chars as $name => $value) 
			{
				insert_into_chars($id, $name, $value);
			}
		}
	}

	function make_order($user_id)
	{
		global $tbl_order;
		$query = "update $tbl_order set is_active=2 where id_user='$user_id' and is_active='1'";
		mysql_query($query);
		echo $query.mysql_error();
	}
 ?>Z:/home/localhost/www/eshop1/database/utils.php<br><?php 
	function orders_count($tbl_name)
	{
		$query = "select count(*) from $tbl_name";
		$res = mysql_query($query);
		$row = mysql_fetch_array($res, MYSQL_NUM);
		//debug($tbl_name.mysql_error(), 2);
		return $row[0];
	}
 ?>Z:/home/localhost/www/eshop1/debug.php<br><?php 
	define('DEBUG', 2);
	
	function debug($msg, $level = 1)
	{
		if (defined('DEBUG') && $level>=DEBUG) {
			echo "<br />[Debug message] $msg";
		}
	}
 ?>Z:/home/localhost/www/eshop1/extensions/add_get.php<br><?php 
	function add_get($url, $param, $pvalue = '') 
	{
    	$res = $url;
    	if (($p = strpos($res, '?')) !== false) 
    	{
	    	$paramsstr = substr($res, $p + 1);
		    $params = explode('&', $paramsstr);
		    $paramsarr = array();
		    foreach ($params as $value) 
		    {
	    		$tmp = explode('=', $value);
	    		$paramsarr[$tmp[0]] = (string) $tmp[1];
	    	}
	    	$paramsarr[$param] = $pvalue;
	    	$res = substr($res, 0, $p + 1);
	    	foreach ($paramsarr as $key => $value) 
	    	{
	    		$str = $key;
	    		if ($value !== '') 
	    		{
	    			$str .= '=' . $value;
	    		}
	    		$res .= $str . '&';
	    	}
	    	$res = substr($res, 0, -1);
    	} 
    	else 
    	{
    		$str = $param;
    		if ($pvalue) 
    		{
    			$str .= '=' . $pvalue;
    		}
    		$res .= '?' . $str;
    	}
    	return $res;
    }
 ?>Z:/home/localhost/www/eshop1/index.php<br><?php 
    require_once "stats/stats.php";
    require_once "database/select_tables.php";
    require_once "config.php";
    session_start();
    if (isset($_GET['out']))
    {
        if (isset($_SESSION['login']))
            unset($_SESSION['login']);
    }
    $cat = "";
    $srch = "";
    $psw = "";
    if (isset($_GET['cat']))
    {
        $cat = fix_string($_GET['cat']);
    }
    if (isset($_GET['srch']))
    {
        $srch = fix_string($_GET['srch']);
    }   
    if (isset($_GET['psw']))
    {
        $psw = intval($_GET['psw']);
    }
    else
    {
        $psw = 1;
    }
    if (empty($cat))
    {
        $w = select_all_categories(1);
        $row = mysql_fetch_assoc($w);
        $cat = $row['name'];
    }
	require_once "templates/top.php";
 ?>
</head>
<body>
	<div class="container">
		<?php 
			require_once "templates/header.php";
		 ?>

    	<div class="row">
    		<?php 
    			require_once "templates/left.php";
    		 ?>
    		<div class="span8">
    			<?php 
    				require_once "templates/info_block.php";
    			 ?>
    			<?php 
                    require_once "products/show_products.php";
                 ?>
    		</div>
    		<div class="span2">
	    		<?php 
	    			require_once "templates/search.php";	
	    			require_once "templates/right.php";
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
	<?php 
		require_once "templates/footer.php";
	 ?>
	</div>
</body>
</html>Z:/home/localhost/www/eshop1/miralab.php<br><?php 	

	function all_files($dir)
	{
		$files = array();
		$d = opendir($dir);
		echo $dir."<br>";
		while (false!==($file=readdir($d)))
		{
			if (is_file($file))
			{
				$files[] = $file;
			}
			else if (is_dir($file))
			{
				if ($file!=="." && $file!="..")
				{
					$files = array_merge($files, all_files($file));
				}					
			}
		}
		print_r($files);
		closedir($d);
		return $files;
	}

	$files = array(1);
	// error_reporting(E_ALL);
	// $handle = opendir(".");
	// while (false!==($file=readdir($handle)))
	// {
	// 	$files[] = $file;
	// }
	// closedir($handle);
	// foreach ($files as $file)
	// {
	// 	echo "$file<br>";
	// }
	$a = all_files(".");
	print_r($a);

 ?>Z:/home/localhost/www/eshop1/only_auth.php<br><?php 
	session_start();
	if (!isset($_SESSION['login']))
		header("Location: auth.php");
?>Z:/home/localhost/www/eshop1/product.php<br><?php 
    require_once "database/select_tables.php";
    require_once "config.php";
    session_start();
    $id = intval($_GET['id']);
    $product = select_product_by_id($id);
    if (!isset($_GET['id']))
    {
        $_SESSION['pnf'] = "1";
        session_write_close();
        header("Location: index.php");
        exit();
    }
    if ($product==null)
    {
        $_SESSION['errid'] = "1";
        session_write_close();
        header("Location: index.php");
        exit();
    }
    echo $_SESSION['pnf'];
	require_once "templates/top.php";
    
 ?>
</head>
<body>
	<div class="container">
		<?php 
			require_once "templates/header.php";
		 ?>
    	<div class="row">
    		<?php 
    			require_once "templates/left.php";
    		 ?>
    		<div class="span8">
    			<?php 
    				require_once "templates/info_block.php";
    			?>
                <h3>
                    <?php 
                        echo $product['name'];
                ?>
                </h3>
                <hr>
                <div class="row">
                    <?php 
                        $src = "http://placehold.it/150x95";
                        if (is_file($_SERVER['DOCUMENT_ROOT']."/".$product['image']))
                        {
                            $src = "/".$product['image'];
                        }
                     ?>
                    <div class="span2 offset1">
                        <img src="<?php echo $src; ?>">
                    </div>
                    <div class="span5">
                        <span class="price_product">
                            <?php 
                                echo $product['price']." $";
                             ?>                            
                        </span>
                        <?php 
                            if (isset($_SESSION['login'])) :
                         ?>
                            <input type='hidden' value="<?php echo $product['id']; ?> " />
                            <a href="" class="btn btn-success basket_btn basket-btn">
                                <i class="icon-shopping-cart icon-white"></i>

                                Добавить в корзину
                            </a>
                        <?php 
                            endif;
                         ?>
                        <div class="small_descr">
                            <?php 
                                echo $product['small_descr'];
                              ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="span7 offset1">
                        <hr>
                        <h4>Полное описание товара</h4>
                         <?php 
                            echo $product['descr'];
                          ?>
                    <hr>
                    <?php 
                        $chars = select_chars_by_product($product['id']);
                     ?>
                    <h4>Технические характеристики</h4>
                    <table class="table table-hover table-condensed">
                        <tr>
                            <th>Характеристика</th>
                            <th>Значение</th>
                        </tr>
                        <?php 
                           while ($row=mysql_fetch_assoc($chars))
                           {
                                echo "<tr>";
                                echo "<td>{$row['name']}</td>";
                                echo "<td>{$row['value']}</td>";
                                echo "</tr>";
                           }
                         ?>
                    </table>
                    <hr>
                    <!-- <h4>Отзывы покупателей</h4>
                    <div class="well">
                        <div>
                            Иван <br>
                            7 мая 2013 <br> <br>
                            На одних сайтах пишут что он не поддерживает T2, здесь в описании указано DVB-T2 ....так как, кто нибудь знает наверняка ...есть или нет поддержка Т2 ???
                        </div>

                    </div>
                    <div class="well">
                        <div>
                            Иван <br>
                            7 мая 2013 <br> <br>
                            На одних сайтах пишут что он не поддерживает T2, здесь в описании указано DVB-T2 ....так как, кто нибудь знает наверняка ...есть или нет поддержка Т2 ???
                        </div>

                    </div> -->
                    </div>
                </div>
    		</div>
            <div class="span2">
        		<?php 
        			require_once "templates/right.php";
        		 ?>
            </div>
    	</div>
        <?php 
            require_once "templates/footer.php";
        ?>
	</div>

</body>
</html>Z:/home/localhost/www/eshop1/products/basket_ajax.php<br><?php 
	session_start();
	require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/database/insert_tables.php";
	require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/config.php";
	$prod = $_POST['prod'];
	if (isset($_SESSION['id_user']))
		$id = $_SESSION['id_user'];
	else
		$id = 1;
	insert_into_order($prod, $id);
 ?>Z:/home/localhost/www/eshop1/products/config_product.php<br><?php 
	require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/config.php";
	require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/database/select_tables.php";
	require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/users/config_user.php";

	function filter_where_category($sql_where, $ct)
	{
		global $tbl_category;
		if ($ct!="Любое значение")
		{
			if (empty($sql_where)) 
			{
				$sql_beg = " where ";
			}
			else
			{
				$sql_beg = " and ";
			}
			$sql_where .= $sql_beg."  b.name='$ct' ";
		}
		return $sql_where;
	}

	function filter_where_price($sql_where, $price)
	{
		if (empty($sql_where)) 
		{
			$sql_beg = " where ";
		}
		else
		{
			$sql_beg = " and ";
		}
		switch ($price)
		{
			case '2':
				$sql_where .= $sql_beg." price<1 ";
				break;
			case '3':	
				$sql_where .= $sql_beg." price>=1 and price<100 ";
				break;
			case '4':	
				$sql_where .= $sql_beg." price>=100 and price<1000 ";
				break;
			case '5':	
				$sql_where .= $sql_beg." price>=1000 and price<10000";
				break;				
			case '6':	
				$sql_where .= $sql_beg."price>=10000";
				break;
		}
		return $sql_where;
	}

	function filter_products($start, $per_page)
	{
		global $tbl_product, $tbl_category;
		$sql_where = "";
		$sql_select = " select a.* from $tbl_product as a ";
		$sql_join = "";
		$sql_order = " order by date_add desc ";
		$sql_limit = " limit $start, $per_page ";

		if (isset($_GET['search_categories'])) 
		{
			$ct = fix_string($_GET['search_categories']);
			if ($ct!="Любое значение")
			{
				$sql_join = " join $tbl_category as b on a.id_category=b.id ";
				$sql_where = filter_where_category($sql_where, $ct);
			}
		}
		if (isset($_GET['search_date_added'])) 
		{
			$sql_where = filter_where_date("date_add", intval($_GET['search_date_added']), $sql_where);
		}
		if (isset($_GET['search_price']))
		{
			$price = intval($_GET['search_price']);
			if ($price!="Любое значение")
			{
				$sql_where = filter_where_price($sql_where, $price);
			}
		}
		if (isset($_GET['search_sorting']))
		{
			$sort = intval($_GET['search_sorting']);
			switch ($sort)
			{
				case '1':
					$sql_order = " order by price asc ";
					break;
				case '2':
					$sql_order = " order by price desc ";
					break;
				case '3':
					$sql_order = " order by date_add desc ";
					break;
				case '4':
					$sql_order = "";
					break;
				case '5':
					$sql_order = "";
					break;

			}
		}
		$query = $sql_select.$sql_join.$sql_where.$sql_order.$sql_limit;		
		$res = mysql_query($query); 
		return $res;
	}

	function get_category_by_product($id_product)
	{
		global $tbl_category, $tbl_product;
		$query = "select cat.name from $tbl_category as cat join $tbl_product 
		as prod on cat.id=prod.id_category where prod.id='$id_product'";
		$res = mysql_query($query);
		$row = mysql_fetch_assoc($res);
		return $row['name'];
	}

	function get_all_categories()
	{
		global $tbl_category;
		$query = "select name from $tbl_category";
		$res = mysql_query($query);
		return $res;
	}

	function chars_of_product($id)
	{
		global $tbl_charact;
		$query = "select * from $tbl_charact where id_product='$id'";
		$res = mysql_query($query);
		return $res;
	}

	function orders_product_count_where()
	{
		global $tbl_product, $tbl_category;
		$query = "select count(*) from $tbl_product as a ";
		$where = "";
		$sql_join = "";
		if (isset($_GET['search_categories']))
		{
			$ct = fix_string($_GET['search_categories']);
			if ($ct!="Любое значение")
			{
				$sql_join = " join $tbl_category as b on a.id_category=b.id ";
				$where = filter_where_category($where, $ct);
			}						
		}
		if (isset($_GET['search_date_added']))
			$where = filter_where_date("date_add", intval($_GET['search_date_added']), $where);;
		if (isset($_GET['search_price']))
			$where = filter_where_price($where, intval($_GET['search_price']));
		$query .= $sql_join.$where;
		$res = mysql_query($query);
		$row = mysql_fetch_array($res, MYSQL_NUM);
		return $row[0];
	}

	function orders_product_count_where_user($cat, $srch="")
	{
		global $tbl_product, $tbl_category;
		$query = "select count(*) from $tbl_product as a ";
		$where = "";
		$sql_join = "";
		$sql_order = "";
		$sql_join = " join $tbl_category as b on a.id_category=b.id ";
		$where = filter_where_category($where, $cat);
		$query .= $sql_join.$where;
		$res = mysql_query($query);
		$row = mysql_fetch_array($res, MYSQL_NUM);
		return $row[0];
	}

	function filter_products_user($start, $per_page, $category, $search, $sorted_by)
	{
		global $tbl_product, $tbl_category;
		$sql_where = "";
		$sql_select = " select a.* from $tbl_product as a ";
		$sql_join = "";
		$sql_order = " order by date_add desc ";
		$sql_limit = " limit $start, $per_page ";

		$sql_join = " join $tbl_category as b on a.id_category=b.id ";
		$sql_where = filter_where_category($sql_where, $category);

		switch ($sorted_by)
		{
			case '1':
				$sql_order = "order by price asc";
				break;
			case '2':
				$sql_order = "order by price desc";
				break;
			case '3':	//todo популярные
				$sql_order = " order by date_add desc ";
				
				break;
			case '4':
				$sql_order = "";
				break;
		}

		//todo search

		$query = $sql_select.$sql_join.$sql_where.$sql_order.$sql_limit;		
		$res = mysql_query($query); 
		return $res;
	}
?>Z:/home/localhost/www/eshop1/products/js/product.js<br>function get_parametr_from_url(param)
{
    var query = window.location.search.substring(1);
    var vars = query.split("&");
    for (var i = 0; i < vars.length; i++) {
        var pair = vars[i].split("=");
        if (pair[0]==param)
            return pair[1];
    };
    return -1;
}

jQuery(document).ready(function($) {
	$(document).on('click', 'a.paginate', search_paginate);    

	sel_val = $("#product_show_with").val();
	$("#product_show_with").change(function () {
		var val = $(this).val();
		if (val!==sel_val)
		{
			sel_val = val;
			page = "page=1";
			var str;
			if ((index = location.href.indexOf("?"))!=-1)
			{
			    str = location.href.substring(0, index+1);
			}
			else
			{
			    str = location.href+"?";
			}
			var param = get_parametr_from_url("cat");
			var param_str = "";
			if (param!==-1)
			{
				param_str = "&cat="+param;
			}
			location.href = str+page+(page=="" ? "" : "&")+"psw="+val+param_str;
		}
	});	

	$('.basket-btn').click(function (e) {
		var prod = $(this).prev().val();
		if (confirm("Вы уверены, что хотите добавить товар в корзину?"))
		{
			$.ajax({
					url: "products/basket_ajax.php",
					type: "POST",
					dataType: "text",
					success: function (data) {
						//alert(data);
						alert("Товар добавлен в корзину!")
						location.href = "basket.php";
					},
					error: function (obj, err) {
						alert("Error "+err);
					},
					data: {prod: prod}
				});
		}
		return false;
	});

	$(document).on('click', '.delete_from_basket', function () {
		var prod = $(this).next().val();
		if (confirm("Вы уверены, что хотите удалить товар из корзины?"))
		{
			$.ajax({
						url: "templates/show_basket.php",
						type: "POST",
						dataType: "text",
						success: function (data) {
							$('#basket_ajax').html(data);							
						},
						error: function (obj, err) {
							alert("Error "+err);
						},
						data: {delete_id: prod}
					});
		}
		return false;
	});

	$(document).on('click', '.make_order', function () {
		if (confirm("Вы уверены, что хотите сделать заказ на все эти товары?"))
		{
			var user_id = $(this).next().val();
			$.ajax({
						url: "products/make_order_ajax.php",
						type: "POST",
						dataType: "text",
						success: function (data) {
							//alert(data)	
							alert("Ваша заявка отправлена")
							location.href = "index.php";					
						},
						error: function (obj, err) {
							alert("Error "+err);
						},
						data: {user_id: user_id}
					});
		}
		return false;
	});

	$('a.disabled').click(function (e) {
		return false;
	});
});


Z:/home/localhost/www/eshop1/products/make_order_ajax.php<br><?php 
	require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/config.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/database/update_tables.php";
	if (isset($_POST['user_id']))
		$user_id = $_POST['user_id'];
	make_order($user_id);
 ?>Z:/home/localhost/www/eshop1/products/show_products.php<br><?php 
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
 ?>Z:/home/localhost/www/eshop1/project_size.php<br><?php 
	
	$start_files=array("style.css","foo.js");
	$stop_files=array("jquery-1.9.1.min.js", "all.php");
	$stop_folder=array("bootstrap", "temp", "font_awesome", "php-ofc-library", "admin/js");
	$files=array();

	function get_files($root,&$files,$start_files)
	{
		global $stop_folder, $stop_files;
		if (count($stop_folder)>0)
		{
			foreach ($stop_folder as $fold) 
			{
				if (strpos($root, "/".$fold)!==false)
					return;
			}
		}
		$folder=opendir($root);
		while (($file=readdir($folder))!==false) {
			if (is_file($root."/".$file)) {
				$reg = preg_replace("/.*?\./", '', $file);
				if ($reg=="php" || $reg=="js") {
					if (!in_array($file, $stop_files))
					{
						$files[]=$root."/".$file;
					}
				}
				foreach ($start_files as $key=>$good) {
					if (strpos($file,$good)!==false) {
						$files[]=$root."/".$file;
						unset($start_files[$key]);
						break;		
					}
				}
				
			}
			elseif ($file!="." && $file!=".." && is_dir($root."/".$file)) {
				get_files($root."/".$file,$files,$start_files);
			}
		}
		closedir($folder);
	}

	$root=$_SERVER['DOCUMENT_ROOT'];
	//$root=$root."/".strtok($_SERVER['PHP_SELF'],"/")."<br>";
	//$root.=""
	$root.="/".strtok($_SERVER['PHP_SELF'],"/");
	get_files($root,$files,$start_files);
	echo preg_replace("/.*?\./", '', 'photo.php');
	foreach ($files as $file) {
		echo $file."<br>";
		//echo preg_replace("/.*?\./", '', $file)."<br>";
	}
	$f=fopen("all.php", "w");
	foreach ($files as $file) {
		if ((strpos($file, "all.php"))!==false) {
			continue;
		}

		$readed=fopen($file,"r");
		$size = filesize($file);
		if ($size>0)
		{
			$text=fread($readed, $size);
		}
		else
		{
			$text = 0;
		}
		$text=$file."<br>".$text;
		//echo $text;
		fclose($readed);
		fwrite($f, $text);
	}
	fclose($f);
	
 ?>Z:/home/localhost/www/eshop1/register.php<br><?php 
    $title = "Регистрация";
    require_once "stats/stats.php";
    require_once "templates/top.php";
 ?>
 <script src="ajax/js/register.js"></script>
</head>
<body>
	<div class="container">
		<?php 
			require_once "templates/header.php";
		 ?>

    	<div class="row">
    		<?php 
    			require_once "templates/left.php";
    		 ?>
    		<div class="span8">
    			<?php 
    				//require_once "templates/info_block.php";
                 ?>
                <div class="row">
                    <div class="offset2 span6">
                        <?php 
                require_once "users/register_form.php"
            ?>
                    </div>
                </div>    			
    		</div>
    	</div>
       
    <?php 
		require_once "templates/footer.php";
	 ?>
	</div>
</body>
</html>Z:/home/localhost/www/eshop1/stats/count.php<br><?php

  // Название таблиц
  $tbl_ip       = 'powercounter_ip';             
  $tbl_pages    = 'powercounter_pages';          
  $tbl_refferer = 'powercounter_refferer';       
  $tbl_searchquerys = 'powercounter_searchquerys';

  // Параметры соединения
  $dblocation = "localhost";
  $dbname = "eshop";
  $dbuser = "root";
  $dbpasswd = "";

  $ip = $_SERVER['REMOTE_ADDR'];
  if(empty($ip)) $ip = '0.0.0.0';

  // Соединяемся с сервером базы данных
  $dbcnx = @mysql_connect($dblocation, $dbuser, $dbpasswd);
  if(!$dbcnx) return;
  // Выбираем базу данных
  if(!@mysql_select_db($dbname,$dbcnx)) exit();
  // Если название не указано - формируем URL
  if(empty($titlepage)) 
  {
    $titlepage = "http://".$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'];
  }
  // Экранируем спец-символы
  $titlepage = mysql_escape_string($titlepage);
  // Проверяем нет ли такой страницы в базе данных
  $query = "SELECT id_page FROM $tbl_pages 
            WHERE title = '$titlepage'"; 
  $pgs = mysql_query($query); 
  if ($pgs) 
  {
    // Выясним, первичный ключ (id_page) 
    // текущей страницы  (по названию страницы) 
    if(mysql_num_rows($pgs)>0) $id_page = mysql_result($pgs,0); 
    // Если название данной страницы отсутствует в таблице pages 
    // то проверяем сраницу по ее адресу. 
    else 
    {   
      $query = "SELECT id_page FROM $tbl_pages 
                WHERE name='$_SERVER[PHP_SELF]'"; 
      $pgs = mysql_query($query); 
      if ($pgs) 
      {
        // Страница существует - обновляем её название
        if(mysql_num_rows($pgs)>0) 
        { 
         $id_page = mysql_result($pgs,0); 
         $query = "UPDATE $tbl_pages 
                   SET title = '$titlepage' 
                   WHERE id_page = $id_page"; 
         mysql_query($query); 
        } 
        // Если данная страница отсутствует в таблице pages 
        // и не разу не учитывалась - добавляем данную 
        // страницу в таблицу. 
        else 
        {   
          $query = "INSERT INTO $tbl_pages 
                    VALUES (NULL, 
                            '$_SERVER[PHP_SELF]',
                            '$titlepage', 
                            0)";
          @mysql_query($query); 
          // Выясняем первичный ключ только что добавленной 
          // страницы 
          $id_page = mysql_insert_id(); 
        } 
      }
    }
  }
  // Пользовательский агент
  $useragent = $_SERVER['HTTP_USER_AGENT'];
  $browser = 'none';
  // Выясняем браузер
  if(strpos($useragent, "Mozilla") !== false) $browser = 'mozilla';
  if(strpos($useragent, "MSIE")    !== false) $browser = 'msie';
  if(strpos($useragent, "MyIE")    !== false) $browser = 'myie';
  if(strpos($useragent, "Opera")   !== false) $browser = 'opera';
  if(strpos($useragent, "Netscape")!== false) $browser = 'netscape';
  if(strpos($useragent, "Firefox") !== false) $browser = 'firefox';
  // Выясняем операционную систему
  $os = 'none';
  if(strpos($useragent, "Win")      !== false) $os = 'windows';
  if(strpos($useragent, "Linux")    !== false 
  || strpos($useragent, "Lynx")     !== false
  || strpos($useragent, "Unix")     !== false) $os = 'unix';
  if(strpos($useragent, "Macintosh")!== false) $os = 'macintosh';
  if(strpos($useragent, "PowerPC")  !== false) $os = 'macintosh';
  // Выясняем принадлежность к поисковым роботам
  if(strpos($useragent, "StackRambler") !== false) $os = 'robot_rambler';
  if(strpos($useragent, "Googlebot")    !== false) $os = 'robot_google';
  if(strpos($useragent, "Yandex")       !== false) $os = 'robot_yandex';
  if(strpos($useragent, "Aport")        !== false) $os = 'robot_aport';
  if(strpos($useragent, "msnbot")       !== false) $os = 'robot_msnbot';
  $search = 'none';

  // Это строчка с реферером - URL страницы, с которой
  // посетитель пришёл на сайт
  if(!isset($_SERVER['HTTP_REFERER'])) $_SERVER['HTTP_REFERER'] = "";
  $reff = urldecode($_SERVER['HTTP_REFERER']);
  // Выясняем принадлежность к поисковым системам
  if(strpos($reff,"yandex"))  $search = 'yandex';
  if(strpos($reff,"rambler")) $search = 'rambler';
  if(strpos($reff,"google"))  $search = 'google';
  if(strpos($reff,"aport"))   $search = 'aport';
  if(strpos($reff,"mail") && strpos($reff,"search"))   $search = 'mail';
  if(strpos($reff,"msn") && strpos($reff,"results"))   $search = 'msn';
  $server_name = $_SERVER["SERVER_NAME"];
  if(substr($_SERVER["SERVER_NAME"],0,4) == "www.")
  {
    $server_name = substr($_SERVER["SERVER_NAME"], 4);
  }
  if(strpos($reff,$server_name)) $search = 'own_site';

  // Заносим всю собранную информацию в базу данных
  $query_main = "INSERT INTO $tbl_ip VALUES (                                           
             NULL,
             INET_ATON('$ip'),
             NOW(),
             $id_page,
             '$browser',
             '$os')";
  @mysql_query($query_main);
  if(!empty($reff) && $search=="none")
  {
    $reff = mysql_escape_string($reff);
    $query_reff = "INSERT INTO $tbl_refferer VALUES (
             NULL,
             '$reff',
             now(),
             INET_ATON('$ip'),
             $id_page)";
    @mysql_query($query_reff);
  }
  //вносим поисковый запрос в соответствующую таблицу
  if(!empty($reff) && $search!="none" && $search != "own_site")
  {
    switch($search)
    {
      case 'yandex':
      {
        preg_match("|text=([^&]+)|is", $reff."&", $out);
        if(strpos($reff,"yandpage")!=null)
          $quer = convert_cyr_string(urldecode($out[1]),"k","w");
        else
          $quer=$out[1];
        break;
      }
      case 'rambler':
      {
        preg_match("|words=([^&]+)|is", $reff."&", $out);
        $quer = win_utf8($out[1]);
        break;
      }
      case 'mail':
      {
        preg_match("|q=([^&]+)|is", $reff."&", $out);
        $quer = win_utf8($out[1]);
        break;
      }
      case 'google':
      {
        preg_match("|[^a]q=([^&]+)|is", $reff."&", $out);
        $quer = $out[1]; 
        break;
      }
      case 'msn':
      {
        preg_match("|q=([^&]+)|is", $reff."&", $out);
        $quer = $out[1];
        break;
      }
      case 'aport':
      {
        preg_match("|r=([^&]+)|is", $reff."&", $out);
        $quer = win_utf8($out[1]);
        break;
      }
    }
    $symbols = array("\"", "'", "(", ")", "+", ",", "-"); 
    $quer = str_replace($symbols, " ", $quer); 
    $quer = trim($quer); 
    $quer = preg_replace('|[\s]+|',' ',$quer); 
    $query = "INSERT INTO $tbl_searchquerys 
              VALUES (NULL, 
                      '$quer', 
                      NOW(), 
                      INET_ATON('$ip'), 
                      $id_page, 
                      '$search')";
    @mysql_query($query);
  }

  function win_utf8($str)
  {
    $win = array("а","б","в","г","д","е","ё","ж","з","и",
                 "й","к","л","м","н","о","п","р","с","т",
                 "у","ф","х","ц","ч","ш","щ","ъ","ы","ь",
                 "э","ю","я","А","Б","В","Г","Д","Е","Ё",
                 "Ж","З","И","Й","К","Л","М","Н","О","П",
                 "Р","С","Т","У","Ф","Х","Ц","Ч","Ш","Щ",
                 "Ъ","Ы","Ь","Э","Ю","Я"," ");
    $utf8 = array("\xD0\xB0","\xD0\xB1","\xD0\xB2","\xD0\xB3","\xD0\xB4",
                  "\xD0\xB5","\xD1\x91","\xD0\xB6","\xD0\xB7","\xD0\xB8",
                  "\xD0\xB9","\xD0\xBA","\xD0\xBB","\xD0\xBC","\xD0\xBD",
                  "\xD0\xBE","\xD0\xBF","\xD1\x80","\xD1\x81","\xD1\x82",
                  "\xD1\x83","\xD1\x84","\xD1\x85","\xD1\x86","\xD1\x87",
                  "\xD1\x88","\xD1\x89","\xD1\x8A","\xD1\x8B","\xD1\x8C",
                  "\xD1\x8D","\xD1\x8E","\xD1\x8F","\xD0\x90","\xD0\x91",
                  "\xD0\x92","\xD0\x93","\xD0\x94","\xD0\x95","\xD0\x81",
                  "\xD0\x96","\xD0\x97","\xD0\x98","\xD0\x99","\xD0\x9A",
                  "\xD0\x9B","\xD0\x9C","\xD0\x9D","\xD0\x9E","\xD0\x9F",
                  "\xD0\xA0","\xD0\xA1","\xD0\xA2","\xD0\xA3","\xD0\xA4",
                  "\xD0\xA5","\xD0\xA6","\xD0\xA7","\xD0\xA8","\xD0\xA9",
                  "\xD0\xAA","\xD0\xAB","\xD0\xAC","\xD0\xAD","\xD0\xAE",
                  "\xD0\xAF","+");
    return str_replace($win, $utf8, $str);
  }
?>Z:/home/localhost/www/eshop1/stats/query_stats.php<br><?php 
/*
Запросы для извлечения из таблиц статистики информации
которая используется в страницах результатов
*/

function all_pages()
{
	$query = "SELECT p.address,
        count(*)
		FROM stats AS s
		JOIN pages AS p ON s.id_page=p.id
		GROUP BY s.id_page";
	return mysql_query($query);
}

 ?>Z:/home/localhost/www/eshop1/stats/realization_stats.php<br><?php 
	function user_browser($agent)
	{
		preg_match("/(MSIE|Opera|Firefox|Chrome|Version|Opera Mini|Netscape|Konqueror|SeaMonkey|Camino|Minefield|Iceweasel|K-Meleon|Maxthon)(?:\/| )([0-9.]+)/", $agent, $browser_info); // регулярное выражение, которое позволяет отпределить браузер
		list(, $browser, $version) = $browser_info;
		if (preg_match("/Opera ([0-9.]+)/i", $agent, $opera)) 
			return 'Opera '.$opera[1]; // определение старых версий Оперы (до 8.50)
        if ($browser == 'MSIE') // если браузер определён как IE
        { 
        	preg_match("/(Maxthon|Avant Browser|MyIE2)/i", $agent, $ie); // проверяем, не разработка ли это на основе IE
        	if ($ie) 
        		return $ie[1].' основан на IE '.$version; // если да, то возвращаем сообщение об этом
            return 'IE '.$version; // иначе просто возвращаем IE и номер версии
        }
        if ($browser == 'Firefox') // если браузер определён как Firefox
        { 
                preg_match("/(Flock|Navigator|Epiphany)\/([0-9.]+)/", $agent, $ff); // проверяем, не разработка ли это на основе Firefox
                if ($ff) 
                	return $ff[1].' '.$ff[2]; // если да, то выводим номер и версию
        }
        if ($browser == 'Opera' && $version == '9.80') 
        	return 'Opera '.substr($agent,-5); // если браузер определён как Opera 9.80, берём версию Оперы из конца строки
        if ($browser == 'Version') // определяем Сафари
        	return 'Safari '.$version; 
        if (!$browser && strpos($agent, 'Gecko')) 
        	return 'Browser based on Gecko'; // для неопознанных браузеров проверяем, если они на движке Gecko, и возращаем сообщение об этом
        return $browser.' '.$version; // для всех остальных возвращаем браузер и версию
	}

    function user_os($agent)
    {
        if(strstr($agent, "Win")) $os = "Windows";
        elseif ((strstr($agent, "Mac")) || (ereg("PPC", etenv("HTTP_USER_AGENT")))) $os = "Mac";
        elseif (strstr($agent, "Linux")) $os = "Linux";
        elseif (strstr($agent, "FreeBSD")) $os = "FreeBSD";
        elseif (strstr($agent, "SunOS")) $os = "SunOS";
        elseif (strstr($agent, "IRIX")) $os = "IRIX";
        elseif (strstr($agent, "BeOS")) $os = "BeOS";
        elseif (strstr($agent, "OS/2")) $os = "OS/2";
        elseif (strstr($agent, "AIX")) $os = "AIX";
        // Выясняем принадлежность к поисковым роботам
        elseif (strstr($agent, "StackRambler")) $os = "robot_rambler";
        elseif (strstr($agent, "Googlebot")) $os = "robot_google";
        elseif (strstr($agent, "Yandex")) $os = "robot_yandex";
        elseif (strstr($agent, "Aport")) $os = "robot_aport";
        elseif (strstr($agent, "msnbot")) $os = "robot_msnbot";
        else $os = "none";
        return $os;
    }

    /*
    Возвращает id браузера (или страницы) по имени из таблицы
    Или если такого (-ой) нет создает новый
    */
    function id_with_name($name, $what)
    {
        global $tbl_browsers, $tbl_pages, $tbl_os;
        if ($what=="browser") 
        {
            $query = "select id from $tbl_browsers where name='$name' limit 1";
        }
        elseif ($what=="page")
        {
            $query = "select id from $tbl_pages where address='$name' limit 1";   
        }    
        elseif ($what=="os")    
        {
            $query = "select id from $tbl_os where name='$name' limit 1";   
        }
        $res = mysql_query($query);
        if (mysql_num_rows($res) == 0) 
        {
            if ($what=="browser") 
            {
                $query = "insert into $tbl_browsers(name) values('$name')";
            }
            elseif ($what=="page") 
            {
                $query = "insert into $tbl_pages(address) values('$name')";   
            }            
            elseif ($what=="os") 
            {
                $query = "insert into $tbl_os(name) values('$name')";   
            }            
            mysql_query($query);
            $res_id = mysql_insert_id();
        }
        else
        {
            $res_id = mysql_result($res, 0);
        }
        return $res_id;
    }

    function unique_users()
    {
        global $tbl_unique;
        $curdate = mktime(0, 0, 0, date("m"), date("d"), date("Y"));
        $nextday = mktime(0, 0, 0, date("m"), date("d")+1, date("Y"));
        if (!isset($_COOKIE['lastvisit'])) 
        {
            setcookie("lastvisit", $curdate, $nextday);
            $mdate = date("d m Y");
            $query = "select * from $tbl_unique where mdate='$mdate' limit 1";
            $res = mysql_query($query);
            if (mysql_num_rows($res)>0) 
            {
                $query = "update $tbl_unique set count=count+1";
            }
            else
            {
                $query = "insert into $tbl_unique(mdate, count) 
                values($mdate, 1)";
            }
            mysql_query($query);
        }
    }
 ?>Z:/home/localhost/www/eshop1/stats/stats.php<br><?php 
	/*
	TODO
	После каждого require везде вызвать для их файлов функцию, которая
	занесет в stats эти файлы (по их имени в качестве параметра)
	*/
	session_start();
	require_once "realization_stats.php";
	require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/config.php";
	require_once $server_root."/database/insert_tables.php";
	require_once $server_root."/database/select_tables.php";

	$agent=$_SERVER['HTTP_USER_AGENT'];

	$browser = user_browser($agent);
	$os = user_os($agent);
	/*
	Если браузер есть в базе, получаем его индекс.
	Иначе добавляем в базу новый браузер
	*/
	$id_browser = id_with_name($browser, "browser");
	$id_os = id_with_name($os, "os");
	//unique_users();
	$ip = $_SERVER['REMOTE_ADDR'];
	$host = $_SERVER['SERVER_NAME'];
	$ref = $_SERVER['HTTP_REFERER'];
	$id_page = id_with_name($_SERVER['PHP_SELF'], "page");
	$id_user = null;
	$id_product = null;	
	$id_category = null;
	if (isset($_SESSION['id_user']))
	{
		$id_user = $_SESSION['id_user'];
	}
	if (strpos($_SERVER['PHP_SELF'], "product.php")!==false && isset($_GET['id']))
	{
		$id_product = $_GET['id'];
	}
	if (isset($_GET['cat']))
	{
		 $categ = select_category_by_name($_GET['cat']);
		 $id_category = $categ['id'];
	}
	insert_into_stats($id_browser, $ip, $host, $ref, $id_page, $id_user,$id_product, $id_os, $id_category);

?>Z:/home/localhost/www/eshop1/test.php<br><?php 
	include("pChart/class/pData.class.php");
include("pChart/class/pDraw.class.php");
include("pChart/class/pPie.class.php");
include("pChart/class/pImage.class.php");
/* pData object creation */
$MyData = new pData();
/* Data definition */
$MyData->addPoints(array(20,30,25,10),"Value");
/* Labels definition */
$MyData->addPoints(array("January","February","March","April"),"Legend");
$MyData->setAbscissa("Legend");
/* Create the pChart object */
$myPicture = new pImage(600,300,$MyData);
/* Draw a gradient background */
$myPicture->drawGradientArea(0,0,600,300,DIRECTION_HORIZONTAL,array("StartR"=>220,"StartG"=>220,"StartB"=>220,"EndR"=>180,"EndG"=>180,
"EndB"=>180,"Alpha"=>100));
/* Add a border to the picture */
$myPicture->drawRectangle(0,0,599,299,array("R"=>0,"G"=>0,"B"=>0));
/* Create the pPie object */
$PieChart = new pPie($myPicture,$MyData);
/* Enable shadow computing */
$myPicture->setShadow(FALSE);
/* Set the default font properties */
$myPicture->setFontProperties(array("FontName"=>"pChart/fonts/Forgotte.ttf","FontSize"=>10,"R"=>80,"G"=>80,"B"=>80));
/* Draw a splitted pie chart */
$PieChart->draw3DPie(250,150,array("Radius"=>140,"DrawLabels"=>TRUE,"DataGapAngle"=>10,"DataGapRadius"=>6,"Border"=>TRUE));
/* Render the picture (choose the best way) */
//$myPicture->autoOutput("pie.png");

 ?>Z:/home/localhost/www/eshop1/users/auth_form.php<br><form action="auth.php" method="post" class="_form" id="auth_form">
	<div id="auth_error"></div>
	<label for="">Логин</label> <br>
	<input type="text" name="" id="login"> <br>
	<label for="">Пароль</label> <br>
	<input type="password" name="" id="password"> <br>
	<!-- <a href="">Забыли пароль?</a> 
	<div id="remember"> <input type="checkbox" name="" id=""> запомнить </div> <br> <br>
	 -->
	<input class="btn" type="submit" value="Войти"> <br> <br>
	<a href="register.php" class="btn btn-primary">Регистрация</a>
</form>
Z:/home/localhost/www/eshop1/users/config_user.php<br><?php 
	require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/config.php";
	require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/database/insert_tables.php";

	function filter_where_date($date_name, $vl, $sql_where="")
	{
		//количество дней от регистрации до сегодня
		if (empty($sql_where)) 
		{
			$sql_beg = " where ";
		}
		else
		{
			$sql_beg = " and ";
		}
		$sql_tmp = $sql_beg." datediff(now(), ".$date_name.")";
		switch ($vl) {
			case '2':	//первый день
				$sql_where .= $sql_tmp."<=1 ";
				break;
			case '3':	//меньше недели
				$sql_where .= $sql_tmp."<7 ";
				break;
			case '4':	//меньше месяца
				$sql_where .= $sql_tmp."<30 ";
				break;
			case '5':	//меньше года
				$sql_where .= $sql_tmp."<365 ";
				break;				
			case '6':	//больше года
				$sql_where .= $sql_tmp.">=365 ";
				break;
		}
		return $sql_where;
	}
	/*
	Вход в систему по верному логину и паролю
	Новая сессия
	*/
	function enter($login, $password)
	{
		global $tbl_user, $tbl_sessions;
		$query = "select * from $tbl_user where login='$login' limit 1";
		$res = mysql_query($query);
		if (mysql_num_rows($res)==0) 
		{
			return false;
		}
		$row = mysql_fetch_array($res);
		if ($row['password'] != encrypt($password)) 
		{
			return false;
		}
		if ($row['block']=='block') 
		{
			return -1;
		}
		$_SESSION['login'] = $row['login'];
		$_SESSION['id_user'] = $row['id'];
		//insert_into_session($row['id']);
		return true;
	}

	/*
	Информация о пользователе по id
	*/
	function user($id)
	{
		global $tbl_user;
		$query = "select * from $tbl_user where id='$id' limit 1";
		$res = mysql_query($query);
		if (mysql_num_rows($res)>0) 
		{
			return mysql_fetch_array($res);
		}
		else
		{
			return 0;
		}
	}

	function out()
	{
		session_unset();
		session_destroy();
	}

	function encrypt($pswd)
	{
		return md5($salt.$pswd);
	}

	function filter_users($start, $per_page)
	{
		global $tbl_user, $city_user_array;
		$sql_where = "";
		$sql_select = " select * from $tbl_user ";
		$sql_order = " order by date_reg desc ";
		$sql_limit = " limit $start, $per_page ";
		//$query = "select * from $tbl_user order by date_reg desc limit $start, $per_page";
		if (isset($_GET['s_site'])) 
		{
			$int_site = intval($_GET['s_site']);
			if ($int_site!=1)	//Не Любое значение
			{
				$sql_where = filter_where_date("date_reg", $int_site);
			}
		}
		if (isset($_GET['s_age'])) 
		{
			$vl = intval($_GET['s_age']);
			if ($vl!=1)		//Не Любое значение
			{
				/*
				Возраст пользоватедя по дню рождения
				первым шагом вычитаем из текущего года, год рождения, 
				вторым шагом вычитаем единичку если 
				дня рождения в этом году ещё не было
				*/
				$sql_tmp = " (YEAR(CURRENT_DATE) - YEAR(date_b)) - 
					(DATE_FORMAT(CURRENT_DATE, '%m%d') < DATE_FORMAT(date_b, '%m%d'))";
				//Уже добавлен фильтр по дате регистрации
				if (empty($sql_where)) 
				{
					$sql_beg = " where ";
				}
				else
				{
					$sql_beg = " and ";
				}
				switch ($vl) {
					case '2':	//менее 18
						$sql_where .= $sql_beg.$sql_tmp."<18 ";		
						break;
					case '3':	//18-40
						$sql_where .= $sql_beg.$sql_tmp.">=18 AND ".$sql_tmp."<=40 ";
						break;
					case '4':	//более 40
						$sql_where .= $sql_beg.$sql_tmp.">40 ";
						break;
				}			
			}
		}
		if (isset($_GET['s_city'])) 
		{
			$index = intval($_GET['s_city']);
			if ($index!=-1)
			{
				if (isset($city_user_array[$index])) 
				{
					$city = $city_user_array[$index];
					if (empty($sql_where)) 
					{
						$sql_beg = " where ";
					}
					else
					{
						$sql_beg = " and ";
					}
					$sql_where .= $sql_beg."address like '%$city%' ";
				}
			}
		}
		if (isset($_GET['text_search'])) 
		{
			/*
			TODO Поиск по основным полям (по каким?)
			*/
			$search = fix_string($_GET['text_search']);
		}
		$query = $sql_select.$sql_where.$sql_order.$sql_limit;		
		$res = mysql_query($query); 
		$query = $sql_select.$sql_where.$sql_order;
		$res2 = mysql_query($query); 
		$count = mysql_num_rows($res2);
		return array($res, $count);
		//return $res;
	}
 ?>Z:/home/localhost/www/eshop1/users/correct_fields.php<br><?php 
	require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/config.php";
	$errors = array();

	function correct_login($login)
	{
		global $errors, $tbl_user;
		if (empty($login)) 
		{
			$errors['login'] = "Поле обязательно для заполнения";
			return false;
		}
		if ((strlen($login)<6)||(strlen($login)>256)) 
		{
			$errors['login'] = "Логин не менее 6 и не более 256 символов";
			return false;
		}
		//Проверяем уникальность логина
		$query = "select * from $tbl_user where login='$login' limit 1";
		$res = mysql_query($query);
		if (mysql_num_rows($res)>0) 
		{	
			$errors['login'] = "Такой логин уже есть в базе";
			return false;
		}
		return true;
	}

	function correct_pass($pass, $pass_rpt)
	{
		global $errors;
		$pass = strtolower($pass);
		$pass_rpt = strtolower($pass_rpt);
		if (empty($pass)) 
		{
			$errors['pass'] = "Поле обязательно для заполнения";
		}
		if (empty($pass_rpt)) 
		{
			$errors['pass_rpt'] = "Поле обязательно для заполнения";
		}
		if (isset($errors['pass'], $errors['pass_rpt'])) 
		{
			return false;
		}
		if ($pass!=$pass_rpt) 
		{
			$errors['pass'] = "Пароли должны совпадать";
			return false;
		}
		return true;
	}

	function correct_fam($fam)
	{
		global $errors;
		if (empty($fam)) 
		{
			$errors['fam'] = "Поле обязательно для заполнения";
			return false;
		}		
		return true;
	}

	function correct_im($im)
	{
		global $errors;
		// if (empty($im)) 
		// {
		// 	$errors['im'] = "Поле обязательно для заполнения";
		// 	return false;
		// }		
		return true;
	}

	function correct_ot($ot)
	{
		global $errors;
		// if (empty($ot)) 
		// {
		// 	$errors['ot'] = "Поле обязательно для заполнения";
		// 	return false;
		// }		
		return true;
	}

	function correct_email($email)
	{
		global $errors;
		// if (empty($email)) 
		// {
		// 	$errors['email'] = "Поле обязательно для заполнения";
		// 	return false;
		// }		
		return true;
	}

	function correct_tel($tel)
	{
		global $errors;
		if (empty($tel)) 
		{
			$errors['tel'] = "Поле обязательно для заполнения";
			return false;
		}		
		return true;
	}

	function correct_addr($addr)
	{
		global $errors;
		if (empty($addr)) 
		{
			$errors['addr'] = "Поле обязательно для заполнения";
			return false;
		}		
		return true;
	}

?>Z:/home/localhost/www/eshop1/users/register_form.php<br><form action="register.php" method="post" class="_form">
	<label for="">Логин<span class="error_message">*</span> </label> <br>
	<input type="text" name="" id="login" 
		title = <?php echo "'$tool_login'"; ?>   		 >
		<span class="error_form"></span>
		<br>

	<label for="">Пароль<span class="error_message">*</span></label> <br>
	<input type="password" name="" id="pass"  
		title = <?php echo "'$tool_pass'"; ?>    		>
		<span class="error_form"></span>
	<br>

	<label for="">Повтор пароля<span class="error_message">*</span></label> <br>
	<input type="password" name="" id="pass_rpt"  
		title = <?php echo "'$tool_pass_rpt'";  		 ?> >
		<span class="error_form"></span>
	<br>

	<label for="">Фамилия<span class="error_message">*</span></label> <br>
	<input type="text" name="" id="fam"  
		title = <?php echo "'$tool_fam'"; ?>  >
		<span class="error_form"></span>
	<br>

	<label for="">Имя</label> <br>
	<input type="text" name="" id="im"  
		title = <?php echo "'$tool_im'"; ?>  >
		<span class="error_form"></span>
	<br>

	<label for="">Отчество</label> <br>
	<input type="text" name="" id="ot"  
		title = <?php echo "'$tool_ot'"; ?>  >
		<span class="error_form"></span>
	<br>

	<label for="">Email</label> <br>
	<input type="text" name="" id="email"  
		title = <?php echo "'$tool_email'"; ?>   		 >
		<span class="error_form"></span>
	<br>

	<label for="">Моб. телефон<span class="error_message">*</span></label> <br>
	<input type="text" name="" id="tel"  
		title = <?php echo "'$tool_tel'"; ?>  >
		<span class="error_form"></span>
	<br>

	<label for="">Адрес доставки<span class="error_message">*</span></label> <br>
	<textarea name="" id="addr" cols="30" rows="10" class="round5" maxlength="200" title = <?php echo "'$tool_addr'"; ?> > <br>
		
	</textarea>
		<span class="error_form"></span>
	<br>
	<input class="btn" type="submit" value="Регистрация" onsubmit="ajax_reg();return false;">				
</form>Z:/home/localhost/www/eshop1/utils/footer.php<br><div id="footer">
	<a href="">asdasdas</a>|
	<a href="">asdasdas</a>|
	<a href="">asdasdas</a>	
</div>Z:/home/localhost/www/eshop1/utils/header.php<br><div id="header">
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
</div>Z:/home/localhost/www/eshop1/utils/left_menu.php<br><div id="categories">
	<a href="">safsdfsd <br /> <span>asdfsdfsd</span> </a>
	<a href="">safsdfsd</a>
	<a href="">safsdfsd</a>
</div>

		Z:/home/localhost/www/eshop1/utils/paginate.php<br><?php 
	//контролирует длину пагинации
	
	if ($num_pages==1 || $num_pages==0) 
	{
		exit();
	}
	$length = 3;
	$pages = array($page);
	for ($i=$page-1; $i > $page-$length; $i--) 
	{
		if ($i>1) 
		{
			array_unshift($pages, $i); 	
		} 		
	}
	for ($j=$page+1; $j<$page+$length; $j++) 
	{ 
		if ($j<$num_pages) 
		{
			array_push($pages, $j);
		}
		
	}
	if ($page-$length>1) 
	{
		array_unshift($pages, -($page-$length));
	}
	if ($page+$length<$num_pages) 
	{
		array_push($pages, -($page+$length));
	}
	if ($page!=1) 
	{
		array_unshift($pages, 1);
	}
	if ($page!=$num_pages) 
	{
		array_push($pages, $num_pages);
	}
	echo "<div class='btn-group'>";
	for ($i=0; $i < count($pages); $i++) 
	{ 
		$act_class = "";
		if ($page==$pages[$i]) 
		{
			$act_class = " active";
		}
		$tmp = ($pages[$i]<0) ? (-$pages[$i]) : $pages[$i];
		echo "<a href='".$_SERVER['PHP_SELF']."?page=".$tmp.$pag_search."' class='btn paginate ".$act_class."'>";	
		if ($pages[$i]<0) 
		{
			echo "...";
		}
		else
		{
			echo $pages[$i];
		}
		echo "</a>";
	}
	echo "</div>";
?>Z:/home/localhost/www/eshop1/utils/top_menu.php<br><div id="top_menu" class="round5">
	<div>
		<a href="#">asdasdasdwq</a>
		<a href="#">asdasdasdwq</a>
		<a href="#">asdasdasdwq</a>
		<input type="text" name="" id="" class="search" />
	</div>
</div>