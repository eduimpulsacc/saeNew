<?php require('../../../../../util/header.inc');



//vei si existe usuario
$sql_u = "select * from usuario where nombre_usuario='".$_NOMBREUSUARIO."' and pw='$emp'";
$result =pg_exec($connection,$sql_u);
$cont=pg_numrows($result);
if($cont==0)
{
echo 0;
}else{
	//elimino de la base
	$repo = explode(",",$repos);
	
	//borro
	echo $sql_d="delete from autoriza_firma where usuario='".$_NOMBREUSUARIO."' and rbd=".$_INSTIT;
		pg_exec($conn,$sql_d);
	
	for($a=0;$a<count($repo);$a++){	
		//vuelvo a agregar
		echo $sql_a = "insert into autoriza_firma values ('".$_NOMBREUSUARIO."',".$_INSTIT.",".$repo[$a].")";
		pg_exec($conn,$sql_a);
	}
	
	echo 1;
}
?>