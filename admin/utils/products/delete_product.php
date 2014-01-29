<?php 
	require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/database/delete_tables.php";
	require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/config.php";
	if (isset($_POST['delete_id'])) 
	{
		$id = intval($_POST['delete_id']);
		$ret = delete_product($id);
		echo $ret;
	}
 ?>