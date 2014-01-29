<?php 
    require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/admin/utils/security_mod.php";
	require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/stats/stats.php";
    $title = "Заголовок страницы";
    $pagename = "Главная";
    $pageinfo = "Описание страницы";
	require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/admin/utils/top.php";
?> 

</head>
<body>
	<div class="container">
    	<?php
    		require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/admin/utils/navbar.php";
            require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/utils/paginate.php";
            require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/admin/utils/pagename.php";
        ?>

    </div>
</body>
</html>