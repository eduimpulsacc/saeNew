<?php
require('../../../../util/header.inc');
require('../../../../util/LlenarCombo.php3');
require('../../../../util/SeleccionaCombo.inc');
include('../../../clases/class_Reporte.php');
include('../../../clases/class_Membrete.php');

$_POSP = 4;
$_bot = 8;

//setlocale("LC_ALL","es_ES");
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso          =$cmb_curso;
	$reporte		=$c_reporte;

	//if ($periodo==0)
		// exit;
	
	$ob_reporte = new Reporte();
	$ob_membrete = new Membrete();
	
	$ob_membrete ->institucion = $institucion;
	$ob_membrete ->institucion($conn);
	
	$ob_membrete ->ano = $ano;
	$ob_membrete ->AnoEscolar($conn);
	


  //-------------------------	 CONFIGURACION DE REPORTE ------------------
	$ob_config = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=$curso;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = @pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);

	
$horas_semanales = 0;
for ($dia=0; $dia < 7; $dia++){	
	/// calculo cuantos horas tiene el alumno a la semana y luego en el mes
	$qry_horario = "SELECT a.id_horario,to_char(a.horaini,'HH24:MI') || CAST ('-' AS CHARACTER) || to_char(a.horafin,'HH24:MI') AS hora, trim(c.nombre) AS nombre FROM horario a, ramo b, subsector c WHERE a.id_ramo=b.id_ramo AND b.cod_subsector=c.cod_subsector AND a.id_curso=" . $curso . " AND a.dia=" . $dia . " union (SELECT a.id_horario,to_char(a.horaini,'HH24:MI') || CAST ('-' AS CHARACTER) || to_char(a.horafin,'HH24:MI') AS hora, trim(c.nombre_taller) AS nombre FROM horario a, taller c WHERE a.id_taller=c.id_taller AND c.rdb=" . $institucion ." AND a.dia=" . $dia . "AND a.id_curso=" . $curso . ") order by hora";
	$res_horario = @pg_exec($conn,$qry_horario);
	$num_horario = @pg_numrows($res_horario);
    $horas_semanales = $horas_semanales + $num_horario;
}
$total_horas_mes = $horas_semanales * 4;

///////////////////////////////////////////////////////////////////////// 	
		 	  	   	   				 		 	  	   		
if(!$cb_ok =="Buscar"){
		$Fecha= date("d-m-Y_h:i");
		header('Content-type: application/vnd.ms-excel');
		header("Content-Disposition:inline; filename=Informe_Asistencia_Por_Horas_$Fecha.xls"); 
	}	
?>		
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<script>
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
</script>

<SCRIPT language="JavaScript">
			function exportar(){
					//form.target="_blank";
					window.location='printInformeAsistenciaporhoras_C.php?cmb_curso=<?=$curso?>&c_reporte=<?=$reporte?>';
					//document.form.submit(true);
				return false;
			}
			function enviapag(form){
			if (form.cmb_curso.value!=0){
				form.cmb_curso.target="self";
				form.action = 'InformeAsistenciaporhoras.php?institucion=$institucion';
				form.submit(true);
	
				}	
			}
			function MM_goToURL() { //v3.0
			  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
			  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
			}
									
</script>
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

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
<script> 
function cerrar(){ 
window.close() 
} 
</script>
</head>
<STYLE>
 H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always
 }
 .titulo
 {
 font-family:<?=$ob_config->letraT;?>;
 font-size:<?=$ob_config->tamanoT;?>px;
 }
 .item
 {
 font-family:<?=$ob_config->letraI;?>;
 font-size:<?=$ob_config->tamanoI;?>px;

 }
 .subitem
 {
 font-family:<?=$ob_config->letraS;?>;
 font-size:<?=$ob_config->tamanoS;?>px;
 }
</style>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">

<!-- INICIO CUERPO DE LA PAGINA -->

<STYLE>
 H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always
 }
 
</style>
<center>

