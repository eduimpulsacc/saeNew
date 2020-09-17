<script>
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
</script>

<?
require('../../../../../util/header.inc');

	setlocale("LC_ALL","es_ES");
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$c_curso;
	$alumno			=$c_alumno;
	if ($curso==0) exit;
	//----------------------------------------------------------------------------
	//-------------- INSTITUCION -------------------------------------------------------------
	$sql_ins = "SELECT institucion.nombre_instit, institucion.calle, institucion.nro, region.nom_reg, provincia.nom_pro, comuna.nom_com, institucion.telefono ";
	$sql_ins = $sql_ins . "FROM ((institucion INNER JOIN region ON institucion.region = region.cod_reg) INNER JOIN provincia ON (institucion.ciudad = provincia.cor_pro) AND (institucion.region = provincia.cod_reg)) INNER JOIN comuna ON (institucion.region = comuna.cod_reg) AND (institucion.ciudad = comuna.cor_pro) AND (institucion.comuna = comuna.cor_com) ";
	$sql_ins = $sql_ins . "WHERE (((institucion.rdb)=".$institucion.")); ";
	$result_ins =@pg_Exec($conn,$sql_ins);
	$fila_ins = @pg_fetch_array($result_ins,0);	
	$ins_pal = $fila_ins['nombre_instit'];
	$direccion = $fila_ins['calle'] . " " . $fila_ins['nro'] . " " . $fila_ins['nom_com'];
	$telefono = $fila_ins['telefono'];	
	//----------------------------------------------------------------------------
	// AÑO ESCOLAR
	//----------------------------------------------------------------------------
	$sql_ano = "select * from ano_escolar where id_ano = ".$ano;
	$result_ano =@pg_Exec($conn,$sql_ano);
	$fila_ano = @pg_fetch_array($result_ano,0);
	$nro_ano = $fila_ano['nro_ano'];
	// Curso //
	$Curso_pal = CursoPalabra($curso, 0, $conn);
	//----------------------------------------- PROFE JEFE
	$sql_profe = "SELECT empleado.ape_pat, empleado.ape_mat, empleado.nombre_emp ";
	$sql_profe = $sql_profe . "FROM supervisa INNER JOIN empleado ON supervisa.rut_emp = empleado.rut_emp ";
	$sql_profe = $sql_profe . "WHERE (((supervisa.id_curso)=".$curso.")); ";
	$result_profe =@pg_Exec($conn,$sql_profe);
	$fila_profe = @pg_fetch_array($result_profe,0);	
	$profe_jefe = ucwords(strtoupper(trim($fila_profe['ape_pat']) . " " . trim($fila_profe['ape_mat'] ) . " " . trim($fila_profe['nombre_emp'])));
	//-----------------------------------------	
?>	

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>.</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../util/objeto.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.Estilo1 {font-weight: bold}
-->
</style></head>

<body>
<STYLE>
 H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always
 }
 
</style>
<center>
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><div id="capa0">
		<div align="right">
          <input name="button3" type="button" class="botonX" onClick="imprimir();" onMouseOver=this.style.background='FFFFD7';this.style.color='003b85' onMouseOut=this.style.background='#5c6fa9';this.style.color='ffffff' value="IMPRIMIR">
        </div>
      </div></td>
  </tr>
