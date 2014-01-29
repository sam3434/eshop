<?php 
	global $tbl_stats;
	//$query = "select date(begin_date), count(date(begin_date)) from $tbl_stats ";
	$arr = array();
	for ($i=30; $i >= 0; $i--) 
	{ 
		// $date = " where date(begin_date) = DATE_SUB(CURDATE(), INTERVAL $i DAY)";
		// $res = mysql_query($query.$date." group by date(begin_date)");		
		$query = "select DATE_SUB(CURDATE(), INTERVAL $i DAY)";
		$res = mysql_query($query);
		$date_t = mysql_result($res, 0);
		$query = "select count(*) from $tbl_stats where date(begin_date) = DATE_SUB(CURDATE(), INTERVAL $i DAY)";
		$res = mysql_query($query);
		$count = mysql_result($res, 0);
		array_push($arr, array($date_t, $count));		
	}
?>