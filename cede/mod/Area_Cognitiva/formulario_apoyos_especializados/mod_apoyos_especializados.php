<? 
header( 'Content-type: text/html; charset=iso-8859-1' );

session_start(); 
require "../../../Class/Membrete.php";

//require "../../Class/Coneccion.php";
class AreaCog {
	   
	public $Conec;
	
	//constructor 
	public function __construct($ip,$bd){
		$this->Conec = new DBManager($ip,$bd);
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
	
	
	public function InsertaAreaCognitiva($id_ano,$_CURSO,$_RUT_ALUMNO,$txtFECHA,$rut_emp,$obser,$_nombre_archivo,$id_tipo){ 
	
	  $sql_insert = "INSERT INTO cede.archivos_cognitivos(id_ano,id_curso,rut_alumno,fecha,rut_emp,observacion,nombre,id_tipo) 
      VALUES (".$id_ano.",".$_CURSO.",".$_RUT_ALUMNO.",'".$txtFECHA."','".$rut_emp."',
	  '".$obser."','".$_nombre_archivo."','".$id_tipo."');";

	$regis = pg_Exec( $this->Conec->conectar(),$sql_insert ) or die( "Error bd insert 1" );
		if($regis){
			   return true;
		}else{
			  return false;
		}
	}
	
	public function Carga_Area_Cognitiva($id_tipo,$rut_alumno){
		
		$sql=" select ent.*,ano.nro_ano,al.nombre_alu,al.ape_pat,al.ape_mat,tpp.nombre
from cede.archivos_cognitivos ent 
inner join cede.tipo_archivo tpp on ent.id_tipo=tpp.id_tipo 
inner join ano_escolar ano on ent.id_ano=ano.id_ano
inner join alumno al on ent.rut_alumno=al.rut_alumno 
where ent.id_tipo=".$id_tipo." and ent.rut_alumno=".$rut_alumno; 
		
		$regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Select 2" );
		 if($regis){
				   return $regis;
			}else{
				 return false;
		}
	}
	
	
	public function Descarga_Archivofinal($id_archivo){
		
	  $sql=" select * from cede.archivos_cognitivos ent where ent.id_archivo=".$id_archivo; 
		
		$regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Select 3" );
		 if($regis){
				   return $regis;
			}else{
				 return false;
		}
	}
	
	public function Busca_area_cognitiva($id_archivo){
		
		$sql=" select * from cede.archivos_cognitivos where id_archivo=".$id_archivo; 
		
		$regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Select 4" );
		 if($regis){
				   return $regis;
			}else{
				 return false;
		}
	}

	
	public function Modifica_area_cognitiva($id_archivo,$_obser){
			
		 $sql="update cede.archivos_cognitivos set observacion='$_obser'  
		 where id_archivo=".$id_archivo; 
		
		$regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd update " );
		 if($regis){
				   return true;
			}else{
				 return false;
		}
	}
	
	
	public function eliminad_AreaCog($id_archivo){
		 $sql="delete from cede.archivos_cognitivos where id_archivo=$id_archivo;"; 
		 
		$regis = @pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Insert 2" );
		if ($regis){
				return true;
			}else{
				 return false;
		}
	}
	
	 
}
?>