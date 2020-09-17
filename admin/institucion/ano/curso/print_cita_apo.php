<script>
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
function exportar(){
			window.location='print_cita_apo.php?c_curso=<?=$curso?>&c_alumno=<?=$alumno?>&xls=1';
			return false;
		  }
</script>


<?php 	
require('../../../../util/header.inc');
include('../../../clases/class_Membrete.php');
include('../../../clases/class_MotorBusqueda.php');
include('../../../clases/class_Reporte.php');


    $institucion	=$_INSTIT	;
	$ano			=$_ANO		;
	$curso			=$c_curso	;
	$alumno			=$rut_alumno	; 
	$reporte		=$c_reporte;
	$citacion		=$id;
	$_POSP = 4;
	$_bot = 8;
	
	
	$sql="SELECT nombre_instit,telefono,calle,nro, c.nom_com FROM institucion i INNER JOIN comuna c ON i.region=c.cod_reg AND i.ciudad=c.cor_pro AND i.comuna=cor_com WHERE rdb=".$institucion;
	$result = pg_exec($conn,$sql) or die(pg_last_error($conn));
	$fila   = pg_fetch_array($result,0);

	$sql="SELECT observacion FROM citacion_apo WHERE id_citacion=".$citacion;
	$result = pg_exec($conn,$sql);
	$fila_cita = pg_fetch_array($result,0);
	
	
	$sql="SELECT nombre_apo,ape_pat,ape_mat FROM apoderado a INNER JOIN tiene2 t ON a.rut_apo=t.rut_apo WHERE t.rut_alumno=".$alumno;
	$result = pg_exec($conn,$sql) or die(pg_last_error($conn));	
	$fila_apo = pg_fetch_array($result,0);
?>
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

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
</head>
<body>
<br>
<br>
<br>
<br>
<form name="form" action="print_cita_apo.php" target="_blank">
  <table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>
	
	<div id="capa0">
	<table width="100%">
	  <tr>
	  	<td><input name="cb_exp" type="button" onClick="exportar()" class="botonXX"  id="cb_exp" value="EXPORTAR"></td>
		<td align="right">
		  <input name="button3" type="button" class="botonXX" onClick="imprimir();" value="IMPRIMIR">
		</td>
	  </tr></table>
      </div></td>
  </tr>
</table>

<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="94" class="textonegrita">Institucion:</td>
    <td width="406" class="textosimple"><? echo $fila ["nombre_instit"];  ?></td>
    <td width="150" rowspan="3"><? echo "<img src='".$d."tmp/".$institucion."insignia". "' >"; ?></td>
  </tr>
  <tr>
    <td class="textonegrita">Direccion:</td>
    <td><? echo $fila ["calle"];  ?></td>
  </tr>
  <tr>
    <td class="textonegrita">Telefono:</td>
    <td><? echo $fila ["telefono"];  ?></td>
  </tr>
</table>
<br>
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td class="tableindex"><div align="center">CITACI&Oacute;N APODERADO</div></td>
  </tr>
</table>
<br>
<br>
<br>
<table width="650" border="0" align="center">
  <tr>
    <td  class="textonegrita"width="116">Se&ntilde;or Apoderado:</td>
    <td width="524" colspan="3">&nbsp;<?=$fila_apo['nombre_apo']." ".$fila_apo['ape_pat']." ".$fila_apo['ape_mat'];?></td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3" class="textosimple"><? echo $fila_cita ["observacion"];  ?></td>
    </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
    </tr>
</table>
<br>
<br>
<br>
<table width="650" border="0" align="center">
  <tr>
    <td><?php
	$dia = date("d");
	$mes = date("m");
	$ano2 = date("Y");
	
	 echo ucwords(strtolower($fila['nom_com'])).", ".$dia." de ".$mes." de ".$ano2 ?></td>
  </tr>
