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
<input name="jornada" id="ijornada" type="hidden" value="<?=$_POST['jornada']?>">
<?php }
if($funcion==2){
//voy a sumar los errores que encuentre, para que si es 0, muestre la tabla con los datos
$fecha = CambioFE($fecha);
$fecha_asis =$fecha;
$err=0;


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
//buscar periodo
 $qry_periodo = "select id_periodo from periodo where id_ano = $ano and fecha_inicio <= '$fecha' and fecha_termino >= '$fecha'";
					$res_periodo = pg_Exec($conn, $qry_periodo)or die("F1".$qry_periodo);
					$fila_periodo = pg_fetch_array($res_periodo,0);
				    if(pg_numrows($res_periodo)==0){
					
					 $err++;
					?>
						<script>
						alert("Fecha fuera de rangos de periodo");
						</script>
					<?
					}else{
					$periodo = $fila_periodo['id_periodo'];
					}

//echo $err;
if($err==0){
	$nalu = pg_result($rsal,0);
	
 $query = "select * from anotacion where tipo=2 and rut_alumno = $rut and fecha = '".$fecha."' and rdb=$_INSTIT";
$rs = pg_exec($conn,$query);
if(pg_numrows($rs)>0){
	?>
    <script>
	alert("Alumno <?php echo trim($nalu) ?> ya tiene registrado atraso");
	</script>
    <?
}
else{

//buscar usuairio
  $qry_user = "select nombre_usuario from usuario where ID_USUARIO = '$_USUARIO'";
	$res_user = pg_Exec($connection,$qry_user);
	$fila_user = pg_fetch_array($res_user);
	//$usuario = trim($fila_user['nombre_usuario']);
	$usuario = $_NOMBREUSUARIO;

					
					
					
//hacer el insert
  $qry_max = "select max(id_anotacion) from anotacion";
					$res_max = pg_Exec($conn,$qry_max);
					$fila_max = pg_fetch_array($res_max);
					$id_max = $fila_max['max']+1;

if($usuario=='admin'){
					
					   $qry_add = "insert into anotacion(id_anotacion,tipo,fecha,observacion,rut_alumno,id_periodo,jornada,rdb) values ('$id_max',2,'$fecha','Atrasado','$rut','$periodo','$jornada',$_INSTIT)";
					}else{
					  $qry_add = "insert into anotacion(id_anotacion,tipo,fecha,observacion,rut_alumno,rut_emp,id_periodo,jornada,rdb) values ('$id_max',2,'$fecha','Atrasado','$rut','$_NOMBREUSUARIO','$periodo','$jornada',$_INSTIT)";	
					}
					
						//if($_PERFIL==0){echo $qry_add;}
						$res_add = pg_Exec($conn,$qry_add)or die("f".$qry_add);
					

	

	
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
}//fin al chorro de validaciones
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
<input name="ano" id="iano" type="hidden" value="<?=$_POST['ano']?>">
<input name="jornada" id="ijornada" type="hidden" value="<?=$_POST['jornada']?>" >
<table width="100%" border="0" cellpadding="0">
  <tr>
    <td class="cuadro02">Fecha</td>
    <td class="cuadro01"><input name="ifecha" id="ifecha" type="text" value="<?php echo date("d") ?>/<?php echo date("m") ?>/<?php echo $fi[0] ?>" onchange="document.getElementById('irut_alumno').focus()" /></td>
  </tr>
  <tr>
    <td class="cuadro02">Rut Alumno</td>
    <td class="cuadro01"><input name="rut_alumno" id="irut_alumno" type="text" onchange="guardAtrasoAll()" /></td>
  </tr>
</table>
<div id="dalu">
</div>

<input name="ano" id="iano" type="hidden" value="<?=$_POST['ano']?>">
<input name="jornada" id="ijornada" type="hidden" value="<?=$_POST['jornada']?>">

<?php 

}
if($funcion==4){

//voy a sumar los errores que encuentre, para que si es 0, muestre la tabla con los datos
$fecha = CambioFE($fecha);
$fecha_asis =$fecha;
$err=0;


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
$querymat = "select rut_alumno,fecha,fecha_retiro,bool_ar,id_curso from matricula where rut_alumno =$rut and id_ano= $ano  and bool_ar =0";
$rsmat = pg_exec($conn,$querymat);

//no matriculado en ese curso o está retirado
if(pg_numrows($rsmat)==0){
	$err++;
	?>
    <script>
	alert("Alumno no matriculado en el establecimiento");
	</script>
    <?
}
//si el alumno está matriculado, pero hay que validar las fechas para que no ingresen fuera de rango
else{
	$filamat = pg_fetch_array($rsmat,0);
	 $fmat = $filamat['fecha'];
	$fret = $filamat['fecha_retiro'];
	$bool_ar = $filamat ['bool_ar'];
	$curso = $filamat ['id_curso'];
	
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
//buscar periodo
 $qry_periodo = "select id_periodo from periodo where id_ano = $ano and fecha_inicio <= '$fecha' and fecha_termino >= '$fecha'";
					$res_periodo = pg_Exec($conn, $qry_periodo)or die("F1".$qry_periodo);
					$fila_periodo = pg_fetch_array($res_periodo,0);
				    if(pg_numrows($res_periodo)==0){
					
					 $err++;
					?>
						<script>
						alert("Fecha fuera de rangos de periodo");
						</script>
					<?
					}else{
					$periodo = $fila_periodo['id_periodo'];
					}

//echo $err;
if($err==0){
	$nalu = pg_result($rsal,0);
	
 $query = "select * from anotacion where tipo=2 and rut_alumno = $rut and fecha = '".$fecha."' and rdb=$_INSTIT";
$rs = pg_exec($conn,$query);
if(pg_numrows($rs)>0){
	?>
    <script>
	alert("Alumno <?php echo trim($nalu) ?> ya tiene registrado atraso");
	</script>
    <?
}
else{

//buscar usuairio
  $qry_user = "select nombre_usuario from usuario where ID_USUARIO = '$_USUARIO'";
	$res_user = pg_Exec($connection,$qry_user);
	$fila_user = pg_fetch_array($res_user);
	//$usuario = trim($fila_user['nombre_usuario']);
	$usuario = $_NOMBREUSUARIO;

					
					
					
//hacer el insert
  $qry_max = "select max(id_anotacion) from anotacion";
					$res_max = pg_Exec($conn,$qry_max);
					$fila_max = pg_fetch_array($res_max);
					$id_max = $fila_max['max']+1;

if($usuario=='admin'){
					
					   $qry_add = "insert into anotacion(id_anotacion,tipo,fecha,observacion,rut_alumno,id_periodo,jornada,rdb) values ('$id_max',2,'$fecha','Atrasado','$rut','$periodo','$jornada',$_INSTIT)";
					}else{
					  $qry_add = "insert into anotacion(id_anotacion,tipo,fecha,observacion,rut_alumno,rut_emp,id_periodo,jornada,rdb) values ('$id_max',2,'$fecha','Atrasado','$rut','$_NOMBREUSUARIO','$periodo','$jornada',$_INSTIT)";	
					}
					
						//if($_PERFIL==0){echo $qry_add;}
						$res_add = pg_Exec($conn,$qry_add)or die("f".$qry_add);
					

	

	
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
}//fin al chorro de validaciones
	
}
?>