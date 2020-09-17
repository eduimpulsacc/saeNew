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
	$sql_curso = "SELECT plan_estudio.nombre_decreto, evaluacion.nombre_decreto_eval, curso.truncado_per ";
	$sql_curso = $sql_curso . "FROM (curso INNER JOIN plan_estudio ON curso.cod_decreto = plan_estudio.cod_decreto) INNER JOIN evaluacion ON curso.cod_eval = evaluacion.cod_eval ";
	$sql_curso = $sql_curso . "WHERE (((curso.id_curso)=".$curso."));";
	$result_curso = @pg_Exec($conn, $sql_curso);
	$fila_curso = @pg_fetch_array($result_curso ,0);
	$decreto_eval = $fila_curso['nombre_decreto_eval'];
	$planes = $fila_curso['nombre_decreto'];
	$truncado_per = $fila_curso['truncado_per'];
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
	
  ?>			
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>.</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../util/objeto.css" rel="stylesheet" type="text/css">
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
    <td width="487"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong><? echo ucwords(strtoupper($nombre_institu));?></strong></font></td>
    <td width="11">&nbsp;</td>
    <td width="152" rowspan="4" align="center">
      <?
		if 	(!empty($fila_institu['insignia']))
		{
			$output= "select lo_export(".$arr['insignia'].",'/var/www/html/tmp/".$arr[rdb]."');";
			$retrieve_result = @pg_exec($conn,$output);?>
      <table width="125" border="0" cellpadding="0" cellspacing="0">
        <tr valign="top" >
          <td width="125" align="center"> <img src=../../../../../../../tmp/<? echo $institucion ?> ALT="NO DISPONIBLE"  height="100"></td>
        </tr>
      </table>
      <? } ?>
    </td>
  </tr>
  <tr>
    <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo ucwords(strtolower($direccion));?></font></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1">Fono:&nbsp;<? echo ucwords(strtolower($telefono));?></font></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="41">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="650" border="0" cellspacing="0" cellpadding="0">
    <tr bgcolor="#003b85">
    	<td ><div align="center"><strong><font color="White" size="1" face="verdana, arial, geneva, helvetica">INFORME DE NOTAS FINALES </font></strong></div></td>
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
<br>
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
  <? } ?>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <?
	$sql_promedio = "select promedio, asistencia from promocion where rut_alumno = '".$alumno. "' and id_curso = ".$curso;
	$result_promedio =@pg_Exec($conn,$sql_promedio);
	$fila_promedio = @pg_fetch_array($result_promedio,0);
	$promedio_final_alumno = 	$fila_promedio['promedio'];
	$asistencia_real = $fila_promedio['asistencia'];
	?>
  <tr>
    <td width="307"><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>PROMEDIO FINAL DEL ALUMNO</strong></font></div></td>
    <td colspan="5">&nbsp;</td>
    <td width="73"><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><? if ($promedio_final_alumno>0) echo $promedio_final_alumno; else echo "---";?></font></div></td>			
  </tr>
  <tr>
    <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>MEJOR PROMEDIO DEL CURSO</strong></font></div></td>
    <td colspan="5">&nbsp;</td>
	
    <td><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2">
        <? if ($promedio_final_mejor>0) echo $promedio_final_mejor; else echo "---";?>
    </font></div></td>
  </tr>
  <tr>
    <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>PROMEDIO GENERAL DEL CURSO</strong></font></div></td>
    <td colspan="5">&nbsp;</td>
	
    <td><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2">
        <? if ($promedio_final_curso>0) echo $promedio_final_curso; else echo "---";?>
    </font></div></td>	
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
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="307"><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>PROMEDIO FINAL DEL ALUMNO</strong></font></div></td>
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
    <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>MEJOR PROMEDIO DEL CURSO</strong></font></div></td>
    <td colspan="4">&nbsp;</td>
	
    <td><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2">
        <? if ($promedio_final_mejor>0) echo $promedio_final_mejor; else echo "---";?>
    </font></div></td>
  </tr>
  <tr>
    <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>PROMEDIO GENERAL DEL CURSO</strong></font></div></td>
    <td colspan="4">&nbsp;</td>
	<td><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2">
        <? if ($promedio_final_curso>0) echo $promedio_final_curso; else echo "---";?>
    </font></div></td>	
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
	
<? }?>
<br>
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>OBSERVACIONES:</strong></font></div></td>
  </tr>
  <tr>
    <td height="20"><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>___________________________________________________________________________________________________________</strong></font></div></td>
  </tr>
  <tr>
    <td height="20"><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>___________________________________________________________________________________________________________</strong></font></div></td>
  </tr>
  <tr>
    <td height="20"><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>___________________________________________________________________________________________________________</strong></font></div></td>
  </tr>
</table>
<br>
<br>
<br>
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
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
    <td><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>FIRMA Y TIMBRE DIRECCI&Oacute;N </strong></font></div></td>
    <td>&nbsp;</td>
  </tr>
</table>


 <? 
// echo $cantidad_alumnos." CANTIDAD ".$i." INDICE __ RESTA:".($cantidad_alumnos - $i);
 if  (($cantidad_alumnos - $i)<>1) 
	echo "<H1 class=SaltoDePagina>&nbsp;</H1>";
	
	
} 

?>
</center>
</body>
</html>
<? pg_close($conn);?>