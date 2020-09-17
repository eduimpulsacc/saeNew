<?  require('../../../../util/header.inc');
	require('../../../../util/LlenarCombo.php3');
	require('../../../../util/SeleccionaCombo.inc');

	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	
?>
<html>
<head>
<title>Documento sin t&iacute;tulo</title>

<link href="../../../../util/objeto.css" rel="stylesheet" type="text/css">
<link href="../../Colegio_restore/css/objeto.css" rel="stylesheet" type="text/css">
<link href="../../Colegio_restore/Reportes/css/objeto.css" rel="stylesheet" type="text/css">
</head>

<body>

<? 
$sql_curso= "SELECT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, curso.ensenanza, curso.cod_decreto  ";
$sql_curso = $sql_curso . "FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
$sql_curso = $sql_curso . "WHERE (((curso.id_ano)=".$ano.")) ";
$sql_curso = $sql_curso . "ORDER BY curso.ensenanza, curso.grado_curso, curso.letra_curso; ";
$resultado_query_cue = pg_exec($conn,$sql_curso);
?>

<center>
<form action="Lista_Curso_adap.php" method="post" target="mainFrame">
<table width="709" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td width="705">
	<table width="705" height="43" border="1" cellpadding="0" cellspacing="0">
  <tr>
    <td width="701" class="titulosMotores">Buscador Avanzado </td>
  </tr>
  <tr>
    <td height="27">
	<table width="701" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="78" class="textosmediano">Curso</td>
    <td width="263" colspan="2">
	  <div align="left"> 
	    <font size="1" face="arial, geneva, helvetica">
		  <select name="cmb_curso" class="ddlb_x">
			  <option value=0 selected>(Seleccione Curso)</option>
			<?
			  for($i=0 ; $i < @pg_numrows($resultado_query_cue) ; $i++)
			  {
				  $fila = @pg_fetch_array($resultado_query_cue,$i); 
				  $Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
				  echo "<option value=".$fila['id_curso'].">".$Curso_pal."</option>";
			   } ?>
		  </select>
		 </font>
		</div>
	</td>
   
    <td width="80">&nbsp;</td>
	</tr>
	<tr>
	<td width="61" class="textosmediano">Sexo <input type="checkbox" name="checkSexo" value="1"></td>
	<td width="90" class="textosmediano">Fecha Nac. <input type="checkbox" name="checkFNAc" value="1"></td>
	<td width="90" class="textosmediano">Telefono <input type="checkbox" name="checkFono" value="1"></td>
    <td width="80"><div align="right">
      <input name="cb_ok" type="submit" class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' id="cb_ok" value="Buscar">
    </div></td>
  </tr>
</table>

	</td>
  </tr>
</table>

	</td>
  </tr>
</table>
</form>
</center>
</body>
</html>

