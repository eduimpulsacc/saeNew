<?php 
class Calendario{
	
	public function contructor(){
			
	}

public function Cursos($conn,$ano){
	 $sql="SELECT id_curso,grado_curso ||'-'|| letra_curso ||' '|| nombre_tipo AS curso, ensenanza FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza=tipo_ensenanza.cod_tipo WHERE id_ano=".$ano." and ensenanza>10 ORDER BY ensenanza,curso ASC";
		$result = pg_exec($conn,$sql);
		
		return $result;	
	
}

 public function traeRamo($conn,$curso){

  $qry="SELECT ramo.id_ramo, subsector.nombre, subsector.cod_subsector, ramo.eee,  ramo.modo_eval, ramo.id_orden,ramo.conex,ramo.prueba_nivel, ramo.porc_examen, ramo.conexper,ramo.prueba_especial,ramo.bool_nquiz,ramo.conexquiz, ramo.coef2,ramo.bool_pu FROM subsector INNER JOIN ramo ON subsector.cod_subsector = ramo.cod_subsector WHERE ramo.id_curso=$curso  order by ramo.id_orden";
 $result = pg_exec($conn,$qry);
		
		return $result;	
}

public function guardaAct($conn,$curso,$nombre,$fecha_inicio,$fecha_termino,$hora_inicio,$hora_termino,$descripcion,$ramo,$teva,$trabajo,$materiales){
	  $sql="insert into cal_pruebas (id_curso,nombre,descripcion,fecha_inicio,fecha_termino,hora_inicio,hora_termino,id_ramo,tipo_evaluacion,trabajo,materiales) values($curso,'".utf8_decode($nombre)."','".utf8_decode($descripcion)."','$fecha_inicio','$fecha_termino','$hora_inicio','$hora_termino',$ramo,$teva,'".utf8_decode($trabajo)."','".utf8_decode($materiales)."')";
	$result = pg_exec($conn,$sql);
		
		return $result;	
}

public function cargaAct($conn,$ramo){
  $sql="select * from cal_pruebas where id_ramo=$ramo";
$result = pg_exec($conn,$sql);
		
		return $result;	
}
public function borraAct($conn,$act){
  $sql=" delete from cal_pruebas where id_actividad=$act";
$result = pg_exec($conn,$sql);
		
		return $result;	
}

public function traeAct($conn,$act){
   $sql="select * from cal_pruebas where id_actividad=$act";
$result = pg_exec($conn,$sql);
		
		return $result;	
}

public function actAct($conn,$nombre,$fecha_inicio,$fecha_termino,$hora_inicio,$hora_termino,$descripcion,$idact,$ramo,$teva,$trabajo,$materiales){
 $sql="update cal_pruebas set nombre='".utf8_decode($nombre)."',fecha_inicio='$fecha_inicio',fecha_termino='$fecha_termino',descripcion='".utf8_decode($descripcion)."',tipo_evaluacion=$teva,trabajo='".utf8_decode($trabajo)."',materiales='".utf8_decode($materiales)."' where id_actividad=$idact";
$result = pg_exec($conn,$sql);
		
		return $result;	

}

public function tipoeva($conn){
   $sql="select * from cal_tevaluacion";
$result = pg_exec($conn,$sql);
		
		return $result;	
}

public function tipoeva1($conn,$tipo){
   $sql="select * from cal_tevaluacion where id_tipo=$tipo";
$result = pg_exec($conn,$sql);
		
		return $result;	
}

public function ctipoeva($conn,$nombre){
   $sql="insert into cal_tevaluacion (glosa) values('".utf8_decode($nombre)."')";
$result = pg_exec($conn,$sql);
		
		return $result;	
}

public function maxI($conn){
  $sql="select max(id_actividad) from cal_pruebas";
$result = pg_exec($conn,$sql);
		
		return $result;	

}
}//fin clase

?>