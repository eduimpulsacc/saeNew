<? 
header( 'Content-type: text/html; charset=iso-8859-1' );
session_start();
require('../../../../../../util/header.inc');

class ensayoSimce {
	
	private $conect;       

//constructor 
public function __construct($con){ 
      $this->conect = $con;  
    }
	 
	  public function carga_anos($rdb){
		
	 	 $sql="select * from ano_escolar an where an.id_institucion=$rdb order by an.nro_ano desc"; 
   		$regis = pg_Exec($this->conect,$sql) or die( "Error bd insert 1".$sql);		
		 if($regis){
		   return $regis;
		 }else{
		   return false;
		}
	}
	
		public function carga_cursos($id_ano){
		
	  	$sql_curso= "SELECT DISTINCT curso.id_curso,curso.ensenanza, curso.grado_curso, curso.letra_curso from curso WHERE id_ano=".$id_ano." ";
		 $sql_curso.= " ORDER BY curso.ensenanza, curso.grado_curso, curso.letra_curso; ";
	
   $regis = pg_Exec($this->conect,$sql_curso) or die( "Error bd insert 1".$sql_curso);		
		 if($regis){
				   return $regis;
			}else{
				 return false;
		}
	}
	
	
	public function carga_alumno($id_curso){
		
	   $sql="select alumno.rut_alumno,alumno.ape_pat,alumno.ape_mat,alumno.nombre_alu from alumno inner join matricula on alumno.rut_alumno = matricula.rut_alumno where matricula.id_curso=".$id_curso."order by alumno.ape_pat,alumno.ape_mat,alumno.nombre_alu ASC"; 
   $regis = pg_Exec($this->conect,$sql) or die( "Error bd insert 1".$sql);		
		 if($regis){
				   return $regis;
			}else{
				 return false;
		}
	}
	
}//fin clase
?>