<script>
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
</script>

<?
require('../../../../../util/header.inc'); 

	setlocale("LC_ALL","es_ES");
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$c_curso;
	$alumno 		=$c_alumno;
	if ($curso==0)
		 exit;
	//----------------------------------------------------------------------------
	// DATOS INSTITUCION
	//----------------------------------------------------------------------------
	$sql_institu = "SELECT institucion.nombre_instit, institucion.insignia, institucion.calle, institucion.nro, region.nom_reg, provincia.nom_pro, comuna.nom_com, institucion.telefono ";
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
	//----------------------------------------------------------------------------
	// AÑO ESCOLAR
	//----------------------------------------------------------------------------
	$sql_ano = "select * from ano_escolar where id_ano = ".$ano;
	$result_ano =@pg_Exec($conn,$sql_ano);
	$fila_ano = @pg_fetch_array($result_ano,0);
	$nro_ano = $fila_ano['nro_ano'];
	//--------------------------------------------------------------------------
	// DATOS CURSO //
	//--------------------------------------------------------------------------	
	$sql_curso = "SELECT plan_estudio.nombre_decreto, evaluacion.nombre_decreto_eval, curso.truncado_per, curso.ensenanza, curso.grado_curso ";
	$sql_curso = $sql_curso . "FROM (curso INNER JOIN plan_estudio ON curso.cod_decreto = plan_estudio.cod_decreto) INNER JOIN evaluacion ON curso.cod_eval = evaluacion.cod_eval ";
	$sql_curso = $sql_curso . "WHERE (((curso.id_curso)=".$curso."));";
	$result_curso = @pg_Exec($conn, $sql_curso);
	$fila_curso = @pg_fetch_array($result_curso ,0);
	$decreto_eval = $fila_curso['nombre_decreto_eval'];
	$planes = $fila_curso['nombre_decreto'];
	$truncado_per = $fila_curso['truncado_per'];
	$Ensenanza = $fila_curso['ensenanza'];
	$Grado = $fila_curso['grado_curso'];
			if($Grado==1) $gr="pa";
			if($Grado==2) $gr="sa";
			if($Grado==3) $gr="ta";
			if($Grado==4) $gr="cu";
			if($Grado==5) $gr="qu";
			if($Grado==6) $gr="sx";
			if($Grado==7) $gr="sp";
			if($Grado==8) $gr="oc";
	//----------------------------------------------------------------------------
	// DATOS ALUMNO
	//----------------------------------------------------------------------------	
	if ($alumno == 0)
	{
		$sql_alumno = "SELECT matricula.rut_alumno, alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu ";
		$sql_alumno = $sql_alumno . "FROM matricula, alumno where matricula.rut_alumno = alumno.rut_alumno and matricula.id_curso = $curso ";
		$sql_alumno = $sql_alumno . "ORDER BY alumno.ape_pat, alumno.ape_mat; ";
		$result_alumno = @pg_Exec($conn, $sql_alumno);
	}
	else
	{
		$sql_alumno = "SELECT matricula.rut_alumno, alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu ";
		$sql_alumno = $sql_alumno . "FROM matricula, alumno where matricula.rut_alumno = '" . $alumno. "' and matricula.rut_alumno = alumno.rut_alumno and matricula.id_curso = $curso ";
		$sql_alumno = $sql_alumno . "ORDER BY alumno.ape_pat, alumno.ape_mat; ";
		$result_alumno = @pg_Exec($conn, $sql_alumno);
	}
?>
<?
	$sql_promedio = "select max(promedio) as max_prom from promocion where id_curso = ".$curso;
	$result_promedio =@pg_Exec($conn,$sql_promedio);
	$fila_promedio = @pg_fetch_array($result_promedio,0);
	$promedio_final_mejor = 	$fila_promedio['max_prom'];
	?>	
<?
	$sql_promedio = "select promedio from promocion where id_curso = ".$curso;
	$result_promedio =@pg_Exec($conn,$sql_promedio);
	$promedio_final = 0; $cont_final = 0;
	for($g=0 ; $g < @pg_numrows($result_promedio) ; $g++)
	{
		$fila_promedio = @pg_fetch_array($result_promedio,$g);	
		if ($fila_promedio['promedio']>0)
		{
			$promedio_final = $promedio_final + $fila_promedio['promedio'];		
			$cont_final = $cont_final + 1;
		}
	}		
	if ($cont_final>0)
	$promedio_final_curso = round($promedio_final/$cont_final,0);
	
	//----------------------------------------------------
	// DATOS PROFESOR JEFE
	//----------------------------------------------------
	$sql_profe = "SELECT empleado.ape_pat, empleado.ape_mat, empleado.nombre_emp ";
	$sql_profe = $sql_profe . "FROM (curso INNER JOIN supervisa ON curso.id_curso = supervisa.id_curso) INNER JOIN empleado ON supervisa.rut_emp = empleado.rut_emp ";
	$sql_profe = $sql_profe . "WHERE (((curso.id_curso)=".$curso.")); ";
	$result_profe = @pg_Exec($conn, $sql_profe);
	$fila_profe = @pg_fetch_array($result_profe ,0);
	$profesor = ucwords(strtoupper($fila_profe['nombre_emp'] . " " . $fila_profe['ape_pat'] . " " . $fila_profe['ape_mat']));
	
	?>	
	
