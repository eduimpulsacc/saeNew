<?  
require('../../../../util/header.inc');

?>
<script>
function imprimir() 
{

	document.getElementById("capa0").style.display='none';
	window.print();

	document.getElementById("capa0").style.display='block';
}
	</script>
<?php 
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$cmb_curso;
	if ($curso==0) exit;
	
	//------------------------
	// Año Escolar
	//------------------------
	$sql_ano = "select * from ano_escolar where id_ano = ".$ano;
	$result_ano =@pg_Exec($conn,$sql_ano);
	$fila_ano = @pg_fetch_array($result_ano,0);	
	$ano_escolar = $fila_ano['nro_ano'];
	//-------------- INSTITUCION -------------------------------------------------------------
	$sql_ins = "SELECT institucion.dig_rdb, institucion.nombre_instit, institucion.calle, institucion.nro, date_part('year',institucion.fecha_resolucion)as fecha_res, region.nom_reg, provincia.nom_pro, comuna.nom_com, institucion.telefono, institucion.nu_resolucion ";
	$sql_ins = $sql_ins . "FROM ((institucion INNER JOIN region ON institucion.region = region.cod_reg) INNER JOIN provincia ON (institucion.ciudad = provincia.cor_pro) AND (institucion.region = provincia.cod_reg)) INNER JOIN comuna ON (institucion.region = comuna.cod_reg) AND (institucion.ciudad = comuna.cor_pro) AND (institucion.comuna = comuna.cor_com) ";
	$sql_ins = $sql_ins . "WHERE (((institucion.rdb)=".$institucion.")); ";
	$result_ins =@pg_Exec($conn,$sql_ins);
	$fila_ins = @pg_fetch_array($result_ins,0);	
	$ins_pal = $fila_ins['nombre_instit'];
	$rdb = $institucion."-".$fila_ins['dig_rdb'];
	$direccion = $fila_ins['calle'] . " " . $fila_ins['nro'] . " " . $fila_ins['nom_com'];
	$telefono = $fila_ins['telefono'];
	$resolucion = $fila_ins['nu_resolucion'];
	$fecha_res = $fila_ins['fecha_res'];
	$comuna = $fila_ins['nom_com'];
	$ciudad = $fila_ins['nom_pro'];
	$region= $fila_ins['nom_reg'];
	//-------
	$sql_curso = "select curso.grado_curso, curso.letra_curso,  tipo_ensenanza.nombre_tipo, plan_estudio.nombre_decreto, evaluacion.nombre_decreto_eval, curso.ensenanza, curso.cod_es ";
	$sql_curso = $sql_curso . "from curso, tipo_ensenanza, plan_estudio, evaluacion ";
	$sql_curso = $sql_curso . "where id_curso = ".$curso." and curso.ensenanza = tipo_ensenanza.cod_tipo ";
	$sql_curso = $sql_curso . "and plan_estudio.cod_decreto = curso.cod_decreto ";
	$sql_curso = $sql_curso . "and evaluacion.cod_eval = curso.cod_eval ";
	$result_curso =@pg_Exec($conn,$sql_curso);
	$fila_curso = @pg_fetch_array($result_curso,0);
	$curso_pal = $fila_curso['grado_curso']."-".$fila_curso['letra_curso'];
	$grado_curso = $fila_curso['grado_curso'];
	$tipo_ensenanza = $fila_curso	['nombre_tipo'];
	$plan_estudio =  $fila_curso['nombre_decreto'];
	$decreto_eval =  $fila_curso['nombre_decreto_eval'];
	$ense = $fila_curso['ensenanza'];
	$cod_es = $fila_curso['cod_es'];
	//-------------------------
	if ($ense>309 and $grado_curso>2){
		$sql_espe = "select * from especialidad where cod_esp = $cod_es";
		$result_espe =@pg_Exec($conn,$sql_espe);
		$fila_espe = @pg_fetch_array($result_espe,0);	
		$especialidad = ucwords(strtolower(", ".$fila_espe['nombre_esp']));
	}
	//--------------------------------	
	//---------
	if (($grado_curso==1 or $grado_curso==2) and $ense == 110) $nb = "NB1";
	if (($grado_curso==3 or $grado_curso==4) and $ense == 110) $nb = "NB2";	
	if (($grado_curso==5) and $ense == 110) $nb = "NB3";
	if (($grado_curso==6) and $ense == 110) $nb = "NB4";
	if (($grado_curso==7) and $ense == 110) $nb = "NB5";
	if (($grado_curso==8) and $ense == 110) $nb = "NB6";
	//-------
	if (($grado_curso==1) and $ense > 300 ) $nb = "NM1";
	if (($grado_curso==2) and $ense > 300 ) $nb = "NM2";
	if (($grado_curso==3) and $ense > 300 ) $nb = "NM3";
	if (($grado_curso==4) and $ense > 300 ) $nb = "NM4";	
	//-------
	$sql_alumnos = "select upper(alumno.ape_pat) as ape_pat, upper(alumno.ape_mat) as ape_mat, upper(alumno.nombre_alu) as nombre_alu, matricula.rut_alumno, upper(alumno.dig_rut) as dig_rut, alumno.sexo, alumno.fecha_nac, comuna.nom_com, matricula.id_curso, matricula.bool_ar ";
	$sql_alumnos = $sql_alumnos . "from matricula, alumno, comuna ";
	$sql_alumnos = $sql_alumnos . "where matricula.id_curso = ".$curso." and matricula.rut_alumno = alumno.rut_alumno ";
	$sql_alumnos = $sql_alumnos . "and comuna.cor_com = alumno.comuna and comuna.cod_reg = alumno.region and comuna.cor_pro = alumno.ciudad and ((matricula.bool_ar=1 and matricula.fecha_retiro > '04-30-".$ano_escolar."') or (matricula.bool_ar=0))";
	$sql_alumnos = $sql_alumnos . "order by alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu ";
	$rsAlumnos =@pg_Exec($conn,$sql_alumnos);
