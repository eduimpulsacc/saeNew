<?  require('../../../../util/header.inc');
	require('../../../../util/LlenarCombo.php3');
	require('../../../../util/SeleccionaCombo.inc');

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

<SCRIPT language="JavaScript">
			function enviapag(form){
			if (form.cmb_curso.value!=0){
				form.cmb_curso.target="self";
				form.action = 'motor_nota_especifica.php?institucion=$institucion';
				form.submit(true);
	
				}	
			}			
</script>

<link href="../../../../util/objeto.css" rel="stylesheet" type="text/css">
</head>

<body>

<form method "post" action="InformeNotaEspecifica.php" target = "mainFrame">
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
<table width="709" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="705">
	<table width="705" height="43" border="1" cellpadding="0" cellspacing="0">
  <tr>
    <td width="701"  class="titulosMotores">Buscador Avanzado</td>
  </tr>
  <tr>
    <td height="27">
	<table width="701" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="69" class="textosmediano">Curso</td>
    <td width="272">
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
	    </font>	  </div></td>
    <td width="61" class="textosmediano">Periodo</span></td>
    <td width="219"><select name="cmb_periodos" class="ddlb_9_x">
			<option value=0 selected>(Seleccione Periodo)</option>
       <?
		  for($i=0 ; $i < @pg_numrows($result_peri) ; $i++)
		  {
		  $fila = @pg_fetch_array($result_peri,$i); ?>
          <option value="<? echo $fila['id_periodo']?>"><? echo $fila['nombre_periodo']?></option>
	   <? } ?>
    </select></td>
    <td width="80"><div align="right">
      <input name="cb_ok" class="botonX" onMouseOver=this.style.background='FFFFD7';this.style.color='003b85' onMouseOut=this.style.background='#5c6fa9';this.style.color='ffffff' type= "submit"  value="Buscar">
    </div></td>
  </tr>
  <tr>
    <td class="textosmediano">NOTA</td>
    <td><select name="cmb_nota" class="ddlb_9_x">
      <option value=1 selected>N� 1</option>
      <option value=2 >N� 2</option>
      <option value=3 >N� 3</option>
      <option value=4 >N� 4</option>
      <option value=5 >N� 5</option>
      <option value=6 >N� 6</option>
      <option value=7 >N� 7</option>
      <option value=8 >N� 8</option>
      <option value=9 >N� 9</option>
      <option value=10 >N� 10</option>
      <option value=11 >N� 11</option>
      <option value=12 >N� 12</option>
      <option value=13 >N� 13</option>
      <option value=14 >N� 14</option>
      <option value=15 >N� 15</option>
      <option value=16 >N� 16</option>
      <option value=17 >N� 17</option>
      <option value=18 >N� 18</option>
      <option value=19 >N� 19</option>
      <option value=20 >N� 20</option>	  	  	  	  	  	  	  	  	  
    </select></td>
    <td class="textosmediano">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
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

