<?

require "../../class/Coneccion.class.php";

class Empleado{
	
	public $Conec;
	
	//constructor 
	public function Empleado($ip,$bd){
		$this->Conec = new DBManager($ip,$bd);
	 }	
	 
	 
	 public function Listado($cargo,$rdb){
		$sql="	SELECT e.rut_emp,e.dig_rut, e.nombre_emp ||' '|| e.ape_pat as nombre_empleado FROM empleado e 
				INNER JOIN trabaja t ON e.rut_emp=t.rut_emp
				INNER JOIN cargos c ON c.id_cargo=t.cargo
				WHERE rdb=".$rdb." and c.id_cargo=".$cargo."
				ORDER BY nombre_empleado ASC ";
				;
		$result = pg_exec( $this->Conec->conectar(),$sql ) or die( "Error bd Select ".$sql );
 
 		return $result;
	 }
	 
	 public function Evaluador($rut,$periodo){
		$sql= "SELECT * FROM evados.eva_evaluador ee WHERE ee.rut_evaluador=".$rut." and id_periodo=".$periodo; 
		$result = pg_exec( $this->Conec->conectar(),$sql ) or die( "Error bd Select ".$sql );
 
 		return $result;
	 }
	 
	 public function Evaluado($rut,$periodo){
		$sql= "SELECT * FROM evados.eva_evaluado ee WHERE ee.rut_evaluado=".$rut." and id_periodo=".$periodo; 
		$result = pg_exec( $this->Conec->conectar(),$sql ) or die( "Error bd Select ".$sql );
 
 		return $result;
	 }
	 
	 public function Relacion($rut,$periodo){
		$sql="SELECT * FROM evados.eva_relacion_evaluacion ee WHERE ee.rut_evaluador=".$rut." and id_periodo=".$periodo; 
		$result = pg_exec( $this->Conec->conectar(),$sql ) or die( "Error bd Select ".$sql );
 
 		return $result;
	 }
	 
	 public function Evaluaciones($rut,$periodo){
		$sql="SELECT * FROM evados.eva_plantilla_evaluacion ee WHERE ee.rut_evaluador=".$rut." and ip_periodo=".$periodo; 
		$result = pg_exec( $this->Conec->conectar(),$sql ) or die( "Error bd Select ".$sql );
 
 		return $result; 
	 }
	 
	 public function BuscaEmpleado($rut,$rdb){
		$sql="	SELECT e.rut_emp,dig_rut, nombre_emp ||' '|| ape_pat ||' '|| ape_mat as nombre, t.cargo, c.nombre_cargo 
				FROM empleado e 
				INNER JOIN trabaja t ON e.rut_emp=t.rut_emp
				INNER JOIN cargos c ON c.id_cargo=t.cargo
				WHERE rdb=".$rdb." AND t.rut_emp=".$rut;
				$result = pg_exec( $this->Conec->conectar(),$sql ) or die( "Error bd Select ".$sql );
 
 		return $result; 		
	 }
	 
	 public function Cargos(){
		$sql="SELECT id_cargo, nombre_cargo FROM cargos ORDER BY nombre_cargo ASC";
 		$result = pg_exec( $this->Conec->conectar(),$sql ) or die( "Error bd Select ".$sql );
 
 		return $result; 		
	 }
	 
	 public function Guarda_Cargo($cargo1,$cargo2,$rut,$rdb){
		$sql="DELETE FROM trabaja WHERE rdb=".$rdb." AND rut_emp=".$rut;
		$rs_delete = pg_exec( $this->Conec->conectar(),$sql ) or die( "Error bd Select ".$sql );
		
		$sql="INSERT INTO trabaja (rut_emp,rdb,cargo) VALUES (".$rut.",".$rdb.",".$cargo1.")";
		$rs_cargo1 = pg_exec( $this->Conec->conectar(),$sql ) or die( "Error bd Select ".$sql );
		
		
		$sql="INSERT INTO trabaja (rut_emp,rdb,cargo) VALUES (".$rut.",".$rdb.",".$cargo2.")";
		$rs_cargo2 = pg_exec( $this->Conec->conectar(),$sql ) or die( "Error bd Select ".$sql );
		
		if($rs_cargo1 || $rs_cargo2){
			return 1;	
		}else{
			return 0;	
		}
	 }
	 
	 public function Elimina_Conf($rut,$periodo,$ano,$rdb){
		 
		 /**************** CONFIGURACIONES DE EVALUADOR ******************/
		 echo $sql="DELETE FROM evados.eva_plantilla_evaluacion epe WHERE epe.id_ano=".$ano." AND epe.ip_periodo=".$periodo." AND rut_evaluador=".$rut;
		 $rs_evaluaciones = pg_exec( $this->Conec->conectar(),$sql ) or die( "Error bd Select ".$sql );
		 
		 echo "<br>".$sql="DELETE FROM evados.eva_relacion_evaluacion WHERE id_ano=".$ano." AND id_periodo=".$periodo." AND rut_evaluador=".$rut;
		 $rs_relaciones = pg_exec( $this->Conec->conectar(),$sql ) or die( "Error bd Select ".$sql );
		 
		echo "<br>".$sql ="DELETE FROM evados.eva_evaluador WHERE id_ano=".$ano." AND id_periodo=".$periodo." AND rut_evaluador=".$rut;
		 $rs_evaluador = pg_exec( $this->Conec->conectar(),$sql ) or die( "Error bd Select ".$sql );
		 
		 /*************** CONFIGURACIONES DE EVALUADO *****************************/
		 echo "<br>".$sql="DELETE FROM evados.eva_plantilla_evaluacion epe WHERE epe.id_ano=".$ano." AND epe.ip_periodo=".$periodo." AND rut_evaluado=".$rut;
		 $rs_evaluaciones1 = pg_exec( $this->Conec->conectar(),$sql ) or die( "Error bd Select ".$sql );
		 
		 echo "<br>".$sql="DELETE FROM evados.eva_relacion_evaluacion WHERE id_ano=".$ano." AND id_periodo=".$periodo." AND rut_evaluado=".$rut;
		 $rs_relaciones1 = pg_exec( $this->Conec->conectar(),$sql ) or die( "Error bd Select ".$sql );
		 
		 echo "<br>".$sql ="DELETE FROM evados.eva_evaluado WHERE id_ano=".$ano." AND id_periodo=".$periodo." AND rut_evaluado=".$rut;
		 $rs_evaluador1 = pg_exec( $this->Conec->conectar(),$sql ) or die( "Error bd Select ".$sql );
		 
		 if($rs_evaluaciones && $rs_evaluaciones1 && $rs_evaluador && $rs_evaluador1 && $rs_relaciones && $rs_relaciones1){
			return 1; 
		 }else{
			return 0; 
		 }
		 
		 
	 }
}

?>
