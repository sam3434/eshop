<?php 
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
