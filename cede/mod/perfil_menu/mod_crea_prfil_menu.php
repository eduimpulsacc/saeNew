<? 
header( 'Content-type: text/html; charset=iso-8859-1' );

session_start();
require "../../Class/Membrete.php";
//require "../../Class/Coneccion.php";
class Crea_Perfil_Menu {
	   
	public $Conec;
	
	//constructor 
	public function __construct($ip,$bd){
		$this->Conec = new DBManager($ip,$bd);
	 } 
	 
	 public function carga_perfil(){
	$sql="SELECT id_perfil,nombre_perfil FROM perfil WHERE id_perfil not in (0,24,15,16,26)  ORDER BY nombre_perfil ASC ;"; 
		 
		$regis = @pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Insert 2" );
		if ($regis){
				return $regis;
			}else{
				 return false;
		}
	}
	 
	

}
?>