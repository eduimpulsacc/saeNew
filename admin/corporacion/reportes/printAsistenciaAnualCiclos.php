<?

include("../controlador/controlador_1.php");


//$corporacion	= $_CORPORACION;
$corporacion	= 2; 	//Usar esta corporación para pruebas si es que no existen datos en corporación
$ano			= $cmbANO;

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
		<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" >
        <tr>
          <td class="titulo1">TOTAL DE ASISTENCIA ANUAL TODOS LOS ESTABLECIMIENTOS POR CICLOS 
           <br />
          A&Ntilde;O <?=$ano;?></td>
        </tr>
      </table>
	    <br />
      <br />
	<? 
								 $sql ="SELECT a.rdb,nombre_instit,c.id_ano FROM institucion a INNER JOIN corp_instit b ON a.rdb=b.rdb INNER JOIN ano_escolar c ON  (a.rdb=c.id_institucion AND b.rdb=c.id_institucion) where  num_corp=".$corporacion."  AND nro_ano=".$cmbANO." ORDER BY nombre_instit ASC";
									$rs_instit = @pg_exec($conn,$sql); 
									
									for($v=0;$v<pg_numrows($rs_instit);$v++){
										$fila_inst=@pg_fetch_array($rs_instit,$v);
										$sql = "SELECT id_ciclo,nomb_ciclo FROM ciclo_conf WHERE rdb=".$fila_inst['rdb']." AND id_ano=".$fila_inst['id_ano']." ORDER BY id_ciclo ASC";
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
									   <?=substr(envia_mes($i),0,3);?></td>
								   <? } ?>
								 </tr>
								 <? 
								 for($k=0;$k<@pg_numrows($rs_ciclo);$k++){
										$fila_ciclo = @pg_fetch_array($rs_ciclo,$k);
										$total_colegio=0;
										$sql = "SELECT count(*) as cuenta,date_part('month',fecha) as fecha, id_ciclo FROM asistencia INNER JOIN ciclos ON (asistencia.id_curso=ciclos.id_curso) WHERE ano=".$fila_inst['id_ano']." AND date_part('year',fecha)=".$cmbANO." group by date_part('month',fecha), id_ciclo ORDER BY id_ciclo ASC";
										$rs_asistencia = @pg_exec($conn,$sql);
										
										?>
								 <tr>
								   <td height="33" colspan="2" class="Estilo25">&nbsp;
								   <?=$fila_ciclo['id_ciclo']."--".$fila_ciclo['nomb_ciclo'];?></td>
								   <? 
								   
								   for($i=3;$i<13;$i++){
										/*echo "<br /><br />".$sql = "select count(*) as cuenta,b.id_ano from matricula a INNER JOIN ano_escolar b ON a.id_ano=b.id_ano 
						INNER JOIN curso c ON (c.id_ano=a.id_ano AND c.id_curso=a.id_curso AND c.id_ano=b.id_ano) INNER JOIN ciclos d ON
						(d.id_ano=a.id_ano AND d.id_curso=a.id_curso AND d.id_ano=b.id_ano AND d.id_ano=c.id_ano AND d.id_curso=c.id_curso) 
						WHERE nro_ano=".$cmbANO." AND d.id_ciclo=".$fila_ciclo['id_ciclo']." AND id_institucion=".$fila_inst['rdb']." AND date_part('month',fecha)<=".$i." GROUP BY b.id_ano";*/
									$sql="select count(*) as cuenta from matricula m INNER JOIN ano_escolar a ON m.id_ano=a.id_ano INNER JOIN ciclos c ON a.id_ano=c.id_ano
 AND m.id_ano=c.id_ano AND m.id_curso=c.id_curso where c.id_ciclo=".$fila_ciclo['id_ciclo']." AND  date_part('MONTH',fecha)<=".$i." and nro_ano=".$cmbANO." and id_institucion=".$fila_inst['rdb'];
						
										
										$rs_mat = @pg_exec($conn,$sql);
										$fila_cont = pg_fetch_array($rs_mat,0);
										$ano_matricula = $fila_cont['id_ano'];
										
										
										for($xx=0;$xx<pg_numrows($rs_asistencia);$xx++){
											$fila = @pg_fetch_array($rs_asistencia,$xx);
											
											
											
											if($fila['fecha']==$i && $fila['id_ciclo']==$fila_ciclo['id_ciclo']){
												$inasistencia = $fila['cuenta'];
												echo "<br/>mes:".$i."- ciclo:".$fila_ciclo['id_ciclo']."- inasist:".$inasistencia;
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
											//$cmbANO69 = $ano_matricula;
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
										$total_mes[$i] = $total_mes[$i] + $matricula;
								   } ?>
								   <td class="Estilo25"><div align="right"><?=number_format($total_colegio,'0',',','.');?>&nbsp;</div></td>
								 </tr>
								 <? } ?>
								 <tr>
								   <td colspan="2" class="Estilo1">TOTAL</td>
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
						<? }?>		
									  <BR />

								

								<br>
		
    <br />
    <br />
    <br /></td>
  </tr>
   <? 
	
	 setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
     $fechaEspañol = strftime("%A %d de %B del %Y");
	 
	?>
  <tr>
    <td valign="baseline"><HR />
       <div align="right" class="fecha"><?=$fechaEspañol?> </div></td>
  </tr>
</table>
</body>
</html>