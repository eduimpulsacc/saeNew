
<?

class Retiro{
	
	public function retiro(){
		
	}
	
	public function Ano($conn,$ano){
		$sql="SELECT nro_ano FROM ano_escolar WHERE id_ano=".$ano;
		$result = pg_exec($conn,$sql);
		$nro_ano = pg_result($result,0);
				
		return $nro_ano;
	}
	
	public function Curso($conn,$ano){
		$sql="SELECT id_curso FROM curso WHERE id_ano=".$ano." ORDER BY ensenanza, grado_curso, letra_curso ASC";
		$result = pg_exec($conn,$sql);
		
		return $result;	
	}
	
	public function Alumno($conn,$curso){
		$sql="SELECT a.rut_alumno, a.ape_pat ||' '|| a.ape_mat ||' '|| a.nombre_alu as nombre_alumno FROM alumno a INNER JOIN matricula m ON a.rut_alumno=m.rut_alumno WHERE id_curso=".$curso." ORDER BY nombre_alumno ASC";
		$result = pg_exec($conn,$sql);
		
		return $result;
	}	
	
	public function Empleado($conn,$rdb){
		$sql="SELECT nombre_emp ||' '|| ape_pat ||' '|| ape_mat as nombre_empl, e.rut_emp FROM empleado e INNER JOIN trabaja t ON e.rut_emp=t.rut_emp WHERE rdb=".$rdb." ORDER BY nombre_empl ASC";
		$result = pg_exec($conn,$sql);
		
		return $result;	
		
	}
	
	public function GuardaRetiro($conn,$ano,$curso,$alumno,$empleado,$fecha,$hora_salida,$hora_regreso,$motivo,$retira){
		$sql="INSERT INTO retiro (id_ano,id_curso,rut_alumno,rut_emp,quien_retira,fecha,hora_salida,hora_regreso,motivo) VALUES(".$ano.",".$curso.",".$alumno.",".$empleado.",'".utf8_decode($retira)."','".$fecha."','".$hora_salida."',";
		if($hora_regreso==""){
			$sql.="null,";			
		}else{
			$sql.="'".$hora_regreso."',";
		}
		$sql.="'".utf8_decode($motivo)."')";
		
		$result = pg_exec($conn,$sql);
		
		return $result;
		
	}
	
	public function ListadoRetiros($conn,$curso,$alumno){
		$sql="SELECT * FROM retiro WHERE id_curso=".$curso." AND rut_alumno=".$alumno." ORDER BY fecha ASC";
		$result = pg_exec($conn,$sql);
		
		return $result;
		
	}
	
	public function EliminaRetiro($conn,$id_retiro){
		$sql="DELETE FROM retiro WHERE id_retiro=".$id_retiro;
		$result=pg_exec($conn,$sql);
		
		return $result;	
	}
	
	public function BuscaRetiro($conn,$id_retiro){
		$sql="SELECT * FROM retiro WHERE id_retiro=".$id_retiro;
		$result=pg_exec($conn,$sql);
				
		return $result;		
	}
	
	public function ModificaRetiro($conn,$ano,$curso,$alumno,$empleado,$fecha,$hora_salida,$hora_regreso,$motivo,$retira,$id_retiro){
		$sql="UPDATE retiro SET rut_emp=".$empleado.", fecha='".$fecha."', hora_salida='".$hora_salida."', hora_regreso='".$hora_regreso."', quien_retira='".utf8_decode($retira)."', motivo='".utf8_decode($motivo)."' WHERE id_retiro=".$id_retiro;
		$result=pg_exec($conn,$sql);
				
		return $result;	
	}
	
	public function VistaPrevia($conn,$id){
		$sql="SELECT r.*, e.nombre_emp ||' '|| ape_pat ||' '|| ape_mat as nombre_empleado FROM retiro r INNER JOIN empleado e ON r.rut_emp=e.rut_emp WHERE id_retiro=".$id;
		$result=pg_exec($conn,$sql);
				
		return $result;		
	}
		
}

?>