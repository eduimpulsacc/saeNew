<?php require('../../../../../../util/header.inc');

include('../../../../../clases/class_Reporte.php');
	include('../../../../../clases/class_Membrete.php');



	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=($cmb_curso!=0)?$cmb_curso:1;
	 $reporte		=$c_reporte;
	$fecha_ini=$fecha_ini;
	$fecha_fin = $fecha_fin;
	
	$ob_reporte = new Reporte();
	$ob_membrete = new Membrete();
	
	
	
	/*******INSITUCION *******************/
	$ob_membrete ->institucion=$institucion;
	$ob_membrete ->institucion($conn);
	
		 
	/********** AÑO ESCOLAR*****************/
	$ob_membrete ->ano = $ano;
	$ob_membrete ->AnoEscolar($conn);
	$nro_ano = $ob_membrete->nro_ano;
	
	
	//-------------------------	 CONFIGURACION DE REPORTE ------------------
	$ob_config = new Reporte();
	$ob_reporte = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=$curso;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = @pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);
	
			  


$ob_reporte->rdb = $institucion;
$ob_reporte->desde = CambioFE($desde);
$ob_reporte->hasta = CambioFE($hasta);

$rs_atenciones=$ob_reporte->cuentaDescarga($conn);
 $cont_atencion = pg_numrows($rs_atenciones);


?>
<?
	$sql_institu = "SELECT institucion.rdb, institucion.dig_rdb, institucion.nombre_instit, institucion.calle, institucion.nro, institucion.telefono, region.nom_reg, provincia.nom_pro, comuna.nom_com ";
	$sql_institu = $sql_institu . "FROM ((institucion INNER JOIN region ON institucion.region = region.cod_reg) INNER JOIN provincia ON (institucion.ciudad = provincia.cor_pro) AND (region.cod_reg = provincia.cod_reg)) INNER JOIN comuna ON (provincia.cod_reg = comuna.cod_reg) AND (provincia.cor_pro = comuna.cor_pro) AND (institucion.comuna = comuna.cor_com) ";
	$sql_institu = $sql_institu . "WHERE (((institucion.rdb)=".$institucion.")); ";
	
	
	$result_institu =@pg_Exec($conn,$sql_institu);
	$fila_institu = @pg_fetch_array($result_institu,0);
	$rdb = $fila_institu['rdb'] . "-" . $fila_institu['dig_rdb'];
	$nombre_institu = ucwords(strtolower($fila_institu['nombre_instit']));
	$direccion = ucwords(strtolower($fila_institu['calle'] . " " . $fila_institu['nro']));
	$telefono = $fila_institu['telefono'];
	$comuna = ucwords(strtolower($fila_institu['nom_com']));
	$ciudad = ucwords(strtolower($fila_institu['nom_pro']));
	$region = ucwords(strtolower($fila_institu['nom_reg']));
?>


<script language="javascript" type="text/javascript">
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
//-->

function cerrar(){ 
	window.close() 
} 
</script>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=latin-9" />
<link href="../../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../../../../../clases/jquery/jquery.js"></script>
<script type="text/javascript" src="../../../../../clases/highcharts/js/highcharts.js"></script>
<script type="text/javascript" src="../../../../../clases/highcharts/js/modules/exporting.js"></script>
<script>

$(function () {
    // Create the chart
    $('#container').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: 'Descarga de reportes'
        },
        subtitle: {
            text: 'Periodo <?php echo $desde ?> a <?php echo $hasta ?>.'
        },
        xAxis: {
            type: 'category'
        },
        yAxis: {
            title: {
                text: 'Cantidad de dscargas'
            }

        },
        legend: {
            enabled: false
        },
        plotOptions: {
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                    format: '{point.y:.0f}'
                }
            }
        },

        tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.0f}</b> descargas<br/>'
        },

        series: [{
            name: 'Reporte',
            colorByPoint: true,
			data: [
			<?php for($a=0;$a<pg_numrows($rs_atenciones);$a++){
				$fila = pg_fetch_array($rs_atenciones,$a);
				$ob_reporte->item_reporte= $fila['id_reporte'];
				$d_reporte=$ob_reporte->ListaReporte($conn);
				$f_item = pg_fetch_array($d_reporte,0);
				?>
			{ 
                name: '<?php echo $f_item['nombre'] ?>',
                y: <?php echo $fila['conteo'] ?>
              
            },
			<?php }?>
			]
        }]
    });
});
</script>
<title>INFORME DE INFORMES DESCARGADOS</title>
<STYLE>
  H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always; height:0;line-height:0
 }
 .titulo
 {
 font-family:<?=$ob_config->letraT;?>;
 font-size:<?=$ob_config->tamanoT;?>px;
 }
 .item
 {
 font-family:Arial, Helvetica, sans-serif;
 font-size:11px;

 }
 .subitem
 {
 font-family:Arial, Helvetica, sans-serif;
 font-size:11px;
 }
.textoverital{writing-mode: tb-rl;filter: flipv fliph;}

.rojo{color:red;}
.azul{color:black;}
</style>
</head>
<!--onLoad="window.print()"-->
<body >
<div id="capa0">
<table width="650" align="center">
  <tr>
    <td width="188"><input name="button4" type="button" class="botonXX" onClick="cerrar()"  value="CERRAR" /></td>
    <td width="367" align="right"><input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR" /></td>
    <td width="79" align="right"></td>
  </tr>
</table>
</div>
<?php 	
if($cont_atencion>0){?>
<br />
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
	  <tr>
		<td width="487"><font face="Verdana, Verdana, Arial, Helvetica, sans-serif" size="1"><strong><? echo ucwords(strtoupper($nombre_institu));?></strong></font></td>
		<td width="11">&nbsp;</td>
		<td width="152" rowspan="4" align="center">
				<?	
					$result = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
					$arr=@pg_fetch_array($result,0);
					$fila_foto = @pg_fetch_array($result,0);
					## código para tomar la insignia
				
					if($institucion!=""){
						echo "<img src='../../../../../../".$d."tmp/".$fila_foto['rdb']."insignia". "' >";
					}else{
						echo "<img src='../../../../../../".$d."menu/imag/logo.gif' >";
					}
				?>
		</td>
	  </tr>
	  <tr>
		<td><font face="Verdana, Verdana, Arial, Helvetica, sans-serif" size="1"><? echo ucwords(strtolower($direccion));?></font></td>
		<td>&nbsp;</td>
	  </tr>
	  <tr>
		<td><font face="Verdana, Verdana, Arial, Helvetica, sans-serif" size="1">Fono:&nbsp;<? echo ucwords(strtolower($telefono));?></font></td>
		<td>&nbsp;</td>
	  </tr>
	  <tr>
		<td height="41">&nbsp;</td>
		<td>&nbsp;</td>
	  </tr>
	</table>
<br />
<div id="container" style="min-width: 650px; height: 300px; max-width: 650px; margin: 0 auto"></div>
<br />
<br />


 <?php  
		 $ruta_timbre =6;
		 $ruta_firma =4;
		// $concur=($curso>0)?1:0;
		 include("../../firmas/firmas.php");?>
<?php }?>
</body>
</html>
