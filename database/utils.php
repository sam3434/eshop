<?php 
	function orders_count($tbl_name)
	{
		$query = "select count(*) from $tbl_name";
		$res = mysql_query($query);
		$row = mysql_fetch_array($res, MYSQL_NUM);
		//debug($tbl_name.mysql_error(), 2);
		return $row[0];
	}
 ?>