<?php 
	echo "string";
	if (isset($_POST['clear']))
	{
		//session_start();
		session_unset();
		//session_destroy();
	}
 ?>