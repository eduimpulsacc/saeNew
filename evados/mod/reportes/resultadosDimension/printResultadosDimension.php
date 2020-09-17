<? 
header( 'Content-type: text/html; charset=iso-8859-1' );


session_start();

require "../class_reporte/class_reporte.php";


$ano = explode("-",$cmbANO);
$periodo = explode("-",$cmbPERIODO);
$cargo = explode("-",$cmbCARGO);

$ob_reporte = new Reporte($_IPDB,$_ID_BASE);

$fila_instit = $ob_reporte->Membrete($_INSTIT);

$nacional = $_NACIONAL;


$periodo 	= explode("-", $cmbPERIODO);
$cargo		= explode(",", $cmbCARGO);

//$area =  $ob_reporte->listaAreas($cmbPAUTA,$nacional,$ano[0],$periodo[0]);
$area = $ob_reporte->dimensionPauta($cmbPAUTA,$ano[0]);

$escala = $ob_reporte->escalaGeneral();


 function  Iniciales($Subsector)
{
	$largo = strlen($Subsector);
	for($cont_letras=0 ; $cont_letras < $largo  ; $cont_letras++)
	{
		if ($cont_letras == 0)
		{
			$cadena = strtoupper(substr($Subsector,0,1));
			$cont_letras = 1;
		}
		$letra_query = substr($Subsector,$cont_letras,1);
		if (strlen(trim($letra_query)) == 0)
			if (substr($Subsector,$cont_letras+1,1) == "(")
				$cont_letras = $largo;
			else
				$cadena = $cadena . strtoupper(substr($Subsector,$cont_letras+1,1));
		if (strlen($cadena)==6 )
			$cont_letras = $largo;
	}	
	if (strlen(trim($cadena))==1)
		return trim(strtoupper(substr($Subsector,0,3)));
	else
		return trim($cadena);
}	


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

</script><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=latin9" />
<link href="../../../css/estilos.css" rel="stylesheet" type="text/css">
<title>SISTEMA EVALUACI&Oacute;N DOCENTE</title>
<script src="https://code.highcharts.com/highcharts.js"></script>
</head>
<body>
<div id="capa0">
<table width="650" border="0" align="center">
  <tr>
    <td><input name="button" type="submit" class="report" id="button" value="CERRAR" onClick="cerrar()" /></td>
    <td align="right"><input name="button2" type="submit" class="report" id="button2" value="IMPRIMIR"  onClick="imprimir();"/></td>
  </tr>
</table>
</div><br />
<table width="650" border="0" align="center">
  <tr>
    <td  align="center" valign="middle">
    <?php include('../cabecera/cabecera.php');?>
    </td>
  </tr>
  <tr>
    <td colspan="3" align="center" valign="middle"><table width="650" border="0">
      <tr>
        <td colspan="2" align="center" class="textonegrita"><u>EVALUACION DOCENTE - <?=$periodo[1]."&nbsp;".$ano[1];?> </u> </td>
        </tr>
      <tr>
        <td colspan="2">&nbsp;</td>
        </tr>
      <tr>
        <td width="11%" class="listadetalleoff">PAUTA:</td>
        <td width="89%" class="textosimple">&nbsp;<span class="listadetalleoff"><?php echo $cargo[1] ?></span></td>
      </tr>
      <!--<tr>
        <td class="listadetalleoff">EVALUACIONES PROYECTADAS:</td>
        <td class="textosimple">&nbsp;<?=$pendientes['primera'];?></td>
      </tr>
      <tr>
        <td class="listadetalleoff">EVALUACIONES REALIZADAS:</td>
        <td class="textosimple">&nbsp;<?=$realizadas['primera'];?></td>
      </tr>-->
      <tr>
        <td class="listadetalleoff">&nbsp;</td>
        <td class="textosimple">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" class="listadetalleoff">&nbsp;</td>
        </tr>
      <tr>
        <td colspan="2">
       
        <table width="100%" border="1" style="border-collapse:collapse">
          <tr class="tabla01">
            <td>DIMENSI&Oacute;N</td>
            <td>RESULTADO</td>
            </tr>
           <?php for($e=0;$e<pg_numrows($area);$e++){
			  
				$fila = pg_fetch_array($area,$e);
				$nombre_area = $fila['nombre'];
				$id_area = $fila['id_area'];
				$id_plantilla = $cmbPAUTA;
                
				
				
			?>	
          <tr>
            <td class="textosimple"><b> <?php echo strtoupper($nombre_area) ?></b></td>
            <td class="textosimple">
           <?php  $valo = $ob_reporte->evaluacionPauta($ano[0],$periodo[0],$id_plantilla,$id_area);
		   echo $valo[$id_area][1]." (". $valo[$id_area][0].")";
		   ?>
            
            </td>
            </tr>
          
       
          
         <?php }?>
        </table>
       
        </td>
       
      </tr>
    </table></td>
  </tr>
</table><br />
<br />

<div id="container" style="width: 650px; height: 400px; margin: 0 auto" align="center"></div>
</body>
<script>
// Data retrieved from http://vikjavev.no/ver/index.php?spenn=2d&sluttid=16.06.2015.

Highcharts.chart('container', {
    chart: {
        type: 'spline',
        scrollablePlotArea: {
            minWidth: 600,
            scrollPositionX: 1
        }
    },
    title: {
        text: ''
    },
    subtitle: {
        text: ''
    },
	

    credits: {
        enabled: false
    },
  xAxis: {
    categories: [
	 <?php for($e=0;$e<pg_numrows($area);$e++){
	$fila = pg_fetch_array($area,$e);
	$nombre_area = $fila['nombre'];
	?>
	'<?php echo Iniciales($nombre_area) ?>',
	 <?php  } ?>
	]
  },
   
    yAxis: {
        title: {
            text: 'Rango Alcanzado'
        },
		min: 0, 
		max: 100,
       
		//rangos escala
        plotBands: [
		<?php for($e=0;$e<pg_numrows($escala);$e++){
		$fescala = pg_fetch_array($escala,$e);
		$color=($e%2==0)?"0,0,0,0"	:"68, 170, 213, 0.1";
		?> 
		
		{ // Light air
            from: <?php echo $fescala['desde'] ?>,
            to: <?php echo $fescala['hasta'] ?>,
            color: 'rgba(<?php echo $color ?>)',
            label: {
                text: '<?php echo $fescala['concepto'] ?>',
                style: {
                    color: '#606060'
                }
            }
        },
		<?php }?>
		]
    },
    tooltip: {
        valueSuffix: ' %'
    },
    plotOptions: {
        spline: {
            lineWidth: 4,
            states: {
                hover: {
                    lineWidth: 5
                }
            },
            marker: {
                enabled: true
            },
			dataLabels: {
                enabled: true
            }
        }
    },
    series: [
			{
			name: 'Rango Alcanzado',
			data: [	
			<?php for($e=0;$e<pg_numrows($area);$e++){
			  
				$fila = pg_fetch_array($area,$e);
				$nombre_area = $fila['nombre'];
				$id_area = $fila['id_area'];
				$id_plantilla = $cmbPAUTA;
				
				$valo = $ob_reporte->evaluacionPauta($ano[0],$periodo[0],$id_plantilla,$id_area);
				?>
			['<?php echo $nombre_area ?>', <?php echo $valo[$id_area][0] ?>],
			<?php  } ?>
			
																				]
			}
	
	],
    navigation: {
        menuItemStyle: {
            fontSize: '10px'
        }
    }
});
</script>
</html>
