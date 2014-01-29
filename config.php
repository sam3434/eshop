<?php 
	$server = "localhost";
	$db_name = "eshop";
	$db_user = "root";
	$db_password = "";

	/*
	Соль
	*/
	$salt = "#v5g!7$";
	/*
	Количество элементов в одной странице при пагинации
	*/
	$per_page = 3;
	$per_page_user = 9;

	/*
		Имена баз данных
	*/
	//Сессии пользователя (статистика)
	$tbl_sessions = "sessions";
	//Список страниц сайта с адресами
	$tbl_pages = "pages";
	//Браузеры
	$tbl_browsers = "browsers";
	//Статистика посещения страниц
	$tbl_stats = "stats";
	// 	Характеристика товара
	$tbl_charact = "charact";
	//Таблица товаров
	$tbl_product = "product";
	//Категории товаров
	$tbl_category = "category";
	// Комментарии к товару
	$tbl_prod_comm = "prod_comm";
	// Заказ
	$tbl_order = "order_prod";
	// Пользователь
	$tbl_user = "user";
	// Связанные товары
	$tbl_link = "link";
	// Операционные системы
	$tbl_os = "os";
	// Операционные системы
	$tbl_unique = "unique_users";

	/*
	Всплывающие подсказки для полей при регистрации
	*/
	// Логин
	$tool_login = "Логин должен быть не менее 6 и не более 30 символов";
	// Пароль
	$tool_pass = "";
	// Пароль повторно
	$tool_rpt = "";
	// Фамилия
	$tool_fam = "";
	// Имя
	$tool_im = "";
	// Отчество
	$tool_ot = "";
	// Электронная почта
	$tool_email = "";
	// Телефон мобильный
	$tool_tel = "";
	// Адрес доставки
	$tool_addr = "";

	/*
	Массив городов для фильтрации по пользователям
	*/
	$city_user_array = array("Киев",	"Харьков",	"Севастополь",	"Луцк", "Чернигов");
	$a = array(1,2,3);
	/*
	Подключение к БД
	*/
	$server_root = $_SERVER['DOCUMENT_ROOT']."/eshop1/";
	$handle = @mysql_connect($server, $db_user, $db_password);
	if (!$hanlde) 
	{
		$query = "create database if not exists $db_name";
		mysql_query($query);
		$handle = @mysql_connect($server, $db_user, $db_password);
		if (!$handle) 
		{
			exit("<p>Ошибка подключения к БД</p>".mysql_error());	
		}		
	}
	if (! @mysql_select_db($db_name, $handle)) 
	{
		exit("<p>Ошибка выбора БД</p>".mysql_error());
	}
	mysql_query("SET NAMES 'utf8'");
	//mysql_query('SET NAMES "utf8"', $db);
	mysql_query("set character_set_connection=utf8");
	mysql_query("set names utf8");

	function fix_string($string)
	{
		return htmlentities(sql_fix_string($string), ENT_QUOTES, 'UTF-8');
	}

	function sql_fix_string($string)
	{
		if (get_magic_quotes_gpc()) 
		{
			$string = stripslashes($string);
		}
		return mysql_real_escape_string($string);
	}

	/*
	Создание всех таблиц при попытке подключения к бд с помощью if no exists

	*/
	//require_once "database/create_tables.php";
 ?>