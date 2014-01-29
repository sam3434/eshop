<?php 
	session_start();
	require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/users/correct_fields.php";
	require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/users/config_user.php";
	if (isset($_POST['login'])) 
	{
		$login = trim(fix_string($_POST['login']));
		$pass = trim(fix_string($_POST['pass']));
		$res = enter($login, $pass);
		if (!$res) 
		{
			echo "Ошибка авторизации";
		}
		elseif ($res<0)
		{
			echo "Ваш аккаунт заблокирован. <br> Обратитесь к администратору!";
		}
		else
		{
			echo "";
		}
	}
?>