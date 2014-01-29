<?php 
	function select_all_categories($limit=-1)
	{
		global $tbl_category;
		$str_limit = ($limit==-1) ? "" : " limit $limit";
		$query = "select * from $tbl_category order by name".$str_limit;
		return mysql_query($query);
	}

	function select_category_by_name($name)
	{
		global $tbl_category;
		$query = "select * from $tbl_category where name='$name'";
		$res = mysql_query($query);
		return mysql_fetch_assoc($res);
	}

	function select_product_by_id($id)
	{
		global $tbl_product;
		$query = "select * from $tbl_product where id='$id'";
		$res = mysql_query($query);
		return mysql_fetch_assoc($res);
	}

	function select_user_by_id($id)
	{
		global $tbl_user;
		$query = "select * from $tbl_user where id='$id'";
		$res = mysql_query($query);
		return mysql_fetch_assoc($res);
	}

	function select_chars_by_product($id_product)
	{
		global $tbl_charact;
		$query = "select * from $tbl_charact where id_product='$id_product'";
		$res = mysql_query($query);
		return $res;
	}

	function select_category_by_product($id_product)
	{
		global $tbl_product, $tbl_category;
		$query = "select * from $tbl_product as prod join $tbl_category
		as cat on cat.id=prod.id_category where prod.id='$id_product'";
		$res = mysql_query($query);
		return mysql_fetch_assoc($res);
	}

	function select_products_from_basket($user_id)
	{
		global $tbl_order, $tbl_product;
		$query = "select * from $tbl_order as a join $tbl_product as b on a.id_product=b.id
		where a.id_user='$user_id' and a.is_active='1'";
		$res = mysql_query($query);
		return $res;	
	}

	function select_from_basket($user_id, $func)
	{
		global $tbl_order, $tbl_product;
		$query = "select ".$func." from $tbl_order as a join $tbl_product as b
		on a.id_product=b.id where a.id_user=$user_id and a.is_active=1";
		$res = mysql_query($query);
		$ar = mysql_fetch_assoc($res);	
		return $ar[$func];	
	}

	function select_all_orders($start, $per_page)
	{
		global $tbl_order;
		$query = "select * from $tbl_order order by date_add DESC limit $start, $per_page";
		return mysql_query($query);
	}

	function count_orders()
	{
		global $tbl_order;
		$query = "select COUNT(*) from $tbl_order";
		$res = mysql_query($query);
		$ar = mysql_fetch_row($res);
		return $ar[0];

	}

?>