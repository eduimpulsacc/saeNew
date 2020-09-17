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
      <td>
      <input type="button" name="Submit" value="VOLVER" onClick="javascript:history.back(1) " class="botonXX"/>
      </td>
      <td>
      <div align="right">
        <input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR" />
      </div>
      </td>
	  
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
          <td class="titulo1">ESCUELAS CON GRUPO DE DIFERENCIAL <br />
          A&Ntilde;O <?=$ano;?></td>
        </tr>
      </table>
    <br />
    <?  $sql = "SELECT count(a.*) as total,b.nombre as diag,c.nombre_instit,c.rdb, e.nombre_emp || cast(' ' as varchar) || e.ape_pat || ";
									$sql.= "cast(' ' as varchar) as nombre_emp, f.hrs_contrato,f.total_aula,d.objetivo ";
									$sql.= "FROM alumno_proyecto a INNER JOIN diagnostico b ON  a.id_dignos=b.id_dignos ";
									$sql.= "INNER JOIN institucion c ON a.rdb=c.rdb INNER JOIN proyecto_grupo d ON a.id_proy=d.id_proy AND d.rdb=c.rdb ";
									$sql.= "INNER JOIN empleado e ON d.rut_emp=e.rut_emp INNER JOIN dotacion_docente f ON f.rut_emp=e.rut_emp AND f.rut_emp=d.rut_emp ";
									$sql.= "AND f.rdb=a.rdb AND f.rdb=c.rdb AND f.rdb=d.rdb INNER JOIN ano_escolar g ON a.id_ano=g.id_ano ";
									$sql.= "WHERE c.rdb in (SELECT rdb FROM corp_instit WHERE num_corp=2) AND d.tipo=".$corporacion." AND g.nro_ano=".$cmbANO."";
									$sql.= "group by b.nombre,c.nombre_instit,c.rdb,e.nombre_emp,e.ape_pat, f.hrs_contrato,f.total_aula ,d.objetivo ";
									
								// tablas no creadas en viña se deja pendiente query  :D 
								
									
									$rs_grupo=@pg_exec($conn,$sql);
									
									
							?>		
									<table width="100%" border="1" cellspacing="0" cellpadding="3">
									  <tr  class="tabla04">
										<td class="celdas1">RDB</td>
										<td class="celdas1">ESTABLECIMIENTO</td>
										<td class="celdas1">PROFESOR</td>
										<td class="celdas1">GRUPO<br>DIFERENCIAL</td>
										<td class="celdas1"><p>N&ordm; ALUMNOS<br>POR GRUPO</p></td>
										<td class="celdas1"><p>HORAS<br>
										  CONTRATO</p>									    </td>
										<td class="celdas1">HORAS<br>AULA</td>
										<td class="celdas1">RANGO<br>ATENCI&Oacute;N</td>
										<td class="celdas1">OBSERVACIONES</td>
									  </tr>
									  <? for($i=0;$i<@pg_numrows($rs_grupo);$i++){
									  		$fila_grupo= @pg_fetch_array($rs_grupo,$i);
											$cont_g++;
										?>
									  <tr>
										<td class="text2"><div align="center">
										  <?=$fila_grupo['rdb'];?>
									    </div></td>
										<td class="text2"><div align="center">
										  <?=$fila_grupo['nombre_instit'];?>
									    </div></td>
										<td class="text2"><div align="center">
										  <?=$fila_grupo['nombre_emp'];?>
									    </div></td>
										<td class="text2"><div align="center">
										  <?=$fila_grupo['diag'];?>
									    </div></td>
										<td class="text2"><div align="center">
										  <?=$fila_grupo['total'];?>
									    </div></td>
										<td class="text2"><div align="center">
										  <?=$fila_grupo['hrs_contrato'];?>
									    </div></td>
										<td class="text2"><div align="center">
										  <?=$fila_grupo['total_aula'];?>
									    </div></td>
										<td class="text2"><div align="center"></div></td>
										<td class="text2"><div align="center">
										  <?=$fila_grupo['objetivo'];?>
									    </div></td>
									  </tr>
									  <? 	$total_alum_g = $total_alum_g + $fila_grupo['total'];
									  		$total_contrato_g = $total_contrato_g + $fila_grupo['hrs_contrato'];
											$total_aula_g = $total_aula_g + $fila_grupo['total_aula'];
									  
									  } ?>
									  <tr class="tabla04">
										<td class="celdas1"><div align="center"></div></td>
										<td class="celdas1"><div align="center">TOTAL (<?=$i;?>)</div></td>
										<td class="celdas1"><div align="center"></div></td>
										<td class="celdas1"><div align="center"></div></td>
										<td class="celdas1"><div align="center">
										  <?=$total_alum_g;?>
									    </div></td>
										<td class="celdas1"><div align="center">
										  <?=$total_contrato_g;?>
									    </div></td>
										<td class="celdas1"><div align="center">
										  <?=$total_aula_g;?>
									    </div></td>
										<td class="celdas1"><div align="center"></div></td>
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