//---------
//------------ PROFESOR  JEFE ---------------
$qry = "";
$qry = "SELECT empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat FROM curso INNER JOIN (empleado INNER JOIN supervisa ON empleado.rut_emp = supervisa.rut_emp) ON curso.id_curso = supervisa.id_curso WHERE (((curso.id_curso)=" . $cmb_curso ."))";
$Rs_Profe =@pg_exec($conn,$qry);
$fila_Profe = @pg_fetch_array($Rs_Profe,0);
$Nombre_Profe = trim($fila_Profe['nombre_emp'])." ".trim($fila_Profe['ape_pat'])." ".trim($fila_Profe['ape_mat']);
//--------
//----------- DIRECTOR ----------------------
$qry="";
$qry = "SELECT empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat FROM (empleado INNER JOIN trabaja ON empleado.rut_emp = trabaja.rut_emp) INNER JOIN institucion ON trabaja.rdb = institucion.rdb WHERE (((institucion.rdb)=" . $institucion . ") and cargo=1)";
$Rs_Dir	= @pg_exec($conn,$qry);
$fila_Dir = @pg_fetch_array($Rs_Dir,0);
$Nombre_Dir = trim($fila_Dir['nombre_emp'])." ".trim($fila_Dir['ape_pat'])." ". trim($fila_Dir['ape_mat']);

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<link href="../../../../util/objeto.css" rel="stylesheet" type="text/css">
<style type="text/css"></style>
</head>

<body > 

<style>
 H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always
 }
 
</style>
<div align="right">
<div id="capa0">
<table width="1075" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="left"><font face="Arial, Helvetica, sans-serif" size="-1" color="#000066"><strong>ESTE INFORME DEBE IMPRIMIRSE EN HOJA TAMA&Ntilde;O OFICIO</strong></font>
		</td>
        <td align="right"><div id="capa0">
          <input name="button3" type="button" class="botonX" onClick="imprimir();" onMouseOver=this.style.background='FFFFD7';this.style.color='003b85' onMouseOut=this.style.background='#5c6fa9';this.style.color='ffffff' value="IMPRIMIR">
        </div></td>
      </tr>
  </table>
</div>
      <table width="1075"  border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="145" rowspan="4" align="left" valign="top"><font face="Arial, Helvetica, sans-serif" size="1"><strong>REP&Uacute;BLICA DE CHILE</strong></font><font face="Arial, Helvetica, sans-serif" size="-2"><strong> MINISTERIO DE EDUCACI&Oacute;N</strong></font><font face="Arial, Helvetica, sans-serif" size="-2"><strong> DIVISI&Oacute;N DE EDUCACI&Oacute;N </strong></font><font face="Arial, Helvetica, sans-serif" size="-2"><strong>SECRETARIA REGIONAL </strong></font><font face="Arial, Helvetica, sans-serif" size="-2"><strong>MINISTERIAL</strong></font><font face="Arial, Helvetica, sans-serif" size="-2"><strong>DE EDUCACI&Oacute;N </strong></font></td>
          <td width="10" rowspan="4" align="left">&nbsp;</td>
          <td width="693" align="left"><font face="Arial, Helvetica, sans-serif" size="1"><strong>ACTA DE CALIFICACIONES FINALES Y PROMOCI&Oacute;N ESCOLAR </strong></font></td>
          <td width="252" colspan="2" rowspan="4" align="left" valign="top"><table width="100%"  border="1" cellspacing="0" cellpadding="0">
              <tr>
                <td colspan="2"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td align="center"><span class="titulo"><span class="detalle"><u><? echo $region ?></u></span></span></td>
                      <td align="center"><span class="titulo"><span class="detalle"><u><? echo $ciudad ?></u></span></span></td>
                    </tr>
                    <tr>
                      <td align="center"><span class="detalle">REGI&Oacute;N</span></td>
                      <td align="center"><span class="detalle">PROVINCIA</span></td>
                    </tr>
                    <tr>
                      <td align="center"><span class="titulo"><span class="detalle"><u><? echo $comuna ?></u></span></span></td>
                      <td align="center"><span class="titulo"><span class="detalle"><u><? echo $ano_escolar ?></u></span></span></td>
                    </tr>
                    <tr>
                      <td align="center"><span class="detalle">COMUNA</span></td>
                      <td align="center"><span class="detalle">A&Ntilde;O ESCOLAR </span></td>
                    </tr>
                    <tr>
                      <td height="30" colspan="2" align="center" valign="top"><span class="titulo">Curso</span> <span class="titulo"><? echo $curso_pal . " " . $nb?></span></td>
                    </tr>
                </table></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td align="left"><font face="Arial, Helvetica, sans-serif" size="1"><strong><? echo $tipo_ensenanza . $especialidad?></strong></font></td>
        </tr>
        <tr>
          <td align="left"><font face="Arial, Helvetica, sans-serif" size="1"><strong><? echo $ins_pal ?></strong></font></td>
        </tr>
        <tr>
          <td valign="top"  align="left"><font face="Arial, Helvetica, sans-serif" size="1">RECONOCIDO OFICIALMENTE POR EL MINISTERIO DE EDUCACI&Oacute;N DE LA REP&Uacute;BLICA DE CHILE SEG&Uacute;N DECRETO <u>Nº <? echo $resolucion?> del <? echo $fecha_res ?> </u>ROL BASE DE DATOS <u>Nº<? echo $rdb?> </u>PLAN DE ESTUDIOS APROBADOS POR DECRETO <u>Nº <? echo $plan_estudio?></u> Y DEL REGLAMENTO DE EVALUACIÓN Y PROMOCION ESCOLAR DECRETO EXENTO <u>Nº <? echo $decreto_eval?></u></font></td>
        </tr>
      </table>

      <table width="1075"  border="1" cellspacing="0" cellpadding="0">
        <tr>
          <td>&nbsp;</td>
          <td valign="top" class="titulo">NOMINA DE ALUMNOS </td>
          <td class="titulo" valign="top">RUN</td>
          <td class="titulo" valign="top" width="20">COD RUN </td>
          <td class="titulo" valign="top" width="27">SEXO</td>
          <td class="titulo" valign="top" width="40">FEC NAC </td>
          <td class="titulo" valign="top">COMUNA RESIDENCIA </td>
          <?
// nuevo2
		$sql_aprox = "SELECT truncado_per FROM curso WHERE id_curso=".$curso."";		  
		$rs_aprox = @pg_Exec($conn,$sql_aprox);
		$fil_aprox = @pg_fetch_array($rs_aprox,0);
		$aprox = $fil_aprox['truncado_per'];
