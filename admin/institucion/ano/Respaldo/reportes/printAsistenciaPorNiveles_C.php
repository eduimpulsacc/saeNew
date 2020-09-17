<?	require('../../../../util/header.inc');
	include('../../../clases/class_MotorBusqueda.php');
	include('../../../clases/class_Membrete.php');
	include('../../../clases/class_Reporte.php');

	$institucion	=$_INSTIT	;
	//$ano			=$_ANO		;
	$ano			=$c_ano	;
	$curso			=$c_curso	;
	$alumno			=$c_alumno	;
	$reporte		=$c_reporte;
	$_POSP = 4;
	$_bot = 8;
	
	$ob_membrete = new Membrete();
	$ob_reporte = new Reporte();
	
	$ob_membrete ->institucion = $institucion;
	$ob_membrete ->institucion($conn);
	
	$ob_membrete ->ano =$ano;
	$ob_membrete ->AnoEscolar($conn);
	
	$ob_reporte->ano=$ano;
	$rs_matricula = $ob_reporte->MatriculaNivel($conn);
	
	$rs_asistencia = $ob_reporte->AsistenciaNivel($conn);
	for($i=3;$i<=12;$i++){
		$fila = @pg_fetch_array($rs_asistencia,$i);
		
	}
	
	$ob_niveles = new Reporte();
	$ob_niveles -> ano=$ano;
	$rs_nivel = $ob_niveles->Niveles($conn);
	
	
	
	//-------------------------	 CONFIGURACION DE REPORTE ------------------
	$ob_config = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=1;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = @pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);
	
	if(!$cb_ok =="Buscar"){
		$Fecha= date("d-m-Y_h:i");
		header('Content-type: application/vnd.ms-excel');
		header("Content-Disposition:inline; filename=AsistenciaPorNiveles_$Fecha.xls"); 
	}	
?>
<script>
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
</script>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<title>COLEGIOINTERACTIVO.COM</title>
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
<table width="650" border="0" align="center">
  <tr>
    <td><input type="button" name="Submit" value="CERRAR" onClick="window.close()" class="botonXX"/></td>
    <td><div align="right">
      <input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR">
    </div></td>
  </tr>
</table>
</div>
<BR /><BR />
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
   <tr>
    <td width="697"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong><? echo ucwords(strtoupper($ob_membrete->ins_pal));?></strong></font></td>
    <td width="10">&nbsp;</td>
    <td width="125" rowspan="4" align="center">
		<table width="125" border="0" cellpadding="0" cellspacing="0">
          <tr valign="top">
            <td width="125" align="center">
   <? if ($institucion=="770"){ 
		  
			   
	 }else{ 
	 	  
			if($institucion!=""){
			    echo "<img src='".$d."tmp/".$institucion."insignia". "' >";
		    }else{
			    echo "<img src='".$d."menu/imag/logo.gif' >";
		    }?>
	  
   <? } ?>  
	  
	  
	  	</td>
		</tr>
      </table>
	</td>
  </tr>
  <tr>
    <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo ucwords(strtolower($ob_membrete->direccion));?></font></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1">Fono: &nbsp;<? echo ucwords(strtolower($ob_membrete->telefono));?></font></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
            <td height="41" valign="top">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>  
</table>
<br>	
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" class="tableindex"><div align="center">INFORME TOTAL DE UN ESTABLECIMIENTOS POR NIVELES </div></td>
  </tr>
  <tr>
    <td align="center"><span class="Estilo2"><strong><? echo trim(strtoupper("AÑO ".$ob_membrete->nro_ano)) ;?></strong></span></td>
  </tr>
