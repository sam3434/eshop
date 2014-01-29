<?php

include 'php-ofc-library/open-flash-chart.php';
require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/stats/stats.php";
require_once $_SERVER['DOCUMENT_ROOT']."/eshop1/admin/utils/stats/hits_order_count.php";

$data = array();
$year = array();
$max = -1;
for ($i=0; $i < count($arr); $i++) { 
	$data[] = intval($arr[$i][1]);
	$year[] = $arr[$i][0];
	if (intval($arr[$i][1])>$max)
		$max = intval($arr[$i][1]);
}

$chart = new open_flash_chart();

$area = new area();
$area->set_colour( '#5B56B6' );
$area->set_values( $data );
$area->set_key( 'Количество хитов', 16 );
$chart->add_element( $area );

$x_labels = new x_axis_labels();
$x_labels->set_steps( 1 );
$x_labels->set_size(15);
$x_labels->set_vertical();
$x_labels->set_colour( '#000' );
$x_labels->set_labels( $year );

$x = new x_axis();
$x->set_colour( '#000' );
$x->set_grid_colour( '#dddddd' );
$x->set_offset( false );
$x->set_steps(4);
// Add the X Axis Labels to the X Axis
$x->set_labels( $x_labels );

$chart->set_x_axis( $x );



$y = new y_axis();
$y->set_grid_colour( '#dddddd' );
$y->set_colour( '#000' );
$step = intval($max/30);
$y->set_range( 0, $max+$step, $step );
$chart->add_y_axis( $y );
$chart->set_bg_colour('#ffffff');
echo $chart->toPrettyString();

?>
