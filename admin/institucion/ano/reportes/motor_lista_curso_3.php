<? require('../../../../util/header.inc');

	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	
?>
<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../util/objeto.css" rel="stylesheet" type="text/css">
<link href="../../Colegio_restore/css/objeto.css" rel="stylesheet" type="text/css">
<link href="../../Colegio_restore/Reportes/css/objeto.css" rel="stylesheet" type="text/css">

<link href="../../../../../coe_prueba/admin/institucion/Colegio_restore/css/objeto.css" rel="stylesheet" type="text/css">
<link href="../../../../../coe_prueba/admin/institucion/Colegio_restore/Reportes/css/objeto.css" rel="stylesheet" type="text/css">
</head>

<body>
<form action="Lista_Alumnos_Curso_3.php" method="post" target="mainFrame">
<? 
$sql_curso= "SELECT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, curso.ensenanza, curso.cod_decreto  ";
$sql_curso = $sql_curso . "FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
$sql_curso = $sql_curso . "WHERE (((curso.id_ano)=".$ano.")) ";
$sql_curso = $sql_curso . "ORDER BY curso.ensenanza, curso.grado_curso, curso.letra_curso; ";
$resultado_query_cue = pg_exec($conn,$sql_curso);

$sql_comuna = "SELECT * FROM comuna order by nom_com asc ";
$resultado_comuna = pg_exec($conn,$sql_comuna);



?>
<center>
<table width="550" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td width="550">
	<table width="550" height="43" border="1" cellpadding="0" cellspacing="0">
  <tr>
    <td width="500" class="titulosMotores" align="center">Buscador Avanzado</td>
  </tr>
  <tr>
    <td height="27">
	<table width="550" border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td width="420" class="textosmediano">Buscar por Curso
		  <select name="cmb_curso" class="ddlb_x">
			<?
			  for($i=0 ; $i < @pg_numrows($resultado_query_cue) ; $i++)
			  {
				  $fila = @pg_fetch_array($resultado_query_cue,$i); 
				  $Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
				  echo "<option value=".$fila['id_curso'].">".$Curso_pal."</option>";
			   } ?>
		  </select>
		 </td>
		</tr>
    	<tr>
		<td width="420" class="textosmediano">Buscar por Comuna
		  <select name="cmb_comuna" class="ddlb_x">
	      <option value=0 selected>(Todas las Comunas)</option>		  
			<?
			  for($j=0 ; $j < @pg_numrows($resultado_comuna) ; $j++)
			  {
				  $fila2 = @pg_fetch_array($resultado_comuna,$j); 
				  echo "<option value=".$fila2['cor_com'].">".$fila2['nom_com']."</option>";
			   } ?>
		  </select>
		 </td>



   
    <td width="80">
            <div align="center">
              <input name="cb_ok" class="botonX" onMouseOver=this.style.background='FFFFD7';this.style.color='003b85' onMouseOut=this.style.background='#5c6fa9';this.style.color='ffffff' type="submit" value="Buscar">        
                  </div></td>
  </tr>
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
