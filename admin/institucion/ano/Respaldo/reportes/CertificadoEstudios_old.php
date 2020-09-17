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
	//------------------------
	// Año Escolar
	//------------------------
	$sql_ano = "select * from ano_escolar where id_ano = ".$ano;
	$result_ano =@pg_Exec($conn,$sql_ano);
	$fila_ano = @pg_fetch_array($result_ano,0);	
	$nro_ano = $fila_ano['nro_ano'];
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
 	$sql_curso = "SELECT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, plan_estudio.nombre_decreto, evaluacion.nombre_decreto_eval, institucion.rdb, institucion.dig_rdb, institucion.nu_resolucion, curso.ensenanza, curso.cod_es,curso.truncado_per ";
	$sql_curso = $sql_curso . "FROM institucion, ((curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo) INNER JOIN plan_estudio ON curso.cod_decreto = plan_estudio.cod_decreto) INNER JOIN evaluacion ON curso.cod_eval = evaluacion.cod_eval ";
 	$sql_curso = $sql_curso . "WHERE (((curso.id_curso)=".$curso.") AND ((institucion.rdb)=".$institucion."));";
	$result_curso =@pg_Exec($conn,$sql_curso);
	$fila_curso = @pg_fetch_array($result_curso,$cont_paginas);
	$curso = $fila_curso['id_curso'];
	$Curso_pal = CursoPalabra($curso, 0, $conn);
	$grado = $fila_curso['grado_curso'];
	$ensenanza = $fila_curso['ensenanza'];
	$ensenanza_pal = $fila_curso['nombre_tipo'];
	$nombre_decreto = $fila_curso['nombre_decreto'];
	$nombre_decreto_eval = $fila_curso['nombre_decreto_eval'];
	$rolbasededatos  = $fila_curso['rdb']." - ".$fila_curso['dig_rdb'];
	$nu_resolucion = $fila_curso['nu_resolucion'];
	$cod_es = $fila_curso['cod_es'];
	$truncado_per=$fila_curso['truncado_per'];
	//-------------------------
	if ($ensenanza>309 and $grado>2){
		$sql_espe = "select * from especialidad where cod_esp = $cod_es";
		$result_espe =@pg_Exec($conn,$sql_espe);
		$fila_espe = @pg_fetch_array($result_espe,0);	
		$especialidad = ", ".$fila_espe['nombre_esp'];
	}
	//--------------------------------
	//  ALUMNOS
	//--------------------------------
	if ($alumno==0){
		$sql_alu = "SELECT alumno.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, matricula.id_curso ";
		$sql_alu = $sql_alu . "FROM matricula INNER JOIN alumno ON matricula.rut_alumno = alumno.rut_alumno ";
		$sql_alu = $sql_alu . "WHERE (((matricula.id_curso)=".$curso.")) ";
		$sql_alu = $sql_alu . "ORDER BY alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu; ";
	}else{
		$sql_alu = "SELECT alumno.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, matricula.id_curso  ";
		$sql_alu = $sql_alu . "FROM matricula INNER JOIN alumno ON matricula.rut_alumno = alumno.rut_alumno ";
		$sql_alu = $sql_alu . "WHERE (((matricula.id_curso)=".$curso.") AND ((alumno.rut_alumno)='".$alumno."')) ";
		$sql_alu = $sql_alu . "ORDER BY alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu; ";
	}
	$result_alu =@pg_Exec($conn,$sql_alu);
	//-------------------------------- 
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>.</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../../util/objeto.css" rel="stylesheet" type="text/css">
</head>
<body>
<STYLE>
 H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always
 }
 
</style>
<center>
	<div id="capa0">	
	<table width="650" border="0" cellspacing="0" cellpadding="0">
      <tr align="left">
        <td >
          <strong><font face="Verdana, Arial, Helvetica, sans-seri" size="-2" color="#000099">ESTE REPORTE SE IMPRIME EN HOJA TAMA&Ntilde;O OFICIO </font></strong>
		</td>
        <td align="right"><input name="button3" type="button" class="botonX" onClick="imprimir();" onMouseOver=this.style.background='FFFFD7';this.style.color='003b85' onMouseOut=this.style.background='#5c6fa9';this.style.color='ffffff' value="IMPRIMIR"></td>
      </tr>
    </table>	
    </div>	

