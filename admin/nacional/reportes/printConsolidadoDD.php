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
          <td class="titulo1">DOTACI&Oacute;N DOCENTE <br />
            A&Ntilde;O <?=$ano;?></td>
        </tr>
      </table>
    <br />
    <?
		
		$sql_corp = "SELECT rdb FROM corp_instit
		inner join nacional_corp on nacional_corp.num_corp = corp_instit.num_corp
        inner join nacional on nacional.id_nacional = nacional_corp.id_nacional
        where nacional.id_nacional=".$corporacion.";";

		$rs_corp = @pg_exec($conn,$sql_corp);
		
		for($a=0;$a<@pg_numrows($rs_corp);$a++){
		
			$fila_corp = @pg_fetch_array($rs_corp,$a);
			if($a!=pg_numrows($rs_corp)-1){
					$rdb = $rdb.$fila_corp['rdb'].",";
			 }else{
					$rdb = $rdb.$fila_corp['rdb'];
			  }
		  }
											
		$sql = "SELECT nombre_instit, rdb FROM institucion WHERE rdb in (".$rdb.")";
		$rs_instit = @pg_exec($conn,$sql);
												
										?>
													<br>
													<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
													<? for($x=0;$x<@pg_numrows($rs_instit);$x++){
															$fila_inst = @pg_fetch_array($rs_instit,$x);
									
														}
										
													?>
															
													  <tr>
														<td class="Estilo20"><b></b></td>
													  </tr>
													  <tr>
														<td>
														<table width="100%" border="1" cellpadding="5" cellspacing="0" class="tabla2">
											  <tr>
												<td colspan="11" class="celdas1">DOCENTES</td>
											  </tr>
											  <tr>
												<td class="celdas1">RBD</td>
												<td class="celdas1">INSTITUCI&Oacute;N</td>
												<td class="celdas1">HORAS<br />
												CONT.</td>
												<td class="celdas1">ART.69</td>
											  <td class="celdas1">HORAS<br />
												  AMPLIAC. <br />
												  SIMPLES</td>
												<td class="celdas1">HORAS<br />
												  AMPLIAC.<br />
												  JEC</td>
											  <td class="celdas1">TOTAL<br />
												  HORAS<br />
												  AULA</td>
											  </tr>
											  <? for($x=0;$x<@pg_numrows($rs_instit);$x++){
											  $fila_inst = @pg_fetch_array($rs_instit,$x);
											  	$sql = "SELECT id_ano FROM ano_escolar WHERE id_institucion=".$fila_inst['rdb']." AND nro_ano=".$cmbANO."  ";
												$rs_ano = pg_exec($conn,$sql);
												$ano_inst = pg_result($rs_ano,0);
												
												if($ano_inst=="") $ano_inst=0;
																				
												$sql =" SELECT * FROM dotacion_docente a ";
												$sql.=" INNER JOIN empleado b ON a.rut_emp=b.rut_emp WHERE rdb=".$fila_inst['rdb']." and";
												$sql.=" id_ano=".$ano_inst;
												$rs_empleado = @pg_exec($conn,$sql) or die ("SELECT FALLÓ (DotacionDocente):".$sql);
												
							
											  ?>
												 <? 
												$sql_inst = "SELECT nombre_instit, rdb FROM institucion WHERE rdb in (".$rdb.")";
												$rs_instit = @pg_exec($conn,$sql_inst);
											
												 $fila_inst = @pg_fetch_array($rs_instit,$x);
												 
												 
											  	$sql = "SELECT id_ano FROM ano_escolar WHERE id_institucion=".$fila_inst['rdb']." AND nro_ano=".$cmbANO."  ";
												$rs_ano = pg_exec($conn,$sql);
												$ano_inst = pg_result($rs_ano,0);
												
												if($ano_inst=="") $ano_inst=0;
																				
									
												$sql="SELECT COUNT(*) as cantidad,SUM(hrs_contrato) as contrato,SUM(art_69) as ";
												$sql.="art69,SUM(amp_simple) as simple,SUM(amp_jec) as amp_jec,SUM(total_aula) as ";
												$sql.="aula FROM dotacion_docente WHERE";
												$sql.=" rdb=".$fila_inst['rdb']." and id_ano=".$ano_inst;
												$rs_empleado = @pg_exec($conn,$sql) or die ("SELECT FALLÓ (DotacionDocente):".$sql);
												
											 
											 
												$fila_emp = @pg_fetch_array($rs_empleado,0);										 
												 
												 
												 ?>
											  <tr>
												<td class="text2"><div align="right">
													<?=$fila_inst['rdb'];?>
												</div></td>
												<td class="text2"><div align="left"><?=strtoupper($fila_inst['nombre_instit']);?></div></td>
												<td class="text2"><? if($fila_emp['contrato']==NULL){echo "0";}else{ echo $fila_emp['contrato'];}?></td>
												<td class="text2"><? if($fila_emp['art69']==NULL){echo "0";}else{ echo $fila_emp['art69'];}?></td>
												<td class="text2"><? if($fila_emp['simple']==NULL){echo "0";}else{ echo $fila_emp['simple'];}?></td>
												<td class="text2"><? if($fila_emp['amp_jec']==NULL){echo "0";}else{ echo $fila_emp['amp_jec'];}?></td>
												<td class="text2"><? if($fila_emp['aula']==NULL){echo "0";}else{ echo $fila_emp['aula'];}?></td>

											 
											  <? 	$total_contrato_1 += $fila_emp['contrato'];
											  		$total_69_1 += $fila_emp['art69'];
													$total_simple_1 += $fila_emp['simple'];
													$total_jec_1 += $fila_emp['amp_jec'];
													$total_aula_1 += $fila_emp['aula'];
													$total_ex_1 += $fila_emp['excedente'];
													
											  } ?>
											  <tr>
												<td colspan="2" class="celdas2">TOTALES (<?=$a;?>)</td>
												<td class="celdas2"><?=$total_contrato_1;?></td>
												<td class="celdas2"><?=$total_69_1;?></td>
												<td class="celdas2"><?=$total_simple_1;?></td>
												<td class="celdas2"><?=$total_jec_1;?></td>
												<td class="celdas2"><?=$total_aula_1;?></td>
											  </tr>
											   
								 		</table>
														</td>
													  </tr>
													  <tr>
													  	<td>&nbsp;</td>
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