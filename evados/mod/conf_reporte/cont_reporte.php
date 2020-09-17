<?
session_start();
require('mod_reporte.php');

$obj_Reporte = new Reporte($_IPDB,$_ID_BASE);

$funcion 	= $_POST['frmModo'];
$ano 		= $_ANO;
$rdb		= $_INSTIT;
$perfil		= $_POST['cmbPERFIL'];


if($funcion=="mostrar"){ // Muestra listado de Reportes
	$result = $obj_Reporte->listadoReporte();


	$tabla = '<table id="flex1" style="display:none">
				<thead>
				<tr align="center">
					<th width="30" class="textosimple">ID</th>
					<th width="250" align="left" class="textosimple">NOMBRE</th>
					<th width="50" class="textosimple">ASIGNAR</th>
					<th width="50" class="textosimple">ELIMINAR</th>
				</thead>
				<tbody>';
				
			for($i=0;$i<@pg_numrows($result);$i++){
				$cont = $i + 1;
				$fila = @pg_fetch_array($result,$i);
				$rs_existe =$obj_Reporte->existeReporte($fila['id_item_reporte'],$perfil,$rdb);
				if(@pg_numrows($rs_existe)==1){
					$check = '&nbsp;';
					$elimina = "<a href='#' onclick='EliminaReporte(".$fila['id_item_reporte'].",".$perfil.",".$rdb.",".$fila['id_reporte'].")' ><img src='img/PNG-48/Delete.png' width='18' height='18' border='0' /></a>";
				}else{
					$check = "<a href='#' onclick='InsertaReporte(".$fila['id_item_reporte'].",".$perfil.",".$rdb.",".$fila['id_reporte'].")' ><img src='img/PNG-48/Add.png' width='18' height='18' border='0' /></a>";
					$elimina = "&nbsp;";
				}
	$tabla.='<tr>
				
				<td class="textosimple" align="right">'.$cont.'&nbsp;&nbsp;</td>
				<td class="textosimple">&nbsp;'.$fila['nombre'].'</td>
				<td>'.$check.'</td>
				<td class="textosimple">'.$elimina.'</td>
				</tr>';
			}
	$tabla.='</tbody></table>';
	echo $tabla;
	
	
	
 }
  
 
if($funcion=="insertar"){ // Inserta Reporte Perfil 
	$result = $obj_Reporte->InsertaReporte($reporte,$id_perfil,$rdb,$id_reporte);
		if($result == true){
		    echo 1;	
		}else{
			 echo 0;
		}
}

if($funcion=="eliminar"){ // Elimina Reporte Perfil
	$result = $obj_Reporte->EliminaReporte($reporte,$id_perfil,$rdb);
	if($result == true){
		echo 1;	
	}else{
		 echo $result;
	}
}
 
  
?>
	
