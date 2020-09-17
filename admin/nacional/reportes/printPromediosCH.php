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
          <td class="titulo1"><div align="center">PROMEDIOS ESTABLECIMIENTOS CIENTIFICO HUMANISTICO POR NIVEL </div>
                    A&Ntilde;O <?=$ano;?></td>
        </tr>
      </table>
    <br />
	<?  				$qry_niv = "select id_nivel, nombre from niveles where id_nivel=".$cmbNIVEL;
								$result_niv =@pg_Exec($conn,$qry_niv);
								for ($i=0; $i < @pg_numrows($result_niv); $i++){
									 $fila = @pg_fetch_array($result_niv,$i);	
									 $nombre_nivel  = $fila['nombre'];
									 $id_nivel      = $fila['id_nivel'];
								}
								
/*						$qry2="SELECT institucion.nombre_instit, institucion.rdb FROM institucion inner join corp_instit on";
						$qry2.=" institucion.rdb = corp_instit.rdb inner join tipo_ense_inst on corp_instit.rdb =";
						$qry2.=" tipo_ense_inst.rdb WHERE corp_instit.num_corp = ' ".$_CORPORACION." ' and ";
						$qry2.="tipo_ense_inst.cod_tipo = 310  group by institucion.rdb, institucion.nombre_instit";*/
						
