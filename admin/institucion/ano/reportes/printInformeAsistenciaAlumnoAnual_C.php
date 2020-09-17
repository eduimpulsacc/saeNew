<?	require('../../../../util/header.inc');
	include('../../../clases/class_MotorBusqueda.php');
	include('../../../clases/class_Membrete.php');
	include('../../../clases/class_Reporte.php');

	//print_r($_POST);
	
	//if($_PERFIL==0){show($_POST);}
	
	$institucion	=$_INSTIT;
	$ano			=$c_ano;
	$reporte		=$c_reporte;
	$curso			=$c_curso;
	$alumno			=$c_alumno;
	
	
	$_POSP = 4; 
	
	$_bot = 8;
	
	$ob_membrete = new Membrete();
	$ob_reporte = new Reporte();
	
	$ob_reporte->curso=$curso;
	$rs_profe = $ob_reporte->ProfeJefe($conn);
	
	$ob_membrete ->institucion = $institucion;
	$ob_membrete ->institucion($conn);
//------------------------
	// Año Escolar
	//------------------------
	$sql_ano = "select * from ano_escolar where id_ano = ".$ano;
	$result_ano =@pg_Exec($conn,$sql_ano);
	$fila_ano = @pg_fetch_array($result_ano,0);	
	$nro_ano = $fila_ano['nro_ano'];
	$f_inicio_aa = $fila_ano['fecha_inicio'];
	$f_fin_aa = $fila_ano['fecha_termino'];
	
	
	$sql_cu="select ensenanza,grado_curso,fecha_inicio,fecha_termino from curso where id_curso=$curso";
	$rs_cu = pg_exec($conn,$sql_cu);
	$ens = pg_result($rs_cu,0);
	$gra = pg_result($rs_cu,1);
	
	$f_inicio_cur = pg_result($rs_cu,2);
	$f_fin_cur = pg_result($rs_cu,3);
	
	$f_inicio_ano=(strlen($f_inicio_cur)==0 && $f_inicio_cur=='1111-11-11')?$f_inicio_aa:$f_inicio_cur;
	
	$f_fin_anio=(strlen($f_fin_cur)==0 && $f_fin_cur=='1111-11-11')?$f_fin_aa:$f_fin_cur;
	
	$corte = ($ens>=310 && $gra==4)?12:13;
	
	
	
	

	$ob_reporte->ano=$ano;
	$ob_reporte->AnoEscolar($conn);
	$ano2=$ob_reporte->nro_ano;
	
	
	
		
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
		header("Content-Disposition:inline; filename=Informe_Asistencia_Mes_Curso_$Fecha.xls"); 
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
    <td><div align="left"><input type="button" name="Submit" value="CERRAR" onClick="window.close()" class="botonXX"/></div></td>
    <td class="textosesion"><div align="center">(*)Reporte debe imprimirse de manera horizontal</div></td>
    <td><div align="right"><input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR" /></div></td>
  </tr>
</table>
</div>
<BR /><BR />
<table width="71%" border="0" align="center" cellpadding="0" cellspacing="0">
   <tr>
    <td width="834"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong><? echo ucwords(strtoupper($ob_membrete->ins_pal));?></strong></font></td>
    <td width="11">&nbsp;</td>
    <td width="152" rowspan="4" align="center">
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
<table width="71%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" class="tableindex"><div align="center">INFORME ANUAL POR ALUMNO																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																						</div></td>
  </tr>
  <tr>
    <td align="center"><span class="Estilo2"><strong><? echo trim(strtoupper("AÑO ".$ano2)) ;?></strong></span></td>
  </tr>
</table>
<br>
<!--/////////////////////////////////////nueva tabla///////////////////////////////-->
<table width="71%" border="0" align="center">
  <tr>
    <td width="19%" class="textonegrita">Curso</td>
    <td width="3%" class="textonegrita">:</td>
    <td width="78%" class="textosimple">&nbsp;<? echo CursoPalabra($curso,0,$conn);?></td>
  </tr>
  <tr>
    <td class="textonegrita">Profesor Jefe</td>
    <td class="textonegrita">:</td>
    <td class="textosimple">&nbsp;<?=$ob_reporte->profe_jefe;?></td>
  </tr>
