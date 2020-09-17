<script>
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
</script>

<?php 

require('../../../../util/header.inc');
include('../../../clases/class_Reporte.php');
include('../../../clases/class_Membrete.php');

setlocale(LC_ALL,"es_ES");

	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$mes 			= $cmb_meses;
	$curso			= $cmb_curso;
	$reporte		=$c_reporte;	
	$_POSP = 4;
	$_bot = 8;

	if (empty($curso) or empty($mes)){

	}else{ 
		if ($mes == 1) $mes_pal = "Enero";
	    if ($mes == 2) $mes_pal = "Febrero";
	    if ($mes == 3) $mes_pal = "Marzo";
	    if ($mes == 4) $mes_pal = "Abril";
	    if ($mes == 5) $mes_pal = "Mayo";
	    if ($mes == 6) $mes_pal = "Junio";
	    if ($mes == 7) $mes_pal = "Julio";
	    if ($mes == 8) $mes_pal = "Agosto";
	    if ($mes == 9) $mes_pal = "Septiembre";
	    if ($mes == 10) $mes_pal = "Octubre";
	    if ($mes == 11) $mes_pal = "Noviembre";
	    if ($mes == 12) $mes_pal = "Diciembre";
	    $dia_1 = "01"; 	$dia_2 = "02"; 	$dia_3 = "03";  $dia_4 = "04";	
	    $dia_5 = "05";	$dia_6 = "06";	$dia_7 = "07";	$dia_8 = "08";	
	    $dia_9 = "09";	$dia_10 = "10";	$dia_11 = "11";	$dia_12 = "12";	
	    $dia_13 = "13";	$dia_14 = "14";	$dia_15 = "15";	$dia_16 = "16";	
	    $dia_17 = "17";	$dia_18 = "18";	$dia_19 = "19";	$dia_20 = "20";	
	    $dia_21 = "21";	$dia_22 = "22";	$dia_23 = "23";	$dia_24 = "24";	
	    $dia_25 = "25";	$dia_26 = "26";	$dia_27 = "27";	$dia_28 = "28";	
	    $dia_29 = "29";	$dia_30 = "30";	$dia_31 = "31";	
	
	    //-------------- INSTITUCION -------------------------------------------------------------
	  /*  $sql_ins = "SELECT institucion.nombre_instit, institucion.calle, institucion.nro, region.nom_reg, provincia.nom_pro, comuna.nom_com, institucion.telefono ";
		$sql_ins = $sql_ins . "FROM ((institucion INNER JOIN region ON institucion.region = region.cod_reg) INNER JOIN provincia ON (institucion.ciudad = provincia.cor_pro) AND (institucion.region = provincia.cod_reg)) INNER JOIN comuna ON (institucion.region = comuna.cod_reg) AND (institucion.ciudad = comuna.cor_pro) AND (institucion.comuna = comuna.cor_com) ";
		$sql_ins = $sql_ins . "WHERE (((institucion.rdb)=".$institucion.")); ";
		$result_ins =@pg_Exec($conn,$sql_ins);
		$fila_ins 	= @pg_fetch_array($result_ins,0);	
		$ins_pal = $fila_ins['nombre_instit'];
		$direccion = $fila_ins['calle'] . " " . $fila_ins['nro'] . " " . $fila_ins['nom_com'];
		$telefono = $fila_ins['telefono'];
*/
	$sql01 = "select nro_ano from ano_escolar where id_ano = " . $ano;
	$result01 =pg_Exec($conn,$sql01);
	if (!$result01) 
	{
		error('<B> ERROR :</b>Error al acceder a la BD. (ANO ESCOLAR)</B>');
	}
	else
	{
	if (pg_numrows($result01)!=0)
	{//En caso de estar el arreglo vacio.
		$fila01 = @pg_fetch_array($result01,0);	
		if (!$fila01)
		{
			error('<B> ERROR :</b>Error al acceder a la BD. (ANO ESCOLAR)</B>');
			exit();
		}
	}
	}
	$nro_ano = $fila01['nro_ano'];
	//-----------------------
	$sql = "select * from curso where id_ano = ".$ano." and id_curso = ".$curso;
	//-----------------------
	$result =pg_Exec($conn,$sql);
	$fila = @pg_fetch_array($result,0);
	$id_curso = $fila["id_curso"];
	$ensenanza = $fila["ensenanza"];	
	if (!$result) 
	{
		error('<B> ERROR :</b>Error al acceder a la BD. (CURSOS)</B>');
	}
	else
	{
	if (pg_numrows($result)!=0)
	{//En caso de estar el arreglo vacio.
		$fila = @pg_fetch_array($result,0);	
		if (!$fila)
		{
			error('<B> ERROR :</b>Error al acceder a la BD. (CURSOS)</B>');
			exit();
		}
	}
	}
	//---------------------------------------
	$sql = "select * from tipo_ensenanza where cod_tipo = " .$ensenanza;
	$result01 =pg_Exec($conn,$sql);
	$fila01 = @pg_fetch_array($result01,0);	
	$ensenanza_pal = $fila01['nombre_tipo'] ;
	//---------------------------------------
	//-----------------------
	
   }
   
  	$ob_membrete = new Membrete();
	$ob_reporte = new Reporte();
	
	$ob_membrete ->institucion = $institucion;
	$ob_membrete ->institucion($conn);
	
	$ob_membrete ->ano =$ano;
	$ob_membrete ->AnoEscolar($conn);
	
	/*$ob_membrete -> curso =$curso;
	$ob_membrete -> curso($conn);*/
	
	//-------------------------	 CONFIGURACION DE REPORTE ------------------
	$ob_config = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=1;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = @pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);
	
	if(!$cb_ok =="Buscar"){
		$Fecha= date("d-m-Y_h:i");
		header('Content-type: application/vnd.ms-excel');
		header("Content-Disposition:inline; filename=Informe_Asistencia_Mes_Conret_$Fecha.xls"); 
	}	
	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">

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
function exportar(){
			//form.target="_blank";
			window.location='printInformeAsistenciaMesConRet_C.php?cmb_curso=<?=$curso?>&cmb_meses=<?=$mes?>&c_reporte=<?=$reporte?>';
			//document.form.submit(true);
		return false;
}
function cerrar(){ 
window.close() 
} 
</script>
</head>
<style type="text/css">
<!--
.Estilo2 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 9px}
.Estilo4 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-weight: bold;
	font-size: 9px;
}
.Estilo6 {font-size: 9px}
.Estilo11 {font-family: Verdana, Arial, Helvetica, sans-serif; font-weight: bold; font-size: 9px; }
-->
</style>
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
 
