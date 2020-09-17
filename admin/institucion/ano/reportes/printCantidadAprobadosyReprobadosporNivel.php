<?php
require('../../../../util/header.inc');
include('../../../clases/class_Reporte.php');
include('../../../clases/class_Membrete.php');


	//setlocale("LC_ALL","es_ES");
    $institucion	=$_INSTIT;
 	$ano			=$_GET[idano];
    $idnivel        =$_GET[idnivel]; 
	$reporte	    =$_GET[c_reporte];

	$_POSP = 4;
	$_bot = 8;
	
	//---------------------CONFIGURO MENBRETE--------------------//
	
	$ob_membrete = new Membrete();
	$ob_membrete ->institucion = $institucion;
	$ob_membrete ->institucion($conn); 
	$ob_membrete ->ano = $ano;
	$ob_membrete ->AnoEscolar($conn);
	$ob_membrete ->idnivel = $idnivel;
	$ob_membrete ->nivel($conn);
	$comuna = $ob_membrete ->comuna;
	
	//-----------------------DATOS REPORTE-----------------------------------//
	
	$ob_reporte = new Reporte();
	$ob_reporte ->ano = $ano;
	$ob_reporte ->idnivel = $idnivel;
	$rs_aproreproxnivel = $ob_reporte->aproreproxnivel($conn); 
	// se genera la consulta y trae todos os registros para ser recorriga por un ciclo
	
	
	//-------------------------	 CONFIGURACION DE REPORTE SIN CURSO  ------------------//
	
	$ob_config = new Reporte();
	
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;

	$rs_config = $ob_config->ConfiguraReportesincurso($conn);
	
	$fila_config = @pg_fetch_array($rs_config,0);
	
	$ob_config->CambiaDatoReporte($fila_config);
	

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
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

<SCRIPT language="JavaScript">
									
function imprimir()	{
		document.getElementById("capa0").style.display='none';
		window.print();
		document.getElementById("capa0").style.display='block';
	}


function cerrar(){ 
window.close() 
} 

</script>

</head>
<body>

<div id="capa0">
  <table width="700" align="center" >
    <tr>
      <td width="302"><input name="button4" type="button" class="botonXX" onClick="cerrar()"   value="CERRAR">      </td>
      <td width="316" align="right"><input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR"></td>
	  <!--<td width="66" align="right"><input name="button4" type="button" class="botonXX" onClick="enviapag2(this.form);"  value="EXPORTAR"> </td>-->
    </tr>
  </table>
</div>

<br>
<br>
<!--INICIO DE MENBRETE-->
		<table width="628" align="center" border=0 cellpadding=1 cellspacing=1 >
		  <tr> 
			<td width="20%" class="item"><strong>INSTITUCION</strong></td>
			<td width="1%"><strong>:</strong></td>
			<td width="44%" class="item"><strong><?=$ob_membrete->ins_pal;?></strong></td>
            <td width="35%" rowspan="3" class="item">
			<?
				$result = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
				
				$arr=@pg_fetch_array($result,0);
				$fila_foto = @pg_fetch_array($result,0);
				## código para tomar la insignia
		
			  if($institucion!=""){
				   echo "<img src='../../../../tmp/".$fila_foto['rdb']."insignia". "' >";
			  }else{
				   echo "<img src='".$d."menu/imag/logo.gif' >";
			  }
						  
			  ?>		
			&nbsp;</td>
		  </tr>
         <tr> 
			<td align=left class="item"><strong>AÑO ESCOLAR</strong></td>
			<td> <strong>:</strong></td>
			<td class="item"><strong><?=$ob_membrete->nro_ano?></strong> </font> </td>
          </tr>

		  <tr> 
			<td align=left class="item"><strong> NIVEL </strong></td>
			<td><strong>:</strong> </font> </td>
			<td class="item"><strong><?=$ob_membrete->nombre_nivel?></strong></td>
          </tr>
        </table> 
<!--FIN DE MENBRETE-->
<br><br>
<!--INICIO DE MOSTRAR DATOS -->
<table width="646" border="1" align="center"  style="border-collapse:collapse" > 
  <tr>
    <th  colspan="7" class="tableindex" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CANTIADAD APROBADOS REPROBADOS POR NIVEL<strong>
      <?=$ob_membrete->nombre_nivel?>
    </strong></th>
  </tr>
  <tr>
    <th class="subitem" >Cursos</th>
    <th class="subitem" >Aprobados</th>
    <th class="subitem" >Reprobados</th>
	<th class="subitem" >Retirados</th>
	<th class="subitem" >Por Inasistencia</th>
    <th class="subitem" >Por Rendimiento</th>
	<th class="subitem" >Total Curso</th>
  </tr>

