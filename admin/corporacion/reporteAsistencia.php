<?php require('../../util/header.inc');
	

echo "corporacion ".$corporacion   =$_CORPORACION;
$ano		   = $_ANO;


?>
<script type="text/javascript">
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
</script>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<style type="text/css">
<!--
.Estilo21 {font-size: 9}
.Estilo25 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; }
.Estilo27 {
	font-size: 8px;
	font-family: Verdana, Arial, Helvetica, sans-serif;
}
-->
</style>
</head>

<body>
<div id="capa0">
  <table width="650" border="0" align="center">
    <tr>
      <td width="25%"><input type="button" name="Submit" value="CERRAR" onClick="window.close()" class="botonXX"/></td>
      <td class="textosesion"><div align="center">(*)Reporte debe imprimirse de manera horizontal</div></td>
      <td width="25%"><div align="right">
        <input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR" />
      </div></td>
    </tr>
  </table>
</div>

  <? if($opcion==1){?>
<table width="100%" border="1" cellpadding="3" cellspacing="0" align="center">
  <tr>
    <td colspan="34" class="Estilo25"><div align="center">Total de Asistencia Mensual de todos los Establecimientos </div></td>
  </tr>
  <tr>
    <td class="Estilo25">MES</td>
    <td colspan="33" class="Estilo25"><? echo envia_mes($cmbMES);?></td>
  </tr>
  <tr>
    <td class="Estilo25">A&Ntilde;O</td>
    <td colspan="33" class="Estilo25"><?=$cmbANO?></td>
  </tr>
  <tr>
    <td colspan="34">&nbsp;</td>
  </tr>
  <tr>
    <td rowspan="2" class="Estilo25"><span class="Estilo25">Establecimientos</span></td>
    <td rowspan="2" class="Estilo25"><span class="Estilo25">Matricula</span></td>
    <td colspan="31" class="Estilo25"><div align="center" class="Estilo25">Dias</div></td>
    <td rowspan="2" class="Estilo25"><span class="Estilo25">Total</span></td>
  </tr>
  <tr>
    <? for($x=1;$x<32;$x++){?>
    <td><span class="Estilo25">&nbsp;
          <?=$x;?>
    </span></td>
    <? } ?>
  </tr>
  <? 	$sql ="SELECT a.rdb,nombre_instit,c.id_ano FROM institucion a INNER JOIN corp_instit b ON a.rdb=b.rdb INNER JOIN ano_escolar c ON  (a.rdb=c.id_institucion AND b.rdb=c.id_institucion) where  num_corp=".$corporacion."  AND nro_ano=".$cmbANO."";
		$rs_instit = @pg_exec($conn,$sql);
		$total_matricula = 0;
		for($k=0;$k<@pg_numrows($rs_instit);$k++){
			$fila_inst = @pg_fetch_array($rs_instit,$k);
			 $fecha  = $cmbMES."-30-".$cmbANO;
			 $sql = "SELECT count(*) FROM matricula WHERE id_ano=".$fila_inst['id_ano']." and fecha <='".$fecha."'";
			 $rs_mat = @pg_exec($conn,$sql);
			 $tot_mat = @pg_result($rs_mat,0);
			 $total_matricula = $total_matricula + $tot_mat;
			 $sql = "SELECT count(*), fecha FROM asistencia WHERE ano=".$fila_inst['id_ano']." and date_part('month',fecha)=".$cmbMES." AND date_part('year',fecha)=".$cmbANO." GROUP BY fecha";
			$rs_asis = @pg_exec($conn,$sql);
			
											?>
  <tr>
    <td><font style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:9px">&nbsp;<?=$fila_inst['nombre_instit'];?></font></td>
    <td align="right"><font style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:9px"><?=number_format($tot_mat,'0',',','.');?>
      &nbsp;</font></td>
    <? for($x=1;$x<32;$x++){
			if($x<10) $d="0".$x; else $d=$x;
			if($cmbMES<10) $mes="0".$cmbMES; else $mes=$cmbMES;
		$dia = $d."-".$mes."-".$cmbANO;
		$dia_f = $x."-".$cmbMES."-".$cmbANO;
		$inasis=0;
		$tot_asis=0;
		for($o=0;$o<@pg_numrows($rs_asis);$o++){
			$fila_asis = @pg_fetch_array($rs_asis,$o);
			//echo "<br>fecha BD-->".impF($fila_asis['fecha'])." ---> fecha sis --->".$dia;
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
			$total_asis="&nbsp;";
		}
		
		?>
    <td <?=$color;?>><font style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:9px">&nbsp;<?=$tot_asis;?></font></td>
    <? } ?>
    <td><font style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:9px">&nbsp;<?=number_format($total_colegio,'0',',','.');?></font></td>
  </tr>
  <? } ?>
  <tr>
    <td><span class="Estilo25">Total</span></td>
    <td><div align="right"><font style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:9px"><?=number_format($total_matricula,'0',',','.');?>&nbsp;</font></div></td>
    <? for($x=1;$x<32;$x++){?>
    <td><font style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:9px">&nbsp;<?=number_format($total_dia[$x],'0',',','.');?></font></td>
    <? } ?>
    <td>&nbsp;</td>
  </tr>
</table>
<? }elseif($opcion==2){ ?>

<table width="100%" border="1" cellpadding="3" cellspacing="0" align="center">
  <tr>
    <td colspan="35" class="Estilo25"><div align="center"><font style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:9px">TOTAL MENSUAL DE ASISTENCIA DE TODOS LOS ESTABLECIMIENTOS POR CICLOS</font> </div></td>
  </tr>
  <tr>
    <td colspan="2" class="Estilo25">MES</td>
    <td colspan="33" class="Estilo25"><? echo envia_mes($cmbMES);?></td>
  </tr>
  <tr>
    <td colspan="2" class="Estilo25">A&Ntilde;O</td>
    <td colspan="33" class="Estilo25"><?=$cmbANO?></td>
  </tr>
  <tr>
    <td colspan="35">&nbsp;</td>
  </tr>
  </table>
  <br />
  <? $sql ="SELECT a.rdb,nombre_instit,c.id_ano FROM institucion a INNER JOIN corp_instit b ON a.rdb=b.rdb INNER JOIN ano_escolar c ON  (a.rdb=c.id_institucion AND b.rdb=c.id_institucion) where  num_corp=".$corporacion."  AND nro_ano=".$cmbANO."";
		$rs_instit = @pg_exec($conn,$sql);
		
		for($v=0;$v<@pg_numrows($rs_instit);$v++){
			$fila_inst = @pg_fetch_array($rs_instit,$v);
			$sql = "SELECT id_ciclo,nomb_ciclo FROM ciclo_conf WHERE rdb=".$fila_inst['rdb']." AND id_ano=".$fila_inst['id_ano'];
			$rs_ciclo = @pg_exec($conn,$sql);
	?>
  <table cellpadding="3" cellspacing="0" border="1" width="100%">
  <tr>
    <td class="Estilo25"><span class="Estilo25">Establecimientos</span></td>
    <td class="Estilo25"><font style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:9px"><?=$fila_inst['nombre_instit'];?></font></td>
    <td rowspan="2" class="Estilo25"><span class="Estilo25">Matricula</span></td>
    <td colspan="31" class="Estilo25"><div align="center" class="Estilo25">Dias</div></td>
    <td rowspan="2" class="Estilo25"><span class="Estilo25">Total</span></td>
  </tr>
  
  <tr>
    <td colspan="2" class="Estilo25">CICLOS</td>
    <? for($x=1;$x<32;$x++){?>
    <td><span class="Estilo25">&nbsp;<?=$x;?></span></td>
    <? } ?>
  </tr>
  <? 	
		$total_matricula = 0;
		for($k=0;$k<@pg_numrows($rs_ciclo);$k++){
			$fila_ciclo = @pg_fetch_array($rs_ciclo,$k);
			 $sql = "select count(*) as cuenta,b.id_ano from matricula a INNER JOIN ano_escolar b ON a.id_ano=b.id_ano 
						INNER JOIN curso c ON (c.id_ano=a.id_ano AND c.id_curso=a.id_curso AND c.id_ano=b.id_ano) INNER JOIN ciclos d ON
						(d.id_ano=a.id_ano AND d.id_curso=a.id_curso AND d.id_ano=b.id_ano AND d.id_ano=c.id_ano AND d.id_curso=c.id_curso) 
						WHERE nro_ano=".$cmbANO." AND d.id_ciclo=".$fila_ciclo['id_ciclo']." AND id_institucion=".$fila_inst['rdb']." AND date_part('month',fecha)<=".$cmbMES." GROUP BY b.id_ano  ";
			 $rs_mat = @pg_exec($conn,$sql);
			 $tot_mat = @pg_result($rs_mat,0);
			 $total_matricula = $total_matricula + $tot_mat;
			$sql = "SELECT count(*), fecha FROM asistencia WHERE ano=".$fila_inst['id_ano']." and date_part('month',fecha)=".$cmbMES." AND date_part('year',fecha)=".$cmbANO." GROUP BY fecha";
			$rs_asis = @pg_exec($conn,$sql);
			$total_colegio=0;
			
											?>
  <tr>
    <td colspan="2"><font style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:9px"><span class="Estilo25">
      <?=$fila_ciclo['nomb_ciclo'];?>
    </span></font></td>
    <td align="right"><font style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:9px"><?=number_format($tot_mat,'0',',','.');?>
      &nbsp;</font></td>
    <? for($x=1;$x<32;$x++){
		$dia = $x."-".$cmbMES."-".$cmbANO;
		$inasis=0;
		$tot_asis=0;
		for($o=0;$o<@pg_numrows($rs_asis);$o++){
			$fila_asis = @pg_fetch_array($rs_asis,$o);
			if($fila_asis['fecha']==$dia){
				$inasis = $fila_asis['count'];
				break;
			}
		}
		$fecha = $cmbANO."-".$cmbMES."-".$x;
		$fechaH = $cmbMES."-".$x."-".$cmbANO;
		$fecha_f = mktime(0,0,0,$cmbMES,$dia,$cmbANO);
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
			$total_dia[$v][$x] = $total_dia[$v][$x] + $tot_asis;
		}else{
			$color="bgcolor=#999999";
			$total_asis="&nbsp;";
		}
		
		?>
    <td <?=$color;?>><font style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:9px">&nbsp;<?=$tot_asis;?></font></td>
    <? } ?>
    <td><font style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:9px">&nbsp;<?=number_format($total_colegio,'0',',','.');?></font></td>
  </tr>
  <? } ?>
  <tr>
    <td colspan="2"><span class="Estilo25">Total</span></td>
    <td><div align="right"><font style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:9px">&nbsp;<?=number_format($total_matricula,'0',',','.');?></font></div></td>
    <? for($x=1;$x<32;$x++){
		$total_gral = $total_gral + $total_dia[$v][$x];
	?>
    <td><font style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:9px"><?=number_format($total_dia[$v][$x],'0',',','.');?>&nbsp;</font></td>
    <? } ?>
    <td><font style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:9px"><?=number_format($total_gral,'0',',','.');?>&nbsp;</font></td>
  </tr>
</table>

<? }   
}elseif($opcion==3){
   	$sql="SELECT nombre FROM niveles WHERE id_nivel=".$cmbNIVEL;
   	$rs_nivel=@pg_exec($conn,$sql);  ?>
   <table width="100%" border="1" cellpadding="3" cellspacing="0">
	  <tr>
		<td colspan="34"><div align="center"><font style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:9px">TOTAL MENSUAL DE ASISTENCIA DE TODOS LOS ESTABLECIMIENTOS POR NIVELES</font></div></td>
	  </tr>
	  <tr>
		<td><font style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:9px">NIVEL</font></td>
		<td colspan="33"><font style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:9px"><? echo @pg_result($rs_nivel,0);?></font></td>
	  </tr>
	  <tr>
		<td><font style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:9px">MES</font></td>
		<td colspan="33"><font style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:9px"><? echo envia_mes($cmbMES);?></font></td>
  </tr>
	  <tr>
		<td><font style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:9px">A&Ntilde;O</font></td>
		<td colspan="33"><font style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:9px"><? echo $cmbANO;?></font></td>
  </tr>
	  <tr>
		<td colspan="34">&nbsp;</td>
	  </tr>
	  <tr>
		<td rowspan="2"><font style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:9px">Establecimientos</font></td>
		<td rowspan="2"><font style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:9px">Matricula</font></td>
		<td colspan="31"><div align="center"><font style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:9px">Dias</font></div></td>
		<td rowspan="2"><font style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:9px">Total</font></td>
	  </tr>
	  <tr>
		<? for($x=1;$x<32;$x++){?>
		<td><font style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:9px">&nbsp;<?=$x;?></font></td>
		<? } ?>
	  </tr>
	  <? 	$sql ="SELECT a.rdb,nombre_instit,c.id_ano FROM institucion a INNER JOIN corp_instit b ON a.rdb=b.rdb INNER JOIN ano_escolar c ON  (a.rdb=c.id_institucion AND b.rdb=c.id_institucion) where  num_corp=".$corporacion."  AND nro_ano=".$cmbANO."";
			$rs_instit = @pg_exec($conn,$sql);
			$total_matricula = 0;
			for($k=0;$k<@pg_numrows($rs_instit);$k++){
				$fila_inst = @pg_fetch_array($rs_instit,$k);
				 echo "matricula ".$sql = "SELECT count(*) FROM matricula INNER JOIN curso ON matricula.id_ano=curso.id_ano AND matricula.id_curso=curso.id_curso WHERE matricula.id_ano=".$fila_inst['id_ano']." and date_part('month',fecha)<=".$cmbMES." AND id_nivel=".$cmbNIVEL." AND bool_ar=0";
				 $rs_mat = @pg_exec($conn,$sql);
				 $tot_mat = @pg_result($rs_mat,0);
				 $total_matricula = $total_matricula + $tot_mat;
				 echo "<br> asistencia ".$sql = "SELECT count(*), fecha FROM asistencia WHERE ano=".$fila_inst['id_ano']." and date_part('month',fecha)=".$cmbMES." AND date_part('year',fecha)=".$cmbANO." AND id_curso in (SELECT id_curso FROM 
curso WHERE id_nivel=".$cmbNIVEL.")  GROUP BY fecha";
				$rs_asis = @pg_exec($conn,$sql);
				$total_colegio=0;
		?>
			
	  <tr>
		<td><font style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:9px">&nbsp;<?=$fila_inst['nombre_instit'];?></font></td>
		<td align="right"><font style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:9px"><?=number_format($tot_mat,'0',',','.');?>&nbsp;</font></td>
		<? for($x=1;$x<32;$x++){
				if($x<10) $d="0".$x; else $d=$x;	
				if($cmbMES<10) $mes="0".$cmbMES; else $mes=$cmbMES;
				$dia = $d."-".$mes."-".$cmbANO;
//			$dia = $x."-".$cmbMES."-".$cmbANO;
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
			$fecha_f = mktime(0,0,0,$cmbMES,$dia,$cmbANO);
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
				$total_asis="&nbsp;";
			}
			?>
		<td <?=$color;?>><font style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:9px"><?=$tot_asis;?>&nbsp;</font></td>
		<? } ?>
		<td><font style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:9px"><?=number_format($total_colegio,'0',',','.');?>&nbsp;</font></td>
	  </tr>
	  <? } ?>
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
									
   <? }elseif($opcion==4){?>
   <table width="100%" border="1" cellpadding="3" cellspacing="0">
	 <tr>
	   <td colspan="12" class="Estilo25"><div align="center"><strong>Total de Asistencia Anual de Todos los Establecimientos </strong></div></td>
	 </tr>
	 <tr>
	   <td class="Estilo1">A&Ntilde;O</td>
	   <td colspan="11" class="Estilo25">&nbsp;<?=$cmbANO;?></td>
     </tr>
	 <tr>
	   <td colspan="12" class="Estilo25">&nbsp;</td>
     </tr>
	 <tr>
	   <td rowspan="2" class="Estilo1">ESTABLECIMIENTOS</td>
	   <td colspan="10" class="Estilo25"><div align="center"><strong>MESES</strong></div></td>
	   <td rowspan="2" class="Estilo25"><div align="center"><strong>TOTAL</strong></div></td>
	 </tr>
	 <? $sql ="SELECT a.rdb,nombre_instit,c.id_ano FROM institucion a INNER JOIN corp_instit b ON a.rdb=b.rdb INNER JOIN ano_escolar c ON  (a.rdb=c.id_institucion AND b.rdb=c.id_institucion) where  num_corp=".$corporacion."  AND nro_ano=".$cmbANO." ORDER BY nombre_instit ASC";
		$rs_instit = @pg_exec($conn,$sql); 
		
		
		?>
		
	 <tr>
	   <? for($i=3;$i<13;$i++){?>
	   <td class="Estilo25">&nbsp;
		   <?=substr(envia_mes($i),0,6);?></td>
	   <? } ?>
	 </tr>
	 <? for($k=0;$k<@pg_numrows($rs_instit);$k++){
			$fila_inst = @pg_fetch_array($rs_instit,$k);
			$total_colegio=0;

			?>
	 <tr>
	   <td class="Estilo25"><?=$fila_inst['nombre_instit'];?></td>
	   <? for($i=3;$i<13;$i++){
			$sql = "select count(*) as cuenta,id_institucion from matricula a INNER JOIN ano_escolar b ON a.id_ano=b.id_ano WHERE nro_ano=".$cmbANO." AND id_institucion=".$fila_inst['rdb']." AND date_part('month',fecha)<=".$i." group by id_institucion ";
			$rs_mat = @pg_exec($conn,$sql);
			
			
			
			?>
	   <td class="Estilo25"><div align="right"><?=number_format(pg_result($rs_mat,0),'0',',','.');?>&nbsp;</div></td>
	   <? 	$total_colegio = $total_colegio + pg_result($rs_mat,0);
			$total_mes[$i] = $total_mes[$i] + pg_result($rs_mat,0);
	   } ?>
	   <td class="Estilo25"><div align="right"><?=number_format($total_colegio,'0',',','.');?>&nbsp;</div></td>
	 </tr>
	 <? } ?>
	 <tr>
	   <td class="Estilo1">TOTAL</td>
	   <? for($i=3;$i<13;$i++){?>
	   <td class="Estilo25"><div align="right">
         <?=number_format($total_mes[$i],'0',',','.');?>
       &nbsp;</div></td>
	   <? $total_gral = $total_gral + $total_mes[$i];
	   } ?>
	   <td class="Estilo25"><div align="right">
         <?=number_format($total_gral,'0',',','.');?>
       &nbsp;</div></td>
	 </tr>
   </table>
 <?	  }elseif($opcion==5){ ?>
		<table width="100%" border="1" cellpadding="3" cellspacing="0">
		 <tr>
		   <td colspan="13" class="Estilo25"><div align="center"><strong>TOTAL DE ASISTENCIA ANUAL TODOS LOS ESTABLECIMIENTOS POR CICLOS </strong></div></td>
		 </tr>
		 <tr>
		   <td colspan="2" class="Estilo1">A&Ntilde;O</td>
		   <td colspan="11" class="Estilo25">&nbsp;<?=$cmbANO;?></td>
	      </tr>
		 <tr>
		   <td colspan="13" class="Estilo25">&nbsp;</td>
	      </tr>
</table>
		   <? 
		 $sql ="SELECT a.rdb,nombre_instit,c.id_ano FROM institucion a INNER JOIN corp_instit b ON a.rdb=b.rdb INNER JOIN ano_escolar c ON  (a.rdb=c.id_institucion AND b.rdb=c.id_institucion) where  num_corp=".$corporacion."  AND nro_ano=".$cmbANO." ORDER BY nombre_instit ASC";
			$rs_instit = @pg_exec($conn,$sql); 
			
			for($v=0;$v<pg_numrows($rs_instit);$v++){
				$fila_inst=@pg_fetch_array($rs_instit,$v);
				$sql = "SELECT id_ciclo,nomb_ciclo FROM ciclo_conf WHERE rdb=".$fila_inst['rdb']." AND id_ano=".$fila_inst['id_ano'];
				$rs_ciclo = @pg_exec($conn,$sql);
				$total_gral=0;
			?>
		  
		  <br />
		   <table width="100%" border="1" align="center" cellpadding="3" cellspacing="0">
		 <tr>
		   <td rowspan="2" class="Estilo1">ESTABLECIMIENTO</td>
		   <td rowspan="2" class="Estilo1"><span class="Estilo25">
		     <?=$fila_inst['nombre_instit'];?>
		   </span></td>
		   <td colspan="10" class="Estilo25">&nbsp;</td>
		   <td rowspan="3" class="Estilo25"><div align="center"><strong>TOTAL</strong></div></td>
		   </tr>
		 <tr>
		   <td colspan="10" class="Estilo25"><div align="center"><strong>MESES</strong></div></td>
		   </tr>
		
			
		 <tr>
		   <td colspan="2" class="Estilo1">CICLOS</td>
		   <? for($i=3;$i<13;$i++){?>
		   <td class="Estilo25">&nbsp;
			   <?=substr(envia_mes($i),0,6);?></td>
		   <? } ?>
		 </tr>
		 <? 
		 for($k=0;$k<@pg_numrows($rs_ciclo);$k++){
				$fila_ciclo = @pg_fetch_array($rs_ciclo,$k);
				$total_colegio=0;
				$sql="SELECT count(*) as cuenta,date_part('month',fecha) as fecha FROM asistencia a INNER JOIN ciclos b ON a.ano=b.id_ano AND a.id_curso=b.id_curso
WHERE ano=".$fila_inst['id_ano']." AND date_part('year',fecha)=".$cmbANO." AND id_ciclo=".$fila_ciclo['id_ciclo']." group by date_part('month',fecha) ";
				$rs_asistencia = @pg_exec($conn,$sql);
				?>
		 <tr>
		   <td height="33" colspan="2" class="Estilo25">&nbsp;
	       <?=$fila_ciclo['id_ciclo']."--".$fila_ciclo['nomb_ciclo'];?></td>
		   <? 
		   
		   for($i=3;$i<13;$i++){
		   		$sql = "SELECT count(a.*) as cuenta FROM matricula a INNER JOIN ano_escolar b ON a.id_ano=b.id_ano INNER JOIN curso c ON a.id_ano=c.id_ano AND a.id_curso=c.id_curso  AND b.id_ano=c.id_ano INNER JOIN ciclos d ON d.id_ano=a.id_ano AND d.id_curso=a.id_curso AND d.id_ano=b.id_ano AND d.id_ano=c.id_ano AND 
 d.id_curso=c.id_curso WHERE b.id_institucion=".$fila_inst['rdb']." AND b.nro_ano=".$cmbANO." AND date_part('month',fecha)<=".$i." AND bool_ar=0 AND id_ciclo=".$fila_ciclo['id_ciclo']." ";
 		
				$rs_mat = @pg_exec($conn,$sql);
				$fila_cont = pg_fetch_array($rs_mat,0);
				$ano_matricula = $fila_cont['id_ano'];
				
				$inasistencia=0;
				
				for($xx=0;$xx<pg_numrows($rs_asistencia);$xx++){
					$fila = @pg_fetch_array($rs_asistencia,$xx);
					if($fila['fecha']==$i){
						$inasistencia = $fila['cuenta'];
						break;
					}
				}

				if($i<10){
					$mes="0".$i;
				}else{
					$mes=$i;
				}
				$dia_termino =dia_mes($mes,$cmbANO);
				$dia_fin = $mes."-".$dia_termino."-".$cmbANO;
				$dia_inicio = "01-".$mes."-".$cmbANO;
				$total_habiles=0;
				for($c=1;$c<=$dia_termino;$c++){
					if($c<10){
						$dia="0".$c;
					}else{
						$dia=$c;
					}
					$fecha = $cmbANO."-".$mes."-".$dia;
					$fechaH = $mes."-".$dia."-".$cmbANO;
					$fecha_f = mktime(0,0,0,$mes,$dia,$cmbANO);
					$dia_pal_f = strftime("%a",$fecha_f); 
					$cmbANO69 = $ano_matricula;
					if(($mes=="04" || $mes=="06" || $mes=="09" || $mes=="11") and $dia==31){
						$habil=0;
					}else{
						$sql ="SELECT * FROM feriado WHERE id_ano=".$fila_inst['rdb']." and (fecha_inicio<='".$fecha."' AND fecha_fin>='".$fecha."')";
						$rs_feriado = @pg_exec($conn,$sql);
						$habil = @pg_result($result,0);
					}
					if($habil==0 AND ($dia_pal_f <> "Sat" and $dia_pal_f <> "Sun" )){
						$total_habiles++;
					}
					
					
				}
				
				$matricula = (pg_result($rs_mat,0) * $total_habiles) - $inasistencia;
				
				?>
		   <td class="Estilo25"><div align="right"><?=number_format($matricula,'0',',','.');?>&nbsp;</div></td>
		   <? 	$total_colegio = $total_colegio + $matricula;
				$total_mes[$v][$i] = $total_mes[$v][$i] + $matricula;
		   } ?>
		   <td class="Estilo25"><div align="right"><?=number_format($total_colegio,'0',',','.');?>&nbsp;</div></td>
		 </tr>
		 <? } ?>
		 <tr>
		   <td colspan="2" class="Estilo1">TOTAL</td>
		   <? for($i=3;$i<13;$i++){?>
		   <td class="Estilo25"><div align="right">
	         <?=number_format($total_mes[$v][$i],'0',',','.');?>
           &nbsp;</div></td>
		   <? $total_gral = $total_gral + $total_mes[$v][$i];
		   } ?>
		   <td class="Estilo25"><div align="right">
	         <?=number_format($total_gral,'0',',','.');?>
           &nbsp;</div></td>
		 </tr>
</table>
<? } ?>

<?   }elseif($opcion==6){
	   $sql="SELECT nombre FROM niveles WHERE id_nivel=".$cmbNIVEL;
	   $rs_nivel=@pg_exec($conn,$sql);
?>
   <table width="100%" border="1" cellpadding="3" cellspacing="0">
	 <tr>
	   <td colspan="12" class="Estilo25"><div align="center"><strong>Total de Asistencia Anual de Todos los Establecimientos por Niveles </strong></div></td>
	 </tr>
	 <tr>
	   <td class="Estilo25">A&Ntilde;O</td>
	   <td colspan="11" class="Estilo25">&nbsp;<?=$cmbANO;?></td>
	   </tr>
	 <tr>
	   <td class="Estilo25">NIVEL</td>
	   <td colspan="11" class="Estilo25">&nbsp;<?=pg_result($rs_nivel,0);?></td>
	 </tr>
	 <tr>
	   <td colspan="12" class="Estilo25">&nbsp;</td>
	   </tr>
	 <tr>
	   <td rowspan="2" class="Estilo25">ESTABLECIMIENTOS</td>
	   <td colspan="10" class="Estilo25"><div align="center"><strong>MESES</strong></div></td>
	   <td rowspan="2" class="Estilo25"><div align="center"><strong>TOTAL</strong></div></td>
	 </tr>
	 <? 
	 $sql ="SELECT a.rdb,nombre_instit,c.id_ano FROM institucion a INNER JOIN corp_instit b ON a.rdb=b.rdb INNER JOIN ano_escolar c ON  (a.rdb=c.id_institucion AND b.rdb=c.id_institucion) where  num_corp=".$corporacion."  AND nro_ano=".$cmbANO." ORDER BY nombre_instit ASC";
		$rs_instit = @pg_exec($conn,$sql); 
		
		
		?>
		
	 <tr>
	   <? for($i=3;$i<13;$i++){?>
	   <td class="Estilo25">&nbsp;
		   <?=substr(envia_mes($i),0,6);?></td>
	   <? } ?>
	 </tr>
	 <? 
	 for($k=0;$k<@pg_numrows($rs_instit);$k++){
			$fila_inst = @pg_fetch_array($rs_instit,$k);
			$total_colegio=0;
			$matricula=0;
			$inasistencia=0;
			$fin_semana=0;
			$feriado=0;
			$total_mes=0;
			$dia_mes=0;
			?>
	 <tr>
	   <td class="Estilo25"><?=$fila_inst['nombre_instit'];?></td>
	   <? 
	   for($i=3;$i<13;$i++){
			$sql = "select count(*) from asistencia WHERE ano=".$fila_inst['id_ano']." AND date_part('month',fecha)=".$i." AND id_curso in (SELECT id_curso FROM curso WHERE id_nivel=".$cmbNIVEL2.")";										
			$rs_asistencia = @pg_exec($conn,$sql);
			$inasistencia = @pg_result($rs_asistencia,0);
			
			$sql = "select count(*) as cuenta,b.id_ano from matricula a INNER JOIN ano_escolar b ON a.id_ano=b.id_ano INNER JOIN curso c ON c.id_ano=a.id_ano AND c.id_curso=a.id_curso AND c.id_ano=b.id_ano WHERE a.id_ano=".$fila_inst['id_ano']." AND id_institucion=".$fila_inst['rdb']." AND fecha<='".$i."-30-".$cmbANO."' AND c.id_nivel=".$cmbNIVEL." GROUP BY b.id_ano ";
			if($fila_inst['rdb']==1522){
				echo "<br>".$sql;
			}
			$rs_mat = @pg_exec($conn,$sql);
			$fila_cont = pg_fetch_array($rs_mat,0);
			$ano_matricula = $fila_cont['id_ano'];
			
			//---------------FERIADO ---------------
			$sql = "select sum((fecha_fin - fecha_inicio) + 1) as feriado from feriado where id_ano=".$fila_inst['id_ano']." and date_part('month',fecha_inicio)=".$i;
			$rs_feriado = @pg_exec($conn,$sql);
			$feriado = @pg_result($rs_feriado,0);
			$fin_semana=0;
			if($i==3 || $i==5 || $i==7 || $i==8 || $i==10 || $i==12){
				$dia_mes =31;
				for($l=1;$l<=$dia_mes;$l++){
					$fecha_semana = mktime(0,0,0,$i,$l,$cmbANO); 
					$dia_semana = strftime("%a",$fecha_semana);
					if($dia_semana=="Sat" || $dia_semana=="Sun"){
						$fin_semana++;
					}
				}
				$total_mes=($dia_mes - $feriado) - $fin_semana;
				echo "<br> mes-->".$i."  feriado-->".$feriado."  fin de semana -->".$fin_semana."  habiles-->".$total_mes."  matricula-->".pg_result($rs_mat,0);
			}else{
				$dia_mes =30;
				for($l=1;$l<=$dia_mes;$l++){
					$fecha_semana = mktime(0,0,0,$i,$l,$cmbANO); 
					$dia_semana = strftime("%a",$fecha_semana);
					if($dia_semana=="Sat" || $dia_semana=="Sun"){
						$fin_semana++;
					}
				}
				$total_mes = ($dia_mes - $feriado) - $fin_semana;
				echo "<br> mes-->".$i."  feriado-->".$feriado."  fin de semana -->".$fin_semana."  habiles-->".$total_mes."  matricula-->".pg_result($rs_mat,0);
			}
			
			$total_habiles=$total_mes;
			//$inasistencia=0;
			$matricula = (pg_result($rs_mat,0) * $total_habiles) - $inasistencia;
			
			?>
	   <td class="Estilo25"><div align="right"><?=number_format($matricula,'0',',','.');?>&nbsp;</div></td>
	   <? 	$total_colegio = $total_colegio + $matricula;
			$total_mes[$i] = $total_mes[$i] + $matricula;
	   } ?>
	   <td class="Estilo25"><div align="right"><?=number_format($total_colegio,'0',',','.');?>&nbsp;</div></td>
	 </tr>
	 <? } ?>
	 <tr>
	   <td class="Estilo25">TOTAL</td>
	   <? for($i=3;$i<13;$i++){?>
	   <td class="Estilo25"><?=number_format($total_mes[$i],'0',',','.');?>&nbsp;</td>
	   <? $total_gral = $total_gral + $total_mes[$i];
	   } ?>
	   <td class="Estilo25"><?=number_format($total_gral,'0',',','.');?>&nbsp;</td>
	 </tr>
   </table>
  <?  }
 ?>
</body>
</html>
