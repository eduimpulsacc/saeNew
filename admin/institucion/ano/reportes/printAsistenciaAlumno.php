<?	
require('../../../../util/header.inc');
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
	
	$fiano = $ob_membrete->fecha_inicio;
	
	$ob_alumno = new Reporte();
	$ob_alumno->ano = $ano;
	$ob_alumno->alumno = $alumno;
	$ob_alumno->curso = $curso;
	$rs_alumno = $ob_alumno->TraeUnAlumno($conn);
	$fila_alu = @pg_fetch_array($rs_alumno,0);
	$nombre_alumno = $fila_alu['nombre_alu']." ".$fila_alu['ape_pat']." ".$fila_alu['ape_mat'];
	$fecha_matricula = $fila_alu['fecha'];
	
	
	$ranoc=$ob_alumno ->AnoEscolarCurso($conn);
	$fic = pg_result($ranoc,0);
	$ftc = pg_result($ranoc,1);
	
	
	

	
	$ob_reporte->ano=$ano;
	$ob_reporte->alumno=$alumno;
	$ob_reporte->curso=$curso;
	$rs_inasis = $ob_reporte->AsistenciaAlumno($conn);
	
	
	$rs_encu = $ob_reporte->ensCu($conn);
	
	
	
	
	  $corte=(pg_result($rs_encu,0)>=310 && pg_result($rs_encu,1)==4)?11:12;
	
	$rs_fercur= $ob_reporte->feriadoCursoNew($conn);
	
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
	
	$fini= array();
	$fter= array();
	
	for($j=3;$j<=$corte;$j++){
		
		if(pg_numrows($rs_fercur)==0){
	 $sqlFer="select id_feriado, date_part('day', feriado.fecha_inicio) AS dia_ini, date_part('month',feriado.fecha_inicio) AS mes_ini, date_part('year',feriado.fecha_inicio) AS ano_ini, date_part('day', feriado.fecha_fin) AS dia_fin, date_part('month',feriado.fecha_fin) AS mes_fin, date_part('year',feriado.fecha_fin) AS ano_fin from feriado where date_part('month',feriado.fecha_inicio)=".trim($j)." and id_ano=".$ano." order by dia_ini;";}
	 else{
		 $sqlFer="select feriado.id_feriado, date_part('day', feriado.fecha_inicio) AS dia_ini, date_part('month',feriado.fecha_inicio) AS mes_ini, date_part('year',feriado.fecha_inicio) AS ano_ini, date_part('day', feriado.fecha_fin) AS dia_fin, date_part('month',feriado.fecha_fin) AS mes_fin, date_part('year',feriado.fecha_fin) AS ano_fin from feriado inner join feriado_curso on feriado_curso.id_feriado=feriado.id_feriado where date_part('month',feriado.fecha_inicio)=".trim($j)." and id_ano=".$ano." order by dia_ini;";
		 
		}
			//if($_PERFIL==0){echo $sqlFer;}
			$resultFer=@pg_Exec($conn,$sqlFer) or die("error sql=".$sqlFer);
			//echo $p=$j-3;
			
			//echo $filaFer["dia_ini"];
	
	
	if(pg_numrows($resultFer)>0){
	for($p=0;$p<pg_numrows($resultFer);$p++)
	{///
	//for($i=1;$i<=31;$i++){
	$filaFer=@pg_fetch_array($resultFer,$p);
		
		$fini[$j][$filaFer["dia_ini"]]=$filaFer["dia_ini"];
		$fter[$j][$filaFer["dia_fin"]]=$filaFer["dia_fin"];
		 }
		}
		
	
	
	
	}//for meses
/*	
	if($_PERFIL==0){
	echo "<pre>";
		var_dump($fini);
		echo "</pre>";
	}
	if($_PERFIL==0){
	echo "<pre>";
		var_dump($fter);
		echo "</pre>";
	}*/
?>
<script>

function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	guardaImp();
	document.getElementById("capa0").style.display='block';
}

function guardaImp(alu){
	var ano =<?php echo $_ANO ?>;
	var curso =<?php echo $c_curso ?>;
	var alumno =<?php echo $c_alumno ?>;
	var reporte =<?php echo $c_reporte ?>;
	var parametros ="ano="+ano+"&curso="+curso+"&alumno="+alumno+"&reporte="+reporte;
	var cuenta=0;
	var cad_cuenta="";
	for(i=0;i<cuenta;i++){
		cad_cuenta = cad_cuenta+"../";
	}
	
	$.ajax({
		url:cad_cuenta+'cuentaRepo/cuentaRepo.php',
		data:parametros,
		type:'POST',
		success:function(data){
			console.log(data);
		}
	})
}

</script>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../../../clases/jquery/jquery.js"></script>
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
<table width="850" border="0" align="center" cellpadding="0" cellspacing="0">
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
		    }
			
			
			?> 
   <? }
   
    ?>  
	  
	  
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
<table width="870" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" class="tableindex"><div align="center">TOTAL DE ASISTENCIA DE UN ALUMNO  </div></td>
  </tr>
  <tr>
    <td align="center"><span class="Estilo2"><strong><? echo trim(strtoupper("AÑO ".$ob_membrete->nro_ano)) ;?></strong></span></td>
  </tr>
