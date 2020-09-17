<? 
header( 'Content-type: text/html; charset=iso-8859-1' );
session_start();
require('../../../../../util/header.inc');

class Ciclos {
	
	private $conect;       

//constructor 
public function __construct($con){ 
      $this->conect = $con;  
    }
	 
	  public function carga_ciclos($ano){
		
	 	$sql ="SELECT id_ciclo,nomb_ciclo FROM ciclo_conf WHERE id_ano=".$ano;
		$rs_ciclo = pg_Exec($this->conect,$sql) or die( "Error bd insert 1".$sql);
//   $regis = pg_Exec($this->conect,$sql) or die( "Error bd insert 1".$sql);		
		 if($rs_ciclo){
				   return $rs_ciclo;
			}else{
				 return false;
		}
	}
	
	
	public function carga_cursos($id_ciclo){
		
	 	$sql="SELECT curso.id_curso, curso.grado_curso ||'-'||curso.letra_curso ||' '|| te.nombre_tipo as nom_curso ";
		$sql.="FROM ciclos INNER JOIN curso ON ciclos.id_curso=curso.id_curso ";
		$sql.="INNER JOIN tipo_ensenanza te ON curso.ensenanza=te.cod_tipo ";
		$sql.="WHERE id_ciclo=".$id_ciclo." ORDER BY grado_curso,letra_curso ASC"; 
   		$regis = pg_Exec($this->conect,$sql) or die( "Error bd  1".$sql);		
		 if($regis){
				   return $regis;
			}else{
				 return false;
		}
	}
	
	
	public function carga_ramo($id_curso){
		
	 $sql="select ramo.id_ramo,su.nombre,ramo.id_orden,su.cod_subsector from ramo 
	inner join subsector su on ramo.cod_subsector=su.cod_subsector
	where ramo.id_curso=".$id_curso."order by ramo.id_orden ASC"; 
   $regis = pg_Exec($this->conect,$sql) or die( "Error2".$sql);		
		 if($regis){
				   return $regis;
			}else{
				 return false;
		}
	}
	
	
	public function carga_lista_alumnos($id_curso,$ano){
		
	   $sql="SELECT alumno.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, 
		alumno.ape_mat, matricula.id_curso, matricula.nro_lista, matricula.bool_ar, 
		matricula.num_mat FROM curso INNER JOIN matricula ON curso.id_curso = matricula.id_curso 
		INNER JOIN alumno ON matricula.rut_alumno = alumno.rut_alumno 
		WHERE matricula.bool_ar=0 AND matricula.id_curso=".$id_curso." AND matricula.id_ano=".$ano." order by ape_pat, ape_mat, nombre_alu";
		
		 $regis = pg_Exec($this->conect,$sql) or die( "Error3 ".$sql);		
		 if($regis){
				   return $regis;
			}else{
				 return false;
		}
	}

	public function carga_periodo($id_ano){
		$sql ="SELECT id_periodo, nombre_periodo FROM periodo WHERE id_ano=".$id_ano." ORDER BY id_periodo ASC";
		$result = pg_exec($this->conect,$sql) or die( "Error3 ".$sql);		
		 if($result){
				   return $result;
			}else{
				 return false;
		}
		
	}
	
	
	 
}
?>