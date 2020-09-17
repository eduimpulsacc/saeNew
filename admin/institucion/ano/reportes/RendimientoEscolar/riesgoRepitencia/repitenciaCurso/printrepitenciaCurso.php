<?php 

require('../../../../../../../util/header.inc');
include('../../../../../../clases/class_Reporte.php');
include('../../../../../../clases/class_Membrete.php');



$curso = 1;
$institucion = $_INSTIT;
$ano=$_ANO;
$reporte		=$c_reporte;
$_POSP = 6;
$_bot = 8;

$ob_reporte = new Reporte();
$ob_membrete = new Membrete();
//-------------------------	 CONFIGURACION DE REPORTE ------------------
	$ob_config = new Reporte();
	$ob_reporte = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=$curso;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = @pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);
	
	$qry_ano="SELECT * FROM ano_escolar WHERE id_ano=".$ano." AND id_institucion=".$institucion;
$result_ano =@pg_Exec($conn,$qry_ano);
$fila_ano = @pg_fetch_array($result_ano,0);
$ano_esc = $fila_ano['nro_ano'];

/// tomar nombre de la institucion
$qry_ins="SELECT nombre_instit FROM institucion WHERE rdb = '$_INSTIT'";
$result_ins =@pg_Exec($conn,$qry_ins);
$fila_ins = @pg_fetch_array($result_ins,0);
$nombre_institucion = $fila_ins['nombre_instit'];
$ob_reporte->ano=$ano;
$ob_reporte->rdb=$institucion;
$ob_reporte->nro_ano=$ano_esc;
$ob_reporte->cod_tipo=$_POST['tense'];

$arc=array();
if($_POST['tipo']==1){
	//filtro por curso

	$ob_reporte->tipo_ensenanza=$_POST['tense'];
	$rs_ll = $ob_reporte->CursoEnsenanza($conn);
	$t2="CURSO";
	
	//lista de cursos
	for($c=0;$c<pg_numrows($rs_ll);$c++){
		$fila_curso = pg_fetch_array($rs_ll,$c);
		$arc[$c]['idc']=$fila_curso['id_curso'];
		$arc[$c]['cpal']=($_POST['trepo']==1)?CursoPalabra($fila_curso['id_curso'],1,$conn):CursoPalabra($fila_curso['id_curso'],3,$conn);
		//si promocion realizada
		$ob_reporte->curso=$fila_curso['id_curso'];
		
		if($_POST['finalp']==1){
			
			//cuento por catidad
			
			if($_POST['cant']==1){
			$ob_reporte->tipo_rep=$_POST['filtrapor'];
			$rs_notas = $ob_reporte->repitentesCursoNotasCP($conn);
			for($n=0;$n<pg_numrows($rs_notas);$n++){
			$fila_notas = pg_fetch_array($rs_notas,$n);
			$arc[$c]['lis']=$fila_notas['promedio'];
			//if($fila_notas['situacion_final']==2){
				$arc[$c]['prm'][]=$fila_notas['promedio'];
				//}
				}
			}
			//cuento por porcentaje
			elseif($_POST['cant']==2){
								
				//cuento los repitentes
				//$ob_reporte->tipo_rep=0;
				$ob_reporte->tipo_rep=$_POST['filtrapor'];
				$rs_notas = $ob_reporte->repitentesCursoNotasCP($conn);
				for($n=0;$n<pg_numrows($rs_notas);$n++){
				$fila_notas = pg_fetch_array($rs_notas,$n);
				$arc[$c]['lis']=$fila_notas['promedio'];
				//if($fila_notas['situacion_final']==2){
					$arc[$c]['prm'][]=$fila_notas['promedio'];
					}
				//}
				
				//cuento a todo el curso
				$ob_reporte->tipo_rep=0;
				$rs_curso = $ob_reporte->repitentesCursoNotasCP($conn);
				/*for($n=0;$n<pg_numrows($rs_notas);$n++){
				$fila_notas = pg_fetch_array($rs_notas,$n);
				$arc[$c]['lis']=$fila_notas['promedio'];
				//if($fila_notas['situacion_final']==2){
					$arc[$c]['cnt'][]=$fila_notas['promedio'];
					//}
				}*/
				
			//echo "<br>".pg_numrows($rs_notas)."-".pg_numrows($rs_curso)."-".
			$cnt = (pg_numrows($rs_notas)*100)/pg_numrows($rs_curso);
			$arc[$c]['porc'][]=$cnt;
				
			}
			
		}
		if($_POST['finalp']==2){
			
			$ob_reporte->repitentesCursoNotasSP($conn);
		}
	}
	
}
if($_POST['tipo']==2){

	$rs_ll = $ob_reporte->Ciclos($conn);
	$t2="CICLO";
	
	
	//lista de ciclos
	for($c=0;$c<pg_numrows($rs_ll);$c++){
	$fila_ciclo = pg_fetch_array($rs_ll,$c);
		$arc[$c]['curso'][]=$fila_ciclo['id_ciclo'];
		
		
		$ob_reporte->ciclo=$fila_ciclo['id_ciclo'];
		$arc[$c]['cpal']=$fila_ciclo['nomb_ciclo'];
		
/***************promocion hecha*/		
		if($_POST['finalp']==1){
			//calculo por cantidad
			if($_POST['cant']==1){
			$ob_reporte->tipo_rep=$_POST['filtrapor'];
			$rs_notas=$ob_reporte->repitentesCicloNotasCP($conn);
			for($n=0;$n<pg_numrows($rs_notas);$n++){
			$fila_notas = pg_fetch_array($rs_notas,$n);
			$arc[$c]['lis']=$fila_notas['promedio'];
			if($fila_notas['situacion_final']==2){
				$arc[$c]['prm'][]=$fila_notas['promedio'];
				}	
			}
			
			}
			//calculo por porcentaje
			if($_POST['cant']==2){
				//cuento repitentes
			$ob_reporte->tipo_rep=$_POST['filtrapor'];
			$rs_notas=$ob_reporte->repitentesCicloNotasCP($conn);
			for($n=0;$n<pg_numrows($rs_notas);$n++){
			$fila_notas = pg_fetch_array($rs_notas,$n);
			$arc[$c]['lis']=$fila_notas['promedio'];
			if($fila_notas['situacion_final']==2){
				$arc[$c]['prm'][]=$fila_notas['promedio'];
				}	
			}
			
			
			//cxuento a todo el curso
			$ob_reporte->tipo_rep=0;
			$rs_curso=$ob_reporte->repitentesCicloNotasCP($conn);
				//echo "<br>".pg_numrows($rs_notas)."-".pg_numrows($rs_curso)."-".
				$cnt = (pg_numrows($rs_notas)*100)/pg_numrows($rs_curso);
			$arc[$c]['porc'][]=$cnt;
			}
		}
		
/****************sin promocion*/
		if($_POST['finalp']==2){
			
			
			if($_POST['tipo']==1){			
			//por notas
			if($_POST['cant']==1){}
			if($_POST['cant']==2){}
			//por asistencia
			if($_POST['cant']==1){}
			if($_POST['cant']==2){}
			//todo
			if($_POST['cant']==1){}
			if($_POST['cant']==2){}
			}
			//fin por tipo de ensenanza
			//por ciclio
			if($_POST['tipo']==2){			
			//por notas
			if($_POST['cant']==1){}
			if($_POST['cant']==2){}
			//por asistencia
			if($_POST['cant']==1){}
			if($_POST['cant']==2){}
			//todo
			if($_POST['cant']==1){}
			if($_POST['cant']==2){}
			}
		}
		
	}
	
}

