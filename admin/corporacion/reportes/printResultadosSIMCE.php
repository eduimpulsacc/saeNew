<?

include("../controlador/controlador_1.php");


$corporacion	= $_CORPORACION;
//$corporacion	= 2;   //Usar esta corporación para pruebas si es que no existen datos en corporación
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
          <td class="titulo1">RESULTADOS SIMCE <? if($cmb_ensenanza==110){ if($cmb_grado==4){ echo "CUARTO GRADO";}else{ echo "OCTAVO GRADO";}}else{ echo "SEGUNDO GRADO";}?><br />
          A&Ntilde;O <?=$ano;?></td>
        </tr>
      </table>
    <br />	
	<? $sql ="SELECT nombre_instit, rdb FROM institucion a INNER JOIN ano_escolar b ON a.rdb=b.id_institucion WHERE rdb in ";
	   $sql.=" (SELECT rdb FROM corp_instit WHERE num_corp=".$corporacion.") AND nro_ano=".$cmbANO."";          																						       $rs_instit = @pg_exec($conn,$sql);
					
	   $sql = "SELECT distinct a.cod_subsector,b.nombre  FROM simce_conf_2009 a INNER JOIN subsector b ON a.cod_subsector=b.cod_subsector ";
	   $sql.="INNER JOIN ano_escolar c ON a.id_ano=c.id_ano WHERE rdb in (SELECT rdb FROM corp_instit WHERE num_corp=".$corporacion.") ";
	   $sql.="AND a.ensenanza=".$cmb_ensenanza." AND a.grado=".$cmb_grado." AND nro_ano=".$cmbANO;
	   $rs_subsector = @pg_exec($conn,$sql);
			?>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
				  <tr>
					<td>&nbsp;</td>
				  </tr>
				  <tr>
					<td>
						<table width="100%" border="1" cellspacing="0" cellpadding="3">
						
						  <tr>
						    <td rowspan="2" class="celdas1">RDB</td>
							<td rowspan="2" class="celdas1">ESTABLECIMIENTO</td>
							<td colspan="<?=pg_numrows($rs_subsector);?>" align="center" class="celdas1">SUBSECTOR</td>
							<td rowspan="2" class="celdas1">RESULTADO<br>PUNTAJE</td>
						  </tr>
						 
						  <tr>
						  <? for($x=0;$x<@pg_numrows($rs_subsector);$x++){
									$fila_sub = @pg_fetch_array($rs_subsector,$x);
							?>
							<td class="celdas1"><?=$fila_sub['nombre'];?></td>
							<? } ?>
						  </tr>
						   <? for($i=0;$i<@pg_numrows($rs_instit);$i++){
								$fila_instit = @pg_fetch_array($rs_instit,$i);
					       ?>
						  <tr>
						    <td class="text2"><?=$fila_instit['rdb'];?></td>
							<td class="text2"><div align="center">
							  <?=$fila_instit['nombre_instit'];?>
						    </div></td>
						  <? 	$prom_inst=0;
								$cont_sub=0;
						  		for($x=0;$x<@pg_numrows($rs_subsector);$x++){
								$fila_sub = @pg_fetch_array($rs_subsector,$x);
								
								$sql ="SELECT avg(nota) FROM simce_notas_2009 WHERE id_ano in (SELECT id_ano FROM ano_Escolar WHERE "; 
								$sql.="id_institucion=".$fila_instit['rdb']."";
								$sql.=" AND nro_ano=".$cmbANO.") AND id_sub_sim in (SELECT id_sub_sim FROM simce_conf_2009 WHERE ";
								$sql.=" cod_subsector=".$fila_sub['cod_subsector']." AND ensenanza=".$cmb_ensenanza." AND grado=".$cmb_grado.")";
								$rs_puntaje = @pg_exec($conn,$sql);	
								$puntaje = @pg_result($rs_puntaje,0);
						  ?>	
							<td class="text2"><div align="center">
							  <?=intval($puntaje);?>
						    </div></td>
						<? 		$prom_inst += $puntaje;
								$prom_sub[$x] +=$puntaje;
								$valor[$x] = $puntaje;
								$puntaje_sub_total[$x] = $puntaje_sub_total[$x]+$puntaje;
								if($valor[$x] !=""){
								 	$cont_sub[$x]=$cont_sub[$x] + 1;
								}
									
						} 
						?>

							<td class="celdas1"><div align="center">
							  <?=intval($prom_inst / @pg_numrows($rs_subsector));?>
						    </div></td>
						  </tr>
						  <? } ?>
						  <tr>
						    <td class="celdas1">&nbsp;</td>
							<td class="celdas1">RESULTADO PUNTAJE </td>
						 <? for($x=0;$x<@pg_numrows($rs_subsector);$x++){?>	
							<td class="celdas1"><?=intval($prom_sub[$x]/$i);?></td>
						<? } ?>
							<td class="celdas1">&nbsp;</td>
						  </tr>
						</table>
						<br>
					</td>
				  </tr>
				</table>
		
    <br />
    <br />
    <br /></td>
  </tr>
  
  <tr>
    <td valign="baseline"><HR />
       <div align="right" class="fecha">Valparaiso,01 de Junio 2010 </div></td>
  </tr>
</table>
</body>
</html>