<?
$cont_alumnos = @pg_numrows($result_alu);
for($cont_paginas=0 ; $cont_paginas < $cont_alumnos  ; $cont_paginas++)
{
	$fila_alu = @pg_fetch_array($result_alu,$cont_paginas);	
	$alumno = $fila_alu['rut_alumno'];
	$rut_alumno = $fila_alu['rut_alumno'] . " - " . strtoupper($fila_alu['dig_rut']);
	$nombre_alu = ucwords(strtoupper(trim($fila_alu['ape_pat']) . " " . trim($fila_alu['ape_mat']) . " " . trim($fila_alu['nombre_alu']))); 
	$curso = $fila_alu['id_curso'];
	
?>
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
	<table width="650" border="0" cellspacing="0" cellpadding="0">
	  <tr>
	    <td width="150" rowspan="5" align="left" valign="top">
		<?
			$result_img = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
			$arr=@pg_fetch_array($result_img,0);
			$fila_foto = @pg_fetch_array($result_img,0);
			if 	(!empty($fila_foto['insignia']))
			{
				$output= "select lo_export(".$arr['insignia'].",'/var/www/html/tmp/".$arr[rdb]."');";
				$retrieve_result = @pg_exec($conn,$output);				?>
				<img src=../../../../../../tmp/<?  echo $institucion ?> ALT="NO DISPONIBLE"  height="100" >
 		<?  } ?>
		</td>
		<td width="198" rowspan="5" align="left" valign="top">		
			<div align="center">
				<font face="Verdana, Arial, Helvetica, sans-seri" size="-2"><strong>REP&Uacute;BLICA DE CHILE</strong></font><BR>
			    <font face="Verdana, Arial, Helvetica, sans-seri" size="-2"> MINISTERIO DE EDUCACI&Oacute;N</font><BR>
			    <font face="Verdana, Arial, Helvetica, sans-seri" size="-2"> DIVISI&Oacute;N DE EDUCACI&Oacute;N </font><BR>
			    <font face="Verdana, Arial, Helvetica, sans-seri" size="-2">SECRETARIA REGIONAL MINISTERIAL</font><BR>
			    <font face="Verdana, Arial, Helvetica, sans-seri" size="-2">DE EDUCACI&Oacute;N </font><BR>
		    </div></td>
 <td width="161" rowspan="5"><? //} ?>
   <?
		//$result = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
		//$arr=@pg_fetch_array($result,0);
		//$fila_foto = @pg_fetch_array($result,0);
		//if 	(!empty($fila_foto['insignia']))
		//{
		//	$output= "select lo_export(".$arr['insignia'].",'/var/www/html/tmp/".$arr[rdb]."');";
		//	$retrieve_result = @pg_exec($conn,$output);?></td>			
		<td width="90"><font face="Verdana, Arial, Helvetica, sans-seri" size="-2">REGIÓN</font></td>
		<td width="10"><font face="Verdana, Arial, Helvetica, sans-seri" size="-2"><strong>:</strong></font></td>
		<td width="191"><font face="Verdana, Arial, Helvetica, sans-seri" size="-2"><strong><? echo $region?></strong></font></td>
	   

	  </tr>
	  <tr>
		<td><font face="Verdana, Arial, Helvetica, sans-seri" size="-2">PROVINCIA</font></td>
		<td><font face="Verdana, Arial, Helvetica, sans-seri" size="-2"><strong>:</strong></font></td>
		<td><font face="Verdana, Arial, Helvetica, sans-seri" size="-2"><strong><? echo $provincia?></strong></font></td>
	    </tr>
	  <tr>
		<td><font face="Verdana, Arial, Helvetica, sans-seri" size="-2">COMUNA</font></td>
		<td><font face="Verdana, Arial, Helvetica, sans-seri" size="-2"><strong>:</strong></font></td>
		<td><font face="Verdana, Arial, Helvetica, sans-seri" size="-2"><strong><? echo $comuna?></strong></font></td>
	    </tr>
	  <tr>
		<td><font face="Verdana, Arial, Helvetica, sans-seri" size="-2">A&Ntilde;O ESCOLAR</font></td>
		<td><font face="Verdana, Arial, Helvetica, sans-seri" size="-2"><strong>:</strong></font></td>
		<td><font face="Verdana, Arial, Helvetica, sans-seri" size="-2"><strong><? echo $nro_ano?></strong></font></td>
	    </tr>
	  <tr>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	    </tr>
	</table>
	<table width="650" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td align="center"><font face="Verdana, Arial, Helvetica, sans-seri" size="4"><strong>CERTIFICADO ANUAL DE ESTUDIOS</strong></font></td>
      </tr>
      <tr >
        <td align="center"><font face="Verdana, Arial, Helvetica, sans-seri" size="3"><? echo $ensenanza_pal; ?></font></td>
      </tr>
    </table>	<br>
	<table width="650" border="0" cellspacing="1" cellpadding="1">
	  <tr>
		<td align="center"><font face="Verdana, Arial, Helvetica, sans-seri" size="-1"><strong><? echo strtoupper($nombre_institu); ?></strong></font></td>
	  </tr>
	  <tr>
		<td align="justify">
		      <font face="Verdana, Arial, Helvetica, sans-seri" size="-1"> Reconocido oficialmente por el Ministerio de Educación de la República de Chile según decreto <strong>N&ordm; 
		      <? echo $nu_resolucion ?></strong> Rol Base de Datos <strong>Nº <? echo $rolbasededatos?></strong> otorga el presente Certificado de Calificaciones Anuales y Situación Final a 
			   <u>DON(A) <strong><? echo $nombre_alu ?></strong> </u> Run <strong><? echo $rut_alumno ?></strong> del <strong><? echo $Curso_pal . $especialidad ?></strong> de acuerdo al plan de estudios aprobados por el Decreto 
			   <strong>Nº <? echo $nombre_decreto?></strong> Reglamento de Evaluación y Promoción Escolar Decreto <strong>Nº <? echo $nombre_decreto_eval ?></strong>
		  </font></td>
	  </tr>
	</table>
	<br>
	<table width="650" border="1" cellspacing="0" cellpadding="0">
	  <tr>
		<td rowspan="2"><font face="Verdana, Arial, Helvetica, sans-seri" size="-2"><strong>SUBSECTOR, ASIGNATURA O M&Oacute;DULO </strong></font></td>
		<td colspan="2" align="center"><font face="Verdana, Arial, Helvetica, sans-seri" size="-2"><strong>CALIFICACI&Oacute;N FINAL</strong></font></td>
		</tr>
	  <tr>
		<td width="55" align="center"><font face="Verdana, Arial, Helvetica, sans-seri" size="-2"><strong>CIFRAS</strong></font></td>
		<td width="200"><font face="Verdana, Arial, Helvetica, sans-seri" size="-2"><strong>EN PALABRAS </strong></font></td>
	  </tr>
	  <?
	  //----------------------------------
	  // SUBSECTORES - RAMOS
	  //---------------------------------
	  $sql_ramo = "SELECT ramo.cod_subsector, ramo.id_ramo, subsector.nombre, ramo.conex, ramo.modo_eval, ramo.sub_obli ";
	  $sql_ramo = $sql_ramo . "FROM ramo, subsector where ramo.id_curso = $curso and ramo.cod_subsector = subsector.cod_subsector ";
      $sql_ramo = $sql_ramo . "ORDER BY ramo.id_orden; ";
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
		$sub_obli 		= $fila_ramo['sub_obli']	;
		$cod_subsector  = $fila_ramo['cod_subsector']	;
	  ?>
	  <tr>
	    <td ><font face="Verdana, Arial, Helvetica, sans-seri" size="-2"> <? echo "  ".$nombre_ramo?></font></td>
	    <td align="center">
		<?
		if ($examen == 2){ // Ramo sin examen (consulta en tabla notas)
			$sql_notas = "select *  from notas$nro_ano, tiene$nro_ano ";
			$sql_notas = $sql_notas . "where notas$nro_ano.rut_alumno = '".$alumno."' and notas$nro_ano.id_ramo = ".$ramo." and tiene$nro_ano.id_ramo = $ramo and tiene$nro_ano.rut_alumno ='". $alumno . "'";
		    $result_notas = @pg_Exec($conn,$sql_notas);

			$promedio_ramo = 0; $contador = 0;
		    for($con_nota=0 ; $con_nota< @pg_numrows($result_notas); $con_nota++)
		    {
				$fila_notas = @pg_fetch_array($result_notas,$con_nota);	
				$promedio = trim($fila_notas['promedio']);
				if ($modo_eval == 1 and $promedio>0){
					$promedio_ramo = $promedio_ramo + $promedio;
					$contador = $contador  + 1;
				}
				
				if ((($modo_eval == 2)||($modo_eval == 3))&& (chop($promedio)!="0")){
					 $promedio = Conceptual($promedio, 2);
					$promedio_ramo = $promedio_ramo + $promedio;
					$contador = $contador  + 1;					
				}
			}
			if ($promedio_ramo>0)
			{
				if ($truncado_per==0){
					$promedio_ramo = floor($promedio_ramo / $contador);
					if($institucion==1517){ 
						switch ($promedio_ramo){
							case 19: $promedio_ramo=20; break;
							case 29: $promedio_ramo=30; break;
							case 39: $promedio_ramo=40; break;
							case 49: $promedio_ramo=50; break;
							case 59: $promedio_ramo=60; break;
							case 69: $promedio_ramo=70; break;
						}
					}
	
				}
				if ($truncado_per==1){
					$promedio_ramo = round($promedio_ramo / $contador);
					if($institucion==1517){ 
						switch ($promedio_ramo){
							case 19: $promedio_ramo=20; break;
							case 29: $promedio_ramo=30; break;
							case 39: $promedio_ramo=40; break;
							case 49: $promedio_ramo=50; break;
							case 59: $promedio_ramo=60; break;
							case 69: $promedio_ramo=70; break;
						}
					}
				
				}
				//$promedio_ramo = round($promedio_ramo / $contador);
			

				
				if ($modo_eval == 1 ){
					$promedio_ramo = substr($promedio_ramo,0,1).".".substr($promedio_ramo,1,1);
					
				}else{
						$promedio_ramo = Conceptual($promedio_ramo , 1);
						
				}
			}else{
				$promedio_ramo = "&nbsp;";
				if ($sub_obli == 1 or $cod_subsector==13){
					$sql_eximidos = "select * from tiene$nro_ano where id_ramo = $ramo and rut_alumno ='". $alumno . "'";
					$result_eximidos = @pg_Exec($conn,$sql_eximidos);				
					if (@pg_numrows($result_eximidos)==0)
						$promedio_ramo = "NO";
				}
			}
		}else{ // Ramo con examen (consulta en tabla situacion_final)
			$sql_notas = "select situacion_final.nota_final as promedio from situacion_final where situacion_final.id_ramo = ".$ramo." ";
			$sql_notas = $sql_notas . "and situacion_final.rut_alumno = '".$alumno."'";
		    $result_notas = @pg_Exec($conn,$sql_notas);
			$promedio_ramo = 0; $contador = 0;
			$fila_notas = @pg_fetch_array($result_notas,0);
			$promedio_ramo = $fila_notas['promedio'];
			if ($promedio_ramo>0)
			{
				if ($modo_eval == 1 ){
					$promedio_ramo = substr($promedio_ramo,0,1).".".substr($promedio_ramo,1,1);
				}else{
					$promedio_ramo = Conceptual($promedio_ramo , 1);
				}
			}else{
				$promedio_ramo = "&nbsp;";
				if ($sub_obli == 1 or $cod_subsector==13){
					$sql_eximidos = "select * from tiene$nro_ano where id_ramo = $ramo and rut_alumno = '" . $alumno . "'";
					$result_eximidos = @pg_Exec($conn,$sql_eximidos);				
					if (@pg_numrows($result_eximidos)==0)
						$promedio_ramo = "&nbsp;";
				}				
			}			
		}
		?>
        <font face="Verdana, Arial, Helvetica, sans-seri" size="-2"><? echo $promedio_ramo;?></font> </td>
	    <td><font face="Verdana, Arial, Helvetica, sans-seri" size="-2"><? Palabras($promedio_ramo, $modo_eval)?></font></td>
      </tr>
  	  <? } ?>
	  <tr>
	    <td ><font face="Verdana, Arial, Helvetica, sans-seri" size="-2">PROMEDIO GENERAL </font></td>
	    <td align="center">
		<?
		$sql_final = "select promedio, asistencia, situacion_final from promocion where promocion.rut_alumno = '".$alumno . "'";
		$sql_final = $sql_final . "and promocion.id_ano = $ano ";
		$result_final = @pg_Exec($conn,$sql_final);
		$fila_final = @pg_fetch_array($result_final,0);
		if ($fila_final['promedio']>0){
			$promedio_final = substr($fila_final['promedio'],0,1).".".substr($fila_final['promedio'],1,1);
			$asistencia = $fila_final['asistencia']."%"; 
			$situacion_final = $fila_final['situacion_final'];
		}else{
			$promedio_final = "&nbsp;";
			$asistencia = "&nbsp;";
		}
		?>
        <font face="Verdana, Arial, Helvetica, sans-seri" size="-2"><? echo $promedio_final ;?></font> </td>
	    <td><font face="Verdana, Arial, Helvetica, sans-seri" size="-2">
	      <? Palabras($promedio_final, 1)?>
	    </font></td>
	    </tr>
	  <tr>
		<td ><font face="Verdana, Arial, Helvetica, sans-seri" size="-2">PROMEDIO ASISTENCIA </font></td>
		<td align="center"><font face="Verdana, Arial, Helvetica, sans-seri" size="-2"><? echo $asistencia ;?></font></td>
		<td>&nbsp;</td>
	  </tr>
	  <tr >
		    <td height="28" colspan="3"><font face="Verdana, Arial, Helvetica, sans-seri" size="-2"><strong>EN 
              CONSECUENCIA: </strong> 
              <?
			    if (($ensenanza==560) and ($grado==1)) {  
				$grado=$grado+1; 
				} 

			$situacion_pal = "EL ALUMNO(A) HA SIDO PROMOVIDO A ".($grado+1)."º AÑO DE LA ".strtoupper($ensenanza_pal);
		
			if ($grado == 8)
				$situacion_pal = "EL ALUMNO(A) HA SIDO LICENCIADO DE LA ".strtoupper($ensenanza_pal);

			if ($grado==4 and $ensenanza>309)
	            $situacion_pal = "EL ALUMNO(A) HA SIDO LICENCIADO DE LA ".strtoupper($ensenanza_pal);
			
		if  ($ensenanza==361){
			if ($grado == 1)
				$situacion_pal = "EL ALUMNO(A) HA SIDO PROMOVIDO A SEGUNDO CICLO DE LA ".strtoupper($ensenanza_pal);
			if ($grado == 2)
				$situacion_pal = "EL ALUMNO(A) HA SIDO LICENCIADO DE LA ".strtoupper($ensenanza_pal);
		}
		
		if  ($ensenanza==110 and $grado == 8){
				$situacion_pal = "EL ALUMNO(A) HA SIDO PROMOVIDO A ENSEÑANZA MEDIA";
		}		
		
		if ($situacion_final==1)
				echo $situacion_pal;
			if ($situacion_final==2)
				echo "EL ALUMNO(A) HA SIDO REPROBADO";
			if ($situacion_final==3)
				echo "EL ALUMNO(A) FUE RETIRADO";
		?>
              </font></td>
		</tr>
	</table>
	<br>
	<table width="650" height="114" border="0" cellpadding="0" cellspacing="0">
	  <tr>
		<td height="22"><div align="left"><font size="2"><strong><font face="Verdana, Arial, Helvetica, sans-seri">Observaciones:___________________________________________________________</font></strong></font></div></td>
	  </tr>
	  <tr>
		<td height="22"><div align="left"><font size="2"><strong><font face="Verdana, Arial, Helvetica, sans-seri">________________________________________________________________________</font></strong></font></div></td>
		</tr>
	  <tr>
		<td height="23"><div align="left"><font size="2"><strong><font face="Verdana, Arial, Helvetica, sans-seri">________________________________________________________________________</font></strong></font></div></td>
		</tr>
				  <tr>
		<td height="23"><div align="left"><font size="2"><strong><font face="Verdana, Arial, Helvetica, sans-seri">________________________________________________________________________</font></strong></font></div></td>
		</tr>
	</table>
	<table width="650" border="0" cellpadding="0" cellspacing="0">
	  <tr>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	    </tr>
	<? for($lineas=0; $lineas < (14-$cont_ramos); $lineas++){?>
	  <tr>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
      </tr>
	<? }?> 
	  <tr>
