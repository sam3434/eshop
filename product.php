<?php 
    require_once "database/select_tables.php";
    require_once "config.php";
    session_start();
    $id = intval($_GET['id']);
    $product = select_product_by_id($id);
    if (!isset($_GET['id']))
    {
        $_SESSION['pnf'] = "1";
        session_write_close();
        header("Location: index.php");
        exit();
    }
    if ($product==null)
    {
        $_SESSION['errid'] = "1";
        session_write_close();
        header("Location: index.php");
        exit();
    }
    echo $_SESSION['pnf'];
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
                <h3>
                    <?php 
                        echo $product['name'];
                ?>
                </h3>
                <hr>
                <div class="row">
                    <?php 
                        $src = "http://placehold.it/150x95";
                        if (is_file($_SERVER['DOCUMENT_ROOT']."/".$product['image']))
                        {
                            $src = "/".$product['image'];
                        }
                     ?>
                    <div class="span2 offset1">
                        <img src="<?php echo $src; ?>">
                    </div>
                    <div class="span5">
                        <span class="price_product">
                            <?php 
                                echo $product['price']." $";
                             ?>                            
                        </span>
                        <?php 
                            if (isset($_SESSION['login'])) :
                         ?>
                            <input type='hidden' value="<?php echo $product['id']; ?> " />
                            <a href="" class="btn btn-success basket_btn basket-btn">
                                <i class="icon-shopping-cart icon-white"></i>

                                Добавить в корзину
                            </a>
                        <?php 
                            endif;
                         ?>
                        <div class="small_descr">
                            <?php 
                                echo $product['small_descr'];
                              ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="span7 offset1">
                        <hr>
                        <h4>Полное описание товара</h4>
                         <?php 
                            echo $product['descr'];
                          ?>
                    <hr>
                    <?php 
                        $chars = select_chars_by_product($product['id']);
                     ?>
                    <h4>Технические характеристики</h4>
                    <table class="table table-hover table-condensed">
                        <tr>
                            <th>Характеристика</th>
                            <th>Значение</th>
                        </tr>
                        <?php 
                           while ($row=mysql_fetch_assoc($chars))
                           {
                                echo "<tr>";
                                echo "<td>{$row['name']}</td>";
                                echo "<td>{$row['value']}</td>";
                                echo "</tr>";
                           }
                         ?>
                    </table>
                    <hr>
                    <!-- <h4>Отзывы покупателей</h4>
                    <div class="well">
                        <div>
                            Иван <br>
                            7 мая 2013 <br> <br>
                            На одних сайтах пишут что он не поддерживает T2, здесь в описании указано DVB-T2 ....так как, кто нибудь знает наверняка ...есть или нет поддержка Т2 ???
                        </div>

                    </div>
                    <div class="well">
                        <div>
                            Иван <br>
                            7 мая 2013 <br> <br>
                            На одних сайтах пишут что он не поддерживает T2, здесь в описании указано DVB-T2 ....так как, кто нибудь знает наверняка ...есть или нет поддержка Т2 ???
                        </div>

                    </div> -->
                    </div>
                </div>
    		</div>
            <div class="span2">
        		<?php 
        			require_once "templates/right.php";
        		 ?>
            </div>
    	</div>
        <?php 
            require_once "templates/footer.php";
        ?>
	</div>

</body>
</html>