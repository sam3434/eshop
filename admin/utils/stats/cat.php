<?php 
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
