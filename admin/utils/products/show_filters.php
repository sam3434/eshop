<?php 
	$html=<<<__html
	<div class="span12">            
        <div class="span3">
            <strong>Фильтрация</strong>  <br> <br>
            <p>По дате добавления</p>
            <select id="date_added">
__html;
	echo $html;
	if (isset($_GET['search_date_added']))
		$date_value = $_GET['search_date_added'];
	else
		$date_value = 1;
	$dates = array("Любое значение", "Первый день", "Менее недели", "Менее 30 дней", 
		"Менее года", "Более года");
	for ($i=1; $i <= count($dates); $i++) 
	{ 
		$opt = "<option value='".$i."'";
		echo $opt;
		if ($i==$date_value)
			echo " selected";
		echo ">".$dates[$i-1]."</option>";
	}

	$html=<<<__html
	</select>
        </div>
        <div class="span3">
            <br> <br>
            <p>По категориям</p>
            <select id="categories">
            <option value="1">Любое значение</option>
                        
__html;
	echo $html;
	$categ_value = $_GET['search_categories'];
	$cats = get_all_categories();
    $index = 2;
    //echo $cats;
    while ($row=mysql_fetch_row($cats))
    {
    	$str_tmp = "";
    	if ($categ_value==$row[0])
    		$str_tmp = "selected";
    	echo "<option value='$index' ".$str_tmp.">{$row[0]}</option>";
        //echo $row[0];
        $index++;
    }

    $html=<<<__html
	</select>
	    </div>
	    <div class="span3">
	        <br> <br> 
	        <p>По цене</p>
	        <select id="price">                        
__html;
	echo $html;
	if (isset($_GET['search_price']))
		$price_value = $_GET['search_price'];
	else
		$price_value = 1;
	$prices = array("Любое значение", "Дешевле 1$", "От 1$ до 100$", 
		"От 100$ до 1000$", "От 1000$ до 10.000$", "Более 10.000$");
	for ($i=1; $i <= count($prices); $i++) 
	{ 
		$opt = "<option value='".$i."'";
		echo $opt;
		if ($i==$price_value)
			echo " selected";
		echo ">".$prices[$i-1]."</option>";
	}

	$html=<<<__html
		</select>
        </div>
    </div>
    <div class="span12">
      
        <div class="span3">
            <strong>Сортировка</strong>  <br> <br>
            <p>Сортировка значений</p>
            <select id="sorting">                       
__html;
	echo $html;
	if (isset($_GET['search_sorting']))
		$sort_value = $_GET['search_sorting'];
	else
		$sort_value = 1;
	$sortes = array("От дешевых к дорогим", "От дорогих к дешевым", 
		"Последние добавленные");
	for ($i=1; $i <= count($sortes); $i++) 
	{ 
		$opt = "<option value='".$i."'";
		echo $opt;
		if ($i==$sort_value)
			echo " selected";
		echo ">".$sortes[$i-1]."</option>";
	}

	$html=<<<__html
	     </select>
            </div> 
              
            
            <div class="span8">
            	<a href="" class="btn btn-primary" id="search">
                <i class="icon-search icon-white"></i>
                Найти</a>
            
                <a href="add_product.php" class="btn btn-success  btn-primary">
                    <i class="icon-plus icon-white"></i>
                    Добавить товар</a>
                <a href="#ModalCreateCategory" data-toggle="modal" class="btn btn-success">
                    <i class="icon-plus icon-white"></i>
                    Добавить категорию</a>
            </div>
        </div>
__html;
	echo $html;
 ?>