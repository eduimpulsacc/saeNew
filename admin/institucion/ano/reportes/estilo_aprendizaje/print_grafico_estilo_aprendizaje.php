<?	
	require('../../../../../util/header.inc');
	require('../../../../../util/LlenarCombo.php3');
	require('../../../../../util/SeleccionaCombo.inc');
	include('../../../../clases/class_Reporte.php');
	include('../../../../clases/class_Membrete.php');
	include('../../../../clases/class_MotorBusqueda.php');
	
	//print_r($_POST);

	$institucion	=$_INSTIT	;
	$ano			=$_ANO	;
	$curso			=($select_curso==0)?1:$select_curso;
	$reporte		=$c_reporte;
	$_POSP = 4;
	$_bot = 8;
	
	
	$ob_membrete = new Membrete();
	$ob_reporte = new Reporte();
	
	$ob_membrete ->institucion = $institucion;
	$ob_membrete ->institucion($conn);
	
	$ob_membrete ->ano =$ano;
	$ob_membrete ->AnoEscolar($conn);
	
	$ob_reporte->ano=$ano;
	$nro_ano=$ob_membrete->nro_ano;
	$ob_reporte->nro_ano =$ob_membrete->nro_ano;
	$ob_reporte->mes = $mes;
	


//echo habiles();
	
	
	
	//-------------------------	 CONFIGURACION DE REPORTE ------------------
	$ob_config = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=1;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = @pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);


	
?>
<script>
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
<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<style type="text/css">
<!--
.Estilo2 {font-weight: bold}
-->
</style>
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
 .fuente
 {
 font-size:10px;
 color:#000000;
 }	
.Estilo1 {
	font-size: 12px;
	font-weight: bold;
}


@media all {
   div.saltopagina{
      display: none;
   }
}
   
@media print{
   div.saltopagina{ 
      display:block; 
      page-break-before:always;
   }
}

</style>
<script type="text/javascript" src="../../../../clases/jquery/jquery.js"></script>
<script type="text/javascript" src="../../../../clases/highcharts/js/highcharts.js"></script>


<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../cortes/b_ayuda_r.jpg','../../../../../cortes/b_info_r.jpg','../../../../../cortes/b_mapa_r.jpg','../../../../../cortes/b_home_r.jpg')">
<div id="capa0">
<table width="650" border="0" align="center">
  <tr>
    <td width="25%"><input type="button" name="Submit" value="CERRAR" onClick="window.close()" class="botonXX"/></td>
    <td class="textosesion"><div align="center"></div></td>
    <td width="25%"><div align="right">
      <input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR" />
    </div></td>
  </tr>
</table>
</div>
<BR /><BR />
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
   <tr>
    <td width="697"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong><? echo ucwords(strtoupper($ob_membrete->ins_pal));?></strong></font></td>
    <td width="10">&nbsp;</td>
    <td width="125" rowspan="4" align="center">
		<table width="125" border="0" cellpadding="0" cellspacing="0">
          <tr valign="top">
            <td width="125" align="center">
                       <?
						if($institucion!=""){
						   echo "<img src='".$d."../tmp/".$institucion."insignia". "' >";
						}else{
						   echo "<img src='".$d."menu/imag/logo.gif' >";
						}?>	
	  
	  
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
            <td height="41" valign="top">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>  
</table>



<p>&nbsp;</p>
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  
  <tr>
    <td align="center"><span class="Estilo2"><strong>&nbsp;</strong></span></td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td align="center"><div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div></td>
  </tr>
</table>
<br>
<br>


 <?php  
		 $ruta_timbre =5;
		 $ruta_firma =3;
		 include("../firmas/firmas.php");?>
</body>
<?php $rs_serie=$ob_reporte->estiloAprendizajeTabla($conn);  ?>
<script>
$(function () {
    $('#container').highcharts({
		 chart: {
        type: 'column'
    },
    title: {
        text: 'Estadísticas estilos de aprendizaje'
    },
    subtitle: {
        text: '<?php echo ($select_curso==0)?"INSTITUCIÓN":CursoPalabra($select_curso,1,$conn); ?>'
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
        title: {
            text: 'Cantidad de alumnos'
        }
    },
    legend: {
        enabled: false
    },
    tooltip: {
        pointFormat: '<b>{point.y:.0f} alumnos</b>'
    },
    series: [{
        name: 'Population',
        data: [
		<?php for($s=0;$s<pg_numrows($rs_serie);$s++){
			$fila_serie=pg_fetch_array($rs_serie,$s);
			
			$ob_reporte->idc=$select_curso;
			$ob_reporte->ano=$ano;
			$ob_reporte->estilo = $fila_serie['id_estilo'];
			$rs_cuenta = $ob_reporte->conteoEstiloAprendizaje($conn);
			
			
			?>
           
             ['<?php echo $fila_serie['nombre'] ?>', <?php echo pg_result($rs_cuenta,0) ?>],
		<?php }?>
           
            
        ],
        dataLabels: {
            enabled: true,
            rotation: -90,
            color: '#FFFFFF',
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
});
</script>

</html>