</table>
<br>
<?
	if ($alumno > 0)
	{
		$sql_alumno = "SELECT matricula.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, alumno.fecha_nac, alumno.sexo, alumno.nacionalidad, alumno.telefono, alumno.email, matricula.fecha, alumno.fecha_retiro, matricula.bool_baj, matricula.bool_bchs, matricula.bool_aoi, matricula.bool_rg, matricula.bool_ae, matricula.bool_i, matricula.bool_gd, matricula.bool_ar, matricula.bool_bchs, alumno.calle, alumno.nro, region.nom_reg, provincia.nom_pro, comuna.nom_com, alumno.depto, alumno.block, alumno.villa ";
		$sql_alumno = $sql_alumno . "FROM (((matricula INNER JOIN alumno ON matricula.rut_alumno = alumno.rut_alumno) INNER JOIN region ON alumno.region = region.cod_reg) INNER JOIN provincia ON (alumno.ciudad = provincia.cor_pro) AND (alumno.region = provincia.cod_reg)) INNER JOIN comuna ON (alumno.comuna = comuna.cor_com) AND (alumno.ciudad = comuna.cor_pro) AND (alumno.region = comuna.cod_reg) ";
		$sql_alumno = $sql_alumno . "WHERE (((matricula.rut_alumno)=".$alumno.") AND ((matricula.id_ano)=".$ano.")); ";
	}
	else
	{
		$sql_alumno = "SELECT matricula.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, alumno.fecha_nac, alumno.sexo, alumno.nacionalidad, alumno.telefono, alumno.email, matricula.fecha, alumno.fecha_retiro, matricula.bool_baj, matricula.bool_bchs, matricula.bool_aoi, matricula.bool_rg, matricula.bool_ae, matricula.bool_i, matricula.bool_gd, matricula.bool_ar, matricula.bool_bchs, alumno.calle, alumno.nro, region.nom_reg, provincia.nom_pro, comuna.nom_com, alumno.depto, alumno.block, alumno.villa ";
		$sql_alumno = $sql_alumno . "FROM (((matricula INNER JOIN alumno ON matricula.rut_alumno = alumno.rut_alumno) INNER JOIN region ON alumno.region = region.cod_reg) INNER JOIN provincia ON (alumno.ciudad = provincia.cor_pro) AND (alumno.region = provincia.cod_reg)) INNER JOIN comuna ON (alumno.comuna = comuna.cor_com) AND (alumno.ciudad = comuna.cor_pro) AND (alumno.region = comuna.cod_reg) ";
		$sql_alumno = $sql_alumno . "WHERE (((matricula.id_ano)=".$ano.") and ((matricula.id_curso)=".$curso.")) order by ape_pat, ape_mat; ";
	}	
	$result_alumno = @pg_Exec($conn, $sql_alumno);
	$cantidad_alumnos = @pg_numrows($result_alumno);
	for($i=0 ; $i < @pg_numrows($result_alumno) ; $i++)
	{
		$fila_alumno = @pg_fetch_array($result_alumno,$i);
		$alumno = $fila_alumno['rut_alumno'];
		$nombre = ucwords(strtoupper($fila_alumno['ape_pat'])) . " " . ucwords(strtoupper($fila_alumno['ape_mat'])) . " " . ucwords(strtoupper($fila_alumno['nombre_alu']));
?>
<?
	$sql_institu = "SELECT institucion.rdb, institucion.dig_rdb, institucion.nombre_instit, institucion.calle, institucion.nro, institucion.telefono, region.nom_reg, provincia.nom_pro, comuna.nom_com ";
	$sql_institu = $sql_institu . "FROM ((institucion INNER JOIN region ON institucion.region = region.cod_reg) INNER JOIN provincia ON (institucion.ciudad = provincia.cor_pro) AND (region.cod_reg = provincia.cod_reg)) INNER JOIN comuna ON (provincia.cod_reg = comuna.cod_reg) AND (provincia.cor_pro = comuna.cor_pro) AND (institucion.comuna = comuna.cor_com) ";
	$sql_institu = $sql_institu . "WHERE (((institucion.rdb)=".$institucion.")); ";
	$result_institu =@pg_Exec($conn,$sql_institu);
	$fila_institu = @pg_fetch_array($result_institu,0);
	$rdb = $fila_institu['rdb'] . "-" . $fila_institu['dig_rdb'];
	$nombre_institu = ucwords(strtolower($fila_institu['nombre_instit']));
	$direccion = ucwords(strtolower($fila_institu['calle'] . " " . $fila_institu['nro']));
	$telefono = $fila_institu['telefono'];
	$comuna = ucwords(strtolower($fila_institu['nom_com']));
	$ciudad = ucwords(strtolower($fila_institu['nom_pro']));
	$region = ucwords(strtolower($fila_institu['nom_reg']));
?>
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="487"><font face="Verdana, Arial, Helvetica, sans-serif" size="+1"><strong><? echo ucwords(strtoupper($ins_pal));?></strong></font></td>
    <td width="11">&nbsp;</td>
    <td width="152" rowspan="4" align="center">
      <?
		$result = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
		$arr=@pg_fetch_array($result,0);
		$fila_foto = @pg_fetch_array($result,0);
		if 	(!empty($fila_foto['insignia']))
		{
			$output= "select lo_export(".$arr['insignia'].",'/var/www/html/tmp/".$arr[rdb]."');";
			$retrieve_result = @pg_exec($conn,$output);?>
      <table width="125" border="0" cellpadding="0" cellspacing="0">
        <tr valign="top">
          <td width="125" align="center"> <img src=../../../../../../../tmp/<? echo $institucion ?> ALT="NO DISPONIBLE" height="100"></td>
        </tr>
      </table>
      <? } ?>
    </td>
  </tr>
  <tr>
    <td><font face="Verdana, Arial, Helvetica, sans-serif" size="-1"><? echo ucwords(strtolower($direccion));?></font></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><font face="Verdana, Arial, Helvetica, sans-serif" size="-1"><? echo ucwords(strtolower($telefono));?></font></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="41">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<br>
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr bgcolor="#003b85">
    <td bgcolor="#003b85"><div align="center" class="Estilo1"><font face="Arial, Helvetica, sans-serif" color="#FFFFFF"><strong>INFORME DE ATRASOS, ANOTACIONES E INASISTENCIAS </strong></font></div></td>
    </tr>
  <tr>
</table>
<br>
<table width="650" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="159"><font face="Arial, Helvetica, sans-serif" size="-1"><strong>Nombre Alumno</strong></font></td>
          <td width="10"><font face="Arial, Helvetica, sans-serif" size="-1"><strong>:</strong></font></td>
          <td width="485"><font face="Arial, Helvetica, sans-serif" size="-1"><? echo $nombre?></font></td>
        </tr>
        <tr>
          <td><font face="Arial, Helvetica, sans-serif" size="-1"><strong>Curso</strong></font></td>
          <td><font face="Arial, Helvetica, sans-serif" size="-1"><strong>:</strong></font></td>
          <td><font face="Arial, Helvetica, sans-serif" size="-1"><? echo $Curso_pal?></font></td>
        </tr>
        <tr>
          <td><font face="Arial, Helvetica, sans-serif" size="-1"><strong>Profesor Jefe</strong></font></td>
          <td><font face="Arial, Helvetica, sans-serif" size="-1"><strong>:</strong></font></td>
          <td><font face="Arial, Helvetica, sans-serif" size="-1"><? echo $profe_jefe?></font></td>
        </tr>
  </table>
	 <br>
<?
	$sql_anota = "select anotacion.*, empleado.nombre_emp, empleado.ape_pat, empleado.ape_pat from anotacion, empleado ";
	$sql_anota = $sql_anota . "where rut_alumno = ".$alumno." and date_part('Y',fecha) = ".$nro_ano." and anotacion.rut_emp = empleado.rut_emp ";
	$sql_anota = $sql_anota . "and (tipo = 1 or tipo = 2) order by tipo, fecha ";
	$result_anota = @pg_Exec($conn, $sql_anota);
	if (@pg_numrows($result_anota)==0) echo "<font face=Arial, Helvetica, sans-serif size=4><strong>NO REGISTRA ANOTACIONES NI ATRASOS</strong></font><br>";
	for($e=0 ; $e < @pg_numrows($result_anota) ; $e++)
	{
		$fila_anota = @pg_fetch_array($result_anota,$e);
		if ($fila_anota['tipo']== 1)
			$tipo = "CONDUCTA";
		else
			$tipo = "ATRASO";
		$fecha = $fila_anota['fecha'];
		$profesor_res = strtoupper($fila_anota['ape_pat'] . " " . $fila_anota['ape_mat'] . " " . $fila_anota['nombre_emp']);
		if (trim($fila_anota['observacion'])=="")
			$observacion = "&nbsp;";
		else
			$observacion = ucfirst($fila_anota['observacion']);
		$hora = $fila_anota['hora'];
		
		
?>	 
<table width="650" border="0" cellspacing="0" cellpadding="0">
   <tr>
     <td><hr width="100%" color=#003b85></td>
   </tr>
 </table>
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="156"><font face="Arial, Helvetica, sans-serif" size="-1"><strong>Fecha</strong></font></td>
    <td width="7"><font face="Arial, Helvetica, sans-serif" size="-1"><strong>:</strong></font></td>
    <td width="258"><font face="Arial, Helvetica, sans-serif" size="-1"><? echo $fecha?></font></td>
    <td width="77"><font face="Arial, Helvetica, sans-serif" size="-1"><strong>Tipo</strong></font></td>
    <td width="9"><font face="Arial, Helvetica, sans-serif" size="-1"><strong>:</strong></font></td>
    <td width="143"><font face="Arial, Helvetica, sans-serif" size="-1"><? echo $tipo?></font></td>
  </tr>
  <tr>
    <td><font face="Arial, Helvetica, sans-serif" size="-1"><strong>Profesor Responsable </strong></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-1"><strong>:</strong></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-1"><? echo $profesor_res?></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-1"><strong>Hora</strong></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-1"><strong>:</strong></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-1"><? echo $hora?></font></td>
  </tr>
  <tr>
    <td><font face="Arial, Helvetica, sans-serif" size="-1"><strong>Observaci&oacute;n</strong></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-1"><strong>:</strong></font></td>
    <td colspan="4"><font face="Arial, Helvetica, sans-serif" size="-1"><? echo $observacion?></font></td>
    </tr>
</table>

<? } ?>
<table width="650" border="0" cellspacing="0" cellpadding="0">
   <tr>
     <td><hr width="100%" color=#003b85></td>
   </tr>
 </table>
<?
	$sql_asis = "select * from asistencia where rut_alumno = ".$alumno." and ano = ".$ano." order by fecha";
	$result_asis = @pg_Exec($conn, $sql_asis);
	if (@pg_numrows($result_asis)==0) 
		echo "<font face=Arial, Helvetica, sans-serif size=4><strong>NO REGISTRA INASISTENCIAS</strong></font><br>";
	for($cont=0 ; $cont < @pg_numrows($result_asis) ; $cont++)
	{
		$fila_asis = @pg_fetch_array($result_asis,$cont);
		$fecha = $fila_asis['fecha'];	
?>
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="126"><font face="Arial, Helvetica, sans-serif" size="-1"><strong>Inasistencia el d&iacute;a </strong></font></td>
    <td width="524"><font face="Arial, Helvetica, sans-serif" size="-1"><? echo ucwords(Cfecha3($fecha));?></font></td>
  </tr>
</table>
<table width="650" border="0" cellspacing="0" cellpadding="0">
   <tr>
     <td><hr width="100%" color=#003b85></td>
   </tr>
 </table>
<?
 }//asistencia
 if  (($cantidad_alumnos - $i)<>1) 
	echo "<H1 class=SaltoDePagina>&nbsp;</H1>";

}//alumno ?>
<br>
<table width="650" height="119" border="0" cellpadding="0" cellspacing="0">
  <tr>
	<td height="27"><div align="left"><font size="2"><strong><font face="Arial, Helvetica, sans-serif">_____________________________________________________________________________</font><font size="2"><strong><font face="Arial, Helvetica, sans-serif">__________</font><font size="2"><strong><font face="Arial, Helvetica, sans-serif">_____</font></strong></font></strong></font></strong></font></div></td>
  </tr>
  <tr>
	<td height="22"><div align="left"><font size="2"><strong><font face="Arial, Helvetica, sans-serif">_____________________________________________________________________________</font><font size="2"><strong><font face="Arial, Helvetica, sans-serif">__________</font><font size="2"><strong><font face="Arial, Helvetica, sans-serif">_____</font></strong></font></strong></font></strong></font></div></td>
	</tr>
  <tr>
	<td height="23"><div align="left"><font size="2"><strong><font face="Arial, Helvetica, sans-serif">_____________________________________________________________________________</font><font size="2"><strong><font face="Arial, Helvetica, sans-serif">__________</font><font size="2"><strong><font face="Arial, Helvetica, sans-serif">_____</font></strong></font></strong></font></strong></font></div></td>
	</tr>
			  <tr>
	<td height="23"><div align="left"><font size="2"><strong><font face="Arial, Helvetica, sans-serif">_____________________________________________________________________________</font><font size="2"><strong><font face="Arial, Helvetica, sans-serif">__________</font><font size="2"><strong><font face="Arial, Helvetica, sans-serif">_____</font></strong></font></strong></font></strong></font></div></td>
	</tr>
  <tr>
	<td><div align="left"><font size="2"><strong><font face="Arial, Helvetica, sans-serif">_____________________________________________________________________________</font><font size="2"><strong><font face="Arial, Helvetica, sans-serif">__________</font><font size="2"><strong><font face="Arial, Helvetica, sans-serif">_____</font></strong></font></strong></font></strong></font></div></td>
	</tr>
</table>
</center>
</body>
</html>
