<?php

/* qry() devuelve consulta sql de la lista de reservas tipo.*/

function qry($date, $dateEnd, $type){

global $connection;

$sql = "SELECT mrbs_entry.name,mrbs_entry.description,from_unixtime(mrbs_entry.start_time),
				from_unixtime(mrbs_entry.end_time),mrbs_entry.room_id,mrbs_room.room_name
						FROM mrbs_entry INNER JOIN mrbs_room ON mrbs_entry.room_id = mrbs_room.id
				WHERE (from_unixtime(mrbs_entry.start_time) BETWEEN '$date' AND '$dateEnd')
						AND mrbs_entry.type = '$type'
				ORDER BY from_unixtime(mrbs_entry.start_time);";

$qry = mysqli_query($connection, $sql);
return $qry;
}

/* qryState() devuelve la última fila de la consulta sql de reservas tipo para
evaluar si existen reservas (ocupación).*/

function qryState($date, $dateEnd, $type){

global $connection;

$sql = "SELECT mrbs_entry.name,mrbs_entry.description,from_unixtime(mrbs_entry.start_time),
				from_unixtime(mrbs_entry.end_time),mrbs_entry.room_id,mrbs_room.room_name
						FROM mrbs_entry INNER JOIN mrbs_room ON mrbs_entry.room_id = mrbs_room.id
				WHERE (from_unixtime(mrbs_entry.start_time) BETWEEN '$date' AND '$dateEnd')
				 		AND mrbs_entry.type = '$type'
				ORDER BY from_unixtime(mrbs_entry.start_time) DESC LIMIT 1;";

$qry = mysqli_query($connection, $sql);
return $qry;
}

/* ocupationState() evalúa si existen o no reservas en función de la fecha y hora
del sistema.*/

function occupationState($qryState){

	global $date;
 	global $time;

	$row = mysqli_fetch_array($qryState);
	$dateBookingEnd = substr($row[3],0,10);
	$timeBookingEnd = substr($row[3],11,5);

	if (mysqli_num_rows($qryState) == 0){
		return 0;
	}else{
		if ( ($dateBookingEnd > $date) || ($timeBookingEnd >= $time) ){
			return 1;
		}else{
			return 0;
		}
	}
}

/* printOccupationTable() devuelve la lista de reservas en función de la hora del
sistema.*/

 function printOccupationTable($qry){

	global $date;
 	global $time;

 	echo '<div><ul id=contain>';

 	while($row = mysqli_fetch_array($qry)) { //$row debe estar definida aquí.
		$dateBookingEnd = substr($row[3],0,10);
		$timeBookingEnd = substr($row[3],11,5);

		if ( ($dateBookingEnd > $date) || ($timeBookingEnd >= $time) ){
 			echo '<li class="prueba"><table><tr>
 						<th width="33%">Día ' . substr($row[3],8,2). '-' . substr($row[3],5,2).
 						' / ' . substr($row[2],11,5) . ' horas en ' . utf8_encode ($row['room_name']) .
 						'</th><th width=\"4%\">---></th><th> ' . utf8_encode ($row['name']) .
 						'</th></tr>';

 			if (empty ($row['description'])){
 				echo '<tr><td colspan="3">No existe información detallada para esta actividad
							</td></tr></table></li>';
 			}else{
 				echo '<tr><td colspan="3">' . utf8_encode ($row['description']) .
 						 '</td></tr></table></li>';
 			}
 		}
 	}
 	echo '</ul></div>';
 }
?>
