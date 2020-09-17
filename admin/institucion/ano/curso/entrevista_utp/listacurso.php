<?php 
require('../../../../../util/header.inc'); 
include('../../../../clases/class_Reporte.php');
include('../../../../clases/class_MotorBusqueda.php');
$ob_reporte = new Reporte();
$ob_motor = new MotorBusqueda();

$institucion	=$_INSTIT;
$ano			=$_ANO;


foreach($_POST as $nombre_campo => $valor){ 
   $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; 
   eval($asignacion); 
 //  echo $asignacion."<br>";
}
$ob_reporte->ano = $ano;
$ob_reporte->curso = $curso;
$ob_motor ->ano = $ano;
$ob_motor ->cmb_curso = $curso;

 if($tipo==1){
	$result_lista = $ob_motor ->alumno($conn);
	
}
elseif($tipo==2){
	$result_lista =$ob_reporte->apo_entre($conn);
}
if(@pg_numrows($result_lista)>0){
	
?>
<select name="cmb_entrevistado" id="cmb_entrevistado">
<option value="0">Seleccione</option>
<?php for($i=0 ; $i < @pg_numrows($result_lista) ;++$i){
	$fila = @pg_fetch_array($result_lista,$i);
	
	if($tipo==1){
	$rut_entrevistado = $fila["rut_alumno"];
	$nombre_entrevistado = ucwords(strtolower($fila["ape_pat"].$fila["ape_mat"].", ".$fila["nombre_alu"]));
	}
	elseif($tipo==2){
	$rut_entrevistado = $fila["rut_apo"];
	$nombre_entrevistado = ucwords($fila["nombre_apo"]);
	}
	
	?>
    
    
    <option value="<?php echo $rut_entrevistado ?>"><?php echo $nombre_entrevistado ?></option>
    <?php }?>
</select>
<?php }?>