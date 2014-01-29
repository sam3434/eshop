<?php 
/*
Страница 1017 php 2
табличка
count.php
utils.hits.php
*/

 ?>
<?php 
    session_start();
    require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/admin/utils/security_mod.php";
	require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/stats/stats.php";
    $title = "Статистика";
    $pagename = "Статистика";
    $pag_search = "";
    echo $_GET['categories'];
    $pageinfo = <<<__PAGEINFO
    <strong>Инфо о странице</strong> <br>
    Просмотр статистики <br>
__PAGEINFO;
	require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/admin/utils/top.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/admin/php-ofc-library/open-flash-chart-object.php";
?> 

<script type="text/javascript" src="js/swfobject.js"></script>
<script type="text/javascript">
    swfobject.embedSWF("open-flash-chart.swf", "sed", "1150", "650", "9.0.0", "expressInstall.swf", {"data-file":"data_today.php"} );
    swfobject.embedSWF("open-flash-chart.swf", "sed2", "1150", "650", "9.0.0", "expressInstall.swf", {"data-file":"data_yest.php"} );
    swfobject.embedSWF("open-flash-chart.swf", "sed3", "1150", "650", "9.0.0", "expressInstall.swf", {"data-file":"data_7.php"} );
    swfobject.embedSWF("open-flash-chart.swf", "sed4", "1150", "650", "9.0.0", "expressInstall.swf", {"data-file":"data_30.php"} );
    swfobject.embedSWF("open-flash-chart.swf", "sed5", "1150", "650", "9.0.0", "expressInstall.swf", {"data-file":"data_all.php"} );
    swfobject.embedSWF("open-flash-chart.swf", "sed6", "1150", "650", "9.0.0", "expressInstall.swf", {"data-file":"data_products.php"} );
    swfobject.embedSWF("open-flash-chart.swf", "sed7", "1150", "650", "9.0.0", "expressInstall.swf", {"data-file":"data_os.php"} );
    swfobject.embedSWF("open-flash-chart.swf", "sed8", "1150", "650", "9.0.0", "expressInstall.swf", {"data-file":"data_cat.php"} );
    swfobject.embedSWF("open-flash-chart.swf", "sed9", "1150", "650", "9.0.0", "expressInstall.swf", {"data-file":"data_hits.php"} );
    swfobject.embedSWF("open-flash-chart.swf", "sed10", "1150", "650", "9.0.0", "expressInstall.swf", {"data-file":"data_br.php"} );
    //swfobject.embedSWF("open-flash-chart.swf", "sed2", "1150", "650", "9.0.0", "expressInstall.swf", {"data-file":"data_pages.php"} );
    //swfobject.embedSWF("open-flash-chart.swf", "sed", "950", "400", "9.0.0", "expressInstall.swf", {"data-file":"data.php"} );
</script>

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
            <ul class="nav nav-tabs" id="myTab">
                <li class="active"><a href="#hosts"  data-toggle="tab">Хиты и хосты</a></li>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        Посещаемость страниц 
                        <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a data-toggle="tab" href="#pages_today">
                            Сегодня
                            </a>
                        </li>
                        <li>
                            <a data-toggle="tab" href="#pages_yest">
                            Вчера
                            </a>
                        </li>
                        <li><a data-toggle="tab" href="#pages_7">
                            За 7 дней
                            </a>
                        </li>
                        <li>
                            <a data-toggle="tab" href="#pages_30">
                            За 30 дней
                            </a>
                        </li>
                        <li>
                            <a data-toggle="tab" href="#pages_all">
                            За все время
                            </a>
                        </li>
                    </ul>
                </li>
                <li><a href="#products"  data-toggle="tab">Продукты</a></li>
                <li><a href="#os"  data-toggle="tab">Операционные системы</a></li>
                <li><a href="#br"  data-toggle="tab">Браузеры</a></li>
                <li><a href="#cat"  data-toggle="tab">Категории</a></li>
                <li><a href="#hits"  data-toggle="tab">Месячный отчет по хитам</a></li>
            </ul>
     
        <div class="tab-content">
            <div class="tab-pane active" id="hosts">
                <?php 
                    require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/admin/utils/stats/hits.php";
                ?>                
            </div>
            <div class="tab-pane" id="profile">
                <!-- <div id="sed"></div> -->
                <?php 
                    //open_flash_chart_object( 300, 300, $_SERVER['SERVER_NAME'] .'/eshop1/admin/utils/stats/data_pages.php' );
                 ?>
            </div>
            <div class="tab-pane" id="pages_today">
                <?php 
                    $date = " where DATE(begin_date) = DATE(NOW())";
                    require $_SERVER['DOCUMENT_ROOT']."/eshop1/admin/utils/stats/pages.php";
                ?>  
                <div id="sed"></div>

            </div>
            <div class="tab-pane" id="pages_yest">
                <?php 
                    $date = " where date(begin_date) = DATE_SUB(CURDATE(), INTERVAL 1 DAY)";
                    require $_SERVER['DOCUMENT_ROOT']."/eshop1/admin/utils/stats/pages.php";
                ?>  
                <div id="sed2"></div>
            </div>
            <div class="tab-pane" id="pages_7">
                <?php 
                    $date = " where DATE_SUB(CURDATE(), INTERVAL 7 DAY)<=begin_date";
                    require $_SERVER['DOCUMENT_ROOT']."/eshop1/admin/utils/stats/pages.php";
                ?>  
                <div id="sed3"></div>
            </div>
            <div class="tab-pane" id="pages_30">
                <?php 
                    $date = " where DATE_SUB(CURDATE(), INTERVAL 30 DAY)<=begin_date";
                    require $_SERVER['DOCUMENT_ROOT']."/eshop1/admin/utils/stats/pages.php";
                ?>  
                <div id="sed4"></div>
            </div>
            <div class="tab-pane" id="pages_all">
                <?php 
                    $date = "";
                    require $_SERVER['DOCUMENT_ROOT']."/eshop1/admin/utils/stats/pages.php";
                ?>  
                <div id="sed5"></div>
            </div>
            <div class="tab-pane" id="products">
                <?php 
                    require $_SERVER['DOCUMENT_ROOT']."/eshop1/admin/utils/stats/products.php";
                 ?>
                 <div id="sed6"></div>
            </div>
            <div class="tab-pane" id="os">
                <?php 
                    require $_SERVER['DOCUMENT_ROOT']."/eshop1/admin/utils/stats/os.php";
                 ?>
                 <div id="sed7"></div>
            </div>
            <div class="tab-pane" id="br">
                <?php 
                    require $_SERVER['DOCUMENT_ROOT']."/eshop1/admin/utils/stats/br.php";
                 ?>
                 <div id="sed10"></div>
            </div>
            <div class="tab-pane" id="cat">
                <?php 
                    require $_SERVER['DOCUMENT_ROOT']."/eshop1/admin/utils/stats/cat.php";
                 ?>
                 <div id="sed8"></div>
            </div>
            <div class="tab-pane" id="hits">
                <?php 
                    require $_SERVER['DOCUMENT_ROOT']."/eshop1/admin/utils/stats/hits_order.php";
                 ?>
                 
            </div>

        </div>

    </div>
</body>
</html>
