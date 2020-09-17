<?
$conn 		= @pg_connect("dbname=coi_usuario host=200.29.21.124 port=5432 user=postgres password=cole#newaccess") or die ("No pude conectar a la base de datos destino 1");


$conn_final = @pg_connect("dbname=coi_corporaciones host=200.29.21.124 port=5432 user=postgres password=cole#newaccess") or die ("No pude conectar a la base de datos destino 2");

/*$conn_vina 	= @pg_connect("dbname=coi_final_vina host=200.29.21.124 port=5432 user=postgres password=cole#newaccess") or die ("No pude conectar a la base de datos destino 3");

$conn_corp 	= @pg_connect("dbname=coi_corporaciones host=200.29.21.124 port=5432 user=postgres password=cole#newaccess") or die ("No pude conectar a la base de datos destino 4");
$conn_final 	= @pg_connect("dbname=coi_antofagasta host=200.29.70.184  port=5432 user=postgres password=anto2010") or die ("No pude conectar a la base de datos destino");*/



/************* TRASPASO INSTITUCION DE LA COI FINAL *************************/
if($paso==""){
	
	
	$sql ="SELECT * FROM usuario 
INNER JOIN accede ON usuario.id_usuario=accede.id_usuario";
//WHERE  rdb not in (SELECT rdb FROM corp_instit) and estado=1 ORDER BY accede.rdb, accede.id_usuario";

	$rs_final = pg_exec($conn_final,$sql);
	echo "<br> contador coi_final-->".pg_numrows($rs_final);
	$contador_final=0;
	$contador_existe =0;
	
	for($i=0;$i<@pg_numrows($rs_final);$i++){
		$fila = @pg_fetch_array($rs_final,$i);
		
		$sql ="SELECT count(*) as contador FROM accede INNER JOIN usuario ON accede.id_usuario=usuario.id_usuario WHERE nombre_usuario='".$fila['nombre_usuario']."'";
		$rs_existe = @pg_exec($conn,$sql) or die (pg_last_error($conn));
		$contador = pg_result($rs_existe,0);
		
		if($contador==0){	
			$sql ="INSERT INTO usuario (nombre_usuario,pw) VALUES ('".$fila['nombre_usuario']."','".$fila['pw']."')";
			$rs_usuario = @pg_exec($conn,$sql) or die (pg_last_error($conn));
			
			$sql ="INSERT INTO ACCEDE (id_usuario,id_perfil,rdb,id_sistema,id_base,estado)
 VALUES ((select currval('usuario_id_usuario_seq')),".$fila['id_perfil'].",".$fila['rdb'].",1,4,".$fila['estado'].")";
			$rs_accede = @pg_exec($conn,$sql) ;
			
			$contador_final++;
		}else{
			$sql ="SELECT usuario.id_usuario FROM usuario INNER JOIN accede ON usuario.id_usuario=accede.id_usuario WHERE nombre_usuario='".$fila['nombre_usuario']."' and id_perfil<>".$fila['id_perfil'];
			$result = @pg_exec($conn,$sql) or die (pg_last_error($conn));
			
			if(pg_numrows($result)!=0){
			$id_usuario = @pg_result($result,0);
			
			$sql ="INSERT INTO ACCEDE (id_usuario,id_perfil,rdb,id_sistema,id_base,estado)
 VALUES (".$id_usuario.",".$fila['id_perfil'].",".$fila['rdb'].",1,4,".$fila['estado'].")";
			$rs_accede = @pg_exec($conn,$sql);
			
			$contador_existe++;	
			}
		}
	}
	echo " insertadas---> ".$contador_final." existentes---> ".$contador_existe;
	echo "<script>window.location='rutina_traspaso_usuarios.php?paso=1'</script>";
}
