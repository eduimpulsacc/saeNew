
<script>
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
function cerrar(){
	window.close()
}

</script> 

<?

require('../../../../../util/header.inc');
include('../../../../clases/class_Reporte.php');
include('../../../../clases/class_Membrete.php');

	$institucion	= $_INSTIT;
     $ano			= $_ANO;
	$curso			= $cmb_curso;
	$alumno 		= $cmb_alumno;
	$reporte		= $c_reporte;
	$ciclo			= $cmbCICLO;
	$ramo 			= $select_ramos;
	$_POSP = 5;
	$_bot = 9;

	$ob_reporte = new Reporte();
	$ob_membrete = new Membrete();
	
	/*******INSITUCION *******************/
	$ob_membrete ->institucion=$institucion;
	$ob_membrete ->institucion($conn);
	
		 
	/********** AÑO ESCOLAR*****************/
	$ob_membrete ->ano = $ano;
	$ob_membrete ->AnoEscolar($conn);
	$nro_ano = $ob_membrete->nro_ano;
	
	/************** CICLOS *****************/
	$ob_membrete->ciclo= $ciclo;
	$ob_membrete->Ciclo($conn);
	
	/*************** RAMO ********************/
	$ob_membrete->ramo= $ramo;
	$ob_membrete->Asignatura($conn);
	
	 $sql ="SELECT id_curso FROM ciclos WHERE id_ciclo=".$ciclo;
	$rs_curso = pg_exec($conn,$sql);
	$curso = pg_result($rs_curso,0);
	
	/***************** PERIODO *****************************/
	$sql ="SELECT id_periodo, nombre_periodo FROM periodo WHERE id_ano=".$ano." ORDER BY id_periodo ASC";
	$rs_perido = pg_exec($conn,$sql);
	
	
	//-------------------------	 CONFIGURACION DE REPORTE ------------------
	$ob_config = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=$curso;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	@$fila_config = pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);
	
	$arr_nivel=array();
	$arr_ense=array();
	$arr_prom=array();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<title>Sistema de Evaluacion Docente</title>
<STYLE>
 H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always
 }
 .titulo
 {
 font-family:<?=$ob_config->letraT;?>;
 font-size:<?=$ob_config->tamanoT;?>px;
 }
 .item
 {
 font-family:<?=$ob_config->letraI;?>;
 font-size:<?=$ob_config->tamanoI;?>px;

 }
 .subitem
 {
 font-family:<?=$ob_config->letraS;?>;
 font-size:<?=$ob_config->tamanoS;?>px;
 }
</style>

</head>

<body>
<div id="capa0">
  <table width="650" align="center">
    <tr>
      <td><input name="button4" type="button" class="botonXX" onClick="cerrar()"   value="CERRAR" /></td>
      <td align="right"><input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR" /></td>
    </tr>
  </table>
</div>
<br />
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="487"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong><? echo ucwords(strtoupper($nombre_institu));?></strong></font></td>
    <td width="11">&nbsp;</td>
    <td width="152" rowspan="4" align="center"><table width="125" border="0" cellpadding="0" cellspacing="0">
      <tr valign="top" >
        <td width="125" align="center"><?
		$result = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
		$arr=@pg_fetch_array($result,0);
		$fila_foto = @pg_fetch_array($result,0);
	    ## código para tomar la insignia

	  if($institucion!=""){
		   echo "<img src='../".$d."tmp/".$fila_foto['rdb']."insignia". "' >";
	  }else{
		   echo "<img src='../".$d."menu/imag/logo.gif' >";
	  }?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo ucwords(strtolower($ob_membrete->direccion));?></font></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1">Fono:&nbsp;<? echo ucwords(strtolower($ob_membrete->telefono));?></font></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="41">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<br />
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td class="tableindex"><div align="center">REPORTE POR CICLOS</div></td>
  </tr>

</table>
<br />
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="91"><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>A&Ntilde;O</strong></font></div></td>
    <td width="8"><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>:</strong></font></div></td>
    <td width="543"><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $nro_ano?></font></div></td>
  </tr>
  <tr>
    <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>CICLO</strong></font></div></td>
    <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>:</strong></font></div></td>
    <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><? echo strtoupper($ob_membrete->nombre_ciclo)?></font></div></td>
  </tr>
  <tr>
    <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>ASIGNATURA</strong></font></div></td>
    <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>:</strong></font></div></td>
    <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $ob_membrete->nombre_subsector;?></font></div></td>
  </tr>
