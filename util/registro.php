<?



function RegistroUsuario($conn,$actividad,$rut,$perfil,$rdb,$tabla,$base){
		$sql="INSERT INTO regis.registro(ID_ACTIVIDAD,FECHA_REGISTRO,USUARIO_ACTIVIDAD,ID_PERFIL,RDB,ID_TABLA,ID_SAE) VALUES(".$actividad.",NOW(),'".$rut."',".$perfil.",".$rdb.",'".$tabla."','".$base."')";
		$result = pg_exec($conn,$sql);
}
?>