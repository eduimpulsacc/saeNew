<?php 
session_start();
require("../../../util/header.php");


require("../clases.php");

//var_dump($_POST);

$institucion	=$_INSTIT;
	$ano			=$cmbANO;
	$curso			=$cmbCURSO;
	$ramo			=$cmbRAMO;
	$unidad			=$cmbUNIDAD;
	$clase			=$cmbCLASE;
	$periodo		=$cmbPERIODO;
	$tipo 		 	=$tipo;

$ob_reporte = new Reporte();

$fila_membrete = $ob_reporte->Membrete($conn,$institucion);

$fila_clase = pg_fetch_array($rs_clase,$c);
$fila_ano = $ob_reporte->Ano($conn,$ano);

$nro_ano = $fila_ano['nro_ano'];

//(1)

$rs_per = $ob_reporte->Periodo($conn,$ano,$periodo);
$fil_per = pg_fetch_array($rs_per,0);

$rs_ramo=$ob_reporte->traeRamo($conn,$curso,$ramo);
$fila_ramo = pg_fetch_array($rs_ramo,0);

$rs_pnotas = $ob_reporte->posicionNotas($conn,$unidad,$periodo,$ramo,$clase);

$pno="";
$col="";
for($n=0;$n<pg_numrows($rs_pnotas);$n++){
$fil_pnotas = pg_fetch_array($rs_pnotas,$n);
$pno.="cast(nota".$fil_pnotas['posicion_nota']." as numeric) as nota$n,";
$col.="nota ".$fil_pnotas['posicion_nota'].", ";
}
  $pno = substr($pno,0,-1);
  $col = substr($col,0,-2);
//cast(nota1 as numeric)

$rs_unidad=$ob_reporte->traeUnidadUno($conn,$unidad);

$rs_clase=$ob_reporte->traeClaseUno($conn,$clase);
$tipo_clase = pg_result($rs_clase,6);

//   se cambio de posicion para dividir las planificaciones de regular y las especiales (1)
$rs_alu = $ob_reporte->tieneElRamo($conn,$curso,$ramo,$nro_ano,$tipo_clase);
$arr_curso=array();


//escala
$ran="";
$arr_escala = array();
$rs_rangos = $ob_reporte->rangoEscalaTodo($conn,$ano);
for($ra=0;$ra<pg_numrows($rs_rangos);$ra++){
	$fil_rangos = pg_fetch_array($rs_rangos,$ra);
	$ran.="'".$fil_rangos['nombre']."',";
}
$ran = substr($ran,0,-1);

