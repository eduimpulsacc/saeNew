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
	$periodo		=$c_periodos;
	if ($periodo==0)
		 exit;
	//----------------------------------------------------------------------------
	// DATOS INSTITUCION
	//----------------------------------------------------------------------------
	$sql_institu = "SELECT institucion.nombre_instit, institucion.calle, institucion.nro, comuna.nom_com, institucion.telefono ";
	$sql_institu = $sql_institu . "FROM institucion INNER JOIN comuna ON (institucion.region = comuna.cod_reg) AND (institucion.ciudad = comuna.cor_pro) AND (institucion.comuna = comuna.cor_com) ";
	$sql_institu = $sql_institu . "WHERE (((institucion.rdb)=".$institucion."));";
	$result_institu =@pg_Exec($conn,$sql_institu);
	$fila_institu = @pg_fetch_array($result_institu,0);
	$nombre_institu = ucwords(strtolower($fila_institu['nombre_instit']));
	$direccion = ucwords(strtolower($fila_institu['calle'])) . " " . $fila_institu['nro'] . " - " . strtoupper($fila_institu['nom_com']);
	$telefono = $fila_institu['telefono'];
	//----------------------------------------------------------------------------
	// AÑO ESCOLAR
	//----------------------------------------------------------------------------
	$sql_ano = "select * from ano_escolar where id_ano = ".$ano;
	$result_ano =@pg_Exec($conn,$sql_ano);
	$fila_ano = @pg_fetch_array($result_ano,0);
	$nro_ano = $fila_ano['nro_ano'];
	//----------------------------------------------------------------------------
	// DATOS PERIODO
	//----------------------------------------------------------------------------
	$sql_periodo = "select * from periodo where id_periodo = ".$periodo;
	$result_periodo = @pg_Exec($conn, $sql_periodo);
	$fila_periodo = @pg_fetch_array($result_periodo,0);
	$periodo_pal = $fila_periodo['nombre_periodo'] . " DEL " . $nro_ano;
	//----------------------------------------------------------------------------
	// DATOS CURSO
	//----------------------------------------------------------------------------	
	if ($curso == 0)
	{
		$sql_curso = "select * from curso where id_ano= ".$ano ." order by ensenanza, grado_curso, letra_curso";
		$result_curso = @pg_Exec($conn, $sql_curso);
	}
	else
	{
		$sql_curso = "select * from curso where id_curso = ".$curso;
		$result_curso = @pg_Exec($conn, $sql_curso);
	}
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
          <input name="button3" type="button" class="botonX" onClick="parent.location='../curso.php3'" onMouseOver=this.style.background='FFFFD7';this.style.color='003b85' onMouseOut=this.style.background='#5c6fa9';this.style.color='ffffff' value="VOLVER">
		  <input name="button3" type="button" class="botonX" onClick="imprimir();" onMouseOver=this.style.background='FFFFD7';this.style.color='003b85' onMouseOut=this.style.background='#5c6fa9';this.style.color='ffffff' value="IMPRIMIR">
        </div>
      </div></td>
  </tr>
</table>
<?
	$cantidad_cursos = @pg_numrows($result_curso);
	
		$fila_curso = @pg_fetch_array($result_curso,0);
		$curso = $fila_curso['id_curso'];
		$Curso_pal = CursoPalabra($curso, 0, $conn);
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
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-1"><strong><? echo $nombre_institu;?></strong></font></div></td>
    </tr>
  <tr>
    <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-1"><strong><? echo $direccion;?></strong></font></div></td>
    </tr>
  <tr>
    <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-1"><strong><? echo $telefono;?></strong></font></div></td>
    </tr>
  <tr bgcolor="#003b85">
    <td bgcolor="#003b85"><div align="center" class="Estilo1"><font face="Arial, Helvetica, sans-serif" color="#FFFFFF"><strong>INFORME RENDIMIENTO ESCOLAR POR CURSO</strong></font></div></td>
    </tr>
  <tr>
    <td><div align="center"><font face="Arial, Helvetica, sans-serif" size="-1"><strong><? echo $periodo_pal;?></strong></font></div></td>
    </tr>
