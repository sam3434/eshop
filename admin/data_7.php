<?php

include 'php-ofc-library/open-flash-chart.php';
require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/stats/stats.php";
 $date = " where DATE_SUB(CURDATE(), INTERVAL 7 DAY)<=begin_date";
 require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/admin/utils/stats/pages_count.php";

$title = new title( 'Посещаемость страниц за 7 дней' );
$title->set_style('color: #00000; font-size: 20px');
$pies = array();
foreach ($arr as $row) 
{
    $pies[] = new pie_value(intval($row['count(p.address)']), "");
    $pies[count($pies)-1]->set_label($row['address'], null, "17");

}
$pie = new pie();
$pie->alpha(0.5)
    ->add_animation( new pie_fade() )
    ->start_angle( 0 )
    ->tooltip( 'Radius: #radius#' )
    ->colours(array("#d01f3c","#356aa0","#C79810", "#1a5c69"))
    ->values( $pies )
    ->radius(250);
$pie->set_tooltip( '#val# of #total#<br>#percent# of 100%' );
$pie->set_gradient_fill();
$chart = new open_flash_chart();
$chart->set_title( $title );
$chart->add_element( $pie );
$chart->set_bg_colour('#ffffff');

echo $chart->toPrettyString();