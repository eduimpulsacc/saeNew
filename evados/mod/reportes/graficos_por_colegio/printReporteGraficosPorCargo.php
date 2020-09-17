<? 
session_start();

require "../../../class/Membrete.class.php";
require "../class_reporte/class_sql.php";
include "../graficos/graficos/funciones_php/FusionCharts.php";

//print_r($_POST);

$ob_membrete = new Membrete($_IPDB,$_ID_BASE);
$ob_membrete->estilosae($_INSTIT);
$fila_inst=$ob_membrete->institucion($_INSTIT);
$fila_ano = $ob_membrete->anoescolar($_INSTIT);

$bloque			= $_POST['cmbCARGO'];
$corporacion	= $_POST['cmbCORP'];
$instirucion	= $_INSTIT;
$pauta 			= $_POST['cmbPAUTA'];
$nacional		= $_NACIONAL;
$anos			= explode(",",$_POST['cmbANO']);
$ano			= $anos[1];
$id_ano			= $anos[0];

$ob_reporte = new SQL($_IPDB,$_ID_BASE);
$rs_NomInstit = $ob_reporte->nom_insitit($instirucion);
$nom_instit= pg_result($rs_NomInstit,0);

$rs_NomCorp = $ob_reporte->Corp_insti($instirucion);
$nom_corp= pg_result($rs_NomCorp,0);

$rs_NomPauta = $ob_reporte->PautaEvaluacion($pauta);
$nom_pauta= pg_result($rs_NomPauta,3);


?>
<script> 
function cerrar(){ 
window.close() 
} 

function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}

</script>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<title>SISTEMA EVALUACI&Oacute;N DOCENTES</title>
</head>

<body>
<div id="capa0">
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><div align="right">
      <input type="submit" name="Submit" value="IMPRIMIR"  class="botonXX" onclick="imprimir()"/>
      <input type="submit" name="Submit2" value="CERRAR" class="botonXX" onclick="window.close()"/>
    </div></td>
  </tr>
</table>
</div>
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
    <td width="463" class="textosimple">&nbsp;<?=trim($nom_corp);?></td>
  </tr>
  <tr>
    <td width="149" class="textonegrita">Instituci&oacute;n  </td>
    <td width="24" class="textonegrita"><div align="center">:</div></td>
    <td width="463" class="textosimple">&nbsp;<? echo (trim($fila_inst['nombre_instit'])) ?></td>
  </tr>
  <tr>
    <td class="textonegrita">Pauta </td>
    <td class="textonegrita"><div align="center">:</div></td>
    <td class="textosimple">&nbsp;<?=trim($nom_pauta);?></td>
  </tr>
  
  <tr>
    <td class="textonegrita">Datos</td>
    <td class="textonegrita"><div align="center">:</div></td>
    <td class="textosimple">&nbsp;<? echo ($tipo==1)?"Ponderados":"Sin Ponderar";?></td>
  </tr>
</table>
<br />
<br />
<div id="maestro_chart" align="center">
<?

 /*[cmbANO][cmbCORP][cmbINST][cmbCARGO][cmbPAUTA][cmbDIMENSION]*/ 

		$colores =  array('AFD8F8','F6BD0F','8BBA00','FF8E46','008E8E');
		$datos_1 = "";
	    $datos_2 = "";
		
	    $results_ = $ob_reporte->resultados_totales_xconceptos_mas_porcentajes( 
	    $ano,$nacional,$_POST['cmbCORP'],$id_ano,$_POST['cmbCARGO'],
		$_POST['cmbGRUPO'],$_POST['cmbPAUTA'],$_POST['cmbDIMENSION'],$_POST['cmbFUNCION'],
		$_POST['cmbINDICADOR'] );
	
	   for ($itx=0; $itx < pg_num_rows($results_) ; $itx++) { 
	   
	    $fila_ = pg_fetch_array($results_,$itx); 
			
		    $_sigla = $fila_['sigla'];
		    $_total_en_porcentaje =  $fila_['total_en_porcentaje'];
			$_total_xconcepto =  $fila_['total_xconcepto'];
		    $color = $colores[$itx];
			
	   $datos_1 .= "<set   label = '$_sigla '   value ='$_total_en_porcentaje'   color = '$color'  />";
	   
	   $datos_2 .= "<set   label = '$_sigla '   value ='$_total_xconcepto'   color = '$color'  />";
	   
	   }				 


   $results_ = $ob_reporte->total_respuestas(
                   $ano,$nacional,$_POST['cmbCORP'],
				   $_POST['cmbINST'],$_POST['cmbCARGO'],
				   $_POST['cmbGRUPO'],$_POST['cmbPAUTA'], 
				   $_POST['cmbDIMENSION'],$_POST['cmbFUNCION'],
				   $_POST['cmbINDICADOR'] );
   
   $total_respuestas_totales = pg_result($results_,0);
   
   
// Inicio de Grafico 
$strXML_1 = "";
$strXML_2 = "";

// en porcentaje 
$strXML_1 = "<chart 
caption = 'Grafico Rendimiento por Cargo Evaluado' 
xAxisName='Conceptos' yAxisName='Escala'
decimalPrecision='1' 
divlinedecimalPrecision='0' 
limitsdecimalPrecision='0' 
pieSliceDepth='30'  
>";
$strXML_1 .= $datos_1 ;
$strXML_1 .= "</chart>";
//

// numerico 
$strXML_2 = "<chart 
caption = 'Grafico Rendimiento por Cargo Evaluado' 
xAxisName='Conceptos' 
yAxisName='Escala'
yaxisminvalue='0' 
yAxisMaxValue=' $total_respuestas_totales' 
formatNumber='0' formatNumberScale='0'
adjustDiv='0' numDivLines='3' 
showSum='0' decimals='0' 
decimalPrecision='1' 
divlinedecimalPrecision='0' 
limitsdecimalPrecision='0' >";

$strXML_2 .= $datos_2 ;
$strXML_2 .= "</chart>";
//
    
echo renderChartHTML("../graficos/graficos/swf_charts/Column3D.swf","",$strXML_2,"maestro_chart",450,400,false);
echo renderChartHTML("../graficos/graficos/swf_charts/Pie3D.swf","",$strXML_1,"maestro_chart",450,400,false);
echo renderChartHTML("../graficos/graficos/swf_charts/Line.swf","",$strXML_2,"maestro_chart",450,400,false);

?>
</div>

<br />
<table width="650" border="0" align="center">
  <tr>
      <td class="textosimple"><div align="right"><?
	setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
     $fechaEspañol = strftime("%A %d de %B del %Y");
	 echo $fechaEspañol;?></div></td>
	 
  </tr>
</table>
</body>
</html>
