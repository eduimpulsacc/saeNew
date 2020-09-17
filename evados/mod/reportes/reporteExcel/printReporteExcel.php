<? 
session_start();

require "../../../class/Membrete.class.php";
require "../class_reporte/class_sql.php";

//print_r($_POST);  

$ob_membrete = new Membrete($_IPDB,$_ID_BASE);
$ob_membrete->estilosae($_INSTIT);
$fila_inst=$ob_membrete->institucion($_INSTIT);
$fila_ano = $ob_membrete->anoescolar($_INSTIT);

$pauta = $_POST['cmbPAUTA'];
$corporacion = $_POST['cmbCORP'];
$instirucion = $_POST['cmbINST'];
$nacional = $_NACIONAL;
$ano = $_POST['cmbANO'];

$ob_reporte = new SQL($_IPDB,$_ID_BASE);
$rs_NomInstit = $ob_reporte->nom_insitit($instirucion);
$nom_instit= pg_result($rs_NomInstit,0);

$result = $ob_reporte->exportar_dataexel( $pauta,$corporacion,$instirucion,$nacional,$ano );
$nom_Corp= pg_result($result,0);
$nom_Pauta= pg_result($result,4);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<title>SISTEMA EVALUACI&Oacute;N DOCENTES</title>
</head>

<body>
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><div align="right">
      <input type="submit" name="Submit" value="IMPRIMIR"  class="botonXX"/>
      <input type="submit" name="Submit2" value="CERRAR" class="botonXX" onclick="window.close()"/>
    </div></td>
  </tr>
</table>
<br />
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>

    <td width="114" class="textonegrita"><div align="left"><strong>INSTITUCI&Oacute;N</strong></div></td>
    <td width="9" class="textonegrita"><strong>:</strong></td>
    <td width="361" class="textonegrita"><div align="left"><? echo strtoupper(trim($fila_inst['nombre_instit'])) ?></div></td>
    <td width="161" rowspan="9" align="center" valign="top" ><img src="../../../../cortes/<?=$_INSTIT?>/insignia.jpg" width="100" height="100" /></td>
  </tr>
  <tr>
    <td class="textonegrita"><div align="left"><strong>A&Ntilde;O ESCOLAR</strong></div></td>
    <td class="textonegrita"><strong>:</strong></td>
    <td class="textonegrita"><div align="left"><? echo trim($fila_ano['nro_ano']) ?></div></td>
  </tr>
  <tr>
    <td class="textonegrita">&nbsp;</td>
    <td class="textonegrita">&nbsp;</td>
    <td class="textonegrita">&nbsp;</td>
  </tr>
  <tr>
    <td class="textonegrita">&nbsp;</td>
    <td class="textonegrita">&nbsp;</td>
    <td class="textonegrita">&nbsp;</td>
  </tr>
</table>
<br />
<table width="650" border="0" align="center">
  <tr>
    <td class="cuadro02"><div align="center">REPORTE EVALUADO </div></td>
  </tr>
</table>
<br />
<table width="650" border="0" align="center">
  <tr>
    <td width="149" class="textonegrita">Corporaci&oacute;n </td>
    <td width="24" class="textonegrita"><div align="center">:</div></td>
    <td width="463" class="textosimple">&nbsp;<?=trim($nom_Corp);?></td>
  </tr>
  <tr>
    <td width="149" class="textonegrita">Instituci&oacute;n  </td>
    <td width="24" class="textonegrita"><div align="center">:</div></td>
    <td width="463" class="textosimple">&nbsp;<?=trim($nom_instit) ?></td>
  </tr>
  <tr>
    <td class="textonegrita">Pauta</td>
    <td class="textonegrita"><div align="center">:</div></td>
    <td class="textosimple">&nbsp;<?=trim($nom_Pauta);?></td>
  </tr>
  
  <tr>
    <td class="textonegrita">Datos</td>
    <td class="textonegrita"><div align="center">:</div></td>
    <td class="textosimple">&nbsp;<? echo ($tipo==1)?"Ponderados":"Sin Ponderar";?></td>
  </tr>
</table>
<br />

<table border="1" >
<td>nombre_corporacion</td>
<td>rdb</td>
<td>nombre_institucion</td>
<td>nombre_bloque</td>
<td>nombre_pauta</td>
<td>nombre_funcion</td>
<td>nombre_dimencion</td>
<td>nombre_indicador</td>
<td>nombre_dimencion</td>
<td>sigla</td>
<td>categoria</td>
<td>concepto</td>
</tr>

<?php 
$result = $ob_reporte->exportar_dataexel( $pauta,$corporacion,$instirucion,$nacional,$ano );

 for( $xk = 0 ; $xk < pg_numrows($result); $xk++ ){
	 
	 $_fila = pg_fetch_array($result,$xk);	
     
     echo "<tr>";					 
	 echo "<td>".$_fila['nombre_corporacion']."</td>";
	 echo "<td>".$_fila['rdb']."</td>";
	 echo "<td>".$_fila['nombre_institucion']."</td>";
	 echo "<td>".$_fila['nombre_bloque']."</td>";
	 echo "<td>".$_fila['nombre_pauta']."</td>";
	 echo "<td>".$_fila['nombre_funcion']."</td>";
	 echo "<td>".$_fila['nombre_dimencion']."</td>";
	 echo "<td>".$_fila['nombre_indicador']."</td>";
	 echo "<td>".$_fila['nombre_dimencion']."</td>";
	 echo "<td>".$_fila['sigla']."</td>";
	 echo "<td>".$_fila['categoria']."</td>";
	 echo "<td>".$_fila['concepto']."</td>";
	 echo "</tr>";
	
	}

 ?>
	
</table>


<br />
<table width="650" border="0" align="center">
  <tr>
  
    <td class="textosimple"><div align="right"><?
	setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
     $fechaEspa�ol = strftime("%A %d de %B del %Y");
	 echo $fechaEspa�ol;?></div></td>
	 
  </tr>
</table>
</body>
</html>
