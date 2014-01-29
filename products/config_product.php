<?php 
	require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/config.php";
	require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/database/select_tables.php";
	require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/users/config_user.php";

	function filter_where_category($sql_where, $ct)
	{
		global $tbl_category;
		if ($ct!="Любое значение")
		{
			if (empty($sql_where)) 
			{
				$sql_beg = " where ";
			}
			else
			{
				$sql_beg = " and ";
			}
			$sql_where .= $sql_beg."  b.name='$ct' ";
		}
		return $sql_where;
	}

	function filter_where_price($sql_where, $price)
	{
		if (empty($sql_where)) 
		{
			$sql_beg = " where ";
		}
		else
		{
			$sql_beg = " and ";
		}
		switch ($price)
		{
			case '2':
				$sql_where .= $sql_beg." price<1 ";
				break;
			case '3':	
				$sql_where .= $sql_beg." price>=1 and price<100 ";
				break;
			case '4':	
				$sql_where .= $sql_beg." price>=100 and price<1000 ";
				break;
			case '5':	
				$sql_where .= $sql_beg." price>=1000 and price<10000";
				break;				
			case '6':	
				$sql_where .= $sql_beg."price>=10000";
				break;
		}
		return $sql_where;
	}

	function filter_products($start, $per_page)
	{
		global $tbl_product, $tbl_category;
		$sql_where = "";
		$sql_select = " select a.* from $tbl_product as a ";
		$sql_join = "";
		$sql_order = " order by date_add desc ";
		$sql_limit = " limit $start, $per_page ";

		if (isset($_GET['search_categories'])) 
		{
			$ct = fix_string($_GET['search_categories']);
			if ($ct!="Любое значение")
			{
				$sql_join = " join $tbl_category as b on a.id_category=b.id ";
				$sql_where = filter_where_category($sql_where, $ct);
			}
		}
		if (isset($_GET['search_date_added'])) 
		{
			$sql_where = filter_where_date("date_add", intval($_GET['search_date_added']), $sql_where);
		}
		if (isset($_GET['search_price']))
		{
			$price = intval($_GET['search_price']);
			if ($price!="Любое значение")
			{
				$sql_where = filter_where_price($sql_where, $price);
			}
		}
		if (isset($_GET['search_sorting']))
		{
			$sort = intval($_GET['search_sorting']);
			switch ($sort)
			{
				case '1':
					$sql_order = " order by price asc ";
					break;
				case '2':
					$sql_order = " order by price desc ";
					break;
				case '3':
					$sql_order = " order by date_add desc ";
					break;
				case '4':
					$sql_order = "";
					break;
				case '5':
					$sql_order = "";
					break;

			}
		}
		$query = $sql_select.$sql_join.$sql_where.$sql_order.$sql_limit;		
		$res = mysql_query($query); 
		return $res;
	}

	function get_category_by_product($id_product)
	{
		global $tbl_category, $tbl_product;
		$query = "select cat.name from $tbl_category as cat join $tbl_product 
		as prod on cat.id=prod.id_category where prod.id='$id_product'";
		$res = mysql_query($query);
		$row = mysql_fetch_assoc($res);
		return $row['name'];
	}

	function get_all_categories()
	{
		global $tbl_category;
		$query = "select name from $tbl_category";
		$res = mysql_query($query);
		return $res;
	}

	function chars_of_product($id)
	{
		global $tbl_charact;
		$query = "select * from $tbl_charact where id_product='$id'";
		$res = mysql_query($query);
		return $res;
	}

	function orders_product_count_where()
	{
		global $tbl_product, $tbl_category;
		$query = "select count(*) from $tbl_product as a ";
		$where = "";
		$sql_join = "";
		if (isset($_GET['search_categories']))
		{
			$ct = fix_string($_GET['search_categories']);
			if ($ct!="Любое значение")
			{
				$sql_join = " join $tbl_category as b on a.id_category=b.id ";
				$where = filter_where_category($where, $ct);
			}						
		}
		if (isset($_GET['search_date_added']))
			$where = filter_where_date("date_add", intval($_GET['search_date_added']), $where);;
		if (isset($_GET['search_price']))
			$where = filter_where_price($where, intval($_GET['search_price']));
		$query .= $sql_join.$where;
		$res = mysql_query($query);
		$row = mysql_fetch_array($res, MYSQL_NUM);
		return $row[0];
	}

	function orders_product_count_where_user($cat, $srch="")
	{
		global $tbl_product, $tbl_category;
		$query = "select count(*) from $tbl_product as a ";
		$where = "";
		$sql_join = "";
		$sql_order = "";
		$sql_join = " join $tbl_category as b on a.id_category=b.id ";
		$where = filter_where_category($where, $cat);
		$query .= $sql_join.$where;
		$res = mysql_query($query);
		$row = mysql_fetch_array($res, MYSQL_NUM);
		return $row[0];
	}

	function filter_products_user($start, $per_page, $category, $search, $sorted_by)
	{
		global $tbl_product, $tbl_category;
		$sql_where = "";
		$sql_select = " select a.* from $tbl_product as a ";
		$sql_join = "";
		$sql_order = " order by date_add desc ";
		$sql_limit = " limit $start, $per_page ";

		$sql_join = " join $tbl_category as b on a.id_category=b.id ";
		$sql_where = filter_where_category($sql_where, $category);

		switch ($sorted_by)
		{
			case '1':
				$sql_order = "order by price asc";
				break;
			case '2':
				$sql_order = "order by price desc";
				break;
			case '3':	//todo популярные
				$sql_order = " order by date_add desc ";
				
				break;
			case '4':
				$sql_order = "";
				break;
		}

		//todo search

		$query = $sql_select.$sql_join.$sql_where.$sql_order.$sql_limit;		
		$res = mysql_query($query); 
		return $res;
	}
?>