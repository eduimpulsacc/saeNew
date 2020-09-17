<? require('../../../util/header.inc');
	

		/*$sql = "DELETE FROM accede WHERE accede.id_usuario = (select u.id_usuario from accede a 
		inner join usuario u on a.id_usuario=u.id_usuario where nombre_usuario='$xrut'
		and rdb=$_INSTIT) AND (accede.rdb = $_INSTIT)";

		$result = pg_Exec($connection,$sql) or die("Error Eliminar Accede ". $sql);
if($result){
	echo 1;
  }*/
  
    $sql="update accede set estado=$estado where id_usuario=$xrut and  rdb=$rbd";
   $result = pg_Exec($connection,$sql) or die("Error cambio acceso Accede ". $sql);
if($result){
	echo 1;
  }
  else{echo 0;}
?>
