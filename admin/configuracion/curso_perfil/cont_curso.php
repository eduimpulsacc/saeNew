<?
require('../../../util/header.inc');
require('mod_curso.php');

$ob_reporte = new Curso();

$funcion = $_POST['funcion'];

if($funcion==1){
	$rs_curso = $ob_reporte->Grados($conn,$ano,$ensenanza);
?>
	<select name="cmbGRADO" id="cmbGRADO" onchange="Listado()">
    	<option	value="0">seleccione...</option>
<? 	for($i=0;$i<pg_numrows($rs_curso);$i++){
		$fila = pg_fetch_array($rs_curso,$i);
?>
		<option value="<?=$fila['grado_curso'];?>"><?=$fila['grado_curso']." ".$fila['nombre_tipo'];?></option>
<? } ?>
	</select>
<?        	
		
}

if($funcion==2){
	$rs_listado = $ob_reporte->Listado($conn,$ano,$ensenanza,$grado);
	
?>
<table width="80%" border="1" align="center" style="border-collapse:collapse">
  <tr class="tableindex">
    <td align="center">ESTADO</td>
    <td align="center">GRADOS</td>
  </tr>
  <? for($i=0;$i<pg_num_rows($rs_listado);$i++){
	  	$fila = pg_fetch_array($rs_listado,$i);
		
		if(($i % 2)==0){
			$class="detalleoff";	
		}else{
			$class="detalleon";
		}
		$rs_existe = $ob_reporte->Existe($conn,$_INSTIT,$perfil,$fila['id_curso'],$ensenanza,$rut);
		if(pg_num_rows($rs_existe)==0){
			$imagen ="<img src='../../clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/PNG-24/Add.png' width='24' height='24' onclick='agregar($fila[id_curso],$fila[grado_curso])' border=0 />	";
		}else{
			$imagen = "<img src='../../clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/PNG-24/Delete.png' width='24' height='24' onclick='Borrar($fila[id_curso])' border=0 />";
		}
  ?>
  <tr class="<?=$class;?>">
    <td align="center"><a href="#"><?=$imagen;?></a></td>
    <td class="<?=$class;?>">&nbsp;<?=$fila['grado_curso']." ".$fila['letra_curso']." ".$fila['nombre_tipo'];?></td>
  </tr>
  <? } ?>
</table>


<?
}

if($funcion==3){
	$rs_insert = $ob_reporte->Agregar($conn,$ensenanza,$id_curso,$grado,$_INSTIT,$perfil,$rut);
	
	if($rs_insert){
		echo 1;
	}else{
		echo 0;
	}
		
}

if($funcion==4){
	$rs_delete =$ob_reporte->Eliminar($conn,$ensenanza,$id_curso,$_INSTIT,$perfil);
	
	if($rs_delete){
		echo 1;
	}else{
		echo 0;
	}
}	

if($funcion==5){
	$rs_personal = $ob_reporte->Personal($connection,$conn,$perfil,$_INSTIT);
?>
<select name="cmbPERSONAL"	 id="cmbPERSONAL" onchange="Listado()">
	<option value="0">seleccione...</option>
<? for($i=0;$i<pg_num_rows($rs_personal);$i++){
		$fila = pg_fetch_array($rs_personal,$i);
?>
	<option value="<?=$fila['rut_emp'];?>"><?=$fila['nombre_emp']." ".$fila['ape_pat']." ".$fila['ape_mat'];?></option>
<? } ?>
	
</select>
<?
}
?>