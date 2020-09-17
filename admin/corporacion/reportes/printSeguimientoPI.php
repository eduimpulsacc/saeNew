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
          <td class="titulo1">SEGUIMIENTO DE ESCUELAS CON PROYECTO DE INTEGRACI&Oacute;N <br />
          A&Ntilde;O <?=$ano;?></td>
        </tr>
      </table>
    <br />
    <? $sql = "SELECT rdb,nombre_instit,id_ano FROM institucion INNER JOIN ano_escolar ON rdb=id_institucion WHERE rdb IN(SELECT rdb FROM corp_instit WHERE num_corp=".$corporacion.") AND nro_ano=".$cmbANO."";
	$rs_instit = @pg_exec($conn,$sql);?>
<table width="850" border="1" align="center" cellpadding="3" cellspacing="0">
  <? 	$sql = "select id_dignos,nombre from diagnostico where rdb IN (SELECT rdb FROM corp_instit WHERE num_corp=".$corporacion.") and tipo=1";
  		$rs_diag = @pg_exec($conn,$sql);
  ?>	
  <tr  class="tabla04">
	<td class="celdas1">RDB</td>
	<td class="celdas1">ESTABLECIMIENTO</td>
	<? for($i=0;$i<@pg_numrows($rs_diag);$i++){
			$fila_d = @pg_fetch_array($rs_diag,$i);
	?>
	<td class="celdas1"><?=$fila_d['nombre'];?></td>
	<? } ?>
	<td class="celdas1">TOTAL<br> PROYECTO<br>INTEGRACI&Oacute;N</td>
	<td class="celdas1">APROBADOS</td>
	<td class="celdas1">REPROBADOS</td>
	<td class="celdas1">MEJORA<br>RENDIMIENTO<br> LENGUAJE</td>
	<td class="celdas1">MEJORA<br>RENDIMIENTO<br>MATEMATICAS</td>
	<td class="celdas1">RETIRADO</td>
  </tr>
  <? for($i=0;$i<@pg_numrows($rs_instit);$i++){
  		$fila_ins = @pg_fetch_array($rs_instit,$i);
		$cont++;
		$cont_total=0;
		
		$sql ="SELECT count(*) as mlenguaje FROM alumno_proyecto a INNER JOIN proyecto_grupo b ON a.id_proy=b.id_proy WHERE b.rdb=".$fila_ins['rdb']." AND ";
		$sql.="id_ano=".$fila_ins['id_ano']." AND mejora_lenguaje=1 AND tipo=1";
		$rs_mlenguaje =@pg_exec($conn,$sql);
		$cont_mlenguaje = @pg_result($rs_mlenguaje,0);
		
		$sql ="SELECT count(*) as matematica FROM alumno_proyecto a INNER JOIN proyecto_grupo b ON a.id_proy=b.id_proy WHERE b.rdb=".$fila_ins['rdb']." AND ";
		$sql.="id_ano=".$fila_ins['id_ano']." AND mejora_matematica=1 AND tipo=1";
		$rs_matematica =@pg_exec($conn,$sql);
		$cont_matematica = @pg_result($rs_matematica,0);
		
		$sql ="SELECT count(*) as aprobado FROM alumno_proyecto a INNER JOIN proyecto_grupo b ON a.id_proy=b.id_proy WHERE b.rdb=".$fila_ins['rdb']." AND ";
		$sql.="id_ano=".$fila_ins['id_ano']." AND aprobado=1 AND tipo=1";
		$rs_aprobado =@pg_exec($conn,$sql);
		$cont_aprobado = @pg_result($rs_aprobado,0);
		
		$sql ="SELECT count(*) as reprobado FROM alumno_proyecto a INNER JOIN proyecto_grupo b ON a.id_proy=b.id_proy WHERE b.rdb=".$fila_ins['rdb']." AND ";
		$sql.="id_ano=".$fila_ins['id_ano']." AND reprobado=1 AND tipo=1";
		$rs_reprobado =@pg_exec($conn,$sql);
		$cont_reprobado = @pg_result($rs_reprobado,0);
		
		$sql ="SELECT count(*) as retirado FROM alumno_proyecto a INNER JOIN proyecto_grupo b ON a.id_proy=b.id_proy WHERE b.rdb=".$fila_ins['rdb']." AND ";
		$sql.="id_ano=".$fila_ins['id_ano']." AND retirado=1 AND tipo=1";
		$rs_retirado =@pg_exec($conn,$sql);
		$cont_retirado = @pg_result($rs_retirado,0);
	?>
  <tr>
	<td class="text2"><div align="center">
	  <?=$fila_ins['rdb'];?>
	  </div></td>
	<td class="text2"><div align="center">
	  <?=$fila_ins['nombre_instit'];?>
	  </div></td>
	<? for($j=0;$j<@pg_numrows($rs_diag);$j++){
			$fila_di = @pg_fetch_array($rs_diag,$j);
			$sql ="SELECT count(*) as lenguaje FROM alumno_proyecto a INNER JOIN proyecto_grupo b ON a.id_proy=b.id_proy AND a.rdb=b.rdb WHERE   ";
			$sql.="b.rdb=".$fila_ins['rdb']." AND id_ano=".$fila_ins['id_ano']." AND id_dignos=".$fila_di['id_dignos']." AND tipo=1";
			$rs_lenguaje =@pg_exec($conn,$sql);
			$cont_diag = @pg_result($rs_lenguaje,0);
			$total_dig[$j]=$total_dig[$j] + $cont_diag;
			$cont_total +=$cont_diag; 
	?>
	<td class="text2"><div align="center">
	  <?=$cont_diag;?>
	  </div></td>
	<? } ?>
	<td class="text2"><div align="center">
	  <?=$cont_total;?>
	  </div></td>
	<td class="text2"><div align="center">
	  <?=$cont_aprobado;?>
	  </div></td>
	<td class="text2"><div align="center">
	  <?=$cont_reprobado;?>
	  </div></td>
	<td class="text2"><div align="center">
	  <?=$cont_mlenguaje;?>
	  </div></td>
	<td class="text2"><div align="center">
	  <?=$cont_matematica;?>
	  </div></td>
	<td class="text2"><div align="center">
	  <?=$cont_retirado;?>
	  </div></td>
  </tr>
  <? 	$total_reprobado = $total_reprobado + $cont_reprobado;
		$total_retirado = $total_retirado + $cont_retirado;
		$total_aprobado = $total_aprobado + $cont_aprobado;
		$total_mlenguaje = $total_mlenguaje + $cont_mlenguaje;
		$total_matematica = $total_matematica + $cont_matematica;
		$total_alum = $total_alum + $cont_total;

  } ?>
  <tr  class="tabla04">
	<td class="celdas1"><div align="center"></div></td>
	<td class="celdas1"><div align="center">TOTAL (
	  <?=$i;?>
	  )</div></td>
	<? for($j=0;$j<@pg_numrows($rs_diag);$j++){ ?>
	<td class="celdas1">
	  <div align="center">
	    <?=$total_dig[$j];?>
	    </div></td><? } ?>
	    <td class="celdas1">
	        <div align="center">
	          <?=$total_alum;?>
              </div></td>
	    <td class="celdas1">
	        <div align="center">
	          <?=$total_aprobado;?>
              </div></td>
	    <td class="celdas1">
	        <div align="center">
	          <?=$total_reprobado;?>
              </div></td>
	    <td class="celdas1">
	        <div align="center">
	          <?=$total_mlenguaje;?>
              </div></td>
	    <td class="celdas1">
	        <div align="center">
	          <?=$total_matematica;?>
              </div></td>
	    <td class="celdas1">
	        <div align="center">
	          <?=$total_retirado;?>
              </div></td></tr>
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