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
<center>
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><div id="capa0">
		<div align="right">
          <input name="button3" type="button" class="botonX" onClick="imprimir();" onMouseOver=this.style.background='FFFFD7';this.style.color='003b85' onMouseOut=this.style.background='#5c6fa9';this.style.color='ffffff' value="IMPRIMIR">
        </div>
      </div></td>
  </tr>
</table>
<?
	$cantidad_cursos = @pg_numrows($result_curso);
	for($i=0 ; $i < @pg_numrows($result_curso) ; $i++)
	{
		$fila_curso = @pg_fetch_array($result_curso,$i);
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
    <td><div align="center" class="Estilo1"><font face="Arial, Helvetica, sans-serif" color="#FFFFFF"><strong>NOMINA DE ALUMNOS CON MEJORES PROMEDIOS </strong></font></div></td>
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
    <td width="233"><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>NOMBRE DEL ALMUNO</strong></font></div></td>
    <td width="41"><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>NOTA</strong></font></div></td>
    <td width="284"><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>CURSO</strong></font></div></td>
    <td width="82"><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>RUT</strong></font></div></td>
  </tr>
  <?
  	// ALUMNOS DEL CURSO //
	$sql_alumno = "SELECT matricula.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat ";
	$sql_alumno = $sql_alumno . "FROM matricula INNER JOIN alumno ON matricula.rut_alumno = alumno.rut_alumno ";
	$sql_alumno = $sql_alumno . "WHERE (((matricula.id_curso)=".$curso.")); ";
	$result_alumno = @pg_Exec($conn, $sql_alumno);
	$cadena="";
	for($cont=0 ; $cont < @pg_numrows($result_alumno) ; $cont++)
	{
		$fila_alumno = @pg_fetch_array($result_alumno,$cont);
		$alumno = $fila_alumno['rut_alumno'];
		$sql_notas = "SELECT notas.promedio ";
		$sql_notas = $sql_notas . "FROM notas INNER JOIN ramo ON notas.id_ramo = ramo.id_ramo ";
		$sql_notas = $sql_notas . "WHERE (((notas.rut_alumno)=".$alumno.") AND ((ramo.modo_eval)=1) AND ((notas.id_periodo)=".$periodo.")); ";
		$result_notas = @pg_Exec($conn, $sql_notas);
		$cont_gen = 0;	$promedio = 0; 
		for($cont2=0 ; $cont2 < @pg_numrows($result_notas) ; $cont2++)
		{
			$fila_notas = @pg_fetch_array($result_notas,$cont2);
			if ($fila_notas['promedio']>0){
				$cont_gen = $cont_gen + 1;
				$promedio = $promedio + $fila_notas['promedio'];}
		}
		if ($cont_gen>0)
			$promedio = round($promedio/$cont_gen,0);
		else
			$promedio = "00";
		if (empty($cadena))
			$cadena = $promedio.$alumno;
		else
			$cadena = $cadena . ";" . $promedio.$alumno;

	}
	$notas = explode(";",$cadena);
	rsort($notas);
	if (@pg_numrows($result_alumno)<=10)
		$maximo = @pg_numrows($result_alumno);
	else
		$maximo = 10;
	for($cont_3=0 ; $cont_3 < $maximo ; $cont_3++)
	{
		$nota_prom = substr($notas[$cont_3],0,2);
		if ($nota_prom=="00")
			$nota_prom = "&nbsp;";
		$alumno = substr($notas[$cont_3],2,8);
		$sql_alumno = "select * from alumno where rut_alumno = ".$alumno;
		$result_alumno = @pg_Exec($conn, $sql_alumno);
		$fila_alumno = @pg_fetch_array($result_alumno ,0);
		$rut_alumno = $fila_alumno['rut_alumno']."-".$fila_alumno['dig_rut'];
		$nombre_alumno = ucwords(strtolower($fila_alumno['ape_pat'] . " " . $fila_alumno['ape_mat'] . " " . $fila_alumno['nombre_alu']));
  ?>
  <tr>
    <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $nombre_alumno?></font></div></td>
    <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $nota_prom?></font></div></td>
    <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $Curso_pal?></font></div></td>
    <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $rut_alumno?></font></div></td>
  </tr>
  <? 
  }
  ?>
</table>

<hr width="100%" color=#003b85>
    </tr>
</table>  
 <? if  (($cantidad_cursos - $i)<>1) 
	echo "<H1 class=SaltoDePagina>&nbsp;</H1>";

} ?>
</center>
</body>
</html>
<? pg_close($conn);?>