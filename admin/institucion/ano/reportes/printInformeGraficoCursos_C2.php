<?php

require('../../../../util/header.inc');
include('../../../clases/class_Reporte.php');
include('../../../clases/class_Membrete.php');
include('../../../clases/class_MotorBusqueda.php');
include ("FusionCharts.php");

//print_r($_GET);

//setlocale("LC_ALL","es_ES");
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$periodo		=$cmb_periodos;
	$reporte		=$c_reporte;
	$_POSP = 4;
	$_bot = 8;
   
	$ob_membrete = new Membrete();
	$ob_reporte = new Reporte();
	
	$ob_membrete ->institucion = $institucion;
	$ob_membrete ->institucion($conn);
	
	$ob_membrete ->ano =$ano;
	$ob_membrete ->AnoEscolar($conn);
	
	//-------------------------	 CONFIGURACION DE REPORTE ------------------
	$ob_config = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=1;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = @pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);
	
	
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
		$sql_curso = "select * from curso where id_ano= ".$ano ." and curso.ensenanza=".$cmb_ense." order by ensenanza, grado_curso, letra_curso";
		$result_curso = @pg_Exec($conn, $sql_curso);
		}
	}
	
	//------------------------------------------------------------------------------
	
	if($opcion==NULL){
	
	$ob_motor = new MotorBusqueda();
	$ob_motor ->ano = $ano;
	$ob_motor ->Ensenanza = $cmb_ense;
	$resultado_query_cue = $ob_motor ->curso_ensenanza($conn);
  // aqui muestro todos los curso de la institución
  
  for($i=0 ; $i < @pg_numrows($resultado_query_cue) ; $i++){
     $fila = @pg_fetch_array($resultado_query_cue,$i); 
	 $id_curso = $fila['id_curso'];
     $Curso_pal =$fila['grado_curso'].'-'.$fila['letra_curso'];
	 
	 // aqui tomo todos los promedios de este curso
	 $ob_reporte ->curso =$id_curso;
	 $ob_reporte ->periodo =$periodo;
	 $ob_reporte ->nro_ano =$nro_ano;
	 $ob_reporte ->PromedioRamo($conn);
	
	 $promedio_curso = @intval($ob_reporte->suma/ $ob_reporte->contador);
	 $arr_curso[] = $Curso_pal;
	 $arr_promedios[] = $promedio_curso;

	
		}
	}

	

//-------------------------------------------------------------------------------------------------------//


if($opcion!=NULL){ // SI ES QUE OPCION NO VIENE VACIO TOMA CON GET LOS ARREGLOS Y LOS DESERIALIZA PARA GRAFICARLOS, DE CASO CONTRARIO SOLO LOS SERIALIZA LOS ARREGLOS PARA LOS CAMBIOS DE GRAFIOS (DE BARRAS A LINEA O VICEVERSA).

$a=stripslashes ($_GET[arr_curso]);
$mi_array=unserialize($a);

$b=stripslashes ($_GET[arr_promedios]);
$my_array=unserialize($b);

$arr1 =serialize($mi_array);
$arr2 =serialize($my_array);

}else{

$arr1 =serialize($arr_curso);
$arr2 =serialize($arr_promedios);

}

