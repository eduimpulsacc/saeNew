<?
require('../../../../util/header.inc'); 
include('../../../clases/class_Reporte.php');
include('../../../clases/class_Membrete.php');
$institucion= $_INSTIT;
 $ano			= $_ANO;

$rut_alumno=$alumno;
$id_curso=$cmb_curso;

$ob_reporte = new Reporte();
$ob_institucion = new Membrete();
	$ob_institucion -> ano =$ano;
	$ob_institucion -> institucion =$institucion;
	$ob_institucion -> institucion($conn);

echo "..".$ob_reporte->ano = $ano; 

$ob_institucion->AnoEscolar($conn);	
$nro_ano=$ob_institucion->nro_ano;	
$sql_ense="select ensenanza from curso where id_curso=$id_curso";	

$rs_ense=pg_exec($conn,$sql_ense);
$ense = pg_result($rs_ense,0);

$Curso_pal = CursoPalabra($id_curso, 0, $conn);

if ($rut_alumno!=0){
	$ob_reporte->ano = $ano; 
	$ob_reporte->alumno = $rut_alumno;
	$result_home=$ob_reporte->FichaAlumnoUno_fichamat($conn);
	//$fila = pg_fetch_array($result_home,0);
}else{
	$ob_reporte->ano = $ano; 
	$ob_reporte->curso = $id_curso;
	$ob_reporte->retirado = 0;
	$ob_reporte->orden=1;
	$result_home=$ob_reporte->FichaAlumnoTodos($conn);
}
echo pg_numrows($result_home);
 
$institucion= $_INSTIT;
 $sci  = "select num_corp from corp_instit where rdb = $institucion";
 $rci= pg_exec($connection,$sci);
  $corp = pg_result($rci,0);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
</head>
<script language="javascript1.1" type="text/javascript">
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
</script>
<STYLE>
 H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always
 }
</STYLE>

