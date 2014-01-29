<?php 
    require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/admin/utils/security_mod.php";
	require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/stats/stats.php";
    $title = "Заголовок страницы";
    $pagename = "Пользователи";
    $pageinfo = <<<__PAGEINFO
    <strong>Инфо о странице</strong> <br>
    Просмотр списка пользователей с возможностью фильтрации по разным полям <br>
    Список доступных действий: <br>
    &nbsp;&nbsp; <i class="icon-edit"></i> - изменение информации о пользователе <br>
    &nbsp;&nbsp;<i class="icon-info-sign"></i> - детальная информация о пользователе <br>
    &nbsp;&nbsp;<i class="icon-remove"></i> - заблокировать пользователя <br>
    &nbsp;&nbsp;<i class="icon-plus"></i> - разблокировать пользователя
    <br> TODO - сортировка по полям <br> поиск по найти <br> изменение данных(возможно, в блоке информация о польозователе)
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
        <!-- 
        МОДАЛЬНОЕ ОКНО
         -->
         <!-- <a href="#myModal" role="button" class="btn" data-toggle="modal">Delete user</a> -->
        <div class="modal hide" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel">Delete user? </h3>
            </div>
            <div class="modal-body">
                <p>Are you sure that you want delete this user?</p>
            </div>
            <div class="modal-footer">
                <a class="btn" data-dismiss="modal" aria-hidden="true" id="confirm_btn">Да</a>
                <a class="btn btn-primary" data-dismiss="modal"  aria-hidden="true">Нет, отменить</a>
            </div>
        </div>
         <!-- 
        /МОДАЛЬНОЕ ОКНО
         -->

       
        <?php 
            require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/admin/utils/users/page_info.php";
         ?>
        <!-- 
        ИНФОРМАЦИЯ О ПОЛЬЗОВАТЕЛЕ (И ФИЛЬТРЫ)
         -->
        <div class="row">
            <div class="span7" id="info_users">
                <?php 
                    require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/admin/utils/users/info_users.php";
                 ?>
            </div>

            
            <?php 
                require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/admin/utils/users/show_filters.php";
             ?>
        </div>
        <hr>
        <!-- 
        ТАБЛИЦА ПОЛЬЗОВАТЕЛЕЙ
         -->
        <div class="row">
            <div class="span12">
                <div id="show_users">
                <?php 
                    require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/admin/utils/users/show_users.php";
                 ?>
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
    </div>

</body>
</html>