<?	require('../../../../util/header.inc');
	include('../../../clases/class_MotorBusqueda.php');
	include('../../../clases/class_Membrete.php');
	include('../../../clases/class_Reporte.php');

	$institucion	=$_INSTIT	;
	$ano			=$c_ano		;
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
	
	$ob_alumno = new Reporte();
	$ob_alumno->ano = $ano;
	$ob_alumno->alumno = $alumno;
	$ob_alumno->curso = $curso;
	$rs_alumno = $ob_alumno->TraeUnAlumno($conn);
	$fila_alu = @pg_fetch_array($rs_alumno,0);
	$nombre_alumno = $fila_alu['nombre_alu']." ".$fila_alu['ape_pat']." ".$fila_alu['ape_mat'];
	
	$ob_reporte->ano=$ano;
	$ob_reporte->alumno=$alumno;
	$ob_reporte->curso=$curso;
	$rs_inasis = $ob_reporte->AsistenciaAlumno($conn);
	
	
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
		header("Content-Disposition:inline; filename=AsistenciaAlumno_$Fecha.xls"); 
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
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
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
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" class="tableindex"><div align="center">TOTAL DE ASISTENCIA DE UN ALUMNO  </div></td>
  </tr>
  <tr>
    <td align="center"><span class="Estilo2"><strong><? echo trim(strtoupper("AÑO ".$ob_membrete->nro_ano)) ;?></strong></span></td>
  </tr>
</table>
<table width="650" border="0" align="center" cellpadding="0" cellspacing="3">
  <tr>
    <td width="7%" class="item"><strong>Alumno</strong></td>
    <td width="1%"><strong>:</strong></td>
    <td width="92%" class="subitem">&nbsp;<?=$ob_reporte->tilde($nombre_alumno);?></td>
  </tr>
  <tr>
    <td class="item"><strong>Curso</strong></td>
    <td><strong>:</strong></td>
    <td class="subitem">&nbsp;<?=CursoPalabra($curso,0,$conn)?></td>
  </tr>
</table>
<br>
<table width="650" border="1" align="center" cellpadding="3" cellspacing="0">
 
 
  <tr>
    <td width="10%" rowspan="2" class="item">&nbsp;
    <div align="center">Meses</div></td>
    <td colspan="31" class="item"><div align="center">DIAS</div></td>
    <td rowspan="2" class="item"><div align="center">Total</div></td>
  </tr>
  <tr>
    <? for($i=1;$i<32;$i++){?>
	<td width="2%" class="item"><?=$i?></td>
    <? }?>
	
	
  </tr>
 
 <? for($j=3;$j<13;$j++){
 	$total=0;?>
  <tr>
    <td class="subitem"><?=envia_mes($j)?></td>
    <? for($i=1;$i<32;$i++){ 
		if($j<10){
			$mes = "0".$j;
		}else{
			$mes=$j;
		}
		if($i<10){
			$dia="0".$i;
		}else{
			$dia=$i;
		}
		$fecha = $ob_membrete->nro_ano."-".$mes."-".$dia;
		$fechaH = $mes."-".$dia."-".$ob_membrete->nro_ano;
		$fecha_f = mktime(0,0,0,$mes,$dia,$ob_membrete->nro_ano);
		$dia_pal_f = strftime("%a",$fecha_f); 
			
		if(($mes=="04" || $mes=="06" || $mes=="09" || $mes=="11") and $dia==31){
			$habil=0;
		}else{
			$ob_habil = new Reporte();
			$ob_habil ->ano=$ano;
			$ob_habil ->fecha=$fechaH;
			$habil = $ob_habil->DiaHabil($conn);	
		}
		
		if($habil==0 AND ($dia_pal_f <> "Sat" and $dia_pal_f <> "Sun" )){
			$color="bgcolor=#FFFFFF";
			for($x=0;$x<@pg_numrows($rs_inasis);$x++){
				$fila_ina = @pg_fetch_array($rs_inasis,$x);
				if($fila_ina['fecha']==$fecha){
					$asistencia="X";
					break;
				}else{
					$asistencia="º";
				}
			}			
		}else{
			$color ="bgcolor=#999999";
			$asistencia="";
		}
		if($asistencia=="º"){
			$total++;
		}
	?>
    <td width="2%" align="center" class="subitem" <?=$color;?>>&nbsp;<?=$asistencia;?></td>
	<? } ?>
   	<td width="4%" class="subitem">
   	  <div align="center">
   	    <?=$total;?>
      </div></td>
  </tr>
  <? }?>
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
