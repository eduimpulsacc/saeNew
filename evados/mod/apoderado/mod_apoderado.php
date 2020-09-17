<?

require "../../class/Coneccion.class.php";

class Apoderado{
	
	public $Conec;
	
	//constructor 
	public function Apoderado($ip,$bd){
		$this->Conec = new DBManager($ip,$bd);
	 }	
	 
	 
	 public function Listado($curso){
		$sql="select a.rut_alumno, a.dig_rut, a.ape_pat ||' '|| a.ape_mat ||' '|| nombre_alu as nombre_alumno,apo.rut_apo, 
		apo.dig_rut as dig_rut_apo, apo.ape_pat ||' '|| apo.ape_mat ||' '|| apo.nombre_apo as nombre_apoderado
		from alumno a 
		inner join matricula m ON a.rut_alumno=m.rut_alumno
		LEFT JOIN tiene2 t ON a.rut_alumno=t.rut_alumno
		LEFT JOIN apoderado apo ON apo.rut_apo=t.rut_apo
		WHERE id_curso=".$curso." AND bool_ar=0 
		ORDER BY a.ape_pat,a.ape_mat ASC";
		$result = pg_exec( $this->Conec->conectar(),$sql ) or die( "Error bd Select ".$sql );
 
 		return $result;
	 }
	
	public function BuscarApo($rut){
		$sql="SELECT nombre_apo, ape_pat, ape_mat, dig_rut FROM apoderado WHERE rut_apo=".$rut;
		$result = pg_exec( $this->Conec->conectar(),$sql );
 
 		return $result;
	}
	
	public function GuardaApo($rut_apo,$dig,$nombre,$paterno,$materno,$rut_alu){
		$sql="SELECT * FROM apoderado WHERE rut_apo=".$rut_apo;
		$rs_existe = pg_exec( $this->Conec->conectar(),$sql ) or die( "Error bd Select ".$sql );	
		
		if(pg_numrows($rs_existe)>0){
			$sql="INSERT INTO tiene2 (rut_apo,rut_alumno,responsable) VALUES(".$rut_apo.",".$rut_alu.",1)";	
			$tiene2 = pg_exec( $this->Conec->conectar(),$sql ) or die( "Error bd Select ".$sql );
		}else{
			$sql="INSERT INTO apoderado (rut_apo,dig_rut,nombre_apo,ape_pat,ape_mat) VALUES (".$rut_apo.",'".$dig."','".$nombre."','".$paterno."','".$materno."')";
			$rs_apo = pg_exec( $this->Conec->conectar(),$sql ) or die( "Error bd Select ".$sql );	
			
			$sql="INSERT INTO tiene2 (rut_apo,rut_alumno,responsable) VALUES(".$rut_apo.",".$rut_alu.",1)";	
			$tiene2 = pg_exec( $this->Conec->conectar(),$sql ) or die( "Error bd Select ".$sql );
		}
		return $tiene2;
	}
	
	public function BuscarAlu($rut){
		$sql="SELECT rut_alumno, dig_rut, nombre_alu ||' '|| ape_pat AS nombre FROM alumno WHERE rut_alumno=".$rut;
		$result = pg_exec( $this->Conec->conectar(),$sql ) or die( "Error bd Select ".$sql );	
				
		return $result;
	}
	
}

?>
