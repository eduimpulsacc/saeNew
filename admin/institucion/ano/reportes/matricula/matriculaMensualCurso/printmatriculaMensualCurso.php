<?	
    require('../../../../../../util/header.inc');
	include('../../../../../clases/class_MotorBusqueda.php');
	include('../../../../../clases/class_Membrete.php');
	include('../../../../../clases/class_Reporte.php');

	$institucion	=$_INSTIT	;
	$ano			=$cmbANO	;
	$mes			=$cmbMES	;
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
	//$rs_asis = $ob_reporte->AsistenciaCurso($conn);
	
	$nro_ano = $ob_reporte->nro_ano;
	
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
	
	
	switch ($mes){
		
		
		case 1:
	 
		
			$fecha_inicio =$nro_ano."-"."0".$mes."-"."01";
			$fecha_termino=$nro_ano."-"."0".$mes."-"."01";
			$dias=31;
			break;
		case 2:
			$fecha_inicio =$nro_ano."-"."0".$mes."-"."01";
			$fecha_termino=$nro_ano."-"."0".$mes."-"."28";
			
			if($nro_ano%4==0)
			$dias=29;
			else
			$dias=28;
			break;
		case 3:
			$fecha_inicio =$nro_ano."-"."0".$mes."-"."01";
			$fecha_termino=$nro_ano."-"."0".$mes."-"."31";
			$dias=31;
			break;
		case 4:
			$fecha_inicio =$nro_ano."-"."0".$mes."-"."01";
			$fecha_termino=$nro_ano."-"."0".$mes."-"."30";
			$dias=30;
			break;
		case 5:
			$fecha_inicio =$nro_ano."-"."0".$mes."-"."01";
			$fecha_termino=$nro_ano."-"."0".$mes."-"."31";
			$dias=31;
			break;
		case 6:
			$fecha_inicio =$nro_ano."-"."0".$mes."-"."01";
			$fecha_termino=$nro_ano."-"."0".$mes."-"."30";
			$dias=30;
			break;
		case 7:
			$fecha_inicio =$nro_ano."-"."0".$mes."-"."01";
			$fecha_termino=$nro_ano."-"."0".$mes."-"."31";
			$dias=31;
			break;
		case 8:
			$fecha_inicio =$nro_ano."-"."0".$mes."-"."01";
			$fecha_termino=$nro_ano."-"."0".$mes."-"."31";
			$dias=31;
			break;
		case 9:
			$fecha_inicio =$nro_ano."-"."0".$mes."-"."01";
			$fecha_termino=$nro_ano."-"."0".$mes."-"."30";
			$dias=30;
			break;
		case 10:
			$fecha_inicio =$nro_ano."-".$mes."-"."01";
			$fecha_termino=$nro_ano."-".$mes."-"."31";
			$dias=31;
			break;
		case 11:
			$fecha_inicio =$nro_ano."-".$mes."-"."01";
			$fecha_termino=$nro_ano."-".$mes."-"."30";
			$dias=30;
			break;
		case 12:
			$fecha_inicio =$nro_ano."-".$mes."-"."01";
			$fecha_termino=$nro_ano."-".$mes."-"."31";
			//$fecha_termino=$nro_ano."-".$mes."-".$dia_final;
			$dias=31;
			break;
		}
		

	 $sqlFer="select id_feriado, date_part('day', feriado.fecha_inicio) AS dia_ini, date_part('month',feriado.fecha_inicio) AS mes_ini, date_part('year',feriado.fecha_inicio) AS ano_ini, date_part('day', feriado.fecha_fin) AS dia_fin, date_part('month',feriado.fecha_fin) AS mes_fin, date_part('year',feriado.fecha_fin) AS ano_fin from feriado where date_part('month',feriado.fecha_inicio)=".trim($mes)." and id_ano=".$ano." order by dia_ini";
			
			$resultFer=@pg_Exec($conn,$sqlFer) or die("error sql=".$sqlFer);
		
			
	/*for($i=1;$i<=$dias;$i++){
		
		$filaFer=@pg_fetch_array($resultFer,$p);
		
		$fini[$filaFer["dia_ini"]]=$filaFer["dia_ini"];
		$fter[$filaFer["dia_fin"]]=$filaFer["dia_fin"];
		
		
	 }*/
	 
	 for($f=0;$f<pg_numrows($resultFer);$f++){
		$filaFer=@pg_fetch_array($resultFer,$f); 
		
		$fila_inicio = $filaFer["ano_ini"]."-".$filaFer["mes_ini"]."-".$filaFer["dia_ini"];
		$fila_termino = $filaFer["ano_fin"]."-".$filaFer["mes_fin"]."-".$filaFer["dia_fin"];
		
		//$dff= ddiff($fila_inicio, $fila_termino); 
		//echo $dff;
		for($i=$filaFer["dia_ini"];$i<=$filaFer["dia_fin"];$i++){
			//echo "<br>".$i;
			 $dd[$i] =intval($i) ;
			
		}
		
		
	}
		
		
		
	
	/*$fini=array_filter($fini, "strlen");
	$fter=array_filter($fter, "strlen");
	
	show($fini);*/
	//show($dd);	

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
			    echo "<img src='../../../../../../tmp/".$institucion."insignia". "' >";
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
    <td align="center" class="tableindex"><div align="center">INFORME  DE MATR&Iacute;CULA MENSUAL</div></td>
  </tr>
  <tr>
    <td align="center"><span class="Estilo2"><strong><? echo trim(strtoupper("MES :".envia_mes($mes)." AÑO: ".$ob_membrete->nro_ano)) ;?></strong></span></td>
  </tr>
</table>
<br>


