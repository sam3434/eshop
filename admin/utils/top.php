<?php 
	//require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/stats/stats.php";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>
		<?php 
		echo $title;
		 ?>
	</title>
	<link href="utils/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
	<link href="utils/bootstrap/css/bootstrap-responsive.css" rel="stylesheet" media="screen">
	<script src="http://code.jquery.com/jquery-latest.js"></script>
	<script src="utils/bootstrap/js/bootstrap.min.js"></script>
	
	<script type="text/javascript" src="utils/bootstrap/js/bootstrap-dropdown.js"></script>
	<script type="text/javascript" src="utils/bootstrap/js/bootstrap-tab.js"></script>
	<?php 
		$script_name = $_SERVER['PHP_SELF'];
		$js_users=<<<__js
		<script src="../ajax/js/user_info.js"></script>
		<script src="../ajax/js/user_search.js"></script>	
__js;

$js_products=<<<__js
		<script type="text/javascript" src="utils/js/top.js"></script>
__js;
		if (strpos($script_name, "users.php")!==false)
			echo $js_users;
		if (strpos($script_name, "products.php")!==false)
			echo $js_products;
		if (strpos($script_name, "add_product.php")!==false)
			echo $js_products;
		echo '<script type="text/javascript" src="utils/js/search_paginate.js"></script>';
	?>		
	<script src="utils/js/navbar.js"></script>
	<link rel="stylesheet" href="../css/style.css">
	<script>
		jQuery(document).ready(function($) {
			$('.dropdown-toggle').dropdown();
		});
	</script>
	