<?

  	//----------------------------------------------------------------------------
	// DATOS PERIODO
	//----------------------------------------------------------------------------
	$sql_periodo = "select * from periodo where id_ano = ".$ano . " order by id_periodo";
	$result_periodo = @pg_Exec($conn, $sql_periodo);
	$cadena = "";
	$habiles = 0;
	$cantidad_periodos =  @pg_numrows($result_periodo);
	for($e=0 ; $e < @pg_numrows($result_periodo) ; $e++)
	{
		$fila_periodo = @pg_fetch_array($result_periodo,$e);
		if ($fila_periodo['dias_habiles']>0)
			$habiles = $habiles + $fila_periodo['dias_habiles'];
		if (trim($cadena)=="")
			$cadena = $fila_periodo['id_periodo'];
		else
			$cadena = $cadena . ";" . $fila_periodo['id_periodo'];
		
	}
	$periodo=explode(";",$cadena);
	
	$sql_subsector = "SELECT ramo.id_ramo, subsector.nombre, ramo.modo_eval, ramo.conex, ramo.nota_exim ";
	$sql_subsector = $sql_subsector . "FROM (curso INNER JOIN ramo ON curso.id_curso = ramo.id_curso) INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector ";
	$sql_subsector = $sql_subsector . "WHERE (((curso.id_curso)=".$curso.")) order by ramo.id_orden; ";
	$result_subsector = @pg_Exec($conn, $sql_subsector);
		
	$Curso_pal = CursoPalabra($curso, 0, $conn);


	$sqlMatri="SELECT matricula.rut_alumno,matricula.rdb,matricula.id_ano,matricula.id_curso,curso.grado_curso,curso.letra_curso,curso.ensenanza,curso.cod_es, curso.cod_sector,curso.cod_rama FROM matricula, curso WHERE matricula.rut_alumno='".$alumno."' and matricula.id_ano=".$ano." and matricula.id_curso=curso.id_curso";
	$resultMatri=@pg_exec($conn,$sqlMatri);
	$filaMatri=@pg_fetch_array($resultMatri,0);
			/*if($filaMatri['grado_curso']==1) $gr="pa";
			if($filaMatri['grado_curso']==2) $gr="sa";
			if($filaMatri['grado_curso']==3) $gr="ta";
			if($filaMatri['grado_curso']==4) $gr="cu";
			if($filaMatri['grado_curso']==5) $gr="qu";
			if($filaMatri['grado_curso']==6) $gr="sx";
			if($filaMatri['grado_curso']==7) $gr="sp";
			if($filaMatri['grado_curso']==8) $gr="oc";*/

	//$sqlTraePlantilla="SELECT * FROM informe_plantilla WHERE tipo_ensenanza=".$filaMatri['ensenanza']." AND ".$gr."=1 and activa=1 AND rdb=".$institucion;
	$sqlTraePlantilla="SELECT * FROM informe_plantilla WHERE tipo_ensenanza=".$Ensenanza." AND ".$gr."=1 and activa=1 AND rdb=".$institucion;
	$resultPlantilla=@pg_Exec($conn, $sqlTraePlantilla);
	$filaPlantilla=@pg_fetch_array($resultPlantilla,0);

	$titulo1 = $filaPlantilla['titulo_informe1'];
	
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
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><div id="capa0">
		<div align="right">
          <input name="button3" type="button" class="botonX" onClick="imprimir();" onMouseOver=this.style.background='FFFFD7';this.style.color='003b85' onMouseOut=this.style.background='#5c6fa9';this.style.color='ffffff' value="IMPRIMIR">
        </div>
      </div>
    </td>
  </tr>
