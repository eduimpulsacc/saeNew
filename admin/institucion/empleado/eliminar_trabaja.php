<? require('../../../util/header.inc');
	/*$conn=pg_connect("dbname=coi_final host=10.132.10.36 port=5432 user=postgres  
	password=cole#newaccess") or die ("Error de conexión.");*/
	$xrut = $_REQUEST['xrut']; 
 	$qry="DELETE FROM trabaja WHERE trabaja.rut_emp = $xrut and trabaja.rdb=$_INSTIT";
	$result = pg_Exec($conn,$qry) or die("Error al Eliminar");
 if (!$result) {
	echo 0;
  }else{
		 /* $sql = "DELETE FROM accede WHERE 
		accede.id_usuario = (select usuario.id_usuario from usuario where usuario.nombre_usuario = '$xrut')
		AND (accede.rdb = $_INSTIT)";*/
		
		$sql = "DELETE FROM accede WHERE accede.id_usuario = (select u.id_usuario from accede a 
		inner join usuario u on a.id_usuario=u.id_usuario where nombre_usuario='$xrut'
		and rdb=$_INSTIT) AND (accede.rdb = $_INSTIT)";

		$result = pg_Exec($connection,$sql) or die("Error Eliminar Accede ". $sql);
if($result){
	$sql = "SELECT * FROM accede WHERE 
	accede.id_usuario = (select u.id_usuario from accede a 
		inner join usuario u on a.id_usuario=u.id_usuario where nombre_usuario='$xrut'
		and rdb=$_INSTIT) AND (accede.rdb = $_INSTIT)";
	$result = pg_Exec($connection,$sql) or die("Error ". $sql);
if(pg_num_rows($result)==0){
	$sql = "DELETE FROM usuario WHERE usuario.id_usuario IN (SELECT 
	accede.id_usuario FROM accede INNER JOIN usuario ON accede.id_usuario = usuario.id_usuario 
	and usuario.nombre_usuario ='$xrut')";
	$result = pg_Exec($connection,$sql) or die("Error Eliminar Usuario". $sql);
}else{
	// Nada no Elimina. 	
	}
  }
	echo 1;
  }
?>
