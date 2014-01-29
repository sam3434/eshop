<?php 
	require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/config.php";
	require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/database/insert_tables.php";

	function filter_where_date($date_name, $vl, $sql_where="")
	{
		//количество дней от регистрации до сегодня
		if (empty($sql_where)) 
		{
			$sql_beg = " where ";
		}
		else
		{
			$sql_beg = " and ";
		}
		$sql_tmp = $sql_beg." datediff(now(), ".$date_name.")";
		switch ($vl) {
			case '2':	//первый день
				$sql_where .= $sql_tmp."<=1 ";
				break;
			case '3':	//меньше недели
				$sql_where .= $sql_tmp."<7 ";
				break;
			case '4':	//меньше месяца
				$sql_where .= $sql_tmp."<30 ";
				break;
			case '5':	//меньше года
				$sql_where .= $sql_tmp."<365 ";
				break;				
			case '6':	//больше года
				$sql_where .= $sql_tmp.">=365 ";
				break;
		}
		return $sql_where;
	}
	/*
	Вход в систему по верному логину и паролю
	Новая сессия
	*/
	function enter($login, $password)
	{
		global $tbl_user, $tbl_sessions;
		$query = "select * from $tbl_user where login='$login' limit 1";
		$res = mysql_query($query);
		if (mysql_num_rows($res)==0) 
		{
			return false;
		}
		$row = mysql_fetch_array($res);
		if ($row['password'] != encrypt($password)) 
		{
			return false;
		}
		if ($row['block']=='block') 
		{
			return -1;
		}
		$_SESSION['login'] = $row['login'];
		$_SESSION['id_user'] = $row['id'];
		//insert_into_session($row['id']);
		return true;
	}

	/*
	Информация о пользователе по id
	*/
	function user($id)
	{
		global $tbl_user;
		$query = "select * from $tbl_user where id='$id' limit 1";
		$res = mysql_query($query);
		if (mysql_num_rows($res)>0) 
		{
			return mysql_fetch_array($res);
		}
		else
		{
			return 0;
		}
	}

	function out()
	{
		session_unset();
		session_destroy();
	}

	function encrypt($pswd)
	{
		return md5($salt.$pswd);
	}

	function filter_users($start, $per_page)
	{
		global $tbl_user, $city_user_array;
		$sql_where = "";
		$sql_select = " select * from $tbl_user ";
		$sql_order = " order by date_reg desc ";
		$sql_limit = " limit $start, $per_page ";
		//$query = "select * from $tbl_user order by date_reg desc limit $start, $per_page";
		if (isset($_GET['s_site'])) 
		{
			$int_site = intval($_GET['s_site']);
			if ($int_site!=1)	//Не Любое значение
			{
				$sql_where = filter_where_date("date_reg", $int_site);
			}
		}
		if (isset($_GET['s_age'])) 
		{
			$vl = intval($_GET['s_age']);
			if ($vl!=1)		//Не Любое значение
			{
				/*
				Возраст пользоватедя по дню рождения
				первым шагом вычитаем из текущего года, год рождения, 
				вторым шагом вычитаем единичку если 
				дня рождения в этом году ещё не было
				*/
				$sql_tmp = " (YEAR(CURRENT_DATE) - YEAR(date_b)) - 
					(DATE_FORMAT(CURRENT_DATE, '%m%d') < DATE_FORMAT(date_b, '%m%d'))";
				//Уже добавлен фильтр по дате регистрации
				if (empty($sql_where)) 
				{
					$sql_beg = " where ";
				}
				else
				{
					$sql_beg = " and ";
				}
				switch ($vl) {
					case '2':	//менее 18
						$sql_where .= $sql_beg.$sql_tmp."<18 ";		
						break;
					case '3':	//18-40
						$sql_where .= $sql_beg.$sql_tmp.">=18 AND ".$sql_tmp."<=40 ";
						break;
					case '4':	//более 40
						$sql_where .= $sql_beg.$sql_tmp.">40 ";
						break;
				}			
			}
		}
		if (isset($_GET['s_city'])) 
		{
			$index = intval($_GET['s_city']);
			if ($index!=-1)
			{
				if (isset($city_user_array[$index])) 
				{
					$city = $city_user_array[$index];
					if (empty($sql_where)) 
					{
						$sql_beg = " where ";
					}
					else
					{
						$sql_beg = " and ";
					}
					$sql_where .= $sql_beg."address like '%$city%' ";
				}
			}
		}
		if (isset($_GET['text_search'])) 
		{
			/*
			TODO Поиск по основным полям (по каким?)
			*/
			$search = fix_string($_GET['text_search']);
		}
		$query = $sql_select.$sql_where.$sql_order.$sql_limit;		
		$res = mysql_query($query); 
		$query = $sql_select.$sql_where.$sql_order;
		$res2 = mysql_query($query); 
		$count = mysql_num_rows($res2);
		return array($res, $count);
		//return $res;
	}
 ?>