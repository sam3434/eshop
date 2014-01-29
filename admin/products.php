<?php 
    require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/admin/utils/security_mod.php";
	require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/stats/stats.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/products/config_product.php";
    $title = "Заголовок страницы";
    $pagename = "Товары";
    $pag_search = "";
    echo $_GET['categories'];
    $pageinfo = <<<__PAGEINFO
    <strong>Инфо о странице</strong> <br>
    Просмотр списка товаров с возможностью фильтрации по разным полям <br>
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

         <div class="modal hide" id="ModalCreateCategory" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel">Создание категории </h3>
            </div>
            <div class="modal-body">
                <div class="control-group">
                    <label for="" class="control-label">Наименование категории</label>
                    <div class="controls">
                        <input type="text" name="" id="name_category" placeholder="Наименование">
                    </div>
                </div>
                <div class="control-group">
                    <label for="" class="control-label">Описание категории</label>
                    <div class="controls">
                        <textarea name="" id="desc_category" cols="60" rows="7" style='width:300px' maxlength="300"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a class="btn" id="confirm_btn_crt_category">Создать</a>
                <a class="btn btn-primary" data-dismiss="modal"  aria-hidden="true">Нет, отменить</a>
            </div>
        </div>

        <div class="modal hide" id="ModalDeleteProduct" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel">Действительно хотите удалить этот товар?</h3>
            </div>
            <div class="modal-body">
                <p>Удаление товара</p>
            </div>
            <div class="modal-footer">
                <a class="btn" id="confirm_btn_del_prod">Удалить</a>
                <a class="btn btn-primary" data-dismiss="modal"  aria-hidden="true">Нет, отменить</a>
            </div>
        </div>

        
        <div class="row" id="products">
            <?php 
                require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/admin/utils/products/show_filters.php";
             ?>
        </div>
        <hr>
        <div id="show_products">
        <?php 
            require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/admin/utils/products/show_products.php"; 
         ?>
        </div>        
        <div class="row">
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