if($_POST['cant']==1){
$t1="CANTIDAD";

	
	
}
if($_POST['cant']==2){
$t1="PORCENTAJE";
	
	
}


/*error_reporting(E_ALL);
ini_set('display_errors', 1);*/
if($_PERFIL==0){
show($arc);
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<link href="../../../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
</head>
<style>
.Estilo7 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; }
.Estilo8 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; font-weight: bold; }
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
</style>

<script> 
function cerrar(){ 
window.close() 
} 
</script>
<script>
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
</script>
<body>
<div id="capa0">
<table width="650" align="center">
  <tr><td>
   <input name="button4" type="button" class="botonXX" onClick="cerrar()"   value="CERRAR"></td><td align="right">
        <font size="1" face="Arial, Helvetica, sans-serif"></font>
   <input name="button3" TYPE="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR">
</td></tr>
</table>
</div>
<table width="650" border="0" cellpadding="0" cellspacing="0" align="center">
			  <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
			  <tr>
                <td width="114"><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>INSTITUCI&Oacute;N</strong></font></div></td>
                <td width="9"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>:</strong></font></td>
                <td width="361"><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><?=$nombre_institucion?></font></div></td>
                <td width="161" rowspan="3" align="center" valign="top" >
				<?
		$result_foto = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
		$arr=@pg_fetch_array($result_foto,0);
		$fila_foto = @pg_fetch_array($result_foto,0);
	    ## código para tomar la insignia

	  if($institucion!=""){
		   echo "<img src='../../".$d."tmp/".$fila_foto['rdb']."insignia". "' >";
	  }else{
		   echo "<img src='../../".$d."menu/imag/logo.gif' >";
	  }?>
				</td>
              <tr>
                <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>A&Ntilde;O ESCOLAR</strong></font></div></td>
                <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>:</strong></font></td>
                <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><?=$ano_esc?></font></div></td>
                </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                </tr>	
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td width="161" rowspan="5" align="center">&nbsp;</td>
              </tr>
              <tr>
                <td colspan="3">&nbsp;</td>
              </tr>
		    </table>