</table>
<table width="870" border="0" align="center" cellpadding="0" cellspacing="3">
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
<table width="850" border="1" align="center" cellpadding="3" cellspacing="0">
 
 
  <tr class="tableindex">
    <td width="10%" rowspan="2" class="item">&nbsp;
    <div align="center">Meses</div></td>
    <td colspan="31" class="item"><div align="center">DIAS</div></td>
    <td rowspan="2" class="item"><div align="center">días asistidos</div></td>
    <td rowspan="2" class="item"><div align="center">% Asist. mensual</div></td>
  </tr>
  <tr>
    <? for($i=1;$i<=31;$i++){?>
	<td width="2%" class="tableindex"><?=$i?></td>
    <? }?>
	
	
  </tr>
 
 
 
 <? for($j=3;$j<=$corte;$j++){
	 	$ina=0;
		$asis=0;
	 
	 
 	$total=0;
	$totali=0;
	?>
  <tr>
    <td class="tableindex" style="height:20px"><?=envia_mes($j)?></td>
    <? 
		for($i=1;$i<=31;$i++){ 
		
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
		$fechaH = $ob_membrete->nro_ano."-".$mes."-".$dia;
		$fecha_f = mktime(0,0,0,$mes,$dia,$ob_membrete->nro_ano);
		$dia_pal_f = strftime("%a",$fecha_f); 
		
		//if($_PERFIL==0){echo $i."--".$fini[$j][$i]."-".$fter[$j][$i];}
		if(($j==4 || $j==6 || $j==9 || $j==11) && $i==31){
			$habil=0;
		}
		elseif(($i>=$fini[$j][$i]) && ($i<=$fter[$j][$i])){
			$habil=0;
			
		}
		elseif($dia_pal_f == "Sat" || $dia_pal_f == "Sun" ){
			$habil=0;
		}
			
		
		
		
		
			
		else{
			
			$ob_habil = new Reporte();
			$ob_habil ->ano=$ano;
			$ob_habil ->fecha_ini=$ob_membrete->nro_ano."-".$mes."-01";
			$ob_habil ->fecha=$fechaH;
			$rhabil = $ob_habil->DiaHabilH($conn);
			//$habil=1;
			if(pg_result($rhabil,0)==0){$habil=1;}else{$habil=0;}
				
			
		}
		
		
		
		
		if($habil==0){
					
			$color ="bgcolor=#999999";
			$asistencia="";
			$as=0;
			
		}
				
		/*if($habil!= 0 && ){*/
		else{
			$color="bgcolor=#FFFFFF";
			$fecha_dia = date("Y-m-d");

			for($x=0;$x<@pg_numrows($rs_inasis);$x++){
				$fila_ina = @pg_fetch_array($rs_inasis,$x);
				 
			
			if($fecha<$fiano){
					$asistencia="";
					$habil=0;
					}			
		
			elseif($fecha<$fecha_matricula){
					$asistencia="";
					$habil=0;
					}	
				
			elseif($fila_ina['fecha']==$fecha){
					$asistencia="<img src='../../../clases/img_jquery/iconos/Free_web_development_icons_by_kurumizawa/Colored/PNG/action_delete.png' width='12'>";
					$as=2;
					$ina++;
					break;
				}
					
							
				else
				{	
					 if($fecha<=$fecha_dia){
					$asistencia="<img src='../../../clases/img_jquery/iconos/Free_web_development_icons_by_kurumizawa/Colored/PNG/action_check.png' width='12'>";
					$as=1;
					$asis++;
					}
					
					else{
						$asistencia="";
						$as=0;
						}
				}
			}			
		}
		
		
		/*elseif($habil==0 && ($dia_pal_f != "Sat" && $dia_pal_f != "Sun" )){
			$color="bgcolor=#FFFFFF";
			for($x=0;$x<@pg_numrows($rs_inasis);$x++){
				$fila_ina = @pg_fetch_array($rs_inasis,$x);
				if($fila_ina['fecha']==$fecha){
					$asistencia="<img src='../../../clases/img_jquery/iconos/Free_web_development_icons_by_kurumizawa/Colored/ICO/action_delete.ico' width='12'>";
					$as=0;
					//break;
				}else{
					$asistencia="<img src='../../../clases/img_jquery/iconos/Free_web_development_icons_by_kurumizawa/Colored/ICO/action_check.ico' width='12'>";
					$as=1;
				}
			}			
		}*/
		
		
		if($as==1){
			$total++;
		}
		if($as==2){
			$totali++;	
		}
		$total_dias = $total + $totali;
		$porc = substr(($total * 100) / $total_dias,0,4);
		
	?>
    <td width="2%" align="center" class="subitem" <?=$color;?>>
	<?php //echo $fecha_matricula ?>
	<?=$asistencia;?></td>
	<? } ?>
   	<td width="4%" class="subitem">
   	  <div align="center">
   	    <?=$total;?>
      </div></td>
      <td width="4%" class="subitem">
   	  <div align="center">
   	    <?=$porc;?>
      </div></td>
  </tr>
  <? }?>
</table>
<br />
<br />
 <?php  
		 $ruta_timbre =4;
		 $ruta_firma =2;
		 include("firmas/firmas.php");?>
</body>
</html>
