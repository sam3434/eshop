<?php 
    require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/database/utils.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/users/config_user.php";
    $num_users = orders_count($tbl_user);
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $start = abs(($page-1)*$per_page);
    //$res = filter_users($start, $per_page);
    $ar = filter_users($start, $per_page);
    $res = $ar[0];
    $num_users = $ar[1];
    $num_pages = ceil($num_users/$per_page);
    if ($num_pages<$page) 
    {
        $page = $num_pages;
    }
       
    echo "<h4>Пользователи</h4>";
    $html=<<<_html
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Логин</th>
                
                <th>Дата регистрации</th>
                <th>Телефон</th>
                <th>Действие</th>
            </tr>
        </thead>
_html;
    echo $html;
    echo "<tbody>";
    while ($row = mysql_fetch_assoc($res)) 
    {
        if ($row['block']=="block") 
        {
            $icon_class = "icon-plus";
            $icon_text = "Разблокировать";
            $tr_class = "error";
        }
        else
        {
            $icon_class = "icon-remove";
            $icon_text = "Блокировать";
            $tr_class = "success";
        }
        echo "<tr class='$tr_class'>";
        echo "<td>";        echo $row['login'];        echo "</td>";
        echo "<td>";        
        echo $row['date_reg'];
        echo "</td>";
        echo "<td>";        echo $row['tel'];        echo "</td>";
        $info_id = $row['id'];
        $html=<<<_html
        <td>
            <div class="btn-group">
                <a href="" class="btn disabled" onclick="return false">
                <i class="icon-edit"></i>
                Изменить
                </a>
                <a href="#" class="btn info">
                <i class="icon-info-sign"></i>
                    Инфо
                </a>

                <input type="hidden" class="info" value="$info_id">
                <span class="div_block">
                <a href="#myModal" class="btn btn-danger block" data-toggle="modal">
                <i class="$icon_class icon-large icon-white"> </i> 
                $icon_text
                </a>
                </span>
            </div>
        </td>
_html;
        echo $html;    
    }
    echo "</tbody>";
    echo "</table>";
?>
