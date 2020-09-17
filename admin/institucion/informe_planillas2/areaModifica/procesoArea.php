<?php 
require('../../../../util/header.inc');

	$plantilla	=$_PLANTILLA;

	//quitar de la session algun id_area anterior
	if(!session_is_registered('_AREA')){
		session_unregister('_AREA');
	};
	
	$fechaCreacion = date("d-m-Y H:i:s");

	//crea el area
	for($cantidad=0 ; $cantidad<$cant ; $cantidad++){
		
		$sqlArea="INSERT INTO informe_area (nombre, id_plantilla, con_concepto, fecha_creacion, con_subArea) VALUES('".$txtNombreAr[$cantidad]."', ".$plantilla.", ".$concepto[$cantidad].", to_date('" .$fechaCreacion. "','DD MM YYYY'), ".$subArea[$cantidad].")";
		$resultArea=pg_Exec($conn, $sqlArea);
		if (!$resultArea)
			error('<b> ERROR :</b>Error al acceder a la BD. (1)'.$sqlArea);
			//exit;
		else{
		
			//trae el id de la ultima area para registrarlo en la session
			$sqlTraeId="select max (id_area) as id_area from informe_area where id_plantilla=".$plantilla;
			$resultTraeId=pg_Exec($conn, $sqlTraeId);
				if (!$resultTraeId)
					error('<b> ERROR :</b>Error al acceder a la BD. (2)'.$sqlTraeId);
					//exit;
				else{
					$filaTraeId=pg_fetch_array($resultTraeId,0);
					$_AREA=$filaTraeId['id_area'];
			
					//registra el id de la ultima area en la session, la q recien se grabó
					if(!session_is_registered('_AREA')){
							session_register('_AREA');
					};
				}//fin if (!$resultTraeId)
		}//fin if (!$resultCrea)
		
		/*echo "<script>window.location='creaArea.php?creada=1&id_area=".$_AREA."'</script>";*/
		echo "<script>parent.location='../plantillaModifica/plantilla.php'</script>";
	}
	
?>