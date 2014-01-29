<?php 
    session_start();
    require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/only_auth.php";
    require_once "config.php";
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
                    //require_once "templates/info_block.php";
                ?>
                <div id="basket_ajax">
                    <?php 
                        require_once "templates/show_basket.php";
                     ?>
                </div>
                
            </div>
            <div class="span2">
                <?php 
                    //require_once "templates/right.php";
                 ?>
            </div>
    		
    	</div>
        <?php 
            require_once "templates/footer.php";
        ?>
	</div>

</body>
</html>