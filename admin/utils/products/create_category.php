<?php 
	require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/users/config_user.php";
	require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/admin/utils/products/correct_fields.php";
	require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/database/insert_tables.php";
	if (isset($_POST['name_category'])) 
	{
		global $errors;
		$name_category = trim(fix_string($_POST['name_category']));
		$desc_category = trim(fix_string($_POST['desc_category']));
		correct_name_category($name_category);
		correct_desc_category($desc_category);
		if (count($errors)==0) 
		{
			insert_into_category($name_category, $desc_category);
			echo json_encode($errors);
		}
		else
		{
			echo json_encode($errors);
		}		
	}
?>