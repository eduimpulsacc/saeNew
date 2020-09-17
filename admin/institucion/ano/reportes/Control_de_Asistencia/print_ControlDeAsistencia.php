<?	
	require('../../../../../util/header.inc');
	require('../../../../../util/LlenarCombo.php3');
	require('../../../../../util/SeleccionaCombo.inc');
	include('../../../../clases/class_Reporte.php');
	include('../../../../clases/class_Membrete.php');
	include('../../../../clases/class_MotorBusqueda.php');
	
	//print_r($_POST);

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
	$nro_ano=$ob_membrete->nro_ano;
	$ob_reporte->nro_ano =$ob_membrete->nro_ano;
	$ob_reporte->mes = $mes;
	$rs_asis = $ob_reporte->AsistenciaCurso($conn);
	
	/*$ob_membrete -> curso =$curso;
	$ob_membrete -> curso($conn);*/
	
	
	
function habiles($mes,$nro_ano){
	
	
   $habiles = 0; 
   // Consigo el número de días que tiene el mes mediante "t" en date()
   $dias_mes = date("t", mktime(0, 0, 0, $mes, 1, $nro_ano));
   // Hago un bucle obteniendo cada día en valor númerico, si es menor que 
   // 6 (sabado) incremento $habiles
   for($i=1;$i<=$dias_mes;$i++) {
       if (date("N", mktime(0, 0, 0, $mes, $i, $nro_ano))<6) $habiles++;
   }

   return $habiles;
 
}

//echo habiles();
	
	
	
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
<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
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


@media all {
   div.saltopagina{
      display: none;
   }
}
   
@media print{
   div.saltopagina{ 
      display:block; 
      page-break-before:always;
   }
}

</style>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../cortes/b_ayuda_r.jpg','../../../../../cortes/b_info_r.jpg','../../../../../cortes/b_mapa_r.jpg','../../../../../cortes/b_home_r.jpg')">
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
                       <?
						if($institucion!=""){
						   echo "<img src='".$d."../tmp/".$institucion."insignia". "' >";
						}else{
						   echo "<img src='".$d."menu/imag/logo.gif' >";
						}?>	
	  
	  
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


