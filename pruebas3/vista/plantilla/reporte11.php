<? require('../util/header.inc');

$corporacion	=$_CORPORACION;

$sql ="SELECT * FROM corporacion WHERE num_corp=".$corporacion;
$rs_corp = @pg_exec($conn,$sql);
$nombre = @pg_result($rs_corp,1);
$direc	= @pg_result($rs_corp,2);
$fono	= @pg_result($rs_corp,3);
$logo	= @pg_result($rs_corp,4);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="estilo.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
body {
	background-image: url();
}
-->
</style></head>

<body>
<table width="750" height="843" border="0" align="center" cellpadding="0" cellspacing="0" >
  <tr>
    <td height="113" valign="top">
      <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td colspan="2"><img src="../linea2.jpg" width="730" height="4" /></td>
        </tr>
        <tr>
          <td rowspan="5"> <?  echo "<img src='../tmp/".$logo. "' >"; ?></td>
          <td class="membrete">&nbsp;</td>
        </tr>
        <tr>
          <td class="membrete"><div align="right"><?="Corporación ".$nombre;?></div></td>
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
          <td colspan="2"><img src="../linea.jpg" width="730" height="4" /></td>
        </tr>
      </table>
      <br />
      <br />
      <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" >
        <tr>
          <td class="titulo1">TOTAL DE MATRICULA TODOS LOS ESTABLECIMIENTOS </td>
        </tr>
      </table>
    <br />
    <table width="98%" border="1" align="center" cellpadding="0" cellspacing="0" class="tabla2">
      <tr>
        <td rowspan="2" class="celdas1">ESTABLECIMIENTO</td>
        <td colspan="11" class="celdas1">2010</td>
        <td rowspan="2" class="celdas1">TOTAL</td>
      </tr>
      <tr>
        <td class="celdas1">FEB</td>
        <td class="celdas1">MAR</td>
        <td class="celdas1">ABR</td>
        <td class="celdas1">MAY</td>
        <td class="celdas1">JUN</td>
        <td class="celdas1">JUL</td>
        <td class="celdas1">AGO</td>
        <td class="celdas1">SEP</td>
        <td class="celdas1">OCT</td>
        <td class="celdas1">NOV</td>
        <td class="celdas1">DIC</td>
      </tr>
      <tr>
        <td class="text">&nbsp;colegio 1 </td>
        <td class="text2">500&nbsp;</td>
        <td class="text2">501&nbsp;</td>
        <td class="text2">502&nbsp;</td>
        <td class="text2">503&nbsp;</td>
        <td class="text2">504&nbsp;</td>
        <td class="text2">505&nbsp;</td>
        <td class="text2">506&nbsp;</td>
        <td class="text2">507&nbsp;</td>
        <td class="text2">508&nbsp;</td>
        <td class="text2">509&nbsp;</td>
        <td class="text2">510&nbsp;</td>
        <td class="text2">5590&nbsp;</td>
      </tr>
      <tr>
        <td class="text">&nbsp;colegio 2 </td>
        <td class="text2">600&nbsp;</td>
        <td class="text2">601&nbsp;</td>
        <td class="text2">602&nbsp;</td>
        <td class="text2">603&nbsp;</td>
        <td class="text2">604&nbsp;</td>
        <td class="text2">605&nbsp;</td>
        <td class="text2">606&nbsp;</td>
        <td class="text2">607&nbsp;</td>
        <td class="text2">608&nbsp;</td>
        <td class="text2">609&nbsp;</td>
        <td class="text2">610&nbsp;</td>
        <td class="text2">6690&nbsp;</td>
      </tr>
      <tr>
        <td class="text">&nbsp;colegio 3 </td>
        <td class="text2">1500&nbsp;</td>
        <td class="text2">1520&nbsp;</td>
        <td class="text2">1520&nbsp;</td>
        <td class="text2">1520&nbsp;</td>
        <td class="text2">1520&nbsp;</td>
        <td class="text2">1520&nbsp;</td>
        <td class="text2">1520&nbsp;</td>
        <td class="text2">1520&nbsp;</td>
        <td class="text2">1520&nbsp;</td>
        <td class="text2">1520&nbsp;</td>
        <td class="text2">1520&nbsp;</td>
        <td class="text2">1520&nbsp;</td>
      </tr>
      <tr>
        <td class="text">&nbsp;colegio 4 </td>
        <td class="text2">8600&nbsp;</td>
        <td class="text2">8600&nbsp;</td>
        <td class="text2">8600&nbsp;</td>
        <td class="text2">8600&nbsp;</td>
        <td class="text2">8600&nbsp;</td>
        <td class="text2">8600&nbsp;</td>
        <td class="text2">8600&nbsp;</td>
        <td class="text2">8600&nbsp;</td>
        <td class="text2">8600&nbsp;</td>
        <td class="text2">8600&nbsp;</td>
        <td class="text2">8600&nbsp;</td>
        <td class="text2">26000&nbsp;</td>
      </tr>
      <tr>
        <td class="text">&nbsp;colegio 5 </td>
        <td class="text2">&nbsp;</td>
        <td class="text2">&nbsp;</td>
        <td class="text2">&nbsp;</td>
        <td class="text2">&nbsp;</td>
        <td class="text2">&nbsp;</td>
        <td class="text2">&nbsp;</td>
        <td class="text2">&nbsp;</td>
        <td class="text2">&nbsp;</td>
        <td class="text2">&nbsp;</td>
        <td class="text2">&nbsp;</td>
        <td class="text2">&nbsp;</td>
        <td class="text2">&nbsp;</td>
      </tr>
      <tr>
        <td class="text">&nbsp;colegio 6 </td>
        <td class="text2">&nbsp;</td>
        <td class="text2">&nbsp;</td>
        <td class="text2">&nbsp;</td>
        <td class="text2">&nbsp;</td>
        <td class="text2">&nbsp;</td>
        <td class="text2">&nbsp;</td>
        <td class="text2">&nbsp;</td>
        <td class="text2">&nbsp;</td>
        <td class="text2">&nbsp;</td>
        <td class="text2">&nbsp;</td>
        <td class="text2">&nbsp;</td>
        <td class="text2">&nbsp;</td>
      </tr>
      <tr>
        <td class="celdas2">TOTALES</td>
        <td class="celdas2">25000&nbsp;</td>
        <td class="celdas2">50000&nbsp;</td>
        <td class="celdas2">25000&nbsp;</td>
        <td class="celdas2">25000&nbsp;</td>
        <td class="celdas2">25000&nbsp;</td>
        <td class="celdas2">25000&nbsp;</td>
        <td class="celdas2">25000&nbsp;</td>
        <td class="celdas2">25000&nbsp;</td>
        <td class="celdas2">25000&nbsp;</td>
        <td class="celdas2">25000&nbsp;</td>
        <td class="celdas2">25000&nbsp;</td>
        <td class="celdas2">1500000&nbsp;</td>
      </tr>
    </table>
    <br />
    <br />
    <br /></td>
  </tr>
  
  <tr>
    <td valign="baseline"><HR />