// fin nuevo2

	$sql_subsectores = "select * from subsector_ramo where id_curso = ".$curso." and (bool_ip = 1 or cod_subsector = 13) order by id_orden";
	$rsSubsectores=@pg_Exec($conn,$sql_subsectores);
	$cantidad_subsectores = @pg_numrows($rsSubsectores);
	for($e=0 ; $e < @pg_numrows($rsSubsectores) ; $e++)
	{
		$fSubsectores= @pg_fetch_array($rsSubsectores,$e);
		$cod_subsector = $fSubsectores['cod_subsector'];
		$id_ramo = $fSubsectores['id_ramo'];
		$sub_obli = $fSubsectores['sub_obli'];
	
			if($cod_subsector!=13){?>
          <td class="titulo" valign="top"><? echo $cod_subsector?></td>
          <? }}?>
          <td align="center" valign="top"><img src="promedio-general.gif" width="11" height="61"></td>
    <? 
	for($e=0 ; $e < @pg_numrows($rsSubsectores) ; $e++)
	{
		$fSubsectores= @pg_fetch_array($rsSubsectores,$e);
		$cod_subsector = $fSubsectores['cod_subsector'];
		$id_ramo = $fSubsectores['id_ramo'];
		$sub_obli = $fSubsectores['sub_obli'];
		
	
			if($cod_subsector==13){
				$religion=$id_ramo;	?>
          <td class="titulo" valign="top"><? echo $cod_subsector?></td>
          <? }}?>
    
	      <td align="center" valign="top"><img src="asistencia.gif"></td>
          <td align="center" valign="top"><img src="situacion-final.gif" width="11" height="59"></td>
          <td class="titulo" valign="top">OBSERVACIONES</td>
        </tr>
        <?
  	if (@pg_numrows($rsAlumnos)<30)
	  $espacio_lineas = 15;
  	if (@pg_numrows($rsAlumnos)>29)
	  $espacio_lineas = 5;
	for($i=0 ; $i < @pg_numrows($rsAlumnos) ; $i++)
	{
		$fAlumno = @pg_fetch_array($rsAlumnos,$i);
		$alumno = trim($fAlumno['rut_alumno']);
		$curso = $fAlumno['id_curso'];
		$sql_promocion = "select promedio, asistencia, situacion_final, observacion from promocion where rut_alumno = ".$alumno." and id_curso = ".$curso;
		$rsPromocion=@pg_Exec($conn,$sql_promocion);
		$fPromocion = @pg_fetch_array($rsPromocion,0);	
		$promedio = $fPromocion['promedio'];
		if (!empty($promedio)) $promedio = substr($promedio,0,1).".".substr($promedio,1,1); else $promedio = "&nbsp;";
		if (!empty($fPromocion['asistencia'])) $asistencia = $fPromocion['asistencia']."%"; else $asistencia = "&nbsp;";
		$situacion_final = $fPromocion['situacion_final'];
		if ($situacion_final==1) $situacion_final = "P";
		if ($situacion_final==2) $situacion_final = "R";
		if ($situacion_final==3) $situacion_final = "Y";
		if (!empty($fPromocion['observacion'])) $observacion = $fPromocion['observacion']; else $observacion = "&nbsp;";
  ?>
        <tr>
          <td class="detalle" height=<? echo $espacio_lineas?>><? echo $i+1 ?></td>
          <td class="detalle"><? echo trim($fAlumno['ape_pat']) . " " . trim($fAlumno['ape_mat'] ). " " . trim($fAlumno['nombre_alu']) ?></td>
          <td class="detalle"><? echo $fAlumno['rut_alumno'] ?></td>
          <td class="detalle"><? echo $fAlumno['dig_rut']."&nbsp;" ?></td>
          <td class="detalle"><?  if ($fAlumno['sexo']==1){ echo "2"; }else{ echo "1";} ?></td>
          <td class="detalle"><? echo Cfecha2($fAlumno['fecha_nac']) ?></td>
          <td class="detalle"><? echo $fAlumno['nom_com'] ?></td>
          <?
	for($e=0 ; $e < $cantidad_subsectores ; $e++)
	{
		$fSubsectores= @pg_fetch_array($rsSubsectores,$e);
		$cod_subsector = $fSubsectores['cod_subsector'];
		$id_ramo = $fSubsectores['id_ramo'];
		$modo_eval = $fSubsectores['modo_eval']; 
		$conex = $fSubsectores['conex']; // 1 si 2 no
		$sql_eximido = "select count(*) as cantidad from tiene$ano_escolar where rut_alumno = ".$alumno." and id_ramo = ".$id_ramo." and id_curso = ".$curso;
		$rsEximido=@pg_Exec($conn,$sql_eximido);
		$fEximido= @pg_fetch_array($rsEximido,0);		
		if ($fEximido['cantidad']>0){
			if ($conex==1){
				$sql_notas = "select * from situacion_final where id_ramo = ".$id_ramo." and rut_alumno = ".$alumno."";
				$rsNotas=@pg_Exec($conn,$sql_notas);
				$fNotas= @pg_fetch_array($rsNotas,0);
				if ($fNotas['nota_final']>0) $promedio_nota = $fNotas['nota_final']; else $promedio_nota = "&nbsp;";
			}else{
				$sql_notas = "select promedio from notas$ano_escolar where rut_alumno = ".$alumno." and id_ramo = ".$id_ramo;
				$rsNotas=@pg_Exec($conn,$sql_notas);				
				$suma_promedios = 0; $con_notas = 0;
				for($u=0 ; $u < @pg_numrows($rsNotas) ; $u++)
				{
					$fNotas = @pg_fetch_array($rsNotas,$u);
					if ($modo_eval==1){//numerico
						$suma_promedios = $suma_promedios + $fNotas['promedio'];
						if ($fNotas['promedio']>0){
						$con_notas = $con_notas + 1;
						}
					}else{
						$suma_promedios = $suma_promedios + Conceptual($fNotas['promedio'],2);
						if (Conceptual($fNotas['promedio'],2)!=""){
						$con_notas = $con_notas + 1;
						}						
					}
				}
				if ($modo_eval==1){
				if ($suma_promedios>0){ 
						if (($institucion==9566)||($institucion==6060)){
							if ($aprox==0){
									$promedio_nota=intval($suma_promedios/$con_notas);	
								}
								elseif($aprox==1){
									$promedio_nota=round($suma_promedios/$con_notas);	
								}
						}else{
							$promedio_nota = round($suma_promedios/$con_notas,0);
						}
						
						$promedio_nota = substr($promedio_nota,0,1).".".substr($promedio_nota,1,1);
					}
					else
					{
						$promedio_nota = "&nbsp;";
					}
				}
				else
				{
					if ($con_notas>0){ 				
						$promedio_nota = Conceptual(round($suma_promedios/$con_notas,0),1);
						//if ($promedio_nota=="I")
							//$promedio_nota = "&nbsp;";
					}
				}
			}
		}else{
			if ($fSubsectores['sub_obli']==1)
				$promedio_nota = "EX";
			else
				$promedio_nota = "&nbsp;";
		}
			if($cod_subsector!=13){
				if($institucion==1517){
					switch ($promedio_nota){
						case 19: $promedio_nota=20; break;
						case 29: $promedio_nota=30; break;
						case 39: $promedio_nota=40; break;
						case 49: $promedio_nota=50; break;
						case 59: $promedio_nota=60; break;
						case 69: $promedio_nota=70; break;
					}
				}
					?>
          <td align="center" class="detalle"><? if ($situacion_final <> "Y") echo $promedio_nota; else echo "&nbsp;"; ?></td>
          <? }} ?>
          <td class="detalle" align="center"><? if ($situacion_final <> "Y") echo $promedio; else echo "&nbsp;"; ?>&nbsp;</td>
     
	 
	     <?  for($e=0 ; $e < $cantidad_subsectores ; $e++)
	{
		$fSubsectores= @pg_fetch_array($rsSubsectores,$e);
		$cod_subsector = $fSubsectores['cod_subsector'];
		$id_ramo = $fSubsectores['id_ramo'];
		$modo_eval = $fSubsectores['modo_eval']; 
		$conex = $fSubsectores['conex']; // 1 si 2 no
		$sql_eximido = "select count(*) as cantidad from tiene$ano_escolar where rut_alumno = ".$alumno." and id_ramo = ".$id_ramo." and id_curso = ".$curso;
		$rsEximido=@pg_Exec($conn,$sql_eximido);
		$fEximido= @pg_fetch_array($rsEximido,0);		
		if ($fEximido['cantidad']>0){
			if ($conex==1){
				$sql_notas = "select * from situacion_final where id_ramo = ".$id_ramo." and rut_alumno = ".$alumno."";
				$rsNotas=@pg_Exec($conn,$sql_notas);
				$fNotas= @pg_fetch_array($rsNotas,0);
				if ($fNotas['nota_final']>0) $promedio_nota = $fNotas['nota_final']; else $promedio_nota = "&nbsp;";
			}else{
				$sql_notas = "select promedio from notas$ano_escolar where rut_alumno = ".$alumno." and id_ramo = ".$id_ramo;
				$rsNotas=@pg_Exec($conn,$sql_notas);				
				$suma_promedios = 0; $con_notas = 0;
				for($u=0 ; $u < @pg_numrows($rsNotas) ; $u++)
				{
					$fNotas = @pg_fetch_array($rsNotas,$u);
					if ($modo_eval==1){//numerico
						$suma_promedios = $suma_promedios + $fNotas['promedio'];
						if ($fNotas['promedio']>0){
						$con_notas = $con_notas + 1;
						}
					}else{
						$suma_promedios = $suma_promedios + Conceptual($fNotas['promedio'],2);
						if (Conceptual($fNotas['promedio'],2)!=""){
						$con_notas = $con_notas + 1;
						}						
					}
				}
				if ($modo_eval==1){
					if ($suma_promedios>0){ 
						if (($institucion==9566)||($institucion==6060)){
									if($aprox==0){
									$promedio_nota=Conceptual(intval($suma_promedios/$con_notas),1);	
								}
								elseif($aprox==1){
									$promedio_nota=Conceptual(round($suma_promedios/$con_notas),1);	
								}
						}else{
							$promedio_nota = round($suma_promedios/$con_notas,0);
						}
						$promedio_nota = substr($promedio_nota,0,1).".".substr($promedio_nota,1,1);
					}
					else
					{
						$promedio_nota = "&nbsp;";
					}
				}
//				else
				elseif($modo_eval==2)
				{
					if ($con_notas>0){ 				
//						$promedio_nota = Conceptual(round($suma_promedios/$con_notas,0),1);
						$promedio_nota = Conceptual(intval($suma_promedios/$con_notas),1);
						//if ($promedio_nota=="I")
							//$promedio_nota = "&nbsp;";
					}
				}
// nuevo				
				elseif($modo_eval==3)
				{
					$sql_notas_3 = "select nota1, nota2, nota3, nota4, nota5, nota6, nota7, nota8, nota9, nota10, nota11, nota12, nota13, nota14,nota15,nota16,nota17,nota18,nota19,nota20 from notas$ano_escolar where rut_alumno = ".$alumno." and id_ramo = ".$id_ramo;
					$rsNotas_3=@pg_Exec($conn,$sql_notas_3);				
					$prom=0;
					$promedio_ramo=0;
					$con_prom=0;
					$prom_per=0;
					for($g=0 ; $g < @pg_numrows($rsNotas_3) ; $g++)
					{
						$con_notas = 0;
						$sum=0;
						$fNotas_3 = @pg_fetch_array($rsNotas_3,$g);
						if($fNotas_3['nota1']>0){
							$notas_1 = $fNotas_3['nota1'];	
							$con_notas=$con_notas+1;	
							$sum = $sum + $notas_1;
						}
						if($fNotas_3['nota2']>0){
							$notas_2 = $fNotas_3['nota2'];	
							$con_notas=$con_notas+1;	
							$sum = $sum + $notas_2;
						}
						if($fNotas_3['nota3']>0){
							$notas_3 = $fNotas_3['nota3'];	
							$con_notas=$con_notas+1;	
							$sum = $sum + $notas_3;
						}
						if($fNotas_3['nota4']>0){
							$notas_4 = $fNotas_3['nota4'];
								$con_notas=$con_notas+1;
							$sum = $sum + $notas_4;
						}
						if($fNotas_3['nota5']>0){
							$notas_5 = $fNotas_3['nota5'];
								$con_notas=$con_notas+1;	
							$sum = $sum + $notas_5;
						}
						if($fNotas_3['nota6']>0){
							$notas_6 = $fNotas_3['nota6'];
								$con_notas=$con_notas+1;	
							$sum = $sum + $notas_6;
						}
						if($fNotas_3['nota7']>0){
							$notas_7 = $fNotas_3['nota7'];
								$con_notas=$con_notas+1;	
							$sum = $sum + $notas_7;
						}
						if($fNotas_3['nota8']>0){
							$notas_8 = $fNotas_3['nota8'];
								$con_notas=$con_notas+1;	
							$sum = $sum + $notas_8;
						}
						if($fNotas_3['nota9']>0){
							$notas_9 = $fNotas_3['nota9'];
								$con_notas=$con_notas+1;	
							$sum = $sum + $notas_9;
						}
						if($fNotas_3['nota10']>0){
							$notas_10 = $fNotas_3['nota10'];
								$con_notas=$con_notas+1;	
							$sum = $sum + $notas_10;
						}
						if($fNotas_3['nota11']>0){
							$notas_11 = $fNotas_3['nota11'];
								$con_notas=$con_notas+1;	
							$sum = $sum + $notas_11;
						}
						if($fNotas_3['nota12']>0){
							$notas_12 = $fNotas_3['nota12'];
								$con_notas=$con_notas+1;	
							$sum = $sum + $notas_12;
						}
						if($fNotas_3['nota13']>0){
							$notas_13 = $fNotas_3['nota13'];
								$con_notas=$con_notas+1;	
							$sum = $sum + $notas_13;
						}
						if($fNotas_3['nota14']>0){
							$notas_14 = $fNotas_3['nota14'];
								$con_notas=$con_notas+1;	
							$sum = $sum + $notas_14;
						}
						if($fNotas_3['nota15']>0){
							$notas_15 = $fNotas_3['nota15'];
								$con_notas=$con_notas+1;	
							$sum = $sum + $notas_15;
						}
						if($fNotas_3['nota16']>0){
							$notas_16 = $fNotas_3['nota16'];
								$con_notas=$con_notas+1;	
							$sum = $sum + $notas_16;
						}
						if($fNotas_3['nota17']>0){
							$notas_17 = $fNotas_3['nota17'];
								$con_notas=$con_notas+1;	
							$sum = $sum + $notas_17;
						}
						if($fNotas_3['nota18']>0){
							$notas_18 = $fNotas_3['nota18'];
								$con_notas=$con_notas+1;	
							$sum = $sum + $notas_18;
						}
						if($fNotas_3['nota19']>0){
							$notas_19 = $fNotas_3['nota19'];
								$con_notas=$con_notas+1;	
							$sum = $sum + $notas_19;
						}
						if($fNotas_3['nota20']>0){
							$notas_20 = $fNotas_3['nota20'];
								$con_notas=$con_notas+1;	
							$sum = $sum + $notas_20;
						}
						
						if($con_notas>0)
							$prom = $sum/$con_notas;
						if($aprox==0){
							$prom_per = $prom_per + intval($prom);
							if($prom_per>0)
								$con_prom = $con_prom + 1;
						}
						elseif($aprox==1){
							$prom_per = $prom_per + round($prom);
							if($prom_per>0)
								$con_prom = $con_prom + 1;
						}
				
					}
					if($con_prom>0){
						if($aprox==0){
							$promedio_nota=Conceptual(intval($prom_per/$con_prom),1);	
						}
						elseif($aprox==1){
							$promedio_nota=Conceptual(round($prom_per/$con_prom),1);	
						}
						else if($prom_per==0){
							$promedio_nota= "&nbsp;";
						}
					}
				}				
// fin nuevo				
			}
		}else{
			if ($fSubsectores['sub_obli']==1)
				$promedio_nota = "EX";
			else
				$promedio_nota = "N/O"; // cambio solicitado por el coyancura
		}
			if($cod_subsector==13){?>
          <td align="center" class="detalle"><? if ($situacion_final <> "Y") echo $promedio_nota; else echo "&nbsp;"; ?></td>
          <? }} ?>
		  <td class="detalle" align="center"><? if ($situacion_final <> "Y") echo $asistencia; else echo "0%"; ?>&nbsp;</td>
          <td class="detalle" align="center"><? echo $situacion_final ?>&nbsp;</td>
          <td class="detalle"><? echo $observacion."&nbsp;"; ?></td>
        </tr>
        <? } ?>
      </table>