<table width="51%" align="center"  border="1" style="border-collapse:collapse">
  
  <tr bgcolor="#CCCCCC" class="item">
    <td width="28%">CURSOS</td>
    <td colspan="2" align="center">MATR&Iacute;C. INI.</td>
    <td width="10%">ALTAS</td>
    <td width="7%">BAJAS</td>
    <td width="12%">MAT. REAL</td>
    <td width="11%">ASIST.</td>
    <td width="14%">%</td>
  </tr>
  <?
 	$ob_cursos = new Reporte();//
	$ob_cursos->ano=$ano;
	$rs_cursos = $ob_cursos->ListadoCurso($conn);
	$cant_cursos=pg_numrows($rs_cursos);
	
		
	
		$contador1=0;
		for($i=0;$i<$cant_cursos;$i++){
		$fer=0;
			
		$fila_cursos = @pg_fetch_array($rs_cursos,$i);
		$cod_curso = $fila_cursos['id_curso'];
		
		
		$ensenanza=$fila_cursos['ensenanza'];
		
		if($ensenanza > 309){
			
			continue;
			}
		$total_curso = 0;
		
		$mes_anterior=$mes;
		
		$dia_mes_anterior= dia_mes($mes_anterior,$nro_ano);
		$dia= dia_mes($mes,$nro_ano);
		$ob_asistencia = new Reporte();
		$ob_asistencia->ano=$ano;
		$ob_asistencia->id_curso=$cod_curso;
		$ob_asistencia->fecha_fin=" ".$mes_anterior."-".$dia_mes_anterior."-".$ob_membrete->nro_ano;
		
		$ob_asistencia->fecha_inicio=" ".$mes."-01-".$ob_membrete->nro_ano;
		$ob_asistencia->fecha_termino=" ".$mes."-".$dia."-".$ob_membrete->nro_ano;
		$ob_asistencia->mes=$mes;
		
		$rs_matriculaAsistencia_curso_hobres = $ob_asistencia->MatriculaAsistencia_curso_hobres($conn);
		$cant_matricula_hombres = @pg_result($rs_matriculaAsistencia_curso_hobres,0);
		
		
		$rs_matriculaAsistencia_curso_mujeres = $ob_asistencia->MatriculaAsistencia_curso_mujeres($conn);
		$MatriculaAsistencia_curso_mujeres = @pg_result($rs_matriculaAsistencia_curso_mujeres,0);
		
		
		$rs_matriculaAltas_mes_hombres = $ob_asistencia->MatriculaAltas_mes_hombres($conn);
		$MatriculaAltas_mes_hombres = @pg_result($rs_matriculaAltas_mes_hombres,0);
		
		
		$rs_matriculaBajas_mes_hombres = $ob_asistencia->MatriculaBajas_mes_hombres($conn);
		$MatriculaBajas_mes_hombres = @pg_result($rs_matriculaBajas_mes_hombres,0);
		
		$rs_matriculaAltas_mes_mujeres = $ob_asistencia->MatriculaAltas_mes_mujeres($conn);
		$MatriculaAltas_mes_mujeres = @pg_result($rs_matriculaAltas_mes_mujeres,0);
		
		$rs_matriculaBajas_mes_mujeres = $ob_asistencia->MatriculaBajas_mes_mujeres($conn);
		$MatriculaBajas_mes_mujeres = @pg_result($rs_matriculaBajas_mes_mujeres,0);
		
		
		$MatriculaAsistencia_curso_hobres_mesActual=$cant_matricula_hombres+$MatriculaAltas_mes_hombres-$MatriculaBajas_mes_hombres;
		
		
		$MatriculaAsistencia_curso_mujeres_mesActual=$MatriculaAsistencia_curso_mujeres+$MatriculaAltas_mes_mujeres-$MatriculaBajas_mes_mujeres;
				
 ?>
  <tr>
    <td width="28%" class="item fuente"><div align="left">
      <?=CursoPalabra($cod_curso,0,$conn)?></div></td>
    <td width="9%" class="subitem">H</td>
    <td width="9%" class="subitem"><?=$cant_matricula_hombres;?></td>
  	<td width="10%" class="subitem"><?=$MatriculaAltas_mes_hombres?></td>
    <td width="7%" class="subitem"><?=$MatriculaBajas_mes_hombres?></td>
    <td width="12%" class="subitem"><?=$MatriculaAsistencia_curso_hobres_mesActual?></td>
    <td width="11%" class="subitem">
	<?		
		 $slq_asis="select count(asistencia.*) from asistencia 
        inner join alumno on asistencia.rut_alumno=alumno.rut_alumno
        where ano=".$ano." and id_curso=".$cod_curso." and date_part('month',fecha)=".$mes." and alumno.sexo=2";
			$result_asis = @pg_Exec($conn,$slq_asis);
	     	$cant_asis = @pg_fetch_array($result_asis);
			 
		
	
		 $dias_habiles= habiles($mes,$nro_ano);	
		 //$dias_Feriados= DiasFeriadosMes($mes, $dia, $nro_ano, $ano,$conn);
		 
		 $ob_asistencia->fecha_ini2=$ob_asistencia->fecha_inicio;
		 $ob_asistencia->fecha2=$ob_asistencia->fecha_inicio;
		 
		 $rs_feriado2=$ob_asistencia->DiaHabil2($conn);
	if(pg_numrows($rs_feriado2)>0){
	for($f=0;$f<pg_numrows($rs_feriado2);$f++){
		$filaf=pg_fetch_array($rs_feriado2,$f);
		 $fecha_inif = date($filaf['fecha_inicio']);
		 $fecha_finf = date($filaf['fecha_fin']);
		 
		 $fer=$fer+ddiff($fecha_inif,$fecha_finf);
	}
	
	
	}
	 $dias_Feriados=$fer;
		
		 $total_dias_habiles=$dias_habiles-$dias_Feriados;
		
		 $alumnos_asistentes= ($MatriculaAsistencia_curso_hobres_mesActual * $total_dias_habiles);
		
		echo $Total_alumnos_asis=$alumnos_asistentes-$cant_asis[0];
		
		$procenHom=round(($Total_alumnos_asis*100)/$alumnos_asistentes)."%";
		
		?>
    </td>
    <td width="14%" class="subitem"><?=$procenHom?></td>
      </tr>
      <?
      if($procenHom >0 ){
		  $contador1++;
		  }
  ?>
  
  <tr>
  <td>&nbsp;</td>
  <td class="subitem">M</td>
  <td class="subitem"><?=$MatriculaAsistencia_curso_mujeres?></td>
  <td class="subitem"><?=$MatriculaAltas_mes_mujeres?></td>
  <td class="subitem"><?=$MatriculaBajas_mes_mujeres?></td>
  <td class="subitem"><?=$MatriculaAsistencia_curso_mujeres_mesActual?></td>
  <td class="subitem">
  <?
  $slq_asis2="select count(asistencia.*) from asistencia 
        inner join alumno on asistencia.rut_alumno=alumno.rut_alumno
        where ano=".$ano." and id_curso=".$cod_curso." and date_part('month',fecha)=".$mes." and alumno.sexo=1";
			$result_asis2 = @pg_Exec($conn,$slq_asis2);
	     	$cant_asis2 = @pg_fetch_array($result_asis2);
		
		
		 $alumnos_asistentes2 = ($MatriculaAsistencia_curso_mujeres_mesActual * $total_dias_habiles);
		
		
		echo $Total_alumnos_asis2=$alumnos_asistentes2-$cant_asis2[0];
		
		$porcenMuj=round(($Total_alumnos_asis2*100)/$alumnos_asistentes2)."%";
		
		
		
		
  ?>
  </td>
  <td class="subitem"><?=$porcenMuj?></td>
  </tr>
  
  
  
  
  
  <?
  
  $totalMatHom=$totalMatHom+$cant_matricula_hombres;
  $totalMatMuj=$totalMatMuj+$MatriculaAsistencia_curso_mujeres;
  
  $totalAltasHom=$TotalAltasHom+$MatriculaAltas_mes_hombres;
  $totalAltasMuj=$totalAltasMuj+$MatriculaAltas_mes_mujeres;
  
  $totalBajasHom=$totalBajasHom=$MatriculaAltas_mes_hombres;
  $totalBajasMuj=$totalBajasMuj+$MatriculaBajas_mes_mujeres;
  
  $totalMatRealHom=$totalMatRealHom+$MatriculaAsistencia_curso_hobres_mesActual;
  $totalMatRealMuj=$totalMatRealMuj+$MatriculaAsistencia_curso_mujeres_mesActual;
  
  $totalAsisHom=$totalAsisHom+$Total_alumnos_asis;
  $totalAsisMuj=$totalAsisMuj+$Total_alumnos_asis2;
  
  $totalPorcenHom=$totalPorcenHom+$procenHom;
  $totalPorcenMuj=$totalPorcenMuj+$porcenMuj;
  
  
   }
   
   $totalMatriculas=$totalMatHom+$totalMatMuj;
   
   $totalAltas=$totalAltasHom+$totalAltasMuj;
   
   $totalBajas=$totalBajasHom+$totalBajasMuj;
   
   $totalMatActual=$totalMatRealHom+$totalMatRealMuj;
   
   $totalAsistencia=$totalAsisHom+$totalAsisMuj;
   
   
   
   $divisor1=$contador1*2;
   $totalPorcentajes=($totalPorcenHom+$totalPorcenMuj)/$divisor1;
   
   
   ?>
  
  
  <tr class="subitem">
    <td width="28%" class="item"><div align="left" class="Estilo1"><font style="font-size:10px">TOTAL</font></div></td>
    <td width="9%"  class="subitem"><div align="center"><font style="font-size:10px">&nbsp;</font></div></td>
    <td width="9%"  class="subitem"><div align="center"><font style="font-size:10px"><?=$totalMatriculas?></font></div></td>
    <td width="10%"  class="subitem"><div align="center"><font style="font-size:10px"><?=$totalAltas?></font></div></td>
    <td width="7%"  class="subitem"><div align="center"><font style="font-size:10px"><?=$totalBajas?></font></div></td>
    <td width="12%"  class="subitem"><div align="center"><font style="font-size:10px"><?=$totalMatActual?></font></div></td>
    <td width="11%"  class="subitem"><div align="center"><font style="font-size:10px"><?=$totalAsistencia?></font></div></td>
    <td width="14%"  class="subitem"><div align="center"><font style="font-size:10px"><?=round($totalPorcentajes)?>%</font></div></td>
     
  </tr>
