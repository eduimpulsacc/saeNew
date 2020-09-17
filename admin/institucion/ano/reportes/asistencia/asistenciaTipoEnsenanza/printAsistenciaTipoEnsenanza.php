<script>
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
</script>

<?php require('../../../../../../util/header.inc');
include('../../../../../clases/class_Reporte.php');
include('../../../../../clases/class_Membrete.php');
setlocale(LC_ALL,"es_ES");
	//setlocale("LC_ALL","es_ES");
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$mes 			= $cmb_mes;
	$ense			= $cmb_ense;
	$reporte		=$c_reporte;
	$curso=1;	
	$_POSP = 4;
	$_bot = 8;


   
  /* echo "parte: $numero_ini<br>";
    echo "termina: $numero_fin<br>";*/
   
   	$ob_membrete = new Membrete();
	$ob_reporte = new Reporte();
	
	$ob_membrete ->institucion = $institucion;
	$ob_membrete ->institucion($conn);
	
	//-------------------------	 CONFIGURACION DE REPORTE ------------------
	$ob_config = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=$curso;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = @pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);
		
	$mestrabaja=($mes<10)?"0".$mes:$mes;
	
	$ob_config->cod_tipo = $ense;
	$ob_config->TipoEnsenanza($conn);
	$tipe = $ob_config->nombre;
	
	
	$sql01 = "select nro_ano,fecha_inicio,fecha_termino from ano_escolar where id_ano = " . $ano;
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
	$fi_ano = $fila01['fecha_inicio'];
	$ft_ano = $fila01['fecha_termino'];
	
	
	$numero_fin = cal_days_in_month(CAL_GREGORIAN, $mes, $nro_ano); // 31
	
	$ob_reporte->ano=$ano;
	$ob_reporte->ensenanza=$ense;
	$rs_cursos = $ob_reporte->ListadoCurso($conn);
	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">

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
.Estilo12 {font-weight: bold; font-family: Verdana, Arial, Helvetica, sans-serif;}
</style>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../../cortes/b_ayuda_r.jpg','../../../../../../cortes/b_info_r.jpg','../../../../../../cortes/b_mapa_r.jpg','../../../../../../cortes/b_home_r.jpg')">
 
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
		  <tr><td><input name="button4" type="button" class="botonXX" onClick="cerrar()"   value="CERRAR"></td><td align="right">
		        <font size="1" face="Arial, Helvetica, sans-serif">**Imprimir 
                  horizontal**</font>

<input name="button3" TYPE="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR">
	</td>
		   <? if($_PERFIL == 0){?>
		    <td align="right"><input name="button32" TYPE="button" class="botonXX" onClick="javascript:exportar();"  value="EXPORTAR"></td>
		  <? }?>
		  </tr></table>
		 
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
			    echo "<img src='../../../../../../tmp/".$institucion."insignia". "' >";
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
  
</table>
<br>	
<table width="826" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center" class="tableindex">INFORME GENERAL DE ASISTENCIA MENSUAL POR TIPO DE ENSE&Ntilde;ANZA</td>
  </tr>
  <tr>
    <td align="center"><span class="Estilo2"><strong><? echo trim(strtoupper(envia_mes($mestrabaja) . " " . $nro_ano)) ;?></strong></span></td>
  </tr>
  <tr>
    <td align="center" class="Estilo2"><?php echo strtoupper($tipe) ?></td>
  </tr>
