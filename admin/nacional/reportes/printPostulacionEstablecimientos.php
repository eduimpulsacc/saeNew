<?

include("../controlador/controlador_1.php");


$corporacion	= $_CORPORACION;
$ano			= $cmbANO;
$mes			= $cmbMES;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Reporte Sostenedor Corporativo</title>
<link href="../estilo.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
body {
	background-image: url();
}
-->
</style>
<script>

function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
	  
		  
</script>
<link href="../../../../../admin/corporacion/estilo.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.Estilo2 {font-weight: bold; background-color: #CCCCCC; text-align: center;}
.Estilo3 {font-family:Verdana, Arial, Helvetica, sans-serif; text-align:center; font-weight: bold; background-color: #CCCCCC;}
-->
</style>
</head>
<body>
<div id="capa0">
  <table width="650" border="0" align="center">
    <tr>
      <td><input type="button" name="Submit" value="VOLVER" onClick="javascript:history.back(1) " class="botonXX"/></td>
      <td><div align="right">
        <input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR" />
      </div></td>
	  
    </tr>
  </table>
</div>
<br />
<table width="900" height="843" border="0" align="center" cellpadding="0" cellspacing="0" >
  <tr>
    <td height="113" valign="top">
      <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td colspan="2"><img src="../images/linea2.jpg" width="900" height="4" /></td>
        </tr>
        <tr>
          <td rowspan="5"> <?  echo "<img src='../images/".$corporacion."_logo.jpg' >"; ?></td>
          <td class="membrete">&nbsp;</td>
        </tr>
        <tr>
          <td class="membrete"><div align="right"><?=$nombre;?></div></td>
        </tr>
        <tr>
          <td class="membrete"><div align="right"><?=$direc;?></div></td>
        </tr>
        <tr>
          <td class="membrete"><div align="right"><?=$fono;?></div></td>
        </tr>
        <tr>
          <td class="membrete">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2"><img src="../images/linea.jpg" width="900" height="4" /></td>
        </tr>
      </table>
      <br />
      <br />
      <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" >
        <tr>
          <td class="titulo1">TOTAL DE POSTULACIONES DE TODOS LOS ESTABLECIMIENTOS <br />
          A&Ntilde;O <?=$ano;?></td>
        </tr>
      </table>
    <br />	
									<table width="100%" border="1" cellspacing="0" cellpadding="3">
									  <tr  class="tabla04">
										<td class="celdas1">RDB</td>
										<td class="celdas1">ESTABLECIMIENTO</td>
										<td class="celdas1">NB1</td>
										<td class="celdas1">NB2</td>
										<td class="celdas1"><p>NB3</p></td>
										<td class="celdas1"><p>NB4</p>									    </td>
										<td class="celdas1">TOTAL</td>
									  </tr>
									  <tr>
										<td class="text2"><div align="center">

									    </div></td>
										<td class="text2"><div align="center">
									    </div></td>
										<td class="text2"><div align="center"></div></td>
										<td class="text2"><div align="center"></div></td>
										<td class="text2"><div align="center"></div></td>
										<td class="text2"><div align="center"></div></td>
										<td class="text2"><div align="center"></div>
									    <div align="center"></div>										  <div align="center"></div></td>
									  </tr>
									  <tr class="tabla04">
										<td class="celdas1"><div align="center"></div></td>
										<td class="celdas1"><div align="center">TOTAL (<?=$i;?>)</div></td>
										<td class="celdas1"><div align="center"></div></td>
										<td class="celdas1"><div align="center"></div></td>
										<td class="celdas1"><div align="center"></div></td>
										<td class="celdas1"><div align="center"></div></td>
										<td class="celdas1"><div align="center"></div>
									    <div align="center"></div>										  <div align="center"></div></td>
									  </tr>
									</table>
    <br />
    <br />
    <br /></td>
  </tr>
  
  <tr>
    <td valign="baseline"><HR />
        <? $fecha=date("d-m-Y");
		$sql="SELECT comuna FROM nacional n INNER JOIN macional_corp nc ON n.id_nacional=nc.id_nacional WHERE num_corp=".$_CORPORACION;
		$rs_nacional = pg_exec($connection,$sql);
		$comuna=pg_result($rs_nacional,0);?>
       <div align="right" class="fecha">Viña del Mar, <? echo fecha_espanol($fecha);?></div></td>
  </tr>
</table>
</body>
</html>