</table>
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />


<div class="SaltoDePagina">
<table width="80%" border="0" align="center" cellpadding="0" cellspacing="0">
   <tr>
    <td width="697"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong><? echo ucwords(strtoupper($ob_membrete->ins_pal));?></strong></font></td>
    <td width="10">&nbsp;</td>
    <td width="125" rowspan="4" align="center">
		<table width="125" border="0" cellpadding="0" cellspacing="0">
          <tr valign="top">
            <td width="125" align="center">
                       <?
						if($institucion!=""){
						   echo "<img src='".$d."../tmp/".$institucion."insignia". "' >";
						}else{
						   echo "<img src='".$d."menu/imag/logo.gif' >";
						}?>	
	  
	  
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


<table width="51%" align="center"  border="1" style="border-collapse:collapse">
  
  <tr bgcolor="#CCCCCC" class="item">
    <td width="28%">CURSOS</td>
    <td colspan="2" align="center">MATR&Iacute;C. INI.</td>
    <td width="10%">A</td>
    <td width="7%">B</td>
    <td width="12%">MAT. REAL</td>
    <td width="11%">ASIST.</td>
    <td width="14%">%</td>
  </tr>
  <?
 	$ob_cursos = new Reporte();//
	$ob_cursos->ano=$ano;
	$rs_cursos = $ob_cursos->ListadoCurso($conn);
	$cant_cursos=pg_numrows($rs_cursos);
	
		$contador2=0;
	
		
		for($i=0;$i<$cant_cursos;$i++){
			$fer=0;
			
		$fila_cursos = @pg_fetch_array($rs_cursos,$i);
		$cod_curso = $fila_cursos['id_curso'];
		
		
		$ensenanza=$fila_cursos['ensenanza'];
		
		if($ensenanza<309){
			
			continue;
			}
		$total_curso = 0;
		
		$mes_anterior=$mes;
		
		$dia_mes_anterior= dia_mes($mes_anterior,$nro_ano);
		$dia= dia_mes($mes,$nro_ano);
		$ob_asistencia = new Reporte();
		$ob_asistencia->ano=$ano;
		$ob_asistencia->id_curso=$cod_curso;
		$ob_asistencia->fecha_fin=" ".$mes_anterior."-".$dia_mes_anterior."-".$ob_membrete->nro_ano;
		
		$ob_asistencia->fecha_inicio=" ".$mes."-01-".$ob_membrete->nro_ano;
		$ob_asistencia->fecha_termino=" ".$mes."-".$dia."-".$ob_membrete->nro_ano;
		$ob_asistencia->mes=$mes;
		
		$rs_matriculaAsistencia_curso_hobres = $ob_asistencia->MatriculaAsistencia_curso_hobres($conn);
		$cant_matricula_hombres = @pg_result($rs_matriculaAsistencia_curso_hobres,0);
		
		
		$rs_matriculaAsistencia_curso_mujeres = $ob_asistencia->MatriculaAsistencia_curso_mujeres($conn);
		$MatriculaAsistencia_curso_mujeres = @pg_result($rs_matriculaAsistencia_curso_mujeres,0);
		
		
		$rs_matriculaAltas_mes_hombres = $ob_asistencia->MatriculaAltas_mes_hombres($conn);
		$MatriculaAltas_mes_hombres = @pg_result($rs_matriculaAltas_mes_hombres,0);
		
		
		$rs_matriculaBajas_mes_hombres = $ob_asistencia->MatriculaBajas_mes_hombres($conn);
		$MatriculaBajas_mes_hombres = @pg_result($rs_matriculaBajas_mes_hombres,0);
		
		$rs_matriculaAltas_mes_mujeres = $ob_asistencia->MatriculaAltas_mes_mujeres($conn);
		$MatriculaAltas_mes_mujeres = @pg_result($rs_matriculaAltas_mes_mujeres,0);
		
		$rs_matriculaBajas_mes_mujeres = $ob_asistencia->MatriculaBajas_mes_mujeres($conn);
		$MatriculaBajas_mes_mujeres = @pg_result($rs_matriculaBajas_mes_mujeres,0);
		
		
		$MatriculaAsistencia_curso_hobres_mesActual=$cant_matricula_hombres+$MatriculaAltas_mes_hombres-$MatriculaBajas_mes_hombres;
		
		
		$MatriculaAsistencia_curso_mujeres_mesActual=$MatriculaAsistencia_curso_mujeres+$MatriculaAltas_mes_mujeres-$MatriculaBajas_mes_mujeres;
				
 ?>
  <tr>
    <td width="28%" class="item fuente"><div align="left">
      <?=CursoPalabra($cod_curso,0,$conn)?></div></td>
    <td width="9%" class="subitem">H</td>
    <td width="9%" class="subitem"><?=$cant_matricula_hombres;?></td>
  	<td width="10%" class="subitem"><?=$MatriculaAltas_mes_hombres?></td>
    <td width="7%" class="subitem"><?=$MatriculaBajas_mes_hombres?></td>
    <td width="12%" class="subitem"><?=$MatriculaAsistencia_curso_hobres_mesActual?></td>
    <td width="11%" class="subitem">
	<?		
		 $slq_asis="select count(asistencia.*) from asistencia 
        inner join alumno on asistencia.rut_alumno=alumno.rut_alumno
        where ano=".$ano." and id_curso=".$cod_curso." and date_part('month',fecha)=".$mes." and alumno.sexo=2";
			$result_asis = @pg_Exec($conn,$slq_asis);
	     	$cant_asis = @pg_fetch_array($result_asis);
			 
		
	
		 $dias_habiles= habiles($mes,$nro_ano);	
		// $dias_Feriados= DiasFeriadosMes($mes, $dia, $nro_ano, $ano,$conn);
		$ob_asistencia->fecha_ini2=$ob_asistencia->fecha_inicio;
		 $ob_asistencia->fecha2=$ob_asistencia->fecha_inicio;
		 
		 $rs_feriado2=$ob_asistencia->DiaHabil2($conn);
	if(pg_numrows($rs_feriado2)>0){
	for($f=0;$f<pg_numrows($rs_feriado2);$f++){
		$filaf=pg_fetch_array($rs_feriado2,$f);
		 $fecha_inif = date($filaf['fecha_inicio']);
		 $fecha_finf = date($filaf['fecha_fin']);
		 
		 $fer=$fer+ddiff($fecha_inif,$fecha_finf);
	}
	
	
	}
	 $dias_Feriados=$fer;
		
		 $total_dias_habiles=$dias_habiles-$dias_Feriados;
		
		 $alumnos_asistentes= ($MatriculaAsistencia_curso_hobres_mesActual * $total_dias_habiles);
		
		echo $Total_alumnos_asis=$alumnos_asistentes-$cant_asis[0];
		
		$procenHom2=round(($Total_alumnos_asis*100)/$alumnos_asistentes)."%";
		
		?>
    </td>
    <td width="14%" class="subitem"><?=$procenHom2?></td>
      </tr>
      <?
      if($procenHom2 > 0 ){
		  $contador2++;
		  }
  ?>
  
  <tr>
  <td>&nbsp;</td>
  <td class="subitem">M</td>
  <td class="subitem"><?=$MatriculaAsistencia_curso_mujeres?></td>
  <td class="subitem"><?=$MatriculaAltas_mes_mujeres?></td>
  <td class="subitem"><?=$MatriculaBajas_mes_mujeres?></td>
  <td class="subitem"><?=$MatriculaAsistencia_curso_mujeres_mesActual?></td>
  <td class="subitem">
  <?
  $slq_asis2="select count(asistencia.*) from asistencia 
        inner join alumno on asistencia.rut_alumno=alumno.rut_alumno
        where ano=".$ano." and id_curso=".$cod_curso." and date_part('month',fecha)=".$mes." and alumno.sexo=1";
			$result_asis2 = @pg_Exec($conn,$slq_asis2);
	     	$cant_asis2 = @pg_fetch_array($result_asis2);
		
		
		 $alumnos_asistentes2 = ($MatriculaAsistencia_curso_mujeres_mesActual * $total_dias_habiles);
		
		
		echo $Total_alumnos_asis2=$alumnos_asistentes2-$cant_asis2[0];
		
		$porcenMuj2=round(($Total_alumnos_asis2*100)/$alumnos_asistentes2)."%";
		
		
		
		
  ?>
  </td>
  <td class="subitem"><?=$porcenMuj2?></td>
  </tr>
  
  
 
  
  
  <?
  
   
  
  $totalMatHom=$totalMatHom+$cant_matricula_hombres;
  $totalMatMuj=$totalMatMuj+$MatriculaAsistencia_curso_mujeres;
  
  $totalAltasHom=$$TotalAltasHom+$MatriculaAltas_mes_hombres;
  $totalAltasMuj=$totalAltasMuj+$MatriculaAltas_mes_mujeres;
  
  $totalBajasHom=$totalBajasHom=$MatriculaAltas_mes_hombres;
  $totalBajasMuj=$totalBajasMuj+$MatriculaBajas_mes_mujeres;
  
  $totalMatRealHom=$totalMatRealHom+$MatriculaAsistencia_curso_hobres_mesActual;
  $totalMatRealMuj=$totalMatRealMuj+$MatriculaAsistencia_curso_mujeres_mesActual;
  
  $totalAsisHom=$totalAsisHom+$Total_alumnos_asis;
  $totalAsisMuj=$totalAsisMuj+$Total_alumnos_asis2;
  
  
  $totalPorcenHom2=$totalPorcenHom2+$procenHom2;
  $totalPorcenMuj2=$totalPorcenMuj2+$porcenMuj2;
  
 
  
  
   }
   
   $totalMatriculas2=$totalMatHom+$totalMatMuj;
   
   $totalAltas2=$totalAltasHom+$totalAltasMuj;
   
   $totalBajas2=$totalBajasHom+$totalBajasMuj;
   
   $totalMatActual2=$totalMatRealHom+$totalMatRealMuj;
   
   $totalAsistencia2=$totalAsisHom+$totalAsisMuj;
   
   
    $divisor2=$contador2*2;
   $totalPorcentajes2=($totalPorcenHom2+$totalPorcenMuj2)/$divisor2;
   
   
   ?>
  
  
  <tr class="subitem">
    <td width="28%" class="item"><div align="left" class="Estilo1"><font style="font-size:10px">TOTAL</font></div></td>
    <td width="9%"  class="subitem"><div align="center"><font style="font-size:10px">&nbsp;</font></div></td>
    <td width="9%"  class="subitem"><div align="center"><font style="font-size:10px"><?=$totalMatriculas2?></font></div></td>
    <td width="10%"  class="subitem"><div align="center"><font style="font-size:10px"><?=$totalAltas2?></font></div></td>
    <td width="7%"  class="subitem"><div align="center"><font style="font-size:10px"><?=$totalBajas2?></font></div></td>
    <td width="12%"  class="subitem"><div align="center"><font style="font-size:10px"><?=$totalMatActual2?></font></div></td>
    <td width="11%"  class="subitem"><div align="center"><font style="font-size:10px"><?=$totalAsistencia2?></font></div></td>
    <td width="14%"  class="subitem"><div align="center"><font style="font-size:10px"><?=round($totalPorcentajes2)?>%</font></div></td>
     
  </tr>
