<? require "../../../../util/connect.php";


class Bitacora { 

	var $ano;
	var $institucion;
	
	function Empleado($conn){
		$sql = "SELECT distinct (empleado.rut_emp), empleado.dig_rut, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat, trabaja.cargo ";
		$sql.= "FROM (empleado INNER  JOIN trabaja ON empleado.rut_emp = trabaja.rut_emp) INNER JOIN institucion ON trabaja.rdb = institucion.rdb ";
		$sql.= "WHERE (((institucion.rdb)=".$this->institucion.")) ";
		if($this->empleado > 0){
		$sql.= " AND empleado.rut_emp = ".$this->empleado." ";
		}
		$sql.= "ORDER BY ape_pat, ape_mat, nombre_emp asc, trabaja.cargo";
		//echo $sql;
		$result = @pg_exec($conn,$sql);
		return $result;
	}
	
	function Nomb_cargo($conn){
		
		$sql= "SELECT nombre_cargo from cargos WHERE id_cargo=".$this->cargo;
		$result = pg_exec($conn,$sql);
		return $result;	
	}
	
	function Ingresar_titulo($conn){
	
		$sql="INSERT INTO bitacora (rut_emp,rdb,titulo) VALUES(".$this->rut_emp.",".$this->rdb.",'".$this->titulo."')" ;
		$result = pg_exec($conn,$sql);
		return $result;
	}
	
	function Ingresar_evento($conn){
	
		$sql = "INSERT INTO detalle_bitacora (id,fecha,texto) VALUES (".$this->id_titulo.",'".$this->fecha."','".$this->evento."')";
		$result = pg_exec($conn,$sql);
		return $result;
	}
	
	function Modificar_evento($conn){
	
		$sql = "UPDATE detalle_bitacora SET texto='".$this->evento2."' WHERE id=".$this->id_titulo2." AND fecha='".$this->fecha."' " ;
		$result = pg_exec($conn,$sql);
		return $result;
	}
	
	function Lista_titulos($conn){
	
		$sql= "SELECT * FROM bitacora WHERE rdb=".$this->institucion." AND rut_emp=".$this->rut_emp." ORDER BY id ASC" ;
		$result =pg_exec($conn,$sql);
		return $result;
	}
	
	function Lista_eventos($conn){
	
		$sql="SELECT * FROM detalle_bitacora WHERE id=".$this->id_titulo."ORDER BY fecha ASC" ;
		$result = pg_exec($conn,$sql);
		return $result;
	}
	
	function Seleccion_evento($conn){
	
		$sql = "SELECT texto FROM detalle_bitacora WHERE id=".$this->id_titulo." AND fecha ='".$this->fecha."'";
		$result = pg_exec($conn,$sql);
		return $result;
	}
}
?>
