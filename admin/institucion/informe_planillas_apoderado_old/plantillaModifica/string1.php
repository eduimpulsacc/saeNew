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

//recorro las areas para actualizar
for ($a=0 ; $a<pg_numrows($res_0) ; $a++){
		$fila_area = pg_fetch_array($res_0, $a);
		$id_area = $fila_area['id_area'];
		$sql_update_area = "update informe_area set nombre='".$AREA[$id_area]."' WHERE id_area =". $id_area;
		$res_update_area=pg_exec($conn, $sql_update_area);
		
		
		//traigo las subareas del area actual
		 $sql_1 = "select id_subarea from informe_subarea where id_area=".$id_area." order by id_subarea";
			$res_1=pg_exec($conn, $sql_1);
			
			//recorro las subareas para actualizar
			for($s = 0 ; $s<pg_numrows($res_1) ; $s++){
				$fila_subarea = pg_fetch_array($res_1, $s);
				$id_subarea = $fila_subarea['id_subarea'];			
				$sql_update_subareas = "update informe_subarea set nombre='".$SUBAREA[$id_subarea]."' where id_subarea =".$id_subarea;
				$res_update_subareas=pg_exec($conn, $sql_update_subareas);
				

			//traigo los items para la subarea actual
							$sql_2 = "select * from informe_item where id_subarea=".$id_subarea." order by id_item";
							$res_2=pg_exec($conn, $sql_2);

										//recorro las subareas para actualizar
							for($i = 0 ; $i<pg_numrows($res_2) ; $i++){
								$fila_item= pg_fetch_array($res_2, $i);
								$id_item = $fila_item['id_item'];			
								$sql_update_item = "update informe_item set glosa='".$ITEM[$id_item]."' where id_item =".$id_item;
								$res_update_item=pg_exec($conn, $sql_update_item);

							}
			
			
			}


}

?>
