<?

require('../../util/header.inc');

$institucion 	= $cmbINSTITUCION;
$ano			= $cmbANO;

$sql="SELECT base_datos,nombre_instit FROM institucion WHERE rdb=".$institucion;
$rs_bd = pg_exec($connection,$sql);
$nombre_colegio = pg_result($rs_bd,1);

$_ID_BASE =pg_result($rs_bd,0);
session_register('_ID_BASE');
//echo $_ID_BASE;

$sql="SELECT DISTINCT perfil.nombre_perfil, perfil.id_perfil
FROM control_users 
INNER JOIN perfil ON perfil.id_perfil=control_users.id_perfil
WHERE rdb_users=".$institucion." and date_part('year',fecha)=".$ano."
ORDER BY 1";
$rs_perfiles = pg_exec($connection,$sql) or die(pg_last_error($connection));

$fecha = date("d-m-Y");
$mes = date("m");
$mesA = $mes - 1;
$mesB = $mes - 2;

$sql="SELECT nombre_emp ||' '|| ape_pat as nombre, sexo FROM empleado e INNER JOIN trabaja t ON e.rut_emp=t.rut_emp WHERE rdb=".$institucion." AND cargo=1";
$rs_director = pg_exec($conn,$sql);
$nombre_director = pg_result($rs_director,0);
$sexo = pg_result($rs_director,1);
if($sexo==1){
	$señor = "Señor";
	$director = "Director";
	$estimado = "Estimado";
}else{
	$señor = "Señora";
	$director = "Directora";
	$estimado = "Estimada";
}

$arr_conex = array();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=latin1" />
<link rel="stylesheet" type="text/css" href="../../cortes/0/estilos.css"/>
<title>REPORTE DE CONEXIONES</title>
<script type="text/javascript" src="../../admin/clases/jquery/jquery-1.11.2.min.js"></script>
<script type="text/javascript" src="../../admin/clases/highcharts/js/highcharts.js"></script>
<script>
function imprimir(){
document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}

function cerrar(){ 
window.close() 
} 
</script>
<style>
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
   div.footer{
   bottom:0px;
	}
}
p { line-height: 200%; }
</style>
</head>

<body topmargin="0" >
<div id="capa0">
<table width="650" align="center">
  <tr><td>
   <input name="button4" type="button" class="botonXX" onClick="cerrar()"   value="CERRAR"></td><td align="right">
        <font size="1" face="Arial, Helvetica, sans-serif"></font>
   <input name="button3" TYPE="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR">
</td></tr>
</table>
</div>
<table width="650" border="0" align="center">
  <tr>
    <td colspan="2" align="center"><img src="img/logo.png" width="275" height="89" /></td>
  </tr>
</table>
<br />
<table width="650" border="0" align="center">
<tr>
    <td width="71%" class="textosimple">&nbsp;</td>
    <td width="29%" class="textosimple">Santiago,
    <?=fecha_espanol($fecha);?></td>
  </tr>
  <tr>
    <td colspan="2" class="textosimple"><? echo $señor."&nbsp;".$nombre_director;?><br />
      <?=$director;?><br />
      <?=$nombre_colegio;?>
      <br />
      <u>Presente</u></td>
  </tr>
  </table>
  <table width="650" border="0" align="center">
  <tr>
    <td colspan="2">
    <table width="100%" border="0" align="center" height="590">
      <tr>
        <td align="justify" class="textosimple" valign="top"><p><? echo $estimado."&nbsp;".$director;?>,<br /><br />

       <p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Enviamos a usted estad&iacute;stica de conexiones por perfiles que ha tenido su instituci&oacute;n en la plataforma SAE<sup>&reg;</sup>, Sistema de Gesti&oacute;n Escolar que tiene contratado.<br />
        <br />
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Esta informaci&oacute;n tiene como objetivo poder potenciar el uso de la plataforma y as&iacute; obtener mayores beneficios de todas las herramientas des gesti&oacute;n que entrega el sistema SAE<sup>&reg;</sup> a favor de su gesti&oacute;n y del proceso de ense&ntilde;anza y aprendizaje de sus estudiantes</p>
        </p><br />

          <table width="100%" border="1" style="border-collapse:collapse">
            <tr class="textonegrita">
              <td>Perfil</td>
              <td>Ene</td>
              <td>Feb</td>
              <td>Mar</td>
              <td>Abr</td>
              <td>May</td>
              <td>Jun</td>
              <td>Jul</td>
              <td>Ago</td>
              <td>Sep</td>
              <td>Oct</td>
              <td>Nov</td>
              <td>Dic</td>
              <td>Total</td>
            </tr>
            <? for($i=0;$i<pg_numrows($rs_perfiles);$i++){
					$fila_p = pg_fetch_array($rs_perfiles,$i);
					$suma_mes=0;
					$valor=0;
			?>
            <tr class="textosimple">
              <td>&nbsp;<?=$fila_p['nombre_perfil'];?></td>
              <? for($j=1;$j<13;$j++){
					$sql="SELECT count(*) FROM control_users WHERE rdb_users=".$institucion." and date_part('year',fecha)=".$ano." AND date_part('MONTH',fecha)=".$j." AND id_perfil=".$fila_p['id_perfil'];
					$rs_contador = pg_exec($connection,$sql);
					if($j==$mes){
						$valor=0;	
					}else{
						$valor=pg_result($rs_contador,0);
					}
				?>
						
              <td align="right"><? echo number_format($valor,0);?>&nbsp;</td>
			<? $suma_mes = $suma_mes + $valor;
			} ?>	
              <td align="right"><? echo number_format($suma_mes,0);?>&nbsp;</td>
            </tr>
            <? } ?>
            <tr class="textonegrita">
              <td>Total</td>
              <? for($j=1;$j<13;$j++){
					$sql="SELECT count(*) FROM control_users WHERE rdb_users=".$institucion." and date_part('year',fecha)=".$ano." AND date_part('MONTH',fecha)=".$j."";
					$rs_contador = pg_exec($connection,$sql);
					if($j==$mes){
						$valor_total=0;	
					}else{
						$valor_total=pg_result($rs_contador,0);
					}
					if($j==$mesA){
						$valorMesA = $valor_total;
					}
					if($j==$mesB){
						$valorMesB = $valor_total;
					}
					
					$arr_conex[]=$valor_total;
				?>
						
              <td align="right"><? echo number_format($valor_total,0,',','.');?>&nbsp;</td>
			<? $suma_total = $suma_total + $valor_total;
			} ?>	
            
             <td align="right"><? echo number_format($suma_total,0,',','.');?>&nbsp;</td>
            </tr>
          </table>

