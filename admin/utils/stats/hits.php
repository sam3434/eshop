<?php 
	$stats = array();
            
    global $tbl_stats, $tbl_os;
    $query = "select id from $tbl_os where name='none'";
    $res = mysql_query($query);
    $os_none = mysql_result($res, 0);
    /*
    ХИТЫ, ЗАСЧИТАНЫЕ ХИТЫ
    */
    for ($i=0; $i <= 1; $i++) 
    { 
        if ($i==0)
        {
            $and = "";
            $and_all = "";
        }
        else
        {
            $and = " and id_os!='$os_none'";
            $and_all = " where id_os!='$os_none'";
        }
        $stats[$i] = array();
        $query = "select count(*) from $tbl_stats where DATE(begin_date) = DATE(NOW())".$and;
        $res = mysql_query($query);
        array_push($stats[$i], mysql_result($res, 0));

        $query = "select count(*) from $tbl_stats where date(begin_date) = DATE_SUB(CURDATE(), INTERVAL 1 DAY)".$and;
        $res = mysql_query($query);
        array_push($stats[$i], mysql_result($res, 0));

        $query = "select count(*) from $tbl_stats where DATE_SUB(CURDATE(), INTERVAL 7 DAY)<=begin_date".$and;
        $res = mysql_query($query);
        array_push($stats[$i], mysql_result($res, 0));

        $query = "select count(*) from $tbl_stats where DATE_SUB(CURDATE(), INTERVAL 30 DAY)<=begin_date".$and;
        $res = mysql_query($query);
        array_push($stats[$i], mysql_result($res, 0));

        $query = "select count(*) from $tbl_stats".$and_all;
        $res = mysql_query($query);
        array_push($stats[$i], mysql_result($res, 0));    
    }
    /*
    ВСЕГО ХОСТОВ
    */
    $stats[2] = array();
    $query = "select count(distinct ip) from $tbl_stats where DATE(begin_date) = DATE(NOW())";
    $res = mysql_query($query);
    array_push($stats[2], mysql_result($res, 0));

    $query = "select count(distinct ip) from $tbl_stats where date(begin_date) = DATE_SUB(CURDATE(), INTERVAL 1 DAY)";
    $res = mysql_query($query);
    array_push($stats[2], mysql_result($res, 0));

    $query = "select count(distinct ip) from $tbl_stats where DATE_SUB(CURDATE(), INTERVAL 7 DAY)<=begin_date";
    $res = mysql_query($query);
    array_push($stats[2], mysql_result($res, 0));

    $query = "select count(distinct ip) from $tbl_stats where DATE_SUB(CURDATE(), INTERVAL 30 DAY)<=begin_date";
    $res = mysql_query($query);
    array_push($stats[2], mysql_result($res, 0));

    $query = "select count(distinct ip) from $tbl_stats";
    $res = mysql_query($query);
    array_push($stats[2], mysql_result($res, 0)); 

    /*
    ЧИСТЫХ ХОСТОВ
    */
    $and = "o.name != 'none' AND
             o.name != 'robot_yandex' AND
             o.name != 'robot_google' AND
             o.name != 'robot_rambler' AND
             o.name != 'robot_aport' AND
             o.name != 'robot_msnbot'";
    $stats[3] = array();
    $query = "select count(distinct ip) from $tbl_stats as s join $tbl_os as o on o.id=s.id_os where DATE(begin_date) = DATE(NOW()) and ".$and;
    $res = mysql_query($query);
    array_push($stats[3], mysql_result($res, 0));

    $query = "select count(distinct ip) from $tbl_stats as s join $tbl_os as o on o.id=s.id_os  where date(begin_date) = DATE_SUB(CURDATE(), INTERVAL 1 DAY) and ".$and;
    $res = mysql_query($query);
    array_push($stats[3], mysql_result($res, 0));

    $query = "select count(distinct ip) from $tbl_stats as s join $tbl_os as o on o.id=s.id_os  where DATE_SUB(CURDATE(), INTERVAL 7 DAY)<=begin_date and ".$and;
    $res = mysql_query($query);
    array_push($stats[3], mysql_result($res, 0));

    $query = "select count(distinct ip) from $tbl_stats as s join $tbl_os as o on o.id=s.id_os  where DATE_SUB(CURDATE(), INTERVAL 30 DAY)<=begin_date and ".$and;
    $res = mysql_query($query);
    array_push($stats[3], mysql_result($res, 0));

    $query = "select count(distinct ip) from $tbl_stats as s join $tbl_os as o on o.id=s.id_os  where ".$and;
    $res = mysql_query($query);
    $rr = mysql_fetch_assoc($res);
    array_push($stats[3], mysql_result($res, 0)); 

 ?>

<div class="row">
        <div class="span12">
            <div class="alert alert-info">
                На этой странице вы видите общую статистику по посетителям сайта. <br>
                Хосты - это количество уникальных посетителей вашего сайта, <br>
                хиты - это общее количество показов сайта. 
            </div>
        </div>
    </div>
    <table class="table table-bordered">
<tr>
    <th></th>
    <th>Сегодня</th>
    <th>Вчера</th>
    <th>За 7 дней</th>
    <th>За 30 дней</th>
    <th>За все время</th>
</tr>
<?php 
    $caption = array("Хиты", "Засчитанные хиты", "Хосты", "Засчитанные хосты",);
    for ($i=0; $i < 4; $i++) 
    { 
        echo "<tr>";
        echo "<td><b>{$caption[$i]}</b></td>";
        for ($j=0; $j < 5; $j++) 
        { 
            echo "<td>{$stats[$i][$j]}</td>";
        }
        echo "</tr>";
    }
 ?>
</table>

