<?php 


class Medica{
	public function contruct(){
		
	}
	
	public function institucion($conn,$rdb){
		$sql="SELECT nombre_instit FROM institucion WHERE rdb=".$rdb;
		$result = pg_exec($conn,$sql);
		
		return $result;
	}
	
	public function Alumno($conn,$rut){
		$sql="SELECT dig_rut, nombre_alu ||' '|| ape_pat ||' '|| ape_mat as nombre FROM alumno WHERE rut_alumno=".$rut;
		$result = pg_exec($conn,$sql);
		
		return $result;	
	}
	
	public function Listado($conn,$alumno){
		$sql="SELECT '1' tipo, id_ficha, fecha,observaciones,rut_alumno,fecha_actualizacion,apo_actualizacion 
FROM FICHA_MEDICANEW WHERE rut_alumno = '$alumno' 
UNION SELECT '2' tipo,id_fichamedica, fecha_creacion, observaciones,rut_alumno,fecha_actualizacion,apo_actualizacion 
FROM ficha_medicanew3 WHERE RUT_ALUMNO=".$alumno;
		$result =pg_exec($conn,$sql);
		
		return $result;	
	}
	
	public function AnoEscolar($conn,$ano){
		$sql="SELECT nro_ano FROM ano_escolar WHERE id_ano=".$ano;
		$result = pg_exec($conn,$sql);
		
		return $result;	
	}
	
	public function Ficha($conn,$ficha){
		$sql = "select * from ficha_medicanew where id_ficha = '$ficha'";	
		$result =pg_exec($conn,$sql);
		
		return $result;
	}
	
	public function FichaCompleta($conn,$alumno){
		$sql="SELECT * FROM FICHA_MEDICA WHERE RUT_ALUMNO=".$alumno." ORDER BY FECHA_ATENCION DESC";
		$result =pg_exec($conn,$sql);
		
		return $result;
	}
	
}
?>
