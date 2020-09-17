<? 
header( 'Content-type: text/html; charset=iso-8859-1' );
session_start();
require('../../../../../util/header.inc');

class PromediosInsuficientesCurso {
	private $conect;       

//constructor 
public function __construct($con){ 
      $this->conect = $con;  
    }
	
	
	public function carga_periodos($id_ano){
		
	 $sql="select * from periodo where id_ano=".$id_ano." order by id_periodo asc"; 
   $regis = pg_Exec($this->conect,$sql) or die( "Error bd insert 1".$sql);		
		 if($regis){
				   return $regis;
			}else{
				 return false;
		}
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
	
	
	
	  public function carga_nivel($id_ano){
		
	$sql="select * from niveles";
          
   $regis = pg_Exec($this->conect,$sql) or die( "Error bd insert 1".$sql);		
		 if($regis){
				   return $regis;
			}else{
				 return false;
		}
	}
	
	
	public function carga_cursos($id_ano,$id_nivel){
		
	  $sql="select c.id_curso, c.grado_curso, c.letra_curso from curso c
			inner join niveles n ON c.id_nivel=n.id_nivel
			WHERE c.id_ano=".$id_ano." and n.id_nivel=".$id_nivel." order by c.grado_curso, c.letra_curso"; 
   $regis = pg_Exec($this->conect,$sql) or die( "Error bd curso".$sql);		
		 if($regis){
				   return $regis;
			}else{
				 return false;
		}
	}
	
	
	
	public function carga_asignatura($id_curso){
		
	 $sql="select nombre,id_ramo from ramo r 
			inner join subsector su ON r.cod_subsector=su.cod_subsector
			where r.id_curso=".$id_curso." order by r.id_orden "; 
   $regis = pg_Exec($this->conect,$sql) or die( "Error bd asig".$sql);		
		 if($regis){
				   return $regis;
			}else{
				 return false;
		}
	}
	
	
	
	public function carga_ramos_nivel($id_nivel,$id_ano){
		
	 $sql="select DISTINCT r.cod_subsector, su.nombre from ramo r
inner join subsector su on r.cod_subsector=su.cod_subsector
inner join curso c on r.id_curso=c.id_curso
inner join niveles ni on ni.id_nivel=c.id_nivel
where c.id_nivel=".$id_nivel." and c.id_ano=".$id_ano.""; 
   $regis = pg_Exec($this->conect,$sql) or die( "Error bd asig".$sql);		
		 if($regis){
				   return $regis;
			}else{
				 return false;
		}
	}
	
	
	
	
	/*public function carga_alumnos($id_curso,$id_ano){
		
		
	
		
	 $sql="select matricula.rut_alumno, alumno.ape_pat||' '|| alumno.ape_mat||' '|| alumno.nombre_alu as nombre_alumno
	 from matricula, alumno 
	 where matricula.id_ano = ".$id_ano."  and  id_curso = ".$id_curso. " and matricula.rut_alumno = 	
			alumno.rut_alumno order by ape_pat, 
			ape_mat, nombre_alu"; 
   $regis = pg_Exec($this->conect,$sql) or die( "Error bd insert 1".$sql);		
		 if($regis){
				   return $regis;
			}else{
				 return false;
		}
	}*/
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	 
}
?>