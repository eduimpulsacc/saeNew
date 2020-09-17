<? 

header( 'Content-type: text/html; charset=iso-8859-1' ); 
session_start(); 

$institucion 	= $_INSTIT;
$ano 			=$_REQUEST['ano'];
//$curso 			= $_REQUEST['curso'];
$rut 		= $_REQUEST['rut'];
$plantilla 		= $_REQUEST['plantilla'];
$tipoplantilla	= $_REQUEST['tipoPlantilla'];




require "../../Class/Membrete.php";	
require "../../Class/Reporte.php";	

$ob_membrete = new Membrete($_IPDB,$_ID_BASE);
$ob_reporte = new Reporte($_IPDB,$_ID_BASE);

$fila_instit = $ob_membrete->institucion($_INSTIT);




$fila_ano =$ob_reporte->AnoEscolarSeteado($ano);

$nro_ano = $fila_ano['nro_ano'];
$cerrado = $fila_ano['situacion'];


$ob_reporte->ano=$ano;
$ob_reporte->curso=$curso;
$ob_reporte->alumno=$alumno;
$rs_periodos = $ob_reporte->TotalPeriodo($ano);
$num_periodos= pg_numrows($rs_periodos);

if ($num_periodos==2) $tipo_per = "SE";
if ($num_periodos==3) $tipo_per = "TR";	
		
function CambioFD($fecha)   //    cambia fecha del tipo   aaaa/mm/dd  ->  dd/mm/aaaa   para mostrarlo en pantalla
{
	$retorno="";
	if(strlen($fecha) <10 )
		return $retorno;
	$d=substr($fecha,8,2);
	$m=substr($fecha,5,2);
	$a=substr($fecha,0,4);
	if (checkdate($m,$d,$a))
		$retorno=$d."/".$m."/".$a;
	else
		$retorno="";
	return $retorno;
}
$rs_plantilla=$ob_reporte->evaluacionApo($ano,$plantilla,$rut);
$fila_plantilla = pg_fetch_array($rs_plantilla,0);

//$ob_reporte->plantilla=$fila_plantilla['id_plantilla'];
	
	$rs_area = $ob_reporte->getAreas($plantilla);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso8859-1" />
<link rel="stylesheet" type="text/css" href="../../../cortes/25269/estilos.css"/>
<title>REPORTE CEDE:::::: COLEGIO INTERACTIVO</title>
</head>
<style>
table{ font-size:12px}
</style>
<body>
<table width="650" border="0" align="center">
  <tr>
    <td width="172" align="center" valign="middle"> <? echo "<img src='../../../tmp/".$institucion."insignia". "' >";?></td>
    <td width="25" align="center" valign="middle"><hr align="center" width="1" size="100" /></td>
    <td width="439"><table width="100%" border="0">
      <tr>
        <td align="center" class="textonegrita"><? echo strtoupper($fila_instit['nombre_instit']);?></td>
      </tr>
      <tr>
        <td align="center" class="textosimple"><? echo $fila_instit['direc']." / ".$fila_instit['nom_reg'];?></td>
      </tr>
      <tr>
        <td align="center" class="textosimple"><? echo htmlentities("Telefóno",ENT_QUOTES,'UTF-8')."  ".$fila_instit['telefono'];?></td>
      </tr>
      <tr>
        <td align="center" class="textosesion">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="3" class="textosimple">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" align="center" class=" textosesion">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" align="center" class="textonegrita"><?php echo $fila_plantilla['titulo'] ?></td>
  </tr>
  <tr>
    <td colspan="3" align="center" class=" textosesion">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" align="center" class="textonegrita"><strong><?php echo $fila_plantilla['descripcion'] ?></strong></td>
  </tr>
  <tr>
    <td colspan="3" align="center" class=" textosesion">&nbsp;</td>
  </tr>
  
</table><br /><table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr >
    <td class="textonegrita">
    <?php   //consultas por tipo de planilla
 if($tipoPlantilla==1){
	$n_ent=$ob_reporte->nombreApo($rut);
}
elseif($tipoPlantilla==2){
	
	 $n_ent=$ob_reporte->nombreAlumno($rut);
	
	
}elseif($tipoPlantilla==3){
	
	
	 $n_ent=$ob_reporte->Empleado($rut);
	 
	
} ?>
    <div align="left"><strong>Entrevistado: 
      <? echo $n_ent; ?>
    </strong></div></td>
  </tr>
  <tr>
    <td class="textonegrita"><strong>A&ntilde;o acad&eacute;mico: <? echo trim($nro_ano) ?></strong></td>
  </tr>
  <tr>
