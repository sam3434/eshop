<?php 
	include("pChart/class/pData.class.php");
include("pChart/class/pDraw.class.php");
include("pChart/class/pPie.class.php");
include("pChart/class/pImage.class.php");
/* pData object creation */
$MyData = new pData();
/* Data definition */
$MyData->addPoints(array(20,30,25,10),"Value");
/* Labels definition */
$MyData->addPoints(array("January","February","March","April"),"Legend");
$MyData->setAbscissa("Legend");
/* Create the pChart object */
$myPicture = new pImage(600,300,$MyData);
/* Draw a gradient background */
$myPicture->drawGradientArea(0,0,600,300,DIRECTION_HORIZONTAL,array("StartR"=>220,"StartG"=>220,"StartB"=>220,"EndR"=>180,"EndG"=>180,
"EndB"=>180,"Alpha"=>100));
/* Add a border to the picture */
$myPicture->drawRectangle(0,0,599,299,array("R"=>0,"G"=>0,"B"=>0));
/* Create the pPie object */
$PieChart = new pPie($myPicture,$MyData);
/* Enable shadow computing */
$myPicture->setShadow(FALSE);
/* Set the default font properties */
$myPicture->setFontProperties(array("FontName"=>"pChart/fonts/Forgotte.ttf","FontSize"=>10,"R"=>80,"G"=>80,"B"=>80));
/* Draw a splitted pie chart */
$PieChart->draw3DPie(250,150,array("Radius"=>140,"DrawLabels"=>TRUE,"DataGapAngle"=>10,"DataGapRadius"=>6,"Border"=>TRUE));
/* Render the picture (choose the best way) */
//$myPicture->autoOutput("pie.png");

 ?>