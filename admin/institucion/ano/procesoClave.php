<?php require('../../../util/header.inc');?>
<?php 
	
if($_PERFIL==0){
echo"<pre>";
	//print_r($_POST);
echo"</pre>";	
}	
	
$institucion	=$_INSTIT;
for($i=0;$i<count($_POST['clave']);$i++){
	if($_POST['usuario'][$i]!="")
		$estado=0;
	else
		$estado=1;
		
	if($_POST['bloqueo'][$i]!="")
		$bloq=1;
	else
		$bloq=0;
	

	$sql="UPDATE accede SET estado=".$estado." WHERE id_usuario in (SELECT id_usuario FROM usuario WHERE nombre_usuario='".$_POST['clave'][$i]."')";
	$Rs_Clave = @pg_exec($connection,$sql) or die(pg_last_error($connection));
	
	$sql ="UPDATE alumno SET bloqueo=".$bloq." WHERE rut_alumno=".$_POST['clave'][$i]."";
	$rs_bloqueo = pg_exec($conn,$sql);

	if($institucion==9035){
		$sql="";
		$sql="SELECT rut_apo FROM tiene2 WHERE rut_alumno=".$_POST['clave'][$i]."";
		$Rs_Apo = @pg_exec($conn,$sql);
		$filsApo = @pg_fetch_array($Rs_Apo,0);
		$sql="";
		$sql="UPDATE accede SET estado=".$estado." WHERE id_usuario in (SELECT id_usuario FROM usuario WHERE nombre_usuario='".$filsApo['rut_apo']."')";
		$Rs_ClaveApo = @pg_exec($conn,$sql);
	}

}
pg_close($conn);
pg_close($connection);
//if($_PERFIL!=0){
echo "<script>window.location = 'Claves.php'</script>";
//}else{
//echo "";
//}
?>