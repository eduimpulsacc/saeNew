<?
require('../../../../util/header.inc');
require('../../../../util/LlenarCombo.php3');
require('../../../../util/SeleccionaCombo.inc');
include('../../../clases/class_MotorBusqueda.php');
include('../../../clases/class_Membrete.php');
include('../../../clases/class_Reporte.php');


	//setlocale("LC_ALL","es_ES");
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$tipo_ensenanza =$tipo_ensenanza;
	$reporte		=$c_reporte;
	$_POSP = 4;
	$_bot = 8;

	$ob_reporte = new Reporte();
	
	//----------------------------------------------------------------------------
	// DATOS INSTITUCION
	//----------------------------------------------------------------------------		
	$ob_membrete = new Membrete();
	$ob_membrete->institucion=$institucion;
	$ob_membrete->institucion($conn);

	/*************ANO ESCOLAR *********************/
	$ob_reporte ->ano =$ano;
	$ob_reporte ->AnoEscolar($conn);
	$nro_ano = $ob_reporte->nro_ano;
	
	/************* CONFIGURACION REPORTE ********************/
	$ob_config = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=1;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);

		

if($cb_ok!="Buscar"){
	$xls=1;
}
	 
if($xls==1){	 
$fecha_actual = date('d/m/Y-H:i:s');
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition:inline; filename=Informe_becas_$fecha_actual.xls"); 	 
}	 

?>
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


function exportar(form){
		  form.target="_blank";
		  form.action='printInformeBecas_C.php?tipo_ensenanza=<?=$tipo_ensenanza?>&xls=1';
		  form.submit(true);
		  }
</script>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
</head>
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
<body>
<div id="capa0">
<form name="form" method="post" action="printInformeBecas_C.php" target="_blank">
<table width="100%">
  <tr>
    <td><input name="button4" type="button" class="botonXX" onClick="cerrar()"   value="CERRAR" /></td>
    <td align="right"><input name="button3" type="button" class="botonXX"  value="IMPRIMIR" onClick="javascript:imprimir()" />
	 <? if($_PERFIL==0){?>		  
		<input name="cb_exp" type="button" onClick="exportar(this.form)" class="botonXX"  id="cb_exp" value="EXPORTAR">
	<? }?>
	
	</td>
  </tr>
</table>
</div>
<br />
<br />
<table width="600" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="119" rowspan="6"><div align="center"><? echo "<img src='".$d."tmp/".$institucion."insignia". "' >";	?></div></td>
    <td width="404"><font face="Verdana, Arial, Helvetica, sans-seri" size="1"><strong>
      <?=$ob_membrete->ins_pal;?>
    </strong></font></td>
  </tr>
  <tr>
    <td><font face="Verdana, Arial, Helvetica, sans-seri" size="1"><strong>
      <?=$ob_membrete->direccion;?>
    </strong></font></td>
  </tr>
  <tr>
    <td><font face="Verdana, Arial, Helvetica, sans-seri" size="1"><strong>
      <?=$ob_membrete->telefono;?>
    </strong></font></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<br />