<?

	if ($curso == 0)
	{
		//$sql_curso = "select * from curso where id_ano= ".$ano ." order by ensenanza, grado_curso, letra_curso";
		//$result_curso = @pg_Exec($conn, $sql_curso);
	}
	else
	{
		$sql_curso = "select * from curso where id_curso = ".$curso;
		$result_curso = @pg_Exec($conn, $sql_curso);
	}
	
	$cantidad_cursos = @pg_numrows($result_curso);
	for($i=0 ; $i < @pg_numrows($result_curso) ; $i++)
	{
		$fila_curso = @pg_fetch_array($result_curso,$i);
		$curso = $fila_curso['id_curso'];
		$Curso_pal = CursoPalabra($curso, 0, $conn);
		//----------------------------------------------------
		// DATOS PROFESOR JEFE
		//----------------------------------------------------
		$ob_reporte ->curso = $curso;
		$ob_reporte ->ProfeJefe($conn);

?>
<div id="capa0">
<table width="650" align="center">
  <tr><td><input name="button4" type="button" class="botonXX" onClick="cerrar()"   value="CERRAR"></td><td align="right">
          <input name="button3" TYPE="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR">
  </td>
  <? if($_PERFIL == 0){?>
    <td align="right"><input name="button5" TYPE="button" class="botonXX" onClick="javascript:exportar()"  value="EXPORTAR"></td>
  <? }?>
  </tr>
</table>
</div>
<br>


<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="487"><font face="Verdana, Verdana, Arial, Helvetica, sans-serif" size="1"><strong><? echo ucwords(strtoupper($ob_membrete->ins_pal));?></strong></font></td>
    <td width="11">&nbsp;</td>
    <td width="152" rowspan="4" align="center">
      <table width="125" border="0" cellpadding="0" cellspacing="0">
        <tr valign="top">
          <td width="125" align="center"> 
		  	<?
	  if($institucion!=""){
		   echo "<img src='".$d."tmp/".$institucion."insignia". "' >";
	  }else{
		   echo "<img src='".$d."menu/imag/logo.gif' >";
	  }?>
	  </td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td><font face="Verdana, Verdana, Arial, Helvetica, sans-serif" size="1"><? echo ucwords(strtolower($ob_membrete->direccion));?></font></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><font face="Verdana, Verdana, Arial, Helvetica, sans-serif" size="1">Fono:&nbsp;<? echo ucwords(strtolower($ob_membrete->telefono));?></font></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="41">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<br>
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center" class="tableindex">INFORME MENSUAL DE ASISTENCIA POR HORAS DE CLASE</td>
    </tr>
  <tr>
    <td><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="-1"><strong>MES: <? echo envia_mes($mes);?></strong></font></div></td>
    </tr>
</table>
<br>
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="118"><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>Curso</strong></font></div></td>
    <td width="10"><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>:</strong></font></div></td>
    <td width="522" class="subitem"><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo $Curso_pal?></font></div></td>
  </tr>
  <tr>
    <td class="item"><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>Profesor(a) Jefe </strong></font></div></td>
    <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>:</strong></font></div></td>
    <td class="subitem"><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo $ob_reporte->tildeM($ob_reporte->profe_jefe);?></font></div></td>
  </tr>
</table>
<br>
<table width="650" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td width="21" align="center" bgcolor="#999999" class="item">N&ordm;</td>
    <td width="365" align="center" bgcolor="#999999" class="item">NOMBRE DEL ALUMNO</td>
    <td width="111" align="center" bgcolor="#999999" class="item">HORAS INASISTENTE</td>
    <td width="143" align="center" bgcolor="#999999" class="item">PORCENTAJE ASISTENCIA</td>
  </tr>
  <?
    $partedefecha = "$ob_membrete->nro_ano"."-"."$mes";

	$ob_reporte ->curso = $curso;
	$ob_reporte ->ano = $ano;
	$res_alu = $ob_reporte ->TraeTodosAlumnos($conn);
	$num_alu = @pg_numrows($res_alu);
	
	for($i=0; $i<$num_alu; $i++){
	     $x = $i +1;
	     $fila_alu = pg_fetch_array($res_alu,$i);
		 $rut_alumno = $fila_alu['rut_alumno'];
	     
		 /// aqui determino cuantas inacistencia ha tenido en el mes
		 $sql_inasis = "select * from inasistencia_asignatura where rut_alumno = '".trim($rut_alumno)."' and ano = '".$ano."' and fecha like '%$partedefecha%' ";
		 $res_inasis = @pg_Exec($conn, $sql_inasis);
		 $num_inasis = @pg_numrows($res_inasis);
		 		 
		 $porcentaje = @round($num_inasis * 100 / $total_horas_mes);
		 $porcentaje = 100 - $porcentaje; 
		 	     
		 ?>
		 <tr>
		 <td align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="-2"><? echo $x;?></font></td>
		 <td><font face="Verdana, Arial, Helvetica, sans-serif" size="-2"><? echo $ob_reporte->tilde(trim($fila_alu['ape_pat'])." ".trim($fila_alu['ape_mat']).", ".trim($fila_alu['nombre_alu']));?></font></td>
		 <td align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="-2"><? echo $num_inasis ?></font></td>
		 <td align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="-2"><? echo $porcentaje."%";?></font></td>
		 </tr>
		 
		 
 <? } ?>
</table>
<table width="650" border="0" align="center">
  <tr>
    <?  
			if($ob_config->firma1!=0){
				$ob_reporte->cargo=$ob_config->firma1;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);?>
    <td width="25%" class="subitem" height="100"><hr align="center" width="150" color="#000000">
        <div align="center">
          <?=$ob_reporte->nombre_emp;?>
          <br>
          <?=$ob_reporte->nombre_cargo;?>
      </div></td>
    <? } ?>
    <? if($ob_config->firma2!=0){
				$ob_reporte->cargo=$ob_config->firma2;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);?>
    <td width="25%" class="subitem"><hr align="center" width="150" color="#000000">
        <div align="center">
          <?=$ob_reporte->nombre_emp;?>
          <br>
          <?=$ob_reporte->nombre_cargo;?>
      </div></td>
    <? } ?>
    <? if($ob_config->firma3!=0){
		  		$ob_reporte->cargo=$ob_config->firma3;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);?>
    <td width="25%" class="subitem"><hr align="center" width="150" color="#000000">
        <div align="center">
          <?=$ob_reporte->nombre_emp;?>
          <br>
          <?=$ob_reporte->nombre_cargo;?>
      </div></td>
    <? } ?>
    <? if($ob_config->firma4!=0){
				$ob_reporte->cargo=$ob_config->firma4;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);?>
    <td width="25%" class="subitem"><hr align="center" width="150" color="#000000">
        <div align="center">
          <?=$ob_reporte->nombre_emp;?>
          <br>
          <?=$ob_reporte->nombre_cargo;?>
      </div></td>
    <? }?>
  </tr>
</table>
<br>
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><HR width="100%" color=#003b85></td>
  </tr>
</table>
 <? if  (($cantidad_cursos - $i)<>1) 
	echo "<H1 class=SaltoDePagina>&nbsp;</H1>";

} ?>

</center>

<!-- FIN CUERPO DE LA PAGINA -->
</body>
</html>
<? pg_close($conn);?>