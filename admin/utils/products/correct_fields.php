<?php 
	function correct_name($name)
	{
		global $errors;		
		//$errors['name'] = "asd"; 
		return true;
	}

	function correct_price($price)
	{
		global $errors;
		//$errors['price'] = "asd";		 
		return true;
	}

	function correct_chars($name, $value)
	{
		return true;
	}

	function correct_name_category($name_category)
	{
		global $errors;
		//$errors['name_category'] = "asd";
		return true;
	}
	function correct_desc_category($desc_category)
	{
		return true;
	}

 ?>