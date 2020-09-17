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
	$_POSP = 5;
	$_bot = 8;
	
	//-------------- INSTITUCION -------------------------------------------------------------
	$sql_ins = "SELECT institucion.nombre_instit, institucion.calle, institucion.nro, region.nom_reg, provincia.nom_pro, comuna.nom_com, institucion.telefono ";
	$sql_ins = $sql_ins . "FROM ((institucion INNER JOIN region ON institucion.region = region.cod_reg) INNER JOIN provincia ON (institucion.ciudad = provincia.cor_pro) AND (institucion.region = provincia.cod_reg)) INNER JOIN comuna ON (institucion.region = comuna.cod_reg) AND (institucion.ciudad = comuna.cor_pro) AND (institucion.comuna = comuna.cor_com) ";
	$sql_ins = $sql_ins . "WHERE (((institucion.rdb)=".$institucion.")); ";
	$result_ins =@pg_Exec($conn,$sql_ins);
	$fila_ins = @pg_fetch_array($result_ins,0);	
	$ins_pal = $fila_ins['nombre_instit'];
	$direccion = $fila_ins['calle'] . " " . $fila_ins['nro'] . " " . $fila_ins['nom_com'];
	$telefono = $fila_ins['telefono'];	
	//----------
	$sql_ano = "select * from ano_escolar where id_ano = ".$ano;
	$result_ano =@pg_Exec($conn,$sql_ano);
	$fila_ano = @pg_fetch_array($result_ano,0);	
	$ano_escolar = $fila_ano['nro_ano'];
	//----------
	$curso			=$cmb_curso;
	$fechaini		= $fecha1;
	$fechafin		= $fecha2;	
	$dia1			=substr($fechaini,0,2);
	$mes1			=substr($fechaini,3,2);
	$ano1			=$ano_escolar;
	$dia2			=substr($fechafin,0,2);
	$mes2			=substr($fechafin,3,2);
	$ano2			=$ano_escolar;	
	//if (empty($curso)) exit;
	if (!checkdate($mes1,$dia1,$ano1)) 
	{
		//echo "FECHA INICIO INVALIDA <br>";
		//exit;
	}	
	if (!checkdate($mes2,$dia2,$ano2)) 
	{
		//echo "FECHA FINAL INVALIDA <br>"; 
		//exit;
	}
	$fecha1			= mktime(0,0,0,$mes1,$dia1,$ano1);
	$fecha2			= mktime(0,0,0,$mes2,$dia2,$ano2);
	$fecha_1		= $mes1."-".$dia1."-".$ano1;
	$fecha_2		= $mes2."-".$dia2."-".$ano2;

	
	//if (empty($curso)) exit;
	//-----------------------------------------
	// Institución
	//-----------------------------------------
	$sql_insti = "Select * from institucion where rdb = " . $institucion;
	$result_insti =@pg_Exec($conn,$sql_insti);
	$fila_insti = @pg_fetch_array($result_insti,0);	
	$nombre_insti = $fila_insti['nombre_instit'];
	//-----------------------------------------
	// Curso
	//-----------------------------------------
	$Curso_pal = CursoPalabra($curso, 0, $conn);
	//--------------------------------------------
	$sql_profe = "SELECT empleado.ape_pat, empleado.ape_mat, empleado.nombre_emp ";
	$sql_profe = $sql_profe . "FROM supervisa INNER JOIN empleado ON supervisa.rut_emp = empleado.rut_emp ";
	$sql_profe = $sql_profe . "WHERE (((supervisa.id_curso)=".$curso.")); ";
	$result_profe =@pg_Exec($conn,$sql_profe);
	$fila_profe = @pg_fetch_array($result_profe,0);	
	$profe_jefe = ucwords(strtoupper(trim($fila_profe['ape_pat']) . " " . trim($fila_profe['ape_mat'] ) . " " . trim($fila_profe['nombre_emp'])));
	//-----------------------------------------
	// Alumnos
	//-----------------------------------------
	$sql = "SELECT alumno.rut_alumno, alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu ";
	$sql = $sql . "FROM matricula INNER JOIN alumno ON matricula.rut_alumno = alumno.rut_alumno ";
	$sql = $sql . "WHERE (((matricula.id_curso)=".$curso.")) ";
	$sql = $sql . "ORDER BY alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu; ";
	$result_alumno = @pg_Exec($conn,$sql);
	//-----------------------------------------
	// Alumnos
	//-----------------------------------------
	$sql_habiles = "select sum(dias_habiles) as dias_habiles from periodo where id_ano = ".$ano;
	$result_habiles =@pg_Exec($conn,$sql_habiles);
	$fila_habiles = @pg_fetch_array($result_habiles,0);	
	$dias_habiles = $fila_habiles['dias_habiles'];
	$sw = 0;
	if ($dias_habiles > 0) $sw = 1;
	if ($sw = 0)
	{
		echo "DEBE INGRESAR LOS DIAS HABILES EN EL SECTOR DE PERIODOS";
		exit;
	}
	//-----------------------------------------
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../../estilos.css" rel="stylesheet" type="text/css">
<link href="../../../Colegio_restore/css/objeto.css" rel="stylesheet" type="text/css">
<link href="../../../Colegio_restore/Reportes/css/objeto.css" rel="stylesheet" type="text/css">
<link href="../../../util/objeto.css" rel="stylesheet" type="text/css">
<link href="../../../../../util/objeto.css" rel="stylesheet" type="text/css">
<link href="../css/objeto.css" rel="stylesheet" type="text/css">

