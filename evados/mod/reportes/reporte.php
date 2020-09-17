<? 
session_start();
require "../../class/Membrete.class.php";
$ob_membrete = new Membrete($_IPDB,$_ID_BASE);

 $institucion 	= $_INSTIT;
 $perfil		= $_PERFIL;

/*$sql ="SELECT DISTINCT r.id_reporte,r.nombre,r.url
FROM evados.eva_reportes r INNER JOIN evados.eva_item_reporte ir ON r.id_reporte=ir.id_reporte
INNER JOIN evados.eva_reporte_perfil rp ON ir.id_item_reporte=rp.id_item_reporte
WHERE rdb=".$institucion." AND id_perfil=".$perfil;
*/
$sql="SELECT DISTINCT er.id_reporte,nombre,url FROM evados.eva_reporte_perfil erp INNER JOIN evados.eva_reportes er ON erp.id_reporte=er.id_reporte WHERE rdb=".$institucion." and id_perfil=".$perfil;
$rs_reporte = @pg_exec($ob_membrete->Conec->conectar(),$sql);


 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>Reporte</title>


<link rel="stylesheet" type="text/css" href="../admin/clases/flexigrid-1.1/css/flexigrid.css">
<script type="text/javascript" src="../admin/clases/flexigrid-1.1/js/flexigrid.js"></script>

        


<style>
#bloques{ margin:10px; margin-top:40px; margin-left:10%; text-align:left; width:80%; }
#table_evaluadores{  margin:10px; margin-top:25px; padding:15px;  }
#botton{ margin-top:10px; padding:15px; }
#nombre_bloque{ margin-top:15px; padding:3px; border:solid 1px; margin-bottom:5px; }
</style>

</head>
<body>

<div id="bloques" align="center"  >

<fieldset>
<legend>Listado de Reportes </legend> 

<br />
<br />
<table width="100%" border="0" cellpadding="3" cellspacing="0">
  <tr>
    <td valign="top"><table width="100%" border="0" cellpadding="3" cellspacing="0">
<? for($i=0;$i<@pg_numrows($rs_reporte);$i++){
		$fila = @pg_fetch_array($rs_reporte,$i);
		$cont = $i + 1;
?>
		  <tr>
			<td width="91%" class="cuadro02" colspan="2">&nbsp;<?=$fila['nombre'];?></td>
		  </tr>
<? 	//$sql ="SELECT id_item_reporte, nombre, url FROM evados.eva_item_reporte WHERE id_reporte=".$fila['id_reporte']." ORDER BY id_item_reporte ASC";
	
	 $sql="SELECT eir.id_item_reporte,nombre,url FROM evados.eva_reporte_perfil erp INNER JOIN evados.eva_item_reporte eir ON erp.id_reporte=eir.id_reporte AND erp.id_item_reporte=eir.id_item_reporte WHERE rdb=".$institucion." and id_perfil=".$perfil." and eir.id_reporte=".$fila['id_reporte'];

	$rs_item = pg_exec($ob_membrete->Conec->conectar(),$sql) or die("SELECT REPORTE2:".$sql);

	for($x=0;$x<pg_numrows($rs_item);$x++){
		$fila_item = @pg_fetch_array($rs_item,$x);
?>
	<tr>
		<td width="5%" class="textosimple"><img src="mod/reportes/arrow.png" width="9" height="9"></td>
		<td width="95%" class="textosimple" align="left">&nbsp;<a href="#" onclick=enviapag("<?=trim($fila_item['url'])?>")><?=$fila_item['nombre'];?></a></td>
	  </tr>
<? }
} ?>
		</table>
	</td>
    <td valign="top"><table width="100%" border="0" cellpadding="3" cellspacing="0">
<? for($i=3;$i<@pg_numrows($rs_reporte);$i++){
		$fila = @pg_fetch_array($rs_reporte,$i);
		$cont2 = $cont + 1;
?>
		  <tr>
			<td width="91%" class="cuadro02">&nbsp;<?=$fila['nombre'];?></td>
		  </tr>
<? 	$sql ="SELECT id_item_reporte, nombre, url FROM evados.eva_item_reporte WHERE id_reporte=".$fila['id_reporte'];
	$rs_item = @pg_exec($ob_membrete->Conec->conectar(),$sql) or die("SELECT REPORTE:".$sql);
	
	for($x=0;$x<@pg_numrows($rs_item);$x++){
		$fila_item = @pg_fetch_array($rs_item,$x);
?>
	<tr>
		<td width="9%" class="textosimple"><img src="cortes/arrow.png" width="9" height="9"></td>
		<td width="91%" class="textosimple">&nbsp;<?=$fila_item['nombre'];?></td>
	  </tr>
<? }
 } ?>
		</table></td>
  </tr>
</table>


<div id="botton" >

</div>

</fieldset>






</div>




</body>
</html>
