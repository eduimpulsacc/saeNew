<?php 
require('../../../../../util/header.inc'); 
require('../../../../../util/LlenarCombo.php3');
require('../../../../../util/SeleccionaCombo.inc');
include('../../../../clases/class_MotorBusqueda.php');

$ob_motor = new MotorBusqueda();

$ob_motor ->ano =$_POST['anio'];
$ob_motor ->cmb_curso =$_POST['curso'];
$result_curso = $ob_motor ->alumno($conn);


?>
<select name="cmb_alumno" class="ddlb_9_x" id="cmb_alumno">
<?php  for($i=0 ; $i < @pg_numrows($result_curso) ;++$i){
	$fila = @pg_fetch_array($result_curso,$i);
	?>
<option value="<? echo $fila["rut_alumno"]; ?>"><? echo ucwords(strtolower($fila["ape_pat"].$fila["ape_mat"].$fila["nombre_alu"]));?></option>
<?php }?>
</select>