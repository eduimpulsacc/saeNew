<? 
echo "dentro";
session_start();
echo "2";
require "../../../class/Coneccion.class.php";
echo "3";	   
class Reporte{

 public $Conec;

//constructor 
	public function __construct($ip,$bd){
		$this->Conec = new DBManager($ip,$bd);
	 } 

	public function Bloque_evaluador($bloque){
		$sql =" SELECT eva_bloque.nombre,empleado.ape_pat ||' ' || ape_mat ||' '|| empleado.nombre_emp as nombre_empleado
				FROM eva_bloque_evaluador INNER JOIN empleado ON rut_evaluador=rut_emp
				INNER JOIN eva_bloque ON eva_bloque_evaluador.id_bloque=eva_bloque.id_bloque
				WHERE eva_bloque.id_bloque=".$bloque;
		$result =pg_exec( $this->Conec->conectar(),$sql) or die ("Select falló : ".$sql);
		
		return $result;
	}
}

?>