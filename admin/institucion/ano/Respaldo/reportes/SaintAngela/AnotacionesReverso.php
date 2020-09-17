<? 
require('../../../../../util/header.inc');
setlocale("LC_ALL","es_ES");
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
	$curso			=$c_curso;
	$alumno		    =$c_alumno;
	$periodo		=$c_periodos;
	
	//echo "curso - " . $curso . "<br>";
	//echo "alumno - " . $alumno . "<br>";
	//echo "periodo - " . $periodo . "<br>";		

	if ($curso==0) exit;
	//------------------------
	// Año Escolar
	//------------------------
	$sql_ano = "select * from ano_escolar where id_ano = ".$ano;
	$result_ano =@pg_Exec($conn,$sql_ano);
	$fila_ano = @pg_fetch_array($result_ano,0);	
	$ano_escolar = $fila_ano['nro_ano'];
	//-------------- INSTITUCION -------------------------------------------------------------
	$sql_ins = "SELECT institucion.nombre_instit, institucion.calle, institucion.nro, region.nom_reg, provincia.nom_pro, comuna.nom_com, institucion.telefono ";
	$sql_ins = $sql_ins . "FROM ((institucion INNER JOIN region ON institucion.region = region.cod_reg) INNER JOIN provincia ON (institucion.ciudad = provincia.cor_pro) AND (institucion.region = provincia.cod_reg)) INNER JOIN comuna ON (institucion.region = comuna.cod_reg) AND (institucion.ciudad = comuna.cor_pro) AND (institucion.comuna = comuna.cor_com) ";
	$sql_ins = $sql_ins . "WHERE (((institucion.rdb)=".$institucion.")); ";
	$result_ins =@pg_Exec($conn,$sql_ins);
	$fila_ins = @pg_fetch_array($result_ins,0);	
	$ins_pal = $fila_ins['nombre_instit'];
	$direccion = $fila_ins['calle'] . " " . $fila_ins['nro'] . " " . $fila_ins['nom_com'];
	$telefono = $fila_ins['telefono'];
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
<form method="post" target="mainFrame">
<center>
<table width="650" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><div align="right">
	  <div id="capa0">
	    <input name="button3" TYPE="button" class="botonX" onclick="imprimir();" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' value="IMPRIMIR">
	  </div>
    </div></td>
  </tr>
</table>
<?
if ($alumno == 0 ){
	$sql_alumno = "select matricula.rut_alumno, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, matricula.id_curso ";
	$sql_alumno = $sql_alumno . "from matricula, alumno, curso ";
	$sql_alumno = $sql_alumno . "where curso.id_curso = ".$curso." ";
	$sql_alumno = $sql_alumno . "and matricula.rut_alumno = alumno.rut_alumno ";
	$sql_alumno = $sql_alumno . "and matricula.id_ano = ".$ano." and matricula.id_curso = curso.id_curso order by alumno.ape_pat, alumno.ape_pat, alumno.nombre_alu";

}else{
	$sql_alumno = "select matricula.rut_alumno, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, matricula.id_curso ";
	$sql_alumno = $sql_alumno . "from matricula, alumno ";
	$sql_alumno = $sql_alumno . "where matricula.rut_alumno = ".$alumno." ";
	$sql_alumno = $sql_alumno . "and matricula.rut_alumno = alumno.rut_alumno ";
	$sql_alumno = $sql_alumno . "and matricula.id_ano = ".$ano." ";
}

