<?

include("../controlador/controlador_1.php");


$corporacion	= $_CORPORACION;
//$corporacion	= 2; 	//Usar esta corporaci�n para pruebas si es que no existen datos en corporaci�n
 $ano			= $cmbANO;
$mes			= $cmbMES;

if($mes==2){
$nomb_mes = "FEBRERO";
}
if($mes==3){
$nomb_mes = "MARZO";
}
if($mes==4){
$nomb_mes = "ABRIL";
}
if($mes==5){
$nomb_mes = "MAYO";
}
if($mes==6){
$nomb_mes = "JUNIO";
}
if($mes==7){
$nomb_mes = "JULIO";
}
if($mes==8){
$nomb_mes = "AGOSTO";
}
if($mes==9){
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
      <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" >
        <tr>
          <td class="titulo1">TOTAL ASISTENCIA MENSUAL <?=$nomb_mes;?> DE TODOS LOS ESTABLECIMIENTOS<br />
          A&Ntilde;O <?=$ano;?></td>
        </tr>
      </table>
    <br />	

	<table width="100%" border="1" cellpadding="3" cellspacing="0">
											<tr>
											  <td rowspan="2" class="celdas1">RDB</td>
											  <td rowspan="2" class="celdas1">Establecimientos</td>
											<td rowspan="2" class="celdas1">Matricula</td>
											<td colspan="31" class="celdas1">Dias</td>
											<td rowspan="2" class="celdas1">Total</td>
										  </tr>
										  <tr>
											<? for($x=1;$x<32;$x++){?>
											<td class="celdas1">&nbsp;<?=$x;?></td>
											<? } ?>
										  </tr>
										  <? 	$sql ="SELECT a.rdb,nombre_instit,c.id_ano FROM institucion a INNER JOIN corp_instit b ON a.rdb=b.rdb INNER JOIN ano_escolar c ON  (a.rdb=c.id_institucion AND b.rdb=c.id_institucion) where  num_corp=".$corporacion."  AND nro_ano=".$cmbANO."";
										  		$rs_instit = @pg_exec($conn,$sql);
												for($k=0;$k<@pg_numrows($rs_instit);$k++){
													$fila_inst = @pg_fetch_array($rs_instit,$k);
													 $fecha  = $cmbMES."-30-".$cmbANO;
													$sql = "SELECT count(*) FROM matricula WHERE id_ano=".$fila_inst['id_ano']." and fecha <='".$fecha."'";
													 $rs_mat = @pg_exec($conn,$sql);
													 $tot_mat = @pg_result($rs_mat,0);
													 
												 $sql = "SELECT count(*), fecha FROM asistencia WHERE ano=".$fila_inst['id_ano']." and date_part('month',fecha)=".$cmbMES." AND date_part('year',fecha)=".$cmbANO." GROUP BY fecha";
													$rs_asis = @pg_exec($conn,$sql);
													
											?>
										  		
										  <tr>
										    <td class="text2">&nbsp;
										      <div align="center">
										        <?=$fila_inst['rdb'];?>
								            </div></td>
											<td class="text2">&nbsp;
											  <div align="center">
											    <?=$fila_inst['nombre_instit'];?>
									        </div></td>
											<td align="right" class="text2"><div align="center">
										      <?=number_format($tot_mat,'0',',','.');?>
									        &nbsp;</div></td>
											<? for($x=1;$x<32;$x++){
												if($x<10) $d="0".$x; else $d=$x;
												if($cmbMES<10) $mes="0".$cmbMES; else $mes=$cmbMES;
												$dia = $d."-".$mes."-".$cmbANO;
												$dia_f=$x."-".$cmbMES."-".$cmbANO;
	
												$inasis=0;
												$tot_asis=0;
												for($o=0;$o<@pg_numrows($rs_asis);$o++){
													$fila_asis = @pg_fetch_array($rs_asis,$o);
													if(Cfecha($fila_asis['fecha'])==$dia){
														 $inasis = $fila_asis['count'];
														break;
													}
													
													
												}											
												$fecha = $cmbANO."-".$cmbMES."-".$x;
												$fechaH = $cmbMES."-".$x."-".$cmbANO;
												$fecha_f = mktime(0,0,0,$cmbMES,$dia_f,$cmbANO);
												$dia_pal_f = strftime("%a",$fecha_f); 
												if(($cmbMES=="04" || $cmbMES=="06" || $cmbMES=="09" || $cmbMES=="11") and $x==31){
													$habil=0;
												}else{
													$sql ="SELECT * FROM feriado WHERE id_ano=".$cmbANO." and (fecha_inicio<='".$fecha."' AND fecha_fin>='".$fecha."')";
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
													$total_asis=" ";
												}
												
												?>
    										<td <?=$color;?> class="text2">&nbsp;
    										  <div align="center">
    										    <?=$tot_asis;?>
   										    </font></div></td>
											<? } ?>
											<td class="text2">&nbsp;
											  <div align="center">
											    <?=number_format($total_colegio,'0',',','.');?>
									        </div></td>
										  </tr>
										  <? } ?>
										  <tr>
										    <td class="celdas1">&nbsp;</td>
											<td class="celdas1">Total</td>
											<td class="celdas1">&nbsp;</td>
											<? for($x=1;$x<32;$x++){?>
											<td class="celdas1">&nbsp;<?=number_format($total_dia[$x],'0',',','.');?></td>
											<? } ?>
										   <td class="celdas1">&nbsp;</td>
										  </tr>
									</table>	
    <br />
    <br />
    <br /></td>
  </tr>
  
  <tr>
    <? 
	
	 setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
     $fechaEspa�ol = strftime("%A %d de %B del %Y");
	 
	?>
    <td valign="baseline"><HR />
       <div align="right" class="fecha"> <?=$fechaEspa�ol?> </div></td>
  </tr>
</table>
</body>
</html>