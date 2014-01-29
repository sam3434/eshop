<?php 
    require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/users/config_user.php";
    if (isset($_GET['info_id'])) 
    {
        $id = intval($_GET['info_id']);
    }
    else
    {
        $id = 1;
    }
    $user = user($id);
    if ($user!=null && empty($user['mail'])) 
    {
        $user['mail'] = "не указано";
    }
    $html=<<<_html
    <h5>Информация о пользователе</h5>
    <table class="table">
        <tr>
            <td>Логин</td>
            <td>{$user['login']}</td>
        </tr>
        <tr>
            <td>ФИО</td>
            <td>{$user['fio']}</td>
        </tr>
        <tr>
            <td>Email</td>
            <td>{$user['mail']}</td>
        </tr>
        <tr>
            <td>Моб. телефон</td>
            <td>{$user['tel']}</td>
        </tr>
        <tr>
            <td>Адрес</td>
            <td>{$user['address']}</td>
        </tr>
        <tr>
            <td>Дата регистрации</td>
            <td>{$user['date_reg']}</td>
        </tr>
        <tr>
            <td>Скидка</td>
            <td>{$user['discount']}</td>
        </tr>
        <tr>
            <td>Дата рождения</td>
            <td>{$user['date_b']}</td>
        </tr>
    </table>
_html;
    if ($user!=null)
    {
        echo $html;
    }
?>