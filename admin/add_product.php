<?php 
    require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/admin/utils/security_mod.php";
	require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/stats/stats.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/database/select_tables.php";
    if (isset($_GET['id'])) 
    {
        $pagename = "Изменение товара";
        $button = "Изменить";    
        $pageinfo = <<<__PAGEINFO
    <strong>Изменение товара</strong> <br>
__PAGEINFO;
        $id = intval($_GET['id']);
        $product = select_product_by_id($id);
        $chars = select_chars_by_product($id);
    }
    else
    {
        $pagename = "Добавление товара";
        $button = "Создать";    
        $pageinfo = <<<__PAGEINFO
    <strong>Добавление товара</strong> <br>
__PAGEINFO;
    }
    $title = "Заголовок страницы";
      
	require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/admin/utils/top.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/database/select_tables.php";
?> 
<script src="utils/js/add_product.js" type="text/javascript"></script>
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

         <div class="modal hide" id="ModalDeleteChar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel">Удаление характеристики </h3>
            </div>
            <div class="modal-body">
                <p>Вы уверены что хотите удалить характеристику для этого товара?</p>
            </div>
            <div class="modal-footer">
                <a class="btn" data-dismiss="modal" aria-hidden="true" id="confirm_btn_char">Да</a>
                <a class="btn btn-primary" data-dismiss="modal"  aria-hidden="true">Нет, отменить</a>
            </div>
        </div>

        <div class="modal hide" id="ModalCreateChar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel">Создание характеристики </h3>
            </div>
            <div class="modal-body">
                <p>Наименование характеристики</p>
                <input type="text" name="" id="name_character"> <br>
                <p>Значение характеристики</p>
                <input type="text" name="" id="value_character">
            </div>
            <div class="modal-footer">
                <a class="btn" data-dismiss="modal" aria-hidden="true" id="confirm_btn_crt_char">Создать</a>
                <a class="btn btn-primary" data-dismiss="modal"  aria-hidden="true">Нет, отменить</a>
            </div>
        </div>
        <?php 
            require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/admin/utils/products/form.php";
         ?>
            
    </div>
</body>
</html>