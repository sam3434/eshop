<?php 
	function _trim($string)
	{
		return preg_replace("/(^\s+)|(\s+$)/", "", $string);
	}
	// $s = "вапаваааяяя";
	// preg_match_all("/а+/", $s, $matches);
	// print_r($matches);
	// echo count($matches[0]);
	// echo preg_replace("/а/", "п", $s);

	// $s = "sadegu";
	// preg_match_all("/[aeuio]+/", $s, $matches);
	// print_r($matches);
	// $s = "asd asdf sef sefs   fs";
	// preg_match_all("/\S+/", $s, $matches);
	// print_r($matches);
	// print_r(explode(" ", $s));



	// //Фамилия
	// $f = "Ыываываыва";
	// echo preg_match("//", $s);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>Document</title>
</head>
<body>
	
	<form action= <?php echo "'".$_SERVER['PHP_SELF']."'"; ?> method="post">
	<input type="text" name="fio" id="">
	<input type="submit" value="Submit">
	
</form>
</body>
</html>

<?php 
	if (isset($_POST['fio'])) {
		$f = $_POST['fio'];
		//ФИО
		$res = preg_match("/^[a-zа-я]+-?[a-zа-я]+$/i", $f);
		echo "<br>";
		if ($res) {	
			echo "good";
		}
		else{
			echo "bad";
		}
	}
 ?>