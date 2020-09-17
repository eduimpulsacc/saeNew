<? 
header( 'Content-type: text/html; charset=iso-8859-1' );
session_start();
require('../../../../../util/header.inc');

class TendenciaMatricula {
	
	private $conect;       

//constructor 
public function __construct($con){ 
      $this->conect = $con;  
    }
	 
	  public function carga_tipo_ense($rdb){
		
	   $sql="select DISTINCT tei.cod_tipo, te.nombre_tipo 
			from tipo_ense_inst tei 
			JOIN tipo_ensenanza te on tei.cod_tipo=te.cod_tipo
			where tei.rdb=$rdb order by tei.cod_tipo asc"; 
			
   $regis = pg_Exec($this->conect,$sql) or die( "Error bd insert 1".$sql);		
		 if($regis){
				   return $regis;
			}else{
				 return false;
		}
	}
	 
}
?>