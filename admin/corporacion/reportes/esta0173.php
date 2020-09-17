<?php
require('../../../util/header.inc');
include ("FusionCharts.php");

$corporacion=$_CORPORACION;
$mes = $cmbMES;
$ano = $cmbANO;

$sql = "SELECT nombre_corp FROM corporacion WHERE num_corp=".$corporacion;
$rs_corp = @pg_exec($conn,$sql);
$nombre_corporacion = @pg_result($rs_corp,0);

$sql = "SELECT a.rdb,b.nombre_instit FROM corp_instit a INNER JOIN institucion b ON a.rdb=b.rdb where num_corp=".$corporacion;
$rs_inst = @pg_exec($conn,$sql);

for($i=0;$i<@pg_numrows($rs_inst);$i++){
	$fila = @pg_fetch_array($rs_inst,$i);
	$rdb = $fila['rdb'];

	
	$sql = "SELECT count(*) FROM matricula WHERE rdb=".$fila['rdb']." AND id_ano in (SELECT id_ano FROM ano_escolar WHERE id_institucion=".$fila['rdb']." AND nro_ano=".$ano.") and date_part('month',fecha)=".$mes." AND bool_ar=0";
	$rs_matricula = @pg_exec($conn,$sql);
	$matricula = @pg_result($rs_matricula,0);
	$total[$rdb]=$matricula;
	
	
}



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
        <td align="right"><input name="volver" type="button" value="VOLVER" class="botonXX" onClick="window.location='../reportesCorporativos4.php'">&nbsp;&nbsp;<input name="imprimir" type="button" value="IMPRIMIR" class="botonXX" onClick="imprimir();" ></td>
</tr>
    <tr>
      <td align="right" class="textosimple"><div align="left">Tipo de Grafico 
        <input name="opcion" type="radio" value="1" onClick="window.location='esta0173.php?opcion=1&cmbMES=<?=$mes;?>&cmbANO=<?=$cmbANO;?>'" <? if($opcion==1) echo "checked"; else echo "";?>>
      Barras 
      <input name="opcion" type="radio" value="2"   onClick="window.location='esta0173.php?opcion=2&cmbMES=<?=$mes;?>&cmbANO=<?=$cmbANO;?>'"  <? if($opcion==2) echo "checked"; else echo "";?>>
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
								<td width="390" class="Estilo4"> <div align="left"><b>Corporacion de <?=$nombre_corporacion;?></b></div></td>
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
						//Create an XML data document in a string variable
						$strXML  = "";
						$vartitulo ="Grafico Estadistico Matricula Mes ".envia_mes($mes)." del ".$ano;
						$vartituxx ="RDB Colegios ";
						$vartituyy =" Cantidad Matricula";
						$strXML .= "<graph caption='$vartitulo' xAxisName='$vartituxx' yAxisName='$vartituyy' decimalPrecision='0' formatNumberScale='0'>";
						
						for ($i=0;$i<@pg_numrows($rs_inst);$i++){
							$fila= @pg_fetch_array($rs_inst,$i);
							$rdb=$fila['rdb'];
							// se grarfica imprime
							$nomest=$fila['rdb'];
							$cantid=$total[$rdb];
							$colorea=$cola;
							$strXML .= "<set name='$nomest' value='$cantid' color='$colorea' />";
						}
						$strXML .= "</graph>";
						
						//Create the chart - Column 3D Chart with data from strXML variable using dataXML method
						//  echo renderChartHTML("FusionCharts/FCF_Column3D.swf", "", $strXML, "myNext", 600, 300);
						
						$ancho=200+(60*10);
						if($opcion==1){
							echo renderChartHTML("../../../FusionCharts/FCF_Column3D.swf", "", $strXML, "myNext", $ancho, 250);
						}else{
							echo renderChartHTML("../../../FusionCharts/FCF_Line.swf", "", $strXML, "myNext", $ancho, 250);
						}	
						?>
					</td>
						
				</tr>
				<tr>
				  <td><blockquote><table width="400" border="1" cellspacing="0" cellpadding="1" style="border-collapse:collapse">
                    <tr>
                      <td colspan="3"><div align="center"><span class="Estilo4">Cuadro Resumen </span></div></td>
                    </tr>
					<? for ($i=0;$i<@pg_numrows($rs_inst);$i++){
							$fila= @pg_fetch_array($rs_inst,$i);
							$rdb=$fila['rdb'];?>
                    <tr>
                      <td><span class="Estilo3"><?=$rdb;?></span></td>
                      <td><span class="Estilo3"><?=$fila['nombre_instit'];?></span></td>
                      <td><div align="right"><span class="Estilo3"><?=$total[$rdb];?></span></div></td>
                    </tr>
					<? } ?>
                  </table></blockquote></td>
			  </tr>
			</table>
		</td>
	</tr>
</table>

<br>
</body>
<html>