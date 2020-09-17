<?php require('../../../util/header.inc');

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
	if($nv)		$nv=1; else	$nv=0;
	if($dc)		$dc=1; else	$dc=0;
	if($un)		$un=1; else	$un=0;
	if($duo)		$duo=1; else	$duo=0;
	if($tre)		$tre=1; else	$tre=0;
	if($cat)		$cat=1; else	$cat=0;
	if($quince)		$quince=1; else	$quince=0;
	if($diezseis)		$diezseis=1; else	$diezseis=0;
	if($diecisiete)		$diecisiete=1; else	$diecisiete=0;
	if($dieciocho)		$dieciocho=1; else	$dieciocho=0;
	if($diecinueve)		$diecinueve=1; else	$diecinueve=0;
	if($veinte)		$veinte=1; else	$veinte=0;
	if($veintiuno)		$veintiuno=1; else	$veintiuno=0;
	if($veintidos)		$veintidos=1; else	$veintidos=0;
	if($veintitres)		$veintitres=1; else	$veintitres=0;
	if($veinticuatro)		$veinticuatro=1; else	$veinticuatro=0;
	if($veinticinco)		$veinticinco=1; else	$veinticinco=0;
	
	//quitar de la session algun id_plantilla anterior
	if(session_is_registered('_PLANTILLA')){
		session_unregister('_PLANTILLA');
	};
	
	
		$fechaCreacion = date("m-d-Y");
	
	
if($Modo=="modificar"){
	for($i=0;$i<$CantArea;$i++){
		$SQLAREA ="UPDATE informe_area SET nombre='" . $NomArea[$i] . "' WHERE id_area=" . $IdArea[$i];
		$SQLSUBAREA = "UPDATE informe_subarea SET nombre='" . $NomSubArea[$i] ."' WHERE id_subarea= " . $IdSubArea[$i];
		$ResultArea = @pg_exec($conn, $SQLAREA);
		$ResultSubArea = @pg_exec($conn, $SQLSUBAREA);
		
	}
	for($j=1;$j<=$CantItem;$j++){
		$SQLITEM = "UPDATE informe_item SET glosa = '" . $NomItem[$j] ."' WHERE id_item = " . $IdItem[$j];
		$ResultItem = @pg_exec($conn, $SQLITEM) or die ("update ".$SQLITEM);
		
	}

	if ((!$ResultArea) and (!$ResultSubArea) and (!$ResultItem)){
		error('<b> ERROR :</b>Error al acceder a la BD. (2)'.$SQLAREA."<br>".$SQLSUBAREA."<br>".$SQLITEM);
		exit;
	}
	
		echo "<script>parent.location='crea_informe_2.php'</script>";
}else{
	if($eliminar!=1){
		//crea la plantilla
//		$sqlCrea="insert into informe_plantilla (rdb, nombre, tipo_ensenanza, fecha_creacion, pa, sa, ta, cu, qu, sx, sp, oc) values(".$institucion.", '".$txtNombrePla."', ".$cmbEns.", to_date('" .$fechaCreacion. "','DD MM YYYY'), ".$pa.",".$sa.",".$ta.",".$cu.",".$qu.",".$sx.",".$sp.",".$oc.")";

		if(trim($txtNombreTitulo1)=='' || trim($txtNombreTitulo1)==NULL){
			$titulo1 = "Informe Educacional";
		}
		else{
			$titulo1 = $txtNombreTitulo1;
		}
		if(trim($txtNombreTitulo2)=='' || trim($txtNombreTitulo2)==NULL){
			$titulo2 = "INFORME DE DESARROLLO PERSONAL Y SOCIAL";
		}
		else{
			$titulo2 = $txtNombreTitulo2;
		}

		/*if(pg_dbname($conn)=="coi_antofagasta"){
			$fechaCreacion = fEs2En($fechaCreacion);
		}*/
		 $sqlCrea="insert into informe_plantilla (rdb, nombre, tipo_ensenanza, fecha_creacion, pa, sa, ta, cu, qu, sx, sp, oc, nv,dc,un,duo,titulo_informe1, titulo_informe2,nuevo_sis,tre,cat,quince,diezseis,tipo,diecisiete,dieciocho,diecinueve,veinte,veintiuno,veintidos,veintitres,veinticuatro,veinticinco)
		 values(".$institucion.", '".$txtNombrePla."', ".$cmbEns.",'$fechaCreacion', ".$pa.",".$sa.",".$ta.",".$cu.",".$qu.",".$sx.",".$sp.",".$oc.",'".$nv."','".$dc."','".$un."','".$duo."','".$titulo1."','".$titulo2."','1',$tre,$cat,$quince,$diezseis,$tipo_planilla,$diecisiete,$dieciocho,$diecinueve,$veinte,$veintiuno,$veintidos,$veintitres,$veinticuatro,$veinticinco)";
		// exit;
	
		$resultCrea=pg_Exec($conn, $sqlCrea) or die("insert-->".$sqlCrea);

			if (!$resultCrea){
				echo "error 50";//error('<b> ERROR :</b>Error al acceder a la BD. (1)'.$sqlCrea);
			}else{
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
			
		echo "<script>parent.location='crea_informe_2.php'</script>";
		}else//fin if($eliminar!=1)
		
		if($eliminar==1){
		$sqlElimina="update informe_plantilla set activa=0 where id_plantilla=".$plantilla;
		$resultElimina=pg_exec($conn, $sqlElimina);
			if (!$resultElimina) {
				error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>'.$sqlElimina);
			}

		
		
		
		echo "<script>parent.location='crea_informe_2.php'</script>";
		}//fin if($eliminar==1)
			
			/*echo "<script>window.location='creaPlantilla.php?creada=1&plantilla=".$_PLANTILLA."'</script>";*/

}// fin If MODO		
?>

?>
