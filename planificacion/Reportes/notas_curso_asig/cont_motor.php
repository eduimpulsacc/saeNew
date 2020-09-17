<? 
require("../../../util/header.php");
require("mod_motor.php");

$funcion = $_POST['funcion'];

$ob_motor = new Motor();

if($funcion==1){
	$rs_curso = $ob_motor->Curso($conn,$ano,$_PERFIL,$_NOMBREUSUARIO);
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
	$rs_ramo = $ob_motor->Ramo($conn,$ano,$curso,$_PERFIL,$_NOMBREUSUARIO);
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
<select name="cmbUNIDAD" id="cmbUNIDAD" onchange="cambia_clase();" class="select_redondo">
	<option value="0">seleccione...</option>
<? for($i=0;$i<pg_numrows($rs_unidad);$i++){
		$fila=pg_fetch_array($rs_unidad,$i);
?>
	<option value="<?=$fila['id_unidad'];?>"><?=$fila['nombre'];?></option>
<? } ?>
</select>
	
<?	
}

if($funcion==4){
	$rs_clase = $ob_motor->Clase($conn,$ano,$curso,$unidad,$ramo);
?>
<select name="cmbCLASE" id="cmbCLASE"  class="select_redondo">
	<option value="0">TODAS.</option>
<? for($i=0;$i<pg_numrows($rs_clase);$i++){
		$fila=pg_fetch_array($rs_clase,$i);
?>
	<option value="<?=$fila['id_clase'];?>"><?=$fila['nombre'];?></option>
<? } ?>
</select>
	
<?	
}if($funcion==5){
	$rs_periodo = $ob_motor->Periodo($conn,$ano);
?>
<select name="cmbPERIODO" id="cmbPERIODO" class="select_redondo" >
	<option value="0">Seleccione.</option>
<? for($i=0;$i<pg_numrows($rs_periodo);$i++){
		$fila=pg_fetch_array($rs_periodo,$i);
?>
	<option value="<?=$fila['id_periodo'];?>"><?=$fila['nombre_periodo'];?></option>
<? } ?>
</select>
	
<?	}
?>
