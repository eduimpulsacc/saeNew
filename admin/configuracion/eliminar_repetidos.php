<?	require('../../util/header.inc');

$conn3=pg_connect("dbname=soporte host=10.132.10.36 port=5432 user=postgres password=cole#newaccess");
	
	if(!$conn3){
		if($_PERFIL==0){
		echo "No se puede conectar a la base de datos.";
		//error('<b>ERROR:</b>No se puede conectar a la base de datos.');
		}
	}

echo $sql="SELECT DISTINCT * FROM empleado";
$resp = pg_exec($conn3,$sql);
echo $num = pg_numrows($resp);
for($i=0;$i<$num;$i++){
	$fila=pg_fetch_array($resp,$i);
	$rut_emp = $fila['rut_emp'];
	$dig_rut = $fila['dig_rut'];
	$nombre_emp = $fila['nombre_emp'];
	$ape_pat = $fila['ape_pat'];
	$ape_mat = $fila['ape_mat'];
	$calle = $fila['calle'];
	$nro = $fila['nro'];
	$depto = $fila['depto'];
	$block = $fila['block'];
	$villa = $fila['villa'];
	$region = $fila['region'];
	$ciudad = $fila['ciudad'];
	$comuna = $fila['comuna'];
	$telefono = $fila['telefono'];
	$sexo = $fila['sexo'];
	$titulo = $fila['titulo'];
	$email = $fila['email'];
	$estado_civil = $fila['estado_civil'];
	$id_usuario = $fila['id_usuario'];
	$foto = $fila['foto'];
	$estudios = $fila['estudios'];
	$nu_resol = $fila['nu_resol'];
	$fecha_resol = $fila['fecha_resol'];
	$tipo_titulo = $fila['tipo_titulo'];
	$anos_exp = $fila['anos_exp'];
	$idiomas_malo = $fila['idiomas_malo'];
	$idiomas = $fila['idiomas'];
	$nacionalidad = $fila['nacionalidad'];
	$telefono2 = $fila['telefono2'];
	$telefono3 = $fila['telefono3'];
	$atencion = $fila['atencion'];
	$habilitado = $fila['habilitado'];
	$titulado = $fila['titulado'];
	$tit_otras = $fila['tit_otras'];
	$habilitado_old = $fila['habilitado_old'];
	$habilitado_tras = $fila['habilitado_tras'];
	$habilitado_para = $fila['habilitado_para'];
	$nom_foto = $fila['nom_foto'];
	$nom_foto2 = $fila['nom_foto2'];
	$hxcontrato = $fila['hxcontrato'];
	$hxclase = $fila['hxclase'];
	$cargo_total = $fila['cargo_total'];
	$fecha_nacimiento = $fila['fecha_nacimiento'];
	$fecha_ingreso = $fila['fecha_ingreso'];
	$horas_presente_ano = $fila['horas_presente_ano'];
	$prevision = $fila['prevision'];
	$sistema_salud = $fila['sistema_salud'];
	$t_institucion1 = $fila['t_institucion1'];
	$t_institucion2 = $fila['t_institucion2'];
	$t_institucion3 = $fila['t_institucion3'];
	$t_hora1 = $fila['t_hora1'];
	$t_hora2 = $fila['t_hora2'];
	$t_hora3 = $fila['t_hora3'];
	
	$sql_insert = "INSERT INTO empleado_new (rut_emp,dig_rut,nombre_emp,ape_pat,ape_mat,calle,nro,depto,block,villa,region,ciudad,comuna,telefono,sexo,titulo,email,estado_civil, ";
	$sql_insert.="id_usuario,foto,estudios,nu_resol,fecha_resol,tipo_titulo,anos_exp,idiomas_malo,idiomas,nacionalidad,telefono2, ";
	$sql_insert.="telefono3,atencion,habilitado,titulado,tit_otras,habilitado_old,habilitado_tras,habilitado_para,nom_foto, ";
	$sql_insert.="nom_foto2,hxcontrato,hxclase,cargo_total,fecha_nacimiento,fecha_ingreso,horas_presente_ano,prevision,sistema_salud, ";
	$sql_insert.="t_institucion1,t_institucion2,t_institucion3,t_hora1,t_hora2,t_hora3) VALUES ";
	$sql_insert.="(".$rut_emp.",'".$dig_rut."','".$nombre_emp."','".$ape_pat."','".$ape_mat."','".$calle."','".$nro."','".$depto."','".$block."','".$villa."',";
	$sql_insert.=" ".$region.",".$ciudad.",".$comuna.",'".$telefono."',".$sexo.",'".$titulo."','".$email."',".$estado_civil.",".$id_usuario.",'".$foto."',";
	$sql_insert.=" '".$estudios."','".$nu_resol."','".$fecha_resol."','".$tipo_titulo."',".$anos_exp.",'".$idiomas_malo."','".$idiomas."',".$nacionalidad.",";
	$sql_insert.=" '".$telefono2."','".$telefono3."','".$atencion."','".$habilitado."','".$titulado."','".$tit_otras."','".$habilitado_old."','".$habilitado_tras."', ";
	$sql_insert.=" '".$habilitado_para."','".$nom_foto."','".$nom_foto2."',".$hxcontrato.",".$hxclase.",".$cargo_total.",'".$fecha_nacimiento."','".$fecha_ingreso."', ";
	$sql_insert.=" ".$horas_presente_ano.",'".$prevision."','".$sistema_salud."','".$t_institucion1."','".$t_institucion2."','".$t_institucion3."','".$t_hora1."', ";
	$sql_insert.=" '".$t_hora2."','".$t_hora3."')";
	
	echo "<br />".$sql_insert;
	
	$resp1 = pg_exec($conn3,$sql_insert);

}



 ?>
