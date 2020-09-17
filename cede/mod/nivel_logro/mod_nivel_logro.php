<? 
header( 'Content-type: text/html; charset=iso-8859-1' );

session_start();
require "../../Class/Membrete.php";

//require "../../Class/Coneccion.php";
class NivelDeLogro {
	   
	public $Conec;
	
	//constructor 
	public function __construct($ip,$bd){
		$this->Conec = new DBManager($ip,$bd);
	 } 
	 
	 public function cargaNivelLogro ($rdb){
		$sql="select * from cede.nivel_logro where rdb=$rdb order by id;"; 
		$regis = @pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error Select tabla" );
		if ($regis){
				return $regis;
			}else{
				 return false;
		}
	}
	 
	 
	 public function guardad_nivelLogro ($id_nivel,$text_concepto,$notaminima,$notamaxima,$id_ano,$descrip,$rdb){
		$sql="insert into cede.nivel_logro (id_nivel,concepto,nota_minima,nota_maxima,id_ano,descripcion,rdb)
			values($id_nivel,'$text_concepto',$notaminima,$notamaxima,$id_ano,'".$descrip."',$rdb);"; 
		 
		$regis = @pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Insert 2" );
		if ($regis){
				return true;
			}else{
				 return false;
		}
	}
	
	
	 public function Busca_nivelLogro($id){
		 $sql="select * from cede.nivel_logro where id=$id;"; 
		 
		$regis = @pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Insert 2" );
		if ($regis){
				return $regis;
			}else{
				 return false;
		}
	}
	
	
	 public function modificad_nivelLogro($id_nivel,$text_concepto,$notaminima,$notamaxima,$rdb,$id){
		  $sql="update cede.nivel_logro set id_nivel=$id_nivel, concepto='$text_concepto',nota_minima=$notaminima,
		 nota_maxima=$notamaxima  where id=$id and rdb=$rdb;"; 
		 
		$regis = @pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Insert 2" );
		if ($regis){
				return true;
			}else{
				 return false;
		}
	}
	
	 public function eliminad_nivelLogro($id){
		 $sql="delete from cede.nivel_logro where id=$id;"; 
		 
		$regis = @pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Insert 2" );
		if ($regis){
				return true;
			}else{
				 return false;
		}
	}
	 
	 
	 
	 
	 
}
	 ?>