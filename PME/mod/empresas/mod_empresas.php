<? 
header( 'Content-type: text/html; charset=iso-8859-1' );

session_start();
require "../../class/Membrete.class.php";

class Empresas {
	   
	public $Conec;
	
	//constructor 
	public function __construct($ip,$bd){
		$this->Conec = new DBManager($ip,$bd);
	 } 
	 
	public function ListadoEmpresas($rdb){
		$sql="SELECT * FROM pme.empresa WHERE rdb=".$rdb;
		$result = pg_exec($this->Conec->Conectar(),$sql);
		
		if($result){
			return $result;
		}else{
			return false;	
		}
	}
	
	public function GuardarDatos($rdb,$rut,$dig,$folio,$razon,$direccion,$email,$fono,$fax,$contacto,$giro){
		$sql="INSERT INTO pme.empresa (rdb, rut_empresa,dig_rut,folio,razon_social,direccion,email,telefono,fax) VALUES ('$rdb','$rut','$dig', '$folio','$razon','$direccion','$email','$fono','$fax')";
		$result = pg_exec($this->Conec->Conectar(),$sql) or die(pg_last_error($sql));
		
		if($result){
			return $result;
		}else{
			return false;
		}
	}
	
	public function EliminaDatos($rdb,$rut){
		$sql="DELETE FROM pme.empresa WHERE rdb=$rdb AND rut_empresa=$rut";
		$result = pg_exec($this->Conec->Conectar(),$sql);
		
		if($result){
			return $result;
		}else{
			return false;
		}
		
	}
	
	public function BuscaDatos($rdb,$rut){
		$sql="SELECT * FROM pme.empresa WHERE rdb=$rdb AND rut_empresa=$rut";
		$result = pg_exec($this->Conec->Conectar(),$sql);
		
		if($result){
			return $result;
		}else{
			return false;
		}
		
	}
	
	public function Modificar($rdb,$rut,$folio,$razon,$direccion,$email,$fono,$fax,$contacto,$giro){
		$sql="UPDATE pme.empresa SET razon_social='".$razon."',folio='".$folio."',direccion='".$direccion."',telefono='".$fono."',fax='".$fax."',contacto='".$contacto."',giro='".$giro."' WHERE rdb=".$rdb." AND rut_empresa=".$rut;
		$result =pg_exec($this->Conec->Conectar(),$sql);
		
		if($result){
			return $result;
		}else{
			return false;
		}
			
	}
	
	public function ArchivoATE($rdb,$rut){
		$sql="SELECT archivo FROM pme.empresa WHERE rdb=".$rdb." AND rut_empresa=".$rut;
		$result =pg_exec($this->Conec->Conectar(),$sql);
		
		if($result){
			return $result;
		}else{
			return false;
		}	
	}
	 
}
?>