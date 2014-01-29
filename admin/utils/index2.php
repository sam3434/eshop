<?php 
	require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/stats/stats.php";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>Bootstrap</title>

	<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">

	<script src="http://code.jquery.com/jquery-latest.js"></script>
	<script src="bootstrap/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="bootstrap/js/bootstrap-dropdown.js"></script>
	<link rel="stylesheet" href="../css/style.css">
	<script type="text/javascript">  
        $(document).ready(function () {  
            $('.dropdown-toggle').dropdown();  
        });  
   </script>  

</head>
<body>
	<div class="container">
    	<div class="navbar navbar-inverse">
	    	<div class="navbar-inner">
	    		<a class="brand" href="#">Админка</a>
	    		<ul class="nav">
	    			<li class="active"><a href="#">Главная</a></li>
	    			<li><a href="#">Товары</a></li>
	    			<li><a href="#">Пользователи</a></li>
	    			<li class="divider-vertical"></li>
	    			<li><a href="#">Статистика</a></li>
	    			<li class="dropdown">
			    		<a href="" class="dropdown-toggle" data-toggle="dropdown">
			    			Добавить<b class="caret"></b>
			    		</a>
			    		<ul class="dropdown-menu">
			    			<li>
			    				<a href="">Пользователей</a>
			    			</li>
			    			<li>
			    				<a href="">Товары</a>
			    			</li>
			    			<li class="divider"></li>
			    			<li>
			    				<a href="">Зависимости</a>
			    			</li>
			    		</ul>
			    	</li>
	    		</ul>
	    	</div>
    	</div>
    	<div class="row">
    		<div class="span10 offset1">
    			<ul class="breadcrumb">
			    	<li><a href="#">Главная</a> <span class="divider">/</span></li>
			    	<li><a href="#">Библиотека</a> <span class="divider">/</span></li>
			    	<li class="active">Данные</li>
			    </ul>		
    		</div>
    	</div>
    </div>
</body>
</html>