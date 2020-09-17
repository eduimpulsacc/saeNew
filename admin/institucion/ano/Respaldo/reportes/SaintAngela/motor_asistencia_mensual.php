<? require('../../../../../util/header.inc');

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
</head>

<body>
<form action="AsistenciaMes.php" method="post" target="mainFrame">
<? 
$sql_curso= "SELECT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, curso.ensenanza, curso.cod_decreto ";
$sql_curso = $sql_curso . "FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
$sql_curso = $sql_curso . "WHERE (((curso.id_ano)=".$ano.")) ";
$sql_curso = $sql_curso . "ORDER BY curso.ensenanza, curso.grado_curso, curso.letra_curso; ";
$resultado_query_cue = pg_exec($conn,$sql_curso);
//------------------
$sql_peri = "select * from periodo where id_ano = ".$ano;
$result_peri = pg_exec($conn,$sql_peri);

//------------------
?>
<center>
<table width="664" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="708">
	<table width="662" height="43" border="1" cellpadding="0" cellspacing="0">
  <tr>
    <td width="658" class="titulosMotores"><div align="center">Buscador Avanzado</div></td>
  </tr>
  <tr>
    <td height="27">
	<table width="658" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="74"><font face="Verdana, Arial, Helvetica, sans-serif" size="-2"><strong>Buscar por </strong></font></td>
    <td width="345">
	  <div align="left">
	    <font size="1" face="arial, geneva, helvetica">
	    <select name="cmb_curso"  class="ddlb_9_x">
          <option value=0 selected>(Seleccione Curso)</option>
          <?
		  for($i=0 ; $i < @pg_numrows($resultado_query_cue) ; $i++)
		  {
		  $fila = @pg_fetch_array($resultado_query_cue,$i); 
		  if ($fila["id_curso"]==$cmb_curso){
  				$Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
				echo "<option selected value=".$fila['id_curso'].">".$Curso_pal."</option>";
  		  }else{
  				$Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
				echo "<option value=".$fila['id_curso'].">".$Curso_pal."</option>";
		  }
          } ?>
        </select>
	    </font></div></td>
    <td width="29"><font face="Verdana, Arial, Helvetica, sans-serif" size="-2"><strong>Mes</strong></font></td>
    <td width="120">
	  <div align="left">
	    <select name="cmb_meses" class="ddlb_9_x">
	      <option value="1">Enero</option>
		  <option value="2">Febrero</option>
		  <option value="3">Marzo</option>
		  <option value="4">Abril</option>
		  <option value="5">Mayo</option>
		  <option value="6">Junio</option>
		  <option value="7">Julio</option>
		  <option value="8">Agosto</option>
		  <option value="9">Septiembre</option>
		  <option value="10">Octubre</option>
		  <option value="11">Noviembre</option>
		  <option value="12">Diciembre</option>
	      </select>
            </div>
		</td>
    <td width="90"><div align="right">
      <input name="cb_ok" type="submit" class="botonX" onMouseOver=this.style.background='FFFFD7';this.style.color='003b85' onMouseOut=this.style.background='#5c6fa9';this.style.color='ffffff' value="Buscar">
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
