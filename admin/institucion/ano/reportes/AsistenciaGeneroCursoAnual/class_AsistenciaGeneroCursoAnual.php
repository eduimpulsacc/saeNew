<? 
header( 'Content-type: text/html; charset=iso-8859-1' );
require('../../../../../util/header.inc');

class BuscadorReporte {
	
	private $conect;       

//constructor 
public function __construct($con){ 
      $this->conect = $con;  
    }
	
	
	
	
	public function numero_ano($ano){
		
		 $sql="select * from ano_escolar where id_ano=$ano";
		 $regis = pg_Exec($this->conect,$sql) or die( "Error bd select 0".$sql);		
		 if($regis){
				   return $regis;
			}else{
				 return false;
		}
		}
	 
	  public function carga_anos($rdb){
		
	 $sql="select * from ano_escolar an where an.id_institucion=$rdb order by an.nro_ano desc"; 
   $regis = pg_Exec($this->conect,$sql) or die( "Error bd 2".$sql);		
		 if($regis){
				   return $regis;
			}else{
				 return false;
		}
	}
	
	public function carga_cursos($id_ano){
		
	 $sql="select * from curso c where c.id_ano=$id_ano ORDER BY c.ensenanza, c.grado_curso, c.letra_curso"; 
   $regis = pg_Exec($this->conect,$sql) or die( "Error bd insert 1".$sql);		
		 if($regis){
				   return $regis;
			}else{
				 return false;
		}
	}



public function dias_habiles($id_ano)
{
	$sql="select sum(dias_habiles) from periodo where id_ano=$id_ano";
	 $regis = pg_Exec($this->conect,$sql) or die( "Error bd 3".$sql);		
		 if($regis){
				   return $regis;
			}else{
				 return false;
		}
		
}	
	
	
public function asistencias_hombres($ano,$id_curso)
 {
	 $sql="select count(*) as contador
			from asistencia a
			INNER JOIN matricula m on a.rut_alumno=m.rut_alumno and m.id_curso=$id_curso
			INNER JOIN alumno al on a.rut_alumno=al.rut_alumno
			where a.ano=$ano and a.id_curso=$id_curso and al.sexo=2
			group BY al.sexo";
			 $regis = pg_Exec($this->conect,$sql) or die( "Error bd 3".$sql);		
		 if($regis){
				   return $regis;
			}else{
				 return false;
		}
 }	
 
 
 public function asistencias_mujeres($ano,$id_curso)
 {
	 $sql="select count(*) as contador
			from asistencia a
			INNER JOIN matricula m on a.rut_alumno=m.rut_alumno and m.id_curso=$id_curso
			INNER JOIN alumno al on a.rut_alumno=al.rut_alumno
			where a.ano=$ano and a.id_curso=$id_curso and al.sexo=1
			group BY al.sexo";
			 $regis = pg_Exec($this->conect,$sql) or die( "Error bd 3".$sql);		
		 if($regis){
				   return $regis;
			}else{
				 return false;
		}
 }	
	
	 
}
?>