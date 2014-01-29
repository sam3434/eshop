<?php 
    $title = "Регистрация";
    require_once "stats/stats.php";
    require_once "templates/top.php";
 ?>
 <script src="ajax/js/register.js"></script>
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
                <div class="row">
                    <div class="offset2 span6">
                        <?php 
                require_once "users/register_form.php"
            ?>
                    </div>
                </div>    			
    		</div>
    	</div>
       
    <?php 
		require_once "templates/footer.php";
	 ?>
	</div>
</body>
</html>