$qry2 = "SELECT institucion.nombre_instit, institucion.rdb 
FROM institucion 
INNER JOIN corp_instit on institucion.rdb = corp_instit.rdb 
INNER JOIN nacional_corp on nacional_corp.num_corp = corp_instit.num_corp
INNER JOIN nacional on nacional.id_nacional = nacional_corp.id_nacional
INNER JOIN tipo_ense_inst on corp_instit.rdb = tipo_ense_inst.rdb 
WHERE nacional.id_nacional = '".$corporacion."' and tipo_ense_inst.cod_tipo = 310  
group by institucion.rdb, institucion.nombre_instit";
						
							$result2 =@pg_Exec($conn,$qry2);
							for ($i=0; $i < @pg_numrows($result2); $i++){
							    $fila2 = @pg_fetch_array($result2,$i);
							    $nombre_institucion_[] = $fila2['nombre_instit'];
								$rdb_[] = $fila2['rdb'];
									
				
						$qry4="SELECT nro_ano, id_ano FROM ano_escolar WHERE nro_ano = '".$cmbANO."' and id_institucion = ".$rdb_[$i];
								$result4 =@pg_Exec($conn,$qry4);
								if (pg_numrows($result4)==0){
								    $id_ano_[] = 0;
								}else{
								    $fila4 = @pg_fetch_array($result4,0);
								    $id_ano_[] = $fila4['id_ano'];
							    }
									
		
						$qry="SELECT periodo.id_periodo, periodo.nombre_periodo FROM periodo WHERE nombre_periodo = '".$cmbPERIODO."' ";
						$qry.="and id_ano =".$id_ano_[$i];
								$result =@pg_Exec($conn,$qry);
								if ($id_ano_[$i]==0){
								    $id_periodo_[]  =  0;										
								}else{
								    $fila1 = @pg_fetch_array($result,0);
								    $id_periodo_[]  = $fila1['id_periodo'];									    	
								}
							}										
						
						     ?>	
    <table width="650" border="1" align="center" cellpadding="2" cellspacing="0" class="Estilo7">
                                       <tr>
                                         <td class="celdas1">&nbsp;</td>
                                         <td align="center" class="celdas1">Promedios</td>
                                         <td class="celdas1">&nbsp;</td>
                                       </tr>
                                       <tr>
                                         <td class="celdas1">Establecimientos</td>
                                        <?										
										if ($id_nivel==7){ ?>
                                            <td align="center" class="celdas1">1&ordm; E. M.</td>
                                       <? } 
									   
									    if ($id_nivel==8){ ?>									   
                                            <td align="center" class="celdas1">2&ordm; E. M.</td>
                                       <? }
									   
									    if ($id_nivel==9){ ?>  
										    <td align="center" class="celdas1">3&ordm; E. M.</td>
                                        <? }
										
										if ($id_nivel==10){ ?>
										    <td align="center" class="celdas1">4&ordm; E. M.</td>
                                        <? } ?>										
										 <td align="center" class="celdas1">Prom. Final</td>
                                       </tr>
                                      
										
									      <?
									  for ($i=0; $i < @pg_numrows($result2); $i++){
										  $suma_promedio = 0;
										  $contador_promedios=0;
								              ?>								  
										      <tr>
											    <td class="text2"><div align="left">
											      <?=$nombre_institucion_[$i]?>
										        </div></td>		
												
												<?
										        if ($id_nivel==7){ ?>							
													<td align="center" class="text2">
													  <div align="center">
													    <?
									$sql_curso1 = "select  sum(CAST(promedio AS integer)) as suma, count(promedio) as";
									$sql_curso1.=" cantidad from notas$cmbANO where id_ramo in (select id_ramo from ramo";
									$sql_curso1.=" where id_curso in (select id_curso from curso where id_ano in (select";										
									$sql_curso1.=" id_ano from ano_escolar where id_institucion = ".$rdb_[$i]." and id_ano";
									$sql_curso1.=" = ".$id_ano_[$i].") and ensenanza = '310' and grado_curso = '1'))   and";
									$sql_curso1.=" id_periodo = ".$id_periodo_[$i]." and promedio not in ('0','MB','B','I','S',' ')";
												$result_curso1 = @pg_Exec($conn, $sql_curso1) or die (pg_last_error($conn));
												$fila_curso1 = @pg_fetch_array($result_curso1,0);
												$cantidad = $fila_curso1['cantidad'];
												$suma     = $fila_curso1['suma'];
												$promedio1 = round($suma / $cantidad);
												 
													if ($promedio1>0){
													   $suma_promedio = $suma_promedio + $promedio1;
													   $contador_promedios++;
													}
													echo number_format($promedio1,'0',',','.');
													
													?>												
											        </div></td>   
												<? } ?>
												
												<?
										        if ($id_nivel==8){ ?>	                                    
													<td align="center" class="text2">
													  <div align="center">
													    <?
									$sql_curso2 = "select  sum(CAST(promedio AS integer)) as suma, count(promedio) as cantidad";
									$sql_curso2.=" from notas$cmbANO where id_ramo in (select id_ramo from ramo where id_curso";
									$sql_curso2.=" in (select id_curso from curso where id_ano in (select id_ano from";
									$sql_curso2.=" ano_escolar where id_institucion = ".$rdb_[$i]." and id_ano ";
									$sql_curso2.="= ".$id_ano_[$i].") and ensenanza = '310' and grado_curso = '2')) and ";
									$sql_curso2.="id_periodo = ".$id_periodo_[$i]." and promedio not in ('0','MB','B','I','S',' ')";
												$result_curso2 = @pg_Exec($conn, $sql_curso2);
												$fila_curso2 = @pg_fetch_array($result_curso2,0);
												$cantidad = $fila_curso2['cantidad'];
												$suma     = $fila_curso2['suma'];
												$promedio2 = round($suma / $cantidad);
												 
													if ($promedio2>0){
													   $suma_promedio = $suma_promedio + $promedio2;
													   $contador_promedios++;

													}
													
													echo number_format($promedio2,'0',',','.');
													
													?>
											        </div></td>
												<? } ?>
												
												<?
										        if ($id_nivel==9){ ?>
													   <td align="center" class="text2">
													     <div align="center">
													       <?
									$sql_curso3 = "select  sum(CAST(promedio AS integer)) as suma, count(promedio) as cantidad";
									$sql_curso3.=" from notas$cmbANO where id_ramo in (select id_ramo from ramo where id_curso ";
									$sql_curso3.="in (select id_curso from curso where id_ano in (select id_ano from ano_escolar";
									$sql_curso3.=" where id_institucion = ".$rdb_[$i]." and id_ano = ".$id_ano_[$i].") and";
									$sql_curso3.=" ensenanza = '310' and grado_curso = '3'))   and id_periodo = ";
									$sql_curso3.="".$id_periodo_[$i]." promedio not in ('0','MB','B','I','S',' ')";
													$result_curso3 = @pg_Exec($conn, $sql_curso3);
													$fila_curso3 = @pg_fetch_array($result_curso3,0);
													$cantidad = $fila_curso3['cantidad'];
													$suma     = $fila_curso3['suma'];
													$promedio3 = round($suma / $cantidad);
													 
														if ($promedio3>0){
														   $suma_promedio = $suma_promedio + $promedio3;
														   $contador_promedios++;
														}
														
														echo number_format($promedio3,'0',',','.');
													
													?>
											           </div></td>
												<? } ?>
												
												<?
										        if ($id_nivel==10){ ?>
													   <td align="center" class="text2">
													     <div align="center">
													       <?
									$sql_curso4 = "select  sum(CAST(promedio AS integer)) as suma, count(promedio) as cantidad from";
									$sql_curso4.=" notas$cmbANO where id_ramo in (select id_ramo from ramo where id_curso in ";
									$sql_curso4.="(select id_curso from curso where id_ano in (select id_ano from ano_escolar where";
									$sql_curso4.=" id_institucion = ".$rdb_[$i]." and id_ano = ".$id_ano_[$i].") and ensenanza = ";
									$sql_curso4.="'310' and grado_curso = '4')) and id_periodo = ".$id_periodo_[$i]." and promedio not in ('0','MB','B','I','S',' ')";
														$result_curso4 = @pg_Exec($conn, $sql_curso4);
														$fila_curso4 = @pg_fetch_array($result_curso4,0);
														$cantidad = $fila_curso4['cantidad'];
														$suma     = $fila_curso4['suma'];
														$promedio4 = @round($suma / $cantidad);
													 
														if ($promedio4>0){
														   $suma_promedio = $suma_promedio + $promedio4;
														   $contador_promedios++;
														}
														
														echo number_format($promedio4,'0',',','.');
														?>
											           </div></td>
												<? }
												
												$prom_establecimiento = @round($suma_promedio / $contador_promedios);
												
												 ?>
												
											       <td align="center" class="text2">
											         <div align="center">
											           <?=number_format($prom_establecimiento,'0',',','.');?>
									               </div></td>
										      </tr>
											  <?
											  	if($prom_establecimiento > 0){
													$promedio_final_est = $promedio_final_est + $prom_establecimiento;
													$contador_final_est ++;
												}
										  } 
	$prom_final_est = round($promedio_final_est / $contador_final_est);
	?>	  
<tr>
<td class="celdas1"><div align="left">Promedio Final </div></td>
<td align="center" class="celdas1"><?=number_format($prom_final_est,'0',',','.');?></td>
<td align="center" class="celdas1"><?=number_format($prom_final_est,'0',',','.');?></td>
</tr>
</table>
<br />
<br />
<br />
</td>
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