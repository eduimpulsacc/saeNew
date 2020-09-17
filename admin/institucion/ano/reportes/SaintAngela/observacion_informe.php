<?
	require('../../../../../util/header.inc');
	setlocale("LC_ALL","es_ES");

	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$id_curso;
	$alumno		    =$rut_alumno;
	$periodo		=$id_periodo;
?>
<html>
<head>
<title>COLEGIO ELECTR&Oacute;NICO - OBSERVACIONES</title>
<link href="../../../../util/objeto.css" rel="stylesheet" type="text/css">
</head>

<body>

<center>
<form action="graba_observacion.php" method="post">
<table width="325" border="0" cellspacing="0" cellpadding="0">
  <tr bgcolor="#003b85">
    <td align="left"><font face="arial, geneva, helvetica" size="2" color="#ffffff"><strong>OBSERVACIONES DEL ALUMNO</strong></font></td>
  </tr>
  <tr>
    <td align="center" valign="bottom"><textarea name="observacion" cols="50" rows="15"></textarea></td>
  </tr>
  <tr>
    <td align="right"><input name="button3" type="submit" class="botonX" onMouseOver=this.style.background='FFFFD7';this.style.color='003b85' onMouseOut=this.style.background='#5c6fa9';this.style.color='ffffff' value="GUARDAR"></td>
  </tr>
</table>
<input name="alumno" type="hidden" value="<? echo $rut_alumno?>">
<input name="periodo" type="hidden" value="<? echo $id_periodo?>">
<input name="alumno_auxi" type="hidden" value="<? echo $alumno_aux?>">
<input name="curso_auxi" type="hidden" value="<? echo $curso_aux?>">
</form>
</center>

</body>
</html>
