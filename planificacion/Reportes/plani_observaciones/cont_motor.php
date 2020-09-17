<? 
require("../../../util/header.php");
require("mod_motor.php");

$funcion = $_POST['funcion'];

$ob_motor = new Motor();

if($funcion==1){
	$rs_curso = $ob_motor->Curso($conn,$ano);
?>
<select name="cmbCURSO" id="cmbCURSO" onChange="cambia_docente();" class="select_redondo">
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
	$rs_docente = $ob_motor->Docente($conn,$ano,$curso,$_PERFIL,$_NOMBREUSUARIO);
?>
<select name="cmbDOCENTE" id="cmbDOCENTE"	 class="select_redondo">
	<option value="0">seleccione...</option>
<? for($i=0;$i<pg_numrows($rs_docente);$i++){
		$fila = pg_fetch_array($rs_docente,$i);
?>
	<option value="<?=$fila['rut_emp'];?>"><?=$fila['nombres'];?></option>
<? } ?>
</select>
<?
}


?>
