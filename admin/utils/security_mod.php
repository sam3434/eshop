<?php 
	function unauthorized()
	{
		header("WWW-Authenticate: Basic realm=\"Admin Page\"");
		header("HTTP/1.0 401 Unauthorized");
		exit();
	}

	require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/config.php";
	//Если пользователь не авторизован - авторизуем
	if (!isset($_SERVER['PHP_AUTH_USER'])) 
	{
		unauthorized();	
	}
	else
	{
		if (!get_magic_quotes_gpc()) 
		{
			$_SERVER['PHP_AUTH_USER'] = mysql_real_escape_string($_SERVER['PHP_AUTH_USER']);
			$_SERVER['PHP_AUTH_PW'] = mysql_real_escape_string($_SERVER['PHP_AUTH_PW']);
		}
		$query = "select password from admin where login='".$_SERVER['PHP_AUTH_USER']."'";
		$res = @mysql_query($query);
		if (!$res) 
		{
			unauthorized();
		}
		if (mysql_num_rows($res) == 0) 
		{
			unauthorized();
		}
		$pass = mysql_fetch_array($res);
		if (md5($_SERVER['PHP_AUTH_PW']) != $pass['password']) 
		{
			unauthorized();	
		}
	}
	
 ?>