<table width="1074" border="0" cellspacing="1" cellpadding="3">
  <tr>
    <td align="left">	  <font face="Arial, Helvetica, sans-serif" size="-2">
	  Códigos :        Promovido= P       Reprobado =  R       Retirado =  Y					Masculino = 1   -   Femenino = 2 *******
	  Nota :   El Subsector de Religión no tiene incidencia en su promedio general de calificaciones ni en la situación final del alumno.															
	  </font></td>
  </tr>
</table>	  
      <?
echo "<H1 class=SaltoDePagina>&nbsp;</H1>";
?>
      <table width="1075" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="1075" align="left" valign="top">&nbsp;
              <table width="1075" border="1" cellspacing="0" cellpadding="0">
                <tr valign="top">
                  <td width="52" ><span class="titulo">COD</span></td>
                  <td width="140" ><span class="titulo">SUBSECTOR</span></td>
                  <td width="375" ><span class="titulo">NOMBRES Y APELLIDOS DEL PROFESOR </span></td>
                  <td width="123" ><span class="titulo">RUN</span></td>
                  <td width="147" ><span class="titulo">TITULADO / HABILITADO </span></td>
                  <td width="224"><span class="titulo">FIRMA</span></td>
                </tr>
                <?
	for($e=0 ; $e < @pg_numrows($rsSubsectores) ; $e++)
	{
		$fSubsectores= @pg_fetch_array($rsSubsectores,$e);
		$cod_subsector = $fSubsectores['cod_subsector'];
		$id_ramo = $fSubsectores['id_ramo'];
		$sql_dicta = "select empleado.rut_emp, empleado.dig_rut, empleado.ape_pat,empleado.ape_mat, empleado.nombre_emp, empleado.tipo_titulo, 
						empleado.nu_resol,empleado.habilitado,empleado.titulado,empleado.tit_otras,empleado.habilitado_para, ";
		$sql_dicta = $sql_dicta . "empleado.fecha_resol ";
 		$sql_dicta = $sql_dicta . "from dicta, empleado ";
		$sql_dicta = $sql_dicta . "where dicta.id_ramo = ".$id_ramo." ";
		$sql_dicta = $sql_dicta . "and   dicta.rut_emp = empleado.rut_emp ";
	//	echo $sql_dicta;
		$rsDicta=pg_Exec($conn,$sql_dicta);
		$titulo="";
		$fDicta= @pg_fetch_array($rsDicta,0);
			if ($fDicta[habilitado]==1){
				$arreglo_temp=unserialize($fDicta[habilitado_para]);
			/*	echo "<pre>";
				print_r($arreglo_temp);
				echo "</pre>";*/
				if (in_array($cod_subsector,$arreglo_temp)){
					$titulo = "H / Res Nº ".$fDicta['nu_resol']." de ".Cfecha2($fDicta['fecha_resol']);
				}
				
			}
		if ((!$titulo)&&($fDicta[titulado]==1)){
			$titulo = "T"; 
		}
		if ((!$titulo)&&($fDicta[tit_otras]==1)){
			$titulo = "T"; 
		}
		if (empty($titulo)){ $titulo = "Indeterminado"; }
		
	/*	if ($fDicta['tipo_titulo']>1) $titulo = "T"; 
		if ($fDicta['tipo_titulo']==1) $titulo = "H / Res Nº ".$fDicta['nu_resol']." de ".Cfecha2($fDicta['fecha_resol']);
		if (empty($fDicta['tipo_titulo'])) $titulo = "Indeterminado"; */
?>
                <tr>
                  <td class="detalle"><? echo $fSubsectores['cod_subsector'] ?></td>
                  <td class="detalle"><? echo $fSubsectores['nombre'] ?></td>
                  <td class="detalle"><? echo strtoupper(trim($fDicta['ape_pat']." ".$fDicta['ape_mat']." ".$fDicta['nombre_emp'])) ?></td>
                  <td class="detalle"><? echo $fDicta['rut_emp']."-".$fDicta['dig_rut'] ?></td>
                  <td class="detalle"><? echo $titulo ?></td>
                  <td>&nbsp;</td>
                </tr>
                <? }?>
              </table>
              <br>
              <?
