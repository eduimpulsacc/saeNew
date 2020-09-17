<?php 
require("../../util/header.php");
session_start();
$_POSP=1;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link  rel="shortcut icon" href="../../images/icono_sae_33.png">
<link href="../../menu_new/head.css" rel="stylesheet" type="text/css" />
<link href="../../cabecera_new/css.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../../menu_new/css/styles.css">
<link href="../../cortes/0/estilos.css" rel="stylesheet" type="text/css"> 
<link href="../../admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/jquery-ui.css" rel="stylesheet" type="text/css"> 
<script type="text/javascript" src="../../admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/external/jquery/jquery.js"></script>
<title>SISTEMA SAE:====> PLANIFICACION</title>
</head>

<body  leftmargin="0" marginheight="0" rightmargin="0" marginwidth="0">
<table width="1280" border="0" cellpadding="0" cellspacing="0">
  <tr>
   	<td rowspan="3" valign="top" background="../../cortes/<?=$_INSTIT;?>/fondo_01_reca.jpg" width="50"  height="900"></td>
   	<td colspan="2" align="left" valign="top" height="70"><? include("../../cabecera_new/head.php");?></td>
    <td rowspan="3" background="../../cortes/<?=$_INSTIT;?>/fomdo_02_reca.jpg" width="53" height="900"></td>
  </tr>
  <tr>
    <td valign="top" align="left"><? include("../../menu_new/index.php");?></td>
    <td valign="top" align="center"><br />
    
    <table width="850" border="0" class="tablaredonda">
  <tr>
    <td>

						<table width="850" border="0">
  <tr>
    <td colspan="4">&nbsp;</td>
    </tr>
  <tr>
    <td width="5%">&nbsp;</td>
    <td colspan="2" class="tableindex tablaredonda">LISTADO DE REPORTES</td>
    <td width="3%">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <? 	if($_PERFIL==0){
	  		$sql="SELECT * FROM planificacion.reportes ORDER BY id_reporte ASC";
		}else{
  			$sql="SELECT * FROM planificacion.reportes r INNER JOIN planificacion.perfil_reporte pr 
  				ON r.id_reporte=pr.id_reporte WHERE rdb=".$_INSTIT." AND id_perfil=".$_PERFIL." ORDER BY r.id_reporte ASC";
		}
  		$rs_reporte = pg_exec($conn,$sql);
		
		for($i=0;$i<pg_numrows($rs_reporte);$i++){
			$fila=pg_fetch_array($rs_reporte,$i);
			$cont=$i+1;
	?>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2" class="textosimple">&nbsp;<img src="../../cortes/arrow.png" />&nbsp;<a href="<?=$fila['url'];?>"><? echo $cont.".- ".$fila['nombre'];?></a></td>
    <td>&nbsp;</td>
  </tr>
  <? } ?>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
</table>
</td>
  </tr>
</table>
</td>
  </tr>
  <tr>
    <td colspan="2"><!--<? include("../../cabecera_new/footer.html");?>--></td>
  </tr>
</table>




</body>

</html>