<table width="80%" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr class="textonegrita">
    <td width="25%" bgcolor="#CCCCCC" class="item">&nbsp;</td>
    <td colspan="<?php echo ($dias)+2 ?>" bgcolor="#CCCCCC" class="item"><div align="center">D&Iacute;AS</div></td>
  </tr>
  <tr class="textonegrita">
    <td width="28%" bgcolor="#CCCCCC" class="item">CURSOS</td>
    <?  
	for($j=1;$j<=$dias;$j++){?>
    <td width="2%" bgcolor="#CCCCCC" class="item"><div align="center">
      <?=$j?>
    </div></td>
    <? }?>
    <td width="3%" bgcolor="#CCCCCC" class="item"><div align="center">TOTAL</div></td>
    <td width="3%" bgcolor="#CCCCCC" class="item">%</td>
  </tr>
  <?
 	$ob_cursos = new Reporte();//
	$ob_cursos->ano=$ano;
	$rs_cursos = $ob_cursos->ListadoCurso($conn);
	$cant_cursos=pg_numrows($rs_cursos);
	
		
		for($i=0;$i<$cant_cursos;$i++){
		$fila_cursos = @pg_fetch_array($rs_cursos,$i);
		$cod_curso = $fila_cursos['id_curso'];
		$total_curso = 0;
		$cuendia=0;
		
		
		$ob_asistencia = new Reporte();
		$ob_asistencia->ano=$ano;
		$ob_asistencia->id_curso=$cod_curso;
		
		
		
		
 ?>
  <tr class="item fuente">
    <td width="28%" class="item fuente"><div align="left">
      <?=CursoPalabra($cod_curso,0,$conn)?></div></td>
    <?
		for($j=1;$j<=$dias;$j++){
			//$total_dia[$j]=0;
			
			
			
			if($mes < 10){
				$mesF="0".$mes;
			}else{
				$mesF=$mes;
			}
			if($j<10){
				$dia="0".$j;
			}else{
				$dia=$j;
			}
			$fecha = $ob_membrete->nro_ano."-".trim($mesF)."-".$dia;
						
			$ob_reporte->id_curso = $cod_curso;
			$ob_reporte->fecha = $fecha;
			$ob_reporte->ano = $cmbANO;
		
		$color="bgcolor=#ffffff";
		
		if(EsSabadoDomingo($fecha)){
			
			$asistencia=0;
			$color="bgcolor=#cccccc";
			$calfecha="";
			}
		
	
		elseif(($j>=$dd[$j]) && ($j<=$dd[$j]))
			{
			$color="bgcolor=#cccccc";
			$asistencia=0;
			$ff=1;
			$calfecha="";
			}
			
		else{
				$ff=0;
				$color="bgcolor=#ffffff";
				$ccat=0;
				$ccrt=0;
				$calfecha=0;
				
				/*$asistencia=$cant_matricula-$inasis;
				$total_curso= $total_curso+$asistencia;
				$total_dia[$j]=$total_dia[$j]+$asistencia;*/
				//$ob_reporte->retirado=0;
				
				//cuento todos los alumnos del curso
				$ob_reporte->curso=$cod_curso;
				$ob_reporte->ano=$ano;
				
				$ob_reporte->fecha=$fecha;
				$ob_reporte->fechar="";
				$ob_reporte->retirado="";
				$cact = $ob_reporte->TraeContelAlsCurso($conn);
				$ccat = pg_numrows($cact);
				$act[$i]=$act[$i]+$ccat;
				//$cuendia++;
				
				//contar los retirados
				
				$ob_reporte->retirado=1;
				$ob_reporte->fecha="";
				$ob_reporte->fechar=$fecha;
				$cret = $ob_reporte->TraeContelAlsCurso($conn);
				$ccrt = pg_numrows($cret);
				
				$calfecha=$ccat-$ccrt; 
				
				$total_curso= $total_curso+$calfecha;
				
				$total_dia[$j]=$total_dia[$j]+$calfecha;
				$cuendia++;
			}
		
		?>
    <td width="2%" align="center" class="subitem" <?php echo $color ?>><?php echo $calfecha ?></td>
    <? }?>
    <td width="3%" align="center" class="subitem"><?=$total_curso;?></td>
    <td width="3%" align="center" class="subitem">
	<?php
	$pcc= ($total_curso*100)/$act[$i];
	 echo number_format($pcc,1,",",".");
	 $tpc=$tpc+$pcc;
	  ?>%	</td>
    
  </tr>
  <? }?>
  <tr>
    <td width="28%" class="item"><div align="left" class="Estilo1"><font style="font-size:10px">TOTAL</font></div></td>
    <? 
		
	?>
    
    <? for($j=1;$j<=$dias;$j++){
		if($mes < 10){
				$mesF="0".$mes;
			}else{
				$mesF=$mes;
			}
			if($j<10){
				$dia="0".$j;
			}else{
				$dia=$j;
			}
			$fecha = $ob_membrete->nro_ano."-".trim($mesF)."-".$dia;
			
			$total_mes= $total_mes+$total_dia[$j];
		?>
    <td width="2%" align="center" class="subitem" <?php echo ($total_dia[$j]==0)?"bgcolor=#cccccc":"" ?>><div align="center"><strong><font style="font-size:10px">
      <?=$total_dia[$j];?>
    </font></strong></div></td>
    <? }?>
    <td width="3%" align="center" class="subitem"><div align="center"><strong><font style="font-size:10px">
      <?=$total_mes;?>
    </font></strong></div></td>
    <td width="3%" align="center" class="subitem"><div align="center"><strong><font style="font-size:10px"><?php echo number_format($tpc/$cant_cursos,1,",","."); ?>%</font></strong></div></td>
  </tr>
</table>
<br />
<br />
 <?php  
		 $ruta_timbre =6;
		 $ruta_firma =4;
		 include("../../firmas/firmas.php");?>
</body>
</html>
