<?php 
require('../../../../../../util/header.inc');

	$plantilla	=$_PLANTILLA;

	$fechaCreacion = date("d-m-Y H:i:s");

	//crea el area
	for($cantidad=0 ; $cantidad<$cant ; $cantidad++){
		
		$sqlSubarea="INSERT INTO informe_item (id_subarea, glosa, tipo, fecha_creacion) VALUES(".$subarea.", '".$txtNombreItem[$cantidad]."', '".$con_concepto[$cantidad]."', to_date('" .$fechaCreacion. "','DD MM YYYY'))";
		$resultSubarea=pg_Exec($conn, $sqlSubarea);
		if (!$resultSubarea)
			error('<b> ERROR :</b>Error al acceder a la BD. (1)'.$sqlSubarea);
		else{
		
			//trae el id de la ultima area para registrarlo en la session
			/*$sqlTraeId="select max (id_subarea) as id_subarea from informe_subarea where id_plantilla=".$plantilla;
			$resultTraeId=pg_Exec($conn, $sqlTraeId);
				if (!$resultTraeId)
					error('<b> ERROR :</b>Error al acceder a la BD. (2)'.$sqlTraeId);
				else{
					$filaTraeId=pg_fetch_array($resultTraeId,0);
					$_AREA=$filaTraeId['id_area'];
			
					//registra el id de la ultima area en la session, la q recien se grabó
					if(!session_is_registered('_AREA')){
							session_register('_AREA');
					};
				}//fin if (!$resultTraeId)*/
		}//fin if (!$resultCrea)
		
		/*echo "<script>window.location='creaArea.php?creada=1&id_area=".$_AREA."'</script>";*/
		echo "<script>parent.location='../../../plantillaModifica/plantillaPaso2.php?itemCreado=1&subareaCreada=1&subarea=".$subarea."'</script>";
		
	
	}


?>
