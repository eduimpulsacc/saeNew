<? 
header( 'Content-type: text/html; charset=iso-8859-1' );
session_start();
require('../../../../../util/header.inc');

class CartaFelAlumno {
	
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
	
	
	public function carga_cursos($id_ano,$perfil,$curso,$usuario,$rdb){
		$sql="SELECT * FROM perfil_curso WHERE rdb=".$rdb." AND id_perfil=".$perfil."";
		if($perfil!=0){
			$sql.=" AND rut_emp=".$usuario;
		}
		//echo $sql;
		$rs_acceso = pg_Exec($this->conect,$sql) or die(pg_last_error($sql));
		
		if(pg_num_rows($rs_acceso)!=0 && $perfil!=0){
			$whe_perfil_curso=" AND curso.ensenanza=".pg_result($rs_acceso,3)." AND grado_curso in(";
			for($i=0;$i<pg_num_rows($rs_acceso);$i++){
				$fila_acceso = pg_fetch_array($rs_acceso,$i);
				if($i==0){
					$whe_perfil_curso.=$fila_acceso['grado_curso'];
				}else{
					$whe_perfil_curso.=",".$fila_acceso['grado_curso'];
				}
			}
			$whe_perfil_curso.=")";
		}
	  	$sql_curso= "SELECT DISTINCT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, ";
		$sql_curso.= "curso.ensenanza, curso.cod_decreto ";
		$sql_curso.= "FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
		$sql_curso.= "WHERE (((curso.id_ano)=".$id_ano.")) ";
		if($perfil==17){
			$sql_curso.= " AND id_curso=".$curso."";	
		}else if(pg_num_rows($rs_acceso)!=0 || $perfil!=0){
			$sql_curso.= $whe_perfil_curso;
		}
		
		 $sql_curso.= " ORDER BY curso.ensenanza, curso.grado_curso, curso.letra_curso; ";
			
	/* $sql="select * from curso c where c.id_ano=$id_ano 
	 ORDER BY c.ensenanza, c.grado_curso, c.letra_curso"; */
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
	
	
	
	
	
	
	
	
	
	
	public function Carga_Entrevista_Profesionales($id_prof){
		
		$sql=" select ent.*,ano.nro_ano,al.nombre_alu,al.ape_pat,al.ape_mat
		from cede.entrevista_profecional ent 
		inner join ano_escolar ano on ent.id_ano=ano.id_ano
		inner join alumno al on ent.rut_alumno=al.rut_alumno 
		where ent.id_prof=".$id_prof." order by id_entrevista"; 
		
		$regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Select 2" );
		 if($regis){
				   return $regis;
			}else{
				 return false;
		}
	}

	
	
	public function Busca_Entrevista_Profesionales($id_entrevista){
		
		 $sql=" select ent.*, tpp.nombre from cede.entrevista_profecional ent
		 		inner join cede.tipo_profesional tpp on ent.id_prof=tpp.id_prof
		  where ent.id_entrevista=".$id_entrevista; 
		
		$regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Select 4" );
		 if($regis){
				   return $regis;
			}else{
				 return false;
		}
	}

	
	
	
	
	 
}
?>