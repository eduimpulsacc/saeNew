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
	$rs_mat = $ob_reporte->MatriculaCiclos($conn);
	
	$ob_reporte->ano=$ano;
	$rs_asis = $ob_reporte->AsistenciaCiclos($conn);
	
	
	
	//-------------------------	 CONFIGURACION DE REPORTE ------------------
	$ob_config = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=1;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = @pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);
	
	/*if(!$cb_ok =="Buscar"){
		$Fecha= date("d-m-Y_h:i");
		header('Content-type: application/vnd.ms-excel');
		header("Content-Disposition:inline; filename=Informe_Asistencia_Mes_Conret_$Fecha.xls"); 
	}	*/
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
.Estilo1 {	font-size: 12px;
	font-weight: bold;
}
.fuente { font-size:10px;
 color:#000000;
}
.item { font-family:<?=$ob_config->letraI;?>;
 font-size:<?=$ob_config->tamanoI;?>px;
}
.subitem { font-family:<?=$ob_config->letraS;?>;
 font-size:<?=$ob_config->tamanoS;?>px;
}
-->
</style>
</head>

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
</div><br />
<table width="80%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="697"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong><? echo ucwords(strtoupper($ob_membrete->ins_pal));?></strong></font></td>
    <td width="10">&nbsp;</td>
    <td width="125" rowspan="4" align="center"><table width="125" border="0" cellpadding="0" cellspacing="0">
      <tr valign="top">
        <td width="125" align="center"><? if ($institucion=="770"){ 
		  
			   
	 }else{ 
	 	  
			if($institucion!=""){
			    echo "<img src='".$d."tmp/".$institucion."insignia". "' >";
		    }else{
			    echo "<img src='".$d."menu/imag/logo.gif' >";
		    }?>
              <? } ?>
        </td>
      </tr>
    </table></td>
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

<br />
<table width="80%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" class="tableindex"><div align="center">INFORME GENERAL DE ASISTENCIA MENSUAL</div></td>
  </tr>
  <tr>
    <td align="center"><span class="Estilo2"><strong><? echo trim(strtoupper(" AÑO: ".$ob_membrete->nro_ano)) ;?></strong></span></td>
  </tr>