</table>
<br />
<table align="center" width="71%" border="1" cellpadding="0" cellspacing="0">
  <tr class="tableindex">
    <td width="71%" height="27"><div align="center">ALUMNOS</div></td>
	<? for($i=3;$i<$corte;$i++){?>
    <td width="9%" align="center"><div align="center"><?=envia_mes2($i);?></div></td>
	<? }?>
    <td width="11%"><div align="center">TOTAL</div></td>
    <td width="11%">TOTAL %</td>
  </tr>
  <?
	$ob_cursos = new Reporte();
	$ob_cursos->ano=$ano;
	$ob_cursos->curso=$curso;
	$ob_cursos->cursoa=$curso;
	$ob_cursos->retirado=0;
	
	if($alumno == 0){
		
	$rs_alumnos=$ob_cursos->TraeTodosAlumnos($conn);
	}else{
		$ob_cursos->alumno=$c_alumno;
		$rs_alumnos=$ob_cursos->TraeUnAlumno($conn);
	}
	$num_alumnos=pg_numrows($rs_alumnos);
	$mes = 0;
	for($i=0;$i<$num_alumnos;$i++){
	$fila= pg_fetch_array($rs_alumnos,$i);
	$nombre_alumno=$fila['ape_pat']." ".$fila['ape_mat']." ".$fila['nombre_alu'];
	$total_asis_alumno =0;
	$dias_t_ano =0;
	$retirado = $fila_alu['bool_ar'];
	$fecha_retiro = $fila_alu['fecha_retiro'];
	
	
	
	?>
  <tr>
    <td class="textosimple"><? echo strtoupper($nombre_alumno);?></td>
	
	<? 
	 $fii = explode("-",$f_inicio_ano);
	 $ffi = explode("-",$f_fin_anio);
	
	for($e=3;$e<$corte;$e++){
		
	   $mes=($e<10)?"0".$e:$e;
		
	  
		
		//fechas matricula
	   $fecha_retiro = $fila['fecha_retiro'];
	   $fecha_matricula = $fila['fecha'];
	   $ini_mes = $ano2."-".$mes."-01";
	   
	   $fa = explode("-",$fecha_matricula);
		
		if($fecha_matricula < $ini_mes)
		{

			if($e==3){
				if($fa[1]==$mes){
				$fini= $ano2."-".$mes."-".$fa[2];
				
				echo $fini;
			}
			else
			 {$fini= $f_inicio_ano;}
			 
			 
			 
			}
			
			else{
				 $fini= $ano2."-".$mes."-01";
			}
		$hab=1;
		
		}
		
		else
		{
			$fa = explode("-",$fecha_matricula);
			
			//ver en marzo
			if($fa[1]==03){
				if($fa[2]<=$fii[2]){
					$fini=$f_inicio_ano;
					$hab=1;
				}
				else{
					$fini=$fecha_matricula;
					$hab=1;
				}
			}
			
				
			
			elseif($fa[1]!=$e){
			$fini= "";
			$hab=0;
			}
			
			else{
			$fini= $fecha_matricula;
			$hab=1;
			}
		} 
		
		
		if($retirado==1){
		 $fter =$fecha_retiro;
		}else{
			if($mes==12){
				$fter = $f_fin_anio;
				}
			else{
		 		$fter =$ano2."-".$mes."-".dia_mes($mes,$ano2);
			}
		}
		
		/*echo $fini;
		echo $fter;*/
		//cuenta habiles
		if($hab==0){
		$habiles_ano=0;	
		$fera=0;
		$feriados_mes=0;
		$diast=0;
		$insasistencias=0;
		$reales=0;
		}
		else
		{
			if(date("m")==$mes && $ano2==date("Y")){
			$fini=$ano2."-".$mes."-01";
			if(trim($mes)==12){
				$dia_ter= substr($f_fin_anio,8,2);	
			}else{
				$dia_ter=date("d");	
			}
			$fter = $ano2."-".$mes."-".$dia_ter;
			}
			
			
		 $habiles_ano=hbl($fini,$fter);	
		 $ob_cursos->ano=$ano;
		 $ob_cursos->fecha_ini2=$fini;
		 $ob_cursos->fecha2=$fter;
		 $rs_feriadosano = $ob_cursos->DiaHabil4($conn);
		 
		 $feriados_ano=0;
		 $fera=0;
		 
	//	echo  $sql_fano ="SELECT fecha_inicio,fecha_fin FROM feriado WHERE id_ano=".$ano."  AND (feriado.fecha_inicio>='".$fini."' or feriado.fecha_fin<='".$fter."');";
		 
		 if(pg_numrows($rs_feriadosano)>0 ){
		 for($ff=0;$ff<pg_numrows($rs_feriadosano);$ff++){
			$fila_feriadoano =pg_fetch_array($rs_feriadosano,$ff);
			
		  $inciof= $fila_feriadoano['fecha_inicio'];
			if($fila_feriadoano['fecha_fin']==NULL)
				{
				 $finf=$inciof ;
			}else{
				$finf= $fila_feriadoano['fecha_fin'];
			}
			
			$fera=$fera+$dif_dias =ddiff($inciof, $finf);
		 }
		  
		 }else{
			$feriados_mes=0;
			$diast=0;
			$insasistencias=0;
			$reales=0;
			}
		$feriados_mes=$fera;
		$diast=$habiles_ano-$feriados_mes;
		/* if($_PERFIL==0) {
			echo "<br>".$habiles_ano."--".$feriados_mes;
		}*/
		//inasistencias
		$ob_cursos->ano=$ano;
		$ob_cursos->alumno=$fila['rut_alumno'];
		$ob_cursos->curso=$curso;
		 $ob_cursos->fecha_inicio=$fini;
		 $ob_cursos->fecha_termino=$fter;
		 $rs_asistencia = $ob_cursos->Asistencia($conn);
		  $insasistencias = pg_numrows($rs_asistencia);	
		
		
		
		 $reales=$diast-$insasistencias;
		 if(date("m")<$mes){
		  //$reales=0;
		 }
		/* if($_PERFIL==0) {
			echo "<br>".$diast."--".$insasistencias."  reales-->".$reales;
		}*/
		 $total_asis_alumno=$total_asis_alumno+$reales;
		 $asi[$e][]=$reales;
		}
		
		
		 // habiles reales mes 
		 
		 $dias_t_ano=$dias_t_ano+$diast;
		 
		 
 $porcentaje =round(($total_asis_alumno*100)/$dias_t_ano,0);
	
	
		?>
    <td align="right" class="textosimple"><?php echo $reales?></td>
    <?php  } ?>
    <td class="textosimple"><div align="right"><?php echo $total_asis_alumno ?></div></td>
    <td align="right" class="textosimple"><strong><?php echo $porcentaje; $sum_porc = $sum_porc+$porcentaje; ?>%</strong></td>
    <? }
		
	?> 
    
  
  </tr>
 
  <?php if($alumno==0){?>
  <tr>
    <td class="textosimple"><strong>TOTALES</strong></td>
	<? for($e=3;$e<$corte;$e++){
		$total_gral = $total_gral + array_sum($asi[$e]);
		
		?>
    <td class="textosimple"><div align="right"><strong><?php echo array_sum($asi[$e])?></strong></div></td>
    <? }?>
    <td class="textosimple"><div align="right"><strong><?php echo number_format($total_gral,0,',','.') ?></strong></div></td>
    <td align="right" class="textosimple"><strong><?php echo round($sum_porc/pg_numrows($rs_alumnos),0) ?>%</strong></td>
  </tr>
  <?php }?>
</table>
<br />
 <?php  
		 $ruta_timbre =4;
		 $ruta_firma =2;
		
		 include("firmas/firmas.php");?>
</body>
</html>
