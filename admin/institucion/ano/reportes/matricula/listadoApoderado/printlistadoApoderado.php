<?php
require('../../../../../../util/header.inc');
include('../../../../../clases/class_Reporte.php');
include('../../../../../clases/class_Membrete.php');

//setlocale("LC_ALL","es_ES");
	$institucion	=$_INSTIT;
	$ano			=$cmb_ano;
	$curso			=1;
	$ramo			=$sel_ramo;
	$reporte		=$c_reporte;
	$total          =$anual;
	
	$ob_reporte = new Reporte();
	$ob_membrete = new Membrete();
	

$ob_reporte ->curso = $curso;
$ob_reporte ->ano = $ano;
$ob_config = new Reporte();
$ob_config->id_item=$reporte;
$ob_config->institucion=$institucion;
$ob_config->curso=$curso;
$rs_config = $ob_config->ConfiguraReporte($conn);
$fila_config = @pg_fetch_array($rs_config,0);
$ob_config->CambiaDatoReporte($fila_config);


$ob_reporte = new Reporte();
$ob_membrete = new Membrete();
$ob_membrete ->institucion = $institucion;
$ob_membrete ->institucion($conn);
$ob_reporte->ano = $ano;

$ob_reporte ->cod_tipo = $cmb_curso;
$ob_reporte ->TipoEnsenanza($conn);

$rs_listado = $ob_reporte ->apoLista($conn);

$ob_membrete->ano = $ano;
$ob_membrete->AnoEscolar($conn);
 $numano = $ob_membrete->nro_ano;

?>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<STYLE>
body{
	font-size:11px}
 H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always
 } 
.item strong {
	font-style: italic;
}
.c {
	text-align: center;
}
.letra_chica
{
font-family:Arial, Helvetica, sans-serif;
font-size:8px;
font-weight:bold;
}
.Estilo1 {font-size: 9px}
</STYLE>
<script>
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
</script>
<link href="../../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<div id="capa0">
<table width="866" align="center">
  <tr>
    <td width="368"><input name="button4" type="button" class="botonXX" onclick="window.close()"   value="CERRAR" /></td>
    <td width="413" align="right"><input name="button3" type="button" class="botonXX"  value="IMPRIMIR" onclick="javascript:imprimir()" /></td>
   
  </tr>
</table>
</div><br>
<table width="100%" height="" border="0" >
        <tr>
          <td width="138" align="left" class="textonegrita">ESTABLECIMENTO</td>
          <td width="200" align="left" class="textonegrita">:&nbsp;<?=$ob_membrete->ins_pal; ?></td>    
          <td width="50" align="left" class="textonegrita">RBD</td>
          <td width="77" align="left" class="textonegrita">:&nbsp;<? echo $institucion."-".$ob_membrete->dig_rdb;; ?></td>
		  <td width="166" align="left" class="textonegrita">A&Ntilde;O ACAD&Eacute;MICO</td>
		  <td width="243" align="left" class="textonegrita">:&nbsp;<? echo $numano ?></td>
        </tr>
        <tr>
          <td class="textonegrita">DIRECCION</td>
          <td class="textonegrita">:&nbsp;<? echo $ob_reporte->tildeM(strtoupper($ob_membrete->direccion));?></td>
          <td class="textonegrita">FONO</td>
          <td class="textonegrita">:&nbsp;<? echo strtoupper($ob_membrete->telefono) ?></td>
		  <td width="166" align="left" class="textonegrita">COMUNA</td>
		  <td width="243" align="left" class="textonegrita">:&nbsp;<? echo strtoupper($ob_membrete->comuna) ?></td>
        </tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
        <tr>
          <td height="16" colspan="15"><div align="center" class="textonegrita"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>LIBRO DE APODERADOS </strong></font></div></td>
        </tr>
</table>
      <br><br>
      
 <?php  if(pg_numrows($rs_listado)>0){  ?>  
<table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#999999">
  <tr>
    <td colspan="6"><div align="center" class="textonegrita"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>DATOS DEL APODERADO </strong></font></div></td>
    <td width="400"><div align="center" class="textonegrita"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>DATOS DEL ALUMNO </strong></font></div></td>
  </tr>
  <tr class="detalle">
    <td width="32" align="center"><strong>N&deg;</strong></td>
    <td width="60" align="center"><strong>RUT</strong></td>
    <td width="80" align="center"><strong>NOMBRE</strong></td>
    <td width="80" align="center"><strong>DIRECCI&Oacute;N</strong></td>
    <td width="60" align="center"><strong>TEL&Eacute;FONO</strong></td>
    <td width="60" align="center"><strong>EMAIL</strong></td>
    <td align="center">
     <table width="100%" >
     <tr class="detalle">
       <td width="12%" ><strong>RUT ALUMNO</strong></td>
      <td width="44%" ><strong>CURSO</strong></td><td width="45%"><strong>NOMBRE</strong></td></table>
    </td>
  </tr>
 <?php  for($i=0;$i<pg_numrows($rs_listado);$i++){
	 $fila_apo = pg_fetch_array($rs_listado,$i);
	 ?>
  <tr class="estilo1">
    <td align="center"><?php echo $i+1 ?></td>
    <td align="center"><?php echo $fila_apo['rut_apo'] ?>-<?php echo strtoupper($fila_apo['dig_rut']) ?>  </td>
    <td><?php echo strtoupper($fila_apo['ape_pat']) ?> <?php echo strtoupper($fila_apo['ape_mat']) ?> <?php echo strtoupper($fila_apo['nombre_apo']) ?></td>
    <td><?php echo strtoupper($fila_apo['direccion']) ?></td>
    <td><?php echo $fila_apo['telefono'] ?></td>
    <td><?php echo $fila_apo['email'] ?></td>
    <td align="center" valign="top">
    <?php 
	 $ob_reporte->rut_apo = $fila_apo['rut_apo'];
	$rs_alu = $ob_reporte ->alumno_curapo($conn);
   for($a=0;$a<pg_numrows($rs_alu);$a++){
	   $fila_al = pg_fetch_array($rs_alu,$a);
	   ?> 
	  <?php if($a>0){?>
     <hr width="100%" color="#999999">
     <?php }?>
   
    <table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#999999">
      <tr class="estilo1">
        <td width="12%" align="center"><?php echo $fila_al['rut_alumno']?>-<?php echo strtoupper($fila_al['dig_rut']) ?>&nbsp;</td>
        <td width="44%"><?php echo CursoPalabra($fila_al['id_curso'],0,$conn); ?></td>
        <td width="44%"><?php echo strtoupper($fila_al['ape_pat']) ?> <?php echo strtoupper($fila_al['ape_mat']) ?> <?php echo strtoupper($fila_al['nombre_alu']) ?></td>
      </tr>
    </table>
	
	<?php }?>
   </td>
  </tr>
  
  <?php }?>
</table>
<?php }else{?>
<table width="100%" border="0" cellspacing="0">
  <tr>
    <td><div align="center" class="textonegrita"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>SIN INFORMACI&Oacute;N</strong></font></div></td>
  </tr>
</table>

<?php }?> <?php  
		 $ruta_timbre =6;
		 $ruta_firma =4;
		 include("../../firmas/firmas.php");?>