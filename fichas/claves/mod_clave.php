<?php 

class Clave{

	public function contruct(){
		
	}
	
	public function ModificarClave($conn,$usuario,$clavenew){
		echo $sql="UPDATE usuario SET pw=".$clavenew." WHERE nombre_usuario='".$usuario."'";
		$result = pg_exec($conn,$sql);
		
		return $result;
		
	}
	
	public function Valida($conn,$usuario,$claveant){
		$sql="SELECT * FROM usuario WHERE nombre_usuario='".$usuario."' AND pw='".$claveant."'";
		$result = pg_exec($conn,$sql);
		
		return $result;
	}
}

?>
