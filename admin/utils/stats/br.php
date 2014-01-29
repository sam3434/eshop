<?php 
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
