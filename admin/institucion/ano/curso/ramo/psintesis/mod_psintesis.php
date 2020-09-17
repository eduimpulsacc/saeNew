<?php 
class Psisntesis{
	
	public function contructor(){
			
	}
	
	public function traeAno($conn,$ano){
		
		$sql= "SELECT nro_ano FROM ano_escolar WHERE id_ano=".$ano;
	$result = @pg_exec($conn,$sql);	
	//$nro_ano = @pg_result($rs_ano,0);
	return $result;
	}
	
	public function traeRamo($conn,$ramo){
		
		$sql ="SELECT nombre FROM subsector a INNER JOIN ramo b ON a.cod_subsector=b.cod_subsector WHERE id_ramo=".$ramo;
	$result = @pg_exec($conn,$sql);
	return $result;
	}
	
	public function traePeriodo($conn,$id_ano){
		
		$sql = "SELECT nombre_periodo,id_periodo FROM periodo WHERE id_ano=".$id_ano." order by nombre_periodo";
		$result = @pg_exec($conn,$sql);
	return $result;
	}
	
	public function traeAlumnos($conn,$curso,$ramo,$periodo,$ano,$nro_ano){
		
		 $sql = "SELECT a.rut_alumno,a.ape_pat || cast(' ' as varchar) || a.ape_mat || CAST(', ' as varchar) || a.nombre_alu as nombre
FROM alumno a 
INNER JOIN matricula b ON a.rut_alumno=b.rut_alumno 
INNER JOIN tiene$nro_ano c ON a.rut_alumno=c.rut_alumno AND b.rut_alumno=c.rut_alumno  
WHERE b.id_ano=$ano AND b.id_curso=$curso AND c.id_ramo=$ramo and b.bool_ar=0 
ORDER BY nro_lista ASC";
	$result = @pg_exec($conn,$sql);
	return $result;

	}

public function traeNotaPsintesis($conn,$rut_alumno,$id_ramo,$id_periodo)
{
	 $sql="select nota from notas_psintesis where rut_alumno=$rut_alumno and id_ramo=$id_ramo and periodo=$id_periodo";
	$result = @pg_exec($conn,$sql);
	return $result;
	}	
	
public function IngresoNota($conn,$curso,$ramo,$ano,$rut,$nota,$periodo){
	$sql="insert into notas_psintesis values ($curso,$ramo,$ano,$rut,$periodo,$nota)";
	$result = @pg_exec($conn,$sql);
	return $result;

}
	public function CambiaNota($conn,$ramo,$rut,$nota,$periodo){
	$sql = "update notas_psintesis set nota=$nota where rut_alumno=$rut and id_ramo=$ramo and periodo=$periodo";	
	$result = @pg_exec($conn,$sql);
	return $result;
	}
	
	public function borraNotas($conn,$ramo,$periodo){
	 $sql = "delete from notas_psintesis where id_ramo=$ramo and periodo=$periodo";	
	$result = @pg_exec($conn,$sql);
	return $result;
	}
	
}//fin clase
?>