</table>
<br />
<table width="650"  align="center" border="1" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
  <tr class="textonegrita">
    <td class=""><div align="left"></div></td>
   
    <td  width="80" align="center" colspan="<?php echo $num_periodos ?>" class="item"><strong>Evaluaci&oacute;n</strong></td>
    
    </tr>
    <?php 
	  for($a=0;$a<pg_numrows($rs_area);$a++){
		  $fila_area = pg_fetch_array($rs_area,$a);
		  
		
		$rs_item=$ob_reporte->getConceptoApo($plantilla,$fila_area['id_area']);		
		  
	  ?>
  <tr class="textonegrita">
    <td ><strong><?= strtoupper(utf8_decode($fila_area['nombre']));?></strong></td>
    <?php  for($i=0;$i<$num_periodos;$i++)
		{
       
		 
	
		?>
    <td  width="80" align="center" class="item"><?php echo $i+1 ?> <?php echo $tipo_per?></td>
    <?php }?>
  </tr>
   <?php 
	  for($ii=0;$ii<pg_numrows($rs_item);$ii++){
			$fil_item = pg_fetch_array($rs_item,$ii);?>
<tr class="textosimple" >
  <td width="545"  ><?php echo utf8_decode($fil_item['nombre']) ?></td>
 <?php  for($i=0;$i<$num_periodos;$i++)
		{
    	 
		$fila_per=pg_fetch_array($rs_periodos,$i);
		 
	 $rs_obs = $ob_reporte->selEvaluacionPeriodo($rut,$ano,$fila_per['id_periodo']);
	 
	$fila_obs = pg_fetch_array($rs_obs,0);
	
	
	$pun="";
		if(pg_numrows($rs_obs)>0){
		//	$ob_reporte->evaluacion= $fila_obs['id_evaluacion'];
			$rs_pun = $ob_reporte->selItemEvaluacionApo($fila_obs['id_evaluacion'],$fila_area['id_area'],$fil_item['id_item'],$ano,$fila_per['id_periodo']);
			
			
			$fil_pun=pg_fetch_array($rs_pun,0);
			$pun=$fil_pun['nombre'];
		}
	
		?>
    <td  width="80" align="center" class="item"><?php echo $pun ?></td>
    <?php }?>
  </tr>
<?php }?>
  <?php }?>
  <tr>
</table><br />
<br />
<table width="650" align="center" border="1" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
<tr class="textonegrita"><td><strong>OBSERVACIONES</strong></td></tr>
 <?php  for($i=0;$i<pg_numrows($rs_periodos);$i++){
	 $fil_per=pg_fetch_array($rs_periodos,$i);
	 
	
	 
	 $rs_obs = $ob_reporte->selEvaluacionPeriodo($rut ,$ano,$fil_per['id_periodo']);
	 
	 $fila_obs = pg_fetch_array($rs_obs,0);
	 
	 ?>
<tr class="textosimple">
  <td><strong><?php echo $i+1 ?> <?php echo $tipo_per?></strong>: <?php echo $fila_obs['observacion']; ?></td>
</tr>
<?php }?>
</table><br />
<br />
<table width="650" align="center" border="1" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
<tr class="textonegrita"><td colspan="3"><div align="center" class="tt"><strong>METODOS DE EVALUACION</strong></div></td>
  </tr>
<tr>
  <td colspan="3">&nbsp;</td>
  </tr>
<tr class="textonegrita">
  <td><strong>NOMBRE</strong></td>
  <td><strong>SIGLA</strong></td>
  <td><strong>GLOSA</strong></td>
  </tr>
  <?php $rs_con = $ob_reporte->ListaConceptoApo($plantilla );
  ?>
    <?php
		for($j=0;$j<pg_numrows($rs_con);$j++){
			$fila_con = pg_fetch_array($rs_con,$j);
		?>
<tr class="textosimple" >
  <td align="center" class="te2"><?php echo utf8_decode($fila_con['nombre']) ?></td>
  <td align="center" class="te2"><?php echo utf8_decode($fila_con['sigla']) ?></td>
  <td class="te">&nbsp;<?php echo utf8_decode($fila_con['glosa']) ?></td>
</tr>
<?php }?>
</table>
</body>
</html>
