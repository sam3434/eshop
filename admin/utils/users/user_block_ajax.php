<?php 
	require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/users/config_user.php";
	require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/database/update_tables.php";
    if (isset($_GET['block_id'])) 
    {
        $id = intval($_GET['block_id']);
    }
    else
    {
        $id = 1;
    }
    $user = user($id);
    $msgs = array();
    if ($user['block']=="block") 
    {
    	$icon_class = "icon-remove";
        $icon_text = "Блокировать";
    	update_user_block($id, 'unblock');
    }
    else
    {
    	$icon_class = "icon-plus";
        $icon_text = "Разблокировать";
    	update_user_block($id, 'block');    	
    }

//     $html=<<<_html
// 	    <a href="#myModal" class="btn btn-danger block" data-toggle="modal">
// 	    <i class="$icon_class icon-large icon-white"> </i> 
// 	    $icon_text
// 	    </a>
// _html;
// 	echo $html;
 ?>