?>
<meta charset="latin1">
<link href="../../../cortes/0/estilos.css" rel="stylesheet" type="text/css"> 
<script type="text/javascript" src="../../../admin/clases/jquery/jquery.js"></script>
<script type="text/javascript" src="../../../admin/clases/highcharts/js/highcharts.js"></script>
<style>
@media all {
   div.saltopagina{
      display: none;
   }
   div.cabecera2{
      display: none;
   }
   
   @media print{
   div.saltopagina{ 
      display:block; 
      page-break-before:always;
   }
   div.cabecera2{ 
      display:block; 
      
   }
    
   }
 .cabecera,.cabecera2 {height: 4em;
/*background-color: #399;
color: #fff;*/
text-align: center;
top:0;

}
</style>
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
<div id="capa0">
<table width="650" align="center">
  <tr><td>
   <input name="button4" type="button" class="botonXX" onClick="cerrar()"   value="CERRAR"></td><td align="right">
        <font size="1" face="Arial, Helvetica, sans-serif"></font>
   <input name="button3" TYPE="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR">
</td></tr>
</table>
</div>
<table width="690" align="center">
<tr><td valign="top">
<div class="cabecera"><?php include("../cabecera/cabecera.php"); ?></div><br>
<p>&nbsp;</p>
<p>&nbsp;</p>
<table width="690" border="0" align="center">
  <tr class="">
    <td width="159" align="center" class="textonegrita" colspan="2" >INFORMACI&Oacute;N GR&Aacute;FICA NOTAS POR ASIGNATURA</td>
  </tr>
  <tr class="">
    <td align="center" class="textonegrita" colspan="2" >&nbsp;</td>
  </tr>
  <tr>
    <td width="159" class="textonegrita">A&Ntilde;O</td>
    <td colspan="3" class="textosimple"><? echo $fila_ano['nro_ano'];?></td>
    </tr>
  <tr>
    <td class="textonegrita">CURSO</td>
    <td colspan="3" class="textosimple"><span class="<?=$clase;?>">
      <?=CursoPalabra($curso, 1, $conn);?>
    </span></td>
  </tr>
  <tr>
    <td class="textonegrita">RAMO</td>
    <td colspan="3" class="textosimple"><? echo $fila_ramo['nombre']." ".$fila_ramo['cod_subsector'];?></td>
  </tr>
  <tr>
    <td class="textonegrita">PERIODO</td>
    <td colspan="3" class="textosimple"><?php echo $fil_per['nombre_periodo'] ?></td>
  </tr>
  <tr>
    <td class="textonegrita">UNIDAD</td>
    <td colspan="3" class="textosimple"><?php echo strtoupper(pg_result($rs_unidad,13))?></td>
  </tr>
  <?php if($clase!=0){ ?>
  <tr>
    <td class="textonegrita">CLASE</td>
    <td colspan="3" class="textosimple"><?php echo strtoupper(pg_result($rs_clase,5))?></td>
  </tr>
  <?php }?>
  <tr>
    <td class="textonegrita">COLUMNA NOTAS</td>
    <td colspan="3" class="textosimple"><?php echo $col ?></td>
  </tr>
    
</table>
<br />
<br />

<?php for($a=0;$a<pg_numrows($rs_alu);$a++){
	$pralu=0;
	$sumnalu=0;
	$contnalu=0;
	
	$fila_alu = pg_fetch_array($rs_alu,$a);
	$alumno = $fila_alu['rut_alumno'];
	
	if(($a % 2)==0){
				$clase="detalleoff";
			}else{
				$clase="detalleon";
			}
			
			$rs_notas_Alu = $ob_reporte->traeNotas($conn,$nro_ano,$pno,$alumno,$ramo,$periodo);
			$fila_notas = pg_fetch_array($rs_notas_Alu,0);
						
			for($n=0;$n<pg_numrows($rs_pnotas);$n++){		
			 if(intval($fila_notas["nota$n"])>0){
			 
			 $sumnalu=$sumnalu+intval($fila_notas["nota$n"]);
			 $contnalu=$contnalu+1;	
			 }
			 
			}
			$pralu = $sumnalu/$contnalu; 
			$prx = ($aprox==1)?round($pralu):intval($pralu);
			
			
			
			$rs_escala = $ob_reporte->rangoEscala($conn,$ano,$prx);
			$escala = strtoupper(pg_result($rs_escala,2));
			
			if($prx!="0"){
			$arr_curso[]="$prx";
			}
			
			//arreglo para meter al rango de notas
			for($rn=0;$rn<pg_numrows($rs_rangos);$rn++){
				$filrangos = pg_fetch_array($rs_rangos,$rn);
				$min = $filrangos['inicio'];
				$max = $filrangos['termino'];
				$nom = $filrangos['id_escala'];
				
				if($prx >= $min && $prx <= $max){
				$arr_escala[$nom]['valor']=$arr_escala[$nom]['valor']+1;
				//echo $nom;
				}
				
			}
			
			
	
	?>
 
 
<?php }?>

<br />
<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
</td></tr></table>

<script>
$(function () {
	//puntos
	<?php if($tipo==1){?>
    $('#container').highcharts({
        title: {
            text: '',
            x: -20 //center
        },
        subtitle: {
            text: '',
            x: -20
        },
        xAxis: {
            categories: [<?php echo $ran ?>]
        },
        yAxis: {
            title: {
                text: 'Cantidad Promedios'
            },
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },
        tooltip: {
            valueSuffix: ''
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle',
            borderWidth: 0
        },
		
		plotOptions: {
            line: {
                dataLabels: {
                    enabled: true
                },
                enableMouseTracking: false
            }
        },
        series: [
		{
            name: 'Cantidad Promedios',
            data: [
			<?php 
			$dt = "";
			for($x=0;$x<pg_numrows($rs_rangos);$x++){
			$filrangos2 = pg_fetch_array($rs_rangos,$x);
			$nom = $filrangos2['id_escala'];
			
			$dt.=$arr_escala[$nom]['valor'].",";
			}
			
			echo $dt= substr($dt,0,-1);
			?>
			
			]

        },
		]
    });
	<?php }
	elseif($tipo==2){
	?>
	//torta
	$('#container').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false
        },
        title: {
            text: ''
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.y:.0f}</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.y:.0f}',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    }
                }
            }
        },
        series: [{
            type: 'pie',
            name: 'Promedios',
            data: [
               <?php 
			$dt = "";
			for($x=0;$x<pg_numrows($rs_rangos);$x++){
			$filrangos2 = pg_fetch_array($rs_rangos,$x);
			$nom = $filrangos2['id_escala'];
			$titulo = $filrangos2['nombre'];
			
			//$dt.="['".$titulo."',".$arr_escala[$nom]['valor']."],";
			$dt.=($arr_escala[$nom]['valor']>0)?"['".$titulo."',".$arr_escala[$nom]['valor']."],":"";
			}
			echo $dt= substr($dt,0,-1);
			?>
                
            ]
        }]
    });
	<?php }elseif($tipo==0){?>
	//barras
	 $('#container').highcharts({
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
            title: {
                text: 'Cantidad Promedios'
            }
        },
        legend: {
            enabled: false
        },
        tooltip: {
            pointFormat: ''
        },
        series: [{
            name: 'Promedios',
            data: [			
				<?php 
			$dt = "";
			for($x=0;$x<pg_numrows($rs_rangos);$x++){
			$filrangos2 = pg_fetch_array($rs_rangos,$x);
			$nom = $filrangos2['id_escala'];
			$titulo = $filrangos2['nombre'];
			
			//$dt.="['".$titulo."',".$arr_escala[$nom]['valor']."],";
			$dt.=($arr_escala[$nom]['valor']>0)?"['".$titulo."',".$arr_escala[$nom]['valor']."],":"";
			}
			echo $dt= substr($dt,0,-1);
			?>
				
            ],
            dataLabels: {
                enabled: true,
                rotation: 0,
                color: '#FFFFFF',
                align: 'right',
                format: '{point.y:.0f}', // one decimal
                y: 25, // 10 pixels down from the top
				x: -10, // 10 pixels down from the top
                style: {
                    fontSize: '13px',
                    fontFamily: 'Verdana, sans-serif'
                }
            }
        }]
    });
	<?php }?>
});
</script>