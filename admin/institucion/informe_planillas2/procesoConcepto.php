<?php
require('file:///C|/xampp/sae/desarollo/util/header.inc');

	$plantilla	=$_PLANTILLA;

	//quitar de la session algun id_area anterior
	if(!session_is_registered('_CONCEPTO')){
		session_unregister('_CONCEPTO');
	};
	
	$fechaCreacion = date("d-m-Y H:i:s");
	
	for($cantidadC=0 ; $cantidadC<$canti ; $cantidadC++){
		$sqlConcepto="INSERT INTO informe_concepto_eval (id_plantilla, nombre, sigla, fecha_creacion) VALUES(".$plantilla.", '".$txtNombreConc[$cantidadC]."', '".$txtSiglaConc[$cantidadC]."', to_date('" .$fechaCreacion. "','DD MM YYYY'))";
		$resultConcepto=pg_Exec($conn, $sqlConcepto);
		if (!$resultConcepto)
			error('<b> ERROR :</b>Error al acceder a la BD. (1)'.$sqlConcepto);
		else{
		
			//trae el id de la ultimo concepto para registrarlo en la session
			$sqlTraeId="select max (id_concepto) as id_concepto from informe_concepto_eval where id_plantilla=".$plantilla;
			$resultTraeId=pg_Exec($conn, $sqlTraeId);
				if (!$resultTraeId)
					error('<b> ERROR :</b>Error al acceder a la BD. (2)'.$sqlTraeId);
				else{
					$filaTraeId=pg_fetch_array($resultTraeId,0);
					$_CONCEPTO=$filaTraeId['id_concepto'];
			
					//registra el id de la ultima area en la session, la q recien se grabó
					if(!session_is_registered('_CONCEPTO')){
							session_register('_CONCEPTO');
					};
				}//fin if (!$resultTraeId)
		}//fin if (!$resultCrea)
		
		/*echo "<script>window.location='creaConcepto.php?creada=1&id_concepto=".$_CONCEPTO."'</script>";*/
		echo "<script>parent.location='plantilla.php'</script>";	
	
	}//fin for

?>
