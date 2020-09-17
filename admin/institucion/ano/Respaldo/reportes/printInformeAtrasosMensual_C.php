<script>
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
</script>

<?php require('../../../../util/header.inc');
include('../../../clases/class_Reporte.php');
include('../../../clases/class_Membrete.php');
setlocale(LC_ALL,"es_ES");
	//setlocale("LC_ALL","es_ES");
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$mes 			= $cmb_meses;
	$curso			= $cmb_curso;
	$reporte		=$c_reporte;	
	$_POSP = 4;
	$_bot = 8;

	if (empty($curso) or empty($mes)){
	 //exit;
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
	
	//-------------------------	 CONFIGURACION DE REPORTE ------------------
	$ob_config = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=$curso;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = @pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);
	
	if(!$cb_ok =="Buscar"){
		$Fecha= date("d-m-Y_h:i");
		header('Content-type: application/vnd.ms-excel');
		header("Content-Disposition:inline; filename=Informe_Asistencia_Mes_$Fecha.xls"); 
	}	
	
	function FechaValida($mes_f, $dia_f, $ano_f, $ano_esc,$conn)
{
	$sw = 0;
	//$conn=@pg_connect("dbname=coe port=1550 user=postgres password=usuariocoegc10");
//	 $conn=pg_connect("dbname=coi_final host=10.132.10.36 port=5432 user=postgres password=cole#newaccess");
		
	
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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<title>Documento sin t&iacute;tulo</title>
<style type="text/css">
<!--
.Estilo11 {font-family: Verdana, Arial, Helvetica, sans-serif; font-weight: bold; font-size: 9px; }
.Estilo2 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 9px}
.Estilo12 {font-weight: bold; font-family: Verdana, Arial, Helvetica, sans-serif;}
.Estilo6 {font-size: 9px}
.item { font-family:<?=$ob_config->letraI;?>;
 font-size:<?=$ob_config->tamanoI;?>px;
}
.subitem { font-family:<?=$ob_config->letraS;?>;
 font-size:<?=$ob_config->tamanoS;?>px;
}
-->
</style>
</head>

<body>
<table width="826" border="0">
  <tr>
    <td><input type="submit" name="Submit" value="CERRAR"  class="botonXX "/></td>
    <td><div align="right">
      <input type="submit" name="Submit2" value="IMPRIMIR"  class="botonXX"/>
    </div></td>
  </tr>
</table>
<br />
<br />
<table width="826" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="697"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong><? echo ucwords(strtoupper($ob_membrete->ins_pal));?></strong></font></td>
    <td width="10">&nbsp;</td>
    <td width="125" rowspan="4" align="center"><table width="125" border="0" cellpadding="0" cellspacing="0">
      <tr valign="top">
        <td width="125" align="center"><? if ($institucion=="770"){ 
		  
			   
	 }else{ 
		    if($institucion!=""){
			    echo "<img src='".$d."tmp/".$institucion."insignia". "' >";
		    }else{
			    echo "<img src='".$d."menu/imag/logo.gif' >";
		    }?>
              <? } ?>
        </td>
      </tr>
    </table></td>
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
<br />
<table width="826" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center" class="tableIndex">INFORME  DE ANOTACIONES MENSUAL</td>
  </tr>
  <tr>
    <td align="center"><span class="Estilo2"><strong><? echo trim(strtoupper($mes_pal . " " . $nro_ano)) ;?></strong></span></td>
  </tr>
