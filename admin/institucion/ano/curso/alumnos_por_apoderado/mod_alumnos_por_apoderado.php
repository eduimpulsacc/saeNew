<? 
header( 'Content-type: text/html; charset=iso-8859-1' );
session_start();
require('../../../../../util/header.inc');

class AlumnosApoderado {
	
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
		
	$sql="select c.id_curso,c.grado_curso,c.letra_curso,c.ensenanza from curso c where c.id_ano=$id_ano order by c.ensenanza,c.grado_curso,c.letra_curso"; 
	 
   $regis = pg_Exec($this->conect,$sql) or die( "Error bd  1".$sql);		
		 if($regis){
				   return $regis;
			}else{
				 return false;
		}
	}
	
	
	public function carga_apo($id_curso)
	{
		$sql=" select ap.rut_apo, ap.ape_pat||' '||ap.ape_mat||' '||ap.nombre_apo as nombre_apo from apoderado ap where rut_apo IN(
        select rut_apo from tiene2 where rut_alumno in(select rut_alumno from matricula where id_curso=$id_curso))";	
  		$regis = pg_Exec($this->conect,$sql) or die( "Error bd  1".$sql);		
		 
		 if($regis){
				   return $regis;
			}else{
				 return false;
		}
	}	
	
	public function carga_datos($rut_apo,$id_ano)
	{
		
		$sql="select apo.nombre_apo||' '||apo.ape_pat||' '||apo.ape_mat as nombre_apo,apo.rut_apo||'-'||apo.dig_rut as rut_apo,apo.calle||' '||apo.nro as direccion_apo, apo.telefono,apo.email
			  from apoderado apo where rut_apo=$rut_apo";
			  
			  $result=pg_Exec($this->conect,$sql) or die( "Error bd  1".$sql);
				
		 if($result){
				   return $result;
			}else{
				 return false;
		}
	}
	
	public function carga_datos_alumnos($rut_apo,$id_ano)
	{
		$sql="select al.nombre_alu||' '||al.ape_pat||' '||al.ape_mat AS nombre_alumno,al.rut_alumno||'-'||al.dig_rut as rut_alumno,ma.id_curso 
       from alumno al
       JOIN tiene2 ti on ti.rut_alumno=al.rut_alumno
       JOIN matricula ma on ma.rut_alumno=al.rut_alumno
       where ti.rut_apo=$rut_apo and ma.id_ano=$id_ano";	
	  
	  $regis = pg_Exec($this->conect,$sql) or die( "Error bd  1".$sql);	
	  	
		 	 if($regis){
				   return $regis;
			}else{
				 return false;
		}
	}
	 
}
?>