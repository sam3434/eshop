<?php 
	function delete_product($id)
	{
		global $tbl_product, $tbl_charact;
		$query = "delete from $tbl_product where id='$id'";
		mysql_query($query);
		$query2 = "delete from $tbl_charact where id_product='$id'";
		mysql_query($query2);
		return $id.mysql_error().$query;
	}

	function delete_order($id)
	{
		global $tbl_order;
		//$query = "delete from $tbl_order where id_order='$id'";
		$query = "update $tbl_order set is_active=0 where id_order='$id'";
		mysql_query($query);
	}
	
 ?>