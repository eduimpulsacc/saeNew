<?
 require("../../util/header.php");
 require("mod_reporte.php");
 
 $funcion=$_POST['funcion'];
 
 $ob_reporte = new Reporte();
 
 if($funcion==1){
	 $rs_reporte = $ob_reporte->ListadoReportes($conn,$perfil,$rdb);
?>
<table width="90%" border="1" align="center" class="tablaredonda" >
	<tr class="tablaredonda">
		<td width="12%" class="tablaredonda cuadro01">&nbsp; ESTADO</td>
		<td width="88%" class="tablaredonda cuadro01">&nbsp;REPORTE</td>
	</tr>
    <? for($i=0;$i<pg_numrows($rs_reporte);$i++){
			$fila =pg_fetch_array($rs_reporte,$i);
			if(($i % 2)==0){
				$estilo="detalleoff";	
			}else{
				$estilo="detalleon";
			}
			
			if($fila['id_reporte']==""){
				$imagen="<img title='AGREGAR' src='../../admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/PNG-24/Add.png' onClick='Agregar(".$fila['nro_reporte'].")' border=0>";
			}else{
				$imagen="<img title='ELIMINAR' src='../../admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/PNG-24/Delete.png' onClick='Eliminar(".$fila['nro_reporte'].")' border=0>";
			}
	?>
	<tr class="tablaredonda">
		<td class="tablaredonda" align="center">&nbsp;<a href="#"><?=$imagen;?></a></td>
		<td class="tablaredonda textosimple">&nbsp;<?=$fila['nombre'];?></td>
	</tr>
	
    <? } ?>
  
</table>
 <img src="../Reportes/img/sombra.png" width="885" height="32">                      
<br>

<?	 
	 
 }
 
 if($funcion==2){
	$rs_insert = $ob_reporte->AgregarReporte($conn,$perfil,$rdb,$reporte);
	
	if($rs_insert){
		echo 1;
	}else{
		echo 0;	
	}
 }

 if($funcion==3){
	$rs_delete = $ob_reporte->EliminaReporte($conn,$perfil,$rdb,$reporte);
	
	if($rs_delete){
		echo 1;
	}else{
		echo 0;	
	}
 }

?>