</table>
<table width="650" border="0" align="center">
		  <tr>
		  	<?  
				//echo $rut_emp;
			                 
			if($ob_config->firma1!=0){
				$ob_reporte->cargo=$ob_config->firma1;
				$ob_reporte->curso=$curso;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);
				$rut_emp=$ob_reporte->rut_emp;
	  if(is_file("../../empleado/firma_digital/".$rut_emp.".jpg")){
	 $firmadig1="<td align='center' width='25%' class='item' height='100'><img src='../../empleado/firma_digital/$rut_emp.jpg' width='100' height='50'><hr align='center' width='150' color='#000000'><div    align='center'><span class='item'>$ob_reporte->nombre_emp</span><br>$ob_reporte->nombre_cargo</div></td>";
					
		     "Archivo Firma 1 encontrado";
	             }else{
	               "Archivo Firma 1 no existe"; 
		        }
				if(isset($firmadig1)){
				echo $firmadig1;
				}else{
				?>
                
			<td width="25%" class="item" height="100"><div style="width:100; height:50;"></div><hr align="center" width="150" color="#000000"><div align="center"><span class="item"><?=$ob_reporte->nombre_emp;?> </span><br>
		    <?=$ob_reporte->nombre_cargo;?></div></td>
			<? }} ?>
			<? if($ob_config->firma2!=0){
				$ob_reporte->cargo=$ob_config->firma2;
				$ob_reporte->curso=$curso;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);
				$rut_emp=$ob_reporte->rut_emp;
	  if(is_file("../../empleado/firma_digital/".$rut_emp.".jpg")){
	 $firmadig2="<td align='center' width='25%' class='item' height='100'><img src='../../empleado/firma_digital/$rut_emp.jpg' width='100' height='50'><hr align='center' width='150' color='#000000'><div    align='center'><span class='item'>$ob_reporte->nombre_emp</span><br>$ob_reporte->nombre_cargo</div></td>";
					
		     "Archivo Firma 2 encontrado";
	             }else{
	               "Archivo Firma 2 no existe"; 
		        }
				if(isset($firmadig2)){
				echo $firmadig2;
				}else{
				?>
		    <td width="25%" class="item"><div style="width:100; height:50;"></div><hr align="center" width="150" color="#000000"> 
		      <div align="center"><?=$ob_reporte->nombre_emp;?><br>
	        <?=$ob_reporte->nombre_cargo;?></div></td>
			<? }} ?>
			 <? if($ob_config->firma3!=0){
		  		$ob_reporte->cargo=$ob_config->firma3;
				$ob_reporte->curso=$curso;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);
				$rut_emp=$ob_reporte->rut_emp;
	  if(is_file("../../empleado/firma_digital/".$rut_emp.".jpg")){
	 $firmadig3="<td align='center' width='25%' class='item' height='100'><img src='../../empleado/firma_digital/$rut_emp.jpg' width='100' height='50'><hr align='center' width='150' color='#000000'><div    align='center'><span class='item'>$ob_reporte->nombre_emp</span><br>$ob_reporte->nombre_cargo</div></td>";
					
		     "Archivo Firma 3 encontrado";
	             }else{
	               "Archivo Firma 3 no existe"; 
		        }
				if(isset($firmadig3)){
				echo $firmadig3;
				}else{
				
				?>
			<td width="25%" class="item"><div style="width:100; height:50;"></div><hr align="center" width="150" color="#000000"><div align="center"><?=$ob_reporte->nombre_emp;?><br>
		    <?=$ob_reporte->nombre_cargo;?></div></td>
			<? }} ?>
			 <? if($ob_config->firma4!=0){
				$ob_reporte->cargo=$ob_config->firma4;
				$ob_reporte->curso=$curso;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);
				$rut_emp=$ob_reporte->rut_emp;
				
	  if(is_file("../../empleado/firma_digital/".$rut_emp.".jpg")){
	 $firmadig4="<td align='center' width='25%' class='item' height='100'><img src='../../empleado/firma_digital/$rut_emp.jpg' width='100' height='50'><hr align='center' width='150' color='#000000'><div    align='center'><span class='item'>$ob_reporte->nombre_emp</span><br>$ob_reporte->nombre_cargo</div></td>";
		  
		     "Archivo Firma 4 encontrado";
	             }else{
	               "Archivo Firma 4 no existe"; 
		        }
				if(isset($firmadig4)){
				echo $firmadig4;
				}else{
				
				
				?>
                
                
		    <td width="25%" class="item"><div style="width:100; height:50;"></div><hr align="center" width="150" color="#000000"><div align="center"><?=$ob_reporte->nombre_emp;?><br>
	        <?=$ob_reporte->nombre_cargo;?> </div></td>
			<? }}?>
		  </tr>
  </table>
</form>







</body>
</html>