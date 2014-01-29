<?php 	

	function all_files($dir)
	{
		$files = array();
		$d = opendir($dir);
		echo $dir."<br>";
		while (false!==($file=readdir($d)))
		{
			if (is_file($file))
			{
				$files[] = $file;
			}
			else if (is_dir($file))
			{
				if ($file!=="." && $file!="..")
				{
					$files = array_merge($files, all_files($file));
				}					
			}
		}
		print_r($files);
		closedir($d);
		return $files;
	}

	$files = array(1);
	// error_reporting(E_ALL);
	// $handle = opendir(".");
	// while (false!==($file=readdir($handle)))
	// {
	// 	$files[] = $file;
	// }
	// closedir($handle);
	// foreach ($files as $file)
	// {
	// 	echo "$file<br>";
	// }
	$a = all_files(".");
	print_r($a);

 ?>