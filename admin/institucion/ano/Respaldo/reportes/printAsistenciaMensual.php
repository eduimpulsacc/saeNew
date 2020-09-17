<?	require('../../../../util/header.inc');
	include('../../../clases/class_MotorBusqueda.php');
	include('../../../clases/class_Membrete.php');
	include('../../../clases/class_Reporte.php');

	$institucion	=$_INSTIT	;
	$ano			=$cmbANO	;
	$mes			=$cmbMES	;
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
	$ob_reporte->nro_ano =$ob_membrete->nro_ano;
	$ob_reporte->mes = $mes;
	$rs_asis = $ob_reporte->AsistenciaCurso($conn);
	
	/*$ob_membrete -> curso =$curso;
	$ob_membrete -> curso($conn);*/
	
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
		header("Content-Disposition:inline; filename=Informe_Asistencia_Mes_Conret_$Fecha.xls"); 
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
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<style type="text/css">
<!--
.Estilo2 {font-weight: bold}
-->
</style>
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
 .fuente
 {
 font-size:10px;
 color:#000000;
 }	
.Estilo1 {
	font-size: 12px;
	font-weight: bold;
}
</style>
<body>
<div id="capa0">
<table width="650" border="0" align="center">
  <tr>
    <td width="25%"><input type="button" name="Submit" value="CERRAR" onClick="window.close()" class="botonXX"/></td>
    <td class="textosesion"><div align="center">(*)Reporte debe imprimirse de manera horizontal</div></td>
    <td width="25%"><div align="right">
      <input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR" />
    </div></td>
  </tr>
</table>
</div>
<BR /><BR />
<table width="80%" border="0" align="center" cellpadding="0" cellspacing="0">
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
<table width="80%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" class="tableindex"><div align="center">INFORME GENERAL DE ASISTENCIA MENSUAL</div></td>
  </tr>
  <tr>
    <td align="center"><span class="Estilo2"><strong><? echo trim(strtoupper("MES :".envia_mes($mes)." AÑO: ".$ob_membrete->nro_ano)) ;?></strong></span></td>
  </tr>
</table>
<br>


<table width="80%" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="25%" bgcolor="#CCCCCC" class="item">&nbsp;</td>
    <td width="5%" bgcolor="#CCCCCC" class="item">&nbsp;</td>
    <td colspan="32" bgcolor="#CCCCCC" class="item"><div align="center">D&Iacute;AS</div></td>
  </tr>
  <tr>
    <td width="28%" bgcolor="#CCCCCC" class="item">CURSOS</td>
    <td width="2%" bgcolor="#CCCCCC" class="item">MATR&Iacute;C.</td>

    <?  
	for($j=1;$j<=31;$j++){?>
    <td width="2%" bgcolor="#CCCCCC" class="item"><div align="center">
      <?=$j?>
    </div></td>
    <? }?>
    <td width="3%" bgcolor="#CCCCCC" class="item"><div align="center">TOTAL</div></td>
  </tr>
  <?
 	$ob_cursos = new Reporte();
	$ob_cursos->ano=$ano;
	$rs_cursos = $ob_cursos->ListadoCurso($conn);
	$cant_cursos=pg_numrows($rs_cursos);
	
		
		for($i=0;$i<$cant_cursos;$i++){
		$fila_cursos = @pg_fetch_array($rs_cursos,$i);
		$cod_curso = $fila_cursos['id_curso'];
		$total_curso = 0;
		
		//$dia= dia_mes($mes,$nro_ano);
		$ob_asistencia = new Reporte();
		$ob_asistencia->ano=$ano;
		$ob_asistencia->id_curso=$cod_curso;
		$ob_asistencia->fecha_fin="12-01-".$ob_membrete->nro_ano;
		$rs_matricula = $ob_asistencia->MatriculaAsistencia_curso($conn);
		$cant_matricula = @pg_result($rs_matricula,0);
		$total_mat = $total_mat + $cant_matricula;
 ?>
  <tr>
    <td width="28%" class="item fuente"><div align="left">
      <?=CursoPalabra($cod_curso,0,$conn)?></div></td>
    <td width="2%" class="subitem">&nbsp;<?=$cant_matricula;?></td>
    <?
		for($j=1;$j<=31;$j++){
			
			if($mes < 10){
				$mesF="0".$mes;
			}else{
				$mesF="0".$mes;
			}
			if($j<10){
				$dia="0".$j;
			}
			$fecha = $ob_membrete->nro_ano."-".$mesF."-".$dia;
			$fechaH = $mesF."-".$j."-".$ob_membrete->nro_ano;
			$fecha_f = mktime(0,0,0,$mes,$j,$ob_membrete->nro_ano);
			$dia_pal_f = strftime("%a",$fecha_f); 
			
			if(($mes==4 || $mes==6 || $mes==9 || $mes==11) and $j==31){
				$habil=0;
			}else{
				$ob_habil = new Reporte();
				$ob_habil ->ano=$ano;
				$ob_habil ->fecha=$fechaH;
				$habil = $ob_habil->DiaHabil($conn);	
			}
			if($habil==0 AND ($dia_pal_f <> "Sat" and $dia_pal_f <> "Sun" )){
				$inasis=0;
				for($x=0;$x<@pg_numrows($rs_asis);$x++){
					$fila = @pg_fetch_array($rs_asis,$x);
					if(($fecha==$fila['fecha']) and ($cod_curso==$fila['id_curso'])){
						$inasis = $fila['cont'];
						break;
					}
				}
			$asistencia = $cant_matricula - $inasis;
			$total_mes = $total_mes + $asistencia;
			$total_curso = $total_curso + $asistencia;

			if($cont<$i){
				$total_dia[$j] = $total_dia[$j] + $asistencia;
			}

			}else{
				$asistencia="&nbsp;";
			}
		
			
		?>
    <td width="2%" class="subitem"><?=$asistencia;?></td>
    <? }?>
    <td width="3%" class="subitem"><?=$total_curso;?></td>
    
  </tr>
  <? }?>
  <tr>
    <td width="28%" class="item"><div align="left" class="Estilo1"><font style="font-size:10px">TOTAL</font></div></td>
    <td width="2%"  class="subitem"><div align="center"><font style="font-size:10px">&nbsp;<?=$total_mat;?></font></div></td>
    <? 
		
	?>
    <? for($j=1;$j<=31;$j++){?>
    <td width="2%" class="subitem"><div align="center"><strong><font style="font-size:10px">&nbsp;<?=$total_dia[$j];?></font></strong></div></td>
    <? }?>
    <td width="3%" class="subitem"><div align="center"><strong><font style="font-size:10px">&nbsp;<?=$total_mes;?></font> </strong> </div></td>
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
