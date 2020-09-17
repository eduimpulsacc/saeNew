<?php 
class cargaFile {
	public $conect;

//constructor 
	public function contructor(){
			
	}

public function fExist($conn,$idpadre,$rut){
$sql="select  ruta from archivo_alumno where id_archivo= $idpadre and rut_alumno=$rut";
$result = pg_exec($conn,$sql);
return $result;

}

public function createFile($conn,$idpadre,$rut,$ruta){
$sql="insert into archivo_alumno (id_archivo,rut_alumno,ruta,fecha_carga) values($idpadre,$rut,'$ruta',now())";
$result = pg_exec($conn,$sql);
return $result;
}

public function modFile($conn,$idpadre,$rut,$ruta){
$sql="update archivo_alumno set ruta ='$ruta',fecha_modificacion=now(),visto=0 where id_archivo=$idpadre and rut_alumno=$rut";
$result = pg_exec($conn,$sql);
return $result;
}


public function actVista($conn,$nro_ano,$rut,$id_archivo){
 $sql="update archivo_alumno_visto$nro_ano set visto=1 where rut_alumno =$rut and id_archivo=$id_archivo";
$result = pg_exec($conn,$sql);
return $result;
}

public function countVista($conn,$nro_ano,$rut,$id_archivo){
$sql="select count(*) from  archivo_alumno_visto$nro_ano where rut_alumno =$rut and id_archivo=$id_archivo and visto=0";
$result = pg_exec($conn,$sql);
return $result;

}

public function getFileSubject($conn,$idFile){
 $sql="SELECT * FROM (archivo INNER JOIN adjunta ON archivo.id_archivo = adjunta.id_archivo) INNER JOIN ramo ON adjunta.id_ramo = ramo.id_ramo WHERE archivo.id_archivo = $idFile";
$result = pg_exec($conn,$sql);
return $result;
}

public function getFileRespuesta($conn,$rut,$id_archivo){
$sql="select ruta from archivo_alumno where id_archivo= ".$id_archivo." and rut_alumno=$rut";
$result = pg_exec($conn,$sql);
return $result;
}	
}//fin clase
?>