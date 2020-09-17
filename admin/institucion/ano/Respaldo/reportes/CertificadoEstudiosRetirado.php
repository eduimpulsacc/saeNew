<script>
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
</script>
<?
require('../../../../util/header.inc');

	setlocale("LC_ALL","es_ES");
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$c_curso;
	$alumno			=$c_alumno;  
	if ($curso==0) exit;
	if ($alumno==0) exit;
	//------------------------
	// Año Escolar
	//------------------------
	$sql_ano = "select * from ano_escolar where id_ano = ".$ano;
	$result_ano =@pg_Exec($conn,$sql_ano);
	$fila_ano = @pg_fetch_array($result_ano,0);	
	$nro_ano = $fila_ano['nro_ano'];
	$fecha_inicio = $fila_ano['fecha_inicio'];
	//----------------------------------------------------------------------------
	// DATOS INSTITUCION
	//----------------------------------------------------------------------------
	$sql_institu = "SELECT institucion.nombre_instit, institucion.calle, institucion.nro, region.nom_reg, provincia.nom_pro, comuna.nom_com, institucion.telefono ";
	$sql_institu = $sql_institu . "FROM ((institucion INNER JOIN region ON institucion.region = region.cod_reg) INNER JOIN comuna ON (institucion.ciudad = comuna.cor_pro) AND (institucion.comuna = comuna.cor_com) AND (institucion.region = comuna.cod_reg)) INNER JOIN provincia ON (institucion.ciudad = provincia.cor_pro) AND (institucion.region = provincia.cod_reg) ";
	$sql_institu = $sql_institu . "WHERE (((institucion.rdb)=".$institucion.")); ";
	$result_institu =@pg_Exec($conn,$sql_institu);
	$fila_institu = @pg_fetch_array($result_institu,0);
	$nombre_institu = ucwords(strtolower($fila_institu['nombre_instit']));
	$direccion = ucwords(strtolower($fila_institu['calle'] . " " . $fila_institu['nro'] . " - " . $fila_institu['nom_com']));
	$telefono = $fila_institu['telefono'];
	$region = ucwords(strtolower($fila_institu['nom_reg']));
	$provincia = ucwords(strtolower($fila_institu['nom_pro']));
	$comuna = ucwords(strtolower($fila_institu['nom_com']));
	
	//--------------------------------
	// CURSO
	//--------------------------------
	$sql_curso = "SELECT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, plan_estudio.nombre_decreto, evaluacion.nombre_decreto_eval, institucion.rdb, institucion.dig_rdb, institucion.nu_resolucion ";
	$sql_curso = $sql_curso . "FROM institucion, ((curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo) INNER JOIN plan_estudio ON curso.cod_decreto = plan_estudio.cod_decreto) INNER JOIN evaluacion ON curso.cod_eval = evaluacion.cod_eval ";
	$sql_curso = $sql_curso . "WHERE (((curso.id_curso)=".$curso.") AND ((institucion.rdb)=".$institucion."));";
	$result_curso =@pg_Exec($conn,$sql_curso);
	$fila_curso = @pg_fetch_array($result_curso,$cont_paginas);
	$curso = $fila_curso['id_curso'];
	$Curso_pal = CursoPalabra($curso, 0, $conn);
	$ensenanza_pal = $fila_curso['nombre_tipo'];
	$nombre_decreto = $fila_curso['nombre_decreto'];
	$nombre_decreto_eval = $fila_curso['nombre_decreto_eval'];
	$rolbasededatos  = $fila_curso['rdb']." - ".$fila_curso['dig_rdb'];
	$nu_resolucion = $fila_curso['nu_resolucion'];
	//--------------------------------
	//  ALUMNOS
	//--------------------------------
	$sql_alu = "SELECT alumno.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, matricula.id_curso, matricula.fecha_retiro  ";
	$sql_alu = $sql_alu . "FROM matricula INNER JOIN alumno ON matricula.rut_alumno = alumno.rut_alumno ";
	$sql_alu = $sql_alu . "WHERE (((matricula.id_curso)=".$curso.") AND ((alumno.rut_alumno)='".$alumno."')) ";
	$sql_alu = $sql_alu . "ORDER BY alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu; ";
	$result_alu =@pg_Exec($conn,$sql_alu);
	//-------------------------------- 
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>.</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../util/objeto.css" rel="stylesheet" type="text/css">
</head>
<body>
<STYLE>
 H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always
 }
 