<table width="100%" border="1" cellpadding="0" cellspacing="0">
  <tr>
    <td rowspan="2" bgcolor="#999999" class="item"><div align="center"><strong>CURSO</strong></div></td>
    <td colspan="3" bgcolor="#999999" class="item"><div align="center"><strong>ALIMENTO<br />
    .JUNAEB.</strong></div></td>
    <td colspan="3" bgcolor="#999999" class="item"><div align="center"><strong>SEGURO</strong></div></td>
    <td colspan="3" bgcolor="#999999" class="item"><div align="center"><strong>CHILE<br />
    SOLIDARIO.</strong></div></td>
    <td colspan="3" bgcolor="#999999" class="item"><div align="center"><strong>ALUMNO<br />
    PRIORITARIO</strong></div></td>
    <td colspan="3" bgcolor="#999999" class="item"><div align="center"><strong>BECA.<br />
    HPV</strong></div></td>
    <td colspan="3" bgcolor="#999999" class="item"><div align="center"><strong>BECA<br />
    PIE</strong></div></td>
    <td colspan="3" bgcolor="#999999" class="item"><div align="center"><strong>CENTRO<br />
    PADRE</strong></div></td>
    <td colspan="3" bgcolor="#999999" class="item"><div align="center"><strong>OTRAS</strong></div></td>
    <td colspan="3" bgcolor="#999999" class="item"><div align="center"><strong>MUNICIPAL.</strong></div></td>
    <td colspan="3" bgcolor="#999999" class="item"><div align="center"><strong>BECA<br />
    CEDAE</strong></div></td>
    <td colspan="3" bgcolor="#999999" class="item"><div align="center"><strong>BECA<br />
    PUENTE</strong></div></td>
    <td colspan="3" bgcolor="#999999" class="item"><div align="center"><strong>BECA<br />
    SEP</strong></div></td>
  </tr>
  <tr>
    <td bgcolor="#999999" class="item"><div align="center"><strong>M</strong></div></td>
    <td bgcolor="#999999" class="item"><div align="center"><strong>F</strong></div></td>
    <td bgcolor="#999999" class="item"><div align="center"><strong>T</strong></div></td>
    <td bgcolor="#999999" class="item"><div align="center"><strong>M</strong></div></td>
    <td bgcolor="#999999" class="item"><div align="center"><strong>F</strong></div></td>
    <td bgcolor="#999999" class="item"><div align="center"><strong>T</strong></div></td>
    <td bgcolor="#999999" class="item"><div align="center"><strong>M</strong></div></td>
    <td bgcolor="#999999" class="item"><div align="center"><strong>F</strong></div></td>
    <td bgcolor="#999999" class="item"><div align="center"><strong>T</strong></div></td>
    <td bgcolor="#999999" class="item"><div align="center"><strong>M</strong></div></td>
    <td bgcolor="#999999" class="item"><div align="center"><strong>F</strong></div></td>
    <td bgcolor="#999999" class="item"><div align="center"><strong>T</strong></div></td>
    <td bgcolor="#999999" class="item"><div align="center"><strong>M</strong></div></td>
    <td bgcolor="#999999" class="item"><div align="center"><strong>F</strong></div></td>
    <td bgcolor="#999999" class="item"><div align="center"><strong>T</strong></div></td>
    <td bgcolor="#999999" class="item"><div align="center"><strong>M</strong></div></td>
    <td bgcolor="#999999" class="item"><div align="center"><strong>F</strong></div></td>
    <td bgcolor="#999999" class="item"><div align="center"><strong>T</strong></div></td>
    <td bgcolor="#999999" class="item"><div align="center"><strong>M</strong></div></td>
    <td bgcolor="#999999" class="item"><div align="center"><strong>F</strong></div></td>
    <td bgcolor="#999999" class="item"><div align="center"><strong>T</strong></div></td>
    <td bgcolor="#999999" class="item"><div align="center"><strong>M</strong></div></td>
    <td bgcolor="#999999" class="item"><div align="center"><strong>F</strong></div></td>
    <td bgcolor="#999999" class="item"><div align="center"><strong>T</strong></div></td>
    <td bgcolor="#999999" class="item"><div align="center"><strong>M</strong></div></td>
    <td bgcolor="#999999" class="item"><div align="center"><strong>F</strong></div></td>
    <td bgcolor="#999999" class="item"><div align="center"><strong>T</strong></div></td>
    <td bgcolor="#999999" class="item"><div align="center"><strong>M</strong></div></td>
    <td bgcolor="#999999" class="item"><div align="center"><strong>F</strong></div></td>
    <td bgcolor="#999999" class="item"><div align="center"><strong>T</strong></div></td>
    <td bgcolor="#999999" class="item"><div align="center"><strong>M</strong></div></td>
    <td bgcolor="#999999" class="item"><div align="center"><strong>F</strong></div></td>
    <td bgcolor="#999999" class="item"><div align="center"><strong>T</strong></div></td>
    <td bgcolor="#999999" class="item"><div align="center"><strong>M</strong></div></td>
    <td bgcolor="#999999" class="item"><div align="center"><strong>F</strong></div></td>
    <td bgcolor="#999999" class="item"><div align="center"><strong>T</strong></div></td>
  </tr>
  <?
  	$ob_reporte->ano =$ano;
	if($tipo_ensenanza!=0){
		$ob_reporte->tipo_ensenanza=$tipo_ensenanza;
	}
	$result =$ob_reporte ->CursoEnsenanza($conn);
	
	for($i=0;$i < @pg_numrows($result); $i++){
		$fila = @pg_fetch_array($result,$i);
		$Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
	
  	
   ?>
  <tr>
    <td class="subitem"><?=$Curso_pal;?></td>
    <td class="subitem"><div align="center">
		<? 	$ob_reporte->nro_ano=$nro_ano;
			$ob_reporte->ano = $ano;
			$ob_reporte->curso = $fila['id_curso'];
			$ob_reporte->sexo=2;
			$ob_reporte->bool_baj=1;
			$ob_reporte->bool_seg=0;
			$ob_reporte->bool_bchs=0;
			$ob_reporte->alum_prio=0;
			$ob_reporte->ben_hpv=0;
			$ob_reporte->bool_cpadre=0;
			$ob_reporte->bool_otros=0;
			$ob_reporte->bool_mun=0;
			$ob_reporte->ben_cedae=0;
			$ob_reporte->ben_puente=0;
			$ob_reporte->ben_sep=0;
			$ob_reporte->Becas($conn);
			echo $bool_bajM = $ob_reporte->total;
			$bool_bajMT = $bool_bajMT + $bool_bajM;
		?>
	</div></td>
    <td class="subitem"><div align="center">
		<? 	$ob_reporte->nro_ano=$nro_ano;
			$ob_reporte->ano = $ano;
			$ob_reporte->curso = $fila['id_curso'];
			$ob_reporte->sexo=1;
			$ob_reporte->bool_baj=1;
			$ob_reporte->bool_seg=0;
			$ob_reporte->bool_bchs=0;
			$ob_reporte->alum_prio=0;
			$ob_reporte->ben_hpv=0;
			$ob_reporte->bool_cpadre=0;
			$ob_reporte->bool_otros=0;
			$ob_reporte->bool_mun=0;
			$ob_reporte->ben_cedae=0;
			$ob_reporte->ben_puente=0;
			$ob_reporte->ben_sep=0;
			$ob_reporte->Becas($conn);
			echo $bool_bajF = $ob_reporte->total;
			$bool_bajFT = $bool_bajFT + $bool_bajF;
		?>
	</div></td>
    <td class="subitem"><div align="center"><? echo ($bool_bajM + $bool_bajF);?></div></td>
    <td class="subitem"><div align="center">
		<? 	$ob_reporte->nro_ano=$nro_ano;
			$ob_reporte->ano = $ano;
			$ob_reporte->curso = $fila['id_curso'];
			$ob_reporte->sexo=2;
			$ob_reporte->bool_baj=0;
			$ob_reporte->bool_seg=1;
			$ob_reporte->bool_bchs=0;
			$ob_reporte->alum_prio=0;
			$ob_reporte->ben_hpv=0;
			$ob_reporte->bool_cpadre=0;
			$ob_reporte->bool_otros=0;
			$ob_reporte->bool_mun=0;
			$ob_reporte->ben_cedae=0;
			$ob_reporte->ben_puente=0;
			$ob_reporte->ben_sep=0;
			$ob_reporte->Becas($conn);
			echo $bool_segM = $ob_reporte->total;
			$bool_segMT = $bool_segMT + $bool_segM;
		?>
	</div></td>
    <td class="subitem"><div align="center">
		<? 	$ob_reporte->nro_ano=$nro_ano;
			$ob_reporte->ano = $ano;
			$ob_reporte->curso = $fila['id_curso'];
			$ob_reporte->sexo=1;
			$ob_reporte->bool_baj=0;
			$ob_reporte->bool_seg=1;
			$ob_reporte->bool_bchs=0;
			$ob_reporte->alum_prio=0;
			$ob_reporte->ben_hpv=0;
			$ob_reporte->bool_cpadre=0;
			$ob_reporte->bool_otros=0;
			$ob_reporte->bool_mun=0;
			$ob_reporte->ben_cedae=0;
			$ob_reporte->ben_puente=0;
			$ob_reporte->ben_sep=0;
			$ob_reporte->Becas($conn);
			echo $bool_segF = $ob_reporte->total;
			$bool_segFT = $bool_segFT + $bool_segF
		?>
	
	</div></td>
    <td class="subitem"><div align="center"><? echo ($bool_segM + $bool_segF);?></div></td>
    <td class="subitem"><div align="center">
		<? 	$ob_reporte->nro_ano=$nro_ano;
			$ob_reporte->ano = $ano;
			$ob_reporte->curso = $fila['id_curso'];
			$ob_reporte->sexo=2;
			$ob_reporte->bool_baj=0;
			$ob_reporte->bool_seg=0;
			$ob_reporte->bool_bchs=1;
			$ob_reporte->alum_prio=0;
			$ob_reporte->ben_hpv=0;
			$ob_reporte->bool_cpadre=0;
			$ob_reporte->bool_otros=0;
			$ob_reporte->bool_mun=0;
			$ob_reporte->ben_cedae=0;
			$ob_reporte->ben_puente=0;
			$ob_reporte->ben_sep=0;
			$ob_reporte->Becas($conn);
			echo $bool_bchsM = $ob_reporte->total;
			$bool_bchsMT = $bool_bchsMT + $bool_bchsM;
		?>
	
	</div></td>
    <td class="subitem"><div align="center">
		<? 	$ob_reporte->nro_ano=$nro_ano;
			$ob_reporte->ano = $ano;
			$ob_reporte->curso = $fila['id_curso'];
			$ob_reporte->sexo=1;
			$ob_reporte->bool_baj=0;
			$ob_reporte->bool_seg=0;
			$ob_reporte->bool_bchs=1;
			$ob_reporte->alum_prio=0;
			$ob_reporte->ben_hpv=0;
			$ob_reporte->bool_cpadre=0;
			$ob_reporte->bool_otros=0;
			$ob_reporte->bool_mun=0;
			$ob_reporte->ben_cedae=0;
			$ob_reporte->ben_puente=0;
			$ob_reporte->ben_sep=0;
			$ob_reporte->Becas($conn);
			echo $bool_bchsF = $ob_reporte->total;
			$bool_bchsFT = $bool_bchsFT + $bool_bchsF;
		?>
	</div></td>
    <td class="subitem"><div align="center"><? echo ($bool_bchsM + $bool_bchsF);?></div></td>
    <td class="subitem"><div align="center">
		<? 	$ob_reporte->nro_ano=$nro_ano;
			$ob_reporte->ano = $ano;
			$ob_reporte->curso = $fila['id_curso'];
			$ob_reporte->sexo=2;
			$ob_reporte->bool_baj=0;
			$ob_reporte->bool_seg=0;
			$ob_reporte->bool_bchs=0;
			$ob_reporte->alum_prio=1;
			$ob_reporte->ben_hpv=0;
			$ob_reporte->bool_cpadre=0;
			$ob_reporte->bool_otros=0;
			$ob_reporte->bool_mun=0;
			$ob_reporte->ben_cedae=0;
			$ob_reporte->ben_puente=0;
			$ob_reporte->ben_sep=0;
			$ob_reporte->Becas($conn);
			echo $alum_prioM = $ob_reporte->total;
			$alum_prioMT = $alum_prioMT + $alum_prioM;
		?>
	</div></td>
    <td class="subitem"><div align="center">
		<? 	$ob_reporte->nro_ano=$nro_ano;
			$ob_reporte->ano = $ano;
			$ob_reporte->curso = $fila['id_curso'];
			$ob_reporte->sexo=1;
			$ob_reporte->bool_baj=0;
			$ob_reporte->bool_seg=0;
			$ob_reporte->bool_bchs=0;
			$ob_reporte->alum_prio=1;
			$ob_reporte->ben_hpv=0;
			$ob_reporte->bool_cpadre=0;
			$ob_reporte->bool_otros=0;
			$ob_reporte->bool_mun=0;
			$ob_reporte->ben_cedae=0;
			$ob_reporte->ben_puente=0;
			$ob_reporte->ben_sep=0;
			$ob_reporte->Becas($conn);
			echo $alum_prioF = $ob_reporte->total;
			$alum_prioFT = $alum_prioFT + $alum_prioF;
		?>
	</div></td>
    <td class="subitem"><div align="center"><? echo ($alum_prioM + alum_prioF);?></div></td>
    <td class="subitem"><div align="center">
		<? 	$ob_reporte->nro_ano=$nro_ano;
			$ob_reporte->ano = $ano;
			$ob_reporte->curso = $fila['id_curso'];
			$ob_reporte->sexo=2;
			$ob_reporte->bool_baj=0;
			$ob_reporte->bool_seg=0;
			$ob_reporte->bool_bchs=0;
			$ob_reporte->alum_prio=0;
			$ob_reporte->ben_hpv=1;
			$ob_reporte->bool_cpadre=0;
			$ob_reporte->bool_otros=0;
			$ob_reporte->bool_mun=0;
			$ob_reporte->ben_cedae=0;
			$ob_reporte->ben_puente=0;
			$ob_reporte->ben_sep=0;
			$ob_reporte->Becas($conn);
			echo $ben_hpvM = $ob_reporte->total;
			$ben_hpvMT = $ben_hpvMT + $ben_hpvM;
		?>
	</div></td>
    <td class="subitem"><div align="center">
		<? 	$ob_reporte->nro_ano=$nro_ano;
			$ob_reporte->ano = $ano;
			$ob_reporte->curso = $fila['id_curso'];
			$ob_reporte->sexo=1;
			$ob_reporte->bool_baj=0;
			$ob_reporte->bool_seg=0;
			$ob_reporte->bool_bchs=0;
			$ob_reporte->alum_prio=0;
			$ob_reporte->ben_hpv=1;
			$ob_reporte->ben_pie=0;
			$ob_reporte->bool_cpadre=0;
			$ob_reporte->bool_otros=0;
			$ob_reporte->bool_mun=0;
			$ob_reporte->ben_cedae=0;
			$ob_reporte->ben_puente=0;
			$ob_reporte->ben_sep=0;
			$ob_reporte->Becas($conn);
			echo $ben_hpvF = $ob_reporte->total;
			$ben_hpvFT = $ben_hpvFT + $ben_hpvF;
		?>
	</div></td>
    <td class="subitem"><div align="center"><? echo ($ben_hpvM + $ben_hpvF);?></div></td>
    <td class="subitem"><div align="center">
		<? 	$ob_reporte->nro_ano=$nro_ano;
			$ob_reporte->ano = $ano;
			$ob_reporte->curso = $fila['id_curso'];
			$ob_reporte->sexo=2;
				$ob_reporte->bool_baj=0;
			$ob_reporte->bool_seg=0;
			$ob_reporte->bool_bchs=0;
			$ob_reporte->alum_prio=0;
			$ob_reporte->ben_hpv=0;
			$ob_reporte->ben_pie=1;
			$ob_reporte->bool_cpadre=0;
			$ob_reporte->bool_otros=0;
			$ob_reporte->bool_mun=0;
			$ob_reporte->ben_cedae=0;
			$ob_reporte->ben_puente=0;
			$ob_reporte->ben_sep=0;
			$ob_reporte->Becas($conn);
			echo $ben_pieM = $ob_reporte->total;
			$ben_pieMT = $ben_pieMT + $ben_pieM;
		?>
	</div></td>
    <td class="subitem"><div align="center">
		<? 	$ob_reporte->nro_ano=$nro_ano;
			$ob_reporte->ano = $ano;
			$ob_reporte->curso = $fila['id_curso'];
			$ob_reporte->sexo=1;
			$ob_reporte->bool_baj=0;
			$ob_reporte->bool_seg=0;
			$ob_reporte->bool_bchs=0;
			$ob_reporte->alum_prio=0;
			$ob_reporte->ben_hpv=0;
			$ob_reporte->ben_pie=1;
			$ob_reporte->bool_cpadre=0;
			$ob_reporte->bool_otros=0;
			$ob_reporte->bool_mun=0;
			$ob_reporte->ben_cedae=0;
			$ob_reporte->ben_puente=0;
			$ob_reporte->ben_sep=0;
			$ob_reporte->Becas($conn);
			echo $ben_pieF = $ob_reporte->total;
			$ben_pieFT = $ben_pieFT + $ben_pieF;
		?>
	</div></td>
    <td class="subitem"><div align="center"><? echo ($ben_pieM + $ben_pieF);?></div></td>
    <td class="subitem"><div align="center">
		<? 	$ob_reporte->nro_ano=$nro_ano;
			$ob_reporte->ano = $ano;
			$ob_reporte->curso = $fila['id_curso'];
			$ob_reporte->sexo=2;
			$ob_reporte->bool_baj=0;
			$ob_reporte->bool_seg=0;
			$ob_reporte->bool_bchs=0;
			$ob_reporte->alum_prio=0;
			$ob_reporte->ben_hpv=0;
			$ob_reporte->ben_pie=0;
			$ob_reporte->bool_cpadre=1;
			$ob_reporte->bool_otros=0;
			$ob_reporte->bool_mun=0;
			$ob_reporte->ben_cedae=0;
			$ob_reporte->ben_puente=0;
			$ob_reporte->ben_sep=0;
			$ob_reporte->Becas($conn);
			echo $bool_cpadreM = $ob_reporte->total;
			$bool_cpadreMT = $bool_cpadreMT + $bool_cpadreM;
		?>
	</div></td>
    <td class="subitem"><div align="center">
		<? 	$ob_reporte->nro_ano=$nro_ano;
			$ob_reporte->ano = $ano;
			$ob_reporte->curso = $fila['id_curso'];
			$ob_reporte->sexo=1;
			$ob_reporte->bool_baj=0;
			$ob_reporte->bool_seg=0;
			$ob_reporte->bool_bchs=0;
			$ob_reporte->alum_prio=0;
			$ob_reporte->ben_hpv=0;
			$ob_reporte->ben_pie=0;
			$ob_reporte->bool_cpadre=1;
			$ob_reporte->bool_otros=0;
			$ob_reporte->bool_mun=0;
			$ob_reporte->ben_cedae=0;
			$ob_reporte->ben_puente=0;
			$ob_reporte->ben_sep=0;
			$ob_reporte->Becas($conn);
			echo $bool_cpadreF = $ob_reporte->total;
			$bool_cpadreFT = $bool_cpadreFT + $bool_cpadreF;
		?>
	</div></td>
    <td class="subitem"><div align="center"><? echo ($bool_cpadreM + $bool_capdreF);?></div></td>
    <td class="subitem"><div align="center">
		<? 	$ob_reporte->nro_ano=$nro_ano;
			$ob_reporte->ano = $ano;
			$ob_reporte->curso = $fila['id_curso'];
			$ob_reporte->sexo=2;
			$ob_reporte->bool_baj=0;
			$ob_reporte->bool_seg=0;
			$ob_reporte->bool_bchs=0;
			$ob_reporte->alum_prio=0;
			$ob_reporte->ben_hpv=0;
			$ob_reporte->ben_pie=0;
			$ob_reporte->bool_cpadre=0;
			$ob_reporte->bool_otros=1;
			$ob_reporte->bool_mun=0;
			$ob_reporte->ben_cedae=0;
			$ob_reporte->ben_puente=0;
			$ob_reporte->ben_sep=0;
			$ob_reporte->Becas($conn);
			echo $bool_otrosM= $ob_reporte->total;
			$bool_otrosMT = $bool_otrosMT + $bool_otrosM;
		?>
	</div></td>
    <td class="subitem"><div align="center">
		<? 	$ob_reporte->nro_ano=$nro_ano;
			$ob_reporte->ano = $ano;
			$ob_reporte->curso = $fila['id_curso'];
			$ob_reporte->sexo=1;
			$ob_reporte->bool_baj=0;
			$ob_reporte->bool_seg=0;
			$ob_reporte->bool_bchs=0;
			$ob_reporte->alum_prio=0;
			$ob_reporte->ben_hpv=0;
			$ob_reporte->ben_pie=0;
			$ob_reporte->bool_cpadre=0;
			$ob_reporte->bool_otros=1;
			$ob_reporte->bool_mun=0;
			$ob_reporte->ben_cedae=0;
			$ob_reporte->ben_puente=0;
			$ob_reporte->ben_sep=0;
			$ob_reporte->Becas($conn);
			echo $bool_otrosF= $ob_reporte->total;
			$bool_otrosFT = $bool_otrosFT + $bool_otrosF;
		?>
	</div></td>
    <td class="subitem"><div align="center"><? echo ($bool_otrosM + $bool_otrosF);?></div></td>
    <td class="subitem"><div align="center">
		<? 	$ob_reporte->nro_ano=$nro_ano;
			$ob_reporte->ano = $ano;
			$ob_reporte->curso = $fila['id_curso'];
			$ob_reporte->sexo=2;
			$ob_reporte->bool_baj=0;
			$ob_reporte->bool_seg=0;
			$ob_reporte->bool_bchs=0;
			$ob_reporte->alum_prio=0;
			$ob_reporte->ben_hpv=0;
			$ob_reporte->ben_pie=0;
			$ob_reporte->bool_cpadre=0;
			$ob_reporte->bool_otros=0;
			$ob_reporte->bool_mun=1;
			$ob_reporte->ben_cedae=0;
			$ob_reporte->ben_puente=0;
			$ob_reporte->ben_sep=0;
			$ob_reporte->Becas($conn);
			echo $bool_munM= $ob_reporte->total;
			$bool_munMT = $bool_munMT + $bool_munM;
		?>
	</div></td>
    <td class="subitem"><div align="center">
		<? 	$ob_reporte->nro_ano=$nro_ano;
			$ob_reporte->ano = $ano;
			$ob_reporte->curso = $fila['id_curso'];
			$ob_reporte->sexo=2;
			$ob_reporte->bool_baj=0;
			$ob_reporte->bool_seg=0;
			$ob_reporte->bool_bchs=0;
			$ob_reporte->alum_prio=0;
			$ob_reporte->ben_hpv=0;
			$ob_reporte->ben_pie=0;
			$ob_reporte->bool_cpadre=0;
			$ob_reporte->bool_otros=0;
			$ob_reporte->bool_mun=1;
			$ob_reporte->ben_cedae=0;
			$ob_reporte->ben_puente=0;
			$ob_reporte->ben_sep=0;
			$ob_reporte->Becas($conn);
			echo $bool_munF= $ob_reporte->total;
			$bool_munFT = $bool_munFT + $bool_munF;
		?>	
	</div></td>
    <td class="subitem"><div align="center"><? echo ($bool_munM + $bool_munF);?></div></td>
    <td class="subitem"><div align="center">
		<? 	$ob_reporte->nro_ano=$nro_ano;
			$ob_reporte->ano = $ano;
			$ob_reporte->curso = $fila['id_curso'];
			$ob_reporte->sexo=2;
			$ob_reporte->bool_baj=0;
			$ob_reporte->bool_seg=0;
			$ob_reporte->bool_bchs=0;
			$ob_reporte->alum_prio=0;
			$ob_reporte->ben_hpv=0;
			$ob_reporte->ben_pie=0;
			$ob_reporte->bool_cpadre=0;
			$ob_reporte->bool_otros=0;
			$ob_reporte->bool_mun=0;
			$ob_reporte->ben_cedae=1;
			$ob_reporte->ben_puente=0;
			$ob_reporte->ben_sep=0;
			$ob_reporte->Becas($conn);
			echo $ben_cedaeM= $ob_reporte->total;
			$ben_cedaeMT = $ben_cedaeMT + $ben_cedaeM;
		?>
	</div></td>
    <td class="subitem"><div align="center">
		<? 	$ob_reporte->nro_ano=$nro_ano;
			$ob_reporte->ano = $ano;
			$ob_reporte->curso = $fila['id_curso'];
			$ob_reporte->sexo=1;
			$ob_reporte->bool_baj=0;
			$ob_reporte->bool_seg=0;
			$ob_reporte->bool_bchs=0;
			$ob_reporte->alum_prio=0;
			$ob_reporte->ben_hpv=0;
			$ob_reporte->ben_pie=0;
			$ob_reporte->bool_cpadre=0;
			$ob_reporte->bool_otros=0;
			$ob_reporte->bool_mun=0;
			$ob_reporte->ben_cedae=1;
			$ob_reporte->ben_puente=0;
			$ob_reporte->ben_sep=0;
			$ob_reporte->Becas($conn);
			echo $ben_cedaeF= $ob_reporte->total;
			$ben_cedaeFT = $ben_cedaeFT + $ben_cedaeF;
		?>	
	</div></td>
    <td class="subitem"><div align="center"><? echo ($ben_cedaeM + $ben_cedaeF);?></div></td>
    <td class="subitem"><div align="center">
		<? 	$ob_reporte->nro_ano=$nro_ano;
			$ob_reporte->ano = $ano;
			$ob_reporte->curso = $fila['id_curso'];
			$ob_reporte->sexo=2;
			$ob_reporte->bool_baj=0;
			$ob_reporte->bool_seg=0;
			$ob_reporte->bool_bchs=0;
			$ob_reporte->alum_prio=0;
			$ob_reporte->ben_hpv=0;
			$ob_reporte->ben_pie=0;
			$ob_reporte->bool_cpadre=0;
			$ob_reporte->bool_otros=0;
			$ob_reporte->bool_mun=0;
			$ob_reporte->ben_cedae=0;
			$ob_reporte->ben_puente=1;
			$ob_reporte->ben_sep=0;
			$ob_reporte->Becas($conn);
			echo $ben_puenteM= $ob_reporte->total;
			$ben_puenteMT = $ben_puenteMT + $ben_puenteM;
		?>
	</div></td>
    <td class="subitem"><div align="center">
		<? 	$ob_reporte->nro_ano=$nro_ano;
			$ob_reporte->ano = $ano;
			$ob_reporte->curso = $fila['id_curso'];
			$ob_reporte->sexo=1;
			$ob_reporte->bool_baj=0;
			$ob_reporte->bool_seg=0;
			$ob_reporte->bool_bchs=0;
			$ob_reporte->alum_prio=0;
			$ob_reporte->ben_hpv=0;
			$ob_reporte->ben_pie=0;
			$ob_reporte->bool_cpadre=0;
			$ob_reporte->bool_otros=0;
			$ob_reporte->bool_mun=0;
			$ob_reporte->ben_cedae=0;
			$ob_reporte->ben_puente=1;
			$ob_reporte->ben_sep=0;
			$ob_reporte->Becas($conn);
			echo $ben_puenteF= $ob_reporte->total;
			$ben_puenteFT = $ben_puenteFT + $ben_puenteF;
		?>
	</div></td>
    <td class="subitem"><div align="center"><? echo ($ben_puenteM + $ben_puenteF);?></div></td>
    <td class="subitem"><div align="center">
		<? 	$ob_reporte->nro_ano=$nro_ano;
			$ob_reporte->ano = $ano;
			$ob_reporte->curso = $fila['id_curso'];
			$ob_reporte->sexo=2;
			$ob_reporte->bool_baj=0;
			$ob_reporte->bool_seg=0;
			$ob_reporte->bool_bchs=0;
			$ob_reporte->alum_prio=0;
			$ob_reporte->ben_hpv=0;
			$ob_reporte->ben_pie=0;
			$ob_reporte->bool_cpadre=0;
			$ob_reporte->bool_otros=0;
			$ob_reporte->bool_mun=0;
			$ob_reporte->ben_cedae=0;
			$ob_reporte->ben_puente=0;
			$ob_reporte->ben_sep=1;
			$ob_reporte->Becas($conn);
			echo $ben_sepM= $ob_reporte->total;
			$ben_sepMT = $ben_sepMT + $ben_sepM;
		?>	
	</div></td>
    <td class="subitem"><div align="center">
		<? 	$ob_reporte->nro_ano=$nro_ano;
			$ob_reporte->ano = $ano;
			$ob_reporte->curso = $fila['id_curso'];
			$ob_reporte->sexo=1;
			$ob_reporte->bool_baj=0;
			$ob_reporte->bool_seg=0;
			$ob_reporte->bool_bchs=0;
			$ob_reporte->alum_prio=0;
			$ob_reporte->ben_hpv=0;
			$ob_reporte->ben_pie=0;
			$ob_reporte->bool_cpadre=0;
			$ob_reporte->bool_otros=0;
			$ob_reporte->bool_mun=0;
			$ob_reporte->ben_cedae=0;
			$ob_reporte->ben_puente=0;
			$ob_reporte->ben_sep=1;
			$ob_reporte->Becas($conn);
			echo $ben_sepF= $ob_reporte->total;
			$ben_sepFT = $ben_sepFT + $ben_sepF;
		?>	
	</div></td>
    <td class="subitem"><div align="center"><? echo ($ben_sepM + $ben_sepF);?></div></td>
  </tr>
  <? } ?>
  <tr>
    <td bgcolor="#999999" class="item"><strong>TOTALES</strong></td>
    <td bgcolor="#999999" class="item"><div align="center"><?=$bool_bajMT;?></div></td>
    <td bgcolor="#999999" class="item"><div align="center"><?=$bool_bajFT;?></div></td>
    <td bgcolor="#999999" class="item"><div align="center"><? echo ($bool_bajMT + $bool_bajFT);?></div></td>
    <td bgcolor="#999999" class="item"><div align="center"><?=$bool_segMT;?></div></td>
    <td bgcolor="#999999" class="item"><div align="center"><?=$bool_segFT;?></div></td>
    <td bgcolor="#999999" class="item"><div align="center"><? echo ($bool_segMT + $bool_segFT);?></div></td>
    <td bgcolor="#999999" class="item"><div align="center"><?=$bool_bchsMT;?></div></td>
    <td bgcolor="#999999" class="item"><div align="center"><?=$bool_bchsFT;?></div></td>
    <td bgcolor="#999999" class="item"><div align="center"><? echo ($bool_bchsMT + $bool_bchsFT);?></div></td>
    <td bgcolor="#999999" class="item"><div align="center"><?=$alum_prioMT;?></div></td>
    <td bgcolor="#999999" class="item"><div align="center"><?=$alum_prioFT;?></div></td>
    <td bgcolor="#999999" class="item"><div align="center"><? echo ($alum_prioMT + $alum_prioFT);?></div></td>
    <td bgcolor="#999999" class="item"><div align="center"><?=$ben_hpvMT;?></div></td>
    <td bgcolor="#999999" class="item"><div align="center"><?=$ben_hpvFT;?></div></td>
    <td bgcolor="#999999" class="item"><div align="center"><? echo ($ben_hpvMT + $ben_hpvFT);?></div></td>
    <td bgcolor="#999999" class="item"><div align="center"><?=$ben_pieMT;?></div></td>
    <td bgcolor="#999999" class="item"><div align="center"><?=$ben_pieFT;?></div></td>
    <td bgcolor="#999999" class="item"><div align="center"><? echo ($ben_pieMT + $ben_pieFT);?></div></td>
    <td bgcolor="#999999" class="item"><div align="center"><?=$bool_cpadreMT;?></div></td>
    <td bgcolor="#999999" class="item"><div align="center"><?=$bool_cpadreFT;?></div></td>
    <td bgcolor="#999999" class="item"><div align="center"><? echo ($bool_cpadreMT + $bool_cpadreFT);?></div></td>
    <td bgcolor="#999999" class="item"><div align="center"><?=$bool_otrosMT;?></div></td>
    <td bgcolor="#999999" class="item"><div align="center"><?=$bool_otrosFT;?></div></td>
    <td bgcolor="#999999" class="item"><div align="center"><? echo ($bool_otrosMT + $bool_otrosFT);?></div></td>
    <td bgcolor="#999999" class="item"><div align="center"><?=$bool_munMT;?></div></td>
    <td bgcolor="#999999" class="item"><div align="center"><?=$bool_munFT;?></div></td>
    <td bgcolor="#999999" class="item"><div align="center"><? echo ($bool_munMT + $bool_munFT);?></div></td>
    <td bgcolor="#999999" class="item"><div align="center"><?=$ben_cedaeMT;?></div></td>
    <td bgcolor="#999999" class="item"><div align="center"><?=$ben_cedaeFT;?></div></td>
    <td bgcolor="#999999" class="item"><div align="center"><? echo ($ben_cedaeMT + $ben_cedaeFT);?></div></td>
    <td bgcolor="#999999" class="item"><div align="center"><?=$ben_puenteMT;?></div></td>
    <td bgcolor="#999999" class="item"><div align="center"><?=$ben_puenteFT;?></div></td>
    <td bgcolor="#999999" class="item"><div align="center"><? echo ($ben_puenteMT + $ben_puenteFT);?></div></td>
    <td bgcolor="#999999" class="item"><div align="center"><?=$ben_sepMT;?></div></td>
    <td bgcolor="#999999" class="item"><div align="center"><?=$ben_sepFT;?></div></td>
    <td bgcolor="#999999" class="item"><div align="center"><? echo ($ben_sepMT + $ben_sepFT);?></div></td>
  </tr>
