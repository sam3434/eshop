<?php 
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
