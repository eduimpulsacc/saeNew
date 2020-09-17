<?php require('../../../util/header.inc');

	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	
?>
<html>
<head>
<title>Documento sin t&iacute;tulo</title>

<script>
	function valida(form)
	{
		if(!chkSelect(frm_buscador.cmb_curso,'Seleccione Curso')){
			return false;
		};

		return true;
	}
</script>	

<SCRIPT language="JavaScript">
			function MM_goToURL() { //v3.0
			  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
			  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
			}
									
</script>
<link href="../../../util/objeto.css" rel="stylesheet" type="text/css">
<link href="../Colegio_restore/css/objeto.css" rel="stylesheet" type="text/css">
<link href="../Colegio_restore/Reportes/css/objeto.css" rel="stylesheet" type="text/css">
</head>

<body>

<form action="ListarClavesCurso.php?tipo_clave=<? echo $tipo_claves ?>" method="post" target="content" name="frm_buscador">

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
<table width="600" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td width="600">
	<table width="600" height="43" border="1" cellpadding="0" cellspacing="0">
  <tr>
    <td width="600" class="titulosMotores">Buscador Avanzado </td>
  </tr>
  <tr>
    <td height="27">
	<table width="600" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="78" class="textosmediano">Curso</td>
    <td width="263">
	  <div align="left"> 
	    <font size="1" face="arial, geneva, helvetica">
	    <select name="cmb_curso"  class="ddlb_9_x" >
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
</font>	  </div></td>
    <td width="80"><div align="right">
      <input name="cb_ok" type="submit" class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' id="cb_ok" value="Buscar" onclick="return valida(this.form);">
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

