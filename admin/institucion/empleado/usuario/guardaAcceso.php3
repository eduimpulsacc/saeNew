<? require('../../../../util/header.inc'); 

  $sql="INSERT INTO USUARIO (NOMBRE_USUARIO, PW) VALUES ('".trim($_EMPLEADO)."','".$txtPW1."')";
  $result =@pg_Exec($connection,$sql);

  $sql = "SELECT currval('usuario_id_usuario_seq') as ultimo";
  $result =@pg_Exec($connection,$sql);
  $fila = @pg_fetch_array($result,0);

  $sql = "INSERT INTO ACCEDE (id_usuario,id_perfil,rdb,id_sistema,id_base,estado) 
  VALUES (".$fila['ultimo'].",".$cmbPERFIL.",".$_INSTIT.",1,".$_ID_BASE.",1)";	
  $result =@pg_Exec($connection,$sql);

  echo "<script>window.location = 'usuario.php3'</script>";

?> 