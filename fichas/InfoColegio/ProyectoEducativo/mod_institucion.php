<?php 


class Institucion{
	public function contruct(){
		
	}
	
	public function institucion($conn,$rdb){
		$sql="SELECT proyecto_educativo FROM institucion WHERE rdb=".$rdb;
		$result = pg_exec($conn,$sql);
		
		return $result;
	}
}
?>
