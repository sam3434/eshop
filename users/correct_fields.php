<?php 
	require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/config.php";
	$errors = array();

	function correct_login($login)
	{
		global $errors, $tbl_user;
		if (empty($login)) 
		{
			$errors['login'] = "Поле обязательно для заполнения";
			return false;
		}
		if ((strlen($login)<6)||(strlen($login)>256)) 
		{
			$errors['login'] = "Логин не менее 6 и не более 256 символов";
			return false;
		}
		//Проверяем уникальность логина
		$query = "select * from $tbl_user where login='$login' limit 1";
		$res = mysql_query($query);
		if (mysql_num_rows($res)>0) 
		{	
			$errors['login'] = "Такой логин уже есть в базе";
			return false;
		}
		return true;
	}

	function correct_pass($pass, $pass_rpt)
	{
		global $errors;
		$pass = strtolower($pass);
		$pass_rpt = strtolower($pass_rpt);
		if (empty($pass)) 
		{
			$errors['pass'] = "Поле обязательно для заполнения";
		}
		if (empty($pass_rpt)) 
		{
			$errors['pass_rpt'] = "Поле обязательно для заполнения";
		}
		if (isset($errors['pass'], $errors['pass_rpt'])) 
		{
			return false;
		}
		if ($pass!=$pass_rpt) 
		{
			$errors['pass'] = "Пароли должны совпадать";
			return false;
		}
		return true;
	}

	function correct_fam($fam)
	{
		global $errors;
		if (empty($fam)) 
		{
			$errors['fam'] = "Поле обязательно для заполнения";
			return false;
		}		
		return true;
	}

	function correct_im($im)
	{
		global $errors;
		// if (empty($im)) 
		// {
		// 	$errors['im'] = "Поле обязательно для заполнения";
		// 	return false;
		// }		
		return true;
	}

	function correct_ot($ot)
	{
		global $errors;
		// if (empty($ot)) 
		// {
		// 	$errors['ot'] = "Поле обязательно для заполнения";
		// 	return false;
		// }		
		return true;
	}

	function correct_email($email)
	{
		global $errors;
		// if (empty($email)) 
		// {
		// 	$errors['email'] = "Поле обязательно для заполнения";
		// 	return false;
		// }		
		return true;
	}

	function correct_tel($tel)
	{
		global $errors;
		if (empty($tel)) 
		{
			$errors['tel'] = "Поле обязательно для заполнения";
			return false;
		}		
		return true;
	}

	function correct_addr($addr)
	{
		global $errors;
		if (empty($addr)) 
		{
			$errors['addr'] = "Поле обязательно для заполнения";
			return false;
		}		
		return true;
	}

?>