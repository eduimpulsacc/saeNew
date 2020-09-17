<?php require('../../../../../util/header.inc');?>
<?php 

	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	$curso			=$_CURSO; 

	//------------------------
	// Año Escolar
	//------------------------
	$sql_ano = "select * from ano_escolar where id_ano = ".$ano;
	$result_ano =@pg_Exec($conn,$sql_ano);
	$fila_ano = @pg_fetch_array($result_ano,0);	
	$nro_ano = $fila_ano['nro_ano'];
	//----------------------------------------------------------------------------
	// DATOS INSTITUCION
	//----------------------------------------------------------------------------
	$sql_institu = "SELECT institucion.nombre_instit, institucion.calle, institucion.nro, region.nom_reg, provincia.nom_pro, comuna.nom_com, institucion.telefono ";
	$sql_institu = $sql_institu . "FROM ((institucion INNER JOIN region ON institucion.region = region.cod_reg) INNER JOIN comuna ON (institucion.ciudad = comuna.cor_pro) AND (institucion.comuna = comuna.cor_com) AND (institucion.region = comuna.cod_reg)) INNER JOIN provincia ON (institucion.ciudad = provincia.cor_pro) AND (institucion.region = provincia.cod_reg) ";
	$sql_institu = $sql_institu . "WHERE (((institucion.rdb)=".$institucion.")); ";
	$result_institu =@pg_Exec($conn,$sql_institu);
	$fila_institu = @pg_fetch_array($result_institu,0);
	$nombre_institu = ucwords(strtolower($fila_institu['nombre_instit']));
	$direccion = ucwords(strtolower($fila_institu['calle'] . " " . $fila_institu['nro'] . " - " . $fila_institu['nom_com']));
	$telefono = $fila_institu['telefono'];
	$region = ucwords(strtolower($fila_institu['nom_reg']));
	$provincia = ucwords(strtolower($fila_institu['nom_pro']));
	$comuna = ucwords(strtolower($fila_institu['nom_com']));
	//----------------------------------------------------------------------------
	// CURSO
	//----------------------------------------------------------------------------	
	$Curso_pal = CursoPalabra($curso, 0, $conn);
	//----------------------------------------------------------------------------
	// ALUMNOS
	//----------------------------------------------------------------------------
	$sql_alu = "SELECT alumno.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, matricula.id_curso ";
	$sql_alu = $sql_alu . "FROM matricula INNER JOIN alumno ON matricula.rut_alumno = alumno.rut_alumno ";
	$sql_alu = $sql_alu . "WHERE (((matricula.id_curso)=".$curso.")) ";
	$sql_alu = $sql_alu . "ORDER BY alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu; ";
	$result_alu =@pg_Exec($conn,$sql_alu);	
	//----------------------------------------------------------------------------	
?>

<html>
<head>
<title>.</title>
<link href="../../../../../util/objeto.css" rel="stylesheet" type="text/css">
</head>

<body>
<center>
<table width="650" border="0" cellspacing="1" cellpadding="1">
  <tr>
    <td width="113" align="left"><FONT face="arial, geneva, helvetica" size=2><strong>INSTITUCION</strong></FONT></td>
    <td width="8" align="left"><FONT face="arial, geneva, helvetica" size=2><strong>:</strong></FONT></td>
    <td width="521" align="left"><FONT face="arial, geneva, helvetica" size=2><? echo strtoupper($nombre_institu)?></FONT></td>
  </tr>
  <tr>
    <td align="left"><FONT face="arial, geneva, helvetica" size=2><strong>A&Ntilde;O ESCOLAR </strong></FONT></td>
    <td align="left"><FONT face="arial, geneva, helvetica" size=2><strong>:</strong></FONT></td>
    <td align="left"><FONT face="arial, geneva, helvetica" size=2><? echo $nro_ano?></FONT></td>
  </tr>
  <tr>
    <td align="left"><FONT face="arial, geneva, helvetica" size=2><strong>CURSO</strong></FONT></td>
    <td align="left"><FONT face="arial, geneva, helvetica" size=2><strong>:</strong></FONT></td>
    <td align="left"><FONT face="arial, geneva, helvetica" size=2><? echo $Curso_pal?></FONT></td>
  </tr>
