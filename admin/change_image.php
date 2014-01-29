<?php 
	require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/stats/stats.php";
	if (isset($_FILES['filename']['name']))
	{
		$id = intval($_POST['id']);
		$saveto = $_SERVER['DOCUMENT_ROOT']."/eshop1/images/".$id.".jpg";
		move_uploaded_file($_FILES['filename']['tmp_name'], $saveto);
		$typeok = true;
		switch ($_FILES['filename']['type']) {
			case 'image/gif':
				$src = imagecreatefromgif($saveto);
				break;
			case 'image/jpeg':
			case 'image/pjpeg':
				$src = imagecreatefromjpeg($saveto);
				break;
			case 'image/png':
				$src = imagecreatefrompng($saveto);
				break;
			default:
				$typeok = false;
				break;
		}
		if ($typeok)
		{
			list($w, $h) = getimagesize($saveto);
			$max = 150;
			$tw = $w;
			$th = $h;
			if ($w > $h && $max < $w)
			{
				$th = $max / $w * $h;
				$tw =  $max;
			}
			elseif ($h>$w && $max<$h)
			{
				$tw = $max/$h*$w;
				$th = $max;
			}
			elseif ($max<$w)
			{
				$tw = $th = $max;
			}
			$tmp = imagecreatetruecolor($tw, $th);
			imagecopyresampled($tmp, $src, 0, 0, 0, 0, $tw, $th, $w, $h);
			imageconvolution($tmp, array(
				array(-1, -1, -1),
				array(-1, 16, -1),
				array(-1, -1, -1),
				), 8, 0);
			imagejpeg($tmp, $saveto);
			imagedestroy($tmp);
			imagedestroy($src);
		}
		global $tbl_product;
		//echo $saveto;
		$save = "eshop1/images/".$id.".jpg";
		$query = "update $tbl_product set image='$save' where id=$id";
		mysql_query($query);
		//echo $query.mysql_error();
	}
	
 //    require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/admin/utils/security_mod.php";
	// require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/database/select_tables.php";
 //    require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/products/config_product.php";
    $title = "Заголовок страницы";
    $pagename = "Установить изображение";
    $pag_search = "";
    $pageinfo = <<<__PAGEINFO
    <strong>Установить изображение товару</strong> <br>
    
__PAGEINFO;
	require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/admin/utils/top.php";
?> 

</head>
<body>
	<div class="container">
    	<?php
    		require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/admin/utils/navbar.php";
            require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/admin/utils/pagename.php";
        ?>
        <?php 
            require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/admin/utils/users/page_info.php";
         ?>
         <hr>
		<div class="row">
			<div class="span12">

				<div class="well">
					<?php if (!isset($_FILES['filename']['name'])): ?>
					<form action="change_image.php" method="post" enctype="multipart/form-data">
	      				<input type="file" name="filename"><br>  <br>
	      				<input type="hidden" name="id" value="<?php echo isset($_GET['id']) ? $_GET['id'] : -1; ?>">
	      				<input type="submit" value="Загрузить" class="btn btn-primary"><br>
	      			</form>
	      			<?php else: ?>
	      			<h3>Изображение установлено</h3>
	      		<?php endif; ?>
				</div>	
			</div>
		</div>
	<div class="row" style="margin-bottom:40px;">
            <div class="span8 offset4">
                <?php 
        require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/utils/paginate.php";
         ?>     
            </div>
               
        </div>
       	 
    
</body>
</html>