</table>
<?
	$cantidad_alumnos = @pg_numrows($result_alumno);
	for($i=0 ; $i < @pg_numrows($result_alumno) ; $i++)
	{
		$fila_alumno = @pg_fetch_array($result_alumno,$i);
		$alumno = $fila_alumno['rut_alumno'];
		$nombre_alumno = ucwords(strtoupper($fila_alumno['ape_pat'] . " " . $fila_alumno['ape_mat'] . " " . $fila_alumno['nombre_alu']));

?>
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
  	<td>
		<table>
			<tr>
			    <td width="180" valign="top"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong><? echo ucwords(strtoupper($nombre_institu));?></strong></font></td>
			</tr>
			<tr>
				<td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo ucwords(strtolower($direccion));?></font></td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td><font face="Verdana, Arial, Helvetica, sans-serif" size="1">Fono:&nbsp;<? echo ucwords(strtolower($telefono));?></font></td>
				<td>&nbsp;</td>
			</tr>
	</table>
	</td>
    <td width="11">&nbsp;</td>
<!-- inicio -->	
	<td width="287">	
		<table width="287" border="0" cellspacing="0" cellpadding="0">
			<tr bgcolor="#003b85">
				<td ><div align="center"><strong><font color="White" size="2" face="verdana, arial, geneva, helvetica">INFORME DE NOTAS</font></strong></div></td>
			</tr>
		  <tr>
			<td><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><strong><? echo "Decreto Evaluación Nº : ".$decreto_eval?></strong></font></div></td>
		  </tr>
		  <tr>
			<td><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><strong><? echo "Planes y Programas Nº : ".$planes?></strong></font></div></td>
		  </tr>
		  <tr>
			<td><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><strong><? echo "Correspondiente al Año Lectivo : ".$nro_ano?></strong></font></div></td>
		  </tr>
		</table>
	</td>	
    <td width="11">&nbsp;</td>
<!-- fin  -->	
    <td width="152" rowspan="4" align="center">
      <?
		if 	(!empty($fila_institu['insignia']))
		{
			$output= "select lo_export(".$arr['insignia'].",'/var/www/html/tmp/".$arr[rdb]."');";
			$retrieve_result = @pg_exec($conn,$output);?>
      <table width="125" border="0" cellpadding="0" cellspacing="0">
        <tr valign="top" >
          <td width="125" align="center"> <img src=../../../../../../../../tmp/<? echo $institucion ?> ALT="NO DISPONIBLE"  height="100"></td>
        </tr>
      </table>
      <? } ?>
    </td>
  </tr>
  <tr><td>&nbsp;</td></tr>
</table>
<!-- <br> -->
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="91"><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>CURSO</strong></font></div></td>
    <td width="8"><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>:</strong></font></div></td>
    <td width="543"><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $Curso_pal?></font></div></td>
  </tr>
  <tr>
    <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>ALUMNO</strong></font></div></td>
    <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>:</strong></font></div></td>
    <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $nombre_alumno?></font></div></td>
  </tr>
  <tr>
    <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>PROFESOR JEFE</strong></font></div></td>
    <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>:</strong></font></div></td>
    <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $profesor?></font></div></td>
  </tr>
</table>
<br>
<?
	if ($cantidad_periodos==3)
	{
?>
<table width="650" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td width="307" rowspan="2"><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>ASIGNATURA O SUBSECTOR DE APRENDIZAJE</strong></font></div></td>
    <td colspan="3"><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>PROMEDIOS</strong></font></div></td>
    <td width="62" rowspan="2"><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>PROMEDIO ANUAL</strong></font></div></td>
    <td width="54" rowspan="2"><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>EXAMEN</strong></font></div></td>
    <td width="73" rowspan="2"><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>CALIFICACIÓN FINAL</strong></font></div></td>
  </tr>
  
  <tr>
    <td width="46"><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>1º Trim</strong></font></div></td>
    <td width="46"><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>2º Trim</strong></font></div></td>
    <td width="46"><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>3º Trim</strong></font></div></td>
  </tr>
  <?
  	
	$prom_gene_periodos = 0;
	for($f=0 ; $f < @pg_numrows($result_subsector) ; $f++)
	{
		$fila_subsector = @pg_fetch_array($result_subsector,$f);
		$id_ramo = $fila_subsector['id_ramo'];
		$nom_subsector = $fila_subsector['nombre'];
		$modo_eval = $fila_subsector['modo_eval'];
		$conex = $fila_subsector['conex'];
		$nota_exim = $fila_subsector['nota_exim'];
		$sw=0;
  ?>	
  <tr>
    <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $nom_subsector?></font></div></td>

	<?
	//---------
	//---------
	$prom_gene_periodos = 0; $contador_pro=0;
	for($procom=0 ; $procom < 3 ; $procom++)
	{?>    
	<td><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2">
	<?
		$sw = 0; 
		$sql_notas = "SELECT promedio from notas$nro_ano where rut_alumno = '".$alumno."' and id_ramo = ".$id_ramo." and id_periodo = ".$periodo[$procom]." order by id_periodo";
		$result_notas =@pg_Exec($conn,$sql_notas);
		$fila_notas = @pg_fetch_array($result_notas,0);
		$promedio = $fila_notas['promedio'];		
			if ($modo_eval==1)
			{		
				if ($promedio>0){
//					echo $promedio;
					if ($promedio<40){
						?><font color="#FF0000"><? echo $promedio;?> </font>	<?
					}
					else{
						echo $promedio;
					}
					$prom_gene_periodos = $prom_gene_periodos + $promedio;
					$contador_pro = $contador_pro + 1;
				}
				else{
					echo "---";
					$sw = 1;
				}
			}
			else
			{
				if (empty($promedio) or chop($promedio)=="0"){
					echo "---";
					$sw = 1;
				}
				else{
					echo $promedio;
					$promedio = Conceptual($promedio,2);
					$prom_gene_periodos = $prom_gene_periodos + $promedio;			
					$contador_pro = $contador_pro + 1;					
				}
			}
?>
</font></div></td>
<?
	}
	if ($conex==1){
		$sql_promedio = "select * from situacion_final where rut_alumno = '".$alumno."' and id_ramo = ".$id_ramo;
		$result_promedio =@pg_Exec($conn,$sql_promedio);
		$fila_promedio = @pg_fetch_array($result_promedio,0);
		$prom_gral = $fila_promedio['prom_gral'];
		$nota_examen = $fila_promedio['nota_examen'];		
		if ($prom_gral == $nota_exim or $prom_gral > $nota_exim ) $nota_examen = "---";
		$nota_final = $fila_promedio['nota_final'];	
	} else {
		$nota_examen = "---";
		if ($prom_gene_periodos>0)
			$prom_gral = Promediar($prom_gene_periodos,$contador_pro,$truncado_per);
		$prom_gene_periodos = 0;			
		$nota_final = $prom_gral;
		
	}
	if ($modo_eval==2){
		$prom_gral = Conceptual($prom_gral,1);
		$nota_final = $prom_gral ;
	}
	if ($sw==1){
		$nota_examen = "---";
		$prom_gral = "---";
		$nota_final = "---";
	}
	?>
    <td><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><? if (!empty($prom_gral)) echo $prom_gral; else echo "---";?></font></div></td>
    <td><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><? if ($nota_examen>0) echo $nota_examen; else echo "---";?></font></div></td>
    <td><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><? if (!empty($nota_final)) echo $nota_final; else echo "---";?></font></div></td>
  </tr>
  <? } 
  
	$sql_promedio = "select promedio, asistencia from promocion where rut_alumno = '".$alumno. "' and id_curso = ".$curso;
	$result_promedio =@pg_Exec($conn,$sql_promedio);
	$fila_promedio = @pg_fetch_array($result_promedio,0);
	$promedio_final_alumno = 	$fila_promedio['promedio'];
	$asistencia_real = $fila_promedio['asistencia'];
	?>
  <tr>
    <td width="307"><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>PROMEDIO GENERAL</strong></font></div></td>
    <td colspan="5">&nbsp;</td>
    <td width="73"><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><? if ($promedio_final_alumno>0) echo $promedio_final_alumno; else echo "---";?></font></div></td>			
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="5">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>TOT. DIAS/HORAS POR TRABAJAR (Anual)</strong></font></div></td>
    <td colspan="5">&nbsp;</td>
    <td><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2">
        <? echo $habiles;?>
    </font></div></td>
  </tr>
  <tr>
    <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>TOTAL INASISTENCIAS (Anual)</strong></font></div></td>
    <td colspan="5">&nbsp;</td>
	<?
	$sql_asistencia = "select count(*) as cantidad from asistencia where rut_alumno = '".$alumno."' and ano = ".$ano." ";
	$result_asistencia =@pg_Exec($conn,$sql_asistencia);
	$fila_asistencia = @pg_fetch_array($result_asistencia,0);
	$inasistencia = $fila_asistencia['cantidad'];
	?>
    <td>
	  <div align="center"><font face="Arial, Helvetica, sans-serif" size="-2">
	    <? echo $inasistencia;?>
      </font></div></td>
  </tr>
  <tr>
    <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>TOTAL ASISTENCIAS (%) (Anual)</strong></font></div></td>
    <td colspan="5">&nbsp;</td>
	<?
	if ($inasistencia>0)
		$porcentaje = 100-round($inasistencia * 100/$habiles,2)."%";
	else
		$porcentaje = "100%";
	?>
    <td><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $asistencia_real;?></font></div></td>
  </tr>
  <tr>
    <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Nº DE ATRASOS (Anual)</strong></font></div></td>
    <td colspan="5">&nbsp;</td>
	<?
	$sql_atraso = "select fecha from anotacion where anotacion.tipo = 2 and anotacion.rut_alumno = '".$alumno . "'";
	$result_atraso =@pg_Exec($conn,$sql_atraso);
	$suma = 0;
	for($g=0 ; $g < @pg_numrows($result_atraso) ; $g++)
	{
		$fila_atraso = @pg_fetch_array($result_atraso,$g);
		$atraso = strftime("%Y",$fila_atraso['fecha']);
		if ($atraso==$nro_ano)
			$suma = suma + 1;
	}		
	?>
    <td><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $suma;?></font></div></td>
  </tr>
</table>
 <?  } 
	if ($cantidad_periodos==2)
	{?>
 <table width="650" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td width="307" rowspan="2"><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>ASIGNATURA O SUBSECTOR DE APRENDIZAJE</strong></font></div></td>
    <td colspan="2"><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>PROMEDIOS</strong></font></div></td>
    <td width="62" rowspan="2"><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>PROMEDIO ANUAL</strong></font></div></td>
    <td width="54" rowspan="2"><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>EXAMEN</strong></font></div></td>
    <td width="73" rowspan="2"><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>CALIFICACIÓN FINAL</strong></font></div></td>
    </tr>
  <tr>
    <td width="71"><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>1º Sem </strong></font></div></td>
    <td width="69"><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>2º Sem </strong></font></div>      
    <div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"></font></div></td>
    </tr>
  <?
  	for($f=0 ; $f < @pg_numrows($result_subsector) ; $f++)
	{
		$fila_subsector = @pg_fetch_array($result_subsector,$f);
		$id_ramo = $fila_subsector['id_ramo'];
		$nom_subsector = $fila_subsector['nombre'];
		$modo_eval = $fila_subsector['modo_eval'];
		$conex = $fila_subsector['conex'];
		$nota_exim = $fila_subsector['nota_exim'];
		$sw = 0;
  ?>	
  <tr>
    <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $nom_subsector?></font></div></td>
   <?
	//---------
	$prom_gene_periodos = 0; $contador_pro=0;	
	//---------
	for($procom=0 ; $procom < 2 ; $procom++)
	{?>    
	<td><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2">
	<?
		$sw = 0	;
		$sql_notas = "SELECT promedio from notas$nro_ano where rut_alumno = '".$alumno."' and id_ramo = ".$id_ramo." and id_periodo = ".$periodo[$procom]." order by id_periodo";
		$result_notas =@pg_Exec($conn,$sql_notas);
		$fila_notas = @pg_fetch_array($result_notas,0);
		$promedio = $fila_notas['promedio'];		
			if ($modo_eval==1)
			{		
				if ($promedio>0){
//					echo $promedio;
					if($promedio<40){
						?><font color="#FF0000"><? echo $promedio;?> </font>	<?
					}else{
						echo $promedio;
					}
					$prom_gene_periodos = $prom_gene_periodos + $promedio;
					$contador_pro = $contador_pro + 1;					
				}
				else{
					echo "---";
					$sw = 1;
				}
			}
			else
			{
				if (empty($promedio) or chop($promedio)=="0"){
					echo "---";
					$sw = 1;
				}
				else{
					echo $promedio;
					$promedio = Conceptual($promedio,2);
					$prom_gene_periodos = $prom_gene_periodos + $promedio;			
					$contador_pro = $contador_pro + 1;										
				}
			}
?>
</font></div></td>
<?
}
	if ($conex==1){
		$sql_promedio = "select * from situacion_final where rut_alumno = '".$alumno."' and id_ramo = ".$id_ramo;
		$result_promedio =@pg_Exec($conn,$sql_promedio);
		$fila_promedio = @pg_fetch_array($result_promedio,0);
		$prom_gral = $fila_promedio['prom_gral'];
		$nota_examen = $fila_promedio['nota_examen'];
		if ($prom_gral == $nota_exim or $prom_gral > $nota_exim ) $nota_examen = "---";
		$nota_final = $fila_promedio['nota_final'];	
	} else {
		$nota_examen = "---";
		if ($prom_gene_periodos>0)
			$prom_gral = Promediar($prom_gene_periodos,$contador_pro,$truncado_per);
		$prom_gene_periodos = 0;
		$nota_final = $prom_gral;
		
	}
	if ($modo_eval==2){
		$prom_gral = Conceptual($prom_gral,1);
		$nota_final = $prom_gral ;
	}
	if ($sw==1){
		$nota_examen = "---";
		$prom_gral = "---";
		$nota_final = "---";
	}
	?>
    <td><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2">
      <? if (!empty($prom_gral)) echo $prom_gral; else echo "---";?>
    </font></div></td>
    <td><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><? if ($nota_examen>0) echo $nota_examen; else echo "---";?></font></div></td>
    <td><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><? if (!empty($nota_final)) echo $nota_final; else echo "---";?></font></div></td>
  </tr>
  <? } ?>
  <tr>
    <td width="307"><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>PROMEDIO GENERAL</strong></font></div></td>
    <td colspan="4">&nbsp;</td>
	<?
	$sql_promedio = "select promedio, asistencia from promocion where rut_alumno = '".$alumno. "' and id_curso = ".$curso;
	$result_promedio =@pg_Exec($conn,$sql_promedio);
	$fila_promedio = @pg_fetch_array($result_promedio,0);
	$promedio_final_alumno = 	$fila_promedio['promedio'];
	$asistencia_real = $fila_promedio['asistencia'];
	?>
    <td width="73"><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><? if ($promedio_final_alumno>0) echo $promedio_final_alumno; else echo "---";?></font></div></td>			
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="4">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>TOT. DIAS/HORAS POR TRABAJAR (Anual)</strong></font></div></td>
    <td colspan="4">&nbsp;</td>
    <td><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2">
        <? echo $habiles;?>
    </font></div></td>
  </tr>
  <tr>
    <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>TOTAL INASISTENCIAS (Anual)</strong></font></div></td>
    <td colspan="4">&nbsp;</td>
	<?
	$sql_asistencia = "select count(*) as cantidad from asistencia where rut_alumno = '".$alumno."' and ano = ".$ano." ";
	$result_asistencia =@pg_Exec($conn,$sql_asistencia);
	$fila_asistencia = @pg_fetch_array($result_asistencia,0);
	$inasistencia = $fila_asistencia['cantidad'];
	?>
    <td>
	  <div align="center"><font face="Arial, Helvetica, sans-serif" size="-2">
	    <? echo $inasistencia;?>
      </font></div></td>
  </tr>
  <tr>
    <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>TOTAL ASISTENCIAS (%) (Anual)</strong></font></div></td>
    <td colspan="4">&nbsp;</td>
	<?
	if ($inasistencia>0)
		$porcentaje = 100-round($inasistencia * 100/$habiles,2)."%";
	else
		$porcentaje = "100%";
	?>
    <td><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $asistencia_real;?></font></div></td>
  </tr>
  <tr>
    <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Nº DE ATRASOS (Anual)</strong></font></div></td>
    <td colspan="4">&nbsp;</td>
	<?
	$sql_atraso = "select fecha from anotacion where anotacion.tipo = 2 and anotacion.rut_alumno = '".$alumno . "'";
	$result_atraso =@pg_Exec($conn,$sql_atraso);
	$suma = 0;
	for($g=0 ; $g < @pg_numrows($result_atraso) ; $g++)
	{
		$fila_atraso = @pg_fetch_array($result_atraso,$g);
		$atraso = strftime("%Y",$fila_atraso['fecha']);
		if ($atraso==$nro_ano)
			$suma = suma + 1;
	}		
	?>
    <td><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $suma;?></font></div></td>
  </tr>
</table>
	


<!-- inicio informe personalidad -->
<br>
  <table width="650" border="0" align="center">
	<tr> 
	  <td align="center" bgcolor="#003b85"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">
	  <strong><? 
	  	if($titulo1!=''){
	  		echo $titulo1;
		}else{	?>
			Informe de Desarrollo Personal y Social
	<?	}
	  ?>&nbsp;</strong></font></td>

	</tr>
  </table>

	<table width="650" cellpadding="0" cellspacing="0">
		<tr>
			<td></td>
		<?php 
					for($countP=0 ; $countP<@pg_numrows($result_periodo) ; $countP++){
					$filaPeriodo=@pg_fetch_array($result_periodo, $countP);
					if(trim($filaPeriodo['nombre_periodo'])=="PRIMER TRIMESTRE") $per="1 Tr.";
					if(trim($filaPeriodo['nombre_periodo'])=="SEGUNDO TRIMESTRE") $per="2 Tr.";
					if(trim($filaPeriodo['nombre_periodo'])=="TERCER TRIMESTRE") $per="3 Tr.";
					if(trim($filaPeriodo['nombre_periodo'])=="PRIMER SEMESTRE") $per="1 Sem.";
					if(trim($filaPeriodo['nombre_periodo'])=="SEGUNDO SEMESTRE") $per="2 Sem.";	?>
						<td align="center"><font size=1 face=Arial, Helvetica, sans-serif><? echo $per;?></font></td>
				<?	}	?>
		</tr>
<?			$sqlTraeConcepto="SELECT * FROM informe_concepto_eval where id_plantilla=".$filaPlantilla['id_plantilla'];
			$resultTraeConcepto=@pg_Exec($conn, $sqlTraeConcepto);
				//trae areas
				$sqlTraeArea="SELECT * FROM informe_area WHERE id_plantilla=".$filaPlantilla['id_plantilla'];
				$resultTraeArea=@pg_Exec($conn, $sqlTraeArea);
				$num=0;
				for($countArea=0 ; $countArea<@pg_numrows($resultTraeArea) ; $countArea++){
					$filaTraeArea=@pg_fetch_array($resultTraeArea, $countArea);
					?>
					<tr><td valign=bottom><font size=1 face=Arial, Helvetica, sans-serif><strong><? echo $filaTraeArea['nombre'];?></strong></font></td>
					<td valign=bottom><font face=Arial, Helvetica, sans-serif>&nbsp;</font></td></tr>
					<?
						//trae subareas para cada area y las imprime
						$sqlTraeSubarea="SELECT * FROM informe_subarea WHERE id_area=".$filaTraeArea['id_area'];
						$resultTraeSubarea=@pg_Exec($conn, $sqlTraeSubarea);
						for($countSubarea=0 ; $countSubarea<@pg_numrows($resultTraeSubarea) ; $countSubarea++){
							$filaTraeSubarea=@pg_fetch_array($resultTraeSubarea, $countSubarea);	?>
							<tr><td valign=bottom><font size=1 face=Arial, Helvetica, sans-serif>&nbsp;&nbsp;&nbsp;<strong><? echo $filaTraeSubarea['nombre'];?></strong></font></td><tr><td bgcolor="#000000" ></td></tr>
							<?
								//trae itemes para cada subarea y los imprime junto con los conceptos para cada item				
								$sqlTraeItem="SELECT * FROM informe_item WHERE id_subarea=".$filaTraeSubarea['id_subarea'];
								$resultTraeItem=@pg_Exec($conn, $sqlTraeItem);
								
								for($countItem=0 ; $countItem<@pg_numrows($resultTraeItem) ; $countItem++){
									$num=$num+1;
									$countI++;
									$filaTraeItem=@pg_fetch_array($resultTraeItem, $countItem);
									//PRIMERO TENGO QUE PREGUNTAR SI EL ITEM SE EVALUA CON CONCEPTOS, SI/NO(RADIO), TEXTO
									
									if($countItem%2==0){
										$color="#CDCDCD";
									}else{
										$color="#B5B5B5";
									}	?>
									<tr><td valign=bottom>
									<?
									
									if(($filaTraeItem['tipo']==1) or ($filaTraeItem['tipo']==2) and ($countItem!=0)){
									}
									?>									
									<font size=1 face=Arial, Helvetica, sans-serif><? echo $num .".- ".$filaTraeItem['glosa'];?></font>
									<?
									if($filaTraeItem['tipo']==0){
									}	?>
									</td>
									<?
											if($filaTraeItem['tipo']==0){
											
											   $sqlP="select * from periodo where id_ano=".$ano." order by id_periodo";
											   $resultP=@pg_Exec($conn, $sqlP);
											   for($countEval=0 ; $countEval<pg_numrows($resultP) ; $countEval++){
											   $filaP=@pg_fetch_array($resultP,$countEval);
												$sqlTraeEval="select * from informe_evaluacion inner join periodo on informe_evaluacion.id_periodo=periodo.id_periodo where informe_evaluacion.id_item=".$filaTraeItem['id_item']." and informe_evaluacion.id_ano=".$ano."and periodo.id_periodo='".$filaP['id_periodo']."' and informe_evaluacion.rut_alumno='".$alumno."' order by periodo.nombre_periodo";
												$resultEval=@pg_Exec($conn, $sqlTraeEval);
												$filaEval=@pg_fetch_array($resultEval,0);
													$sqlTraeConc="select * from informe_concepto_eval where id_concepto=".$filaEval['id_concepto'];
													$resultConc=@pg_Exec($conn, $sqlTraeConc);
													$filaConc=@pg_fetch_array($resultConc,0);
													?>
													<td valign=bottom>&nbsp;&nbsp;
													<font size=1 face=Arial, Helvetica, sans-serif><? echo $filaConc['sigla'];?></font></td>
											<?	}
											}else if($filaTraeItem['tipo']==2){
												//$sqlTraeEval="select * from informe_evaluacion where id_item=".$filaTraeItem['id_item']." and id_ano=".$filaMatri['id_ano']." and id_periodo=".$id_periodo." and rut_alumno='".$alumno."'";
												$sqlTraeEvalu="select * from informe_evaluacion inner join periodo on informe_evaluacion.id_periodo=periodo.id_periodo where informe_evaluacion.id_item=".$filaTraeItem['id_item']." and informe_evaluacion.id_ano=".$ano." and informe_evaluacion.rut_alumno='".$alumno."' order by periodo.nombre_periodo asc";
												$resultEvalu=@pg_Exec($conn, $sqlTraeEvalu);
												for($countEvalu=0 ; $countEvalu<pg_numrows($resultEvalu) ; $countEvalu++){
													$filaEvalu=pg_fetch_array($resultEvalu,$countEvalu);	?>
													<tr><td valign=bottom>
													<font size=1 face=Arial, Helvetica, sans-serif>&nbsp;&nbsp;&nbsp;&nbsp;<? echo $filaEvalu['nombre_periodo'];?> :&nbsp;&nbsp; <? echo $filaEvalu['text'];?></td></tr>
													<tr><td bgcolor="#0099FF" ></td></tr>
											<?	}
											}else if($filaTraeItem['tipo']==1){
												//$sqlTraeEval="select * from informe_evaluacion where id_item=".$filaTraeItem['id_item']." and id_ano=".$filaMatri['id_ano']." and id_periodo=".$id_periodo." and rut_alumno='".$alumno."'";
												$sqlTraeEvalua="select * from informe_evaluacion inner join periodo on informe_evaluacion.id_periodo=periodo.id_periodo where informe_evaluacion.id_item=".$filaTraeItem['id_item']." and informe_evaluacion.id_ano=".$ano." and informe_evaluacion.rut_alumno='".$alumno."' order by periodo.nombre_periodo asc";
												$resultEvalua=@pg_Exec($conn, $sqlTraeEvalua);
												for($countEvalua=0 ; $countEvalua<pg_numrows($resultEvalua) ; $countEvalua++){
													$filaEvalua=@pg_fetch_array($resultEvalua,$countEvalua);
													if(($filaEvalua['radio']==0) and ($filaEvalua['radio']!="")){	?>
															<tr><td valign=bottom>
															<font size=1 face=Arial, Helvetica, sans-serif>&nbsp;&nbsp;&nbsp;&nbsp;<? echo $filaEvalua['nombre_periodo'];?>:&nbsp;&nbsp;No</font></td></tr>	
															<tr><td bgcolor="#0099FF" ></td></tr>
													<?	}else if($filaEvalua['radio']==1){	?>
															<tr><td valign=bottom>
															<font size=1 face=Arial, Helvetica, sans-serif>&nbsp;&nbsp;&nbsp;&nbsp;<? echo $filaEvalua['nombre_periodo'];?>:&nbsp;&nbsp;Si</font></td></tr>
															<tr><td bgcolor="#0099FF"></td></tr>
													<?	}
												}
													
											}
											
										//if ($countI==14) //echo "<br style=\"page-break-after:always\">";
										
								}//fin for($countItem....
								
						}//fin for($countSubarea....
						
				}//fin for($countArea....
								

	  ?>
		<input name="plantilla" type="hidden" value="<?php echo $filaPlantilla['id_plantilla']?>">
		<input name="alumno" type="hidden" value="<?php echo $alumno?>">
	  </table>
<br>
          <table width="650">
            <tr> 
              <td align="center" bgcolor="#003B85"><strong><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">ESCALA 
                DE EVALUACI&Oacute;N / AREAS DE DESARROLLO</font></strong></td>
            </tr>
            <tr> </tr>
          </table>
          <table width="650" border="0">
            <tr> 
              <?php 
			$sqlConc="SELECT * FROM informe_concepto_eval where id_plantilla=".$filaPlantilla['id_plantilla'];
			$resultConc=@pg_Exec($conn, $sqlConc);
			for($countConc=0 ; $countConc<@pg_numrows($resultConc) ; $countConc++){
				$filaConc=@pg_fetch_array($resultConc,$countConc);
				echo "<td><font size=1 face=Arial, Helvetica, sans-serif>".$filaConc['nombre']."&nbsp;(".$filaConc['sigla'].")</font></td>";
				echo "<td><font size=1 face=Arial, Helvetica, sans-serif>:&nbsp;</font></td>";
				echo "<td><font size=1 face=Arial, Helvetica, sans-serif>".$filaConc['glosa']."</font><td>";
			}		
		?>
            </tr>
          </table>



<!-- fin informe personalidad -->

<br>
	  <table width="650" border="0" cellpadding="0" cellspacing="0" bgcolor="003b85">
		<tr> 
		  <td><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif"><strong>&nbsp;&nbsp; 
			Observaciones:</strong></font></td>
		</tr>
	  </table>
	  <table width="650" border="1" cellpadding="1" cellspacing="0">
		<?php //$sqlTraeObs="select * from informe_observaciones where id_periodo=".$id_periodo." and id_ano=".$filaMatri['id_ano']." and id_plantilla=".$filaPlantilla['id_plantilla']." and rut_alumno='".$alumno."'";
				$sqlTraeObs="select * from informe_observaciones inner join periodo on informe_observaciones.id_periodo=periodo.id_periodo where informe_observaciones.id_ano=".$filaMatri['id_ano']." and informe_observaciones.id_plantilla=".$filaPlantilla['id_plantilla']." and informe_observaciones.rut_alumno='".$alumno."'";
				//exit;
				$resultObs=@pg_Exec($conn, $sqlTraeObs);
				?>
		<?php 
	  for($countObs=0 ; $countObs<@pg_numrows($resultObs) ;$countObs++ ){
	  $filaObs=@pg_fetch_array($resultObs, $countObs);
		echo "<tr>";
		echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">";
		echo $filaObs['nombre_periodo'];
		echo "</td>";
		echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">";
		echo $filaObs['glosa'];
		echo "&nbsp;</font></td>";
		echo "</tr>";
	}
	?>
	  </table>
	  <table width="650" border="0">
		<tr> 
		  <td>&nbsp; </td>
		</tr>
		<tr> 
		  <td align="right">&nbsp;<font size="2" face="Arial, Helvetica, sans-serif">
			<?php setlocale ("LC_TIME", "es_ES"); echo (strftime("%d de %B de %Y")); ?>
			</font> </td>
		</tr>
	</table>

<br>
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>&nbsp;</td>
    <td><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>___________________________</strong></font></div></td>
    <td>&nbsp;</td>
    <td><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>___________________________</strong></font></div></td>
    <td>&nbsp;</td>
    <td><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>___________________________</strong></font></div></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>FIRMA PROFESOR(A) JEFE</strong></font></div></td>
    <td>&nbsp;</td>
    <td><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>ORIENTADORA</strong></font></div></td>
    <td>&nbsp;</td>
    <td><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>FIRMA Y TIMBRE DIRECCI&Oacute;N </strong></font></div></td>
    <td>&nbsp;</td>
  </tr>
</table>


 <? 
// echo $cantidad_alumnos." CANTIDAD ".$i." INDICE __ RESTA:".($cantidad_alumnos - $i);
 if  (($cantidad_alumnos - $i)<>1) 
	echo "<H1 class=SaltoDePagina>&nbsp;</H1>";
	
	
} 
}
?>
</center>
</body>
</html>
