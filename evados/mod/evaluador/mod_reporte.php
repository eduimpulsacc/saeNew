<?

require "../../class/Coneccion.class.php";

class Evaluador{
       
	public $Conec;
	
	//constructor 
	public function Evaluador($ip,$bd){
		$this->Conec = new DBManager($ip,$bd);
	 } 

	public function listadoEvaluados($rdb,$cargo,$ano){  // guarda en la base datos 
	
		  $sql="SELECT empleado.rut_emp, empleado.dig_rut,empleado.nombre_emp || ' ' || ape_pat  || ' ' || ape_mat as nombre, porcentaje FROM empleado INNER JOIN trabaja ON empleado.rut_emp=trabaja.rut_emp INNER JOIN cargos ON trabaja.cargo=cargos.id_cargo LEFT JOIN eva_evaluador eva ON empleado.rut_emp=eva.rut_evaluador and id_ano=$ano WHERE trabaja.rdb=$rdb and id_cargo=$cargo";
		  $result = pg_Exec($this->Conec->conectar(),$sql) or die ("fallo:".$sql);
			
		return $result;
		
	}
	
	public function InsertaDocente($rut,$ano,$porc){
		$sql ="INSERT INTO eva_evaluador (id_ano,rut_evaluador,porcentaje) VALUES(".$ano.",".$rut.",".$porc.")";
		$rs_docente = pg_exec($this->Conec->conectar(),$sql) or die ("fallo:".$sql);
		
		if($rs_docente){
			return true;
		}else{
			return $sql;
		}
	}
	public function existeEvaluados($rut,$ano){
		$sql ="SELECT * FROM eva_evaluador WHERE id_ano=".$ano." AND rut_evaluador=".$rut;
		$rs_existe = pg_Exec($this->Conec->conectar(),$sql) or die ("fallo:".$sql);
		
		return $rs_existe;
	}
	
	public function EliminaDocente($rut,$ano){
		$sql ="DELETE FROM eva_evaluador WHERE id_ano=".$ano." AND rut_evaluador=".$rut;
		$rs_docente = pg_Exec($this->Conec->conectar(),$sql) or die ("fallo:".$sql);
		
		if($rs_docente){
			return true;
		}else{
			return false;
		}
	}



 }	




	



?>

