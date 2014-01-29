<?php 
	function insert_into_stats($id_browser, $ip, $host, $ref, $id_page, $id_user, 
		$id_product, $id_os, $id_category)
	{
		global $tbl_stats;
		if ($id_product===null)
		{
			$id_product = "NULL";
		}
		else
		{
			$id_product = "'$id_product'";
		}
		if ($id_user===null)
		{
			$id_user = "NULL";
		}
		else
		{
			$id_user = "'$id_user'";
		}
		if ($id_category===null)
		{
			$id_category = "NULL";
		}
		else
		{
			$id_category = "'$id_category'";
		}
		$query = "INSERT INTO $tbl_stats(id_browser, ip, begin_date, id_page, id_user, id_product, id_os, id_category) 
						values('$id_browser', '$ip', now(), '$id_page', $id_user, $id_product, '$id_os', $id_category)";
		mysql_query($query);
		//echo $query.mysql_error();
		debug(__FILE__, 1);
	}

	function insert_into_user($fio, $mail, $address, $date_b, $login, $tel, $password, $image="")
	{
		global $tbl_user;
		$query = "insert into $tbl_user(fio, mail, address, date_b, login,
			       tel, password, image, discount, date_reg) values('$fio', '$mail', '$address', 
			       '$date_b', '$login',
			       '$tel', '$password', '$image', '0', now())";
		mysql_query($query);
		return mysql_error();
	}

	function insert_into_session($id_user)
	{
		global $tbl_sessions;
		$query = "insert into $tbl_sessions(id_user, begin_date) values('$id_user', now())";
		mysql_query($query);
	}

	function insert_into_product($name, $small_pic, $big_pic, $price, $short_desc, $long_desc, $category_id, $chars)
	{
		global $tbl_product;
		$query = "insert into $tbl_product(id_category, name, small_descr, 
			descr, small_image, image, price, date_add) values('$category_id', 
			'$name', '$short_desc',	'$long_desc', '$small_pic', '$big_pic', '$price', now())";
		mysql_query($query);
		$query = "select last_insert_id()";
		$res = mysql_query($query);
		if (mysql_num_rows($res)>0)
		{
			$row = mysql_fetch_row($res);
			$id = $row[0];
		}
		foreach ($chars as $name => $value) 
		{
			insert_into_chars($id, $name, $value);
		}
		return mysql_error().$query.$small_pic;
	}

	function insert_into_chars($id_product, $name, $value)
	{
		global $tbl_charact;
		$query = "insert into $tbl_charact(id_product, name, value) 
		values('$id_product', '$name', '$value')";
		mysql_query($query);
	}

	function insert_into_category($name, $desc)
	{
		global $tbl_category;
		$query = "insert into $tbl_category(name, description) values('$name', '$desc')";
		mysql_query($query);
	}

	function insert_into_order($prod, $user)
	{
		global $tbl_order;
		$query = "insert into $tbl_order(id_user, id_product, is_active, date_add) values('$user', '$prod', '1', now())";
		mysql_query($query);
		echo $query.mysql_error();	
	}
 ?>