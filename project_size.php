<?php 
	
	$start_files=array("style.css","foo.js");
	$stop_files=array("jquery-1.9.1.min.js", "all.php");
	$stop_folder=array("bootstrap", "temp", "font_awesome", "php-ofc-library", "admin/js");
	$files=array();

	function get_files($root,&$files,$start_files)
	{
		global $stop_folder, $stop_files;
		if (count($stop_folder)>0)
		{
			foreach ($stop_folder as $fold) 
			{
				if (strpos($root, "/".$fold)!==false)
					return;
			}
		}
		$folder=opendir($root);
		while (($file=readdir($folder))!==false) {
			if (is_file($root."/".$file)) {
				$reg = preg_replace("/.*?\./", '', $file);
				if ($reg=="php" || $reg=="js") {
					if (!in_array($file, $stop_files))
					{
						$files[]=$root."/".$file;
					}
				}
				foreach ($start_files as $key=>$good) {
					if (strpos($file,$good)!==false) {
						$files[]=$root."/".$file;
						unset($start_files[$key]);
						break;		
					}
				}
				
			}
			elseif ($file!="." && $file!=".." && is_dir($root."/".$file)) {
				get_files($root."/".$file,$files,$start_files);
			}
		}
		closedir($folder);
	}

	$root=$_SERVER['DOCUMENT_ROOT'];
	//$root=$root."/".strtok($_SERVER['PHP_SELF'],"/")."<br>";
	//$root.=""
	$root.="/".strtok($_SERVER['PHP_SELF'],"/");
	get_files($root,$files,$start_files);
	echo preg_replace("/.*?\./", '', 'photo.php');
	foreach ($files as $file) {
		echo $file."<br>";
		//echo preg_replace("/.*?\./", '', $file)."<br>";
	}
	$f=fopen("all.php", "w");
	foreach ($files as $file) {
		if ((strpos($file, "all.php"))!==false) {
			continue;
		}

		$readed=fopen($file,"r");
		$size = filesize($file);
		if ($size>0)
		{
			$text=fread($readed, $size);
		}
		else
		{
			$text = 0;
		}
		$text=$file."<br>".$text;
		//echo $text;
		fclose($readed);
		fwrite($f, $text);
	}
	fclose($f);
	
 ?>