<br />
<br />
<table width="650" border="1" align="center" style="border-collapse:collapse ">
<tr>
<td colspan="9" class="tableindex">
<div align="center"><?php echo $t1 ?> DE ALUMNOS EN RIESGO DE REPITENCIA - POR <?php echo $t2 ?><br />
<?php if($tipo==1){
	$ob_reporte->cod_tipo=$_POST['tense'];
	$ob_reporte->TipoEnsenanza($conn);
	echo $ob_reporte->nombre;
	} ?>
</div></td>
</tr></table><br />
<br />
<?php if($_POST['trepo']==1){?>
<table width="650" border="1" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse ">
  <tr class="tableindex">
    <td width="450"><?php echo $t2 ?>&nbsp;</td>
    <td width="103" align="center">Cantidad</td>
    <?php if($_POST['cant']==2){?>
    <td width="89" align="center">Porcentaje</td>
    <?php }?>
  </tr>
  <?php for($x=0;$x<count($arc);$x++){?>
  <tr class="textosimple">
    <td><?php echo $arc[$x]['cpal'] ?></td>
    <td align="center"><?php echo count($arc[$x]['prm']) ?></td>
    <?php if($_POST['cant']==2){?>
    <td align="center"><?php echo round($arc[$x]['porc'][0],1) ?></td>
    <?php }?>
  </tr>
  <?php  } ?>
</table>
<?php }
 if($_POST['trepo']==2){?>
 <script type="text/javascript" src="../../../../../../clases/jquery/jquery.js"></script>
<script type="text/javascript" src="../../../../../../clases/highcharts/js/highcharts2.js"></script>
 <table width="950" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td> <div id="container" style="width: 950px; height: 400px; margin: 0 auto"></div>&nbsp;</td>
  </tr>
</table>

 
 <script type="text/javascript">
 // Create the chart
		
<?php if($_POST['cant']==1){?>
Highcharts.chart('container', {
    chart: {
        type: 'column'
    },
    title: {
        text: ''
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
		allowDecimals: false,
        title: {
            text: 'N° Alumnos'
        }
    }/*,
    legend: {
        enabled: false
    },
    tooltip: {
        pointFormat: '{point.y:.0f} alumnos</b>'
    }*/,
    series: [{
        name: 'Alumnos',
        data: [
		<?php for($x=0;$x<count($arc);$x++){?>
		           	
			['<?php echo $arc[$x]['cpal'] ?>', <?php echo count($arc[$x]['prm']) ?>],
       
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
<?php }?>
<?php if($_POST['cant']==2){?>
Highcharts.chart('container', {
    chart: {
        zoomType: 'xy'
    },
    title: {
        text: ''
    },
    subtitle: {
        text: ''
    },
    xAxis: [{
        categories: [
		<?php for($x=0;$x<count($arc);$x++){?>
		'<?php echo $arc[$x]['cpal'] ?>', 
		<?php }?>
		],
        crosshair: true,
        labels: {
            rotation: -45,
            style: {
                fontSize: '13px',
                fontFamily: 'Verdana, sans-serif'
            }
        }
    }],
    yAxis: [{ // Primary yAxis
        labels: {
            format: '{value} %',
            style: {
                color: Highcharts.getOptions().colors[1]
            }
        },
        title: {
            text: 'Porcentaje',
            style: {
                color: Highcharts.getOptions().colors[1]
            }
        }
    }, { // Secondary yAxis
	allowDecimals: false,
        title: {
            text: 'Cantidad Alumnos',
            style: {
                color: Highcharts.getOptions().colors[0]
            }
        },
        labels: {
            format: '{value} ',
            style: {
                color: Highcharts.getOptions().colors[0]
            }
        },
        opposite: true
    }],
	
    plotOptions: {
        series: {
            borderWidth: 0,
            dataLabels: {
                enabled: true,
                //format: '{point.y:.1f}'
            }
        }
    },
    tooltip: {
        shared: true
    },
    legend: {
        layout: 'vertical',
        align: 'left',
        x: 120,
        verticalAlign: 'top',
        y: 100,
        floating: true,
        backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'
    },
    series: [{
        name: 'Cantidad Alumnos',
        type: 'column',
        yAxis: 1,
        data: [
		<?php for($x=0;$x<count($arc);$x++){?>
		<?php echo round(count($arc[$x]['prm']),0)."," ?>
		<?php }?>
		],
        tooltip: {
            valueSuffix: ' alumnos'
        }

    }, {
        name: 'Porcentaje',
        type: 'column',
        data: [<?php for($x=0;$x<count($arc);$x++){?>
		<?php echo round($arc[$x]['porc'][0],1)."," ?>
		<?php }?>],
        tooltip: {
            valueSuffix: '%'
        }
    }]
});
<?php }?>
 </script>

<?php }?>