//------------------ TOTAL MATRICULA INICIAL AL 30-04 HOMBRE
$sql="";
$sql = "select count(matricula.rut_alumno) as cantidad from matricula, alumno where matricula.id_ano = $ano and matricula.id_curso = $curso and alumno.rut_alumno = matricula.rut_alumno and alumno.sexo = 2 and matricula.fecha < '05-01-$ano_escolar' ";

$resultado = pg_exec($conn,$sql);
$fila2 = @pg_fetch_array($resultado,0);
$matricula_inicial_hombre = $fila2['cantidad'];
//if ($_NOMBREUSUARIO=="saeKa"){
//	echo "$sql --- $matricula_inicial_hombre<br>";
//}
//------------------			  
//------------------ TOTAL MATRICULA INICIAL AL 30-04 MUJER
$sql="";
$sql = "select count(matricula.rut_alumno) as cantidad from matricula, alumno where matricula.id_ano = $ano and matricula.id_curso = $curso and alumno.rut_alumno = matricula.rut_alumno and alumno.sexo = 1  and matricula.fecha < '05-01-$ano_escolar' ";
$resultado = pg_exec($conn,$sql);
$fila2 = @pg_fetch_array($resultado,0);
$matricula_inicial_mujer = $fila2['cantidad'];
//------------------			  
//------------------ TOTAL MATRICULA HOMBRES Ingresos entre el 1º Mayo y 29 Noviembre
$sql="";
$sql = "select count(matricula.rut_alumno) as cantidad from matricula, alumno where id_ano = ".$ano." and matricula.fecha > '04-30-".$ano_escolar."' and matricula.fecha < '11-30-".$ano_escolar."' and id_ano = $ano and alumno.rut_alumno = matricula.rut_alumno and alumno.sexo = 2 and matricula.id_curso=" . $curso . "";
$resultado = pg_exec($conn,$sql);
$fila2 = @pg_fetch_array($resultado,0);
$matricula_1_hombre = $fila2['cantidad'];
//------------------
//------------------ TOTAL MATRICULA MUJERES Ingresos entre el 1º Mayo y 29 Noviembre
$sql="";
$sql = "select count(matricula.rut_alumno) as cantidad from matricula, alumno where id_ano = ".$ano." and matricula.fecha > '04-30-".$ano_escolar."' and matricula.fecha < '11-30-".$ano_escolar."' and id_ano = $ano and alumno.rut_alumno = matricula.rut_alumno and alumno.sexo = 1 and matricula.id_curso=" . $curso . " ";
$resultado = pg_exec($conn,$sql);
$fila2 = @pg_fetch_array($resultado,0);
$matricula_1_mujer = $fila2['cantidad'];
//----------------------------------------------------------------				
// ALUMNOS retirados entre el 1º de mayo y el 29 de noviembre - HOMBRES
//----------------------------------------------------------------
$sql="";
$sql = "select count(matricula.rut_alumno) as cantidad from matricula, alumno where matricula.id_ano = ".$ano." and matricula.id_curso = $curso and matricula.rut_alumno = alumno.rut_alumno and alumno.sexo = 2 and matricula.bool_ar = 1 and (matricula.fecha_retiro > '04-30-".$ano_escolar."' and matricula.fecha_retiro  < '11-30-".$ano_escolar."') ";
$resultado = pg_exec($conn,$sql);
$fila2 = @pg_fetch_array($resultado,0);
$retirados1 = $fila2['cantidad'];
//----------------------------------------------------------------	
//----------------------------------------------------------------				
// ALUMNOS retirados entre el 1º de mayo y el 29 de noviembre - MUJERES
//----------------------------------------------------------------
$sql="";
$sql = "select count(matricula.rut_alumno) as cantidad from matricula, alumno where matricula.id_ano = ".$ano." and matricula.id_curso = $curso and matricula.rut_alumno = alumno.rut_alumno and alumno.sexo = 1 and matricula.bool_ar = 1 and (matricula.fecha_retiro  > '04-30-".$ano_escolar."' and matricula.fecha_retiro  < '11-30-".$ano_escolar."') ";
$resultado = pg_exec($conn,$sql);
$fila2 = @pg_fetch_array($resultado,0);
$retirados2 = $fila2['cantidad'];
//----------------------------------------------------------------	
//------------------
$sql="";
$sql = "select count(*) as cantidad from matricula where id_curso = ".$curso." and matricula.fecha < '12-01-".($ano_escolar)."' and id_ano = ".$ano . " and matricula.bool_ar=0 " ;
$resultado = pg_exec($conn,$sql);
$fila2 = @pg_fetch_array($resultado,0);
$matriculados = $fila2['cantidad'];	
//------------------
//------------------ MATRICULADOS HOMBRES
$sql="";
$sql = "select count(matricula.rut_alumno) as cantidad from matricula, alumno where id_curso = ".$curso." and matricula.fecha < '12-01-".$ano_escolar."' and id_ano =". $ano . " and alumno.rut_alumno = matricula.rut_alumno and alumno.sexo = 2 and (matricula.bool_ar=0)";
$resultado = pg_exec($conn,$sql);
$fila2 = @pg_fetch_array($resultado,0);
$matriculados_hombre = $fila2['cantidad'];	
//------------------
//------------------ MATRICULADOS MUJERES
$sql="";
$sql = "select count(matricula.rut_alumno) as cantidad from matricula, alumno where id_curso = ".$curso." and matricula.fecha < '12-01-".$ano_escolar."' and id_ano =" . $ano . " and alumno.rut_alumno = matricula.rut_alumno and alumno.sexo = 1 and (matricula.bool_ar=0)";
$resultado = pg_exec($conn,$sql);
$fila2 = @pg_fetch_array($resultado,0);
$matriculados_mujer = $fila2['cantidad'];	
//------------------ PROMOVIDOS
$sql="";
$sql = "select count(*) as cantidad from promocion where promocion.id_curso = ".$curso." and promocion.situacion_final = 1";
$resultado = pg_exec($conn,$sql);
$fila2 = @pg_fetch_array($resultado,0);
$aprobados = $fila2['cantidad'];
//------------------
//------------------ PROMOVIDOS HOMBRE
$sql="";
$sql = "select count(promocion.rut_alumno) as cantidad from promocion, alumno where promocion.id_curso = ".$curso." and promocion.situacion_final = 1 and promocion.rut_alumno = alumno.rut_alumno and alumno.sexo = 2";
$resultado = pg_exec($conn,$sql);
$fila2 = @pg_fetch_array($resultado,0);
$aprobados_hombre = $fila2['cantidad'];
//------------------
//------------------ PROMOVIDOS MUJERES
$sql="";
$sql = "select count(promocion.rut_alumno) as cantidad from promocion, alumno where promocion.id_curso = ".$curso." and promocion.situacion_final = 1 and promocion.rut_alumno = alumno.rut_alumno and alumno.sexo = 1";
$resultado = pg_exec($conn,$sql);
$fila2 = @pg_fetch_array($resultado,0);
$aprobados_mujer = $fila2['cantidad'];
//------------------ REPROVADOS
$sql="";
$sql = "select count(*) as cantidad from promocion where promocion.id_curso = ".$curso." and promocion.situacion_final = 2 ";
$resultado = pg_exec($conn,$sql);
$fila2 = @pg_fetch_array($resultado,0);
$reprovados = $fila2['cantidad'];
//------------------

