<?
class Curso{
	public function contruct(){
		
	}
	
	public function Grados($conn,$ano,$ensenanza){
		  $sql="SELECT DISTINCT(c.ensenanza),c.grado_curso,e.nombre_tipo
				FROM curso c
				INNER JOIN tipo_ensenanza e on e.cod_tipo = c.ensenanza
				WHERE id_ano =$ano AND c.ensenanza=$ensenanza order by c.ensenanza,c.grado_curso";
		$result = pg_exec($conn,$sql);
		return $result;	
	}
	
	public function Personal($connect,$conn,$perfil,$rdb){
		 $sql="SELECT nombre_usuario FROM usuario u INNER JOIN accede a ON u.id_usuario=a.id_usuario WHERE id_perfil=".$perfil." AND rdb=".$rdb;
		$rs_accede = pg_exec($connect,$sql);
		for($i=0;$i<pg_num_rows($rs_accede);$i++){
			$fila = pg_fetch_array($rs_accede,$i);
			
			if($i==0){
				$datos=$fila['nombre_usuario'];
			}else{
				$datos.=",".$fila['nombre_usuario'];
			}
		}
		$sql="SELECT rut_emp, nombre_emp, ape_pat, ape_mat FROM empleado WHERE rut_emp in($datos)";
		$result = pg_exec($conn,$sql);
		
		return $result; 
	}
	
	public function Listado($conn,$ano,$ensenanza,$grado){
		$sql="SELECT grado_curso, letra_curso, nombre_tipo,id_curso FROM curso c INNER JOIN tipo_ensenanza te ON te.cod_tipo=c.ensenanza WHERE c.ensenanza=".$ensenanza."  AND id_ano=".$ano;
		if($grado!=0){
			$sql.="AND grado_curso=".$grado;	
		}
		$sql.=" ORDER BY grado_curso ASC";
		//echo $sql;
		$result = pg_exec($conn,$sql);
		
		return $result;
	}
	
	public function Existe($conn,$rdb,$perfil,$id_curso,$ensenanza,$rut){
		$sql="SELECT * FROM perfil_curso WHERE rdb=".$rdb." AND id_perfil=".$perfil." AND id_curso=".$id_curso." AND cod_tipo=".$ensenanza." AND rut_emp=".$rut;
		$result = pg_exec($conn,$sql);
		
		
		return $result;
	}
	public function Agregar($conn,$ensenanza,$id_curso,$grado,$rdb,$perfil,$rut){
		echo $sql="INSERT INTO perfil_curso (rdb,id_perfil,id_curso,cod_tipo,rut_emp,grado_curso) VALUES(".$rdb.",".$perfil.",".$id_curso.",".$ensenanza.",".$rut.",".$grado.")";
		$result = pg_exec($conn,$sql);
		
		return $result;
			
	}
	
	public function Eliminar($conn,$ensenanza,$id_curso,$rdb,$perfil){
		$sql="DELETE FROM perfil_curso WHERE rdb=".$rdb." AND cod_tipo=".$ensenanza." AND id_curso=".$id_curso." AND id_perfil=".$perfil;
		$result = pg_exec($conn,$sql);
		
		return $result;	
	}

}

?>