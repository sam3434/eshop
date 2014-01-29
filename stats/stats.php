<?php 
	/*
	TODO
	После каждого require везде вызвать для их файлов функцию, которая
	занесет в stats эти файлы (по их имени в качестве параметра)
	*/
	session_start();
	require_once "realization_stats.php";
	require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/config.php";
	require_once $server_root."/database/insert_tables.php";
	require_once $server_root."/database/select_tables.php";

	$agent=$_SERVER['HTTP_USER_AGENT'];

	$browser = user_browser($agent);
	$os = user_os($agent);
	/*
	Если браузер есть в базе, получаем его индекс.
	Иначе добавляем в базу новый браузер
	*/
	$id_browser = id_with_name($browser, "browser");
	$id_os = id_with_name($os, "os");
	//unique_users();
	$ip = $_SERVER['REMOTE_ADDR'];
	$host = $_SERVER['SERVER_NAME'];
	$ref = $_SERVER['HTTP_REFERER'];
	$id_page = id_with_name($_SERVER['PHP_SELF'], "page");
	$id_user = null;
	$id_product = null;	
	$id_category = null;
	if (isset($_SESSION['id_user']))
	{
		$id_user = $_SESSION['id_user'];
	}
	if (strpos($_SERVER['PHP_SELF'], "product.php")!==false && isset($_GET['id']))
	{
		$id_product = $_GET['id'];
	}
	if (isset($_GET['cat']))
	{
		 $categ = select_category_by_name($_GET['cat']);
		 $id_category = $categ['id'];
	}
	insert_into_stats($id_browser, $ip, $host, $ref, $id_page, $id_user,$id_product, $id_os, $id_category);

?>