</table>
<br>
<table width="80%" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td bgcolor="#CCCCCC" class="titulo">&nbsp;</td>
    <td colspan="10" bgcolor="#CCCCCC" class="titulo"><div align="center">MESES</div></td>
    <td  bgcolor="#CCCCCC" class="titulo">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#CCCCCC" class="titulo">NIVELES</td>
    <td width="4" bgcolor="#CCCCCC" class="titulo">MARZO</td>
    <td width="4" bgcolor="#CCCCCC" class="titulo">ABRIL</td>
    <td width="4" bgcolor="#CCCCCC" class="titulo">MAYO</td>
    <td width="4" bgcolor="#CCCCCC" class="titulo">JUNIO</td>
    <td width="4" bgcolor="#CCCCCC" class="titulo">JULIO</td>
    <td width="4" bgcolor="#CCCCCC" class="titulo">AGOSTO</td>
    <td width="4" bgcolor="#CCCCCC" class="titulo">SEPT</td>
    <td width="4" bgcolor="#CCCCCC" class="titulo">OCT.</td>
    <td width="4" bgcolor="#CCCCCC" class="titulo">NOV.</td>
    <td width="4" bgcolor="#CCCCCC" class="titulo">DIC.</td>
    <td bgcolor="#CCCCCC" class="titulo">TOTAL</td>
  </tr>
  <? for($i=0;$i<@pg_numrows($rs_nivel);$i++){
  		$fila_nivel = @pg_fetch_array($rs_nivel,$i);
		
	?>
  <tr>
    <td class="titulo">&nbsp;<?=$fila_nivel['nivel_grado'];?></td>
	<? for($j=3;$j<=12;$j++){
		
			for($x=0;$x<@pg_numrows($rs_matricula);$x++){
				$fila_mat = @pg_fetch_array($rs_matricula,$x);
				if($fila_nivel['nivel_grado']==$fila_mat['nivel_grado']){
					$matricula = $fila_mat['total'];
					break;
				}
			}
	
	?>
    <td class="titulo">&nbsp;<?=$matricula;?></td>
	
    <? } ?>
	<td class="titulo">&nbsp;</td>
  </tr>
  <? } // FIN FOR NIVEL ?>
  <tr>
    <td bgcolor="#CCCCCC" class="titulo">TOTAL</td>
    <? for($j=3;$j<=12;$j++){
	
	?>
    <td class="titulo">&nbsp;</td>
	
    <? } ?>
	<td class="titulo">&nbsp;</td>
  </tr>

</table>
<br />
<br />
<table width="650" border="0" align="center">
  <tr>
  		  <? if(!$cb_ok=="Buscar"){?>
		  <td>&nbsp;</td>
		  <? }?>
    <?  
			if($ob_config->firma1!=0){
				$ob_reporte->cargo=$ob_config->firma1;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);?>
    <td width="25%" class="item" height="100"><hr align="center" width="150" color="#000000">
        <div align="center">
          <?=$ob_reporte->nombre_emp;?>
          <br>
          <?=$ob_reporte->nombre_cargo;?>
        </div></td>
    <? } ?>
    <? if($ob_config->firma2!=0){
				$ob_reporte->cargo=$ob_config->firma2;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);?>
    <td width="25%" class="item"><hr align="center" width="150" color="#000000">
        <div align="center">
          <?=$ob_reporte->nombre_emp;?>
          <br>
          <?=$ob_reporte->nombre_cargo;?>
        </div></td>
    <? } ?>
    <? if($ob_config->firma3!=0){
		  		$ob_reporte->cargo=$ob_config->firma3;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);?>
    <td width="25%" class="item"><hr align="center" width="150" color="#000000">
        <div align="center">
          <?=$ob_reporte->nombre_emp;?>
          <br>
          <?=$ob_reporte->nombre_cargo;?>
        </div></td>
    <? } ?>
    <? if($ob_config->firma4!=0){
				$ob_reporte->cargo=$ob_config->firma4;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);?>
    <td width="25%" class="item"><hr align="center" width="150" color="#000000">
        <div align="center">
          <?=$ob_reporte->nombre_emp;?>
          <br>
          <?=$ob_reporte->nombre_cargo;?>
      </div></td>
    <? }?>
  </tr>
</table>
</body>
</html>
