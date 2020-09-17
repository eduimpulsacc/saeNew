<?php 
require('../../../../../util/header.inc');

//	$plantilla	=$_PLANTILLA;

if($plantilla==""){
	if($_PLANTILLA!="") {
		$plantilla	=$_PLANTILLA;
	
	}
}


	$fechaCreacion = date("d-m-Y H:i:s");

	//crea el area
	for($cantidad=0 ; $cantidad<$cant ; $cantidad++){
		
		$sqlSubarea="INSERT INTO informe_subarea (id_area, nombre, fecha_creacion) VALUES(".$cmbArea[$cantidad].", '".$txtNombreSubar[$cantidad]."', to_date('" .$fechaCreacion. "','DD MM YYYY'))";
		$resultSubarea=pg_Exec($conn, $sqlSubarea);
		if (!$resultSubarea)
			error('<b> ERROR :</b>Error al acceder a la BD. (1)'.$sqlSubarea);

		}
		echo $sqltraeAreaSubarea="select id_area, nombre from informe_area where id_plantilla=".$plantilla." and con_subarea=0 and subarea_creada=0";
		//exit;
		$res_sqlTraeAreaSubarea=pg_exec($conn, $sqltraeAreaSubarea);
		for($i=0 ; $i<pg_numrows($res_sqlTraeAreaSubarea) ; $i++){
			$filaAreaSubarea=pg_fetch_array($res_sqlTraeAreaSubarea, $i);
			$sqlAreaSubarea="INSERT INTO informe_subarea (id_area, nombre, fecha_creacion) VALUES(".$filaAreaSubarea['id_area'].", '".trim($filaAreaSubarea['nombre'])."', to_date('" .$fechaCreacion. "','DD MM YYYY'))";
			$res_AreaSubarea=pg_exec($conn, $sqlAreaSubarea);
			$sqlSaCreada="insert into informe_area (subarea_creada) values (1)";
		}
		echo "<script>parent.location='../../plantillaModifica/plantillaPaso2.php?subareaCreada=1&plantilla=$plantilla'</script>";
		
	
	//}


?>
