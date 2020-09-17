
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
include_once('mod_promedios_subsector.php');
print_r($_POST);

	$ob_PromSub = new PromSub($conn);

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
	
	/*$sql ="SELECT id_curso FROM ciclos WHERE id_ciclo=".$ciclo;
	$rs_curso = pg_exec($conn,$sql);
	$curso = pg_result($rs_curso,0);*/
	
	/***************** PERIODO *****************************/
	$sql ="SELECT nombre_periodo FROM periodo WHERE id_periodo=".$cmbPERIODO." ORDER BY id_periodo ASC";
	$rs_perido = pg_exec($conn,$sql);
	$periodo = pg_result($rs_perido,0);
	
	
	//-------------------------	 CONFIGURACION DE REPORTE ------------------
	$ob_config = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=$curso;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	@$fila_config = pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);
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
		   echo "<img src='".$d."tmp/".$fila_foto['rdb']."insignia". "' >";
	  }else{
		   echo "<img src='".$d."menu/imag/logo.gif' >";
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
    <td class="tableindex"><div align="center">PROMEDIOS POR SUBSECTOR</div></td>
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
    <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>PERIODO</strong></font></div></td>
    <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>:</strong></font></div></td>
    <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><?=$periodo;?></font></div></td>
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
    <td class="item">PROMEDIO</td>
  </tr>
  
  <? 	
  		/*$ob_reporte->nro_ano=$nro_ano;
  		$ob_reporte->ciclo=$ciclo;
		$ob_reporte->ramo=$ramo;
		$rs_result =$ob_reporte->PromedioCiclo($conn);*/
		
		$rs_curso = $ob_PromSub->nombreCurso($ano);
		
		
		
		for($xx=0;$xx<pg_numrows($rs_curso);$xx++){
			$fila_cu = pg_fetch_array($rs_curso,$xx);
			$prom_final=0;
			$prom_gral=0;
			$contador=0;
	?>
  <tr>
    <td class="subitem">&nbsp;<?=$fila_cu['cursos'].'-'.$fila_cu['id_curso'];?></td>
    <? 
	//$id_periodo,$id_ramo,$id_curso;
	//$ob_PromSub->detallado($cmbPERIODO,$fila_cu['id_curso']);
	
	for($x=0;$x<pg_numrows($rs_perido);$x++){
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
			}
	?>
    <td class="subitem" align="center">&nbsp;<?=$promedio;?></td>
    <? $prom_final = $prom_final + $promedio;
	} 
		$prom_gral = round($prom_final / $contador,0);
	?>

  </tr>
  <? } ?>
</table>
<br />
<table width="650" border="0" align="center">
  <tr>
    <?  
			if($ob_config->firma1!=0){
				$ob_reporte->cargo=$ob_config->firma1;
				$ob_reporte->curso=$curso;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->empleado=$ob_config->empleado1;
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
    <td width="25%" class="item" height="100"><div style="width:100; height:50;"></div>
      <hr align="center" width="150" color="#000000" />
      <div align="center">
        <?=$ob_reporte->nombre_emp;?>
        <br />
        <?=$ob_reporte->nombre_cargo;?>
      </div></td>
    <? }} ?>
    <? if($ob_config->firma2!=0){
				$ob_reporte->cargo=$ob_config->firma2;
				$ob_reporte->curso=$curso;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->empleado=$ob_config->empleado2;
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
    <td width="25%" class="item"><div style="width:100; height:50;"></div>
      <hr align="center" width="150" color="#000000" />
      <div align="center">
        <?=$ob_reporte->nombre_emp;?>
        <br />
        <?=$ob_reporte->nombre_cargo;?>
      </div></td>
    <? }} ?>
    <? if($ob_config->firma3!=0){
		  		$ob_reporte->cargo=$ob_config->firma3;
				$ob_reporte->empleado=$ob_config->empleado3;
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
    <td width="25%" class="item"><div style="width:100; height:50;"></div>
      <hr align="center" width="150" color="#000000" />
      <div align="center">
        <?=$ob_reporte->nombre_emp;?>
        <br />
        <?=$ob_reporte->nombre_cargo;?>
      </div></td>
    <? }} ?>
    <? if($ob_config->firma4!=0){
				$ob_reporte->cargo=$ob_config->firma4;
				$ob_reporte->empleado=$ob_config->empleado4;
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
    <td width="25%" class="item"><div style="width:100; height:50;"></div>
      <hr align="center" width="150" color="#000000" />
      <div align="center">
        <?=$ob_reporte->nombre_emp;?>
        <br />
        <?=$ob_reporte->nombre_cargo;?>
      </div></td>
    <? }}?>
  </tr>
</table>
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
