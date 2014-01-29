<?php 
	session_start();
	require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/database/insert_tables.php";
	require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/config.php";
	$prod = $_POST['prod'];
	if (isset($_SESSION['id_user']))
		$id = $_SESSION['id_user'];
	else
		$id = 1;
	insert_into_order($prod, $id);
 ?>