//------------------ REPROVADOS HOMBRES INASISTENCIA
$sql="";
$sql = "select count(promocion.rut_alumno) as cantidad from promocion, alumno where promocion.id_curso = ".$curso." and promocion.situacion_final = 2 and promocion.rut_alumno = alumno.rut_alumno and alumno.sexo = 2  and tipo_reprova = 2";
$resultado = pg_exec($conn,$sql);
$fila2 = @pg_fetch_array($resultado,0);
$reprovados_hombre = $fila2['cantidad'];
//------------------
//------------------ REPROVADOS MUJERES INASISTENCIA
$sql="";
$sql = "select count(promocion.rut_alumno) as cantidad from promocion, alumno where promocion.id_curso = ".$curso." and promocion.situacion_final = 2 and promocion.rut_alumno = alumno.rut_alumno and alumno.sexo = 1  and tipo_reprova = 2";
$resultado = pg_exec($conn,$sql);
$fila2 = @pg_fetch_array($resultado,0);
$reprovados_mujer = $fila2['cantidad'];
//------------------ REPROVADOS HOMBRES RENDIMIENTO
$sql="";
$sql = "select count(promocion.rut_alumno) as cantidad from promocion, alumno where promocion.id_curso = ".$curso." and promocion.situacion_final = 2 and promocion.rut_alumno = alumno.rut_alumno and alumno.sexo = 2  and tipo_reprova = 1";
$resultado = pg_exec($conn,$sql);
$fila2 = @pg_fetch_array($resultado,0);
$reprovados_hombre1 = $fila2['cantidad'];
//------------------
//------------------ REPROVADOS MUJERES RENDIMIENTO
$sql="";
$sql = "select count(promocion.rut_alumno) as cantidad from promocion, alumno where promocion.id_curso = ".$curso." and promocion.situacion_final = 2 and promocion.rut_alumno = alumno.rut_alumno and alumno.sexo = 1  and tipo_reprova = 1";
$resultado = pg_exec($conn,$sql);
$fila2 = @pg_fetch_array($resultado,0);
$reprovados_mujer1 = $fila2['cantidad'];

