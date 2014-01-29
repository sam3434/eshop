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