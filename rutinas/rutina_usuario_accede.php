<?php

echo "rdb->".$rdb=1732;

$conn = @pg_connect("dbname=coi_usuario host=200.29.21.124 port=5432 user=postgres password=cole#newaccess") or die ("No pude conectar a la base de datos destino 1");


$conn_vina = @pg_connect("dbname=coi_final_vina host=200.29.21.124 port=5432 user=postgres password=cole#newaccess") or die ("No pude conectar a la base de datos destino 3");


   $sql_cursos="select DISTINCT id_curso  from matricula where rdb = 1732";
   $rs_curso=pg_exec($conn_vina,$sql_cursos);

for($x=0;$x<pg_numrows($rs_curso);$x++){

	 $fila_curso=pg_fetch_array($rs_curso,$x);

     $id_curso = $fila_curso['id_curso'];


     $sql_rut_alumnos="select rut_alumno from matricula where id_curso = $id_curso";

     $rs_rut=pg_exec($conn_vina,$sql_rut_alumnos);

for($i=0; $i<pg_numrows($rs_rut); $i++){
	
	 $fila_al=pg_fetch_array($rs_rut,$i);
	 $rut_alumno=$fila_al['rut_alumno'];
	
	
if($rs_rut){
		
		 $sql_usuarios=" select * from usuario us where us.nombre_usuario='".$rut_alumno."' ";
		 $rs_usuarios=pg_exec($conn,$sql_usuarios);
		
		 $fila_usuario=pg_fetch_array($rs_usuarios,0);
		
		 $id_usuario=$fila_usuario['id_usuario'];
		
		echo "<pre>";
		echo $id_usuario;
		echo "</pre>";
		
		$sql_ver_estado="select id_usuario form accede where id_usuario=".$id_usuario." ";
		$rs_estado=pg_exec($conn,$sql_ver_estado);
		
		//if($rs_estado){
		echo $sql_accede="INSERT INTO accede
		(id_usuario,id_perfil,rdb,id_sistema,id_base,estado) 
		VALUES 
		(".$fila_usuario['id_usuario'].",16,".$rdb.",1,2,1)";
		$rs_accede=pg_exec($conn,$sql_accede);
		//}else{
			//continue;
			
			//}
		 }
	 }
}





?>