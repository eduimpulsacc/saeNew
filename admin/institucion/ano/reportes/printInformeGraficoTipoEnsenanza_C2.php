<?php
echo "hola";
require('../../../../util/connect.php');
include('../../../clases/class_Reporte.php');
include('../../../clases/class_Membrete.php');
include('../../../clases/class_MotorBusqueda.php');
include ("FusionCharts.php");
echo "chao";
//$corporacion=$_CORPORACION;
//$mes = $mes;
//$ano = $nro_ano;

//setlocale("LC_ALL","es_ES");
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$periodo		=$cmb_periodos;
	$reporte		=$c_reporte;
	$_POSP = 4;
	$_bot = 8;

	if ($periodo==0){
	   ## nada
	}else{
		 
	$ob_reporte = new Reporte();
	$ob_membrete = new Membrete();	 
	/*******INSITUCION *******************/
	$ob_membrete ->institucion=$institucion;
	$ob_membrete ->institucion($conn);
	
		 
	/********** AÑO ESCOLAR*****************/
	$ob_membrete ->ano = $ano;
	$ob_membrete ->AnoEscolar($conn);
	$nro_ano = $ob_membrete->nro_ano;

	/****************DATOS PERIODO************/
	$ob_membrete ->ano=$ano;
	$ob_membrete ->periodo=$periodo;
	$ob_membrete ->periodo($conn);
	$periodo_pal = $ob_membrete->nombre_periodo . " DEL " . $nro_ano;
	
	//----------------------------------------------------------------------------
	// DATOS CURSO
	//----------------------------------------------------------------------------	
	if ($curso == 0){
		$sql_curso = "select * from curso where id_ano= ".$ano ." order by ensenanza, grado_curso, letra_curso";
		$result_curso = @pg_Exec($conn, $sql_curso);
		}
	}
	
	//------------------------------------------------------------------------------
	
	$ob_motor = new MotorBusqueda();
	$ob_motor ->ano = $ano;
	$resultado_query_cue = $ob_motor ->curso($conn);
  	$suma_promedio = 0; $contador = 0; $anchotabla = 0;
	
	
	for($i=0 ; $i < @pg_numrows($resultado_query_cue) ; $i++){
     $fila = @pg_fetch_array($resultado_query_cue,$i); 
	 $filanex = @pg_fetch_array($resultado_query_cue,$i+1); 
	 $id_curso = $fila['id_curso'];
	 $tipo_ensenanza = $fila['ensenanza'];
	 $tipo_ensenanzanex = $filanex['ensenanza'];
     $Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
	 
	 // aqui tomo todos los promedios de este curso
	 $ob_reporte ->curso =$id_curso;
	 $ob_reporte ->periodo =$periodo;
	 $ob_reporte ->nro_ano =$nro_ano;
	 $ob_reporte ->PromedioRamo($conn);	
	
	 if($ob_reporte->suma > 0){	
		$suma_promedio = ($suma_promedio + $ob_reporte->suma);
		$contador = $contador + $ob_reporte->contador;
	 }
	 $promedio_curso = round($suma_promedio/ $contador);
	 
	 if ($tipo_ensenanza==$tipo_ensenanzanex){
	      // no muestro aun el promedio
		 // y sigo acumulando
	 }else{
	     // muestro el promedio y luego limpio las variables
		 // busco el nombre de tipo de ensenanza
		 $sql_te = "select * from tipo_ensenanza where cod_tipo = '$tipo_ensenanza'";
		 $res_te = @pg_Exec($conn,$sql_te);
		 $fila_te = pg_fetch_array($res_te,0);
		 
		 $nombre_tipo_ensenanza = $fila_te['nombre_tipo'];	
	   
	     // limpio las variables
		 $suma_promedio = 0; $contador = 0;	 
	 }	 
  }
	
	

$a=stripslashes ($_GET[arr_rdb]);
$mi_array=unserialize($a);

$arr1 =serialize($mi_array);
$arr1 = urlencode($arr1);

$b=stripslashes ($_GET[arr_mat_mes]);
$my_array=unserialize($b);

