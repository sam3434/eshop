<?php 
	$html=<<<__div
	<div class="span3 offset2">
        <strong>Фильтрация</strong>  <br> <br>
        <p>Зарегистрирован на сайте</p>
        <select id="site">
__div;
	echo $html;
	if (isset($_GET['s_site']))
		$date_value = $_GET['s_site'];
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
	$html=<<<__div
	</select>
	    <p>Возраст</p>
	    <select id="age">
__div;
	echo $html;

	if (isset($_GET['s_age']))
		$age_value = $_GET['s_age'];
	else
		$age_value = 1;
	$ages = array("Любое значение", "Менее 18 лет", "От 18 до 40", "Старше 40");
	for ($i=1; $i <= count($ages); $i++) 
	{ 
		$opt = "<option value='".$i."'";
		echo $opt;
		if ($i==$age_value)
			echo " selected";
		echo ">".$ages[$i-1]."</option>";
	}

	$html=<<<__div
	</select>
        <p>Город</p>
        <select id="city">
__div;
	//echo $html;
	echo "</select>";

	// echo "<option value='-1'>Любое значение</option>";
 //    for ($i=0; $i < count($city_user_array); $i++) 
 //    { 
 //        echo "<option value='$i'>{$city_user_array[$i]}</option>";
 //    }
    $html=<<<__div
    
        <br>
        <br>
        <a href="" class="btn btn-primary" id="search_user">
            <i class="icon-search icon-white"></i>
           Отобрать</a>
    </div>
__div;
	echo $html;
?>