</table>
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="63">&nbsp;</td>
    <td width="8">&nbsp;</td>
    <td width="571">&nbsp;</td>
  </tr>
  <tr>
    <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-1"><strong>Profesor</strong></font></div></td>
    <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-1"><strong>:</strong></font></div></td>
    <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-1"><? echo $profesor;?></font></div></td>
  </tr>
  <tr>
    <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-1"><strong>Curso</strong></font></div></td>
    <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-1"><strong>:</strong></font></div></td>
    <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-1"><? echo $Curso_pal;?></font></div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="650" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="2"><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Nombre Asignatura</strong></font></div></td>
    <td width="171"><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Nombre Profesor</strong></font></div></td>
    <td colspan="2"><div align="Center"><font face="Arial, Helvetica, sans-serif" size="-2"><strong><1 - 3.9></strong></font></div></td>
    <td colspan="2"><div align="Center"><font face="Arial, Helvetica, sans-serif" size="-2"><strong><4 - 4.9></strong></font></div></td>
    <td colspan="2"><div align="Center"><font face="Arial, Helvetica, sans-serif" size="-2"><strong><5 - 5.9></strong></font></div></td>
    <td colspan="2"><div align="Center"><font face="Arial, Helvetica, sans-serif" size="-2"><strong><6 - 7.0></strong></font></div></td>
    </tr>
	<?
	//----------------------------------------------------------------
	// SUBSECTORES
	//----------------------------------------------------------------
	$sql_sub = "SELECT subsector.cod_subsector, subsector.nombre, ramo.id_ramo, ramo.modo_eval ";
	$sql_sub = $sql_sub . "FROM ramo INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector ";
	$sql_sub = $sql_sub . "WHERE (((ramo.id_curso)=".$curso.")) AND ramo.modo_eval<>2 ORDER BY subsector.cod_subsector; ";
	$result_sub = @pg_Exec($conn, $sql_sub);
    $cont_gen1 = 0; $cont_gen2 = 0;
    $cont_gen3 = 0; $cont_gen4 = 0;
	for($e=0 ; $e < @pg_numrows($result_sub) ; $e++)
	{
		// DATOS SUBSECTOR //
		$fila_sub = @pg_fetch_array($result_sub,$e);
		$ramo = $fila_sub['id_ramo'];
		$subsector_num = $fila_sub['cod_subsector'];
		$subsector_pal = ucwords(strtolower($fila_sub['nombre']));
		$modo_eval = $fila_sub['modo_eval'];
		
		// DATOS PROFESOR SUBSECTOR
		$sql_dicta = "SELECT dicta.id_ramo, empleado.ape_pat, empleado.ape_mat, empleado.nombre_emp ";
		$sql_dicta = $sql_dicta . "FROM dicta INNER JOIN empleado ON dicta.rut_emp = empleado.rut_emp ";
		$sql_dicta = $sql_dicta . "WHERE (((dicta.id_ramo)=".$ramo.")); ";
		$result_dicta = @pg_Exec($conn, $sql_dicta);
		$fila_dicta = @pg_fetch_array($result_dicta,0);
		$profe_dicta = ucwords(strtolower($fila_dicta['nombre_emp'] . " " . $fila_dicta['ape_pat'] . " " . $fila_dicta['ape_mat']));
		
		$sql_tiene = "SELECT  rut_alumno FROM tiene$nro_ano WHERE id_ramo=" . $ramo;
		$result_tiene = @pg_exec($conn,$sql_tiene);
		$Cuenta = 0;
		$rut = 0;
		for($a=0;$a<@pg_numrows($result_tiene);$a++){
			$fila_tiene= @pg_fetch_array($result_tiene,$a);
			$rut_alumno[$a] = trim($fila_tiene['rut_alumno']);
			$rut++;
		}
		
		for($u=0;$u<$rut;$u++){
		// NOTAS //
			$sql_notas = "SELECT notas$nro_ano.promedio, notas$nro_ano.id_ramo, notas$nro_ano.id_periodo ";
			$sql_notas = $sql_notas . "FROM notas$nro_ano  ";
			$sql_notas = $sql_notas . "WHERE (((notas$nro_ano.id_ramo)=".$ramo.") AND ((notas$nro_ano.id_periodo)=".$periodo.")) AND (notas$nro_ano.rut_alumno='" . $rut_alumno[$u]."')";
			$result_notas = @pg_Exec($conn, $sql_notas);
			$fila_notas = @pg_fetch_array($result_notas,0);
			$promedio[$u] = $fila_notas['promedio'];
			$Cuenta ++;
		}
		$con_gen  = 0;
		$con_1 = 0;		$con_2 = 0;
		$con_3 = 0;		$con_4 = 0;
		$porcentaje1=0; $porcentaje2=0;						
		$porcentaje3=0; $porcentaje4=0;								
		
		for($o=0 ; $o < $Cuenta ; $o++)
		{
			
				if ($promedio[$o]>0)
				{
					$con_gen = $con_gen +1;
					if ($promedio[$o] > 0 and  $promedio[$o] < 40)
						$con_1 = $con_1  + 1;
					if ($promedio[$o] > 39 and  $promedio[$o] < 50)
						$con_2 = $con_2  + 1;
					if ($promedio[$o] > 49 and  $promedio[$o] < 60)
						$con_3 = $con_3  + 1;										
					if ($promedio[$o] > 59 and  $promedio[$o] < 71)
						$con_4 = $con_4  + 1;
				}
		}// fin for o
							
		if ($con_1>0)
			$porcentaje1 = round($con_1*100/$con_gen,0) ."";
		else
			$porcentaje1 = "0";
		if ($con_2>0)
			$porcentaje2 = round($con_2*100/$con_gen,0) ."";
		else
			$porcentaje2 = "0";			
		if ($con_3>0)
			$porcentaje3 = round($con_3*100/$con_gen,0) ."";
		else
			$porcentaje3 = "0";
		if ($con_4>0)
			$porcentaje4 = round($con_4*100/$con_gen,0) ."";
		else
			$porcentaje4 = "0";
	
	?>
  <tr>
    <td width="28"><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $subsector_num;?></font></div></td>
    <td width="208"><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $subsector_pal;?></font></div></td>
    <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $profe_dicta;?></font></div></td>
    <td width="27"><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $con_1; ?></font></div></td>
    <td width="27"><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $porcentaje1."%"; ?></font></div></td>
    <td width="27"><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $con_2; ?></font></div></td>
    <td width="27"><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $porcentaje2."%"; ?></font></div></td>
    <td width="27"><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $con_3; ?></font></div></td>
    <td width="27"><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $porcentaje3."%"; ?></font></div></td>
    <td width="27"><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $con_4; ?></font></div></td>
    <td width="27"><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $porcentaje4."%"; ?></font></div></td>
  </tr>
  <? } // FIN FOR E ?>
</table>
<br>

<hr width="100%" color=#003b85>
    </tr>
</table>  
 <? if  (($cantidad_cursos - $i)<>1) 
	echo "<H1 class=SaltoDePagina>&nbsp;</H1>";

?>
</center>
</body>
</html>
