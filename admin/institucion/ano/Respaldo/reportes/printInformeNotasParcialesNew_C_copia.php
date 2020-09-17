<?
	require('../../../../util/header.inc');
	include('../../../clases/class_Reporte.php');
	include('../../../clases/class_Membrete.php');

	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$c_curso;
	$alumno		    =$c_alumno;
	$reporte		=$c_reporte;
	$periodo		=$cmb_periodos;
	$taller			=$opc_Taller;
	$estadistica	=$opc_estadistica;
	$obs			=$opc_obs;
	$tipo_rep		=$tipo_rep;
	$anotacion		=$opc_Anotacion;
	$colilla		=$opc_Colilla;
	$muestra_notas	=$Mnotas;
	
	$ob_reporte = new Reporte();
	$ob_membrete = new Membrete();
	
	/*******INSITUCION *******************/
	$ob_membrete ->institucion=$institucion;
	$ob_membrete ->institucion($conn);
	
		 
	/********** AÑO ESCOLAR*****************/
	$ob_membrete ->ano = $ano;
	$ob_membrete ->AnoEscolar($conn);
	$nro_ano = $ob_membrete->nro_ano;
	
	/****************DATOS PERIODO************/
	$ob_reporte ->ano=$ano;
	$ob_reporte ->periodo=$periodo;
	$ob_reporte ->Periodo($conn);
	$periodo_pal = $ob_reporte->nombre_periodo . " DEL " . $nro_ano;
	$result1 = $ob_reporte->result;
	$dias_habiles = $ob_reporte->dias_habiles;
	$fecha_ini = $ob_reporte->fecha_inicio;
	$fecha_fin = $ob_reporte->fecha_termino;
	
	$ob_reporte ->ano = $ano; 
	$resultPeri = $ob_reporte ->TotalPeriodo($conn);
	$num_periodos = @pg_numrows($resultPeri);
	if ($num_periodos==2) $tipo_per = "SE";
	if ($num_periodos==3) $tipo_per = "TR";		
	
	/*************** PROFESOR JEFE ****************/
	$ob_reporte ->curso =$curso;
	$ob_reporte ->ProfeJefe($conn);
	
	/************** CURSO ***********************/
	$Curso_pal = CursoPalabra($curso, 0, $conn);
	
	//-------------------------	 CONFIGURACION DE REPORTE ------------------
	$ob_config = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=$curso;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);
	
			  


  

				  

	if($cb_ok!="Buscar"){
		$xls=1;
	}
		 
	if($xls==1){	 
	$fecha_actual = date('d/m/Y-H:i:s');
	header('Content-type: application/vnd.ms-excel');
	header("Content-Disposition:inline; filename=Parciales_alumno_$fecha_actual.xls"); 	 
	}


?>
<script language="javascript" type="text/javascript">
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
//-->

function cerrar(){ 
	window.close() 
} 
</script>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=latin-9" />
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<title>INFORME DE NOTAS PARCIALES</title>
<STYLE>
 H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always; height:0;line-height:0
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

<body ><!--onLoad="window.print()"-->

<?
	
	$ob_reporte ->curso = $curso;
	$ob_reporte ->ano = $ano;
	$ob_reporte ->retirado =0;
	$ob_reporte ->orden =$ck_orden;
	$result_alu =$ob_reporte ->TraeTodosAlumnos($conn);
	$cont_alumnos = @pg_numrows($result_alu);



	
	
?>
<br />
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="114" class="item"><div align="left"><strong>INSTITUCI&Oacute;N</strong></div></td>
    <td width="9" class="item"><strong>:</strong></td>
    <td width="361" class="item"><div align="left"><? echo strtoupper(trim($ob_membrete->ins_pal)) ?></div></td>
    <td width="161" rowspan="7" align="center" valign="top" >
	<?
		$result = @pg_Exec($conn,"select insignia,rdb from institucion where rdb=".$institucion);
		$arr=@pg_fetch_array($result,0);
		$fila_foto  = @pg_fetch_array($result,0);
		## c&oacute;digo para tomar la insignia
	
		  if($institucion!=""){
			   echo "<img src='../../../../tmp/".$fila_foto['rdb']."insignia". "' >";
		  }else{
			   echo "<img src='".$d."menu/imag/logo.gif' >";
		  }?>    
	</td> 	
  </tr>
  <tr>
    <td class="item"><div align="left"><strong>A&Ntilde;O ESCOLAR</strong></div></td>
    <td class="item"><strong>:</strong></td>
    <td class="item"><div align="left"><? echo trim($nro_ano) ?></div></td>
  </tr>
  <tr>
    <td class="item"><div align="left"><strong>CURSO</strong></div></td>
    <td class="item"><strong>:</strong></td>
    <td class="item"><div align="left"><? echo $Curso_pal; ?></div></td>
  </tr>
  <tr>
    <td class="item"><div align="left"><strong>SUBSECTOR</strong></div></td>
    <td class="item"><strong>:</strong></td>
    <td class="item"><div align="left">
      <? $nombre_alumno = ucwords(strtoupper(trim($fila['ape_pat']) . " " . trim($fila['ape_mat']) . " " . trim($fila['nombre_alu'])));
	  echo $ob_reporte->tildeM($nombre_alumno);  ?>
    </div></td>
  </tr>
  <tr>
    <td class="item"><div align="left"><strong>PROFESOR(A) JEFE</strong></div></td>
    <td class="item"><div align="left"><strong>:</strong></div></td>
    <td class="item"><div align="left"><?  echo $ob_reporte->tildeM($ob_reporte->profe_jefe);?></div></td>
  </tr>
  
