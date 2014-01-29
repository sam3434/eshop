<?php 
	require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/database/insert_tables.php";

	function update_user_block($id, $block)
	{
		global $tbl_user;
		$query = "update $tbl_user set block='$block' where id='$id'";
		mysql_query($query);
	}

	function update_into_product($id, $name, $small_pic, $big_pic, $price, $short_desc, $long_desc, $category_id, $chars)
	{
		global $tbl_product, $tbl_charact;
		$query = "update $tbl_product
		set name='$name', small_image='$small_pic', image='$big_pic', small_descr='$short_desc',
			descr='$long_desc', price='$price', id_category='$category_id'
		where id='$id'
		";
		mysql_query($query);
		$query = "delete from $tbl_charact where id_product='$id'";
		mysql_query($query);
		if (count($chars)!=0)
		{
			foreach ($chars as $name => $value) 
			{
				insert_into_chars($id, $name, $value);
			}
		}
	}

	function make_order($user_id)
	{
		global $tbl_order;
		$query = "update $tbl_order set is_active=2 where id_user='$user_id' and is_active='1'";
		mysql_query($query);
		echo $query.mysql_error();
	}
 ?>