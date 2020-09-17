<?php 


class Institucion{
	public function contruct(){
		
	}
	
	public function institucion($conn,$rdb){
		$sql="SELECT proceso_admision FROM institucion WHERE rdb=".$rdb;
		$result = pg_exec($conn,$sql);
		
		return $result;
	}
}
?>
