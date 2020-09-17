
<script>
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
function cerrar(){
	window.close()
}

</script> 

<?

require('../../../../../../util/header.inc');
include('../../../../../clases/class_Reporte.php');
include('../../../../../clases/class_Membrete.php');

	$institucion	= $_INSTIT;
     $ano			= $_ANO;
	
	$reporte		= $c_reporte;
	
	
	$_POSP = 5;
	$_bot = 9;

	$ob_reporte = new Reporte();
	$ob_membrete = new Membrete();
	$ob_config ->curso=1;
	
	
	/*******INSITUCION *******************/
	$ob_membrete ->institucion=$institucion;
	$ob_membrete ->institucion($conn);
	
		 
	/********** AÑO ESCOLAR*****************/
	$ob_membrete ->ano = $ano;
	$ob_membrete ->AnoEscolar($conn);
	$nro_ano = $ob_membrete->nro_ano;
	
	//-------------------------	 CONFIGURACION DE REPORTE ------------------
	$ob_config = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=1;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	@$fila_config = pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);
	
	$ob_reporte->rdb=$institucion;
	$ob_reporte->ano_desde = $ano_desde;
	$ob_reporte->ano_hasta = $ano_hasta;
	$rs_ano = $ob_reporte->rangoAnos($conn);
	
	
	// $lista_idano = substr($lista_idano,0,-1);
	
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="../../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../../../../../clases/jquery/jquery.js"></script>
<script type="text/javascript" src="../../../../../clases/highcharts/js/highcharts.js"></script>
<title>Sistema de Evaluacion Docente</title>
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

</head>

<body>
<div id="capa0">
  <table width="650" align="center">
    <tr>
      <td><input name="button4" type="button" class="botonXX" onClick="cerrar()"   value="CERRAR" /></td>
      <td align="right"><input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR" /></td>
    </tr>
  </table>
</div>
<br />
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="487"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong><? echo ucwords(strtoupper($ob_membrete->ins_pal));?></strong></font></td>
    <td width="11">&nbsp;</td>
    <td width="152" rowspan="4" align="center"><table width="125" border="0" cellpadding="0" cellspacing="0">
      <tr valign="top" >
        <td width="125" align="center"><?
		$result = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
		$arr=@pg_fetch_array($result,0);
		$fila_foto = @pg_fetch_array($result,0);
	    ## código para tomar la insignia

	  if($institucion!=""){
		   echo "<img src='../".$d."tmp/".$fila_foto['rdb']."insignia". "' >";
	  }else{
		   echo "<img src='../".$d."menu/imag/logo.gif' >";
	  }?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo ucwords(strtolower($ob_membrete->direccion));?></font></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1">Fono:&nbsp;<? echo ucwords(strtolower($ob_membrete->telefono));?></font></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="41">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<br />
<div id="container" style="width: 650px; height: 400px; margin: 0 auto" align="center"></div>
<br>
<?php  ;

/*echo "<pre>";
var_dump($arr_prom);
echo "</pre>";*/
?>
<br />
 <?php  
		 $ruta_timbre =4;
		 $ruta_firma =2;
		 include("../../firmas/firmas.php");?>
		 
<br />
<p><br />
</p>
<?php  //$lista_idano="";
	for($a=0;$a<pg_numrows($rs_ano);$a++){
	$fila_ano =pg_fetch_array($rs_ano,$a);
	//$lista_idano.= $fila_ano['id_ano'].",";
	 $ob_reporte->idano = $fila_ano['id_ano'];
	 $rs_promedio = $ob_reporte->promedioRangoPsu($conn);
	  $arr['dato']['fecha'][]=$fila_ano['nro_ano'];
	  $arr['dato']['puntaje'][]=round(pg_result($rs_promedio,0),1);
		
	} ?>
<?php // show($arr['dato']);
echo count($arr['dato']['fecha']);
?>

<script>
$(function () {
    $('#container').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: 'Promedio puntajes PSU'
        },
        subtitle: {
            text: ''
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
                text: 'Puntajes'
            }
        },
        legend: {
            enabled: false
        },
        tooltip: {
            pointFormat: 'Puntaje: <b>{point.y:.1f} puntos</b>'
        },
        series: [{
            name: 'Puntaje',
            data: [
		<?php for($f=0;$f<count($arr['dato']['fecha']);$f++){?>
                ['<?php echo $arr['dato']['fecha'][$f] ?>', <?php echo $arr['dato']['puntaje'][$f] ?>],
			<?php }?>
            ],
            dataLabels: {
                enabled: true,
                rotation: -90,
                color: '#FFFFFF',
                align: 'right',
                format: '{point.y:.1f}', // one decimal
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
</body>
</html>