</table>
<p>&nbsp;</p>
<table width="100%" border="0">
  <tr>
  <? if($cb_ok!="Buscar"){?>
    <td>&nbsp;</td>
	<? }?>
	<?  
			if($ob_config->firma1!=0){
				$ob_reporte->cargo=$ob_config->firma1;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);?>
	    <td width="25%" class="item" height="100"><hr align="center" width="150" color="#000000" />
        <div align="center">
          <?=$ob_reporte->nombre_emp;?>
          <br />
          <?=$ob_reporte->nombre_cargo;?>
        </div></td>
    <? } ?>
    <? if($ob_config->firma2!=0){
				$ob_reporte->cargo=$ob_config->firma2;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);?>
    <td width="25%" class="item"><hr align="center" width="150" color="#000000" />
        <div align="center">
          <?=$ob_reporte->nombre_emp;?>
          <br />
          <?=$ob_reporte->nombre_cargo;?>
        </div></td>
    <? } ?>
    <? if($ob_config->firma3!=0){
		  		$ob_reporte->cargo=$ob_config->firma3;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);?>
    <td width="25%" class="item"><hr align="center" width="150" color="#000000" />
        <div align="center">
          <?=$ob_reporte->nombre_emp;?>
          <br />
          <?=$ob_reporte->nombre_cargo;?>
        </div></td>
    <? } ?>
    <? if($ob_config->firma4!=0){
				$ob_reporte->cargo=$ob_config->firma4;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);?>
    <td width="25%" class="item"><hr align="center" width="150" color="#000000" />
        <div align="center">
          <?=$ob_reporte->nombre_emp;?>
          <br />
          <?=$ob_reporte->nombre_cargo;?>
      </div></td>
    <? }?>
  </tr>
</table>
</form>
<p>&nbsp; </p>
</body>
</html>
