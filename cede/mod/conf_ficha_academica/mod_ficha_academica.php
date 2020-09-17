<? 
header( 'Content-type: text/html; charset=iso-8859-1' );

session_start(); 
require "../../Class/Membrete.php";

class FichaAcademica {
	   
	public $Conec;
	
	//constructor 
	public function __construct($ip,$bd){
		$this->Conec = new DBManager($ip,$bd);
	 } 
	 
  public function ano_academico($id_instit){

   $sql_ins = "SELECT * FROM ANO_ESCOLAR WHERE ID_INSTITUCION=".$id_instit." ORDER BY NRO_ANO";
   $result_ins = pg_exec( $this->Conec->conectar(),$sql_ins ) or die ("Select falló : ".   $sql_ins);
   
  if($result_ins){
				   return $result_ins;
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
	
	public function carga_periodo($ano){
		
		$sql="select * from  periodo where periodo.id_ano=".$ano; 
		
		$regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Select 2" );
		 if($regis){
				   return $regis;
			}else{
				 return false;
		}
	}
	
	public function carga_ano_acad($ano_academ){
		
		$sql="SELECT * FROM ANO_ESCOLAR where ANO_ESCOLAR.id_ano=".$ano_academ; 
		$regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Select 2" );
		 if($regis){
				   return $regis;
			}else{
				 return false;
		}
	}
	
	
	public function InsertaFichaAcademica($rdb,$ano,$id_periodo,$nota_inicial,$nota_final,$chk_promedio,$id_nivel,$id_ramo,$nombre_conf){ 
	
	 $sql_insert = "INSERT INTO cede.configuracion_notas(rdb,id_ano,id_periodo,nota_inicial,nota_final,promedio,id_nivel,cod_subsector,nombre_conf) 
      VALUES (".$rdb.",".$ano.",".$id_periodo.",".$nota_inicial.",".$nota_final.",
	  ".$chk_promedio.",".$id_nivel.",".$id_ramo.",'".$nombre_conf."');";

	$regis = pg_Exec( $this->Conec->conectar(),$sql_insert ) or die( "Error bd insert 1" );
		if($regis){
			   return true;
		}else{
			  return false;
		}
	}
	
	public function tabla_ficha_acad($rdb){
		
	$sql="SELECT cnt.*,ano.nro_ano,sub.nombre,per.nombre_periodo FROM cede.configuracion_notas cnt
	inner join ano_escolar ano on cnt.id_ano=ano.id_ano
	inner join subsector sub on cnt.cod_subsector=sub.cod_subsector
	inner join periodo per on cnt.id_periodo=per.id_periodo
	where rdb=".$rdb; 
		$regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Select 2" );
		 if($regis){
				   return $regis;
			}else{
				 return false;
		}
	}
	
	
	public function Busca_ficha_acad($id_conf){
		
	$sql="SELECT * FROM cede.configuracion_notas where id_conf=".$id_conf; 
		$regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Select 7" );
		 if($regis){
				   return $regis;
			}else{
				 return false;
		}
	}
	
	
	public function ModificaFichaAcademica($_id_conf,$id_periodo,$nota_inicial,$nota_final,$chk_promedio,$id_nivel,$id_ramo,$nombre_conf){
		  $sql="update cede.configuracion_notas set id_conf=$_id_conf, id_periodo=$id_periodo,nota_inicial=$nota_inicial,
		 nota_final=$nota_final,promedio=$chk_promedio,id_nivel=$id_nivel,cod_subsector=$id_ramo,nombre_conf='$nombre_conf' where id_conf=$_id_conf;"; 
		 
		$regis = @pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Insert 2" );
		if ($regis){
				return true;
			}else{
				 return false;
		}
	}
	
	public function eliminad_FichaAcad($_id_conf){
		 $sql="delete from cede.configuracion_notas where id_conf=$_id_conf;"; 
		 
		$regis = @pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Delete" );
		if ($regis){
				return true;
			}else{
				 return false;
		}
	}
	 
	
	
	 
}
?>