</table>
<br />
<table width="827" border="1" cellpadding="0" cellspacing="0">
  <? 
  $cadena4 = "";
  $cadena5 = "";
  
  if($mes==4 || $mes==6 || $mes==9 || $mes==11){
	  $dia_final=30;
  }else{
	  $dia_final=31;
  }
  for($YYY=0 ; $YYY < $dia_final ; $YYY++)
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
    <td width="78"><div align="center"><span class="Estilo11"><? echo $mes_pal ?></span></div></td>
    <td class="subitem"><div align="center"><span class="Estilo11"><? echo $dias_semana[1];?></span></div></td>
    <td class="subitem"><div align="center"><span class="Estilo11"><? echo $dias_semana[2];?></span></div></td>
    <td class="subitem"><div align="center"><span class="Estilo11"><? echo $dias_semana[3];?></span></div></td>
    <td class="subitem"><div align="center"><span class="Estilo11"><? echo $dias_semana[4];?></span></div></td>
    <td class="subitem"><div align="center"><span class="Estilo11"><? echo $dias_semana[5];?></span></div></td>
    <td class="subitem"><div align="center"><span class="Estilo11"><? echo $dias_semana[6];?></span></div></td>
    <td class="subitem"><div align="center"><span class="Estilo11"><? echo $dias_semana[7];?></span></div></td>
    <td class="subitem"><div align="center"><span class="Estilo11"><? echo $dias_semana[8];?></span></div></td>
    <td class="subitem"><div align="center"><span class="Estilo11"><? echo $dias_semana[9];?></span></div></td>
    <td class="subitem"><div align="center"><span class="Estilo11"><? echo $dias_semana[10];?></span></div></td>
    <td class="subitem"><div align="center"><span class="Estilo11"><? echo $dias_semana[11];?></span></div></td>
    <td class="subitem"><div align="center"><span class="Estilo11"><? echo $dias_semana[12];?></span></div></td>
    <td class="subitem"><div align="center"><span class="Estilo11"><? echo $dias_semana[13];?></span></div></td>
    <td class="subitem"><div align="center"><span class="Estilo11"><? echo $dias_semana[14];?></span></div></td>
    <td class="subitem"><div align="center"><span class="Estilo11"><? echo $dias_semana[15];?></span></div></td>
    <td class="subitem"><div align="center"><span class="Estilo11"><? echo $dias_semana[16];?></span></div></td>
    <td class="subitem"><div align="center"><span class="Estilo11"><? echo $dias_semana[17];?></span></div></td>
    <td class="subitem"><div align="center"><span class="Estilo11"><? echo $dias_semana[18];?></span></div></td>
    <td class="subitem"><div align="center"><span class="Estilo11"><? echo $dias_semana[19];?></span></div></td>
    <td class="subitem"><div align="center"><span class="Estilo11"><? echo $dias_semana[20];?></span></div></td>
    <td class="subitem"><div align="center"><span class="Estilo11"><? echo $dias_semana[21];?></span></div></td>
    <td class="subitem"><div align="center"><span class="Estilo11"><? echo $dias_semana[22];?></span></div></td>
    <td class="subitem"><div align="center"><span class="Estilo11"><? echo $dias_semana[23];?></span></div></td>
    <td class="subitem"><div align="center"><span class="Estilo11"><? echo $dias_semana[24];?></span></div></td>
    <td class="subitem"><div align="center"><span class="Estilo11"><? echo $dias_semana[25];?></span></div></td>
    <td class="subitem"><div align="center"><span class="Estilo11"><? echo $dias_semana[26];?></span></div></td>
    <td class="subitem"><div align="center"><span class="Estilo11"><? echo $dias_semana[27];?></span></div></td>
    <td class="subitem"><div align="center"><span class="Estilo11"><? echo $dias_semana[28];?></span></div></td>
    <td class="subitem"><div align="center"><span class="Estilo11"><? echo $dias_semana[29];?></span></div></td>
    <td class="subitem"><div align="center"><span class="Estilo11"><? echo $dias_semana[30];?></span></div></td>
	<? if($mes!=4 || $mes!=6 || $mes!=9 || $mes!=11){?>
    <td class="subitem"><div align="center"><span class="Estilo11"><? echo $dias_semana[31];?></span></div></td>
	<? } ?>
    <td width="37"><span class="Estilo11">TOTAL</span></div></td>   
  </tr>
  <tr>
    <td height="28">&nbsp;</td>
    <td class="subitem"><div align="center"><span class="Estilo11"><? echo $dias_letra[1];?></span></div></td>
    <td class="subitem"><div align="center"><span class="Estilo11"><? echo $dias_letra[2];?></span></div></td>
    <td class="subitem"><div align="center"><span class="Estilo11"><? echo $dias_letra[3];?></span></div></td>
    <td class="subitem"><div align="center"><span class="Estilo11"><? echo $dias_letra[4];?></span></div></td>
    <td class="subitem"><div align="center"><span class="Estilo11"><? echo $dias_letra[5];?></span></div></td>
    <td class="subitem"><div align="center"><span class="Estilo11"><? echo $dias_letra[6];?></span></div></td>
    <td class="subitem"><div align="center"><span class="Estilo11"><? echo $dias_letra[7];?></span></div></td>
    <td class="subitem"><div align="center"><span class="Estilo11"><? echo $dias_letra[8];?></span></div></td>
    <td class="subitem"><div align="center"><span class="Estilo11"><? echo $dias_letra[9];?></span></div></td>
    <td class="subitem"><div align="center"><span class="Estilo11"><? echo $dias_letra[10];?></span></div></td>
    <td class="subitem"><div align="center"><span class="Estilo11"><? echo $dias_letra[11];?></span></div></td>
    <td class="subitem"><div align="center"><span class="Estilo11"><? echo $dias_letra[12];?></span></div></td>
    <td class="subitem"><div align="center"><span class="Estilo11"><? echo $dias_letra[13];?></span></div></td>
    <td class="subitem"><div align="center"><span class="Estilo11"><? echo $dias_letra[14];?></span></div></td>
    <td class="subitem"><div align="center"><span class="Estilo11"><? echo $dias_letra[15];?></span></div></td>
    <td class="subitem"><div align="center"><span class="Estilo11"><? echo $dias_letra[16];?></span></div></td>
    <td class="subitem"><div align="center"><span class="Estilo11"><? echo $dias_letra[17];?></span></div></td>
    <td class="subitem"><div align="center"><span class="Estilo11"><? echo $dias_letra[18];?></span></div></td>
    <td class="subitem"><div align="center"><span class="Estilo11"><? echo $dias_letra[19];?></span></div></td>
    <td class="subitem"><div align="center"><span class="Estilo11"><? echo $dias_letra[20];?></span></div></td>
    <td class="subitem"><div align="center"><span class="Estilo11"><? echo $dias_letra[21];?></span></div></td>
    <td class="subitem"><div align="center"><span class="Estilo11"><? echo $dias_letra[22];?></span></div></td>
    <td class="subitem"><div align="center"><span class="Estilo11"><? echo $dias_letra[23];?></span></div></td>
    <td class="subitem"><div align="center"><span class="Estilo11"><? echo $dias_letra[24];?></span></div></td>
    <td class="subitem"><div align="center"><span class="Estilo11"><? echo $dias_letra[25];?></span></div></td>
    <td class="subitem"><div align="center"><span class="Estilo11"><? echo $dias_letra[26];?></span></div></td>
    <td class="subitem"><div align="center"><span class="Estilo11"><? echo $dias_letra[27];?></span></div></td>
    <td class="subitem"><div align="center"><span class="Estilo11"><? echo $dias_letra[28];?></span></div></td>
    <td class="subitem"><div align="center"><span class="Estilo11"><? echo $dias_letra[29];?></span></div></td>
    <td class="subitem"><div align="center"><span class="Estilo11"><? echo $dias_letra[30];?></span></div></td>
	<? if($mes!=4 || $mes!=6 || $mes!=9 || $mes!=11){?>
    <td class="subitem"><div align="center"><span class="Estilo11"><? echo $dias_letra[31];?></span></div></td>
	<? } ?>
    <td>&nbsp;</td>
  </tr>
  <?
  		$ob_reporte = new Reporte();
		$ob_reporte->ano = $ano;
		$ob_reporte->curso = $id_curso;
		$ob_reporte->retirado=1;
		$rs_alumno = $ob_reporte->TraeTodosAlumnos($conn);
		
		for($m=0;$m<@pg_numrows($rs_alumno);$m++){
			$fila_alu = @pg_fetch_array($rs_alumno,$m);
			$ob_reporte->CambiaDato($fila_alu);
			
			$ob_atraso = new Reporte();
			
  ?>
  <tr>
    <td><div align="left" class="Estilo2"><? echo $ob_reporte->Tilde($ob_reporte->nombres);	?></div></td>
  <? 	 for($YYY=0 ; $YYY < $dia_final ; $YYY++)
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
	$ob_atraso->tipo=2;
	$ob_atraso->rut_alumno=$ob_reporte->alumno;
	//$ob_atraso->fecha1=$mes."-"."01-".$nro_ano;
	$ob_atraso->fecha2=$mes."-".$dia_num."-".$nro_ano;
	$rs_atraso = $ob_atraso->Atrasos($conn);
	if(@pg_numrows($rs_atraso)>0){
		$atraso[$m] ="x";
	}else{
		$atraso[$m] ="&nbsp;";
	}
  }
  ?>
    <td><?=$atraso[$m];?></td>
  </tr>
  <? } ?>
</table>
</body>
</html>
