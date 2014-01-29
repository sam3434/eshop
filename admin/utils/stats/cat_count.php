<?php 
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
?>