<!-- FIN CODIGO DE BOTONES -->

<!-- INICIO CUERPO DE LA PAGINA -->
<?
if (empty($curso) or empty($mes)){
   ## no hace nada
}else{
   ?>   

<table width="819" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="839">
	
	<table>
    <tr>
	  <td align="left">&nbsp;</td>
	</tr>
  </table>
	
   <center>
	<table width="827" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="827">
		
		<div id="capa0">
		<table width="100%">
		  <tr>
		  	<td><input name="button4" type="button" class="botonXX" onClick="cerrar()"   value="CERRAR"></td><td align="right">
		        <font size="1" face="Arial, Helvetica, sans-serif">**Imprimir horizontal**</font>
				<input name="button3" TYPE="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR">
			</td>
			<? if($_PERFIL == 0){?>
		   		<td align="right"><input name="button32" TYPE="button" class="botonXX" onClick="javascript:exportar();"  value="EXPORTAR"></td>
		  	<? }?>
		  </tr>
		</table>
		 
        </div></td>
      </tr>
    </table>
	
   <? if ($institucion=="770"){ 
		   // no muestro los datos de la institucion
		   // por que ellos tienen hojas pre-impresas
		   echo "<br><br><br><br><br><br><br><br><br><br>";
   }  ?>
	
	
  <table width="826" border="0" cellspacing="0" cellpadding="0">
   <tr>
    <td width="697"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong><? echo ucwords(strtoupper($ob_membrete->ins_pal));?></strong></font></td>
    <td width="10">&nbsp;</td>
    <td width="125" rowspan="4" align="center">
		<table width="125" border="0" cellpadding="0" cellspacing="0">
          <tr valign="top">
            <td width="125" align="center">
   <? if ($institucion=="770"){ 
		  
			   
	 }else{ 
	 	  
			if($institucion!=""){
			    echo "<img src='".$d."tmp/".$institucion."insignia". "' >";
		    }else{
			    echo "<img src='".$d."menu/imag/logo.gif' >";
		    }?>
	  
   <? } ?>  
	  
	  
	  	</td>
		</tr>
      </table>
	</td>
  </tr>
  <tr>
    <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo ucwords(strtolower($ob_membrete->direccion));?></font></td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1">Fono: &nbsp;<? echo ucwords(strtolower($ob_membrete->telefono));?></font></td>
    <td>&nbsp;</td>
    </tr>
  <tr>
            <td height="41" valign="top"><span class="Estilo11">ASISTENCIA &nbsp;<span class="Estilo2"><strong><? echo CursoPalabra($curso, 1, $conn)?></strong></span></span></td>
    <td>&nbsp;</td>
    </tr>  
</table>
<br>	
<table width="826" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center" class="tableindex">INFORME GENERAL DE ASISTENCIA MENSUAL</td>
  </tr>
  <tr>
    <td align="center"><span class="Estilo2"><strong><? echo trim(strtoupper($mes_pal . " " . $ob_membrete->nro_ano)) ;?></strong></span></td>
  </tr>
</table>
<br>
<table width="827" border="1" cellpadding="0" cellspacing="0">
<? 
  $cadena4 = "";
  $cadena5 = "";
  for($YYY=0 ; $YYY < 31 ; $YYY++)
  {
  	$dia_num = $YYY+1;
	$fecha = mktime(0,0,0,$mes,$dia_num,$nro_ano);
	$dia_pal = strftime("%a",$fecha);
	if (FechaValida($mes,$dia_num,$nro_ano, $ano)){
		$cadena4 = $cadena4 . ";" . $dia_num;
		$cadena5 = $cadena5 . ";" . strtoupper(substr($dia_pal,0,1));
	}else{
		$cadena4 = $cadena4 . ";" . ".";
		$cadena5 = $cadena5 . ";" . ".";
	}
   }	

	$dias_semana = explode(";",$cadena4);
	$dias_letra = explode(";",$cadena5);
	
 		?> 
  <tr>
    <td width="78" class="item"><div align="center"><strong><? echo $mes_pal ?></strong></div></td>
    <td class="item"><div align="center"><strong><? echo $dias_semana[1];?></strong></div></td>
    <td class="item"><div align="center"><strong><? echo $dias_semana[2];?></strong></div></td>
    <td class="item"><div align="center"><strong><? echo $dias_semana[3];?></strong></div></td>
    <td class="item"><div align="center"><strong><? echo $dias_semana[4];?></strong></div></td>
    <td class="item"><div align="center"><strong><? echo $dias_semana[5];?></strong></div></td>
    <td class="item"><div align="center"><strong><? echo $dias_semana[6];?></strong></div></td>
    <td class="item"><div align="center"><strong><? echo $dias_semana[7];?></strong></div></td>
    <td class="item"><div align="center"><strong><? echo $dias_semana[8];?></strong></div></td>
    <td class="item"><div align="center"><strong><? echo $dias_semana[9];?></strong></div></td>
    <td class="item"><div align="center"><strong><? echo $dias_semana[10];?></strong></div></td>
    <td class="item"><div align="center"><strong><? echo $dias_semana[11];?></strong></div></td>
    <td class="item"><div align="center"><strong><? echo $dias_semana[12];?></strong></div></td>
    <td class="item"><div align="center"><strong><? echo $dias_semana[13];?></strong></div></td>
    <td class="item"><div align="center"><strong><? echo $dias_semana[14];?></strong></div></td>
    <td class="item"><div align="center"><strong><? echo $dias_semana[15];?></strong></div></td>
    <td class="item"><div align="center"><strong><? echo $dias_semana[16];?></strong></div></td>
    <td class="item"><div align="center"><strong><? echo $dias_semana[17];?></strong></div></td>
    <td class="item"><div align="center"><strong><? echo $dias_semana[18];?></strong></div></td>
    <td class="item"><div align="center"><strong><? echo $dias_semana[19];?></strong></div></td>
    <td class="item"><div align="center"><strong><? echo $dias_semana[20];?></strong></div></td>
    <td class="item"><div align="center"><strong><? echo $dias_semana[21];?></strong></div></td>
    <td class="item"><div align="center"><strong><? echo $dias_semana[22];?></strong></div></td>
    <td class="item"><div align="center"><strong><? echo $dias_semana[23];?></strong></div></td>
    <td class="item"><div align="center"><strong><? echo $dias_semana[24];?></strong></div></td>
    <td class="item"><div align="center"><strong><? echo $dias_semana[25];?></strong></div></td>
    <td class="item"><div align="center"><strong><? echo $dias_semana[26];?></strong></div></td>
    <td class="item"><div align="center"><strong><? echo $dias_semana[27];?></strong></div></td>
    <td class="item"><div align="center"><strong><? echo $dias_semana[28];?></strong></div></td>
    <td class="item"><div align="center"><strong><? echo $dias_semana[29];?></strong></div></td>
    <td class="item"><div align="center"><strong><? echo $dias_semana[30];?></strong></div></td>
    <td class="item"><div align="center"><strong><? echo $dias_semana[31];?></strong></div></td>
    <td width="37" class="item"><strong>TOTAL</strong></div></td>
    <td width="51"><span class="Estilo4">% ASIS</span></div></td>
    </tr>
  <tr>
    <td height="28" class="item">&nbsp;</td>
    <td class="item"><div align="center"><strong><? echo $dias_letra[1];?></strong></div></td>
    <td class="item"><div align="center"><strong><? echo $dias_letra[2];?></strong></div></td>
    <td class="item"><div align="center"><strong><? echo $dias_letra[3];?></strong></div></td>
    <td class="item"><div align="center"><strong><? echo $dias_letra[4];?></strong></div></td>
    <td class="item"><div align="center"><strong><? echo $dias_letra[5];?></strong></div></td>
    <td class="item"><div align="center"><strong><? echo $dias_letra[6];?></strong></div></td>
    <td class="item"><div align="center"><strong><? echo $dias_letra[7];?></strong></div></td>
    <td class="item"><div align="center"><strong><? echo $dias_letra[8];?></strong></div></td>
    <td class="item"><div align="center"><strong><? echo $dias_letra[9];?></strong></div></td>
    <td class="item"><div align="center"><strong><? echo $dias_letra[10];?></strong></div></td>
    <td class="item"><div align="center"><strong><? echo $dias_letra[11];?></strong></div></td>
    <td class="item"><div align="center"><strong><? echo $dias_letra[12];?></strong></div></td>
    <td class="item"><div align="center"><strong><? echo $dias_letra[13];?></strong></div></td>
    <td class="item"><div align="center"><strong><? echo $dias_letra[14];?></strong></div></td>
    <td class="item"><div align="center"><strong><? echo $dias_letra[15];?></strong></div></td>
    <td class="item"><div align="center"><strong><? echo $dias_letra[16];?></strong></div></td>
    <td class="item"><div align="center"><strong><? echo $dias_letra[17];?></strong></div></td>
    <td class="item"><div align="center"><strong><? echo $dias_letra[18];?></strong></div></td>
    <td class="item"><div align="center"><strong><? echo $dias_letra[19];?></strong></div></td>
    <td class="item"><div align="center"><strong><? echo $dias_letra[20];?></strong></div></td>
    <td class="item"><div align="center"><strong><? echo $dias_letra[21];?></strong></div></td>
    <td class="item"><div align="center"><strong><? echo $dias_letra[22];?></strong></div></td>
    <td class="item"><div align="center"><strong><? echo $dias_letra[23];?></strong></div></td>
    <td class="item"><div align="center"><strong><? echo $dias_letra[24];?></strong></div></td>
    <td class="item"><div align="center"><strong><? echo $dias_letra[25];?></strong></div></td>
    <td class="item"><div align="center"><strong><? echo $dias_letra[26];?></strong></div></td>
    <td class="item"><div align="center"><strong><? echo $dias_letra[27];?></strong></div></td>
    <td class="item"><div align="center"><strong><? echo $dias_letra[28];?></strong></div></td>
    <td class="item"><div align="center"><strong><? echo $dias_letra[29];?></strong></div></td>
    <td class="item"><div align="center"><strong><? echo $dias_letra[30];?></strong></div></td>
    <td class="item"><div align="center"><strong><? echo $dias_letra[31];?></strong></div></td>	
    <td class="item">&nbsp;</td>
    <td>&nbsp;</td>
    </tr>
   <?
  ?>
  <tr>
    <td class="item"><div align="left"><strong>
	<? 
		//-----------------------------------------
		$Curso_pal = CursoPalabra($id_curso, 3, $conn);
		echo $Curso_pal ;
		//----------------------------------------
	?>
	</strong></div></td>
	<td class="item">&nbsp;</td>
    <td class="item">&nbsp;</td>
    <td class="item">&nbsp;</td>
    <td class="item">&nbsp;</td>
    <td class="item">&nbsp;</td>
    <td class="item">&nbsp;</td>
    <td class="item">&nbsp;</td>
    <td class="item">&nbsp;</td>
    <td class="item">&nbsp;</td>
    <td class="item">&nbsp;</td>
    <td class="item">&nbsp;</td>
    <td class="item">&nbsp;</td>
    <td class="item">&nbsp;</td>
    <td class="item">&nbsp;</td>
    <td class="item">&nbsp;</td>
    <td class="item">&nbsp;</td>
    <td class="item">&nbsp;</td>
    <td class="item">&nbsp;</td>
    <td class="item">&nbsp;</td>
    <td class="item">&nbsp;</td>
    <td class="item">&nbsp;</td>
    <td class="item">&nbsp;</td>
    <td class="item">&nbsp;</td>
    <td class="item">&nbsp;</td>
    <td class="item">&nbsp;</td>
    <td class="item">&nbsp;</td>
    <td class="item">&nbsp;</td>
    <td class="item">&nbsp;</td>
    <td class="item">&nbsp;</td>
    <td class="item">&nbsp;</td>
    <td class="item">&nbsp;</td>
    <td class="item">&nbsp;</td>
    <td>&nbsp;</td>
    </tr>
  <tr>
  <? 
	$cadena="";
	$total_mat=0;
	$matricula_a = ""; 			
	$asistentes_a = ""; 			
	$inasistentes_a = ""; 			
	for($Y=0 ; $Y < 31 ; $Y++)
  	{
		$dia = $Y+1;
		if (($Y+1)<10) 
			$dia = "0".($Y+1);
		//-------------------
		$sql_consulta ="";
		$sql_consulta = $sql_consulta . "select (count(*) - (SELECT count(*) FROM matricula WHERE id_curso=".$id_curso." ";
		$sql_consulta = $sql_consulta . " AND fecha_retiro<= '".$mes."-".$dia."-".$nro_ano."'))as cantidad ";
		$sql_consulta = $sql_consulta . " from matricula where id_curso = ".$id_curso;
		$sql_consulta = $sql_consulta . " and fecha <= '".$mes."-".$dia."-".$nro_ano."'  union ";
		$sql_consulta = $sql_consulta . "select count(*) as cantidad from asistencia where id_curso = ".$id_curso;
		$sql_consulta = $sql_consulta . " and fecha = '".$mes."-".$dia."-".$nro_ano."'";

		//------------------- Consulto las inasistencias que han sido justificadas
		$sql_justifica = "select count(*) as cantidad from justifica_inasistencia where id_curso = '$id_curso' and fecha = '$mes-$dia-$nro_ano'";				

		if (FechaValida($mes,$dia,$nro_ano, $ano))
		{
			//----------------------------------------------------
			$result_consulta =pg_Exec($conn,$sql_consulta);
			$fila_comsulta = @pg_fetch_array($result_consulta,1);
			$total_mat = $total_mat + $fila_comsulta['cantidad']; 
			$matricula_a[$Y+1] = $fila_comsulta['cantidad']; 
			//------------ Justifica INasistecia -----------------
			$res_justifica = @pg_Exec($sql_justifica);
			$fila_justifica = @pg_fetch_array($res_justifica);
			$justificados = $fila_justifica['cantidad'];			
			//----------------------------------------------------
			$fila_comsulta = @pg_fetch_array($result_consulta,0);
			$asistentes = ($matricula_a[$Y+1] - $fila_comsulta['cantidad']);
			$asistentes_a[$Y+1] = $asistentes + $justificados; 
			$inasistentes_a[$Y+1] = $fila_comsulta['cantidad'] - $justificados; 
			$total_asis = $total_asis + $asistentes + $justificados; 
			$total_ause = $total_ause + $fila_comsulta['cantidad'] - $justificados; 
			
		}
		else
		{
			$matricula_a[$Y+1] = "."; 			
			$asistentes_a[$Y+1] = "."; 			
			$inasistentes_a[$Y+1] = "."; 			
		}
		
	}
	
	?>
    <td height="30" class="item"><div align="left">
                <p><strong>Asistencia</strong></p>
              </div></td>
    <td class="item"><div align="left" class="Estilo6 "><? echo $asistentes_a[1]; $asis1 = $asis1 + $asistentes_a[1];?></div></td>
    <td class="item"><div align="left" class="Estilo6 "><? echo $asistentes_a[2]; $asis2 = $asis2 + $asistentes_a[2];?></div></td>
    <td class="item"><div align="left" class="Estilo6 "><? echo $asistentes_a[3]; $asis3 = $asis3 + $asistentes_a[3];?></div></td>
    <td class="item"><div align="left" class="Estilo6 "><? echo $asistentes_a[4]; $asis4 = $asis4 + $asistentes_a[4];?></div></td>
    <td class="item"><div align="left" class="Estilo6 "><? echo $asistentes_a[5]; $asis5 = $asis5 + $asistentes_a[5];?></div></td>
    <td class="item"><div align="left" class="Estilo6 "><? echo $asistentes_a[6]; $asis6 = $asis6 + $asistentes_a[6];?></div></td>
    <td class="item"><div align="left" class="Estilo6 "><? echo $asistentes_a[7]; $asis7 = $asis7 + $asistentes_a[7];?></div></td>
    <td class="item"><div align="left" class="Estilo6 "><? echo $asistentes_a[8]; $asis8 = $asis8 + $asistentes_a[8];?></div></td>
    <td class="item"><div align="left" class="Estilo6 "><? echo $asistentes_a[9]; $asis9 = $asis9 + $asistentes_a[9];?></div></td>
    <td class="item"><div align="left" class="Estilo6 "><? echo $asistentes_a[10]; $asis10 = $asis10 + $asistentes_a[10];?></div></td>
    <td class="item"><div align="left" class="Estilo6 "><? echo $asistentes_a[11]; $asis11 = $asis11 + $asistentes_a[11];?></div></td>
    <td class="item"><div align="left" class="Estilo6 "><? echo $asistentes_a[12]; $asis12 = $asis12 + $asistentes_a[12];?></div></td>
    <td class="item"><div align="left" class="Estilo6 "><? echo $asistentes_a[13]; $asis13 = $asis13 + $asistentes_a[13];?></div></td>
    <td class="item"><div align="left" class="Estilo6 "><? echo $asistentes_a[14]; $asis14 = $asis14 + $asistentes_a[14];?></div></td>
    <td class="item"><div align="left" class="Estilo6 "><? echo $asistentes_a[15]; $asis15 = $asis15 + $asistentes_a[15];?></div></td>
    <td class="item"><div align="left" class="Estilo6 "><? echo $asistentes_a[16]; $asis16 = $asis16 + $asistentes_a[16];?></div></td>
    <td class="item"><div align="left" class="Estilo6 "><? echo $asistentes_a[17]; $asis17 = $asis17 + $asistentes_a[17];?></div></td>
    <td class="item"><div align="left" class="Estilo6 "><? echo $asistentes_a[18]; $asis18 = $asis18 + $asistentes_a[18];?></div></td>
    <td class="item"><div align="left" class="Estilo6 "><? echo $asistentes_a[19]; $asis19 = $asis19 + $asistentes_a[19];?></div></td>
    <td class="item"><div align="left" class="Estilo6 "><? echo $asistentes_a[20]; $asis20 = $asis20 + $asistentes_a[20];?></div></td>
    <td class="item"><div align="left" class="Estilo6 "><? echo $asistentes_a[21]; $asis21 = $asis21 + $asistentes_a[21];?></div></td>
    <td class="item"><div align="left" class="Estilo6 "><? echo $asistentes_a[22]; $asis22 = $asis22 + $asistentes_a[22];?></div></td>
    <td class="item"><div align="left" class="Estilo6 "><? echo $asistentes_a[23]; $asis23 = $asis23 + $asistentes_a[23];?></div></td>
    <td class="item"><div align="left" class="Estilo6 "><? echo $asistentes_a[24]; $asis24 = $asis24 + $asistentes_a[24];?></div></td>
    <td class="item"><div align="left" class="Estilo6 "><? echo $asistentes_a[25]; $asis25 = $asis25 + $asistentes_a[25];?></div></td>
    <td class="item"><div align="left" class="Estilo6 "><? echo $asistentes_a[26]; $asis26 = $asis26 + $asistentes_a[26];?></div></td>
    <td class="item"><div align="left" class="Estilo6 "><? echo $asistentes_a[27]; $asis27 = $asis27 + $asistentes_a[27];?></div></td>
    <td class="item"><div align="left" class="Estilo6 "><? echo $asistentes_a[28]; $asis28 = $asis28 + $asistentes_a[28];?></div></td>
    <td class="item"><div align="left" class="Estilo6 "><? echo $asistentes_a[29]; $asis29 = $asis29 + $asistentes_a[29];?></div></td>
    <td class="item"><div align="left" class="Estilo6 "><? echo $asistentes_a[30]; $asis30 = $asis30 + $asistentes_a[30];?></div></td>
    <td class="item"><div align="left" class="Estilo6 "><? echo $asistentes_a[31]; $asis31 = $asis31 + $asistentes_a[31];?></div></td>
    <td class="item"><div align="left" class="Estilo6 "><? echo $total_asis;?></div></td>
	<td><div align="left" class="Estilo2 Estilo6">
	<? 
	
	if ($total_mat>0) 
	{
	  echo round(($total_asis*100)/$total_mat,2)."%"; 
	  $promedio_gral = $promedio_gral + round(($total_asis*100)/$total_mat,2);
	  $cont_gral = $cont_gral + 1;
	}
	else 
	  echo "&nbsp;";
	  ?></div></td>
    </tr>
  <tr>
    <td height="30" class="item"><div align="left"><strong>Ausentes</strong></div></td>
    <td class="item"><div align="left" class="Estilo6 "><? echo $inasistentes_a[1]; $inasis1 = $inasis1 + $inasistentes_a[1];?></div></td>
    <td class="item"><div align="left" class="Estilo6 "><? echo $inasistentes_a[2]; $inasis2 = $inasis2 + $inasistentes_a[2];?></div></td>
    <td class="item"><div align="left" class="Estilo6 "><? echo $inasistentes_a[3]; $inasis3 = $inasis3 + $inasistentes_a[3];?></div></td>
    <td class="item"><div align="left" class="Estilo6 "><? echo $inasistentes_a[4]; $inasis4 = $inasis4 + $inasistentes_a[4];?></div></td>
    <td class="item"><div align="left" class="Estilo6 "><? echo $inasistentes_a[5]; $inasis5 = $inasis5 + $inasistentes_a[5];?></div></td>
    <td class="item"><div align="left" class="Estilo6 "><? echo $inasistentes_a[6]; $inasis6 = $inasis6 + $inasistentes_a[6];?></div></td>
    <td class="item"><div align="left" class="Estilo6 "><? echo $inasistentes_a[7]; $inasis7 = $inasis7 + $inasistentes_a[7];?></div></td>
    <td class="item"><div align="left" class="Estilo6 "><? echo $inasistentes_a[8]; $inasis8 = $inasis8 + $inasistentes_a[8];?></div></td>
    <td class="item"><div align="left" class="Estilo6 "><? echo $inasistentes_a[9]; $inasis9 = $inasis9 + $inasistentes_a[9];?></div></td>
    <td class="item"><div align="left" class="Estilo6 "><? echo $inasistentes_a[10]; $inasis10 = $inasis10 + $inasistentes_a[10];?></div></td>
    <td class="item"><div align="left" class="Estilo6 "><? echo $inasistentes_a[11]; $inasis11 = $inasis11 + $inasistentes_a[11];?></div></td>
    <td class="item"><div align="left" class="Estilo6 "><? echo $inasistentes_a[12]; $inasis12 = $inasis12 + $inasistentes_a[12];?></div></td>
    <td class="item"><div align="left" class="Estilo6 "><? echo $inasistentes_a[13]; $inasis13 = $inasis13 + $inasistentes_a[13];?></div></td>
    <td class="item"><div align="left" class="Estilo6 "><? echo $inasistentes_a[14]; $inasis14 = $inasis14 + $inasistentes_a[14];?></div></td>
    <td class="item"><div align="left" class="Estilo6 "><? echo $inasistentes_a[15]; $inasis15 = $inasis15 + $inasistentes_a[15];?></div></td>
    <td class="item"><div align="left" class="Estilo6 "><? echo $inasistentes_a[16]; $inasis16 = $inasis16 + $inasistentes_a[16];?></div></td>
    <td class="item"><div align="left" class="Estilo6 "><? echo $inasistentes_a[17]; $inasis17 = $inasis17 + $inasistentes_a[17];?></div></td>
    <td class="item"><div align="left" class="Estilo6 "><? echo $inasistentes_a[18]; $inasis18 = $inasis18 + $inasistentes_a[18];?></div></td>
    <td class="item"><div align="left" class="Estilo6 "><? echo $inasistentes_a[19]; $inasis19 = $inasis19 + $inasistentes_a[19];?></div></td>
    <td class="item"><div align="left" class="Estilo6 "><? echo $inasistentes_a[20]; $inasis20 = $inasis20 + $inasistentes_a[20];?></div></td>
    <td class="item"><div align="left" class="Estilo6 "><? echo $inasistentes_a[21]; $inasis21 = $inasis21 + $inasistentes_a[21];?></div></td>
    <td class="item"><div align="left" class="Estilo6 "><? echo $inasistentes_a[22]; $inasis22 = $inasis22 + $inasistentes_a[22];?></div></td>
    <td class="item"><div align="left" class="Estilo6 "><? echo $inasistentes_a[23]; $inasis23 = $inasis23 + $inasistentes_a[23];?></div></td>
    <td class="item"><div align="left" class="Estilo6 "><? echo $inasistentes_a[24]; $inasis24 = $inasis24 + $inasistentes_a[24];?></div></td>
    <td class="item"><div align="left" class="Estilo6 "><? echo $inasistentes_a[25]; $inasis25 = $inasis25 + $inasistentes_a[25];?></div></td>
    <td class="item"><div align="left" class="Estilo6 "><? echo $inasistentes_a[26]; $inasis26 = $inasis26 + $inasistentes_a[26];?></div></td>
    <td class="item"><div align="left" class="Estilo6 "><? echo $inasistentes_a[27]; $inasis27 = $inasis27 + $inasistentes_a[27];?></div></td>
    <td class="item"><div align="left" class="Estilo6 "><? echo $inasistentes_a[28]; $inasis28 = $inasis28 + $inasistentes_a[28];?></div></td>
    <td class="item"><div align="left" class="Estilo6 "><? echo $inasistentes_a[29]; $inasis29 = $inasis29 + $inasistentes_a[29];?></div></td>
    <td class="item"><div align="left" class="Estilo6 "><? echo $inasistentes_a[30]; $inasis30 = $inasis30 + $inasistentes_a[30];?></div></td>
    <td class="item"><div align="left" class="Estilo6 "><? echo $inasistentes_a[31]; $inasis31 = $inasis31 + $inasistentes_a[31];?></div></td>
	<td class="item"><div align="left" class="Estilo6 "><? echo $total_ause; ?></div></td>
    <td>&nbsp;</td>
	</tr>
  <tr>
	<td height="30" class="item"><div align="left"><strong>Matr&iacute;cula</strong></div></td>
    <td class="item"><div align="left" class="Estilo6 "><? echo $matricula_a[1]; $mat1 = $mat1 + $matricula_a[1];?></div></td>
    <td class="item"><div align="left" class="Estilo6 "><? echo $matricula_a[2]; $mat2 = $mat2 + $matricula_a[2];?></div></td>
    <td class="item"><div align="left" class="Estilo6 "><? echo $matricula_a[3]; $mat3 = $mat3 + $matricula_a[3];?></div></td>
    <td class="item"><div align="left" class="Estilo6 "><? echo $matricula_a[4]; $mat4 = $mat4 + $matricula_a[4];?></div></td>
    <td class="item"><div align="left" class="Estilo6 "><? echo $matricula_a[5]; $mat5 = $mat5 + $matricula_a[5];?></div></td>
    <td class="item"><div align="left" class="Estilo6 "><? echo $matricula_a[6]; $mat6 = $mat6 + $matricula_a[6];?></div></td>
    <td class="item"><div align="left" class="Estilo6 "><? echo $matricula_a[7]; $mat7 = $mat7 + $matricula_a[7];?></div></td>
    <td class="item"><div align="left" class="Estilo6 "><? echo $matricula_a[8]; $mat8 = $mat8 + $matricula_a[8];?></div></td>
    <td class="item"><div align="left" class="Estilo6 "><? echo $matricula_a[9]; $mat9 = $mat9 + $matricula_a[9];?></div></td>
    <td class="item"><div align="left" class="Estilo6 "><? echo $matricula_a[10]; $mat10 = $mat10 + $matricula_a[10];?></div></td>
    <td class="item"><div align="left" class="Estilo6 "><? echo $matricula_a[11]; $mat11 = $mat11 + $matricula_a[11];?></div></td>
    <td class="item"><div align="left" class="Estilo6 "><? echo $matricula_a[12]; $mat12 = $mat12 + $matricula_a[12];?></div></td>
    <td class="item"><div align="left" class="Estilo6 "><? echo $matricula_a[13]; $mat13 = $mat13 + $matricula_a[13];?></div></td>
    <td class="item"><div align="left" class="Estilo6 "><? echo $matricula_a[14]; $mat14 = $mat14 + $matricula_a[14];?></div></td>
    <td class="item"><div align="left" class="Estilo6 "><? echo $matricula_a[15]; $mat15 = $mat15 + $matricula_a[15];?></div></td>
    <td class="item"><div align="left" class="Estilo6 "><? echo $matricula_a[16]; $mat16 = $mat16 + $matricula_a[16];?></div></td>
    <td class="item"><div align="left" class="Estilo6 "><? echo $matricula_a[17]; $mat17 = $mat17 + $matricula_a[17];?></div></td>
    <td class="item"><div align="left" class="Estilo6 "><? echo $matricula_a[18]; $mat18 = $mat18 + $matricula_a[18];?></div></td>
    <td class="item"><div align="left" class="Estilo6 "><? echo $matricula_a[19]; $mat19 = $mat19 + $matricula_a[19];?></div></td>
    <td class="item"><div align="left" class="Estilo6 "><? echo $matricula_a[20]; $mat20 = $mat20 + $matricula_a[20];?></div></td>
    <td class="item"><div align="left" class="Estilo6 "><? echo $matricula_a[21]; $mat21 = $mat21 + $matricula_a[21];?></div></td>
    <td class="item"><div align="left" class="Estilo6 "><? echo $matricula_a[22]; $mat22 = $mat22 + $matricula_a[22];?></div></td>
    <td class="item"><div align="left" class="Estilo6 "><? echo $matricula_a[23]; $mat23 = $mat23 + $matricula_a[23];?></div></td>
    <td class="item"><div align="left" class="Estilo6 "><? echo $matricula_a[24]; $mat24 = $mat24 + $matricula_a[24];?></div></td>
    <td class="item"><div align="left" class="Estilo6 "><? echo $matricula_a[25]; $mat25 = $mat25 + $matricula_a[25];?></div></td>
    <td class="item"><div align="left" class="Estilo6 "><? echo $matricula_a[26]; $mat26 = $mat26 + $matricula_a[26];?></div></td>
    <td class="item"><div align="left" class="Estilo6 "><? echo $matricula_a[27]; $mat27 = $mat27 + $matricula_a[27];?></div></td>
    <td class="item"><div align="left" class="Estilo6 "><? echo $matricula_a[28]; $mat28 = $mat28 + $matricula_a[28];?></div></td>
    <td class="item"><div align="left" class="Estilo6 "><? echo $matricula_a[29]; $mat29 = $mat29 + $matricula_a[29];?></div></td>
    <td class="item"><div align="left" class="Estilo6 "><? echo $matricula_a[30]; $mat30 = $mat30 + $matricula_a[30];?></div></td>
    <td class="item"><div align="left" class="Estilo6 "><? echo $matricula_a[31]; $mat31 = $mat31 + $matricula_a[31];?></div></td>
    <td class="item"><div align="left" class="Estilo6 "><? echo $total_mat;?></div></td>
    <td>&nbsp;</td>
    </tr>
</table>  
<table width="827" border="0" cellspacing="0" cellpadding="0">
  <tr><br>
    <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>Promedio Asistencia Mes : <? if ($cont_gral>0) echo round($promedio_gral/$cont_gral,2)."%"; else echo "&nbsp;";?></strong></font></div></td>
  </tr>
</table>
  </td>
  </tr>
  
</table>
<?
}

