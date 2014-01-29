<?php 
	//header('Content-type: application/json');
	session_start();
	require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/users/correct_fields.php";
	require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/users/config_user.php";
	require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/database/insert_tables.php";
	global $errors;
	$errors = array();
	$login = trim(fix_string($_POST['login']));
	$pass = trim(fix_string($_POST['pass']));
	$pass_rpt = trim(fix_string($_POST['pass_rpt']));
	$fam = trim(fix_string($_POST['fam']));
	$im = trim(fix_string($_POST['im']));
	$ot = trim(fix_string($_POST['ot']));
	$email = trim(fix_string($_POST['email']));
	$tel = trim(fix_string($_POST['tel']));
	$addr = trim(fix_string($_POST['addr']));
	$fio = $fam." ".$im." ".$ot;
	correct_login($login);
	correct_pass($pass, $pass_rpt);
	correct_fam($fam);
	correct_im($im);
	correct_ot($ot);
	correct_email($email);
	correct_tel($tel);
	correct_addr($addr);
	if (count($errors)==0) 
	{
		$errors['href'] = "index.php";
		$pass = encrypt($pass);
		$errors['er'] = insert_into_user($fio, $email, $addr, date("m/d/y g:i A", time()), $login, $tel, $pass);
		$_SESSION['login'] = $login;
		echo json_encode($errors);
	}
	else
	{
		echo json_encode($errors);
	}
?>