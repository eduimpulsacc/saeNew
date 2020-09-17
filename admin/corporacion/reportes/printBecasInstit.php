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
<table width="750" height="843" border="0" align="center" cellpadding="0" cellspacing="0" >
  <tr>
    <td height="113" valign="top">
      <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td colspan="2"><img src="../images/linea2.jpg" width="730" height="4" /></td>
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
          <td colspan="2"><img src="../images/linea.jpg" width="730" height="4" /></td>
        </tr>
      </table>
      <br />
      <br />
      <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" >
        <tr>
          <td class="titulo1">CANTIDAD DE ALUMNOS BECADOS POR INSTITUCI&Oacute;N <br />
          A&Ntilde;O <?=$ano;?></td>
        </tr>
      </table>
    <br />
	<? $sql  ="SELECT nombre_instit, rdb FROM institucion WHERE rdb in (SELECT rdb FROM corp_instit WHERE num_corp=".$corporacion.")";
								$rs_instit = @pg_exec($conn,$sql);
								
	?>
    <table width="100%" border="1" cellspacing="0" cellpadding="3">
									<tr>
									  <td class="celdas1">RDB</td>
									  <td class="celdas1">ESTABLECIMIENTO</td>
									  <td align="center" class="celdas1">CANTIDAD</td>
									</tr>
									<? for($i=0;$i<@pg_numrows($rs_instit);$i++){
											$fila_instit = @pg_fetch_array($rs_instit,$i);
									   ?>
									<tr>
									  <td class="text2"><div align="center">
									    <?=$fila_instit['rdb'];?>
								      </div></td>
									  <td class="text2"><div align="center">
									    <?=$fila_instit['nombre_instit'];?>
								      </div></td>
									  <? 
								$sql_ano  ="SELECT id_ano FROM ano_escolar WHERE id_institucion=".$fila_instit['rdb']." ";
								$sql_ano.="and nro_ano=".$ano."";
								$rs_ano = @pg_exec($conn,$sql_ano);
								$id_ano = pg_result($rs_ano,0);
								//$fila_instit['rdb']."=".$id_ano;
								
								$sql_becados  ="SELECT COUNT(*) FROM becas_benef WHERE id_ano=".$id_ano." ";
								$rs_becados = @pg_exec($conn,$sql_becados);
								$becados = pg_result($rs_becados,0);
								
									  ?>
									  <td class="text2"><div align="center">
									    <?=$becados?>
								      </div></td>
									  <? $total= $total+$becados; 
									  ?>
									</tr>
									<? } ?>
									<tr>
									  <td colspan="2" class="celdas1"><div align="right">TOTAL BECADOS </div></td>
									  <td class="celdas1"><?=$total?></td>
									</tr>
								</table>
    <br />
    <br />
    <br /></td>
  </tr>
   <? 
	
	 setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
     $fechaEspañol = strftime("%A %d de %B del %Y");
	 
	?>
  <tr>
    <td valign="baseline"><HR />
       <div align="right" class="fecha"><?=$fechaEspañol?></div></td>
  </tr>
</table>
</body>
</html>