<div align="right" class="fecha">Valparaiso,30 de Abril 2010 </div></td>
  </tr>
</table>

<br /><br /><br />

<table width="600" border="0" align="center" cellpadding="5" cellspacing="0">
<tr>
<td>

<table width="100%" border="0" cellpadding="3" cellspacing="0">
  <tr>
    <td colspan="14"><div align="center">Total matr&iacute;cula corporaci&oacute;n</div></td>
    </tr>
  <tr>
    <td bgcolor="#999999" class="Estilo4">Establecimiento</td>
    <td bgcolor="#999999" class="Estilo4"><div align="center">MAR</div></td>
    <td bgcolor="#999999" class="Estilo4"><div align="center">ABR</div></td>
    <td bgcolor="#999999" class="Estilo4"><div align="center">MAY</div></td>
    <td bgcolor="#999999" class="Estilo4"><div align="center">JUN</div></td>
    <td bgcolor="#999999" class="Estilo4"><div align="center">JUL</div></td>
    <td bgcolor="#999999" class="Estilo4"><div align="center">AUG</div></td>
    <td bgcolor="#999999" class="Estilo4"><div align="center">SEP</div></td>
    <td bgcolor="#999999" class="Estilo4"><div align="center">OCT</div></td>
    <td bgcolor="#999999" class="Estilo4"><div align="center">NOV</div></td>
    <td bgcolor="#999999" class="Estilo4"><div align="center">DIC</div></td>
    </tr>