//------------------ RETIRADOS
$sql="";
$sql = "select count(*) as cantidad from promocion where promocion.id_curso = ".$curso." and promocion.situacion_final = 3 ";
$resultado = pg_exec($conn,$sql);
$fila2 = @pg_fetch_array($resultado,0);
$retirados= $fila2['cantidad'];
//------------------
//------------------ RETIRADOS HOMBRES
$sql="";
$sql = "select count(promocion.rut_alumno) as cantidad from promocion, alumno where promocion.id_curso = ".$curso." and promocion.situacion_final = 3 and promocion.rut_alumno = alumno.rut_alumno and alumno.sexo = 2";
$resultado = pg_exec($conn,$sql);
$fila2 = @pg_fetch_array($resultado,0);
$retirados_hombre = $fila2['cantidad'];
//------------------
//------------------ RETIRADOS MUJERES
$sql="";
$sql = "select count(promocion.rut_alumno) as cantidad from promocion, alumno where promocion.id_curso = ".$curso." and promocion.situacion_final = 3 and promocion.rut_alumno = alumno.rut_alumno and alumno.sexo = 1";
$resultado = pg_exec($conn,$sql);
$fila2 = @pg_fetch_array($resultado,0);
$retirados_mujer = $fila2['cantidad'];
//------------------
?>
              <table width="778" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="171" bordercolor="#000000"><span class="titulo">RESULTADO GENERAL DEL CURSO </span></td>
                  <td align="center" bordercolor="#000000"><span class="titulo">M</span></td>
                  <td align="center" bordercolor="#000000"><span class="titulo">F</span></td>
                  <td align="center" bordercolor="#000000"><span class="titulo">TOTAL</span></td>
                  <td width="27">&nbsp;</td>
                  <td width="144">&nbsp;</td>
                  <td width="4">&nbsp;</td>
                  <td width="152">&nbsp;</td>
                  <td width="13">&nbsp;</td>
                </tr>
                <tr>
                  <td bordercolor="#000000"><span class="detalle">MATRICULA:</span></td>
                  <td bordercolor="#000000">&nbsp;</td>
                  <td bordercolor="#000000">&nbsp;</td>
                  <td bordercolor="#000000">&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td bordercolor="#000000"><span class="detalle">Matrícula 30 Abril (inicial)</span></td>
                  <td align="center" bordercolor="#000000"><span class="detalle"><? echo $matricula_inicial_hombre  ?></span></td>
                  <td align="center" bordercolor="#000000"><span class="detalle"><? echo $matricula_inicial_mujer?></span></td>
                  <td align="center" bordercolor="#000000"><span class="detalle"><? echo $matricula_inicial_hombre+$matricula_inicial_mujer ?></span></td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  
            <td bordercolor="#000000"><span class="detalle">Ingresos entre el 1º Mayo y 29 Noviembre</span></td>
                  <td align="center" bordercolor="#000000"><span class="detalle"><? echo $matricula_1_hombre ?></span></td>
                  <td align="center" bordercolor="#000000"><span class="detalle"><? echo $matricula_1_mujer ?></span></td>
                  <td align="center" bordercolor="#000000"><span class="detalle"><? echo $matricula_1_hombre +  $matricula_1_mujer?></span></td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  
            <td bordercolor="#000000"><span class="detalle">Retirados entre 1º Mayo y 29 Noviembre</span></td>
                  <td align="center" bordercolor="#000000"><span class="detalle"><? echo $retirados1 ?></span></td>
                  <td align="center" bordercolor="#000000"><span class="detalle"><? echo $retirados2 ?></span></td>
                  <td align="center" bordercolor="#000000"><span class="detalle"><? echo $retirados1 + $retirados2 ?></span></td>
                  <td>&nbsp;</td>
                  <td align="center">&nbsp;</td>
                  <td>&nbsp;</td>
                  <td align="center">&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td bordercolor="#000000"><span class="detalle"></span><span class="detalle">Matrícula 30 Noviembre (final) </span></td>
                  <td bordercolor="#000000" align="center"><span class="detalle"><? echo $matriculados_hombre ?></span></td>
                  <td bordercolor="#000000" align="center"><span class="detalle"><? echo $matriculados_mujer ?></span></td>
                  <td bordercolor="#000000" align="center"><span class="detalle"><? echo $matriculados ?></span></td>
                  <td>&nbsp;</td>
                  <td align="center">__________________</td>
                  <td>&nbsp;</td>
                  <td align="center">___________________</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td bordercolor="#000000"><span class="detalle">Promovidos</span></td>
                  <td bordercolor="#000000" align="center"><span class="detalle"><? echo $aprobados_hombre ?></span></td>
                  <td bordercolor="#000000" align="center"><span class="detalle"><? echo $aprobados_mujer ?></span></td>
                  <td bordercolor="#000000" align="center"><span class="detalle"><? echo $aprobados ?></span></td>
                  <td>&nbsp;</td>
                  <td align="center"><span class="detalle">ENCARGADO CONFECCI&Oacute;N DEL ACTA </span></td>
                  <td>&nbsp;</td>
                  <td align="center"><span class="detalle"><? echo strtoupper($Nombre_Profe);?><br>PROFESOR JEFE </span></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td bordercolor="#000000"><span class="detalle">Reprobados por Inasistencia</span></td>
                  <td bordercolor="#000000" align="center"><span class="detalle"><? echo $reprovados_hombre ?></span></td>
                  <td bordercolor="#000000" align="center"><span class="detalle"><? echo $reprovados_mujer ?></span></td>
                  <td bordercolor="#000000" align="center"><span class="detalle"><? echo $reprovados_hombre + $reprovados_mujer ?></span></td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td bordercolor="#000000"><span class="detalle">Reprobados por Rendimiento</span></td>
                  <td bordercolor="#000000" align="center"><span class="detalle"><? echo $reprovados_hombre1 ?></span></td>
                  <td bordercolor="#000000" align="center"><span class="detalle"><? echo $reprovados_mujer1 ?></span></td>
                  <td bordercolor="#000000" align="center"><span class="detalle"><? echo $reprovados_hombre1 + $reprovados_mujer1 ?></span></td>
                  <td>&nbsp;</td>
                  <td colspan="3" align="center">________________________</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td><span class="detalle">Total Reprobados </span></td>
                 <td bordercolor="#000000" align="center"><span class="detalle"><? echo $reprovados_hombre + $reprovados_hombre1 ?></span></td>
                  <td bordercolor="#000000" align="center"><span class="detalle"><? echo $reprovados_mujer + $reprovados_mujer1 ?></span></td>
                  <td bordercolor="#000000" align="center"><span class="detalle"><? echo $reprovados_hombre + $reprovados_mujer + $reprovados_hombre1 + $reprovados_mujer1 ?></span></td>
                  <td>&nbsp;</td>
                  <td colspan="3" align="center"><span class="detalle">
				  <?php 
						if ($institucion == 24511){
							echo "ANDREA LUCI ALARCÓN";
						} 						
						else {
 							 echo strtoupper($Nombre_Dir); }
					?><br>JEFE ESTABLECIMIENTO </span></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
            </table></td>
        </tr>
    </table>
	<table width="1074" border="0" cellspacing="1" cellpadding="3">
  <tr>
    <td align="left"><span class="detalle">OBSERVACIONES:______________________________________________________________________________________________________________________________________________</span></td>
  </tr>
  <tr>
    <td align="left"><span class="detalle">_______________________________________________________________________________________________________________________________________________________________</span></td>
  </tr>
  <tr>
    <td align="right"><font face="Arial, Helvetica, sans-serif" size="-1"><? echo ucwords(strtolower($comuna)).", ".strftime("%d",time())." de ".ucwords(strftime("%B",time()))." de ".strftime("%Y",time()) ?></font></td>
    </tr>  
