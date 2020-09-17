<?php 

require('../../../../../../util/header.inc');
include('../../../../../clases/class_Reporte.php');
include('../../../../../clases/class_Membrete.php');


$curso = 1;
$institucion = $_INSTIT;
$ano=$_ANO;
$reporte		=$c_reporte;
$_POSP = 6;
$_bot = 8;

$ob_reporte = new Reporte();
$ob_membrete = new Membrete();





//-------------------------	 CONFIGURACION DE REPORTE ------------------
	$ob_config = new Reporte();
	$ob_reporte = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=$curso;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = @pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);
	
	$qry_ano="SELECT * FROM ano_escolar WHERE id_ano=".$ano." AND id_institucion=".$institucion;
$result_ano =@pg_Exec($conn,$qry_ano);
$fila_ano = @pg_fetch_array($result_ano,0);
$ano_esc = $fila_ano['nro_ano'];

/// tomar nombre de la institucion
$sql_institu = "SELECT institucion.rdb, institucion.dig_rdb, institucion.nombre_instit, institucion.calle, institucion.nro, institucion.telefono, region.nom_reg, provincia.nom_pro, comuna.nom_com ";
	$sql_institu = $sql_institu . "FROM ((institucion INNER JOIN region ON institucion.region = region.cod_reg) INNER JOIN provincia ON (institucion.ciudad = provincia.cor_pro) AND (region.cod_reg = provincia.cod_reg)) INNER JOIN comuna ON (provincia.cod_reg = comuna.cod_reg) AND (provincia.cor_pro = comuna.cor_pro) AND (institucion.comuna = comuna.cor_com) ";
	$sql_institu = $sql_institu . "WHERE (((institucion.rdb)=".$institucion.")); ";

$result_institu =@pg_Exec($conn,$sql_institu);
	$fila_institu = @pg_fetch_array($result_institu,0);
	$rdb = $fila_institu['rdb'] . "-" . $fila_institu['dig_rdb'];
	$nombre_institu = ucwords(strtolower($fila_institu['nombre_instit']));
	$direccion = ucwords(strtolower($fila_institu['calle'] . " " . $fila_institu['nro']));
	$telefono = $fila_institu['telefono'];
	$comuna = ucwords(strtolower($fila_institu['nom_com']));
	$ciudad = ucwords(strtolower($fila_institu['nom_pro']));
	$region = ucwords(strtolower($fila_institu['nom_reg']));

$ob_reporte->rut_emp = $c_docente;
$ob_reporte->Profesor($conn);

$ob_reporte->periodo=$c_periodos;
$ob_reporte->Periodo($conn);

$ob_reporte->ano =$ano;
$ob_reporte->nro_ano=$ano_esc;

$rs_subsector = $ob_reporte->subsDocente($conn);
$rs_curso =  $ob_reporte->getCursosDictaDocente($conn);



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<link href="../../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
</head>
<style>
.Estilo7 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; }
.Estilo8 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; font-weight: bold; }
</style>
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

<script> 
function cerrar(){ 
window.close() 
} 
</script>
<script>
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
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
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
	  <tr>
		<td width="487"><font face="Verdana, Verdana, Arial, Helvetica, sans-serif" size="1"><strong><? echo ucwords(strtoupper($nombre_institu));?></strong></font></td>
		<td width="11">&nbsp;</td>
		<td width="152" rowspan="4" align="center">
				<?	
					$result = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
					$arr=@pg_fetch_array($result,0);
					$fila_foto = @pg_fetch_array($result,0);
					## código para tomar la insignia
				
					if($institucion!=""){
						echo "<img src='../../../../../../".$d."tmp/".$fila_foto['rdb']."insignia". "' >";
					}else{
						echo "<img src='../../../../../../".$d."menu/imag/logo.gif' >";
					}
				?>
		</td>
	  </tr>
	  <tr>
		<td><font face="Verdana, Verdana, Arial, Helvetica, sans-serif" size="1"><? echo ucwords(strtolower($direccion));?></font></td>
		<td>&nbsp;</td>
	  </tr>
	  <tr>
		<td><font face="Verdana, Verdana, Arial, Helvetica, sans-serif" size="1">Fono:&nbsp;<? echo ucwords(strtolower($telefono));?></font></td>
		<td>&nbsp;</td>
	  </tr>
	  <tr>
		<td height="41">&nbsp;</td>
		<td>&nbsp;</td>
	  </tr>
</table>
<br />
<br />
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td class="tableindex"><div align="center">PROMEDIOS POR DOCENTE</div></td>
    </tr>
  <tr>
    <td c>&nbsp;</td>
  </tr>
 
  <tr>
    <td class="textosimple"><b>DOCENTE:</b> <?php echo	$ob_reporte->profesor;
	 ?></td>
  </tr>
  <tr>
    <td class="textosimple"><strong>PERIODO:</strong> <?php echo $ob_reporte->nombre_periodo ?> </td>
  </tr>
 
  <tr>
    <td class="textosimple">&nbsp;</td>
  </tr>
  <tr>
</table>
<br />
<table width="650" border="1" cellspacing="1" cellpadding="1" align="center" style="border-collapse:collapse">
  <tr>
    <td width="30%" rowspan="2" class="tableindex">Subsector</td>
    <td colspan="<?php echo pg_numrows($rs_curso) ?>" align="center" class="tableindex">Curso</td>
  </tr>
  <tr class="tableindex">
  <?php for($c=0;$c<pg_numrows($rs_curso);$c++){
	  $fila_c = pg_fetch_array($rs_curso,$c);
	  
	  
	  ?>
    <td align="center"><?php echo cursoPalabra($fila_c['id_curso'],6,$conn); ?></td>
    <?php }?>
   
  </tr>
  <?php for($s=0;$s<pg_numrows($rs_subsector);$s++){
	 $fila_s = pg_fetch_array($rs_subsector,$s); 
	 ?>
  
  <tr class="textosimple">
    <td><?php echo $fila_s['nombre'] ?></td>
   <?php for($c=0;$c<pg_numrows($rs_curso);$c++){
	   $fila_c = pg_fetch_array($rs_curso,$c);  
	   ?>
    <td align="center" >
   <?php 
   	   $ob_reporte->modo_eval = "";
   	   $ob_reporte->curso = $fila_c['id_curso'];
	   $ob_reporte->cdsub = $fila_s['cod_subsector'];
	   $rs_ramo =  $ob_reporte->SubsectorRamo($conn);
    if(strlen($ob_reporte->id_ramo)>0){
		$ob_reporte->ramo =  $ob_reporte->id_ramo;
		//consulta calculo del promedio
		$ob_reporte->PromedioRamoCurso($conn);
		$prom = $ob_reporte->suma_curso/$ob_reporte->contador_curso;
				
		echo (isset($chk_aprox))?round($prom):intval($prom);
		
		} ?></td>
    <?php }?>
   
  </tr>
  <?php }?>
</table>

<br />
<br />

 <?php  
		 $ruta_timbre =6;
		 $ruta_firma =4;
		 $concur=0;
		 include("../../firmas/firmas.php");?>
