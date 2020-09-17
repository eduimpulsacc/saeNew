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
		
	  	$sql_curso= "SELECT DISTINCT curso.id_curso,curso.ensenanza, curso.grado_curso, curso.letra_curso from curso WHERE id_ano=".$id_ano." and curso.ensenanza>10";
		 $sql_curso.= " ORDER BY curso.ensenanza, curso.grado_curso, curso.letra_curso; ";
	
   $regis = pg_Exec($this->conect,$sql_curso) or die( "Error bd insert 1".$sql_curso);		
		 if($regis){
				   return $regis;
			}else{
				 return false;
		}
	}
	
	
	public function carga_ramos($id_curso){
		
	  $sql="select ramo.id_ramo,su.nombre,ramo.id_orden,su.cod_subsector from ramo 
	inner join subsector su on ramo.cod_subsector=su.cod_subsector
	where ramo.id_curso=".$id_curso."order by ramo.id_orden ASC"; 
   $regis = pg_Exec($this->conect,$sql) or die( "Error bd insert 1".$sql);		
		 if($regis){
				   return $regis;
			}else{
				 return false;
		}
	}
	
}//fin clase
?>