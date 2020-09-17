<?php 
require('../../../../../../util/header.inc');


foreach($_POST as $nombre_campo => $valor){ 
   $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; 
   eval($asignacion); 
}

if($funcion==1){
$query ="select nro_ano from ano_escolar where id_ano=$ano";
$rs=pg_exec($conn,$query);
$nano = pg_result($rs,0);
$fecha = "$d/$mes/$nano";
?>

<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<table width="100%" border="0" cellpadding="0">
  <tr>
    <td class="cuadro02">Rut Alumno</td>
    <td class="cuadro01"><input name="rut_alumno" id="irut_alumno" type="text" onchange="guardInas()" /></td>
  </tr>
</table>
<div id="dalu">
</div>
<input name="fecha" id="ifecha" type="hidden" value="<?php echo $fecha ?>">
<input name="curso" id="icurso" type="hidden" value="<?=$_POST['curso']?>">
<input name="ano" id="iano" type="hidden" value="<?=$_POST['ano']?>">

<?php }
if($funcion==2){
//voy a sumar los errores que encuentre, para que si es 0, muestre la tabla con los datos
$err=0;

$fecha_asis  = CambioFE($fecha);
//ver si existe en la base de datos
$queryal="select upper(nombre_alu||' '||ape_pat||' '||ape_mat) as nombre from alumno where rut_alumno = $rut";	
$rsal = pg_exec($conn,$queryal);
//no existe en la base de datos
if(pg_numrows($rsal)==0){
	$err++;
	?>
    <script>
	alert("Alumno no registrado");
	</script>
    <?

}
else{
	$nalu = pg_result($rsal,0);
//veo si está matriculado, o que al menos esté activo 
$querymat = "select rut_alumno,fecha,fecha_retiro,bool_ar from matricula where rut_alumno =$rut and id_ano= $ano and id_curso=$curso and bool_ar =0";
$rsmat = pg_exec($conn,$querymat);

//no matriculado en ese curso o está retirado
if(pg_numrows($rsmat)==0){
	$err++;
	?>
    <script>
	alert("Alumno no matriculado en el curso");
	</script>
    <?
}
//si el alumno está matriculado, pero hay que validar las fechas para que no ingresen fuera de rango
else{
	$filamat = pg_fetch_array($rsmat,0);
	$fmat = $filamat['fecha'];
	$fret = $filamat['fecha_retiro'];
	$bool_ar = $filamat ['bool_ar'];
	
	//matriculado pero fecha es menor a fecha de matricula
	if($bool_ar==0 && $fecha_asis<$fmat){
	$err++;
	?>
		<script>
        alert("Alumno con fecha de matr\xEDcula fuera de rango");
        </script>
    <?
	}
	//si está activo pero tiene fecha de retiro
	if($bool_ar==0 && strlen($fret)>0){
	$err++;
	?>
		<script>
        alert("Revisar datos de alumno. Alumno activo en curso, pero tiene fecha de retiro");
        </script>
    <?
	}
	
}


}

//echo $err;
if($err==0){
//después del montón de validaciones a hacer el insert
$query = "select * from asistencia where rut_alumno =$rut and ano= $ano and id_curso=$curso and fecha='".CambioFE($fecha)."'";
	$rs = pg_exec($conn,$query);
	if(pg_numrows($rs)>0){
		?>
		<script>
		alert("Alumno <?php echo $nalu ?> ya tiene registrada asistencia");
		</script>
		<?
	}

else{
 $query ="insert into asistencia (rut_alumno,ano,id_curso,fecha) values ($rut,$ano,$curso,'".CambioFE($fecha)."')";
$rs = pg_exec($conn,$query);
	
}
?>

<table width="100%" border="0" cellpadding="1" cellspacing="1">
  <tr>
    <td class="cuadro02" width="25%">Nombre Alumno</td>
    <td width="75%" class="cuadro01"><?php echo $nalu ?></td>
  </tr>
  <tr>
    <td class="cuadro02">Curso</td>
    <td class="cuadro01"><?php echo CursoPalabra($curso,1,$conn); ?></td>
  </tr>
</table>

<?
}

}
if($funcion==3){

$query ="select nro_ano,fecha_inicio,fecha_termino from ano_escolar where id_ano=$ano";
$rs=pg_exec($conn,$query);
$nano = pg_result($rs,0);
$fecha_inicio =pg_result($rs,1);
$fi = explode("-",$fecha_inicio); 
$fecha_termino =pg_result($rs,2);
$ft = explode("-",$fecha_termino); 

?>
<script type="text/javascript" src="../../../../../clases/jqueryui/jquery.ui.datepicker-es.js"></script>
<style type="text/css">
	div.ui-datepicker{
	font-size:12px;
	}
	
	
</style>
<script>
$( document ).ready(function() {
   $("#ifecha").datepicker({
	firstDay: 1,
	changeMonth: true,
	minDate: new Date('<?php echo $fi[0] ?>/<?php echo $fi[1] ?>/<?php echo $fi[2] ?>'),
	maxDate: new Date('<?php echo $ft[0] ?>/<?php echo $ft[1] ?>/<?php echo $ft[2] ?>'),
	defaultDate: new Date(<?php echo date("d") ?>,<?php echo date("m")-1 ?>, <?php echo $fi[0] ?>),
	dateFormat: 'dd/mm/yy',
	monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic']
	});
	
});
</script>
<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<table width="100%" border="0" cellpadding="0">
  <tr>
    <td class="cuadro02">Fecha</td>
    <td class="cuadro01"><input name="ifecha" id="ifecha" type="text" value="<?php echo date("d") ?>/<?php echo date("m") ?>/<?php echo $fi[0] ?>" /></td>
  </tr>
  <tr>
    <td class="cuadro02">Rut Alumno</td>
    <td class="cuadro01"><input name="rut_alumno" id="irut_alumno" type="text" onchange="guardInasAll()" /></td>
  </tr>
</table>
<div id="dalu">
</div>

<input name="ano" id="iano" type="hidden" value="<?=$_POST['ano']?>">

<?php 
}
if($funcion==4){
$err=0;
$fecha_asis  = CambioFE($fecha);
	 $querymat = "select rut_alumno,fecha,fecha_retiro,bool_ar,id_curso from matricula where rut_alumno =$rut and id_ano= $ano  and bool_ar =0";
$rsmat = pg_exec($conn,$querymat);
//si no esta matriculado
	if(pg_numrows($rsmat)==0){
		$err++;
	}
	else{
	$queryal="select upper(nombre_alu||' '||ape_pat||' '||ape_mat) as nombre from alumno where rut_alumno = $rut";	
$rsal = pg_exec($conn,$queryal);
//no existe en la base de datos
if(pg_numrows($rsal)==0){
	$err++;
	?>
    <script>
	alert("Alumno no registrado");
	</script>
    <?

}
else{
	$nalu = pg_result($rsal,0);
	$filamat = pg_fetch_array($rsmat,0);
	$fmat = $filamat['fecha'];
	$fret = $filamat['fecha_retiro'];
	$bool_ar = $filamat ['bool_ar'];
	$id_curso = $filamat ['id_curso'];
	
	//matriculado pero fecha es menor a fecha de matricula
	if($bool_ar==0 && $fecha_asis<$fmat){
	$err++;
	?>
		<script>
        alert("Alumno con fecha de matr\xEDcula fuera de rango");
        </script>
    <?
	}
	//si está activo pero tiene fecha de retiro
	if($bool_ar==0 && strlen($fret)>0){
	$err++;
	?>
		<script>
        alert("Revisar datos de alumno. Alumno activo en curso, pero tiene fecha de retiro");
        </script>
    <?
	}
	

	}
	}
	//echo $err;
if($err==0){
//después del montón de validaciones a hacer el insert
$query = "select * from asistencia where rut_alumno =$rut and ano=$ano and id_curso=$id_curso and fecha='".CambioFE($fecha)."'";
	$rs = pg_exec($conn,$query);
	if(pg_numrows($rs)>0){
		?>
		<script>
		alert("Alumno <?php echo $nalu ?> ya tiene registrada asistencia");
		</script>
		<?
	}

else{
 $query ="insert into asistencia (rut_alumno,ano,id_curso,fecha) values ($rut,$ano,$id_curso,'".CambioFE($fecha)."')";
$rs = pg_exec($conn,$query);
	
}
?>

<table width="100%" border="0" cellpadding="1" cellspacing="1">
  <tr>
    <td class="cuadro02" width="25%">Nombre Alumno</td>
    <td width="75%" class="cuadro01"><?php echo $nalu ?></td>
  </tr>
  <tr>
    <td class="cuadro02">Curso</td>
    <td class="cuadro01"><?php echo CursoPalabra($id_curso,1,$conn); ?></td>
  </tr>
</table>

<?
}
}
?>