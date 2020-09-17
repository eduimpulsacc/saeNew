<?php 
class Calendario{
	
	public function contructor(){
			
	}

public function Cursos($conn,$ano){
	 $sql="SELECT id_curso,grado_curso ||'-'|| letra_curso ||' '|| nombre_tipo AS curso, ensenanza FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza=tipo_ensenanza.cod_tipo WHERE id_ano=".$ano." and ensenanza>10 ORDER BY ensenanza,curso ASC";
		$result = pg_exec($conn,$sql);
		
		return $result;	
	
}

public function guardaAct($conn,$curso,$nombre,$fecha_inicio,$fecha_termino,$hora_inicio,$hora_termino,$descripcion){
	echo $sql="insert into cal_actividades (id_curso,nombre,descripcion,fecha_inicio,fecha_termino,hora_inicio,hora_termino) values($curso,'".utf8_decode($nombre)."','".utf8_decode($descripcion)."','$fecha_inicio','$fecha_termino','$hora_inicio','$hora_termino')";
	$result = pg_exec($conn,$sql);
		
		return $result;	
}

public function cargaAct($conn,$curso){
  echo $sql="select * from cal_actividades where id_curso=$curso";
$result = pg_exec($conn,$sql);
		
		return $result;	
}

public function borraAct($conn,$act){
 echo $sql=" delete from cal_actividades where id_actividad=$act";
$result = pg_exec($conn,$sql);
		
		return $result;	
}

public function traeAct($conn,$act){
    $sql="select * from cal_actividades where id_actividad=$act";
$result = pg_exec($conn,$sql);
		
		return $result;	
}

public function actAct($conn,$nombre,$fecha_inicio,$fecha_termino,$hora_inicio,$hora_termino,$descripcion,$idact){
  $sql="update cal_actividades set nombre='".utf8_decode($nombre)."',fecha_inicio='$fecha_inicio',fecha_termino='$fecha_termino',descripcion='".utf8_decode($descripcion)."' where id_actividad=$idact";
$result = pg_exec($conn,$sql);
		
		return $result;	

}

public function maxI($conn){
  $sql="select max(id_actividad) from cal_actividades";
$result = pg_exec($conn,$sql);
		
		return $result;	

}


}//fin clase

?>