<script language="JavaScript" type="text/JavaScript">
<!--
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
//-->
</script>
<script> 
function cerrar(){ 
window.close() 
} 
</script>
<STYLE>
 H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always
 }
 
</style>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../cortes/b_ayuda_r.jpg','../../../../../cortes/b_info_r.jpg','../../../../../cortes/b_mapa_r.jpg','../../../../../cortes/b_home_r.jpg','<? echo $c; ?>botones/periodo_roll.gif','<? echo $c; ?>botones/feriados_roll.gif','<? echo $c; ?>botones/planes_roll.gif','<? echo $c; ?>botones/tipos_roll.gif','<? echo $c; ?>botones/cursos_roll.gif','<? echo $c; ?>botones/matricula_roll.gif','<? echo $c; ?>botones/informe_roll.gif','<? echo $c; ?>botones/reportes_roll.gif','<? echo $c; ?>botones/actas_roll.gif','<? echo $c; ?>botones/generar_roll.gif')">
<!-- INICIO CUERPO DE LA PAGINA -->
<?
if (empty($curso)){
   // exit;
}else{
   

?>

<form action="" method="get">
 <table>
    <tr>
	  <td align="left"><input name="button4" type="button" class="botonX" onClick="cerrar()"  onMouseOver=this.style.background='FFFFD7';this.style.color='003b85' onMouseOut=this.style.background='#5c6fa9';this.style.color='ffffff' value="CERRAR">
	  </td>
	</tr>
  </table>
  
<center>
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
	<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
	<div align="right">
	<div id="capa0">
      <input name="button3" type="button" class="botonX" onClick="imprimir();" onMouseOver=this.style.background='FFFFD7';this.style.color='003b85' onMouseOut=this.style.background='#5c6fa9';this.style.color='ffffff' value="IMPRIMIR">
	 </div>
    </div></td>
  </tr>
</table>
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="487"><font face="Verdana, Arial, Helvetica, sans-serif" size="-1"><? echo ucwords(strtolower($direccion));?></font><font face="Verdana, Arial, Helvetica, sans-serif" size="+1">&nbsp;</font></td>
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
            <td width="125" align="center">

							<img src=../../../../../../../tmp/<? echo $institucion ?> ALT="NO DISPONIBLE" height="100"></td>
			 </tr>
             </table>
			<? } ?>
	</td>
  </tr>
  <tr>
    <td><font face="Verdana, Arial, Helvetica, sans-serif" size="-1"><? echo ucwords(strtolower($telefono));?></font></td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td height="41">&nbsp;</td>
    <td>&nbsp;</td>
    </tr>  
</table>
	<table width="650" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>
		<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td  align="center" class="tableindex">INFORME DE ATRASOS E INASISTENCIAS</td>
  </tr>
  <tr>
    <td align="center"><font size="2" face="arial, geneva, helvetica">Del <? echo (strtolower(strftime("%A, %d de %B de %Y",mktime(0,0,0,$mes1,$dia1,$ano1)))) ?> al <? echo (strtolower(strftime("%A, %d de %B de %Y",mktime(0,0,0,$mes2,$dia2,$ano2)))) ?></font></td>
  </tr>
