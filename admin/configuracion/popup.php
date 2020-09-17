<?php require('../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$_POSP = 3;
   $_MDINAMICO = 1;	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<link href="../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>

</head>

<body>
<table width="373" border="1" cellspacing="0" cellpadding="0" align="center">
  <tr class="tableindex"> 
    <td width="92" align="center" >&nbsp;Criterio</td>
    <td width="265" align="center">&nbsp;Sigla</td>
  </tr>
  
<? 
	$cmb_grado= $_GET["cmb_grado"];
	$tipo_ensenanza= $_GET["tipo_ensenanza"];
	$sqlgrado="SELECT grado_curso FROM curso where id_curso=".$cmb_grado;
	$result = pg_exec($conn,$sqlgrado);
	$fila2 = @pg_fetch_array($result,0);
	
	$sql="SELECT * FROM criterio_seleccion where grado=".$fila2["grado_curso"]." and ensenanza=".$tipo_ensenanza;
	$resultado = pg_exec($conn,$sql);
	
	     for($i=0 ; $i < @pg_numrows($resultado) ; $i++)
		        {  
				$fila = @pg_fetch_array($resultado,$i); 
				?>
				
  <tr>
				<td align="center"><?= $fila["descripcion"];?></td>
				<td align="center"><?= $fila["sigla"];?></td>

  </tr>		
				<?
				}
?>
</table>
</body>
</html>
