<?php 
	require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/config.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/database/update_tables.php";
	if (isset($_POST['user_id']))
		$user_id = $_POST['user_id'];
	make_order($user_id);
 ?>