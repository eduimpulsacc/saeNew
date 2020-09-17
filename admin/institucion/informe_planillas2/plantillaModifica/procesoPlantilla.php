<?php require('../../../../util/header.inc');

//$Modo	=$_FRMMODO;
$institucion	=$_INSTIT;
$eliminar=$_GET[eliminar];
//$eliminar=$hiddenPlantilla;
$plantilla=$hiddenPlantilla;
	
	if($pa)		$pa=1; else $pa=0;
	if($sa)		$sa=1; else	$sa=0;	
	if($ta)		$ta=1; else	$ta=0;	
	if($cu)		$cu=1; else	$cu=0;	
	if($qu)		$qu=1; else	$qu=0;	
	if($sx)		$sx=1; else	$sx=0;	
	if($sp)		$sp=1; else	$sp=0;	
	if($oc)		$oc=1; else	$oc=0;
	
	//quitar de la session algun id_plantilla anterior
	if(session_is_registered('_PLANTILLA')){
		session_unregister('_PLANTILLA');
	};
	
	$fechaCreacion = date("d-m-Y H:i:s");
	
if($Modo=="modificar"){
	for($i=0;$i<$CantArea;$i++){
		$SQLAREA ="UPDATE informe_area SET nombre='" . $NomArea[$i] . "' WHERE id_area=" . $IdArea[$i];
		$SQLSUBAREA = "UPDATE informe_subarea SET nombre='" . $NomSubArea[$i] ."' WHERE id_subarea= " . $IdSubArea[$i];
		$ResultArea = @pg_exec($conn, $SQLAREA);
		$ResultSubArea = @pg_exec($conn, $SQLSUBAREA);
		
	}
	for($j=1;$j<=$CantItem;$j++){
		$SQLITEM = "UPDATE informe_item SET glosa = '" . $NomItem[$j] ."' WHERE id_item = " . $IdItem[$j];
		$ResultItem = @pg_exec($conn, $SQLITEM);
		
	}

	if ((!$ResultArea) and (!$ResultSubArea) and (!$ResultItem)){
		error('<b> ERROR :</b>Error al acceder a la BD. (2)'.$SQLAREA."<br>".$SQLSUBAREA."<br>".$SQLITEM);
		exit;
	}
	echo "<script>window.location = 'seteaPlantilla.php?caso=1' </script>";
}else{
	if($eliminar!=1){
		//crea la plantilla
		$sqlCrea="insert into informe_plantilla (rdb, nombre, tipo_ensenanza, fecha_creacion, pa, sa, ta, cu, qu, sx, sp, oc) values(".$institucion.", '".$txtNombrePla."', ".$cmbEns.", to_date('" .$fechaCreacion. "','DD MM YYYY'), ".$pa.",".$sa.",".$ta.",".$cu.",".$qu.",".$sx.",".$sp.",".$oc.")";
		$resultCrea=pg_Exec($conn, $sqlCrea);
			if (!$resultCrea)
				echo "error 50";//error('<b> ERROR :</b>Error al acceder a la BD. (1)'.$sqlCrea);
			else{
				//trae el id ded la ultima plantilla para registrarlo en la session
				$sqlTraeId="select max (id_plantilla) as id_plantilla from informe_plantilla where rdb=".$institucion;
				$resultTraeId=pg_Exec($conn, $sqlTraeId);
					if (!$resultTraeId)
						echo "error 56";//error('<b> ERROR :</b>Error al acceder a la BD. (2)'.$sqlTraeId);
					else{
						$filaTraeId=pg_fetch_array($resultTraeId,0);
						$_PLANTILLA=$filaTraeId['id_plantilla'];
				
						//registra el id de la ultima plantilla en la session, la q recien se grabó
						if(!session_is_registered('_PLANTILLA')){
								session_register('_PLANTILLA');
						};
					//inserto en plantillaGrado
					/*$sqlInsGrados="INSERT INTO informe_plantillagrado (id_plantilla, pa, sa, ta, cu, qu, sx, sp, oc) VALUES (".$_PLANTILLA.",".$pa.",".$sa.",".$ta.",".$cu.",".$qu.",".$sx.",".$sp.",".$oc.")";
					$resultGrados=pg_Exec($conn, $sqlInsGrados);
					if (!$resultGrados)
						error('<b> ERROR :</b>Error al acceder a la BD. (2)'.$sqlInsGrados);*/
					
					}//fin if (!$resultTraeId)
			}//fin if (!$resultCrea)
			echo "<script>parent.location='plantilla.php'</script>";
		}else//fin if($eliminar!=1)
		
		if($eliminar==1){
		$sqlElimina="update informe_plantilla set activa=0 where id_plantilla=".$plantilla;
		$resultElimina=pg_exec($conn, $sqlElimina);
			if (!$resultElimina) {
				error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>'.$sqlElimina);
			}

		
		
		echo "<script>parent.location='listaPlantillas.php'</script>";
		}//fin if($eliminar==1)
			
			/*echo "<script>window.location='creaPlantilla.php?creada=1&plantilla=".$_PLANTILLA."'</script>";*/

}// fin If MODO		
?>
