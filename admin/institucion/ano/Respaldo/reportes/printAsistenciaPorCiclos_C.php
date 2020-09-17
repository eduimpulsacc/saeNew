<?	require('../../../../util/header.inc');
	include('../../../clases/class_MotorBusqueda.php');
	include('../../../clases/class_Membrete.php');
	include('../../../clases/class_Reporte.php');

	$institucion	=$_INSTIT	;
	$ano			=$_ANO		;
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
	$rs_asis = $ob_reporte->AsistenciaAno($conn);
	
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
    <td align="center" class="tableindex"><div align="center">INFORME TOTAL DE UN ESTABLECIMIENTOS POR CICLOS </div></td>
  </tr>
  <tr>
    <td align="center"><span class="Estilo2"><strong><? echo trim(strtoupper("AÑO ".$ob_membrete->nro_ano)) ;?></strong></span></td>
  </tr>
</table>
<br>
<table width="100%" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td width="8%" bgcolor="#CCCCCC" class="titulo">&nbsp;</td>
    <td colspan="10" bgcolor="#CCCCCC" class="titulo"><div align="center">MESES</div></td>
    <td width="10%" bgcolor="#CCCCCC" class="titulo">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#CCCCCC" class="titulo">CICLOS</td>
    <td width="4" bgcolor="#CCCCCC" class="titulo">MARZO</td>
    <td width="4" bgcolor="#CCCCCC" class="titulo">ABRIL</td>
    <td width="4" bgcolor="#CCCCCC" class="titulo">MAYO</td>
    <td width="4" bgcolor="#CCCCCC" class="titulo">JUNIO</td>
    <td width="4" bgcolor="#CCCCCC" class="titulo">JULIO</td>
    <td width="4" bgcolor="#CCCCCC" class="titulo">AGOSTO</td>
    <td width="4" bgcolor="#CCCCCC" class="titulo">SEPT</td>
    <td width="4" bgcolor="#CCCCCC" class="titulo">OCT.</td>
    <td width="4" bgcolor="#CCCCCC" class="titulo">NOV.</td>
    <td bgcolor="#CCCCCC" class="titulo">DIC.</td>
    <td bgcolor="#CCCCCC" class="titulo">TOTAL</td>
  </tr>
  <?
  	$total_mat =0; 
	$cont=2;
  	for($i=3;$i<13;$i++){ 
  		$dia= dia_mes($i,$nro_ano);
		$fecha_ini = $i."-01-".$ob_membrete->nro_ano;
		$fecha_fin = $i."-".$dia."-".$ob_membrete->nro_ano;
		$ob_reporte ->ano=$ano;
		$ob_reporte ->fecha_ini=$fecha_ini;
		$ob_reporte ->fecha_fin=$fecha_fin;
		$result = $ob_reporte->MatriculaAsistencia($conn);
		$cont_matricula = @pg_result($result,0);		
		$total_mat=$total_mat+$cont_matricula;
  		?>
  
  <tr>
    <td class="item"><? echo envia_mes($i);?></td>
    <? 	$total_mes=0;
		for($j=1;$j<=12;$j++){
			$fecha = $i."-".$j."-".$ob_membrete->nro_ano;
			$fecha_f = mktime(0,0,0,$i,$j,$ob_membrete->nro_ano);
			$dia_pal_f = strftime("%a",$fecha_f);
			if($j<=$dia and ($dia_pal_f <> "Sat" and $dia_pal_f <> "Sun" )){
				for($x=0;$x<@pg_numrows($rs_asis);$x++){
					$fila = @pg_fetch_array($rs_asis,$x);
					if($fecha==$fila['fecha']){
						$inasis = $fila['cont'];
						break;
					}
				}
			$asistencia = $cont_matricula - $inasis;
			$total_mes = $total_mes + $asistencia;

			if($cont<$i){
				$total_dia[$j] = $total_dia[$j] + $asistencia;
			}

			}else{
				$asistencia="&nbsp;";
			}
	?>
		<td class="subitem"><div align="right"><font style="font-size:10px"><? echo trim($asistencia);?></font></div></td>

	<?  } ?>
			<td class="subitem"><div align="right"><font style="font-size:10px">
		    <?=number_format($total_mes,'0',',','.');?>
		    </font></div></td>		
  </tr>
  <? } ?>
  <tr>
    <td bgcolor="#CCCCCC" class="item">TOTAL</td>
    <? for($j=1;$j<=31;$j++){?>
	    <td  bgcolor="#CCCCCC" class="subitem"><div align="right"><font style="font-size:10px">
        <?=number_format($total_dia[$j],'0',',','.');?>
        </font></div></td>
	<? $total_gral = $total_gral + $total_dia[$j];
	} ?>
    <td bgcolor="#CCCCCC" class="subitem"><div align="right"><font style="font-size:10px">
      <?=number_format($total_gral,'0',',','.');?>
    </font></div></td>
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
