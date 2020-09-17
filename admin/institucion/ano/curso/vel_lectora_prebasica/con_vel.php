<?php 
header( 'Content-type: text/html; charset=iso-8859-1' );

session_start();

require "mod_vel.php";

$obj_VelocidadLec = new VelocidadLec($conn);
$funcion = $_POST['funcion'];


if($funcion==1){
//show($_POST);
$rs_ano = $obj_VelocidadLec->selAno($rdb);

?>

<select name="" id="cmb_ano" onChange="cCur()">
<option value="0">Seleccione...</option>
<?php for($i=0;$i<pg_numrows($rs_ano);$i++){
	$fila=pg_fetch_array($rs_ano,$i);
?>
<option value="<?php echo $fila['id_ano'] ?>"><?php echo $fila['nro_ano'] ?></option>
<?php }?>
</select>
<?
}
if($funcion==2){
//show($_POST);
$rs_curso = $obj_VelocidadLec->selCurso($ano);
$rs_anoUno = $obj_VelocidadLec->selAnoUno($ano);

?>

<select name="" id="cmb_curso" >
<option value="0">Seleccione...</option>
<?php for($i=0;$i<pg_numrows($rs_curso);$i++){
	$fila=pg_fetch_array($rs_curso,$i);
?>
<option value="<?php echo $fila['id_curso'] ?>"><?php echo CursoPalabra($fila['id_curso'],1,$conn); ?></option>
<?php }?>
</select>
<script>
$( document ).ready(function() {
	
$( "#txtFECHA" ).removeClass("hasDatepicker");
$( ".ui-datepicker-trigger" ).remove();
$( "#txtFECHA" ).val("");

 $( "#txtFECHA" ).datepicker({
    'dateFormat':'dd/mm/yy',
	firstDay: 1,
	showOn: "button",
	minDate: new Date('<?php echo pg_result($rs_anoUno,1) ?>/01/01'),
	maxDate: new Date('<?php echo pg_result($rs_anoUno,1) ?>/12/31'),

	dayNames: [ "Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado" ],
    // Dias cortos en castellano
    dayNamesMin: [ "Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa" ],
    // Nombres largos de los meses en castellano
    monthNames: [ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre" ],
    // Nombres de los meses en formato corto 
    monthNamesShort: [ "Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dec" ]
	
});  
	
	
	
});
</script>
<?
}
if($funcion==3){
	$rs_alumnos = $obj_VelocidadLec->selAlumnos($curso);
	$rs_area = $obj_VelocidadLec->traeItem($rdb,0);
	?>
    <form id="frmeca">
    <input type="hidden" name="ss">
	<table border="1"  style="border-collapse:collapse">
  <tr class="tableindex">
    <td colspan="2">&nbsp;</td>
   <?php  for($a=0;$a<pg_numrows($rs_area);$a++){
	   $fila_area= pg_fetch_array($rs_area,$a);
	   $rs_item = $obj_VelocidadLec->traeItem($rdb,$fila_area['id_item']);
	   ?>
    <td colspan="<?php echo pg_numrows($rs_item) ?>"><?php echo $fila_area['glosa'] ?></td>
    <?php }?>
    </tr>
  <tr class="tableindex">
    <td>#</td>
    <td>Alumno</td>
    <?php 
	 for($a=0;$a<pg_numrows($rs_area);$a++){
	   $fila_area= pg_fetch_array($rs_area,$a);
	   $rs_item = $obj_VelocidadLec->traeItem($rdb,$fila_area['id_item']);
	for($b=0;$b<pg_numrows($rs_item);$b++){
		$fila_item=pg_fetch_array($rs_item,$b)
		?>
    <td><?php echo $fila_item['glosa'] ?></td>
    <?php }
	
	 }?>
   
  </tr>
<?php  for($i=0;$i<pg_numrows($rs_alumnos);$i++){
	$fila_alumno=pg_fetch_array($rs_alumnos,$i);
	?>
  <tr class="textosimple" bgcolor="#ffffff" onmouseover="this.style.background='yellow';this.style.cursor='pointer'" onmouseout="this.style.background='#ffffff'" style="background: rgb(255, 255, 255); cursor: pointer;">
  <td ><?php echo ($i+1) ?></td>
    <td><?php echo $fila_alumno['ape_pat']." ".$fila_alumno['ape_mat']." ".$fila_alumno['nombre_alu'] ?><input type="hidden" name="ralu[]" value="<?php echo $fila_alumno['rut_alumno']?>"></td>
    
     
   <?php 
	 for($a=0;$a<pg_numrows($rs_area);$a++){
	   $fila_area= pg_fetch_array($rs_area,$a);
	   $rs_item = $obj_VelocidadLec->traeItem($rdb,$fila_area['id_item']);
	for($b=0;$b<pg_numrows($rs_item);$b++){
		$fila_item=pg_fetch_array($rs_item,$b);
		?>
    <td><select name="eva[]">
    <option value="<?php echo $fila_alumno['rut_alumno']?>_<?php echo $fila_area['id_item'] ?>_<?php echo $fila_item['id_item'] ?>_0">Seleccione</option>
    <?php $rs_conc = $obj_VelocidadLec->listaConCal($rdb);
	for($c=0;$c<pg_numrows($rs_conc);$c++){
		$fila_conc = pg_fetch_array($rs_conc,$c);
		
		//buscar si esta seleccionado
		$rs_tengoEva = $obj_VelocidadLec->tengoEva($ano,$curso,$fila_alumno['rut_alumno'],CambioFE($fecha),$fila_area['id_item'],$fila_item['id_item']);
		@$fila_eva = pg_fetch_array($rs_tengoEva,0);
		
		$respuesta=$fila_alumno['rut_alumno']."_".$fila_area['id_item']."_".$fila_item['id_item']."_".$fila_eva['respuesta'];
		
		$valor=$fila_alumno['rut_alumno']."_".$fila_area['id_item']."_".$fila_item['id_item']."_".$fila_conc['id_concepto'];
	?>
    <option value="<?php echo $valor ?>" <?php echo ($valor==$respuesta)?"selected":"" ?>><?php echo $fila_conc['nombre'] ?></option>
    <?php }?>
    </select></td>
    <?php }
	
	 }?>
    
   
  </tr>
  <?php }?>
</table><br>
</form>
<br>
<input name="" type="button" value="Guardar Evaluaciones" onClick="guardaeva()" class="botonXX">
<?
}if($funcion==4){
//show($_POST);

$fecha=CambioFE($fecha);

$cuenta=count($ralu);



for($a=0;$a<count($eva);$a++){
$cad=explode("_",$eva[$a]);
$rut=$cad[0];
$area=$cad[1];
$item=$cad[2];
$respuesta	=$cad[3];
$rs_guarda="";
//revisar si tengo evaluaciones
if($respuesta!="0"){
	$rs_tengoEva = $obj_VelocidadLec->tengoEva($ano,$curso,$rut,$fecha,$area,$item);
	
	if(pg_numrows($rs_tengoEva)==0){
	//gardar	
	$rs_guarda = $obj_VelocidadLec->guardarNEva($ano,$curso,$rut,$fecha,$area,$item,$respuesta);
	}else{
	//actualizar
	$rs_guarda = $obj_VelocidadLec->guardarUEva($ano,$curso,$rut,$fecha,$area,$item,$respuesta);	
	}
}
	
}


}
?>