$arr1 = urlencode($arr1);
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
<script type="text/javascript" src="../../../clases/highcharts/js/highcharts2.js"></script>
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
<style type="text/css">
.item { font-family:<?=$ob_config->letraI;?>;
 font-size:<?=$ob_config->tamanoI;?>px;
}
</style>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<div id="capa0">
  <table width="640" border="0" align="center" cellpadding="0" cellspacing="0">
   
    <tr>
    
      <td align="right" class="textosimple"><div align="left">Tipo de Grafico 
        <input name="opcion" type="radio" value="1" onClick="window.location='printInformeGraficoCursos_C2.php?opcion=1&arr_curso=<?=$arr1;?>&arr_promedios=<?=$arr2;?>&c_reporte=<?=$reporte;?>'" <? if($opcion==1) echo "checked"; else echo "";?>>
      Barras 
      <input name="opcion" type="radio" value="2"   onClick="window.location='printInformeGraficoCursos_C2.php?opcion=2&arr_curso=<?=$arr1;?>&arr_promedios=<?=$arr2;?>&c_reporte=<?=$reporte;?>'"  <? if($opcion==2) echo "checked"; else echo "";?>>
      Lineas</div></td>
      <td>
    <div align="right">
          <input name="button3" type="button" class="botonXX" onClick="imprimir();" value="IMPRIMIR">
        </div>
        <td>
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
                        <tr>
                        <td><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
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
                                  <? } ?></td>
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
                            <td height="41" valign="top">&nbsp;</td>
                            <td>&nbsp;</td>
                          </tr>
                        </table></td>
                        </tr>
                        
							<tr class="celdas3">
								<td width="390" class="Estilo4"> <!--<div align="left"><?  //echo "<img src='../images/".$corporacion."_logo.jpg' >"; ?></div>--></td>
							</tr>
							<tr class="celdas3">
							  <td>
                                  <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
                              
                              </td>
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
						$vartitulo ="RENDIMIENTO GRÁFICO POR CURSO DEL ".$nro_ano;
						$vartituxx ="Cursos";
						$vartituyy =" Rango de Notas";
						$strXML .= "<graph caption='$vartitulo' xAxisName='$vartituxx' yAxisName='$vartituyy' decimalPrecision='0' formatNumberScale='0'>";
						
						if (isset($arr_curso)){
						   	if($cb_ok!=NULL){ // SI ES QUE VIENE DIRECTO DESDE LA PAGINA InformeGraficoCursos_C.php
							$mi_array = $arr_curso;
            			    $my_array = $arr_promedios;
							}
							
							$i=0;
            		      	foreach ($mi_array AS $clave => $valor):
								$cantidad = $my_array[$i];
            					$nomest=$valor;
								$cantid=$cantidad;
								$colorea=$cola;
								;
								$i++;
								//$cola+=3050;
							endforeach;
						}
 


					
						
						//Create the chart - Column 3D Chart with data from strXML variable using dataXML method
						//  echo renderChartHTML("FusionCharts/FCF_Column3D.swf", "", $strXML, "myNext", 600, 300);
						
						$ancho=200+(60*10);
						/*if($opcion==1){
							echo renderChartHTML("../../../../FusionCharts/FCF_Column3D.swf", "", $strXML, "myNext", $ancho, 350);
						}else{
							echo renderChartHTML("../../../../FusionCharts/FCF_Line.swf", "", $strXML, "myNext", $ancho, 350);
						}	*/
						
						?>
					</td>
						
				</tr>
                <tr>
                <td><table width="650" border="0" align="center">
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
                </table></td>
                </tr>
				
			</table>
		</td>
	</tr>
</table>

<script>

Highcharts.chart('container', {
    chart: {
        type: '<?php echo ($opcion==2 || $opcion=="")?"line":"column"; ?>'
    },
    title: {
        text: 'Rendimiento gráfico por curso'
    },
    subtitle: {
        text: ''
    },
	credits: {
        enabled: false
    },
    xAxis: {
        type: 'category',
        labels: {
            rotation: -45,
            style: {
                fontSize: '13px',
                fontFamily: 'Verdana, sans-serif'
            }
        }
    },
    yAxis: {
       min: 0,
            max: 70,
            tickInterval: 10,
        title: {
            text: 'Rango de notas',
			
        }
    },
    legend: {
        enabled: false
    },
    tooltip: {
        pointFormat: 'Promedio curso: <b>{point.y:.0f} </b>'
    },
    series: [{
        name: 'Promedio curso',
        data: [
		<?php 
		$i=0;
		foreach ($mi_array AS $clave => $valor):
			$cantidad = $my_array[$i];
			$nomest=$valor;
			$cantid=$cantidad;
			$colorea=$cola;
			$strXML .= "<set name='$nomest' value='$cantid' color='$colorea' />";
			$i++;
			//$cola+=3050;?>
			
			 ['<?php echo $nomest ?>', <?php echo $cantid ?>],
			 <?
		endforeach;
						
		?>
           
           
        ],
        dataLabels: {
            enabled: true,
            rotation: -90,
            color: '#000',
            align: 'right',
            format: '{point.y:.0f}', // one decimal
            y: 10, // 10 pixels down from the top
            style: {
                fontSize: '13px',
                fontFamily: 'Verdana, sans-serif'
            }
        }
    }]
});

</script>

<br>
</body>
</html>