</table>
<br />
<table width="650" border="1" align="center" style="border-collapse:collapse">
  <tr class="tableindex">
    <td class="item">CURSO</td>
    <? for($j=0;$j<pg_numrows($rs_perido);$j++){
			$fila_p = pg_fetch_array($rs_perido,$j);
	?>		
    <td class="item"><?=$fila_p['nombre_periodo'];?></td>
<? } ?>
    <td class="item">FINAL</td>
    <td class="item">NIVEL</td>
  </tr>
  
  <? 	$ob_reporte->nro_ano=$nro_ano;
  		$ob_reporte->ciclo=$ciclo;
		$ob_reporte->ramo=$ramo;
		$rs_result =$ob_reporte->PromedioCiclo($conn);
		
		for($xx=0;$xx<pg_numrows($rs_result);$xx++){
			$fila_cu = pg_fetch_array($rs_result,$xx);
			$prom_final=0;
			$prom_gral=0;
			$contador=0;
			
			$arr_nivel[]=$fila_cu['id_nivel'];
			$arr_ense[]=$fila_cu['ensenanza'];
			
			
			
	?>
  <tr>
    <td class="subitem">&nbsp;<?=$fila_cu['cursos'];?></td>
    <? for($x=0;$x<pg_numrows($rs_perido);$x++){
			$fila_p = pg_fetch_array($rs_perido,$x);
			$ob_reporte->nro_ano=$nro_ano;
			$ob_reporte->ciclo=$ciclo;
			$ob_reporte->ramo=$ramo;
			$ob_reporte->periodo=$fila_p['id_periodo'];
			$ob_reporte->curso=$fila_cu['id_curso'];
			$rs_promedio =$ob_reporte->PromedioCiclo($conn);
			$promedio = round(pg_result($rs_promedio,2),0);
			if($promedio > 0){
				$contador++;	
				$arr_prom[$fila_cu['id_nivel']][]=$promedio;
			}
	?>
    <td class="subitem" align="center">&nbsp;<?=$promedio;?></td>
    <? $prom_final = $prom_final + $promedio;
	} 
		$prom_gral = round($prom_final / $contador,0);
		
		$suma_ciclo = $suma_ciclo+$prom_gral;
		
	?>

    <td class="subitem" align="center">&nbsp;<?=$prom_gral;?></td>
    <td class="subitem" align="center">&nbsp;<?
		if($prom_gral>=1 && $prom_gral<=39){
			echo "INICIAL";	
		}elseif($prom_gral>=40 && $prom_gral<=49){
			echo "SUFICIENTE";
		}elseif($prom_gral>=50 && $prom_gral<=59){
			echo "INTERMEDIO";
		}elseif($prom_gral>=60 && $prom_gral<=70){
			echo "AVANZADO";
		}
	?></td>
  </tr>
  <? } ?>
</table><br>
<?php  ;
$arr_nivel=array_values(array_unique($arr_nivel));
$arr_ense=array_values(array_unique($arr_ense));
/*echo "<pre>";
var_dump($arr_prom);
echo "</pre>";*/
?>
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
<tr><td width="159" class="item">Promedio ciclo</td><td width="491" class="item">
<?php echo round($suma_ciclo/pg_numrows($rs_result),0);
 ?>
</td></tr>
<?php foreach($arr_nivel as $ar_nivel => $d_nivel){
	
	$sqln ="SELECT nombre,tipo_ense from niveles WHERE id_nivel=".$d_nivel." ";
	$rs_n = pg_exec($conn,$sqln);
	$filn= pg_fetch_array($rs_n,0);
	$p_nivel=0;
	
	foreach($arr_prom[$d_nivel] as $d_prom => $v_prom){
		$p_nivel= $p_nivel+$v_prom;
	}
	
	?>
<tr>
  <td class="item">Promedio <?php echo $filn['nombre']; ?></td><td class="item"><?php echo round($p_nivel/count($arr_prom[$d_nivel]));?></td></tr>
  <?php }?>
</table>
<br />
 <?php  
		 $ruta_timbre =4;
		 $ruta_firma =2;
		 include("firmas/firmas.php");?>
		 
<br />
<table width="650" border="0" align="center">
  <tr>
    <td><div align="left" class="item">
      <? 
	 
		echo $fecha=$ob_reporte->fecha_actual();
//		echo $ob_reporte->date;
	 ?>
    </div></td>
  </tr>
</table>
<p><br />
</p>
</body>
</html>