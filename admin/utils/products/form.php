<div class="row">
    <div class="span12"> 
        <div class="row">
        <div class="span3">
            <ul class="nav nav-list">
                <li class="nav-header">Категории</li>
                <?php 
                    $categories = select_all_categories();
                    $active = false;
                    while ($row=mysql_fetch_assoc($categories))
                    {
                        echo "<li ";
                        if ($product==null && !$active)
                        {
                            $active = true;
                            echo "class='active'";   
                        }
                        if ($product['id_category']==$row['id'])
                        {
                            echo "class='active'";
                        }
                        echo ">";
                        echo "<a href='index.php'>{$row['name']}</a>";
                        echo "<input type='hidden' name='' value='{$row['id']}'>";
                    }
                ?>
            </ul>
        </div>
        <div class="span9">
            <form action="index.php" class="form-horizontal" id="create_product">
                <div class="control-group">
                    <label for="name" class="control-label">Имя товара</label>
                    <div class="controls">
                        <input type="text" name="" id="name" placeholder="Имя товара"
                        value="<?php echo $product['name']; ?>"
                        >
                    </div>
                </div>
                <div class="control-group">
                    <label for="price" class="control-label">Цена</label>
                    <div class="controls">
                        <input type="text" name="" id="price" placeholder="Цена"
                        value="<?php echo $product['price']; ?>"
                        >
                    </div>
                </div>
                <div class="control-group">
                    <label for="" class="control-label">Картинка</label>
                    <div class="controls">
                        <input type="text" name="" id="small_pic" placeholder="Картинка"
                        value="<?php echo $product['small_image']; ?>"
                        >
                    </div>
                </div>
                <div class="control-group">
                    <label for="" class="control-label">Картинка</label>
                    <div class="controls">
                        <input type="text" name="" id="big_pic" placeholder="Картинка"
                        value="<?php echo $product['image']; ?>"
                        >
                    </div>
                </div>
                <div class="control-group">
                    <!-- <div class="controls"> -->
                        <table class="table table-condensed table-hover" id="characters">
                <tr>
                    <th>Характеристика</th>
                    <th>Значение</th>
                    <th></th>
                </tr>
                <?php 
                    if ($chars)
                    {
                        while ($row=mysql_fetch_assoc($chars))
                        {
                            $html=<<<__html
                            <tr>
                                <td>{$row['name']}</td>
                                <td>{$row['value']}</td>
                                <td>
                                    <a href="#ModalDeleteChar" data-toggle="modal"><i class="icon-remove remove_char"></i></a>
                                </td> 
                            </tr>        
__html;
                            echo $html;
                        }
                    }
                 ?>
                <tr id="tr_insert">
                    <td></td>
                    <td></td>
                    <td>
                        <a href="#ModalCreateChar" data-toggle="modal"><i class="icon-plus"></i></a>
                    </td>
                </tr>
            </table>
                    <!-- </div> -->
                </div>
                <div class="control-group">
                    <label for="short_desc" class="control-label">Краткое описание</label>
                    <div class="controls">
                        <textarea name="" id="short_desc" class="field span5" rows="7"><?php echo $product['small_descr'];; ?></textarea>
                    </div>
                </div>
                <div class="control-group">
                    <label for="long_desc" class="control-label">Полное описание</label>
                    <div class="controls">
                        <textarea name="" id="long_desc" class="field span5" rows="15"><?php echo $product['descr'];; ?></textarea>
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <button class="btn" type="submit" id="main_button">
                            <?php echo $button; ?>
                        </button>
                    </div>
                </div>
            </form>
        </div>
        </div>
    </div>  
</div>