</table>

      </table>
      <?
echo "<H1 class=SaltoDePagina>&nbsp;</H1>";

?>
<div align="center">
<font face="Arial, Helvetica, sans-serif"><strong>TABLA DE SUBSECTORES PARA <? echo $curso_pal." ".$tipo_ensenanza?></strong></font>
	<table width="600" border="1" cellspacing="1" cellpadding="3">
  <tr>
    <td align="center"><font face="Arial, Helvetica, sans-serif"><strong>Código Subsector</strong></font></td>
    <td align="center"><font face="Arial, Helvetica, sans-serif"><strong>Nombre Subsector</strong></font></td>
  </tr>
  <?
  	for($e=0 ; $e < @pg_numrows($rsSubsectores) ; $e++)
	{
		$fSubsectores= @pg_fetch_array($rsSubsectores,$e);
		$cod_subsector = $fSubsectores['cod_subsector'];
		$id_ramo = $fSubsectores['id_ramo'];
		$nombre_subsector = $fSubsectores['nombre'];
  ?>
  <tr>
    <td align="left"><font face="Arial, Helvetica, sans-serif" ><? echo $cod_subsector?></font></td>
    <td align="left"><font face="Arial, Helvetica, sans-serif" ><? echo $nombre_subsector?></font></td>
  </tr>
  <?
  }
  ?>
</table>

<font face="Arial, Helvetica, sans-serif">ESTA HOJA NO SE ADJUNTA AL ACTA IMPRESA POR AMBAS CARAS<br>ES SOLO UNA GUÍA PARA LOS USUARIOS</font>	
</div>
</div>
</body>
</html>
<? pg_close($conn);?>