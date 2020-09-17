<?php  
class Impnota {
	public $conect;

//constructor 
	public function contructor(){
			
	}
	
public function revNota($conn,$rut,$ano,$ramo,$periodo,$posicion){
	 $sql="select * from notas$ano where rut_alumno=$rut and id_ramo=$ramo and id_periodo=$periodo";
	$result = pg_exec($conn,$sql);
		
	return $result;	
	
}

public function ingNota($conn,$rut,$ano,$ramo,$periodo,$posicion,$nota){
	   $sql="insert into notas$ano (rut_alumno,id_periodo,id_ramo,nota$posicion) values ($rut,$periodo,$ramo,$nota) ";
	$result = pg_exec($conn,$sql);
		
	return $result;	
	
}

public function upNota($conn,$rut,$ano,$ramo,$periodo,$posicion,$nota){
	 $sql="update notas$ano set nota$posicion = $nota where rut_alumno=$rut and id_periodo=$periodo and id_ramo=$ramo ";
	$result = pg_exec($conn,$sql);
		
		return $result;	
	
}
		
}//fin clase
?>