</td></tr></table>
</td></tr></table>
<div class="footer">
<table width="650" border="0" align="center">
<tr>
    <td align="left"><img src="img/logo2.png" width="273" height="85" /></td>
    <td align="right"><img src="img/logo3.png" width="148" height="108" /></td>
  </tr>
<tr>
  <td colspan="2" align="left"><img src="barra.gif" width="100%" height="10" /></td>
  </tr>
</table>
</div>
<div class="saltopagina"></div>
<table width="650" border="0" align="center">
  <tr>
    <td colspan="2" align="center"><img src="img/logo.png" width="275" height="89" /></td>
  </tr>
</table>
 <? 	
				$variacion = (($valorMesA - $valorMesB) / $valorMesB) * 100;
				if($variacion > 0){
					$mensaje = "al alza";
				}else{
					$mensaje = "a la baja";
				}
						
		?>
<br />
<table width="650" border="0" align="center">
            
            <tr>
              <td><div id="container" style="min-width: 210px; height: 250px; margin: 0 auto"></div></td>
            </tr>
</table><br />
<br />
<table width="650" border="0" align="center" >
      <tr>
        <td align="justify" class="textosimple" height="100" valign="top"><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Considerando los dos utlimos meses, la tendencia de uso ha sido de un <? echo substr($variacion,0,5);?>% <?=$mensaje;?></p>
          <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Si tiene alguna duda con la informacion entregada o desea mas detalle, no dude en contactarse con nosotros a nuestra mesa central (56-2) 2829 3350 o generando una consulta on-line a trav&eacute;s de nuestra plataforma.<br />
            <br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sin otro particular, me despido atentamente</p>
        </td>
      </tr>
      <tr>
        <td align="center" class="textonegrita">
     
<div style="width:300px;margin:0 auto;height:180px;position:relative;">
<div style="padding:20px;position: absolute;text-align: center;left:30px;top:50px;">______________________________<br />

Daniela Zamora<br />
Gerente General</div
><div style="padding: 20px; position: absolute; text-align: center; right: 64px; bottom: 46px;"><img src="firmadzamora.png" /></div></div>


</td>
      </tr>
    </table>

<div class="footer">
<table width="650" border="0" align="center">
<tr>
  <td colspan="2" align="left" height="25">&nbsp;</td>
</tr>
<tr>
  <td align="left"><img src="img/logo2.png" width="273" height="85" /></td>
  <td align="right"><img src="img/logo3.png" width="148" height="108" /></td>
</tr>
 <tr>
  <td colspan="2" align="left"><img src="barra.gif" width="100%" height="10" /></td>
  </tr>
</table>
</div>
</body>
<?php 
			$con="";
			//var_dump($arr_conex);
			foreach($arr_conex as $cnx){
			 $con.=$cnx.",";
			}
			?>
<script>
$(function () {
	
	Highcharts.setOptions({
		lang: {
			decimalPoint: ',',
            thousandsSep: '.'
		}
	});
	
    $('#container').highcharts({
        chart: {
            type: 'line'
        },
        title: {
            text: 'Gráfico de Conexiones'
        },
        subtitle: {
            text: ''
        },
		credits: {
      		enabled: false
  		},
        xAxis: {
            categories: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic']
        },
        yAxis: {
            title: {
                text: ''
            }
        },
        plotOptions: {
            line: {
                dataLabels: {
                    enabled: true
                },
                enableMouseTracking: false
            }
        },
        series: [{
            name: 'Conexiones',
			
            data: [<?php echo substr($con, 0, -1) ?>]
        }]
    });
});
</script>

</html>
