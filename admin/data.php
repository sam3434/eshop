<?php

include 'php-ofc-library/open-flash-chart.php';

$data = array();
$year = array();
for ($i=0; $i < 10; $i++) { 
	$data[] = $i+1;
}

$data[0] = 7;


$year[] = "Пон";
$year[] = "Вторник";
$year[] = "Среда";
$year[] = "Четверг";
$year[] = "Пятница";
$year[] = "Суббота";
$year[] = "Вторник";
$year[] = "Среда";
$year[] = "Четверг";
$year[] = "Пятница";

$chart = new open_flash_chart();

$area = new area();
$area->set_colour( '#5B56B6' );
$area->set_values( $data );
$area->set_key( 'Data', 12 );
$chart->add_element( $area );

$x_labels = new x_axis_labels();
$x_labels->set_steps( 1 );
$x_labels->set_size(15);
//$x_labels->set_vertical();
$x_labels->set_colour( '#000' );
$x_labels->set_labels( $year );

$x = new x_axis();
$x->set_colour( '#A2ACBA' );
$x->set_grid_colour( '#D7E4A3' );
$x->set_offset( false );
$x->set_steps(4);
// Add the X Axis Labels to the X Axis
$x->set_labels( $x_labels );

$chart->set_x_axis( $x );



$y = new y_axis();
$y->set_range( 0, 150, 30 );
$chart->add_y_axis( $y );

echo $chart->toPrettyString();


?>
