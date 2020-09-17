<? 
header( 'Content-type: text/html; charset=iso-8859-1' );

session_start();
require "../../Class/Membrete.php";

//require "../../Class/Coneccion.php";
class MapaConceptual {
	   
	public $Conec;
	
	//constructor 
	public function __construct($_IPDB,$_ID_BASE){
	$this->Conec = new DBManager($_IPDB,$_ID_BASE);
	 } 
	 
	/*  public function carga_cursos($ano){
		  
		   $sql="select id_curso from curso where id_ano=".$ano."
	         ORDER BY curso.ensenanza, curso.grado_curso, curso.letra_curso ASC";
	
	$regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Select 1" );
	
			if($regis){
				   return $regis;
			}else{
				  return false;
		}
 	 } */
	 
	 
	 public function carga_ramos($id_nivel){
		
		 $sql="select DISTINCT subsector.nombre, cede.nivel_ramo.cod_subsector
		from cede.nivel_ramo 
		inner join subsector on subsector.cod_subsector=cede.nivel_ramo.cod_subsector
		where id_nivel=".$id_nivel." order by nombre"; 
		
		$regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Select 2" );
		 if($regis){
				   return $regis;
			}else{
				 return false;
		}
	}
	
	public function carga_nivel($id_ramo){
		 $sql="select * from cede.niveles"; 
		$regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Select 2" );
		 if($regis){
				   return $regis;
			}else{
				 return false;
		}
	}
	
	
	public function carga_funcion($subsector){
		 $sql="select * from cede.mpa_funcion as mpf where mpf.cod_subsector=".$subsector; 
		$regis = @pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Select 2" );
		if ($regis){
			
				return $regis;
			}else{
				
				 return false;
		}
	}
	
	
	public function guarda_funcion($id_curso,$nombre_funcion){
		 $sql="insert into cede.mpa_funcion (id_funcion,cod_subsector,nombre)VALUES
         (DEFAULT,$id_curso,'$nombre_funcion')"; 
		 
		$regis = @pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Insert 1" );
		if ($regis){
				return true;
			}else{
				 return false;
		}
	}
	
	
	public function guardad_mapacon($id_ramo,$id_nivel,$id_funcion,$text_concepto,$text_ejemplos){
		
		 $sql="insert into cede.mpa (cod_subsector,id_nivel,id_funcion,concepto,ejemplos)VALUES
         ($id_ramo,$id_nivel,$id_funcion,'$text_concepto','$text_ejemplos')"; 
		
		$regis = @pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Insert 2" );
		if ($regis){
				return true;
			}else{
				 return false;
	 }
	}
	
	
	public function ver_reg_mapacon($id_ramo,$id_nivel,$id_funcion){
		
		 $sql="select * from cede.mpa where cod_subsector=".$id_ramo."and id_nivel=".$id_nivel." and id_funcion=".$id_funcion;
			$regis = @pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Select 2" );
		 if ($regis){
				return $regis;
			}else{
		return false;
		}
	}
	
	
	public function carga_tabla()
	{
		  $sql="select mp.*,su.nombre as nombre_subsector,mf.nombre as nombre_funcion from cede.mpa mp
				inner join subsector su on mp.cod_subsector=su.cod_subsector
				inner join cede.mpa_funcion mf on mp.id_funcion=mf.id_funcion";
			$regis = @pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Select 8" );
		 if ($regis){
				return $regis;
			}else{
		return false;
		}
	}
	
	
}

	 ?>