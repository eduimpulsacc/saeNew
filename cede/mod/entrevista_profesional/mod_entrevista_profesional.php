<? 
header( 'Content-type: text/html; charset=iso-8859-1' );

session_start();
require "../../Class/Membrete.php";

//require "../../Class/Coneccion.php";
class EntrevistaProf {
	   
	public $Conec;
	
	//constructor 
public function __construct($_IPDB,$_ID_BASE){
	$this->Conec = new DBManager($_IPDB,$_ID_BASE);	
	 } 
	 
	 
	  public function carga_profesionales(){
		
	 $sql="select * from cede.tipo_profesional order by 1"; 
		
		$regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Select 0" );
		 if($regis){
				   return $regis;
			}else{
				 return false;
		}
	}
	
	
	public function InsertaEntrevista($id_ano,$_CURSO,$_RUT_ALUMNO,$txtFECHA,$select_profesional,$obser,$_nombre_archivo){ 
	
	 $sql_insert = "INSERT INTO cede.entrevista_profecional(id_ano,id_curso,rut_alumno,fecha,id_prof,obs,archivo) 
      VALUES (".$id_ano.",".$_CURSO.",".$_RUT_ALUMNO.",'".$txtFECHA."','".$select_profesional."',
	  '".$obser."','".$_nombre_archivo."');";

	$regis = @pg_Exec( $this->Conec->conectar(),$sql_insert );
		if($regis){
			   return true;
		}else{
			  return false;
		}
	}
	
	public function Carga_Entrevista_Profesionales($id_prof,$id_ano){
		
		$sql=" select ent.*,ano.nro_ano,al.nombre_alu,al.ape_pat,al.ape_mat
		from cede.entrevista_profecional ent 
		inner join ano_escolar ano on ent.id_ano=ano.id_ano
		inner join alumno al on ent.rut_alumno=al.rut_alumno 
		where ent.id_prof=".$id_prof." and ent.id_ano=".$id_ano." order by id_entrevista"; 
		
		$regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Select 2" );
		 if($regis){
				   return $regis;
			}else{
				 return false;
		}
	}
	
	
	public function Descarga_Archivo($id_entrevista){
		
	  $sql=" select * from cede.entrevista_profecional  ent where ent.id_entrevista=".$id_entrevista; 
		
		$regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Select 3" );
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

	
	public function Modifica_Entrevista_Profesionales($id_entrevista,$_obser){
			
		 $sql="update cede.entrevista_profecional set obs='$_obser'  
		 where id_entrevista=".$id_entrevista; 
		
		$regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd update " );
		 if($regis){
				   return true;
			}else{
				 return false;
		}
	}
	
	
	public function eliminad_Entrevista($id_entrevista){
		 $sql="delete from cede.entrevista_profecional where id_entrevista=$id_entrevista;"; 
		 
		$regis = @pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Insert 2" );
		if ($regis){
				return true;
			}else{
				 return false;
		}
	}
	
	 
}
?>