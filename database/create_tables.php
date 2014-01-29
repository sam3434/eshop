<?php 
	require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/config.php";

	//Сессии пользователя (статистика)
	$query = "CREATE TABLE IF NOT EXISTS $tbl_sessions(
					id int unsigned NOT NULL auto_increment, 
					id_user int unsigned,
					begin_date datetime, 
					exit_date datetime, 
					primary key(id)) engine=myisam";
	mysql_query($query);

	//Список страниц сайта с адресами
	$query = "CREATE TABLE IF NOT EXISTS $tbl_pages(
					id smallint unsigned NOT NULL auto_increment, 
					address varchar(1024), 
					primary key(id)) engine=myisam";
	mysql_query($query);

	//Уникальные посетители
	$query = "CREATE TABLE IF NOT EXISTS $tbl_unique(
					id smallint unsigned NOT NULL auto_increment, 
					mdate datetime,
					count smallint, 
					primary key(id)) engine=myisam";
	mysql_query($query);

	//Браузеры
	$query = "CREATE TABLE IF NOT EXISTS $tbl_browsers(
					id smallint unsigned NOT NULL auto_increment, 
					name varchar(128), 
					PRIMARY key(id)) engine=myisam";
	mysql_query($query);

	//Операционные системы
	$query = "CREATE TABLE IF NOT EXISTS $tbl_os(
					id smallint unsigned NOT NULL auto_increment, 
					name varchar(128), 
					PRIMARY key(id)) engine=myisam";
	mysql_query($query);

	//Посещаемость страниц
	$query = "CREATE TABLE IF NOT EXISTS $tbl_stats(
					id bigint unsigned NOT NULL auto_increment, 
					id_browser smallint unsigned, 
					id_os smallint unsigned,
					ip varchar(128), 
					host_name varchar(128), 
					ref_address varchar(1024), 
					begin_date datetime, 
					id_page smallint unsigned, 
					id_user int unsigned default null, 
					id_product int unsigned default null, 
					PRIMARY key(id)) engine=myisam";
	mysql_query($query);

	// 	Характеристика товара
	$query = "CREATE TABLE IF NOT EXISTS $tbl_charact(
					id smallint unsigned NOT NULL auto_increment, 
					id_product bigint unsigned, 
					name varchar(128), 
					value varchar(128), 
					PRIMARY key(id)) engine=myisam";
	mysql_query($query);
	debug(mysql_error(), 1);

	//Таблица товаров
	$query = "CREATE TABLE IF NOT EXISTS $tbl_product(
					id bigint unsigned NOT NULL auto_increment, 
					id_category smallint unsigned, 
					name varchar(350), 
					small_descr varchar(1024), 
					descr text, 
					small_image varchar(512), 
					image varchar(512), 
					price float, 
					date_add datetime, 
					PRIMARY key(id)) engine myisam";
	mysql_query($query);
	debug(mysql_error(), 1);

	//Категории товаров
	$query = "CREATE TABLE IF NOT EXISTS $tbl_category(
					id smallint unsigned NOT NULL auto_increment,
					name varchar(256), 
					description text, 
					PRIMARY key(id))engine=myisam";
	mysql_query($query);

	// Комментарии к товару
	$query = "CREATE TABLE IF NOT EXISTS $tbl_prod_comm(
					id int unsigned NOT NULL auto_increment, 
					id_user int unsigned, 
					id_product bigint unsigned, 
					comm varchar(2048), 
					prod_mark tinyint, 
					date_add datetime, 
					comm_mark tinyint, 
					PRIMARY key(id)) engine=myisam";
	mysql_query($query);

	// Заказ
	$query = "CREATE TABLE IF NOT EXISTS $tbl_order(
					id_order int unsigned NOT NULL auto_increment, 
					id_user int unsigned, 
					id_product bigint unsigned, 
					is_active tinyint default 1,
					date_add datetime, 
					PRIMARY key(id)) engine=myisam";
	mysql_query($query);

	// Пользователь
	$query = "CREATE TABLE IF NOT EXISTS $tbl_user(
					id int unsigned NOT NULL auto_increment, 
					fio varchar(256), 
					mail varchar(256), 
					address varchar(256), 
					date_b datetime, 
					login varchar(256),
					tel varchar(24), 
					password varchar(512), 
					image varchar(512), 
					discount decimal, 
					date_reg datetime,
					block ENUM('block', 'unblock') not null default 'unblock', 
					PRIMARY key(id)) engine=myisam";
	mysql_query($query);

	// Связанные товары
	$query = "CREATE TABLE IF NOT EXISTS $tbl_link(
					id_product bigint unsigned, 
					id_linked bigint unsigned) engine=myisam";
	mysql_query($query);

	$query = "CREATE TABLE IF NOT EXISTS admin( 
					login tinytext, 
					password tinytext) engine=myisam";
	mysql_query($query);
	$pswd = md5("root");
	$query = "insert ignore into admin
					set login='root', password='$pswd'";
	mysql_query($query);
 ?>