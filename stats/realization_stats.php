<?php 
	function user_browser($agent)
	{
		preg_match("/(MSIE|Opera|Firefox|Chrome|Version|Opera Mini|Netscape|Konqueror|SeaMonkey|Camino|Minefield|Iceweasel|K-Meleon|Maxthon)(?:\/| )([0-9.]+)/", $agent, $browser_info); // регулярное выражение, которое позволяет отпределить браузер
		list(, $browser, $version) = $browser_info;
		if (preg_match("/Opera ([0-9.]+)/i", $agent, $opera)) 
			return 'Opera '.$opera[1]; // определение старых версий Оперы (до 8.50)
        if ($browser == 'MSIE') // если браузер определён как IE
        { 
        	preg_match("/(Maxthon|Avant Browser|MyIE2)/i", $agent, $ie); // проверяем, не разработка ли это на основе IE
        	if ($ie) 
        		return $ie[1].' основан на IE '.$version; // если да, то возвращаем сообщение об этом
            return 'IE '.$version; // иначе просто возвращаем IE и номер версии
        }
        if ($browser == 'Firefox') // если браузер определён как Firefox
        { 
                preg_match("/(Flock|Navigator|Epiphany)\/([0-9.]+)/", $agent, $ff); // проверяем, не разработка ли это на основе Firefox
                if ($ff) 
                	return $ff[1].' '.$ff[2]; // если да, то выводим номер и версию
        }
        if ($browser == 'Opera' && $version == '9.80') 
        	return 'Opera '.substr($agent,-5); // если браузер определён как Opera 9.80, берём версию Оперы из конца строки
        if ($browser == 'Version') // определяем Сафари
        	return 'Safari '.$version; 
        if (!$browser && strpos($agent, 'Gecko')) 
        	return 'Browser based on Gecko'; // для неопознанных браузеров проверяем, если они на движке Gecko, и возращаем сообщение об этом
        return $browser.' '.$version; // для всех остальных возвращаем браузер и версию
	}

    function user_os($agent)
    {
        if(strstr($agent, "Win")) $os = "Windows";
        elseif ((strstr($agent, "Mac")) || (ereg("PPC", etenv("HTTP_USER_AGENT")))) $os = "Mac";
        elseif (strstr($agent, "Linux")) $os = "Linux";
        elseif (strstr($agent, "FreeBSD")) $os = "FreeBSD";
        elseif (strstr($agent, "SunOS")) $os = "SunOS";
        elseif (strstr($agent, "IRIX")) $os = "IRIX";
        elseif (strstr($agent, "BeOS")) $os = "BeOS";
        elseif (strstr($agent, "OS/2")) $os = "OS/2";
        elseif (strstr($agent, "AIX")) $os = "AIX";
        // Выясняем принадлежность к поисковым роботам
        elseif (strstr($agent, "StackRambler")) $os = "robot_rambler";
        elseif (strstr($agent, "Googlebot")) $os = "robot_google";
        elseif (strstr($agent, "Yandex")) $os = "robot_yandex";
        elseif (strstr($agent, "Aport")) $os = "robot_aport";
        elseif (strstr($agent, "msnbot")) $os = "robot_msnbot";
        else $os = "none";
        return $os;
    }

    /*
    Возвращает id браузера (или страницы) по имени из таблицы
    Или если такого (-ой) нет создает новый
    */
    function id_with_name($name, $what)
    {
        global $tbl_browsers, $tbl_pages, $tbl_os;
        if ($what=="browser") 
        {
            $query = "select id from $tbl_browsers where name='$name' limit 1";
        }
        elseif ($what=="page")
        {
            $query = "select id from $tbl_pages where address='$name' limit 1";   
        }    
        elseif ($what=="os")    
        {
            $query = "select id from $tbl_os where name='$name' limit 1";   
        }
        $res = mysql_query($query);
        if (mysql_num_rows($res) == 0) 
        {
            if ($what=="browser") 
            {
                $query = "insert into $tbl_browsers(name) values('$name')";
            }
            elseif ($what=="page") 
            {
                $query = "insert into $tbl_pages(address) values('$name')";   
            }            
            elseif ($what=="os") 
            {
                $query = "insert into $tbl_os(name) values('$name')";   
            }            
            mysql_query($query);
            $res_id = mysql_insert_id();
        }
        else
        {
            $res_id = mysql_result($res, 0);
        }
        return $res_id;
    }

    function unique_users()
    {
        global $tbl_unique;
        $curdate = mktime(0, 0, 0, date("m"), date("d"), date("Y"));
        $nextday = mktime(0, 0, 0, date("m"), date("d")+1, date("Y"));
        if (!isset($_COOKIE['lastvisit'])) 
        {
            setcookie("lastvisit", $curdate, $nextday);
            $mdate = date("d m Y");
            $query = "select * from $tbl_unique where mdate='$mdate' limit 1";
            $res = mysql_query($query);
            if (mysql_num_rows($res)>0) 
            {
                $query = "update $tbl_unique set count=count+1";
            }
            else
            {
                $query = "insert into $tbl_unique(mdate, count) 
                values($mdate, 1)";
            }
            mysql_query($query);
        }
    }
 ?>