</table>
</div>
<br />
<br />
<br />
<br />


<table width="80%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" class=""><div align="center">CUADRO RESUMEN</div></td>
  </tr>
  <tr>
    <td align="center"><span class="Estilo2"><strong>&nbsp;</strong></span></td>
  </tr>
</table>
<table width="51%" align="center"  border="1" style="border-collapse:collapse">
  
  <tr bgcolor="#CCCCCC" class="item">
    <td width="28%">NIVEL</td>
    <td colspan="2" align="center">MATR&Iacute;C. INI.</td>
    <td width="10%">A</td>
    <td width="7%">B</td>
    <td width="12%">MAT. REAL</td>
    <td width="11%">ASIST.</td>
    <td width="14%">%</td>
  </tr>
 
  <tr>
    <td width="28%" class="item fuente"><div align="left">E.BASICA
      </div></td>
    <td width="9%" class="subitem">H</td>
    <td width="9%" class="subitem" align="center"><?=$totalMatriculas?></td>
  	<td width="10%" class="subitem" align="center"><?=$totalAltas?></td>
    <td width="7%" class="subitem" align="center"><?=$totalBajas?></td>
    <td width="12%" class="subitem" align="center"><?=$totalMatActual?></td>
    <td width="11%" class="subitem" align="center"><?=$totalAsistencia?></td>
    <td width="14%" class="subitem" align="center"><?=round($totalPorcentajes)?>%</td>
      </tr>
  
  
  <tr>
  <td class="subitem">E.MEDIA</td>
  <td class="subitem">M</td>
  <td align="center" class="subitem"><?=$totalMatriculas2?></td>
  <td align="center" class="subitem"><?=$totalAltas2?></td>
  <td align="center" class="subitem"><?=$totalBajas2?></td>
  <td align="center" class="subitem"><?=$totalMatActual2?></td>
  <td align="center" class="subitem"><?=$totalAsistencia2?></td>
  <td align="center" class="subitem"><?=round($totalPorcentajes2)?>%</td>
  </tr>
  
  <?
  	
	$TotalMatTotal=$totalMatActual+$totalMatActual2;
	$TotalAltasTot=$totalAltas+$totalAltas2;
	$TotalBajasTotal=$totalBajas+$totalBajas2;
	$TotalMatRealTotal=$totalMatActual+$totalMatActual2;
	$TotalAsisTotal=$totalAsistencia+$totalAsistencia2;
	
	
	$TotalPocenTotal=(round($totalPorcentajes)+round($totalPorcentajes2))/2
  
  ?>
  
  <tr class="subitem">
    <td width="28%" class="item"><div align="left" class="Estilo1"><font style="font-size:10px">TOTAL</font></div></td>
    <td width="9%"  class="subitem"><div align="center"><font style="font-size:10px">&nbsp;</font></div></td>
    <td width="9%"  class="subitem"><div align="center"><font style="font-size:10px"></font><?=$TotalMatTotal?></div></td>
    <td width="10%"  class="subitem"><div align="center"><font style="font-size:10px"></font><?=$TotalAltasTot?></div></td>
    <td width="7%"  class="subitem"><div align="center"><font style="font-size:10px"></font><?=$TotalBajasTotal?></div></td>
    <td width="12%"  class="subitem"><div align="center"><font style="font-size:10px"></font><?=$TotalMatRealTotal?></div></td>
    <td width="11%"  class="subitem"><div align="center"><font style="font-size:10px"></font><?=$TotalAsisTotal?></div></td>
    <td width="14%"  class="subitem"><div align="center"><font style="font-size:10px"><?=$TotalPocenTotal?>%</font></div></td>
     
  </tr>
</table>

<br>
<br>


<?



		
	function DiasFeriadosMes($mes, $dia, $nro_ano, $ano,$conn)
{
	//$sw = 0;
	
	//$mes, $dia, $nro_ano, $ano,$conn
	
	  $sql_feriado = "select count(*) as cantidad from feriado where  fecha_inicio BETWEEN '".$mes."-01-".$nro_ano."' and '".$mes."-".$dia."-".$nro_ano."' and id_ano = " .$ano. " ";
	 

		$result_feriado = @pg_Exec($conn,$sql_feriado);
		$fila_feriado = @pg_fetch_array($result_feriado,0);	
		 $feriado = $fila_feriado['cantidad'];
		if ($feriado==0)
		{
			$feriado=0;
		}
		else
		{
			$feriado;
		}
	return $feriado;
}

?>
 <?php  
		 $ruta_timbre =5;
		 $ruta_firma =3;
		 include("../firmas/firmas.php");?>
</body>
</html>