</table>
<table width="650" border="0" cellspacing="1" cellpadding="1">
  <tr>
    <td align="right">
	<?
	 if (($_PERFIL==17) AND ($_INSTIT==9566)){
		// No muestro boton
	 }else{  ?>
	     <INPUT name="button" TYPE="button" class="botonX" onClick=document.location="promocion_ingresa_d.php" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' value="PROCESAR">
   <? } ?>   
	  <INPUT name="button2" TYPE="button" class="botonX" onClick=document.location="../seteaCurso.php3?caso=4" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' value="VOLVER"></td>
  </tr>
  <tr bgcolor="#003b85" align="center">
    <td ><FONT face="arial, geneva, helvetica" size=2 color="#FFFFFF"><strong>PROMOCION DE ALUMNOS </strong></FONT></td>
  </tr>
</table>
<table width="650" border="0" cellspacing="1" cellpadding="1">
  <tr bgcolor="#48d1cc">
    <td width="63" height="24" align="center"><FONT face="arial, geneva, helvetica" size=1><strong>RUT ALUMNO </strong></FONT></td>
    <td width="161" align="center"><FONT face="arial, geneva, helvetica" size=1><strong>NOMBRE ALUMNO </strong></FONT></td>
    <td width="50" align="center"><FONT face="arial, geneva, helvetica" size=1><strong>PROMEDIO</strong></FONT></td>
    <td width="75" align="center"><FONT face="arial, geneva, helvetica" size=1><strong>ASISTENCIA (%) </strong></FONT></td>
    <td width="125" align="center"><FONT face="arial, geneva, helvetica" size=1><strong>SITUACION</strong></FONT></td>
    <td width="157" align="center"><FONT face="arial, geneva, helvetica" size=1><strong>OBSERVACI&Oacute;N</strong></FONT></td>
  </tr>
 <?
$cont_alumnos = @pg_numrows($result_alu);
for($cont_paginas=0 ; $cont_paginas < $cont_alumnos  ; $cont_paginas++)
{
	$fila_alu = @pg_fetch_array($result_alu,$cont_paginas);	
	$alumno = $fila_alu['rut_alumno'];
	$rut_alumno = $fila_alu['rut_alumno'] . "-" . strtoupper($fila_alu['dig_rut']);
	$nombre_alu = ucwords(strtoupper(trim($fila_alu['ape_pat']) . " " . trim($fila_alu['ape_mat']) . " " . trim($fila_alu['nombre_alu']))); 
	$curso = $fila_alu['id_curso'];
	$observacion = "";
	//------------------------------------------------------------------------------
	// CONSULTA EN TABLA PROMOCION
	//------------------------------------------------------------------------------
	$sql_promo = "select * from promocion where rut_alumno = '".$alumno."' and id_ano = ".$ano." and id_curso = ".$curso;
	$result_promo =@pg_Exec($conn,$sql_promo);
	$fila_promo = @pg_fetch_array($result_promo,0);		
	if ($fila_promo['promedio']>0) $promedio = $fila_promo['promedio']; else $promedio = "&nbsp;";
	if ($fila_promo['asistencia']>0) $asistencia = $fila_promo['asistencia']."%"; else $asistencia = "&nbsp;";
	if ($fila_promo['situacion_final']>0){
		if ($fila_promo['situacion_final']==1)
			$situacion_final = "APROBADO";
		if ($fila_promo['situacion_final']==2){
			if ($fila_promo['tipo_reprova']==1) $tipo_reproba = "POR NOTAS";
			if ($fila_promo['tipo_reprova']==2) $tipo_reproba = "POR ASISTENCIA";						
			$situacion_final = "REPROBADO"." - ". $tipo_reproba;}
		if ($fila_promo['situacion_final']==3){
			$situacion_final = "RETIRADO";}			//$observacion ="RET. ".cfecha2($fila_promo['fecha_retiro']);
	}else{
		$situacion_final = "&nbsp;";
	}
	$observacion = $observacion . " " .  $fila_promo['observacion'];
?>  
  <tr>
    <td align="left"><FONT face="arial, geneva, helvetica" size=1><strong><? echo $rut_alumno?></strong></FONT></td>
    <td align="left"><FONT face="arial, geneva, helvetica" size=1><strong><? echo substr($nombre_alu,0,20)?></strong></FONT></td>
    <td align="center"><FONT face="arial, geneva, helvetica" size=1><strong><? echo $promedio?></strong></FONT></td>
    <td align="center"><FONT face="arial, geneva, helvetica" size=1><strong><? echo $asistencia?></strong></FONT></td>
    <td align="left"><FONT face="arial, geneva, helvetica" size=1><strong><? echo $situacion_final?></strong></FONT></td>
    <td align="left"><FONT face="arial, geneva, helvetica" size=1><strong><? echo $observacion?></strong></FONT></td>
  </tr>
 <? }?>
</table>

</center>
</body>
</html>
