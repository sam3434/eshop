<?php 
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
