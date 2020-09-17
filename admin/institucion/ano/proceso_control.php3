<?php 	$conn=@pg_connect("dbname=coe port=1550 user=postgres password=cole#newaccess");
	if (!$conn) {
	 error('<b>ERROR:</b>No se puede conectar a la base de datos.');
	 exit;
	}
?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body>
<table width="75%" border="1">
<?php 
$qry = "select * from control ";
	$result = @pg_Exec($conn,$qry);
					for($i=0;$i < @pg_numrows($result);$i++){
					$fila = @pg_fetch_array($result,$i);
$qryACC = "select  control.dia, control.hora, usuario.nombre_usuario, accede.rdb, accede.id_perfil, perfil.nombre_perfil, institucion.nombre_instit
from ((((usuario inner join accede on usuario.id_usuario=accede.id_usuario)
inner join perfil on accede.id_perfil=perfil.id_perfil)
inner join institucion on accede.rdb=institucion.rdb)inner join control on usuario.nombre_usuario=control.usuario) where usuario.nombre_usuario='".$fila['usuario']."' order by accede.rdb" ;
$resultACC = @pg_Exec($conn,$qryACC);
$filaACC = @pg_fetch_array($resultACC,0);
?>
  <tr>
    <td width="13%"><?php echo $filaACC['dia']; ?></td>
    <td width="7%"><?php echo $filaACC['hora']; ?></td>
	<?php if ($filaACC['id_perfil']==15){ 
				$usuario="apoderado"; 
				$rut="rut_apo";
				$nombre="nombre_apo";
				}
		  if ($filaACC['id_perfil']==16) {
		  $usuario="alumno"; 
		  $rut="rut_alu";
		  $nombre="nombre_alu";		  
		  }
		  if (($filaACC['id_perfil']!=15)and($filaACC['id_perfil']!=16)) {
		  $usuario="empleado"; 
		  $rut="rut_emp";
		  $nombre="nombre_emp";
		  }
		  $qryC = "Select * from ".$usuario." where ".$rut."='".$filaACC['nombre_usuario']"'";
			$resultC = @pg_Exec($conn,$qryC);
					$filaC = @pg_fetch_array($resultC,0);
	  ?>
    <td width="30%"><?php echo $filaACC['nombre_usuario']; ?></td>
    <td width="30%">hola<?php echo $filaC['$nombre']," ",$filaC['ape_pat']," ",$filaC['ape_mat']; ?></td>
    <td width="11%"><?php echo $filaACC['nombre_perfil']; ?></td>
    <td width="32%"><?php echo $filaACC['nombre_instit']; ?></td>
    <td width="1%">&nbsp;</td>
    <td width="6%">&nbsp;</td>
  </tr>
  <?php }?>
</table>
<? pg_close($conn); ?>
</body>
</html>
