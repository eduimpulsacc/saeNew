<? include"Coneccion/conexion.php" ?>
<?
if($cb_ok !='')
{
	$sql = "select institucion.rdb, institucion.nombre_instit, usuario.nombre_usuario ";
	$sql = $sql . " from usuario, accede, institucion ";
	$sql = $sql . " where usuario.id_usuario = accede.id_usuario ";
	$sql = $sql . " and institucion.rdb = accede.rdb ";
	$sql = $sql . " and usuario.id_usuario = $tf_user  ";
	$sql = $sql . " and usuario.pw = '$tf_pass' ";
	$sql = $sql . " group by institucion.rdb, institucion.nombre_instit, usuario.nombre_usuario ";

	$resultado_query= pg_exec($conexion,$sql);
	$total_filas= pg_numrows($resultado_query);
	
	pg_close($conexion);
}
	if($total_filas>0)
	{
		//session_start(); 
		//session_register('gs_institucion'); 
		$li_institucion = pg_result($resultado_query, 0, 0);
		?>
		<script>
			parent.location.href = "main.php?ai_institucion=<?=($li_institucion)?>";
		</script>
		<?
	}


?>
<html>
<head>
<title>acceso</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/objeto.css" rel="stylesheet" type="text/css">
</head>

<body>
<form name="form1" method="post" action="">
  <br>
  <br>
  <br>
  <table width="350" border="0" align="center" cellpadding="0" cellspacing="2">
    <tr> 
      <td colspan="2" class="titulos">Acceso Usuario</td>
    </tr>
    <tr> 
      <td class="textosmediano">Usuario</td>
      <td><input name="tf_user" type="text" class="text_9_x_100" id="tf_user"></td>
    </tr>
    <tr> 
      <td class="textosmediano">Clave</td>
      <td><input name="tf_pass" type="text" class="text_9_x_100" id="tf_pass"></td>
    </tr>
    <tr> 
      <td colspan="2"><div align="center"> 
          <input name="cb_ok" type="submit" class="cb_submit_9_x_75" id="cb_ok" value="Ingresar">
          <input name="cb_reset" type="reset" class="cb_submit_9_x_75" id="cb_reset" value="Reset">
        </div></td>
    </tr>
  </table>
</form>
</body>
</html>