<body>
<?php  if ((pg_numrows($result_home)>0) ){
	 ?>
<div id="capa0">
<table width="650" align="center">
  <tr>
    <td><input name="button4" type="button" class="botonXX" onclick="window.close()"   value="CERRAR" /></td>
    <td align="right"><input name="button3" type="button" class="botonXX"  value="IMPRIMIR" onclick="javascript:imprimir()" />
        <? if($_PERFIL==0){?>
        <input name="cb_exp" type="button" onclick="exportar(this.form)" class="botonXX"  id="cb_exp" value="EXPORTAR" />
        <? }?>
    </td>
  </tr>
</table>
</div>
<?php for($i=0;$i<pg_numrows($result_home);$i++){
	$fila=pg_fetch_array($result_home,$i);
$ob_reporte->CambiaDato($fila);
	?><table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="10%" rowspan="4"><?
						if($institucion!=""){
							echo "<img src='../../../../tmp/".$institucion."insignia". "' >";
						}else{
						   echo "<img src='".$d."menu/imag/logo.gif' >";
						}	?></td>
    <td width="67%" class="textonegrita" align="center">&nbsp;
    <? $sql="SELECT nombre_instit FROM institucion WHERE rdb=".$institucion;
		$rs_instit = pg_exec($conn,$sql);
		echo pg_result($rs_instit,0);
	?>
    </td>
    <td width="13%" class="textosimple">A&ntilde;o Escolar </td>
    <td width="10%">&nbsp;</td>
  </tr>
  <tr>
    <td valign="baseline">&nbsp;
    <hr color="#000000" /></td>
    <td class="textosimple">N&ordm; Matricula </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="textonegrita"><div align="center">FICHA DE MATRICULA </div></td>
    <td class="textosimple">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td valign="top"><hr color="#000000" /></td>
    <td class="textosimple">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<br />
<table width="650" border="1" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
<tr>
    <td colspan="7" valign="top" bgcolor="#CCCCCC" class="textonegrita"><p>&nbsp;I.- DATOS DEL ESTUDIANTE</p></td>
  </tr>
</table>
<br />
<table width="650" border="1" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
  
  <tr>
    <td width="95" valign="top" class="textosimple" bgcolor="#CCCCCC">&nbsp;NOMBRE</td>
    <td colspan="2" valign="top"><span class="textosimple">
      <?=$fila['nombre_alu'];?>
    </span></td>
    <td width="88" valign="top" bgcolor="#CCCCCC"><span class="textosimple">CURSO</span></td>
    <td valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td width="95" valign="top" bgcolor="#CCCCCC"  class="textosimple">&nbsp;RUT</td>
    <td valign="top"><span class="textosimple">
      <?=$fila['rut_alumno']."-".$fila['dig_rut'];?>
    </span></td>
    <td  valign="top" bgcolor="#CCCCCC"  class="textosimple">F.NAC</td>
    <td colspan="2"  valign="top" class="textosimple">&nbsp;</td>
  </tr>
  <tr>
    <td width="95" valign="top" bgcolor="#CCCCCC" class="textosimple">&nbsp;DOMICILIO</td>
    <td colspan="6" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td width="95" valign="top" bgcolor="#CCCCCC" class="textosimple">&nbsp;COMUNA</td>
    <td width="222"  valign="top">&nbsp;</td>
    <td width="85" valign="top" bgcolor="#CCCCCC" class="textosimple">COLEGIO PROCEDENCIA</td>
    <td colspan="2" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top" bgcolor="#CCCCCC" class="textosimple">&nbsp;CURSOS REPETIDOS</td>
    <td colspan="4"  valign="top">&nbsp;</td>
  </tr>
</table>
<br />
<table width="650" border="1" align="center" cellpadding="1" cellspacing="0" style="border-collapse:collapse" >
        <tr>
          <td width="232" align="left" bgcolor="#CCCCCC" class="textonegrita" >&nbsp;RELIGION</td>
          <td colspan="3" align="left"  class="textonegrita" >&nbsp;</td>
        </tr>
        <tr>
          <td align="left" bgcolor="#CCCCCC" class="textosimple">&nbsp;SACRAMENTOS RECIBIDOS</td>
          <td align="left" valign="top" class="textosimple" >Bautismo</td>
          <td align="left" valign="top" class="textosimple">Primera Comuni&oacute;n</td>
          <td align="left" valign="top" class="textosimple" >Confirmaci&oacute;n</td>
  </tr>
</table>
<br />
<table width="650" border="1" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
<tr>
    <td colspan="7" valign="top" bgcolor="#CCCCCC" class="textonegrita"><p>&nbsp;II.- DATOS FAMILIARES</p></td>
  </tr>
</table>
<br />
      <table width="650" border="1" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse" class="textosimple">
       
        <tr>
          <td valign="top" class="textosimple" bgcolor="#CCCCCC">&nbsp;NOMBRE PADRE</td>
          <td colspan="3"  valign="top">&nbsp;</td>
          <td width="88"  valign="top" bgcolor="#CCCCCC">RUT</td>
          <td width="133"  valign="top">&nbsp;</td>
        </tr>
        <tr>
          <td width="94" valign="top" bgcolor="#CCCCCC" class="textosimple">&nbsp;F. NAC</td>
          <td width="126"  valign="top">&nbsp;</td>
          <td width="102"  valign="top" bgcolor="#CCCCCC">CELULAR</td>
          <td width="93"  valign="top">&nbsp;</td>
          <td  valign="top" bgcolor="#CCCCCC">TEL.FIJO</td>
          <td  valign="top">&nbsp;</td>
        </tr>
        <tr>
          <td  valign="top" bgcolor="#CCCCCC" class="textosimple">&nbsp;PREVISION</td>
          <td colspan="5" valign="top">&nbsp;</td>
        </tr>
        <tr>
          <td  valign="top" bgcolor="#CCCCCC" class="textosimple">&nbsp;ESTUDIOS</td>
          <td colspan="2" valign="top">&nbsp;</td>
          <td valign="top" bgcolor="#CCCCCC">OCUPACI&Oacute;N</td>
          <td colspan="2" valign="top">&nbsp;</td>
        </tr>
        <tr>
          <td  valign="top" bgcolor="#CCCCCC" class="textosimple">&nbsp;MAIL</td>
          <td colspan="5" valign="top">&nbsp;</td>
        </tr>
      </table>
<BR />
<table width="650" border="1" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse" class="textosimple">
       
        <tr>
          <td valign="top" class="textosimple" bgcolor="#CCCCCC">&nbsp;NOMBRE MADRE</td>
          <td colspan="3"  valign="top">&nbsp;</td>
          <td width="88"  valign="top" bgcolor="#CCCCCC">RUT</td>
          <td width="133"  valign="top">&nbsp;</td>
        </tr>
        <tr>
          <td width="94" valign="top" bgcolor="#CCCCCC" class="textosimple">&nbsp;F. NAC</td>
          <td width="126"  valign="top">&nbsp;</td>
          <td width="102"  valign="top" bgcolor="#CCCCCC">CELULAR</td>
          <td width="93"  valign="top">&nbsp;</td>
          <td  valign="top" bgcolor="#CCCCCC">TEL.FIJO</td>
          <td  valign="top">&nbsp;</td>
        </tr>
        <tr>
          <td  valign="top" bgcolor="#CCCCCC" class="textosimple">&nbsp;PREVISION</td>
          <td colspan="5" valign="top">&nbsp;</td>
        </tr>
        <tr>
          <td  valign="top" bgcolor="#CCCCCC" class="textosimple">&nbsp;ESTUDIOS</td>
          <td colspan="2" valign="top">&nbsp;</td>
          <td valign="top" bgcolor="#CCCCCC">OCUPACI&Oacute;N</td>
          <td colspan="2" valign="top">&nbsp;</td>
        </tr>
        <tr>
          <td  valign="top" bgcolor="#CCCCCC" class="textosimple">&nbsp;MAIL</td>
          <td colspan="5" valign="top">&nbsp;</td>
        </tr>
      </table>
</p>
<br />
<table width="650" border="1" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
       
        <tr>
          <td valign="top" class="textosimple" bgcolor="#CCCCCC">&nbsp;NRO DE HERMANOS EN EL COLEGIO</td>
          <td width="290"  valign="top">&nbsp;</td>
          <td width="84"  valign="top" bgcolor="#CCCCCC">CURSOS</td>
          <td width="117"  valign="top">&nbsp;</td>
        </tr>
        <tr>
          <td width="149" valign="top" bgcolor="#CCCCCC" class="textosimple">&nbsp;EL ESTUDIANTE VIVE CON</td>
          <td colspan="3"  valign="top">&nbsp;</td>
        </tr>
        <tr>
          <td  valign="top" bgcolor="#CCCCCC" class="textosimple">&nbsp;PREVISION ESTUDIANTE</td>
          <td colspan="3" valign="top">&nbsp;</td>
        </tr>
      </table>
<br />
<table width="650" border="1" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
<tr>
    <td colspan="7" valign="top" bgcolor="#CCCCCC" class="textonegrita"><p>&nbsp;INDIQUE SI PARTICIPA DE UN BENEFICIO DE UN PROGRAMA DE GOBIERNO</p></td>
  </tr>
</table>
<br />
<table width="650" border="1" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse" class="textosimple">
  <tr>
         <td width="148" height="32" valign="top">CHILE SOLIDARIO</td>
         <td width="29" valign="top">&nbsp;</td>
         <td width="214" valign="top">PUENTE</td>
         <td width="28" valign="top">&nbsp;</td>
         <td width="186" valign="top">PRIORITARIO</td>
         <td width="31" valign="top">&nbsp;</td>
       </tr>
  <tr>
    <td height="32" valign="top">SUBSIDIO &Uacute;NICO FAMILIAR</td>
    <td valign="top">&nbsp;</td>
    <td valign="top">ASCENDENCIA IND&Iacute;GENA</td>
    <td valign="top">&nbsp;</td>
    <td valign="top">JUNAEB</td>
    <td valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td height="32" valign="top">OTROS</td>
    <td colspan="5" valign="top">&nbsp;</td>
  </tr>
</table>
<br />
 <H1 class="SaltoDePagina"></H1>
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="10%" rowspan="4"><?
						if($institucion!=""){
							echo "<img src='../../../../tmp/".$institucion."insignia". "' >";
						}else{
						   echo "<img src='".$d."menu/imag/logo.gif' >";
						}	?></td>
    <td width="67%" class="textonegrita" align="center">&nbsp;
    <? $sql="SELECT nombre_instit FROM institucion WHERE rdb=".$institucion;
		$rs_instit = pg_exec($conn,$sql);
		echo pg_result($rs_instit,0);
	?>
    </td>
    <td width="13%" class="textosimple">A&ntilde;o Escolar </td>
    <td width="10%">&nbsp;</td>
  </tr>
  <tr>
    <td valign="baseline">&nbsp;
    <hr color="#000000" /></td>
    <td class="textosimple">N&ordm; Matricula </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="textonegrita"><div align="center">FICHA DE MATRICULA </div></td>
    <td class="textosimple">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td valign="top"><hr color="#000000" /></td>
    <td class="textosimple">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<br />
<table width="650" border="1" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
<tr>
    <td colspan="7" valign="top" bgcolor="#CCCCCC" class="textonegrita"><p>III.- ANTECEDENTES DE SALUD</p></td>
  </tr>
</table><br />
<table width="650" align="center" border="0" cellpadding="0" cellspacing="0">
<tr>
  <td>
<table width="382" border="1" cellpadding="0" cellspacing="0" style="border-collapse:collapse" class="textosimple">
  <tr>
         <td width="225" height="32" valign="top">PROBLEMAS DE VISI&Oacute;N</td>
         <td width="38" align="center" valign="top">&nbsp;</td>
         <td width="33" align="center" valign="top">SI</td>
         <td width="38" align="center" valign="top">&nbsp;</td>
         <td width="42" align="center" valign="top">NO</td>
       </tr>
  <tr>
    <td height="32" valign="top">PROBLEMAS DE AUDICI&Oacute;N</td>
    <td align="center" valign="top">&nbsp;</td>
    <td align="center" valign="top">SI</td>
    <td align="center" valign="top">&nbsp;</td>
    <td align="center" valign="top">NO</td>
  </tr>
  <tr>
    <td height="32" valign="top">PROBLEMAS DE COLUMNA</td>
    <td align="center" valign="top">&nbsp;</td>
    <td align="center" valign="top">SI</td>
    <td align="center" valign="top">&nbsp;</td>
    <td align="center" valign="top">NO</td>
  </tr>
  <tr>
    <td height="32" valign="top">PROBLEMAS DENTALES</td>
    <td align="center" valign="top">&nbsp;</td>
    <td align="center" valign="top">SI</td>
    <td align="center" valign="top">&nbsp;</td>
    <td align="center" valign="top">NO</td>
  </tr>
</table>
</td></tr></table>
<BR />
<table width="650" border="1" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
  <tr>
    <td width="562" colspan="6" valign="top" bgcolor="#CCCCCC" class="textonegrita">TRATAMIENTOS QUE HA TENIDO EL ESTUDIANTE (A&Ntilde;OS)</td>
  </tr>
  <tr class="textosimple">
    <td width="562" valign="top">GRUPO DIFERENCIAL</td>
    <td width="94" valign="top">&nbsp;</td>
    <td width="95" valign="top">NEUR&Oacute;LOGO</td>
    <td width="85" valign="top">&nbsp;</td>
    <td width="217" valign="top">PSIC&Oacute;LOGO</td>
    <td width="217" valign="top">&nbsp;</td>
  </tr>
  <tr class="textosimple">
    <td valign="top">FONOAUDI&Oacute;LOGO</td>
    <td valign="top">&nbsp;</td>
    <td valign="top">PSIQUI&Aacute;TRICO</td>
    <td valign="top">&nbsp;</td>
    <td valign="top">OTROS</td>
    <td valign="top">&nbsp;</td>
  </tr>
</table><br />
<table width="650" border="1" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
  <tr>
    <td width="562" valign="top" bgcolor="#CCCCCC" class="textonegrita">INDIQUE SI SU HIJO(A) HA TENIDO O SUFRE DEL ALGUNA ENFERMEDAD CR&Oacute;NICA</td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
  </tr>
</table>
<br />
<table width="650" border="1" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
<tr>
    <td colspan="7" valign="top" bgcolor="#CCCCCC" class="textonegrita"><p>IV.- DATOS DEL APODERADO</p></td>
  </tr>
</table>
<br />
<table width="650" border="1" align="center" cellpadding="1" cellspacing="0"  class="textosimple">
  
  <tr>
    <td width="101" bgcolor="#CCCCCC" class="textosimple">NOMBRE APODERADO</td>
    <td colspan="3" class="textosimple">&nbsp;</td>
    <td width="108" bgcolor="#CCCCCC" class="textosimple">RUT</td>
    <td width="81" class="textosimple">&nbsp;</td>
  
  </tr>
  <tr>
    <td bgcolor="#CCCCCC" class="textosimple">DIRECCI&Oacute;N</td>
    <td colspan="5" class="textosimple">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#CCCCCC" class="textosimple">PARENTESCO</td>
    <td width="143" class="textosimple">&nbsp;</td>
    <td width="86" bgcolor="#CCCCCC" class="textosimple">CELULAR</td>
    <td width="105" class="textosimple">&nbsp;</td>
    <td bgcolor="#CCCCCC" class="textosimple">TEL.FIJO</td>
    <td class="textosimple">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#CCCCCC" class="textosimple">MAIL</td>
    <td colspan="5" class="textosimple">&nbsp;</td>
  </tr>
</table><br />
<table width="650" border="1" align="center" cellpadding="1" cellspacing="0"  class="textosimple">
  
  <tr>
    <td width="101" bgcolor="#CCCCCC" class="textosimple">NOMBRE APOD. SUPLENTE</td>
    <td colspan="3" class="textosimple">&nbsp;</td>
    <td width="108" bgcolor="#CCCCCC" class="textosimple">RUT</td>
    <td width="81" class="textosimple">&nbsp;</td>
  
  </tr>
  <tr>
    <td bgcolor="#CCCCCC" class="textosimple">DIRECCI&Oacute;N</td>
    <td colspan="5" class="textosimple">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#CCCCCC" class="textosimple">PARENTESCO</td>
    <td width="143" class="textosimple">&nbsp;</td>
    <td width="86" bgcolor="#CCCCCC" class="textosimple">CELULAR</td>
    <td width="105" class="textosimple">&nbsp;</td>
    <td bgcolor="#CCCCCC" class="textosimple">TEL.FIJO</td>
    <td class="textosimple">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#CCCCCC" class="textosimple">MAIL</td>
    <td colspan="5" class="textosimple">&nbsp;</td>
  </tr>
</table>
<br />
<table width="650" border="1" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
<tr>
    <td colspan="7" valign="top" bgcolor="#CCCCCC" class="textonegrita"><p>V.- EN CASO DE EMERGENCIA INDIQUE A QUIEN DIRIGIRNOS</p></td>
  </tr>
</table>
<br />
<table width="650" border="1" align="center" cellpadding="1" cellspacing="0" style="border-collapse:collapse" class="textosimple">
  
  <tr>
    <td width="102" class="textosimple">NOMBRE </td>
    <td width="273" class="textosimple">&nbsp;</td>
    <td width="109" class="textosimple">PARENTESCO</td>
    <td width="148" class="textosimple">&nbsp;</td>
  
  </tr>
  <tr>
    <td class="textosimple">TEL&Eacute;FONO RED FIJA</td>
    <td class="textosimple">&nbsp;</td>
    <td class="textosimple">CELULAR</td>
    <td class="textosimple">&nbsp;</td>
  </tr>
</table>
<br />
 <H1 class="SaltoDePagina"></H1>
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="10%" rowspan="4"><?
						if($institucion!=""){
							echo "<img src='../../../../tmp/".$institucion."insignia". "' >";
						}else{
						   echo "<img src='".$d."menu/imag/logo.gif' >";
						}	?></td>
    <td width="67%" class="textonegrita" align="center">&nbsp;
    <? $sql="SELECT nombre_instit FROM institucion WHERE rdb=".$institucion;
		$rs_instit = pg_exec($conn,$sql);
		echo pg_result($rs_instit,0);
	?>
    </td>
    <td width="13%" class="textosimple">A&ntilde;o Escolar </td>
    <td width="10%">&nbsp;</td>
  </tr>
  <tr>
    <td valign="baseline">&nbsp;
    <hr color="#000000" /></td>
    <td class="textosimple">N&ordm; Matricula </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="textonegrita"><div align="center">FICHA DE MATRICULA </div></td>
    <td class="textosimple">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td valign="top"><hr color="#000000" /></td>
    <td class="textosimple">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table><br />

<table width="650" border="1" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
<tr>
    <td colspan="7" valign="top" bgcolor="#CCCCCC" class="textonegrita"><p>VI.- ACTIVIDADES PROGRAMADAS QUE NECESITAN AUTORIZACI&Oacute;N MEDIANTE LA FIRMA DEL APODERADO</p></td>
  </tr>
  <tr>
    <td colspan="3" class="textosimple">Salidas a Parroquia para las actividades de car&aacute;cter pastoral: Misas, Celebraciones lit&uacute;rgicas, etc</td>
    <td width="339" class="textosimple">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" class="textosimple"><p>Actividades deportivas fuera del establecimiento</p>
    <p>&nbsp;</p></td>
    <td class="textosimple">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" class="textosimple">Estudiantes JEX; 3&deg; a 6&deg; B&aacute;sico, salir a almorzar fuera del establecimiento: al hogar, a menos de 1&deg; cuadras del establecimiento y regresar a tiempo para el inicio de la jornada de la tarde</td>
    <td class="textosimple">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="7" valign="top" bgcolor="#CCCCCC" class="textonegrita"><p>VII.- PROGRAMA DE SALUD ESCOLAR, AUTORIZACI&Oacute;N MEDIANTE LA FIRMA DEL APODERADO</p></td>
  </tr>
  <tr>
    <td colspan="3" class="textosimple">Programa de vacunaci&oacute;n del Ministerio de Salud de acuerdo a la edad y nivel que le corresponde</td>
    <td class="textosimple">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" class="textosimple"><p>Control de ni&ntilde;o sano, que realiza el Ministerio de Salud</p>
    <p>&nbsp;</p></td>
    <td class="textosimple">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" class="textosimple"><p>Prevenci&oacute;n dental a cargo de SAMU</p>
    <p>&nbsp;</p></td>
    <td class="textosimple">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="7" valign="top" bgcolor="#CCCCCC" class="textonegrita"><p>VIII.- RETIRO DEL ESTUDIANTE EN CASO DE EMERGENCIA: TERREMOTO/INCENDIO, ETC.</p></td>
  </tr>
  <tr>
    <td colspan="3" class="textosimple">INDICAR PERSONAS AUTORIZADAS PARA RETIRAR A ALUMNO(A) DEL ESTABLECIMIENTO</td>
    <td class="textosimple">INDICAR PARENTESCO / RELACI&Oacute;N CON ALUMNO(A)</td>
  </tr>
  <tr>
    <td width="5%" class="textosimple">1</td>
    <td colspan="2" class="textosimple">&nbsp;</td>
    <td class="textosimple">&nbsp;</td>
  </tr>
  <tr>
    <td class="textosimple">2</td>
    <td colspan="2" class="textosimple">&nbsp;</td>
    <td class="textosimple">&nbsp;</td>
  </tr>
  <tr>
    <td class="textosimple">3</td>
    <td colspan="2" class="textosimple">&nbsp;</td>
    <td class="textosimple">&nbsp;</td>
  </tr>
</table>
<br />


<table width="650" border="0" align="center" cellpadding="0" cellspacing="0" class="tabla04">
  <tr>
    <td align="center"><div align="center">______________________________</div></td>
  </tr>
  <tr>
    <td align="center"><div align="center">FIRMA APODERADO </div></td>
  </tr>
</table>
<br />
<br />
<?php if(pg_numrows($result_home)>1){?>
<H1 class="SaltoDePagina"></H1>
<? }
} //fin for
 } //fin if hay alumnos?></td>  
</body>
</html>
