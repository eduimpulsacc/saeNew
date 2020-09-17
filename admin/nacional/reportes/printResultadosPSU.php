<?

include("../controlador/controlador_1.php");


$corporacion	= $_NACIONAL;

//$corporacion	= 2; 	//Usar esta corporación para pruebas si es que no existen datos en corporación

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
          <td class="titulo1">RESULTADOS PSU <br />
          A&Ntilde;O <?=$ano;?></td>
        </tr>
      </table>
    <br />	
	<? 
	
/*$sql  ="SELECT nombre_instit, rdb, id_ano FROM institucion a INNER JOIN ano_escolar b ON a.rdb=b.id_institucion WHERE rdb in (SELECT rdb FROM corp_instit WHERE num_corp=".$corporacion.") AND nro_ano=".$cmbANO;
*/	
	
	$sql = "SELECT rdb,nombre_instit,id_ano FROM institucion INNER JOIN ano_escolar ON rdb=id_institucion 
			    WHERE rdb IN(SELECT rdb FROM corp_instit 
				inner join nacional_corp on nacional_corp.num_corp = corp_instit.num_corp 
				inner join nacional on nacional.id_nacional = nacional_corp.id_nacional 
				where nacional.id_nacional=".$corporacion." 
				) AND nro_ano=".$cmbANO.";";
				
				$rs_instit = @pg_exec($conn,$sql);
					
					$sql_subsector = "SELECT distinct a.cod_subsector,b.nombre FROM psu_conf_2009 a INNER JOIN subsector b ON a.cod_subsector=b.cod_subsector ";
					$sql_subsector.= "INNER JOIN ano_escolar c ON a.cod_ano=c.id_ano WHERE c.id_institucion in (SELECT rdb FROM corp_instit WHERE num_corp=".$corporacion.") ";
					$sql_subsector.= " AND nro_ano=".$cmbANO;
					$rs_subsector = @pg_exec($conn,$sql_subsector);
					
			?>
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
                        <? 	for($i=0;$i<@pg_numrows($rs_instit);$i++){
						   		$fila_instit = @pg_fetch_array($rs_instit,$i);
								
								
								
					   ?>
                        <tr>
                          <td class="text2"><div align="center">
                            <?=$fila_instit['rdb'];?>
                          </div></td>
                          <td class="text2"><div align="center">
                            <?=$fila_instit['nombre_instit'];?>
                          </div></td>
                          <? $puntaje_inst=0;
						  for($x=0;$x<@pg_numrows($rs_subsector);$x++){
								$fila_sub = @pg_fetch_array($rs_subsector,$x);
								
								$sql =" SELECT avg(puntaje) FROM psu_notas_2009 WHERE cod_ano in (SELECT id_ano FROM ano_Escolar WHERE ";
								$sql.=" id_institucion=".$fila_instit['rdb']." AND nro_ano=".$cmbANO.") AND cod_sub_psu in (SELECT cod_sub_psu ";
								$sql.=" FROM psu_conf_2009 WHERE cod_subsector=".$fila_sub['cod_subsector'].") 	";
								$rs_puntaje = @pg_exec($conn,$sql);
								$puntaje = @pg_result($rs_puntaje,0);
						  ?>
						  <td class="text2"><div align="center">
						    <?=round($puntaje,1);?>
					      </div></td>
                          <? 
						  	$puntaje_inst += $puntaje;
							$puntaje_sub[$x] +=$puntaje;
						  } ?>
						  <td class="celdas1"><div align="center">
						    <? $puntaje_inst = $puntaje_inst/$x;
							   echo round($puntaje_inst,0);?>
					      </div></td>
                        </tr>
                        <? } 
						
						?>
                        <tr>
                          <td class="celdas1"><div align="center"></div></td>
                          <td class="celdas1"><div align="center">RESULTADO PUNTAJE </div></td>
						<?	for($y=0;$y<@pg_numrows($rs_subsector);$y++){
							$fila_sub = @pg_fetch_array($rs_subsector,$y);
							
							for($a=0;$a<$i;$a++){
								$fila_instit = @pg_fetch_array($rs_instit,$a);
								$sql =" SELECT avg(puntaje) FROM psu_notas_2009 WHERE cod_ano in (SELECT id_ano FROM ano_Escolar WHERE ";
								$sql.=" id_institucion=".$fila_instit['rdb']." AND nro_ano=".$cmbANO.") AND cod_sub_psu in (SELECT cod_sub_psu ";
								$sql.=" FROM psu_conf_2009 WHERE cod_subsector=".$fila_sub['cod_subsector'].") 	";
								$rs_puntaje_sub = @pg_exec($conn,$sql);
								
								$prom_sub = @pg_result($rs_puntaje_sub,0);
								$prom_sub_total[$y] = $prom_sub_total[$y]+$prom_sub;
								}
						?>
                          <td class="celdas1"><div align="center">
                            <? 	$puntaje_sub = $prom_sub_total[$y]/$a;
								echo round($puntaje_sub,0);?>
                          </div></td>
                        <? } ?>
                          <td class="celdas1"><div align="center"></div></td>
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
        <?php switch($_CORPORACION){
			case 6:
				$nom_com="Pe&ntilde;alol&eacute;n,";
			break;
			case 1:
				$nom_com="Santiago,";
			break;
			case 2:
				$nom_com="Vi&ntilde;a del Mar,";
			break;
		}?>
       <div align="right" class="fecha"><?php echo $nom_com ?> <? echo fecha_espanol($fecha);?></div></td>
  </tr>
</table>
</body>
</html>