</style>
<?
$cont_alumnos = @pg_numrows($result_alu);
for($cont_paginas=0 ; $cont_paginas < $cont_alumnos  ; $cont_paginas++)
{
	$fila_alu = @pg_fetch_array($result_alu,$cont_paginas);	
	$alumno = $fila_alu['rut_alumno'];
	$rut_alumno = $fila_alu['rut_alumno'] . " - " . strtoupper($fila_alu['dig_rut']);
	$nombre_alu = ucwords(strtoupper(trim($fila_alu['ape_pat']) . " " . trim($fila_alu['ape_mat']) . " " . trim($fila_alu['nombre_alu']))); 
	$curso = $fila_alu['id_curso'];
	$fecha_retiro = $fila_alu['fecha_retiro'];
	
?>
<center>
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
	<div id="capa0">	
	<table width="650" border="0" cellspacing="0" cellpadding="0">
      <tr align="left">
        <td >

          <strong><font face="Arial, Helvetica, sans-serif" size="-1" color="#000099">ESTE REPORTE SE IMPRIME EN HOJA TAMA&Ntilde;O OFICIO </font></strong>
</td>
        <td align="right"><input name="button3" type="button" class="botonX" onClick="imprimir();" onMouseOver=this.style.background='FFFFD7';this.style.color='003b85' onMouseOut=this.style.background='#5c6fa9';this.style.color='ffffff' value="IMPRIMIR"></td>
      </tr>
    </table>	
    </div>	
	<table width="650" border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td width="349" rowspan="2" align="center"><font face="Arial, Helvetica, sans-serif" size="4"><strong>CERTIFICADO ANUAL DE ESTUDIOS</strong></font></td>
		<td width="108"><font face="Arial, Helvetica, sans-serif" size="-1">REGIÓN</font></td>
		<td width="10"><font face="Arial, Helvetica, sans-serif" size="-1"><strong>:</strong></font></td>
		<td width="183"><font face="Arial, Helvetica, sans-serif" size="-1"><strong><? echo $region?></strong></font></td>
	  </tr>
	  <tr>
		<td><font face="Arial, Helvetica, sans-serif" size="-1">PROVINCIA</font></td>
		<td><font face="Arial, Helvetica, sans-serif" size="-1"><strong>:</strong></font></td>
		<td><font face="Arial, Helvetica, sans-serif" size="-1"><strong><? echo $provincia?></strong></font></td>
	  </tr>
	  <tr>
		<td rowspan="2" align="center" valign="top"><font face="Arial, Helvetica, sans-serif" size="3"><? echo $ensenanza_pal; ?></font></td>
		<td><font face="Arial, Helvetica, sans-serif" size="-1">COMUNA</font></td>
		<td><font face="Arial, Helvetica, sans-serif" size="-1"><strong>:</strong></font></td>
		<td><font face="Arial, Helvetica, sans-serif" size="-1"><strong><? echo $comuna?></strong></font></td>
	  </tr>
	  <tr>
		<td><font face="Arial, Helvetica, sans-serif" size="-1">ANO ESCOLAR</font></td>
		<td><font face="Arial, Helvetica, sans-serif" size="-1"><strong>:</strong></font></td>
		<td><font face="Arial, Helvetica, sans-serif" size="-1"><strong><? echo $nro_ano?></strong></font></td>
	  </tr>
	</table>
	<br>
	<table width="650" border="1" cellspacing="0" cellpadding="1">
	  <tr>
		<td><font face="Arial, Helvetica, sans-serif" size="2"><strong><? echo strtoupper($nombre_institu); ?></strong></font></td>
	  </tr>
	  <tr>
		<td align="justify">
		      <font face="Arial, Helvetica, sans-serif" size="-1"> RECONOCIDO OFICIALMENTE POR EL MINISTERIO DE EDUCACI&Oacute;N DE LA REP&Uacute;BLICA DE CHILE SEG&Uacute;N DECRETO <u>N&ordm; 
		      <? echo $nu_resolucion ?></u> ROL BASE DE DATOS <u>Nº <? echo $rolbasededatos?></u> OTORGA EL PRESENTE CERTIFICADO DE CALIFICACIONES ANUALES Y SITUACI&Oacute;N FINAL
		  A <u>DON(A) <? echo $nombre_alu ?> </u> RUN <u><? echo $rut_alumno ?></u> DEL <u><? echo $Curso_pal ?></u> DE ACUERDO AL PLAN DE ESTUDIOS APROBADOS POR EL DECRETO 
		  <u>Nº <? echo $nombre_decreto?></u> REGLAMENTO DE EVALUACIÓN Y PROMOCIÓN ESCOLAR DECRETO <u>Nº <? echo $nombre_decreto_eval ?></u>
		  </font></td>
	  </tr>
	</table>
	<br>
	<table width="650" border="1" cellspacing="0" cellpadding="0">
	  <tr>
		<td rowspan="2"><font face="Arial, Helvetica, sans-serif" size="2"><strong>SUBSECTOR, ASIGNATURA O M&Oacute;DULO </strong></font></td>
		<td colspan="2" align="center"><font face="Arial, Helvetica, sans-serif" size="2"><strong>CALIFICACI&Oacute;N FINAL</strong></font></td>
		</tr>
	  <tr>
		<td width="55" align="center"><font face="Arial, Helvetica, sans-serif" size="2"><strong>CIFRAS</strong></font></td>
		<td width="200"><font face="Arial, Helvetica, sans-serif" size="2"><strong>EN PALABRAS </strong></font></td>
	  </tr>
	  <?
	  //----------------------------------
	  // SUBSECTORES - RAMOS
	  //---------------------------------
	  $sql_ramo = "SELECT ramo.id_ramo, subsector.nombre, ramo.conex, ramo.modo_eval, ramo.cod_subsector ";
	  $sql_ramo = $sql_ramo . "FROM ramo INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector, tiene$nro_ano ";
	  $sql_ramo = $sql_ramo . "WHERE (((ramo.id_curso)=".$curso.") and tiene$nro_ano.rut_alumno = ".$alumno." and tiene$nro_ano.id_ramo = ramo.id_ramo) ";
      $sql_ramo = $sql_ramo . "ORDER BY ramo.id_orden ;";
	  //---------------------------------
	  $result_ramo = @pg_Exec($conn,$sql_ramo);
	  $cont_ramos  = @pg_numrows($result_ramo);
	  for($i=0 ; $i< $cont_ramos  ; $i++)
	  {
		$fila_ramo = @pg_fetch_array($result_ramo,$i);	
		$ramo 			= $fila_ramo['id_ramo'] 	;
		$nombre_ramo 	= $fila_ramo['nombre'] 		;
		$examen 		= $fila_ramo['conex'] 		;
		$modo_eval		= $fila_ramo['modo_eval']	;
		$cod_subsector	= $fila_ramo['cod_subsector']	;
	  ?>
	  <tr>
	    <td ><font face="Arial, Helvetica, sans-serif" size="2"> <? echo "  ".$nombre_ramo?></font></td>
	    <td align="center">
		<?
			$sql_notas = "select promedio from notas$nro_ano ";
			$sql_notas = $sql_notas . "where rut_alumno = '".$alumno."' and id_ramo = ".$ramo;
		    $result_notas = @pg_Exec($conn,$sql_notas);
			$promedio_ramo = 0; $contador = 0;
		    for($con_nota=0 ; $con_nota< @pg_numrows($result_notas); $con_nota++)
		    {
				$fila_notas = @pg_fetch_array($result_notas,$con_nota);	
				$promedio = trim($fila_notas['promedio']);
				if ($modo_eval == 1 ){
					$promedio_ramo = $promedio_ramo + $promedio;
					$contador = $contador  + 1;
				}else{
					$promedio = Conceptual($promedio, 2);
					$promedio_ramo = $promedio_ramo + $promedio;
					$contador = $contador  + 1;					
				}
			}
			if ($promedio_ramo>0)
			{
				$promedio_ramo = round($promedio_ramo / $contador);
				if ($modo_eval == 1 ){
					if ($cod_subsector<>13){
						$suma_promedio = $suma_promedio + $promedio_ramo;
						$contador_suma = $contador_suma + 1;
					}
					$promedio_ramo = substr($promedio_ramo,0,1).".".substr($promedio_ramo,1,1);
				}else{
					$promedio_ramo = Conceptual($promedio_ramo , 1);
				}
			}else{
				$promedio_ramo = "&nbsp;";
			}
		?>
        <font face="Arial, Helvetica, sans-serif" size="-1"><? echo $promedio_ramo;?></font> </td>
	    <td><font face="Arial, Helvetica, sans-serif" size="2"><? 	      
		  if ($promedio_ramo == "&nbsp;")
		  	echo "&nbsp;";
		  else
		  	Palabras($promedio_ramo, 1)?></font></td>
      </tr>
  	  <? } ?>
	  <tr>
	    <td ><font face="Arial, Helvetica, sans-serif" size="-1">PROMEDIO GENERAL </font></td>
	    <td align="center">
		<?
		if ($contador_suma>0){
		$promedio_final = round($suma_promedio/$contador_suma,0);
		$promedio_final = substr($promedio_final,0,1).".".substr($promedio_final,1,1);
		}else{
		}
		?>
        <font face="Arial, Helvetica, sans-serif" size="-1"><? echo $promedio_final ;?>&nbsp;</font> </td>
	    <td><font face="Arial, Helvetica, sans-serif" size="2">
	      <? 
		  if ($promedio_final == "&nbsp;")
		  	echo "&nbsp;";
		  else
		  	Palabras($promedio_final, 1)?>
	    </font>&nbsp;	</td>
	    </tr>
	  <tr>
		<td ><font face="Arial, Helvetica, sans-serif" size="-1">PROMEDIO ASISTENCIA </font></td>
		<?
		//---- asistencia ----
		$sql_asis = "select count(rut_alumno) as inasistencias from asistencia where asistencia.ano = ".$ano." and rut_alumno  = ".$alumno;
		$result_asis =@pg_Exec($conn,$sql_asis);
		$fila_asis = @pg_fetch_array($result_asis,0);	
		$inasistencias = $fila_asis['inasistencias'];
		$dias_efectivos = DiasTrabajados($ano, $fecha_inicio, $fecha_retiro, $conn);
		$dias_trabajados = $dias_efectivos - $inasistencias;
		$asistencia = round(($dias_trabajados * 100)/$dias_efectivos,2)."%";
		//--------------------
		?>
		<td align="center"><font face="Arial, Helvetica, sans-serif" size="-1"><? echo $asistencia ;?></font></td>
		<td>&nbsp;</td>
	  </tr>
	  <tr >
		<td height="41" colspan="3"><font face="Arial, Helvetica, sans-serif" size="2"><strong>SITUACI&Oacute;N FINAL: .......................................................................................................... </strong>
		</font></td>
		</tr>
	</table>
	<br>
	<table width="650" height="119" border="0" cellpadding="0" cellspacing="0">
	  <tr>
		<td height="27"><div align="left"><font size="2"><strong><font face="Arial, Helvetica, sans-serif">Observaciones:</font></strong><font face="Arial, Helvetica, sans-serif" size="2">
		  <?
				echo "EL ALUMNO(A) FUE RETIRADO - ".Cfecha2($fecha_retiro);								
		?>
		</font></font></div></td>
	  </tr>
	  <tr>
		<td height="22"><div align="left"><font size="2"><strong><font face="Arial, Helvetica, sans-serif">_____________________________________________________________________________</font><font size="2"><strong><font face="Arial, Helvetica, sans-serif">__________</font><font size="2"><strong><font face="Arial, Helvetica, sans-serif">_____</font></strong></font></strong></font></strong></font></div></td>
		</tr>
	  <tr>
		<td height="23"><div align="left"><font size="2"><strong><font face="Arial, Helvetica, sans-serif">_____________________________________________________________________________</font><font size="2"><strong><font face="Arial, Helvetica, sans-serif">__________</font><font size="2"><strong><font face="Arial, Helvetica, sans-serif">_____</font></strong></font></strong></font></strong></font></div></td>
		</tr>
				  <tr>
		<td height="23"><div align="left"><font size="2"><strong><font face="Arial, Helvetica, sans-serif">_____________________________________________________________________________</font><font size="2"><strong><font face="Arial, Helvetica, sans-serif">__________</font><font size="2"><strong><font face="Arial, Helvetica, sans-serif">_____</font></strong></font></strong></font></strong></font></div></td>
		</tr>
	  <tr>
		<td><div align="left"><font size="2"><strong><font face="Arial, Helvetica, sans-serif">_____________________________________________________________________________</font><font size="2"><strong><font face="Arial, Helvetica, sans-serif">__________</font><font size="2"><strong><font face="Arial, Helvetica, sans-serif">_____</font></strong></font></strong></font></strong></font></div></td>
		</tr>
	</table>
	<table width="650" border="0" cellpadding="0" cellspacing="0">
	  <tr>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	    </tr>
	<? for($lineas=0; $lineas < (17-$cont_ramos); $lineas++){?>
	  <tr>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
      </tr>
	<? }?> 
	  <tr>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	    </tr>
	  <tr> 
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	  </tr>
	  <tr> 
		<td><div align="center"><strong><font face="Arial, Helvetica, sans-serif" size="2">________________________________</font></strong></div></td>
		<td><div align="center"><strong><font face="Arial, Helvetica, sans-serif" size="2">________________________________</font></strong></div></td>
	  </tr>
	  <tr> 
		<td><div align="center"><font face="Arial, Helvetica, sans-serif" size="2">Profesor(a) 
			Jefe </font></div></td>
		<td><div align="center"><font face="Arial, Helvetica, sans-serif" size="2">Director(a) 
			Establecimiento </font></div></td>
	  </tr>
		<tr>
		<?
		$sql4 = "SELECT empleado.ape_pat, empleado.ape_mat, empleado.nombre_emp FROM supervisa INNER JOIN empleado ON supervisa.rut_emp = empleado.rut_emp ";
		$sql4 = $sql4 . "WHERE (((supervisa.id_curso)=".$curso.")); ";
		$result =@pg_Exec($conn,$sql4);
		$fila = @pg_fetch_array($result,0);	
		$nombre_profe = ucwords(strtoupper(trim($fila['ape_pat']) . " " . trim($fila['ape_mat']) . " " . trim($fila['nombre_emp'])));
		?>
		<td><div align="center"><strong><font face="Arial, Helvetica, sans-serif" size="2"><? echo $nombre_profe; ?> 
			</font></strong></div></td>
		<td><div align="center"><strong><font face="Arial, Helvetica, sans-serif" size="2"> 
		<?
		$sql = "SELECT empleado.ape_pat, empleado.ape_mat, empleado.nombre_emp ";
		$sql = $sql . "FROM trabaja INNER JOIN empleado ON trabaja.rut_emp = empleado.rut_emp ";
		$sql = $sql . "WHERE (((trabaja.rdb)=".$institucion.") AND ((trabaja.cargo)=1)); ";
		$result =@pg_Exec($conn,$sql);
		$fila = @pg_fetch_array($result,0);	
		echo ucwords(strtoupper(trim($fila['ape_pat']) . " " . trim($fila['ape_mat']) . " " . trim($fila['nombre_emp'])));
	?>
			</font></strong></div></td>
	  </tr>
	</table>
	</td>
  </tr>
</table>
<? if  (($cont_alumnos - $cont_paginas)<>1) 
	echo "<H1 class=SaltoDePagina>&nbsp;</H1>";

} ?>
</center>
</body>
</html>
<?
function Palabras($prom, $modo)
{
if (empty($prom)){
		$palabra_completa = "&nbsp;";
}else{		
	if ($modo == 1){
	    for($e=0 ; $e < 3; $e++)
		{
			$numero = substr($prom,$e,1);
			switch ($numero) {
			
			 case ".":				 
				 $palabra[$e] = "COMA";
				 break;				 
			 case "0":
				 $palabra[$e] = "CERO";
				 break;
			 case "1":
				 $palabra[$e] = "UNO";
				 break;
			 case "2":
				 $palabra[$e] = "DOS";
				 break;
			 case "3":
				 $palabra[$e] = "TRES";
				 break;
			 case "4":
				 $palabra[$e] = "CUATRO";
				 break;				 				 				 
			 case "5":
				 $palabra[$e] = "CINCO";
				 break;
			 case "6":
				 $palabra[$e] = "SEIS";
				 break;
			 case "7":
				 $palabra[$e] = "SIETE";
				 break;
			 case "8":
				 $palabra[$e] = "OCHO";
				 break;
			 case "9":
				 $palabra[$e] = "NUEVE";
				 break;				 
			}

		}
	
		$palabra_completa = $palabra[0]." ".$palabra[1]." ".$palabra[2];
	}else{
		switch(trim($prom)){
			case "MB":
				$palabra_completa = "MUY BIEN";
				break;
			case "B":
				$palabra_completa = "BIEN";
				break;
			case "S":
				$palabra_completa = "SUFICIENTE";
				break;
			case "I":
				$palabra_completa = "INSUFICIENTE";												
				break;
		}
	}
}
	if (empty($palabra_completa))
		$palabra_completa = "&nbsp;";
		
	echo  $palabra_completa;
}
?>
<? pg_close($conn);?>