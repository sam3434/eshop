<?php 
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
?>