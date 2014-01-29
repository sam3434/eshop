<a href="" class="btn btn-primary btn-block disabled product_search">
	Фильтр
</a>
<form action="">
	<!-- <input type="text" class="input-medium" placeholder="Найти">	
	<button type="submit" class="btn">Поиск</button> -->
	<label for="" class="product_label">Выводить по</label>
	<select name="" id="product_show_with" class="span2">
		<?php 
			$selected = "";
			$ar = array("От дешевых к дорогим", "От дорогих к дешевым",
			 "Новинки");
			for ($i=0; $i < count($ar); $i++) 	
			{ 
				if (($psw=="" && $i==0) || ($i+1==$psw))
				{
					$selected = "selected";
				}
				$vl_tmp = $i+1;
				echo "<option value='$vl_tmp' $selected>
						{$ar[$i]}
					  </option>";
				$selected = "";
			}
		 ?>
	</select>
</form>