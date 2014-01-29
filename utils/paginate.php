<?php 
	//контролирует длину пагинации
	
	if ($num_pages==1 || $num_pages==0) 
	{
		exit();
	}
	$length = 3;
	$pages = array($page);
	for ($i=$page-1; $i > $page-$length; $i--) 
	{
		if ($i>1) 
		{
			array_unshift($pages, $i); 	
		} 		
	}
	for ($j=$page+1; $j<$page+$length; $j++) 
	{ 
		if ($j<$num_pages) 
		{
			array_push($pages, $j);
		}
		
	}
	if ($page-$length>1) 
	{
		array_unshift($pages, -($page-$length));
	}
	if ($page+$length<$num_pages) 
	{
		array_push($pages, -($page+$length));
	}
	if ($page!=1) 
	{
		array_unshift($pages, 1);
	}
	if ($page!=$num_pages) 
	{
		array_push($pages, $num_pages);
	}
	echo "<div class='btn-group'>";
	for ($i=0; $i < count($pages); $i++) 
	{ 
		$act_class = "";
		if ($page==$pages[$i]) 
		{
			$act_class = " active";
		}
		$tmp = ($pages[$i]<0) ? (-$pages[$i]) : $pages[$i];
		echo "<a href='".$_SERVER['PHP_SELF']."?page=".$tmp.$pag_search."' class='btn paginate ".$act_class."'>";	
		if ($pages[$i]<0) 
		{
			echo "...";
		}
		else
		{
			echo $pages[$i];
		}
		echo "</a>";
	}
	echo "</div>";
?>