<!--	    <td>&nbsp;</td>		-->
	    <td>&nbsp;</td>
	    </tr>
	  <tr> 
		<td><div align="center"><strong><font face="Verdana, Arial, Helvetica, sans-seri" size="2">________________________________</font></strong></div></td>
		<td><div align="center"><strong><font face="Verdana, Arial, Helvetica, sans-seri" size="2">________________________________</font></strong></div></td>
	  </tr>
	  <tr> 
		<td><div align="center"><font face="Verdana, Arial, Helvetica, sans-seri" size="-2">Profesor(a) 
			Jefe </font></div></td>
		<td><div align="center"><font face="Verdana, Arial, Helvetica, sans-seri" size="-2"><? if ($institucion==9566){?>Vice-Rector del Establecimiento<? } else {?>Director(a) 
			Establecimiento<? }?> </font></div></td>
	  </tr>
	  <tr> 
		<?
		$sql4 = "SELECT empleado.ape_pat, empleado.ape_mat, empleado.nombre_emp FROM supervisa INNER JOIN empleado ON supervisa.rut_emp = empleado.rut_emp ";
		$sql4 = $sql4 . "WHERE (((supervisa.id_curso)=".$curso.")); ";
		$result =@pg_Exec($conn,$sql4);
		$fila = @pg_fetch_array($result,0);	
		$nombre_profe = ucwords(strtoupper(trim($fila['ape_pat']) . " " . trim($fila['ape_mat']) . " " . trim($fila['nombre_emp'])));
		?>
		<td><div align="center"><strong><font face="Verdana, Arial, Helvetica, sans-seri" size="-2"><? echo $nombre_profe; ?> 
			</font></strong></div></td>
		<td><div align="center"><strong><font face="Verdana, Arial, Helvetica, sans-seri" size="-2"> 
		<?
		if ($institucion == 9566){
			echo "PAVÉZ MENESES ROBERTO";
		} else {
		$sql = "SELECT empleado.ape_pat, empleado.ape_mat, empleado.nombre_emp ";
		$sql = $sql . "FROM trabaja INNER JOIN empleado ON trabaja.rut_emp = empleado.rut_emp ";
		$sql = $sql . "WHERE (((trabaja.rdb)=".$institucion.") AND ((trabaja.cargo)=1)); ";
		$result =@pg_Exec($conn,$sql);
		$fila = @pg_fetch_array($result,0);	
		echo ucwords(strtoupper(trim($fila['ape_pat']) . " " . trim($fila['ape_mat']) . " " . trim($fila['nombre_emp'])));
		}
	?>
			</font></strong></div></td>
	  </tr>
		<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	  </tr>
		<tr>
		    <td><font face="Verdana, Arial, Helvetica, sans-seri" size="-1"><? echo ucwords(strtolower($comuna)).", ".strftime("%d",time())." de ".ucwords(strftime("%B",time()))." de ".strftime("%Y",time()) ?></font></td>
		  <td>&nbsp;</td>
		  </tr>
		<tr>
		    <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  </tr>
	</table>
	</td>
  </tr>
</table>
<? if  (($cont_alumnos - $cont_paginas)<>1) 
	echo "<H1 class=SaltoDePagina></H1>";

} ?>
</center>
</body>
</html>
<?
function Palabras($prom, $modo)
{
	$palabra_completa = "";
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
				$palabra_completa = "MUY BUENO";
				break;
			case "B":
				$palabra_completa = "BUENO";
				break;
			case "S":
				$palabra_completa = "SUFICIENTE";
				break;
			case "I":
				$palabra_completa = "INSUFICIENTE";												
				break;
		}
	}
	if($prom=="NO")
		$palabra_completa="NO OPTA";
	if ($prom=="EX")
		$palabra_completa = "EXIMIDO DEL SUBSECTOR";
	if (chop($palabra_completa)=="")
		$palabra_completa = "&nbsp;";
		
	echo  $palabra_completa;
}
?>
<? pg_close($conn);?>