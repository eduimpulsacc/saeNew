<? 
require("../../../util/header.php");
require("mod_motor.php");

$funcion = $_POST['funcion'];

$ob_motor = new Motor();

if($funcion==1){
	$rs_curso = $ob_motor->Curso($conn,$ano,$_PERFIL,$rut);
?>
<select name="cmbCURSO" id="cmbCURSO" onChange="cambia_ramo();" class="select_redondo">
	<option value="0">seleccione...</option>
<? for($i=0;$i<pg_numrows($rs_curso);$i++){
		$fila = pg_fetch_array($rs_curso,$i);
?>	 
	<option value="<?=$fila['id_curso'];?>"><?=CursoPalabra($fila['id_curso'], 1, $conn);?></option>
<?   
 }
 ?>
 </select>

<?		
}

if($funcion==2){
	$rs_ramo = $ob_motor->Ramo($conn,$ano,$curso,$_PERFIL,$rut);
?>
<select name="cmbRAMO" id="cmbRAMO" onChange="cambia_unidad();" class="select_redondo"	>
	<option value="0">seleccione...</option>
<? for($i=0;$i<pg_numrows($rs_ramo);$i++){
		$fila = pg_fetch_array($rs_ramo,$i);
?>
	<option value="<?=$fila['id_ramo'];?>"><?=$fila['nombre'];?></option>
<? } ?>
</select>
<?
}

if($funcion==3){
	$rs_unidad = $ob_motor->Unidad($conn,$ano,$curso,$ramo);
?>
<select name="cmbUNIDAD" id="cmbUNIDAD" class="select_redondo">
	<option value="0">seleccione...</option>
<? for($i=0;$i<pg_numrows($rs_unidad);$i++){
		$fila=pg_fetch_array($rs_unidad,$i);
?>
	<option value="<?=$fila['id_unidad'];?>"><?=$fila['nombre'];?></option>
<? } ?>
</select>
	
<?	
}
?>
