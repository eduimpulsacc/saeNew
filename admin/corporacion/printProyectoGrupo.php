<?php require('../../util/header.inc');
	

$corporacion   =$_CORPORACION;
$ano		   = $cmbANO_P;

echo $caso_p;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
</head>
<script>
	function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
	</script>
<body>
<div id="capa0">
<table width="850" border="0" align="center">
  <tr>
    <td><input name="CERRAR" type="button" onClick="window.close();" value="CERRAR" class="botonXX"/></td>
    <td><div align="right">
      <input name="IMPRIMIR" type="button" onClick="imprimir();" value="IMPRIMIR" class="botonXX"  align="right"/>
    </div></td>
  </tr>
</table>
</div>
<br />
<?  if($caso_p==2){
	/*$sql = "SELECT count(e.*) as total,a.nombre_instit,b.nombre,c.hrs_contrato,c.total_aula, d.nombre_emp || ";
	$sql.=" cast(' ' as varchar) || d.ape_pat || cast(' ' as  varchar) as nombre_emp,b.objetivo  FROM institucion a ";
	$sql.=" INNER JOIN proyecto_grupo b ON a.rdb=b.rdb INNER JOIN dotacion_docente c ON b.rut_emp=c.rut_emp  INNER JOIN ";
	$sql.=" empleado d ON (b.rut_emp=d.rut_emp AND c.rut_emp=d.rut_emp) LEFT JOIN inscribe_proyecto e ON  ";
	$sql.=" b.id_proy=e.id_proy WHERE b.rdb in (SELECT rdb FROM corp_instit WHERE num_corp=".$corporacion.") AND ";
	$sql.= " b.tipo=1 GROUP BY a.nombre_instit,b.nombre,c.hrs_contrato,c.total_aula, d.nombre_emp,d.ape_pat,b.objetivo ";*/
	$sql = "SELECT count(a.*) as total,b.nombre as diag,c.nombre_instit, e.nombre_emp || cast(' ' as varchar) || e.ape_pat || ";
	$sql.= "cast(' ' as varchar) as nombre_emp, f.hrs_contrato,f.total_aula,d.objetivo ";
	$sql.= "FROM alumno_proyecto a INNER JOIN diagnostico b ON  a.id_dignos=b.id_dignos ";
	$sql.= "INNER JOIN institucion c ON a.rdb=c.rdb INNER JOIN proyecto_grupo d ON a.id_proy=d.id_proy AND d.rdb=c.rdb ";
	$sql.= "INNER JOIN empleado e ON d.rut_emp=e.rut_emp INNER JOIN dotacion_docente f ON f.rut_emp=e.rut_emp AND f.rut_emp=d.rut_emp ";
	$sql.= "AND f.rdb=a.rdb AND f.rdb=c.rdb AND f.rdb=d.rdb  ";
	$sql.= "WHERE c.rdb in (SELECT rdb FROM corp_instit WHERE num_corp=".$corporacion.") AND d.tipo=1 ";
	$sql.= "group by b.nombre,c.nombre_instit,e.nombre_emp,e.ape_pat, f.hrs_contrato,f.total_aula ,d.objetivo ";	
	$rs_proyecto = @pg_exec($conn,$sql);
?>
<table width="850" border="1" cellpadding="3" cellspacing="0" align="center">
  <tr>
	<td colspan="9" class="tableindex">DATOS ESCUELAS CON PROYECTO DE INTEGRACI&Oacute;N </td>
  </tr>
  <tr class="tabla04">
	<td>N&ordm;</td>
	<td>ESTABLECIMIENTO</td>
	<td>PROFESOR</td>
	<td>PROYECTO<br>INTEGRACI&Oacute;N</td>
	<td><p>N&ordm; ALUMNOS<br>POR PROYECTO </p></td>
	<td>HORAS<br>CONTRATO</td>
	<td>HORAS <br>AULA</td>
	<td>RANGO<br>ATENCI&Oacute;N</td>
	<td>OBSERVACIONES</td>
  </tr>
  <? for($i=0;$i<@pg_numrows($rs_proyecto);$i++){
		$fila_pro =@pg_fetch_array($rs_proyecto,$i);
		$cont_pro++;
	?>
	
  <tr>
	<td class="datos"><?=$cont_pro;?></td>
	<td class="datos"><?=$fila_pro['nombre_instit'];?></td>
	<td class="datos"><?=$fila_pro['nombre_emp'];?></td>
	<td class="datos"><?=$fila_pro['diag'];?></td>
	<td class="datos"><?=$fila_pro['total'];?></td>
	<td class="datos"><?=$fila_pro['hrs_contrato'];?></td>
	<td class="datos"><?=$fila_pro['total_aula'];?></td>
	<td class="datos">&nbsp;</td>
	<td class="datos"><?=$fila_pro['objetivo'];?></td>
  </tr>
  <? 	$cont_alumno = $cont_alumno + $fila_pro['total'];
		$cont_contrato = $cont_contrato + $fila_pro['hrs_contrato'];
		$cont_aula = $cont_aula + $fila_pro['total_aula'];
  } ?>
  <tr class="tabla04">
	<td>&nbsp;</td>
	<td>TOTAL</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td><?=$cont_alumno;?>&nbsp;</td>
	<td><?=$cont_contrato;?>&nbsp;</td>
	<td><?=$cont_aula;?>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
  </tr>
</table>
<? }
if($caso_p==3){
	$sql = "SELECT rdb,nombre_instit,id_ano FROM institucion INNER JOIN ano_escolar ON rdb=id_institucion WHERE rdb IN(SELECT rdb FROM corp_instit WHERE num_corp=".$corporacion.") AND nro_ano=".$ano."";
	$rs_instit = @pg_exec($conn,$sql);?>
<table width="850" border="1" align="center" cellpadding="3" cellspacing="0">
  <tr>
	<td colspan="14"  class="tableindex">FICHA SEGUIMIENTO PROYECTO INTEGRACI&Oacute;N POR ESTABLECIMIENTO </td>
  </tr>
  <? 	$sql = "select id_dignos,nombre from diagnostico where rdb IN (SELECT rdb FROM corp_instit WHERE num_corp=".$corporacion.") and tipo=1";
  		$rs_diag = @pg_exec($conn,$sql);
  ?>	
  <tr  class="tabla04">
	<td>N&ordm;</td>
	<td>ESTABLECIMIENTO</td>
	<? for($i=0;$i<@pg_numrows($rs_diag);$i++){
			$fila_d = @pg_fetch_array($rs_diag,$i);
	?>
	<td><?=$fila_d['nombre'];?></td>
	<? } ?>
	<td>TOTAL<br> PROYECTO<br>INTEGRACI&Oacute;N</td>
	<td>APROBADOS</td>
	<td>REPROBADOS</td>
	<td>MEJORA<br>RENDIMIENTO<br> LENGUAJE</td>
	<td>MEJORA<br>RENDIMIENTO<br>MATEMATICAS</td>
	<td>RETIRADO</td>
  </tr>
  <? for($i=0;$i<@pg_numrows($rs_instit);$i++){
  		$fila_ins = @pg_fetch_array($rs_instit,$i);
		$cont++;
		$cont_total=0;
		
		/*$sql ="SELECT count(*) as lenguaje FROM alumno_proyecto a INNER JOIN proyecto_grupo b ON a.id_proy=b.id_proy AND a.rdb=b.rdb WHERE   ";
		$sql.="b.rdb=".$fila_ins['rdb']." AND id_ano=".$fila_ins['id_ano']." AND lenguaje=1 AND tipo=1";
		$rs_lenguaje =@pg_exec($conn,$sql);
		$cont_lenguaje = @pg_result($rs_lenguaje,0);
		
		$sql ="SELECT count(*) as mental FROM alumno_proyecto a INNER JOIN proyecto_grupo b ON a.id_proy=b.id_proy WHERE b.rdb=".$fila_ins['rdb']." AND ";
		$sql.="id_ano=".$fila_ins['id_ano']." AND deficit_mental=1 AND tipo=1";
		$rs_mental =@pg_exec($conn,$sql);
		$cont_mental = @pg_result($rs_mental,0);
		
		$sql ="SELECT count(*) as audicion FROM alumno_proyecto a INNER JOIN proyecto_grupo b ON a.id_proy=b.id_proy WHERE b.rdb=".$fila_ins['rdb']." AND ";
		$sql.="id_ano=".$fila_ins['id_ano']." AND audicion=1 AND tipo=1";
		$rs_audicion =@pg_exec($conn,$sql);
		$cont_audicion = @pg_result($rs_audicion,0);*/
		
		/*$sql="SELECT COUNT(*) as proyecto FROM proyecto_grupo WHERE rdb=".$fila_ins['rdb']." AND tipo=1";
		$rs_total = @pg_exec($conn,$sql);
		$cont_total = @pg_result($rs_total,0);*/
		
		$sql ="SELECT count(*) as mlenguaje FROM alumno_proyecto a INNER JOIN proyecto_grupo b ON a.id_proy=b.id_proy WHERE b.rdb=".$fila_ins['rdb']." AND ";
		$sql.="id_ano=".$fila_ins['id_ano']." AND mejora_lenguaje=1 AND tipo=1";
		$rs_mlenguaje =@pg_exec($conn,$sql);
		$cont_mlenguaje = @pg_result($rs_mlenguaje,0);
		
		$sql ="SELECT count(*) as matematica FROM alumno_proyecto a INNER JOIN proyecto_grupo b ON a.id_proy=b.id_proy WHERE b.rdb=".$fila_ins['rdb']." AND ";
		$sql.="id_ano=".$fila_ins['id_ano']." AND mejora_matematica=1 AND tipo=1";
		$rs_matematica =@pg_exec($conn,$sql);
		$cont_matematica = @pg_result($rs_matematica,0);
		
		$sql ="SELECT count(*) as aprobado FROM alumno_proyecto a INNER JOIN proyecto_grupo b ON a.id_proy=b.id_proy WHERE b.rdb=".$fila_ins['rdb']." AND ";
		$sql.="id_ano=".$fila_ins['id_ano']." AND aprobado=1 AND tipo=1";
		$rs_aprobado =@pg_exec($conn,$sql);
		$cont_aprobado = @pg_result($rs_aprobado,0);
		
		$sql ="SELECT count(*) as reprobado FROM alumno_proyecto a INNER JOIN proyecto_grupo b ON a.id_proy=b.id_proy WHERE b.rdb=".$fila_ins['rdb']." AND ";
		$sql.="id_ano=".$fila_ins['id_ano']." AND reprobado=1 AND tipo=1";
		$rs_reprobado =@pg_exec($conn,$sql);
		$cont_reprobado = @pg_result($rs_reprobado,0);
		
		$sql ="SELECT count(*) as retirado FROM alumno_proyecto a INNER JOIN proyecto_grupo b ON a.id_proy=b.id_proy WHERE b.rdb=".$fila_ins['rdb']." AND ";
		$sql.="id_ano=".$fila_ins['id_ano']." AND retirado=1 AND tipo=1";
		$rs_retirado =@pg_exec($conn,$sql);
		$cont_retirado = @pg_result($rs_retirado,0);
	?>
  <tr>
	<td class="datos"><?=$cont;?></td>
	<td class="datos"><?=$fila_ins['nombre_instit'];?></td>
	<? for($j=0;$j<@pg_numrows($rs_diag);$j++){
			$fila_di = @pg_fetch_array($rs_diag,$j);
			$sql ="SELECT count(*) as lenguaje FROM alumno_proyecto a INNER JOIN proyecto_grupo b ON a.id_proy=b.id_proy AND a.rdb=b.rdb WHERE   ";
			$sql.="b.rdb=".$fila_ins['rdb']." AND id_ano=".$fila_ins['id_ano']." AND id_dignos=".$fila_di['id_dignos']." AND tipo=1";
			$rs_lenguaje =@pg_exec($conn,$sql);
			$cont_diag = @pg_result($rs_lenguaje,0);
			$total_dig[$j]=$total_dig[$j] + $cont_diag;
			$cont_total += $cont_diag;
	?>
	<td class="datos"><?=$cont_diag;?></td>
	<? } ?>
	<td class="datos"><?=$cont_total;?></td>
	<td class="datos"><?=$cont_aprobado;?></td>
	<td class="datos"><?=$cont_reprobado;?></td>
	<td class="datos"><?=$cont_mlenguaje;?></td>
	<td class="datos"><?=$cont_matematica;?></td>
	<td class="datos"><?=$cont_retirado;?></td>
  </tr>
  <? 	/*$total_lenguaje = $total_tea + $cont_lenguaje;
		$total_mental = $total_mental + $cont_mental;
		$total_audicion = $total_audicion + $cont_audicion;*/
		$total_reprobado = $total_reprobado + $cont_reprobado;
		$total_retirado = $total_retirado + $cont_retirado;
		$total_aprobado = $total_aprobado + $cont_aprobado;
		$total_mlenguaje = $total_mlenguaje + $cont_mlenguaje;
		$total_matematica = $total_matematica + $cont_matematica;
		$total_alum = $total_alum + $cont_total;
  } ?>
  <tr  class="tabla04">
	<td>&nbsp;</td>
	<td>TOTAL</td>
	<? for($j=0;$j<@pg_numrows($rs_diag);$j++){ ?>
	<td><?=$total_dig[$j];?></td>
	<? } ?>
	<td><?=$total_alum;?></td>
	<td><?=$total_aprobado;?></td>
	<td><?=$total_reprobado;?></td>
	<td><?=$total_mlenguaje;?></td>
	<td><?=$total_matematica;?></td>
	<td><?=$total_retirado;?></td>
  </tr>
</table>
<? }
if($caso_p==4){ 
	/*$sql ="SELECT count(e.*) as total,a.nombre_instit,b.nombre,c.hrs_contrato,c.total_aula,d.nombre_emp || cast(' ' as varchar) || ";
	$sql.=" d.ape_pat || cast(' ' as  varchar) as nombre_emp,b.objetivo  FROM institucion a INNER JOIN proyecto_grupo b ";
	$sql.=" ON a.rdb=b.rdb INNER JOIN dotacion_docente c ON b.rut_emp=c.rut_emp  INNER JOIN empleado d ON ";
	$sql.=" (b.rut_emp=d.rut_emp AND c.rut_emp=d.rut_emp) LEFT JOIN inscribe_proyecto e ON  b.id_proy=e.id_proy ";
	$sql.=" WHERE b.rdb in (SELECT rdb FROM corp_instit WHERE num_corp=".$corporacion.") AND b.tipo=2 GROUP BY  a.nombre_instit, ";
	$sql.=" b.nombre,c.hrs_contrato,c.total_aula, d.nombre_emp,d.ape_pat,b.objetivo  ";*/
	$sql = "SELECT count(a.*) as total,b.nombre as diag,c.nombre_instit, e.nombre_emp || cast(' ' as varchar) || e.ape_pat || ";
	$sql.= "cast(' ' as varchar) as nombre_emp, f.hrs_contrato,f.total_aula,d.objetivo ";
	$sql.= "FROM alumno_proyecto a INNER JOIN diagnostico b ON  a.id_dignos=b.id_dignos ";
	$sql.= "INNER JOIN institucion c ON a.rdb=c.rdb INNER JOIN proyecto_grupo d ON a.id_proy=d.id_proy AND d.rdb=c.rdb ";
	$sql.= "INNER JOIN empleado e ON d.rut_emp=e.rut_emp INNER JOIN dotacion_docente f ON f.rut_emp=e.rut_emp AND f.rut_emp=d.rut_emp ";
	$sql.= "AND f.rdb=a.rdb AND f.rdb=c.rdb AND f.rdb=d.rdb  ";
	$sql.= "WHERE c.rdb in (SELECT rdb FROM corp_instit WHERE num_corp=".$corporacion.") AND d.tipo=2 ";
	$sql.= "group by b.nombre,c.nombre_instit,e.nombre_emp,e.ape_pat, f.hrs_contrato,f.total_aula ,d.objetivo ";
	$rs_grupo=@pg_exec($conn,$sql);

?>		
	<table width="850" border="1" align="center" cellpadding="3" cellspacing="0">
	  <tr>
		<td colspan="9" class="tableindex">DATOS ESCUELAS CON GRUPO DIFERENCIAL </td>
	  </tr>
	  <tr  class="tabla04">
		<td>N&ordm;</td>
		<td>ESTABLECIMIENTO</td>
		<td>PROFESOR</td>
		<td>GRUPO<br>DIFERENCIAL</td>
		<td><p>N&ordm; ALUMNOS<br>POR GRUPO</p></td>
		<td><p>HORAS<br>CONTRATO</p></td>
		<td>HORAS<br>AULA</td>
		<td>RANGO<br>ATENCI&Oacute;N</td>
		<td>OBSERVACIONES</td>
	  </tr>
	  <? for($i=0;$i<@pg_numrows($rs_grupo);$i++){
			$fila_grupo= @pg_fetch_array($rs_grupo,$i);
			$cont_g++;
		?>
	  <tr>
		<td class="datos"><?=$cont_g;?></td>
		<td class="datos"><?=$fila_grupo['nombre_instit'];?></td>
		<td class="datos"><?=$fila_grupo['nombre_emp'];?></td>
		<td class="datos"><?=$fila_grupo['diag'];?></td>
		<td class="datos"><?=$fila_grupo['total'];?></td>
		<td class="datos"><?=$fila_grupo['hrs_contrato'];?></td>
		<td class="datos"><?=$fila_grupo['total_aula'];?></td>
		<td class="datos">&nbsp;</td>
		<td class="datos"><?=$fila_grupo['objetivo'];?></td>
	  </tr>
	  <? 	$total_alum_g = $total_alum_g + $fila_grupo['total'];
			$total_contrato_g = $total_contrato_g + $fila_grupo['hrs_contrato'];
			$total_aula_g = $total_aula_g + $fila_grupo['total_aula'];
	  
	  } ?>
	  <tr class="tabla04">
		<td>&nbsp;</td>
		<td>TOTAL</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td><?=$total_alum_g;?></td>
		<td><?=$total_contrato_g;?></td>
		<td><?=$total_aula_g;?></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	  </tr>
</table>
<? }
if($caso_p==5) {
	$sql = "SELECT rdb,nombre_instit,id_ano FROM institucion INNER JOIN ano_escolar ON rdb=id_institucion WHERE rdb IN(SELECT rdb FROM corp_instit WHERE num_corp=".$corporacion.") AND nro_ano=".$ano."";
	$rs_instit = @pg_exec($conn,$sql);?>
<table width="850" border="1" align="center" cellpadding="3" cellspacing="0">
  <tr>
	<td colspan="12"  class="tableindex">FICHA SEGUIMIENTO GRUPO DIFERENCIAL POR ESTABLECIMIENTO </td>
  </tr>
  <? 	$sql = "select id_dignos,nombre from diagnostico where rdb IN (SELECT rdb FROM corp_instit WHERE num_corp=".$corporacion.") and tipo=2";
  		$rs_diag = @pg_exec($conn,$sql);
  ?>	
  <tr  class="tabla04">
	<td>N&ordm; </td>
	<td>ESTABLECIMIENTO</td>
	<? for($i=0;$i<@pg_numrows($rs_diag);$i++){
			$fila_d = @pg_fetch_array($rs_diag,$i);
	?>
	<td><?=$fila_d['nombre'];?></td>
	<? } ?>
	<td>TOTAL<br>
	GD</td>
	<td>APROBADOS</td>
	<td>REPROBADOS</td>
	<td><p>MEJORA<br>
	  RENDIMIENTO<br>
	LENGUAJE</p>
    </td>
	<td>MEJORA<br>
	  RENDIMIENTO<br>
	  MATEMATICAS</td>
	<td>RETIRADOS</td>
  </tr>
  <? for($i=0;$i<@pg_numrows($rs_instit);$i++){
  		$fila_ins = @pg_fetch_array($rs_instit,$i);
		$cont++;
		$cont_total=0;
		
		
	/*	$sql ="SELECT count(*) as pa FROM alumno_proyecto a INNER JOIN proyecto_grupo b ON a.id_proy=b.id_proy AND a.rdb=b.rdb WHERE b.rdb=".$fila_ins['rdb']." AND ";
		$sql.="id_ano=".$fila_ins['id_ano']." AND pa=1 AND tipo=2";
		$rs_pa =@pg_exec($conn,$sql);
		$cont_pa = @pg_result($rs_pa,0);
		
		$sql ="SELECT count(*) as tea FROM alumno_proyecto a INNER JOIN proyecto_grupo b ON a.id_proy=b.id_proy WHERE b.rdb=".$fila_ins['rdb']." AND ";
		$sql.="id_ano=".$fila_ins['id_ano']." AND tea=1 AND tipo=2";
		$rs_tea =@pg_exec($conn,$sql);
		$cont_tea = @pg_result($rs_tea,0);
		
		$sql ="SELECT count(*) as sda FROM alumno_proyecto a INNER JOIN proyecto_grupo b ON a.id_proy=b.id_proy WHERE b.rdb=".$fila_ins['rdb']." AND ";
		$sql.="id_ano=".$fila_ins['id_ano']." AND sda=1 AND tipo=2";
		$rs_sda =@pg_exec($conn,$sql);
		$cont_sda = @pg_result($rs_sda,0);
		
		$sql ="SELECT count(*) as l FROM alumno_proyecto a INNER JOIN proyecto_grupo b ON a.id_proy=b.id_proy WHERE b.rdb=".$fila_ins['rdb']." AND ";
		$sql.="id_ano=".$fila_ins['id_ano']." AND l=1 AND tipo=2";
		$rs_l =@pg_exec($conn,$sql);
		$cont_l = @pg_result($rs_l,0);
		
		$sql="SELECT COUNT(*) as proyecto FROM proyecto_grupo WHERE rdb=".$fila_ins['rdb']." AND tipo=2";
		$rs_total = @pg_exec($conn,$sql);
		$cont_total = @pg_result($rs_total,0);*/
		
		$sql ="SELECT count(*) as lenguaje FROM alumno_proyecto a INNER JOIN proyecto_grupo b ON a.id_proy=b.id_proy WHERE b.rdb=".$fila_ins['rdb']." AND ";
		$sql.="id_ano=".$fila_ins['id_ano']." AND mejora_lenguaje=1 AND tipo=2";
		$rs_lenguaje =@pg_exec($conn,$sql);
		$cont_lenguaje = @pg_result($rs_lenguaje,0);
		
		$sql ="SELECT count(*) as matematica FROM alumno_proyecto a INNER JOIN proyecto_grupo b ON a.id_proy=b.id_proy WHERE b.rdb=".$fila_ins['rdb']." AND ";
		$sql.="id_ano=".$fila_ins['id_ano']." AND mejora_matematica=1 AND tipo=2";
		$rs_matematica =@pg_exec($conn,$sql);
		$cont_matematica = @pg_result($rs_matematica,0);
		
		$sql ="SELECT count(*) as aprobado FROM alumno_proyecto a INNER JOIN proyecto_grupo b ON a.id_proy=b.id_proy WHERE b.rdb=".$fila_ins['rdb']." AND ";
		$sql.="id_ano=".$fila_ins['id_ano']." AND aprobado=1 AND tipo=2";
		$rs_aprobado =@pg_exec($conn,$sql);
		$cont_aprobado = @pg_result($rs_aprobado,0);
		
		$sql ="SELECT count(*) as reprobado FROM alumno_proyecto a INNER JOIN proyecto_grupo b ON a.id_proy=b.id_proy WHERE b.rdb=".$fila_ins['rdb']." AND ";
		$sql.="id_ano=".$fila_ins['id_ano']." AND reprobado=1 AND tipo=2";
		$rs_reprobado =@pg_exec($conn,$sql);
		$cont_reprobado = @pg_result($rs_reprobado,0);
		
		$sql ="SELECT count(*) as retirado FROM alumno_proyecto a INNER JOIN proyecto_grupo b ON a.id_proy=b.id_proy WHERE b.rdb=".$fila_ins['rdb']." AND ";
		$sql.="id_ano=".$fila_ins['id_ano']." AND retirado=1 AND tipo=2";
		$rs_retirado =@pg_exec($conn,$sql);
		$cont_retirado = @pg_result($rs_retirado,0);
	?>
  <tr>
	<td class="datos"><?=$cont;?></td>
	<td class="datos"><?=$fila_ins['nombre_instit'];?></td>
	<? for($j=0;$j<@pg_numrows($rs_diag);$j++){
			$fila_di = @pg_fetch_array($rs_diag,$j);
			$sql ="SELECT count(*) as lenguaje FROM alumno_proyecto a INNER JOIN proyecto_grupo b ON a.id_proy=b.id_proy AND a.rdb=b.rdb WHERE   ";
			$sql.="b.rdb=".$fila_ins['rdb']." AND id_ano=".$fila_ins['id_ano']." AND id_dignos=".$fila_di['id_dignos']." AND tipo=2";
			$rs_lenguaje =@pg_exec($conn,$sql);
			$cont_diag = @pg_result($rs_lenguaje,0);
			$total_dig[$j]=$total_dig[$j] + $cont_diag;
			$cont_total +=$cont_diag;
	?>
	<td class="datos"><?=$cont_diag;?></td>
	<? } ?>
	<td class="datos"><?=$cont_total;?></td>
	<td class="datos"><?=$cont_aprobado;?></td>
	<td class="datos"><?=$cont_reprobado;?></td>
	<td class="datos"><?=$cont_lenguaje;?></td>
	<td class="datos"><?=$cont_matematica;?></td>
	<td class="datos"><?=$cont_retirado;?></td>
  </tr>
  <? 	/*$total_pa = $total_pa + $cont_pa;
  		$total_tea = $total_tea + $cont_tea;
		$total_sda = $total_sda + $cont_sda;
		$total_l = $total_l + $cont_l;*/
		$total_reprobado = $total_reprobado + $cont_reprobado;
		$total_retirado = $total_retirado + $cont_retirado;
		$total_aprobado = $total_aprobado + $cont_aprobado;
		$total_lenguaje = $total_lenguaje + $cont_lenguaje;
		$total_matematica = $total_matematica + $cont_matematica;
		$total_alum = $total_alum + $cont_total;
  } ?>
  <tr class="tabla04">
	<td>&nbsp;</td>
	<td>TOTAL</td>

	<? for($j=0;$j<@pg_numrows($rs_diag);$j++){ ?>
	<td><?=$total_dig[$j];?></td>
	<? } ?>
	<td><?=$total_alum;?></td>
	<td><?=$total_aprobado;?></td>
	<td><?=$total_reprobado;?></td>
	<td><?=$total_lenguaje;?></td>
	<td><?=$total_matematica;?></td>
	<td><?=$total_retirado;?></td>
  </tr>
</table>
<? } ?>
</body>
</html>
<? pg_close($conn);?>