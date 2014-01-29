<?php 
	require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/users/config_user.php";
	require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/admin/utils/products/correct_fields.php";
	require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/database/insert_tables.php";
	require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/database/update_tables.php";
	global $errors;
	$errors = array();
	$name = trim(fix_string($_POST['name']));
	$small_pic = trim(fix_string($_POST['small_pic']));
	$big_pic = trim(fix_string($_POST['big_pic']));
	$price = trim(fix_string($_POST['price']));
	$short_desc = trim(fix_string($_POST['short_desc']));
	$long_desc = trim(fix_string($_POST['long_desc']));
	$mode = $_POST['mode'];
	$category_id = intval($_POST['category_id']);
	$chars = $_POST['chars'];
	$id = $_POST['id'];
	correct_name($name);
	correct_price($price);
	if (count($chars)!=0)
	{
		foreach ($chars as $key => $value) 
		{
			correct_chars($key, $value);
		}	
	}
	if (count($errors)==0) 
	{
		$errors['href'] = "products.php";
		if ($mode=="create")
		{
			$errors['er'] = insert_into_product($name, $small_pic, $big_pic, $price, $short_desc, $long_desc, $category_id, $chars);
		}
		else
		{
			$errors['er'] = update_into_product($id, $name, $small_pic, $big_pic, $price, $short_desc, $long_desc, $category_id, $chars);	
		}
		echo json_encode($errors);
	}
	else
	{
		echo json_encode($errors);
	}
?>