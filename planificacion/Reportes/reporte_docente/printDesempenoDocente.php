<?
require("../../../util/header.php");
require("../clases.php");

$ano = $cmbANO;
$docente = $cmbDOCENTE;
$institucion = $_INSTIT;
$periodo = $cmbPERIODO;


$ob_reporte = new Reporte();

$fila_membrete = $ob_reporte->Membrete($conn,$institucion);
$fila_docente = $ob_reporte->Docente($conn,$docente);
$fila_ano = $ob_reporte->Ano($conn,$ano);
$rs_dicta = $ob_reporte->Dicta2($conn,$docente,$ano);

$rs_per = $ob_reporte->Periodo($conn,$ano,$periodo);
$fil_per = pg_fetch_array($rs_per,0);
$arr_prom = array();
$ar_prom_curso=array();

?>
<!doctype html>
<html>
<head>
<meta charset="latin1">
<link href="../../../cortes/0/estilos.css" rel="stylesheet" type="text/css"> 
<title>Documento sin título</title>
</head>
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
<body>

<div id="capa0">
<table width="650" align="center">
  <tr><td>
   <input name="button4" type="button" class="botonXX" onClick="cerrar()"   value="CERRAR"></td><td align="right">
        <font size="1" face="Arial, Helvetica, sans-serif"></font>
   <input name="button3" TYPE="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR">
</td></tr>
</table>
</div>
<table width="690" border="0" align="center">
  <tr>
    <td><?php include("../cabecera/cabecera.php"); ?><br><br>
<table width="100%" border="0">
  <tr>
    <td colspan="3" class="textonegrita" align="center">REPORTE EFECTIVIDAD DOCENTE</td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td width="11%" class="textonegrita">DOCENTE</td>
    <td width="2%" class="textonegrita">:</td>
    <td width="87%" class="textosimple" align="left"><? echo $fila_docente['ape_pat']." ".$fila_docente['ape_mat']." ".$fila_docente['nombre_emp'];?></td>
  </tr>
  <tr>
    <td class="textonegrita">A&Ntilde;O</td>
    <td class="textonegrita">:</td>
    <td class="textosimple"><? echo $fila_ano['nro_ano'];?></td>
  </tr>
  <tr>
    <td class="textonegrita">PERIODO</td>
    <td class="textonegrita">:</td>
    <td class="textosimple"><?php echo $fil_per['nombre_periodo'] ?></td>
  </tr>
