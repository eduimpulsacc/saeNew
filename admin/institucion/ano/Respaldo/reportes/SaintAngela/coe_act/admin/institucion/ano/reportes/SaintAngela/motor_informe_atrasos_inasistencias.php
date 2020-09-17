<? require('../../../../../util/header.inc');

	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	
?>
<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../util/objeto.css" rel="stylesheet" type="text/css">
<link href="../../Colegio_restore/Reportes/css/objeto.css" rel="stylesheet" type="text/css">
<link href="../../Colegio_restore/css/objeto.css" rel="stylesheet" type="text/css">
</head>

<body>
<form action="InformeGeneralAsistencia.php" method="post" target="mainFrame">
<? 
$sql_curso= "SELECT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, curso.ensenanza, curso.cod_decreto ";
$sql_curso = $sql_curso . "FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
$sql_curso = $sql_curso . "WHERE (((curso.id_ano)=".$ano.")) ";
$sql_curso = $sql_curso . "ORDER BY curso.ensenanza, curso.grado_curso, curso.letra_curso; ";
$resultado_query_cue = pg_exec($conn,$sql_curso);
?>
<center>
<table width="686" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="674">
	<table width="686" height="43" border="1" cellpadding="0" cellspacing="0">
  <tr>
    <td width="865" class="titulosMotores">Buscador Avanzado</td>
  </tr>
  <tr>
    <td height="27">
	<table width="684" height="46" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><font size="1" face="arial, geneva, helvetica">Curso</font></td>
    <td><font size="1" face="arial, geneva, helvetica">
      <select name="cmb_curso" class="ddlb_9_x">
        <?
		  for($i=0 ; $i < @pg_numrows($resultado_query_cue) ; $i++)
		  {
				$fila = @pg_fetch_array($resultado_query_cue,$i); 
				$Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
				echo "<option value=".$fila['id_curso'].">".$Curso_pal."</option>";
          } ?>
      </select>
    </font></td>
    <td><font size="1" face="arial, geneva, helvetica">Fecha 1</font></td>
    <td><div align="left"><font size="1" face="arial, geneva, helvetica">
        <input name="fecha1" type="text" id="fecha1" size="4" maxlength="6" >
    </font></div></td>
    <td><font size="1" face="arial, geneva, helvetica">Fecha 2</font></td>
    <td><div align="left"><font size="1" face="arial, geneva, helvetica">
        <input name="fecha2" type="text" id="fecha2" size="4" maxlength="6" >
    </font></div></td>
    <td><div align="right">
      <input name="cb_ok" class="botonX" onMouseOver=this.style.background='FFFFD7';this.style.color='003b85' onMouseOut=this.style.background='#5c6fa9';this.style.color='ffffff' type="submit" value="Buscar">
</div></td>
  </tr>
  <tr>
    <td width="47">&nbsp;</td>
    <td width="337"><font size="1" face="arial, geneva, helvetica">
	  <div align="left">	  </div></font></td>
    <td width="47">&nbsp;</td>
    <td width="59">
	  <div align="left"><font size="1" face="arial, geneva, helvetica">	dd/mm</font></div></td>
    <td width="47">&nbsp;</td>
    <td width="64"><div align="left"><font size="1" face="arial, geneva, helvetica">      dd/mm</font></div></td>
    <td width="83">
          <div align="right">          </div></td></tr>
</table>

	</td>
  </tr>
</table>

	</td>
  </tr>
</table>
</center>
</form>
</body>
</html>
