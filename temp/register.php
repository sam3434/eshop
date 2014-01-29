<?php 
	$title = "Регистрация";
	require_once "stats/stats.php";
	require_once "utils/top.php";
?>

<script src="ajax/js/register.js"></script>

</head>
<body> 
	<div id="container">		
		<?php 
			require_once "utils/header.php";
			require_once "utils/top_menu.php";
			require_once "utils/left_menu.php";
		 ?>
			
		<div id="main_content">
			<?php 
				require_once "users/register_form.php"
			?>
			
		</div>
		<?php 
			require_once "utils/footer.php";
		?>
	</div>
</body>
</html>