</table>
<br>
<br>
<table width="100%" border="0" cellpadding="5">
	<? for($i=0;$i<pg_numrows($rs_dicta);$i++){
			$fila_dicta = pg_fetch_array($rs_dicta,$i);
			
			$rs_curso = $ob_reporte->CursoDicta($conn,$ano,$docente,$fila_dicta['cod_subsector']);?>
  <tr>
    <td width="18%" class="textonegrita">&nbsp;ASIGNATURA</td>
    <td width="2%" class="textonegrita">&nbsp;:</td>
    <td width="80%" class="textosimple">&nbsp;<? echo $fila_dicta['nombre']." ".$fila_dicta['cod_subsector'];?></td>
  </tr>
  <tr>
    <td colspan="3">
    <table width="670" border="0" class="tablaredonda">
   
  <tr class="cuadro01">
    <td width="373">CURSO</td>
    <td width="82" align="center">PROMEDIO</td>
    <td width="60" align="center">MODA</td>
    <td width="73" align="center">MEDIANA</td>
    <td width="90" align="center">ESCALA</td>
  </tr>
   <? for($j=0;$j<pg_numrows($rs_curso);$j++){
			$fila_curso = pg_fetch_array($rs_curso,$j);
			if(($j % 2)==0){
				$clase="detalleoff";
			}else{
				$clase="detalleon";
			}
			
			//$rs_ramo = $ob_reporte->CursoDicta($conn,$ano,$rut,$cod_subsector);
			$rs_ramo = $ob_reporte->CursoDicta2($conn,$ano,$docente,$fila_dicta['cod_subsector'],$fila_curso['id_curso']);
			$idramo = pg_result($rs_ramo,0);
			
			/***************promedio del curso*******************/
			
			
			
			
	$pralu=0;
	$sumnalu=0;
	$contnalu=0;
	
	$fila_alu = pg_fetch_array($rs_alu,$a);
	$alumno = $fila_alu['rut_alumno'];
	
	//me traigo las los promedios
	$rs_promedio_curso = $ob_reporte-> promedioCurso($conn,$fila_ano['nro_ano'],$periodo,$idramo);
	
	for($p=0;$p<pg_numrows($rs_promedio_curso);$p++){
	$fila_promedio = pg_fetch_array($rs_promedio_curso,$p);
	$promedio = $fila_promedio['promedio'];
	
	
	$sumnalu = $sumnalu+$promedio;
	
	$ar_prom_curso[$fila_curso['id_curso']][]=$promedio;
	
	}
	
	
	
	
	
			
			
		$pr = $sumnalu/pg_numrows($rs_promedio_curso);
		
		$prx =($aprox==1)?round($pr):intval($pr);
			
		$arr_prom[$fila_dicta['cod_subsector']][]=$prx;	
		
		
	//moda del curso}
	$cuenta_cur = array_count_values($ar_prom_curso[$fila_curso['id_curso']]);
	arsort($cuenta_cur);
	$moda_cur = key($cuenta_cur);
	$arr_prom['moda'][$fila_dicta['cod_subsector']][]=$moda_cur;	
	
	
	//mediana del curso
	sort($arr_promedio[$cad[1]]);
	$arr_mediana = $ar_prom_curso[$fila_curso['id_curso']];
	$posMediana = (count($arr_mediana) + 1) / 2;
	$mediana= $arr_mediana[$posMediana - 1];
	$arr_prom['mediana'][$fila_dicta['cod_subsector']][]=$moda_cur;
	
	
	//escala del curso
	$rs_escala = $ob_reporte->rangoEscala($conn,$ano,$prx);
	$escala = strtoupper(pg_result($rs_escala,2));
			
			/***************fin promedio del curso****************/
			
	
			
			
	?>
  <tr>
    <td class="<?=$clase;?>">&nbsp;<?=CursoPalabra($fila_curso['id_curso'], 1, $conn);?></td>
    <td width="82" align="center" class="<?=$clase;?>"><div align="center"><?php echo $prx ?></div></td>
    <td width="60" align="center" class="<?=$clase;?>"><div align="center"><?php echo $moda_cur ?></div></td>
    <td width="73" align="center" class="<?=$clase;?>"><div align="center"><?php echo $mediana ?></div></td>
    <td width="90" align="center" class="<?=$clase;?>"><div align="center"><?php echo $escala ?>
    </div></td>
  </tr>
  <? } ?>
  
  <?php 
  //datos promedio
  //media
  $md = array_sum($arr_prom[$fila_dicta['cod_subsector']])/count($arr_prom[$fila_dicta['cod_subsector']]);
  
  $media = ($aprox==1)?round($md):intval($md);
  
  $rs_escalax = $ob_reporte->rangoEscala($conn,$ano,$media);
			$escalax = strtoupper(pg_result($rs_escalax,2));
			
			
			
	//moda 
	$cuenta_gen = array_count_values($arr_prom['moda'][$fila_dicta['cod_subsector']]);
	arsort($cuenta_gen);
	$moda_gen = key($cuenta_gen);
	
	//mediana
	//mediana del curso
	sort($arr_prom['mediana'][$fila_dicta['cod_subsector']]);
	$arr_mediana_gen = $arr_prom['mediana'][$fila_dicta['cod_subsector']];
	$posMediana_gen = (count($arr_mediana_gen) + 1) / 2;
	$mediana_gen= $arr_mediana[$posMediana_gen - 1];
	
	
			
  
  ?>
  <tr class="cuadro01">
    <td>TOTALES GENERALES</td>
    <td width="82" align="center"><?php echo $media ?></td>
    <td width="60" align="center"><?php echo $moda_gen ?></td>
    <td width="73" align="center"><?php echo $mediana_gen ?></td>
    <td width="90" align="center"><div align="center"><?php echo $escalax ?></div></td>
  </tr>
</table>
</td>
  </tr>

  <? } ?>
</table>


</td>
  </tr>
</table>
</body>
</html>
