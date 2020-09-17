<?php
require('../../../../util/header.inc');

/*$str = "area:121";
$dir = substr (strrchr ($str, ":"), 1);
echo "dir",$dir;

$pos = strpos ($str, ":");
echo "pos",$pos;

$inicio = $pos;
$pri = substr ($str, 0, $inicio);
echo "pri",$pri;

echo "plantilla",$plantilla;*/


//traigo las areas de la plantilla actual
$sql_0 = "select * from informe_area where id_plantilla=".$plantilla." order by id_area";
$res_0 = @pg_exec($conn,$sql_0);

$sql_titulo = "select * from informe_plantilla where id_plantilla=".$plantilla." ";
$res_titulo = @pg_exec($conn,$sql_titulo);
$filaPlantilla=@pg_fetch_array($res_titulo,0);

if(trim($Titulo1)=='' || trim($Titulo1)==NULL ){
	$titulo1 = "Informe Educacional";
}else{
	$titulo1 = $Titulo1;
}

if(trim($Titulo2)=='' || trim($Titulo2)==NULL ){
	$titulo2 = "INFORME DE DESARROLLO PERSONAL Y SOCIAL";
}else{
	$titulo2 = $Titulo2;
}

$sql_update_titulo = "update informe_plantilla set titulo_informe1='".$titulo1."', titulo_informe2='".$titulo2."' WHERE id_plantilla =". $plantilla;
$res_update_titulo=pg_exec($conn, $sql_update_titulo);

//recorro las areas para actualizar
for ($a=0 ; $a<pg_numrows($res_0) ; $a++){
		$fila_area = pg_fetch_array($res_0, $a);
		$id_area = $fila_area['id_area'];
		if ($delAREA[$id_area]==1){
			//traigo las subareas para eliminar subareas e itemes
			$sql_suba="select id_subarea from informe_subarea where id_area=".$id_area;
			$res_sql_suba=pg_exec($conn, $sql_suba);
			for ($i=0 ; $i<pg_numrows($res_sql_suba) ; $i++){
				$fila_suba=pg_fetch_array($res_sql_suba,$i);
				//elimino los itemes
				$sql_del_it="delete from informe_item where id_subarea=".$fila_suba['id_subarea'];
				$res_del_it=pg_exec($conn, $sql_del_it);
				//elimino la subarea
				$sql_del_sub="delete from informe_subarea where id_subarea=".$fila_suba['id_subarea'];
				$res_del_sub=pg_exec($conn, $sql_del_sub);
			}
			//elimino el area
			$sql_del_area="delete from informe_area where id_area=".$id_area;
			$res_del_area=pg_exec($conn, $sql_del_area);
		}else{
			$sql_update_area = "update informe_area set nombre='".$AREA[$id_area]."' WHERE id_area =". $id_area;
			$res_update_area=pg_exec($conn, $sql_update_area);
			
			
			//traigo las subareas del area actual
			 $sql_1 = "select id_subarea from informe_subarea where id_area=".$id_area." order by id_subarea";
				$res_1=pg_exec($conn, $sql_1);
				
				//recorro las subareas para actualizar
				for($s = 0 ; $s<pg_numrows($res_1) ; $s++){
					$fila_subarea = pg_fetch_array($res_1, $s);
					$id_subarea = $fila_subarea['id_subarea'];
					if ($delSUBAREA[$id_subarea]==1){
						//ELIMINO LOS ITEMES QUE DEPENDEN DE LA SUBAREA
						$sql_del_itemes_subarea="delete from informe_item where id_subarea=".$id_subarea;
						$res_del_itemes_subarea=pg_exec($conn, $sql_del_itemes_subarea);
						
						//ELIMINO LA SUBAREA
						$sql_del_subarea="delete from informe_subarea where id_subarea=".$id_subarea;
						$res_del_subarea=pg_exec($conn, $sql_del_subarea);
					}else{	
						$sql_update_subareas = "update informe_subarea set nombre='".$SUBAREA[$id_subarea]."' where id_subarea =".$id_subarea;
						$res_update_subareas=pg_exec($conn, $sql_update_subareas);
						
		
					//traigo los items para la subarea actual
									$sql_2 = "select * from informe_item where id_subarea=".$id_subarea." order by id_item";
									$res_2=pg_exec($conn, $sql_2);
		
												//recorro los itemes para actualizar o eliminar
									for($i = 0 ; $i<pg_numrows($res_2) ; $i++){
										$fila_item= pg_fetch_array($res_2, $i);
										$id_item = $fila_item['id_item'];
										if ($delITEM[$id_item]==1){
											$sql_del_item="delete from informe_item where id_item=".$id_item;
											$res_del_item=pg_exec($conn, $sql_del_item);
										}else{
											$sql_update_item = "update informe_item set glosa='".$ITEM[$id_item]."' where id_item =".$id_item;
											$res_update_item=pg_exec($conn, $sql_update_item);
										}// FIN if ($delITEM[$id_item]==1){ ELIMINA ITEMES
									}// fin for($i = 0 ; $i<pg_numrows($res_2) ; $i++){
					}//fin if ($delSUBAREA[$id_subarea]==1) ELIMINA SUBAREA
				}//fin for de subareas
		}//if ($delAREA[$id_area]==1) ELIMINA AREA

}//fin for areas
		echo "<script>window.location='../plantilla/muestraPlantilla.php?plantilla=$plantilla'</script>";
?>
