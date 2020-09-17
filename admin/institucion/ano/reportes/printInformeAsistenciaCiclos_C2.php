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
	$nro_ano = $ob_reporte->nro_ano;

	$ob_reporte->ano=$ano;
	$rs_mat = $ob_reporte->MatriculaCiclos($conn);
	
	
	
	
	
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
		$total_ciclo=0;
		$cuenta =0;
			for($x=0;$x<@pg_numrows($rs_mat);$x++){
				$fila_mat = @pg_fetch_array($rs_mat,$x);
				if($cod_ciclo == $fila_mat['id_ciclo']){
					$matricula = $fila_mat['count'];
					$total_matricula = $total_matricula + $matricula;
				}
				
			}
 ?>
  <tr class="item fuente">
    <td width="28%" class="item fuente"><div align="left">
      <?=$fila_ciclos['nomb_ciclo'];?>
    </div></td>
    <td width="2%" class="subitem">
      <div align="right">
        <?=$matricula;?>&nbsp;
    </div></td>
	<? 	$total_habiles=0;
		for($j=3;$j<=12;$j++){	
		$mes=$j;
		$m=$j;
		$fer=0;
		$diast=0;
		$asistencia=0;
		
		
		switch ($mes){
		case 1:
		
			$fecha_inicio =$nro_ano."-".$mes."-"."01";
			$fecha_termino=$nro_ano."-".$mes."-"."01";
			$dias=31;
			break;
		case 2:
			$fecha_inicio =$nro_ano."-".$mes."-"."01";
			$fecha_termino=$nro_ano."-".$mes."-"."28";
			
			if($nro_ano%4==0)
			$dias=29;
			else
			$dias=28;
			break;
		case 3:
			$fecha_inicio =$nro_ano."-".$mes."-"."01";
			$fecha_termino=$nro_ano."-".$mes."-"."31";
			$dias=31;
			break;
		case 4:
			$fecha_inicio =$nro_ano."-".$mes."-"."01";
			$fecha_termino=$nro_ano."-".$mes."-"."30";
			$dias=30;
			break;
		case 5:
			$fecha_inicio =$nro_ano."-".$mes."-"."01";
			$fecha_termino=$nro_ano."-".$mes."-"."31";
			$dias=31;
			break;
		case 6:
			$fecha_inicio =$nro_ano."-".$mes."-"."01";
			$fecha_termino=$nro_ano."-".$mes."-"."30";
			$dias=30;
			break;
		case 7:
			$fecha_inicio =$nro_ano."-".$mes."-"."01";
			$fecha_termino=$nro_ano."-".$mes."-"."31";
			$dias=31;
			break;
		case 8:
			$fecha_inicio =$nro_ano."-".$mes."-"."01";
			$fecha_termino=$nro_ano."-".$mes."-"."31";
			$dias=31;
			break;
		case 9:
			$fecha_inicio =$nro_ano."-".$mes."-"."01";
			$fecha_termino=$nro_ano."-".$mes."-"."30";
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
		
		
		
		//fecha inicio y termino del des			
		 $fi=$fecha_inicio;
		 $ft=$fecha_termino;
		
		//dias habiles del mes
		$habiles = hbl($fi,$ft);
		
		
		//conteo feriados mes
		$ob_reporte->fecha_ini2=$fi;	
		$ob_reporte->fecha2=$ft;		
		$rs_feriado2=$ob_reporte->DiaHabil2($conn);
		if(pg_numrows($rs_feriado2)>0){
		for($f=0;$f<pg_numrows($rs_feriado2);$f++){
			$filaf=pg_fetch_array($rs_feriado2,$f);
			 $fecha_inif = date($filaf['fecha_inicio']);
			 $fecha_finf = date($filaf['fecha_fin']);
			 
			 $fer=$fer+ddiff($fecha_inif,$fecha_finf);
		}
	
	
	}
	 $feriados=$fer;
	 
	 //dias trabajados del mes
	 $diast= $habiles-$feriados;
	 
	 
	 //inasistencias
	 $ob_reporte->ano=$ano;
	 $ob_reporte->mes=$m;
	 $ob_reporte->ciclo=$cod_ciclo ;
	 $rs_asis = $ob_reporte->AsistenciaCiclosMES($conn);
	 $fil_inasis = pg_fetch_array($rs_asis,0);
	 $inasis = $fil_inasis['cuenta'];
	 
	 
	 // asistencia del mes
	// if($m <= date("m") )
	 $asistencia=($matricula*$diast)-$inasis;
	 //else
	 //$asistencia=0;
	 
	 $total_mes[$j]=$total_mes[$j]+$asistencia;
		
		
	?>
    <td width="2%" class="subitem">
      <div align="right">
       <?php echo $asistencia ?>
    </div></td>
	<? 
	$total_ciclo=$total_ciclo+$asistencia;
	
	} ?>
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
    <td width="2%" class="subitem"><div align="right"><strong><font style="font-size:10px"><?=number_format($total_mes[$j],'0',',','.');?></font></strong></div></td>
    <? }?>
    <td width="3%" class="subitem"><div align="right"><strong><font style="font-size:10px"><?=number_format($total_gral,'0',',','.');?></font> </strong> </div></td>
  </tr>
</table>
<br />
 <?php  
		 $ruta_timbre =4;
		 $ruta_firma =2;
		 include("firmas/firmas.php");?>
</body>
</html>