<?

for($x=0 ; $x < @pg_numrows($rs_aproreproxnivel) ; $x++){

 $fila_aproreproxnivel = @pg_fetch_array($rs_aproreproxnivel,$x);
 
?>  
  <tr align="center">
    <td class="subitem"><?=$fila_aproreproxnivel['curso'];?>&nbsp;</td>
    <td class="subitem"><?=$fila_aproreproxnivel['cantidad_aprobados'];?>&nbsp;</td>
    <td class="subitem"><?=$fila_aproreproxnivel['cantidad_reprobados'];?>&nbsp;</td>
	<td class="subitem"><?=$fila_aproreproxnivel['cantidad_retirados'];?>&nbsp;</td>
	<td class="subitem"><?=$fila_aproreproxnivel['cantidad_pornotas'];?>&nbsp;</td>
	<td class="subitem"><?=$fila_aproreproxnivel['cantidad_porinasistencia'];?>&nbsp;</td>
	<td class="subitem"><?=$fila_aproreproxnivel['total_alumnos'];?>&nbsp;</td>
  </tr>
<? } ?>

</table> <!--FIN DE MOSTRAR DATOS -->
<br><br><br>
<!--INICIO DE FIRMA-->
<table width="650" border="0" cellspacing="0" cellpadding="0" align="center">
<tr>
<td>
<HR width="100%" color=#003b85>
<td>
<tr>
</table>
<br>
<table width="650" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>OBSERVACIONES:&nbsp;&nbsp;</strong></font></div></td>
  </tr>
  <tr>
    <td height="20"><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>___________________________________________________________________________________________________________</strong></font></div></td>
  </tr>
  <tr>
    <td height="20"><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>___________________________________________________________________________________________________________</strong></font></div></td>
  </tr>
  <tr>
    <td height="20"><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>___________________________________________________________________________________________________________</strong></font></div></td>
  </tr>
</table>
<br>
<!--INICIO FIRMA-->

<table width="650" border="0" align="center">
		  <tr>
		  	<?  
			if($ob_config->firma1!=0){
				$ob_reporte->cargo=$ob_config->firma1;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);?>
			<td width="25%" class="item" height="100">
			<hr align="center" width="150" color="#000000"><div align="center">
			<span class="item"><?=$ob_reporte->nombre_emp;?> </span><br>
		    <?=$ob_reporte->nombre_cargo;?></div></td>
			<? } ?>
			
			
			<? if($ob_config->firma2!=0){
				$ob_reporte->cargo=$ob_config->firma2;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);?>
		    <td width="25%" class="item"><hr align="center" width="150" color="#000000"> 
		      <div align="center">
			  <?=$ob_reporte->nombre_emp;?><br>
	          <?=$ob_reporte->nombre_cargo;?></div></td>
			<? } ?>
			
			 <? if($ob_config->firma3!=0){
		  		$ob_reporte->cargo=$ob_config->firma3;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);?>
			<td width="25%" class="item">
			<hr align="center" width="150" color="#000000">
			<div align="center">
			<?=$ob_reporte->nombre_emp;?><br>
		    <?=$ob_reporte->nombre_cargo;?></div></td>
			<? } ?>
			 
			 <? if($ob_config->firma4!=0){
				$ob_reporte->cargo=$ob_config->firma4;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);?>
		    <td width="25%" class="item">
			<hr align="center" width="150" color="#000000"><div align="center"><?=$ob_reporte->nombre_emp;?><br>
	        <?=$ob_reporte->nombre_cargo;?> </div></td>
			<? }?>
		  </tr>
</table>

<!--FIN FIRMA-->

<br>
<table align="center"><?  $fecha = date("d-m-Y");?>
<tr>
<td colspan="4"><br><br><font face="Verdana, Arial, Helvetica, sans-seri" size="-1">
<?= ucwords(strtolower($comuna)).", ".fecha_espanol($fecha) ?></font></td>
</tr>
</table>

<!-- FIN CUERPO DE LA PAGINA -->
</body>
</html>
<? pg_close($conn);?>

