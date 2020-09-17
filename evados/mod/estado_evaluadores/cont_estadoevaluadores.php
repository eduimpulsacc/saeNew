<?
session_start();
require('mod_estadoevaluadores.php');

$obj_estado_evaluadores = new estado_evaluadores($_IPDB,$_ID_BASE);

$ano 		= $_ANO;
$rdb		= $_INSTIT;
$perfil		= $_POST['cmbPERFIL'];

if($_POST['funcion']==1){

	$result = $obj_estado_evaluadores->listadoReporte($ano);

	$tabla = '<table id="flex1" style="display:none">
				<thead>
				<tr align="center">
					<th width="30" class="textosimple">ID</th>
					<th width="200" align="left" class="textosimple">Nombre Cargo</th>
					<th width="100" class="textosimple">Ejecutar</th>
				</thead>
				<tbody>';
				
	for($i=0;$i<@pg_numrows($result);$i++){
				
	$fila = @pg_fetch_array($result,$i);
 				
	$estado_cargo_acceso_perfil_evaluador =  $obj_estado_evaluadores->estadoperfilevaluadores($fila['id_cargo'],$ano,$rdb);
				
	if($estado_cargo_acceso_perfil_evaluador==0){	// servicio inactivo solicito activar
															
					$check = "<a href='#' onclick='activarevaluadores(".$fila['id_cargo'].",1)' >
					<img src='img/PNG-48/Add.png' width='18' height='18' border='0' />Activar</a>";
					
                }else{		// servicio activo solicito desactivar 
						
					$check = "<a href='#' onclick='activarevaluadores(".$fila['id_cargo'].",0)' >
					<img src='img/PNG-48/Delete.png' width='18' height='18' border='0' />Desactivar</a>";
					
				}
				 
	$tabla.='<tr><td class="textosimple">&nbsp;'.($i+1).'</td>
					<td class="textosimple">&nbsp;'.$fila['nombre_cargo'].'</td>
					<td>'.$check.'</td></tr>';

			}

	$tabla.='</tbody></table>';

	echo $tabla;      
	
   }

  
if($_POST['funcion']==2){ 

	$result = $obj_estado_evaluadores->activarevaluadores($_POST['id_cargo'],$ano,$_POST['modo'],$rdb,$_ID_BASE);
	if($result == true){
		echo 1;	
	 }else{
		echo 0;
	}

 }


if($funcion=="eliminar"){ // Elimina Reporte Perfil
	$result = $obj_estado_evaluadores->EliminaReporte($reporte,$id_perfil,$rdb);
	if($result == true){
		echo 1;	
	}else{
		 echo $result;
	}
}
 
  
?>
	
