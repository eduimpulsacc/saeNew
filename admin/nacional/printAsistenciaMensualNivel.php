<?

include("controlador/controlador_1.php");

$corporacion	= $_CORPORACION;
//$corporacion	= 2; 	//Usar esta corporación para pruebas si es que no existen datos en corporación
$ano			= $cmbANO;
$mes			= $cmbMES;


if($mes==02){
$nomb_mes = "FEBRERO";
}
if($mes==03){
$nomb_mes = "MARZO";
}
if($mes==04){
$nomb_mes = "ABRIL";
}
if($mes==05){
$nomb_mes = "MAYO";
}
if($mes==06){
$nomb_mes = "JUNIO";
}
if($mes==07){
$nomb_mes = "JULIO";
}
if($mes==08){
$nomb_mes = "AGOSTO";
}
if($mes==09){
$nomb_mes = "SEPTIEMBRE";
}
if($mes==10){
$nomb_mes = "OCTUBRE";
}
if($mes==11){
$nomb_mes = "NOVIEMBRE";
}
if($mes==12){
$nomb_mes = "DICIEMBRE";
}


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
      <br />	
	<? $sql="SELECT nombre FROM niveles WHERE id_nivel=".$cmbNIVEL;
									$rs_nivel=@pg_exec($conn,$sql);  ?>
								<table width="100%" border="1" cellpadding="3" cellspacing="0">
										  <tr>
											<td colspan="34"><div align="center">Total de Asistencia Mensual de todos los Establecimientos por Niveles</div></td>
										  </tr>
										  <tr>
											<td class="Estilo25">NIVEL</td>
										    <td colspan="33" class="Estilo25"><? echo @pg_result($rs_nivel,0);?></td>
									      </tr>
										  <tr>
										    <td class="Estilo25">MES</td>
										    <td colspan="33" class="Estilo25"><? echo envia_mes($cmbMES31);?></td>
								      </tr>
										  <tr>
										    <td class="Estilo25">A&Ntilde;O</td>
										    <td colspan="33" class="Estilo25"><? echo $cmbANO3;?></td>
								      </tr>
										  <tr>
											<td colspan="34">&nbsp;</td>
										  </tr>
										  <tr>
											<td rowspan="2"><span class="Estilo25">Establecimientos</span></td>
											<td rowspan="2"><span class="Estilo25">Matricula</span></td>
											<td colspan="31"><div align="center" class="Estilo25">Dias</div></td>
											<td rowspan="2"><span class="Estilo25">Total</span></td>
										  </tr>
										  <tr>
											<? for($x=1;$x<32;$x++){?>
											<td><span class="Estilo25">&nbsp;
										    <?=$x;?>
											</span></td>
											<? } ?>
										  </tr>
										  <? 	echo $sql ="SELECT a.rdb,nombre_instit,c.id_ano FROM institucion a INNER JOIN corp_instit b ON a.rdb=b.rdb INNER JOIN ano_escolar c ON  (a.rdb=c.id_institucion AND b.rdb=c.id_institucion) where  num_corp=".$corporacion."  AND nro_ano=".$cmbANO3."";
										  		$rs_instit = @pg_exec($conn,$sql)or die("fallo ".$sql);
												for($k=0;$k<@pg_numrows($rs_instit);$k++){
													$fila_inst = @pg_fetch_array($rs_instit,$k);
													
													$sql = "SELECT (count(*) + (select count(*) FROM matricula INNER JOIN curso ON matricula.id_ano=curso.id_ano AND matricula.id_curso=curso.id_curso WHERE matricula.id_ano=".$fila_inst['id_ano']." and fecha<='".$cmbMES31."-30-".$cmbANO3."' AND id_nivel=".$cmbNIVEL." and bool_ar=1 and fecha_retiro<='".$cmbMES31."-30-".$cmbANO3."')  ) as count FROM matricula INNER JOIN curso ON matricula.id_ano=curso.id_ano AND matricula.id_curso=curso.id_curso
WHERE matricula.id_ano=".$fila_inst['id_ano']." and fecha<='".$cmbMES31."-30-".$cmbANO3."' AND id_nivel=".$cmbNIVEL." and bool_ar=0";
													 $rs_mat = @pg_exec($conn,$sql);
													 $tot_mat = @pg_result($rs_mat,0);
													 $total_matricula = $total_matricula + $tot_mat;
													 
													$sql = "SELECT count(*), fecha FROM asistencia WHERE ano=".$fila_inst['id_ano']." and date_part('month',fecha)<=".$cmbMES31." AND date_part('year',fecha)=".$cmbANO3." AND id_curso in (SELECT id_curso FROM 
curso WHERE id_nivel=".$cmbNIVEL.")   GROUP BY fecha";
													$rs_asis = @pg_exec($conn,$sql);
													$total_colegio=0;
													if($tot_mat > 0){
											?>
										  		
										  <tr>
											<td><span class="Estilo26">&nbsp;
										    <?=$fila_inst['nombre_instit'];?>
											</span></td>
											<td align="right"><span class="Estilo21"><?=number_format($tot_mat,'0',',','.');?>&nbsp;</span></td>
											<? for($x=1;$x<32;$x++){
													if($x<10) $d="0".$x; else $d=$x;	
													if($cmbMES31<10) $mes="0".$cmbMES31; else $mes=$cmbMES31;
													$dia = $d."-".$mes."-".$cmbANO3;
												//$dia = $x."-".$cmbMES31."-".$cmbANO3;
												$inasis=0;
												$tot_asis=0;
												for($o=0;$o<@pg_numrows($rs_asis);$o++){
													$fila_asis = @pg_fetch_array($rs_asis,$o);
													if(Cfecha($fila_asis['fecha'])==$dia){
														$inasis = $fila_asis['count'];
														break;
													}
													
												}
												$fecha = $cmbANO3."-".$cmbMES31."-".$x;
												$fechaH = $cmbMES31."-".$x."-".$cmbANO3;
												$fecha_f = mktime(0,0,0,$cmbMES31,$dia,$cmbANO3);
												$dia_pal_f = strftime("%a",$fecha_f); 
												if(($cmbMES31=="04" || $cmbMES31=="06" || $cmbMES31=="09" || $cmbMES31=="11") and $x==31){
													$habil=0;
												}else{
													$sql ="SELECT * FROM feriado WHERE id_ano=".$cmbANO3." and (fecha_inicio<='".$fecha."' AND fecha_fin>='".$fecha."')";
													$rs_feriado = @pg_exec($conn,$sql);
													$habil = @pg_result($result,0);
												}
												if($habil==0 AND ($dia_pal_f <> "Sat" and $dia_pal_f <> "Sun" )){
													$color="bgcolor=#FFFFFF";
													$tot_asis = $tot_mat - $inasis;
													$total_colegio = $total_colegio + $tot_asis;
													$total_dia[$x] = $total_dia[$x] + $tot_asis;
												}else{
													$color="bgcolor=#999999";
													$total_asis="&nbsp;";
												}
												?>
											<td <?=$color;?>><font style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:9px"><?=$tot_asis;?>&nbsp;</font></td>
											<? } ?>
											<td><font style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:9px"><?=number_format($total_colegio,'0',',','.');?>&nbsp;</font></td>
										  </tr>
										  <? }
										  } ?>
										  <tr>
											<td><font style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:9px">Total</font></td>
											<td><div align="right"><font style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:9px">
											<?=number_format($total_matricula,'0',',','.');?>
											&nbsp;</font></div></td>
											<? for($x=1;$x<32;$x++){
												$total_gral = $total_gral + $total_dia[$x];?>
											<td><font style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:9px"><?=number_format($total_dia[$x],'0,',',','.');?>&nbsp;</font></td>
											<? } ?>
										   <td><font style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:9px"><?=number_format($total_gral,'0,',',','.');?>&nbsp;</font></td>
										  </tr>
								  </table>	
									  <BR />

								

								<br>
								<table width="200" border="0" align="center">
								  <tr>
									<td class="Estilo4"><span class="Estilo8"><a href="reportesCorporativos.php?pesta=2&opc=" ""><img src="images/volver.gif" width="60" height="14" border="0"></a></span></td>
									<td class="Estilo4"><a href="reporteAsistencia.php?opcion=2&cmbMES=<?=$cmbMES2;?>&cmbANO=<?=$cmbANO2;?>" target="_blank"><img src="images/imprimir_reporte.gif" width="118" height="14" border="0"></a></td>
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