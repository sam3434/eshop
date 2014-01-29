<?php 
    require_once "stats/stats.php";
    require_once "database/select_tables.php";
    require_once "config.php";
    session_start();
    if (isset($_GET['out']))
    {
        if (isset($_SESSION['login']))
            unset($_SESSION['login']);
    }
    $cat = "";
    $srch = "";
    $psw = "";
    if (isset($_GET['cat']))
    {
        $cat = fix_string($_GET['cat']);
    }
    if (isset($_GET['srch']))
    {
        $srch = fix_string($_GET['srch']);
    }   
    if (isset($_GET['psw']))
    {
        $psw = intval($_GET['psw']);
    }
    else
    {
        $psw = 1;
    }
    if (empty($cat))
    {
        $w = select_all_categories(1);
        $row = mysql_fetch_assoc($w);
        $cat = $row['name'];
    }
	require_once "templates/top.php";
 ?>
</head>
<body>
	<div class="container">
		<?php 
			require_once "templates/header.php";
		 ?>

    	<div class="row">
    		<?php 
    			require_once "templates/left.php";
    		 ?>
    		<div class="span8">
    			<?php 
    				require_once "templates/info_block.php";
    			 ?>
    			<?php 
                    require_once "products/show_products.php";
                 ?>
    		</div>
    		<div class="span2">
	    		<?php 
	    			require_once "templates/search.php";	
	    			require_once "templates/right.php";
	    		 ?>
    		</div>

    	</div>
        <div class="row" style="margin-bottom:40px;">
            <div class="span8 offset4">
                <?php 
                    require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/utils/paginate.php";
                ?>     
            </div>
               
        </div>
	<?php 
		require_once "templates/footer.php";
	 ?>
	</div>
</body>
</html>