</table>
<br />
<table width="80%" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="25%" bgcolor="#CCCCCC" class="item">&nbsp;</td>
    <td width="5%" bgcolor="#CCCCCC" class="item">&nbsp;</td>
    <td colspan="32" bgcolor="#CCCCCC" class="item"><div align="center">MESES</div></td>
  </tr>
  <tr>
    <td width="28%" bgcolor="#CCCCCC" class="item">CICLOS</td>
    <td width="2%" bgcolor="#CCCCCC" class="item">MATR&Iacute;C.</td>
    <? for($j=3;$j<=12;$j++){?>
    <td width="2%" bgcolor="#CCCCCC" class="item"><div align="center">
      <? echo  envia_mes($j);?>
    </div></td>
    <? }?>
    <td width="3%" bgcolor="#CCCCCC" class="item"><div align="center">TOTAL</div></td>
  </tr>
  <?
 	$ob_ciclos = new Reporte();
	$ob_ciclos->ano=$ano;
	$ob_ciclos->rdb=$institucion;
	$rs_ciclos = $ob_ciclos->Ciclos($conn);
	$cant_ciclos=pg_numrows($rs_ciclos);
	
		for($i=0;$i<$cant_ciclos;$i++){
		$fila_ciclos = pg_fetch_array($rs_ciclos,$i);
		$cod_ciclo = $fila_ciclos['id_ciclo'];
		$total_curso = 0;
		$cuenta =0;
			for($x=0;$x<@pg_numrows($rs_mat);$x++){
				$fila_mat = @pg_fetch_array($rs_mat,$x);
				if($cod_ciclo == $fila_mat['id_ciclo']){
					$matricula = $fila_mat['count'];
					$total_matricula = $total_matricula + $matricula;
				}
				
			}
 ?>
  <tr>
    <td width="28%" class="item fuente"><div align="left">
      <?=$fila_ciclos['nomb_ciclo'];?>
    </div></td>
    <td width="2%" class="subitem">
      <div align="right">
        <?=$matricula;?>&nbsp;
    </div></td>
	<? 	$total_habiles=0;
		for($j=3;$j<=12;$j++){																														
			for($z=0;$z<@pg_numrows($rs_asis);$z++){
				$fila = @pg_fetch_array($rs_asis,$z);
				if($cod_ciclo==$fila['id_ciclo'] && $j==$fila['mes']){
					$inasistencia=$fila['cuenta'];
					//break;																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																							
				}
			}
			$dia_termino =dia_mes($j,$ob_membrete->nro_ano);
			/*$dia_fin = $j."-".$dia_termino."-".$ob_membrete->nro_ano;
			$dia_inicio = "01-".$j."-".$ob_membrete->nro_ano;*/
			$dia_fin = $ob_membrete->nro_ano."-".$dia_termino."-".$j;
			$dia_inicio = $ob_membrete->nro_ano."-".$j."-"."01";
			
			for($c=1;$c<=$dia_termino;$c++){
				if($j<10){
					$mes = "0".$j;
				}else{
					$mes=$j;
				}
				if($c<10){
					$dia="0".$c;
				}else{
					$dia=$c;
				}
				$fecha = $ob_membrete->nro_ano."-".$mes."-".$dia;
				$fechaH = $ob_membrete->nro_ano."-".$mes."-".$dia;
				$fecha_f = mktime(0,0,0,$mes,$dia,$ob_membrete->nro_ano);
				$dia_pal_f = strftime("%a",$fecha_f); 
					
				if(($mes=="04" || $mes=="06" || $mes=="09" || $mes=="11") and $dia==31){
					$habil=0;
				}else{
					$ob_habil = new Reporte();
					$ob_habil ->ano=$ano;
					$ob_habil ->fecha_ini=$dia_inicio;
					$ob_habil ->fecha=$fechaH;
					$habil = $ob_habil->DiaHabil($conn);	
				}
				if($habil==0 && ($dia_pal_f <> "Sat" and $dia_pal_f <> "Sun" )){
					$total_habiles++;
				}
			}
			
			$asistencia = ($matricula * $total_habiles) - $inasistencia;
			$total_ciclo = $total_ciclo + $asistencia;
			
			$total_mes[$j] = $total_mes[$j] + $asistencia;
	?>
    <td width="2%" class="subitem">
      <div align="right">
        <?=number_format($asistencia,'0',',','.');?>&nbsp;
    </div></td>
	<? } ?>
    <td width="3%" class="subitem"><div align="right"><?=number_format($total_ciclo,'0',',','.');?>&nbsp;</div></td>
  </tr>
  <? 	$total_gral = $total_gral + $total_ciclo;
  }?>
  <tr>
    <td width="28%" class="item"><div align="left" class="Estilo1"><font style="font-size:10px">TOTAL</font></div></td>
    <td width="2%"  class="subitem"><div align="right"><font style="font-size:10px"><?=$total_matricula;?>&nbsp;</font></div></td>
    <? 
		
	?>
    <? for($j=3;$j<=12;$j++){?>
    <td width="2%" class="subitem"><div align="right"><strong><font style="font-size:10px"><?=number_format($total_mes[$j],'0',',','.');?>&nbsp;</font></strong></div></td>
    <? }?>
    <td width="3%" class="subitem"><div align="right"><strong><font style="font-size:10px"><?=number_format($total_gral,'0',',','.');?>&nbsp;</font> </strong> </div></td>
  </tr>
</table>
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
    <td width="25%" class="item" height="100"><hr align="center" width="150" color="#000000" />
        <div align="center">
          <?=$ob_reporte->nombre_emp;?>
          <br />
          <?=$ob_reporte->nombre_cargo;?>
      </div></td>
    <? } ?>
    <? if($ob_config->firma2!=0){
				$ob_reporte->cargo=$ob_config->firma2;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);?>
    <td width="25%" class="item"><hr align="center" width="150" color="#000000" />
        <div align="center">
          <?=$ob_reporte->nombre_emp;?>
          <br />
          <?=$ob_reporte->nombre_cargo;?>
      </div></td>
    <? } ?>
    <? if($ob_config->firma3!=0){
		  		$ob_reporte->cargo=$ob_config->firma3;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);?>
    <td width="25%" class="item"><hr align="center" width="150" color="#000000" />
        <div align="center">
          <?=$ob_reporte->nombre_emp;?>
          <br />
          <?=$ob_reporte->nombre_cargo;?>
      </div></td>
    <? } ?>
    <? if($ob_config->firma4!=0){
				$ob_reporte->cargo=$ob_config->firma4;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);?>
    <td width="25%" class="item"><hr align="center" width="150" color="#000000" />
        <div align="center">
          <?=$ob_reporte->nombre_emp;?>
          <br />
          <?=$ob_reporte->nombre_cargo;?>
      </div></td>
    <? }?>
  </tr>
</table>
</body>
</html>
