<? 
header( 'Content-type: text/html; charset=iso-8859-1' );
session_start();

require('../../../../util/header.inc');

class AtrasosMinutosEmp {
	private $conect;       

//constructor 
public function __construct($con){ 
		
	$this->conect = $con;	
       
    }
	
	 public function carga_empleados($rdb){
		
	 $sql="SELECT distinct empleado.rut_emp, empleado.dig_rut, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat 
	 FROM empleado INNER  JOIN trabaja ON empleado.rut_emp = trabaja.rut_emp INNER JOIN institucion ON trabaja.rdb = institucion.rdb 
	 WHERE institucion.rdb=".$rdb." order by ape_pat, ape_mat, nombre_emp asc"; 
   $regis = pg_Exec($this->conect,$sql);		
		 if($regis){
				   return $regis;
			}else{
				 return false;
		}
	}
	
	
	public function modifica_min($rut_emp,$fecha,$minutos){
		
		$sql="update atraso_minutosemp set minutos_atraso=".$minutos." where rut_empleado=".$rut_emp." and fecha_atraso='".$fecha."'";
		
			$regis = pg_Exec($this->conect,$sql);		
		 if($regis){
				   return true;
			}else{
				 return false;
		}
		
	}
	
	
	public function elimina_min($rut_emp,$fecha){
		
		$sql="delete from atraso_minutosemp where rut_empleado=".$rut_emp." and fecha_atraso='".$fecha."'";
		
			$regis = pg_Exec($this->conect,$sql) or die( "Error bd 2".$sql);		
		 if($regis){
				   return true;
			}else{
				 return false;
		}
	}
	
	
	 
}
?>