</table>
<br>
		<table width="650" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="126"><font face="Verdana, Arial, Helvetica, sans-serif" size="-1"><strong>Curso</strong></font><strong></strong></td>
            <td width="10" ><div align="left"><strong><font size="2" face="arial, geneva, helvetica">:</font></strong></div></td>
            <td width="514" ><font size="2" face="arial, geneva, helvetica"><? echo $Curso_pal; ?></font></td>
          </tr>
          <tr>
            <td><font face="Verdana, Arial, Helvetica, sans-serif" size="-1"><strong>Profesor(a) Jefe</strong></font></td>
            <td ><div align="left"><strong><font size="2" face="arial, geneva, helvetica">:</font></strong></div></td>
            <td ><font size="2" face="arial, geneva, helvetica"><? echo $profe_jefe; ?></font></td>
          </tr>
        </table>
		<br>
		<table width="650" border="1" cellspacing="0" cellpadding="0">
  		  <tr>
			<td width="18" class="tablatit2-1"><div align="center">Nº</div></td>
			<td width="277" class="tablatit2-1"><div align="center">Nombre del Alumno</div></td>
			<td width="114" class="tablatit2-1"><div align="center">Atrasos</div></td>
			<td width="114" class="tablatit2-1"><div align="center">Ausencias</div></td>
			<td width="115" class="tablatit2-1"><div align="center">Porcentaje Asistencia </div></td>
    	 </tr>
	<?	
	for($i=0 ; $i < @pg_numrows($result_alumno) ; $i++)
  	{
	  $fila = @pg_fetch_array($result_alumno,$i);
	  $nombre_alu = ucwords(strtolower(trim($fila['ape_pat']) . " " . trim($fila['ape_mat']) . " " . trim($fila['nombre_alu'])));
	  $rut_alumno = $fila['rut_alumno'];
	  ?>
	<tr>
    <td height="21" align="center">	<font size="1" face="arial, geneva, helvetica"><? echo $i+1;?></font></td>
    <td>							<font size="1" face="arial, geneva, helvetica"><? echo $nombre_alu;?></font></td>
    <td><div align="center">		<font size="1" face="arial, geneva, helvetica">
	<?
	$sql_atraso = "select count(*) as cantidad from anotacion where tipo = 2 and rut_alumno = ".$rut_alumno." and (fecha >='".$fecha_1."' and fecha <='".$fecha_2."')";
	$result_atraso =@pg_Exec($conn,$sql_atraso);
	$fila_atraso = @pg_fetch_array($result_atraso,0);	
	echo $fila_atraso['cantidad'];
	$atrasos = $atrasos + $fila_atraso['cantidad'];
	?>
	</font></div></td>
        <td><div align="center"><font size="1" face="arial, geneva, helvetica">
	<?
	$sql_asis = "select count(*) as cantidad from asistencia where ano = ".$ano." and rut_alumno = ".$rut_alumno." and (fecha >='".$fecha_1."' and fecha <='".$fecha_2."')";
	$result_asis =@pg_Exec($conn,$sql_asis);
	$fila_asis = @pg_fetch_array($result_asis,0);
	$dias_ausente = $fila_asis['cantidad'];
	echo $fila_asis['cantidad'];
	$asistencias = $asistencias + $fila_asis['cantidad'];
	?>
	</font></div></td>
    <td><div align="center"><font size="1" face="arial, geneva, helvetica">
	<?
	if ($dias_habiles>0)
	{
		$dias_asistidos = $dias_habiles - $dias_ausente;
		$procentaje = round(($dias_asistidos * 100)/$dias_habiles,2);
		echo $procentaje."%";
		$porcentaje_asis = $porcentaje_asis + $procentaje;
	}
	else
		echo "0%";
	{
	
	}

	?>
	</font></div></td>
  </tr>
    <? }$i=$i+1;?>
	<tr>
	  <td height="21" align="center" colspan="5">&nbsp;</td>
	  </tr>
	<tr>
	  <td colspan="2" align="left"><font size="2" face="arial, geneva, helvetica"><strong>Totales</strong></font></td>
	  <td align="center"><font size="1" face="arial, geneva, helvetica"><? echo $atrasos;?></font></td>
	  <td align="center"><font size="1" face="arial, geneva, helvetica"><? echo $asistencias;?></font></td>
	  <td align="center"><font size="1" face="arial, geneva, helvetica"><? echo round($porcentaje_asis/$i,2)."%";?></font></td>
	  </tr>	  
</table>		</td>
      </tr>
    </table></td>
  </tr>
</table>
<br>
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><HR width="100%" color=#003b85></td>
  </tr>
</table>
<table width="650" height="119" border="0" cellpadding="0" cellspacing="0">
  <tr>
	<td height="27"><div align="left"><font size="2"><strong><font face="Arial, Helvetica, sans-serif">Observaciones:_______________________________________________________________<font size="2"><strong>__________<font size="2"><strong>_____</strong></font></strong></font></font></strong></font></div></td>
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
</form>
<?
}
?>
<!-- FIN CUERPO DE LA PAGINA -->
</body>
</html>