$arr2 = serialize($my_array);
$arr2 = urlencode($arr2);




?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
//-->

function imprimir() {
        document.getElementById("capa0").style.display='none';
        window.print();
        document.getElementById("capa0").style.display='block';
}
</script>
<link href="../estilo1.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.Estilo3 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; }
.Estilo4 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	
}
-->
</style>
<link href="../../../../../estilos.css" rel="stylesheet" type="text/css">
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<div id="capa0">
  <table width="640" border="0" align="center" cellpadding="0" cellspacing="0">
   
    <tr>
      <td align="right" class="textosimple"><div align="left">Tipo de Grafico 
        <input name="opcion" type="radio" value="1" onClick="window.location='graficoTotalMatricula.php?opcion=1&arr_rdb=<?=$arr1;?>&arr_mat_mes=<?=$arr2;?>'" <? if($opcion==1) echo "checked"; else echo "";?>>
      Barras 
      <input name="opcion" type="radio" value="2"   onClick="window.location='graficoTotalMatricula.php?opcion=2&arr_rdb=<?=$arr1;?>&arr_mat_mes=<?=$arr2;?>'"  <? if($opcion==2) echo "checked"; else echo "";?>>
      Lineas</div></td>
    </tr>
</table>

</div>
<br>
<table width="640" border="1" align="center" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC" style="border-collapse:collapse">
	<tr>
		<td> 
			<table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" bordercolor="#CCCCCC" class="celdas3">
				<tr>
					<td width="390" align="left"> 
						<table width="100%" border="0" cellpadding="0" cellspacing="0">
							<tr class="celdas3">
								<td width="390" class="Estilo4"> <div align="left"><?  echo "<img src='../images/".$corporacion."_logo.jpg' >"; ?></div></td>
							</tr>
							<tr class="celdas3">
							  <td><div align="left"></div></td>
							</tr>
						</table>					</td>
				</tr>
				<tr>
					<td>
						<BR>
						
						<?php
						
						
						
						// ahora que todo esta en $tabla1(conceptos1-5 , meses 1-12)
						// se lleva el formato grafico
						// los colores
						$cola = "AFD8F8";
						//echo "cola-->".$cola = "9900000";
						//$cola =array("#0033FF","#3498A9","","","","","","","","");
						//Create an XML data document in a string variable
						$strXML  = "";
						$vartitulo =" Grafico Estadistico Matricula Mes ".envia_mes($mes)." del ".$ano;
						$vartituxx =" Tipo de enseñanza";
						$vartituyy =" Rango de Notas";
						$strXML .= "<graph caption='$vartitulo' xAxisName='$vartituxx' yAxisName='$vartituyy' decimalPrecision='0' formatNumberScale='0'>";
						
						if (isset($_GET[arr_rdb])){
							$a=stripslashes ($_GET[arr_rdb]);
						  	$mi_array=unserialize($a);
						   	$b=stripslashes ($_GET[arr_mat_mes]);
            			    $my_array=unserialize($b);
							$i=0;
            		      	foreach ($mi_array AS $clave => $valor):
								$cantidad = $my_array[$i];
            					$nomest=$valor;
								$cantid=$cantidad;
								$colorea=$cola;
								$strXML .= "<set name='$nomest' value='$cantid' color='$colorea' />";
								$i++;
								//$cola+=3050;
							endforeach;
						}
 


						$strXML .= "</graph>";
						
						//Create the chart - Column 3D Chart with data from strXML variable using dataXML method
						//  echo renderChartHTML("FusionCharts/FCF_Column3D.swf", "", $strXML, "myNext", 600, 300);
						
						$ancho=200+(60*10);
						if($opcion==1){
							echo renderChartHTML("../../../../FusionCharts/FCF_Column3D.swf", "", $strXML, "myNext", $ancho, 350);
						}else{
							echo renderChartHTML("../../....//FusionCharts/FCF_Line.swf", "", $strXML, "myNext", $ancho, 350);
						}	
						
						?>
					</td>
						
				</tr>
				
			</table>
		</td>
	</tr>
</table>

<br>
</body>
</html>
