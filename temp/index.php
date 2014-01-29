<?php 
	$title = "Главная";
	require_once "stats/stats.php";
	require_once "utils/top.php";
	require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/users/config_user.php";
?>

</head>
<body>
	<div id="container">		
		<?php 
			if (isset($_GET['out'])) 
			{
				out();
			}
			require_once "utils/header.php";
			require_once "utils/top_menu.php";
			require_once "utils/left_menu.php";
		 ?>
			
		<div id="main_content">
			<div class="product">
				<img src="images/pic1.jpg" alt="" />
				<div class="product_comment">
					Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed mattis odio et massa fringilla a tempor eros adipiscing. Quisque lobortis tempor tortor, eu tristique mauris vehicula quis. Cras aliquet cursus augue in accumsan. Vestibulum tempor consectetur risus vitae consequat. Integer vulputate blandit felis id facilisis. Cras vestibulum urna id risus euismod vehicula. Donec non nibh ut sapien vehicula laoreet a quis sem.  <br />
234$ <br />
<?php print_r($_SESSION); if (isset($_SESSION['login'])) echo "yes"; else echo "no"; ?>
<input type="submit" value="asd" />
				</div>
			</div>
			
			Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus eu neque vitae lacus congue rhoncus. Sed consequat tempor aliquam. Pellentesque sed lorem velit, sed feugiat libero. Nullam sollicitudin libero vitae velit luctus eu vestibulum quam rhoncus. Donec eget iaculis tortor. Nulla metus lorem, pretium in accumsan vel, condimentum ac libero. Integer eu est a orci tincidunt venenatis. Pel
			Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus eu neque vitae lacus congue rhoncus. Sed consequat tempor aliquam. Pellentesque sed lorem velit, sed feugiat libero. Nullam sollicitudin libero vitae velit luctus eu vestibulum quam rhoncus. Donec eget iaculis tortor. Nulla metus lorem, pretium in accumsan vel, condimentum ac libero. Integer eu est a orci tincidunt venenatis. PelLorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus eu neque vitae lacus congue rhoncus. Sed consequat tempor aliquam. Pellentesque sed lorem velit, sed feugiat libero. Nullam sollicitudin libero vitae velit luctus eu vestibulum quam rhoncus. Donec eget iaculis tortor. Nulla metus lorem, pretium in accumsan vel, condimentum ac libero. Integer eu est a orci tincidunt venenatis. PelLorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus eu neque vitae lacus congue rhoncus. Sed consequat tempor aliquam. Pellentesque sed lorem velit, sed feugiat libero. Nullam sollicitudin libero vitae velit luctus eu vestibulum quam rhoncus. Donec eget iaculis tortor. Nulla metus lorem, pretium in accumsan vel, condimentum ac libero. Integer eu est a orci tincidunt venenatis. PelLorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus eu neque vitae lacus congue rhoncus. Sed consequat tempor aliquam. Pellentesque sed lorem velit, sed feugiat libero. Nullam sollicitudin libero vitae velit luctus eu vestibulum quam rhoncus. Donec eget iaculis tortor. Nulla metus lorem, pretium in accumsan vel, condimentum ac libero. Integer eu est a orci tincidunt venenatis. PelLorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus eu neque vitae lacus congue rhoncus. Sed consequat tempor aliquam. Pellentesque sed lorem velit, sed feugiat libero. Nullam sollicitudin libero vitae velit luctus eu vestibulum quam rhoncus. Donec eget iaculis tortor. Nulla metus lorem, pretium in accumsan vel, condimentum ac libero. Integer eu est a orci tincidunt venenatis. Pel

			<div class="ratings">
				<div style="width:80%;"></div>
			</div>
			<div class="ratings2">
				<div style="width:58%;"></div>
			</div>
		</div>
		<?php 
			require_once "utils/footer.php";
		?>
	</div>
</body>
</html>
