<?php

// Pendiente: definir un front-end diferente.

require_once ("config.inc.php");
require_once ("functions.php");

$connection=mysqli_connect($mysqlhost, $mysqluser, $mysqlpwd, $mysqldb);
mysqli_select_db($connection, $mysqldb);

$date   = date('Y-m-d');
$time   = date('H:i');
$dateEnd = date_create($date);
date_add ($dateEnd, date_interval_create_from_date_string('' .$dateRange . 'days'));
$dateEnd = date_format($dateEnd, 'Y-m-d');

echo '<!DOCTYPE html>
			<html>
			<head>
			<meta charset="UTF-8">
			<link rel="stylesheet" type="text/css" href="css/style.css" />
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
			<title>' . $titlePage . '</title>
			<script type="text/javascript" src="js/jquery-3.1.1.min.js"></script>
			<script type="text/javascript" src="js/infinite.scroll.js"></script>
			</head>
			<body>';

echo '<div id="pricing-table" class="clear">
			<div class="plan" id="most-popular">
			<h3>' . $title;

if (occupationState(qryState($date, $dateEnd, $mrbsType)) == 1){
	echo '<span class="large"><font color="#4267b2">PRÓXIMAMENTE</font></span></h3>';

}else{
	echo '<span class="large"><font color="#4267b2">ESTAMOS ESPERANDO TU TFE</font>
				</span></h3>';

}
printOccupationTable(qry($date, $dateEnd, $mrbsType));
echo '</div></div>';
getIndicators(qry($date, $dateEnd, $mrbsType));
echo '</body></html>';
?>