$result_alumno =@pg_Exec($conn,$sql_alumno);	
$cantidad_alumnos = @pg_numrows($result_alumno);
for($e=0 ; $e< @pg_numrows($result_alumno); $e++)
{
?>
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="487"><font face="Verdana, Arial, Helvetica, sans-serif" size="-1"><? echo ucwords(strtolower($direccion));?></font><font face="Verdana, Arial, Helvetica, sans-serif" size="+1">&nbsp;</font></td>
    <td width="11">&nbsp;</td>
    <td width="152" rowspan="4" align="center">
	<?
		$result = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
		$arr=@pg_fetch_array($result,0);
		$fila_foto = @pg_fetch_array($result,0);
		if 	(!empty($fila_foto['insignia']))
		{
			$output= "select lo_export(".$arr['insignia'].",'/var/www/html/tmp/".$arr[rdb]."');";
			$retrieve_result = @pg_exec($conn,$output);?>
		<table width="125" border="0" cellpadding="0" cellspacing="0">
          <tr valign="top" >
            <td width="125" align="center">

							<img src=../../../../../../../tmp/<? echo $institucion ?> ALT="NO DISPONIBLE"  height="100"></td>
		    </tr>
          </table>
			<? } ?>
	</td>
  </tr>
  <tr>
    <td><font face="Verdana, Arial, Helvetica, sans-serif" size="-1"><? echo ucwords(strtolower($telefono));?></font></td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td height="41">&nbsp;</td>
    <td>&nbsp;</td>
    </tr>  
</table>
<br>
<table width="650" border="0" cellspacing="0" cellpadding="0">
    <tr bgcolor="#003b85">
    	<td ><div align="center"><strong><font color="White" size="3" face="arial, geneva, helvetica">INFORME DE ANOTACIONES </font></strong></div></td>
	</tr>
	<tr>
		<td ><div align="center"><font size="2" face="arial, geneva, helvetica">AÑO: <? echo $ano_escolar?> </font></div></td>
	</tr>
</table>
<br>
<?
	$fila_alumno = @pg_fetch_array($result_alumno,$e);	
	$alumno = $fila_alumno['rut_alumno'];
	$nombre_alumno = strtoupper(trim($fila_alumno['ape_pat']))." ".strtoupper(trim($fila_alumno['ape_mat']))." ".strtoupper(trim($fila_alumno['nombre_alu']));
	$curso = $fila_alumno['id_curso'];
	//-----------------------------------------
	$Curso_pal = CursoPalabra($curso, 0, $conn);
	//----------------------------------------
	$sql_profe = "SELECT empleado.ape_pat, empleado.ape_mat, empleado.nombre_emp ";
	$sql_profe = $sql_profe . "FROM supervisa INNER JOIN empleado ON supervisa.rut_emp = empleado.rut_emp ";
	$sql_profe = $sql_profe . "WHERE (((supervisa.id_curso)=".$curso.")); ";
	$result_profe =@pg_Exec($conn,$sql_profe);
	$fila_profe = @pg_fetch_array($result_profe,0);	
	$profe_jefe = ucwords(strtoupper(trim($fila_profe['ape_pat']) . " " . trim($fila_profe['ape_mat'] ) . " " . trim($fila_profe['nombre_emp'])));
	//-----------------------------------------	
	?>
	<table width="650" border="0" cellspacing="0" cellpadding="0">

        <tr>
          <td><font size="2" face="arial, geneva, helvetica"><strong>Alumno</strong></font></td>
          <td><font size="2" face="arial, geneva, helvetica"><strong>:</strong></font></td>
          <td><font size="2" face="arial, geneva, helvetica"><? echo $nombre_alumno;?></font></td>
        </tr>
        <td width="112"><font size="2" face="arial, geneva, helvetica"><strong>Curso</strong></font></td>
        <td width="10"><div align="left"><font size="2" face="arial, geneva, helvetica"><strong>:</strong></font></div></td>
        <td width="534"><font size="2" face="arial, geneva, helvetica"><? echo $Curso_pal;?></font></td>
      </tr>
      <tr>
        <td><font size="2" face="arial, geneva, helvetica"><strong>Profesor(a) Jefe</strong></font></td>
        <td><font size="2" face="arial, geneva, helvetica"><strong>:</strong></font></td>
        <td><font size="2" face="arial, geneva, helvetica"><? echo $profe_jefe;?></font></td>
      </tr>
    </table><br>
	<table width="650" border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td><HR width="100%" color=#003b85></td>
	  </tr>
	</table><br>
	<?
	//----
	$sql_periodo = "select * from periodo where id_ano = ".$ano." and id_periodo = ".$periodo." order by id_periodo";
	$result_periodo =@pg_Exec($conn,$sql_periodo);	
	for($i=0 ; $i< @pg_numrows($result_periodo); $i++)
	{
		$fila_periodo = @pg_fetch_array($result_periodo,$i);	
		$nombre_periodo = $fila_periodo['nombre_periodo'];
		$fecha_inicio = $fila_periodo['fecha_inicio'];
		$fecha_termino = $fila_periodo['fecha_termino'];
		$dias_habiles = $fila_periodo['dias_habiles'];
		//------
		$sql13 = "select count(*) as cantidad from asistencia where rut_alumno = " . $alumno . " and ano = ". $ano . " and id_curso = " . $curso . " and fecha >= '" . $fecha_inicio ."' and fecha <= '" . $fecha_termino . "'";
		$result13 =@pg_Exec($conn,$sql13);
		$fila13 = @pg_fetch_array($result13,0);	
		$inasistencia = $fila13['cantidad'];
		$dias_asistidos = $dias_habiles - $fila13['cantidad'];
		//--
		$sql3 = "SELECT notas.promedio ";
		$sql3 = $sql3 . "FROM notas WHERE (((notas.rut_alumno)='".$alumno."') AND  ((notas.id_periodo)=".$periodo.")); ";
		$result2 =pg_Exec($conn,$sql3);
		$fila2 = pg_fetch_array($result2,0);	
		for($k=0 ; $k < @pg_numrows($result2) ; $k++)
		{
			$fila2 = @pg_fetch_array($result2,$f);
			if(Trim($fila2['promedio'])>0)
			{
				$prom = $fila2['promedio'];
			}else{
				$prom = "&nbsp;";				
			}  
			if (number_format($prom) > 0) 
			{
				  $cont_prom=$cont_prom+1;
				  //echo "Contador ". $cont_prom. "<br>";
				  $promedio = ($promedio + $prom);
				  //echo "Suma" . $promedio ;
			}
		}
		$promedio = round($promedio/$cont_prom,0);
		//------
		?>
		<table width="650" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td><font face="Arial, Helvetica, sans-serif" size="-1"><strong><? echo $nombre_periodo;?></strong></font></td>
		  </tr>
		</table>
		<br>
		<?
		$sql_anota = "select * from anotacion where rut_alumno = ".$alumno." and tipo = 1 and fecha >= '".$fecha_inicio."' and fecha <= '".$fecha_termino."' and date_part('year',fecha) = ".$ano_escolar." order by fecha";
		$result_anota =@pg_Exec($conn,$sql_anota );	
		$bloques = @pg_numrows($result_anota)*7; 
		if (@pg_numrows($result_anota) ==0) echo "<strong>NO SE REGISTRAN ANOTACIONES EN ESTE PERIODO</strong>";
		for($a=0 ; $a< @pg_numrows($result_anota); $a++)
		{
			$fila_periodo = @pg_fetch_array($result_anota,$a);
			$fecha_anota = $fila_periodo['fecha'];
			$rut_responsable = $fila_periodo['rut_emp'];
			$observacion = $fila_periodo['observacion'];
			if ($fila_periodo['tipo_conducta']==1) $tipo_conducta = " - POSITIVA";
			if ($fila_periodo['tipo_conducta']==2) $tipo_conducta = " - NEGATIVA";			
			?>
			<table width="650" border="0" cellspacing="1" cellpadding="1">
			  <tr>
				<td width="86"><font size="2" face="arial, geneva, helvetica"><strong>Conducta</strong></font></td>
				<td width="4"><font size="2" face="arial, geneva, helvetica"><strong>:</strong></font></td>
				<td width="276"><font size="2" face="arial, geneva, helvetica"><? echo "CONDUCTA".$tipo_conducta;?></font></td>
				<td width="39"><font size="2" face="arial, geneva, helvetica"><strong>Fecha</strong></font></td>
				<td width="4"><font size="2" face="arial, geneva, helvetica"><strong>:</strong></font></td>
				<td width="222"><font size="2" face="arial, geneva, helvetica"><? echo cfecha($fecha_anota);?></font></td>				
			  </tr>
			  <tr>
				<td><font size="2" face="arial, geneva, helvetica"><strong>Responsable</strong></font></td>
				<td><font size="2" face="arial, geneva, helvetica"><strong>:</strong></font></td>
				<td colspan="4"><font size="2" face="arial, geneva, helvetica">
				<? 
				$sql_responsable = "select * from empleado where rut_emp = '".$rut_responsable."'";
				$result_responsable =@pg_Exec($conn,$sql_responsable );
				$fila_responsable = @pg_fetch_array($result_responsable ,0);	
				echo strtoupper(trim($fila_responsable['ape_pat']))." ".strtoupper(trim($fila_responsable['ape_mat']))." ".strtoupper(trim($fila_responsable['nombre_emp']));
				?></font></td>
			  </tr>
			  <tr>
				<td colspan="6"><font size="2" face="arial, geneva, helvetica"><strong>Observaci&oacute;n:</strong></font></td>
			  </tr>
			  <tr>
				<td colspan="6"><font size="2" face="arial, geneva, helvetica"><? echo $observacion;?></font></td>
			  </tr>
		</table>
		<br>
		<? } ?>
		<table width="650" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td><HR width="100%" color=#003b85></td>
		  </tr>
		</table>
		<table width="650" border="0" cellspacing="0" cellpadding="0">
		<? for($j=0 ; $j< 34-$bloques; $j++){ ?>
		  <tr>
			<td>&nbsp;</td>
		  </tr>
        <? }?>
		</table>

		<table width="650" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td width="124" align="left"><font face="Arial, Helvetica, sans-serif" size="-2">Devolver colilla firmada</font></td>
			<td width="245">&nbsp;</td>
			<td width="109"><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
			<td width="162">&nbsp;</td>
		  </tr>
		  <tr>
			<td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><strong>Alumno</strong></font></div></td>
			<td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><strong><? echo $nombre_alumno; ?></strong></font></div></td>
			<td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><strong>Curso</strong></font></div></td>
			<td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><strong><? echo ucwords(strtolower($Curso_pal))?></strong></font></div></td>
		  </tr>
		  <tr>
			<td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><strong>Promedio Alumno</strong></font></div></td>
			<td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><strong>
			  <?
			if ($promedio>0)
				echo $promedio;
			else
				echo "&nbsp;";
				
			?>
			  </strong></font></div></td>
			<td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif">Total D&iacute;as Inasistente </font></div></td>
			<td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><? echo $inasistencia ?></font></div></td>
		  </tr>
		  <tr>
			<td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif">Total d&iacute;as Período </font></div></td>
			<td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><? echo trim($dias_habiles) ?></font></div></td>
			<td><font size="1" face="Arial, Helvetica, sans-serif">Total Atrasos </font></td>
			<td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif">
			  <?
			$sql_atraso = "select * from anotacion where rut_alumno = ".$alumno." and tipo = 2 and (fecha >= '" . $fecha_ini ."' and fecha <= '" . $fecha_fin . "')";
			$result_atraso =@pg_Exec($conn,$sql_atraso);
			$fila_atraso = @pg_fetch_array($result_atraso,0);
			if (empty($fila_atraso['cantidad']))
				echo "0";
			else
				echo trim($fila_atraso['cantidad']);
			?>
			</font></div></td>
		  </tr>
		  <tr>
			<td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif">Total Asistencias (%) </font></div></td>
			<td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif">
				<? 
					if ($dias_habiles>0)
					{
						$promedio_asistencia = round(($dias_asistidos*100) / $dias_habiles,2);
						$prom_gen_asis = $prom_gen_asis + $promedio_asistencia; 
						$prom_cont_asis = $prom_cont_asis + 1;
					}
					echo $promedio_asistencia . "%" ;
					?>
			</font></div></td>
			<td><div align="left">&nbsp;</div></td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td><div align="center">___________________________</div></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td><div align="center"><font size="1" face="Arial, Helvetica, sans-serif">Firma Apoderado </font></div></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		</table>
	<? } ?>
<? if  (($cantidad_alumnos - $e)<>1) 
	echo "<H1 class=SaltoDePagina>&nbsp;</H1>";

?>	
<? } ?>	

</center>
</form>
</body>
</html>
