<?php require('../../../util/header.inc');?>
<?php 
	$institucion	= $_INSTIT;
	$_POSP = 3;
	$_bot = 0;
	
	$curso			= $_GET["curso"];
	$ano 			= $_ANO;
	$fecha = time();
	$dd = date(d);
	$mm = date(m);
	$aa = date(Y);
	$fechahoy = "$dd-$mm-$aa";
	$fechahoy.="_";
	$hora= date ( "h:i:s" , $fecha );
	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=".$fechahoy."ClavesAlumnos.xls"); 
		$_TIPO_CLAVE = 1;
		$sqlAlumnos = "select matricula.rut_alumno as rut, alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu as nombres, matricula.id_curso from matricula, alumno where matricula.id_ano = ".$ano." and matricula.id_curso = ".$curso." and matricula.rut_alumno = alumno.rut_alumno order by alumno.ape_pat, alumno.ape_mat";
		$rsResultado =@pg_Exec($conn,$sqlAlumnos);
		$texto = "ALUMNO";		
	
?>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../cortes/b_ayuda_r.jpg','../../../cortes/b_info_r.jpg','../../../cortes/b_mapa_r.jpg','../../../cortes/b_home_r.jpg')">
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
  <tr>
    <td><br>
        <center>
          <table width="650" border="0" cellspacing="0" cellpadding="0">
            <TR height=20>
              <TD align=center colspan=2 bgcolor="#999999"><font color="#FFFFFF" face="Arial, Helvetica, sans-serif">Administrador de Claves - ALUMNO</font></TD>
            </TR>
          </table>
          <table width="650" border="0" cellspacing="0" cellpadding="0">
            <tr bgcolor="#999999">
              <td><font color="#FFFFFF" face="Arial, Helvetica, sans-serif">Rut</font></td>
              <td><font color="#FFFFFF" face="Arial, Helvetica, sans-serif">Clave</font></td>
              <td><font color="#FFFFFF" face="Arial, Helvetica, sans-serif">Nombre Usuario</font></td>
            </tr>
            <?
	for($i=0;$i < @pg_numrows($rsResultado);$i++){
		$fResultado= @pg_fetch_array($rsResultado,$i);
		//$url_pass = "_ALUMNO=".trim($fResultado['rut']);
		echo $url_pass;
		//return;
		
	  if ($tipo_clave==2) 
		$url = "curso/alumno/apoderado/usuario/usuario.php3?RUT";
	  else 
		$url = "curso/alumno/usuario/usuario.php3?RUT";
	    
		$sql="SELECT estado FROM accede INNER JOIN usuario ON accede.id_usuario=usuario.id_usuario WHERE nombre_usuario='".$fResultado['rut']."'";
		$Rs_Clave = @pg_exec($conn,$sql);
		$filsClave = @pg_fetch_array($Rs_Clave,0);
		$Estado = $filsClave['estado'];
?>
            <tr>
              <td><font face="Arial, Helvetica, sans-serif"><? echo $fResultado['rut']?></font></td>
              <td><font face="Arial, Helvetica, sans-serif">
                <?
	$sqlUsuario = "select * from usuario where nombre_usuario = '".$fResultado['rut']."'";
	$rsUsuario =@pg_Exec($conn,$sqlUsuario);	
	$fUsuario= @pg_fetch_array($rsUsuario,0);	
	echo $fUsuario['pw'];
	?>
&nbsp;</font></td>
              <td><font face="Arial, Helvetica, sans-serif"><? echo ucwords(strtolower(trim($fResultado['ape_pat'])." ".trim($fResultado['ape_mat'])." ".trim($fResultado['nombres'])))?></font></td>
              <INPUT TYPE="hidden" name="clave[<? echo $i ?>]" value="<? echo $fResultado['rut']?>">
            </tr>
            <? } ?>
          </table>
        </center>
        <!-- AQU&Iacute; INGRESO EL CONTENIDO DE LA P&Aacute;GINA MotorBuscadorCalve.php, QUE AHORA VA SIN FRAME -->
        <br>
        <br>
        <!-- FIN DE INGRESO DE CODIGO NUEVO -->
    </td>
  </tr>
</table>
</body>
</html>
