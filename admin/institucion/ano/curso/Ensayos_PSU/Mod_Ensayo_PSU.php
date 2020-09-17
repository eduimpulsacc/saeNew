<? 
header( 'Content-type: text/html; charset=iso-8859-1' );
session_start();
require('../../../../../util/header.inc');

class EnsayoPSU {
	
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
		
	  $sql="select * from curso c where c.id_ano=$id_ano and c.ensenanza>110 ORDER BY c.ensenanza, c.grado_curso, c.letra_curso"; 
   $regis = pg_Exec($this->conect,$sql) or die( "Error bd  1".$sql);		
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

public function traePuntajedia($curso,$ramo,$alumno,$fecha){
	   $sql="select * from ensayos_psu eps where eps.id_curso=".$curso." and eps.id_ramo=".$ramo." and rut_alumno=".$alumno." AND fecha='".$fecha."' order by fecha";
	  $regis = pg_Exec($this->conect,$sql) or die( "Error3 ".$sql);		
		 if($regis){
				   return $regis;
			}else{
				 return false;
		}	

}
	
	public function actPuntaje($curso,$ramo,$alumno,$fecha,$puntaje){
		  $sql="update ensayos_psu set puntaje =$puntaje where rut_alumno = $alumno and id_ramo = $ramo and fecha='$fecha'";
		$regis = pg_Exec($this->conect,$sql) or die( "Error3 ".$sql);		
		 if($regis){
				   return $regis;
			}else{
				 return false;
		}
	}
	
	
	 
}
?>