function FechaValida($mes_f, $dia_f, $ano_f, $ano_esc)
{
	$sw = 0;
	$conn=@pg_connect("dbname=coe port=1550 user=postgres password=usuariocoegc10");
	
		
	
	if (strlen($mes_f)==1)
		$mes_f = "0".$mes_f;
	if (strlen($dia_f)==1)
		$dia_f = "0".$dia_f;
		
	$fecha_f = mktime(0,0,0,$mes_f,$dia_f,$ano_f);
	$dia_pal_f = strftime("%a",$fecha_f);
	
	if (checkdate($mes_f, $dia_f, $ano_f) and ($dia_pal_f <> "sáb" and $dia_pal_f <> "dom" )) 
	{
		$sql_feriado = "select count(*) as cantidad from feriado where id_ano = " . $ano_esc . " and fecha_inicio <= '".$mes_f."-".$dia_f."-".$ano_f."' and fecha_fin >= '".$mes_f."-".$dia_f."-".$ano_f."'";
		$result_feriado = @pg_Exec($conn,$sql_feriado);
		$fila_feriado = @pg_fetch_array($result_feriado,0);	
		$feriado = $fila_feriado['cantidad'];
		if ($feriado==0)
		{
			$sw = 0;
		}
		else
		{
			$sw = 1;
		}
	}
	else
	{
		$sw = 1;
	}
		
	if ($sw == 0)
		return true;
	else
		return false;
}

?>
 

<!-- FIN CUERPO DE LA PAGINA -->

<table width="650" border="0" align="center">
  <tr>
    <?  
			if($ob_config->firma1!=0){
				$ob_reporte->cargo=$ob_config->firma1;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);?>
    <td width="25%" class="item" height="100"><hr align="center" width="150" color="#000000">
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
    <td width="25%" class="item"><hr align="center" width="150" color="#000000">
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
    <td width="25%" class="item"><hr align="center" width="150" color="#000000">
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
    <td width="25%" class="item"><hr align="center" width="150" color="#000000">
        <div align="center">
          <?=$ob_reporte->nombre_emp;?>
          <br>
          <?=$ob_reporte->nombre_cargo;?>
      </div></td>
    <? }?>
  </tr>
</table>
</body>
</html>
<? pg_close($conn);?>