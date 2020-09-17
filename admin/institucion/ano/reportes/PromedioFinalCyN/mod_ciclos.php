<? 
header( 'Content-type: text/html; charset=iso-8859-1' );
session_start();
require('../../../../../util/header.inc');

class Ciclos {
	
	private $conect;       

//constructor 
public function __construct($con){ 
      $this->conect = $con;  
    }
	 
	  public function carga_ciclos($ano){
		
	 	$sql ="SELECT id_ciclo,nomb_ciclo FROM ciclo_conf WHERE id_ano=".$ano;
		$rs_ciclo = pg_Exec($this->conect,$sql) or die( "Error bd insert 1".$sql);
//   $regis = pg_Exec($this->conect,$sql) or die( "Error bd insert 1".$sql);		
			 if($rs_ciclo){
				   return $rs_ciclo;
			}else{
				 return false;
			}
		}
		 public function carga_ano($rdb){
		
	 	$sql ="SELECT id_ano,nro_ano FROM ano_escolar WHERE id_institucion=".$rdb." ORDER BY nro_ano DESC";
		$rs_ano = pg_Exec($this->conect,$sql) or die( "Error bd insert 1".$sql);
//   $regis = pg_Exec($this->conect,$sql) or die( "Error bd insert 1".$sql);		
			 if($rs_ano){
				   return $rs_ano;
			}else{
				 return false;
			}
		}
		
		
		 public function carga_periodos($ano){
		
	 	$sql ="SELECT id_periodo,nombre_periodo FROM periodo WHERE id_ano=".$ano." ORDER BY id_periodo ASC";
		$rs_periodo = pg_Exec($this->conect,$sql) or die( "Error bd insert 1".$sql);
//   $regis = pg_Exec($this->conect,$sql) or die( "Error bd insert 1".$sql);		
			 if($rs_periodo){
				   return $rs_periodo;
			}else{
				 return false;
			}
		}
		
		public function carga_nivel(){
		
	 	$sql ="SELECT id_nivel,nombre FROM niveles";
		$rs_nivel = pg_Exec($this->conect,$sql) or die( "Error bd insert 1".$sql);
//   $regis = pg_Exec($this->conect,$sql) or die( "Error bd insert 1".$sql);		
			 if($rs_nivel){
				   return $rs_nivel;
			}else{
				 return false;
			}
		}
	
	
	
	
	
	 
}
?>