</table>
<br />
<table width="650" border="0" align="center">
  <tr>
    <td class="tableindex"><div align="center">INFORME DE NOTAS </div></td>
  </tr>
   
      <tr>
        <td><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong><? echo ucwords(strtoupper($periodo_pal))?></strong></font></div></td>
      </tr>
  
 
</table>
<br />
<table width="650" border="1" cellspacing="0" cellpadding="0" align="center" style="border-collapse:collapse">
  <tr>
    <td class="titulo"><div align="center">Alumnos</div></td>
    <td colspan="20" class="titulo"><div align="center">Notas</div></td>
    <td width="50" class="titulo"><div align="center">Promedio</div></td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td width="50">&nbsp;</td>
  </tr>
</table>



<table width="650" border="0" cellspacing="0" cellpadding="0" align="center">
	  <tr>
		<td width="153"><font size="1" face="Arial, Helvetica, sans-serif"><strong>NOTA MAYOR  </strong></font></td>
		<td width="237">&nbsp;</td>
		<td width="172"><font size="1" face="Arial, Helvetica, sans-serif"><strong>(%)</strong></font><strong><font size="1" face="Arial, Helvetica, sans-serif"> SOBRE 60</font></strong></td>
		<td width="78">&nbsp;</td>
	  </tr>
	  <tr>
		<td><font size="1" face="Arial, Helvetica, sans-serif"><strong> NOTA MENOR </strong></font></td>
		<td>&nbsp;</td>
		<td><font size="1" face="Arial, Helvetica, sans-serif"><strong> (%) BAJO 40 </strong></font></td>
		<td><font size="1" face="Arial, Helvetica, sans-serif"><br>
		</font></td>
	  </tr>
</table>
	
<table width="650" border="0" align="center">
<tr>
<?  
	for($mm=1;$mm<$txtESPACIO;$mm++){
		echo "<br>";
	}
if($ob_config->firma1!=0){
	$ob_reporte->cargo=$ob_config->firma1;
	$ob_reporte->rdb=$institucion;
	$ob_reporte->empleado=$ob_config->empleado1;
	$ob_reporte->curso=$curso;
	$ob_reporte->Firmas($conn);?>
	<td width="25%" class="item" height="100"><div align="center">________________________________
	<br>       
	  <?=$ob_reporte->nombre_emp;?>
	  <br>
	  <?=$ob_reporte->nombre_cargo;?>
	</div></td>
<? } ?>
<? if($ob_config->firma2!=0){
	$ob_reporte->cargo=$ob_config->firma2;
	$ob_reporte->empleado=$ob_config->empleado2;
	$ob_reporte->curso=$curso;
	$ob_reporte->rdb=$institucion;
	$ob_reporte->Firmas($conn);?>
<td width="25%" class="item"> <div align="center">________________________________
<br>
<?=$ob_reporte->nombre_emp;?>
<br>
<?=$ob_reporte->nombre_cargo;?>
</div></td>
<? } ?>
<? if($ob_config->firma3!=0){
	$ob_reporte->cargo=$ob_config->firma3;
	$ob_reporte->empleado=$ob_config->empleado3;
	$ob_reporte->curso=$curso;
	$ob_reporte->rdb=$institucion;
	$ob_reporte->Firmas($conn);?>
<td width="25%" class="item"><div align="center">________________________________
<br>
<?=$ob_reporte->nombre_emp;?>
<br>
<?=$ob_reporte->nombre_cargo;?>
</div></td>
<? } ?>
<? if($ob_config->firma4!=0){
	$ob_reporte->cargo=$ob_config->firma4;
	$ob_reporte->empleado=$ob_config->empleado4;
	$ob_reporte->curso=$curso;
	$ob_reporte->rdb=$institucion;
	$ob_reporte->Firmas($conn);?>
<td width="25%" class="item"> <div align="center">________________________________
<br>
<?=$ob_reporte->nombre_emp;?>
<br>
<?=$ob_reporte->nombre_cargo;?>
</div></td>
<? }?>
</tr>
</table> 

<table width="650" align="center">
	<tr>
	<td>
   <? $fecha = $txtFECHA;?>
	  <font face="Verdana, Arial, Helvetica, sans-seri" size="-1"><? echo ucwords(strtolower($ob_membrete->comuna)).", ". fecha_espanol($fecha) ?></font>
	</td>
	</tr>
</table>
</body>
</html>