<?php
$qry_ins="select corp_instit.rdb, corp_instit.estado, institucion.nombre_instit from corp_instit, institucion where corp_instit.num_corp = ".$corporacion." and corp_instit.rdb = institucion.rdb order by nombre_instit asc";
$result_ins=@pg_Exec($conn,$qry_ins);
// echo "encontrados=".pg_numrows($result_ins);
for($i=0;$i<pg_numrows($result_ins);$i++){	
   $fila_ins = pg_fetch_array($result_ins,$i);
 $rdb = $fila_ins['rdb'];
   $establecimiento = $fila_ins['nombre_instit'];
   
  
  //busco año escolar
$sql_bus_anio="select * from ano_escolar where id_institucion=".$rdb." and nro_ano=".$cmb_ano;
$res_bus_anio=@pg_Exec($conn,$sql_bus_anio);  
for($h=0;$h<pg_numrows($res_bus_anio);$h++)
{ 
 $fila_anio = pg_fetch_array($res_bus_anio,$h); 
	$id_anio = $fila_anio['id_ano'];
	//busco cursos con ese año
	

   ?>
  <tr>
    <td class="Estilo4"><span class="Estilo11"><?php echo $establecimiento ?> </span></td>
	<?php for ($a=0;$a<=12;$a++)
	{
		
		if ($a>2){
		     //empezar a hacer calculo
			 
		
	?>
    <td >
	  <div align="center" class="Estilo11" >
	    <?php   
		
		if ($a < 10){
		    $fecha_hasta = $cmb_ano."-0".$a."-30";
		}else{
		    $fecha_hasta = $cmb_ano."-".$a."-30";
		}
		
				
		$sql_matri = "select count(*) as cantidad from matricula where id_ano='$id_anio' and bool_ar <> '1' and fecha <= '$fecha_hasta' ";
		$res_matri = @pg_Exec($conn, $sql_matri);
		$fil_matri = pg_fetch_array($res_matri,0);
		$calc_total = $fil_matri['cantidad'];		  
	    echo $calc_total;
	?>
	    </div></td>
    <?php
	 }
	}
	}
	?>
    </tr>
	<?php  }?>
	 <tr>
    <td bgcolor="#999999" class="Estilo4">Totales</td>
	<?php for ($a=0;$a<=12;$a++)
	{
		
		if ($a>2){
		
		
		
		
		//empezar a hacer calculo
		
	?>
    <td bgcolor="#999999" class="Estilo4"><div align="center"><span class="Estilo11"><?php   
		//retirados
		
		if ($a < 10){
		    $fecha_hasta = $cmb_ano."-0".$a."-30";
		}else{
		    $fecha_hasta = $cmb_ano."-".$a."-30";
		}
		
		
		   $sql_calc="select count(rut_alumno) as calc1 from matricula where id_ano in (select id_ano from ano_escolar where nro_ano = $cmb_ano and id_institucion in (select rdb from corp_instit where num_corp=$corporacion)) and fecha_retiro<".$cmb_ano."-".$a."-".$dias[$a];
			$res_calc=pg_exec($conn,$sql_calc);
				for($b=0;$b<pg_numrows($res_calc);$b++)
				{
				$fila_calc_1 = pg_fetch_array($res_calc,$b);
				 $calc_1=$fila_calc_1['calc1'];
				} 
				
				//matricula total
		$sql_calc="select count(rut_alumno) as calc2 from matricula where id_ano in (select id_ano from ano_escolar where nro_ano = $cmb_ano and id_institucion in (select rdb from corp_instit where num_corp=$corporacion))";
				$res_calc=pg_exec($conn,$sql_calc);
				for($c=0;$c<pg_numrows($res_calc);$c++)
				{
				$fila_calc_2 = pg_fetch_array($res_calc,$c);
				$calc_2=$fila_calc_2['calc2'];
				
				$total=$total+$calc_2;
				} 
				
	  $calc_total=$calc_2-$calc_1;
	echo $calc_total;
	?></span></div></td>
    <?php }
	}?>
    </tr>
</table>
												
	</td>
  </tr>
</table>
<table width="600" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr>
	<td width="50%"><div align="right"><a href="reportesCorporativos.php?op=&cmb_ano=<?=$cmb_ano ?>"><img src="images/volver.gif" width="60" height="14" border="0"></a></div></td>
	<td width="50%"><a href="print_mat_anual_corp.php?pesta=1&op=1&cmb_ano=<?=$cmb_ano ?>" target="_blank"><img src="images/imprimir_reporte.gif" width="118" height="14" border="0"  ></a></td>
  </tr>
</table>
									      

</body>
</html>
