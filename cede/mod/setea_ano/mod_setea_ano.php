<? 
header( 'Content-type: text/html; charset=iso-8859-1' );

session_start(); 
require "../../Class/Membrete.php";

class SeteaAno {
	   
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
	
	
	 
}
?>