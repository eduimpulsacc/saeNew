<?php 
require('../../../../util/header.inc');

$institucion	=$_INSTIT;
	
	//quitar de la session algun id_plantilla anterior
	if(!session_is_registered('_PLANTILLA')){
		session_unregister('_PLANTILLA');
	};
	
	$fechaCreacion = date("d-m-Y H:i:s");
	
	//crea la plantilla
	$sqlCrea="insert into informe_plantilla (rdb, nombre, tipo_ensenanza, fecha_creacion) values(".$institucion.", '".$txtNombrePla."', ".$cmbEns.", to_date('" .$fechaCreacion. "','DD MM YYYY'))";
	$resultCrea=pg_Exec($conn, $sqlCrea);
		if (!$resultCrea)
			error('<b> ERROR :</b>Error al acceder a la BD. (1)'.$sqlCrea);
		else{
		
			//trae el id ded la ultima plantilla para registrarlo en la session
			$sqlTraeId="select max (id_plantilla) as id_plantilla from informe_plantilla where rdb=".$institucion;
			$resultTraeId=pg_Exec($conn, $sqlTraeId);
				if (!$resultTraeId)
					error('<b> ERROR :</b>Error al acceder a la BD. (2)'.$sqlTraeId);
				else{
					$filaTraeId=pg_fetch_array($resultTraeId,0);
					$_PLANTILLA=$filaTraeId['id_plantilla'];
			
					//registra el id de la ultima plantilla en la session, la q recien se grabó
					if(!session_is_registered('_PLANTILLA')){
							session_register('_PLANTILLA');
					};
				}//fin if (!$resultTraeId)
		}//fin if (!$resultCrea)
		
		/*echo "<script>window.location='creaPlantilla.php?creada=1&plantilla=".$_PLANTILLA."'</script>";*/
		echo "<script>parent.location='plantilla.php'</script>";
?>
