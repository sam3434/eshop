<?php 
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
?>