</table>
<br><br>
<?php for($c=0;$c<pg_numrows($rs_cursos);$c++){
$fila_curso = pg_fetch_array($rs_cursos,$c);
$id_curso = $fila_curso['id_curso'];
?><table width="827" border="1" cellpadding="0" cellspacing="0">
<? 
  $cadena4 = "";
  $cadena5 = "";
  $fila1="";
  $fila2="";
  $fila3="";
  for($YYY=$numero_ini ; $YYY <= $numero_fin ; $YYY++)
  {
  $dia_num = $YYY."<br>";
	$fecha = mktime(0,0,0,$mes,$dia_num,$nro_ano);
	$dia_pal = strftime("%a",$fecha);
	if (FechaValida($mes,$dia_num,$nro_ano, $ano)){
		$cadena4 =  $dia_num;
		$cadena5 =  strtoupper(substr($dia_pal,0,1));
	}else{
		$cadena4 =  ".";
		$cadena5 =  ".";
	}
	
	$dias_semana = $cadena4;
	$dias_letra = $cadena5;
	$fila1.=' <td class="subitem"><div align="center"><span class="Estilo4">'.$dias_semana.'</span></div></td>';
	$fila2.=' <td class="subitem"><div align="center"><span class="Estilo4">'.$dias_letra.'</span></div></td>';
	$fila3.="<td>&nbsp;</td>";
  }

	
	
		?> 
  <tr>
    <td width="78"><div align="center"><span class="Estilo4"><? echo $mes_pal ?></span></div></td>
   <?php echo  $fila1 ?>

    <td width="37"><span class="Estilo4">TOTAL</span></div></td>
    <td width="51"><span class="Estilo4">% ASIS</span></div></td>
    </tr>
  <tr>
    <td height="28">&nbsp;</td>
    <?php echo  $fila2 ?>

    <td>&nbsp;</td>
    <td>&nbsp;</td>
    </tr>
   <?
  ?>
  <tr>
    <td><div align="left"><span class="Estilo4">
	<? 
		//-----------------------------------------
		$Curso_pal = CursoPalabra($id_curso, 1, $conn);
		echo $Curso_pal ;
		//----------------------------------------
	?>
	</span></div></td>
    <?php echo $fila3 ?>

    <td>&nbsp;</td>
    <td>&nbsp;</td>
    </tr>
  <tr>
  <? 
	$cadena="";
	$total_mat=0;
	$matricula_a = ""; 			
	$asistentes_a = ""; 			
	$inasistentes_a = "";
	$fila4=""; 		
	$fila5=""; 
	$fila6=""; 
	$promedio_gral=0;
	$cont_gral=0;
	$total_asis=0;
	$total_ause=0;
	for($Y=$numero_ini ; $Y <= $numero_fin ; $Y++)
  	{
		$dia = $Y;
		if (($Y)<10) 
			$dia = "0".($Y);
		//-------------------
		$sql_consulta ="";
		$sql_consulta = $sql_consulta . "select count(*)- (SELECT count(*) FROM matricula WHERE ID_CURSO=$id_curso AND (bool_ar=1 and fecha_retiro <='".$mes."-".$dia."-".$nro_ano."')) as cantidad from matricula where id_curso = ".$id_curso;
		$sql_consulta = $sql_consulta . " and fecha <= '".$mes."-".$dia."-".$nro_ano."'  union ";
		$sql_consulta = $sql_consulta . "select count(*) as cantidad from asistencia where id_curso = ".$id_curso;
		$sql_consulta = $sql_consulta . " and fecha = '".$mes."-".$dia."-".$nro_ano."'";
		//if($_PERFIL==0) echo "<br>".$sql_consulta;
		//------------------- Consulto las inasistencias que han sido justificadas
		$sql_justifica = "select count(*) as cantidad from justifica_inasistencia where id_curso = '$id_curso' and fecha = '$mes-$dia-$nro_ano'";				

		if (FechaValida($mes,$dia,$nro_ano, $ano,$conn)){
			//----------------------------------------------------
			$result_consulta =pg_Exec($conn,$sql_consulta);
			$fila_comsulta = @pg_fetch_array($result_consulta,1);
			$total_mat = $total_mat + $fila_comsulta['cantidad']; 
			$matricula_a[$Y] = $fila_comsulta['cantidad']; 
			//------------ Justifica INasistecia -----------------
			$res_justifica = @pg_Exec($sql_justifica);
			$fila_justifica = @pg_fetch_array($res_justifica);
			$justificados = $fila_justifica['cantidad'];			
			//----------------------------------------------------
			$fila_comsulta = @pg_fetch_array($result_consulta,0);
			if($matricula_a[$Y]==""){
				$matricula_a[$Y]=$fila_comsulta['cantidad'];
			}
			$asistentes = ($matricula_a[$Y] - $fila_comsulta['cantidad']);
			$asistentes_a[$Y] = $asistentes + $justificados; 
			$inasistentes_a[$Y] = $fila_comsulta['cantidad'] - $justificados; 
			$total_asis = $total_asis + $asistentes + $justificados; 
			$total_ause = $total_ause + $fila_comsulta['cantidad'] - $justificados; 
			
			
			$asis[$Y]=$asis[$Y]+$asistentes_a[$Y];
			
		}else{
			$matricula_a[$Y] = "."; 			
			$asistentes_a[$Y] = "."; 			
			$inasistentes_a[$Y] = "."; 			
		}
		
		
		$fila4.=' <td class="subitem"><div align="left" class="Estilo2 Estilo6">'.$asistentes_a[$Y].'</div></td>';
		$fila5.=' <td class="subitem"><div align="left" class="Estilo2 Estilo6">'.$inasistentes_a[$Y].'</div></td>';
		$fila6.=' <td class="subitem"><div align="left" class="Estilo2 Estilo6">'.$matricula_a[$Y].'</div></td>';
	}
	
	?>
    <td height="30" class="item"><div align="left">
                <p><span class="Estilo12">Asistencia</span></p>
              </div></td>
              <?php echo $fila4 ?>
   
    <td class="subitem"><div align="left" class="Estilo2 Estilo6"><? echo $total_asis;?></div></td>
	<td class="subitem"><div align="left" class="Estilo2 Estilo6">
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
    <td height="30" class="item"><div align="left"><span class="Estilo12">Ausentes</span></div></td>
    <?php echo $fila5; ?>

	<td class="subitem"><div align="left" class="Estilo2 Estilo6"><? echo $total_ause; ?></div></td>
    <td class="subitem">&nbsp;</td>
	</tr>
  <tr>
	<td height="30" class="item"><div align="left"><span class="Estilo12">Matr&iacute;cula</span></div></td>
    <?php echo $fila6; ?>

    <td class="subitem"><div align="left" class="Estilo2 Estilo6"><? echo $total_mat;?></div></td>
    <td class="subitem">&nbsp;</td>
    </tr>
</table>
<br><br>
<?php }?>

  
</table>
<?
}



?>
<?php  function FechaValida($mes_f, $dia_f, $ano_f, $ano_esc,$conn)
{
	$sw = 0;
	
		
	$mes_f=($mes_f<10)?"0".$mes_f:$mes_f;
	
	
	
	$dia_f=($dia_f<10)?"0".$dia_f:$dia_f;
		
	$fecha_f = mktime(0,0,0,$mes_f,$dia_f,$ano_f);
	$dia_pal_f = strftime("%a",$fecha_f);
	
	if (checkdate($mes_f, $dia_f, $ano_f) and ($dia_pal_f <> "s�b" and $dia_pal_f <> "dom" )) 
	{
		 $sql_feriado = "select count(*) as cantidad from feriado where id_ano = " . $ano_esc . " and fecha_inicio <= '".$ano_f."-".$mes_f."-".$dia_f."' and fecha_fin >= '".$ano_f."-".$mes_f."-".$dia_f."'";
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
 <?php  
		 $ruta_timbre =6;
		 $ruta_firma =4;
		 include("../../firmas/firmas.php");?>
</body>
</html>
<? pg_close($conn);?>