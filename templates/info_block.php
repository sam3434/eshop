<?php 
	$str = "";
	if (isset($_SESSION['pnf']))
	{
		$str = "Вы были перенаправлены со страницы информации о продукте. <br>
    		Не выбран конкрентный продукт!";
		unset($_SESSION['pnf']);
	}
	if (isset($_SESSION['errid']))
	{
		$str = "Вы были перенаправлены со страницы информации о продукте. <br>
    		Неверный идентификатор продукта!";
		unset($_SESSION['errid']);
	}
	if (!empty($str))
	{
		$html=<<<__div
		    <div class="alert alert-block">
    		<button type="button" class="close" data-dismiss="alert">&times;</button>
    		<h4>Внимание!</h4>
    		$str
    		</div>
__div;
		echo $html;
	}
	if (isset($_GET['id']))
	{
		$id = intval($_GET['id']);
		$w = select_category_by_product($id);
		$cat = $w['name'];
	}
	$cat_desc = select_category_by_name($cat);
	echo "<div class='alert alert-info'>";
	echo "<h4>$cat</h4>";
	echo "{$cat_desc['description']}";
	echo "</div>";
	
 ?>