<?php

session_start();
require_once('mod_reporte_subvencion.php');


$obj_ReporteSubvencion = new Motor($conn);
 $funcion = $_POST['funcion'];


if($funcion==1)
{
	
	$result = $obj_ReporteSubvencion->busca_institucion($id_nacional);
		  //if($result){
		$select = "<select name='select_instit' id='select_instit'>
		<option value='0' select='select' >(Selecccionar)</option>";
				
		for($i=0;$i<pg_numrows($result);$i++){
			$fila=pg_fetch_array($result,$i);
			$select .= "<option value='".$fila['rdb']."'>".utf8_encode(trim($fila['nombre_instit']))."</option>";
		 }  // for 2 
		 $select .= "</select>"; 
		 echo $select;
		 //}else{
		 //echo 0;			
		// }	
		
		
	
}

	if($funcion == 2){
			
			$id_nacional=$_POST['id_nacional'];
			$mes=$_POST['mes'];
			$nro_ano=$_POST['nro_ano'];
			$result=$obj_ReporteSubvencion->busca_nacional($id_nacional,$mes,$nro_ano);
			if(pg_numrows($result)>0){
				echo 1;
				}else{
				echo 0;	
				}
			
			}

	
	?>
    
    
    <?php







?>